<?php

/***************************************************************************\
 *  SPIP, Systeme de publication pour l'internet                           *
 *                                                                         *
 *  Copyright (c) 2001-2016                                                *
 *  Arnaud Martin, Antoine Pitrou, Philippe Riviere, Emmanuel Saint-James  *
 *                                                                         *
 *  Ce programme est un logiciel libre distribue sous licence GNU/GPL.     *
 *  Pour plus de details voir le fichier COPYING.txt ou l'aide en ligne.   *
\***************************************************************************/

/**
 * Gestion de l'action editer__site et de l'API d'édition d'un site
 *
 * @package SPIP\Sites\Edition
 */

if (!defined("_ECRIRE_INC_VERSION")) {
	return;
}


/**
 * Action d'édition d'un site dans la base de données dont
 * l'identifiant est donné en paramètre de cette fonction ou
 * en argument de l'action sécurisée
 *
 * Si aucun identifiant n'est donné, on crée alors un nouvel article,
 * à condition que la rubrique parente (id_rubrique) puisse être obtenue
 * (avec _request(id_parent))
 *
 * @uses site_inserer()
 * @uses site_modifier()
 *
 * @param null|int $arg
 *     Identifiant du site. En absence utilise l'argument
 *     de l'action sécurisée.
 * @return array
 *     Liste (identifiant du site, Texte d'erreur éventuel)
 */
function action_editer_site_dist($arg = null) {

	if (is_null($arg)) {
		$securiser_action = charger_fonction('securiser_action', 'inc');
		$arg = $securiser_action();
	}

	if (!$id_syndic = intval($arg)) {
		$id_syndic = site_inserer(_request('id_parent'));
		if ($logo = _request('logo')
			and $format_logo = _request('format_logo')
		) {
			include_spip('inc/distant');
			$logo = _DIR_RACINE . copie_locale($logo);
			@rename($logo, _DIR_IMG . 'siteon' . $id_syndic . '.' . $format_logo);
		}
	}

	if (!$id_syndic) {
		return array(0, '');
	}

	$err = site_modifier($id_syndic);

	return array($id_syndic, $err);
}


/**
 * Insérer un nouveau site en base
 *
 * @pipeline_appel pre_insertion
 * @pipeline_appel post_insertion
 *
 * @param int $id_rubrique
 *     Identifiant de rubrique parente
 * @param array|null $set
 * @return int
 *     Identifiant du site créé
 */
function site_inserer($id_rubrique, $set = null) {

	include_spip('inc/rubriques');

	// Si id_rubrique vaut 0 ou n'est pas definie, creer le site
	// dans la premiere rubrique racine
	if (!$id_rubrique = intval($id_rubrique)) {
		$id_rubrique = sql_getfetsel("id_rubrique", "spip_rubriques", "id_parent=0", '', '0+titre,titre', "1");
	}

	// Le secteur a la creation : c'est le secteur de la rubrique
	$id_secteur = sql_getfetsel("id_secteur", "spip_rubriques", "id_rubrique=" . intval($id_rubrique));
	// eviter un null si la rubrique n'existe pas (rubrique -1 par exemple)
	if (!$id_secteur) {
		$id_secteur = 0;
	}

	$champs = array(
		'id_rubrique' => $id_rubrique,
		'id_secteur' => $id_secteur,
		'statut' => 'prop',
		'date' => date('Y-m-d H:i:s')
	);

	if ($set) {
		$champs = array_merge($champs, $set);
	}

	// Envoyer aux plugins
	$champs = pipeline('pre_insertion',
		array(
			'args' => array(
				'table' => 'spip_syndic',
			),
			'data' => $champs
		)
	);

	$id_syndic = sql_insertq("spip_syndic", $champs);
	pipeline('post_insertion',
		array(
			'args' => array(
				'table' => 'spip_syndic',
				'id_objet' => $id_syndic
			),
			'data' => $champs
		)
	);

	return $id_syndic;
}

