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

function action_supprimer_url_dist($arg = null) {

	if (is_null($arg)) {
		// Rien a faire ici pour le moment
		$securiser_action = charger_fonction('securiser_action', 'inc');
		$arg = $securiser_action();
	}
	if (strncmp($arg, "-1-", 3) == 0) {
		$id_parent = -1;
		$url = substr($arg, 3);
	} else {
		$arg = explode('-', $arg);
		$id_parent = array_shift($arg);
		$url = implode('-', $arg);
	}

	$where = 'id_parent=' . intval($id_parent) . " AND url=" . sql_quote($url);
	if ($row = sql_fetsel('*', 'spip_urls', $where)) {

		if (autoriser('modifierurl', $row['type'], $row['id_objet'])) {
			sql_delete('spip_urls', $where);
		} else {
			spip_log('supprimer sans autorisation l\'URL ' . $id_parent . "://" . $url, "urls." . _LOG_ERREUR);
		}

	} else {
		spip_log('Impossible de supprimer une URL inconnue ' . $id_parent . "://" . $url, "urls." . _LOG_INFO_IMPORTANTE);
	}


}
