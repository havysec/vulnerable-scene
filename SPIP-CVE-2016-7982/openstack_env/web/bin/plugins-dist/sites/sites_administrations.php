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
 * Installation/maj des tables syndic et syndic articles
 *
 * @param string $nom_meta_base_version
 * @param string $version_cible
 */
function sites_upgrade($nom_meta_base_version, $version_cible) {
	// cas particulier :
	// si plugin pas installe mais que la table existe
	// considerer que c'est un upgrade depuis v 1.0.0
	// pour gerer l'historique des installations SPIP <=2.1
	if (!isset($GLOBALS['meta'][$nom_meta_base_version])) {
		$trouver_table = charger_fonction('trouver_table', 'base');
		if ($desc = $trouver_table('spip_syndic')
			and isset($desc['exist']) and $desc['exist']
		) {
			ecrire_meta($nom_meta_base_version, '1.0.0');
		}
		// si pas de table en base, on fera une simple creation de base
	}

	$maj = array();
	$maj['create'] = array(
		array('maj_tables', array('spip_syndic', 'spip_syndic_articles')),
	);

	$maj['1.1.0'] = array(
		array('sql_alter', "TABLE spip_syndic_articles DROP key url"),
		array('sql_alter', "TABLE spip_syndic_articles CHANGE url url text DEFAULT '' NOT NULL"),
		array('sql_alter', "TABLE spip_syndic_articles ADD INDEX url(url(255))")
	);

	$maj['1.1.1'] = array(
		array('maj_tables', array('spip_syndic_articles')),
	);

	include_spip('base/upgrade');
	maj_plugin($nom_meta_base_version, $version_cible, $maj);
}


/**
 * Desinstallation/suppression des tables mots et groupes de mots
 *
 * @param string $nom_meta_base_version
 */
function sites_vider_tables($nom_meta_base_version) {
	sql_drop_table("spip_syndic");
	sql_drop_table("spip_syndic_articles");

	effacer_meta($nom_meta_base_version);
}
