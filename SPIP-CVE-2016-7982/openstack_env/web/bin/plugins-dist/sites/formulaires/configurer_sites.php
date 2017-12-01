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
 * Gestion du formulaire de configuration des sites et de la syndication
 *
 * @package SPIP\Sites\Formulaires
 **/

if (!defined("_ECRIRE_INC_VERSION")) {
	return;
}

/**
 * Chargement du formulaire de configuration des sites et de la syndication
 *
 * @return array
 *     Environnement du formulaire
 **/
function formulaires_configurer_sites_charger_dist() {
	foreach (array(
		         "activer_sites",
		         "activer_syndic",
		         "proposer_sites",
		         "moderation_sites",
	         ) as $m) {
		$valeurs[$m] = isset($GLOBALS['meta'][$m]) ? $GLOBALS['meta'][$m] : '';
	}

	return $valeurs;
}

/**
 * Traitement du formulaire de configuration des sites et de la syndication
 *
 * @return array
 *     Retours du traitement
 **/
function formulaires_configurer_sites_traiter_dist() {
	$res = array('editable' => true);
	foreach (array(
		         "activer_sites",
		         "activer_syndic",
		         "moderation_sites",
	         ) as $m) {
		if (!is_null($v = _request($m))) {
			ecrire_meta($m, $v == 'oui' ? 'oui' : 'non');
		}
	}

	$v = _request('proposer_sites');
	ecrire_meta('proposer_sites', in_array($v, array('0', '1', '2')) ? $v : '0');

	$res['message_ok'] = _T('config_info_enregistree');

	return $res;
}
