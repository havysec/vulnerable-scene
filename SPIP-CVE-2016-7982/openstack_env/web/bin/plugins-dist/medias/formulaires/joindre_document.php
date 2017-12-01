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
 * Gestion du formulaire de téléversement de documents
 *
 * @package SPIP\Medias\Formulaires
 */
if (!defined("_ECRIRE_INC_VERSION")) {
	return;
}

/**
 * Déterminer le mode d'upload si la valeur au chargement du formulaire est "auto"
 *
 * @param string $mode
 *    Le mode passé au formulaire
 * @param int|string $id_document
 *    L'identifiant numérique du document à remplacer ou "new" par défaut
 * @param string $objet
 *    Le type d'objet sur lequel ajouter le document
 * @return string $mode
 *    Le mode définitif
 */
function joindre_determiner_mode($mode, $id_document, $objet) {
	if ($mode == 'auto') {
		if (intval($id_document)) {
			$mode = sql_getfetsel('mode', 'spip_documents', 'id_document=' . intval($id_document));
		}
		if (!in_array($mode, array('choix', 'document', 'image'))) {
			$mode = 'choix';
			if ($objet and !in_array(table_objet_sql($objet), explode(',', $GLOBALS['meta']["documents_objets"]))) {
				$mode = 'image';
			}
		}
	}

	return $mode;
}

/**
 * Chargement du formulaire
 *
 * @param int|string $id_document
 *    L'identidiant numérique du document s'il est à remplacer, sinon "new"
 * @param int $id_objet
 *    L'identifiant numérique de l'objet sur lequel on ajoute le document
 * @param string $objet
 *    Le type de l'objet sur lequel on ajoute le document
 * @param string $mode
 *    Le mode du document (auto,choix,document,image,vignette...), par défaut auto
 * @param string $galerie
 *    Passer optionnellement une galerie jointe au form, plus utilise nativement,
 *    on prefere la mise a jour apres upload par ajaxReload('documents')
 * @param bool|string $proposer_media
 *    Doit on afficher la médiathèque ?  par défaut oui
 *    Valeurs possibles si string : false,'non','no'.
 * @param bool|string $proposer_ftp
 *    Doit on afficher le ftp ? par défaut oui
 *    Valeurs possibles si string : false,'non','no'.
 * @return array $valeurs
 *    Les valeurs chargées dans le formulaire
 */
function formulaires_joindre_document_charger_dist(
	$id_document = 'new',
	$id_objet = 0,
	$objet = '',
	$mode = 'auto',
	$galerie = false,
	$proposer_media = true,
	$proposer_ftp = true
) {
	$valeurs = array();
	$mode = joindre_determiner_mode($mode, $id_document, $objet);

	$valeurs['id'] = $id_document;
	$valeurs['_mode'] = $mode;

	$valeurs['url'] = 'http://';
	$valeurs['fichier_upload'] = $valeurs['_options_upload_ftp'] = $valeurs['_dir_upload_ftp'] = '';
	$valeurs['joindre_upload'] = $valeurs['joindre_distant'] = $valeurs['joindre_ftp'] = $valeurs['joindre_mediatheque'] = '';

	$valeurs['editable'] = ' ';
	if (intval($id_document)) {
		$valeurs['editable'] = autoriser('modifier', 'document', $id_document) ? ' ' : '';
	}

	$valeurs['proposer_media'] = is_string($proposer_media) ? (preg_match('/^(false|non|no)$/i',
		$proposer_media) ? false : true) : $proposer_media;
	$valeurs['proposer_ftp'] = is_string($proposer_ftp) ? (preg_match('/^(false|non|no)$/i',
		$proposer_ftp) ? false : true) : $proposer_ftp;

	# regarder si un choix d'upload FTP est vraiment possible
	if (
		$valeurs['proposer_ftp']
		and test_espace_prive() # ??
		and ($mode != 'image') and ($mode != 'vignette') # si c'est pour un document
		//AND !$vignette_de_doc		# pas pour une vignette (NB: la ligne precedente suffit, mais si on la supprime il faut conserver ce test-ci)
		and $GLOBALS['flag_upload']
	) {
		include_spip('inc/documents');
		if ($dir = determine_upload('documents')) {
			// quels sont les docs accessibles en ftp ?
			$valeurs['_options_upload_ftp'] = joindre_options_upload_ftp($dir, $mode);
			// s'il n'y en a pas, on affiche un message d'aide
			// en mode document, mais pas en mode image
			if ($valeurs['_options_upload_ftp'] or ($mode == 'document' or $mode == 'choix')) {
				$valeurs['_dir_upload_ftp'] = "<b>" . joli_repertoire($dir) . "</b>";
			}
		}
	}
	// On ne propose le FTP que si on a des choses a afficher
	$valeurs['proposer_ftp'] = ($valeurs['_options_upload_ftp'] or $valeurs['_dir_upload_ftp']);

	if ($galerie) {
		# passer optionnellement une galerie jointe au form
		# plus utilise nativement, on prefere la mise a jour
		# apres upload par ajaxReload('documents')
		$valeurs['_galerie'] = $galerie;
	}
	if ($objet and $id_objet) {
		$valeurs['id_objet'] = $id_objet;
		$valeurs['objet'] = $objet;
		$valeurs['refdoc_joindre'] = '';
		if ($valeurs['editable']) {
			include_spip('inc/autoriser');
			$valeurs['editable'] = autoriser('joindredocument', $objet, $id_objet) ? ' ' : '';
		}
	}

	return $valeurs;
}

