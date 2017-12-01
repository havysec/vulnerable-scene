<?php
// This is a SPIP language file  --  Ceci est un fichier langue de SPIP
// extrait automatiquement de http://trad.spip.net/tradlang_module/dump?lang_cible=ja
// ** ne pas modifier le fichier **

if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}

$GLOBALS[$GLOBALS['idx_lang']] = array(

	// B
	'bouton_restaurer_base' => 'データベースを復元',

	// I
	'info_restauration_sauvegarde' => 'バックアップ@archive@の復元', # MODIF
	'info_sauvegarde' => 'バックアップ',
	'info_sauvegarde_reussi_02' => 'データベースは、@archive@に保存されました。あなたは出来ます',
	'info_sauvegarde_reussi_03' => '管理画面へ戻る',
	'info_sauvegarde_reussi_04' => 'of あなたのサイト。',

	// T
	'texte_admin_tech_01' => 'このオプションはデータベースの内容を@dossier@ディレクトリに用意してあるファイルに保存することができます。記事やセクションで使った画像やドキュメントを含んだ<i>IMG/</i>全体、ディレクトリを忘れずに保存しておいてください。',
	'texte_admin_tech_02' => '警告：このバックアップは、同じバージョンのSPIPがインストールしてある場合のみ復元できます。もちろんデータベースを空にしたり、アップグレード後にバックアップを復元してはいけません。さらに詳しいことは<a href="@spipnet@">SPIP documentation</a>を参照してください。', # MODIF
	'texte_restaurer_base' => 'データベースのバックアップの内容を復元',
	'texte_restaurer_sauvegarde' => 'このオプションで前にバックアップしたデータベースを復元することが可能です。復元するには、バックアップ用のファイルが@dossier@ディレクトリに保存されていなければなりません。必ずこの機能は注意して使ってください：<b>どんな潜在的な変更や損失も撤回することができません。</b>', # MODIF
	'texte_sauvegarde' => 'データベースの内容をバックアップ',
	'texte_sauvegarde_base' => 'データベースをバックアップ'
);

?>
