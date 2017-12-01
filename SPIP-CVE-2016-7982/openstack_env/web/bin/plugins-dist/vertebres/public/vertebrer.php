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
 * Échafaudage du contenu du d'un squelette présentant le contenu d'une table SQL
 *
 * Production dynamique d'un squelette lorsqu'il ne figure pas dans les dossiers
 * de squelettes mais que son nom est celui d'une table SQL:
 * on produit une table HTML montrant le contenu de la table SQL
 *
 * Le squelette produit illustre quelques possibilites de SPIP:
 * - pagination automatique
 * - tri ascendant et descendant sur chacune des colonnes
 * - critere conditionnel donnant l'extrait correspondant a la colonne en URL
 *
 * @package SPIP\Vertebres\Fonctions
 **/

if (!defined("_ECRIRE_INC_VERSION")) {
	return;
}


/**
 * Retourne un morceau de squelette pour ajouter les noms des colonnes
 * et des tris possibles dessus
 *
 * @param array $fields
 *     Liste des champs de la table
 * @return string
 *     Ligne de tableau
 **/
function vertebrer_sort($fields) {
	$res = '';
	foreach ($fields as $n => $t) {
		$res .= "\n\t\t<th scope='col'>[(#TRI{" . "$n,$n,ajax})]</th>";
	}

	return $res;
}

/**
 * Retourne un morceau de squelette pour ajouter des recherches sur chaque champ de la table
 *
 * Autant de formulaire que de champs (pour les criteres conditionnels)
 *
 * @param array $fields
 *     Liste des champs de la table
 * @return string
 *     Ligne de tableau
 **/
