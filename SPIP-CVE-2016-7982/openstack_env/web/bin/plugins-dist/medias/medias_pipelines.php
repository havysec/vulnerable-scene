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
 * Utilisations de pipelines
 *
 * @package SPIP\Medias\Pipelines
 **/


if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}

/**
 * Traiter le cas pathologique d'un upload de document ayant echoué
 * car étant trop gros
 *
 * @uses erreur_upload_trop_gros()
 * @pipeline detecter_fond_par_defaut
 * @param string $fond
 *     Nom du squelette par défaut qui sera utilisé
 * @return string
 *     Nom du squelette par défaut qui sera utilisé
 **/
function medias_detecter_fond_par_defaut($fond) {
	if (empty($_GET) and empty($_POST) and empty($_FILES)
		and isset($_SERVER["CONTENT_LENGTH"])
		and strstr($_SERVER["CONTENT_TYPE"], "multipart/form-data;")
	) {
		include_spip('inc/getdocument');
		erreur_upload_trop_gros();
	}

	return $fond;
}


/**
 * À chaque insertion d'un nouvel objet editorial
 * auquel on a attaché des documents, restituer l'identifiant
 * du nouvel objet crée sur les liaisons documents/objet,
 * qui ont ponctuellement un identifiant id_objet négatif.
 *
 * @see medias_affiche_gauche()
 * @pipeline post_insertion
 *
 * @param array $flux
 *     Données du pipeline
 * @return array
 *     Données du pipeline
 **/
function medias_post_insertion($flux) {

	$objet = objet_type($flux['args']['table']);
	$id_objet = $flux['args']['id_objet'];

	include_spip('inc/autoriser');

	if (autoriser('joindredocument', $objet, $id_objet)
		and $id_auteur = intval($GLOBALS['visiteur_session']['id_auteur'])
	) {

		# cf. HACK medias_affiche_gauche()
		# rattrapper les documents associes a cet objet nouveau
		# ils ont un id = 0-id_auteur

		# utiliser l'api editer_lien pour les appels aux pipeline edition_lien
		include_spip('action/editer_liens');
		$liens = objet_trouver_liens(array('document' => '*'), array($objet => 0 - $id_auteur));
		foreach ($liens as $lien) {
			objet_associer(array('document' => $lien['document']), array($objet => $id_objet), $lien);
		}
		// un simple delete pour supprimer les liens temporaires
		sql_delete("spip_documents_liens", array("id_objet = " . (0 - $id_auteur), "objet=" . sql_quote($objet)));
	}

	return $flux;
}

/**
 * Ajoute la configuration des documents à la page de configuration des contenus
 *
 * @pipeline affiche_milieu
 * @param array $flux
 * @return array
 */
function medias_affiche_milieu($flux) {
	if ($flux["args"]["exec"] == "configurer_contenu") {
		$flux["data"] .= recuperer_fond('prive/squelettes/inclure/configurer',
			array('configurer' => 'configurer_documents'));
	}

	return $flux;
}

/**
 * Définir les meta de configuration liées aux documents
 *
 * @pipeline configurer_liste_metas
 * @param array $config
 *     Couples nom de la méta => valeur par défaut
 * @return array
 *    Couples nom de la méta => valeur par défaut
 */
function medias_configurer_liste_metas($config) {
	$config['documents_objets'] = 'spip_articles';
	$config['documents_date'] = 'non';

	return $config;
}

/**
 * Institue ou met à jour les liens de documents après l'édition d'un objet
 *
 * @pipeline post_edition
 * @param array $flux
 *     Données du pipeline
 * @return array
 *     Données du pipeline
 **/
