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

include_spip('inc/dump');
include_spip('inc/autoriser');

/**
 * Telecharger un dump quand on est webmestre
 *
 * @param string $arg
 */
function action_supprimer_dump_dist($arg = null) {
	if (!$arg) {
		$securiser_action = charger_fonction('securiser_action', 'inc');
		$arg = $securiser_action();
	}

	$fichier = $arg;

	if (autoriser('webmestre')) {
		// verifier que c'est bien une sauvegarde
		include_spip("inc/dump");
		$dir = dump_repertoire();
		$dumps = dump_lister_sauvegardes($dir);

		foreach ($dumps as $dump) {
			if ($dump['fichier'] == $fichier) {
				spip_unlink($dir . $fichier);
			}
		}
	}

}
