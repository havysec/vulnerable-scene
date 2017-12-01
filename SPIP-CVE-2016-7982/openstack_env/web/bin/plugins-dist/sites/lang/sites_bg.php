<?php
// This is a SPIP language file  --  Ceci est un fichier langue de SPIP
// extrait automatiquement de http://trad.spip.net/tradlang_module/sites?lang_cible=bg
// ** ne pas modifier le fichier **

if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}

$GLOBALS[$GLOBALS['idx_lang']] = array(

	// A
	'avis_echec_syndication_01' => 'Обединението пропадна: или избраната крайна точка не се чете, или там няма статия.',
	'avis_echec_syndication_02' => 'Обединението пропадна: няма връзка с информацията от сайта',
	'avis_site_introuvable' => 'Страницата не е намерена',
	'avis_site_syndique_probleme' => 'Предупреждение: проблем при обединението на сайта; в  следствие на това системата е временно прекъсната. Моля, проверете файла за обединяване (<b>@url_syndic@</b>) и опитайте отново да възстановите информацията. ', # MODIF
	'avis_sites_probleme_syndication' => 'Проблем при обединението на сайтовете',
	'avis_sites_syndiques_probleme' => 'Проблем при обединяването на сайтовете',

	// B
	'bouton_radio_modere_posteriori' => 'последваща модерация', # MODIF
	'bouton_radio_modere_priori' => 'предварителна модерация', # MODIF
	'bouton_radio_non_syndication' => 'Без обединяване',
	'bouton_radio_syndication' => 'Обединеняване на сайтове:',

	// E
	'entree_adresse_fichier_syndication' => 'Адрес на файла за обединяване:',
	'entree_adresse_site' => '<b>Уеб-адрес (URL) на сайта</b> [Задължително]',
	'entree_description_site' => 'Описание на сайта',

	// F
	'form_prop_nom_site' => 'Име на сайта',

	// I
	'icone_modifier_site' => 'Промяна на страницата',
	'icone_referencer_nouveau_site' => 'Свързване на нов сайт',
	'icone_voir_sites_references' => 'Показване на свързани сайтове',
	'info_1_site' => '1 сайт',
	'info_a_valider' => '[за одобрение]',
	'info_bloquer' => 'блокиране',
	'info_bloquer_lien' => 'блокиране на препратката',
	'info_derniere_syndication' => 'Последното обединяване на този сайт бе на',
	'info_liens_syndiques_1' => 'обединени връзки',
	'info_liens_syndiques_2' => 'очакват одобрение.',
	'info_nom_site_2' => '<b>Име на сайта</b> [Задължително]',
	'info_panne_site_syndique' => 'Обединеният сайт не работи',
	'info_probleme_grave' => 'грешка с',
	'info_question_proposer_site' => 'Кой може да предложи свързани сайтове?',
	'info_retablir_lien' => 'възстановяване на препратката',
	'info_site_attente' => 'Сайт очакващ одобрение',
	'info_site_propose' => 'Сайтът е изпратен на:',
	'info_site_reference' => 'Свързани сайтове',
	'info_site_refuse' => 'Интернет страницата е отхвърлена',
	'info_site_syndique' => 'Този сайт е обединен.', # MODIF
	'info_site_valider' => 'Сайтове, очакващи одобрение за публикуване',
	'info_sites_referencer' => 'Свързване на сайт',
	'info_sites_refuses' => 'Отхвърлени сайтове',
	'info_statut_site_1' => 'Сайтът е:',
	'info_statut_site_2' => 'Публикуван',
	'info_statut_site_3' => 'Изпратен',
	'info_statut_site_4' => 'За изтриване', # MODIF
	'info_syndication' => 'обединение:',
	'info_syndication_articles' => 'статия (статии)',
	'item_bloquer_liens_syndiques' => 'Блокиране на обединените връзки за одобрение',
	'item_gerer_annuaire_site_web' => 'Управление на директорията на уеб сайта',
	'item_non_bloquer_liens_syndiques' => 'Без блокиране на връзките - следствия от обединяване',
	'item_non_gerer_annuaire_site_web' => 'Деактивиране на директорията на уеб сайта',
	'item_non_utiliser_syndication' => 'Без използване на автоматично обединяване',
	'item_utiliser_syndication' => 'Използване на автоматично обединяване',

	// L
	'lien_mise_a_jour_syndication' => 'Актуализация',
	'lien_nouvelle_recuperation' => 'Опитайте да направите ново възстановяване на данните ',

	// S
	'syndic_choix_moderation' => 'Какво да се направи със следващите препратки от сайта?',
	'syndic_choix_oublier' => 'Какво да се направи с препратките, които вече не присъстват във файла за обединение?',
	'syndic_choix_resume' => 'Някои сайтове предлагат пълен текст на статиите. Когато се предлага пълен текст, искате ли да направите обединение:',
	'syndic_lien_obsolete' => 'излязла от употреба препратка',
	'syndic_option_miroir' => 'автоматично да се блокират',
	'syndic_option_oubli' => 'автоматично да се изтриват (след @mois@ месец(а))',
	'syndic_option_resume_non' => 'пълно съдържание на статиите (във формат HTML)',
	'syndic_option_resume_oui' => 'само резюме (текстов формат)',
	'syndic_options' => 'Опции за обединение:',

	// T
	'texte_liens_sites_syndiques' => 'Препратките, идващи от обединените сайтове
   може да бъдат предварително блокирани.
     Следната настройка показва обединените
    сайтове след тяхното създаване в обичаен вид
   След това е възможно да се блокира
   индивидуално всяка препратка поотделно или да
   се избере от всеки сайт, да се блокира препратката,
   идваща от него.', # MODIF
	'texte_messages_publics' => 'Публични съобщения към статията:',
	'texte_non_fonction_referencement' => 'Можете да изберете да не използвате автоматичното свойство и да въвжедате ръчно елементите, свързани със сайта.', # MODIF
	'texte_referencement_automatique' => '<b>Автоматично свързване на сайт</b><br />Можете лесно да свъжетете уеб страници чрез обозначаване по-долу на желания URL на страницата или адресът на нейния файл за обединение. СПИП автоматично ще събере нужната информация, отнасяща се до сайта (наименование, описание и т.н.).', # MODIF
	'texte_syndication' => 'Ако сайтът го позволява, възможно е автоматично да възстановява
  списъка с най-новия материал. За да постигнете това, нужно е да активирате обединяване. 
  <blockquote><i>Някои доставчици деактивират тази функция; 
  ако случаят е този, няма да можете да използвате обединяването на съдържание
  от Вашия сайт.</i></blockquote>', # MODIF
	'titre_articles_syndiques' => 'Обединени статии, изтеглени от този сайт',
	'titre_dernier_article_syndique' => 'Най-новите обединени статии',
	'titre_page_sites_tous' => 'Свързани сайтове',
	'titre_referencement_sites' => 'Свързване и обединение на сайтове',
	'titre_site_numero' => 'НОМЕР НА СТРАНИЦАТА:',
	'titre_sites_proposes' => 'Изпратени сайтове',
	'titre_sites_references_rubrique' => 'Свързани сайтове в рубриката',
	'titre_sites_syndiques' => 'Обединени сайтове',
	'titre_sites_tous' => 'Свързани сайтове',
	'titre_syndication' => 'Обединяване на сайтовете'
);

?>
