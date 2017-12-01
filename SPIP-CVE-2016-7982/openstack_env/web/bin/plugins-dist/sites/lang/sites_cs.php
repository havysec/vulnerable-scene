<?php
// This is a SPIP language file  --  Ceci est un fichier langue de SPIP
// extrait automatiquement de http://trad.spip.net/tradlang_module/sites?lang_cible=cs
// ** ne pas modifier le fichier **

if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}

$GLOBALS[$GLOBALS['idx_lang']] = array(

	// A
	'avis_echec_syndication_01' => 'Vytvoření dat selhalo: Buď nelze číst z vybraného základního systému (backend) nebo na něm není žádný článek.',
	'avis_echec_syndication_02' => 'Selhalo zpracování dat: Nelze komunikovat se základním systémem (backend) těchto stránek.',
	'avis_site_introuvable' => 'Web nenalezen',
	'avis_site_syndique_probleme' => 'Varování: při syndikalizaci tohoto webu došlo k potížím. Systém je proto nefunkční. Zkontrolujte adresu syndikalizačního souborutohoto webu(<b>@url_syndic@</b>) a zkuste znovu provést obnovu informací.', # MODIF
	'avis_sites_probleme_syndication' => 'Na těchto webech došlo k problémům se syndikalizací',
	'avis_sites_syndiques_probleme' => 'Problém pochází z těchto syndikovaných webů',

	// B
	'bouton_radio_modere_posteriori' => 'moderování ex post', # MODIF
	'bouton_radio_modere_priori' => 'moderování předem', # MODIF
	'bouton_radio_non_syndication' => 'Bez syndikace',
	'bouton_radio_syndication' => 'Syndikace:',

	// E
	'entree_adresse_fichier_syndication' => 'Adresa souboru pro syndikaci:',
	'entree_adresse_site' => '<b>Adresa webu</b> [povinný údaj]',
	'entree_description_site' => 'Popis webu',

	// F
	'form_prop_nom_site' => 'Název webu',

	// I
	'icone_modifier_site' => 'Změnit web',
	'icone_referencer_nouveau_site' => 'Zveřejnit odkaz na nový web',
	'icone_voir_sites_references' => 'Zobrazit odkazovaný web',
	'info_1_site' => '1 web',
	'info_a_valider' => '[ke schválení]',
	'info_bloquer' => 'zablokovat',
	'info_bloquer_lien' => 'zablokovat tento odkaz',
	'info_derniere_syndication' => 'Poslední syndikace tohoto webu byla pro vedena ',
	'info_liens_syndiques_1' => 'syndikovaný odkaz',
	'info_liens_syndiques_2' => 'čekající na schválení.',
	'info_nom_site_2' => '<b>Název webu</b> [povinný údaj]',
	'info_panne_site_syndique' => 'Syndikovaný web nefunguje',
	'info_probleme_grave' => 'chyba',
	'info_question_proposer_site' => 'Kdo může navrhovat odkazy na weby?',
	'info_retablir_lien' => 'obnovit tento odkaz',
	'info_site_attente' => 'Web čeká na schválení',
	'info_site_propose' => 'Web navržen dne:',
	'info_site_reference' => 'Web odkazovaný online',
	'info_site_refuse' => 'Web byl odmítnut',
	'info_site_syndique' => 'Toto je syndikovaný web...', # MODIF
	'info_site_valider' => 'Weby ke schválení',
	'info_sites_referencer' => 'Zadat odkaz na web',
	'info_sites_refuses' => 'Odmítnuté weby',
	'info_statut_site_1' => 'Tento web je:',
	'info_statut_site_2' => 'Publikováno',
	'info_statut_site_3' => 'Připraveno',
	'info_statut_site_4' => 'Do koše', # MODIF
	'info_syndication' => 'syndikace:',
	'info_syndication_articles' => 'článek/článků',
	'item_bloquer_liens_syndiques' => 'Zablokovat syndikované odkazy pro schválení',
	'item_gerer_annuaire_site_web' => 'Správa adresáře webů',
	'item_non_bloquer_liens_syndiques' => 'Neblokovat odkazy, které jsou výsledkem syndikace',
	'item_non_gerer_annuaire_site_web' => 'Vypnout adresář webu',
	'item_non_utiliser_syndication' => 'Nepoužívat automatickou syndikaci',
	'item_utiliser_syndication' => 'Používat automatickou syndikaci',

	// L
	'lien_mise_a_jour_syndication' => 'Aktualizovat',
	'lien_nouvelle_recuperation' => 'Pokusit se znovu získat data',

	// S
	'syndic_choix_moderation' => 'Co se má udělat s budoucími odkazy z tohoto webu?',
	'syndic_choix_oublier' => 'Co s odkazy, které už nejsou v syndikačním souboru?',
	'syndic_choix_resume' => 'Některé weby publikují celé texty článků. Je-li tato funkce k dispozici, chcete syndikovat:',
	'syndic_lien_obsolete' => 'zastaralý odkaz',
	'syndic_option_miroir' => 'automaticky blokovat',
	'syndic_option_oubli' => 'odstranit (po @mois@ měsíci/měsících)',
	'syndic_option_resume_non' => 'celý obsah článků (ve formátu HTML)',
	'syndic_option_resume_oui' => 'stručný obsah (v textovém formátu)',
	'syndic_options' => 'Možnosti syndikace:',

	// T
	'texte_liens_sites_syndiques' => 'Odkazy ze syndikovaných webů lze předem zablokovat.
   Níže uvedené nastavení je standardním
   nastavením syndikovaných webů po jejich vytvoření.
   Jednotlivé odkazy můžete vždy následně odblokovat,
   případně se rozhodnout zablokovat odkazy pocházející z konkrétních webů.', # MODIF
	'texte_messages_publics' => 'Veřejné zprávy k článku:',
	'texte_non_fonction_referencement' => 'Tuto automatickou funkci nemusíte použít a parametry webu můžete zadat sami...', # MODIF
	'texte_referencement_automatique' => '<b>Automatický odkaz na web</b><br />Odkaz na web snadno vytvoříte zadáním požadované adresy URL nebo adresy jeho syndikačního souboru. Systém SPIP automaticky převezme údaje o takovém webu (název, popis...).', # MODIF
	'texte_syndication' => 'Pokud to web umožňuje, můžete automaticky získat seznam na něm zveřejněných
  novinek. K tomu je nutno zapnout syndikaci.
  <blockquote><i>Někteří poskytovatelé webového prostoru tuto funkcni vypínají.
  V takovém případě nemůžete syndikaci ze svého webu použít.</i></blockquote>', # MODIF
	'titre_articles_syndiques' => 'Syndikované články, přenesené z tohoto webu',
	'titre_dernier_article_syndique' => 'Poslední syndikované články',
	'titre_page_sites_tous' => 'Odkazované weby',
	'titre_referencement_sites' => 'Odkazy na weby a syndikace',
	'titre_site_numero' => 'ČÍSLO WEBU:',
	'titre_sites_proposes' => 'Navržené weby',
	'titre_sites_references_rubrique' => 'Weby, na něž jsou v této sekci odkazy',
	'titre_sites_syndiques' => 'Syndikované weby',
	'titre_sites_tous' => 'Odkazované weby',
	'titre_syndication' => 'Syndikace webů'
);

?>
