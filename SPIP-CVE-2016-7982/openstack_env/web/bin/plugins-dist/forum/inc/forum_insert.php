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

if (!defined("_ECRIRE_INC_VERSION")) {
	return;
}
include_spip('inc/forum');
include_spip('inc/filtres');
include_spip('inc/actions');

// Ce fichier est inclus par dist/formulaires/forum.php

// http://code.spip.net/@mots_du_forum
function mots_du_forum($ajouter_mot, $id_message) {
	include_spip('action/editer_mot');
	mot_associer($ajouter_mot, array('forum' => $id_message));
}


// http://code.spip.net/@tracer_erreur_forum
function tracer_erreur_forum($type = '') {
	spip_log("erreur forum ($type): " . print_r($_POST, true));

	define('_TRACER_ERREUR_FORUM', false);
	if (_TRACER_ERREUR_FORUM) {
		$envoyer_mail = charger_fonction('envoyer_mail', 'inc');
		$envoyer_mail($GLOBALS['meta']['email_webmaster'], "erreur forum ($type)",
			"erreur sur le forum ($type) :\n\n" .
			'$_POST = ' . print_r($_POST, true) . "\n\n" .
			'$_SERVER = ' . print_r($_SERVER, true));
	}
}

/**
 * Un parametre permet de forcer le statut (exemple: plugin antispam)
 *
 * http://code.spip.net/@inc_forum_insert_dist
 *
 * @param $objet
 * @param $id_objet
 * @param $id_forum
 *   en reponse a
 * @param null $force_statut
 * @return bool
 */
function inc_forum_insert_dist($objet, $id_objet, $id_forum, $force_statut = null) {

	if (!in_array($force_statut, array('privrac', 'privadm'))) {
		if (!strlen($objet)
			or !intval($id_objet)
		) {
			spip_log("Erreur insertion forum sur objet='$objet', id_objet=$id_objet", 'forum.' . _LOG_ERREUR);

			return 0;
		}
	}
	spip_log("insertion de forum $force_statut sur $objet $id_objet (+$id_forum)", 'forum');


	include_spip('inc/filtres');
	include_spip('inc/modifier');
	include_spip('inc/session');
	$champs = objet_info('forum', 'champs_editables');
	$c = collecter_requests($champs, array());

	$c['statut'] = 'off';
	$c['objet'] = $objet;
	$c['id_objet'] = $id_objet;
	$c['auteur'] = sinon(session_get('nom'), session_get('session_nom'));
	$c['email_auteur'] = sinon(session_get('email'), session_get('session_email'));

	$c = pipeline('pre_edition', array(
		'args' => array(
			'table' => 'spip_forum',
			'id_objet' => $id_forum,
			'action' => 'instituer'
		),
		'data' => forum_insert_statut($c, $force_statut)
	));

	$id_reponse = forum_insert_base($c, $id_forum, $objet, $id_objet, $c['statut'], _request('ajouter_mot'));

	if (!$id_reponse) {
		spip_log("Echec insertion forum sur $objet $id_objet (+$id_forum)", 'forum.' . _LOG_ERREUR);
	} else {
		spip_log("forum insere' $id_reponse sur $objet $id_objet (+$id_forum)", 'forum');
	}

	return $id_reponse;

}

// http://code.spip.net/@forum_insert_base
function forum_insert_base($c, $id_forum, $objet, $id_objet, $statut, $ajouter_mot = false) {

	if (!in_array($statut, array('privrac', 'privadm'))) {
		// si le statut est vide, c'est qu'on ne veut pas de ce presume spam !
		if (!$statut or !$objet or !$id_objet) {
			$args = func_get_args();
			spip_log("Erreur sur forum_insert_base " . var_export($args, 1), 'forum.' . _LOG_ERREUR);

			return false;
		}
	}

	// Entrer le message dans la base
	$id_reponse = sql_insertq('spip_forum', array(
		'date_heure' => date('Y-m-d H:i:s'),
		'ip' => $GLOBALS['ip'],
		'id_auteur' => $GLOBALS['visiteur_session']['id_auteur']
	));

	if ($id_reponse) {
		if ($id_forum > 0) {
			$id_thread = sql_getfetsel("id_thread", "spip_forum", "id_forum =" . intval($id_forum));
		} else {
			$id_thread = $id_reponse;
		} # id_thread oblige INSERT puis UPDATE.

		// Entrer les cles
		sql_updateq('spip_forum', array(
			'id_parent' => $id_forum,
			'objet' => $objet,
			'id_objet' => $id_objet,
			'id_thread' => $id_thread,
			'statut' => $statut
		), "id_forum=" . intval($id_reponse));

		// Entrer les mots-cles associes
		if ($ajouter_mot) {
			mots_du_forum($ajouter_mot, $id_reponse);
		}

		//
		// Entree du contenu et invalidation des caches
		//
		include_spip('action/editer_forum');
		revision_forum($id_reponse, $c);

		// Ajouter un document
		if (isset($_FILES['ajouter_document'])
			and $_FILES['ajouter_document']['tmp_name']
		) {
			$files[] = array(
				'tmp_name' => $_FILES['ajouter_document']['tmp_name'],
				'name' => $_FILES['ajouter_document']['name']
			);
			$ajouter_documents = charger_fonction('ajouter_documents', 'action');
			$ajouter_documents(
				'new',
				$files,
				'forum',
				$id_reponse,
				'document');
			// supprimer le temporaire et ses meta donnees
			spip_unlink($_FILES['ajouter_document']['tmp_name']);
			spip_unlink(preg_replace(',\.bin$,',
				'.txt', $_FILES['ajouter_document']['tmp_name']));
		}

		// Notification
		$quoi = (strncmp($statut, 'priv', 4) == 0 ? 'forumprive' : 'forumposte');
		if ($notifications = charger_fonction('notifications', 'inc')) {
			$notifications($quoi, $id_reponse);
		}
	}

	return $id_reponse;
}


// http://code.spip.net/@forum_insert_statut
function forum_insert_statut($champs, $forcer_statut = null) {
	include_spip('inc/forum');
	$statut = controler_forum($champs['objet'], $champs['id_objet']);

	if ($forcer_statut !== null) {
		$champs['statut'] = $forcer_statut;
	} else {
		$champs['statut'] = ($statut == 'non') ? 'off' : (($statut == 'pri') ? 'prop' : 'publie');
	}

	return $champs;
}
