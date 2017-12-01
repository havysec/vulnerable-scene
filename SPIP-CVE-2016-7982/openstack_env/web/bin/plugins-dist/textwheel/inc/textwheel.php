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

if (!defined("_ECRIRE_INC_VERSION")) {
	return;
}

include_spip('engine/textwheel');
// si une regle change et rend son cache non valide
// incrementer ce define au numero de commit concerne
// (inconsistence entre la wheel et l'inclusion php)
if (!defined('_WHEELS_VERSION')) {
	define('_WHEELS_VERSION', 68672);
}

//
// Definition des principales wheels de SPIP
//
if (!isset($GLOBALS['spip_wheels'])) {
	$GLOBALS['spip_wheels'] = array();
}

// Si le tableau des raccourcis existe déjà
if (!isset($GLOBALS['spip_wheels']['raccourcis']) or !is_array($GLOBALS['spip_wheels']['raccourcis'])) {
	$GLOBALS['spip_wheels']['raccourcis'] = array(
		'spip/spip.yaml',
		'spip/spip-paragrapher.yaml'
	);
} else {
	$GLOBALS['spip_wheels']['raccourcis'] = array_merge(
		array(
			'spip/spip.yaml',
			'spip/spip-paragrapher.yaml'
		),
		$GLOBALS['spip_wheels']['raccourcis']
	);
}

if (test_espace_prive()) {
	$GLOBALS['spip_wheels']['raccourcis'][] = 'spip/ecrire.yaml';
}

$GLOBALS['spip_wheels']['interdire_scripts'] = array(
	'spip/interdire-scripts.yaml'
);

$GLOBALS['spip_wheels']['echappe_js'] = array(
	'spip/echappe-js.yaml'
);

$GLOBALS['spip_wheels']['paragrapher'] = array(
	'spip/spip-paragrapher.yaml'
);

$GLOBALS['spip_wheels']['listes'] = array(
	'spip/spip-listes.yaml'
);

//
// Methode de chargement d'une wheel SPIP
//

class SPIPTextWheelRuleset extends TextWheelRuleSet {
	protected function findFile(&$file, $path = '') {
		static $default_path;

		// absolute file path?
		if (file_exists($file)) {
			return $file;
		}

		// file include with texwheels, relative to calling ruleset
		if ($path and file_exists($f = $path . $file)) {
			return $f;
		}

		return find_in_path($file, 'wheels/');
	}

	public static function &loader($ruleset, $callback = '', $class = 'SPIPTextWheelRuleset') {

		# memoization
		# attention : le ruleset peut contenir apres loading des chemins relatifs
		# il faut donc que le cache depende du chemin courant vers la racine de SPIP
		$key = "";
		if ($callback) {
			$key = $callback($key);
		}
		$key = 'tw-' . md5(_WHEELS_VERSION . "-" . serialize($ruleset) . $key . $class . _DIR_RACINE);

		# lecture du cache
		if ((!defined('_VAR_MODE') or _VAR_MODE != 'recalcul')
			and $cacheruleset = tw_cache_get($key)
		) {
			return $cacheruleset;
		}

		# calcul de la wheel
		$ruleset = parent::loader($ruleset, $callback, $class);

		# ecriture du cache
		tw_cache_set($key, $ruleset);

		return $ruleset;
	}
}


function tw_trig_purger($quoi) {
	if ($quoi == 'cache') {
		purger_repertoire(_DIR_CACHE . "wheels");
	}

	return $quoi;
}


/**
 * Lire une valeur en cache
 * memoization minimale
 * (utilise le plugin memoization si disponible)
 *
 * @param string $key
 * @return mixed
 */
function tw_cache_get($key) {
	if (function_exists('cache_get')) {
		return cache_get($key);
	}

	return @unserialize(file_get_contents(_DIR_CACHE . "wheels/" . $key . ".txt"));
}

/**
 * Ecrire une valeur en cache
 * memoization minimale
 * (utilise le plugin memoization si disponible)
 *
 * @param string $key
 * @param mixed $value
 * @param int|null $ttl
 * @return bool
 */
function tw_cache_set($key, $value, $ttl = null) {
	if (function_exists('cache_set')) {
		return cache_set($key, $value, $ttl);
	}
	$dir = sous_repertoire(_DIR_CACHE, "wheels/");

	return ecrire_fichier($dir . $key . ".txt", serialize($value));
}
