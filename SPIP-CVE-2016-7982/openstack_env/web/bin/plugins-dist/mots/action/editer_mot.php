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
 * Gestion de l'action editer_mot
 *
 * @package SPIP\Mots\Actions
 */
if (!defined("_ECRIRE_INC_VERSION")) {
	return;
}

include_spip('inc/filtres');

/**
 * Action d'édition d'un mot clé dans la base de données dont
 * l'identifiant est donné en paramètre de cette fonction ou
 * en argument de l'action sécurisée
 *
 * Si aucun identifiant n'est donné, on crée alors un nouveau mot clé.
 *
 * @param null|int $arg
 *     Identifiant du mot-clé. En absence utilise l'argument
 *     de l'action sécurisée.
 * @return array
 *     Liste (identifiant du mot clé, Texte d'erreur éventuel)
 **/
function action_editer_mot_dist($arg = null) {
	if (is_null($arg)) {
		$securiser_action = charger_fonction('securiser_action', 'inc');
		$arg = $securiser_action();
	}
	$id_mot = intval($arg);

	$id_groupe = intval(_request('id_groupe'));
	if (!$id_mot and $id_groupe) {
		$id_mot = mot_inserer($id_groupe);
	}

	// Enregistre l'envoi dans la BD
	if ($id_mot > 0) {
		$err = mot_modifier($id_mot);
	}

	return array($id_mot, $err);
}

/**
 * Insertion d'un mot dans un groupe
 *
 * @pipeline_appel pre_insertion
 * @pipeline_appel post_insertion
 *
 * @param int $id_groupe
 *     Identifiant du groupe de mot
 * @param array|null $set
 * @return int|bool
 *     Identifiant du nouveau mot clé, false si erreur.
 */
function mot_inserer($id_groupe, $set = null) {

	$champs = array();
	$row = sql_fetsel("titre", "spip_groupes_mots", "id_groupe=" . intval($id_groupe));
	if ($row) {
		$champs['id_groupe'] = $id_groupe;
		$champs['type'] = $row['titre'];
	} else {
		return false;
	}

	if ($set) {
		$champs = array_merge($champs, $set);
	}

	// Envoyer aux plugins
	$champs = pipeline('pre_insertion',
		array(
			'args' => array(
				'table' => 'spip_mots',
			),
			'data' => $champs
		)
	);

	$id_mot = sql_insertq("spip_mots", $champs);

	pipeline('post_insertion',
		array(
			'args' => array(
				'table' => 'spip_mots',
				'id_objet' => $id_mot
			),
			'data' => $champs
		)
	);

	return $id_mot;
}

/**
 * Modifier un mot
 *
 * @param int $id_mot
 *     Identifiant du mot clé à modifier
 * @param array|null $set
 *     Couples (colonne => valeur) de données à modifier.
 *     En leur absence, on cherche les données dans les champs éditables
 *     qui ont été postés (via _request())
 * @return string|null
 *     - Chaîne vide si aucune erreur,
 *     - Null si aucun champ n'est à modifier,
 *     - Chaîne contenant un texte d'erreur sinon.
 */
function mot_modifier($id_mot, $set = null) {
	include_spip('inc/modifier');
	$c = collecter_requests(
	// white list
		array(
			'titre',
			'descriptif',
			'texte',
			'id_groupe'
		),
		// black list
		array('id_groupe'),
		// donnees eventuellement fournies
		$set
	);

	if ($err = objet_modifier_champs('mot', $id_mot,
		array(
			'data' => $set,
			'nonvide' => array('titre' => _T('info_sans_titre'))
		),
		$c)
	) {
		return $err;
	}

	$c = collecter_requests(array('id_groupe', 'type'), array(), $set);
	$err = mot_instituer($id_mot, $c);

	return $err;
}

