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
 * Fonctions utiles pour les squelettes et déclarations de boucle
 * pour le compilateur
 *
 * @package SPIP\Medias\Fonctions
 **/

// sécurité
if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}

// nettoyer les zip abandonnes par l'utilisateur
if (isset($GLOBALS['visiteur_session']['zip_to_clean'])
	and test_espace_prive()
	and isset($_SERVER['REQUEST_METHOD'])
	and $_SERVER['REQUEST_METHOD'] !== 'POST'
) {
	$zip_to_clean = unserialize($GLOBALS['visiteur_session']['zip_to_clean']);
	if ($zip_to_clean) {
		foreach ($zip_to_clean as $zip) {
			if (@file_exists($zip)) {
				@unlink($zip);
			}
		}
	}
	session_set('zip_to_clean');
}

// capturer un formulaire POST plus grand que post_max_size
// on genere un minipres car on ne peut rien faire de mieux
if (isset($_SERVER['REQUEST_METHOD'])
	and $_SERVER['REQUEST_METHOD'] == 'POST'
	and empty($_POST)
	and strlen($_SERVER['CONTENT_TYPE']) > 0
	and strncmp($_SERVER['CONTENT_TYPE'], 'multipart/form-data', 19) == 0
	and $_SERVER['CONTENT_LENGTH'] > medias_inigetoctets('post_max_size')
) {

	include_spip('inc/minipres');
	echo minipres(_T('medias:upload_limit', array('max' => ini_get('post_max_size'))));
	exit;
}

/**
 * Retourne la taille en octet d'une valeur de configuration php
 *
 * @param string $var
 *     Clé de configuration ; valeur récupérée par `ini_get()`. Exemple `post_max_size`
 * @return int|string
 *     Taille en octet, sinon chaine vide.
 **/
function medias_inigetoctets($var) {
	$last = '';
	$val = trim(@ini_get($var));
	if (is_numeric($val)) {
		return $val;
	}
	// en octet si "32M"
	if ($val != '') {
		$last = strtolower($val[strlen($val) - 1]);
		$val = substr($val, 0, -1);
	}
	switch ($last) { // The 'G' modifier is available since PHP 5.1.0
		case 'g':
			$val *= 1024;
		case 'm':
			$val *= 1024;
		case 'k':
			$val *= 1024;
	}

	return $val;
}

/**
 * Afficher la puce de statut pour les documents
 *
 * @param int $id_document
 *     Identifiant du document
 * @param string $statut
 *     Statut du document
 * @return string
 *     Code HTML de l'image de puce
 */
function medias_puce_statut_document($id_document, $statut) {
	if ($statut == 'publie') {
		$puce = 'puce-verte.gif';
	} else {
		if ($statut == "prepa") {
			$puce = 'puce-blanche.gif';
		} else {
			if ($statut == "poubelle") {
				$puce = 'puce-poubelle.gif';
			} else {
				$puce = 'puce-blanche.gif';
			}
		}
	}

	return http_img_pack($puce, $statut, "class='puce'");
}


/**
 * Compile la boucle `DOCUMENTS` qui retourne une liste de documents multimédia
 *
 * `<BOUCLE(DOCUMENTS)>`
 *
 * @param string $id_boucle
 *     Identifiant de la boucle
 * @param array $boucles
 *     AST du squelette
 * @return string
 *     Code PHP compilé de la boucle
 **/
function boucle_DOCUMENTS($id_boucle, &$boucles) {
	$boucle = &$boucles[$id_boucle];
	$id_table = $boucle->id_table;

	// on ne veut pas des fichiers de taille nulle,
	// sauf s'ils sont distants (taille inconnue)
	array_unshift($boucle->where, array("'($id_table.taille > 0 OR $id_table.distant=\\'oui\\')'"));

	/**
	 * N'afficher que les modes de documents que l'on accepte
	 * Utiliser le "pipeline medias_documents_visibles" pour en ajouter
	 */
	if (!isset($boucle->modificateur['criteres']['mode'])
		and !isset($boucle->modificateur['tout'])
	) {
		$modes = pipeline('medias_documents_visibles', array('image', 'document'));
		$f = sql_serveur('quote', $boucle->sql_serveur, true);
		$modes = addslashes(join(',', array_map($f, array_unique($modes))));
		array_unshift($boucle->where, array("'IN'", "'$id_table.mode'", "'($modes)'"));
	}

	return calculer_boucle($id_boucle, $boucles);
}


