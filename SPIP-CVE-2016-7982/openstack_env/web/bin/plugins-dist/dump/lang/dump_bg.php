<?php
// This is a SPIP language file  --  Ceci est un fichier langue de SPIP
// extrait automatiquement de http://trad.spip.net/tradlang_module/dump?lang_cible=bg
// ** ne pas modifier le fichier **

if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}

$GLOBALS[$GLOBALS['idx_lang']] = array(

	// B
	'bouton_restaurer_base' => 'Възстановяване на базата данни',

	// I
	'info_restauration_sauvegarde' => 'възстановяване на архива @archive@', # MODIF
	'info_sauvegarde' => 'Архивиране (backup)',
	'info_sauvegarde_reussi_02' => 'Базата данни беше запазена в @archive@. Можете да',
	'info_sauvegarde_reussi_03' => 'се върнете към управлението ',
	'info_sauvegarde_reussi_04' => 'на сайта.',

	// T
	'texte_admin_tech_01' => 'Тази опция позволява запазване насъдържанието от базата данни във файл от директорията @dossier@.Не забравяйте да обновите и цялата @img@ директория, която съдържаизображенията и документите, използвани в статиите и рубриките.',
	'texte_admin_tech_02' => 'Предупреждение: този архив може да бъде  възстановяван САМО в сайт, който има същата версия на СПИП. Не изпразвайте базата данни, защото при актуализация на версията, архивът няма да се преинсталира. За повече информация, посетете <a href="@spipnet@">документацията на СПИП</a>.', # MODIF
	'texte_restaurer_base' => 'Възстановяване съдържанието на архива на базата данни',
	'texte_restaurer_sauvegarde' => 'Тази опция позволява да се възстанови предишния
архив на базата данни. За да се направи това, файлът, който съдържа този архив е съхранен в
директория @dossier@.
Внимавайте с това свойство: <b>Всички потенциални промени или загуби ще бъдат
необратими.</b>', # MODIF
	'texte_sauvegarde' => 'Архивиране съдържанието на базата данни',
	'texte_sauvegarde_base' => 'Архивиране на базата данни'
);

?>
