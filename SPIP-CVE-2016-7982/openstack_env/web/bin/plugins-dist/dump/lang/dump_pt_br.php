<?php
// This is a SPIP language file  --  Ceci est un fichier langue de SPIP
// extrait automatiquement de http://trad.spip.net/tradlang_module/dump?lang_cible=pt_br
// ** ne pas modifier le fichier **

if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}

$GLOBALS[$GLOBALS['idx_lang']] = array(

	// A
	'aucune_donnee' => 'vazio',
	'avis_probleme_ecriture_fichier' => 'Problema de escrita do arquivo @fichier@',

	// B
	'bouton_restaurer_base' => 'Restaurar a base',

	// C
	'confirmer_ecraser_base' => 'Sim, quero substituir minha base de dados por essa cópia de segurança',
	'confirmer_ecraser_tables_selection' => 'Sim, quero substituir as tabelas selecionadas por essa cópia de segurança',
	'confirmer_supprimer_sauvegarde' => 'Tem certeza de que quer remover essa cópia de segurança?',

	// D
	'details_sauvegarde' => 'Detalhes da cópia de segurança:',

	// E
	'erreur_aucune_donnee_restauree' => 'Nenhum dado restaurado',
	'erreur_connect_dump' => 'Já existe um servidor chamado «@dump@». Escolha outro nome.',
	'erreur_creation_base_sqlite' => 'Impossível criar uma base SQLite para a cópia de segurança',
	'erreur_nom_fichier' => 'Este nome de arquivo não é autorizado',
	'erreur_restaurer_verifiez' => 'Corrija o erro para poder restaurar.',
	'erreur_sauvegarde_deja_en_cours' => 'Você já possui uma cópia de segurança em andamento',
	'erreur_sqlite_indisponible' => 'Não foi possível fazer uma cópia de segurança SQLite em seu provedor de hospedagem',
	'erreur_table_absente' => 'Tabela @table@ ausente',
	'erreur_table_donnees_manquantes' => 'Tabela @table@, faltando dados',
	'erreur_taille_sauvegarde' => 'A cópia de segurança parece ter falhado. O arquivo @fichier@ está vazio ou não existe.',

	// I
	'info_aucune_sauvegarde_trouvee' => 'Nenhuma cópia de segurança encontrada',
	'info_restauration_finie' => 'Pronto! A cópia de segurança @archive@ foi restaurada em seu site. Você pode',
	'info_restauration_sauvegarde' => 'Restauração da cópia de segurança @archive@',
	'info_sauvegarde' => 'Cópia de segurança',
	'info_sauvegarde_reussi_02' => 'A cópia de segurança da base foi gravada em @archive@. Você pode',
	'info_sauvegarde_reussi_03' => 'voltar para o gerenciamento',
	'info_sauvegarde_reussi_04' => 'do seu site.',
	'info_selection_sauvegarde' => 'Você escolheu restaurar a cópia de segurança @fichier@. Esta operação é irreversível.',

	// L
	'label_nom_fichier_restaurer' => 'Ou indique o nome do arquivo a ser restaurado',
	'label_nom_fichier_sauvegarde' => 'Nome do arquivo para a cópia de segurança',
	'label_selectionnez_fichier' => 'Selecione um arquivo na lista',

	// N
	'nb_donnees' => '@nb@ registros',

	// R
	'restauration_en_cours' => 'Restauração em andamento',

	// S
	'sauvegarde_en_cours' => 'Cópia de segurança em andamento',
	'sauvegardes_existantes' => 'Cópias de segurança existentes',
	'selectionnez_table_a_restaurer' => 'Selecione as tabelas que quer restaurar',

	// T
	'texte_admin_tech_01' => 'Esta opção permite fazer uma cópia de segurança do conteúdo da base num arquivo que será gravado no diretório @dossier@. Não se esqueça, também, de transferir a totalidade do diretório @img@, que contém as imagens e os documentos usados nas matérias e nas seções.',
	'texte_admin_tech_02' => 'Atenção: esta cópia de segurança só poderá ser restaurada em um site com a mesma versão do SPIP. Sobretudo, não «limpe a base» com o objetivo de reinstalar a cópia de segurança após uma atualização... Consulte <a href="@spipnet@">a documentação do SPIP</a>.',
	'texte_restaurer_base' => 'Restaurar o conteúdo de uma cópia de segurança da base',
	'texte_restaurer_sauvegarde' => 'Esta opção permite restaurar uma cópia de segurança previamente efetuada da base. Para isso, o arquivo contendo a cópia de segurança precisa ser colocado no diretório @dossier@.
Seja cuidadoso com esta funcionalidade: <b>as alterações e, eventualmente perdas, são irreversíveis.</b>',
	'texte_sauvegarde' => 'Fazer uma cópia de segurança do conteúdo da base',
	'texte_sauvegarde_base' => 'Fazer uma cópia de segurança da base',
	'tout_restaurer' => 'Restaurar todas as tabelas',
	'tout_sauvegarder' => 'Fazer cópia de segurança de todas as tabelas',

	// U
	'une_donnee' => '1 registro'
);

?>
