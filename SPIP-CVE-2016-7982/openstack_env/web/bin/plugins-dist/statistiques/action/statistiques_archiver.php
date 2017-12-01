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
 * Action d'archivage des statistiques
 *
 * @plugin Statistiques pour SPIP
 * @license GNU/GPL
 * @package SPIP\Stats\Actions
 **/

if (!defined("_ECRIRE_INC_VERSION")) {
	return;
}


if (!defined('STATISTIQUES_ARCHIVER_PAR_MOIS')) {
	/**
	 * Nombre d'années après quoi on permet de concaténer les statistiques de visites par mois
	 *
	 * Après ce nombre d'années, on peut concaténer les données de visites d'articles par mois
	 * pour prendre moins de place dans la base de données
	 *
	 * @var int Nombre d'années
	 **/
	define('STATISTIQUES_ARCHIVER_PAR_MOIS', 2);
}

if (!defined('STATISTIQUES_ARCHIVER_PAR_AN')) {
	/**
	 * Nombre d'années après quoi on permet de concaténer les statistiques de visites par an
	 *
	 * Après ce nombre d'années, on peut concaténer les données de visites d'articles par années
	 * pour prendre moins de place dans la base de données
	 *
	 * @var int Nombre d'années
	 **/
	define('STATISTIQUES_ARCHIVER_PAR_AN', 5);
}


/**
 * Archiver ou nettoyer des statistiques
 *
 * @param string $arg
 */
function action_statistiques_archiver_dist($arg = null) {
	if (!$arg) {
		$securiser_action = charger_fonction('securiser_action', 'inc');
		$arg = $securiser_action();
	}

	if (!autoriser('webmestre')) {
		include_spip('inc/minipres');
		minipres();
	}

	if (!in_array($arg, array(
		'archiver_visites_articles',
		'nettoyer_visites_articles',
		'nettoyer_referers_articles'
	))
	) {
		include_spip('inc/minipres');
		minipres("Argument non compris");
	}

	$func = 'statistiques_' . $arg;
	$func();
}


/**
 * Logguer ces informations importantes.
 *
 * @uses spip_log()
 * @param string $texte
 **/
function statistiques_archiver_log($texte) {
	spip_log($texte, 'statistiques_archiver.' . _LOG_INFO_IMPORTANTE);
}

/**
 * Nettoyer des lignes de visites d'articles incorrectes
 *
 * Supprime toutes les lignes qui ne font pas partie
 * d'un article présent en base
 **/
function statistiques_nettoyer_visites_articles() {
	statistiques_archiver_log("Supprimer les visites d'articles qui n'existent pas dans spip_articles.");
	$i = sql_delete('spip_visites_articles', 'id_article NOT IN (SELECT id_article FROM spip_articles)');
	statistiques_archiver_log("Fin de la suppression : $i lignes supprimées");
}

/**
 * Nettoyer des lignes de referers d'articles incorrectes
 *
 * Supprime toutes les lignes qui ne font pas partie
 * d'un article présent en base
 **/
function statistiques_nettoyer_referers_articles() {
	statistiques_archiver_log("Supprimer les referers d'articles qui n'existent pas dans spip_articles.");
	$i = sql_delete('spip_referers_articles', 'id_article NOT IN (SELECT id_article FROM spip_articles)');
	statistiques_archiver_log("Fin de la suppression : $i lignes supprimées");
}

/**
 * Archiver les visites d'articles
 *
 * @note
 *   Cela peut prendre beaucoup de temps.
 *
 *   La base de test avait (en 2014) 12.500.000 d'entrées depuis 2005.
 *   Cet archivage réduit à 1.200.000 entrées en réduisant
 *   par mois jusqu'à 2012 inclu et par an jusqu'à 2009 inclu.
 *
 *   Cela prenait 8 minutes sur ma machine locale
 *   (Intel Core i5-4258U CPU @ 2.40GHz × 4 avec disque SSD)
 *
 * @note
 *   On peut suivre l'avancement dans le fichier de log
 *   tail -f tmp/log/statistiques_archiver.log
 *
 * @note
 *   On ne peut pas vraiment avec le code actuel de la fonction
 *   appliquer les calculs sur l'ensemble d'un mois car cela
 *   peut facilement surcharger la mémoire de php.
 *
 *   Du coup, on applique par petit bouts d'abord.
 *
 * @uses statistiques_concatener_visites_entre_jours()
 * @uses statistiques_concatener_visites_par_mois()
 * @uses statistiques_concatener_visites_par_an()
 **/
