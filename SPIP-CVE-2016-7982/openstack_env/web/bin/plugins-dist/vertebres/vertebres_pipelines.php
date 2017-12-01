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
 * Utilisations de pipelines
 *
 * @package SPIP\Vertebres\Pipelines
 **/

if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}

if (!defined('_DIR_VERTEBRES')) {
	/**
	 * Chemin du répertoire stockant les squelettes calculés des vertèbres
	 *
	 * @var string
	 **/
	define('_DIR_VERTEBRES', _DIR_CACHE . 'vertebres/');
}

/**
 * Déterminer l'utilisation du vertebreur
 *
 * Lorsqu'on inclut le squelette `prive/vertebres:$table`,
 * vérifier l'autorisation et créer le squelette spécifique
 * à la table demandée si on la trouve
 *
 * @pipeline styliser
 * @uses base_trouver_table_dist()
 * @uses public_vertebrer_dist()
 *
 * @param array $flux Données du pipeline
 * @return array Données du pipeline
 */
function vertebres_styliser($flux) {

	// si pas de squelette trouve,
	// on verifie si on demande une vue de table
	if (!$squelette = $flux['data']
		and $fond = $flux['args']['fond']
		and strncmp($fond, 'prive/vertebres:', 16) == 0
		and $table = substr($fond, 16)
		and include_spip('inc/autoriser')
		and autoriser('webmestre')
	) {

		$ext = $flux['args']['ext'];
		$connect = $flux['args']['connect'];

		// Si pas de squelette regarder si c'est une table
		// et si l'on a la permission de l'afficher
		$trouver_table = charger_fonction('trouver_table', 'base');
		if ($desc = $trouver_table($table, $connect)) {
			$fond = $table;
			$base = _DIR_VERTEBRES . 'table_' . $fond . ".$ext";
			if (!file_exists($base) or (defined('_VAR_MODE') and _VAR_MODE)) {
				sous_repertoire(_DIR_VERTEBRES);
				$vertebrer = charger_fonction('vertebrer', 'public');
				ecrire_fichier($base, $vertebrer($desc));
			}

			// sauver les changements
			$flux['data'] = _DIR_VERTEBRES . 'table_' . $fond;
		}
	}

	return $flux;
}
