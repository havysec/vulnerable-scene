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
 * Définit les autorisations du plugin Médias
 *
 * @package SPIP\Medias\Autorisations
 **/

if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}

/**
 * Fonction d'appel pour le pipeline
 *
 * @pipeline autoriser
 */
function medias_autoriser() { }

/**
 * Autorisation d'administrer la médiathèque
 *
 * @param  string $faire Action demandée
 * @param  string $type Type d'objet sur lequel appliquer l'action
 * @param  int $id Identifiant de l'objet
 * @param  array $qui Description de l'auteur demandant l'autorisation
 * @param  array $opt Options de cette autorisation
 * @return bool          true s'il a le droit, false sinon
 **/
function autoriser_mediatheque_administrer_dist($faire, $type, $id, $qui, $opt) {
	return $qui['statut'] == '0minirezo';
}

/**
 * Autorisation de voir le bouton Documents dans le menu
 *
 * @param  string $faire Action demandée
 * @param  string $type Type d'objet sur lequel appliquer l'action
 * @param  int $id Identifiant de l'objet
 * @param  array $qui Description de l'auteur demandant l'autorisation
 * @param  array $opt Options de cette autorisation
 * @return bool          true s'il a le droit, false sinon
 **/
function autoriser_documents_menu_dist($faire, $type, $id, $qui, $opt) {
	return autoriser('administrer', 'mediatheque', $id, $qui, $opt);
}

/**
 * Autoriser le changement des dimensions sur un document
 *
 * @param  string $faire Action demandée
 * @param  string $type Type d'objet sur lequel appliquer l'action
 * @param  int $id Identifiant de l'objet
 * @param  array $qui Description de l'auteur demandant l'autorisation
 * @param  array $options Options de cette autorisation
 * @return bool          true s'il a le droit, false sinon
 */
function autoriser_document_tailler_dist($faire, $type, $id, $qui, $options) {

	if (!$id_document = intval($id)) {
		return false;
	}
	if (!autoriser('modifier', 'document', $id, $qui, $options)) {
		return false;
	}

	if (!isset($options['document']) or !$document = $options['document']) {
		$document = sql_fetsel('*', 'spip_documents', 'id_document=' . intval($id_document));
	}

	// (on ne le propose pas pour les images qu'on sait
	// lire : gif jpg png), sauf bug, ou document distant
	if (in_array($document['extension'], array('gif', 'jpg', 'png'))
		and $document['hauteur']
		and $document['largeur']
		and $document['distant'] != 'oui'
	) {
		return false;
	}

	// Donnees sur le type de document
	$extension = $document['extension'];
	$type_inclus = sql_getfetsel('inclus', 'spip_types_documents', "extension=" . sql_quote($extension));

	if (($type_inclus == "embed" or $type_inclus == "image")
		and (
			// documents dont la taille est definie
			($document['largeur'] * $document['hauteur'])
			// ou distants
			or $document['distant'] == 'oui'
			// ou tous les formats qui s'affichent en embed
			or $type_inclus == "embed"
		)
	) {
		return true;
	}
}

/**
 * Autorisation de joindre un document
 *
 * On ne peut joindre un document qu'a un objet qu'on a le droit d'editer
 * mais il faut prevoir le cas d'une *creation* par un redacteur, qui correspond
 * au hack id_objet = 0-id_auteur
 *
 * Il faut aussi que les documents aient ete actives sur les objets concernes
 * ou que ce soit un article, sur lequel on peut toujours uploader des images
 *
 * @param  string $faire Action demandée
 * @param  string $type Type d'objet sur lequel appliquer l'action
 * @param  int $id Identifiant de l'objet
 * @param  array $qui Description de l'auteur demandant l'autorisation
 * @param  array $opt Options de cette autorisation
 * @return bool          true s'il a le droit, false sinon
 */
