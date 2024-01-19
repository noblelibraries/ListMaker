<?php

if(isset($_GET["lib"]) )
{
   include "/usr/local/noble/db_config/db_info.php";

   $db = pg_connect("host=$eg_host port=$eg_port dbname=$eg_database user=$eg_user password=$eg_password");
   if (!$db)
   {
      die("Error in connection: " . pg_last_error());
   }

   $library = $_GET["lib"];
   $branch = $_GET["branch"];

   //get the branch id
   if ($branch == "none") $lib = $library;
   else $lib = $branch;

   if ($library == "NOBLE")
   {
      $sql = "SELECT  asset.course_module_term.id, asset.course_module_term.name, asset.course_module_term.start_date
			    FROM asset.course_module_term
			    ORDER BY asset.course_module_term.start_date DESC";
   }
   else if ($branch == 'none')
   {
      	$sql = "SELECT  asset.course_module_term.id, asset.course_module_term.name, asset.course_module_term.start_date
			    FROM asset.course_module_term
			    JOIN actor.org_unit ON actor.org_unit.id = asset.course_module_term.owning_lib
			    WHERE actor.org_unit.shortname IN (SELECT child.shortname
											 FROM actor.org_unit child
											 JOIN actor.org_unit parent on child.parent_ou = parent.id
											 WHERE parent.shortname='$library' OR child.shortname='$library')
			  ORDER BY asset.course_module_term.start_date DESC";
   }
   else
   {
      $sql = "SELECT  asset.course_module_term.id, asset.course_module_term.name, asset.course_module_term.start_date
			    FROM asset.course_module_term
			    JOIN actor.org_unit ON actor.org_unit.id = asset.course_module_term.owning_lib
			    WHERE actor.org_unit.shortname = '$branch' OR actor.org_unit.shortname = '$library'
			    ORDER BY asset.course_module_term.start_date DESC";
   }



   $result = pg_query($db, $sql);

   echo "obj.options[obj.options.length] = new Option('Select','-1');\n";

   while($row = pg_fetch_row($result))
   {
      if( strlen($row[0]) > 0)
      {
         echo "obj.options[obj.options.length] = new Option(\"".$row[1]."\",\"".$row[1]."***".$row[0]."\");\n";
      }
   }
}

?>