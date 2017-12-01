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
 * Gestion de l'action supprimer_groupe_mots
 *
 * @package SPIP\Mots\Actions
 */
if (!defined("_ECRIRE_INC_VERSION")) {
	return;
}

include_spip('inc/filtres');

/**
 * Action supprimant un groupe de mots clés dans la base de données
 * dont l'identifiant du groupe est donné en paramètre de cette fonction
 * ou en argument de l'action sécurisée
 *
 * Supprime le groupe uniquement si on en a l'autorisation. Cela implique
 * qu'il n'y ait pas de mots clés dans le groupe.
 *
 * @param null|int $id_groupe
 *     Identifiant du groupe à supprimer. En absence utilise l'argument
 *     de l'action sécurisée.
 */
function action_supprimer_groupe_mots_dist($id_groupe = null) {

	if (is_null($id_groupe)) {
		$securiser_action = charger_fonction('securiser_action', 'inc');
		$id_groupe = $securiser_action();
	}

	include_spip('inc/autoriser');
	if (autoriser('supprimer', 'groupemots', $id_groupe)) {
		sql_delete("spip_groupes_mots", "id_groupe=" . intval($id_groupe));
	} else {
		spip_log("action_supprimer_groupe_mots_dist $id_groupe interdit", _LOG_INFO_IMPORTANTE);
	}
}
