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
 * Informations meta d'un SVG
 *
 * @package SPIP\Medias\Metadata
 **/

if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}
include_spip('inc/autoriser');

/**
 * Déterminer les dimensions d'un svg, et enlever ses scripts si nécessaire
 *
 * On utilise safehtml qui n'est pas apropriée pour ça en attendant mieux
 * cf http://www.slideshare.net/x00mario/the-image-that-called-me
 * http://heideri.ch/svgpurifier/SVGPurifier/index.php
 *
 * @param string $file
 * @return array Tableau (largeur, hauteur)
 */
function metadata_svg_dist($file) {
	$meta = array();

	$texte = spip_file_get_contents($file);

	// Securite si pas autorise : virer les scripts et les references externes
	// sauf si on est en mode javascript 'ok' (1), cf. inc_version
	if ($GLOBALS['filtrer_javascript'] < 1
		and !autoriser('televerser', 'script')
	) {
		include_spip('inc/texte');
		$new = trim(safehtml($texte));
		// petit bug safehtml
		if (substr($new, 0, 2) == ']>') {
			$new = ltrim(substr($new, 2));
		}
		if ($new != $texte) {
			ecrire_fichier($file, $texte = $new);
		}
	}

	$width = $height = 150;
	if (preg_match(',<svg[^>]+>,', $texte, $s)) {
		$s = $s[0];
		if (preg_match(',\WviewBox\s*=\s*.\s*(\d+)\s+(\d+)\s+(\d+)\s+(\d+),i', $s, $r)) {
			$width = $r[3];
			$height = $r[4];
		} else {
			// si la taille est en centimetre, estimer le pixel a 1/64 de cm
			if (preg_match(',\Wwidth\s*=\s*.(\d+)([^"\']*),i', $s, $r)) {
				if ($r[2] != '%') {
					$width = $r[1];
					if ($r[2] == 'cm') {
						$width <<= 6;
					}
				}
			}
			if (preg_match(',\Wheight\s*=\s*.(\d+)([^"\']*),i', $s, $r)) {
				if ($r[2] != '%') {
					$height = $r[1];
					if ($r[2] == 'cm') {
						$height <<= 6;
					}
				}
			}
		}
	}
	$meta['largeur'] = $width;
	$meta['hauteur'] = $height;

	return $meta;
}
