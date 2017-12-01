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
 * Gestion de l'action ajouter_documents
 *
 * @package SPIP\Medias\Action
 **/

if (!defined("_ECRIRE_INC_VERSION")) {
	return;
}

include_spip('inc/getdocument');
include_spip('inc/documents');
include_spip('inc/choisir_mode_document'); // compat core
include_spip('inc/renseigner_document');

/**
 * Ajouter des documents
 *
 * @param int $id_document
 *   Document à remplacer, ou pour une vignette, l'id_document de maman
 *   0 ou 'new' pour une insertion
 * @param array $files
 *   Tableau de taleau de propriété pour chaque document à insérer
 * @param string $objet
 *   Objet auquel associer le document
 * @param int $id_objet
 *   id_objet
 * @param string $mode
 *   Mode par défaut si pas precisé pour le document
 * @return array
 *   Liste des id_documents inserés
 */
function action_ajouter_documents_dist($id_document, $files, $objet, $id_objet, $mode) {
	$ajouter_un_document = charger_fonction('ajouter_un_document', 'action');
	$ajoutes = array();

	// on ne peut mettre qu'un seul document a la place d'un autre ou en vignette d'un autre
	if (intval($id_document)) {
		$ajoutes[] = $ajouter_un_document($id_document, reset($files), $objet, $id_objet, $mode);
	} else {
		foreach ($files as $file) {
			$ajoutes[] = $ajouter_un_document('new', $file, $objet, $id_objet, $mode);
		}
	}

	return $ajoutes;
}

/**
 * Ajouter un document (au format $_FILES)
 *
 * @param int $id_document
 *   Document à remplacer, ou pour une vignette, l'id_document de maman
 *   0 ou 'new' pour une insertion
 * @param array $file
 *   Propriétes au format $_FILE étendu :
 *
 *   - string tmp_name : source sur le serveur
 *   - string name : nom du fichier envoye
 *   - bool titrer : donner ou non un titre a partir du nom du fichier
 *   - bool distant : pour utiliser une source distante sur internet
 *   - string mode : vignette|image|documents|choix
 * @param string $objet
 *   Objet auquel associer le document
 * @param int $id_objet
 *   id_objet
 * @param string $mode
 *   Mode par défaut si pas precisé pour le document
 * @return array|bool|int|mixed|string|unknown
 *
 *   - int : l'id_document ajouté (opération réussie)
 *   - string : une erreur s'est produit, la chaine est le message d'erreur
 *
 */