/**
 * Vérification du formulaire
 *
 * @param int|string $id_document
 *    L'identidiant numérique du document s'il est à remplacer, sinon "new"
 * @param int $id_objet
 *    L'identifiant numérique de l'objet sur lequel on ajoute le document
 * @param string $objet
 *    Le type de l'objet sur lequel on ajoute le document
 * @param string $mode
 *    Le mode du document (auto,choix,document,image,vignette...), par défaut auto
 * @param string $galerie
 *    Passer optionnellement une galerie jointe au form, plus utilise nativement,
 *    on prefere la mise a jour apres upload par ajaxReload('documents')
 * @param bool|string $proposer_media
 *    Doit on afficher la médiathèque ?  par défaut oui
 *    Valeurs possibles si string : false,'non','no'.
 * @param bool|string $proposer_ftp
 *    Doit on afficher le ftp ? par défaut oui
 *    Valeurs possibles si string : false,'non','no'.
 * @return array $erreurs
 *    Les erreurs éventuelles dans un tableau
 */
function formulaires_joindre_document_verifier_dist(
	$id_document = 'new',
	$id_objet = 0,
	$objet = '',
	$mode = 'auto',
	$galerie = false,
	$proposer_media = true,
	$proposer_ftp = true
) {
	include_spip('inc/joindre_document');

	$erreurs = array();
	// on joint un document deja dans le site
	if (_request('joindre_mediatheque')) {
		$refdoc_joindre = intval(preg_replace(',^(doc|document|img),', '', _request('refdoc_joindre')));
		if (!sql_getfetsel('id_document', 'spip_documents', 'id_document=' . intval($refdoc_joindre))) {
			$erreurs['message_erreur'] = _T('medias:erreur_aucun_document');
		}
	} // sinon c'est un upload
	else {
		$files = joindre_trouver_fichier_envoye();
		if (is_string($files)) {
			$erreurs['message_erreur'] = $files;
		} elseif (is_array($files)) {
			// erreur si on a pas trouve de fichier
			if (!count($files)) {
				$erreurs['message_erreur'] = _T('medias:erreur_aucun_fichier');
			} else {
				// regarder si on a eu une erreur sur l'upload d'un fichier
				foreach ($files as $file) {
					if (isset($file['error'])
						and $test = joindre_upload_error($file['error'])
					) {
						if (is_string($test)) {
							$erreurs['message_erreur'] = $test;
						} else {
							$erreurs['message_erreur'] = _T('medias:erreur_aucun_fichier');
						}
					}
				}

				// si ce n'est pas deja un post de zip confirme
				// regarder si il faut lister le contenu du zip et le presenter
				if (!count($erreurs)
					and !_request('joindre_zip')
					and $contenu_zip = joindre_verifier_zip($files)
				) {
					list($fichiers, $erreurs, $tmp_zip) = $contenu_zip;
					if ($fichiers) {
						$erreurs['message_erreur'] = '';
						$erreurs['lister_contenu_archive'] = recuperer_fond("formulaires/inc-lister_archive_jointe",
							array('chemin_zip' => $tmp_zip, 'liste_fichiers_zip' => $fichiers, 'erreurs_fichier_zip' => $erreurs));
					} else {
						$erreurs['message_erreur'] = _T('medias:erreur_aucun_fichier');
					}
				}
			}
		}

		if (count($erreurs) and defined('_tmp_dir')) {
			effacer_repertoire_temporaire(_tmp_dir);
		}
	}

	return $erreurs;
}