function autoriser_joindredocument_dist($faire, $type, $id, $qui, $opt) {
	include_spip('inc/config');

	// objet autorisé en upload ?
	if ($type == 'article' or in_array(table_objet_sql($type), explode(',', lire_config('documents_objets', '')))) {
		// sur un objet existant
		if ($id > 0) {
			return autoriser('modifier', $type, $id, $qui, $opt);
		} // sur un nouvel objet
		elseif ($id < 0 and (abs($id) == $qui['id_auteur'])) {
			return autoriser('ecrire', $type, $id, $qui, $opt);
		}
	}

	return false;
}


/**
 * Autorisation de modifier un document
 *
 * On ne peut modifier un document que s'il n'est pas lie a un objet qu'on n'a pas le droit d'editer
 *
 * @staticvar <type> $m
 * @param  string $faire Action demandée
 * @param  string $type Type d'objet sur lequel appliquer l'action
 * @param  int $id Identifiant de l'objet
 * @param  array $qui Description de l'auteur demandant l'autorisation
 * @param  array $opt Options de cette autorisation
 * @return bool          true s'il a le droit, false sinon
 */
function autoriser_document_modifier_dist($faire, $type, $id, $qui, $opt) {
	static $m = array();

	$q = $qui['id_auteur'];
	if (isset($m[$q][$id])) {
		return $m[$q][$id];
	}

	$s = sql_getfetsel("statut", "spip_documents", "id_document=" . intval($id));
	// les admins ont le droit de modifier tous les documents existants
	if ($qui['statut'] == '0minirezo'
		and !$qui['restreint']
	) {
		return is_string($s) ? true : false;
	}

	if (!isset($m[$q][$id])) {
		// un document non publie peut etre modifie par tout le monde (... ?)
		if ($s and $s !== 'publie' and ($qui['id_auteur'] > 0)) {
			$m[$q][$id] = true;
		}
	}

	if (!isset($m[$q][$id])) {
		$interdit = false;

		$s = sql_select("id_objet,objet", "spip_documents_liens", "id_document=" . intval($id));
		while ($t = sql_fetch($s)) {
			if (!autoriser('modifier', $t['objet'], $t['id_objet'], $qui, $opt)) {
				$interdit = true;
				break;
			}
		}

		$m[$q][$id] = ($interdit ? false : true);
	}

	return $m[$q][$id];
}


/**
 * Autorisation de supprimer un document
 *
 * On ne peut supprimer un document que s'il n'est lie a aucun objet
 * ET qu'on a le droit de le modifier !
 *
 * @param  string $faire Action demandée
 * @param  string $type Type d'objet sur lequel appliquer l'action
 * @param  int $id Identifiant de l'objet
 * @param  array $qui Description de l'auteur demandant l'autorisation
 * @param  array $opt Options de cette autorisation
 * @return bool          true s'il a le droit, false sinon
 */
function autoriser_document_supprimer_dist($faire, $type, $id, $qui, $opt) {
	if (!intval($id)
		or !$qui['id_auteur']
		or !autoriser('ecrire', '', '', $qui)
	) {
		return false;
	}

	// ne pas considerer les document parent
	// (cas des vignettes ou autre document annexe rattache a un document)
	if (sql_countsel('spip_documents_liens', "objet!='document' AND id_document=" . intval($id))) {
		return false;
	}

	// si c'est une vignette, se ramener a l'autorisation de son parent
	if (sql_getfetsel('mode', 'spip_documents', 'id_document=' . intval($id)) == 'vignette') {
		$id_document = sql_getfetsel('id_document', 'spip_documents', 'id_vignette=' . intval($id));

		return !$id_document or autoriser('modifier', 'document', $id_document);
	}
	// si c'est un document annexe, se ramener a l'autorisation de son parent
	if ($id_document = sql_getfetsel('id_objet', 'spip_documents_liens',
		"objet='document' AND id_document=" . intval($id))
	) {
		return autoriser('modifier', 'document', $id_document);
	}

	return autoriser('modifier', 'document', $id, $qui, $opt);
}