function action_ajouter_un_document_dist($id_document, $file, $objet, $id_objet, $mode) {

	$source = $file['tmp_name'];
	$nom_envoye = $file['name'];

	// passer en minuscules le nom du fichier, pour eviter les collisions
	// si le file system fait la difference entre les deux il ne detectera
	// pas que Toto.pdf et toto.pdf
	// et on aura une collision en cas de changement de file system
	$file['name'] = strtolower(translitteration($file['name']));

	// Pouvoir definir dans mes_options.php que l'on veut titrer tous les documents par d?faut
	if (!defined('_TITRER_DOCUMENTS')) {
		define('_TITRER_DOCUMENTS', false);
	}

	$titrer = isset($file['titrer']) ? $file['titrer'] : _TITRER_DOCUMENTS;
	$mode = ((isset($file['mode']) and $file['mode']) ? $file['mode'] : $mode);

	include_spip('inc/modifier');
	if (isset($file['distant']) and $file['distant'] and !in_array($mode, array('choix', 'auto', 'image', 'document'))) {
		spip_log("document distant $source accepte sans verification, mode=$mode","medias"._LOG_INFO_IMPORTANTE);
		include_spip('inc/distant');
		$file['tmp_name'] = _DIR_RACINE . copie_locale($source);
		$source = $file['tmp_name'];
		unset($file['distant']);
	}

	// Documents distants : pas trop de verifications bloquantes, mais un test
	// via une requete HEAD pour savoir si la ressource existe (non 404), si le
	// content-type est connu, et si possible recuperer la taille, voire plus.
	if (isset($file['distant']) and $file['distant']) {
		if (!tester_url_absolue($source)){
			return _T('medias:erreur_chemin_distant', array('nom' => $source));
		}
		include_spip('inc/distant');
		if (is_array($a = renseigner_source_distante($source))) {

			$champs = $a;
			# NB: dans les bonnes conditions (fichier autorise et pas trop gros)
			# $a['fichier'] est une copie locale du fichier

			$infos = renseigner_taille_dimension_image($champs['fichier'], $champs['extension'], true);
			// on ignore erreur eventuelle sur $infos car on est distant, ca ne marche pas forcement
			if (is_array($infos)) {
				$champs = array_merge($champs, $infos);
			}

			unset($champs['type_image']);
		} // on ne doit plus arriver ici, car l'url distante a ete verifiee a la saisie !
		else {
			spip_log("Echec du lien vers le document $source, abandon");

			return $a; // message d'erreur
		}
	} else { // pas distant

		$champs = array(
			'distant' => 'non'
		);

		$type_image = ''; // au pire
		$champs['titre'] = '';
		if ($titrer) {
			$titre = substr($nom_envoye, 0, strrpos($nom_envoye, ".")); // Enlever l'extension du nom du fichier
			$titre = preg_replace(',[[:punct:][:space:]]+,u', ' ', $titre);
			$champs['titre'] = preg_replace(',\.([^.]+)$,', '', $titre);
		}

		if (!is_array($fichier = fixer_fichier_upload($file, $mode))) {
			return is_string($fichier) ? $fichier : _T("medias:erreur_upload_type_interdit", array('nom' => $file['name']));
		}

		$champs['inclus'] = $fichier['inclus'];
		$champs['extension'] = $fichier['extension'];
		$champs['fichier'] = $fichier['fichier'];

		/**
		 * Récupère les informations du fichier
		 * -* largeur
		 * -* hauteur
		 * -* type_image
		 * -* taille
		 * -* ses metadonnées si une fonction de metadatas/ est présente
		 */
		$infos = renseigner_taille_dimension_image($champs['fichier'], $champs['extension']);
		if (is_string($infos)) {
			return $infos;
		} // c'est un message d'erreur !

		$champs = array_merge($champs, $infos);

		// Si mode == 'choix', fixer le mode image/document
		if (in_array($mode, array('choix', 'auto'))) {
			$choisir_mode_document = charger_fonction('choisir_mode_document', 'inc');
			$mode = $choisir_mode_document($champs, $champs['inclus'] == 'image', $objet);
		}
		$champs['mode'] = $mode;

		if (($test = verifier_taille_document_acceptable($champs)) !== true) {
			spip_unlink($champs['fichier']);

			return $test; // erreur sur les dimensions du fichier
		}

		unset($champs['type_image']);
		unset($champs['inclus']);
		$champs['fichier'] = set_spip_doc($champs['fichier']);
	}

	// si le media est pas renseigne, le faire, en fonction de l'extension
	if (!isset($champs['media'])) {
		$champs['media'] = sql_getfetsel('media_defaut', 'spip_types_documents',
			'extension=' . sql_quote($champs['extension']));
	}

	// lier le parent si necessaire
	if ($id_objet = intval($id_objet) and $objet) {
		$champs['parents'][] = "$objet|$id_objet";
	}

	// "mettre a jour un document" si on lui
	// passe un id_document
	if ($id_document = intval($id_document)) {
		unset($champs['titre']); // garder le titre d'origine
		unset($champs['date']); // garder la date d'origine
		unset($champs['descriptif']); // garder la desc d'origine
		// unset($a['distant']); # on peut remplacer un doc statique par un doc distant
		// unset($a['mode']); # on peut remplacer une image par un document ?
	}

	include_spip('action/editer_document');
	// Installer le document dans la base
	if (!$id_document) {
		if ($id_document = document_inserer()) {
			spip_log("ajout du document " . $file['tmp_name'] . " " . $file['name'] . "  (M '$mode' T '$objet' L '$id_objet' D '$id_document')",
				'medias');
		} else {
			spip_log("Echec insert_document() du document " . $file['tmp_name'] . " " . $file['name'] . "  (M '$mode' T '$objet' L '$id_objet' D '$id_document')",
				'medias' . _LOG_ERREUR);
		}
	}
	if (!$id_document) {
		return _T('medias:erreur_insertion_document_base', array('fichier' => "<em>" . $file['name'] . "</em>"));
	}

	document_modifier($id_document, $champs);

	// permettre aux plugins de faire des modifs a l'ajout initial
	// ex EXIF qui tourne les images si necessaire
	// Ce plugin ferait quand même mieux de se placer dans metadata/jpg.php
	pipeline('post_edition',
		array(
			'args' => array(
				'table' => 'spip_documents', // compatibilite
				'table_objet' => 'documents',
				'spip_table_objet' => 'spip_documents',
				'type' => 'document',
				'id_objet' => $id_document,
				'champs' => array_keys($champs),
				'serveur' => '', // serveur par defaut, on ne sait pas faire mieux pour le moment
				'action' => 'ajouter_document',
				'operation' => 'ajouter_document', // compat <= v2.0
			),
			'data' => $champs
		)
	);

	return $id_document;
}


