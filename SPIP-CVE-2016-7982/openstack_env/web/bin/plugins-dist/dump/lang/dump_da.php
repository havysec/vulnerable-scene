<?php
// This is a SPIP language file  --  Ceci est un fichier langue de SPIP
// extrait automatiquement de http://trad.spip.net/tradlang_module/dump?lang_cible=da
// ** ne pas modifier le fichier **

if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}

$GLOBALS[$GLOBALS['idx_lang']] = array(

	// B
	'bouton_restaurer_base' => 'Genetabler databasen',

	// I
	'info_restauration_sauvegarde' => 'Genindlæsning af sikkerhedskopi @archive@', # MODIF
	'info_sauvegarde' => 'Sikkerhedskopi',
	'info_sauvegarde_reussi_02' => 'Databasen er gemt i @archive@. Du kan',
	'info_sauvegarde_reussi_03' => 'returnere til administration',
	'info_sauvegarde_reussi_04' => 'af webstedet.',

	// T
	'texte_admin_tech_01' => 'Dette valg giver dig mulighed for at gemme databasens indhold i en fil lagret i kataloget 
 @dossier@.
 Husk også at medtage hele kataloget <i>IMG/</i>, som rummer de billeder og dokumenter, der bruges i artikler og afsnit.',
	'texte_admin_tech_02' => 'Advarsel: denne sikkerhedskopi kan KUN genindlæses på et websted, der har installeret samme version af SPIP.
 Det er en almindelig misforståelse at tage sikkerhedskopi af et websted forud for opgradering af SPIP...
 For mere information henvises til <a href="@spipnet@">SPIP dokumentation</a>.', # MODIF
	'texte_restaurer_base' => 'Genindlæs indholdet af sikkerhedskopien af databasen',
	'texte_restaurer_sauvegarde' => 'Denne valgmulighed giver dig adgang til at genindlæse en tidligere 
		sikkerhedskopi af databasen. For at gøre det, skal filen, der indeholder sikkerhedskopien af databasen, 
		på forhånd kopieres til kataloget @dossier@.
		Vær forsigtig med denne funktion: <b>Alle eventuelle ændringer og tab er uoprettelige.</b>', # MODIF
	'texte_sauvegarde' => 'Sikkerhedskopier indholdet af databasen',
	'texte_sauvegarde_base' => 'Sikkerhedskopier databasen'
);

?>
