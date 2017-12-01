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
 * Gestion de l'action editer_groupes_mots
 *
 * @package SPIP\Mots\Actions
 */
if (!defined("_ECRIRE_INC_VERSION")) {
	return;
}

include_spip('inc/filtres');

/**
 * Action d'édition d'un groupe de mots clés dans la base de données dont
 * l'identifiant du groupe est donné en paramètre de cette fonction ou
 * en argument de l'action sécurisée
 *
 * Si aucun identifiant n'est donné, on crée alors un nouveau groupe de
 * mots clés.
 *
 * @param null|int $id_groupe
 *     Identifiant du groupe de mot-clé. En absence utilise l'argument
 *     de l'action sécurisée.
 * @return array
 *     Liste (identifiant du groupe de mot clé, Texte d'erreur éventuel)
 **/
function action_editer_groupe_mots_dist($id_groupe = null) {
	if (is_null($id_groupe)) {
		$securiser_action = charger_fonction('securiser_action', 'inc');
		$id_groupe = $securiser_action();
	}

	if (!intval($id_groupe)) {
		$id_groupe = groupe_mots_inserer();
	}

	if ($id_groupe > 0) {
		$err = groupe_mots_modifier($id_groupe);
	}

	return array($id_groupe, $err);
}


/**
 * Insertion d'un groupe de mots clés
 *
 * @pipeline_appel pre_insertion
 * @pipeline_appel post_insertion
 *
 * @param int $id_parent
 *     inutilise, pour consistance de l'API
 * @param null|array $set
 * @return int|bool
 *     Identifiant du nouveau groupe de mots clés.
 */
function groupe_mots_inserer($id_parent = null, $set = null) {

	// support de la signature derogatoire pour compat
	// groupe_mots_inserer($table='')
	if (is_string($id_parent) and strlen($id_parent)) {
		if (is_null($set)) {
			$set = array();
		}
		$set['tables_liees'] = $id_parent;
	}


	$champs = array(
		'titre' => '',
		'unseul' => 'non',
		'obligatoire' => 'non',
		'tables_liees' => '',
		'minirezo' => 'oui',
		'comite' => 'non',
		'forum' => 'non'
	);

	if ($set) {
		$champs = array_merge($champs, $set);
	}

	// Envoyer aux plugins
	$champs = pipeline('pre_insertion',
		array(
			'args' => array(
				'table' => 'spip_groupes_mots',
			),
			'data' => $champs
		)
	);

	$id_groupe = sql_insertq("spip_groupes_mots", $champs);

	pipeline('post_insertion',
		array(
			'args' => array(
				'table' => 'spip_groupes_mots',
				'id_objet' => $id_groupe
			),
			'data' => $champs
		)
	);

	return $id_groupe;
}


/**
 * Modifier un groupe de mot
 *
 * @param int $id_groupe
 *     Identifiant du grope de mots clés à modifier
 * @param array|null $set
 *     Couples (colonne => valeur) de données à modifier.
 *     En leur absence, on cherche les données dans les champs éditables
 *     qui ont été postés
 * @return string|null
 *     Chaîne vide si aucune erreur,
 *     Null si aucun champ à modifier,
 *     Chaîne contenant un texte d'erreur sinon.
 */
function groupe_mots_modifier($id_groupe, $set = null) {
	$err = '';

	include_spip('inc/modifier');
	$c = collecter_requests(
	// white list
		array(
			'titre',
			'descriptif',
			'texte',
			'tables_liees',
			'obligatoire',
			'unseul',
			'comite',
			'forum',
			'minirezo',
		),
		// black list
		array(),
		// donnees eventuellement fournies
		$set
	);
	// normaliser les champ oui/non
	foreach (array(
		         'obligatoire',
		         'unseul',
		         'comite',
		         'forum',
		         'minirezo'
	         ) as $champ) {
		if (isset($c[$champ])) {
			$c[$champ] = ($c[$champ] == 'oui' ? 'oui' : 'non');
		}
	}

	if (isset($c['tables_liees']) and is_array($c['tables_liees'])) {
		$c['tables_liees'] = implode(',', array_diff($c['tables_liees'], array('')));
	}

	$err = objet_modifier_champs('groupe_mot', $id_groupe,
		array(
			'data' => $set,
			'nonvide' => array('titre' => _T('info_sans_titre'))
		),
		$c);

	return $err;
}

// Fonctions Dépréciées
// --------------------

/**
 * Créer une révision sur un groupe de mot
 *
 * @deprecated Utiliser groupe_mots_modifier()
 * @see groupe_mots_modifier()
 *
 * @param int $id_groupe
 *     Identifiant du grope de mots clés à modifier
 * @param array|null $c
 *     Couples (colonne => valeur) de données à modifier.
 *     En leur absence, on cherche les données dans les champs éditables
 *     qui ont été postés
 * @return string|null
 *     Chaîne vide si aucune erreur,
 *     Null si aucun champ à modifier,
 *     Chaîne contenant un texte d'erreur sinon.
 */
function revision_groupe_mot($id_groupe, $c = false) {
	return groupe_mots_modifier($id_groupe, $c);
}


/**
 * Insertion d'un groupe de mots clés
 *
 * @deprecated Utiliser groupe_mots_inserer() ou objet_inserer()
 * @see groupe_mots_inserer()
 *
 * @param string $table
 *     Tables sur lesquels des mots de ce groupe pourront être liés
 * @param null|array $set
 * @return int|bool
 *     Identifiant du nouveau groupe de mots clés.
 */
function groupemots_inserer($table = '', $set = null) {
	return groupe_mots_inserer($table, $set);
}

/**
 * Modifier un groupe de mot
 *
 * @deprecated Utiliser groupe_mots_modifier() ou objet_modifier()
 * @see groupe_mots_modifier()
 *
 * @param int $id_groupe
 *     Identifiant du grope de mots clés à modifier
 * @param array|null $set
 *     Couples (colonne => valeur) de données à modifier.
 *     En leur absence, on cherche les données dans les champs éditables
 *     qui ont été postés
 * @return string|null
 *     Chaîne vide si aucune erreur,
 *     Null si aucun champ à modifier,
 *     Chaîne contenant un texte d'erreur sinon.
 */
function groupemots_modifier($id_groupe, $set = null) {
	return groupe_mots_modifier($id_groupe, $set);
}
