<?php

/**
 * Enregistrer les config avec le plugin IEConfig
 *
 * @package SPIP\Revisions\Pipelines
 **/
if (!defined("_ECRIRE_INC_VERSION")) {
	return;
}

/**
 * Ajoute les éléments de config des révisions pour les sauvegardes de IEConfig
 *
 * @pipeline ieconfig_metas
 * @param array $table Description des configurations
 * @return array        Description des configurations
 **/
function revisions_ieconfig_metas($table) {
	$table['revisions']['titre'] = _T('revisions:titre_revisions');
	$table['revisions']['icone'] = 'revision-16.png';
	$table['revisions']['metas_serialize'] = 'objets_versions';

	return $table;
}
