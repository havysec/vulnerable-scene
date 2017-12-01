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
 * Définit les autorisations du plugin forum
 *
 * @package SPIP\Forum\Autorisations
 **/
if (!defined("_ECRIRE_INC_VERSION")) {
	return;
}

/**
 * Fonction d'appel pour le pipeline
 *
 * @pipeline autoriser
 */
function forum_autoriser() { }

/**
 * Autorisation de voir l'élément «forums internes» dans le menu
 *
 * @param  string $faire Action demandée
 * @param  string $type Type d'objet sur lequel appliquer l'action
 * @param  int $id Identifiant de l'objet
 * @param  array $qui Description de l'auteur demandant l'autorisation
 * @param  array $opt Options de cette autorisation
 * @return bool          true s'il a le droit, false sinon
 **/
function autoriser_foruminternesuivi_menu_dist($faire, $type = '', $id = 0, $qui = null, $opt = null) {
	if ((($GLOBALS['meta']['forum_prive'] == 'non') && ($GLOBALS['meta']['forum_prive_admin'] == 'non'))
		or (($GLOBALS['meta']['forum_prive'] == 'non') && ($qui['statut'] == '1comite'))
	) {
		return false;
	}

	return true;
}

/**
 * Autorisation de voir l'élément «suivi des forums» dans le menu
 *
 * @param  string $faire Action demandée
 * @param  string $type Type d'objet sur lequel appliquer l'action
 * @param  int $id Identifiant de l'objet
 * @param  array $qui Description de l'auteur demandant l'autorisation
 * @param  array $opt Options de cette autorisation
 * @return bool          true s'il a le droit, false sinon
 **/
function autoriser_forumreactions_menu_dist($faire, $type = '', $id = 0, $qui = null, $opt = null) {
	return (sql_countsel('spip_forum') && autoriser('publierdans', 'rubrique', _request('id_rubrique')));
}


/**
 * Autorisation de modérer un message de forum
 *
 * Il faut l'autorisation de modifier l'objet correspondant
 * (si le forum est attaché à un objet), sinon avoir droits par défaut
 * (être administrateur).
 *
 * @see autoriser_forum_moderer_dist()
 *
 * @param  string $faire Action demandée
 * @param  string $type Type d'objet sur lequel appliquer l'action
 * @param  int $id Identifiant de l'objet
 * @param  array $qui Description de l'auteur demandant l'autorisation
 * @param  array $opt Options de cette autorisation
 * @return bool          true s'il a le droit, false sinon
 **/
function autoriser_modererforum_dist($faire, $type, $id, $qui, $opt) {
	return $type ? autoriser('modifier', $type, $id, $qui, $opt) : autoriser('moderer', 'forum', 0, $qui, $opt);
}

/**
 * Autorisation de changer le statut d'un message de forum
 *
 * Seulement sur les objets qu'on a le droit de modérer.
 *
 * @param  string $faire Action demandée
 * @param  string $type Type d'objet sur lequel appliquer l'action
 * @param  int $id Identifiant de l'objet
 * @param  array $qui Description de l'auteur demandant l'autorisation
 * @param  array $opt Options de cette autorisation
 * @return bool          true s'il a le droit, false sinon
 */
function autoriser_forum_instituer_dist($faire, $type, $id, $qui, $opt) {
	if (!intval($id)) {
		return autoriser('moderer', 'forum');
	}
	$row = sql_fetsel('objet,id_objet', 'spip_forum', 'id_forum=' . intval($id));

	return $row ? autoriser('modererforum', $row['objet'], $row['id_objet'], $qui, $opt) : false;
}

/**
 * Autorisation par défaut de modérer un message de forum
 *
 * Si l'on connait l'objet, on délègue à modererforum, sinon il faut
 * être administrateur
 *
 * @see autoriser_modererforum_dist()
 *
 * @param  string $faire Action demandée
 * @param  string $type Type d'objet sur lequel appliquer l'action
 * @param  int $id Identifiant de l'objet
 * @param  array $qui Description de l'auteur demandant l'autorisation
 * @param  array $opt Options de cette autorisation
 * @return bool          true s'il a le droit, false sinon
 */
