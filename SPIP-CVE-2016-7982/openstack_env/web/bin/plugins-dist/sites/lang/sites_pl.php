<?php
// This is a SPIP language file  --  Ceci est un fichier langue de SPIP
// extrait automatiquement de http://trad.spip.net/tradlang_module/sites?lang_cible=pl
// ** ne pas modifier le fichier **

if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}

$GLOBALS[$GLOBALS['idx_lang']] = array(

	// A
	'avis_echec_syndication_01' => 'Syndykacja nie powiodła się : plik backend jest nieodczytywalny lub nie ma w nim żadnego artykułu.',
	'avis_echec_syndication_02' => 'Syndykacja nie powiodła się : nie ma dostępu do pliku backend tego serwisu.',
	'avis_site_introuvable' => 'Strony nie znaleziono',
	'avis_site_syndique_probleme' => 'Uwaga : syndykacja strony napotkała na problem ; system został na chwilę wstrzymany. Sprawdź URL syndykowanej strony (<b>@url_syndic@</b>), i spróbuj powtórnie pozyskać informacje.', # MODIF
	'avis_sites_probleme_syndication' => 'Te strony mają problem z syndykacją',
	'avis_sites_syndiques_probleme' => 'Następujące strony syndykowane sprawiają problem',

	// B
	'bouton_radio_modere_posteriori' => 'moderacja a posteriori', # MODIF
	'bouton_radio_modere_priori' => 'moderacja a priori', # MODIF
	'bouton_radio_non_syndication' => 'Bez syndykacji',
	'bouton_radio_syndication' => 'Syndykacja:',

	// E
	'entree_adresse_fichier_syndication' => 'Adres pliku syndykacji:',
	'entree_adresse_site' => '<b>URL strony</b> [obowiązkowo]',
	'entree_description_site' => 'Opis strony',

	// F
	'form_prop_nom_site' => 'Nazwa stron\\y',

	// I
	'icone_modifier_site' => 'Zmień tę stronę',
	'icone_referencer_nouveau_site' => 'Nowy link do strony',
	'icone_voir_sites_references' => 'Pokaż zlinkowane strony',
	'info_1_article_syndique' => '1 artykuł konsorcjalny',
	'info_1_site' => '1 strona',
	'info_a_valider' => '[do zatwierdzenia]',
	'info_aucun_article_syndique' => 'Brak artykułów syndykatowych',
	'info_aucun_site' => 'Brak powiązanych stron',
	'info_bloquer' => 'zablokuj',
	'info_bloquer_lien' => 'zablokuj ten link',
	'info_derniere_syndication' => 'Ostatnia syndykacja tego serwisu została dokonana',
	'info_liens_syndiques_1' => 'linki syndykowane',
	'info_liens_syndiques_2' => 'oczekujące zatwierdzenia.',
	'info_nom_site_2' => '<b>Nazwa strony</b> [obowiązkowo]',
	'info_panne_site_syndique' => 'Strona syndykowana nie działa',
	'info_probleme_grave' => 'błąd',
	'info_question_proposer_site' => 'Kto może proponować zlinkowane strony ?',
	'info_retablir_lien' => 'przywróc link',
	'info_site_attente' => 'Strona internetowa oczekująca na zatwierdzenie',
	'info_site_propose' => 'Strona zaproponowana :',
	'info_site_reference' => 'Strona zlinkowana on-line',
	'info_site_refuse' => 'Strona internetowa odrzucona',
	'info_site_syndique' => 'Ta strona jest syndykowana...', # MODIF
	'info_site_valider' => 'Strony do zatwierdzenia',
	'info_sites_referencer' => 'Dodaj link',
	'info_sites_refuses' => 'Odrzucone strony',
	'info_statut_site_1' => 'Ta strona jest:',
	'info_statut_site_2' => 'Opublikowana',
	'info_statut_site_3' => 'Zatwierdzona',
	'info_statut_site_4' => 'Do kosza', # MODIF
	'info_syndication' => 'syndykacja :',
	'info_syndication_articles' => 'artykuł(y)',
	'item_bloquer_liens_syndiques' => 'Zablokuj akceptację syndykowanych linków',
	'item_gerer_annuaire_site_web' => 'Zarządzaj katalogiem stron www',
	'item_non_bloquer_liens_syndiques' => 'Nie blokuj łączy pochodzących z syndykacji',
	'item_non_gerer_annuaire_site_web' => 'Wyłącz katalog stron www',
	'item_non_utiliser_syndication' => 'Wyłącz automatyczną syndykację',
	'item_utiliser_syndication' => 'Używaj automatycznej syndykacji',

	// L
	'lien_mise_a_jour_syndication' => 'Uaktualnij teraz',
	'lien_nouvelle_recuperation' => 'Spróbuj ponowić odtwarzanie danych',

	// S
	'syndic_choix_moderation' => 'Co zrobić z linkami, które pochodzą z tego serwisu ?',
	'syndic_choix_oublier' => 'Co zrobić z linkami, których nie ma już w pliku syndykacji?',
	'syndic_choix_resume' => 'Niektóre strony publikują pełny tekst artykułów. Jeśli dostępna jest taka wersja czy chcesz z niej skorzystać :',
	'syndic_lien_obsolete' => 'nieaktualny link',
	'syndic_option_miroir' => 'blokować automatycznie',
	'syndic_option_oubli' => 'usunąć (po @mois@ miesiącach)',
	'syndic_option_resume_non' => 'pełna treść artykułów (w formacie HTML)',
	'syndic_option_resume_oui' => 'posumowanie (w postaci tekstowej)',
	'syndic_options' => 'Opcje syndykacji :',

	// T
	'texte_liens_sites_syndiques' => 'Łącza pochodzące z syndykacji mogą
   być domyślnie zablokowane ; regulacja tego
   wskazuje regulacje domyślne
   stron syndykowanych po ich stworzeniu. Jest
   możliwe późniejsze odblokowanie, łączy indywidualnie, lub
   wybór, strona po stronie, blokady linków pochodzących z danych stron.', # MODIF
	'texte_messages_publics' => 'Publiczne komentarze do artykułu :',
	'texte_non_fonction_referencement' => 'Być może wolisz nie używać funkcji automatycznej, i samemu zaznaczyć elementy związane z tą stroną...', # MODIF
	'texte_referencement_automatique' => '<b>Zautomatyzowane dodawanie linków</b><br />Możesz szybko dodać link do jakiejś strony internetowej, wpisując poniżej jej adres, oraz adres jej pliku syndykacji. SPIP automatycznie dopisze informacje, dotyczące tej strony (tytuł, opis...).', # MODIF
	'texte_syndication' => 'Jeśli dany serwis na to pozwala, jest możliwość wyciągnięcia z niego 
  listy newsów. Aby skorzystać z tej funkcji musisz włączyć <i>syndykację ?</i>. 
  <blockquote><i>Niektóre serwery mają taką możliwość wyłączoną ; 
  wówczas nie możesz używać syndykacji przy użyciu swojej strony.</i></blockquote>', # MODIF
	'titre_articles_syndiques' => 'Artykułu syndykowane, wyciągnięte z tej strony',
	'titre_dernier_article_syndique' => 'Ostatnio syndykowane artykuły',
	'titre_page_sites_tous' => 'Zlinkowane strony',
	'titre_referencement_sites' => 'Linkowanie i zrzeszanie stron',
	'titre_site_numero' => 'STRONA NUMER :',
	'titre_sites_proposes' => 'Strony zatwierdzone',
	'titre_sites_references_rubrique' => 'Linki do stron z tego działu',
	'titre_sites_syndiques' => 'Syndykowane serwisy',
	'titre_sites_tous' => 'Linki do stron',
	'titre_syndication' => 'Syndykacja stron'
);

?>
