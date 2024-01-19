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

   if ($library != "NOBLE")
   {
		if (isset($_GET["branch"]) )
		{
			$branch = $_GET["branch"];

			$sql = "SELECT asset.copy_location.id, asset.copy_location.name
					  FROM asset.copy_location
					  JOIN actor.org_unit ON actor.org_unit.id=asset.copy_location.owning_lib
					  WHERE (actor.org_unit.shortname = '$library' OR actor.org_unit.shortname = '$branch' OR actor.org_unit.shortname = 'NOBLE')
					  AND asset.copy_location.deleted = false
					  ORDER BY asset.copy_location.name";
		}
		else
		{
			 $sql = "SELECT asset.copy_location.id, asset.copy_location.name
						FROM asset.copy_location
						JOIN actor.org_unit ON actor.org_unit.id=asset.copy_location.owning_lib
						WHERE asset.copy_location.deleted = false
						AND (actor.org_unit.shortname = '$library'  OR
						actor.org_unit.id IN (SELECT child.id
								 FROM actor.org_unit child
								 JOIN actor.org_unit parent on child.parent_ou = parent.id
								 WHERE parent.shortname='$library'
								 ORDER BY child.id)
						OR actor.org_unit.shortname = 'NOBLE')
						ORDER BY asset.copy_location.name";
		}

		$result = pg_query($db, $sql);

		$copy_locs ="";

		while($row = pg_fetch_row($result))
		{
		   $loc_id = $row[0];
		   $loc_name = $row[1];

			if( strlen($loc_name) > 0)
			{
				$copy_locs .="<input type=\\\"checkbox\\\" id=\\\"".$loc_id."\\\" name=\\\"copy_loc_checkboxes[]\\\" value=\\\"".$loc_id."\\\" class=\\\"multi_check\\\"  onclick=\\\"JavaScript:getCircModifierList(false)\\\" />";
            $copy_locs .="<label for=\\\"".$loc_name."\\\" class=\\\"multi_cb_label\\\">".$loc_name."</label><br/>";
			}
		}

		echo "copy_loc.innerHTML = \"".$copy_locs."\";\n";
   }

   //set the copy location groups
   $sql = "SELECT asset.copy_location_group.id, asset.copy_location_group.name
			  FROM asset.copy_location_group
			  JOIN actor.org_unit ON actor.org_unit.id = asset.copy_location_group.owner
			  WHERE actor.org_unit.shortname = '$library'
			  UNION
			  SELECT  asset.copy_location_group.id, asset.copy_location_group.name
			  FROM asset.copy_location_group
			  JOIN actor.org_unit ON actor.org_unit.id = asset.copy_location_group.owner
			  WHERE asset.copy_location_group.owner IN (SELECT child.id
																  FROM actor.org_unit child
																  JOIN actor.org_unit parent on child.parent_ou = parent.id
																  WHERE parent.shortname='$library' AND child.ou_type = 3)
			ORDER BY 2";

   $result = pg_query($db, $sql);

   echo "copy_loc_group.options[copy_loc_group.options.length] = new Option('','-1');\n";

   while($row = pg_fetch_row($result))
	{
		if( strlen($row[1]) > 0)
		{
		   echo "copy_loc_group.options[copy_loc_group.options.length] = new Option(\"".$row[1]."\",\"".$row[0]."\");\n";
	   }
	}

}

?>
