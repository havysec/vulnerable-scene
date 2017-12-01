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
 * Gestion du formulaire de configuration indiquant où les forums peuvent
 * être activés
 *
 * @package SPIP\Forum\Formulaires
 **/
if (!defined("_ECRIRE_INC_VERSION")) {
	return;
}

/**
 * Récupérer le réglage des forums publics d'un objet
 *
 * @param int $id_objet
 * @param string $objet
 * @return bool
 *     true si les forums publics sont autorisés, false sinon
 **/
function get_forums_publics($id_objet = 0, $objet = 'article') {

	if ($objet == 'article' and $id_objet) {
		$obj = sql_fetsel("accepter_forum", "spip_articles", "id_article=" . intval($id_objet));

		if ($obj) {
			return $obj['accepter_forum'];
		}
	} else { // dans ce contexte, inutile
		return substr($GLOBALS['meta']["forums_publics"], 0, 3);
	}

	return $GLOBALS['meta']["forums_publics"];
}

/**
 * Charger
 *
 * @param int $id_objet
 * @param string $objet
 * @return array
 *     Contexte du squelette du formulaire
 */
function formulaires_activer_forums_objet_charger_dist($id_objet, $objet = 'article') {
	if (!autoriser('modererforum', $objet, $id_objet)) {
		return false;
	}

	include_spip('inc/presentation');
	include_spip('base/abstract_sql');
	$nb_forums = sql_countsel("spip_forum",
		"objet=" . sql_quote($objet) . " AND id_objet=" . intval($id_objet) . " AND statut IN ('publie', 'off', 'prop', 'spam')");
	$editable = ($objet == 'article') ? true : false;
	if (!$editable and !$nb_forums) {
		return false;
	}

	return array(
		'editable' => $editable,
		'objet' => $objet,
		'id_objet' => $id_objet,
		'accepter_forum' => get_forums_publics($id_objet, $objet),
		'_suivi_forums' => $nb_forums ? _T('forum:icone_suivi_forum', array('nb_forums' => $nb_forums)) : "",
	);

}

/**
 * Traiter
 *
 * @param int $id_objet
 * @param string $objet
 * @return array
 *     Retours des traitements
 */
function formulaires_activer_forums_objet_traiter_dist($id_objet, $objet = 'article') {
	include_spip('inc/autoriser');
	if ($objet == 'article' and autoriser('modererforum', $objet, $id_objet)) {
		$statut = _request('accepter_forum');
		include_spip('base/abstract_sql');
		sql_updateq("spip_articles", array("accepter_forum" => $statut), "id_article=" . intval($id_objet));

		if ($statut == 'abo') {
			ecrire_meta('accepter_visiteurs', 'oui');
		}
		include_spip('inc/invalideur');
		suivre_invalideur("id='$objet/$id_objet'");
	}

	return array('message_ok' => _T('config_info_enregistree'), 'editable' => true);
}