/**
 * Modifier un site
 *
 * Appelle toutes les fonctions de modification d'un site
 *
 * @uses objet_modifier_champs()
 * @uses objet_instituer()
 *
 * @param int $id_syndic
 *     Identifiant du site à modifier
 * @param array|null $set
 *     Couples (colonne => valeur) de données à modifier.
 *     En leur absence, on cherche les données dans les champs éditables
 *     qui ont été postés (via collecter_requests())
 * @return string
 *     - Chaîne vide si aucune erreur,
 *     - Chaîne contenant un texte d'erreur sinon.
 */
function site_modifier($id_syndic, $set = null) {
	$resyndiquer = false;

	include_spip('inc/rubriques');
	include_spip('inc/modifier');
	$c = collecter_requests(
	// white list
		array(
			'nom_site',
			'url_site',
			'descriptif',
			'url_syndic',
			'syndication',
			'moderation',
			'miroir',
			'oubli',
			'resume'
		),
		// black list
		array('statut', 'id_parent', 'date'),
		// donnees eventuellement fournies
		$set
	);

	// resyndiquer si un element de syndication modifie
	if ($t = sql_fetsel('url_syndic,syndication,resume', 'spip_syndic', "id_syndic=" . intval($id_syndic))) {
		foreach ($t as $k => $v) {
			if (isset($c[$k]) and $v != $c[$k]) {
				$resyndiquer = true;
			}
		}
	}

	// Si le site est publie, invalider les caches et demander sa reindexation
	$t = sql_getfetsel("statut", "spip_syndic", "id_syndic=" . intval($id_syndic));
	$invalideur = $indexation = false;
	if ($t == 'publie') {
		$invalideur = "id='site/$id_syndic'";
		$indexation = true;
	}

	if ($err = objet_modifier_champs('site', $id_syndic,
		array(
			'data' => $set,
			'nonvide' => array('nom_site' => _T('info_sans_titre')),
			'invalideur' => $invalideur,
			'indexation' => $indexation
		),
		$c)
	) {
		return $err;
	}


	if ($resyndiquer and sql_getfetsel('syndication', 'spip_syndic', "id_syndic=" . intval($id_syndic)) !== 'non') {
		$syndiquer_site = charger_fonction('syndiquer_site', 'action');
		$syndiquer_site($id_syndic);
	}


	// Modification de statut, changement de rubrique ?
	$c = collecter_requests(array('date', 'statut', 'id_parent'), array(), $set);
	include_spip('action/editer_objet');
	$err = objet_instituer('site', $id_syndic, $c);

	return $err;
}


// Fonctions Dépréciées
// --------------------

/**
 * Insérer un site
 *
 * @deprecated Utiliser site_inserer()
 * @uses site_inserer()
 *
 * @param int $id_rubrique
 * @return int
 **/
function insert_syndic($id_rubrique) {
	return site_inserer($id_rubrique);
}

/**
 * Modifier un site
 *
 * @deprecated Utiliser site_modifier()
 * @uses site_modifier()
 *
 * @param int $id_syndic
 * @param array|bool $set
 * @return string
 **/
function syndic_set($id_syndic, $set = false) {
	return site_modifier($id_syndic, $set);
}

/**
 * Créer une révision d'un site
 *
 * @deprecated Utiliser site_modifier()
 * @uses site_modifier()
 *
 * @param int $id_syndic
 * @param array|bool $set
 * @return string
 **/
function revisions_sites($id_syndic, $set = false) {
	return site_modifier($id_syndic, $set);
}

/**
 * Instituer un site
 *
 * @deprecated Utiliser objet_instituer()
 * @uses objet_instituer()
 *
 * @param int $id_syndic
 * @param array $c
 * @param bool $calcul_rub
 * @return string
 **/
function instituer_syndic($id_syndic, $c, $calcul_rub = true) {
	include_spip('action/editer_objet');

	return objet_instituer('site', $id_syndic, $c, $calcul_rub);
}
