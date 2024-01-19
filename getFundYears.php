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
   $branch_sql = "SELECT id
              FROM actor.org_unit
              WHERE shortname = '$lib'";

   $branch_result = pg_query($db, $branch_sql);
   $branch_row = pg_fetch_row($branch_result);
   $branch_id = $branch_row[0];

	$sql = "SELECT DISTINCT(acq.fund.year)
			  FROM acq.fund
			  JOIN actor.org_unit ON actor.org_unit.id=acq.fund.org
			  WHERE actor.org_unit.shortname IN (SELECT child.shortname
											 FROM actor.org_unit child
											 JOIN actor.org_unit parent on child.parent_ou = parent.id
											 WHERE parent.shortname='$library' OR child.shortname='$library')
			  ORDER BY acq.fund.year DESC";

   $result = pg_query($db, $sql);

   echo "obj.options[obj.options.length] = new Option('Select','-1');\n";

   while($row = pg_fetch_row($result))
   {
      if( strlen($row[0]) > 0)
      {
         echo "obj.options[obj.options.length] = new Option(\"".$row[0]."\",\"".$row[0]."***".$branch_id."\");\n";
      }
   }
}

?>