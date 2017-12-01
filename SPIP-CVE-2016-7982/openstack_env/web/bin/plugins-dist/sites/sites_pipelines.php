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

/**
 * Ajouter les sites et syndication a valider sur les rubriques
 *
 * @param array $flux
 * @return array
 */
function sites_rubrique_encours($flux) {
	if ($flux['args']['type'] == 'rubrique') {
		$lister_objets = charger_fonction('lister_objets', 'inc');

		$id_rubrique = $flux['args']['id_objet'];

		//
		// Les sites references a valider
		//
		if ($GLOBALS['meta']['activer_sites'] != 'non') {
			$flux['data'] .= $lister_objets('sites', array(
				'titre' => _T('sites:info_site_valider'),
				'statut' => 'prop',
				'id_rubrique' => $id_rubrique,
				'par' => 'nom_site'
			));
		}

		//
		// Les sites a probleme
		//
		if ($GLOBALS['meta']['activer_sites'] != 'non'
			and autoriser('publierdans', 'rubrique', $id_rubrique)
		) {
			$flux['data'] .= $lister_objets('sites', array(
				'titre' => _T('sites:avis_sites_syndiques_probleme'),
				'statut' => 'publie',
				'syndication' => array('off', 'sus'),
				'id_rubrique' => $id_rubrique,
				'par' => 'nom_site'
			));
		}

		// Les articles syndiques en attente de validation
		if ($id_rubrique == 0
			and autoriser('publierdans', 'rubrique', $id_rubrique)
		) {

			$cpt = sql_countsel("spip_syndic_articles", "statut='dispo'");
			if ($cpt) {
				$flux['data'] .= "<br /><small><a href='" .
					generer_url_ecrire("sites") .
					"' style='color: black;'>" .
					$cpt .
					" " .
					_T('sites:info_liens_syndiques_1') .
					" " .
					_T('sites:info_liens_syndiques_2') .
					"</a></small>";
			}
		}
	}

	return $flux;
}

/**
 * Configuration des contenus
 *
 * @param array $flux
 * @return array
 */
function sites_affiche_milieu($flux) {
	if ($flux["args"]["exec"] == "configurer_contenu") {
		$flux["data"] .= recuperer_fond('prive/squelettes/inclure/configurer', array('configurer' => 'configurer_sites'));
	}

	return $flux;
}

/**
 * Ajouter les sites et syndication a valider sur la page d'accueil
 *
 * @param array $flux
 * @return array
 */
function sites_accueil_encours($flux) {
	$lister_objets = charger_fonction('lister_objets', 'inc');

	//
	// Les sites references a valider
	//
	if ($GLOBALS['meta']['activer_sites'] != 'non') {
		$flux .= $lister_objets('sites', array(
			'titre' => afficher_plus_info(generer_url_ecrire('sites')) . _T('sites:info_site_valider'),
			'statut' => 'prop',
			'par' => 'nom_site'
		));
	}

	if ($GLOBALS['visiteur_session']['statut'] == '0minirezo') {
		//
		// Les sites a probleme
		//
		if ($GLOBALS['meta']['activer_sites'] != 'non') {
			$flux .= $lister_objets('sites', array(
				'titre' => afficher_plus_info(generer_url_ecrire('sites')) . _T('sites:avis_sites_syndiques_probleme'),
				'statut' => 'publie',
				'syndication' => array('off', 'sus'),
				'par' => 'nom_site'
			));
		}

		// Les articles syndiques en attente de validation
		$cpt = sql_countsel("spip_syndic_articles", "statut='dispo'");
		if ($cpt) {
			$flux .= "\n<br /><small><a href='"
				. generer_url_ecrire("sites", "")
				. "' style='color: black;'>"
				. $cpt
				. " "
				. _T('sites:info_liens_syndiques_1')
				. " "
				. _T('sites:info_liens_syndiques_2')
				. "</a></small>";
		}

	}

	return $flux;
}


/**
 * Ajouter les sites references sur les vues de rubriques
 *
 * @param array $flux
 * @return array
 */
function sites_affiche_enfants($flux) {
	if (isset($flux['args']['exec'])
		and $e = trouver_objet_exec($flux['args']['exec'])
		and $e['type'] == 'rubrique'
		and $e['edition'] == false
	) {
		$id_rubrique = $flux['args']['id_rubrique'];

		if ($GLOBALS['meta']["activer_sites"] == 'oui') {
			$lister_objets = charger_fonction('lister_objets', 'inc');
			$bouton_sites = '';
			if (autoriser('creersitedans', 'rubrique', $id_rubrique)) {
				$bouton_sites .= icone_verticale(_T('sites:info_sites_referencer'),
						generer_url_ecrire('site_edit', "id_rubrique=$id_rubrique"), "site-24.png", "new", 'right')
					. "<br class='nettoyeur' />";
			}

			$flux['data'] .= $lister_objets('sites', array(
				'titre' => _T('sites:titre_sites_references_rubrique'),
				'where' => "statut!='refuse' AND statut != 'prop' AND syndication NOT IN ('off','sus')",
				'id_rubrique' => $id_rubrique,
				'par' => 'nom_site'
			));
			$flux['data'] .= $bouton_sites;
		}
	}

	return $flux;
}