/**
 * Autorisation de voir un document
 *
 * Peut-on voir un document dans _DIR_IMG ?
 *
 * Tout le monde (y compris les visiteurs non enregistrés), puisque par
 * défaut ce repertoire n'est pas protégé ; si une extension comme
 * acces_restreint a positionné creer_htaccess, on regarde
 * si le document est lié à un élément publié.
 *
 * @todo
 *     À revoir car c'est dommage de sortir de l'API true/false
 *
 * @param  string $faire Action demandée
 * @param  string $type Type d'objet sur lequel appliquer l'action
 * @param  int $id Identifiant de l'objet
 * @param  array $qui Description de l'auteur demandant l'autorisation
 * @param  array $opt Options de cette autorisation
 * @return bool          true s'il a le droit, false sinon
 **/
function autoriser_document_voir_dist($faire, $type, $id, $qui, $opt) {

	if (!isset($GLOBALS['meta']["creer_htaccess"])
		or $GLOBALS['meta']["creer_htaccess"] != 'oui'
	) {
		return true;
	}

	if ((!is_numeric($id)) or $id < 0) {
		return false;
	}

	if (in_array($qui['statut'], array('0minirezo', '1comite'))) {
		return 'htaccess';
	}

	if ($liens = sql_allfetsel('objet,id_objet', 'spip_documents_liens', 'id_document=' . intval($id))) {
		foreach ($liens as $l) {
			$table_sql = table_objet_sql($l['objet']);
			$id_table = id_table_objet($l['objet']);
			if (sql_countsel($table_sql, "$id_table = " . intval($l['id_objet'])
					. (in_array($l['objet'], array('article', 'rubrique', 'breve'))
						? " AND statut = 'publie'"
						: '')
				) > 0
			) {
				return 'htaccess';
			}
		}
	}

	return false;
}


/**
 * Autorisation d'auto-association de documents à du contenu editorial qui le référence
 *
 * Par defaut true pour tous les objets
 *
 * @param  string $faire Action demandée
 * @param  string $type Type d'objet sur lequel appliquer l'action
 * @param  int $id Identifiant de l'objet
 * @param  array $qui Description de l'auteur demandant l'autorisation
 * @param  array $opt Options de cette autorisation
 * @return bool          true s'il a le droit, false sinon
 */
function autoriser_autoassocierdocument_dist($faire, $type, $id, $qui, $opt) {
	return true;
}

/**
 * Autoriser à nettoyer les orphelins de la base des documents
 *
 * Réservé aux admins complets.
 *
 * @param  string $faire Action demandée
 * @param  string $type Type d'objet sur lequel appliquer l'action
 * @param  int $id Identifiant de l'objet
 * @param  array $qui Description de l'auteur demandant l'autorisation
 * @param  array $opt Options de cette autorisation
 * @return bool          true s'il a le droit, false sinon
 */
function autoriser_orphelins_supprimer_dist($faire, $type, $id, $qui, $opt) {
	if ($qui['statut'] == '0minirezo'
		and !$qui['restreint']
	) {
		return true;
	}
}


/**
 * Autoriser a associer des documents a un objet :
 * il faut avoir le droit de modifier cet objet
 *
 * @param $faire
 * @param $type
 * @param $id
 * @param $qui
 * @param $opt
 * @return bool
 */
function autoriser_associerdocuments_dist($faire, $type, $id, $qui, $opt) {
	// cas particulier (hack nouvel objet)
	if (intval($id) < 0 and $id == -$qui['id_auteur']) {
		return true;
	}

	return autoriser('modifier', $type, $id, $qui, $opt);
}

/**
 * Autoriser a dissocier des documents a un objet :
 * il faut avoir le droit de modifier cet objet
 *
 * @param $faire
 * @param $type
 * @param $id
 * @param $qui
 * @param $opt
 * @return bool
 */
function autoriser_dissocierdocuments_dist($faire, $type, $id, $qui, $opt) {
	// cas particulier (hack nouvel objet)
	if (intval($id) < 0 and $id == -$qui['id_auteur']) {
		return true;
	}

	return autoriser('modifier', $type, $id, $qui, $opt);
}
