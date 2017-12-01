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
 * Utilisations de pipelines
 *
 * @package SPIP\Breves\Pipelines
 **/
if (!defined("_ECRIRE_INC_VERSION")) {
	return;
}


/**
 * Définir les meta de configuration liées aux brèves
 *
 * @pipeline configurer_liste_metas
 * @param array $metas
 *     Couples nom de la méta => valeur par défaut
 * @return array
 *    Couples nom de la méta => valeur par défaut
 */
function breves_configurer_liste_metas($metas) {
	$metas['activer_breves'] = 'non';

	return $metas;
}

/**
 * Ajouter les brèves à valider sur les rubriques
 *
 * @pipeline rubrique_encours
 *
 * @param array $flux Données du pipeline
 * @return array       Données du pipeline
 **/
function breves_rubrique_encours($flux) {
	if ($flux['args']['type'] == 'rubrique') {
		$lister_objets = charger_fonction('lister_objets', 'inc');

		$id_rubrique = $flux['args']['id_objet'];

		//
		// Les breves a valider
		//
		$flux['data'] .= $lister_objets('breves', array(
			'titre' => _T('breves:info_breves_valider'),
			'statut' => array('prepa', 'prop'),
			'id_rubrique' => $id_rubrique,
			'par' => 'date_heure'
		));
	}

	return $flux;
}


/**
 * Ajouter les brèves référencées sur les vues de rubriques
 *
 * @pipeline affiche_enfants
 *
 * @param array $flux Données du pipeline
 * @return array       Données du pipeline
 **/
function breves_affiche_enfants($flux) {
	if (isset($flux['args']['exec'])
		and $e = trouver_objet_exec($flux['args']['exec'])
		and $e['type'] == 'rubrique'
		and $e['edition'] == false
	) {
		$id_rubrique = $flux['args']['id_rubrique'];

		if ($GLOBALS['meta']["activer_breves"] == 'oui') {
			$lister_objets = charger_fonction('lister_objets', 'inc');
			$bouton_breves = '';
			$id_parent = sql_getfetsel('id_parent', 'spip_rubriques', 'id_rubrique=' . $id_rubrique);
			if (autoriser('creerbrevedans', 'rubrique', $id_rubrique, null, array('id_parent' => $id_parent))) {
				$bouton_breves .= icone_verticale(_T('breves:icone_nouvelle_breve'),
						generer_url_ecrire("breve_edit", "id_rubrique=$id_rubrique&new=oui"), "breve-24.png", "new", 'right')
					. "<br class='nettoyeur' />";
			}

			$flux['data'] .= $lister_objets('breves', array(
				'titre' => _T('breves:icone_ecrire_nouvel_article'),
				'where' => "statut != 'prop' AND statut != 'prepa'",
				'id_rubrique' => $id_rubrique,
				'par' => 'date_heure'
			));
			$flux['data'] .= $bouton_breves;
		}
	}

	return $flux;
}


/**
 * Ajoute le nombre de brèves sur l'accueil privé
 *
 * @pipeline accueil_informations
 *
 * @param string $texte
 *     HTML des informations générales concernant chaque type d'objet
 *     sur la page d'accueil privée
 * @return string
 *     HTML des informations générales concernant chaque type d'objet
 *     sur la page d'accueil privée
 */
function breves_accueil_informations($texte) {
	include_spip('base/abstract_sql');

	$q = sql_select("COUNT(*) AS cnt, statut", 'spip_breves', '', 'statut', '', '', "COUNT(*)<>0");

	$cpt = array();
	$cpt2 = array();
	$where = false;
	if ($GLOBALS['visiteur_session']['statut'] == '0minirezo') {
		$where = sql_allfetsel('id_objet', 'spip_auteurs_liens',
			"objet='rubrique' AND id_auteur=" . intval($GLOBALS['visiteur_session']['id_auteur']));
		if ($where) {
			$where = sql_in('id_rubrique', array_map('reset', $where));
		}
	}
	$defaut = $where ? '0/' : '';
	while ($row = sql_fetch($q)) {
		$cpt[$row['statut']] = $row['cnt'];
		$cpt2[$row['statut']] = $defaut;
	}

	if ($cpt) {
		if ($where) {
			$q = sql_select("COUNT(*) AS cnt, statut", 'spip_breves', $where, "statut");
			while ($row = sql_fetch($q)) {
				$r = $row['statut'];
				$cpt2[$r] = intval($row['cnt']) . '/';
			}
		}
		$texte .= "<div class='accueil_informations breves liste'>";
		$texte .= "<h4>" . afficher_plus_info(generer_url_ecrire("breves"), "", _T('breves:info_breves_02')) . "</h4>";
		$texte .= "<ul class='liste-items'>";
		if (isset($cpt['prop'])) {
			$texte .= "<li class='item'>" . _T("texte_statut_attente_validation") . ": " . $cpt2['prop'] . $cpt['prop'] . '</li>';
		}
		if (isset($cpt['publie'])) {
			$texte .= "<li class='item on'>" . _T("texte_statut_publies") . ": " . $cpt2['publie'] . $cpt['publie'] . '</li>';
		}
		$texte .= "</ul>";
		$texte .= "</div>";
	}

	return $texte;
}


/**
 * Compter les brèves dans une rubrique
 *
 * @pipeline objet_compte_enfants
 *
 * @param array $flux Données du pipeline
 * @return array       Données du pipeline
 */
