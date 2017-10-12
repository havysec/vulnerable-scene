Open "admin/image_upload.php"

Search for:
	$sql="SELECT cat_id, cat_name FROM ".$prefix."categories";

Replace by:
	$sql="SELECT cat_id, cat_name FROM ".$prefix."categories ORDER BY cat_name ASC";

-------------------------------------------------------------------------------------------

Open "upload.php"

Search for:
	$sql="SELECT cat_id, cat_name FROM ".$prefix."categories";

Replace by:
	$sql="SELECT cat_id, cat_name FROM ".$prefix."categories ORDER BY cat_name ASC";