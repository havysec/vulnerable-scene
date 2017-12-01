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
 * Fichier gérant l'installation et désinstallation du plugin Statistiques
 *
 * @plugin Statistiques pour SPIP
 * @license GNU/GPL
 * @package SPIP\Stats\Pipelines
 **/

if (!defined("_ECRIRE_INC_VERSION")) {
	return;
}

/**
 * Installation et mises à jour du plugin
 *
 * @param string $nom_meta_base_version
 *     Nom de la meta informant de la version du schéma de données du plugin installé dans SPIP
 * @param string $version_cible
 *     Version du schéma de données dans ce plugin (déclaré dans paquet.xml)
 * @return void
 **/
function stats_upgrade($nom_meta_base_version, $version_cible) {
	// cas particulier :
	// si plugin pas installe mais que la table existe
	// considerer que c'est un upgrade depuis v 1.0.0
	// pour gerer l'historique des installations SPIP <=2.1
	if (!isset($GLOBALS['meta'][$nom_meta_base_version])) {
		$trouver_table = charger_fonction('trouver_table', 'base');
		if ($desc = $trouver_table('spip_visites')
			and isset($desc['exist']) and $desc['exist']
		) {
			ecrire_meta($nom_meta_base_version, '1.0.0');
		}
		// si pas de table en base, on fera une simple creation de base
	}

	$maj = array();
	$maj['create'] = array(
		array('maj_tables', array('spip_visites', 'spip_visites_articles', 'spip_referers', 'spip_referers_articles')),
	);
	$maj['1.0.0'] = array();
	$maj['1.0.1'] = array(
		array('ecrire_meta','activer_referers', 'oui'),
	);


	include_spip('base/upgrade');
	maj_plugin($nom_meta_base_version, $version_cible, $maj);

}


/**
 * Désinstallation du plugin
 *
 * @param string $nom_meta_base_version
 *     Nom de la meta informant de la version du schéma de données du plugin installé dans SPIP
 * @return void
 **/
function stats_vider_tables($nom_meta_base_version) {
	sql_drop_table("spip_visites");
	sql_drop_table("spip_visites_articles");
	sql_drop_table("spip_referers");
	sql_drop_table("spip_referers_articles");

	effacer_meta("activer_statistiques");
	effacer_meta("activer_captures_referers");

	effacer_meta($nom_meta_base_version);
}
