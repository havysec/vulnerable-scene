<?php

/**
 * Gestion du formulaire de t�l�chargement de plugin via une URL
 *
 * @plugin SVP pour SPIP
 * @license GPL
 * @package SPIP\SVP\Formulaires
 */

if (!defined("_ECRIRE_INC_VERSION")) {
	return;
}

include_spip("inc/plugin");

/**
 * Cr�e une valeur d'action pour l'attribut 'name' d'une saisie de formulaire
 *
 * @example
 *     [(#ID_PAQUET|svp_nom_action{on})]
 *     �crit : actions[on][24]
 * @param int $id_paquet
 *     Identifiant du paquet
 * @param string $action
 *     Une action possible (on, off, stop, up, on, upon, kill)
 **/
function filtre_svp_nom_action($id_paquet, $action) {
	return "actions[$action][$id_paquet]";
}
