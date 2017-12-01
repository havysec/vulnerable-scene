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
 * Gestion du formulaire de configuration des documents
 *
 * @package SPIP\Medias\Formulaires
 **/

if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}

/**
 * Chargement du formulaire de configuration des documents
 *
 * @return array
 *     Environnement du formulaire
 **/
function formulaires_configurer_documents_charger_dist() {
	foreach (array(
		         "documents_objets",
		         "documents_date",
	         ) as $m) {
		$valeurs[$m] = isset($GLOBALS['meta'][$m]) ? $GLOBALS['meta'][$m] : '';
	}
	$valeurs['documents_objets'] = explode(',', $valeurs['documents_objets']);

	return $valeurs;
}

/**
 * Traitement du formulaire de configuration des documents
 *
 * @return array
 *     Retours du traitement
 **/
function formulaires_configurer_documents_traiter_dist() {
	$res = array('editable' => true);
	if (!is_null($v = _request($m = 'documents_date'))) {
		ecrire_meta($m, $v == 'oui' ? 'oui' : 'non');
	}
	if (!is_null($v = _request($m = 'documents_objets'))) {
		ecrire_meta($m, is_array($v) ? implode(',', $v) : '');
	}

	$res['message_ok'] = _T('config_info_enregistree');

	return $res;
}
