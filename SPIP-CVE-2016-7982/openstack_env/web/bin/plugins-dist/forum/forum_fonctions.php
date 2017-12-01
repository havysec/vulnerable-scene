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
 * Définit les fonctions utiles du plugin forum
 *
 * @package SPIP\Forum\Fonctions
 **/

if (!defined("_ECRIRE_INC_VERSION")) {
	return;
}


include_spip('public/forum');

/**
 * Un filtre appliqué à `#PARAMETRES_FORUM`, qui donne l'adresse de la page
 * de réponse
 *
 * @example
 *     ```
 *     [<p class="repondre">
 *          <a href="(#PARAMETRES_FORUM|url_reponse_forum)">
 *          <:repondre_article:>
 *          </a>
 *      </p>]
 *      ```
 *
 * @filtre
 * @see balise_PARAMETRES_FORUM_dist()
 *
 * @param string $parametres
 * @return string URL de la page de réponse
 */
function filtre_url_reponse_forum($parametres) {
	if (!$parametres) {
		return '';
	}

	return generer_url_public('forum', $parametres);
}

/**
 * Un filtre qui, étant donné un `#PARAMETRES_FORUM`, retourne une URL de suivi rss
 * dudit forum
 *
 * Attention : appliqué à un `#PARAMETRES_FORUM` complexe (`id_article=x&id_forum=y`)
 * ça retourne une URL de suivi du thread `y` (que le thread existe ou non)
 *
 * @filtre
 * @see balise_PARAMETRES_FORUM_dist()
 *
 * @param string $param
 * @return string URL pour le suivi RSS
 */
function filtre_url_rss_forum($param) {
	if (!preg_match(',.*(id_(\w*?))=([0-9]+),S', $param, $regs)) {
		return '';
	}
	list(, $k, $t, $v) = $regs;
	if ($t == 'forum') {
		$k = 'id_' . ($t = 'thread');
	}

	return generer_url_public("rss_forum_$t", array($k => $v));
}

/**
 * Empêche l'exécution de code HTML
 *
 * Permet si la constante `_INTERDIRE_TEXTE_HTML`  est définie
 * (ce n'est pas le cas par défaut) d'échapper les balises HTML
 * d'un texte (de sorte qu'elles seront affichées et non traitées par
 * le navigateur).
 *
 * @see forum_declarer_tables_interfaces()
 *
 * @param string $texte
 * @return string
 **/
function interdit_html($texte) {
	if (defined('_INTERDIRE_TEXTE_HTML')) {
		$texte = str_replace("<", "&lt;", $texte);
	}

	return $texte;
}
