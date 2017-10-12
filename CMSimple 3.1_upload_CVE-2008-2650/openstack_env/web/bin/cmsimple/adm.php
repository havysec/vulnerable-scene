<?php
/*
CMSimple version 3.1 - April 2. 2008
Small - simple - smart
© 1999-2008 Peter Andreas Harteg - peter@harteg.dk

This file is part of CMSimple.
For licence see notice in /cmsimple/cms.php and http://www.cmsimple.dk/?Licence
*/

if (eregi('adm.php', sv('PHP_SELF')))die('Access Denied');

// Functions used for adm

function selectlist($fn, $regm, $regr) {
	global $k1, $k2, $v2, $o, $pth;
	$o .= '<select name="'.$k1.'_'.$k2.'">';
	if ($fd = @opendir($pth['folder'][$fn])) {
		while (($p = @readdir($fd)) == true) {
			if (preg_match($regm, $p)) {
				$v = preg_replace($regr, "\\1", $p);
				$o .= '<option value="'.$v.'"';
				if ($v == $v2) $o .= ' selected="selected"';
				$o .= '>'.$v.'</option>';
			}
		}
		closedir($fd);
	}
	$o .= '</select>';
}

function im($n, $p) {
	if (!isset($_FILES)) {
		global $_FILES;
		 $_FILES = $GLOBALS['HTTP_POST_FILES'];
	}
	if (isset($_FILES[$n][$p]))return $_FILES[$n][$p];
	else return'';
}

// Adm functionality

