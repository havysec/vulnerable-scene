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
 * Gestion de l'action editer_petition
 *
 * @package SPIP\Petitions\Actions
 **/

if (!defined("_ECRIRE_INC_VERSION")) {
	return;
}

function action_editer_petition_dist($arg = null) {

	if (is_null($arg)) {
		$securiser_action = charger_fonction('securiser_action', 'inc');
		$arg = $securiser_action();
	}

	// si id_petition n'est pas un nombre, c'est une creation
	// mais on verifie qu'on a toutes les donnees qu'il faut.
	if (!$id_petition = intval($arg)) {
		$id_article = _request('id_article');
		if (!($id_article)) {
			include_spip('inc/headers');
			redirige_url_ecrire();
		}
		$id_petition = petition_inserer($id_article);
	}

	// Enregistre l'envoi dans la BD
	if ($id_petition > 0) {
		$err = petition_modifier($id_petition);
	}

	return array($id_petition, $err);
}

/**
 * Mettre à jour une petition existante
 *
 * @param int $id_petition
 * @param array $set
 * @return string
 */
function petition_modifier($id_petition, $set = null) {
	$err = '';

	include_spip('inc/modifier');
	$c = collecter_requests(
	// white list
		array(
			"email_unique",
			"site_obli",
			"site_unique",
			"message",
			"texte"
		),
		// black list
		array('statut', 'id_article'),
		// donnees eventuellement fournies
		$set
	);

	if ($err = objet_modifier_champs('petition', $id_petition,
		array(
			'data' => $set,
		),
		$c)
	) {
		return $err;
	}

	// changement d'article ou de statut ?
	$c = collecter_requests(array('statut', 'id_article'), array(), $set);
	$err .= petition_instituer($id_petition, $c);

	return $err;
}

/**
 * Insérer une petition en base
 *
 * @param int $id_article
 *     Identifiant de l'article recevant la pétition
 * @param array|null $set
 * @return int
 *     Identifiant de la pétition
 */
function petition_inserer($id_article, $set = null) {

	// Si id_article vaut 0 ou n'est pas definie, echouer
	if (!$id_article = intval($id_article)) {
		return 0;
	}

	$champs = array(
		'id_article' => $id_article,
	);

	if ($set) {
		$champs = array_merge($champs, $set);
	}

	// Envoyer aux plugins
	$champs = pipeline('pre_insertion',
		array(
			'args' => array(
				'table' => 'spip_petitions',
			),
			'data' => $champs
		)
	);

	$id_petition = sql_insertq("spip_petitions", $champs);

	pipeline('post_insertion',
		array(
			'args' => array(
				'table' => 'spip_petitions',
				'id_objet' => $id_petition
			),
			'data' => $champs
		)
	);

	return $id_petition;
}


/**
 * Institution d'une pétition
 *
 * @param int $id_petition
 *     Identifiant de la pétition
 * @param array $c
 *     Liste des champs à modifier
 * @return string|null
 */
function petition_instituer($id_petition, $c) {

	include_spip('inc/autoriser');
	include_spip('inc/modifier');

	$row = sql_fetsel("id_article,statut", "spip_petitions", "id_petition=" . intval($id_petition));
	$statut_ancien = $statut = $row['statut'];
	#$date_ancienne = $date = $row['date_time'];
	$champs = array();

	$s = isset($c['statut']) ? $c['statut'] : $statut;

	// cf autorisations dans inc/petition_instituer
	if ($s != $statut /*OR ($d AND $d != $date)*/) {
		$statut = $champs['statut'] = $s;

		// En cas de publication, fixer la date a "maintenant"
		// sauf si $c commande autre chose
		// ou si l'petition est deja date dans le futur
		// En cas de proposition d'un petition (mais pas depublication), idem
		/*
		if ($champs['statut'] == 'publie') {
			if ($d)
				$champs['date_time'] = $date = $d;
			else
				$champs['date_time'] = $date = date('Y-m-d H:i:s');
		}*/
	}

	// Envoyer aux plugins
	$champs = pipeline('pre_edition',
		array(
			'args' => array(
				'table' => 'spip_petitions',
				'id_objet' => $id_petition,
				'action' => 'instituer',
				'statut_ancien' => $statut_ancien,
			),
			'data' => $champs
		)
	);

	if (!count($champs)) {
		return;
	}

	// Envoyer les modifs.
	sql_updateq('spip_petitions', $champs, 'id_petition=' . intval($id_petition));

	// Invalider les caches
	include_spip('inc/invalideur');
	suivre_invalideur("id='petition/$id_petition'");
	suivre_invalideur("id='article/" . $row['id_article'] . "'");

	// Pipeline
	pipeline('post_edition',
		array(
			'args' => array(
				'table' => 'spip_petitions',
				'id_objet' => $id_petition,
				'action' => 'instituer',
				'statut_ancien' => $statut_ancien,
			),
			'data' => $champs
		)
	);

	// Notifications
	if ($notifications = charger_fonction('notifications', 'inc')) {
		$notifications('instituerpetition', $id_petition,
			array('statut' => $statut, 'statut_ancien' => $statut_ancien)
		);
	}

	return ''; // pas d'erreur
}

// http://code.spip.net/@revision_petition
function revision_petition($id_petition, $c = null) {
	return petition_modifier($id_petition, $c);
}
