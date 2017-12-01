<?php

/**
 * Gestion du formulaire de gestion des plugins
 *
 * @plugin SVP pour SPIP
 * @license GPL
 * @package SPIP\SVP\Formulaires
 */

if (!defined("_ECRIRE_INC_VERSION")) {
	return;
}

/**
 * Chargement du formulaire de gestion des plugins
 *
 * @uses  svp_actualiser_paquets_locaux()
 * @param string $voir
 *     Statut des plugins que l'on souhaite voir : actif, inactif, tous
 * @param string $verrouille
 *     Types de plugins que l'on souhaite voir :
 *     - 'non' : les plugins utilisateurs
 *     - 'oui' : les plugins verrouillés (plugins-dist)
 *     - 'tous' : les deux !
 * @param string|int $id_paquet
 *     Identifiant du paquet dont on veut obtenir une description complète
 *     lors de l'affichage du formulaire
 * @param string $redirect
 *     URL de redirection après les traitements
 * @return array
 *     Environnement du formulaire
 **/
function formulaires_admin_plugin_charger_dist($voir = 'actif', $verrouille = 'non', $id_paquet = '', $redirect = '') {
	$valeurs = array();

	// actualiser la liste des paquets locaux systematiquement
	include_spip('inc/svp_depoter_local');
	// sans forcer tout le recalcul en base, mais en récupérant les erreurs XML
	$valeurs['_erreurs_xml'] = array();
	svp_actualiser_paquets_locaux(false, $valeurs['_erreurs_xml']);

	$valeurs['actif'] = 'oui';
	if ($voir == 'inactif') {
		$valeurs['actif'] = 'non';
	}
	if ($voir == 'tous') {
		$valeurs['actif'] = '';
	}

	$valeurs['constante'] = array('_DIR_PLUGINS', '_DIR_PLUGINS_SUPPL');
	if ($verrouille == 'oui') {
		$valeurs['constante'] = array('_DIR_PLUGINS_DIST');
	}
	if ($verrouille == 'tous') {
		$valeurs['constante'] = array();
	}

	$valeurs['verrouille'] = $verrouille;
	$valeurs['id_paquet'] = $id_paquet;
	$valeurs['actions'] = array();
	$valeurs['ids_paquet'] = _request('ids_paquet');
	$valeurs['afficher_incompatibles'] = _request('afficher_incompatibles');
	$valeurs['_todo'] = _request('_todo');
	$valeurs['_notices'] = _request('_notices');
	$valeurs['_libelles_actions'] = _request('_libelles_actions');

	return $valeurs;
}

/**
 * Vérifications du formulaire de gestion des plugins
 *
 * Appelle le décideur qui détermine la liste des actions à faire et si celles-ci
 * peuvent être faites (dépendances connues). Une erreur sera levé dans le
 * cas contraire.
 *
 * Si toutes les actions peuvent être faites, une demande de confirmation
 * est envoyée (dans une erreur spéciale), présentant alors toutes les
 * actions qui seront réalisées (celle demandée + celles à faire par voie
 * de conséquence.
 *
 * Si on reçoit une demande de confirmation, on sort sans lever d'erreur !
 *
 * @uses  svp_decider_verifier_actions_demandees()
 *
 * @param string $voir
 *     Statut des plugins que l'on souhaite voir : actif, inactif, tous
 * @param string $verrouille
 *     Types de plugins que l'on souhaite voir :
 *     - 'non' : les plugins utilisateurs
 *     - 'oui' : les plugins verrouillés (plugins-dist)
 *     - 'tous' : les deux !
 * @param string|int $id_paquet
 *     Identifiant du paquet dont on veut obtenir une description complète
 *     lors de l'affichage du formulaire
 * @param string $redirect
 *     URL de redirection après les traitements
 * @return array
 *     Tableau des erreurs
 **/
