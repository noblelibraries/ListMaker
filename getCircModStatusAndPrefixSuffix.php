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

   $location = "(".$_GET["location"].")";

   $use_branch = false;

   if ( isset($_GET["branch"]) )
   {
       $branch = $_GET["branch"];
       $use_branch = true;
   }

   $use_loc_grp = false;
   $get_all = false;

   if(isset($_GET['loc_grp']))
   {
      $use_loc_grp = true;
      $loc_group = $_GET['loc_grp'];

      //get all the locations from the database and set location string
       $sql = "SELECT location
               FROM asset.copy_location_group_map
               WHERE lgroup = $loc_group";

       $result = pg_query($db,$sql);

       $locs = array();
       while($row = pg_fetch_row($result))
       {
          $locs[] = $row[0];
       }
       $location = "(".implode(",",$locs).")";

   }
   else
   {
      if ($_GET["location"] == "all")
      {
         $get_all= true;
      }
      else
      {
         $location = "(".$_GET["location"].")";
      }
   }

   if ($get_all)
   {
      $sql = "SELECT DISTINCT code
              FROM config.circ_modifier
              ORDER BY 1";
   }
   else if ( $use_branch )
   {

      $sql = "SELECT DISTINCT asset.copy.circ_modifier
              FROM asset.copy
              JOIN actor.org_unit ON actor.org_unit.id=asset.copy.circ_lib AND actor.org_unit.shortname = '$branch'
              WHERE asset.copy.location IN $location
              AND asset.copy.deleted = false
              AND asset.copy.circ_modifier IS NOT NULL
              ORDER BY asset.copy.circ_modifier";
   }
   else
   {

       $sql = "SELECT DISTINCT asset.copy.circ_modifier
               FROM asset.copy
               JOIN actor.org_unit ON actor.org_unit.id=asset.copy.circ_lib  AND actor.org_unit.id IN
                     (SELECT child.id
                      FROM actor.org_unit child
                      JOIN actor.org_unit parent on child.parent_ou = parent.id
                      WHERE parent.shortname='$library'
                      ORDER BY child.id)
               WHERE asset.copy.location IN $location
               AND asset.copy.deleted = false
               AND asset.copy.circ_modifier IS NOT NULL
               ORDER BY asset.copy.circ_modifier";
   }

   $result = pg_query($db, $sql);

   $circ_mods = "";

   $count = 0;
   while($row = pg_fetch_row($result))
   {
      $name = $row[0];

      //create a new checkbox
      $circ_mods .="<input type=\\\"checkbox\\\" id=\\\"".$name."\\\" name=\\\"circ_mod_checkboxes[]\\\" value=\\\"".$name."\\\" class=\\\"multi_check\\\" />";
      $circ_mods .="<label for=\\\"".$name."\\\" class=\\\"multi_cb_label\\\">".$name."</label><br/>";
      $count++;
   }

   if ($count == 0)
   {
      echo "circ_mod.innerHTML = \"NONE\";\n";
   }
   else
   {
       echo "circ_mod.innerHTML = \"".$circ_mods."\";\n";
   }

   if ($get_all)
   {
       $sql = "SELECT asset.call_number_prefix.id, asset.call_number_prefix.label, asset.call_number_prefix.label_sortkey
              FROM asset.call_number_prefix
              JOIN actor.org_unit ON actor.org_unit.id=asset.call_number_prefix.owning_lib";
              if ( $use_branch)
              {
                 $sql .=" WHERE actor.org_unit.shortname = '$library' OR actor.org_unit.shortname = '$branch' ";
              }
              else
              {
                  $sql .=" WHERE actor.org_unit.id IN (SELECT child.id
                                    FROM actor.org_unit child
                                    JOIN actor.org_unit parent on child.parent_ou = parent.id
                                    WHERE parent.shortname='$library'
                                    ORDER BY child.id)
                           OR actor.org_unit.shortname = '$library'";
              }
              $sql .= "ORDER BY asset.call_number_prefix.label_sortkey";
   }
   else if ( $use_branch )
   {
      $sql = "SELECT DISTINCT asset.call_number_prefix.id, asset.call_number_prefix.label, asset.call_number_prefix.label_sortkey
              FROM asset.copy
              JOIN actor.org_unit ON actor.org_unit.id=asset.copy.circ_lib AND actor.org_unit.shortname = '$branch'
              JOIN asset.call_number ON asset.copy.call_number = asset.call_number.id AND asset.call_number.deleted = false
              JOIN asset.call_number_prefix ON asset.call_number.prefix = asset.call_number_prefix.id
              WHERE asset.copy.location IN $location
              AND asset.copy.deleted = false
              AND asset.call_number_prefix.id != -1
              ORDER BY asset.call_number_prefix.label_sortkey";
   }
   else
   {

       $sql = "SELECT DISTINCT asset.call_number_prefix.id, asset.call_number_prefix.label, asset.call_number_prefix.label_sortkey
              FROM asset.copy
              JOIN actor.org_unit ON actor.org_unit.id=asset.copy.circ_lib AND actor.org_unit.id IN
                     (SELECT child.id
                      FROM actor.org_unit child
                      JOIN actor.org_unit parent on child.parent_ou = parent.id
                      WHERE parent.shortname='$library'
                      ORDER BY child.id)
              JOIN asset.call_number ON asset.copy.call_number = asset.call_number.id AND asset.call_number.deleted = false
              JOIN asset.call_number_prefix ON asset.call_number.prefix = asset.call_number_prefix.id
              WHERE asset.copy.location IN $location
              AND asset.copy.deleted = false
              AND asset.call_number_prefix.id != -1
              ORDER BY asset.call_number_prefix.label_sortkey";

   }

   $result = pg_query($db, $sql);
   $prefixes = "";

   $count = 0;
   while($row = pg_fetch_row($result))
   {
      $id = $row[0];
      $name = $row[1];

      //create a new checkbox
      $prefixes .="<input type=\\\"checkbox\\\" id=\\\"".$id."\\\" name=\\\"prefix_checkboxes[]\\\" value=\\\"".$id."\\\" class=\\\"multi_check\\\" />";
      $prefixes .="<label for=\\\"".$name."\\\" class=\\\"multi_cb_label\\\">".$name."</label><br/>";
      $count++;
   }

   if ($count == 0)
   {
      echo "prefix.innerHTML = \"NONE\";\n";
   }
   else
   {
       echo "prefix.innerHTML = \"".$prefixes."\";\n";
   }

   if ($get_all)
   {
      $sql = "SELECT asset.call_number_suffix.id, asset.call_number_suffix.label, asset.call_number_suffix.label_sortkey
              FROM asset.call_number_suffix
              JOIN actor.org_unit ON actor.org_unit.id=asset.call_number_suffix.owning_lib ";
              if ( $use_branch)
              {
                 $sql .=" WHERE actor.org_unit.shortname = '$library' OR actor.org_unit.shortname = '$branch' ";
              }
              else
              {
                  $sql .=" WHERE actor.org_unit.id IN (SELECT child.id
                                    FROM actor.org_unit child
                                    JOIN actor.org_unit parent on child.parent_ou = parent.id
                                    WHERE parent.shortname='$library'
                                    ORDER BY child.id)
                           OR actor.org_unit.shortname = '$library'";
              }
              $sql .= "ORDER BY asset.call_number_suffix.label_sortkey";
   }
   else if ( $use_branch )
   {
      $sql = "SELECT DISTINCT asset.call_number_suffix.id, asset.call_number_suffix.label, asset.call_number_suffix.label_sortkey
              FROM asset.copy
              JOIN actor.org_unit ON actor.org_unit.id=asset.copy.circ_lib AND actor.org_unit.shortname = '$branch'
              JOIN asset.call_number ON asset.copy.call_number = asset.call_number.id AND asset.call_number.deleted = false
              JOIN asset.call_number_suffix ON asset.call_number.suffix = asset.call_number_suffix.id
              WHERE asset.copy.location IN $location
              AND asset.copy.deleted = false
              AND asset.call_number_suffix.id != -1
              ORDER BY asset.call_number_suffix.label_sortkey";
   }
   else
   {

       $sql = "SELECT DISTINCT asset.call_number_suffix.id, asset.call_number_suffix.label, asset.call_number_suffix.label_sortkey
              FROM asset.copy
              JOIN actor.org_unit ON actor.org_unit.id=asset.copy.circ_lib AND actor.org_unit.id IN
                     (SELECT child.id
                      FROM actor.org_unit child
                      JOIN actor.org_unit parent on child.parent_ou = parent.id
                      WHERE parent.shortname='$library'
                      ORDER BY child.id)
              JOIN asset.call_number ON asset.copy.call_number = asset.call_number.id AND asset.call_number.deleted = false
              JOIN asset.call_number_suffix ON asset.call_number.suffix = asset.call_number_suffix.id
              WHERE asset.copy.location IN $location
              AND asset.copy.deleted = false
              AND asset.call_number_suffix.id != -1
              ORDER BY asset.call_number_suffix.label_sortkey";

   }

   $result = pg_query($db, $sql);
   $suffixes = "";

   $count = 0;
   while($row = pg_fetch_row($result))
   {
      $id = $row[0];
      $name = $row[1];

      //create a new checkbox
      $suffixes .="<input type=\\\"checkbox\\\" id=\\\"".$id."\\\" name=\\\"suffix_checkboxes[]\\\" value=\\\"".$id."\\\" class=\\\"multi_check\\\" />";
      $suffixes .="<label for=\\\"".$name."\\\" class=\\\"multi_cb_label\\\">".$name."</label><br/>";
      $count++;
   }

   if ($count == 0)
   {
      echo "suffix.innerHTML = \"NONE\";\n";
   }
   else
   {
       echo "suffix.innerHTML = \"".$suffixes."\";\n";
   }

   if ($get_all)
   {
      $sql = "SELECT DISTINCT id, name
              FROM config.copy_status
              ORDER BY name";
   }
   else if ( $use_branch )
   {

      $sql = "SELECT DISTINCT config.copy_status.id, config.copy_status.name
              FROM asset.copy
              JOIN actor.org_unit ON actor.org_unit.id=asset.copy.circ_lib AND actor.org_unit.shortname = '$branch'
              JOIN config.copy_status ON asset.copy.status = config.copy_status.id
              WHERE asset.copy.location IN $location
              AND asset.copy.deleted = false
              ORDER BY config.copy_status.name";
   }
   else
   {

       $sql = "SELECT DISTINCT config.copy_status.id, config.copy_status.name
               FROM asset.copy
               JOIN actor.org_unit ON actor.org_unit.id=asset.copy.circ_lib  AND actor.org_unit.id IN
                     (SELECT child.id
                      FROM actor.org_unit child
                      JOIN actor.org_unit parent on child.parent_ou = parent.id
                      WHERE parent.shortname='$library'
                      ORDER BY child.id)
               JOIN config.copy_status ON asset.copy.status = config.copy_status.id
               WHERE asset.copy.location IN $location
               AND asset.copy.deleted = false
               ORDER BY config.copy_status.name";
   }

   $result = pg_query($db, $sql);

   $statuses = "";

   $count = 0;
   while($row = pg_fetch_row($result))
   {
      $id = $row[0];
      $name = $row[1];

      //create a new checkbox
      $statuses .="<input type=\\\"checkbox\\\" id=\\\"".$id."\\\" name=\\\"status_checkboxes[]\\\" value=\\\"".$id."\\\" class=\\\"multi_check\\\" />";
      $statuses .="<label for=\\\"".$name."\\\" class=\\\"multi_cb_label\\\">".$name."</label><br/>";
      $count++;
   }

   if ($count == 0)
   {
      echo "status.innerHTML = \"NONE\";\n";
   }
   else
   {
       echo "status.innerHTML = \"".$statuses."\";\n";
   }

}

?>