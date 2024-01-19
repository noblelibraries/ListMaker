<?php

if(isset($_GET["lib"]) && isset($_GET["fund"]))
{
   include "/usr/local/noble/db_config/db_info.php";

   $db = pg_connect("host=$eg_host port=$eg_port dbname=$eg_database user=$eg_user password=$eg_password");
   if (!$db)
   {
      die("Error in connection: " . pg_last_error());
   }

   $library = $_GET["lib"];
   $funds = explode("*",$_GET["fund"]);
   $branch = $_GET["branch"];

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

   echo "fund_year_obj.options[fund_year_obj.options.length] = new Option('Select','-1');\n";

   while($row = pg_fetch_row($result))
   {
      if( strlen($row[0]) > 0)
      {
         echo "fund_year_obj.options[fund_year_obj.options.length] = new Option(\"".$row[0]."\",\"".$row[0]."***".$branch_id."\");\n";
      }
   }

   //loop thorugh the selected stat cats
   foreach($funds as $curr)
   {
      //get the cat id
      //find the cat words
      $fund_sql = "SELECT acq.fund.id, acq.fund.year, acq.fund.name
                   FROM acq.fund
                   WHERE id = $curr ";

      $fund_result = pg_query($db, $fund_sql);
      $fund_row = pg_fetch_row($fund_result);

      $fund_val = $fund_row[0];
      $fund_words =$fund_row[1]."/".$fund_row[2];


      $node_name = str_replace("'","*",$fund_row[2])."***".$fund_val;
      //add new nodes to the bottom

      echo "var new_html ='';\n";

      //create a span ew_html += "<span id='"+checkbox_val+"' class='stat_row'>";
      echo "new_html  += \"<span id='".$node_name."' class='stat_row'>\";\n";

      //create words for the stat
      echo "new_html += \"<span id='".str_replace("'","*", $fund_words)."' name='fund_words'>".$fund_words."</span>\";\n";

      //create hidden input for the values with common name
      echo "new_html += \"<input type='hidden' name='fund_vals' value='".$fund_val."' />\";";

      //create a button to remove with checkbox_val ans val
      echo "new_html +=\"<input type=\\\"button\\\"  value=\\\"Remove\\\" class=\\\"remove_stat\\\" onClick=\\\"RemoveFund('".$node_name."')\\\"/>\";";

      //end span
      echo "new_html += \"</span>\";";

      echo "selected_fund_div.innerHTML += new_html;";

   }

}

?>