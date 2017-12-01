<?php

/**
 * Déclarations d'autorisations et utilisations de pipelines
 *
 * @plugin Statistiques pour SPIP
 * @license GNU/GPL
 * @package SPIP\Stats\Pipelines
 **/

if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}


/**
 * Compter les visites sur les pages HTML
 *
 * Uniquement si les statistiques sont activées dans la configuration :
 * - permet de compter par défaut toutes les pages de type HTML
 * - sauf si on explicite, pour une page donnée, l'entête
 *   header `X-Spip-Visites` à `oui` ou `non`.
 *   Indiquer `oui` pour forcer le comptage de la page, ou `non` pour au contraire l'éviter
 *
 * @uses public_stats_dist() si la page doit être comptée.
 * @pipeline affichage_entetes_final
 * @param array $entetes liste des entêtes de la page
 * @return array
 **/
function stats_affichage_entetes_final($entetes) {
	if (isset($GLOBALS['meta']["activer_statistiques"]) and $GLOBALS['meta']["activer_statistiques"] != "non") {
		$html = preg_match(',^\s*text/html,', $entetes['Content-Type']);

		// decomptage des visites, on peut forcer a oui ou non avec le header X-Spip-Visites
		// par defaut on ne compte que les pages en html (ce qui exclue les js,css et flux rss)
		$spip_compter_visites = $html ? 'oui' : 'non';
		if (isset($entetes['X-Spip-Visites'])) {
			$spip_compter_visites = in_array($entetes['X-Spip-Visites'], array('oui', 'non'))
				? $entetes['X-Spip-Visites']
				: $spip_compter_visites;
			unset($entetes['X-Spip-Visites']);
		}

		// Gestion des statistiques du site public
		if ($spip_compter_visites != 'non') {
			$stats = charger_fonction('stats', 'public');
			$stats();
		}
	}

	return $entetes;
}


/**
 * Compléter des pages de l'espace privé
 *
 * - Ajoute les formulaire de configuration des statistiques dans les configurations avancées
 * - Ajoute les formulaire de suppression des statistiques dans la maintenance technique
 *
 * @pipeline affiche_milieu
 * @param array $flux Données du pipeline
 * @return array       Données du pipeline
 **/
function stats_affiche_milieu($flux) {
	// afficher le formulaire de configuration (activer ou desactiver les statistiques).
	if ($flux['args']['exec'] == 'configurer_avancees') {
		$flux['data'] .= recuperer_fond('prive/squelettes/inclure/configurer',
			array('configurer' => 'configurer_compteur'));
	}

	// afficher le formulaire de suppression des visites (configuration > maintenance du site).
	if ($flux['args']['exec'] == 'admin_tech') {
		$flux['data'] .= recuperer_fond('prive/squelettes/inclure/admin_effacer_stats', array());
	}

	return $flux;
}


/**
 * Ajoute les boutons d'administration indiquant la popularité et les visites d'un objet
 *
 * @uses admin_stats()
 * @pipeline formulaire_admin
 * @param array $flux Données du pipeline
 * @return array       Données du pipeline
 **/
function stats_formulaire_admin($flux) {
	if (
		isset($flux['args']['contexte']['objet'])
		and $objet = $flux['args']['contexte']['objet']
		and isset($flux['args']['contexte']['id_objet'])
		and $id_objet = $flux['args']['contexte']['id_objet']
	) {
		if ($l = admin_stats($objet, $id_objet, defined('_VAR_PREVIEW') ? _VAR_PREVIEW : '')) {
			$btn = recuperer_fond('prive/bouton/statistiques', array(
				'visites' => $l[0],
				'popularite' => $l[1],
				'statistiques' => $l[2],
			));
			$flux['data'] = preg_replace('%(<!--extra-->)%is', $btn . '$1', $flux['data']);
		}
	}

	return $flux;
}

/**
 * Calcule les visites et popularite d'un objet éditorial
 *
 * @note
 *     Actuellement uniquement valable pour les articles.
 *
 * @param string $objet
 * @param int $id_objet
 * @param string $var_preview
 *     Indique si on est en prévisualisation : pas de statistiques dans ce cas.
 * @return false|array
 *     - false : pas de statistiques disponibles
 *     - array : Tableau les stats `[visites, popularité, url]`
 **/
function admin_stats($objet, $id_objet, $var_preview = "") {
	if ($GLOBALS['meta']["activer_statistiques"] != "non"
		and $objet == 'article'
		and !$var_preview
		and autoriser('voirstats')
	) {
		$row = sql_fetsel("visites, popularite", "spip_articles", "id_article=$id_objet AND statut='publie'");

		if ($row) {
			return array(
				intval($row['visites']),
				ceil($row['popularite']),
				str_replace('&amp;', '&', generer_url_ecrire_statistiques($id_objet))
			);
		}
	}

	return false;
}

/**
 * Génère URL de la page dans l'espace privé permettant de visualiser les statistiques d'un article
 *
 * @param int $id_article
 * @return string URL
 **/
function generer_url_ecrire_statistiques($id_article) {
	return generer_url_ecrire('stats_visites', "id_article=$id_article");
}


/**
 * Ajoute le cron de traitement des statistiques et calcul des popularités
 *
 * @pipeline taches_generales_cron
 * @param array $taches_generales
 *     Tableau `[nom de la tache => intervalle en secondes]`
 * @return array
 *     Tableau `[nom de la tache => intervalle en secondes]`
 **/
function stats_taches_generales_cron($taches_generales) {

	// stats : toutes les 5 minutes on peut vider un panier de visites
	if (isset($GLOBALS['meta']["activer_statistiques"])
		and $GLOBALS['meta']["activer_statistiques"] == "oui"
	) {
		$taches_generales['visites'] = 300;
		$taches_generales['popularites'] = 7200; # calcul lourd
	}

	return $taches_generales;
}

/**
 * Lister les metas de statistiques et leurs valeurs par défaut
 *
 * @pipeline configurer_liste_metas
 * @param array $metas
 *     Couples nom de la méta => valeur par défaut
 * @return array
 *    Couples nom de la méta => valeur par défaut
 */
function stats_configurer_liste_metas($metas) {
	$metas['activer_statistiques'] = 'non';
	$metas['activer_captures_referers'] = 'non';
	$metas['activer_referers']='oui';

	return $metas;
}

/**
 * Afficher le lien vers la page de statistique sur la vue d'un article dans l'espace privé
 *
 * @pipeline boite_infos
 * @param array $flux Données du pipeline
 * @return array       Données du pipeline
 */
function stats_boite_infos($flux) {
	if ($GLOBALS['meta']["activer_statistiques"] == "oui") {
		if ($flux['args']['type'] == 'article'
			and $id_article = $flux['args']['id']
			and autoriser('voirstats', 'article', $id_article)
		) {
			$visites = sql_getfetsel('visites', 'spip_articles', 'id_article=' . intval($id_article));
			if ($visites > 0) {
				$icone_horizontale = chercher_filtre('icone_horizontale');
				$flux['data'] .= $icone_horizontale(generer_url_ecrire("stats_visites", "id_article=$id_article"),
					_T('statistiques:icone_evolution_visites', array('visites' => $visites)), "statistique-24.png");
			}
		}
	}

	return $flux;
}
