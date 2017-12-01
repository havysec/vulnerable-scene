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

include_spip('inc/dump');

/**
 * Afficher les erreurs survenues dans la restauration
 *
 * @param string $status_file Nom du fichier qui contient le statut de la restauration sous une forme serialisee
 * @return string               Code HTML a afficher
 */
function dump_afficher_tables_restaurees_erreurs($status_file) {
	$status = dump_lire_status($status_file);
	$tables = $status['tables_copiees'];

	$corps = "";
	$erreurs = array();

	if (!$tables) {
		return "<p>" . _T("dump:erreur_aucune_donnee_restauree") . "</p>";
	}

	// lister les tables copiees aller verifier dans la base
	// qu'on a le bon nombre de donnees
	foreach ($tables as $t => $n) {
		if (!sql_showtable($t, true) or $n === 0) {
			$erreurs[$t] = _T('dump:erreur_table_absente', array('table' => "<strong>$t</strong>"));
		} else {
			$n = abs(intval($n));
			$n_dump = intval(sql_countsel($t));
			if ($n_dump < $n) {
				$erreurs[$t] = _T('dump:erreur_table_donnees_manquantes', array('table' => "<strong>$t</strong>"));
			};
		}
	}

	if (count($erreurs)) {
		$corps = "<ul class='spip'><li>" . implode("</li><li class='spip'>", $erreurs) . "</li></ul>";
	}

	return $corps;
}