function formulaires_admin_plugin_verifier_dist($voir = 'actif', $verrouille = 'non', $id_paquet = '', $redirect = '') {

	$erreurs = array();

	if (_request('annuler_actions')) {
		// Requete : Annulation des actions d'installation en cours
		// -- On vide la liste d'actions en cours
		set_request('_todo', '');
		// -- vider les paquets coches s'il y en a
		set_request('ids_paquet', array());
	} elseif (_request('valider_actions')) {
		// ... 
	} else {
		$a_actionner = array();

		// actions globales...
		if ($action_globale = _request('action_globale') and _request('appliquer')) {
			$ids_paquet = _request('ids_paquet');
			if (!is_array($ids_paquet)) {
				$erreurs['message_erreur'] = _T('svp:message_erreur_aucun_plugin_selectionne');
			} else {
				foreach ($ids_paquet as $i) {
					$a_actionner[$i] = $action_globale;
				}
			}
			// action unitaire
		} else {
			$actions = _request('actions');
			// $actions[type][id] = Texte
			// -> $a_actionner[id] = type
			foreach ($actions as $action => $p) {
				foreach ($p as $i => $null) {
					$a_actionner[$i] = $action;
				}
			}
		}
		// lancer les verifications
		if (!$a_actionner) {
			$erreurs['message_erreur'] = _T('svp:message_erreur_aucun_plugin_selectionne');
		} else {

			// On fait appel au decideur pour determiner la liste exacte des commandes apres
			// verification des dependances
			include_spip('inc/svp_decider');
			svp_decider_verifier_actions_demandees($a_actionner, $erreurs);
			$todo = _request('_todo') ? unserialize(_request('_todo')) : array();
			$actions = _request('_decideur_actions') ? unserialize(_request('_decideur_actions')) : array();
			// si c'est une action simple (hors suppression) sans rien a faire de plus que demande, on y go direct
			if (in_array('stop', $todo) or in_array('kill', $todo)) {
				if (in_array('stop', $todo)) {
					$notices = array(); 
					$notices['decideur_warning'] = _T('svp:confirmer_desinstaller');
					set_request('_notices', $notices);
				}
			} elseif (!isset($erreurs['decideur_erreurs'])
				and (!isset($erreurs['decideur_propositions']) or !count($actions['decideur_propositions']))
			) {
				set_request('valider_actions', true); // on fake la validation, non mais ho !
			}
		}
	}

	if (count($erreurs) and !isset($erreurs['message_erreur'])) {
		$erreurs['message_erreur'] = '';
	}

	return $erreurs;
}

/**
 * Traitement du formulaire de gestion des plugins
 *
 * Si une liste d'action est validée, on redirige de formulaire sur
 * l'action 'actionner' qui les traitera une par une.
 *
 * @uses svp_actionner_traiter_actions_demandees()
 *
 * @param string $voir
 *     Statut des plugins que l'on souhaite voir : actif, inactif, tous
 * @param string $verrouille
 *     Types de plugins que l'on souhaite voir :
 *     - 'non' : les plugins utilisateurs
 *     - 'oui' : les plugins verrouillés (plugins-dist)
 *     - 'tous' : les deux !
 * @param string|int $id_paquet
 *     Identifiant du paquet dont on veut obtenir une description complète
 *     lors de l'affichage du formulaire
 * @param string $redirect
 *     URL de redirection après les traitements
 * @return array
 *     Retours du traitement
 **/
function formulaires_admin_plugin_traiter_dist($voir = 'actif', $verrouille = 'non', $id_paquet = '', $redirect = '') {

	$retour = array();

	if (_request('valider_actions')) {
		refuser_traiter_formulaire_ajax();
		// Ajout de la liste des actions à l'actionneur
		// c'est lui qui va effectuer rellement les actions
		// lors de l'appel de action/actionner 
		$actions = unserialize(_request('_todo'));
		include_spip('inc/svp_actionner');
		svp_actionner_traiter_actions_demandees($actions, $retour, $redirect);
	}

	$retour['editable'] = true;

	return $retour;
}