function statistiques_archiver_visites_articles() {

	// Tenter de donner du temps au temps
	@set_time_limit(15 * 60); // 15mn

	$annee_par_mois = date('Y') - STATISTIQUES_ARCHIVER_PAR_MOIS;
	$annee_par_an = date('Y') - STATISTIQUES_ARCHIVER_PAR_AN;

	$annee_minimum = statistiques_concatener_annee_minimum();
	if (!$annee_minimum) {
		return false;
	}

	if ($annee_minimum > $annee_par_mois) {
		statistiques_archiver_log("Il n'y a pas de statistiques assez anciennes pour concaténer par mois !");
	} else {
		// en plusieurs temps pour éviter trop de mémoire !
		statistiques_concatener_visites_entre_jours($annee_par_mois, 1, 10);
		statistiques_concatener_visites_entre_jours($annee_par_mois, 11, 20);
		statistiques_concatener_visites_entre_jours($annee_par_mois, 21, 31);

		// et on regroupe tout en 1 seul morceau.
		statistiques_concatener_visites_par_mois($annee_par_mois);
	}

	if ($annee_minimum > $annee_par_an) {
		statistiques_archiver_log("Il n'y a pas de statistiques assez anciennes pour concaténer par an !");
	} else {
		// et les vieilles années, on regroupe par an directement.
		statistiques_concatener_visites_par_an($annee_par_an);
	}

	statistiques_archiver_log("* Optimiser la table spip_visites_articles après les travaux.");
	sql_optimize('spip_visites_articles');
}

/**
 * Concatène les statistiques de visites d'articles par mois
 *
 * @see statistiques_concatener_visites_entre_jours()
 *
 * @param int $annee
 *    On concatène ce qui est avant cette année là.
 **/
function statistiques_concatener_visites_par_mois($annee) {
	return statistiques_concatener_visites_entre_jours($annee, 1, 31);
}


/**
 * Concatène les statistiques de visites d'articles par portion de mois (entre groupe de jours)
 *
 * @param int $annee
 *    On concatène ce qui est avant cette année là.
 * @param int $debut
 *    Numéro de jour du début de la concaténation, exemple 1.
 *    Le total des visites concaténé sera mis dans ce jour là.
 * @param int $fin
 *    Numéro de jour de fin de la concaténation, exemple 31.
 *    Toutes les entrées entre le jour $debut+1 et $fin seront supprimées
 *    et concaténées au jour $debut.
 *
 **/
function statistiques_concatener_visites_entre_jours($annee, $debut, $fin) {

	$annee_minimum = statistiques_concatener_annee_minimum();
	if (!$annee_minimum) {
		return false;
	}

	if ($annee_minimum > $annee) {
		statistiques_archiver_log("Il n'y a pas de statistiques assez anciennes !");

		return false;
	}

	// on a besoin pour le champ date d'une écriture sur 2 chiffres.
	$debut = str_pad($debut, 2, '0', STR_PAD_LEFT);
	$fin = str_pad($fin, 2, '0', STR_PAD_LEFT);

	statistiques_archiver_log("\nConcaténer les visites d'articles (jours entre $debut et $fin)");
	statistiques_archiver_log("===========================================================");

	$annees = range($annee_minimum, $annee);
	$mois = range(1, 12);

	foreach ($annees as $a) {
		statistiques_archiver_log("\n- Concaténer les visites de l'année : $a");

		foreach ($mois as $m) {
			$m = str_pad($m, 2, '0', STR_PAD_LEFT);
			statistiques_concatener_visites_entre_periode("$a-$m-$debut", "$a-$m-$fin");
		}
	}
}


/**
 * Retourne la plus petite année des visites d'articles
 *
 * @return int|bool
 *     - int : l'année
 *     - false : année non trouvée.
 **/