function breves_objet_compte_enfants($flux) {
	if ($flux['args']['objet'] == 'rubrique'
		and $id_rubrique = intval($flux['args']['id_objet'])
	) {
		// juste les publies ?
		if (array_key_exists('statut', $flux['args']) and ($flux['args']['statut'] == 'publie')) {
			$flux['data']['breve'] = sql_countsel('spip_breves',
				"id_rubrique=" . intval($id_rubrique) . " AND (statut='publie')");
		} else {
			$flux['data']['breve'] = sql_countsel('spip_breves',
				"id_rubrique=" . intval($id_rubrique) . " AND (statut='publie' OR statut='prop')");
		}
	}

	return $flux;
}


/**
 * Changer la langue des brèves si la rubrique change
 *
 * @pipeline trig_calculer_langues_rubriques
 *
 * @param array $flux Données du pipeline
 * @return array       Données du pipeline
 */
function breves_trig_calculer_langues_rubriques($flux) {

	$s = sql_select("A.id_breve AS id_breve, R.lang AS lang", "spip_breves AS A, spip_rubriques AS R",
		"A.id_rubrique = R.id_rubrique AND A.langue_choisie != 'oui' AND (A.lang='' OR R.lang<>'') AND R.lang<>A.lang");
	while ($row = sql_fetch($s)) {
		$id_breve = $row['id_breve'];
		sql_updateq('spip_breves', array("lang" => $row['lang'], 'langue_choisie' => 'non'), "id_breve=$id_breve");
	}

	return $flux;
}


/**
 * Publier et dater les rubriques qui ont une brève publiée
 *
 * @pipeline calculer_rubriques
 *
 * @param array $flux Données du pipeline
 * @return array       Données du pipeline
 */
function breves_calculer_rubriques($flux) {

	$r = sql_select(
		"R.id_rubrique AS id, max(A.date_heure) AS date_h",
		"spip_rubriques AS R JOIN spip_breves AS A ON R.id_rubrique = A.id_rubrique",
		"A.date_heure>R.date_tmp AND A.statut='publie' ", "R.id_rubrique");
	while ($row = sql_fetch($r)) {
		sql_updateq('spip_rubriques', array('statut_tmp' => 'publie', 'date_tmp' => $row['date_h']),
			"id_rubrique=" . $row['id']);
	}

	return $flux;
}


/**
 * Ajouter les brèves à valider sur la page d'accueil
 *
 * @pipeline accueil_encours
 *
 * @param string $flux HTML du bloc encours sur la page d'accueil privée
 * @return string       HTML du bloc encours sur la page d'accueil privée
 **/
function breves_accueil_encours($flux) {
	$lister_objets = charger_fonction('lister_objets', 'inc');


	$flux .= $lister_objets('breves', array(
		'titre' => afficher_plus_info(generer_url_ecrire('breves')) . _T('breves:info_breves_valider'),
		'statut' => array('prepa', 'prop'),
		'par' => 'date_heure'
	));

	return $flux;
}


/**
 * Optimiser la base de données en supprimant les liens de brèves orphelins
 *
 * @pipeline optimiser_base_disparus
 *
 * @param array $flux Données du pipeline
 * @return array       Données du pipeline
 */
function breves_optimiser_base_disparus($flux) {
	$n = &$flux['data'];
	$mydate = $flux['args']['date'];


	# les breves qui sont dans une id_rubrique inexistante
	$res = sql_select("B.id_breve AS id",
		"spip_breves AS B
		        LEFT JOIN spip_rubriques AS R
		          ON B.id_rubrique=R.id_rubrique",
		"R.id_rubrique IS NULL
		         AND B.maj < " . sql_quote($mydate));

	$n += optimiser_sansref('spip_breves', 'id_breve', $res);


	//
	// Breves
	//

	sql_delete("spip_breves", "statut='refuse' AND maj < $mydate");

	return $flux;

}

/**
 * Afficher le nombre de brèves dans chaque rubrique
 *
 * @pipeline boite_infos
 *
 * @param array $flux Données du pipeline
 * @return array       Données du pipeline
 */
function breves_boite_infos($flux) {
	if (
		isset($flux['args']['type']) and $flux['args']['type'] == 'rubrique'
		and isset($flux['args']['id']) and $id_rubrique = $flux['args']['id']
	) {
		if ($nb = sql_countsel('spip_breves', "statut='publie' AND id_rubrique=" . intval($id_rubrique))) {
			$nb = "<div>" . singulier_ou_pluriel($nb, "breves:info_1_breve", "breves:info_nb_breves") . "</div>";
			if ($p = strpos($flux['data'], "<!--nb_elements-->")) {
				$flux['data'] = substr_replace($flux['data'], $nb, $p, 0);
			}
		}
	}

	return $flux;
}

/**
 * Ajoute le formulaire de configuration des brèves sur la page de
 * configuration des contenus
 *
 * @pipeline affiche_milieu
 *
 * @param array $flux Données du pipeline
 * @return array       Données du pipeline
 */
function breves_affiche_milieu($flux) {
	if ($flux["args"]["exec"] == "configurer_contenu") {
		$flux["data"] .= recuperer_fond('prive/squelettes/inclure/configurer', array('configurer' => 'configurer_breves'));
	}

	return $flux;
}
