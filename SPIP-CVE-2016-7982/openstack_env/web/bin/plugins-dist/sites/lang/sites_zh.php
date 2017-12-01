<?php
// This is a SPIP language file  --  Ceci est un fichier langue de SPIP
// extrait automatiquement de http://trad.spip.net/tradlang_module/sites?lang_cible=zh
// ** ne pas modifier le fichier **

if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}

$GLOBALS[$GLOBALS['idx_lang']] = array(

	// A
	'avis_echec_syndication_01' => '联合失败: 要么是选择的禁止读,要么它不提供任何文章.',
	'avis_echec_syndication_02' => '联合失败: 不能到达站点的阻止区.',
	'avis_site_introuvable' => '站点未找到',
	'avis_site_syndique_probleme' => '警告: 联合站点遇到问题; 目前系统临时中断. 请确认站点的联合文件地址(<b>@url_syndic@</b>), 重新尝试执行信息恢复.', # MODIF
	'avis_sites_probleme_syndication' => '这些站点遇到联合问题',
	'avis_sites_syndiques_probleme' => '这些联合站点出现问题',

	// B
	'bouton_radio_modere_posteriori' => '预存后', # MODIF
	'bouton_radio_modere_priori' => '预存前', # MODIF
	'bouton_radio_non_syndication' => '没有联合',
	'bouton_radio_syndication' => '联合:',

	// E
	'entree_adresse_fichier_syndication' => '联合所用的«引用»文件地址:', # MODIF
	'entree_adresse_site' => '<b>站点地址</b> [必须的]',
	'entree_description_site' => '站点描述',

	// F
	'form_prop_nom_site' => '站点名',

	// I
	'icone_modifier_site' => '修改站点',
	'icone_referencer_nouveau_site' => '引用一个新站点',
	'icone_voir_sites_references' => '查看参考站点',
	'info_1_site' => '1个站点',
	'info_a_valider' => '[使有效]',
	'info_bloquer_lien' => '阻止这个连接',
	'info_derniere_syndication' => '站点的最近联合己移出',
	'info_liens_syndiques_1' => '联合连接',
	'info_liens_syndiques_2' => '未确认.',
	'info_nom_site_2' => '<b>站点名</b> [必须]',
	'info_panne_site_syndique' => '联合站点次序颠倒',
	'info_probleme_grave' => '错误',
	'info_question_proposer_site' => '谁能提出引用站点?',
	'info_retablir_lien' => '恢复这个连接',
	'info_site_attente' => '未确认的站点',
	'info_site_propose' => '提交的站点:',
	'info_site_reference' => '在线引用的站点',
	'info_site_refuse' => '丢弃的站点',
	'info_site_syndique' => '联合的站点...', # MODIF
	'info_site_valider' => '使有效的站点',
	'info_sites_referencer' => '参考站点',
	'info_sites_refuses' => '丢弃的站点',
	'info_statut_site_1' => '站点是:',
	'info_statut_site_2' => '出版',
	'info_statut_site_3' => '提交',
	'info_statut_site_4' => '到垃圾箱', # MODIF
	'info_syndication' => '聚合 ：', # MODIF
	'info_syndication_articles' => '文章',
	'item_bloquer_liens_syndiques' => '阻止联合站点确认',
	'item_gerer_annuaire_site_web' => '管理站点目录',
	'item_non_bloquer_liens_syndiques' => '不阻止联合中引出的链接',
	'item_non_gerer_annuaire_site_web' => '使网站目录不可用',
	'item_non_utiliser_syndication' => '不使用自动联合',
	'item_utiliser_syndication' => '使用自动联合',

	// L
	'lien_mise_a_jour_syndication' => '现在更新',
	'lien_nouvelle_recuperation' => '试着重新获取数据',

	// T
	'texte_liens_sites_syndiques' => '从联合站点发出的连接能
   被预先阻止; 以下
   设置允许联合站点创建后
   显示缺省设置. 
   然后无论如何可分开阻止每个连接
   , 或选择,
   对每一站点, 阻止连接来自
   任何特别的站点.', # MODIF
	'texte_messages_publics' => '文章的公共消息:',
	'texte_non_fonction_referencement' => '你可以选择不使用这个自动特性, 手动输入连接元素...', # MODIF
	'texte_referencement_automatique' => '<b>自动站点引用</b><br />通过指出以下的想得到的URL或后端文件的地址,您可以迅速引用一个站点. SPIP 将自动获得关于站点的信息 (标题, 描述...).', # MODIF
	'texte_syndication' => '如果站点允许, 可以自动得到最新的素材
  . 要这样的话, 你必须激活联合. 
  <blockquote><i>一些主机禁用这个功能; 
  这种情况下, 你不能使用
  你站点的内容联合.</i></blockquote>', # MODIF
	'titre_articles_syndiques' => '剔除站点的联合文章',
	'titre_dernier_article_syndique' => '最后联合的文章',
	'titre_page_sites_tous' => '参考站点',
	'titre_referencement_sites' => '参考站点和联合组织',
	'titre_site_numero' => '站点号:',
	'titre_sites_proposes' => '已提交站点',
	'titre_sites_references_rubrique' => '此栏下的参考站点',
	'titre_sites_syndiques' => '联合站点',
	'titre_sites_tous' => '参考站点',
	'titre_syndication' => '站点联合'
);

?>