function autoriser_forum_moderer_dist($faire, $type, $id, $qui, $opt) {
	// si on fournit un id : deleguer a modererforum sur l'objet concerne
	if ($id) {
		include_spip('inc/forum');
		if ($racine = racine_forum($id)
			and list($objet, $id_objet, ) = $racine
			and $objet
		) {
			return autoriser('modererforum', $objet, $id_objet);
		}
	}

	// sinon : admins uniquement
	return $qui['statut'] == '0minirezo'; // les admins restreints peuvent moderer leurs messages
}


/**
 * Autorisation de modifier un message de forum
 *
 * Jamais
 *
 * @param  string $faire Action demandée
 * @param  string $type Type d'objet sur lequel appliquer l'action
 * @param  int $id Identifiant de l'objet
 * @param  array $qui Description de l'auteur demandant l'autorisation
 * @param  array $opt Options de cette autorisation
 * @return bool          true s'il a le droit, false sinon
 */
function autoriser_forum_modifier_dist($faire, $type, $id, $qui, $opt) {
	return false;
}

/**
 * Autorisation de consulter le forum des administrateurs
 *
 * Il faut être administrateur (y compris restreint)
 *
 * @param  string $faire Action demandée
 * @param  string $type Type d'objet sur lequel appliquer l'action
 * @param  int $id Identifiant de l'objet
 * @param  array $qui Description de l'auteur demandant l'autorisation
 * @param  array $opt Options de cette autorisation
 * @return bool          true s'il a le droit, false sinon
 */
function autoriser_forum_admin_dist($faire, $type, $id, $qui, $opt) {
	return $qui['statut'] == '0minirezo';
}

/**
 * Autorisation d'auto-association de documents sur des forum
 *
 * Jamais
 *
 * @param  string $faire Action demandée
 * @param  string $type Type d'objet sur lequel appliquer l'action
 * @param  int $id Identifiant de l'objet
 * @param  array $qui Description de l'auteur demandant l'autorisation
 * @param  array $opt Options de cette autorisation
 * @return bool          true s'il a le droit, false sinon
 */
function autoriser_forum_autoassocierdocument_dist($faire, $type, $id, $qui, $opt) {
	return false;
}

/**
 * Autorisation d'association de documents sur des forum
 *
 * Toujours
 *
 * @param  string $faire Action demandée
 * @param  string $type Type d'objet sur lequel appliquer l'action
 * @param  int $id Identifiant de l'objet
 * @param  array $qui Description de l'auteur demandant l'autorisation
 * @param  array $opt Options de cette autorisation
 * @return bool          true s'il a le droit, false sinon
 */
function autoriser_forum_associerdocuments_dist($faire, $type, $id, $qui, $opt) {
	return true;
}

/**
 * Autorisation de dissociation de documents sur des forum
 *
 * Toujours
 *
 * @param  string $faire Action demandée
 * @param  string $type Type d'objet sur lequel appliquer l'action
 * @param  int $id Identifiant de l'objet
 * @param  array $qui Description de l'auteur demandant l'autorisation
 * @param  array $opt Options de cette autorisation
 * @return bool          true s'il a le droit, false sinon
 */
function autoriser_forum_dissocierdocuments_dist($faire, $type, $id, $qui, $opt) {
	return true;
}

/**
 * Autorisation de participer au forum des admins
 *
 * Il faut être administrateur (y compris restreint)
 *
 * @param  string $faire Action demandée
 * @param  string $type Type d'objet sur lequel appliquer l'action
 * @param  int $id Identifiant de l'objet
 * @param  array $qui Description de l'auteur demandant l'autorisation
 * @param  array $opt Options de cette autorisation
 * @return bool          true s'il a le droit, false sinon
 */
function autoriser_forumadmin_participer_dist($faire, $type, $id, $qui, $opt) {
	return ($GLOBALS['meta']['forum_prive_admin'] == 'oui') && $qui['statut'] == '0minirezo';
}


/**
 * Autorisation de participer au forum privé d'un objet quelconque
 *
 * Afin de rester compatible avec l'existant cette autorisation est toujours vraie.
 *
 * @param  string $faire Action demandée
 * @param  string $type Type d'objet sur lequel appliquer l'action
 * @param  int $id Identifiant de l'objet
 * @param  array $qui Description de l'auteur demandant l'autorisation
 * @param  array $opt Options de cette autorisation
 * @return bool          true s'il a le droit, false sinon
 */
function autoriser_participerforumprive_dist($faire, $type, $id, $qui, $opt) {
	return true;
}
