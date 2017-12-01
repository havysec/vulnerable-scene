<?php

/**
 * Déclarations des configurations qui peuvent être sauvegardées
 *
 * @plugin Statistiques pour SPIP
 * @license GNU/GPL
 * @package SPIP\Stats\Pipelines
 **/

if (!defined("_ECRIRE_INC_VERSION")) {
	return;
}

/**
 * Ajoute les metas sauvegardables de Statistiques pour le plugin IEConfig
 *
 * @pipeline ieconfig_metas
 *
 * @param array $table
 *     Déclaration des sauvegardes
 * @return array
 *     Déclaration des sauvegardes complétées
 **/
function stats_ieconfig_metas($table) {
	$table['statistiques']['titre'] = _T('statistiques:info_forum_statistiques');
	$table['statistiques']['icone'] = 'statistique-16.png';
	$table['statistiques']['metas_brutes'] = 'activer_statistiques,activer_captures_referers';

	return $table;
}