/**
 * Traitement du formulaire
 *
 * @param int|string $id_document
 *    L'identidiant numérique du document s'il est à remplacer, sinon "new"
 * @param int $id_objet
 *    L'identifiant numérique de l'objet sur lequel on ajoute le document
 * @param string $objet
 *    Le type de l'objet sur lequel on ajoute le document
 * @param string $mode
 *    Le mode du document (auto,choix,document,image,vignette...), par défaut auto
 * @param string $galerie
 *    Passer optionnellement une galerie jointe au form, plus utilise nativement,
 *    on prefere la mise a jour apres upload par ajaxReload('documents')
 * @param bool|string $proposer_media
 *    Doit on afficher la médiathèque ?  par défaut oui
 *    Valeurs possibles si string : false,'non','no'.
 * @param bool|string $proposer_ftp
 *    Doit on afficher le ftp ? par défaut oui
 *    Valeurs possibles si string : false,'non','no'.
 * @return array $res
 *    Le tableau renvoyé par les CVT avec le message et editable
 */
function formulaires_joindre_document_traiter_dist(
	$id_document = 'new',
	$id_objet = 0,
	$objet = '',
	$mode = 'auto',
	$galerie = false,
	$proposer_media = true,
	$proposer_ftp = true
) {
	$res = array('editable' => true);
	$ancre = '';
	// on joint un document deja dans le site
	if (_request('joindre_mediatheque')) {
		$refdoc_joindre = _request('refdoc_joindre');
		$refdoc_joindre = strtr($refdoc_joindre, ";,", "  ");
		$refdoc_joindre = preg_replace(',\b(doc|document|img),', '', $refdoc_joindre);
		// expliciter les intervales xxx-yyy
		while (preg_match(",\b(\d+)-(\d+)\b,", $refdoc_joindre, $m)) {
			$refdoc_joindre = str_replace($m[0], implode(" ", range($m[1], $m[2])), $refdoc_joindre);
		}
		$refdoc_joindre = explode(" ", $refdoc_joindre);
		include_spip('action/editer_document');
		foreach ($refdoc_joindre as $j) {
			if ($j = intval(preg_replace(',^(doc|document|img),', '', $j))) {
				// lier le parent en plus
				$champs = array('ajout_parents' => array("$objet|$id_objet"));
				document_modifier($j, $champs);
				if (!$ancre) {
					$ancre = $j;
				}
				$sel[] = $j;
				$res['message_ok'] = _T('medias:document_attache_succes');
			}
		}
		if ($sel) {
			$res['message_ok'] = singulier_ou_pluriel(count($sel), 'medias:document_attache_succes',
				'medias:nb_documents_attache_succes');
		}
		set_request('refdoc_joindre', ''); // vider la saisie
	} // sinon c'est un upload
	else {
		$ajouter_documents = charger_fonction('ajouter_documents', 'action');

		$mode = joindre_determiner_mode($mode, $id_document, $objet);
		include_spip('inc/joindre_document');
		$files = joindre_trouver_fichier_envoye();

		$nouveaux_doc = $ajouter_documents($id_document, $files, $objet, $id_objet, $mode);

		if (defined('_tmp_zip')) {
			unlink(_tmp_zip);
		}
		if (defined('_tmp_dir')) {
			effacer_repertoire_temporaire(_tmp_dir);
		}

		// checker les erreurs eventuelles
		$messages_erreur = array();
		$nb_docs = 0;
		$sel = array();
		foreach ($nouveaux_doc as $doc) {
			if (!is_numeric($doc)) {
				$messages_erreur[] = $doc;
			} // cas qui devrait etre traite en amont
			elseif (!$doc) {
				$messages_erreur[] = _T('medias:erreur_insertion_document_base', array('fichier' => '<em>???</em>'));
			} else {
				if (!$ancre) {
					$ancre = $doc;
				}
				$sel[] = $doc;
			}
		}
		if (count($messages_erreur)) {
			$res['message_erreur'] = implode('<br />', $messages_erreur);
		}
		if ($sel) {
			$res['message_ok'] = singulier_ou_pluriel(count($sel), 'medias:document_installe_succes',
				'medias:nb_documents_installe_succes');
		}
		if ($ancre) {
			$res['redirect'] = "#doc$ancre";
		}
	}
	if (count($sel) or isset($res['message_ok'])) {
		$callback = "";
		if ($ancre) {
			$callback .= "jQuery('#doc$ancre a.editbox').eq(0).focus();";
		}
		if (count($sel)) {
			// passer les ids document selectionnes aux pipelines
			$res['ids'] = $sel;

			$sel = "#doc" . implode(",#doc", $sel);
			$callback .= "jQuery('$sel').animateAppend();";
		}
		$js = "if (window.jQuery) jQuery(function(){ajaxReload('documents',{callback:function(){ $callback }});});";
		$js = "<script type='text/javascript'>$js</script>";
		if (isset($res['message_erreur'])) {
			$res['message_erreur'] .= $js;
		} else {
			$res['message_ok'] .= $js;
		}
	}

	return $res;
}

