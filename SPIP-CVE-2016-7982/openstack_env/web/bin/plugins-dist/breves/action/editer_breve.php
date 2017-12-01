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
 * Gestion de l'action editer_breve
 *
 * @package SPIP\Breves\Actions
 */
if (!defined("_ECRIRE_INC_VERSION")) {
	return;
}

/**
 * Action d'édition d'une brève dans la base de données dont
 * l'identifiant est donné en paramètre de cette fonction ou
 * en argument de l'action sécurisée
 *
 * Si aucun identifiant n'est donné, on crée alors une nouvelle brève.
 *
 * @param null|int $arg
 *     Identifiant de la brève. En absence utilise l'argument
 *     de l'action sécurisée.
 * @return array
 *     Liste : identifiant de la brève, texte d'erreur éventuel
 **/
function action_editer_breve_dist($arg = null) {

	if (is_null($arg)) {
		$securiser_action = charger_fonction('securiser_action', 'inc');
		$arg = $securiser_action();
	}

	// Envoi depuis le formulaire d'edition d'une breve
	if (!$id_breve = intval($arg)) {
		$id_breve = breve_inserer(_request('id_parent'));
	}

	if (!$id_breve) {
		return array(0, '');
	} // erreur

	$err = breve_modifier($id_breve);

	return array($id_breve, $err);
}


/**
 * Insertion d'une brève dans une rubrique
 *
 * @pipeline_appel pre_insertion
 * @pipeline_appel post_insertion
 *
 * @param int $id_rubrique
 *     Identifiant de la rubrique
 * @param array|null $set
 * @return int
 *     Identifiant de la nouvelle brève.
 */
function breve_inserer($id_rubrique, $set = null) {

	include_spip('inc/rubriques');

	// Si id_rubrique vaut 0 ou n'est pas definie, creer la breve
	// dans la premiere rubrique racine
	if (!$id_rubrique = intval($id_rubrique)) {
		$id_rubrique = sql_getfetsel("id_rubrique", "spip_rubriques", "id_parent=0", '', '0+titre,titre', "1");
	}

	// La langue a la creation : c'est la langue de la rubrique
	$row = sql_fetsel("lang, id_secteur", "spip_rubriques", "id_rubrique=$id_rubrique");
	$lang = $row['lang'];
	$id_rubrique = $row['id_secteur']; // garantir la racine

	$champs = array(
		'id_rubrique' => $id_rubrique,
		'statut' => 'prop',
		'date_heure' => date('Y-m-d H:i:s'),
		'lang' => $lang,
		'langue_choisie' => 'non'
	);

	if ($set) {
		$champs = array_merge($champs, $set);
	}

	// Envoyer aux plugins
	$champs = pipeline('pre_insertion',
		array(
			'args' => array(
				'table' => 'spip_breves',
			),
			'data' => $champs
		)
	);
	$id_breve = sql_insertq("spip_breves", $champs);
	pipeline('post_insertion',
		array(
			'args' => array(
				'table' => 'spip_breves',
				'id_objet' => $id_breve
			),
			'data' => $champs
		)
	);

	return $id_breve;
}


/**
 * Modifier une brève en base
 *
 * @param int $id_breve
 *     Identifiant de la brève à modifier
 * @param array|null $set
 *     Couples (colonne => valeur) de données à modifier.
 *     En leur absence, on cherche les données dans les champs éditables
 *     qui ont été postés (via _request())
 * @return string|null
 *     Chaîne vide si aucune erreur,
 *     Null si aucun champ à modifier,
 *     Chaîne contenant un texte d'erreur sinon.
 */
function breve_modifier($id_breve, $set = null) {

	include_spip('inc/modifier');
	$c = collecter_requests(
	// white list
		array('titre', 'texte', 'lien_titre', 'lien_url'),
		// black list
		array('id_parent', 'statut'),
		// donnees eventuellement fournies
		$set
	);

	$invalideur = '';
	$indexation = false;

	// Si la breve est publiee, invalider les caches et demander sa reindexation
	$t = sql_getfetsel("statut", "spip_breves", "id_breve=$id_breve");
	if ($t == 'publie') {
		$invalideur = "id='breve/$id_breve'";
		$indexation = true;
	}

	if ($err = objet_modifier_champs('breve', $id_breve,
		array(
			'data' => $set,
			'nonvide' => array('titre' => _T('breves:titre_nouvelle_breve') . " " . _T('info_numero_abbreviation') . $id_breve),
			'invalideur' => $invalideur,
			'indexation' => $indexation
		),
		$c)
	) {
		return $err;
	}

	$c = collecter_requests(array('id_parent', 'statut'), array(), $set);
	$err = breve_instituer($id_breve, $c);

	return $err;
}


