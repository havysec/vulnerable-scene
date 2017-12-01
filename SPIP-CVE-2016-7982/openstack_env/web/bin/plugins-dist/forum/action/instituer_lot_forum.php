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

// http://code.spip.net/@action_instituer_forum_dist
function action_instituer_lot_forum_dist($arg = null) {

	if (is_null($arg)) {
		$securiser_action = charger_fonction('securiser_action', 'inc');
		$arg = $securiser_action();
	}

	// verifier les droits
	if (autoriser('instituer', 'forum', 0)) {

		/**
		 * Cas 1 : les arguments sont explicites
		 * statut-ip/email/id_auteur/auteur
		 *
		 */
		if (preg_match(",^(\w+)-,", $arg, $match)
			and in_array($statut = $match[1], array('publie', 'off', 'spam'))
		) {
			$arg = substr($arg, strlen($statut) + 1);

			$arg = explode('/', $arg);
			$ip = array_shift($arg);
			$email_auteur = array_shift($arg);
			$id_auteur = intval(array_shift($arg));
			$auteur = implode('/', $arg);
			$where = array();
			// pas de moderation par lot sur les forum prives
			$where[] = sql_in('statut', array('privadm', 'prive', 'privrac'), 'NOT');
			if ($ip) {
				$where[] = "ip=" . sql_quote($ip);
			}
			if ($email_auteur) {
				$where[] = "email_auteur=" . sql_quote($email_auteur);
			}
			if ($id_auteur) {
				$where[] = "id_auteur=" . intval($id_auteur);
			}
			if ($auteur) {
				$where[] = "auteur=" . sql_quote($auteur);
			}
			$rows = sql_allfetsel("*", "spip_forum", $where);
			if (!count($rows)) {
				return;
			}

			include_spip('action/instituer_forum');
			foreach ($rows as $row) {
				instituer_un_forum($statut, $row);
			}
		} /**
		 * Cas 2 : seul le statut est explicite et signe
		 * les id concernes sont passes en arg supplementaires
		 * dans un taleau ids[]
		 */
		elseif (preg_match(",^(\w+)$,", $arg, $match)
			and in_array($statut = $match[1], array('publie', 'off', 'spam'))
			and $id = _request('ids')
			and is_array($id)
		) {

			$ids = array_map('intval', $id);
			$where = array();
			// pas de moderation par lot sur les forum prives
			$where[] = sql_in('statut', array('privadm', 'prive', 'privrac'), 'NOT');
			$where[] = sql_in('id_forum', $ids);
			$rows = sql_allfetsel("*", "spip_forum", $where);
			if (!count($rows)) {
				return;
			}

			include_spip('action/instituer_forum');
			foreach ($rows as $row) {
				instituer_un_forum($statut, $row);
			}
		}
	} else {
		spip_log("instituer_lot_forum interdit pour auteur " . $GLOBALS['visiteur_session']['id_auteur'], _LOG_ERREUR);
	}

}