function medias_post_edition($flux) {
	// le serveur n'est pas toujours la
	$serveur = (isset($flux['args']['serveur']) ? $flux['args']['serveur'] : '');
	// si on ajoute un document, mettre son statut a jour
	if (isset($flux['args']['action']) and $flux['args']['action'] == 'ajouter_document') {
		include_spip('action/editer_document');
		// mettre a jour le statut si necessaire
		document_instituer($flux['args']['id_objet']);
	} // si on institue un objet, mettre ses documents lies a jour
	elseif (isset($flux['args']['table']) and $flux['args']['table'] !== 'spip_documents') {
		$type = isset($flux['args']['type']) ? $flux['args']['type'] : objet_type($flux['args']['table']);
		// verifier d'abord les doublons !
		include_spip('inc/autoriser');
		if (autoriser('autoassocierdocument', $type, $flux['args']['id_objet'])) {
			$table_objet = isset($flux['args']['table_objet']) ? $flux['args']['table_objet'] : table_objet($flux['args']['table'],
				$serveur);
			$marquer_doublons_doc = charger_fonction('marquer_doublons_doc', 'inc');
			$marquer_doublons_doc($flux['data'], $flux['args']['id_objet'], $type, id_table_objet($type, $serveur),
				$table_objet, $flux['args']['table'], '', $serveur);
		}

		if (($flux['args']['action'] and $flux['args']['action'] == 'instituer') or isset($flux['data']['statut'])) {
			include_spip('base/abstract_sql');
			$id = $flux['args']['id_objet'];
			$docs = array_map('reset', sql_allfetsel('id_document', 'spip_documents_liens',
				'id_objet=' . intval($id) . ' AND objet=' . sql_quote($type)));
			include_spip('action/editer_document');
			foreach ($docs as $id_document) // mettre a jour le statut si necessaire
			{
				document_instituer($id_document);
			}
		}
	} else {
		if (isset($flux['args']['table']) and $flux['args']['table'] !== 'spip_documents') {
			// verifier les doublons !
			$marquer_doublons_doc = charger_fonction('marquer_doublons_doc', 'inc');
			$marquer_doublons_doc($flux['data'], $flux['args']['id_objet'], $flux['args']['type'],
				id_table_objet($flux['args']['type'], $serveur), $flux['args']['table_objet'],
				$flux['args']['spip_table_objet'], '', $serveur);
		}
	}

	return $flux;
}

/**
 * Ajouter le portfolio et ajout de document sur les fiches objet
 *
 * Uniquement sur les objets pour lesquelles les medias ont été activés
 *
 * @pipeline afficher_complement_objet
 * @param array $flux
 * @return array
 */
function medias_afficher_complement_objet($flux) {
	if ($type = $flux['args']['type']
		and $id = intval($flux['args']['id'])
		and (autoriser('joindredocument', $type, $id))
	) {
		$documenter_objet = charger_fonction('documenter_objet', 'inc');
		$flux['data'] .= $documenter_objet($id, $type);
	}

	return $flux;
}

/**
 * Ajoute le formulaire d'ajout de document au formulaire d'édition
 * d'un objet (lorsque cet objet peut recevoir des documents).
 *
 * @note
 *   HACK : Lors d'une première création de l'objet, celui-ci n'ayant pas
 *   encore d'identifiant tant que le formulaire d'édition n'est pas enregistré,
 *   les liaisions entre les documents liés et l'objet à créer sauvegardent
 *   un identifiant d'objet négatif de la valeur de id_auteur (l'auteur
 *   connecte). Ces liaisons seront corrigées après validation dans
 *   le pipeline medias_post_insertion()
 *
 * @pipeline affiche_gauche
 * @see medias_post_insertion()
 *
 * @param array $flux
 *     Données du pipeline
 * @return array
 *     Données du pipeline
 */
function medias_affiche_gauche($flux) {
	if ($en_cours = trouver_objet_exec($flux['args']['exec'])
		and $en_cours['edition'] !== false // page edition uniquement
		and $type = $en_cours['type']
		and $id_table_objet = $en_cours['id_table_objet']
		// id non defini sur les formulaires de nouveaux objets
		and (isset($flux['args'][$id_table_objet]) and $id = intval($flux['args'][$id_table_objet])
			// et justement dans ce cas, on met un identifiant negatif
			or $id = 0 - $GLOBALS['visiteur_session']['id_auteur'])
		and autoriser('joindredocument', $type, $id)
	) {
		$flux['data'] .= recuperer_fond('prive/objets/editer/colonne_document', array('objet' => $type, 'id_objet' => $id));
	}

	return $flux;
}

