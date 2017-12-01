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
 * Gestion du formulaire de d'édition d'un groupe de mots
 *
 * @package SPIP\Mots\Formulaires
 **/
if (!defined("_ECRIRE_INC_VERSION")) {
	return;
}

include_spip('inc/actions');
include_spip('inc/editer');

/**
 * Chargement du formulaire d'édition d'un groupe de mots
 *
 * @param int|string $id_groupe
 *     Identifiant du groupe de mots. 'new' pour un nouveau groupe.
 * @param string $retour
 *     URL de redirection après le traitement
 * @param string $config_fonc
 *     Nom de la fonction ajoutant des configurations particulières au formulaire
 * @param array $row
 *     Valeurs de la ligne SQL du groupe de mot, si connu
 * @param string $hidden
 *     Contenu HTML ajouté en même temps que les champs cachés du formulaire.
 * @return array
 *     Environnement du formulaire
 **/
function formulaires_editer_groupe_mot_charger_dist(
	$id_groupe = 'new',
	$retour = '',
	$config_fonc = 'groupes_mots_edit_config',
	$row = array(),
	$hidden = ''
) {
	$valeurs = formulaires_editer_objet_charger('groupe_mots', $id_groupe, 0, '', $retour, $config_fonc, $row, $hidden);

	$valeurs['tables_liees'] = explode(',', $valeurs['tables_liees']);

	// par defaut a la creation de groupe
	if (!intval($id_groupe)) {
		$valeurs['tables_liees'] = array('articles');
		$valeurs['minirezo'] = 'oui';
		$valeurs['comite'] = 'oui';
	}

	return $valeurs;
}

/**
 * Identifier le formulaire en faisant abstraction des paramètres qui
 * ne representent pas l'objet édité
 *
 * @param int|string $id_groupe
 *     Identifiant du groupe de mots. 'new' pour un nouveau groupe.
 * @param string $retour
 *     URL de redirection après le traitement
 * @param string $config_fonc
 *     Nom de la fonction ajoutant des configurations particulières au formulaire
 * @param array $row
 *     Valeurs de la ligne SQL du groupe de mot, si connu
 * @param string $hidden
 *     Contenu HTML ajouté en même temps que les champs cachés du formulaire.
 * @return string
 *     Hash du formulaire
 */
function formulaires_editer_groupe_mot_identifier_dist(
	$id_groupe = 'new',
	$retour = '',
	$config_fonc = 'groupes_mots_edit_config',
	$row = array(),
	$hidden = ''
) {
	return serialize(array(intval($id_groupe)));
}

/**
 * Choix par défaut des options de présentation
 *
 * @param array $row
 *     Valeurs de la ligne SQL du groupe de mot, si connu
 * return array
 *     Configuration pour le formulaire
 */
function groupes_mots_edit_config($row) {
	global $spip_ecran, $spip_lang;

	$config = $GLOBALS['meta'];
	$config['lignes'] = ($spip_ecran == "large") ? 8 : 5;
	$config['langue'] = $spip_lang;

	return $config;
}

/**
 * Vérification du formulaire d'édition d'un groupe de mots
 *
 * @param int|string $id_groupe
 *     Identifiant du groupe de mots. 'new' pour un nouveau groupe.
 * @param string $retour
 *     URL de redirection après le traitement
 * @param string $config_fonc
 *     Nom de la fonction ajoutant des configurations particulières au formulaire
 * @param array $row
 *     Valeurs de la ligne SQL du groupe de mot, si connu
 * @param string $hidden
 *     Contenu HTML ajouté en même temps que les champs cachés du formulaire.
 * @return array
 *     Tableau des erreurs
 **/
function formulaires_editer_groupe_mot_verifier_dist(
	$id_groupe = 'new',
	$retour = '',
	$config_fonc = 'groupes_mots_edit_config',
	$row = array(),
	$hidden = ''
) {

	$erreurs = formulaires_editer_objet_verifier('groupe_mots', 0, array('titre'));

	return $erreurs;
}

/**
 * Traitement du formulaire d'édition d'un groupe de mots
 *
 * @param int|string $id_groupe
 *     Identifiant du groupe de mots. 'new' pour un nouveau groupe.
 * @param string $retour
 *     URL de redirection après le traitement
 * @param string $config_fonc
 *     Nom de la fonction ajoutant des configurations particulières au formulaire
 * @param array $row
 *     Valeurs de la ligne SQL du groupe de mot, si connu
 * @param string $hidden
 *     Contenu HTML ajouté en même temps que les champs cachés du formulaire.
 * @return array
 *     Retour des traitements
 **/
function formulaires_editer_groupe_mot_traiter_dist(
	$id_groupe = 'new',
	$retour = '',
	$config_fonc = 'groupes_mots_edit_config',
	$row = array(),
	$hidden = ''
) {
	set_request('redirect', '');
	// cas des checkbox : injecter la valeur non si rien de coche
	foreach (array(
		         'obligatoire',
		         'unseul',
		         'comite',
		         'forum',
		         'minirezo'
	         ) as $champ) {
		if (!_request($champ)) {
			set_request($champ, 'non');
		}
	}

	$res = formulaires_editer_objet_traiter('groupe_mots', $id_groupe, 0, 0, $retour, $config_fonc, $row, $hidden);

	return $res;
}
