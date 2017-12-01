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
 * Fonctions et filtres du compresseur
 *
 * @package SPIP\Compresseur\Pipelines
 */
if (!defined("_ECRIRE_INC_VERSION")) {
	return;
}

/**
 * Compression des JS et CSS de l'espace privé
 *
 * @pipeline header_prive
 * @see compacte_head()
 *
 * @param string $flux
 *     Partie de contenu du head HTML de l'espace privé
 * @return string
 *     Partie de contenu du head HTML de l'espace privé
 */
function compresseur_header_prive($flux) {
	include_spip('compresseur_fonctions');

	return compacte_head($flux);
}


/**
 * Compression des JS et CSS de l'espace public
 *
 * Injecter l'appel au compresseur sous la forme de filtre
 * pour intervenir sur l'ensemble du head du squelette public
 *
 * @pipeline insert_head
 * @see compacte_head()
 *
 * @param string $flux
 *     Partie de contenu du head HTML de l'espace public
 * @return string
 *     Partie de contenu du head HTML de l'espace public
 */
function compresseur_insert_head($flux) {
	$flux .= '<'
		. '?php header("X-Spip-Filtre: '
		. 'compacte_head'
		. '"); ?' . '>';

	return $flux;
}

/**
 * Afficher le formulaire de configuration sur la page de configurations avancées
 *
 * @pipeline affiche_milieu
 *
 * @param string $flux Données du pipeline
 * @return string       Données du pipeline
 */
function compresseur_affiche_milieu($flux) {

	if ($flux['args']['exec'] == 'configurer_avancees') {
		// Compression http et compactages CSS ou JS
		$flux['data'] .= recuperer_fond('prive/squelettes/inclure/configurer',
			array('configurer' => 'configurer_compresseur'));
	}

	return $flux;
}


/**
 * Lister les metas du compresseur et leurs valeurs par défaut
 *
 * @pipeline configurer_liste_metas
 * @param array $metas
 *     Couples nom de la méta => valeur par défaut
 * @return array
 *    Couples nom de la méta => valeur par défaut
 */
function compresseur_configurer_liste_metas($metas) {
	$metas['auto_compress_js'] = 'non';
	$metas['auto_compress_closure'] = 'non';
	$metas['auto_compress_css'] = 'non';
	$metas['url_statique_ressources'] = '';

	return $metas;
}
