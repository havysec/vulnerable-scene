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

// http://code.spip.net/@action_instituer_syndic_article_dist
function action_urls_verrouiller_dist() {

	$securiser_action = charger_fonction('securiser_action', 'inc');
	$arg = $securiser_action();

	include_spip('inc/autoriser');
	$arg = explode('-', $arg);
	$type = array_shift($arg);
	$id = array_shift($arg);
	$url = implode('-', $arg);
	if (autoriser('modifierurl', $type, $id)) {
		include_spip('action/editer_url');
		url_verrouiller($type, $id, $url);
	}
}
