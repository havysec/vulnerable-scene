<?php

/**
 * Action retournant un morceau du plan du site (en ajax)
 *
 * @plugin     Plan du site dans l’espace privé
 * @copyright  2015
 * @author     Matthieu Marcillaud
 * @licence    GNU/GPL
 * @package    SPIP\Plan\Action
 */

if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}


function action_plan_dist() {

	include_spip('inc/autoriser');
	if (!autoriser('ecrire')) {
		return false;
	}

	include_spip('base/objets');
	include_spip('inc/utils');
	$objet = table_objet(_request('objet'));

	$env = array(
		'id_rubrique' => intval(_request('id_rubrique')),
		// pour le dépliement d'une rubrique, ne pas lister le contenu récursivement
		'lister' => ($objet == 'rubriques') ? 'rubrique' : 'tout',
		'conteneur' => 'non'
	);

	if ($statut = _request('statut')) {
		$env['statut'] = $statut;
	}

	$fond = "prive/squelettes/inclure/plan-$objet";
	header("Content-Type: text/html; charset=" . $GLOBALS['meta']['charset']);

	if (trouver_fond($fond)) {
		echo recuperer_fond($fond, $env);
	} else {
		echo "";
	}
}
