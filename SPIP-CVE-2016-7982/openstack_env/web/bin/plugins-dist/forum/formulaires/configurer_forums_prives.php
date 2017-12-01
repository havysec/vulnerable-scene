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

function formulaires_configurer_forums_prives_charger_dist() {

	return array(
		'forum_prive_objets' => explode(',', $GLOBALS['meta']["forum_prive_objets"]),
		'forum_prive' => $GLOBALS['meta']["forum_prive"],
		'forum_prive_admin' => $GLOBALS['meta']["forum_prive_admin"],
	);

}

function formulaires_configurer_forums_prives_traiter_dist() {
	$res = array('editable' => true);

	if (!is_null($v = _request($m = 'forum_prive_objets'))) {
		ecrire_meta($m, is_array($v) ? implode(',', $v) : '');
	}
	if (!is_null($v = _request($m = 'forum_prive'))) {
		ecrire_meta($m, $v == 'oui' ? 'oui' : 'non');
	}
	if (!is_null($v = _request($m = 'forum_prive_admin'))) {
		ecrire_meta($m, $v == 'oui' ? 'oui' : 'non');
	}

	$res['message_ok'] = _T('config_info_enregistree');

	return $res;
}
