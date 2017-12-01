<?php
/**
 * Gestion du téléporteur HTTP.
 *
 * @plugin SVP pour SPIP
 * @license GPL
 * @package SPIP\SVP\Teleporteur
 */


if (!defined('_SVN_COMMAND')) {
	define('_SVN_COMMAND', "svn");
} // Securite : mettre le chemin absolu dans mes_options.php

/**
 * Téléporter et déballer un composant SVN
 *
 * Déployer un repository SVN depuis une source et une révision données
 *
 * @uses  teleporter_svn_read()
 * @uses  teleporter_nettoyer_vieille_version()
 *
 * @param string $methode
 *     Méthode de téléportation : http|git|svn|...
 * @param string $source
 *     URL de la source SVN
 * @param string $dest
 *     Chemin du répertoire de destination
 * @param array $options
 *     Tableau d'options. Index possibles :
 *     - revision => 'nnn'
 *     - literal => --ignore-externals
 * @return bool
 *     True si l'opération réussie, false sinon.
 */
function teleporter_svn_dist($methode, $source, $dest, $options = array()) {
	if (is_dir($dest)) {
		$infos = teleporter_svn_read($dest);
		if (!$infos) {
			spip_log("Suppression de $dest qui n'est pas au format SVN", "teleport");
			$old = teleporter_nettoyer_vieille_version($dest);
		} elseif ($infos['source'] !== $source) {
			spip_log("Suppression de $dest qui n'est pas sur le bon repository SVN", "teleport");
			$old = teleporter_nettoyer_vieille_version($dest);
		} elseif (!isset($options['revision'])
			or $options['revision'] != $infos['revision']
		) {
			$command = _SVN_COMMAND . " up ";
			if (isset($options['revision'])) {
				$command .= escapeshellarg("-r" . $options['revision']) . " ";
			}
			if (isset($options['ignore-externals'])) {
				$command .= "--ignore-externals ";
			}

			$command .= escapeshellarg($dest);
			spip_log($command, "teleport");
			exec($command);
		} else {
			// Rien a faire !
			spip_log("$dest deja a jour (Revision " . $options['revision'] . " SVN de $source)", "teleport");
		}
	}

	if (!is_dir($dest)) {
		$command = _SVN_COMMAND . " co ";
		if (isset($options['revision'])) {
			$command .= escapeshellarg("-r" . $options['revision']) . " ";
		}
		if (isset($options['ignore-externals'])) {
			$command .= "--ignore-externals ";
		}
		$command .= escapeshellarg($source) . " " . escapeshellarg($dest);
		spip_log($command, "teleport");
		exec($command);
	}

	// verifier que tout a bien marche
	$infos = teleporter_svn_read($dest);
	if (!$infos) {
		return false;
	}

	return true;
}

/**
 * Lire source et révision d'un répertoire SVN
 * et reconstruire la ligne de commande
 *
 * @param string $dest
 *     Chemin du répertoire SVN
 * @param array $options
 *     Options
 * @return array|string
 *     Chaîne vide si pas SVN ou erreur de lecture,
 *     Tableau sinon avec les index :
 *     - source : URL de la source SVN
 *     - revision : numéro de la révision SVN
 *     - dest : Chemin du répertoire
 */
function teleporter_svn_read($dest, $options = array()) {

	if (!is_dir("$dest/.svn")) {
		return "";
	}

	// on veut lire ce qui est actuellement deploye
	// et reconstituer la ligne de commande pour le deployer
	exec(_SVN_COMMAND . " info " . escapeshellarg($dest), $output);
	$output = implode("\n", $output);

	// URL
	// URL: svn://trac.rezo.net/spip/spip
	if (!preg_match(",^URL[^:\w]*:\s+(.*)$,Uims", $output, $m)) {
		return "";
	}
	$source = $m[1];

	// Revision
	// Revision: 18763
	if (!preg_match(",^R..?vision[^:\w]*:\s+(\d+)$,Uims", $output, $m)) {
		return "";
	}

	$revision = $m[1];

	return array(
		'source' => $source,
		'revision' => $revision,
		'dest' => $dest
	);
}


/**
 * Tester si la commande 'svn' est disponible
 *
 * @return bool
 *     true si on peut utiliser la commande svn
 **/
function teleporter_svn_tester() {
	static $erreurs = null;
	if (is_null($erreurs)) {
		exec(_SVN_COMMAND . " --version", $output, $erreurs);
	}

	return !$erreurs;
}
