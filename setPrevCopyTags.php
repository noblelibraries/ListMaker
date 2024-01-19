<?php

if(isset($_GET["lib"]) && isset($_GET["tags"]))
{
   include "/usr/local/noble/db_config/db_info.php";

   $db = pg_connect("host=$eg_host port=$eg_port dbname=$eg_database user=$eg_user password=$eg_password");
   if (!$db)
   {
      die("Error in connection: " . pg_last_error());
   }

   $library = $_GET["lib"];
   $tags = explode(",",$_GET["tags"]);
   $branch = $_GET["branch"];

   //Get all the Possible tag types for this library
  	if ($library == "NOBLE")
	{
	   $sql = "SELECT config.copy_tag_type.label, config.copy_tag_type.code
		       FROM config.copy_tag_type
			   JOIN actor.org_unit ON actor.org_unit.id=config.copy_tag_type.owner
			   ORDER BY 1";
	}
	else
	{

	   $sql = "SELECT DISTINCT config.copy_tag_type.label, config.copy_tag_type.code
		       FROM config.copy_tag_type
			   JOIN actor.org_unit ON actor.org_unit.id=config.copy_tag_type.owner
			   WHERE actor.org_unit.shortname = '$library'
			   OR actor.org_unit.shortname = '$branch'
			   OR actor.org_unit.shortname IN (SELECT child.shortname
			                                   FROM actor.org_unit child
		                                       JOIN actor.org_unit parent on child.parent_ou = parent.id
											   WHERE parent.shortname='$library' OR child.shortname='$library')
               UNION
               SELECT DISTINCT config.copy_tag_type.label, config.copy_tag_type.code
               FROM config.copy_tag_type
               JOIN asset.copy_tag ON asset.copy_tag.tag_type = config.copy_tag_type.code
               JOIN actor.org_unit ON actor.org_unit.id=asset.copy_tag.owner
               WHERE config.copy_tag_type.owner = 1
               AND (actor.org_unit.shortname = '$library'
			   OR actor.org_unit.shortname IN (SELECT child.shortname
											 FROM actor.org_unit child
											 JOIN actor.org_unit parent on child.parent_ou = parent.id
											 WHERE parent.shortname='$library' OR child.shortname='$library'))
               ORDER BY 1";
   }

   $result = pg_query($db, $sql);

   echo "tag_type_obj.options[tag_type_obj.options.length] = new Option('Select','-1');\n";

   while($row = pg_fetch_row($result))
   {
      if( strlen($row[1]) > 0)
      {
         echo "tag_type_obj.options[tag_type_obj.options.length] = new Option(\"".$row[0]."\",\"".$row[0]."***".$row[1]."\");\n";
      }
   }

   $remove = array("(", ")");

   //loop thorugh the selected stat cats
   foreach($tags as $curr)
   {
      //get the cat id
      //find the cat words
      $tag_sql = "SELECT config.copy_tag_type.code, config.copy_tag_type.label, asset.copy_tag.id, asset.copy_tag.value
                  FROM asset.copy_tag
                  JOIN config.copy_tag_type ON config.copy_tag_type.code = asset.copy_tag.tag_type
                  WHERE asset.copy_tag.id = $curr ";

      $tag_result = pg_query($db, $tag_sql);
      $tag_row = pg_fetch_row($tag_result);

      $type_words = $tag_row[1];
      $type_id = $tag_row[0];

      $tag_words = $tag_row[3];
      $tag_id = $tag_row[2];

      //add new nodes to the bottom
      $node_name = str_replace("'","*",$tag_words)."***".$tag_id;


      echo "var new_html ='';\n";

      //create a span ew_html += "<span id='"+checkbox_val+"' class='stat_row'>";
      echo "new_html  += \"<span id='".$node_name."' class='stat_row'>\";\n";

      //create words for the stat
      echo "new_html += \"<span id='".$type_words."/".str_replace("'","*", $tag_words)."' name='tag_words'>".$type_words."/".$tag_words."</span>\";\n";

      //create hidden input for the values with common name
      echo "new_html += \"<input type='hidden' name='tag_vals' value='".$tag_id."' />\";";

      //create a button to remove with checkbox_val ans val
      echo "new_html +=\"<input type=\\\"button\\\"  value=\\\"Remove\\\" class=\\\"remove_stat\\\" onClick=\\\"RemoveTag('".$node_name."')\\\"/>\";";

      //end span
      echo "new_html += \"</span>\";";

      echo "selected_tags.innerHTML += new_html;";

   }

}

?>