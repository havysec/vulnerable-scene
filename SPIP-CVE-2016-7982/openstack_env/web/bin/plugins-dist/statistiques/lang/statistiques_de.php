<?php
// This is a SPIP language file  --  Ceci est un fichier langue de SPIP
// extrait automatiquement de http://trad.spip.net/tradlang_module/statistiques?lang_cible=de
// ** ne pas modifier le fichier **

if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}

$GLOBALS[$GLOBALS['idx_lang']] = array(

	// A
	'archiver' => 'Archivieren',
	'archiver_concatener_explications' => 'Diese Operation führt die Besuchstatistiken der Artikel zusammen:',
	'archiver_concatener_ignorer' => 'Besuche, die weniger als @nb@ Jahre zurückliegen werden nicht mit einbezogen.',
	'archiver_concatener_par_an' => 'Besuche, die mehr als @nb@ Jahre zurückliegen, werden für jeden Artikel, am ersten Tag des  jeweiligen Jahres zusammengefasst',
	'archiver_concatener_par_mois' => 'Besuche, die mehr als @nb@ Jahre zurückliegen werden, pro Artikel, am ersten Tag eines Monats. zusammengefasst.',
	'archiver_conseil_sauvegarde' => 'Es wird empfohlen zuerst ein Backup der Datenbank zu machen.',
	'archiver_description' => 'Diese Seite liefert die Werkzeuge um die Statistiken der Website zu archivieren und aufzuräumen',
	'archiver_et_nettoyer' => 'Archivieren und Aufräumen',
	'archiver_nettoyer' => 'Aufräumen',
	'archiver_nettoyer_explications' => 'Referrer und Besuche von Artikeln  die nicht (mehr) in der Datenbank sind löschen.',
	'archiver_nettoyer_referers_articles' => 'Referrer der Artikel zurücksetzen',
	'archiver_nettoyer_visites_articles' => 'Besuche der Artikel zurücksetzen',
	'archiver_nombre_lignes' => 'Anzahl der Zeilen',
	'archiver_operation_longue' => 'Diese Operation kann bei der ersten Ausführung sehr lange dauern.',
	'archiver_operations_irreversibles' => 'Diese Operationen können nicht rückgängig gemacht werden!',

	// B
	'bouton_effacer_referers' => 'Nur eingehende Links löschen',
	'bouton_effacer_statistiques' => 'Alle Statistiken löschen',

	// C
	'csv' => 'CSV',

	// I
	'icone_evolution_visites' => 'Besuchsentwicklung<br />@visites@ Abrufe',
	'icone_repartition_actuelle' => 'Aktuelle Verteilung anzeigen',
	'icone_repartition_visites' => 'Verteilung der Besuche',
	'icone_statistiques_visites' => 'Statistiken',
	'info_affichier_visites_articles_plus_visites' => 'Besuche der <b>beliebtesten Artikel seit Start der Website</b> anzeigen:',
	'info_comment_lire_tableau' => 'Interpretation der Tabelle',
	'info_forum_statistiques' => 'Besucherstatistiken',
	'info_graphiques' => 'Grafik',
	'info_popularite_2' => 'Beliebtheit der Website: ',
	'info_popularite_3' => 'Beliebtheit: @popularite@ ; Besuche: @visites@',
	'info_popularite_5' => 'Beliebtheit:',
	'info_previsions' => 'Vorschau:',
	'info_question_vignettes_referer' => 'Sie können die Besucherstatistiken mit Thumbnails der Herkunftswebsites (referer) ergänzen',
	'info_question_vignettes_referer_oui' => 'Thumbnails der Herkunftswebsites anzeigen',
	'info_tableaux' => 'Tabelle',
	'info_visites' => 'Besuche:',
	'info_visites_plus_populaires' => 'Seitenabrufe für die <b>beliebtesten Artikel</b> und die <b>letzten veröffentlichten Artikel:</b>',
	'info_zoom' => 'Zoom',
	'item_gerer_statistiques' => 'Besucherstatistiken verwalten',

	// O
	'onglet_origine_visites' => 'Ursprung der Besuche',
	'onglet_repartition_debut' => 'von Anfang an',
	'onglet_repartition_lang' => 'nach Sprachen',

	// R
	'resume' => 'Zusammenfassung',

	// T
	'texte_admin_effacer_stats' => 'Dieser Befehl löscht alle Daten der Besucherstatistiken, auch die zur Popularität der Artikel.',
	'texte_admin_effacer_toutes_stats' => 'Die erste Schaltfläche löscht alle Statistiken: Besuche, Beliebtheit der Artikel und eingehende Links.',
	'texte_comment_lire_tableau' => 'Die Position eines Artikels wird durch einen Balken angezeigt. Seine Popularität (eine Schätzung der täglichen Besucher im Fall, dass die Zugriffe konstant bleiben) und die Anzahl der Besuche von Anfang an werden angezeigt, wenn der Mauszeiger über den Titel bewegt wird.',
	'texte_signification' => 'Die roten Balken stellen die Summe der Einträge dar (Summe der Unterrubriken), die hellen Balken symbolisieren die Anzahl der Seitenabrufe pro Rubrik.',
	'titre_evolution_visite' => 'Entwicklung der Seitenabrufe',
	'titre_liens_entrants' => 'Referer',
	'titre_page_statistiques' => 'Statistiken pro Rubrik',
	'titre_page_statistiques_visites' => 'Statistik der Seitenabrufe',

	// V
	'visites_journalieres' => 'Anzahl Besuche pro Tag',
	'visites_mensuelles' => 'Anzahl Besucher pro Monat'
);

?>
