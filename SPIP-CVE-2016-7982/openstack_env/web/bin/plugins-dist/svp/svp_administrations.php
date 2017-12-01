<?php

/**
 * Fichier gérant l'installation et désinstallation du plugin
 *
 * @plugin SVP pour SPIP
 * @license GPL
 * @package SPIP\SVP\Installation
 **/

include_spip('base/create');

/**
 * Installation et mises à jour du plugin
 *
 * Crée les tables SQL du plugin (spip_depots, spip_plugins, spip_depots_plugins, spip_paquets)
 *
 * @param string $nom_meta_base_version
 *     Nom de la meta informant de la version du schéma de données du plugin installé dans SPIP
 * @param string $version_cible
 *     Version du schéma de données dans ce plugin (déclaré dans paquet.xml)
 * @return void
 **/
function svp_upgrade($nom_meta_base_version, $version_cible) {

	$maj = array();

	$install = array('maj_tables', array('spip_depots', 'spip_plugins', 'spip_depots_plugins', 'spip_paquets'));
	$maj['create'][] = $install;
	$maj['0.2'][] = array('maj_tables', 'spip_paquets');
	$maj['0.3'][] = array('maj_tables', 'spip_paquets'); // prefixe et attente
	$maj['0.3'][] = array('svp_synchroniser_prefixe');
	include_spip('inc/svp_depoter_local');
	// on force le recalcul des infos des paquets locaux.
	$maj['0.3.1'][] = array('svp_actualiser_paquets_locaux', true);

	// autant mettre tout a jour pour avoir une base propre apres renommage extensions=> plugins_dist
	$maj['0.4.0'][] = array('svp_vider_tables', $nom_meta_base_version);
	$maj['0.4.0'][] = $install;
	// on force le recalcul des infos des paquets locaux.
	$maj['0.4.1'][] = array('svp_actualiser_paquets_locaux', true);
	// on force le recalcul des infos des paquets locaux.
	$maj['0.5.0'][] = array('maj_tables', 'spip_paquets');
	$maj['0.5.1'][] = array('svp_actualiser_paquets_locaux', true);

	include_spip('base/upgrade');
	maj_plugin($nom_meta_base_version, $version_cible, $maj);
}

/**
 * Désinstallation du plugin
 *
 * Supprime les tables SQL du plugin (spip_depots, spip_plugins, spip_depots_plugins, spip_paquets)
 *
 * @param string $nom_meta_base_version
 *     Nom de la meta informant de la version du schéma de données du plugin installé dans SPIP
 * @return void
 **/
function svp_vider_tables($nom_meta_base_version) {
	sql_drop_table("spip_depots");
	sql_drop_table("spip_plugins");
	sql_drop_table("spip_depots_plugins");
	sql_drop_table("spip_paquets");
	effacer_meta($nom_meta_base_version);

	spip_log('DESINSTALLATION BDD', 'svp_actions.' . _LOG_INFO);
}


/**
 * Ajoute le préfixe des plugins dans chaque ligne de paquets
 *
 * Cette mise à jour permet de dupliquer le préfixe des plugins
 * dans la ligne des paquets (cette colonne était absente avant)
 * pour plus de simplicité ensuite dans les requêtes SQL.
 */
function svp_synchroniser_prefixe() {
	$paquets = sql_allfetsel(
		array('pa.id_paquet', 'pl.prefixe'),
		array('spip_paquets AS pa', 'spip_plugins AS pl'),
		'pl.id_plugin=pa.id_plugin');

	if ($paquets) {
		// On insere, en encapsulant pour sqlite...
		if (sql_preferer_transaction()) {
			sql_demarrer_transaction();
		}

		foreach ($paquets as $paquet) {
			sql_updateq('spip_paquets',
				array('prefixe' => $paquet['prefixe']),
				'id_paquet=' . intval($paquet['id_paquet']));
		}

		if (sql_preferer_transaction()) {
			sql_terminer_transaction();
		}
	}
}
