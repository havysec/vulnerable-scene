<?php
/**
 * GetID3
 * Gestion des métadonnées de fichiers sonores et vidéos directement dans SPIP
 *
 * Auteurs :
 * kent1 (http://www.kent1.info - kent1@arscenic.info), BoOz
 * 2008-2016 - Distribué sous licence GNU/GPL
 *
 * @package SPIP\GetID3\Metadatas
 */

if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}

/**
 * Fonction de récupération des métadonnées sur les fichiers vidéo
 * appelée à l'insertion en base dans le plugin medias (inc/renseigner_document)
 *
 * @param string $file
 *    Le chemin du fichier à analyser
 * @return array $metas
 *    Le tableau comprenant les différentes metas à mettre en base
 */
function metadata_video($file) {
	$meta = array();

	include_spip('lib/getid3/getid3');
	$getID3 = new getID3;
	$getID3->setOption(array('tempdir' => _DIR_TMP));

	// Scan file - should parse correctly if file is not corrupted
	$file_info = $getID3->analyze($file);

	/**
	 * Les pistes vidéos
	 */
	if (isset($file_info['video'])) {
		$id3['hasvideo'] = 'oui';
		if (isset($file_info['video']['resolution_x'])) {
			$meta['largeur'] = $file_info['video']['resolution_x'];
		}
		if (isset($file_info['video']['resolution_y'])) {
			$meta['hauteur'] = $file_info['video']['resolution_y'];
		}
		if (isset($file_info['video']['frame_rate'])) {
			$meta['framerate'] = $file_info['video']['frame_rate'];
		}
	}
	if (isset($file_info['playtime_seconds'])) {
		$meta['duree'] = round($file_info['playtime_seconds'], 0);
	}

	return $meta;
}
