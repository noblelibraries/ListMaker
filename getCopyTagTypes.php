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

   echo "obj.options[obj.options.length] = new Option('Select','-1');\n";

   while($row = pg_fetch_row($result))
   {
      if( strlen($row[0]) > 0)
      {
         echo "obj.options[obj.options.length] = new Option(\"".$row[0]."\",\"".$row[0]."***".$row[1]."\");\n";
      }
   }
}

?>