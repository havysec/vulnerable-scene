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
 * Gestion de l'action verifier_documents_liens
 *
 * @package SPIP\Medias\Action
 **/

if (!defined("_ECRIRE_INC_VERSION")) {
	return;
}

/**
 * Vérifier tous les fichiers brisés
 *
 * @param int|null $id_document
 *     Indique le document cible de l'action, sinon il sera
 *     obtenu par la clé d'action sécurisée.
 */
function action_verifier_documents_liens_dist($id_document = null) {

	if (is_null($id_document)) {
		$securiser_action = charger_fonction('securiser_action', 'inc');
		$id_document = $securiser_action();
	}

	$id_document = ($id_document == '*') ? '*' : intval($id_document);
	include_spip('action/editer_liens');
	objet_optimiser_liens(array('document' => $id_document), '*');

}
