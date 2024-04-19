<?php

  require_once('/var/www/shared/PHPMailer/class.phpmailer.php');

  //get the vars
  $args ="";
  $message_body = "";

  //assemble the string then call the reporter
  $library  = $_POST['lib'];
  $message_body .="libray is ".$library."\n";
  $args .="lib ".$library." ";

  if(isset($_POST['loc']))
  {
     $copy_loc = $_POST['loc'];
     $message_body .="loc is ".$copy_loc."\n";
     $args .="copy_loc ".$copy_loc." ";
  }
  else if(isset($_POST['loc_grp']))
  {
     $loc_grp = $_POST['loc_grp'];
     $message_body .="loc grp is ".$loc_grp."\n";
     $args .="copy_loc_grp ".$loc_grp." ";
  }

  $type = $_POST['report_type'];

  $testing = false;
  $working = false;

  if ($type == "weeding")
  {
     $message_body .="report type is weeding\n";
     $args .="weeding ";

     if (isset($_POST['checkin_date']))
     {
        $check_in = $_POST['checkin_date'];
        $check_in = date('Y-m-d', strtotime("$check_in"));
        //reformat date to DB time
        $message_body .="shelf is ".$check_in."\n";
        $args .="shelf ".$check_in." ";
     }
     else if (isset($_POST['checkin_date_relative']))
     {
        $check_in = $_POST['checkin_date_relative'];
        //reformat date to DB time
        $message_body .="relative shelf is ".$check_in."\n";
        $args .="shelf_relative ".$check_in." ";
     }


  }
  else if ($type == "inventory")
  {
     $message_body .="report type is inventory\n";


     if (isset($_POST['status']))
     {
        $status = $_POST['status'];
        $message_body .="status is ".$status."\n";
        $args .="status ".$status." ";
     }


	  if(isset($_POST['stat_date_type']))
	  {
		  $time_type = $_POST['stat_time_type'];

		  if ($_POST['stat_date_type'] == "absolute")
		  {
			  $start = $_POST['stat_start'];
			  $stat_start = date('Y-m-d', strtotime("$start"));

			  if ($time_type == "between")
			  {
				  $end = $_POST['stat_end'];
				  $stat_end = date('Y-m-d', strtotime("$end"));

				  $message_body .="status change date is between ".$stat_start." to ".$stat_end."\n";
				  $args .="stat_change between ".$stat_start." ".$stat_end." ";
			  }
			  else
			  {
				 $message_body .="status change is ".$time_type." ".$stat_start."\n";
				 $args .="stat_change ".$time_type." ".$stat_start." ";
			  }
		  }
		  else if ($_POST['stat_date_type'] == "relative")
		  {
			  $stat_start = $_POST['stat_start'];

			  if ($time_type == "between")
			  {
				  $stat_end = $_POST['stat_end'];

				  $message_body .="relative status change date is between ".$stat_start." to ".$stat_end."\n";
				  $args .="stat_change_relative between ".$stat_start." ".$stat_end." ";
			  }
			  else
			  {
					$message_body .="relative status change is ".$time_type." ".$stat_start."\n";
					$args .="stat_change_relative ".$time_type." ".$stat_start." ";
			  }
		  }

     }


     $deleted  = $_POST['deleted'];
     $message_body .="Deleted is ".$deleted."\n";
     $args .="".$deleted." ";

     if(isset($_POST['deleted_date_type']))
	  {
		  $time_type = $_POST['deleted_time_type'];

		  if ($_POST['deleted_date_type'] == "absolute")
		  {
			  $start = $_POST['deleted_start'];
			  $del_start = date('Y-m-d', strtotime("$start"));

			  if ($time_type == "between")
			  {
				  $end = $_POST['deleted_end'];
				  $del_end = date('Y-m-d', strtotime("$end"));

				  $message_body .="delete date  is between ".$del_start." to ".$del_end."\n";
				  $args .="delete_date  between ".$del_start." ".$del_end." ";
			  }
			  else
			  {
				 $message_body .="deleted date is ".$time_type." ".$del_start."\n";
				 $args .="delete_date ".$time_type." ".$del_start." ";
			  }
		  }
		  else if ($_POST['deleted_date_type'] == "relative")
		  {
			  $del_start = $_POST['deleted_start'];

			  if ($time_type == "between")
			  {
				  $del_end = $_POST['deleted_end'];

				  $message_body .="relative deleted date is between ".$del_start." to ".$del_end."\n";
				  $args .="delete_date_relative between ".$del_start." ".$del_end." ";
			  }
			  else
			  {
					$message_body .="relative deleted date is ".$time_type." ".$del_start."\n";
					$args .="delete_date_relative ".$time_type." ".$del_start." ";
			  }
		  }

     }
  }

  if (isset($_POST['pub_before']))
  {
     $pub_date = $_POST['pub_before'];
     $message_body .="pubdate before is ".$pub_date."\n";
     $args .="pub_before ".$pub_date." ";
  }

  if (isset($_POST['pub_after']))
  {
     $pub_date = $_POST['pub_after'];
     $message_body .="pubdate after is ".$pub_date."\n";
     $args .="pub_after ".$pub_date." ";
  }

  if (isset($_POST['pub_between_start']) && isset($_POST['pub_between_end']))
  {
     $pub_date_start = $_POST['pub_between_start'];
     $pub_date_end= $_POST['pub_between_end'];
     $message_body .="pubdate between is ".$pub_date_start." and ".$pub_date_end."\n";
     $args .="pub_between ".$pub_date_start." ".$pub_date_end." ";
  }

  if (isset($_POST['include_null_pub_date']))
  {
     $message_body .="include null pub date\n";
     $args .="pub_null ";
  }

  if(isset($_POST['active_type']))
  {
     $time_type = $_POST['active_time_type'];

	  if ($_POST['active_type'] == "absolute")
	  {
		  $start = $_POST['active_start'];
		  $active_start = date('Y-m-d', strtotime("$start"));

        if ($time_type == "between")
        {
		     $end = $_POST['active_end'];
           $active_end = date('Y-m-d', strtotime("$end"));

		     $message_body .="added date is between ".$active_start." to ".$active_end."\n";
		     $args .="added between ".$active_start." ".$active_end." ";
		  }
		  else
		  {
		    $message_body .="added date is ".$time_type." ".$active_start."\n";
		    $args .="added ".$time_type." ".$active_start." ";
		  }
	  }
	  else if ($_POST['active_type'] == "relative")
	  {
		  $active_start = $_POST['active_start'];

		  if ($time_type == "between")
        {
   		  $active_end = $_POST['active_end'];

		     $message_body .="relative added date is between ".$active_start." to ".$active_end."\n";
		     $args .="added_relative between ".$active_start." ".$active_end." ";
		  }
		  else
		  {
		      $message_body .="added date is ".$time_type." ".$active_start."\n";
		      $args .="added_relative ".$time_type." ".$active_start." ";
		  }
	  }

	  $electronic  = $_POST['electronic'];
     $message_body .="Electronic is ".$electronic."\n";
     $args .="".$electronic." ";
  }

  if (isset($_POST['circ_mod']))
  {
     $circ_mod = $_POST['circ_mod'];
     $message_body .="circ_mod is ".$circ_mod."\n";
     $args .="circ_mod ".$circ_mod." ";
  }

  if (isset($_POST['prefix']))
  {
     $prefix = $_POST['prefix'];
     $message_body .="prefix is ".$prefix."\n";
     $args .="prefix ".$prefix." ";
  }

  if (isset($_POST['suffix']))
  {
     $suffix = $_POST['suffix'];
     $message_body .="suffix is ".$suffix."\n";
     $args .="suffix ".$suffix." ";
  }

  if (isset($_POST['coll_man']))
  {
     $call_class = $_POST['call_class'];
     $coll_man = $_POST['coll_man'];
     $message_body .="class is ".$call_class."\n";
     $message_body .="coll_man is ".$coll_man."\n";
     $args .="coll_topic ".$call_class." ".$coll_man." ";
  }
  else if (isset($_POST['start_call']) && isset($_POST['end_call']))
  {
     $call_class = $_POST['call_class'];
     $start_call = str_replace(" ", "",$_POST['start_call']);
     $end_call = str_replace(" ","",$_POST['end_call']);
     $message_body .="class is ".$call_class."\n";
     $message_body .="start call is ".$start_call."\n";
     $message_body .="end call is ".$end_call."\n";
     $args .="call_range ".$call_class." ".$start_call." ".$end_call." ";
  }
  else if (isset($_POST['contains_call']) )
  {
     $call_class = str_replace(" ", "",$_POST['call_class']);
     $contain_call = str_replace(" ", "_",$_POST['contains_call']);
     $message_body .="class is ".$call_class."\n";
     $message_body .="contain call is ".$contain_call."\n";
     $args .="call_contain ".$call_class." ".$contain_call." ";
  }
  else if (isset($_POST['bisac']) )
  {
     $call_class = str_replace(" ", "",$_POST['call_class']);
     $bisac = str_replace(" ", "",$_POST['bisac']);
     $message_body .="class is ".$call_class."\n";
     $message_body .="bisac is ".$bisac."\n";
     $args .="bisac ".$call_class." ".$bisac." ";
  }


  if (isset($_POST['filename']))
  {

     $filename = $_POST['filename'];
     $data_type = $_POST['data_type'];
     $file_type = $_POST['file_type'];

     //$message_body .=$data_type." is ".$filename."\n";

     $replace_chars = array("\\", "/", "%", ":", "'", "*", "?", ":", ";", "<", ">", "|", " ", "#", "$");
     $filename= str_replace($replace_chars, "_",$filename );

     if ($data_type == "bib") $command = "bib_file";
     else if ($data_type == "barcode") $command = "barcode_file";
     else if ($data_type == "isbn") $command = "isbn_file";

     $message_body .=$command." is ".$file_type." ".$filename."\n";
     $args .= $command." ".$file_type." ".$filename." ";

     //dont look at this is it was read with active date
     if ( isset($_POST['active_type']) == false &&( $data_type == "bib" || $data_type == "isbn"))
     {
        $electronic  = $_POST['electronic'];
        $message_body .="Electronic is ".$electronic."\n";
        $args .="".$electronic." ";
     }
  }

  if (isset($_POST['circ_count']))
  {
     $circ_count = $_POST['circ_count'];
     $compare = $_POST['circ_count_compare'];
     $compare_date = $_POST['circ_compare_date'];

     $message_body .="Circ Count ".$compare." than ".$circ_count." in ".$compare_date."\n";

     $args .="circ_count ".$compare." ".$circ_count." ";
  }

  if(isset($_POST['circ_date_type']))
  {
     $time_type = $_POST['circ_time_type'];

	  if ($_POST['circ_date_type'] == "absolute")
	  {
		  $start = $_POST['circ_start'];
		  $circ_start = date('Y-m-d', strtotime("$start"));

        if ($time_type == "between")
        {
		     $end = $_POST['circ_end'];
           $circ_end = date('Y-m-d', strtotime("$end"));

		     $message_body .="circ date is between ".$circ_start." to ".$circ_end."\n";
		     $args .="circ_date between ".$circ_start." ".$circ_end." ";
		  }
		  else
		  {
		    $message_body .="circ date is ".$time_type." ".$circ_start."\n";
		    $args .="circ_date ".$time_type." ".$circ_start." ";
		  }
	  }
	  else if ($_POST['circ_date_type'] == "relative")
	  {
		  $circ_start = $_POST['circ_start'];

		  if ($time_type == "between")
        {
   		  $circ_end = $_POST['circ_end'];

		     $message_body .="relative circ date is between ".$circ_start." to ".$circ_end."\n";
		     $args .="circ_date_relative between ".$circ_start." ".$circ_end." ";
		  }
		  else
		  {
		      $message_body .="relative circ date is ".$time_type." ".$circ_start."\n";
		      $args .="circ_date_relative ".$time_type." ".$circ_start." ";
		  }
	  }
  }

  if(isset($_POST['due_date_type']))
  {
     $time_type = $_POST['due_time_type'];

	  if ($_POST['due_date_type'] == "absolute")
	  {
		  $start = $_POST['due_start'];
		  $due_start = date('Y-m-d', strtotime("$start"));

        if ($time_type == "between")
        {
		     $end = $_POST['due_end'];
           $due_end = date('Y-m-d', strtotime("$end"));

		     $message_body .="due date is between ".$due_start." to ".$due_end."\n";
		     $args .="due_date between ".$due_start." ".$due_end." ";
		  }
		  else
		  {
		    $message_body .="due date is ".$time_type." ".$due_start."\n";
		    $args .="due_date ".$time_type." ".$due_start." ";
		  }
	  }
	  else if ($_POST['due_date_type'] == "relative")
	  {
		  $due_start = $_POST['due_start'];

		  if ($time_type == "between")
        {
   		  $due_end = $_POST['due_end'];

		     $message_body .="relative due date is between ".$due_start." to ".$due_end."\n";
		     $args .="due_date_relative between ".$due_start." ".$due_end." ";
		  }
		  else
		  {
		      $message_body .="relative due date is ".$time_type." ".$due_start."\n";
		      $args .="due_date_relative ".$time_type." ".$due_start." ";
		  }
	  }
  }

  if (isset($_POST['hold_count']))
  {
     $hold_count = $_POST['hold_count'];
     $hold_loc = $_POST['hold_loc'];

     $message_body .="Hold Count ".$hold_count." at ".$hold_loc." library \n";

     $args .="hold_count ".$hold_count." ".$hold_loc." ";
  }

  if(isset($_POST['inventory_date_type']))
  {
     $time_type = $_POST['inventory_time_type'];

	  if ($_POST['inventory_date_type'] == "absolute")
	  {
		  $start = $_POST['inventory_start'];
		  $inventory_start = date('Y-m-d', strtotime("$start"));

        if ($time_type == "between")
        {
		     $end = $_POST['inventory_end'];
           $inventory_end = date('Y-m-d', strtotime("$end"));

		     $message_body .="inventory date is between ".$inventory_start." to ".$inventory_end."\n";
		     $args .="inventory_date between ".$inventory_start." ".$inventory_end." ";
		  }
		  else
		  {
		    $message_body .="inventory date is ".$time_type." ".$inventory_start."\n";
		    $args .="inventory_date ".$time_type." ".$inventory_start." ";
		  }
	  }
	  else if ($_POST['inventory_date_type'] == "relative")
	  {
		  $inventory_start = $_POST['inventory_start'];

		  if ($time_type == "between")
        {
   		  $inventory_end = $_POST['inventory_end'];

		     $message_body .="relative inventory date is between ".$inventory_start." to ".$inventory_end."\n";
		     $args .="inventory_date_relative between ".$inventory_start." ".$inventory_end." ";
		  }
		  else
		  {
		      $message_body .="relative inventory date is ".$time_type." ".$inventory_start."\n";
		      $args .="inventory_date_relative ".$time_type." ".$inventory_start." ";
		  }
	  }
  }

  if (isset($_POST['include_null_inventory']))
  {
     $message_body .="include null inventory\n";
     $args .="inventory_null ";
  }


  if(isset($_POST['invoice_date_type']))
  {
     $time_type = $_POST['invoice_time_type'];

	  if ($_POST['invoice_date_type'] == "absolute")
	  {
		  $start = $_POST['invoice_start'];
		  $invoice_start = date('Y-m-d', strtotime("$start"));

        if ($time_type == "between")
        {
		     $end = $_POST['invoice_end'];
           $invoice_end = date('Y-m-d', strtotime("$end"));

		     $message_body .="invoice date is between ".$invoice_start." to ".$invoice_end."\n";
		     $args .="invoice_date between ".$invoice_start." ".$invoice_end." ";
		  }
		  else
		  {
		    $message_body .="invoice date is ".$time_type." ".$invoice_start."\n";
		    $args .="invoice_date ".$time_type." ".$invoice_start." ";
		  }
	  }
	  else if ($_POST['invoice_date_type'] == "relative")
	  {
		  $invoice_start = $_POST['invoice_start'];

		  if ($time_type == "between")
        {
   		  $invoice_end = $_POST['invoice_end'];

		     $message_body .="relative invoice date is between ".$invoice_start." to ".$invoice_end."\n";
		     $args .="invoice_date_relative between ".$invoice_start." ".$invoice_end." ";
		  }
		  else
		  {
		      $message_body .="relative invoice date is ".$time_type." ".$invoice_start."\n";
		      $args .="invoice_date_relative ".$time_type." ".$invoice_start." ";
		  }
	  }
  }

  if(isset($_POST['invoice_closed_date_type']))
  {
     $time_type = $_POST['invoice_closed_time_type'];

	  if ($_POST['invoice_closed_date_type'] == "absolute")
	  {
		  $start = $_POST['invoice_closed_start'];
		  $invoice_closed_start = date('Y-m-d', strtotime("$start"));

        if ($time_type == "between")
        {
		     $end = $_POST['invoice_closed_end'];
           $invoice_closed_end = date('Y-m-d', strtotime("$end"));

		     $message_body .="invoice_closed date is between ".$invoice_closed_start." to ".$invoice_closed_end."\n";
		     $args .="invoice_closed_date between ".$invoice_closed_start." ".$invoice_closed_end." ";
		  }
		  else
		  {
		    $message_body .="invoice_closed date is ".$time_type." ".$invoice_closed_start."\n";
		    $args .="invoice_closed_date ".$time_type." ".$invoice_closed_start." ";
		  }
	  }
	  else if ($_POST['invoice_closed_date_type'] == "relative")
	  {
		  $invoice_closed_start = $_POST['invoice_closed_start'];

		  if ($time_type == "between")
        {
   		  $invoice_closed_end = $_POST['invoice_closed_end'];

		     $message_body .="relative invoice_closed date is between ".$invoice_closed_start." to ".$invoice_closed_end."\n";
		     $args .="invoice_closed_date_relative between ".$invoice_closed_start." ".$invoice_closed_end." ";
		  }
		  else
		  {
		      $message_body .="relative invoice_closed date is ".$time_type." ".$invoice_closed_start."\n";
		      $args .="invoice_closed_date_relative ".$time_type." ".$invoice_closed_start." ";
		  }
	  }
  }

  if (isset($_POST['include_null_invoice_closed']))
  {
     $message_body .="include null invoice closed\n";
     $args .="invoice_closed_null ";
  }


  if(isset($_POST['order_date_type']))
  {
     $time_type = $_POST['order_time_type'];

	  if ($_POST['order_date_type'] == "absolute")
	  {
		  $start = $_POST['order_start'];
		  $order_start = date('Y-m-d', strtotime("$start"));

        if ($time_type == "between")
        {
		     $end = $_POST['order_end'];
           $order_end = date('Y-m-d', strtotime("$end"));

		     $message_body .="order date is between ".$order_start." to ".$order_end."\n";
		     $args .="order_date between ".$order_start." ".$order_end." ";
		  }
		  else
		  {
		    $message_body .="order date is ".$time_type." ".$order_start."\n";
		    $args .="order_date ".$time_type." ".$order_start." ";
		  }
	  }
	  else if ($_POST['order_date_type'] == "relative")
	  {
		  $order_start = $_POST['order_start'];

		  if ($time_type == "between")
        {
   		  $order_end = $_POST['order_end'];

		     $message_body .="relative order date is between ".$order_start." to ".$order_end."\n";
		     $args .="order_date_relative between ".$order_start." ".$order_end." ";
		  }
		  else
		  {
		      $message_body .="relative order date is ".$time_type." ".$order_start."\n";
		      $args .="order_date_relative ".$time_type." ".$order_start." ";
		  }
	  }
  }

  if (isset($_POST['include_null_order_date']))
  {
     $message_body .="include null order_date\n";
     $args .="order_date_null ";
  }


  if (isset($_POST['lineitem_status']))
  {
     $line_item_status = $_POST['lineitem_status'];
     $message_body .="line_item_status is ".$line_item_status."\n";
     $args .="line_item_status ".$line_item_status." ";
  }


  if (isset($_POST['fund']))
  {
     $fund = trim($_POST['fund'],"*");
     $fund = str_replace("*", ",", $fund);
     $message_body .="fund is ".$fund."\n";
     $args .="fund ".$fund." ";
  }

  if (isset($_POST['stat_cats'])  && $_POST['stat_cats'] != -1)
  {
     $stat_cats =trim($_POST['stat_cats'], "*");
     $stat_cats_array = explode("*",$stat_cats);

     $cmd_stats = array();

     foreach($stat_cats_array as $new_stat_cat)
     {
        $open_paren = strpos($new_stat_cat,"(");
        $stat_cat = substr($new_stat_cat, 0, $open_paren);
        $stat_cat_entry = trim(substr($new_stat_cat, $open_paren+1), ")");

        //group them in sets by stat_cat in order for the OR part to work
        if (!array_key_exists($stat_cat, $cmd_stats))
        {
           $cmd_stats[$stat_cat] = array();
        }

        $cmd_stats[$stat_cat][] = $stat_cat_entry;
     }

     foreach($cmd_stats as $stat_cat => $entry_array)
     {
        $stat_cat_entry = implode(",", $entry_array);

        $message_body .="stat_cat is ".$stat_cat."\n";
        $message_body .="stat_cat_entry is ".$stat_cat_entry."\n";

        $args .="stat_cat ".$stat_cat." ".$stat_cat_entry." ";
     }
  }

  if (isset($_POST['courses'])  && $_POST['courses'] != -1)
  {
     $courses =trim($_POST['courses'], "*");
     $course_array = explode("*",$courses);

     foreach($course_array as $curr_course)
     {
        //split the inputof 12(5) into course 12 5
        $open_paren = strpos($curr_course,"(");
        $term = substr($curr_course, 0, $open_paren);
        $course = trim(substr($curr_course, $open_paren+1), ")");

        $message_body .="term is ".$term."\n";
        $message_body .="course is ".$course."\n";

        $args .="course ".$term." ".$course." ";
     }
  }

  if (isset($_POST['tags']))
  {
     $tags = trim($_POST['tags'],"*");
     $tags = str_replace("*", ",", $tags);
     $message_body .="tags is ".$tags."\n";
     $args .="tag ".$tags." ";
  }

  $address = $_POST['email'];
  $address = str_replace(" ", ",",$address);
  $addresses = explode(",", $address);
  foreach ($addresses as $curr)
  {
     $curr = trim($curr);
     if (strlen($curr) > 0)
     {
        $message_body .="email is ".$curr."\n";
        $args .="email ".$curr." ";
     }
  }

  if (isset($_POST['out_file']))
  {
     $out_file = $_POST['out_file'];
     $replace_chars = array("\\", "/", "%", ":", "'", "*", "?", ":", ";", "<", ">", "|", " ", "#", "$",")","(","&","!","@","#","$","^","\"","~","`","|");
     $out_file= str_replace($replace_chars, "_",$out_file );
     $message_body .="out_file is ".$out_file."\n";
     $args .="out_file ".$out_file." ";
  }

  if(isset($_POST['report_name']))
  {
     $report_name = str_replace("'","''",$_POST['report_name']);

     $message_body .= "report name =".$report_name."\n\n";

     $args .="report_name \"".$report_name."\" ";
  }

  if (isset($_POST['only_holder']))
  {
     $only_opt = $_POST['only_holder'];
     $message_body .="Filter By Only Holder=". $only_opt ."\n";
     $args .= "only_holder ".$only_opt." ";
  }

  if (isset($_POST['scope']))
  {
     $message_body .="Scope Links\n";
     $args .="scope ";
  }

  if (isset($_POST['domain']))
  {
     $domain = $_POST['domain'];
     $message_body .="Use ".$domain ." Domain \n";
     $args .="domain ".$domain." ";
  }

  if (isset($_POST['search_links']))
  {
     $message_body .="Search Links\n";
     $args .="search_links ";
  }

  if (isset($_POST['spreadsheet']))
  {
     $args.="spreadsheet ";
     //look at order
     $order = $_POST['sheet_order'];
     $args .=$order." ";

     //look at format
     $format = $_POST['sheet_format'];
     $args .= $format." ";

     if (isset($_POST['sheet_options'])) $args .= $_POST['sheet_options'];

     if (isset($_POST['sheet_display']))
     {
        $display = str_replace("*", " ", $_POST['sheet_display'] );
        $args .= $display." ";
     }

     if (isset($_POST['circ_between_start']) && isset($_POST['circ_between_end']) )
     {
        $start = $_POST['circ_between_start'];
        $end = $_POST['circ_between_end'];

        $between_start = date('Y-m-d', strtotime("$start"));
        $between_end = date('Y-m-d', strtotime("$end"));

        $message_body .="circ_between is ".$between_start." to ".$between_end."\n";
        $args .="circ_between ".$between_start." ".$between_end." ";

     }

  }

  if (isset($_POST['html']))
  {
     $args.="html ";
     //look at order
     $order = $_POST['html_order'];
     $args .=$order." ";

     //look at format
     if (isset($_POST['block_layout'])) $args .= "block ";
     if (isset($_POST['inline_layout'])) $args .= "inline ";
     if (isset($_POST['grid_layout'])) $args .= "grid ".$_POST['html_grid_width']." ";

     if (isset($_POST['html_group'])) $args .= "group_copy ".$_POST['html_group']." ";
     if (isset($_POST['html_word_press'])) $args .= "word_press ";
     if (isset($_POST['save_html'])) $args .= "save_html ";

     if (isset($_POST['html_display']))
     {
        $display = str_replace("*", " ", $_POST['html_display'] );
        $args .= $display." ";
     }

     if(isset($_POST['image_size']))
     {
        $args .= "image_size ".$_POST['image_size']." ";
     }

  }

  if (isset($_POST['rss']))
  {
     $args.="rss ";

     //look at format
     $args .= "rss_desc \"".$_POST['rss_desc']."\" ";
     $args .= "rss_list \"".$_POST['rss_list']."\" ";

  }

  if (isset($_POST['bookbag']))
  {
     $args.="bucket ";

     //look at format
     if (isset($_POST['bag_name']))
     {
        $bucket_name = str_replace("!", "\!", $_POST['bag_name']);
        $args .= "bucket_name \"".$bucket_name."\" ";
     }
     if (isset($_POST['bag_desc']))
     {
        $bucket_desc = str_replace("!", "\!", $_POST['bag_desc']);
        $args .= "bucket_desc \"".$bucket_desc."\" ";
     }
     $args .= "update_type ".$_POST['bag_update']." ";
     if (isset($_POST['bag_owner'])) $args .= "bucket_owner ".$_POST['bag_owner']." ";
     if (isset($_POST['bag_id'])) $args .= "bucket_id ".$_POST['bag_id']." ";
     if (isset($_POST['carousel'])) $args .= "carousel ";
  }

  if (isset($_POST['copy_bucket']))
  {
     $args.="copy_bucket ";

     //look at format
     if (isset($_POST['copy_bucket_name']))
     {
        $bucket_name = str_replace("!", "\!", $_POST['copy_bucket_name']);
        $args .= "bucket_name \"".$bucket_name."\" ";
     }

     if (isset($_POST['copy_bucket_desc']))
     {
        $bucket_desc = str_replace("!", "\!", $_POST['copy_bucket_desc']);
        $args .= "bucket_desc \"".$bucket_desc."\" ";
     }
     $args .= "update_type ".$_POST['copy_bucket_update']." ";
     if (isset($_POST['copy_bucket_owner'])) $args .= "bucket_owner ".$_POST['copy_bucket_owner']." ";
     if (isset($_POST['copy_bucket_id'])) $args .= "bucket_id ".$_POST['copy_bucket_id']." ";

  }


  if (isset($_POST['json']))
  {
     $args.="json ";
     $json_data_type = strtolower($_POST['json_data_type']);
     $json_data_type = str_replace(" ", "_", $json_data_type);

     $args .= $json_data_type." ";
  }

	$today = date('m_d_Y');
	$log_file_name = "/var/www/tools/reports/list_log_".$today.".txt";
	$log_file_string = date('m-d-Y G:i:s');

	if ($working)$log_file_string .= "------TEST----- /usr/bin/php -f /var/www/tools/list_maker_working/create_list.php ".$args."\n\n";
	else if ($testing) $log_file_string .= "------TEST----- /usr/bin/php -f /var/www/tools/list_maker_test/create_list.php ".$args."\n\n";
	else $log_file_string .= "------ /usr/bin/php -f /var/www/tools/list_maker/create_list.php ".$args."\n\n";

	$message_body .="log file name = ".$log_file_name."\n";

	if (file_exists($log_file_name))
	{
		$file = fopen($log_file_name, 'a');
		fwrite($file, $log_file_string);
		fclose($file);
	}
	else
	{
	  file_put_contents($log_file_name, $log_file_string);
	  chgrp($log_file_name, "www-data");
	}

	if ($working) $message_body .= "\n /usr/bin/php -f /var/www/tools/list_maker_working/create_list.php ".$args;
	else if ($testing) $message_body .= "\n /usr/bin/php -f /var/www/tools/list_maker_test/create_list.php ".$args;
	else $message_body .= "\n /usr/bin/php -f /var/www/tools/list_maker/create_list.php ".$args;

	$email = new PHPMailer();
	$email->From      = 'xxx@noblenet.org';
	$email->FromName  = 'List Report Generator';
	$email->Subject   = '*******New List*******';
	$email->Body      = $message_body;

	$email->AddAddress( 'xxx@noblenet.org');

	$email->Send();

    if ($working) $cmd = "/usr/bin/php -f /var/www/tools/list_maker_working/create_list.php ".$args;
	else if ($testing) $cmd = "/usr/bin/php -f /var/www/tools/list_maker_test/create_list.php ".$args;
	else $cmd = "/usr/bin/php -f /var/www/tools/list_maker/create_list.php  ".$args;

	if (!$working) exec($cmd . " > /dev/null &");

?>
