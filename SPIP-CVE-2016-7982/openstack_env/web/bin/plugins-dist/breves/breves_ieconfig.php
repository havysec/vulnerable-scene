<?php

/**
 * Déclarations des configurations qui peuvent être sauvegardées
 *
 * @package SPIP\Breves\Pipelines
 **/

if (!defined("_ECRIRE_INC_VERSION")) {
	return;
}

/**
 * Ajoute les metas sauvegardables de Brèves pour le plugin IEConfig
 *
 * @pipeline ieconfig_metas
 *
 * @param array $table
 *     Déclaration des sauvegardes
 * @return array
 *     Déclaration des sauvegardes complétées
 **/
function breves_ieconfig_metas($table) {
	$table['breves']['titre'] = _T('breves:titre_breves');
	$table['breves']['icone'] = 'breve-16.png';
	$table['breves']['metas_brutes'] = 'activer_breves';

	return $table;
}
