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
 * Déclarations de pipelines
 *
 * @package SPIP\SquelettesParRubrique\Pipelines
 **/
if (!defined("_ECRIRE_INC_VERSION")) {
	return;
}

if (!isset($GLOBALS['spip_pipeline']['styliser'])) {
	$GLOBALS['spip_pipeline']['styliser'] = '';
}

// Ajoute à la fin du pipeline styliser la recherche de squelettes par rubriques et par langue
$GLOBALS['spip_pipeline']['styliser'] .= '||squelettes_par_rubrique_styliser_par_rubrique|squelettes_par_rubrique_styliser_par_langue';

/**
 * Cherche un squelette par rubrique squelette-XX.html ou squelette=XX.html
 *
 * Options de recherche de squelette par le styliseur, appelé par le pipeline 'styliser'
 *
 * @pipeline styliser
 *
 * @param array $flux Données du pipeline
 * @return array       Données du pipeline
 */
function squelettes_par_rubrique_styliser_par_rubrique($flux) {

	// uniquement si un squelette a ete trouve
	if ($squelette = $flux['data']) {
		$ext = $flux['args']['ext'];

		// On selectionne, dans l'ordre :
		// fond=10
		if ($id_rubrique = $flux['args']['id_rubrique']) {
			$f = "$squelette=$id_rubrique";
			if (@file_exists("$f.$ext")) {
				$squelette = $f;
			} else {
				$maxiter = 10000; // on ne remonte pas au dela en profondeur
				// fond-10 fond-<rubriques parentes>
				do {
					$f = "$squelette-$id_rubrique";
					if (@file_exists("$f.$ext")) {
						$squelette = $f;
						break;
					}
				} while (
					$maxiter--
					and $id_rubrique = quete_parent($id_rubrique)
					// se proteger des references circulaires
					and $id_rubrique != $flux['args']['id_rubrique']
				);
			}
			// sauver le squelette
			$flux['data'] = $squelette;
		}
	}

	return $flux;
}


/**
 * Cherche l'existence un squelette par langue squelette.en.html
 *
 * Options de recherche de squelette par le styliseur, appelé par le pipeline 'styliser'
 *
 * @pipeline styliser
 *
 * @param array $flux Données du pipeline
 * @return array       Données du pipeline
 */
function squelettes_par_rubrique_styliser_par_langue($flux) {

	// uniquement si un squelette a ete trouve
	if ($squelette = $flux['data']) {
		$ext = $flux['args']['ext'];

		// Affiner par lang
		if ($lang = $flux['args']['lang']) {
			$l = lang_select($lang);
			$f = "$squelette." . $GLOBALS['spip_lang'];
			if ($l) {
				lang_select();
			}
			if (@file_exists("$f.$ext")) {
				// sauver le squelette
				$flux['data'] = $f;
			}
		}
	}

	return $flux;
}
