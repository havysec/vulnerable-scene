<?php

/**
 * Déclarations des configurations qui peuvent être sauvegardées
 *
 * @package SPIP\Mots\Pipelines
 **/
if (!defined("_ECRIRE_INC_VERSION")) {
	return;
}

/**
 * Ajoute les metas sauvegardables de Mots pour le plugin IEConfig
 *
 * @pipeline ieconfig_metas
 *
 * @param array $table
 *     Déclaration des sauvegardes
 * @return array
 *     Déclaration des sauvegardes complétées
 **/
function mots_ieconfig_metas($table) {
	$table['mots']['titre'] = _T('mots:info_mots_cles');
	$table['mots']['icone'] = 'mot-16.png';
	$table['mots']['metas_brutes'] = 'articles_mots,config_precise_groupes,mots_cles_forums';

	return $table;
}