/**
 * Instituer un mot clé : modifier son groupe parent
 *
 * @pipeline_appel pre_insertion
 * @pipeline_appel post_insertion
 *
 * @param int $id_mot
 *     Identifiant du mot clé
 * @param array $c
 *     Couples (colonne => valeur) des données à instituer
 * @return null|string
 *     Null si aucun champ à modifier, chaîne vide sinon.
 */
function mot_instituer($id_mot, $c) {
	$champs = array();
	// regler le groupe
	if (isset($c['id_groupe']) or isset($c['type'])) {
		$row = sql_fetsel("titre", "spip_groupes_mots", "id_groupe=" . intval($c['id_groupe']));
		if ($row) {
			$champs['id_groupe'] = $c['id_groupe'];
			$champs['type'] = $row['titre'];
		}
	}

	// Envoyer aux plugins
	$champs = pipeline('pre_edition',
		array(
			'args' => array(
				'table' => 'spip_mots',
				'id_objet' => $id_mot,
				'action' => 'instituer',
			),
			'data' => $champs
		)
	);

	if (!$champs) {
		return;
	}

	sql_updateq('spip_mots', $champs, "id_mot=" . intval($id_mot));

	//
	// Post-modifications
	//

	// Invalider les caches
	include_spip('inc/invalideur');
	suivre_invalideur("id='mot/$id_mot'");

	// Pipeline
	pipeline('post_edition',
		array(
			'args' => array(
				'table' => 'spip_mots',
				'id_objet' => $id_mot,
				'action' => 'instituer',
			),
			'data' => $champs
		)
	);

	// Notifications
	if ($notifications = charger_fonction('notifications', 'inc')) {
		$notifications('instituermot', $id_mot,
			array('id_groupe' => $champs['id_groupe'])
		);
	}

	return ''; // pas d'erreur
}

/**
 * Supprimer un mot
 *
 * @pipeline_appel trig_supprimer_objets_lies
 *
 * @param int $id_mot
 *     Identifiant du mot clé à supprimer
 * @return void
 */
function mot_supprimer($id_mot) {
	sql_delete("spip_mots", "id_mot=" . intval($id_mot));
	mot_dissocier($id_mot, '*');
	pipeline('trig_supprimer_objets_lies',
		array(
			array('type' => 'mot', 'id' => $id_mot)
		)
	);
}


/**
 * Associer un mot à des objets listés sous forme
 * `array($objet=>$id_objets,...)`
 *
 * $id_objets peut lui-même être un scalaire ou un tableau pour une
 * liste d'objets du même type
 *
 * On peut passer optionnellement une qualification du (des) lien(s) qui sera
 * alors appliquée dans la foulée. En cas de lot de liens, c'est la
 * même qualification qui est appliquée à tous.
 *
 * @example
 *     ```
 *     mot_associer(3, array('auteur'=>2));
 *     // Ne fonctionnera pas ici car pas de champ 'vu' sur spip_mots_liens :
 *     mot_associer(3, array('auteur'=>2), array('vu'=>'oui));
 *     ```
 *
 * @param int $id_mot
 *     Identifiant du mot à faire associer
 * @param array $objets
 *     Description des associations à faire
 * @param array $qualif
 *     Couples (colonne => valeur) de qualifications à faire appliquer
 * @return int|bool
 *     Nombre de modifications, false si erreur
 */
function mot_associer($id_mot, $objets, $qualif = null) {

	include_spip('action/editer_liens');

	// si il s'agit d'un groupe avec 'unseul', alors supprimer d'abord les autres
	// mots de ce groupe associe a ces objets
	$id_groupe = sql_getfetsel('id_groupe', 'spip_mots', 'id_mot=' . intval($id_mot));
	if (un_seul_mot_dans_groupe($id_groupe)) {
		$mots_groupe = sql_allfetsel("id_mot", "spip_mots", "id_groupe=" . intval($id_groupe));
		$mots_groupe = array_map('reset', $mots_groupe);
		objet_dissocier(array('mot' => $mots_groupe), $objets);
	}

	return objet_associer(array('mot' => $id_mot), $objets, $qualif);
}


