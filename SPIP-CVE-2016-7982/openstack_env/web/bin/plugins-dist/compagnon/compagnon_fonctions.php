<?php

/**
 * Fonctions pour les squelettes
 *
 * @package SPIP\Compagnon\Fonctions
 **/

if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}


/**
 * Retourne un court texte de compréhension
 * aléatoirement parmi une liste.
 *
 * @example
 *     [(#VAL|ok_aleatoire)]
 *
 * @return string
 *     Le texte traduit.
 **/
function filtre_ok_aleatoire_dist() {
	$alea = array(
		'compagnon:ok',
		'compagnon:ok_jai_compris',
		'compagnon:ok_bien',
		'compagnon:ok_merci',
		'compagnon:ok_parfait',
	);

	return _T($alea[array_rand($alea)]);
}
