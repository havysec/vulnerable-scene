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
 * Déclarations de fonctions pour le compilateur
 *
 * @package SPIP\Sites\Compilateur
 **/
if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}

/**
 * Compile la boucle `SITES` qui retourne la liste des sites référencés
 *
 * @param string $id_boucle
 *     Identifiant de la boucle
 * @param array $boucles
 *     AST du squelette
 * @return string
 *     Code PHP compilé de la boucle
 **/
function boucle_SITES_dist($id_boucle, &$boucles) {
	$boucle = &$boucles[$id_boucle];
	$boucle->type_requete = 'syndication'; // pas sur que ce soit indispensable
	if (!function_exists($f = 'boucle_SYNDICATION') and !function_exists($f = $f . '_dist')) {
		$f = 'calculer_boucle';
	}

	return $f($id_boucle, $boucles);
}
