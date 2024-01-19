<?php

if(isset($_GET["lib"]) && isset($_GET["stat"]))
{
   include "/usr/local/noble/db_config/db_info.php";

   $db = pg_connect("host=$eg_host port=$eg_port dbname=$eg_database user=$eg_user password=$eg_password");
   if (!$db)
   {
      die("Error in connection: " . pg_last_error());
   }

   $library = $_GET["lib"];
   $stat_cats = explode("*",$_GET["stat"]);
   $branch = $_GET["branch"];

   //Get all the Possible CAtegories for this library
   if ($library == "NOBLE")
   {
       $sql = "SELECT asset.stat_cat.id, asset.stat_cat.name
               FROM asset.stat_cat
               JOIN actor.org_unit ON actor.org_unit.id=asset.stat_cat.owner
               WHERE actor.org_unit.shortname = 'NOBLE'
               ORDER BY asset.stat_cat.name";
   }
   else if ($branch == 'none')
   {

      $sql = "SELECT asset.stat_cat.id, asset.stat_cat.name
              FROM asset.stat_cat
              JOIN actor.org_unit ON actor.org_unit.id=asset.stat_cat.owner
              WHERE actor.org_unit.shortname = 'NOBLE'
              OR actor.org_unit.shortname IN (SELECT child.shortname
                                     FROM actor.org_unit child
                                     JOIN actor.org_unit parent on child.parent_ou = parent.id
                                     WHERE parent.shortname='$library' OR child.shortname='$library')
              ORDER BY asset.stat_cat.name";
   }
   else
   {
       $sql = "SELECT asset.stat_cat.id, asset.stat_cat.name
               FROM asset.stat_cat
               JOIN actor.org_unit ON actor.org_unit.id=asset.stat_cat.owner
               WHERE actor.org_unit.shortname = '$library' OR actor.org_unit.shortname = 'NOBLE'
               OR actor.org_unit.shortname = '$branch'
               ORDER BY asset.stat_cat.name";
   }
   $result = pg_query($db, $sql);

   echo "stat_obj.options[stat_obj.options.length] = new Option('Select','-1');\n";

   while($row = pg_fetch_row($result))
   {
      if( strlen($row[1]) > 0)
      {
         echo "stat_obj.options[stat_obj.options.length] = new Option(\"".$row[1]."\",\"".$row[1]."***".$row[0]."\");\n";
      }
   }

   $remove = array("(", ")");

   //loop thorugh the selected stat cats
   foreach($stat_cats as $curr)
   {
      //get the cat id
      $cat_id = substr($curr, 0, strpos($curr,"("));
      //find the cat words
      $cat_sql = "SELECT asset.stat_cat.id, asset.stat_cat.name
                  FROM asset.stat_cat
                  WHERE id = $cat_id ";

      $cat_result = pg_query($db, $cat_sql);
      $cat_row = pg_fetch_row($cat_result);

      $cat_words = $cat_row[1];

      //get the entry id
      $entry_id = str_replace($remove,"",strstr($curr,"("));
      //find the entry words
      $entry_sql = "SELECT DISTINCT asset.stat_cat_entry.id, asset.stat_cat_entry.value
                    FROM asset.stat_cat_entry
                    WHERE asset.stat_cat_entry.id = $entry_id ";

      $entry_result = pg_query($db, $entry_sql);
      $entry_row = pg_fetch_row($entry_result);

      $entry_words = $entry_row[1];

      $node_name = str_replace("'","*",$entry_row[1])."***".$entry_row[0];;
      //add new nodes to the bottom

      echo "var new_html ='';\n";

      //create a span ew_html += "<span id='"+checkbox_val+"' class='stat_row'>";
      echo "new_html  += \"<span id='".$node_name."' class='stat_row'>\";\n";

      //create words for the stat
      echo "new_html += \"<span id='".$cat_words."/".str_replace("'","*", $entry_words)."' name='stat_words'>".$cat_words."/".$entry_words."</span>\";\n";

      //create hidden input for the values with common name
      echo "new_html += \"<input type='hidden' name='stat_vals' value='".$cat_id."(".$entry_id.")' />\";";

      //create a button to remove with checkbox_val ans val
      echo "new_html +=\"<input type=\\\"button\\\"  value=\\\"Remove\\\" class=\\\"remove_stat\\\" onClick=\\\"RemoveStatCat('".$node_name."')\\\"/>\";";

      //end span
      echo "new_html += \"</span>\";";

      echo "selected_stats.innerHTML += new_html;";

   }

}

?>