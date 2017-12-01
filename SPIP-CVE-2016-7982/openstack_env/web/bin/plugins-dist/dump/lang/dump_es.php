<?php
// This is a SPIP language file  --  Ceci est un fichier langue de SPIP
// extrait automatiquement de http://trad.spip.net/tradlang_module/dump?lang_cible=es
// ** ne pas modifier le fichier **

if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}

$GLOBALS[$GLOBALS['idx_lang']] = array(

	// A
	'aucune_donnee' => 'vacío',
	'avis_probleme_ecriture_fichier' => 'Problema de escritura del archivo @fichier@',

	// B
	'bouton_restaurer_base' => 'Restaurar la base',

	// C
	'confirmer_ecraser_base' => 'Sí, quiero destruir mi base con la restauración de este respaldo. ',
	'confirmer_ecraser_tables_selection' => 'Sí, quiero destruir las tablas seleccionadas con la restauración de este respaldo',
	'confirmer_supprimer_sauvegarde' => '¿Está seguro de querer eliminar esta copia de seguridad?',

	// D
	'details_sauvegarde' => 'Detalles del respaldo:',

	// E
	'erreur_aucune_donnee_restauree' => 'Ningún dato restaurado',
	'erreur_connect_dump' => 'Un servidor denominado « @dump@ » ya existe. Elija otro nombre.',
	'erreur_creation_base_sqlite' => 'Imposible crear una base SQLite para la copia de seguridad',
	'erreur_nom_fichier' => 'Este nombre de archivo no está autorizado',
	'erreur_restaurer_verifiez' => 'Corrija el error para poder restaurarlo.',
	'erreur_sauvegarde_deja_en_cours' => 'Ya tiene una copia de seguridad en curso.',
	'erreur_sqlite_indisponible' => 'Imposible hacer un copia de seguridad SQLite en su espacio de alojamiento.',
	'erreur_table_absente' => 'Tabla @table@ ausente',
	'erreur_table_donnees_manquantes' => 'Tabla @table@, faltan datos',
	'erreur_taille_sauvegarde' => 'La copia de seguridad parece haber fallado. El archivo @fichier@ está vacío o ausente.',

	// I
	'info_aucune_sauvegarde_trouvee' => 'Ninguna copia de seguridad encontrada',
	'info_restauration_finie' => '¡Ya está! La copia de seguridad @archive@ ha sido restaurada en su sitio. Puedes',
	'info_restauration_sauvegarde' => 'Restauración de la copia de seguridad @archive@',
	'info_sauvegarde' => 'Copia de seguridad',
	'info_sauvegarde_reussi_02' => 'La base se ha guardado en @archive@. Puedes',
	'info_sauvegarde_reussi_03' => 'volver a la gestión',
	'info_sauvegarde_reussi_04' => 'del sitio.',
	'info_selection_sauvegarde' => 'Ha elegido restaurar la copia de seguridad  @fichier@. Esta operación es irreversible.',

	// L
	'label_nom_fichier_restaurer' => 'O indique el nombre del archivo a restaurar',
	'label_nom_fichier_sauvegarde' => 'Nombre del archivo para la copia de seguridad',
	'label_selectionnez_fichier' => 'Seleccione un archivo en la lista',

	// N
	'nb_donnees' => '@nb@ registros',

	// R
	'restauration_en_cours' => 'Restauración en courso',

	// S
	'sauvegarde_en_cours' => 'Copia de seguridad en curso',
	'sauvegardes_existantes' => 'Copias de seguridad existentes',
	'selectionnez_table_a_restaurer' => 'Seleccione las tablas a restaurar',

	// T
	'texte_admin_tech_01' => 'Esta opción le permite guardar el contenido de la base en un archivo que será almacenado en la carpeta @dossier@. No olvide asimismo recuperar la totalidad de la carpeta @img@, que contiene las imágenes y los documentos utilizadas en los artículos y secciones.',
	'texte_admin_tech_02' => '¡Atención! Esta copia de seguridad SÓLO podrá ser restaurada en un sitio que utilice la misma versión de SPIP. Por ningún motivo se deberá «vaciar la base» esperando volver a instalar la copia de seguridad después de una actualización. Consulte la <a href="@spipnet@">documentación de SPIP</a>.',
	'texte_restaurer_base' => 'Restaurar el contenido de una copia de seguridad',
	'texte_restaurer_sauvegarde' => 'Esta opción le permite restaurar una copia de seguridad de la base efectuada anteriormente. A tal efecto, el archivo que contiene la copia de seguridad debe estar en la carpeta @dossier@. 
Sea prudente con esta funcionalidad: <b>las modificaciones, eventuales pérdidas, son irreversibles.</b>',
	'texte_sauvegarde' => 'Guardar el contenido de la base',
	'texte_sauvegarde_base' => 'Guardar la base',
	'tout_restaurer' => 'Restaurar todas las tablas',
	'tout_sauvegarder' => 'Guardar todas las tablas',

	// U
	'une_donnee' => '1 registro'
);

?>
