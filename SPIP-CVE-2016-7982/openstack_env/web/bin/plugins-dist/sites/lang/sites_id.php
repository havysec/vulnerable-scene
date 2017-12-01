<?php
// This is a SPIP language file  --  Ceci est un fichier langue de SPIP
// extrait automatiquement de http://trad.spip.net/tradlang_module/sites?lang_cible=id
// ** ne pas modifier le fichier **

if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}

$GLOBALS[$GLOBALS['idx_lang']] = array(

	// A
	'avis_echec_syndication_01' => 'Sindikasi gagal: berkas yang dipilih tidak dapat dibaca atau ia tidak menyediakan satu artikel pun.',
	'avis_echec_syndication_02' => 'Sindikasi gagal: tidak dapat menjangkau berkas sindikasi situs ini.',
	'avis_site_introuvable' => 'Situs tidak ditemukan',
	'avis_site_syndique_probleme' => 'Peringatan: sindikasi situs ini mengalami gangguan; oleh karena itu sistem dihentikan untuk sementara waktu. Silakan verifikasi alamat berkas sindikasi situs (<b>@url_syndic@</b>), dan coba sekali lagi untuk melanjutkan proses pengambilan informasi.', # MODIF
	'avis_sites_probleme_syndication' => 'Situs-situs ini mengalami gangguan sindikasi',
	'avis_sites_syndiques_probleme' => 'Situs-situs tersindikasi ini menimbulkan sebuah permasalahan',

	// B
	'bouton_radio_modere_posteriori' => 'moderasi akhir', # MODIF
	'bouton_radio_modere_priori' => 'moderasi awal', # MODIF
	'bouton_radio_non_syndication' => 'Tidak ada sindikasi',
	'bouton_radio_syndication' => 'Sindikasi:',

	// E
	'entree_adresse_fichier_syndication' => 'Alamat berkas untuk sindikasi:',
	'entree_adresse_site' => '<b>URL Situs</b> [Diperlukan]',
	'entree_description_site' => 'Deskripsi situs',

	// F
	'form_prop_nom_site' => 'Nama situs',

	// I
	'icone_modifier_site' => 'Modifikasi situs ini',
	'icone_referencer_nouveau_site' => 'Referensi sebuah situs baru',
	'icone_voir_sites_references' => 'Tampilkan situs-situs referensi',
	'info_1_site' => '1 situs',
	'info_a_valider' => '[akan divalidasi]',
	'info_bloquer' => 'blok',
	'info_bloquer_lien' => 'Blokir tautan ini',
	'info_derniere_syndication' => 'Sindikasi terakhir situs ini dijalankan pada',
	'info_liens_syndiques_1' => 'tautan tersindikasi',
	'info_liens_syndiques_2' => 'validasi tertunda.',
	'info_nom_site_2' => '<b>Nama situs</b> [Dibutuhkan]',
	'info_panne_site_syndique' => 'Situs-situs sindikasi tidak dapat dijangkau',
	'info_probleme_grave' => 'kesalahan',
	'info_question_proposer_site' => 'Siapa yang dapat menyarankan situs-situs referensi?',
	'info_retablir_lien' => 'pulihkan tautan ini',
	'info_site_attente' => 'Validasi tertunda situs web',
	'info_site_propose' => 'Situs dikirim pada:',
	'info_site_reference' => 'Situs-situs referensi online',
	'info_site_refuse' => 'Situs web ditolak',
	'info_site_syndique' => 'Situs ini disindikasi...', # MODIF
	'info_site_valider' => 'Situs-situs yang akan divalidasi',
	'info_sites_referencer' => 'Merujuk sebuah situs',
	'info_sites_refuses' => 'Situs-situs yang ditolak',
	'info_statut_site_1' => 'Situs ini adalah:',
	'info_statut_site_2' => 'Dipublikasi',
	'info_statut_site_3' => 'Dikirim',
	'info_statut_site_4' => 'Dalam keranjang sampah', # MODIF
	'info_syndication' => 'sindikasi:',
	'info_syndication_articles' => 'artikel',
	'item_bloquer_liens_syndiques' => 'Blokir tautan sindikasi untuk validasi',
	'item_gerer_annuaire_site_web' => 'Kelola direktori situs-situs web',
	'item_non_bloquer_liens_syndiques' => 'Jangan blokir tautan web yang berasal dari sindikasi',
	'item_non_gerer_annuaire_site_web' => 'Non aktifkan direktori situs-situs web',
	'item_non_utiliser_syndication' => 'Jangan gunakan sindikasi terotomasi',
	'item_utiliser_syndication' => 'Gunakan sindikasi terotomasi',

	// L
	'lien_mise_a_jour_syndication' => 'Perbaharui sekarang',
	'lien_nouvelle_recuperation' => 'Mencoba melakukan pengambilan data baru',

	// S
	'syndic_choix_moderation' => 'Apa yang akan dilakukan dengan tautan berikut dari situs ini?',
	'syndic_choix_oublier' => 'Apa yang akan dilakukan dengan tautan yang tidak ada lagi dalam berkas sindikasi?',
	'syndic_choix_resume' => 'Sejumlah situs menawarkan teks penuh dari artikel-artikel mereka. Ketika teks penuh tersedia, apakah anda ingin mensindikasikannya:',
	'syndic_lien_obsolete' => 'tautan yang tidak perlu',
	'syndic_option_miroir' => 'blokir secara otomatis',
	'syndic_option_oubli' => 'hapus (setelah @mois@ bulan)',
	'syndic_option_resume_non' => 'isi penuh dari artikel (format HTML)',
	'syndic_option_resume_oui' => 'sekedar ringkasan (format teks)',
	'syndic_options' => 'Opsi sindikasi:',

	// T
	'texte_liens_sites_syndiques' => 'Tautan yang berasal dari situs-situs tersindikasi
			dapat diblok sebelumnya; pengaturan berikut
			menampilkan pengaturan standar dari situs-
			situs tersindikasi setelah dibuat. Ini
			memungkinkan untuk memblokir setiap tautan
			secara individual, atau memilih, untuk setiap
			situs, memblokir tautan yang berasal dari
			situs-situs tertentu.', # MODIF
	'texte_messages_publics' => 'Pesan umum artikel:',
	'texte_non_fonction_referencement' => 'Anda dapat memilih untuk tidak menggunakan fitur terotomasi ini, dan masukkan elemen-elemen yang berkaitan dengan situs secara manual...', # MODIF
	'texte_referencement_automatique' => '<b>Referensi situs terotomasi</b><br />Anda dapat mereferensi sebuah situs web secara cepat dengan memberikan di bawah URL yang dimaksud, atau alamat berkas sindikasinya. SPIP secara otomatis akan mengambil informasi yang berkaitan dengan situs tersebut (judul, deskripsi...).', # MODIF
	'texte_syndication' => 'Jika sebuah situs mengizinkannya, daftar isi terbaru dari situs tersebut
  dapat diambil secara otomatis. Untuk melakukannya, anda harus mengaktifkan sindikasi.
  <blockquote><i>Sejumlah hosting menonaktifkan fungsi ini; 
  dalam hal ini, anda tidak dapat menggunakan sindikasi isi
  dari situs anda.</i></blockquote>', # MODIF
	'titre_articles_syndiques' => 'Artikel-artikel tersindikasi ditarik dari situs ini',
	'titre_dernier_article_syndique' => 'Artikel-artikel sindikasi terbaru',
	'titre_page_sites_tous' => 'Situs-situs referensi',
	'titre_referencement_sites' => 'Referensi dan sindikasi situs',
	'titre_site_numero' => 'NOMOR SITUS:',
	'titre_sites_proposes' => 'Situs-situs yang dikirim',
	'titre_sites_references_rubrique' => 'Situs-situs referensi dalam bagian ini',
	'titre_sites_syndiques' => 'Situs-situs tersindikasi',
	'titre_sites_tous' => 'Situs-situs referensi',
	'titre_syndication' => 'Sindikasi situs'
);

?>