function statistiques_concatener_annee_minimum() {
	static $annee_minimum = null;

	// calcul de la plus petite année de statistiques
	if (is_null($annee_minimum)) {
		$annee_minimum = sql_getfetsel('YEAR(MIN(date))', 'spip_visites_articles', '', '', '', '0,1');
	}

	if (!$annee_minimum) {
		statistiques_archiver_log("Erreur de calcul de la plus petite année de statistiques !");

		return false;
	}

	return $annee_minimum;
}


/**
 * Concatène les statistiques de visites d'articles par an
 *
 * @param int $annee
 *    On concatène ce qui est avant cette année là.
 *
 **/
function statistiques_concatener_visites_par_an($annee) {

	$annee_minimum = statistiques_concatener_annee_minimum();
	if (!$annee_minimum) {
		return false;
	}

	if ($annee_minimum > $annee) {
		statistiques_archiver_log("Il n'y a pas de statistiques assez anciennes !");

		return false;
	}

	statistiques_archiver_log("\nConcaténer les visites d'articles (par an)");
	statistiques_archiver_log("===========================================================");

	$annees = range($annee_minimum, $annee);

	foreach ($annees as $a) {
		statistiques_archiver_log("\n- Concaténer les visites de l'année : $a");
		statistiques_concatener_visites_entre_periode("$a-01-01", "$a-12-31");
	}
}


/**
 * Concatène les statistiques de visites d'articles entre 2 périodes.
 *
 * @param string $date_debut
 *     Date de début tel que '2010-01-01'
 * @param string $date_fin
 *     Date de fin tel que '2010-12-31'
 * @return bool
 *     - false : aucune visite sur cette période
 *     - true : il y avait des visites, elles ont été concaténées (ou l'étaient déjà)
 *
 **/
function statistiques_concatener_visites_entre_periode($date_debut, $date_fin) {

	// récupérer toutes les visites de cette période (année, mois, entre jour début et fin)
	$visites = sql_allfetsel('id_article, date, visites', 'spip_visites_articles', array(
		"date >= " . sql_quote($date_debut),
		"date <= " . sql_quote($date_fin),
	));

	if (!$visites) {
		return false;
	}

	$liste = $updates = array();
	$total = 0;

	// - Crée un tableau plus simple (id_article => total des visites de la période) (permettant un array_diff_key facile).
	// - Calcule au passage le total des visites de la période (pour le log)
	// - Rempli un autre tableau ($updates) qui indique si cet article doit avoir ses visites concaténées sur cette période,
	//   c'est à dire, si il y a une date qui n'est pas le début de période.
	//   (évite de nombreuses requêtes si l'on exécute plusieurs fois le script)
	foreach ($visites as $v) {
		$id_article = $v['id_article'];
		if (!isset($liste[$id_article])) {
			$liste[$id_article] = 0;
		}
		$liste[$id_article] += $v['visites'];
		$total += $v['visites'];
		if ($v['date'] != $date_debut) {
			$updates[$id_article] = true;
		}
	}

	unset($visites);

	$nb_articles = count($liste);

	// juste ceux qui nécessitent une mise à jour (date <> de $debut de période)
	$liste = array_intersect_key($liste, $updates);

	statistiques_archiver_log("-- du $date_debut au $date_fin : $total visites dans $nb_articles articles");

	if ($liste) {

		// formater pour l'insertion dans la base.
		$inserts = array();
		foreach ($liste as $id_article => $visites) {
			$inserts[] = array(
				'id_article' => $id_article,
				'date' => $date_debut,
				'visites' => $visites,
			);
		}

		statistiques_archiver_log("--- concaténer les statistiques de " . count($liste) . " articles");

		// /!\ Attention,
		// Entre ces 2 requêtes, on peut perdre des données (si timeout ou autre)
		// Transaction à faire ?

		sql_delete('spip_visites_articles', array(
			"date >= " . sql_quote($date_debut),
			"date <= " . sql_quote($date_fin),
			sql_in('id_article', array_keys($liste)),
		));

		sql_insertq_multi('spip_visites_articles', $inserts);
	}

	unset($liste, $inserts);

	return true;
}
