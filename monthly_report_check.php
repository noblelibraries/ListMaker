<?php

  require_once('/var/www/shared/PHPMailer/class.phpmailer.php');
  include "list_functions.php";
  include "/usr/local/noble/db_config/db_info.php";

  //get all the active reports
  //Run Filters->SQL to get records
  $eg_db = pg_connect("host=$eg_host port=$eg_port dbname=$eg_database user=$eg_user password=$eg_password");
  if (!$eg_db)
  {
     die("Error in connection to circulation DB: " . pg_last_error());
  }


  //make an list of emails, with all the associated ids
  $emails = array();

  $sql = "SELECT id, email, name
          FROM noble.scheduled_list
          WHERE active = true
          GROUP by email, id
          ORDER BY email";


  $result = pg_query($eg_db,$sql);

  while($row = pg_fetch_row($result))
  {
      $id = $row[0];
      $addresses = explode(",",$row[1]);
      $name = $row[2];

      foreach($addresses as $email_address)
      {
		  if (array_key_exists($email_address, $emails))
		  {
			 $emails[$email_address][] = array("id" => $id, "name" => $name);
		  }
		  else
		  {
			 $emails[$email_address] = array();
			 $emails[$email_address][] = array("id" => $id, "name" => $name);
		  }
      }
  }

  ksort($emails);

  //go through the array and write out links to each report

  $message2 = new PHPMailer();
  $message2->From      = 'evergreen@noblenet.org';
  $message2->FromName  = 'Report Generator';
  $message2->Subject   = "Users with Scheduled Reports";
  $message2->AddReplyTo('evergreen@noblenet.org', 'Report Generator');

  $message2->AddAddress("et@noblenet.org");
  //$message2->AddAddress("driscoll@noblenet.org");

  $body2 = "The following users have scheduled reports. \n\n";

  foreach($emails as $curr_email => $list_info)
  {
      //Send email
       $message = new PHPMailer();
       $message->From      = 'evergreen@noblenet.org';
       $message->FromName  = 'Report Generator';
       $message->Subject   = "Scheduled List Maker Report Check";
       $message->AddReplyTo('evergreen@noblenet.org', 'Report Generator');

       $message->AddAddress( $curr_email);
       //$message->AddAddress("driscoll@noblenet.org");


       $message_body = "You have the following Scheduled List Maker reports. The links will take you directly to the information for each report with an option to Edit or Turn Off the report.\n\n";

       //echo "Looking at reports for ".$curr_email."\n";

       $count = 0;

       foreach($list_info as $curr_list)
       {
          $message_body .= $curr_list["name"]." = https://tools.noblenet.org/list_maker/edit_scheduled_out.php?id=".$curr_list["id"]." \n";
          $count++;
       }

       $body2 .= $curr_email." (".$count.")-   https://tools.noblenet.org/list_maker/edit_scheduled_out.php?email=".$curr_email."\n";


       $message_body .= "\nSee all your scheduled lists at once https://tools.noblenet.org/list_maker/edit_scheduled_out.php?email=".$curr_email."\n";

       $message->Body      = $message_body;

       $message->Send();
  }


  $message2->Body      = $body2;

  $message2->Send();
?>
