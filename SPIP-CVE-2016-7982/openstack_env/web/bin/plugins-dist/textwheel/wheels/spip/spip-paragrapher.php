<?php

/**
 * Fonctions utiles pour les wheels SPIP sur les paragraphes
 *
 * @SPIP\Textwheel\Wheel\SPIP\Fonctions
 **/

if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}

if (!defined('_BALISES_BLOCS')) {
	define('_BALISES_BLOCS',
	'address|applet|article|aside|blockquote|button|center|d[ltd]|div|fieldset|fig(ure|caption)|footer|form|h[1-6r]|hgroup|head|header|iframe|li|map|marquee|nav|noscript|object|ol|pre|section|t(able|[rdh]|body|foot|extarea)|ul|script|style'
	);
}

/**
 * Callback de detection des liens qui contiennent des blocks :
 * dans ce cas il faut traiter le <a> comme un quasi block et fermer/ouvrir les <p> autour du <a>
 *
 * @param string $t
 * @return string
 */
function detecter_liens_blocs(&$t) {

	// si une balise bloc est dans le liens, on y a aussi ajoute un <p>, il suffit donc de detecter ce dernier
	if (strpos($t[2], "<p>") !== false) {
		return "<STOP P>" . $t[1] . "<p>" . $t[2] . "</p>" . $t[3] . "\n<p>";
	}

	return $t[0];
}

/**
 * Callback fermer-para-mano
 *
 * On refait le preg, à la main
 *
 * @param string $t
 * @return string
 */
function fermer_para_mano(&$t) {
	# match: ",<p (.*)<(/?)(stop p|address|applet|article|aside|blockquote|button|center|d[ltd]|div|fieldset|fig(ure|caption)|footer|form|h[1-6r]|hgroup|head|header|iframe|li|map|marquee|nav|noscript|object|ol|pre|section|t(able|[rdh]|body|foot|extarea)|ul|script|style)\b,UimsS"
	# replace: "\n<p "+trim($1)+"</p>\n<$2$3"

	foreach (array('<p ' => "</p>\n", '<li' => "<br-li/>") as $cut => $close) {
		if (strpos($t, $cut) !== false) {
			foreach (explode($cut, $t) as $c => $p) {
				if ($c == 0) {
					$t = $p;
				} else {
					$pi = strtolower($p);
					if (preg_match(
						",</?(?:stop p|" . _BALISES_BLOCS . ")\b,S",
						$pi, $r)) {
						$pos = strpos($pi, $r[0]);
						$t .= $cut . str_replace("\n", _AUTOBR . "\n",
								($close ? rtrim(substr($p, 0, $pos)) : substr($p, 0, $pos))) . $close . substr($p, $pos);
					} else {
						$t .= $cut . $p;
					}
				}
			}
		}
	}

	if (strpos($t, "<br-li/>") !== false) {
		$t = str_replace("<br-li/></li>", "</li>", $t); // pour respecter les non-retour lignes avant </li>
		$t = str_replace("<br-li/><ul>", "<ul>", $t); // pour respecter les non-retour lignes avant <ul>
		$t = str_replace("<br-li/>", "\n", $t);
	}
	if (_AUTOBR) {
		$t = str_replace(_AUTOBR . "\n" . "<br", "\n<br", $t); #manque /i
		$reg = ',(<(p|br|li)\b[^>]*>\s*)' . preg_quote(_AUTOBR . "\n", ',') . ",iS";
		$t = preg_replace($reg, '\1' . "\n", $t);
	}

	return $t;
}
