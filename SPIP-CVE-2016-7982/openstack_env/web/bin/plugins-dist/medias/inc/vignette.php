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
 * Gestion des vignettes de types de fichier
 *
 * @package SPIP\Medias\Vignette
 **/

if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}

/**
 * Vignette pour une extension de document
 *
 * Recherche les fichiers d'icones au format png pour l'extension demandée.
 * On cherche prive/vignettes/ext.png dans le path.
 *
 * @param string $ext
 *     Extension du fichier. Exemple : png
 * @param bool $size
 *     true pour retourner un tableau avec les tailles de la vignette
 *     false pour retourner uniquement le chemin du fichier
 * @param bool $loop
 *     Autoriser la fonction à s'appeler sur elle-même
 *     (paramètre interne).
 * @return array|bool|string
 *     False si l'image n'est pas trouvée
 *     Chaîne (chemin vers l'image) si on ne demande pas de taille
 *     Tableau (chemin, largeur, hauteur) si on demande avec la taille.
 */
function inc_vignette_dist($ext, $size = true, $loop = true) {

	if (!$ext) {
		$ext = 'txt';
	}

	// Chercher la vignette correspondant a ce type de document
	// dans les vignettes persos, ou dans les vignettes standard
	if (
		# installation dans un dossier /vignettes personnel, par exemple /squelettes/vignettes
	!$v = find_in_path("prive/vignettes/" . $ext . ".png")
	) {
		if ($loop) {
			$f = charger_fonction('vignette', 'inc');
			$v = $f('defaut', false, $loop = false);
		} else {
			$v = false;
		}
	} # pas trouve l'icone de base

	if (!$size) {
		return $v;
	}

	$largeur = $hauteur = 0;
	if ($v and $size = @getimagesize($v)) {
		$largeur = $size[0];
		$hauteur = $size[1];
	}

	return array($v, $largeur, $hauteur);
}
