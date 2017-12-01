<?php
/**
 * Démarre SPIP afin d'obtenir ses fonctions depuis
 * les jeux de tests unitaires de type simpletest
 */
$remonte = "../";
while (!is_dir($remonte . "ecrire")) {
	$remonte = "../$remonte";
}
require $remonte . 'tests/test.inc';

demarrer_simpletest();
