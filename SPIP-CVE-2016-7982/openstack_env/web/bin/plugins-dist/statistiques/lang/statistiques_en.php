<?php
// This is a SPIP language file  --  Ceci est un fichier langue de SPIP
// extrait automatiquement de http://trad.spip.net/tradlang_module/statistiques?lang_cible=en
// ** ne pas modifier le fichier **

if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}

$GLOBALS[$GLOBALS['idx_lang']] = array(

	// A
	'archiver' => 'Archive',
	'archiver_concatener_explications' => 'This operation will combine the statistics of visits to articles:',
	'archiver_concatener_ignorer' => 'The visits of at least @nb@ years are not affected.',
	'archiver_concatener_par_an' => 'Additional visits of @nb@ years will be combined, for every article, on the first day of every year.',
	'archiver_concatener_par_mois' => 'Additional visits of @nb@ years will be combined, for every article, on the first day of every month.',
	'archiver_conseil_sauvegarde' => 'It is advisable to backup the database first.',
	'archiver_description' => 'This page provides tools to clean or archive the statistics of the site.',
	'archiver_et_nettoyer' => 'Archive and clean',
	'archiver_nettoyer' => 'Clean',
	'archiver_nettoyer_explications' => 'Removes lines of "referrers" or "visits" to which items do not exist (anymore) in the database.',
	'archiver_nettoyer_referers_articles' => 'Clean referers_articles',
	'archiver_nettoyer_visites_articles' => 'Clean visites_articles',
	'archiver_nombre_lignes' => 'Number of lines',
	'archiver_operation_longue' => 'This operation could take a lot of time especially on the first execution.',
	'archiver_operations_irreversibles' => 'These operations can’t be undone!',

	// B
	'bouton_effacer_referers' => 'Delete only incoming links',
	'bouton_effacer_statistiques' => 'Delete all statistics',

	// C
	'csv' => 'csv',

	// I
	'icone_evolution_visites' => 'Number of visits <br />@visites@ visits',
	'icone_repartition_actuelle' => 'Show current distribution',
	'icone_repartition_visites' => 'Distribution of Visits',
	'icone_statistiques_visites' => 'Statistics',
	'info_affichier_visites_articles_plus_visites' => 'Show visits for <b>the most popular articles of all time:</b>',
	'info_comment_lire_tableau' => 'How to read this graph',
	'info_forum_statistiques' => 'Visit statistics',
	'info_graphiques' => 'Graphs',
	'info_popularite_2' => 'site popularity:',
	'info_popularite_3' => 'popularity: @popularite@; visits: @visites@',
	'info_popularite_5' => 'popularity:',
	'info_previsions' => 'forecasts:',
	'info_question_vignettes_referer' => 'When you consult the statistics, you can see a preview of any referring sites from which a visitor came. ',
	'info_question_vignettes_referer_oui' => 'Show screenshots of referring sites',
	'info_tableaux' => 'Tables',
	'info_visites' => 'visits:',
	'info_visites_plus_populaires' => 'Show visits for <b>the most popular articles</b> and <b>the most recent articles:</b>',
	'info_zoom' => 'zoom',
	'item_gerer_statistiques' => 'Manage visitor statistics',

	// O
	'onglet_origine_visites' => 'Visitors came from',
	'onglet_repartition_debut' => 'of all time',
	'onglet_repartition_lang' => 'Distribution by language',

	// R
	'resume' => 'Resume',

	// T
	'texte_admin_effacer_stats' => 'This command deletes all statistics on visits to the site, including article popularity.',
	'texte_admin_effacer_toutes_stats' => 'The first button deletes all statistics: visits, articles popularity and referers.',
	'texte_comment_lire_tableau' => 'The rank of the article in the popularity rating is indicated in the margin; the popularity of the article (an estimation of the number of daily visits it receives if the current flow of  consultation continues) and the number of visits received since the beginning are displayed in the tooltip that appears when the mouse is hovering the title.',
	'texte_signification' => 'Dark bars represent cumulative entries (total subsections), light bars represent the number of visits for each section.',
	'titre_evolution_visite' => 'Visitor Statistics',
	'titre_liens_entrants' => 'Incoming links',
	'titre_page_statistiques' => 'Statistics by section',
	'titre_page_statistiques_visites' => 'Visit statistics',

	// V
	'visites_journalieres' => 'Number of visits per day',
	'visites_mensuelles' => 'Number of visits per month'
);

?>
