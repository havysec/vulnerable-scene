<?php
// This is a SPIP language file  --  Ceci est un fichier langue de SPIP
// Fichier source, a modifier dans svn://zone.spip.org/spip-zone/_core_/plugins/statistiques/lang/
if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}

$GLOBALS[$GLOBALS['idx_lang']] = array(

	// A
	'archiver' => 'Archiver',
	'archiver_concatener_explications' => 'Cette opération va concaténer les statistiques de visites des articles :',
	'archiver_concatener_ignorer' => 'Les visites de moins de @nb@ ans ne sont pas touchées.',
	'archiver_concatener_par_an' => 'Les visites de plus de @nb@ ans seront concaténées, pour chaque article, dans le premier jour de chaque année.',
	'archiver_concatener_par_mois' => 'Les visites de plus de @nb@ ans seront concaténées, pour chaque article, dans le premier jour de chaque mois.',
	'archiver_conseil_sauvegarde' => 'Il est conseillé de faire une sauvegarde préalable de la base de données.',
	'archiver_description' => 'Cette page fournit des outils pour nettoyer ou archiver les statistiques du site.',
	'archiver_et_nettoyer' => 'Archiver et nettoyer',
	'archiver_nettoyer' => 'Nettoyer',
	'archiver_nettoyer_explications' => 'Enlève les lignes de "réferers" ou de "visites" dont les articles n’existent pas (ou plus) dans la base de données.',
	'archiver_nettoyer_referers_articles' => 'Nettoyer referers_articles',
	'archiver_nettoyer_visites_articles' => 'Nettoyer visites_articles',
	'archiver_nombre_lignes' => 'Nombre de lignes',
	'archiver_operation_longue' => 'Cette opération peut être très longue, surtout lors de la première exécution.',
	'archiver_operations_irreversibles' => 'Ces opérations sont irréversibles !',

	// B
	'bouton_effacer_referers' => 'Effacer seulement les liens entrants',
	'bouton_effacer_statistiques' => 'Effacer toutes les statistiques',

	// C
	'csv' => 'csv',

	// I
	'icone_evolution_visites' => 'Évolution des visites<br />@visites@ visites',
	'icone_repartition_actuelle' => 'Afficher la répartition actuelle',
	'icone_repartition_visites' => 'Répartition des visites',
	'icone_statistiques_visites' => 'Statistiques',
	'info_affichier_visites_articles_plus_visites' => 'Afficher les visites pour <b>les articles les plus visités depuis le début :</b>',
	'info_comment_lire_tableau' => 'Comment lire ce tableau',
	'info_forum_statistiques' => 'Statistiques des visites',
	'info_graphiques' => 'Graphiques',
	'info_popularite_2' => 'popularité du site :',
	'info_popularite_3' => 'popularité : @popularite@ ; visites : @visites@',
	'info_popularite_5' => 'popularité :',
	'info_previsions' => 'prévisions :',
	'info_referer_oui' => 'Activer les referers',
	'info_question_vignettes_referer' => 'Lorsque vous consultez les statistiques, vous pouvez visualiser des aperçus des sites d’origine des visites',
	'info_question_vignettes_referer_oui' => 'Afficher les captures des sites d’origine des visites',
	'info_tableaux' => 'Tableaux',
	'info_visites' => 'visites :',
	'info_visites_plus_populaires' => 'Afficher les visites pour <b>les articles les plus populaires</b> et pour <b>les derniers articles publiés :</b>',
	'info_zoom' => 'zoom',
	'item_gerer_statistiques' => 'Gérer les statistiques des visites',

	// O
	'onglet_origine_visites' => 'Origine des visites',
	'onglet_repartition_debut' => 'depuis le début',
	'onglet_repartition_lang' => 'Répartition par langues',

	// R
	'resume' => 'Résumé',

	// T
	'texte_admin_effacer_stats' => 'Cette commande efface toutes les données liées aux statistiques de visite du site, y compris la popularité des articles.',
	'texte_admin_effacer_toutes_stats' => 'Le premier bouton supprime toutes les statistiques : visites, popularité des articles et liens entrants.',
	'texte_comment_lire_tableau' => 'Le rang de l’article, dans le classement par popularité, est indiqué dans la marge ; la popularité de l’article (une estimation du nombre de visites quotidiennes qu’il recevra si le rythme actuel de consultation se maintient) et le nombre de visites reçues depuis le début sont affichés dans la bulle qui apparaît lorsque la souris survole le titre.',
	'texte_signification' => 'Les barres foncées représentent les entrées cumulées (total des sous-rubriques), les barres claires le nombre de visites pour chaque rubrique.',
	'titre_evolution_visite' => 'Évolution des visites',
	'titre_liens_entrants' => 'Liens entrants',
	'titre_page_statistiques' => 'Statistiques par rubriques',
	'titre_page_statistiques_visites' => 'Statistiques des visites',

	// V
	'visites_journalieres' => 'Nombre de visites par jour',
	'visites_mensuelles' => 'Nombre de visites par mois'
);

?>