/**
 * Instituer une brève : modifier son statut ou son parent
 *
 * @pipeline_appel pre_insertion
 * @pipeline_appel post_insertion
 *
 * @param int $id_breve
 *     Identifiant de la brève
 * @param array $c
 *     Couples (colonne => valeur) des données à instituer
 * @return string|null
 *     Null si aucun champ à modifier, chaîne vide sinon.
 */
function breve_instituer($id_breve, $c) {
	$champs = array();

	// Changer le statut de la breve ?
	$row = sql_fetsel("statut, id_rubrique,lang, langue_choisie", "spip_breves", "id_breve=" . intval($id_breve));
	$id_rubrique = $row['id_rubrique'];

	$statut_ancien = $statut = $row['statut'];
	$langue_old = $row['lang'];
	$langue_choisie_old = $row['langue_choisie'];

	if (isset($c['statut'])
		and $c['statut']
		and $c['statut'] != $statut
		and autoriser('publierdans', 'rubrique', $id_rubrique)
	) {
		$statut = $champs['statut'] = $c['statut'];
	}

	// Changer de rubrique ?
	// Verifier que la rubrique demandee est a la racine et differente
	// de la rubrique actuelle
	if ($id_parent = intval($c['id_parent'])
		and $id_parent != $id_rubrique
		and (null !== ($lang = sql_getfetsel('lang', 'spip_rubriques',
				"id_parent=0 AND id_rubrique=" . intval($id_parent))))
	) {
		$champs['id_rubrique'] = $id_parent;
		// - changer sa langue (si heritee)
		if ($langue_choisie_old != "oui") {
			if ($lang != $langue_old) {
				$champs['lang'] = $lang;
			}
		}
		// si la breve est publiee
		// et que le demandeur n'est pas admin de la rubrique
		// repasser la breve en statut 'prop'.
		if ($statut == 'publie') {
			if (!autoriser('publierdans', 'rubrique', $id_parent)) {
				$champs['statut'] = $statut = 'prop';
			}
		}
	}

	// Envoyer aux plugins
	$champs = pipeline('pre_edition',
		array(
			'args' => array(
				'table' => 'spip_breves',
				'id_objet' => $id_breve,
				'action' => 'instituer',
				'statut_ancien' => $statut_ancien,
			),
			'data' => $champs
		)
	);

	if (!$champs) {
		return;
	}

	sql_updateq('spip_breves', $champs, "id_breve=" . intval($id_breve));

	//
	// Post-modifications
	//

	// Invalider les caches
	include_spip('inc/invalideur');
	suivre_invalideur("id='breve/$id_breve'");

	// Au besoin, changer le statut des rubriques concernees 
	include_spip('inc/rubriques');
	calculer_rubriques_if($id_rubrique, $champs, $statut_ancien);

	// Pipeline
	pipeline('post_edition',
		array(
			'args' => array(
				'table' => 'spip_breves',
				'id_objet' => $id_breve,
				'action' => 'instituer',
				'statut_ancien' => $statut_ancien,
			),
			'data' => $champs
		)
	);


	// Notifications
	if ($notifications = charger_fonction('notifications', 'inc')) {
		$notifications('instituerbreve', $id_breve,
			array('statut' => $statut, 'statut_ancien' => $statut_ancien)
		);
	}

	return ''; // pas d'erreur
}


// Fonctions Dépréciées
// --------------------

/**
 * Insertion d'une brève dans une rubrique
 *
 * @deprecated Utiliser breve_inserer()
 * @see breve_inserer()
 *
 * @param int $id_rubrique
 *     Identifiant de la rubrique
 * @return int
 *     Identifiant de la nouvelle brève.
 */
function insert_breve($id_rubrique) {
	return breve_inserer($id_rubrique);
}

/**
 * Créer une révision de brève
 *
 * @deprecated Utiliser breve_modifier()
 * @see breve_modifier()
 *
 * @param int $id_breve
 *     Identifiant de la brève à modifier
 * @param array|null $set
 *     Couples (colonne => valeur) de données à modifier.
 *     En leur absence, on cherche les données dans les champs éditables
 *     qui ont été postés (via _request())
 * @return string|null
 *     Chaîne vide si aucune erreur,
 *     Null si aucun champ à modifier,
 *     Chaîne contenant un texte d'erreur sinon.
 */
function revisions_breves($id_breve, $set = false) {
	return breve_modifier($id_breve, $set);
}
