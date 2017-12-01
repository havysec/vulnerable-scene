<?php

/**
 * Fichier gérant l'installation et désinstallation du plugin
 *
 * @package SPIP\Compagnon\Installation
 **/

if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}

/**
 * Installation et mises à jour du plugin
 *
 * Active par défaut le compagnon s'il n'y a aucune rubrique dans le site.
 *
 * @param string $nom_meta_base_version
 *     Nom de la meta informant de la version du schéma de données du plugin installé dans SPIP
 * @param string $version_cible
 *     Version du schéma de données dans ce plugin (déclaré dans paquet.xml)
 * @return void
 **/
function compagnon_upgrade($nom_meta_base_version, $version_cible) {

	$maj = array();
	$maj['create'] = array(
		array('compagnon_create')
	);
	include_spip('base/upgrade');
	maj_plugin($nom_meta_base_version, $version_cible, $maj);
}

/**
 * Déclare la configuration du compagnon
 *
 * Si aucune rubrique n'est présente, active le compagnon, sinon non.
 **/
function compagnon_create() {
	include_spip('inc/config');
	if (sql_getfetsel('id_rubrique', 'spip_rubriques', '', '', '', '0,1')) {
		ecrire_config('compagnon/config/activer', 'non');
	} else {
		ecrire_config('compagnon/config/activer', 'oui');
	}
}

/**
 * Désinstallation du plugin
 *
 * Efface les informations du compagnon
 *
 * @param string $nom_meta_base_version
 *     Nom de la meta informant de la version du schéma de données du plugin installé dans SPIP
 * @return void
 **/
function compagnon_vider_tables($nom_meta_base_version) {
	effacer_meta("compagnon");
	effacer_meta($nom_meta_base_version);
}
