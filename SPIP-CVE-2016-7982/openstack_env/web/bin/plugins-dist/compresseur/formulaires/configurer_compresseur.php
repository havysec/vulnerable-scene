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
 * Gestion du formulaire de configuration du compresseur
 *
 * @package SPIP\Compresseur\Formulaires
 **/
if (!defined("_ECRIRE_INC_VERSION")) {
	return;
}

/**
 * Chargement du formulaire de configuration du compresseur
 *
 * @return array
 *     Environnement du formulaire
 **/
function formulaires_configurer_compresseur_charger_dist() {

	$valeurs = array();

	$valeurs['auto_compress_js'] = $GLOBALS['meta']['auto_compress_js'];
	$valeurs['auto_compress_css'] = $GLOBALS['meta']['auto_compress_css'];
	$valeurs['auto_compress_closure'] = $GLOBALS['meta']['auto_compress_closure'];
	$valeurs['url_statique_ressources'] = $GLOBALS['meta']['url_statique_ressources'];

	return $valeurs;

}

/**
 * Vérifications du formulaire de configuration du compresseur
 *
 * @return array
 *     Tableau des erreurs
 **/
function formulaires_configurer_compresseur_verifier_dist() {
	$erreurs = array();

	// les checkbox
	foreach (array('auto_compress_js', 'auto_compress_css', 'auto_compress_closure') as $champ) {
		if (_request($champ) != 'oui') {
			set_request($champ, 'non');
		}
	}

	if ($url = _request('url_statique_ressources')){
		$url = preg_replace(",/?\s*$,", "", $url);
		if (!tester_url_absolue($url)) {
			$protocole = explode('://',$GLOBALS['meta']['adresse_site']);
			$protocole = reset($protocole);
			$url = $protocole . "://$url";
		}
		set_request('url_statique_ressources',$url);
	}


	return $erreurs;
}

/**
 * Traitement du formulaire de configuration du compresseur
 *
 * @return array
 *     Retours du traitement
 **/
function formulaires_configurer_compresseur_traiter_dist() {
	include_spip('inc/config');
	appliquer_modifs_config();

	return array('message_ok' => _T('config_info_enregistree'));
}
