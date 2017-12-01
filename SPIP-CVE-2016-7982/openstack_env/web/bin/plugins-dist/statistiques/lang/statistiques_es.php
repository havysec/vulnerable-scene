<?php
// This is a SPIP language file  --  Ceci est un fichier langue de SPIP
// extrait automatiquement de http://trad.spip.net/tradlang_module/statistiques?lang_cible=es
// ** ne pas modifier le fichier **

if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}

$GLOBALS[$GLOBALS['idx_lang']] = array(

	// A
	'archiver' => 'Archivar',
	'archiver_concatener_explications' => 'Esta operación va a concatenar las estadísticas de visitas de los artículos:',
	'archiver_concatener_ignorer' => 'Las visitas de menos de @nb@ años no se han tocado.',
	'archiver_concatener_par_an' => 'Las visitas de más de @nb@ años serán concatenadas, para cada artículo, durante el primer día de cada año. ',
	'archiver_concatener_par_mois' => 'Las visitas de más de @nb@ años serán concatenadas, para cada artículo, durante el primer día de cada mes.',
	'archiver_conseil_sauvegarde' => 'Es aconsejable hacer una copia de seguridad previa de la base de datos.',
	'archiver_description' => 'Esta página proporciona herramientas para limpiar o archivar las estadísticas del sitio.',
	'archiver_et_nettoyer' => 'Archivar y limpiar',
	'archiver_nettoyer' => 'Limpiar',
	'archiver_nettoyer_explications' => 'Elimina las líneas de "referenciadores" o de "visitas" cuyos artículos no existen (o ya no existen) en la base de datos.',
	'archiver_nettoyer_referers_articles' => 'Limpiar referers_articles',
	'archiver_nettoyer_visites_articles' => 'Limpiar visites_articles',
	'archiver_nombre_lignes' => 'Número de líneas',
	'archiver_operation_longue' => 'Esta operación puede ser muy larga, sobre todo durante la primera ejecución.',
	'archiver_operations_irreversibles' => '¡Estas operaciones son irreversibles!',

	// B
	'bouton_effacer_referers' => 'Eliminar sólo los enlaces entrantes',
	'bouton_effacer_statistiques' => 'Borrar todas las estadísticas',

	// C
	'csv' => 'csv',

	// I
	'icone_evolution_visites' => 'Evolución de las visitas<br />@visites@ visitas',
	'icone_repartition_actuelle' => 'Mostrar el reparto actual',
	'icone_repartition_visites' => 'Distribución de las visitas',
	'icone_statistiques_visites' => 'Estadísticas de visitas',
	'info_affichier_visites_articles_plus_visites' => 'Mostrar las visitas de <b>los artículos más visitados desde el inicio:</b>',
	'info_comment_lire_tableau' => 'Como leer este cuadro',
	'info_forum_statistiques' => 'Estadísticas de las visitas',
	'info_graphiques' => 'Gráficos',
	'info_popularite_2' => 'Popularidad del sitio:',
	'info_popularite_3' => 'Popularidad: @popularite@  Visitas: @visites@',
	'info_popularite_5' => 'Popularidad:',
	'info_previsions' => 'pronósticos:',
	'info_question_vignettes_referer' => 'Cuando consultes las estadísticas, puedes tener una vista de los sitios de origen de las visitas',
	'info_question_vignettes_referer_oui' => 'Mostrar las capturas de los sitios de origen de las visitas',
	'info_tableaux' => 'Tablas',
	'info_visites' => 'visitas:',
	'info_visites_plus_populaires' => 'Mostrar las visitas de <b>los artículos más populares</b> y de <b>los últimos artículos publicados</b>',
	'info_zoom' => 'zoom',
	'item_gerer_statistiques' => 'Gestionar las estadísticas de visitas',

	// O
	'onglet_origine_visites' => 'Origen de las visitas',
	'onglet_repartition_debut' => 'desde el principio',
	'onglet_repartition_lang' => 'Distribución por idiomas',

	// R
	'resume' => 'Resumen',

	// T
	'texte_admin_effacer_stats' => 'Esta orden borra todos los datos ligados con las estadísticas de visitas al sitio, incluyendo la popularidad de los artículos.',
	'texte_admin_effacer_toutes_stats' => 'El primer botón elimina todas las estadísticas: visitas, popularidad de los artículos y enlaces entrantes.',
	'texte_comment_lire_tableau' => 'El rango del artículo, en la clasificación por popularidad, está indicado al margen; la popularidad del artículo (una estimación del número de visitas cotidianas que recibirá si el ritmo actual de visitas se mantiene) y el número de visitas recibidas desde el inicio se muestran en el menú que aparece cuando pasamos el cursor sobre el título.',
	'texte_signification' => 'Las barras oscuras representan las entradas acumuladas (total de las subsecciones), las barras claras el número de visitas de cada sección.',
	'titre_evolution_visite' => 'Evolución de las visitas',
	'titre_liens_entrants' => 'Los enlaces entrantes ',
	'titre_page_statistiques' => 'Estadísticas por sección',
	'titre_page_statistiques_visites' => 'Estadísticas de las visitas',

	// V
	'visites_journalieres' => 'Cantidad de visitas por día',
	'visites_mensuelles' => 'Cantidad de visitas por mes'
);

?>
