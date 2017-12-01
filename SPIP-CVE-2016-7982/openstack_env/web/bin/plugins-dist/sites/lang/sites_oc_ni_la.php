<?php
// This is a SPIP language file  --  Ceci est un fichier langue de SPIP
// extrait automatiquement de http://trad.spip.net/tradlang_module/sites?lang_cible=oc_ni_la
// ** ne pas modifier le fichier **

if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}

$GLOBALS[$GLOBALS['idx_lang']] = array(

	// A
	'avis_echec_syndication_01' => 'La sindicacion s’es encalada: lo backend indicat es indeschifrable ò prepaua minga d’article.',
	'avis_echec_syndication_02' => 'La sindicacion s’es encalada: impossible d’accedir au backend d’aqueu sit.',
	'avis_site_introuvable' => 'Sit introbable',
	'avis_site_syndique_probleme' => 'Atencion: la sindicacion d’aqueu sit a rescontrat un problèma; lo sistèma es doncas interromput temporàriament. Verificatz l’adreiça dau fichier de sindicacion d’aqueu sit (<b>@url_syndic@</b>), e tornatz assaiar de recuperar li informacions.', # MODIF
	'avis_sites_probleme_syndication' => 'Aquelu sits an rescontrat un problèma de sindicacion',
	'avis_sites_syndiques_probleme' => 'Aquelu sits sindicats an pauat un problèma',

	// B
	'bouton_radio_modere_posteriori' => 'moderat a posteriòri', # MODIF
	'bouton_radio_modere_priori' => 'moderat a priòri', # MODIF
	'bouton_radio_non_syndication' => 'Minga de sindicacion',
	'bouton_radio_syndication' => 'Sindicacion:',

	// E
	'entree_adresse_fichier_syndication' => 'Adreiça dau fichier "backend" per la sindicacion:', # MODIF
	'entree_adresse_site' => '<b>Adreiça dau sit</b> [Obligatòria]',
	'entree_description_site' => 'Descripcion dau sit',

	// F
	'form_prop_nom_site' => 'Nom dau sit',

	// I
	'icone_modifier_site' => 'Modificar aqueu sit',
	'icone_referencer_nouveau_site' => 'Referenciar un sit nòu',
	'icone_voir_sites_references' => 'Veire lu sits referenciats',
	'info_1_site' => '1 sit',
	'info_a_valider' => '[de validar]',
	'info_bloquer' => 'blocar',
	'info_bloquer_lien' => 'Blocar aqueu liame',
	'info_derniere_syndication' => 'La darriera sindicacion d’aqueu sit si faguèt lo',
	'info_liens_syndiques_1' => 'ligams sindicats',
	'info_liens_syndiques_2' => 'son en espèra de validacion.',
	'info_nom_site_2' => '<b>Nom dau sit</b> [Obligatòri]',
	'info_panne_site_syndique' => 'Sit sindicat en pana',
	'info_probleme_grave' => 'problèma de',
	'info_question_proposer_site' => 'Cu pòu prepausar de sits referenciats?',
	'info_retablir_lien' => 'Restablir aqueu ligam',
	'info_site_attente' => 'Sit web en espèra de validacion',
	'info_site_propose' => 'Sit prepauat lo:',
	'info_site_reference' => 'Sit referenciat en linha',
	'info_site_refuse' => 'Sit web refusat',
	'info_site_syndique' => 'Aqueu sit es sindicat...', # MODIF
	'info_site_valider' => 'Sits de validar',
	'info_sites_referencer' => 'Referenciar un sit',
	'info_sites_refuses' => 'Lu sits refusats',
	'info_statut_site_1' => 'Aqueu sit es:',
	'info_statut_site_2' => 'Publicat',
	'info_statut_site_3' => 'Prepauat',
	'info_statut_site_4' => 'Au bordilhier', # MODIF
	'info_syndication' => 'sindicacion:',
	'info_syndication_articles' => 'article(s)',
	'item_bloquer_liens_syndiques' => 'Blocar lu ligams sindicats per validacion',
	'item_gerer_annuaire_site_web' => 'Gerir un annuari de sits web',
	'item_non_bloquer_liens_syndiques' => 'Non blocar lu ligams eissits de la sindicacion',
	'item_non_gerer_annuaire_site_web' => 'Desactivar l’annuari de sits web',
	'item_non_utiliser_syndication' => 'Non utilizar la sindicacion automatica',
	'item_utiliser_syndication' => 'Utilizar la sindicacion automatica',

	// L
	'lien_mise_a_jour_syndication' => 'Actualizar aüra',
	'lien_nouvelle_recuperation' => 'Assaiar una novèla recuperacion dei donadas',

	// S
	'syndic_choix_moderation' => 'Que si pòu far embai ligams venents que provenon d’aqueu sit?',
	'syndic_choix_oublier' => 'Que si pòu far embai ligams que figuran pus dins lo fichier de sindicacion?',
	'syndic_lien_obsolete' => 'ligam obsolet',
	'syndic_option_miroir' => 'lu blocar sus lo còup',
	'syndic_option_oubli' => 'lu escafar (après @mois@ mois)',
	'syndic_options' => 'Opcions de sindicacion:',

	// T
	'texte_liens_sites_syndiques' => 'Lu ligams eissits dei sits sindicats si pòdon
   blocar a priòri; lo reglatge
  çai sota indica lo reglatge predefinit dei
   sits sindicats après la sieu creacion. De tot biais,
    es possible pi de 
   desblocar cada ligam individualament, ò de
   chausir, sit per sit, de blocar lu ligams avenidors.', # MODIF
	'texte_messages_publics' => 'Messatges publics de l’article:',
	'texte_non_fonction_referencement' => 'Podètz chausir de non utilizar aquela foncion automatica, e indicar dau vòstre sicap lu elements que pertòcan aqueu sit...', # MODIF
	'texte_referencement_automatique' => '<b>Referenciament automatizat d’un sit</b><br /> Podètz referenciar lèu-lèu un sit web en indicant çai sota l’adreiça URL desirada, ò l’adreiça dau sieu fichier backend. SPIP agantarà automaticament li informacions que concernisson aqueu sit (títol, descripcion...).', # MODIF
	'texte_syndication' => 'Si pòu recuperar automaticament, quora un sit web o permete, 
  la tiera dei novetats. Per aquò far, vos cau activar la sindicacion. 
  <blockquote><i>D’unu aubergadors non activan aquela foncionalitat; 
  en aqueu cas, non porretz utilizar la sindicacion de contengut
  despí lo vòstre sit.</i></blockquote>', # MODIF
	'titre_articles_syndiques' => 'Articles sindicats tirats d’aqueu sit',
	'titre_dernier_article_syndique' => 'Darriers articles sindicats',
	'titre_page_sites_tous' => 'Lu sits referenciats',
	'titre_referencement_sites' => 'Referenciament de sits e sindicacion',
	'titre_site_numero' => 'SIT NÚMERO:',
	'titre_sites_proposes' => 'Lu sits prepauats',
	'titre_sites_references_rubrique' => 'Lu sits referenciats dins aquela rubrica',
	'titre_sites_syndiques' => 'Lu sits sindicats',
	'titre_sites_tous' => 'Lu sits referenciats',
	'titre_syndication' => 'Sindicacion de sits'
);

?>
