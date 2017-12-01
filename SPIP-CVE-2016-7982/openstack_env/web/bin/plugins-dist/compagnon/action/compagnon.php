<?php


/**
 * Gestion de l'action compagnon
 *
 * @package SPIP\Compagnon\Action
 **/

if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}

/**
 * Action compagnon : indique qu'un auteur a validé un message d'aide
 *
 * @global array $GLOBALS ['visiteur_session']
 **/
function action_compagnon_dist() {
	$securiser_action = charger_fonction('securiser_action', 'inc');
	$arg = $securiser_action();

	if (substr($arg, 0, 8) !== 'compris/') {
		include_spip('inc/minipres');
		echo minipres("Arguments de l'action compagnon non compris");
		exit;
	}
	$quoi = substr($arg, 8);
	$auteur = $GLOBALS['visiteur_session']['id_auteur'];

	include_spip('inc/config');
	ecrire_config("compagnon/$auteur/$quoi", 1);

}
