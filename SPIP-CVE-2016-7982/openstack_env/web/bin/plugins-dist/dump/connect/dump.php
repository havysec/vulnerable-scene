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

/**
 * Se reconnecter a la base sqlite dont le nom est stocke dans le fichier de statut
 */

include_spip('inc/dump');
if ($args = dump_serveur()) {
	$GLOBALS['spip_connect_version'] = 0.7;
	if (call_user_func_array('spip_connect_db', $args)) {
		define('_DUMP_SERVEUR_OK', true);
	}
}
