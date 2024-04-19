<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />

<title> Edit Scheduled Lists  - Version 1.1  </title>

<link rel="stylesheet" type="text/css" href="../css/noble.css" />
<link rel="stylesheet" href="https://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
<script src="https://code.jquery.com/jquery-1.9.1.js"></script>
<script src="https://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<script type="text/javascript" src="../../shared/ajax/ajax.js"></script>

<script src="../../shared/sweetalert2/dist/sweetalert2.min.js"></script>
<script type="text/javascript" src="edit_scheduled.js"></script>

<link rel="stylesheet" type="text/css" href="../../shared/sweetalert2/dist/sweetalert2.css">

<link rel="icon"  type="image/png" href="../favicon.ico">

</head>

<body >
<div id="wrapper">

  <div id="header">

    <div id="top_nav">
       <ul>
          <li></li>
       </ul>
    </div><!-- end top nav -->

    <div id="header_image">
       <img src="../../shared/images/nblue.png" class="nat_sign" />
    </div> <!-- end header image -->

    <div id ="header_text">
       <h1> Edit Scheduled Lists  - Version 1.1 </h1>
    </div><!-- end header text-->

    <div id ="page_nav">
      <ul>
        <li><a href="https://tools.noblenet.org/list_maker/list_form.php" target="_blank">List Maker</a></li>
      </ul>
    </div><!-- end page nav -->

  </div> <!-- end header -->

  <div id ="content">

  <a href="edit_scheduled.php" class="top_link">Search for Lists</a>