/**
 * Utilisation du pipeline document_desc_actions
 *
 * Ne fait rien ici.
 *
 * Ce pipeline permet aux plugins d'ajouter de boutons d'action supplémentaires
 * sur les formulaires d'ajouts de documents
 *
 * @pipeline document_desc_actions
 * @param array $flux
 *     Données du pipeline
 * @return array
 *     Données du pipeline
 **/
function medias_document_desc_actions($flux) {
	return $flux;
}

/**
 * Utilisation du pipeline editer_document_actions
 *
 * Ne fait rien ici.
 *
 * Ce pipeline permet aux plugins d'ajouter de boutons d'action supplémentaires
 * sur les formulaires d'édition de documents
 *
 * @pipeline editer_document_actions
 * @param array $flux
 *     Données du pipeline
 * @return array
 *     Données du pipeline
 **/
function medias_editer_document_actions($flux) {
	return $flux;
}

/**
 * Utilisation du pipeline renseigner_document_distant
 *
 * Ne fait rien ici.
 *
 * Ce pipeline permet aux plugins de renseigner les clés `fichier` et
 * `mode` d'un document distant à partir de l'URL du fichier dans
 * la clé `source`.
 *
 * @see renseigner_source_distante()
 * @pipeline renseigner_document_distant
 * @param array $flux
 *     Données du pipeline
 * @return array
 *     Données du pipeline
 **/
function medias_renseigner_document_distant($flux) {
	return $flux;
}

/**
 * Compter les documents dans un objet
 *
 * @pipeline objet_compte_enfants
 * @param array $flux
 * @return array
 */
function medias_objet_compte_enfants($flux) {
	if ($objet = $flux['args']['objet']
		and $id = intval($flux['args']['id_objet'])
	) {
		// juste les publies ?
		if (array_key_exists('statut', $flux['args']) and ($flux['args']['statut'] == 'publie')) {
			$flux['data']['document'] = sql_countsel('spip_documents AS D JOIN spip_documents_liens AS L ON D.id_document=L.id_document',
				"L.objet=" . sql_quote($objet) . "AND L.id_objet=" . intval($id) . " AND (D.statut='publie')");
		} else {
			$flux['data']['document'] = sql_countsel('spip_documents AS D JOIN spip_documents_liens AS L ON D.id_document=L.id_document',
				"L.objet=" . sql_quote($objet) . "AND L.id_objet=" . intval($id) . " AND (D.statut='publie' OR D.statut='prepa')");
		}
	}

	return $flux;
}

/**
 * Afficher le nombre de documents dans chaque rubrique
 *
 * @pipeline boite_infos
 * @param array $flux
 * @return array
 */
function medias_boite_infos($flux) {
	if ($flux['args']['type'] == 'rubrique'
		and $id_rubrique = $flux['args']['id']
	) {
		if ($nb = sql_countsel('spip_documents_liens', "objet='rubrique' AND id_objet=" . intval($id_rubrique))) {
			$nb = "<div>" . singulier_ou_pluriel($nb, "medias:un_document", "medias:des_documents") . "</div>";
			if ($p = strpos($flux['data'], "<!--nb_elements-->")) {
				$flux['data'] = substr_replace($flux['data'], $nb, $p, 0);
			}
		}
	}

	return $flux;
}

/**
 * Insertion dans le pipeline revisions_chercher_label (Plugin révisions)
 * Trouver le bon label à afficher sur les champs dans les listes de révisions
 *
 * Si un champ est un champ extra, son label correspond au label défini du champs extra
 *
 * @pipeline revisions_chercher_label
 * @param array $flux Données du pipeline
 * @return array      Données du pipeline
 **/
function medias_revisions_chercher_label($flux) {
	foreach (array('id_vignette', 'hauteur', 'largeur', 'mode', 'taille') as $champ) {
		if ($flux['args']['champ'] == $champ) {
			$flux['data'] = _T('medias:info_' . $champ);

			return $flux;
		}
	}
	foreach (array('fichier', 'taille', 'mode', 'credits') as $champ) {
		if ($flux['args']['champ'] == $champ) {
			$flux['data'] = _T('medias:label_' . $champ);

			return $flux;
		}
	}
	if ($flux['args']['champ'] == 'distant') {
		$flux['data'] = $flux['data'] = _T('medias:fichier_distant');
	}

	return $flux;
}
