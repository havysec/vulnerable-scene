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

if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}

function action_importer_bookmarks_opml_dist($fichier_ok, $id_parent, $importer_statut_publie, $importer_tags) {
	$nb = 0;
	if (autoriser('importer', '_sites')) {
		$out = bookmarks_opml_parse($fichier_ok['contenu']);
		$nb = bookmarks_opml_insert($out, $id_parent, $importer_statut_publie, $importer_tags);
	}

	return $nb;
}


// http://www.stargeek.com/php_scripts.php?script=20&cat=blog
function bookmarks_opml_parse(&$contenu) {
	global $blogs, $folder, $inOpmlfolder, $inOpmlItem;

	$inOpmlfolder = $inOpmlItem = false;

	$xp = xml_parser_create();

	xml_set_element_handler($xp, 'opml_startElement', 'opml_endElement');

	xml_parse($xp, $contenu, true);
	xml_parser_free($xp);

	return $blogs;
}

function opml_startElement($xp, $element, $attr) {
	global $blogs, $folder, $inOpmlfolder, $inOpmlItem;
	if (strcasecmp('outline', $element)) {
		return;
	}
	if (!array_key_exists('XMLURL', $attr) && (array_key_exists('TEXT', $attr) || array_key_exists('TITLE', $attr))) {
		//some opml use title instead of text to define a folder (ex: newzcrawler)
		$folder = $attr['TEXT'] ? $attr['TEXT'] : $attr['TITLE'];
		$inOpmlfolder = true;
		$inOpmlItem = false;
	} else {
		$inOpmlItem = true;
		if ($folder != '') {
			$blogs[$folder][] = $attr;
		} else {
			$blogs[] = $attr;
		}
	}
}

function opml_endElement($xp, $element) {
	global $blogs, $folder, $inOpmlfolder, $inOpmlItem;
	if (strcasecmp($element, "outline") === 0) {
		if (!$inOpmlItem && $inOpmlfolder) {
			// end of folder element!
			$inOpmlfolder = false;
		} else {
			// end of item element
			$inOpmlItem = false;
		}
	}

	return;
}

function bookmarks_opml_insert($tree, $id_parent, $importer_statut_publie, $importer_tags) {
	include_spip('action/editer_rubrique');
	include_spip('action/editer_site');

	$nb = 0;

	if (count($tree)) {
		foreach ($tree as $key => $item) {
			// cas d'un flux
			if (array_key_exists('XMLURL', $item)) {
				$statut = 'prop';
				if ($importer_statut_publie and autoriser('publierdans', 'rubrique', $id_parent)) {
					$statut = 'publie';
				}
				$now = time();
				if (!$id_syndic = sql_getfetsel('id_syndic', 'spip_syndic',
					'id_rubrique=' . intval($id_parent) . " AND url_site=" . sql_quote($item['HTMLURL']))
				) {
					$id_syndic = site_inserer($id_parent);
					$set = array(
						'url_site' => $item['HTMLURL'],
						'nom_site' => $item['TITLE'],
						'url_syndic' => $item['XMLURL'],
						'syndication' => 'oui',
						'resume' => 'non',
						'date' => date('Y-m-d H:i:s', $now),
						'statut' => $statut
					);
					site_modifier($id_syndic, $set);
					$nb++;
				} else {
					$nb++;
				}
			} else {
				// cas d'un dossier
				$titre = $key;
				$id_rubrique = sql_getfetsel('id_rubrique', 'spip_rubriques',
					'id_parent=' . intval($id_parent) . " AND titre=" . sql_quote($titre));
				if (!$id_rubrique and $id_rubrique = rubrique_inserer($id_parent)) {
					rubrique_modifier($id_rubrique, array('titre' => $titre));
				}
				if ($id_rubrique) {
					$nb += bookmarks_opml_insert($item, $id_rubrique, $importer_statut_publie, $importer_tags);
				}
			}
		}
	}

	return $nb;
}