/**
 * Retourner le contenu du select HTML d'utilisation de fichiers envoyes par le serveur
 *
 * @param string $dir
 *    Le répertoire de recherche des documents
 * @param string $mode
 *    Le mode d'ajout de document
 * @return string $texte
 *    Le contenu HTML du selecteur de documents
 */
function joindre_options_upload_ftp($dir, $mode = 'document') {
	$fichiers = preg_files($dir);
	$exts = $dirs = $texte_upload = array();

	// en mode "charger une image", ne proposer que les inclus
	$inclus = ($mode == 'image' or $mode == 'vignette')
		? " AND inclus='image'"
		: '';

	foreach ($fichiers as $f) {
		$f = preg_replace(",^$dir,", '', $f);
		if (preg_match(",\.([^.]+)$,", $f, $match)) {
			$ext = strtolower($match[1]);
			if (!isset($exts[$ext])) {
				include_spip('action/ajouter_documents');
				$ext = corriger_extension($ext);
				if (sql_fetsel('extension', 'spip_types_documents', $a = "extension='$ext'" . $inclus)) {
					$exts[$ext] = 'oui';
				} else {
					$exts[$ext] = 'non';
				}
			}

			$k = 2 * substr_count($f, '/');
			$n = strrpos($f, "/");
			if ($n === false) {
				$lefichier = $f;
			} else {
				$lefichier = substr($f, $n + 1, strlen($f));
				$ledossier = substr($f, 0, $n);
				if (!in_array($ledossier, $dirs)) {
					$texte_upload[] = "\n<option value=\"$ledossier\">"
						. str_repeat("&nbsp;", $k)
						. _T('medias:tout_dossier_upload', array('upload' => $ledossier))
						. "</option>";
					$dirs[] = $ledossier;
				}
			}

			if ($exts[$ext] == 'oui') {
				$texte_upload[] = "\n<option value=\"$f\">"
					. str_repeat("&nbsp;", $k + 2)
					. $lefichier
					. "</option>";
			}
		}
	}

	$texte = join('', $texte_upload);
	if (count($texte_upload) > 1) {
		$texte = "\n<option value=\"/\" style='font-weight: bold;'>"
			. _T('medias:info_installer_tous_documents')
			. "</option>" . $texte;
	}

	return $texte;
}


/**
 * Lister les fichiers contenus dans un zip
 *
 * @param array $files
 *    La liste des fichiers
 * @return string $res
 *    La liste HTML des fichiers <li>...</li>
 */
function joindre_liste_contenu_tailles_archive($files) {
	include_spip('inc/charsets'); # pour le nom de fichier

	$res = '';
	if (is_array($files)) {
		foreach ($files as $nom => $file) {
			$nom = translitteration($nom);
			$date = date_interface(date("Y-m-d H:i:s", $file['mtime']));

			$taille = taille_en_octets($file['size']);
			$res .= "<li title=\"" . attribut_html($title) . "\"><b>$nom</b> &ndash; $taille<br />&nbsp; $date</li>\n";
		}
	}

	return $res;
}

/**
 * Lister les erreurs dans une archive jointe
 * Utilisé formulaires/inc-lister_archive_jointe.html
 *
 * @param array $erreurs
 *    La liste des erreurs
 * @return string $res
 *    Le code HTML des erreurs
 */
function joindre_liste_erreurs_to_li($erreurs) {
	if (count($erreurs) == 1) {
		return "<p>" . reset($erreurs) . "</p>";
	}

	$res = implode("</li><li>", $erreurs);
	if (strlen($res)) {
		$res = "<li>$res</li></ul>";
	}
	if (count($erreurs) > 4) {
		$res = "<p style='cursor:pointer;' onclick='jQuery(this).siblings(\"ul\").toggle();return false;'>" . _T("medias:erreurs_voir",
				array('nb' => count($erreurs))) . "</p><ul class=\"spip none-js\">" . $res . "</ul>";
	} else {
		$res = "<ul class=\"spip\">$res</ul>";
	}

	return $res;
}