/**
 * Definir les meta de configuration liee aux syndications et sites
 *
 * @param array $metas
 * @return array
 */
function sites_configurer_liste_metas($metas) {
	$metas['activer_sites'] = 'non';
	$metas['proposer_sites'] = 0;
	$metas['activer_syndic'] = 'oui';
	$metas['moderation_sites'] = 'non';

	return $metas;
}

/**
 * Taches periodiques de syndication
 *
 * @param array $taches_generales
 * @return array
 */
function sites_taches_generales_cron($taches_generales) {

	if (isset($GLOBALS['meta']["activer_syndic"])
		and $GLOBALS['meta']["activer_syndic"] == "oui"
		and isset($GLOBALS['meta']["activer_sites"])
		and $GLOBALS['meta']["activer_sites"] == "oui"
	) {
		$taches_generales['syndic'] = 90;
	}

	return $taches_generales;
}


/**
 * Optimiser la base de donnee en supprimant les liens orphelins
 *
 * @param array $flux
 * @return array
 */
function sites_optimiser_base_disparus($flux) {
	$n = &$flux['data'];
	$mydate = $flux['args']['date'];

	sql_delete("spip_syndic", "maj<" . sql_quote($mydate) . " AND statut=" . sql_quote("refuse"));

	# les articles syndiques appartenant a des sites effaces
	$res = sql_select("S.id_syndic AS id",
		"spip_syndic_articles AS S
		        LEFT JOIN spip_syndic AS syndic
		          ON S.id_syndic=syndic.id_syndic",
		"syndic.id_syndic IS NULL");

	$n += optimiser_sansref('spip_syndic_articles', 'id_syndic', $res);


	return $flux;

}


/**
 * Publier et dater les rubriques qui ont un site publie
 *
 * @param array $flux
 * @return array
 */
function sites_calculer_rubriques($flux) {

	$r = sql_select(
		"R.id_rubrique AS id, max(A.date) AS date_h",
		"spip_rubriques AS R JOIN spip_syndic AS A ON R.id_rubrique = A.id_rubrique",
		"A.date>R.date_tmp AND A.statut='publie' ", "R.id_rubrique");
	while ($row = sql_fetch($r)) {
		sql_updateq('spip_rubriques', array('statut_tmp' => 'publie', 'date_tmp' => $row['date_h']),
			"id_rubrique=" . $row['id']);
	}

	return $flux;
}

/**
 * Compter les sites dans une rubrique
 *
 * @param array $flux
 * @return array
 */
function sites_objet_compte_enfants($flux) {
	if ($flux['args']['objet'] == 'rubrique'
		and $id_rubrique = intval($flux['args']['id_objet'])
	) {
		// juste les publies ?
		if (array_key_exists('statut', $flux['args']) and ($flux['args']['statut'] == 'publie')) {
			$flux['data']['site'] = sql_countsel('spip_syndic',
				"id_rubrique=" . intval($id_rubrique) . " AND (statut='publie')");
		} else {
			$flux['data']['site'] = sql_countsel('spip_syndic',
				"id_rubrique=" . intval($id_rubrique) . " AND (statut='publie' OR statut='prop')");
		}
	}

	return $flux;
}


function sites_trig_propager_les_secteurs($flux) {
	// reparer les sites
	$r = sql_select("A.id_syndic AS id, R.id_secteur AS secteur", "spip_syndic AS A, spip_rubriques AS R",
		"A.id_rubrique = R.id_rubrique AND A.id_secteur <> R.id_secteur");
	while ($row = sql_fetch($r)) {
		sql_update("spip_syndic", array("id_secteur" => $row['secteur']), "id_syndic=" . $row['id']);
	}

	return $flux;
}

/**
 * Afficher le nombre de sites dans chaque rubrique
 *
 * @param array $flux
 * @return array
 */
function sites_boite_infos($flux) {
	if ($flux['args']['type'] == 'rubrique'
		and $id_rubrique = $flux['args']['id']
	) {
		if ($nb = sql_countsel('spip_syndic', "statut='publie' AND id_rubrique=" . intval($id_rubrique))) {
			$nb = "<div>" . singulier_ou_pluriel($nb, "sites:info_1_site", "sites:info_nb_sites") . "</div>";
			if ($p = strpos($flux['data'], "<!--nb_elements-->")) {
				$flux['data'] = substr_replace($flux['data'], $nb, $p, 0);
			}
		}
	}

	return $flux;
}
