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
 * Gestion de l'action urls_actualiser
 *
 * @package SPIP\Urls_etendues\Action
 **/

if (!defined("_ECRIRE_INC_VERSION")) {
	return;
}

/**
 * Action qui actualise toutes URLs
 *
 * Actualise les éléments (objet/id_objet) de la table des urls,
 * ajoutant donc à chacun une URL plus récente si son calcul
 * est différent de ce qui est stocké.
 *
 * Cette action ne supprime pas les anciennes urls.
 * Elle n'invalide pas non plus les URLs «permanentes».
 **/
function action_urls_actualiser_dist() {

	$securiser_action = charger_fonction('securiser_action', 'inc');
	$arg = $securiser_action();

	if (!defined('_VAR_URLS')) {
		define('_VAR_URLS', true);
	}
	$type = $id = "";
	$res = sql_select("type,id_objet", "spip_urls", "", "", "type,id_objet");
	while ($row = sql_fetch($res)) {
		if ($row['id_objet'] !== $id
			or $row['type'] !== $type
		) {
			$id = $row['id_objet'];
			$type = $row['type'];
			generer_url_entite($id, $type, "", "", true);
		}
	}
}
