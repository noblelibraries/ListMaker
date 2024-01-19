<?php

if(isset($_GET["str"]) )
{
   include "/usr/local/noble/db_config/db_info.php";
   
   $db = pg_connect("host=$dbro_host port=5432 dbname=$dbro_database user=$dbro_user password=$dbro_password");
   if (!$db) 
   {
      die("Error in connection: " . pg_last_error());
   } 
   
   $stat_string = str_replace("%", " ", $_GET["str"]);
   
   //get the stat cat from string
   $pos = strpos($stat_string,"("); 
   $stat_cat_id = substr($stat_string, 0, $pos-1);
   
   $sql = "SELECT asset.stat_cat.name
           FROM asset.stat_cat
           WHERE asset.stat_cat.id = $stat_cat_id";
   $result = pg_query($db, $sql); 
   
   $row = pg_fetch_row($result);
   
   $stat_cat_name = $row[0];
   echo "cat_obj.value= ' ".$stat_cat_id." ' ;\n ";
    
   //get the stat cat entries () from string
   $stat_cat_entries = substr($stat_string, $pos);
   echo "entry_obj.value= ' ".$stat_cat_entries." ' ;\n ";
     
   if(strpos($stat_cat_entries, "ALL") == true )
   {
      echo "text_obj.innerHTML+= ' <span class=\"stat\"> ".$stat_cat_name." / ALL <br /></span>' ;\n";
   }
   else
   {
      $sql = "SELECT asset.stat_cat_entry.value
              FROM asset.stat_cat_entry
              WHERE asset.stat_cat_entry.id IN $stat_cat_entries
              ORDER BY asset.stat_cat_entry.value";
      $result = pg_query($db, $sql); 
   

      while ($row = pg_fetch_row($result) )
      {
         $display = str_replace("'","\'",$row[0]);
         echo "text_obj.innerHTML+= ' <span class=\"stat\"> ".$stat_cat_name." / ".$display." <br /></span>' ;\n";
      }

   }
}

?>