/**
 * Dissocier un mot des objets listés sous forme
 * `array($objet=>$id_objets,...)`
 *
 * $id_objets peut lui-même être un scalaire ou un tableau pour une
 * liste d'objets du même type
 *
 * un * pour $id_mot,$objet,$id_objet permet de traiter par lot
 *
 * @param int $id_mot
 *     Identifiant du mot à faire dissocier
 * @param array $objets
 *     Description des dissociations à faire
 * @return int|bool
 *     Nombre de modifications, false si erreur
 */
function mot_dissocier($id_mot, $objets) {
	include_spip('action/editer_liens');

	return objet_dissocier(array('mot' => $id_mot), $objets);
}

/**
 * Qualifier le lien d'un mot avec les objets listés
 * `array($objet=>$id_objets,...)`
 *
 * $id_objets peut lui-même être un scalaire ou un tableau pour une
 * liste d'objets du même type
 *
 * Une * pour $id_auteur,$objet,$id_objet permet de traiter par lot
 *
 * @example
 *     ```
 *     $c = array('vu'=>'oui');
 *     ```
 *
 * @param int $id_mot
 *     Identifiant du mot à faire associer
 * @param array $objets
 *     Description des associations à faire
 * @param array $qualif
 *     Couples (colonne => valeur) de qualifications à faire appliquer
 * @return int|bool
 *     Nombre de modifications, false si erreur
 */
function mot_qualifier($id_mot, $objets, $qualif) {
	include_spip('action/editer_liens');

	return objet_qualifier(array('mot' => $id_mot), $objets, $qualif);
}


/**
 * Teste si un groupe ne doit avoir qu'un seul mot clé associé
 *
 * Renvoyer TRUE si le groupe de mot ne doit être associé qu'une fois aux objet
 * (maximum un seul mot de ce groupe associé à chaque objet)
 *
 * @param int $id_groupe
 *     Identifiant du groupe de mot clé
 * @return bool
 *     true si un seul mot doit être lié avec ce groupe, false sinon.
 */
function un_seul_mot_dans_groupe($id_groupe) {
	return sql_countsel('spip_groupes_mots', "id_groupe=$id_groupe AND unseul='oui'");
}


// Fonctions Dépréciées
// --------------------

/**
 * Insertion d'un mot dans un groupe
 *
 * @deprecated Utiliser mot_inserer()
 * @see mot_inserer()
 *
 * @param int $id_groupe
 *     Identifiant du groupe de mot
 * @return int|bool
 *     Identifiant du nouveau mot clé, false si erreur.
 */
function insert_mot($id_groupe) {
	return mot_inserer($id_groupe);
}

/**
 * Modifier un mot
 *
 * @deprecated Utiliser mot_modifier()
 * @see mot_modifier()
 *
 * @param int $id_mot
 *     Identifiant du mot clé à modifier
 * @param array|null $set
 *     Couples (colonne => valeur) de données à modifier.
 *     En leur absence, on cherche les données dans les champs éditables
 *     qui ont été postés
 * @return string|null
 *     - Chaîne vide si aucune erreur,
 *     - Null si aucun champ à modifier,
 *     - Chaîne contenant un texte d'erreur sinon.
 */
function mots_set($id_mot, $set = null) {
	return mot_modifier($id_mot, $set);
}

/**
 * Créer une révision d'un mot
 *
 * @deprecated Utiliser mot_modifier()
 * @see mot_modifier()
 *
 * @param int $id_mot
 *     Identifiant du mot clé à modifier
 * @param array|null $c
 *     Couples (colonne => valeur) de données à modifier.
 *     En leur absence, on cherche les données dans les champs éditables
 *     qui ont été postés
 * @return string|null
 *     - Chaîne vide si aucune erreur,
 *     - Null si aucun champ à modifier,
 *     - Chaîne contenant un texte d'erreur sinon.
 */
function revision_mot($id_mot, $c = false) {
	return mot_modifier($id_mot, $c);
}
