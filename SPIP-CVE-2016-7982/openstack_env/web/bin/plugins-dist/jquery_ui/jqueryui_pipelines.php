<?php

if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}

/**
 * Ajout des scripts de jQuery UI pour les pages publiques et privées
 *
 * @param array $plugins
 * @return array $plugins
 */
function jqueryui_jquery_plugins($plugins) {

	// Modules demandés par le pipeline jqueryui_plugins
	is_array($jqueryui_plugins = pipeline('jqueryui_plugins', array())) || $jqueryui_plugins = array();

	// gestion des dépendances des modules demandés
	is_array($jqueryui_plugins = jqueryui_dependances($jqueryui_plugins)) || $jqueryui_plugins = array();

	// insérer les scripts nécessaires
	foreach ($jqueryui_plugins as $val) {
		$plugins[] = "javascript/ui/" . $val . ".js";
	}

	return $plugins;
}

/**
 * Ajout des css de jQuery UI pour les pages publiques
 *
 * @param: $flux
 * @return: $flux
 */
function jqueryui_insert_head_css($flux) {
	/**
	 * Doit on ne pas insérer les css (défini depuis un autre plugin) ?
	 */
	if (defined('_JQUERYUI_CSS_NON')) {
		return $flux;
	}


	// Modules demandés par le pipeline jqueryui_plugins
	is_array($jqueryui_plugins = pipeline('jqueryui_plugins', array())) || $jqueryui_plugins = array();
	// gestion des dépendances des modules demandés
	is_array($jqueryui_plugins = jqueryui_dependances($jqueryui_plugins)) || $jqueryui_plugins = array();

	// ajouter le thème si nécessaire
	if ($jqueryui_plugins and !in_array('jquery.ui.theme', $jqueryui_plugins)) {
		$jqueryui_plugins[] = 'theme';
	}

	// les css correspondantes aux plugins
	$styles = array(
		'accordion',
		'autocomplete',
		'button',
		'core',
		'datepicker',
		'dialog',
		'draggable',
		'menus',
		'progressbar',
		'resizable',
		'selectable',
		'selectmenu',
		'slider',
		'sortable',
		'spinner',
		'tabs',
		'tooltip',
		'theme'
	);

	// insérer les css nécessaires
	foreach ($jqueryui_plugins as $plugin) {
		if (in_array($plugin, $styles)) {
			$flux .= "<link rel='stylesheet' type='text/css' media='all' href='" . find_in_path('css/ui/' . $plugin . '.css') . "' />\n";
		}
	}

	return $flux;
}

/**
 * Ajout de la css de jQuery UI pour les pages privées
 *
 * @param: $flux
 * @return: $flux
 */
function jqueryui_header_prive_css($flux) {

	$flux .= "<link rel='stylesheet' type='text/css' media='all' href='" . find_in_path('css/ui/jquery-ui.css') . "' />\n";

	return $flux;
}

/**
 * Ajout du script effect de jQuery UI pour les pages privées
 *
 * @param: $flux
 * @return: $flux
 */
function jqueryui_header_prive($flux) {

	$flux .= "\n" . '<script src="' . find_in_path('prive/javascript/ui/effect.js') . '" type="text/javascript"></script>';

	return $flux;
}

/**
 * Gérer les dépendances de la lib jQuery UI
 *
 * @param array $plugins tableau des plugins demandés
 * @return array $plugins tableau des plugins nécessaires ou false
 */
function jqueryui_dependances($plugins) {

	// Gestion des renommages de plugins jqueryui
	foreach ($plugins as $nb => $val) {
		if (0 === strpos($val, 'jquery.effects.')) {
			$plugins[$nb] = str_replace('jquery.effects.', 'effect-', $val);
		}
		if (0 === strpos($val, 'jquery.ui.')) {
			$plugins[$nb] = str_replace('jquery.ui.', '', $val);
		}
	}

	/**
	 * Gestion des dépendances inter plugins
	 */
	$dependance_core = array(
		'mouse',
		'widget',
		'datepicker',
		'selectmenu'
	);

	/**
	 * Dépendances à widget
	 * Si un autre plugin est dépendant d'un de ceux là, on ne les ajoute pas
	 */
	$dependance_widget = array(
		'accordion',
		'autocomplete',
		'button',
		'dialog',
		'mouse',
		'menu',
		'progressbar',
		'tabs',
		'tooltip',
		'selectmenu'
	);

	$dependance_mouse = array(
		'draggable',
		'droppable',
		'resizable',
		'selectable',
		'slider',
		'sortable'
	);

	$dependance_position = array(
		'autocomplete',
		'dialog',
		'menu',
		'tooltip',
		'selectmenu'
	);

	$dependance_button = array(
		'dialog',
		'spinner'
	);

	$dependance_menu = array(
		'autocomplete',
		'selectmenu'
	);

	$dependance_draggable = array(
		'droppable'
	);

	$dependance_resizable = array(
		'dialog'
	);

	$dependance_effects = array(
		'effect-blind',
		'effect-bounce',
		'effect-clip',
		'effect-drop',
		'effect-explode',
		'effect-fade',
		'effect-fold',
		'effect-highlight',
		'effect-puff',
		'effect-pulsate',
		'effect-scale',
		'effect-shake',
		'effect-size',
		'effect-slide',
		'effect-transfer'
	);

	/**
	 * Vérification des dépendances
	 * Ici on ajoute quand même le plugin en question et on supprime les doublons via array_unique
	 * Pour éviter le cas où un pipeline demanderait un plugin dans le mauvais sens de la dépendance par exemple
	 *
	 * On commence par le bas de l'échelle :
	 * - button
	 * - menu
	 * - draggable
	 * - position
	 * - mouse
	 * - widget
	 * - core
	 * - effects
	 */
	if (count($intersect = array_intersect($plugins, $dependance_resizable)) > 0) {
		$keys = array_keys($intersect);
		array_splice($plugins, $keys[0], 0, "resizable");
	}
	if (count($intersect = array_intersect($plugins, $dependance_button)) > 0) {
		$keys = array_keys($intersect);
		array_splice($plugins, $keys[0], 0, "button");
	}
	if (count($intersect = array_intersect($plugins, $dependance_menu)) > 0) {
		$keys = array_keys($intersect);
		array_splice($plugins, $keys[0], 0, "menu");
	}
	if (count($intersect = array_intersect($plugins, $dependance_draggable)) > 0) {
		$keys = array_keys($intersect);
		array_splice($plugins, $keys[0], 0, "draggable");
	}
	if (count($intersect = array_intersect($plugins, $dependance_position)) > 0) {
		$keys = array_keys($intersect);
		array_splice($plugins, $keys[0], 0, "position");
	}
	if (count($intersect = array_intersect($plugins, $dependance_mouse)) > 0) {
		$keys = array_keys($intersect);
		array_splice($plugins, $keys[0], 0, "mouse");
	}
	if (count($intersect = array_intersect($plugins, $dependance_widget)) > 0) {
		$keys = array_keys($intersect);
		array_splice($plugins, $keys[0], 0, "widget");
	}
	if (count($intersect = array_intersect($plugins, $dependance_core)) > 0) {
		$keys = array_keys($intersect);
		array_splice($plugins, $keys[0], 0, "core");
	}
	if (count($intersect = array_intersect($plugins, $dependance_effects)) > 0) {
		$keys = array_keys($intersect);
		array_splice($plugins, $keys[0], 0, "effect");
	}
	$plugins = array_unique($plugins);

	return $plugins;
}
