<?php
/**
 * Gestion du formulaire de réinitialisation des messages de compagnon
 * validés (vus) par des auteurs.
 *
 * Ce formulaire permet d'effacer pour soi ou pour tous les auteurs
 * les messages qu'on a déjà vus. Du coup, ils seront de nouveaux
 * affichés sur les différentes pages.
 *
 * @package SPIP\Compagnon\Formulaires
 **/

if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}

/**
 * Chargement du formulaire de réinitialisation des messages du compagnon
 *
 * @return array
 *     Environnement du formulaire
 **/
function formulaires_reinitialiser_compagnon_charger() {
	return array('qui' => 'moi');
}

/**
 * Traitement du formulaire de réinitialisation des messages du compagnon
 *
 * @return array
 *     Retours du traitement
 **/
function formulaires_reinitialiser_compagnon_traiter() {
	$qui = _request('qui');
	include_spip('inc/config');
	if ($qui == 'moi') {
		effacer_config('compagnon/' . $GLOBALS['visiteur_session']['id_auteur']);
	}
	if ($qui == 'tous') {
		$config = lire_config('compagnon/config');
		effacer_config('compagnon');
		ecrire_config('compagnon/config', $config);
	}

	return array(
		'message_ok' => _T('compagnon:reinitialisation_ok')
	);
}
