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

function formulaires_configurer_forums_contenu_charger_dist() {

	return array(
		'forums_titre' => $GLOBALS['meta']["forums_titre"],
		'forums_texte' => $GLOBALS['meta']["forums_texte"],
		'forums_urlref' => $GLOBALS['meta']["forums_urlref"],
		'forums_afficher_barre' => $GLOBALS['meta']["forums_afficher_barre"],
		'forums_forcer_previsu' => $GLOBALS['meta']["forums_forcer_previsu"],
		'formats_documents_forum' => $GLOBALS['meta']['formats_documents_forum'],
	);

}

function formulaires_configurer_forums_contenu_verifier_dist() {
	$erreurs = array();

	if (!_request('forums_titre') and !_request('forums_texte') and !_request('forums_urlref')) {
		$erreurs['forums_titre'] = _T('info_obligatoire');
	}

	foreach (array(
		         'forums_titre',
		         'forums_texte',
		         'forums_urlref',
		         'forums_afficher_barre',
		         'forums_forcer_previsu'
	         ) as $champ) {
		if (_request($champ) !== 'oui') {
			set_request($champ, 'non');
		}
	}

	return $erreurs;
}

function formulaires_configurer_forums_contenu_traiter_dist() {
	include_spip('inc/config');
	appliquer_modifs_config();

	return array('message_ok' => _T('config_info_enregistree'));
}
