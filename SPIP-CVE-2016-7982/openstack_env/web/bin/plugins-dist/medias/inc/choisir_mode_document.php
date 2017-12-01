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
 * Gestion des modes de documents
 *
 * @package SPIP\Medias\Modes
 */
if (!defined("_ECRIRE_INC_VERSION")) {
	return;
}

/**
 * Choisir le mode du document : image/document
 *
 * @param array $infos
 *     Informations sur le document (en base + prises sur le fichier)
 * @param bool $type_inclus_image
 *     Type d'inclusion demandée : true si image
 * @param string $objet
 *     Objet sur lequel est placé le document
 * @return string
 *     Mode du document
 */
function inc_choisir_mode_document($infos, $type_inclus_image, $objet) {

	// si ce n'est pas une image, c'est forcement un document
	if (!$infos['type_image'] or !$type_inclus_image) {
		return 'document';
	}

	// si on a pas le droit d'ajouter de document a l'objet, c'est donc un mode image
	if ($objet and isset($GLOBALS['meta']["documents_$objet"]) and ($GLOBALS['meta']["documents_$objet"] == 'non')) {
		return 'image';
	}


	// _INTERFACE_DOCUMENTS
	// en fonction de la taille de l'image
	// par defaut l'affectation en fonction de la largeur de l'image
	// est desactivee car pas comprehensible par le novice
	// il suffit de faire dans mes_options
	// define('_LARGEUR_MODE_IMAGE', 450);
	// pour beneficier de cette detection auto
	@define('_LARGEUR_MODE_IMAGE', 0);

	if (!_LARGEUR_MODE_IMAGE) {
		return 'image';
	}

	if ($infos['largeur'] > 0
		and $infos['largeur'] < _LARGEUR_MODE_IMAGE
	) {
		return 'image';
	} else {
		return 'document';
	}
}