function vertebrer_form($fields) {
	$res = '';
	$url = join('|', array_keys($fields));
	$url = "#SELF|\n\t\t\tparametre_url{'$url',''}";
	foreach ($fields as $n => $t) {
		$s = sql_test_int($t) ? 11
			: (preg_match('/char\s*\((\d)\)/i', $t, $r) ? $r[1] : '');

		if (!in_array($n, array('date', 'date_redac', 'lang'))) {
			$res .= "\n\t\t<td>
				[(#ENV{" . $n . "}|non)
				<a href='#' onclick=\"jQuery(this).toggle('fast').siblings('form').toggle('fast');return false;\">[(#CHEMIN_IMAGE{rechercher-20.png}|balise_img)]</a>
				]
				<form class='[(#ENV{" . $n . "}|non)none-js]' action='./' method='get'>"
				. "<div>"
				. "\n\t\t\t<input name='$n'"
				. ($s ? " size='$s'" : '')
				. "value=\"[(#ENV{" . $n . "}|entites_html)]\""
				. " />\n\t\t\t[($url|\n\t\t\tform_hidden)]"
				. "\n\t\t</div></form></td>";
		} else {
			$res .= "<td></td>";
		}
	}

	return $res;
}

/**
 * Retourne un morceau de squelette pour ajouter les critères à la boucle
 *
 * Autant de criteres conditionnels que de champs
 *
 * @param array $fields
 *     Liste des champs de la table
 * @return string
 *     Critères de boucles
 **/
function vertebrer_crit($fields) {
	$res = "";
	foreach ($fields as $n => $t) {
		if (!in_array($n, array('date', 'date_redac', 'lang', 'recherche', 'logo'))) {
			$res .= "\n\t\t{" . $n . " ?}";
		}
	}

	return $res;
}


/**
 * Retourne un morceau de squelette pour afficher le contenu de chaque
 * champ SQL dans une ligne d'un tableau
 *
 * Class CSS en fonction de la parité du numero de ligne.
 * Style text-align en fonction du type SQL (numerique ou non).
 *
 * Filtre de belle date sur type SQL signalant une date ou une estampillé.
 *
 * Si une colonne référence une table, ajoute un href sur sa page dynamique
 * (il faudrait aller chercher sa def pour ilustrer les jointures en SPIP)
 *
 * @param array $fields
 *     Liste des champs de la table
 * @return string
 *     Ligne de tableau
 **/
function vertebrer_cell($fields) {
	$res = "";
	foreach ($fields as $n => $t) {
		$texte = "#CHAMP_SQL{" . $n . "}";
		if (preg_match('/\s+references\s+([\w_]+)/', $t, $r)) {
			$url = "[(#SELF|parametre_url{page,'" . $r[1] . "'})]";
			$texte = "<a href='$url'>" . $texte . "</a>";
		}
		if (sql_test_int($t)) {
			$s = " style='text-align: right;'";
		} else {
			$s = '';
			if (sql_test_date($t)) {
				$texte = "[($texte|affdate_heure)]";
			}
		}
		$res .= "\n\t\t<td$s>$texte</td>";
	}

	return $res;
}

/**
 * Calcule le contenu d'un squelette pour lister le contenu d'une
 * table SQL à partir de la description de cette table.
 *
 * @see  base_trouver_table_dist()
 * @uses vertebrer_form()
 * @uses vertebrer_crit()
 * @uses vertebrer_cell()
 * @uses vertebrer_sort()
 *
 * @param array $desc
 *     Descrption de la table, telle que retournéer par trouver_table.
 * @return string
 *     Contenu du squelette pour la table
 **/
function public_vertebrer_dist($desc) {
	$nom = $desc['table'];
	$surnom = $desc['id_table'];
	$connexion = $desc['connexion'];
	$field = $desc['field'];
	$key = $desc['key'];

	$defaut_tri = array_keys($field);
	$defaut_tri = reset($defaut_tri);

	//ksort($field);

	$form = vertebrer_form($field);
	$crit = vertebrer_crit($field);
	$cell = vertebrer_cell($field);
	$sort = vertebrer_sort($field);
	$distant = !$connexion ? '' : "&amp;connect=$connexion";

	return
		"#CACHE{0}
<B1>
<h2>[(#GRAND_TOTAL|singulier_ou_pluriel{vertebres:1_donnee,vertebres:nb_donnees})]</h2>
[<p class='pagination'>(#PAGINATION)</p>]
<div style='overflow: scroll;overflow-y: auto'>
<table class='spip'>
	<thead>
	<tr class='row_first'>
		<th>
			<p class='tri'>#TRI{'>',#CHEMIN_IMAGE{tri-asc-16.png}|balise_img{up},ajax}  #TRI{'<',#CHEMIN_IMAGE{tri-desc-16.png}|balise_img{desc},ajax}</p>
		</th>
		$sort
	</tr>
	<tr>
		<td></td>$form
	</tr>
	</thead>
	<tbody>
<BOUCLE1($surnom){pagination}
		{tri $defaut_tri, direct}$crit>
	<tr class='[row_(#COMPTEUR_BOUCLE|alterner{'odd','even'})]'>
		<td style='text-align: right;'>#COMPTEUR_BOUCLE</td>$cell
	</tr>
</BOUCLE1>
	</tbody>
	<tfoot>
	<tr>
		<th>
			<p class='tri'>#TRI{'>',#CHEMIN_IMAGE{tri-asc-16.png}|balise_img{up},ajax}  #TRI{'<',#CHEMIN_IMAGE{tri-desc-16.png}|balise_img{desc},ajax}</p>
		</th>
		$sort
	</tr>
	</tfoot>
</table>
</B1>
<div style='overflow: scroll;overflow-y: auto'>
<h2><:texte_vide:></h2>
<table class='spip'>
	<thead>
	<tr class='row_first'>
		<th>
			<p class='tri'>#TRI{'>',#CHEMIN_IMAGE{tri-asc-16.png}|balise_img{up},ajax}  #TRI{'<',#CHEMIN_IMAGE{tri-desc-16.png}|balise_img{desc},ajax}</p>
		</th>
		$sort
	</tr>
	<tr>
		<td></td>$form
	</tr>
	</thead>
</table>
<//B1>
</div>
";
}
