<?php

  require_once('/var/www/shared/PHPMailer/class.phpmailer.php');
  include "/usr/local/noble/db_config/db_info.php";
  include "list_functions.php";
  include "CopyRec.php";
  include "CopyList.php";
  include "BibRec.php";
  include "BibList.php";
  include "Filters.php";
  include "Output_Options.php";

  $filters = new Filters();
  $output = new Output_Options();

  $working = false;
  $testing = false;

  //Run Filters->SQL to get records
  $eg_db = pg_connect("host=$eg_host port=$eg_port dbname=$eg_database user=$eg_user password=$eg_password");
  if (!$eg_db)
  {
     die("Error in connection to circulation DB: " . pg_last_error());
  }

  $now = date('m_d_Y');
  $log_file_name = "/var/www/tools/reports/scheduled_list_log_".$now.".txt";
  $log_text = date('m-d-Y G:i:s')."\n\n";

  $day_of_week = date("l");
  $day = date("d");
  $month = date("F");
  $today = date('Y-m-d');

  /************************* Daily ***********************************/
  $daily_sql = "SELECT email, filters, output, name, id
                 FROM noble.scheduled_list
                 WHERE active = true
                 AND schedule_type ='daily'";

  $result = pg_query($eg_db,$daily_sql);

  while($row = pg_fetch_row($result))
  {
      $email = str_replace(",", " email ",$row[0]);
      $filter_args = $row[1];
      $output_args = $row[2];
      $name = "\"".$row[3]."\"";
      $db_id = $row[4];

      if ($working)$email = "xxx@noblenet.org";

      $args = $filter_args."email ".$email." scheduled db_id ".$db_id." report_name ".$name." ".$output_args;

	   if ($working)
	   {
	      $log_text .= "------TEST----- /usr/bin/php -f /var/www/tools/list_maker_working/create_list.php ".$args."\n\n";
	      $cmd = "/usr/bin/php -f /var/www/tools/list_maker_working/create_list.php ".$args;
	   }
	   else if ($testing)
	   {
	      $log_text .= "------TEST----- /usr/bin/php -f /var/www/tools/list_maker_test/create_list.php ".$args."\n\n";
	      $cmd = "/usr/bin/php -f /var/www/tools/list_maker_test/create_list.php ".$args;
	   }
	   else
	   {
	      $log_text .= "------ /usr/bin/php -f /var/www/tools/list_maker/create_list.php ".$args."\n\n";
	      $cmd = "/usr/bin/php -f /var/www/tools/list_maker/create_list.php  ".$args;
	   }

	   exec($cmd . " > /dev/null &");

       if (!$working && !$testing)
	   {


		   //add today to the last run field in database
		   $schedule_sql="UPDATE noble.scheduled_list
			  				SET last_run = '$today'
							WHERE id = $db_id";

		   $update_date_result = pg_query($eg_db,$schedule_sql);
		}


		echo "RUNNING -- ".$cmd."\n\n";
		sleep(10);
  }

  /************************* WEEKLY ***********************************/
  $weekly_sql = "SELECT email, filters, output, name, id
                 FROM noble.scheduled_list
                 WHERE active = true
                 AND schedule_type ='weekly'
                 AND weekly ILIKE '%$day_of_week%'";

  $result = pg_query($eg_db,$weekly_sql);

  while($row = pg_fetch_row($result))
  {
      $email = str_replace(",", " email ",$row[0]);
      $filter_args = $row[1];
      $output_args = $row[2];
      $name = "\"".$row[3]."\"";
      $db_id = $row[4];

       if ($working)$email = "xxx@noblenet.org";

       $args = $filter_args."email ".$email." scheduled db_id ".$db_id." report_name ".$name." ".$output_args;

	   if ($working)
	   {
	      $log_text .= "------TEST----- /usr/bin/php -f /var/www/tools/list_maker_working/create_list.php ".$args."\n\n";
	      $cmd = "/usr/bin/php -f /var/www/tools/list_maker_working/create_list.php ".$args;
	   }
	   else if ($testing)
	   {
	      $log_text .= "------TEST----- /usr/bin/php -f /var/www/tools/list_maker_test/create_list.php ".$args."\n\n";
	      $cmd = "/usr/bin/php -f /var/www/tools/list_maker_test/create_list.php ".$args;
	   }
	   else
	   {
	      $log_text .= "------ /usr/bin/php -f /var/www/tools/list_maker/create_list.php ".$args."\n\n";
	      $cmd = "/usr/bin/php -f /var/www/tools/list_maker/create_list.php  ".$args;
	   }

	   if (!$working && !$testing)
	   {
	       exec($cmd . " > /dev/null &");

		   //add today to the last run field in database
		   $schedule_sql="UPDATE noble.scheduled_list
			  				SET last_run = '$today'
							WHERE id = $db_id";

		   $update_date_result = pg_query($eg_db,$schedule_sql);
		}

		echo "RUNNING -- ".$cmd."\n\n";
		sleep(10);
  }

  /************************* MONTHLY Specific Days ***********************************/
  $monthly_sql = "SELECT email, filters, output, name, id
                  FROM noble.scheduled_list
                  WHERE active = true
                   AND schedule_type ='monthly'
                  AND specific_days ILIKE '%$day%'";

  $result = pg_query($eg_db,$monthly_sql);

  while($row = pg_fetch_row($result))
  {

      $email = str_replace(",", " email ",$row[0]);
      $filter_args = $row[1];
      $output_args = $row[2];
      $name = "\"".$row[3]."\"";
      $db_id = $row[4];

      if ($working)$email = "xxx@noblenet.org";

       $args = $filter_args."email ".$email." scheduled db_id ".$db_id." report_name ".$name." ".$output_args;

	   if ($working)
	   {
	      $log_text .= "------TEST----- /usr/bin/php -f /var/www/tools/list_maker_working/create_list.php ".$args."\n\n";
	      $cmd = "/usr/bin/php -f /var/www/tools/list_maker_working/create_list.php ".$args;
	   }
	    else if ($testing)
	   {
	      $log_text .= "------TEST----- /usr/bin/php -f /var/www/tools/list_maker_test/create_list.php ".$args."\n\n";
	      $cmd = "/usr/bin/php -f /var/www/tools/list_maker_test/create_list.php ".$args;
	   }
	   else
	   {
	      $log_text .= "------ /usr/bin/php -f /var/www/tools/list_maker/create_list.php ".$args."\n\n";
	      $cmd = "/usr/bin/php -f /var/www/tools/list_maker/create_list.php  ".$args;
	   }

       if (!$working && !$testing)
	   {
	       exec($cmd . " > /dev/null &");

		   //add today to the last run field in database
		   $schedule_sql="UPDATE noble.scheduled_list
			  				SET last_run = '$today'
							WHERE id = $db_id";

		   $update_date_result = pg_query($eg_db,$schedule_sql);
		}
		echo "RUNNING -- ".$cmd."\n\n";
		sleep(10);
  }

  /************************* MONTHLY Relative Days  ***********************************/
  $relative_days_sql = "SELECT email, filters, output, relative_days_of_month, name, id
                        FROM noble.scheduled_list
                        WHERE active = true
                        AND schedule_type ='monthly'
                        AND relative_days_of_month IS NOT NULL ";

  $result = pg_query($eg_db,$relative_days_sql);

  while($row = pg_fetch_row($result))
  {
      $email = str_replace(",", " email ",$row[0]);
      $filter_args = $row[1];
      $output_args = $row[2];
      $relative_days_of_month = $row[3];
      $name = "\"".$row[4]."\"";
      $db_id = $row[5];

      if ($working)$email = "xxx@noblenet.org";

      //figure out if this is one of the days to  run
      $rel_date = date('Y-m-d', strtotime($relative_days_of_month." of ".$month));

      if ($rel_date == $today)
      {
          $args = $filter_args."email ".$email." scheduled db_id ".$db_id." report_name ".$name." ".$output_args;

	      if ($working)
	      {
	         $log_text .= "------TEST----- /usr/bin/php -f /var/www/tools/list_maker_working/create_list.php ".$args."\n\n";
	         $cmd = "/usr/bin/php -f /var/www/tools/list_maker_working/create_list.php ".$args;
	      }
	      else if ($testing)
	      {
	         $log_text .= "------TEST----- /usr/bin/php -f /var/www/tools/list_maker_test/create_list.php ".$args."\n\n";
	         $cmd = "/usr/bin/php -f /var/www/tools/list_maker_test/create_list.php ".$args;
	      }
	      else
	      {
	         $log_text .= "------ /usr/bin/php -f /var/www/tools/list_maker/create_list.php ".$args."\n\n";
	         $cmd = "/usr/bin/php -f /var/www/tools/list_maker/create_list.php  ".$args;
	      }

		   if (!$working && !$testing)
		   {
			   exec($cmd . " > /dev/null &");

			   //add today to the last run field in database
			   $schedule_sql="UPDATE noble.scheduled_list
								SET last_run = '$today'
								WHERE id = $db_id";

			   $result = pg_query($eg_db,$schedule_sql);
			}
		   echo "RUNNING -- ".$cmd."\n\n";
	   	   sleep(10);
		}
  }

  /************************* RELATIVE Relative Days  ***********************************/
  $relative_days_sql = "SELECT email, filters, output, interval, start_date, last_run, id, name
                        FROM noble.scheduled_list
                        WHERE active = true
                        AND schedule_type ='relative'";

  $result = pg_query($eg_db,$relative_days_sql);

  while($row = pg_fetch_row($result))
  {
      $email = str_replace(",", " email ",$row[0]);
      $filter_args = $row[1];
      $output_args = $row[2];
      $interval = $row[3];
      $start_date = $row[4];
      $last_run = $row[5];
      $db_id = $row[6];
      $name = "\"".$row[7]."\"";

      if ($working)$email = "xxx@noblenet.org";

      //figure out if this is one of the days to run
      if ($last_run) $rel_date = date('Y-m-d', strtotime($last_run."+".$interval));
      else $rel_date = date('Y-m-d', strtotime($start_date."+".$interval));

      $today = date('Y-m-d');

      if ($rel_date == $today)
      {
          $args = $filter_args."email ".$email." scheduled db_id ".$db_id." report_name ".$name." ".$output_args;

	      if ($working)
	      {
	         $log_text .= "------TEST----- /usr/bin/php -f /var/www/tools/list_maker_working/create_list.php ".$args."\n\n";
	         $cmd = "/usr/bin/php -f /var/www/tools/list_maker_working/create_list.php ".$args;
	      }
	      else if ($testing)
	      {
	         $log_text .= "------TEST----- /usr/bin/php -f /var/www/tools/list_maker_test/create_list.php ".$args."\n\n";
	         $cmd = "/usr/bin/php -f /var/www/tools/list_maker_test/create_list.php ".$args;
	      }
	      else
	      {
	         $log_text .= "------ /usr/bin/php -f /var/www/tools/list_maker/create_list.php ".$args."\n\n";
	         $cmd = "/usr/bin/php -f /var/www/tools/list_maker/create_list.php  ".$args;
	      }

		  if (!$working && !$testing)
		  {
			   exec($cmd . " > /dev/null &");

			   //add today to the last run field in database
			   $schedule_sql="UPDATE noble.scheduled_list
								SET last_run = '$today'
								WHERE id = $db_id";

			   $update_date_result = pg_query($eg_db,$schedule_sql);
		   }


		   echo "RUNNING -- ".$cmd."\n\n";
	       sleep(10);
		}

  }

  /************************* RELATIVE  ***********************************/


  file_put_contents($log_file_name, $log_text);
  chgrp($log_file_name, "www-data");

  ?>
