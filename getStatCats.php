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

   echo "obj.options[obj.options.length] = new Option('Select','-1');\n";

   while($row = pg_fetch_row($result))
   {
      if( strlen($row[1]) > 0)
      {
         echo "obj.options[obj.options.length] = new Option(\"".$row[1]."\",\"".$row[1]."***".$row[0]."\");\n";
      }
   }
}

?>