<?php
// This is a SPIP language file  --  Ceci est un fichier langue de SPIP
// extrait automatiquement de http://trad.spip.net/tradlang_module/dump?lang_cible=pl
// ** ne pas modifier le fichier **

if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}

$GLOBALS[$GLOBALS['idx_lang']] = array(

	// B
	'bouton_restaurer_base' => 'Przywróć bazę danych',

	// I
	'info_restauration_sauvegarde' => 'odtworzenie zapisanego pliku @archive@', # MODIF
	'info_sauvegarde' => 'Backup',
	'info_sauvegarde_reussi_02' => '<Baza danych została zapisana w @archive@. Możesz',
	'info_sauvegarde_reussi_03' => 'powrót do zarządzania',
	'info_sauvegarde_reussi_04' => 'Twojej strony.',

	// T
	'texte_admin_tech_01' => 'Ta opcja pozwala Ci zapisać zawartość bazy danych w pliku, który zostanie zachowany w katalogu @dossier@. Pamiętaj także o skopiowaniu całego katalogu @img@, który zawiera obrazki i dokumenty używane w artykułach i działach.',
	'texte_admin_tech_02' => 'Uwaga: tą kopię bezpieczeństwa będzie można odtworzyć
 TYLKO I WYŁĄCZNIE w serwisie opartym na tej samej wersji SPIP. Nie wolno  "oprózniać bazy danych" sądząc, że po zaktualizowaniu SPIP będzie można odtworzyć bazę z backupu. Więcej informacji w <a href="@spipnet@">dokumentacji SPIP</a>.', # MODIF
	'texte_restaurer_base' => 'Odtwórz zawartość kopii bezpieczeństwa bazy',
	'texte_restaurer_sauvegarde' => 'Ta opcja pozwala Ci odtworzyć poprzednią kopię bezpieczeństwa
  bazy danych. Aby móc to uczynić plik - kopia bezpieczeństwa powienien być
  umieszczony w katalogu @dossier@.
  Bądź ostrożny korzystając z tej funkcji : <b> modyfikacje i ewentualne straty, są
  nieodwracalne.</b>', # MODIF
	'texte_sauvegarde' => 'Backup zawartości bazy danych',
	'texte_sauvegarde_base' => 'Backup bazy danych'
);

?>
