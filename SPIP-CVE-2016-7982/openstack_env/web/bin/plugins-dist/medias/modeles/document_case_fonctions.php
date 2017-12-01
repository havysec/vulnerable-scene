<?php
/**
 * Déclaration de fonctions utiles à ce squelette
 *
 * @copyright (c) 2009-2016 cedric
 * @license Distribue sous licence GPL
 *
 * @package SPIP\Medias\Fonctions
 */

if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}

define('_BOUTON_MODE_IMAGE', true);

include_spip('inc/documents'); // pour la fonction affiche_raccourci_doc
function medias_raccourcis_doc(
	$id_document,
	$titre,
	$descriptif,
	$inclus,
	$largeur,
	$hauteur,
	$mode,
	$vu,
	$media = null
) {
	$raccourci = '';
	$doc = 'doc';

	if ($mode == 'image' and (strlen($descriptif . $titre) == 0)) {
		$doc = 'img';
	}

	// Affichage du raccourci <doc...> correspondant
	$raccourci =
		affiche_raccourci_doc($doc, $id_document, 'left')
		. affiche_raccourci_doc($doc, $id_document, 'center')
		. affiche_raccourci_doc($doc, $id_document, 'right');
	if ($mode == 'document'
		and ($inclus == "embed" or $inclus == "image")
		and (($largeur > 0 and $hauteur > 0)
			or in_array($media, array('video', 'audio')))
	) {
		$raccourci =
			"<span>" . _T('medias:info_inclusion_vignette') . "</span>"
			. $raccourci
			. "<span>" . _T('medias:info_inclusion_directe') . "</span>"
			. affiche_raccourci_doc('emb', $id_document, 'left')
			. affiche_raccourci_doc('emb', $id_document, 'center')
			. affiche_raccourci_doc('emb', $id_document, 'right');
	}

	return "<div class='raccourcis'>" . $raccourci . "</div>";
}