if ($adm) {

	if ($validate)$f = 'validate';
	if ($settings)$f = 'settings';
	if ($file)$f = 'file';
	if ($images || $function == 'images')$f = 'images';
	if ($downloads || $function == 'downloads')$f = 'downloads';
	if ($function == 'save')$f = 'save';

	if ($f == 'settings' || $f == 'images' || $f == 'downloads' || $f == 'validate') {
		$title = $tx['title'][$f];
		$o .= '<h1>'.$title.'</h1>';
	}

	// SETTINGS

	if ($f == 'settings') {
		$o .= '<p>'.$tx['settings']['warning'].'</p><h4>'.$tx['settings']['systemfiles'].'</h4><ul>';
		foreach(array('config', 'language') as $i)$o .= '<li><a href="'.$sn.'?file='.$i.amp().'action=array">'.ucfirst($tx['action']['edit']).' '.$tx['filetype'][$i].'</a></li>';
		foreach(array('stylesheet', 'template') as $i)$o .= '<li><a href="'.$sn.'?file='.$i.amp().'action=edit">'.ucfirst($tx['action']['edit']).' '.$tx['filetype'][$i].'</a></li>';
		foreach(array('log') as $i)$o .= '<li><a href="'.$sn.'?file='.$i.amp().'action=view">'.ucfirst($tx['action']['view']).' '.$tx['filetype'][$i].'</a></li>';
		foreach(array('content') as $i)$o .= '<li>'.ucfirst($tx['filetype'][$i]).' <a href="'.$sn.'?file='.$i.amp().'action=view">'.$tx['action']['view'].'</a>'.' <a href="'.$sn.'?file='.$i.'">'.$tx['action']['edit'].'</a>'.' <a href="'.$sn.'?file='.$i.amp().'action=download">'.$tx['action']['download'].'</a></li>';
		$o .= '</ul><h4>'.$tx['settings']['backup'].'</h4><p>'.$tx['settings']['backupexplain1'].'</p><p>'.$tx['settings']['backupexplain2'].'</p><ul>';
		$fs = sortdir($pth['folder']['content']);
		foreach($fs as $p)if(preg_match("/\d{3}\.htm/", $p))$o .= '<a href="'.$sn.'?file='.$p.amp().'action=view"><li>'.$p.'</a> ('.(round((filesize($pth['folder']['content'].'/'.$p))/102.4)/10).' KB)</li>';
		$o .= '</ul>';
		}

	if ($f == 'images' || $f == 'downloads') {
		if ($f == 'images')$reg = "/\.gif$|\.jpg$|\.jpeg$|\.png$/i";
		else $reg = "/^[^\.]/i";
		if ($action == 'delete') {
			if (!(preg_match($reg, $GLOBALS[$f])))e('wrongext', 'file', $GLOBALS[$f]);
			else
				{
				if (@unlink($pth['folder'][$f].$GLOBALS[$f]))$o .= '<p>'.ucfirst($tx['filetype']['file']).' '.$GLOBALS[$f].' '.$tx['result']['deleted'].'</p>';
				else e('cntdelete', 'file', $GLOBALS[$f]);
			}
		}
		if ($action == 'upload') {
			$name = im($f, 'name');
			$size = im($f, 'size');
			if (!(preg_match($reg, $name)))e('wrongext', 'file', $name);
			else if(file_exists(rp($pth['folder'][$f].$name)))e('alreadyexists', 'file', $name);
			else if($size > $cf[$f]['maxsize'])$e .= '<li>'.ucfirst($tx['filetype']['file']).' '.$name.' '.$tx['error']['tolarge'].' '.$cf[$f]['maxsize'].' '.$tx['files']['bytes'].'</li>';
			if (!$e) {
				if (@move_uploaded_file(im($f, 'tmp_name'), $pth['folder'][$f].$name))$o .= '<p>'.ucfirst($tx['filetype']['file']).' '.$name.' '.$tx['result']['uploaded'].'</p>';
				else e('cntsave', 'file', $name);
			}
		}
		if ($cf[$f]['maxsize'] > 0)$o .= '<form method="POST" action="'.$sn.'" enctype="multipart/form-data"><p>'.tag('input type="file" class="file" name="'.$f.'" size="30"').tag('input type="hidden" name="action" value="upload"').' '.tag('input type="hidden" name="function" value="'.$f.'"').tag('input type="submit" class="submit" value="'.ucfirst($tx['action']['upload']).'"').'</p></form>';
		$o .= '<form method="post" action='.$sn.'><table width="100%" cellpadding="5" cellspacing="0" border="0">';
		$totalsize = 0;
		if (@is_dir($pth['folder'][$f])) {
			$fs = sortdir($pth['folder'][$f]);
			foreach($fs as $p) {
				if (preg_match($reg, $p)) {
					$totalsize += filesize($pth['folder'][$f].$p);
					$o .= '<tr><td>'.tag('input type="radio" class="radio" name="'.$f.'" value="'.$p.'"').'</td><td>';
					if ($f == 'images')$o .= '<img src="'.$pth['folder'][$f].$p.'">'.tag('br');
					$o .= $p.' ('.(round((filesize($pth['folder'][$f].$p))/102.4)/10).' KB)';
					if ($f == 'images') {
						for($i = 0; $i < $cl; $i++) {
							$ic = preg_match_all('/<img src=["]*([^"]*?)'.'\/'.$p.'["]*(.*?)>/i', $c[$i], $matches, PREG_PATTERN_ORDER);
							if ($ic > 0)$o .= tag('br').$tx[$f]['usedin'].' '.a($i, '').$h[$i].'</a>';
						}
					}
					$o .= '</td></tr>';
				}
			}
			$o .= '</table>'.tag('br').tag('input type="hidden" name="action" value="delete"').tag('input type="hidden" name="function" value="'.$f.'"');
			if ($totalsize > 0)$o .= tag('input type="submit" class="submit" value="'.ucfirst($tx['action']['delete']).'"');
			$o .= '</form>';
			$o .= '<p>'.$tx['files']['totalsize'].': '.(round($totalsize/102.4)/10).' KB</p>';
		}
		else e('cntopen', 'folder', $pth['folder'][$f]);
	}

	if ($f == 'file') {
		if (preg_match("/\d{3}\.htm/", $file))$pth['file'][$file] = $pth['folder']['content'].'/'.$file;
		if ($pth['file'][$file] != '') {
			if ($action == 'view') {
				header('Content-Type: text/plain');
				echo rmnl(rf($pth['file'][$file]));
				exit;
			}
			if ($action == 'download') {
				download($pth['file'][$file]);
			} else {
				initvar('form');
				if ($action == 'array') $form = 'array';
				if ($form == 'array') {
					if ($file == 'language')$a = 'tx';
					if ($file == 'config')$a = 'cf';
					if ($file == 'plugin_config') { $a = 'plugin_cf'; }
					if ($file == 'plugin_language') { $a = 'plugin_tx'; }

				}
				if ($action == 'save') {
					if ($form == 'array') {
						$text = "<?php\n";
						foreach($GLOBALS[$a] as $k1 => $v1) {
							if (is_array($v1)) {
								foreach($v1 as $k2 => $v2) {
									if (!is_array($v2)) {
										initvar($k1.'_'.$k2);
										$GLOBALS[$a][$k1][$k2] = $GLOBALS[$k1.'_'.$k2];
										$GLOBALS[$a][$k1][$k2] = stsl($GLOBALS[$a][$k1][$k2]);
										if ($k1.$k2 == 'editorbuttons')$text .= '$'.$a.'[\''.$k1.'\'][\''.$k2.'\']=\''.$GLOBALS[$a][$k1][$k2].'\';';
										else $text .= '$'.$a.'[\''.$k1.'\'][\''.$k2.'\']="'.preg_replace("/\"/s", "", $GLOBALS[$a][$k1][$k2]).'";'."\n";
									}
								}
							}
						}
						$text .= '?>';
					}
					else $text = rmnl(stsl($text));
					if ($fh = @fopen($pth['file'][$file], "w")) {
						fwrite($fh, $text);
						fclose($fh);
						if ($file == 'config' || $file == 'language') {
							if (!@include($pth['file'][$file]))e('cntopen', $file, $pth['file'][$file]);
							if ($file == 'config') {
								$pth['folder']['template'] = $pth['folder']['templates'].$cf['site']['template'].'/';
								$pth['file']['template'] = $pth['folder']['template'].'template.htm';
								$pth['file']['stylesheet'] = $pth['folder']['template'].'stylesheet.css';
								$pth['folder']['menubuttons'] = $pth['folder']['template'].'menu/';
								$pth['folder']['templateimages'] = $pth['folder']['template'].'images/';
								if (!(preg_match('/\/[A-z]{2}\/[^\/]*/', sv('PHP_SELF')))) {
									$sl = $cf['language']['default'];
									$pth['file']['language'] = $pth['folder']['language'].$sl.'.php';
									if (!@include($pth['file']['language']))die('Language file '.$pth['file']['language'].' missing');
								}
							}
						}
					}
					else e('cntwriteto', $file, $pth['file'][$file]);
				}
				chkfile($file, true);
				$title = ucfirst($tx['action']['edit']).' '.(isset($tx['filetype'][$file])?$tx['filetype'][$file]:$file);
				$o .= '<h1>'.$title.'</h1><form action="'.$sn.(isset($plugin)?'?'.amp().$plugin:'').'" method="post">';
				if ($form == 'array') {
					$o .= '<table width="100%" cellpadding="1" cellspacing="0" border="0">';
					foreach($GLOBALS[$a] as $k1 => $v1) {
					if(!@$plugin||$k1==@$plugin) {
						$o .= '<tr><td colspan="2"><h4>'.ucfirst($k1).'</h4></td></tr>';
						if (is_array($v1))foreach($v1 as $k2 => $v2)if(!is_array($v2)) {
							if (isset($tx['help'][$k1.'_'.$k2]) && $a == 'cf')$o .= '<tr><td colspan="2"><b>'.$tx['help'][$k1.'_'.$k2].':</b></td></tr>';
							$o .= '<tr><td valign="top">'.$k1.'_'.$k2.':</td><td>';
							if ($k1.$k2 == 'editorbuttons')$o .= '<textarea rows="25" cols="35" name="'.$k1.'_'.$k2.'">'.$v2.'</textarea>';
							else if($k1.$k2 == 'securitytype') {
								$o .= '<select name="'.$k1.'_'.$k2.'">';
								foreach(array('page', 'javascript', 'wwwaut') as $v) {
									$o .= '<option value="'.$v.'"';
									if ($v == $v2) $o .= ' selected="selected"';
									$o .= '>'.$v.'</option>';
								}
								$o .= '</select>';
							}
							else if($k1.$k2 == 'languagedefault')selectlist('language', "/^[a-z]{2}\.php$/i", "/^([a-z]{2})\.php$/i");
							else if($k1.$k2 == 'sitetemplate')selectlist('templates', "/^[^\.]*$/i", "/^([^\.]*)$/i");
							else $o .= tag('input type="text" class="text" name="'.$k1.'_'.$k2.'" value="'.$v2.'" size="50"');
							$o .= '</td></tr>';
						}}
					}
					$o .= '</table>'.tag('input type="hidden" name="form" value="'.$form.'"');
				}
				else $o .= '<textarea rows="25" cols="50" name="text">'.rmnl(rf($pth['file'][$file])).'</textarea>';
				if($admin)$o .= tag('input type="hidden" name="admin" value="'.$admin.'"');
				$o .= tag('input type="hidden" name="file" value="'.$file.'"').tag('input type="hidden" name="action" value="save"').' '.tag('input type="submit" class="submit" value="'.ucfirst($tx['action']['save']).'"').'</form>';
			}
		}
	}

	if ($f == 'validate') {
		@set_time_limit(0);
		for($i = 0; $i < $cl; $i++) {
			$ic = preg_match_all('/<a(.*?)href=["]*([^"]*)["]*(.*?)>(.*?)<\/a>/i', $c[$i], $ms, PREG_PATTERN_ORDER);
			if ($ic > 0) {
				$o .= '<h4>'.a($i, '').h($i).'</a> - '.$ic.' link';
				if ($ic > 1)$o .= 's';
				$o .= ':</h4>';
				for($j = 0; $j < $ic; $j++) {
					$o .= '<p>'.$ms[0][$j].tag('br').$ms[2][$j].tag('br');
					if (trim(strip_tags($ms[0][$j])) == '')$o .= '<font color="red">'.$tx[$f]['notxt'].'</font> ';
					if (preg_match('/^http/i', $ms[2][$j])) {
						$tu = parse_url($ms[2][$j]);
						$doc = $tu['path'];
						if (isset($tu['query']))$doc .= '?'.$tu['query'];
						if ($fh = @fsockopen($tu['host'], 80, $en, $es, 5)) {
							$t = '';
							fputs ($fh, "HEAD ".$doc." HTTP/1.0\r\nHost: ".$tu['host']."\r\n\r\n");
							if (function_exists("socket_set_timeout"))socket_set_timeout($fh, 5);
							else if(function_exists("stream_set_timeout"))stream_set_timeout($fh, 5);
							$t = fread($fh, 12);
							fclose($fh);
							$t = preg_replace("/HTTP\/.\.. /i", "", $t);
							if ($t == 200)$o .= '<font color="green">'.$tx[$f]['extok'].'</font>';
							else $o .= '<font color="red">'.$tx[$f]['extfail'].'</font>';
						}
						else $o .= '<font color="red">'.$tx[$f]['extfail'].'</font>';
					} else {
						if (preg_match('/^mailto/i', $ms[2][$j]))$o .= '<font color="orange">'.$tx[$f]['mailto'].'</font>';
						else
							{
							$m = false;
							for($k = 0; $k < $cl; $k++) {
								if ($ms[2][$j] == $sn.'?'.$u[$k])$m = true;
							}
							if ($m)$o .= '<font color="green">'.$tx[$f]['intok'].'</font>';
							else
								{
								if (chkdl($ms[2][$j]))$o .= '<font color="green">'.$tx[$f]['intfilok'].'</font>';
								else $o .= '<font color="red">'.$tx[$f]['intfail'].'</font>';
							}
						}
					}
					$o .= '</p>';
				}
			}
		}
	}
}

