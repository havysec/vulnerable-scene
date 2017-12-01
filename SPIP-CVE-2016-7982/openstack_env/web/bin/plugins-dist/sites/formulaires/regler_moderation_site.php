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
 * Gestion du formulaire de réglage de la modération d'un site
 *
 * @package SPIP\Sites\Formulaires
 **/

if (!defined("_ECRIRE_INC_VERSION")) {
	return;
}

include_spip('inc/actions');
include_spip('inc/editer');


/**
 * Chargement du formulaire de réglage de la modération d'un site
 *
 * @uses formulaires_editer_objet_charger()
 *
 * @param int $id_syndic
 *     Identifiant du site.
 * @param string $retour
 *     URL de redirection après le traitement
 * @return array
 *     Environnement du formulaire
 **/
function formulaires_regler_moderation_site_charger_dist($id_syndic, $retour = '') {
	$valeurs = formulaires_editer_objet_charger('site', $id_syndic, 0, 0, $retour, '');
	# pour recuperer le logo issu d'analyse auto
	foreach (array('moderation', 'miroir', 'oubli', 'resume') as $k) {
		if (!$valeurs[$k]) {
			$valeurs[$k] = 'non';
		}
	}

	return $valeurs;
}

/**
 * Identifier le formulaire en faisant abstraction des paramètres qui
 * ne représentent pas l'objet edité
 *
 * @param int $id_syndic
 *     Identifiant du site
 * @param string $retour
 *     URL de redirection après le traitement
 * @return string
 *     Hash du formulaire
 */
function formulaires_regler_moderation_site_identifier_dist($id_syndic, $retour = '') {
	return serialize(array($id_syndic));
}

/**
 * Vérifications du formulaire de réglage de la modération d'un site
 *
 * @param int $id_syndic
 *     Identifiant du site.
 * @param string $retour
 *     URL de redirection après le traitement
 * @return array
 *     Erreurs du formulaire
 **/
function formulaires_regler_moderation_site_verifier_dist($id_syndic, $retour = '') {
	$erreurs = array();

	foreach (array('moderation', 'miroir', 'oubli', 'resume') as $k) {
		if (!_request($k) or !in_array(_request($k), array('oui', 'non'))) {
			set_request($k, 'non');
		}
	}

	return $erreurs;
}

/**
 * Traitements du formulaire de réglage de la modération d'un site
 *
 * @uses formulaires_editer_objet_traiter()
 *
 * @param int $id_syndic
 *     Identifiant du site.
 * @param string $retour
 *     URL de redirection après le traitement
 * @return array
 *     Retours des traitements
 **/
function formulaires_regler_moderation_site_traiter_dist($id_syndic, $retour = '') {
	$res = formulaires_editer_objet_traiter('site', $id_syndic, 0, 0, $retour, '');
	$res['editable'] = true;
	if (!isset($res['message_erreur'])) {
		$res['message_ok'] = _T('config_info_enregistree');
	}

	return $res;
}
