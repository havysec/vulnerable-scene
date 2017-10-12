<?php
/*
CMSimple version 3.1 - April 2. 2008
Small - simple - smart
© 1999-2008 Peter Andreas Harteg - peter@harteg.dk

This file is part of CMSimple.
For licence see notice in /cmsimple/cms.php and http://www.cmsimple.dk/?Licence
*/

if (eregi('mailform.php', sv('PHP_SELF')))die('Access Denied');

$title = $tx['title'][$f];
$o .= '<h1>'.$title.'</h1>';
initvar('sender');
$t = '';
if ($action == 'send') {
	if ($mailform == '')$e .= '<li>'.$tx['error']['mustwritemes'];
	else if(!(eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[_a-z0-9-]+(\.[_a-z0-9-]+)*(\.([a-z]{2,4}))+$", $sender)))$e .= '<li>'.$tx['error']['mustwritemail'].'.';
	else if(!(@mail($cf['mailform']['email'], 'Mailform from '.sv('SERVER_NAME'), stsl($mailform), "From: ".stsl($sender)."\r\n"."X-Remote: ".sv('REMOTE_ADDR')."\r\n")))$e .= '<li>'.$tx['mailform']['notsend'];
	else $t = '<p>'.$tx['mailform']['send'].'</p>';
}
if ($t == '' || $e != '') {
	if (@$tx['mailform']['message'] != '')$o .= '<p>'.$tx['mailform']['message'].'</p>';
	$o .= '<form action="'.$sn.'" method="post"><textarea rows="12" cols="40" name="mailform">';
	if ($mailform != 'true')$o .= htmlspecialchars(stsl($mailform));
	$o .= '</textarea>'.tag('input type="hidden" name="function" value="mailform"').tag('input type="hidden" name="action" value="send"').tag('br').$tx['mailform']['sender'].': '.tag('input type="text" class="text" name="sender" value="'.htmlspecialchars(stsl($sender)).'"').' '.tag('input type="submit" class="submit" value="'.$tx['mailform']['sendbutton'].'"').'</form>';
}
else $o .= $t;

?>