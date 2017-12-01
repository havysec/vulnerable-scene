<?php
// This is a SPIP language file  --  Ceci est un fichier langue de SPIP
// extrait automatiquement de http://trad.spip.net/tradlang_module/forum?lang_cible=ja
// ** ne pas modifier le fichier **

if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}

$GLOBALS[$GLOBALS['idx_lang']] = array(

	// B
	'bouton_radio_articles_futurs' => 'これから作られる記事のみ（今データベースにある記事はそのまま除外）。',
	'bouton_radio_articles_tous' => 'すべての記事、特例を認めない、全部。',
	'bouton_radio_articles_tous_sauf_forum_desactive' => 'すべての記事、掲示板機能を使っていない記事は除く。',
	'bouton_radio_enregistrement_obligatoire' => '必要な登録 (
  ユーザは、寄稿することができる前に彼らのe-mailアドレスを提供することによって、
  定期受信すべきです)。',
	'bouton_radio_moderation_priori' => '事前に適正検査 (
 投稿物は、管理者によって適正検査された後、表示されます)。', # MODIF
	'bouton_radio_modere_abonnement' => '会員だけ投稿可能',
	'bouton_radio_modere_posteriori' => 'コメントを投稿後に検査', # MODIF
	'bouton_radio_modere_priori' => '検査したコメントのみ表示', # MODIF
	'bouton_radio_publication_immediate' => '投稿と同時に表示
（投稿すると瞬時に表示するため、管理者は投稿を削除することは可能ですが投稿後になるでしょう）。',

	// F
	'form_pet_message_commentaire' => 'よろしければメッセージをお寄せください。',
	'forum' => 'フォーラム',
	'forum_acces_refuse' => 'あなたはもうこれらの掲示板にアクセスできません。',
	'forum_attention_dix_caracteres' => '<b>警告 !</b> あなたのメッセージは長さが１０文字以下です。',
	'forum_attention_trois_caracteres' => '<b>警告 !</b> あなたの題名は長さが３文字以下です。',
	'forum_avez_selectionne' => 'あなたの選択:',
	'forum_cliquer_retour' => '<a href=\'@retour_forum@\'>ここ</a> を押して続けて下さい。',
	'forum_forum' => '掲示板',
	'forum_info_modere' => 'この掲示板への投稿はあらかじめ検査されます: あなたの投稿は、サイトの管理者によって適性検査されてから表示されます。', # MODIF
	'forum_lien_hyper' => '<b>リンク</b> (オプション)', # MODIF
	'forum_message_definitif' => '最後のメッセージ: サイトへ送る',
	'forum_message_trop_long' => 'あなたのメッセージは長すぎます。最大20000文字(全角は２つ分)であるべきです。', # MODIF
	'forum_ne_repondez_pas' => 'このメールに返信しないで、次のアドレスの掲示板で:', # MODIF
	'forum_page_url' => '(もしあなたのメッセージがウェブに公表されている記事、更なる情報が提供されているページを参照するなら、ページのタイトルとその下にURLを入力してください)。',
	'forum_poste_par' => 'あなたの記事の後に投稿された@parauteur@ メッセージ。', # MODIF
	'forum_qui_etes_vous' => '<b>あなたはだれ?</b> (オプション)', # MODIF
	'forum_texte' => 'あなたのメッセージテキスト:', # MODIF
	'forum_titre' => '件名:', # MODIF
	'forum_url' => 'URL:', # MODIF
	'forum_valider' => 'この選択を確認',
	'forum_voir_avant' => '投稿する前にメッセージをプレビュー', # MODIF
	'forum_votre_email' => 'あなたのe-mailアドレス:', # MODIF
	'forum_votre_nom' => 'あなたの名前（か仮名）:', # MODIF
	'forum_vous_enregistrer' => 'この掲示板に投稿する前に
  あなたは登録しなければなりません。あなたに与えられた個人的なIDを入力してくれてありがとう。もしまだ登録してないなら、あなたはするべきです。',
	'forum_vous_inscrire' => '登録者。',

	// I
	'icone_poster_message' => 'メッセージの投稿',
	'icone_suivi_forum' => '公開掲示板の追跡: @nb_forums@ 投稿',
	'icone_suivi_forums' => '掲示板を管理する',
	'icone_supprimer_message' => 'このメッセージを削除',
	'icone_valider_message' => 'このメッセージを確認',
	'info_activer_forum_public' => '<i>公開掲示板を利用可能にするため、それらの検査方法の標準を選択して下さい:</i>', # MODIF
	'info_appliquer_choix_moderation' => 'この検査方法を使う:',
	'info_desactiver_forum_public' => '公開掲示板は使わない。公開掲示板は記事ごとに許可する。それらはセクション、ニュース、その他によって禁止できる。',
	'info_envoi_forum' => '記事の著者たちに掲示板を送る',
	'info_fonctionnement_forum' => '掲示板の操作:',
	'info_gauche_suivi_forum_2' => '<i>掲示板の続報</i>ページはあなたのサイトの管理道具です。（議論したり編集できません）。この記事の公開掲示板のすべての投稿を表示して、それらの投稿を管理することが可能です。', # MODIF
	'info_liens_syndiques_3' => '掲示板',
	'info_liens_syndiques_4' => 'are',
	'info_liens_syndiques_5' => '掲示板',
	'info_liens_syndiques_6' => 'is',
	'info_liens_syndiques_7' => '適正検査前。',
	'info_mode_fonctionnement_defaut_forum_public' => '公開掲示板の標準の操作方法',
	'info_option_email' => 'サイトの訪問者が、記事に関連している掲示板にメッセージを投稿した時、記事の著者たちにe-mailによってこのメッセージを通知できます。あなたはこのオプションを使いたいですか ？', # MODIF
	'info_pas_de_forum' => '掲示板無し',
	'item_activer_forum_administrateur' => '管理者用の掲示板を作る',
	'item_desactiver_forum_administrateur' => '管理者用の掲示板を作らない',

	// L
	'lien_reponse_article' => '記事へ返信',
	'lien_reponse_breve_2' => 'ニュースに返信',
	'lien_reponse_rubrique' => 'セクションに返信',
	'lien_reponse_site_reference' => '参照されたサイトに返信:', # MODIF

	// O
	'onglet_messages_internes' => '内部のメッセージ',
	'onglet_messages_publics' => '公開されているメッセージ',
	'onglet_messages_vide' => 'テキストがないメッセージ',

	// R
	'repondre_message' => 'このメッセージに返信',

	// T
	'titre_cadre_forum_administrateur' => '管理者のプライベートな掲示板',
	'titre_cadre_forum_interne' => '関係者用の掲示板',
	'titre_forum' => '掲示板',
	'titre_forum_suivi' => '掲示板の続報',
	'titre_page_forum_suivi' => '掲示板の続報'
);

?>
