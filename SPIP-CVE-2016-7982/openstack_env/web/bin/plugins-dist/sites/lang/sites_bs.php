<?php
// This is a SPIP language file  --  Ceci est un fichier langue de SPIP
// extrait automatiquement de http://trad.spip.net/tradlang_module/sites?lang_cible=bs
// ** ne pas modifier le fichier **

if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}

$GLOBALS[$GLOBALS['idx_lang']] = array(

	// A
	'avis_echec_syndication_01' => 'Sindikacija nije uspjela: odabrani backend nije citljiv ili ne nudi nijedan clanak.',
	'avis_echec_syndication_02' => 'Sindikacija nije uspjela: nije moguce dostici backend ove stranice',
	'avis_site_introuvable' => 'Stranica nije pronadjena',
	'avis_site_syndique_probleme' => 'Paznja : Problem prilikom sindikacije ove stranice; Doslo je do privremenog prekida sistema. Provjerite adresu dokumenta sindikacije ove stranice \\f1 (<b>@url_syndic@</b>)\\f0  i pokusajte povratiti informacije.', # MODIF
	'avis_sites_probleme_syndication' => 'Doslo je do problema  prilikom sindikacije ovih stranica',
	'avis_sites_syndiques_probleme' => 'Sindikovane stranice su postavljale problem',

	// B
	'bouton_radio_modere_posteriori' => '\\f1 post-moderation\\f0 ', # MODIF
	'bouton_radio_modere_priori' => '\\f1 pre-moderation\\f0 ', # MODIF
	'bouton_radio_non_syndication' => 'Bez sindikacije',
	'bouton_radio_syndication' => 'Sindikacija:',

	// E
	'entree_adresse_fichier_syndication' => 'Adresa dokumenta « backend » za sindikaciju:',
	'entree_adresse_site' => '<b>Adresa stranice</b> [Obavezno]',
	'entree_description_site' => 'OПИС СТРАНИЦЕ',

	// F
	'form_prop_nom_site' => 'Naziv stranice',

	// I
	'icone_modifier_site' => 'Izmijeni ovu stranicu',
	'icone_referencer_nouveau_site' => 'Preporuciti novu stranicu',
	'icone_voir_sites_references' => 'Pogledaj preporucene stranice',
	'info_1_site' => '1. stranica',
	'info_a_valider' => '[za ovjeriti]',
	'info_bloquer' => 'blokirati',
	'info_bloquer_lien' => 'blokiraj ovaj link',
	'info_derniere_syndication' => 'Posljednja sindikacija ove stranice je izvrsena',
	'info_liens_syndiques_1' => 'sindikovani linkovi',
	'info_liens_syndiques_2' => 'na cekanju za ovjeru.',
	'info_nom_site_2' => '<b>Ime stranice</b> [Obavezno]',
	'info_panne_site_syndique' => 'Sindikovana stranica nije u funkciji',
	'info_probleme_grave' => 'problem sa',
	'info_question_proposer_site' => 'Ko moze predloziti preporucene stranice?',
	'info_retablir_lien' => 'obnovi ovaj link',
	'info_site_attente' => 'Web stranica ceka na ovjeru',
	'info_site_propose' => 'Stranica preporucena:',
	'info_site_reference' => 'Preporucene stranice online',
	'info_site_refuse' => 'Web stranica odbijena',
	'info_site_syndique' => 'Ova stranica je sindikovana...', # MODIF
	'info_site_valider' => 'Stranice za ovjeriti',
	'info_sites_referencer' => 'Preporuci stranicu',
	'info_sites_refuses' => 'Odbijene stranice',
	'info_statut_site_1' => 'Ova stranica je:',
	'info_statut_site_2' => 'Objavljena',
	'info_statut_site_3' => 'Predlozena',
	'info_statut_site_4' => 'U korpi za smece', # MODIF
	'info_syndication' => 'sindikacija:',
	'info_syndication_articles' => 'clanak/ci',
	'item_bloquer_liens_syndiques' => 'Blokiraj sindikovane linkove za validaciju',
	'item_gerer_annuaire_site_web' => 'Uredi direktorij za web stranice',
	'item_non_bloquer_liens_syndiques' => 'Ne blokiraj linkove koji su rezultat sindikacije',
	'item_non_gerer_annuaire_site_web' => 'Dezaktiviraj direktorij web stranica',
	'item_non_utiliser_syndication' => 'Ne koristi automatsku sindikaciju',
	'item_utiliser_syndication' => 'Koristi automatsku sindikaciju',

	// L
	'lien_mise_a_jour_syndication' => 'Osvjezi sada',
	'lien_nouvelle_recuperation' => 'Pokusaj ponovno dobavljanje podataka',

	// S
	'syndic_choix_moderation' => 'Sta treba uraditi sa sljedecim linkovima sa ove stranice?',
	'syndic_choix_oublier' => 'Sta treba uraditi sa linkovima koji vise nisu prisutni u dokumentu sindikacije?',
	'syndic_choix_resume' => 'Neke stranice nude na raspolaganje cjelokupni tekst clanaka. Ako je taj dostupan, zelite li pristupiti sindikaciji:',
	'syndic_lien_obsolete' => 'zastarijeli link',
	'syndic_option_miroir' => 'atomatski blokiraj',
	'syndic_option_oubli' => 'izbrisi (poslije  @mois@ mmjesec/a/i)',
	'syndic_option_resume_non' => 'kompletni sadrzaj clanaka (u  HTML formatu)',
	'syndic_option_resume_oui' => 'jednostavni rezime (u formi teksta)',
	'syndic_options' => 'Opcije sindikacije:',

	// T
	'texte_liens_sites_syndiques' => 'Linkovi izvedeni iz sindikovanih stranica mogu a priori biti blokirani; dole prikazana postavka  je standardna postavka sindikovanih stranica prije njihove kreacije. U svakom slucaju je moguce pojedinacno deblokirati  svaki link ili, stranicu po stranicu, blokirati linkove koji  dolaze sa odredjene lokacije.', # MODIF
	'texte_messages_publics' => 'Javne poruke clanka:',
	'texte_non_fonction_referencement' => 'Mozete izabrati da ne koristite ovu automatsku funkciju i sami naznaciti elemente vezane za ovu stranicu...', # MODIF
	'texte_referencement_automatique' => '<b>Automatska preporuka stranice</b><br />Mozete brzo preporuciti web stranicu, tako sto cete naznaciti zeljenu URL adresu ili adresu njenog backend dokumenta. SPIP ce automatski sakupiti informacije vezane za tu stranicu (naslov, opis...).', # MODIF
	'texte_syndication' => 'Moguce je automatsko otkrivanje spiska novosti, ako web stranica to dozvoljava. Zato trebate aktivirati sindikaciju\\tab <blockquote><i>Odredjeni hosting servisi dezaktiviraju tu funkciju; u tom slucaju ne mozete koristiti sindikaciju sadrzaja na vasoj stranici.</i></blockquote>', # MODIF
	'titre_articles_syndiques' => 'Sindikovani clanci, izvuceni iz ove stranice',
	'titre_dernier_article_syndique' => 'Posljednji sindikovani clanci',
	'titre_page_sites_tous' => 'Preporucene stranice',
	'titre_referencement_sites' => 'Sindikacija i preporucivanje stranica',
	'titre_site_numero' => 'STRANICA BROJ:',
	'titre_sites_proposes' => 'Predlozene stranice',
	'titre_sites_references_rubrique' => 'Preporucene stranice u ovoj rubrici',
	'titre_sites_syndiques' => 'Sindikovane stranice',
	'titre_sites_tous' => 'Preporucene stranice',
	'titre_syndication' => 'Sindikacija stranica'
);

?>
