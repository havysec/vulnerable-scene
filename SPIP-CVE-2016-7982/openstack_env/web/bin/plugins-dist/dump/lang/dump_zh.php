<?php
// This is a SPIP language file  --  Ceci est un fichier langue de SPIP
// extrait automatiquement de http://trad.spip.net/tradlang_module/dump?lang_cible=zh
// ** ne pas modifier le fichier **

if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}

$GLOBALS[$GLOBALS['idx_lang']] = array(

	// B
	'bouton_restaurer_base' => '恢复数据库',

	// I
	'info_restauration_sauvegarde' => '恢复备份 @archive@', # MODIF
	'info_sauvegarde' => '备份',
	'info_sauvegarde_reussi_02' => '数据库保存在@archive@. 你可以', # MODIF
	'info_sauvegarde_reussi_03' => '返回管理',
	'info_sauvegarde_reussi_04' => '你的站点.',

	// T
	'texte_admin_tech_01' => '此操作允许您保存数据库内容为一个文件到@dossier@.
记得刷新整个 <i>IMG/</i> 目录, 它包含文章和各专栏中使用的图片和文档.', # MODIF
	'texte_admin_tech_02' => '警告 : 备份仅有在同样的SPIP版本中才被恢复
. 升级SPIP前备份数据库这是
普遍的错误
... 更多消息参见 <a href="@spipnet@">SPIP 文档</a>.', # MODIF
	'texte_restaurer_base' => '恢复备份数据库内容',
	'texte_restaurer_sauvegarde' => '该选项允许你恢复以前的数据库
. 打包它, 包括备份的文件已存在
目录 @dossier@.
小心使用这个特性: <b>任何修改或丢失将不可
撤回.</b>', # MODIF
	'texte_sauvegarde' => '备份数据库内容',
	'texte_sauvegarde_base' => '备份数据库'
);

?>
