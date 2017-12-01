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
 * Déclaration de filtres pour les squelettes
 *
 * @package SPIP\Mots\Filtres
 **/
if (!defined("_ECRIRE_INC_VERSION")) {
	return;
}

include_spip('inc/presentation');
include_spip('inc/actions');
include_spip('base/abstract_sql');

/**
 * Compte le nombre d'objets associés pour chaque type d'objet, liés
 * à un mot clé donné.
 *
 * @pipeline_appel afficher_nombre_objets_associes_a
 *
 * @param int $id_mot
 *     Identifiant du mot clé
 * @param int $id_groupe
 *     Identifiant du groupe parent
 * @return string[]
 *     Tableau de textes indiquant le nombre d'éléments tel que '3 articles'
 **/
function filtre_objets_associes_mot_dist($id_mot, $id_groupe) {
	static $occurrences = array();

	// calculer tous les liens du groupe d'un coup
	if (!isset($occurrences[$id_groupe])) {
		$occurrences[$id_groupe] = calculer_utilisations_mots($id_groupe);
	}

	$associes = array();
	$tables = lister_tables_objets_sql();
	foreach ($tables as $table_objet_sql => $infos) {
		$nb = (isset($occurrences[$id_groupe][$table_objet_sql][$id_mot]) ? $occurrences[$id_groupe][$table_objet_sql][$id_mot] : 0);
		if ($nb) {
			$associes[] = objet_afficher_nb($nb, $infos['type']);
		}
	}

	$associes = pipeline('afficher_nombre_objets_associes_a',
		array('args' => array('objet' => 'mot', 'id_objet' => $id_mot), 'data' => $associes));

	return $associes;

}

/**
 * Calculer les nombres d'éléments (articles, etc.) liés à chaque mot
 * d'un groupe de mots
 *
 * @param int $id_groupe
 *     Identifiant du groupe de mots
 * @return array
 *     Couples (tables de liaison => mots).
 *     Mots est un tableau de couples (id_mot => nombre d'utilisation)
 */
function calculer_utilisations_mots($id_groupe) {
	$retour = array();
	$objets = sql_allfetsel('DISTINCT objet', array('spip_mots_liens AS L', 'spip_mots AS M'),
		array('L.id_mot=M.id_mot', 'M.id_groupe=' . intval($id_groupe)));

	foreach ($objets as $o) {
		$objet = $o['objet'];
		$_id_objet = id_table_objet($objet);
		$table_objet_sql = table_objet_sql($objet);
		$infos = lister_tables_objets_sql($table_objet_sql);
		if (isset($infos['field']) and $infos['field']) {
			// uniquement certains statut d'objet,
			// et uniquement si la table dispose du champ statut.
			$statuts = "";
			if (isset($infos['field']['statut']) or isset($infos['statut'][0]['champ'])) {
				// on s'approche au mieux de la declaration de l'objet.
				// il faudrait ameliorer ce point.
				$c_statut = isset($infos['statut'][0]['champ']) ? $infos['statut'][0]['champ'] : 'statut';

				// bricoler les statuts d'apres la declaration de l'objet (champ previsu a defaut de mieux)
				if (array_key_exists('previsu', $infos['statut'][0]) and strlen($infos['statut'][0]['previsu']) > 1) {
					$str_statuts = $infos['statut'][0]['previsu'];
					if ($GLOBALS['connect_statut'] != "0minirezo") {
						$str_statuts = str_replace('prepa', '', $str_statuts);
					}
					$not = (substr($str_statuts, 0, 1) == '!' ? 'NOT' : '');
					$str_statuts = str_replace('!', '', $str_statuts);
					$Tstatuts = array_filter(explode(',', $str_statuts));
					$statuts = " AND " . sql_in("O.$c_statut", $Tstatuts, $not);
				} // objets sans champ previsu ou avec un previsu == '!' (par ex les rubriques)
				else {
					$statuts = " AND " . sql_in("O.$c_statut",
							($GLOBALS['connect_statut'] == "0minirezo") ? array('prepa', 'prop', 'publie') : array('prop', 'publie'));
				}
			}
			$res = sql_allfetsel(
				"COUNT(*) AS cnt, L.id_mot",
				"spip_mots_liens AS L
					LEFT JOIN spip_mots AS M ON L.id_mot=M.id_mot
						AND L.objet=" . sql_quote($objet) . "
					LEFT JOIN " . $table_objet_sql . " AS O ON L.id_objet=O.$_id_objet",
				"M.id_groupe=$id_groupe$statuts",
				"L.id_mot");
			foreach ($res as $row) {
				$retour[$table_objet_sql][$row['id_mot']] = $row['cnt'];
			}
		}
	}

	return $retour;
}
