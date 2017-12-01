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
 * Gestion du formulaire de d'édition d'une brève
 *
 * @package SPIP\Breves\Formulaires
 **/
if (!defined("_ECRIRE_INC_VERSION")) {
	return;
}

include_spip('inc/actions');
include_spip('inc/editer');

/**
 * Chargement du formulaire d'édition d'une brève
 *
 * @see formulaires_editer_objet_charger()
 *
 * @param int|string $id_breve
 *     Identifiant de la brève. 'new' pour une nouvelle brève.
 * @param int $id_rubrique
 *     Identifiant de la rubrique parente (si connue)
 * @param string $retour
 *     URL de redirection après le traitement
 * @param int $lier_trad
 *     Identifiant de la brève que l'on cherche à traduire
 * @param string $config_fonc
 *     Nom de la fonction ajoutant des configurations particulières au formulaire
 * @param array $row
 *     Valeurs de la ligne SQL de la brève, si connue
 * @param string $hidden
 *     Contenu HTML ajouté en même temps que les champs cachés du formulaire.
 * @return array
 *     Environnement du formulaire
 **/
function formulaires_editer_breve_charger_dist(
	$id_breve = 'new',
	$id_rubrique = 0,
	$retour = '',
	$lier_trad = 0,
	$config_fonc = 'breves_edit_config',
	$row = array(),
	$hidden = ''
) {
	$valeurs = formulaires_editer_objet_charger('breve', $id_breve, $id_rubrique, $lier_trad, $retour, $config_fonc, $row,
		$hidden);
	// un bug a permis a un moment que des breves soient dans des sous rubriques
	// lorsque ce cas se presente, il faut relocaliser la breve dans son secteur, plutot que n'importe ou
	if ($valeurs['id_parent']) {
		$valeurs['id_parent'] = sql_getfetsel('id_secteur', 'spip_rubriques',
			'id_rubrique=' . intval($valeurs['id_parent']));
	}

	return $valeurs;
}


/**
 * Identifier le formulaire en faisant abstraction des paramètres qui
 * ne representent pas l'objet édité
 *
 * @param int|string $id_breve
 *     Identifiant de la brève. 'new' pour une nouvelle brève.
 * @param int $id_rubrique
 *     Identifiant de la rubrique parente (si connue)
 * @param string $retour
 *     URL de redirection après le traitement
 * @param int $lier_trad
 *     Identifiant de la brève que l'on cherche à traduire
 * @param string $config_fonc
 *     Nom de la fonction ajoutant des configurations particulières au formulaire
 * @param array $row
 *     Valeurs de la ligne SQL de la brève, si connue
 * @param string $hidden
 *     Contenu HTML ajouté en même temps que les champs cachés du formulaire.
 * @return string
 *     Hash du formulaire
 **/
function formulaires_editer_breve_identifier_dist(
	$id_breve = 'new',
	$id_rubrique = 0,
	$retour = '',
	$lier_trad = 0,
	$config_fonc = 'breves_edit_config',
	$row = array(),
	$hidden = ''
) {
	return serialize(array(intval($id_breve), $lier_trad));
}


/**
 * Choix par défaut des options de présentation
 *
 * @param array $row
 *     Valeurs de la ligne SQL d'un mot, si connu
 * return array
 *     Configuration pour le formulaire
 */
function breves_edit_config($row) {
	global $spip_lang;

	$config = $GLOBALS['meta'];
	$config['lignes'] = 8;
	$config['langue'] = $spip_lang;

	$config['restreint'] = ($row['statut'] == 'publie');

	return $config;
}

/**
 * Vérification du formulaire d'édition d'une brève
 *
 * @see formulaires_editer_objet_verifier()
 *
 * @param int|string $id_breve
 *     Identifiant de la brève. 'new' pour une nouvelle brève.
 * @param int $id_rubrique
 *     Identifiant de la rubrique parente (si connue)
 * @param string $retour
 *     URL de redirection après le traitement
 * @param int $lier_trad
 *     Identifiant de la brève que l'on cherche à traduire
 * @param string $config_fonc
 *     Nom de la fonction ajoutant des configurations particulières au formulaire
 * @param array $row
 *     Valeurs de la ligne SQL de la brève, si connue
 * @param string $hidden
 *     Contenu HTML ajouté en même temps que les champs cachés du formulaire.
 * @return array
 *     Tableau des erreurs
 */
function formulaires_editer_breve_verifier_dist(
	$id_breve = 'new',
	$id_rubrique = 0,
	$retour = '',
	$lier_trad = 0,
	$config_fonc = 'breves_edit_config',
	$row = array(),
	$hidden = ''
) {
	// auto-renseigner le titre si il n'existe pas
	titre_automatique('titre', array('texte'));
	// on ne demande pas le titre obligatoire : il sera rempli a la volee dans editer_article si vide
	$erreurs = formulaires_editer_objet_verifier('breve', $id_breve, array('id_parent'));

	return $erreurs;
}

/**
 * Traitements du formulaire d'édition d'une brève
 *
 * @see formulaires_editer_objet_traiter()
 *
 * @param int|string $id_breve
 *     Identifiant de la brève. 'new' pour une nouvelle brève.
 * @param int $id_rubrique
 *     Identifiant de la rubrique parente (si connue)
 * @param string $retour
 *     URL de redirection après le traitement
 * @param int $lier_trad
 *     Identifiant de la brève que l'on cherche à traduire
 * @param string $config_fonc
 *     Nom de la fonction ajoutant des configurations particulières au formulaire
 * @param array $row
 *     Valeurs de la ligne SQL de la brève, si connue
 * @param string $hidden
 *     Contenu HTML ajouté en même temps que les champs cachés du formulaire.
 * @return array
 *     Tableau des erreurs
 */
function formulaires_editer_breve_traiter_dist(
	$id_breve = 'new',
	$id_rubrique = 0,
	$retour = '',
	$lier_trad = 0,
	$config_fonc = 'breves_edit_config',
	$row = array(),
	$hidden = ''
) {
	return formulaires_editer_objet_traiter('breve', $id_breve, $id_rubrique, $lier_trad, $retour, $config_fonc, $row,
		$hidden);
}
