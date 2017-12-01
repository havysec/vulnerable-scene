<?php
// This is a SPIP language file  --  Ceci est un fichier langue de SPIP
// extrait automatiquement de http://trad.spip.net/tradlang_module/sites?lang_cible=ca
// ** ne pas modifier le fichier **

if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}

$GLOBALS[$GLOBALS['idx_lang']] = array(

	// A
	'avis_echec_syndication_01' => 'La sindicació ha fallat : el backend indicat és indescifrable o no proposa cap article.',
	'avis_echec_syndication_02' => 'La sindicació ha fallat : impossible accedir al backend d’aquest lloc.',
	'avis_site_introuvable' => 'Lloc il·localitzable',
	'avis_site_syndique_probleme' => 'Atenció: la sindicació d’aquest lloc s’ha trobat amb un problema ; per tant, el sistema queda temporalment interromput. Verifiqueu l’adreça del fitxer de sindicació d’aquest lloc (<b>@url_syndic@</b>), i intenteu una nova recuperació de les informacions.',
	'avis_sites_probleme_syndication' => 'Aquests llocs han trobat un problema de sindicació',
	'avis_sites_syndiques_probleme' => 'Aquests llocs sindicats donen un problema ',

	// B
	'bouton_radio_modere_posteriori' => 'moderació a posteriori', # MODIF
	'bouton_radio_modere_priori' => 'moderació a priori', # MODIF
	'bouton_radio_non_syndication' => 'Cap sindicació',
	'bouton_radio_syndication' => 'Sindicació:',

	// E
	'entree_adresse_fichier_syndication' => 'Adreça del fitxer de sindicació:',
	'entree_adresse_site' => '<b>Adreça del lloc</b> [Obligatòria]',
	'entree_description_site' => 'Descripció del lloc',

	// F
	'form_prop_nom_site' => 'Nom del lloc',

	// I
	'icone_modifier_site' => 'Modificar aquest lloc',
	'icone_referencer_nouveau_site' => 'Referenciar un nou lloc',
	'icone_voir_sites_references' => 'Mostrar els llocs referenciats',
	'info_1_article_syndique' => '1 article sindicat',
	'info_1_site' => '1 lloc',
	'info_a_valider' => '[per validar]',
	'info_aucun_article_syndique' => 'Cap article sindicat',
	'info_aucun_site' => 'Cap lloc',
	'info_bloquer' => 'blocar',
	'info_bloquer_lien' => 'blocar aquest enllaç',
	'info_derniere_syndication' => 'La última sindicació d’aquest lloc ha estat realitzada el',
	'info_liens_syndiques_1' => 'enllaços sindicats',
	'info_liens_syndiques_2' => 'estan pendents de validació.',
	'info_nb_articles_syndiques' => '@nb@ articles sindicats',
	'info_nb_sites' => '@nb@ llocs',
	'info_nom_site_2' => '<b>Nom del lloc</b> [Obligatori]',
	'info_panne_site_syndique' => 'Lloc sindicat en pana',
	'info_probleme_grave' => 'problema de',
	'info_question_proposer_site' => 'Qui pot proposar llocs referenciats?',
	'info_retablir_lien' => 'restaurar aquest enllaç',
	'info_site_attente' => 'Lloc Web pendent de validació',
	'info_site_propose' => 'Lloc proposat el:',
	'info_site_reference' => 'Lloc referenciat en línia',
	'info_site_refuse' => 'Lloc Web rebutjat',
	'info_site_syndique' => 'Aquest lloc está sindicat...', # MODIF
	'info_site_valider' => 'Llocs a validar',
	'info_sites_referencer' => 'Referenciar un lloc',
	'info_sites_refuses' => 'Els llocs rebutjats',
	'info_statut_site_1' => 'Aquest lloc és:',
	'info_statut_site_2' => 'Publicat',
	'info_statut_site_3' => 'Proposat',
	'info_statut_site_4' => 'A la paperera', # MODIF
	'info_syndication' => 'sindicació:',
	'info_syndication_articles' => 'article(s)',
	'item_bloquer_liens_syndiques' => 'Bloquejar els enllaços sindicats per validar',
	'item_gerer_annuaire_site_web' => 'Gestionar un directori de llocs web',
	'item_non_bloquer_liens_syndiques' => 'No bloquejar els enllaços sortits de la sindicació',
	'item_non_gerer_annuaire_site_web' => 'Desactivar el directori de llocs Web',
	'item_non_utiliser_syndication' => 'No utilitzar la sindicació automàtica',
	'item_utiliser_syndication' => 'Utilitzar la sindicació automàtica',

	// L
	'lien_mise_a_jour_syndication' => 'Actualitzar ara',
	'lien_nouvelle_recuperation' => 'Intentar una nova recuperació de les dades',

	// S
	'syndic_choix_moderation' => 'Què fer dels següents enllaços que procedeixin d’aquest lloc Web?',
	'syndic_choix_oublier' => 'Què fer dels enllaços que ja no figuren en el fitxer de sindicació?',
	'syndic_choix_resume' => 'Alguns llocs Web presenten el text complet dels articles. Quan el text sencer es troba disponible desitgeu sindicar:',
	'syndic_lien_obsolete' => 'enllaç obsolet',
	'syndic_option_miroir' => 'blocar-los automàticament',
	'syndic_option_oubli' => 'esborrar-los (després @mois@ mois)',
	'syndic_option_resume_non' => 'el contingut complet dels articles (en format HTML)',
	'syndic_option_resume_oui' => 'un simple resum (en format text)',
	'syndic_options' => 'Opcions de sindicació:',

	// T
	'texte_liens_sites_syndiques' => 'Els enllaços provenents de les webs sindicades poden
ser bloquejats a priori; la norma
que apareix a continuació indica  la regla per defecte dels llocs sindicats després de la seua creació. És
possible inmediatament desbloquejar cada enllaç de forma individual, o 
triar, web per web, bloquejar els enllaços que vinguen d’un o altre web.', # MODIF
	'texte_messages_publics' => 'Missatges públics de l’article:',
	'texte_non_fonction_referencement' => 'Es pot preferir no utilitzar aquesta funció automàtica i indicar vosté mateix els elements referits a aquest lloc...', # MODIF
	'texte_referencement_automatique' => '<b>Referenciament automatitzat d’un lloc Web</b><br />Podeu referenciar ràpidament un lloc Web només indicant aquí baix l’adreça URL desitjada, o l’adreça del seu fitxer de sindicació. SPIP recuperarà automàticament les informacions pel que fa a aquest lloc Web (títol, descripció...).', # MODIF
	'texte_referencement_automatique_verifier' => 'Verifiqueu les informacions subministrades per <tt>@url@</tt> abans d’enregistrar. ',
	'texte_syndication' => 'És possible recuperar automàticament, quan el lloc Web ho permet, la llista de novetats. Per això, heu d’activar la sindicació.
<blockquote><i>Alguns proveïdors d’hostatge desactiven aquesta funcionalitat; en aquest cas, no podreu utilitzar la sindicació de contingut des del vostre lloc.</i></blockquote>', # MODIF
	'titre_articles_syndiques' => 'Articles sindicats extrets d’aquest lloc.',
	'titre_dernier_article_syndique' => 'Darrers articles sindicats',
	'titre_page_sites_tous' => 'Webs enllaçades',
	'titre_referencement_sites' => 'Enllaçament de webs i sindicació',
	'titre_site_numero' => 'LLOC WEB NÚMERO:',
	'titre_sites_proposes' => 'Les webs proposades',
	'titre_sites_references_rubrique' => 'Les webs enllaçades a aquesta secció',
	'titre_sites_syndiques' => 'Les webs sindicades',
	'titre_sites_tous' => 'Les webs enllaçades',
	'titre_syndication' => 'Sindicació de webs'
);

?>
