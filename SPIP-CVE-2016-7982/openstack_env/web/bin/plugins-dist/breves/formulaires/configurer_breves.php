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
 * Gestion du formulaire de configuration des brèves
 *
 * @package SPIP\Breves\Formulaires
 **/
if (!defined("_ECRIRE_INC_VERSION")) {
	return;
}

/**
 * Chargement du formulaire de configuration des brèves
 *
 * @return array
 *     Environnement du formulaire
 **/
function formulaires_configurer_breves_charger_dist() {
	foreach (array(
		         "activer_breves",
	         ) as $m) {
		$valeurs[$m] = $GLOBALS['meta'][$m];
	}

	return $valeurs;
}

/**
 * Traitement du formulaire de configuration des brèves
 *
 * @return array
 *     Retours du traitement
 **/
function formulaires_configurer_breves_traiter_dist() {
	$res = array('editable' => true);
	foreach (array(
		         "activer_breves",
	         ) as $m) {
		if (!is_null($v = _request($m))) {
			ecrire_meta($m, $v == 'oui' ? 'oui' : 'non');
		}
	}

	$res['message_ok'] = _T('config_info_enregistree');

	return $res;
}
