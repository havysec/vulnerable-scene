<?php

if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}

/**
 * Trouver le fond pour embarquer un document
 * - avec une extension
 * - avec un mime_type donne
 *
 * => modeles/emb_html.html si il existe
 * => modeles/text_html.html si il existe,
 * => modeles/text.html sinon
 *
 * @param  $extension
 * @param  $mime_type
 * @return mixed
 */
function trouver_modele_emb($extension, $mime_type) {
	if ($extension and trouve_modele($fond = "emb_" . $extension)) {
		return $fond;
	}
	$fond = preg_replace(',\W,', '_', $mime_type);
	if (trouve_modele($fond)) {
		return $fond;
	} else {
		return preg_replace(',\W.*$,', '', $mime_type);
	}
}
