<?php

if(isset($_GET["type"]) )
{
   include "/usr/local/noble/db_config/db_info.php";

   $db = pg_connect("host=$eg_host port=$eg_port dbname=$eg_database user=$eg_user password=$eg_password");
   if (!$db)
   {
      die("Error in connection: " . pg_last_error());
   }

   $check_tags = false;
   $type = $_GET["type"];

   $library = $_GET["lib"];
   $branch = $_GET["branch"];


   if (isset($_GET["tags"]))
   {
      $check_tags = true;
      $tags = explode("*", $_GET["tags"]);
   }

   if ($library == "NOBLE")
   {
      $sql = "SELECT DISTINCT asset.copy_tag.id, asset.copy_tag.value
              FROM asset.copy_tag
              WHERE asset.copy_tag.tag_type = '$type'
              ORDER BY asset.copy_tag.value";
   }
   else if ($branch != "none")
   {
       $sql = "SELECT DISTINCT asset.copy_tag.id, asset.copy_tag.value
              FROM asset.copy_tag
              JOIN actor.org_unit ON actor.org_unit.id=asset.copy_tag.owner
              WHERE asset.copy_tag.tag_type = '$type'
              AND actor.org_unit.shortname = '$branch'
              ORDER BY asset.copy_tag.value";
   }
   else
   {
      $sql = "SELECT DISTINCT asset.copy_tag.id, asset.copy_tag.value
              FROM asset.copy_tag
              JOIN actor.org_unit ON actor.org_unit.id=asset.copy_tag.owner
              WHERE asset.copy_tag.tag_type = '$type'
              AND (actor.org_unit.shortname = '$library'
			  OR actor.org_unit.shortname IN (SELECT child.shortname
											 FROM actor.org_unit child
											 JOIN actor.org_unit parent on child.parent_ou = parent.id
											 WHERE parent.shortname='$library' OR child.shortname='$library'))
              ORDER BY asset.copy_tag.value";
   }

   $result = pg_query($db, $sql);

   while($row = pg_fetch_row($result))
   {
      if( strlen($row[1]) > 0)
      {
         $cb_val = str_replace("'","*",$row[1])."***".$row[0];
         echo "var checkbox = \"<input type='checkbox' name='tag_checkboxes' value='".$cb_val."' id='".$cb_val."_cb' ";
         if (in_array($row[0], $tags)) echo "checked=checked ";
         echo "onClick='AddTag(this)'/>\";";
         echo "checkbox_div.innerHTML+=checkbox +\"".$row[1]."\"+ \"<br/>\";";
      }
   }
}

?>