/**
 * Corrige l'extension du fichier dans quelques cas particuliers
 *
 * @note
 *     Une extension 'pdf ' passe dans la requête de contrôle
 *     mysql> SELECT * FROM spip_types_documents WHERE extension="pdf ";
 *
 * @todo
 *     À passer dans base/typedoc
 *
 * @param string $ext
 * @return string
 */
function corriger_extension($ext) {
	$ext = preg_replace(',[^a-z0-9],i', '', $ext);
	switch ($ext) {
		case 'htm':
			$ext = 'html';
			break;
		case 'jpeg':
			$ext = 'jpg';
			break;
		case 'tiff':
			$ext = 'tif';
			break;
		case 'aif':
			$ext = 'aiff';
			break;
		case 'mpeg':
			$ext = 'mpg';
			break;
	}

	return $ext;
}

/**
 * Vérifie la possibilité d'uploader une extension
 *
 * Vérifie aussi si l'extension est autorisée pour le mode demandé
 * si on connait le mode à ce moment là
 *
 * @param string $source
 *     Nom du fichier
 * @param string $mode
 *     Mode d'inclusion du fichier, si connu
 * @return array|bool|string
 *
 *     - array : extension acceptée (tableau descriptif).
 *       Avec un index 'autozip' si il faut zipper
 *     - false ou message d'erreur si l'extension est refusée
 */
function verifier_upload_autorise($source, $mode = '') {
	$infos = array('fichier' => $source);
	$res = false;
	if (preg_match(",\.([a-z0-9]+)(\?.*)?$,i", $source, $match)
		and $ext = $match[1]
	) {

		$ext = corriger_extension(strtolower($ext));
		if ($res = sql_fetsel("extension,inclus,media_defaut as media", "spip_types_documents",
			"extension=" . sql_quote($ext) . " AND upload='oui'")
		) {
			$infos = array_merge($infos, $res);
		}
	}
	if (!$res) {
		if ($res = sql_fetsel("extension,inclus,media_defaut as media", "spip_types_documents",
			"extension='zip' AND upload='oui'")
		) {
			$infos = array_merge($infos, $res);
			$res['autozip'] = true;
		}
	}
	if ($mode and $res) {
		// verifier en fonction du mode si une fonction est proposee
		if ($verifier_document_mode = charger_fonction("verifier_document_mode_" . $mode, "inc", true)) {
			$check = $verifier_document_mode($infos); // true ou message d'erreur sous forme de chaine
			if ($check !== true) {
				$res = $check;
			}
		}
	}

	if (!$res or is_string($res)) {
		spip_log("Upload $source interdit ($res)", _LOG_INFO_IMPORTANTE);
	}

	return $res;
}


/**
 * Tester le type de document
 *
 * - le document existe et n'est pas de taille 0 ?
 * - interdit a l'upload ?
 * - quelle extension dans spip_types_documents ?
 * - est-ce "inclus" comme une image ?
 *
 * Le zipper si necessaire
 *
 * @param array $file
 *     Au format $_FILES
 * @param string $mode
 *     Mode d'inclusion du fichier, si connu
 * @return array
 */
function fixer_fichier_upload($file, $mode = '') {
	/**
	 * On vérifie que le fichier existe et qu'il contient quelque chose
	 */
	if (is_array($row = verifier_upload_autorise($file['name'], $mode))) {
		if (!isset($row['autozip'])) {
			$row['fichier'] = copier_document($row['extension'], $file['name'], $file['tmp_name']);
			/**
			 * On vérifie que le fichier a une taille
			 * si non, on le supprime et on affiche une erreur
			 */
			if ($row['fichier'] && (!$taille = @intval(filesize(get_spip_doc($row['fichier']))))) {
				spip_log("Echec copie du fichier " . $file['tmp_name'] . " (taille de fichier indéfinie)");
				spip_unlink(get_spip_doc($row['fichier']));

				return _T('medias:erreur_copie_fichier', array('nom' => $file['tmp_name']));
			} else {
				return $row;
			}
		}
		// creer un zip comme demande
		// pour encapsuler un fichier dont l'extension n'est pas supportee
		else {

			unset($row['autozip']);

			$ext = 'zip';
			if (!$tmp_dir = tempnam(_DIR_TMP, 'tmp_upload')) {
				return false;
			}

			spip_unlink($tmp_dir);
			@mkdir($tmp_dir);

			include_spip('inc/charsets');
			$tmp = $tmp_dir . '/' . translitteration($file['name']);

			$file['name'] .= '.' . $ext; # conserver l'extension dans le nom de fichier, par exemple toto.js => toto.js.zip

			// deplacer le fichier tmp_name dans le dossier tmp
			deplacer_fichier_upload($file['tmp_name'], $tmp, true);

			include_spip('inc/pclzip');
			$source = _DIR_TMP . basename($tmp_dir) . '.' . $ext;
			$archive = new PclZip($source);

			$v_list = $archive->create($tmp,
				PCLZIP_OPT_REMOVE_PATH, $tmp_dir,
				PCLZIP_OPT_ADD_PATH, '');

			effacer_repertoire_temporaire($tmp_dir);
			if (!$v_list) {
				spip_log("Echec creation du zip ");

				return false;
			}

			$row['fichier'] = copier_document($row['extension'], $file['name'], $source);
			spip_unlink($source);
			/**
			 * On vérifie que le fichier a une taille
			 * si non, on le supprime et on affiche une erreur
			 */
			if ($row['fichier'] && (!$taille = @intval(filesize(get_spip_doc($row['fichier']))))) {
				spip_log("Echec copie du fichier " . $file['tmp_name'] . " (taille de fichier indéfinie)");
				spip_unlink(get_spip_doc($row['fichier']));

				return _T('medias:erreur_copie_fichier', array('nom' => $file['tmp_name']));
			} else {
				return $row;
			}
		}
	} else {
		return $row;
	} // retourner le message d'erreur
}