if ($s == -1 && !$f && $o == '' && $su == '') {
	$s = 0;
	$hs = 0;
}

// SAVE

if ($adm && $f == 'save') {
	$ss = $s;
	$c[$s] = preg_replace("/<h[1-".$cf['menu']['levels']."][^>]*>(\&nbsp;| )?<\/h[1-".$cf['menu']['levels']."]>/i", "", stsl($text));
	if ($s == 0)if(!preg_match("/^<h1[^>]*>.*<\/h1>/i", rmanl($c[0])) && !preg_match("/^(<p[^>]*>)?(\&nbsp;| |<br \/>)?(<\/p>)?$/i", rmanl($c[0])))$c[0] = '<h1>'.$tx['toc']['missing'].'</h1>'.$c[0];
	$title = ucfirst($tx['filetype']['content']);
	if ($fh = @fopen($pth['file']['content'], "w")) {
		fwrite($fh, '<html><head>'.head().'</head><body>'."\n");
		foreach($c as $i) {
			fwrite($fh, rmnl($i."\n"));
		}
		fwrite($fh, '</body></html>');
		fclose($fh);
		rfc();
	}
	else e('cntwriteto', 'content', $pth['file']['content']);
	$title = '';
}

// EDITOR CALL

if ($adm && $edit && (!$f || $f == 'save') && !$download) {
	if (isset($ss))if($s < 0 && $ss < $cl)$s = $ss;
	if ($s > -1) {
		$su = $u[$s];
		$iimage = '';
		if ($cf['editor']['external'] == '')$cf['editor']['external'] = 'oedit';
		if (!@include($pth['folder']['cmsimple'].$cf['editor']['external'].'.php'))$e .= '<li>External editor '.$cf['editor']['external'].' missing</li>';
	}
	else $o = '<p>'.$tx['error']['cntlocateheading'].'</p>';
}

?>