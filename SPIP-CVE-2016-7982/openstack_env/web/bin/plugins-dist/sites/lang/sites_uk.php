<?php
// This is a SPIP language file  --  Ceci est un fichier langue de SPIP
// extrait automatiquement de http://trad.spip.net/tradlang_module/sites?lang_cible=uk
// ** ne pas modifier le fichier **

if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}

$GLOBALS[$GLOBALS['idx_lang']] = array(

	// A
	'articles_dispo' => 'Розглядається',
	'articles_meme_auteur' => 'Усі статті цього автора',
	'articles_off' => 'Блоковано',
	'articles_publie' => 'Опубліковано',
	'articles_refuse' => 'Видалено',
	'articles_tous' => 'Усі',
	'aucun_article_syndic' => 'Нема жодної імпортованої статті',
	'avis_echec_syndication_01' => 'Не вдалося імпортувати статті: не вдається прочитати файл-джерело або він не має жодної статті.',
	'avis_echec_syndication_02' => 'Не вдалося імпортувати статті: не знайдено файл-джерело (RSS) цього сайта.',
	'avis_site_introuvable' => 'Не вдалося знайти сайт',
	'avis_site_syndique_probleme' => 'Увага: не вдалося імпортувати матеріали. Внаслідок цього роботу модуля імпорту було припинено. Перевірте посилання на файл-джерело (<b>@url_syndic@</b>) і спробуйте ще раз.',
	'avis_sites_probleme_syndication' => 'На цьому сайті виникли проблеми з експортом матеріалів',
	'avis_sites_syndiques_probleme' => 'Спроба імпортувати матеріали з цього сайту спричинила помилку',

	// B
	'bouton_exporter' => 'Експорт',
	'bouton_importer' => 'Імпорт',
	'bouton_radio_modere_posteriori' => 'одразу публікувати',
	'bouton_radio_modere_priori' => 'не публікувати до підтвердження',
	'bouton_radio_non_syndication' => 'Не імпортувати статті на сайт',
	'bouton_radio_syndication' => 'Імпортувати матеріали',

	// C
	'confirmer_purger_syndication' => 'Ви впевнені, що бажаєте видалити усі імпортовані статті з цього сайту?',

	// E
	'entree_adresse_fichier_syndication' => 'RSS стрічка(и):',
	'entree_adresse_site' => '<b>URL сайта</b> [обов’язково]',
	'entree_description_site' => 'Опис сайту',
	'erreur_fichier_format_inconnu' => 'Формат файлу @fichier@ не підтримується системою.',
	'erreur_fichier_incorrect' => 'Неможливо прочитати файл.',

	// F
	'form_prop_nom_site' => 'Назва сайту',

	// I
	'icone_article_syndic' => 'Імпортована стаття',
	'icone_articles_syndic' => 'Імпортовані статті',
	'icone_controler_syndication' => 'Імпортовані статті',
	'icone_modifier_site' => 'Редагувати сайт',
	'icone_referencer_nouveau_site' => 'Додати сайт',
	'icone_site_reference' => 'Каталог веб сайтів',
	'icone_supprimer_article' => 'Видалити статью',
	'icone_supprimer_articles' => 'Видалити статті',
	'icone_valider_article' => 'Затвердити статью',
	'icone_valider_articles' => 'Затвердити статті',
	'icone_voir_sites_references' => 'Каталог сайтів',
	'info_1_article_syndique' => '1 стаття синдикована',
	'info_1_site' => '1 сайт',
	'info_1_site_importe' => '1 сайт імпортований',
	'info_a_valider' => '[перевіряється]',
	'info_aucun_article_syndique' => 'Ніякої синдикованої статті',
	'info_aucun_site' => 'Ніякого сайту',
	'info_aucun_site_importe' => 'Не було імпортовано жодного сайту',
	'info_bloquer' => 'блок',
	'info_bloquer_lien' => 'блокувати посилання',
	'info_derniere_syndication' => 'Дата останнього імпорту материалів ',
	'info_liens_syndiques_1' => 'імпортованих статтей',
	'info_liens_syndiques_2' => 'чекають на затвердження.',
	'info_nb_articles_syndiques' => '@nb@ статей, що реферуються',
	'info_nb_sites' => '@nb@ сайти',
	'info_nb_sites_importes' => 'Було імпортовано @nb@ сайтів',
	'info_nom_site_2' => '<b>Назва сайту</b> [обов’язково]',
	'info_panne_site_syndique' => 'Сайт недосяжний',
	'info_probleme_grave' => 'помилка',
	'info_question_proposer_site' => 'Кому дозволено пропонувати посилання на інші сайти?',
	'info_retablir_lien' => 'відновити',
	'info_site_attente' => 'Cайт, що чекає на перевірку',
	'info_site_propose' => 'Доданий для перевірки:',
	'info_site_reference' => 'Посилання на онлайн сайти',
	'info_site_refuse' => 'Сайт відхилено',
	'info_site_syndique' => 'Можна імпортувати статті з цього сайту',
	'info_site_valider' => 'Чекають на затвердження',
	'info_sites_referencer' => 'Додати сайт',
	'info_sites_refuses' => 'Видалені сайти',
	'info_statut_site_1' => 'Цей сайт:',
	'info_statut_site_2' => 'Опубликовано',
	'info_statut_site_3' => 'Запропоновано',
	'info_statut_site_4' => 'Видалено',
	'info_syndication' => 'RSS:',
	'info_syndication_articles' => 'стаття(і)',
	'item_bloquer_liens_syndiques' => 'Блокувати імпортовані (синдиковані) посилання до затвердження',
	'item_gerer_annuaire_site_web' => 'Включити каталог сайтів та імпорт статтей по RSS',
	'item_non_bloquer_liens_syndiques' => 'Не блокувати посилання, які виходять від синдикованих сайтів',
	'item_non_gerer_annuaire_site_web' => 'Вимкнути каталог сайтів та імпорт статтей по RSS',
	'item_non_utiliser_syndication' => 'Вимкнути функцію імпорту статтей по RSS',
	'item_utiliser_syndication' => 'Увімкнути функцію імпорту статтей по RSS',

	// L
	'label_exporter_avec_mots_cles_1' => 'Експортувати ключові слова як теги',
	'label_exporter_id_parent' => 'Експортувати сайт із розділу',
	'label_exporter_publie_seulement_1' => 'Експортувати тільки ті сайти, що опубликовано',
	'label_fichier_import' => 'HTML файл',
	'label_importer_les_tags_1' => 'Імпортувати теги як ключові слова',
	'label_importer_statut_publie_1' => 'Публікувати сайти автоматично',
	'lien_mise_a_jour_syndication' => 'Поновити зараз',
	'lien_nouvelle_recuperation' => 'Спробувати отримати інформацію знову',
	'lien_purger_syndication' => 'Видалити усі імпортовані статті',

	// N
	'nombre_articles_syndic' => '@nb@ статтей імпортовано',

	// S
	'statut_off' => 'Видалено',
	'statut_prop' => 'Чекають',
	'statut_publie' => 'Опубліковано',
	'syndic_choix_moderation' => 'Що робити з новими матеріалами?',
	'syndic_choix_oublier' => 'Що робити з матеріалами, які прибрали з RSS стрічки сайту-джерела?',
	'syndic_choix_resume' => 'Частина сайтів експортує в RSS стрічку повний текст матеріалу. Що імпортувати в такому випадку:',
	'syndic_lien_obsolete' => 'застаріле посилання',
	'syndic_option_miroir' => 'відправляти на перевірку',
	'syndic_option_oubli' => 'видалити їх (через @mois@ міс.)',
	'syndic_option_resume_non' => 'матеріал повністю (HTML формат)',
	'syndic_option_resume_oui' => 'короткий зміст (текстовий формат)',
	'syndic_options' => 'Налашування імпорту:',

	// T
	'texte_expliquer_export_bookmarks' => 'Ви можете експортувати список сайтів в HTML формате закладок, аби далі додати їх в свій браузер чи онлайн сервіс управління закладками.',
	'texte_expliquer_import_bookmarks' => 'Ви можете додати список сайтів у форматі закладок з вашого браузера чи онлайн сервіса по зберіганню закладок.',
	'texte_liens_sites_syndiques' => 'Ви можете модерувати усі матеріали, импортовані з інших сайтів. Це налаштування встановлює правило для нових сайтів, що додаються. В будь-якому випадку ви можете задавати правила окремо для кожного сайту.',
	'texte_messages_publics' => 'Коментарі до статті:',
	'texte_non_fonction_referencement' => 'Ви можете визначити назву сайта та його опис самостійно.',
	'texte_referencement_automatique' => '<b>Вкажіть адресу сайту. </b> <br /> SPIP автоматично визначить назву сайту та інформацію про нього.',
	'texte_referencement_automatique_verifier' => 'Інформацію про сайт <tt>@url@</tt> було імпортовано автоматично. Перевірте її перед доданням сайту.',
	'texte_syndication' => 'Якщо на іншому сайті є експорт матеріалів через RSS, ви можете автоматично імпортувати останні  статті на ваш сайт. Для цього необхідмо активувати імпорт статей на вашому сайті. 
  <blockquote><i>Потрібно зазначити, що на частині сайтів нема автоматичного експорту матеріалів через RSS стрічку. В такому випадку ви не зможете отримати інформацію з таких сайтів в автоматичному режимі. </i> </blockquote>',
	'titre_articles_syndiques' => 'Статті, імпортовані з цього сайта',
	'titre_dernier_article_syndique' => 'Останні імпортовані статті',
	'titre_exporter_bookmarks' => 'Експортувати Закладки',
	'titre_importer_bookmarks' => 'Імпортувати Закладки',
	'titre_importer_exporter_bookmarks' => 'Імпортувати и експортувати закладки',
	'titre_page_sites_tous' => 'Каталог сайтів',
	'titre_referencement_sites' => 'Каталог сайтів, імпорт статтей по RSS',
	'titre_site_numero' => 'НОМЕР САЙТУ:',
	'titre_sites_proposes' => 'Запропоновані сайти',
	'titre_sites_references_rubrique' => 'Посилання на сайти в поточній рубриці',
	'titre_sites_syndiques' => 'Сайти-джерела інформації',
	'titre_sites_tous' => 'Каталог сайтів',
	'titre_syndication' => 'Імпорт статтей з іншого сайту по RSS',
	'tout_voir' => 'Показати всі імпортовані статті',

	// U
	'un_article_syndic' => '1 імпортована стаття'
);

?>
