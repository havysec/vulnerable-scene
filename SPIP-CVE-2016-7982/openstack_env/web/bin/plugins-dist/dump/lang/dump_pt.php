<?php
// This is a SPIP language file  --  Ceci est un fichier langue de SPIP
// extrait automatiquement de http://trad.spip.net/tradlang_module/dump?lang_cible=pt
// ** ne pas modifier le fichier **

if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}

$GLOBALS[$GLOBALS['idx_lang']] = array(

	// A
	'aucune_donnee' => 'vazio',
	'avis_probleme_ecriture_fichier' => 'Problema de escrita no ficheiro @fichier@',

	// B
	'bouton_restaurer_base' => 'Restaurar a base de dados',

	// C
	'confirmer_ecraser_base' => 'Sim, desejo reescrever a minha base de dados com a cópia de segurança',
	'confirmer_ecraser_tables_selection' => 'Sim, desejo reescrever as tabelas seleccionadas com a cópia de segurança',

	// D
	'details_sauvegarde' => 'Detalhes da cópia de segurança:',

	// E
	'erreur_aucune_donnee_restauree' => 'Sem dados restaurados',
	'erreur_connect_dump' => 'Já existe um servidor com o nome « @dump@ » Por favor escolha outro nome.',
	'erreur_creation_base_sqlite' => 'Impossível criar uma base de dados SQLite para a cópia de segurança',
	'erreur_nom_fichier' => 'Este nome de ficheiro não é autorizado',
	'erreur_restaurer_verifiez' => 'Corrija o erro para poder restaurar.',
	'erreur_sauvegarde_deja_en_cours' => 'Já tem uma cópia de segurança em curso',
	'erreur_sqlite_indisponible' => 'Impossível criar uma cópia de segurança SQLite no seu serviço de hospedagem',
	'erreur_table_absente' => 'Tabela @table@ inexistente',
	'erreur_table_donnees_manquantes' => 'Tabela @table@, dados em falta',
	'erreur_taille_sauvegarde' => 'A cópia de segurança parece ter falhado. O ficheiro @fichier@ está vazio ou ausente.',

	// I
	'info_aucune_sauvegarde_trouvee' => 'Nenhuma cópia de segurança encontrada',
	'info_restauration_finie' => 'Terminou !. A cópia de segurança @archive@ foi restaurada no seu sítio. Pode',
	'info_restauration_sauvegarde' => 'restauro da cópia de segurança @archive@',
	'info_sauvegarde' => 'Cópia de segurança',
	'info_sauvegarde_reussi_02' => 'Foi criada uma cópia de segurança da base de dados em @archive@. Pode',
	'info_sauvegarde_reussi_03' => 'voltar à gestão',
	'info_sauvegarde_reussi_04' => 'do seu sítio',
	'info_selection_sauvegarde' => 'Escolheu restaurar a cópia de segurança @fichier@. esta operação é irreversível.',

	// L
	'label_nom_fichier_restaurer' => 'Ou indique o nome do ficheiro a restaurar',
	'label_nom_fichier_sauvegarde' => 'Nome do ficheiro para a cópia de segurança',
	'label_selectionnez_fichier' => 'Seleccione um ficheiro na lista',

	// N
	'nb_donnees' => '@nb@ registos',

	// R
	'restauration_en_cours' => 'Restauro em curso',

	// S
	'sauvegarde_en_cours' => 'Cópia de segurança em curso',
	'sauvegardes_existantes' => 'Cópias de segurança existentes',
	'selectionnez_table_a_restaurer' => 'Seleccione as tabelas a restaurar',

	// T
	'texte_admin_tech_01' => 'Esta opção permite-lhe guardar o conteúdo da base num ficheiro que será armazenado no directório @dossier@. Não esqueça de recuperar a totalidade do directório @img@, que contém as imagens e os documentos utlizados nos artigos e rubricas.',
	'texte_admin_tech_02' => 'Atenção: esta cópia de segurança só poderá ser restaurada
 num sítio instalado sob a mesma versão de SPIP. Nunca apague a sua base de dados esperando que esta seja reinstalada após uma actualização. Consulte <a href="@spipnet@">a documentação de SPIP</a>.',
	'texte_restaurer_base' => 'Restaurar o conteúdo de uma cópia de segurança da base de dados',
	'texte_restaurer_sauvegarde' => 'Esta opção permite restaurar uma cópia de segurança anteriormente
efectuada à base de dados. Para esse efeito, o ficheiro que contém a cópia de segurança deve ter sido
 guardado no directório @dossier@.
 Seja prudente com esta funcionalidade : <b>as eventuais modificações, e/ou perdas são irreversíveis.</b>  ',
	'texte_sauvegarde' => 'Criar uma cópia de segurança do conteúdo da base de dados',
	'texte_sauvegarde_base' => 'Criar uma cópia de segurança da base de dados',
	'tout_restaurer' => 'Restaurar todas a tabelas',
	'tout_sauvegarder' => 'Criar cópia de segurança de todas as tabelas',

	// U
	'une_donnee' => '1 registo'
);

?>
