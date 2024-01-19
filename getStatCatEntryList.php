<?php

if(isset($_GET["statCat"]) )
{
   include "/usr/local/noble/db_config/db_info.php";

   $db = pg_connect("host=$eg_host port=$eg_port dbname=$eg_database user=$eg_user password=$eg_password");
   if (!$db)
   {
      die("Error in connection: " . pg_last_error());
   }

   $check_entries = false;
   $stat_cat = $_GET["statCat"];

   if (isset($_GET["entries"]))
   {
      $check_entries = true;
      $entries = explode("*", $_GET["entries"]);
   }

   $sql = "SELECT DISTINCT asset.stat_cat_entry.id, asset.stat_cat_entry.value
           FROM asset.stat_cat_entry
           WHERE asset.stat_cat_entry.stat_cat = $stat_cat
           ORDER BY asset.stat_cat_entry.value";

   $result = pg_query($db, $sql);

   while($row = pg_fetch_row($result))
   {
      if( strlen($row[1]) > 0)
      {
         $cb_val = str_replace("'","*",$row[1])."***".$row[0];
         echo "var checkbox = \"<input type='checkbox' name='SC_entries' value='".$cb_val."' id='".$cb_val."_cb' ";
         if (in_array($row[0], $entries)) echo "checked=checked ";
         echo "onClick='AddStatCat(this)'/>\";";
         echo "checkbox_div.innerHTML+=checkbox +\"".$row[1]."\"+ \"<br/>\";";
      }
   }
}

?>