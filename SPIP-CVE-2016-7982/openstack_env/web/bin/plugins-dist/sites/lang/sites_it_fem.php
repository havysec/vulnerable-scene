<?php
// This is a SPIP language file  --  Ceci est un fichier langue de SPIP
// extrait automatiquement de http://trad.spip.net/tradlang_module/sites?lang_cible=it_fem
// ** ne pas modifier le fichier **

if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}

$GLOBALS[$GLOBALS['idx_lang']] = array(

	// A
	'avis_echec_syndication_01' => 'La syndication è fallita: il backend indicato è indecifrabile o non propone alcun articolo.',
	'avis_echec_syndication_02' => 'La syndication è fallita: impossibile accedere al backend di questo sito.',
	'avis_site_introuvable' => 'Sito introvabile',
	'avis_site_syndique_probleme' => 'Attenzione: si è verificato un errore nella syndication del sito; il sistema è temporaneamente fuori uso.
Verifica l’indirizzo del file per la syndication di (<b>@url_syndic@</b>) e prova nuovamente a recuperare le informazioni remote.',
	'avis_sites_probleme_syndication' => 'Si sono verificati alcuni problemi nella syndication di questi siti',
	'avis_sites_syndiques_probleme' => 'Si sono verificati alcuni problemi nella syndication di questi siti',

	// B
	'bouton_radio_modere_posteriori' => 'moderato a posteriori', # MODIF
	'bouton_radio_modere_priori' => 'moderato a priori', # MODIF
	'bouton_radio_non_syndication' => 'Nessuna syndication',
	'bouton_radio_syndication' => 'Syndication:',

	// E
	'entree_adresse_fichier_syndication' => 'Indirizzo del file di syndication:',
	'entree_adresse_site' => '<b>Indirizzo del sito</b> [Obbligatorio]',
	'entree_description_site' => 'Descrizione del sito',

	// F
	'form_prop_nom_site' => 'Nome del sito',

	// I
	'icone_modifier_site' => 'Modifica il sito',
	'icone_referencer_nouveau_site' => 'Inserisci un nuovo sito in repertorio',
	'icone_voir_sites_references' => 'Vedi i siti in repertorio',
	'info_1_site' => '1 sito',
	'info_a_valider' => '[da convalidare]',
	'info_bloquer' => 'bloccare',
	'info_bloquer_lien' => 'bloccare questo link',
	'info_derniere_syndication' => 'L’ultima <em>syndication</em> di questo sito è stata effettuata il',
	'info_liens_syndiques_1' => 'link in syndication',
	'info_liens_syndiques_2' => 'sono in attesa di convalida.',
	'info_nom_site_2' => '<b>Nome del sito</b> [Obbligatorio]',
	'info_panne_site_syndique' => 'Il sito in syndication non funziona',
	'info_probleme_grave' => 'problema di',
	'info_question_proposer_site' => 'Chi può proporre i siti da citare?',
	'info_retablir_lien' => 'ripristinare questo link',
	'info_site_attente' => 'Sito Web in attesa di convalida',
	'info_site_propose' => 'Sito proposto il:',
	'info_site_reference' => 'Sito repertoriato in linea',
	'info_site_refuse' => 'Sito Web rifiutato',
	'info_site_syndique' => 'Questo è un sito in syndication...', # MODIF
	'info_site_valider' => 'Siti da convalidare',
	'info_sites_referencer' => 'Inserisci un sito in repertorio',
	'info_sites_refuses' => 'I siti rifiutati',
	'info_statut_site_1' => 'Questo sito è:',
	'info_statut_site_2' => 'Pubblicato',
	'info_statut_site_3' => 'Proposto',
	'info_statut_site_4' => 'Nel cestino', # MODIF
	'info_syndication' => 'syndication:',
	'info_syndication_articles' => 'articolo/i',
	'item_bloquer_liens_syndiques' => 'Blocca i link in syndication per la convalida',
	'item_gerer_annuaire_site_web' => 'Gestisci un repertorio di siti Web',
	'item_non_bloquer_liens_syndiques' => 'Non bloccare i link provenienti da una syndication',
	'item_non_gerer_annuaire_site_web' => 'Disattiva il repertorio di siti Web',
	'item_non_utiliser_syndication' => 'Non attivare la syndication automatica',
	'item_utiliser_syndication' => 'Attiva la syndication automatica',

	// L
	'lien_mise_a_jour_syndication' => 'Aggiorna adesso',
	'lien_nouvelle_recuperation' => 'Tenta nuovamente di ripristinare i dati',

	// S
	'syndic_choix_moderation' => 'Come comportarsi con i prossimi link provenienti da questo sito?',
	'syndic_choix_oublier' => 'Come comportarsi con i link che non compaiono più nel file di syndication?',
	'syndic_choix_resume' => 'Alcuni siti diffondono il testo completo degli articoli. Nel caso esso sia disponibile desiderate metterlo in syndication:',
	'syndic_lien_obsolete' => 'link non più valido',
	'syndic_option_miroir' => 'bloccarli automaticamente',
	'syndic_option_oubli' => 'cancellarli (dopo @mois@ mesi)',
	'syndic_option_resume_non' => 'il contenuto completo degli articoli (in formato HTML)',
	'syndic_option_resume_oui' => 'un semplice riassunto (in formato testo)',
	'syndic_options' => 'Opzioni per la syndication:',

	// T
	'texte_liens_sites_syndiques' => 'I link provenienti dai siti in syndication
possono essere bloccati a priori; l’impostazione
qui sotto indica i criteri predefiniti dei siti in syndication.
Sarà comunque possibile sbloccare singolarmente ogni link,
o scegliere di bloccare i link di ogni singolo sito.', # MODIF
	'texte_messages_publics' => 'Messaggi pubblici dell’articolo:',
	'texte_non_fonction_referencement' => 'Puoi non utilizzare questa funzione automatica, e indicare direttamente gli elementi riguardanti il sito...', # MODIF
	'texte_referencement_automatique' => '<b>Inserimento automatizzato in repertorio</b><br />È possibile repertoriare rapidamente un sito Web indicandone qui sotto l’indirizzo URL, o l’indirizzo del file di syndication. SPIP recupererà automaticamente le informazioni riguardanti il sito (titolo, descrizione...).', # MODIF
	'texte_referencement_automatique_verifier' => 'Controllare le informazioni fornite da <tt>@url@</tt> prima di registrare.',
	'texte_syndication' => 'Quando un sito Web lo permette, è possibile recuperarne automaticamente
la lista delle novità. A tal fine è necessario attivare la syndication.

<blockquote><i>Alcuni provider disattivano questa funzionalità; 
in questo caso, non potrai utilizzare la syndication del contenuto
a partire dal tuo sito.</i></blockquote>', # MODIF
	'titre_articles_syndiques' => 'Articoli in syndication raccolti da questo sito',
	'titre_dernier_article_syndique' => 'Ultimi articoli in syndication',
	'titre_page_sites_tous' => 'I siti repertoriati',
	'titre_referencement_sites' => 'Repertorio di siti e syndication',
	'titre_site_numero' => 'SITO NUMERO:',
	'titre_sites_proposes' => 'I siti proposti',
	'titre_sites_references_rubrique' => 'I siti repertoriati in questa rubrica',
	'titre_sites_syndiques' => 'I siti in syndication',
	'titre_sites_tous' => 'I siti repertoriati',
	'titre_syndication' => 'Syndication di siti'
);

?>
