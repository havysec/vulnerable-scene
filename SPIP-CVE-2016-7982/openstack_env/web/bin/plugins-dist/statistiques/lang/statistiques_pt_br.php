<?php
// This is a SPIP language file  --  Ceci est un fichier langue de SPIP
// extrait automatiquement de http://trad.spip.net/tradlang_module/statistiques?lang_cible=pt_br
// ** ne pas modifier le fichier **

if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}

$GLOBALS[$GLOBALS['idx_lang']] = array(

	// A
	'archiver' => 'Arquivar',
	'archiver_concatener_explications' => 'Esta operação vai concatenar as estatísticas de visitasção das matérias',
	'archiver_concatener_ignorer' => 'As visitas com menos de @nb@ anos N#ao serão alteradas.',
	'archiver_concatener_par_an' => 'As visitas com mais de @nb@ anos serão concatenadas, para cada matéria, no primeiro dia do ano.',
	'archiver_concatener_par_mois' => 'As visitas com mais de @nb@ anos serão concatenadas, para cada matéria, no primeiro dia de cada mês.',
	'archiver_conseil_sauvegarde' => 'É recomendável fazer um backup prévio da base de dados.',
	'archiver_description' => 'Esta página fornece as ferramentas para limpar ou arquivar as estat’isticas do site.',
	'archiver_et_nettoyer' => 'Arquivar e limpar',
	'archiver_nettoyer' => 'Limpar',
	'archiver_nettoyer_explications' => 'Remove as linhas dos referenciadores ou das visitas que não existem (mais) na base de dados.', # MODIF
	'archiver_nettoyer_referers_articles' => 'Limpar os referenciadores das matérias', # MODIF
	'archiver_nettoyer_visites_articles' => 'Limpar as visitas das matérias', # MODIF
	'archiver_nombre_lignes' => 'Número de linhas',
	'archiver_operation_longue' => 'Esta operação pode ser muito demorada, especialmente na primeira execução.',
	'archiver_operations_irreversibles' => 'Estas operações são irreversíveis!',

	// B
	'bouton_effacer_referers' => 'Apagar somente os links de entrada',
	'bouton_effacer_statistiques' => 'Apagar todas as estatísticas',

	// C
	'csv' => 'csv',

	// I
	'icone_evolution_visites' => 'Evolução das visitas<br />@visites@ visitas',
	'icone_repartition_actuelle' => 'Exibir a repartição atual',
	'icone_repartition_visites' => 'Repartição das visitas',
	'icone_statistiques_visites' => 'Estatísticas',
	'info_affichier_visites_articles_plus_visites' => 'Exibir as visitas para <b>as matérias mais visitada após o lançamento:</b>',
	'info_comment_lire_tableau' => 'Como ler esta tabela',
	'info_forum_statistiques' => 'Estatísticas das visitas',
	'info_graphiques' => 'Gráficos',
	'info_popularite_2' => 'popularidade do site:',
	'info_popularite_3' => 'popularidade: @popularite@; visitas: @visites@',
	'info_popularite_5' => 'popularidade:',
	'info_previsions' => 'previsões:',
	'info_question_vignettes_referer' => 'Ao consultar as estatísticas, você poderá visualizar resumos dos sites que originaram as visitas',
	'info_question_vignettes_referer_oui' => 'Exibir as capturas dos sites de origem das visitas',
	'info_tableaux' => 'Tabelas',
	'info_visites' => 'visitas:',
	'info_visites_plus_populaires' => 'Exibir os visitantes para <b>as matérias mais populares</b> e para <b>as mais recentes matérias publicadas:</b>',
	'info_zoom' => 'zoom',
	'item_gerer_statistiques' => 'Gerenciar estatísticas de visitas',

	// O
	'onglet_origine_visites' => 'Origem das visitas',
	'onglet_repartition_debut' => 'desde o início',
	'onglet_repartition_lang' => 'Repartição por idiomas',

	// R
	'resume' => 'Resumo',

	// T
	'texte_admin_effacer_stats' => 'Este comando apaga todos os dados ligados às estatísticas de visitação do site, incluindo a popularidade das matérias.',
	'texte_admin_effacer_toutes_stats' => 'O primeiro botão remove todas as estatísticas: visitas, popularidade das matérias e links de entrada.',
	'texte_comment_lire_tableau' => 'A classificação da matéria, na classificação por popularidade, é indicada na margem; a popularidade de uma matéria (uma estimativa do número de visitas diárias que ela receberia se o ritmo atual de acesso se mantivesse) e o número de visitas recebidas depois do lançamento são exibidas na dica que aparece quando o cursor do mouse se sobrepõe ao título.',
	'texte_signification' => 'As barras escuras representão as entradas acumuladas (total das subseções), as barras claras, o número de visitas para cada seção.',
	'titre_evolution_visite' => 'Evolução das visitas',
	'titre_liens_entrants' => 'Links de entrada',
	'titre_page_statistiques' => 'Estatísticas por seções',
	'titre_page_statistiques_visites' => 'Estatísticas de visitas',

	// V
	'visites_journalieres' => 'Número de visitas por dia',
	'visites_mensuelles' => 'Número de visitas por mês'
);

?>
