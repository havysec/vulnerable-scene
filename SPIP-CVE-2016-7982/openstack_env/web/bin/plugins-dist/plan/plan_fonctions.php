<?php
/**
 * Fonctions pour le plugin Plan du site dans l’espace privé
 *
 * @plugin     Plan du site dans l’espace privé
 * @copyright  2015
 * @author     Matthieu Marcillaud
 * @licence    GNU/GPL
 * @package    SPIP\Plan\Fonctions
 */

if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}

/**
 * Retourne le nombre d'éléments d'une liste d'objet qui fait qu'on
 * n'affiche pas le contenu par défaut, mais seulement en ajax
 * après clic…
 *
 * @return int nombre
 **/
function plan_limiter_listes() {
	return defined('_PLAN_LIMITER_LISTES') ? _PLAN_LIMITER_LISTES : 50;
}


/**
 * Compile la balise `#PLAN_AFFICHER_LISTE` qui, dans une boucle listant un objet
 * permet de savoir si on doit afficher la liste complète.
 *
 * Cela dépend de la variable d'environnement 'lister' et du nombre d'éléments dans la liste :
 * - si lister = tout, retourne vrai
 * - si le nombre d'élément ne dépasse pas _PLAN_LIMITER_LISTES, retourne vrai,
 * - sinon retourne faux.
 *
 * @param Pile $p
 * @return Pile
 **/
function balise_PLAN_AFFICHER_LISTE_dist($p) {

	// #GRAND_TOTAL
	$grand_total = charger_fonction('GRAND_TOTAL', 'balise');
	$p = $grand_total($p);
	$grand_total = $p->code;

	// #ENV{lister}
	$lister = "(isset(\$Pile[0]['lister']) ? \$Pile[0]['lister'] : '')";

	$p->code = "(($lister == 'tout') OR ($grand_total <= plan_limiter_listes()))";

	return $p;
}

/**
 * Trouve les objets qui peuvent s'afficher dans le plan de page, dans une rubrique
 *
 * @return array [table -> chemin du squelette]
 **/
function plan_lister_objets_rubrique() {
	static $liste = null;
	if (is_null($liste)) {
		$liste = array();
		$tables = lister_tables_objets_sql();
		unset($tables['spip_rubriques']);
		foreach ($tables as $cle => $desc) {
			if (isset($desc['field']['id_rubrique'])) {
				if (trouver_fond('prive/squelettes/inclure/plan-' . $desc['table_objet'])) {
					$liste[$cle] = $desc['table_objet'];
				}
			}
		}
	}

	return $liste;
}

/**
 * Trouve les objets qui peuvent s'afficher dans le plan de page,
 * dans une rubrique ainsi que leurs statuts éventuels
 *
 * @note
 *     Tous les statuts sont ici retournés, même ceux que ne peuvent pas
 *     forcément utiliser l'auteur en cours.
 *
 * @see  plan_lister_objets_rubrique_statuts_auteur()
 * @uses plan_lister_objets_rubrique()
 *
 * @return array
 **/
function plan_lister_objets_rubrique_statuts() {
	static $liste = null;
	if (is_null($liste)) {
		$objets = plan_lister_objets_rubrique();
		include_spip('inc/puce_statut');
		$liste = array();
		foreach ($objets as $table => $null) {
			$desc = lister_tables_objets_sql($table);
			// l'objet possède un statut
			if (!empty($desc['statut_textes_instituer'])) {
				$statuts = array_keys($desc['statut_textes_instituer']);
				$objet = $desc['table_objet'];
				// obtenir titre et image du statut
				$_statuts = array();
				foreach ($statuts as $statut) {
					$_statuts[$statut] = array(
						'image' => statut_image($objet, $statut),
						'titre' => statut_titre($objet, $statut),
					);
				}
				$liste[$objet] = $_statuts;
			}
		}
	}

	return $liste;
}


/**
 * Trouve les objets qui peuvent s'afficher dans le plan de page,
 * dans une rubrique ainsi que leurs statuts utilisables pour l'auteur en cours
 *
 * @uses plan_lister_objets_rubrique_statuts()
 *
 * @return array
 **/
function plan_lister_objets_rubrique_statuts_auteur() {
	static $liste = null;
	if (is_null($liste)) {
		$liste = plan_lister_objets_rubrique_statuts();
		include_spip('inc/session');
		foreach ($liste as $objet => $statuts) {
			if ($objet == 'articles') {
				$autorises = statuts_articles_visibles(session_get('statut'));
				$statuts = array_intersect_key($statuts, array_flip($autorises));
				$liste[$objet] = $statuts;
			}
		}
	}

	return $liste;
}
