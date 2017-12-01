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

function forum_compte_messages_from($email, $id_forum) {
	static $mem = array();

	if (isset($mem[$email])) {
		return $mem[$email];
	}

	// sinon on fait une requete groupee pour essayer de ne le faire qu'une fois pour toute la liste
	$emails = sql_allfetsel("DISTINCT email_auteur", "spip_forum",
		"id_forum>" . intval($id_forum - 50) . " AND id_forum<" . intval($id_forum + 50));
	$emails = array_map('reset', $emails);
	$emails = array_filter($emails);
	// et compter
	$counts = sql_allfetsel("email_auteur,count(id_forum) AS N", "spip_forum", sql_in("email_auteur", $emails),
		"email_auteur");

	foreach ($counts as $c) {
		$mem[$c['email_auteur']] = $c['N'];
	}

	return $mem[$email];
}
