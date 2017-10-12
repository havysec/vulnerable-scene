<?php
/*
CMSimple version 3.1 - April 2. 2008
Small - simple - smart
© 1999-2008 Peter Andreas Harteg - peter@harteg.dk

This file is part of CMSimple.
For licence see notice in /cmsimple/cms.php and http://www.cmsimple.dk/?Licence
*/

if (eregi('functions.php', sv('PHP_SELF')))die('Access Denied');

// Backward compatibility for DHTML menus
$si = -1;
$hc = array();
for($i = 0; $i < $cl; $i++) {
	if (!hide($i))$hc[] = $i;
	if ($i == $s)$si = count($hc);
}
$hl = count($hc);

// #CMSimple functions to use within content

function geturl($u) {
	$t = '';
	if ($fh = @fopen(preg_replace("/\&amp;/is", "&", $u), "r")) {
		while (!feof($fh))$t .= fread($fh, 1024);
		fclose($fh);
		return preg_replace("/.*<body[^>]*>(.*)<\/body>.*/is", "\\1", $t);
	}
}

function geturlwp($u) {
	global $su;
	$t = '';
	if ($fh = @fopen(($u.'?'.preg_replace("/^".preg_replace("/\+/s", "\\\+", preg_replace("/\//s", "\\\/", $su))."(\&)?/s", "", sv('QUERY_STRING'))), "r")) {
		while (!feof($fh))$t .= fread($fh, 1024);
		fclose($fh);
		return $t;
	}
}

function autogallery($u) {
	global $su;
	return preg_replace("/.*<!-- autogallery -->(.*)<!-- \/autogallery -->.*/is", "\\1", preg_replace("/(option value=\"\?)(p=)/is", "\\1".$su."&\\2", preg_replace("/(href=\"\?)/is", "\\1".$su.amp(), preg_replace("/(src=\")(\.)/is", "\\1".$u."\\2", geturlwp($u)))));
}

// Other functions

function newsbox($b) {
	global $c, $cl, $h, $cf;
	for($i = 0; $i < $cl; $i++)if($h[$i] == $b)return preg_replace("/".$cf['scripting']['regexp']."/is", "", preg_replace("/.*<\/h[1-".$cf['menu']['levels']."]>/i", "", $c[$i]));
}

?>