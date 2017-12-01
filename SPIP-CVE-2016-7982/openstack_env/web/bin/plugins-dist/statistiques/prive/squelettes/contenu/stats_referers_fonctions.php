<?php

if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}

// Vignettes de previsulation des referers
// dans les statistiques
// 2 de trouves, possibilite de switcher
// - Alexa, equivalent Thumbshots, avec vignettes beaucoup plus grandes mais avertissement si pas de preview
//   Pour Alexa, penser a indiquer l'url du site dans l'id.
//   Dans Alexa, si on supprimer size=small, alors vignettes tres grandes
// - apercite.fr : on conserve exactement la m�me expression pour ins�rer l'url du site
if (!isset($GLOBALS['source_vignettes'])) {
	$GLOBALS['source_vignettes'] = "http://www.apercite.fr/api/apercite/120x90/oui/oui/http://";
}
// $source_vignettes = "http://pthumbnails.alexa.com/image_server.cgi?id=www.monsite.net&size=small&url=http://";

function vigneter_referer($url) {

	if (!strlen($GLOBALS['source_vignettes']) or $GLOBALS['meta']["activer_captures_referers"] == 'non') {
		return '';
	}

	return $GLOBALS['source_vignettes'] . rawurlencode(preg_replace(";^[a-z]{3,6}://;", "", $url));
}
