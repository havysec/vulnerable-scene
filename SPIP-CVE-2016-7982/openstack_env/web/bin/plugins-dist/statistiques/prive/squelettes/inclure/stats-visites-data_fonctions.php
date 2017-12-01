<?php

if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}

include_spip('inc/acces');
include_spip('inc/statistiques');

function duree_affiche($duree, $periode) {
	if (intval($duree) AND $duree>0) {
		return $duree;
	}
	if ($periode == 'mois' OR $duree<0) {
		$debut = sql_getfetsel("date", "spip_visites", "", "", "date", "0,1");
		$debut = strtotime($debut);
		$duree = ceil((time() - $debut) / 24 / 3600);

		return $duree;
	}


	// par defaut 90 jours
	return 90;
}

function duree_zoom($duree, $sens = 'plus') {
	$largeur_abs = 420 / $duree;

	if ($largeur_abs > 1) {
		$inc = ceil($largeur_abs / 5);
		$duree_plus = round(420 / ($largeur_abs - $inc));
		$duree_moins = round(420 / ($largeur_abs + $inc));
	}

	if ($largeur_abs == 1) {
		$duree_plus = 840;
		$duree_moins = 210;
	}

	if ($largeur_abs < 1) {
		$duree_plus = round(420 * ((1 / $largeur_abs) + 1));
		$duree_moins = round(420 * ((1 / $largeur_abs) - 1));
	}

	return ($sens == 'plus' ? $duree_moins : $duree_plus);
}

function stats_total($serveur = '') {
	$row = sql_fetsel("SUM(visites) AS total_absolu", "spip_visites", '', '', '', '', '', $serveur);

	return $row ? $row['total_absolu'] : 0;
}
