<?php
// This is a SPIP language file  --  Ceci est un fichier langue de SPIP
// extrait automatiquement de http://trad.spip.net/tradlang_module/dump?lang_cible=fr_tu
// ** ne pas modifier le fichier **

if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}

$GLOBALS[$GLOBALS['idx_lang']] = array(

	// A
	'aucune_donnee' => 'vide',
	'avis_probleme_ecriture_fichier' => 'Problème d’écriture du fichier @fichier@',

	// B
	'bouton_restaurer_base' => 'Restaurer la base',

	// C
	'confirmer_ecraser_base' => 'Oui, je veux écraser ma base avec cette sauvegarde',
	'confirmer_ecraser_tables_selection' => 'Oui, je veux écraser les tables sélectionnées avec cette sauvegarde',
	'confirmer_supprimer_sauvegarde' => 'Es-tu sûr de vouloir supprimer cette sauvegarde ?',

	// D
	'details_sauvegarde' => 'Détails de la sauvegarde :',

	// E
	'erreur_aucune_donnee_restauree' => 'Aucune donnée restaurée',
	'erreur_connect_dump' => 'Un serveur nommé « @dump@ » existe déjà. Renomme-le.',
	'erreur_creation_base_sqlite' => 'Impossible de créer une base SQLite pour la sauvegarde',
	'erreur_nom_fichier' => 'Ce nom de fichier n’est pas autorisé',
	'erreur_restaurer_verifiez' => 'Corrige l’erreur pour pouvoir restaurer.',
	'erreur_sauvegarde_deja_en_cours' => 'Tu as déjà une sauvegarde en cours',
	'erreur_sqlite_indisponible' => 'Impossible de faire une sauvegarde SQLite sur votre hébergement',
	'erreur_table_absente' => 'Table @table@ absente',
	'erreur_table_donnees_manquantes' => 'Table @table@, données manquantes',
	'erreur_taille_sauvegarde' => 'La sauvegarde semble avoir échoué. Le fichier @fichier@ est vide ou absent.',

	// I
	'info_aucune_sauvegarde_trouvee' => 'Aucune sauvegarde trouvée',
	'info_restauration_finie' => 'C’est fini ! La sauvegarde @archive@ a été restaurée dans votre site. Tu peux',
	'info_restauration_sauvegarde' => 'Restauration de la sauvegarde @archive@',
	'info_sauvegarde' => 'Sauvegarde',
	'info_sauvegarde_reussi_02' => 'La base a été sauvegardée dans @archive@. Tu peux',
	'info_sauvegarde_reussi_03' => 'retourner à la gestion',
	'info_sauvegarde_reussi_04' => 'de ton site.',
	'info_selection_sauvegarde' => 'Tu as choisi de restaurer la sauvegarde @fichier@. Cette opération est irréversible.',

	// L
	'label_nom_fichier_restaurer' => 'Ou indique le nom du fichier à restaurer',
	'label_nom_fichier_sauvegarde' => 'Nom du fichier pour la sauvegarde',
	'label_selectionnez_fichier' => 'Sélectionne un fichier dans la liste',

	// N
	'nb_donnees' => '@nb@ enregistrements',

	// R
	'restauration_en_cours' => 'Restauration en cours',

	// S
	'sauvegarde_en_cours' => 'Sauvegarde en cours',
	'sauvegardes_existantes' => 'Sauvegardes existantes',
	'selectionnez_table_a_restaurer' => 'Sélectionne les tables à restaurer',

	// T
	'texte_admin_tech_01' => 'Cette option te permet de sauvegarder le contenu de la base dans un fichier qui sera stocké dans le répertoire @dossier@.N’oublie pas également de récupérer l’intégralité du répertoire @img@, qui contient les images et les documents utilisés dans les articles et les rubriques.',
	'texte_admin_tech_02' => 'Attention : cette sauvegarde ne pourra être restaurée QUE dans un site installé sous la même version de SPIP. Il ne faut donc surtout pas « vider la base » en espérant réinstaller la sauvegarde après une mise à jour… Consulte <a href="@spipnet@">la documentation de SPIP</a>.',
	'texte_restaurer_base' => 'Restaurer le contenu d’une sauvegarde de la base',
	'texte_restaurer_sauvegarde' => 'Cette option te permet de restaurer une sauvegarde précédemment effectuée de la base. À cet effet, le fichier contenant la sauvegarde doit avoir été placé dans le répertoire @dossier@.
Sois prudent avec cette fonctionnalité : <b>les modifications, pertes éventuelles, sont irréversibles.</b>',
	'texte_sauvegarde' => 'Sauvegarder le contenu de la base',
	'texte_sauvegarde_base' => 'Sauvegarder la base',
	'tout_restaurer' => 'Restaurer toutes les tables',
	'tout_sauvegarder' => 'Sauvegarder toutes les tables',

	// U
	'une_donnee' => '1 enregistrement'
);

?>
