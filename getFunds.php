<?php

if(isset($_GET["year"]) )
{
   include "/usr/local/noble/db_config/db_info.php";

   $db = pg_connect("host=$eg_host port=$eg_port dbname=$eg_database user=$eg_user password=$eg_password");
   if (!$db)
   {
      die("Error in connection: " . pg_last_error());
   }

   $check_funds = false;
   $year = $_GET["year"];
   $lib =  $_GET["lib"];

   if (isset($_GET["funds"]))
   {
      $check_funds = true;
      $fund_list = explode("*", $_GET["funds"]);
   }

   //Get list of lib ids
   $lib_sql = "SELECT child.id
               FROM actor.org_unit child
               JOIN actor.org_unit parent on child.parent_ou = parent.id
               WHERE parent.id=$lib OR child.id=$lib
               UNION
               SELECT parent_ou
               FROM actor.org_unit
               WHERE id = $lib
               AND parent_ou !=1";

   $lib_result = pg_query($db, $lib_sql);
   $lib_list ="(";

   while($lib_row = pg_fetch_row($lib_result))
   {
       $lib_list .="'".$lib_row[0]."',";
   }
   $lib_list = rtrim($lib_list, ',');
   $lib_list.=")";


   $sql = "SELECT DISTINCT acq.fund.id, acq.fund.name
           FROM acq.fund
           WHERE acq.fund.year = $year
           AND acq.fund.org IN $lib_list
           ORDER BY acq.fund.name";

   $result = pg_query($db, $sql);

   while($row = pg_fetch_row($result))
   {
      if( strlen($row[1]) > 0)
      {
         $cb_val = str_replace("'","*",$row[1])."***".$row[0];
         echo "var checkbox = \"<input type='checkbox' name='fund_checkboxes' value='".$cb_val."' id='".$cb_val."_cb' ";
         if ($check_funds && in_array($row[0], $fund_list)) echo "checked=checked ";
         echo "onClick='AddFund(this)'/>\";";
         echo "checkbox_div.innerHTML+=checkbox +\"".$row[1]."\"+ \"<br/>\";";
      }
   }
}

?>