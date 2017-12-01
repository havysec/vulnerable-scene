<?php
// This is a SPIP language file  --  Ceci est un fichier langue de SPIP
// extrait automatiquement de http://trad.spip.net/tradlang_module/dump?lang_cible=uk
// ** ne pas modifier le fichier **

if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}

$GLOBALS[$GLOBALS['idx_lang']] = array(

	// A
	'aucune_donnee' => 'порожньо',
	'avis_probleme_ecriture_fichier' => 'Не вдалося зберегти файл @fichier@',

	// B
	'bouton_restaurer_base' => 'Відновити базу даних',

	// C
	'confirmer_ecraser_base' => 'Так, я хочу перезаписати усю поточну інформацію даними з резервної копії',
	'confirmer_ecraser_tables_selection' => 'Так, я хочу замінити інформацію в обраних таблицях даними з резервної копії.',
	'confirmer_supprimer_sauvegarde' => 'Ви впевнені, що хочете видалити цю резервну копію?',

	// D
	'details_sauvegarde' => 'Інформація про резервну копію:',

	// E
	'erreur_aucune_donnee_restauree' => 'Не вдалося відновити інформацію',
	'erreur_connect_dump' => 'Сервер „@dump@” вже існує. Перейменуйте його.',
	'erreur_creation_base_sqlite' => 'Не вдалося створити SQLite базу для бекапу',
	'erreur_nom_fichier' => 'Дана назва файлу не є дозволеною',
	'erreur_restaurer_verifiez' => 'Виправте помилки для того, щоб продовжити відновлення.',
	'erreur_sauvegarde_deja_en_cours' => 'Резервна копія вже створюється',
	'erreur_sqlite_indisponible' => 'Не вдалося зробити резервну копію SQLite на вашому хостингу',
	'erreur_table_absente' => 'Не вистачає таблиці @table@ ',
	'erreur_table_donnees_manquantes' => 'В таблиці @table@ нема інформації',
	'erreur_taille_sauvegarde' => 'Проблеми з резервною копією. Схоже, що файл @fichier@ порожній або відсутній.',

	// I
	'info_aucune_sauvegarde_trouvee' => 'Резервні копії не знайдено',
	'info_restauration_finie' => 'Відновлення завершено! Резервну копію @archive@ завантажено на сайт. Ви можете',
	'info_restauration_sauvegarde' => 'Відновлення резервної копії @archive@',
	'info_sauvegarde' => 'Резервна копія',
	'info_sauvegarde_reussi_02' => 'Базу даних було збережено в @archive@. Ви можете',
	'info_sauvegarde_reussi_03' => 'повернутися до налаштувань',
	'info_sauvegarde_reussi_04' => 'сайту.',
	'info_selection_sauvegarde' => 'Ви вирішили відновити інформацію з резервної копії в файлі @fichier@. Дана операція незворотна.',

	// L
	'label_nom_fichier_restaurer' => '... або вкажіть назву файлу з резервною копією:',
	'label_nom_fichier_sauvegarde' => 'Назва файлу резервної копії',
	'label_selectionnez_fichier' => 'Оберіть файл зі списку:',

	// N
	'nb_donnees' => '@nb@ записів',

	// R
	'restauration_en_cours' => 'Йде відновлення',

	// S
	'sauvegarde_en_cours' => 'Йде збереження даних',
	'sauvegardes_existantes' => 'Резервні копії',
	'selectionnez_table_a_restaurer' => 'Обрати таблиці для відновлення',

	// T
	'texte_admin_tech_01' => 'Ви можете зробити резервну копію бази даних. Файл буде збережено в каталозі @dossier@. Не забудьте скопіювати папку @img@, в які збережені зображення і завантажені файли. Усі файли необхідно скопіювати на локальний комп’ютер або інший сервер.',
	'texte_admin_tech_02' => 'Увага: ви можете відновити резервну копію лише в тій версії SPIP, в якій ви її створили. Детальніше див. <a href="@spipnet@">документацію</a>.',
	'texte_restaurer_base' => 'Відновлення з резервної копії',
	'texte_restaurer_sauvegarde' => 'Ви можете відновити сайт з резервної копії. Для цього помістить файл з копією в папку @dossier@.<br />
<b>Увага:</b>  уся поточна інформація буде замінена інформацією з резервної копії. Ця операція незворотна! Якщо ви не певні в тому, що ви робите, - зробіть резервну копію перед початком відновлення. ',
	'texte_sauvegarde' => 'Зберегти базу даних',
	'texte_sauvegarde_base' => 'Зберегти базу даних',
	'tout_restaurer' => 'Відновити усі таблиці',
	'tout_sauvegarder' => 'Зберегти усі таблиці',

	// U
	'une_donnee' => '1 запис'
);

?>
