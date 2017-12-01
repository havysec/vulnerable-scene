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


if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}

// fonction pour le pipeline
function sites_autoriser() { }


// bouton du bandeau
function autoriser_sites_menu_dist($faire, $type = '', $id = 0, $qui = null, $opt = null) {
	return
		autoriser('voir', '_sites', $id, $qui, $opt);
}

// Le bouton de création d'un site est présent si on peut en créer un.
function autoriser_sitecreer_menu_dist($faire, $type, $id, $qui, $opt) {
	return
		autoriser_site_creer_dist($faire, $type, $id, $qui, $opt);
}

function autoriser_sites_voir_dist($faire, $type = '', $id = 0, $qui = null, $opt = null) {
	return
		($GLOBALS['meta']['activer_sites'] != 'non');
}

// Moderer la syndication ?
// = modifier l'objet correspondant (si forum attache a un objet)
// = droits par defaut sinon (admin complet pour moderation complete)
// http://code.spip.net/@autoriser_modererforum_dist
function autoriser_site_moderer_dist($faire, $type, $id, $qui, $opt) {
	return
		autoriser('modifier', 'site', $id, $qui, $opt);
}

function autoriser_site_purger_dist($faire, $type, $id, $qui, $opt) {
	return
		autoriser('moderer', 'site', $id, $qui, $opt);
}


function autoriser_controlersyndication_menu_dist($faire, $type, $id, $qui, $opt) {
	return ($qui['statut'] == '0minirezo' and sql_countsel('spip_syndic_articles'));
}

// Creer un nouveau site ?
function autoriser_site_creer_dist($faire, $type, $id, $qui, $opt) {
	return
		($GLOBALS['meta']["activer_sites"] != 'non'
			and verifier_table_non_vide()
			and (
				$qui['statut'] == '0minirezo'
				or ($GLOBALS['meta']['proposer_sites'] >=
					($qui['statut'] == '1comite' ? 1 : 2))));
}

// Pour creer un site dans la rubrique $id il faut:
// - que la rubrique existe et soit accessible pour l'auteur
// - que l'on puisse créer un site
// http://code.spip.net/@autoriser_rubrique_creersitedans_dist
function autoriser_rubrique_creersitedans_dist($faire, $type, $id, $qui, $opt) {
	return
		$id
		and autoriser('voir', 'rubrique', $id)
		and autoriser_site_creer_dist($faire, $type, $id, $qui, $opt);
}


// Autoriser a modifier un site
// http://code.spip.net/@autoriser_site_modifier_dist
function autoriser_site_modifier_dist($faire, $type, $id, $qui, $opt) {
	if ($qui['statut'] == '0minirezo' and !$qui['restreint']) {
		return true;
	}

	$r = sql_fetsel("id_rubrique,statut", "spip_syndic", "id_syndic=" . intval($id));

	return ($r
		and autoriser('voir', 'rubrique', $r['id_rubrique'])
		and
		($r['statut'] == 'publie' or (isset($opt['statut']) and $opt['statut'] == 'publie'))
			? autoriser('publierdans', 'rubrique', $r['id_rubrique'], $qui, $opt)
			: in_array($qui['statut'], array('0minirezo', '1comite'))
	);
}

// Autoriser a voir un site $id_syndic
// http://code.spip.net/@autoriser_site_voir_dist
function autoriser_site_voir_dist($faire, $type, $id, $qui, $opt) {
	return
		autoriser_site_modifier_dist($faire, $type, $id, $qui, $opt);
}

// Autoriser l'importation de sites que si on peut en créer
function autoriser_sites_importer_dist($faire, $type, $id, $qui, $opt) {
	return
		autoriser_site_creer_dist($faire, $type, $id, $qui, $opt);
}

// Autoriser l'exportation de sites que si la table n'est pas vide
function autoriser_sites_exporter_dist($faire, $type, $id, $qui, $opt) {
	return
		verifier_table_non_vide('spip_syndic');
}