/**
 * Pour compat uniquement, utiliser generer_lien_entite
 *
 * @deprecated
 * @uses generer_lien_entite()
 *
 * @param int $id
 * @param string $type
 * @param int $longueur
 * @param null $connect
 * @return string
 */
function lien_objet($id, $type, $longueur = 80, $connect = null) {
	return generer_lien_entite($id, $type, $longueur, $connect);
}

/**
 * critere {orphelins} selectionne les documents sans liens avec un objet editorial
 *
 * @param string $idb
 * @param object $boucles
 * @param object $crit
 */
function critere_DOCUMENTS_orphelins_dist($idb, &$boucles, $crit) {

	$boucle = &$boucles[$idb];
	$cond = $crit->cond;
	$not = $crit->not ? "" : "NOT";

	$select = sql_get_select("DISTINCT id_document", "spip_documents_liens as oooo");
	$where = "'" . $boucle->id_table . ".id_document $not IN ($select)'";
	if ($cond) {
		$_quoi = '@$Pile[0]["orphelins"]';
		$where = "($_quoi)?$where:''";
	}

	$boucle->where[] = $where;
}

/**
 * critere {portrait} qui selectionne
 * - les documents dont les dimensions sont connues
 * - les documents dont la hauteur est superieure a la largeur
 *
 * {!portrait} exclus ces documents
 *
 * @param string $idb
 * @param object $boucles
 * @param object $crit
 */
function critere_DOCUMENTS_portrait_dist($idb, &$boucles, $crit) {
	$boucle = &$boucles[$idb];
	$table = $boucle->id_table;
	$not = ($crit->not ? "NOT " : "");
	$boucle->where[] = "'$not($table.largeur>0 AND $table.hauteur > $table.largeur)'";
}

/**
 * critere {paysage} qui selectionne
 * - les documents dont les dimensions sont connues
 * - les documents dont la hauteur est inferieure a la largeur
 *
 * {!paysage} exclus ces documents
 *
 * @param string $idb
 * @param object $boucles
 * @param object $crit
 */
function critere_DOCUMENTS_paysage_dist($idb, &$boucles, $crit) {
	$boucle = &$boucles[$idb];
	$table = $boucle->id_table;
	$not = ($crit->not ? "NOT " : "");
	$boucle->where[] = "'$not($table.largeur>0 AND $table.largeur > $table.hauteur)'";
}

/**
 * critere {carre} qui selectionne
 * - les documents dont les dimensions sont connues
 * - les documents dont la hauteur est egale a la largeur
 *
 * {!carre} exclus ces documents
 *
 * @param string $idb
 * @param object $boucles
 * @param object $crit
 */
function critere_DOCUMENTS_carre_dist($idb, &$boucles, $crit) {
	$boucle = &$boucles[$idb];
	$table = $boucle->id_table;
	$not = ($crit->not ? "NOT " : "");
	$boucle->where[] = "'$not($table.largeur>0 AND $table.largeur = $table.hauteur)'";
}


/**
 * Calcule la vignette d'une extension (l'image du type de fichier)
 *
 * Utile dans une boucle DOCUMENTS pour afficher une vignette du type
 * du document (balise `#EXTENSION`) alors que ce document a déjà une vignette
 * personnalisée (affichable par `#LOGO_DOCUMENT`).
 *
 * @example
 *     `[(#EXTENSION|vignette)]` produit une balise `<img ... />`
 *     `[(#EXTENSION|vignette{true})]` retourne le chemin de l'image
 *
 * @param string $extension
 *     L'extension du fichier, exemple : png ou pdf
 * @param bool $get_chemin
 *     false pour obtenir une balise img de l'image,
 *     true pour obtenir seulement le chemin du fichier
 * @return string
 *     Balise HTML <img...> ou chemin du fichier
 **/
function filtre_vignette_dist($extension = 'defaut', $get_chemin = false) {
	static $vignette = false;
	static $balise_img = false;

	if (!$vignette) {
		$vignette = charger_fonction('vignette', 'inc');
		$balise_img = charger_filtre('balise_img');
	}

	$fichier = $vignette($extension, false);
	// retourne simplement le chemin du fichier
	if ($get_chemin) {
		return $fichier;
	}

	// retourne une balise <img ... />
	return $balise_img($fichier);
}
