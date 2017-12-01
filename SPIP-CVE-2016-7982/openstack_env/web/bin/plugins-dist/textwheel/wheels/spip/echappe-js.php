<?php

/**
 * Fonctions utiles pour la wheel echappe-js
 *
 * @SPIP\Textwheel\Wheel\SPIP\Fonctions
 **/

if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}

function echappe_anti_xss($match) {
	static $safehtml;

	if (!is_array($match) or !strlen($match[0])) {
		return "";
	}
	$texte = &$match[0];

	// on echappe les urls data: javascript: et tout ce qui ressemble
	if (strpos($texte, ":") !== false
		and preg_match(",(data|script)\s*:,iS", $texte)
	) {
		$texte = nl2br(htmlspecialchars($texte));
	} // on echappe si on a possiblement un attribut onxxx et que ca passe pas dans safehtml
	elseif (stripos($texte, "on") !== false
		and preg_match(",\bon\w+\s*=,i", $texte)
	) {
		if (!isset($safehtml)) {
			$safehtml = charger_fonction('safehtml', 'inc', true);
		}
		if (!$safehtml or strlen($safehtml($texte)) !== strlen($texte)) {
			$texte = nl2br(htmlspecialchars($texte));
		}
	}

	if (strpos($texte, "<") === false) {
		$texte = "<code class=\"echappe-js\">$texte</code>";
	}

	return $texte;
}
