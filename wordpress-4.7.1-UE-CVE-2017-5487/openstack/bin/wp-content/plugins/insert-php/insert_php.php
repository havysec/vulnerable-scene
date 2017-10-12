<?php
/*
Plugin Name: Insert PHP
Plugin URI: http://www.willmaster.com/software/WPplugins/
Description: Run PHP code inserted into WordPress posts and pages.
Version: 1.3
Date: 29 September 2015
Author: Will Bontrager Software, LLC <will@willmaster.com>
Author URI: http://www.willmaster.com/contact.php
*/

/*
	Copyright 2012,2013,2015 Will Bontrager Software LLC (email: will@willmaster.com)

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License, version 2, as 
	published by the Free Software Foundation. A copy of the license is at
	http://www.gnu.org/licenses/gpl-2.0.html

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
	GNU General Public License for more details.
*/

/*
Note: This plugin requires WordPress version 3.3.1 or higher.

Information about the Insert PHP plugin can be found here:
http://www.willmaster.com/software/WPplugins/go/iphphome_iphplugin

Instructions and examples can be found here:
http://www.willmaster.com/software/WPplugins/go/iphpinstructions_iphplugin
*/


if( ! function_exists('will_bontrager_insert_php') )
{

	function will_bontrager_insert_php($content)
	{
		$will_bontrager_content = $content;
		preg_match_all('!\[insert_php[^\]]*\](.*?)\[/insert_php[^\]]*\]!is',$will_bontrager_content,$will_bontrager_matches);
		$will_bontrager_nummatches = count($will_bontrager_matches[0]);
		for( $will_bontrager_i=0; $will_bontrager_i<$will_bontrager_nummatches; $will_bontrager_i++ )
		{
			ob_start();
			eval($will_bontrager_matches[1][$will_bontrager_i]);
			$will_bontrager_replacement = ob_get_contents();
			ob_clean();
			ob_end_flush();
			$will_bontrager_content = preg_replace('/'.preg_quote($will_bontrager_matches[0][$will_bontrager_i],'/').'/',$will_bontrager_replacement,$will_bontrager_content,1);
		}
		return $will_bontrager_content;
	} # function will_bontrager_insert_php()

	add_filter( 'the_content', 'will_bontrager_insert_php', 9 );

} # if( ! function_exists('will_bontrager_insert_php') )
?>
