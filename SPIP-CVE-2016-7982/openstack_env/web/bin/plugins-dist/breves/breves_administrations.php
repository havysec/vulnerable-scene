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
 * Fichier gérant l'installation et désinstallation du plugin
 *
 * @package SPIP\Breves\Installation
 **/
if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}

/**
 * Installation/maj des tables de brèves
 *
 * Crée les tables SQL du plugin (spip_breves)
 *
 * @param string $nom_meta_base_version
 *     Nom de la meta informant de la version du schéma de données du plugin installé dans SPIP
 * @param string $version_cible
 *     Version du schéma de données dans ce plugin (déclaré dans paquet.xml)
 */
function breves_upgrade($nom_meta_base_version, $version_cible) {
	// cas particulier :
	// si plugin pas installe mais que la table existe
	// considerer que c'est un upgrade depuis v 1.0.0
	// pour gerer l'historique des installations SPIP <=2.1
	if (!isset($GLOBALS['meta'][$nom_meta_base_version])) {
		$trouver_table = charger_fonction('trouver_table', 'base');
		if ($desc = $trouver_table('spip_breves')
			and isset($desc['exist']) and $desc['exist']
		) {
			ecrire_meta($nom_meta_base_version, '1.0.0');
		}
		// si pas de table en base, on fera une simple creation de base
	}

	$maj = array();
	$maj['create'] = array(
		array('maj_tables', array('spip_breves')),
	);

	include_spip('base/upgrade');
	maj_plugin($nom_meta_base_version, $version_cible, $maj);
}


/**
 * Désinstallation du plugin
 *
 * Supprime les tables SQL du plugin (spip_breves)
 *
 * @param string $nom_meta_base_version
 *     Nom de la meta informant de la version du schéma de données du plugin installé dans SPIP
 **/
function breves_vider_tables($nom_meta_base_version) {
	sql_drop_table("spip_breves");

	effacer_meta("activer_breves");

	effacer_meta($nom_meta_base_version);
}
