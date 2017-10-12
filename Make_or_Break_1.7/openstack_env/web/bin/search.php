<?php
/************************************************************************
 * This file is part of Make or Break.					*
 *									*
 * Make or Break is free software: you can redistribute it and/or modify*
 * it under the terms of the GNU General Public License as published by	*
 * the Free Software Foundation, either version 3 of the License, or	*
 * (at your option) any later version.					*
 *									*
 * Make or Break is distributed in the hope that it will be useful,	*
 * but WITHOUT ANY WARRANTY; without even the implied warranty of	*
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the	*
 * GNU General Public License for more details.				*
 *									*
 * You should have received a copy of the GNU General Public License	*
 * along with Make or Break.  If not, see <http://www.gnu.org/licenses>.*
 ************************************************************************/
require('include/header.php');

// Set up our error check and result check array
$error = array();
$results = array();

// First check if a form was submitted. 
// Since this is a search we will use $_GET
if (isset($_GET['search'])) {
   $searchTerms = trim($_GET['search']);
   $searchTerms = strip_tags($searchTerms); // remove any html/javascript.
   
   if (strlen($searchTerms) < 3) {
      $error[] = "Search terms must be longer than 3 characters.";
   }else {
      $searchTermDB = mysql_real_escape_string($searchTerms); // prevent sql injection.
   }
   
   // If there are no errors, lets get the search going.
   if (count($error) < 1) {
      //$searchSQL = "SELECT img_id, img_name, img_filename, img_description FROM mob_images WHERE ";
      $searchSQL = "SELECT * FROM mob_images WHERE ";
      
      // grab the search types.
      $types = array();
      $types[] = isset($_GET['name'])?"`img_name` LIKE '%{$searchTermDB}%'":'';
      $types[] = isset($_GET['filename'])?"`img_filename` LIKE '%{$searchTermDB}%'":'';
      $types[] = isset($_GET['desc'])?"`img_description` LIKE '%{$searchTermDB}%'":'';
      
      $types = array_filter($types, "removeEmpty"); // removes any item that was empty (not checked)
      
      if (count($types) < 1)
         $types[] = "`img_name` LIKE '%{$searchTermDB}%'"; // use the body as a default search if none are checked
      
          $andOr = isset($_GET['matchall'])?'AND':'OR';
      $searchSQL .= implode(" {$andOr} ", $types) . " ORDER BY `img_name`"; // order by title.

      $searchResult = mysql_query($searchSQL) or trigger_error("There was an error.<br/>" . mysql_error() . "<br />SQL Was: {$searchSQL}");
      


      if (mysql_num_rows($searchResult) < 1) {
         $error[] = "The search term provided {$searchTerms} has no results.";
      }else {
         $results = array(); // the result array
         $i = 1;
         while ($row = mysql_fetch_assoc($searchResult)) {
			$results[] = "<table><tr>
				<td valign='top'>{$i}:</td>
				<td valign='top'><a href='index.php?imgid={$row['img_id']}'><img border='0' src='uploads/thumbs/{$row['img_filename']}'></a></td>

				<td valign='top'>
					<a href='../index.php?imgid={$row['img_id']}'>{$row['img_name']}</a><br>
					Uploaded at: {$row['img_date']}<br>
					Voting average: {$row['img_average']}
				</td>
			</tr></table><hr>";
            $i++;
         }
      }
   }
}



function removeEmpty($var) {
   return (!empty($var)); 
}
?>
<html>
   <?php echo "<title>".$pagename." - Search</title>";?>
   <style type="text/css">
      #error {
         color: red;
      }
   </style>
   <body>


<?php
echo "<table class='table' width='100%'>";
echo "<tr class='table_header'>";
echo "<td class='table_header'>Search:</td>";
echo "</tr><tr>";
echo "<td class='cell_content'>";

       echo (count($error) > 0)?"The following had errors:<br /><span id=\"error\">" . implode("<br />", $error) . "</span><br /><br />":""; ?>
      <form method="GET" action="<?php echo $_SERVER['PHP_SELF'];?>" name="searchForm">
         Search For: <input type="text" name="search" value="<?php echo isset($searchTerms)?htmlspecialchars($searchTerms):''; ?>" /><br />
         Search In:<br />
         Name: <input type="checkbox" name="name" value="on" <?php echo isset($_GET['name'])?"checked":''; ?> /> | 
         Filename: <input type="checkbox" name="filename" value="on" <?php echo isset($_GET['filename'])?"checked":''; ?> /> | 
         Description: <input type="checkbox" name="desc" value="on" <?php echo isset($_GET['desc'])?"checked":''; ?> /><br />
                 Match All Selected Fields? <input type="checkbox" name="matchall" value="on" <?php echo isset($_GET['matchall'])?"checked":''; ?><br /><br />
         <input type="submit" name="submit" value="Search!" />
      </form>
      <?php echo (count($results) > 0)?"Your search term: {$searchTerms} returned:<br /><br />" . implode("", $results):""; ?>
   </body>
</html>


</td></tr></table>

<?php
	require('include/footer.php');
?>