<?php

  include "/usr/local/noble/db_config/db_info.php";
  include "Filters.php";
  include "Output_Options.php";
  include "list_functions.php";

  $db = pg_connect("host=$eg_host port=$eg_port dbname=$eg_database user=$eg_user password=$eg_password");
  if (!$db)
  {
     die("Error in connection: " . pg_last_error());
  }

  $use_library = false;
  $library = "";
  $use_email = false;
  $email = "";
  $use_id = false;
  $list_id = -1;
  $include_inactive = false;
  $working = false;

  if (isset($_POST['library']) && $_POST['library'] !== "NONE")
  {
     $use_library = true;
     $library = $_POST['library'];

     //look at branch
     if(isset($_POST['branch']) && $_POST['branch'] != "ALL")
     {
        $library = $_POST['branch'];
     }

  }

  if (isset($_POST['email']) && strlen($_POST['email']) > 1)
  {
     $use_email = true;
     $email = $_POST['email'];
  }
  else if (isset($_GET['email']) && strlen($_GET['email']) > 1)
  {
     $use_email = true;
     $email = $_GET['email'];
  }


  if (isset($_POST['inactive']))
  {
     $include_inactive = true;
  }

  if (isset($_GET['id']))
  {
     $list_id = $_GET['id'];
     $use_id = true;
  }

  $sql = "SELECT *
          FROM noble.scheduled_list
          WHERE ";

   if ($use_id)
   {
      $sql .= "id = $list_id ";
   }
   else
   {
	   if ($use_library)
	   {
		  $sql .= "library IN (SELECT child.shortname
							   FROM actor.org_unit parent
							   INNER JOIN actor.org_unit child ON child.parent_ou = parent.id
							   WHERE parent.shortname = '$library' OR child.shortname = '$library' )";
	   }

	   if ($use_library && $use_email) $sql .= " AND ";

	   if ($use_email) $sql .= "email LIKE '%$email%' ";

	   if (!$include_inactive) $sql .=" AND active = true ";
   }

   $sql .= " ORDER BY create_date";

   $result = pg_query($db, $sql);

   $count = pg_num_rows($result);


   if ($use_id)
   {
      echo "<h2>Here are the details of your scheduled list. </h2> ";
   }
   else
   {
	   echo "<h2>".$count." scheduled lists have been found for ";
	   if ($use_library) echo $library;
	   if ($use_library && $use_email) echo " and ";
	   if ($use_email) echo $email;
	   if ($include_inactive) echo " including inactive";
	   echo  ".</h2>";
   }

   echo "<div class=\"\">";
   while ($row = pg_fetch_row($result))
   {

      $filters = new Filters();
      $filters->SetDB($db);
      $filters->SetRelativeDates();

	  $output = new Output_Options();

      $db_id = $row[0];
      $lib = $row[1];
      $email = $row[2];

      $filter_string = $row[3];
      $filters->CreateFiltersFromString($filter_string);
      $output_string = $row[4];
      $output->CreateOutputOptionsFromString($output_string);

      $name = $row[5];
      $active = $row[6];
      $sched_type = $row[7];
      $create_date = $row[8];
      $weekly = $row[9];
      $specific_days = $row[10];
      $rel_days = $row[11];
      $interval = $row[12];
      $start_date = $row[13];
      $last_run = $row[14];

      echo "<div class=\"scheduled_list\">\n";

      echo "<div id=\"activate_status_".$db_id."\" class=\"active_box\">";
      if ($active=="t")
      {
         echo "<h3 style=\"color:green;\">Active";
         echo "<input type=\"button\" name=\"active\" id=\"active\" class=\"stats on_button\" value=\"Turn Off\" onclick=\"ActivateReport(".$db_id.",false);\">";
         echo "</h3>";

      }
      else
      {
         echo "<h3 style=\"color:red;\">Inactive";
         echo "<input type=\"button\" name=\"active\" id=\"active\" class=\"stats on_button\" value=\"Turn On\" onclick=\"ActivateReport(".$db_id.",true);\">";
         echo "</h3>";
      }

      ?>

      </div>

      <div class="list_info">

        <table id="list_info_table" valign="top">
        <tbody>
          <?php
            if (!$use_library)
            {
                echo "<tr>";
                echo "<td class=\"bold\">Library:</td>";
                echo "<td>".$lib."</td>";
                echo "</tr>";
            }
          ?>
          <tr>
             <td class="bold"> Name:</td>
             <td> <?php echo $name; ?></td>
          </tr>

          <tr>
             <td class="bold">Email:</td>
             <td> <?php echo str_replace(",", "<br />", $email);
                if ($output->GetNoEmail())
                {
                   echo "<br/> <i>  -- No Daily Emails <i/>";
                }
             ?></td>
          </tr>

          <tr>
             <td class="bold">Created:</td>
             <td> <?php echo date("m/d/Y", strtotime($create_date)); ?></td>
          </tr>

          <tr>
             <td class="bold">Schedule:</td>
             <td>
             <?php
                if ($sched_type == "daily")
                {
                   echo "Daily";
                }
                else if ($sched_type == "weekly")
                {
                   $weekly = str_replace(",", " ", rtrim($weekly, ","));
                   echo "Weekly On ".ucwords($weekly);
                }
                else if ($sched_type == "monthly")
                {
                   if($specific_days)
                   {
                      echo "Monthly On ".ucwords(rtrim($specific_days, ","));
                      if ($rel_days) echo " And ".ucwords(rtrim($rel_days,","));
                   }
                   else
                   {
                      if ($rel_days) echo "Monthly On ".ucwords($rel_days);
                   }
                }
                else if ($sched_type == "relative")
                {
                   echo "Runs every ".$interval."<br />";
                   echo "Starting ".date("m/d/Y", strtotime($start_date))."<br />";
                   if ($last_run)echo "Last Run ".date("m/d/Y", strtotime($last_run))."<br />";
                   else echo "Not yet run <br />";
                }
             ?>
             </td>
          </tr>

        </tbody>
        </table>
      </div>

      <?php
      echo "<div class=\"list_filters\">\n";
      echo $filters->GetHTMLText()."<br />";
      echo "</div>\n";

      echo "<div class=\"list_output\">\n";
      echo $output->GetHTMLText()."<br />";
      echo "</div>\n";

      $get_params = "db_id=".$db_id;
      $get_params .= "&filters=".str_replace(" ", "*", $filter_string);

      if($output->WriteBucket() || $output->WriteRSS())
      {
         //strip off rss to end of args
         if ($output->WriteRSS())
         {
            //strip off rss to end of string
            $pos = strpos($output_string, 'rss');
            $output_string = substr($output_string, 0, $pos);
            //echo $output_string."<br/>";

            $output_string .="*".$output->GetReportLinkParams();

         }
         else if ($output->WriteBucket())
         {
            //strip off from bookbag to end of string -- will already be gone if there's rss
            $pos = strpos($output_string, 'bookbag');
            if (!$pos) $pos = strpos($output_string, 'bucket');
            $output_string = substr($output_string, 0, $pos);
            //echo $output_string."<br/>";

            $output_string .= $output->GetReportLinkParams();

         }
         else if ($output->WriteCopyBucket())
         {
            //strip off from bookbag to end of string -- will already be gone if there's rss
            $pos = strpos($output_string, 'copy_bucket');
            $output_string = substr($output_string, 0, $pos);
            //echo $output_string."<br/>";

            $output_string .= $output->GetReportLinkParams();
         }
      }
      $get_params .= "&output=".str_replace(" ", "*", $output_string);


      $get_params .= "&name=".urlencode($name);
      $get_params .= "&email=".urlencode($email);
      $get_params .= "&schedule=".$sched_type;
      if ($sched_type == "weekly")
		{
			$get_params .= "&days=".rtrim($weekly, ",");
		}
		else if ($sched_type == "monthly")
		{
		   if($specific_days)
		   {
		      $get_params .= "&spec_days=".rtrim($specific_days, ",");
		   }
         if ($rel_days)
         {
            $get_params .= "&rel_days=".str_replace(" ","_",$rel_days);
         }
		}
		else if ($sched_type == "relative")
		{
		   $get_params .= "&interval=".str_replace(" ","_",$interval);
		   $get_params .= "&start_date=".$start_date;
		}

	   if ($working) echo $get_params."<br/>";

      echo "<input type=\"button\" onclick=\"window.open('list_form.php?".$get_params."');\" value=\"Edit This Report\" class=\"stats edit_button\"/>";

      echo "</div>\n";

   }

   echo "</div>";


?>

  <a href="edit_scheduled.php" class="top_link">Search for Lists</a> <br /> <br />


  </div><!-- end contents -->

     <div id="footer">

      <div id="footer_links">
      <ul>
         <li><a href="https://evergreen.noblenet.org" target="blank"> Catalog </a></li>
      </ul>
      </div><!-- end links -->

   </div> <!-- end footer -->


</div><!-- end wrapper -->

</body>

</html>
