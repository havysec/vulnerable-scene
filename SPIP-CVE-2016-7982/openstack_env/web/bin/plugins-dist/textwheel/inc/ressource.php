<?php

/*
 * transforme un raccourci de ressource en un lien minimaliste
 * 
 *
 */

define('_EXTRAIRE_RESSOURCES', ',' . '<"?(https?://|[^\s][\w -]+\.[\w -]+)[^<]*>' . ',UimsS');


/* pipeline pour typo */
function tw_post_typo($t) {
	if (strpos($t, '<') !== false) {
		$t = preg_replace_callback(_EXTRAIRE_RESSOURCES, 'tw_traiter_ressources', $t);
	}

	return $t;
}

/* pipeline pour propre */
function tw_pre_liens($t) {
	if (strpos($t, '<') !== false) {
		$t = preg_replace_callback(_EXTRAIRE_RESSOURCES, 'tw_traiter_ressources', $t);

		// echapper les autoliens eventuellement inseres (en une seule fois)
		if (strpos($t, "<html>") !== false) {
			$t = echappe_html($t);
		}
	}

	return $t;
}

function tw_traiter_ressources($r) {
	$html = null;

	include_spip('inc/lien');
	$url = explode(' ', trim($r[0], '<>'));
	$url = $url[0];
	# <http://url/absolue>
	if (preg_match(',^https?://,i', $url)) {
		$html = PtoBR(propre("<span class='ressource spip_out'>&lt;[->" . $url . "]&gt;</span>"));
	} # <url/relative>
	else {
		if (false !== strpos($url, '/')) {
			$html = PtoBR(propre("<span class='ressource spip_in'>&lt;[->" . $url . "]&gt;</span>"));
		} # <fichier.rtf>
		else {
			preg_match(',\.([^.]+)$,', $url, $regs);
			if (file_exists($f = _DIR_IMG . $regs[1] . '/' . $url)) {
				$html = PtoBR(propre("<span class='ressource spip_in'>&lt;[" . $url . "->" . $f . "]&gt;</span>"));
			} else {
				$html = PtoBR(propre("<span class='ressource'>&lt;" . $url . "&gt;</span>"));
			}
		}
	}

	return '<html>' . $html . '</html>';
}