/**
 * Verifier si le fichier respecte les contraintes de tailles
 *
 * @param  array $infos
 * @return bool|mixed|string
 */
function verifier_taille_document_acceptable(&$infos) {

	// si ce n'est pas une image
	if (!$infos['type_image']) {
		if (defined('_DOC_MAX_SIZE') and _DOC_MAX_SIZE > 0 and $infos['taille'] > _DOC_MAX_SIZE * 1024) {
			return _T('medias:info_doc_max_poids',
				array(
					'maxi' => taille_en_octets(_DOC_MAX_SIZE * 1024),
					'actuel' => taille_en_octets($infos['taille'])
				)
			);
		}
	} // si c'est une image
	else {

		if ((defined('_IMG_MAX_WIDTH') and _IMG_MAX_WIDTH and $infos['largeur'] > _IMG_MAX_WIDTH)
			or (defined('_IMG_MAX_HEIGHT') and _IMG_MAX_HEIGHT and $infos['hauteur'] > _IMG_MAX_HEIGHT)
		) {
			$max_width = (defined('_IMG_MAX_WIDTH') and _IMG_MAX_WIDTH) ? _IMG_MAX_WIDTH : '*';
			$max_height = (defined('_IMG_MAX_HEIGHT') and _IMG_MAX_HEIGHT) ? _IMG_MAX_HEIGHT : '*';

			// pas la peine d'embeter le redacteur avec ca si on a active le calcul des miniatures
			// on met directement a la taille maxi a la volee
			if (isset($GLOBALS['meta']['creer_preview']) and $GLOBALS['meta']['creer_preview'] == 'oui') {
				include_spip('inc/filtres');
				$img = filtrer('image_reduire', $infos['fichier'], $max_width, $max_height);
				$img = extraire_attribut($img, 'src');
				$img = supprimer_timestamp($img);
				if (@file_exists($img) and $img !== $infos['fichier']) {
					spip_unlink($infos['fichier']);
					@rename($img, $infos['fichier']);
					$size = @getimagesize($infos['fichier']);
					$infos['largeur'] = $size[0];
					$infos['hauteur'] = $size[1];
					$infos['taille'] = @filesize($infos['fichier']);
				}
			}

			if ((defined('_IMG_MAX_WIDTH') and _IMG_MAX_WIDTH and $infos['largeur'] > _IMG_MAX_WIDTH)
				or (defined('_IMG_MAX_HEIGHT') and _IMG_MAX_HEIGHT and $infos['hauteur'] > _IMG_MAX_HEIGHT)
			) {

				return _T('medias:info_image_max_taille',
					array(
						'maxi' =>
							_T('info_largeur_vignette',
								array(
									'largeur_vignette' => $max_width,
									'hauteur_vignette' => $max_height
								)),
						'actuel' =>
							_T('info_largeur_vignette',
								array(
									'largeur_vignette' => $infos['largeur'],
									'hauteur_vignette' => $infos['hauteur']
								))
					));
			}
		}

		if (defined('_IMG_MAX_SIZE') and _IMG_MAX_SIZE > 0 and $infos['taille'] > _IMG_MAX_SIZE * 1024) {
			return _T('medias:info_image_max_poids',
				array(
					'maxi' => taille_en_octets(_IMG_MAX_SIZE * 1024),
					'actuel' => taille_en_octets($infos['taille']
					)
				)
			);
		}

	}

	// verifier en fonction du mode si une fonction est proposee
	if ($verifier_document_mode = charger_fonction("verifier_document_mode_" . $infos['mode'], "inc", true)) {
		return $verifier_document_mode($infos);
	}

	return true;
}
