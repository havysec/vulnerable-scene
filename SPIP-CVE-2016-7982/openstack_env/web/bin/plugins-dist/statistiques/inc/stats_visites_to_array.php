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

include_spip('inc/statistiques');
// moyenne glissante sur 30 jours
define('MOYENNE_GLISSANTE_JOUR', 30);
// moyenne glissante sur 12 mois
define('MOYENNE_GLISSANTE_MOIS', 12);

function inc_stats_visites_to_array_dist($unite, $duree, $id_article, $options = array()) {
	$now = time();

	if (!in_array($unite, array('jour', 'mois'))) {
		$unite = 'jour';
	}
	$serveur = '';

	$table = "spip_visites";
	$order = "date";
	$where = array();
	if ($duree) {
		$where[] = sql_date_proche($order, -$duree, 'day', $serveur);
	}

	if ($id_article) {
		$table = "spip_visites_articles";
		$where[] = "id_article=" . intval($id_article);
	}

	$where = implode(" AND ", $where);
	$format = ($unite == 'jour' ? '%Y-%m-%d' : '%Y-%m-01');

	$res = sql_select("SUM(visites) AS v, DATE_FORMAT($order,'$format') AS d", $table, $where, "d", "d", "", '',
		$serveur);

	$format = str_replace('%', '', $format);
	$periode = ($unite == 'jour' ? 24 * 3600 : 365 * 24 * 3600 / 12);
	$step = intval(round($periode * 1.1, 0));
	$glisse = constant('MOYENNE_GLISSANTE_' . strtoupper($unite));
	moyenne_glissante();
	$data = array();
	$r = sql_fetch($res, $serveur);
	if (!$r) {
		$r = array('d' => date($format, $now), 'v' => 0);
	}
	do {
		$data[$r['d']] = array('visites' => $r['v'], 'moyenne' => moyenne_glissante($r['v'], $glisse));
		$last = $r['d'];

		// donnee suivante
		$r = sql_fetch($res, $serveur);
		// si la derniere n'est pas la date courante, l'ajouter
		if (!$r and $last != date($format, $now)) {
			$r = array('d' => date($format, $now), 'v' => 0);
		}

		// completer les trous manquants si besoin
		if ($r) {
			$next = strtotime($last);
			$current = strtotime($r['d']);
			while (($next += $step) < $current and $d = date($format, $next)) {
				if (!isset($data[$d])) {
					$data[$d] = array('visites' => 0, 'moyenne' => moyenne_glissante(0, $glisse));
				}
				$last = $d;
				$next = strtotime($last);
			}
		}
	} while ($r);

	// projection pour la derniere barre :
	// mesure courante
	// + moyenne au pro rata du temps qui reste
	$moyenne = end($data);
	$moyenne = prev($data);
	$moyenne = ($moyenne and isset($moyenne['moyenne'])) ? $moyenne['moyenne'] : 0;
	$data[$last]['moyenne'] = $moyenne;

	// temps restant
	$remaining = strtotime(date($format, strtotime(date($format, $now)) + $step)) - $now;

	$prorata = $remaining / $periode;

	// projection
	$data[$last]['prevision'] = $data[$last]['visites'] + intval(round($moyenne * $prorata));
	/*
	 * Compter les fichiers en attente de depouillement dans tmp/visites/
	 * pour affiner la prediction.
   * A activer dans le mes_options si l'hebergement tient le coup en cas de gros pics de traffic
	 */
	if (!$id_article and defined('_STATS_COMPTE_EN_ATTENTE') AND _STATS_COMPTE_EN_ATTENTE){
		// eviter un depassement memoire en mesurant un echantillon pour commencer
		$n = count(glob(_DIR_RACINE . "tmp/visites/0*"));
		if ($n < 10000) {
			$n = count(glob(_DIR_RACINE . "tmp/visites/*"));
		} else {
			$n += count(glob(_DIR_RACINE . "tmp/visites/4*"));
			$n += count(glob(_DIR_RACINE . "tmp/visites/8*"));
			$n += count(glob(_DIR_RACINE . "tmp/visites/c*"));
			$n = 4 * $n;
		}
		$data[$last]['prevision'] += $n;
	}

	return $data;
}
