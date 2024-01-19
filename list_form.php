<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />

<title> List Maker  - Version 8.6 </title>


<link rel="stylesheet" type="text/css" href="../css/noble.css" />
<link rel="stylesheet" href="https://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
<script src="https://code.jquery.com/jquery-1.9.1.js"></script>
<script src="https://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<script type="text/javascript" src="../../shared/ajax/ajax.js"></script>
<script type="text/javascript" src="form_functions.js"></script>
<script type="text/javascript" src="form_jquery.js"></script>
<script src="../../shared/sweetalert2/dist/sweetalert2.all.min.js"></script>

<link rel="icon"  type="image/png" href="../favicon.ico">
<link rel="stylesheet" href="../../shared/sweetalert2/dist/sweetalert2.min.css">

</head>

<?php
    //Get all the GET variables from the URL
    //use them later to set all the right form options
    $use_filters = false;
    $use_scheduled = false;
    $use_out_file = false;
    $use_name = false;
    $use_email = false;
    $use_db_id = false;
    $use_location_group = false;
    $location_group = -1;
    $loc_string = "";
    $db_id = -1;
    $use_schedule = false;
    $report_type = "new";
    $use_all_loc = false;
    $del_type = "active";
    $elec_type = "physical";
    $status_filter = false;
    $prefix_filter = false;
    $suffix_filter = false;
    $circ_mod_filter = false;
    $line_item_status_filter = false;
    $fund_filter = false;
    $copy_tag_filter = false;
    $tags = "";
    $fund_list = "";
    $file_data_type = "none";
    $shelf_type ="none";
    $pub_type = "none";
    $del_date_type = "none";
    $stat_date_type = "none";
    $add_date_type = "none";
    $circ_date_type = "none";
    $inventory_date_type = "none";
    $due_date_type = "none";
    $invoice_date_type = "none";
    $invoice_closed_date_type = "none";
    $order_date_type = "none";
    $call_class = 0;
    $use_call_contains = false;
    $use_call_range = false;
    $use_coll_topic = false;
    $coll_topic = -1;
    $circ_count = -1;
    $hold_count = -1;
    $only_holder = "all";
    $use_scope = false;
    $use_search_links = false;
    $domain = "none";
    $use_stat_cat = false;
    $use_course = false;
    $use_spreadsheet = false;
    $use_html = false;
    $use_rss = false;
    $use_bookbag = false;
    $bookbag_id = -1;
    $make_carousel = false;
    $use_copy_bucket = false;
    $copy_bucket_id = -1;
    $use_json = false;
    $bisac_set = false;
    $stat_cat = "";
    $course_list = "";
    $save_file_name = false;
    $include_null_inventory = false;
    $include_null_pub_date = false;
    $include_null_invoice_closed = false;
    $include_null_order_date = false;
    $invoice_closed_time_type = '';
    $invoice_closed_time2 ='';
    $invoice_closed_time ='';
    $invoice_time2 = '';
    $invoice_time = '';
    $invoice_time_type = '';
    $order_time2 = '';
    $order_time = '';
    $order_time_type = '';
    $inventory_time_type = '';
    $inventory_time2 = '';
    $inventory_time = '';
    $due_time2 = '';
    $due_time = '';
    $due_time_type = '';
    $circ_time2 = '';
    $circ_time = '';
    $circ_time_type = '';
    $stat_time2 = '';
    $stat_time = '';
    $stat_time_type = '';
    $del_time2 = '';
    $del_time = '';
    $del_time_type = '';
    $add_time2 = '';
    $add_time = '';
    $add_time_type = '';
    $shelf_time = '';
    $library = '';
    $no_email = false;


     //get all the GET variables
    if (isset($_GET['db_id']))
    {
       $use_db_id = true;
       $db_id = $_GET['db_id'];
    }

    if (isset($_GET['filters']))
    {
       $use_filters = true;
       $filters = explode('*',$_GET['filters']);

       for ($i=0; $i < count($filters); $i++)
       {
          $arg = $filters[$i];

          if ($arg == "lib")
          {
             $library = $filters[++$i];
          }
          else if ($arg == "copy_loc")
          {
             $location = $filters[++$i];
             if ($location == "all")$use_all_loc = true;
          }
          else if ($arg == "copy_loc_grp")
          {
             $use_location_group = true;
             $location_group = $filters[++$i];
          }
          else if ($arg == "weeding")
          {
				 $report_type = "shelf";
          }
			 else if ($arg == "shelf")
			 {
				 $shelf_type = "absolute";
				 $shelf_date = date("m/d/Y", strtotime($filters[++$i]));
			 }
			 else if ($arg == "shelf_relative")
			 {
				 $shelf_type = "relative";
				 $temp = explode("_",$filters[++$i]);
				 $shelf_value = $temp[0];
				 $shelf_time = $temp[1];
			 }
			 else if ($arg == "pub_after")
			 {
				 $pub_type = "after";
				 $pub_date = $filters[++$i];
			 }
			 else if ($arg == "pub_before")
			 {
				 $pub_type = "before";
				 $pub_date = $filters[++$i];
			 }
			 else if ($arg == "pub_between")
			 {
				  $pub_type = "between";
				  $pub_date = $filters[++$i];
				  $pub_date2 = $filters[++$i];
			 }
			 else if ($arg == "pub_null")
			 {
			    $include_null_pub_date = true;
			 }
			 else if ($arg == "deleted_only")
			 {
			    $del_type = "deleted";
			 }
			 else if ($arg == "active_deleted")
			 {
			    $del_type = "both";
			 }
			 else if ($arg == "delete_date")
			 {
			    $del_date_type = "absolute";
			    $del_time_type = $filters[++$i];
				 $del_date = date("m/d/Y", strtotime($filters[++$i]));
				 if ($del_time_type == "between" ) $del_date2 = date("m/d/Y", strtotime($filters[++$i]));
			 }
			 else if ($arg == "delete_date_relative")
			 {
			    $del_date_type = "relative";
			    $del_time_type = $filters[++$i];

				 $temp = explode("_",$filters[++$i]);
				 $del_value = $temp[0];
				 $del_time = $temp[1];

				 if ($del_time_type == "between")
				 {
				    $temp2 = explode("_",$filters[++$i]);
				    $del_value2 = $temp2[0];
				    $del_time2 = $temp2[1];
				 }
			 }
			 else if( $arg =="electronic_only")
			 {
			    $elec_type = "electronic";
			 }
			 else if ($arg =="physical_electronic" )
          {
             $elec_type = "both";
          }
          else if ($arg == "status")
			 {
			    $status_filter = true;
			    $status = $filters[++$i];
			 }
			 else if ($arg == "prefix")
			 {
			    $prefix_filter = true;
			    $prefix = $filters[++$i];
			 }
			 else if ($arg == "suffix")
			 {
			    $suffix_filter = true;
			    $suffix = $filters[++$i];
			 }
			 else if ($arg == "circ_mod")
			 {
			    $circ_mod_filter = true;
			    $circ_mod = $filters[++$i];
			 }
			 else if ($arg == "stat_change")
			 {
			    $stat_date_type = "absolute";
			    $stat_time_type = $filters[++$i];
				 $stat_date = date("m/d/Y", strtotime($filters[++$i]));
				 if ($stat_time_type == "between" ) $stat_date2 = date("m/d/Y", strtotime($filters[++$i]));
			 }
			 else if ($arg == "stat_change_relative")
			 {
			    $stat_date_type = "relative";
			    $stat_time_type = $filters[++$i];

				 $temp = explode("_",$filters[++$i]);
				 $stat_value = $temp[0];
				 $stat_time = $temp[1];

				 if ($stat_time_type == "between")
				 {
				    $temp2 = explode("_",$filters[++$i]);
				    $stat_value2 = $temp2[0];
				    $stat_time2 = $temp2[1];
				 }
			 }
			 else if ($arg == "added")
			 {
			    $add_date_type = "absolute";
			    $add_time_type = $filters[++$i];
				 $add_date = date("m/d/Y", strtotime($filters[++$i]));
				 if ($add_time_type == "between" ) $add_date2 = date("m/d/Y", strtotime($filters[++$i]));
			 }
			 else if ($arg == "added_relative")
			 {
			    $add_date_type = "relative";
			    $add_time_type = $filters[++$i];

				 $temp = explode("_",$filters[++$i]);
				 $add_value = $temp[0];
				 $add_time = $temp[1];

				 if ($add_time_type == "between")
				 {
				    $temp2 = explode("_",$filters[++$i]);
				    $add_value2 = $temp2[0];
				    $add_time2 = $temp2[1];
				 }
			 }
			 else if ($arg == "bib_file" || $arg == "barcode_file"  || $arg == "isbn_file" )
			 {
			    if ($arg == "bib_file") $file_data_type = "bib";
			    else if ($arg == "barcode_file") $file_data_type = "barcode";
			    else if ($arg == "isbn_file") $file_data_type = "isbn";

			    $file_type = $filters[++$i];
			    $file_name = $filters[++$i];
			 }
			 else if ($arg == "call_contain" || $arg == "call_contains")
			 {
			    $call_class = $filters[++$i];
			    $call_contains = $filters[++$i];
			    $use_call_contains = true;
			 }
			 else if ($arg == "call_range")
			 {
			    $call_class = $filters[++$i];
			    $call_start = $filters[++$i];
			    $call_end = $filters[++$i];
			    $use_call_range = true;
			 }
			 else if ($arg == "coll_topic")
			 {
			    $use_coll_topic = true;
			    $call_class = $filters[++$i];
			    $coll_topic = $filters[++$i];
			 }
			 else if ($arg == "bisac")
			 {
			    $call_class = $filters[++$i];
			    $bisac_set = true;
			    $bisac_cats = explode("-",$filters[++$i]);
			 }
			 else if ($arg == "circ_count")
			 {
			    $circ_count_compare = $filters[++$i];
			    $circ_count = $filters[++$i];
			 }
			 else if ($arg == "circ_date")
			 {
			    $circ_date_type = "absolute";
			    $circ_time_type = $filters[++$i];
				 $circ_date = date("m/d/Y", strtotime($filters[++$i]));
				 if ($circ_time_type == "between" ) $circ_date2 = date("m/d/Y", strtotime($filters[++$i]));
			 }
			 else if ($arg == "circ_date_relative")
			 {
			    $circ_date_type = "relative";
			    $circ_time_type = $filters[++$i];

				 $temp = explode("_",$filters[++$i]);
				 $circ_value = $temp[0];
				 $circ_time = $temp[1];

				 if ($circ_time_type == "between")
				 {
				    $temp2 = explode("_",$filters[++$i]);
				    $circ_value2 = $temp2[0];
				    $circ_time2 = $temp2[1];
				 }
			 }
			 else if ($arg == "due_date")
			 {
			    $due_date_type = "absolute";
			    $due_time_type = $filters[++$i];
				$due_date = date("m/d/Y", strtotime($filters[++$i]));
				if ($due_time_type == "between" ) $due_date2 = date("m/d/Y", strtotime($filters[++$i]));
			 }
			 else if ($arg == "due_date_relative")
			 {
			    $due_date_type = "relative";
			    $due_time_type = $filters[++$i];

				 $temp = explode("_",$filters[++$i]);
				 $due_value = $temp[0];
				 $due_time = $temp[1];

				 if ($due_time_type == "between")
				 {
				    $temp2 = explode("_",$filters[++$i]);
				    $due_value2 = $temp2[0];
				    $due_time2 = $temp2[1];
				 }
			 }
			 else if ($arg == "hold_count")
			 {
			    $hold_count = $filters[++$i];
			    $hold_loc = $filters[++$i];
			 }
			 else if ($arg == "inventory_date")
			 {
			    $inventory_date_type = "absolute";
			    $inventory_time_type = $filters[++$i];
				 $inventory_date = date("m/d/Y", strtotime($filters[++$i]));
				 if ($inventory_time_type == "between" ) $inventory_date2 = date("m/d/Y", strtotime($filters[++$i]));
			 }
			 else if ($arg == "inventory_date_relative")
			 {
			    $inventory_date_type = "relative";
			    $inventory_time_type = $filters[++$i];

				 $temp = explode("_",$filters[++$i]);
				 $inventory_value = $temp[0];
				 $inventory_time = $temp[1];

				 if ($inventory_time_type == "between")
				 {
				    $temp2 = explode("_",$filters[++$i]);
				    $inventory_value2 = $temp2[0];
				    $inventory_time2 = $temp2[1];
				 }
			 }
			 else if ($arg == "inventory_null")
			 {
			    $include_null_inventory = true;
			 }
		     else if ($arg == "invoice_date")
			 {
			    $invoice_date_type = "absolute";
			    $invoice_time_type = $filters[++$i];
				 $invoice_date = date("m/d/Y", strtotime($filters[++$i]));
				 if ($invoice_time_type == "between" ) $invoice_date2 = date("m/d/Y", strtotime($filters[++$i]));
			 }
			 else if ($arg == "invoice_date_relative")
			 {
			    $invoice_date_type = "relative";
			    $invoice_time_type = $filters[++$i];

				 $temp = explode("_",$filters[++$i]);
				 $invoice_value = $temp[0];
				 $invoice_time = $temp[1];

				 if ($invoice_time_type == "between")
				 {
				    $temp2 = explode("_",$filters[++$i]);
				    $invoice_value2 = $temp2[0];
				    $invoice_time2 = $temp2[1];
				 }
			 }
			 else if ($arg == "invoice_closed_date")
			 {
			     $invoice_closed_date_type = "absolute";
			     $invoice_closed_time_type = $filters[++$i];
				 $invoice_closed_date = date("m/d/Y", strtotime($filters[++$i]));
				 if ($invoice_closed_time_type == "between" ) $invoice_closed_date2 = date("m/d/Y", strtotime($filters[++$i]));
			 }
			 else if ($arg == "invoice_closed_date_relative")
			 {
			    $invoice_closed_date_type = "relative";
			    $invoice_closed_time_type = $filters[++$i];

				 $temp = explode("_",$filters[++$i]);
				 $invoice_closed_value = $temp[0];
				 $invoice_closed_time = $temp[1];

				 if ($invoice_closed_time_type == "between")
				 {
				    $temp2 = explode("_",$filters[++$i]);
				    $invoice_closed_value2 = $temp2[0];
				    $invoice_closed_time2 = $temp2[1];
				 }
			 }
			 else if ($arg == "invoice_closed_null")
			 {
			    $include_null_invoice_closed = true;
			 }
			 else if ($arg == "order_date")
			 {
			    $order_date_type = "absolute";
			    $order_time_type = $filters[++$i];
				$order_date = date("m/d/Y", strtotime($filters[++$i]));
				if ($order_time_type == "between" ) $order_date2 = date("m/d/Y", strtotime($filters[++$i]));
			 }
			 else if ($arg == "order_date_relative")
			 {
			    $order_date_type = "relative";
			    $order_time_type = $filters[++$i];

				 $temp = explode("_",$filters[++$i]);
				 $order_value = $temp[0];
				 $order_time = $temp[1];

				 if ($order_time_type == "between")
				 {
				    $temp2 = explode("_",$filters[++$i]);
				    $order_value2 = $temp2[0];
				    $order_time2 = $temp2[1];
				 }
			 }
			 else if ($arg == "order_date_null")
			 {
			    $include_null_order_date = true;
			 }
			 else if ($arg == "line_item_status")
			 {
			    $line_item_status_filter = true;
			    $line_item_status = $filters[++$i];
			 }
			 else if ($arg == "fund")
			 {
			    $fund_filter = true;
			    $fund_ids = $filters[++$i];
			    $fund_id_array = explode(",",$fund_ids);

			    foreach ($fund_id_array as $fund_id)
			    {
			       $fund_list .=$fund_id."*";
			    }
			 }
			 else if ($arg == "only_holder")
			 {
			    $only_holder = $filters[++$i];
			 }
			 else if ($arg == "scope")
			 {
			    $use_scope = true;
			 }
			 else if ($arg == "domain")
			 {
			    $domain = $filters[++$i];
			 }
			 else if ($arg == "search_links")
			 {
			    $use_search_links = true;
			 }
			 else if ($arg == "stat_cat")
			 {
			    $use_stat_cat = true;
			    $stat_cat_id = $filters[++$i];
			    $entry_ids = $filters[++$i];
			    $entry_id_array = explode(",",$entry_ids);

			    foreach ($entry_id_array as $entry_id)
			    {
			       $stat_cat .=$stat_cat_id."(".$entry_id.")*";
			    }
			 }
			 else if ($arg == "course")
			 {
			    $use_course = true;
			    $term_id = $filters[++$i];
                $course_id = $filters[++$i];
                $course_list .=$term_id."(".$course_id.")*";
			 }
			 else if ($arg == "tag")
			 {
			    $copy_tag_filter = true;
			    $tags = $filters[++$i];
			 }
       }
    }

   if($use_filters && $report_type != "shelf") $report_type = "inventory";


    if (isset($_GET['output']))
    {
       $output = explode('*',$_GET['output']);

       for ($i=0; $i < count($output); $i++)
       {
          $arg = $output[$i];

          if ($arg == "out_file")
			 {
			    $use_out_file = true;
			    $out_file = urldecode($output[++$i]);
			 }
			 else if ($arg == "save_file_name")
			 {
			    $save_file_name = true;
			 }
			 else if ($arg == "spreadsheet")
			 {
			    $use_spreadsheet = true;
			    $sheet_order = "";
			    $sheet_display = "";
			    $sheet_format = "";
			    $sheet_options ="";

			    $i++;
			    $sheet_var = $output[$i];

			    $item_sheet = true;

			    while ($i < count($output) && $sheet_var !== "html" && $sheet_var !== "rss" && $sheet_var !== "bookbag"
			                               && $sheet_var !== "bucket" && $sheet_var !== "copy_bucket" && $sheet_var !== "json")
			    {
			        if(strpos($sheet_var, '_sort') !== false)
			        {
			           //this is the kind of sort
			           if($sheet_var == "title_sort") $sheet_order = "Title";
			           else if($sheet_var == "author_sort") $sheet_order = "Author";
			           else if($sheet_var == "call_sort") $sheet_order = "Call Number";
			           else if($sheet_var == "active_sort") $sheet_order = "Active Date";
			           else if($sheet_var == "circ_sort") $sheet_order = "Lifetime Circs";
			           else if($sheet_var == "circ_between_sort") $sheet_order = "Circs in Selected Dates";
			           else if($sheet_var == "ytd_sort") $sheet_order = "YTD Circs";
			        }
			        else if(strpos($sheet_var, 'excel') !== false)
			        {
			           $sheet_format = "Excel";
			        }
			        else if(strpos($sheet_var, 'csv') !== false)
			        {
			           $sheet_format = "CSV";
			        }
			        else if(strpos($sheet_var, 'bib_sheet') !== false)
			        {
			           $sheet_options .= "<li>Bib Sheet</li>";
			        }
			        else if(strpos($sheet_var, 'author_sheet') !== false)
			        {
			           $sheet_options .= "<li>Author Sheet</li>";
			        }
			        else if(strpos($sheet_var, 'no_item_sheet') !== false)
			        {
			           $item_sheet = false;
			        }
			        else if(strpos($sheet_var, 'count_sheet') !== false)
			        {
			           $sheet_options .= "<li>Count Sheet</li>";
			        }
			        else if(strpos($sheet_var, 'single_sheet') !== false)
			        {
			           $sheet_options .= "<li>Single Sheet</li>";
			        }
			        else if(strpos($sheet_var, 'summary_sheet') !== false)
			        {
			           $sheet_options .= "<li>Summary Sheet</li>";
			        }
			        else if(strpos($sheet_var, 'circs_by_lib') !== false)
			        {
			           $sheet_options .= "<li>Circs By Library</li>";
			        }
			        else
			        {
			             //these are all the display options
			             switch($sheet_var)
					     {
								case 'author':
								  $sheet_display .="<li>Author</li>";
								  break;
								case 'barcode':
								  $sheet_display .="<li>Barcode</li>";
								  break;
								case 'bib_id':
								  $sheet_display .="<li>Bib Id</li>";
								  break;
								case 'call_num':
								  $sheet_display .="<li>Call Number</li>";
								  break;
								case 'copy_loc':
								  $sheet_display .="<li>Shelving Location</li>";
								  break;
								case 'last_checkin':
								  $sheet_display .="<li>Last Checkin</li>";
								  break;
								case 'life_circ':
								  $sheet_display .="<li>Lifetime Circs</li>";
								  break;
								case 'only_holder':
								  $sheet_display .="<li>Only Holder</li>";
								  break;
								case 'part':
								  $sheet_display .="<li>Part</li>";
								  break;
								case 'prefix':
								  $sheet_display .="<li>Prefix</li>";
								  break;
								case 'pub_date':
								  $sheet_display .="<li>Pub Date</li>";
								  break;
								case 'suffix':
								  $sheet_display .="<li>Suffix</li>";
								  break;
								case 'title':
								  $sheet_display .="<li>Title</li>";
								  break;

								case 'active':
								  $sheet_display .="<li>Active Date</li>";
								  break;
								case 'age_protect':
								  $sheet_display .="<li>Age Protection</li>";
								  break;
								case 'alert':
								  $sheet_display .="<li>Alert Message</li>";
								  break;
								case 'amz_direct':
								  $sheet_display .="<li>Amazon Direct</li>";
								  break;
								case 'amz_search':
								  $sheet_display .="<li>Amazon Search</li>";
								  break;
								case 'acq_cost':
								  $sheet_display .="<li>Acquisition Cost</li>";
								  break;
								case 'branch':
								  $sheet_display .="<li>Branch</li>";
								  break;
								case 'call_class':
								  $sheet_display .="<li>Call Number Class</li>";
								  break;
								case 'sortkey':
								  $sheet_display .="<li>Call Num Sort Key</li>";
								  break;
								case 'cat_link_opac':
								  $sheet_display .="<li>Catalog OPAC Link</li>";
								  break;
								case 'cat_link_staff':
								  $sheet_display .="<li>Catalog Staff Link</li>";
								  break;
								case 'course':
								  $sheet_display .="<li>Course</li>";
								  break;
								case 'course_circ':
								  $sheet_display .="<li>Course Circulation</li>";
								  break;
								case 'title_link_opac':
								  $sheet_display .="<li>Title OPAC Link</li>";
								  break;
								case 'title_link_staff':
								  $sheet_display .="<li>Title StaffLink</li>";
								  break;
								case 'circ_lib':
								  $sheet_display .="<li>Circulation Library</li>";
								  break;
								case 'circ_selected':
								  $sheet_display .="<li>Circs in Selected Dates</li>";
								  break;
								case 'circ_between':
								  $start = date("m/d/Y", strtotime($output[++$i]));
								  $end = date("m/d/Y", strtotime($output[++$i]));
								  $sheet_display .="<li>Circs Between ".$start." - ".$end."</li>";
								  break;
								case 'circ_mod':
								  $sheet_display .="<li>Circ Modifier</li>";
								  break;
								case 'copy_id':
								  $sheet_display .="<li>Item Id</li>";
								  break;
								case 'create_date':
								  $sheet_display .="<li>Create Date</li>";
								  break;
								case 'status':
								  $sheet_display .="<li>Item Status</li>";
								  break;
								case 'tag':
								  $sheet_display .="<li>Item Tag</li>";
								  break;
								case 'cover':
								  $sheet_display .="<li>Cover Image</li>";
								  break;
								case 'fund_debit':
								  $sheet_display .="<li>Debit Amount</li>";
								  break;
								case 'due_date':
								  $sheet_display .="<li>Due Date</li>";
								  break;
								case 'encumbered':
								  $sheet_display .="<li>Encumbered</li>";
								  break;
								case 'fine':
								  $sheet_display .="<li>Fine Level</li>";
								  break;
								case 'fingerprint':
								  $sheet_display .="<li>Fingerprint</li>";
								  break;
								case 'floating':
								  $sheet_display .="<li>Floating</li>";
								  break;
								case 'fund':
								  $sheet_display .="<li>Fund</li>";
								  break;
							   case 'goodreads':
								  $sheet_display .="<li>Goodreads Link</li>";
								  break;
								case 'holds':
									$sheet_display .="<li>Hold Count</li>";
									break;
								case 'in_house':
								  $sheet_display .="<li>In House Use</li>";
								  break;
								case 'invoice_date':
								  $sheet_display .="<li>Invoice Date</li>";
								  break;
								case 'invoice_closed_date':
								  $sheet_display .="<li>Invoice Closed Date</li>";
								  break;
								case 'invoice_num':
								  $sheet_display .="<li>Invoice Number</li>";
								  break;
								case 'inventory':
								  $sheet_display .="<li>Inventory</li>";
								  break;
							 	case 'isbn':
								  $sheet_display .="<li>All ISBNs</li>";
								  break;
								case 'isbn1':
								  $sheet_display .="<li>First ISBN</li>";
								  break;
								case 'item_status_link':
								  $sheet_display .="<li>Item Status Link</li>";
								  break;
								case 'checkout':
								  $sheet_display .="<li>Last Checkout Date</li>";
								  break;
								case 'checkout_lib':
								  $sheet_display .="<li>Last Checkout Library</li>";
								  break;
								case 'last_fy':
								  $sheet_display .="<li>Last FY Circs</li>";
								  break;
								case 'line_item_id':
								  $sheet_display .="<li>Lineitem Id</li>";
								  break;
								case 'line_item_status':
								  $sheet_display .="<li>Lineitem Status</li>";
								  break;
								case 'loan_dur':
								  $sheet_display .="<li>Loan Duration</li>";
								  break;
								case 'marc':
								  $tag = $output[++$i];
								  $subfield = $output[++$i];
								  $sheet_display .="<li>MARC ".$tag." $".$subfield."</li>";
								  break;
								case 'oclc':
								  $sheet_display .="<li>OCLC Number</li>";
								  break;
								case 'order_date':
								  $sheet_display .="<li>Order Date</li>";
								  break;
								case 'other_lib_count':
								  $sheet_display .="<li>Other Library Count</li>";
								  break;
								case 'owning_lib':
								  $sheet_display .="<li>Owning Library</li>";
								  break;
								case 'po_num':
								  $sheet_display .="<li>Purchase Order Number</li>";
								  break;
								case 'price':
								  $sheet_display .="<li>Price</li>";
								  break;
								case 'public_note':
								  $sheet_display .="<li>Public Note</li>";
								  break;
							 	case 'publisher':
								  $sheet_display .="<li>Publisher</li>";
								  break;
								case 'reference':
								  $sheet_display .="<li>Reference</li>";
								  break;
								case 'staff_note':
								  $sheet_display .="<li>Staff Note</li>";
								  break;
								case 'stat_cat':
								  $sheet_display .="<li>Stat Cat</li>";
								  break;
								case 'stat_change':
								  $sheet_display .="<li>Last Status Change</li>";
								  break;
								case 'summary':
								  $sheet_display .="<li>Summary</li>";
								  break;
								case 'ytd_circ':
								  $sheet_display .="<li>YTD Circs</li>";
								  break;
					     }
					  }
			        $i++;
			        $sheet_var = $output[$i];
			    }
			    $i--;

			    if ($item_sheet)
			    {
			       //add Item sheet to the display options.
			       $sheet_options = "<li>Item Sheet</li>".$sheet_options;
			    }
			 }
			 else if ($arg == "html")
			 {
			    $use_html = true;
			    $html_order = "";
			    $html_display = "";
			    $html_layout = "";
			    $html_options ="";

			    $i++;
			    $html_var = $output[$i];

			    while ($i < count($output) && $html_var !== "spreadsheet" && $html_var !== "rss" && $html_var !== "bookbag"
			                               && $html_var !== "bucket" && $html_var !== "copy_bucket" && $html_var !== "json")
			    {
			        if(strpos($html_var, 'sort') !== false)
			        {
			           //this is the kind of sort
			           if($html_var == "title_sort") $html_order = "Title";
			           else if($html_var == "author_sort") $html_order = "Author";
			           else if($html_var == "call_sort") $html_order = "Call Number";
			           else if($html_var == "active_sort") $html_order = "Active Date";
			           else if($html_var == "circ_sort") $html_order = "Lifetime Circs";
			           else if($html_var == "ytd_sort") $html_order = "YTD Circs";
			        }
			        else if(strpos($html_var, 'block') !== false)
			        {
			           $html_layout .= "Block<br />";
			        }
			        else if(strpos($html_var, 'inline') !== false)
			        {
			           $html_layout .= "Inline<br/>";
			        }
			        else if(strpos($html_var, 'grid') !== false)
			        {
			           //get next value its the width
			           $html_layout .= "Grid ".$output[++$i];
			        }
			        else if(strpos($html_var, 'image_size') !== false)
			        {
			           $html_options .= "<li>Image Size ".ucwords($output[++$i])."</li>";
			        }
			        else if(strpos($html_var, 'group_copy') !== false)
			        {
			           $group_type = $output[++$i];
			           if ($group_type == "1")$html_options .= "<li>Group Items First</li>";
			           else $html_options .= "<li>Group Items All</li>";
			        }
			        else if(strpos($html_var, 'word_press') !== false)
			        {
			           $html_options .= "<li>WordPress</li<";
			        }
			        else
			        {
			           //these are all the display options
			             switch($html_var)
					     {
								case 'author':
								  $html_display .="<li>Author</li>";
								  break;
								case 'call_num':
								  $html_display .="<li>Call Number</li>";
								  break;
								case 'cover':
								  $html_display .="<li>Cover Image</li>";
								  break;
							   case 'title':
								  $html_display .="<li>Title</li>";
								  break;

								case 'active':
								  $html_display .="<li>Active Date</li>";
								  break;
								case 'age_protect':
								  $html_display .="<li>Age Protection</li>";
								  break;
								case 'amz_direct':
								  $html_display .="<li>Amazon Direct</li>";
								  break;
								case 'amz_search':
								  $html_display .="<li>Amazon Search</li>";
								  break;
								case 'barcode':
								  $html_display .="<li>Barcode</li>";
								  break;
							   case 'bib_id':
								  $html_display .="<li>Bib Id</li>";
								  break;
								case 'circ_lib':
								  $html_display .="<li>Circulation Library</li>";
								  break;
								case 'circ_mod':
								  $html_display .="<li>Circ Modifier</li>";
								  break;
								case 'copy_loc':
								  $html_display .="<li>Shelving Location</li>";
								  break;
								case 'status':
								  $html_display .="<li>Item Status</li>";
								  break;
							   case 'goodreads':
								  $html_display .="<li>Goodreads Link</li>";
								  break;
								case 'in_house':
								  $html_display .="<li>In House Use</li>";
								  break;
							 	case 'isbn':
								  $html_display .="<li>ISBN</li>";
								  break;
								case 'last_checkin':
								  $html_display .="<li>Last Checkin</li>";
								  break;
								case 'life_circ':
								  $html_display .="<li>Lifetime Circs</li>";
								  break;
								case 'oclc':
								  $html_display .="<li>OCLC Number</li>";
								  break;
								case 'part':
								  $html_display .="<li>Part</li>";
								  break;
								case 'prefix':
								  $html_display .="<li>Prefix</li>";
								  break;
								case 'pub_date':
								  $html_display .="<li>Pub Date</li>";
								  break;
								case 'public_note':
								  $html_display .="<li>Public Note</li>";
								  break;
							 	case 'publisher':
								  $html_display .="<li>Publisher</li>";
								case 'staff_note':
								  $html_display .="<li>Staff Note</li>";
								  break;
								case 'stat_cat':
								  $html_display .="<li>Stat Cat</li>";
								  break;
								case 'stat_change':
								  $html_display .="<li>Last Status Change</li>";
								  break;
								case 'summary':
								  $html_display .="<li>Summary</li>";
								  break;
								case 'ytdcirc':
								  $html_display .="<li>YTD Circs</li>";
								  break;
					     }
					}
			        $i++;
			        $html_var = $output[$i];
			    }
			    $i--;
			 }
			 else if ($arg == "rss")
			 {
			    $use_rss = true;
			    $rss_desc = "";
			    $rss_list ="";

			    $i++;
			    $rss_var = $output[$i];

			    while ($i < count($output) && $rss_var !== "spreadsheet" && $rss_var !== "html" && $rss_var !== "bookbag"
			                               && $rss_var !== "bucket" && $rss_var !== "copy_bucket" && $rss_var !== "json")
			    {
			        if(strpos($rss_var, 'rss_desc') !== false)
			        {
			           $rss_desc = urldecode($output[++$i]);
			        }
			        else if(strpos($rss_var, 'rss_list') !== false)
			        {
			           $rss_list = urldecode($output[++$i]);
			        }

			        $i++;
			        $rss_var = $output[$i];
			    }
			    $i--;
			}
			 else if ($arg == "bookbag" || $arg == "bucket")
			 {
			    $use_bookbag = true;
			    $bookbag_desc = "";
			    $bookbag_name ="";
			    $bookbag_id = -1;
			    $bookbag_update = "new";
			    $bookbag_owner = "";

			    $i++;
			    $bag_var = $output[$i];

			    while ($i < count($output) && $bag_var !== "spreadsheet" && $bag_var !== "html" && $bag_var !== "rss"
			                               && $bag_var !== "copy_bucket"  && $bag_var !== "json")
			    {
			        if(strpos($bag_var, 'bag_desc') !== false || strpos($bag_var, 'bucket_desc') !== false )
			        {
			           $bookbag_desc = urldecode($output[++$i]);
			           $bookbag_desc = str_replace("\!", "!", $bookbag_desc);
			        }
			        else if(strpos($bag_var, 'bag_name') !== false || strpos($bag_var, 'bucket_name') !== false )
			        {
			           $bookbag_name = urldecode($output[++$i]);
			           $bookbag_name = str_replace("\!", "!", $bookbag_name);
			        }
			        else if(strpos($bag_var, 'bag_id') !== false || strpos($bag_var, 'bucket_id') !== false)
			        {
			           $bookbag_id = urldecode($output[++$i]);
			        }
			        else if(strpos($bag_var, 'bucket_owner') !== false )
			        {
			           $bookbag_owner = urldecode($output[++$i]);
			        }
			        else if(strpos($bag_var, 'update_type') !== false)
			        {
			           $bookbag_update= urldecode($output[++$i]);
			        }
			        else if(strpos($bag_var, 'carousel') !== false)
			        {
			           $make_carousel = true;
			        }
			        else if (strpos($bag_var, 'no_email') !== false)
			        {
		               $no_email = true;
			        }

			        $i++;
			        $bag_var = $output[$i];
			    }
			    $i--;
			}
			 else if ($arg == "copy_bucket")
			 {
			    $use_copy_bucket = true;
			    $copy_bucket_desc = "";
			    $copy_bucket_name ="";
			    $copy_bucket_id = -1;

			    $i++;
			    $copy_var = $output[$i];

			    while ($i < count($output) && $copy_var !== "spreadsheet" && $copy_var !== "html" && $copy_var !== "rss"
			                               && $copy_var !== "bookbag" && $copy_var !== "bucket" && $copy_var !== "json")
			    {
			        if(strpos($copy_var, 'bucket_desc') !== false)
			        {
			           $copy_bucket_desc = urldecode($output[++$i]);
			           $copy_bucket_desc = str_replace("\!", "!", $copy_bucket_desc);
			        }
			        else if(strpos($copy_var, 'bucket_name') !== false)
			        {
			           $copy_bucket_name = urldecode($output[++$i]);
			           $copy_bucket_name = str_replace("\!", "!", $copy_bucket_name);
			        }
			        else if(strpos($copy_var, 'bucket_id') !== false)
			        {
			           $copy_bucket_id = urldecode($output[++$i]);
			        }
			        else if(strpos($copy_var, 'bucket_owner') !== false )
			        {
			           $copy_bucket_owner = urldecode($output[++$i]);
			        }
			        else if(strpos($copy_var, 'update_type') !== false)
			        {
			           $copy_bucket_update= urldecode($output[++$i]);
			        }
			        else if (strpos($bag_var, 'no_email') !== false)
			        {
		               $no_email = true;
			        }

			        $i++;
			        $copy_var = $output[$i];
			    }
			    $i--;
			}
			else if ($arg == "json")
			{
			    $use_json = true;
			    $i++;
			    $json_var = $output[$i];

			    while ($i < count($output) && $json_var !== "spreadsheet" && $json_var !== "html" && $json_var !== "bookbag"
			                               && $json_var !== "bucket" && $json_var !== "copy_bucket" && $json_var !== "rss")
			    {
			        if(strpos($json_var, 'bib_id') !== false)
			        {
			           $json_data_type = "Bib Id";
			        }
			        else if(strpos($json_var, 'isbn') !== false)
			        {
			           $json_data_type = "ISBN";
			        }
			        else if (strpos($bag_var, 'no_email') !== false)
			        {
		               $no_email = true;
			        }

			        $i++;
			        $json_var = $output[$i];
			    }
			    $i--;
			}
       }
    }

    if (isset($_GET['name']))
    {
       $use_name = true;
       $report_name = urldecode($_GET['name']);
    }

    if (isset($_GET['email']))
    {
       $use_email = true;
       $email = urldecode($_GET['email']);
    }

    if (isset($_GET['schedule']))
    {
       $use_schedule = true;
       $schedule = $_GET['schedule'];


       if ($schedule == "weekly")
       {
          $days = explode(",", $_GET['days']);
       }
       else if ($schedule == "monthly")
       {
          $use_spec_days = false;
          $use_rel_days = false;

          if (isset($_GET['spec_days']) )
          {
             $use_spec_days = true;
             $spec_days = $_GET['spec_days'];
          }

          if (isset($_GET['rel_days']))
          {
             $use_rel_days = true;
             $rel = explode("_", $_GET['rel_days']);
             $rel_time = $rel[0];
             $rel_day = $rel[1];
          }
       }
       else if ($schedule == "relative")
       {
          $rel = explode("_",$_GET['interval']);
          $rel_day = $rel[0];
          $rel_time = $rel[1];
          $start_date = date('m/d/Y', strtotime($_GET['start_date']));
       }

    }

    include "/usr/local/noble/db_config/db_info.php";

    $eg_db = pg_connect("host=$eg_host port=$eg_port dbname=$eg_database user=$eg_user password=$eg_password");
    if (!$eg_db)
    {
       die("Error in connection: " . pg_last_error());
    }

?>


<body onLoad="JavaScript:getCollManTopics(<?php echo "'".$coll_topic."'";?>)">
<a name="top"></a>
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
       <h1> List Maker  - Version 8.6  </h1>
    </div><!-- end header text-->

    <div id ="page_nav">
      <ul>
        <li><a href="edit_scheduled.php" target="_blank">Edit Scheduled</a></li>
        <li><a href="https://www.noblenet.org/sis/evergreen/tools/listmaker/" target="_blank">Help</a></li>
        <li><a href="https://docs.google.com/document/d/1qx6Kc7CKGDMiSGUd47NZQ8ACLl8gSaD452XdhIJ8fHI/edit?usp=sharing" target="_blank">Roadmap</a></li>
        <!--<li><a href="https://docs.google.com/a/noblenet.org/document/d/1eCN_JjnpSpY3xBxaO_-fAVLf-Fv9VJUo_CBUfkdiXG4/edit?usp=sharing" target="_blank">Changelog</a></li>-->
      </ul>
    </div><!-- end page nav -->

  </div> <!-- end header -->

<div id ="content">
<form id="stats" action="preview_output.php" onsubmit="return CheckPreviewForm()" method="post">

   <!-- if not set skips all the jquery stuff for an input -->
   <input type="hidden" id="use_filters" name="use_filters" <?php echo"value=\"".$use_filters."\"";?> />
   <input type="hidden" id="use_db" name="use_db" <?php echo"value=\"".$db_id."\"";?> />

    <h2> Report Type: <hr/></h2>
   <h3 class="weeding">Select a report type?

   <img src='../../shared/images/question-mark-small.png' class="help" onclick="JavaScript:swal('Basic vs Advanced','Simple reports are common types of reports with few options. Advanced reports give you a longer form and let you choose many more options.', 'info');"/></h3>

    <table class="select_report weeding">
    <tbody>
    <tr>

     <td>
      <input type="radio" name="report_type" id="new_items" class="report_type" value="new_items" <?php if ($report_type == "new") echo "checked";?>  >
      <label class="report_type"> Basic List</label>
     </td>

     <td>
      <input type="radio" name="report_type" id="inventory_report" class="report_type" value="inventory" <?php if ($report_type == "inventory") echo "checked";?> >
       <label class="report_type" >Advanced List</label>
     </td>

    </tr>

     <tr>
      <td>
       <input type="radio" name="report_type" id="file_upload" class="report_type" value="file_upload">
       <label class="report_type">Basic File Upload</label>
      </td>

       <td>
       <span class="no-noble"><input type="radio" name="report_type" id="weeding_report" class="report_type" value="weeding" <?php if ($report_type == "shelf") echo "checked";?> >
       <label class="report_type">Advanced Shelf Sitter</label></span>
      </td>

     </tr>

     <tr>
      <td>
       <input type="radio" name="report_type" id="status_change" class="report_type" value="status_change" >
       <label class="report_type"> Basic Status Change </label>
      </td>

     <td>
       <input type="radio" name="report_type" id="preview_report" class="report_type" value="preview">
       <label class="report_type">Quick Preview</label>
     </td>

     </tr>

     <tr>
      <td>
        <input type="radio" name="report_type" id="shelf_sitter" class="report_type" value="shelf_sitter">
        <label class="report_type">Basic Shelf Sitter</label>
        </td>
     </tr>

      <tr>
      <td>
        <input type="radio" name="report_type" id="acq_report" class="report_type" value="acq_report">
        <label class="report_type">Basic Acquisitions</label>
        </td>
     </tr>

   </tbody>
   </table>


  <span class="no-preview">
  <h3 class="weeding"> Do you want to run Only Once or Schedule? </h3>
  <p  class="weeding">

  <input type="radio" name="frequency" id="one_report" class="frequency" value="once" class="frequency" onchange="JavaScript:updateAllCircPreSuffix(this.value)" <?php if (!$use_schedule) echo "checked";?>>
  <label class="frequency" >Once </label>

  <input type="radio" name="frequency" id="schedule_report" class="frequency" value="schedule"  class="frequency" onchange="JavaScript:updateAllCircPreSuffix(this.value)" <?php if ($use_schedule) echo "checked";?>>
  <label class="frequency">Schedule </label>
 </p>

  <div id="schedule">
      <h2> Schedule Report: <hr/></h2>
          <div class="configure_schedule">
          <h3>Repeating
           <select id="how_often" class="stats">
             <option value="none"></option>
             <option value="daily" <?php if ($use_schedule && $schedule=="daily") echo selected;?> > Daily</option>
             <option value="weekly" <?php if ($use_schedule && $schedule=="weekly") echo selected;?> > Weekly</option>
             <option value="monthly" <?php if ($use_schedule && $schedule=="monthly") echo selected;?> > Monthly</option>
             <option value="configure" <?php if ($use_schedule && $schedule=="relative") echo selected;?> >Relative</option>
           </select>
           </h3>
           <div id="monthly">
             <h3>Which days of the month?</h3>
               <p>
                Pick specific days: <input type="text" id="specific_days" class="stats" <?php if($use_schedule && $use_spec_days) echo "value=\"".$spec_days."\"";?> /> <span class="note">separate days (1-31) with commas</span>
                 <br />

                <br />And/Or<br /><br />

                <select id="first_last" class="stats">
                   <option value="none"></option>
                   <option value="first" <?php if ($use_schedule && $use_rel_days && $rel_time=="first") echo selected;?> >First</option>
                   <option value="second" <?php if ($use_schedule && $use_rel_days && $rel_time=="second")echo selected;?> >Second</option>
                   <option value="third" <?php if ($use_schedule && $use_rel_days && $rel_time=="third") echo selected;?> >Third</option>
                   <option value="fourth" <?php if ($use_schedule && $use_rel_days && $rel_time=="fourth") echo selected;?> >Fourth</option>
                   <option value="last" <?php if ($use_schedule && $use_rel_days && $rel_time=="last") echo selected;?> >Last</option>
                   <!--<option value="every_other">Every Other</option>-->
                </select>

                <select id="month_days" class="stats">
                   <option value="none"></option>
                   <option value="monday" <?php if ($use_schedule && $use_rel_days && $rel_day=="monday") echo selected;?> >Monday</option>
                   <option value="tuesday" <?php if ($use_schedule && $use_rel_days && $rel_day=="tuesday") echo selected;?> >Tuesday</option>
                   <option value="wednesday" <?php if ($use_schedule && $use_rel_days && $rel_day=="wednesday") echo selected;?> >Wednesday</option>
                   <option value="thursday" <?php if ($use_schedule && $use_rel_days && $rel_day=="thursday") echo selected;?> >Thursday</option>
                   <option value="friday" <?php if ($use_schedule && $use_rel_days && $rel_day=="friday") echo selected;?> >Friday</option>
                   <option value="saturday" <?php if ($use_schedule && $use_rel_days && $rel_day=="saturday") echo selected;?> >Saturday</option>
                   <option value="sunday" <?php if ($use_schedule && $use_rel_days && $rel_day=="sunday") echo selected;?> >Sunday</option>
                </select>

             </p>
           </div>

           <div id="weekly">
            <h3>Which days of the week? </h3>
               <table>
               <tbody>
               <tr>
                <td><input type="checkbox" id="monday" name="monday" value="monday" class="stats" <?php if ($use_schedule && $schedule=="weekly" && in_array("monday", $days)) echo checked;?> >
                 </td><td>Monday</td>
               </tr>
               <tr>
                <td><input type="checkbox" id="tuesday" name="tuesday" value="tuesday" class="stats"  <?php if ($use_schedule && $schedule=="weekly" && in_array("tuesday", $days)) echo checked;?> >
                </td><td>Tuesday</td>
               </tr>
               <tr>
                <td><input type="checkbox" id="wednesday" name="wednesday" value="wednesday" class="stats"  <?php if ($use_schedule && $schedule=="weekly" && in_array("wednesday", $days)) echo checked;?> >
                 </td><td>Wednesday</td>
               </tr>
               <tr>
                <td><input type="checkbox" id="thursday" name="thursday" value="thursday" class="stats"  <?php if ($use_schedule && $schedule=="weekly" && in_array("thursday", $days)) echo checked;?> >
                </td><td>Thursday</td>
               </tr>
               <tr>
                <td><input type="checkbox" id="friday" name="friday" value="friday" class="stats"  <?php if ($use_schedule && $schedule=="weekly" && in_array("friday", $days)) echo checked;?> >
                </td><td>Friday</td>
               </tr>
               <tr>
                <td><input type="checkbox" id="saturday" name="saturday" value="saturday" class="stats"  <?php if ($use_schedule && $schedule=="weekly" && in_array("saturday", $days)) echo checked;?> >
                </td><td>Saturday</td>
               </tr>
               <tr>
                <td><input type="checkbox" id="sunday" name="sunday" value="sunday" class="stats"  <?php if ($use_schedule && $schedule=="weekly" && in_array("sunday", $days)) echo checked;?> >
                </td><td>Sunday</td>
                </tr>
               </tbody>
               </table>
           </div>


            <div id="configure">
             <p>
              Every <input type="text" id="relative_time" size="3" class="stats" <?php if ($use_schedule && $schedule=="relative" ) echo "value=\"".$rel_day."\"";?> />
              <select id="relative_measure" class="stats">
                <option value="days" <?php if ($use_schedule && $schedule=="relative" && $rel_time=="days" ) echo selected;?> >Days</option>
                <option value="weeks" <?php if ($use_schedule && $schedule=="relative" && $rel_time=="weeks" ) echo selected;?> >Weeks</option>
                <option value="months" <?php if ($use_schedule && $schedule=="relative" && $rel_time=="months" ) echo selected;?> >Months</option>

              </select>
              Starting On  <input type="text" name="relative_start_date" id ="relative_start_date" maxlength="10" size="10" class="stats" <?php if ($use_schedule && $schedule=="relative" ) echo "value=\"".$start_date."\"";?>>
              </p>
            </div>
         </div>

         <h3 class="weeding"> Run Now?
         <input type="checkbox" id="run_now" name="run_now" class="stats" <?php if ($use_schedule && $use_json) echo checked; ?>/>
         </h3>

   </div> <!-- end schedule -->
 </span>

    <h2> Choose Your Data: <hr/></h2>
    <h3 class="weeding"> Location </h3>

   <table class="weeding" cellspacing="12">
    <tr>
       <td>
          Library:
       </td>
       <td>
         <select name="library" id="library" class="stats" onchange="JavaScript:getCopyLocationsList(this.value)">
         <option value="NONE">Select Library</option>
         <?php

            $parent_id = -1;
            $has_branches = false;
            $is_branch = false;

            if (strlen($library) <= 4 && $library != "LYNN")
            {
               $is_branch = true;
               //get the parent id
               $branch_sql = "SELECT parent_ou
                              FROM actor.org_unit
                              WHERE shortname = '$library'";
               $branch_result = pg_query($eg_db, $branch_sql);

               $branch_row = pg_fetch_row($branch_result);

               if ($branch_row)$parent_id = $branch_row[0];
            }

             $lib_sql = "SELECT shortname, name, id
                        FROM actor.org_unit
                        WHERE ou_type IN (1,2)
                        AND id NOT IN (31, 36, 39, 42) ";

            $lib_sql .=" ORDER by shortname";

            $result = pg_query($eg_db, $lib_sql);

            while($row = pg_fetch_row($result))
            {
               $shortname = $row[0];
               $arr = explode(" ",trim($row[1]));
               $ou_id = $row[2];

               if ($shortname == "BUNKERHILL" || $shortname == "SALEMSTATE") $name = $arr[0]." ".$arr[1];
               else $name = $arr[0];

               echo "<option value=\"".$shortname."\"";

               if ($use_filters)
               {
						if ($library == $shortname || $ou_id == $parent_id)
						{
							 //if it's a library with branches save id
							 echo " selected";

							 if( $shortname=="BEVERLY" || $shortname=="EVERETT" || $shortname=="PEABODY" || $shortname=="PHILLIPS" || $shortname=="SALEMSTATE" )
                      {
							     $parent_id = $ou_id;
							     $has_branches = true;
							 }
						}
               }

               echo ">".$name."</option>\n";
            }

         ?>
      </select>
    </td>
    </tr>

    <tr>
      <td>
         Branch:
      </td>
      <td>
          <?php
          if($parent_id > -1 )
          {
               echo "<select name=\"branch_filter\" id=\"branch_filter\" class=\"stats\" onchange=\"JavaScript:UpdateCopyLocations(this.value)\" >\n";

              //A branch or system with branches is selected
              $branch_sql = "SELECT shortname, name
                              FROM actor.org_unit
                              WHERE parent_ou = $parent_id";
              $branch_result = pg_query($eg_db, $branch_sql);

              echo " <option value=\"ALL\"";
              if($has_branches)echo " selected";
              echo ">ALL</option>\n";

              while ($branch_row = pg_fetch_row($branch_result))
              {
                 //put all the branches in the box
                 //if is branch select that one
                 $shortname = $branch_row[0];
                 $name = $branch_row[1];

                 echo "<option value=\"".$shortname."\"";

                 if($is_branch && $shortname == $library) echo " selected";

                 switch($parent_id)
                 {
                     //beverly phillips peabody
                     case 2:
                     case 49:
                     case 45:
                       $arr = explode(" ", $name);
                       $display_name = $arr[1];
                       break;

                     //everett
                     case 14:
                        $arr = explode(" ", $name);
                        $display_name = $arr[2];
                        break;

                     //salem state
                     case 64:
                       if ($shortname == "SSU") $display_name = "SSU";
                       else if ($shortname == "SSUE") $display_name = "ERA";
                       break;

                 }

                 echo ">".$display_name."</option>\n";
              }

              echo "</select>\n";
          }
          else
          {
          ?>
             <select name="branch_filter" id="branch_filter" class="stats" onchange="JavaScript:UpdateCopyLocations(this.value)" disabled>
                <option value="NONE"> NONE </option>
             </select>
          <?php
          }?>
      </td>
    </tr>
    </table>

   <h3 class="weeding"> Choose one of the three following options</h3> <br />

  <table class="weeding" cellspacing="12">
    <tr>
      <td valign="top">
         1. Shelving Location(s):
      </td>
      <td>
      <div id="copy_loc" class="scrolling_loc_cb">
      <?php
         if ($use_filters)
         {
               $loc_arr =explode(",", $location);

					$copy_loc_sql = "SELECT asset.copy_location.id, asset.copy_location.name
                                FROM asset.copy_location
                                JOIN actor.org_unit ON actor.org_unit.id = asset.copy_location.owning_lib
                                WHERE asset.copy_location.deleted = false
                                AND actor.org_unit.shortname = '$library'
                                UNION
                                SELECT asset.copy_location.id, asset.copy_location.name
                                FROM asset.copy_location
                                JOIN actor.org_unit ON actor.org_unit.id = asset.copy_location.owning_lib
                                WHERE asset.copy_location.deleted = false
                                AND asset.copy_location.owning_lib IN (SELECT parent_ou FROM actor.org_unit WHERE shortname = '$library' and parent_ou != 1)
                                UNION
                                SELECT asset.copy_location.id, asset.copy_location.name
                                FROM asset.copy_location
                                JOIN actor.org_unit ON actor.org_unit.id = asset.copy_location.owning_lib
                                WHERE asset.copy_location.deleted = false
                                AND asset.copy_location.owning_lib IN (SELECT child.id
                                                                       FROM actor.org_unit child
                                                                       JOIN actor.org_unit parent on child.parent_ou = parent.id
                                                                       WHERE parent.shortname='$library' )
                               UNION
                               SELECT asset.copy_location.id, asset.copy_location.name
                               FROM asset.copy_location
                               JOIN actor.org_unit ON actor.org_unit.id = asset.copy_location.owning_lib
                               WHERE asset.copy_location.deleted = false
                               AND actor.org_unit.shortname = 'NOBLE'
                               ORDER BY 2";

				$loc_result = pg_query($eg_db, $copy_loc_sql);

				while ($row = pg_fetch_row($loc_result))
				{
				   $loc_id = $row[0];
				   $loc_name = $row[1];

				   if(strlen($loc_name) > 0 )
				   {
				      echo "<input type=\"checkbox\" id=\"".$loc_id."\" name=\"copy_loc_checkboxes[]\" value=\"".$loc_id."\" class=\"multi_check\" ";

				      if(in_array($loc_id, $loc_arr))
				      {
				         echo " checked";
				      }

				      echo " onclick=\"JavaScript:getCircModifierList(false)\" /><label for=\"".$loc_name."\" class=\"multi_cb_label\">".$loc_name."</label><br/>\n";
				   }
				}

				if(!$use_location_group)
				{
				   $loc_string = "(".$location.")";
				}
         }
         else
         {
             echo "NONE\n";
         }
      ?>
      </div>
      </td>
    </tr>


    <tr>
      <td>
        2. Shelving Location Group:
      </td>
      <td>
       <select id="copy_loc_group" name="copy_loc_group" class="stats"  onchange="JavaScript:getCircModifierList(true)" <?php if ($use_all_loc) echo "disabled";?>>
       <?php
         if ($use_filters)
         {
				$copy_loc_grp_sql = "SELECT asset.copy_location_group.id, asset.copy_location_group.name
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

				$loc_result = pg_query($eg_db, $copy_loc_grp_sql);

			   echo "<option value=\"-1\"></option>\n";

				while ($row = pg_fetch_row($loc_result))
				{
				   $loc_id = $row[0];
				   $loc_name = $row[1];

				   echo "<option value=\"".$loc_id."\"";

				   if($use_location_group && $loc_id == $location_group)
				   {
				      echo " selected";
				   }

				   echo ">".$loc_name."</option>\n";
				}

				if($use_location_group)
				{
				   //get the string of locations included so the status/circ mod/prefix/suffix work
				   $loc_grp_locs_sql = "SELECT location
                                    FROM asset.copy_location_group_map
                                    WHERE lgroup = $location_group";

               $grp_result = pg_query($eg_db,$loc_grp_locs_sql);

               $locs_in_grp = array();
               while($row = pg_fetch_row($grp_result))
               {
                  $locs_in_grp[] = $row[0];
               }

               $loc_string = "(".implode(",",$locs_in_grp).")";
				}

         }
         else
         {
             echo "<option value=\"-1\"> NONE </option>\n";
         }
      ?>
      </td>
    </tr>

    <tr>
       <td>
        3. <label id="all_label"> Use All Shelving Locations:</label>
        </td>
        <td>
        <input type="checkbox" id="all_locations" name="all_locations" value="all" onchange="JavaScript:getAllCircPreSuffix(this)" <?php if ($use_all_loc) echo "checked";?>>

          <img src='../../shared/images/question-mark-small.png' class="help" onclick="JavaScript:swal('All Shelving Locations','Output reports can have a maximum of 50,000 items.' , 'info');"/>
       </td>
    </tr>

    </table>


  <h2> Filters: <hr/></h2>

<div id ="all_filters">

  <div id="weeding_only">
   <h3 class="weeding"> Record Selector <span class="note"> REQUIRED </span></h3>
   <p class="weeding">
        <select id="checkin_date_type" name="checkin_date_type" class="stats">
          <option value="absolute" <?php if($shelf_type == "absolute") echo "selected"; ?> >Absolute</option>
          <option value="relative" <?php if($shelf_type == "relative") echo "selected"; ?>>Relative</option>
       </select>
       <label id="date_label">Sitting on the shelf since </label>
       <input type="text" name="last_checkin_date" maxlength="10" size="10" id="last_checkin_date" class="stats checkin_absolute" <?php if($shelf_type == "absolute") echo "value=\"".$shelf_date."\""; ?>>
       <input type="text" name="checkin_date_relative" size="3" id="checkin_date_relative" class=" stats checkin_relative" <?php if($shelf_type == "relative") echo "value=\"".$shelf_value."\""; ?>>
         <select id="checkin_time" name="checkin_time" class="stats checkin_relative">
           <option value="days" <?php if($shelf_time == "days") echo "selected"; ?> >Days</option>
           <option value="weeks" <?php if($shelf_time == "weeks") echo "selected"; ?>>Weeks</option>
           <option value="months" <?php if($shelf_time == "months") echo "selected"; ?>>Months</option>
           <option value="years" <?php if($shelf_time == "years") echo "selected"; ?>>Years</option>
        </select>
        <label id="date_label2" class="stats checkin_relative"> ago </label>
        <img src='../../shared/images/question-mark-small.png' class="help" onclick="JavaScript:swal('Checkin','Use the calendar widget to select a date of last check in.', 'info');"/>
   <br/>

   </p>

	</div> <!-- end div weeding -->



    <div class="canned_file">
    <span class="no_schedule">
    <h5 class="topic_section"> File Upload     <hr class="topic_seperator"/></h5>

    <h3 class="weeding">Filter With File <span class="note"> (Optional) </span>
    <img src='../../shared/images/question-mark-small.png' class="help" onclick="JavaScript:swal('File Name','Upload a file that contains the Document ID of bib records or the barcode of item records in either text or CSV format.  The CSV file can include additional columns, but the file must have header row with Document ID or Barcode as column heading', 'info');"/></h3>
    <p class="weeding">
          <!-- <input type="checkbox" id="use_file" name="use_file" value="use_file" >
          <label id="file_label">File Name <a href="JavaScript:uploadFile()" class="stat_link"><span class="configure">Upload File</span></a></label>
          -->
       <span id="upload_button"><input type="button" value="Upload File" class="stats" id="upload" onclick="JavaScript:uploadFile()"/></span>
       <span id="file_name"><?php if($file_data_type != "none") echo "File: ".$file_name."<br />"; ?></span>
       <span id="data_type"><?php if($file_data_type != "none") echo "Data: ".$file_data_type."<br />"; ?></span>
       <span id="file_type"><?php if($file_data_type != "none") echo "Format: ".$file_type."<br />"; ?></span>
       <span id="clear_file_button"><input type="button" value="Clear File" class="stats" id="clear_file" onclick="JavaScript:clearFile()"/></span>
       <input type="hidden" id="input_file_name" name="input_file_name" <?php if($file_data_type != "none") echo "value=\"".$file_name."\""; else echo"value=\"-1\"";?> />
	    <input type="hidden" id="input_data_type" name="input_data_type" <?php if($file_data_type != "none") echo "value=\"".$file_data_type."\""; else echo"value=\"-1\"";?> />
	    <input type="hidden" id="input_file_type" name="input_file_type" <?php if($file_data_type != "none") echo "value=\"".$file_type."\""; else echo"value=\"-1\"";?> />
   </p>
   </span>
   </div> <!-- end if canned file -->


   <div class="canned_new">

   <h5 class="topic_section"> Lifespan <hr class="topic_seperator"/></h5>


   <h3 class="weeding">Filter By Added to Collection  <span class="note"> (Optional) </span>
      <img src='../../shared/images/question-mark-small.png' class="help" onclick="JavaScript:swal('Added to Collection','The Absolute option lets you use the calendar to choose specific dates, like January 1, 2018. The Relative option lets you choose time periods, like before 10 days ago', 'info');"/></h3>
   <p class="weeding">
      <input type="checkbox" id="use_active" name="use_active" value="use_active" onChange="JavaScript:SetElectronic(this.checked)" <?php if ($add_date_type !="none") echo "checked";?>>
      <select id="added_date_type" name="added_date_type" class="stats">
        <option value="absolute" <?php if($add_date_type == "absolute") echo "selected"; ?> >Absolute</option>
        <option value="relative" <?php if($add_date_type == "relative") echo "selected"; ?> >Relative</option>
      </select>
      <label id="active_label">Added  </label>
         <select id ="added_time_type" name="added_time_type" class="stats">
           <option value="between" <?php if($add_time_type == "between") echo "selected"; ?>>Between</option>
           <option value="before" <?php if($add_time_type == "before") echo "selected"; ?> >Before</option>
           <option value="after" <?php if($add_time_type == "after") echo "selected"; ?> >After</option>
        </select>

         <input type="text" name="active_start" maxlength="10" size="10" id="active_start" onChange="JavaScript:SetCheckbox(this.value, 'use_active')" class="stats added_absolute" <?php if($add_date_type == "absolute") echo "value=\"".$add_date."\""; ?>>
         <input type="text" name="active_start_relative" size="3" id="active_start_relative" onchange="JavaScript:SetCheckbox(this.value, 'use_active')" class="stats added_relative" <?php if($add_date_type == "relative" ) echo "value=\"".$add_value."\""; ?>>
         <select id="added_start_time" name="added_start_time"class="stats added_relative">
            <option value="days" <?php if($add_time == "days") echo "selected"; ?> >Days</option>
            <option value="weeks" <?php if($add_time == "weeks") echo "selected"; ?> >Weeks</option>
            <option value="months" <?php if($add_time == "months") echo "selected"; ?> >Months</option>
            <option value="years" <?php if($add_time == "years") echo "selected"; ?> >Years</option>
         </select>
         <span class ="added_between">and
         <input type="text" name="active_end" maxlength="10" size="10" id="active_end" class="stats added_absolute " <?php if($add_date_type == "absolute" && $add_time_type == "between") echo "value=\"".$add_date2."\""; ?>>
         <input type="text" name="active_end_relative" size="3" id="active_end_relative" class=" stats added_relative " <?php if($add_date_type == "relative" && $add_time_type == "between") echo "value=\"".$add_value2."\""; ?>>
         <select id="added_end_time" name="added_end_time" class="stats added_relative">
           <option value="days" <?php if($add_time2 == "days") echo "selected"; ?> >Days</option>
           <option value="weeks" <?php if($add_time2 == "weeks") echo "selected"; ?> >Weeks</option>
           <option value="months" <?php if($add_time2 == "months") echo "selected"; ?> >Months</option>
           <option value="years" <?php if($add_time2 == "years") echo "selected"; ?> >Years</option>
         </select>
         </span>
         <label id="active_label2" class="stats added_relative"> ago</label>
   <br/>
   </p>
   </div>


   <span class="not_weeding">
   <div class="canned_hide">
   <span class="no-noble">
    <h3 class="weeding no-preview">Filter by Deleted  <span class="note"> (Optional) </span>
      <img src='../../shared/images/question-mark-small.png' class="help" onclick="JavaScript:swal('Status','By default, your list will only include “Active” items, which means any item that hasn’t been deleted.  You can use this filter if you want to a list of only Deleted items,or that includes both Active and Deleted items.', 'info');"/> </h3>
      <p class="weeding no-preview">
          <select id="deleted" name="deleted" class="stats no-preview" >
             <option value="active_only" <?php if($del_type == "active") echo "selected"; ?> >Active Items Only</option>
             <option value="active_deleted" <?php if($del_type == "both") echo "selected"; ?> >All Items (active AND deleted)</option>
             <option value="deleted_only" <?php if($del_type == "deleted") echo "selected"; ?> >Deleted Items Only</option>
          </select>
      </p>


       <div id="deleted_date_div">
           <h3 class="weeding">Filter By Deleted Date  <span class="note"> (Optional) </span> </h3>
          <p class="weeding">
           <input type="checkbox" id="use_deleted_date" name="use_deleted_date" value="use_deleted_date" <?php if ($del_date_type !="none") echo "checked";?>>
              <select id="deleted_date_type" name="deleted_date_type" class="stats">
             <option value="absolute" <?php if($del_date_type == "absolute") echo "selected"; ?> >Absolute</option>
             <option value="relative" <?php if($del_date_type == "relative") echo "selected"; ?> >Relative</option>
           </select>
          <label id="deleted_change_label">Deleted </label>
           <select id ="deleted_time_type" name="deleted_time_type"class="stats">
              <option value="after" <?php if($del_time_type == "after") echo "selected"; ?> >After</option>
              <option value="before" <?php if($del_time_type == "before") echo "selected"; ?> >Before</option>
              <option value="between" <?php if($del_time_type == "between") echo "selected"; ?>>Between</option>
          </select>

            <input type="text" name="deleted_date_start" maxlength="10" size="10" id="deleted_date_start" onchange="JavaScript:SetCheckbox(this.value, 'use_deleted_date')" class="stats deleted_absolute" <?php if($del_date_type == "absolute") echo "value=\"".$del_date."\""; ?>>
            <input type="text" name="deleted_date_start_relative" size="3" id="deleted_date_start_relative" onchange="JavaScript:SetCheckbox(this.value, 'use_deleted_date')" class=" stats deleted_relative" <?php if($del_date_type == "relative" ) echo "value=\"".$del_value."\""; ?>>
            <select id="deleted_start_time" name="deleted_start_time" class="stats deleted_relative">
              <option value="days" <?php if($del_time == "days") echo "selected"; ?> >Days</option>
              <option value="weeks" <?php if($del_time == "weeks") echo "selected"; ?> >Weeks</option>
              <option value="months" <?php if($del_time == "months") echo "selected"; ?> >Months</option>
              <option value="years" <?php if($del_time == "years") echo "selected"; ?> >Years</option>
            </select>
            <span class ="deleted_between">and
             <input type="text" name="deleted_date_end" maxlength="10" size="10" id="deleted_date_end" class="stats deleted_absolute " <?php if($del_date_type == "absolute" && $del_time_type == "between") echo "value=\"".$del_date2."\""; ?>>
            <input type="text" name="deleted_date_end_relative" size="3" id="deleted_date_end_relative" class=" stats deleted_relative " <?php if($del_date_type == "relative" && $del_time_type == "between") echo "value=\"".$del_value2."\""; ?>>
             <select id="deleted_end_time" name="deleted_end_time" class="stats deleted_relative">
              <option value="days" <?php if($del_time2 == "days") echo "selected"; ?>>Days</option>
              <option value="weeks" <?php if($del_time2 == "weeks") echo "selected"; ?>>Weeks</option>
              <option value="months" <?php if($del_time2 == "months") echo "selected"; ?>>Months</option>
              <option value="years" <?php if($del_time2 == "years") echo "selected"; ?>>Years</option>
            </select>
            </span>

            <label id="deleted_change_label2" class="stats deleted_relative"> ago</label>
          </p>
      </div>
      </span>
      </div>


   <div class ="show_electronic">
   <h5 class="topic_section"> Physical Electronic    <hr class="topic_seperator"/></h5>

   <h3 class="weeding">Filter by Electronic  <span class="note"> (Optional) </span>

   <img src='../../shared/images/question-mark-small.png' class="help" onclick="JavaScript:swal('Electronic','If you are filtering by a file of bib records that includes electronic resource records, you can filter the file to include only the records for physical items, only the electronic resource records, or both.', 'info');"/> </h3>
   <p class="weeding">
        <select id="electronic" name="electronic" class="stats" onChange = "JavaScript:CheckCopyLocation(this.value)" <?php if( !($file_data_type == "bib" || $add_date_type !="none")) echo "disabled"; ?> >
           <option value="physical_only" <?php if($elec_type =="physical") echo "selected"; ?> >Physical Items Only</option>
           <option value="physical_electronic" <?php if($elec_type =="both") echo "selected"; ?> >All Items (physical AND electronic)</option>
           <option value="electronic_only" <?php if($elec_type =="electronic") echo "selected"; ?>>Electronic Items Only</option>
        </select>
    </p>
    </div> <!-- end if canned file -->

     <span class="no-noble">
     <div class="canned_status">
     <h5 class="topic_section"> Status      <hr class="topic_seperator"/>   </h5>

     <h3 class="weeding">Filter by Status  <span class="note"> (Optional) </span>
     <img src='../../shared/images/question-mark-small.png' class="help" onclick="JavaScript:swal('Status','Limit your search by selecting one or more Statuses.  The list will only include Statuses that are in records in the copy locations you selected.', 'info');"/> </h3>
         <div id="statuses" class="scrolling_cb weeding">
         <?php
         if ($use_filters)
         {
               if ($status_filter) $stat_arr =explode(",", $status);

               if ($use_db_id || $use_all_loc)
               {
                  //this is a scheduled report use all statuses
                  $status_sql = "SELECT DISTINCT id, name
                                 FROM config.copy_status
                                 ORDER BY name";
               }
               else
               {
				   	$status_sql = "SELECT DISTINCT config.copy_status.id, config.copy_status.name
                                 FROM asset.copy
                                 JOIN actor.org_unit ON actor.org_unit.id=asset.copy.circ_lib  AND actor.org_unit.id IN
                                   (SELECT child.id
                                    FROM actor.org_unit child
                                    JOIN actor.org_unit parent on child.parent_ou = parent.id
                                    WHERE parent.shortname='$library' OR child.shortname= '$library'
                                    ORDER BY child.id)
                                 JOIN config.copy_status ON asset.copy.status = config.copy_status.id
                                 WHERE asset.copy.location IN $loc_string
                                 AND asset.copy.deleted = false
                                 ORDER BY 1";
               }


					$stat_result = pg_query($eg_db, $status_sql);

					if( pg_num_rows($stat_result) < 1 )
					{
					   echo "NONE\n";
					}
					else
					{
						while ($row = pg_fetch_row($stat_result))
						{
							$stat_id = $row[0];
							$stat_name = $row[1];

							echo "<input type=\"checkbox\" id=\"".$stat_id."\" name=\"status_checkboxes[]\" value=\"".$stat_id."\" class=\"multi_check\" ";

							if($status_filter && in_array($stat_id, $stat_arr))
							{
								echo " checked";
							}

							echo " /><label for=\"".$stat_name."\" class=\"multi_cb_label\">".$stat_name."</label><br/>\n";
						}
					}
         }
         else
         {
             echo "NONE\n";
         }
      ?>
     <br />
    </div>
    <span class ="clear_button">
      <input type="button"  value="Clear" onClick="ClearStatus()"/>
   </span>

     <h3 class="weeding">Filter By Last Status Change  <span class="note"> (Optional) </span> </h3>
     <p class="weeding">
      <input type="checkbox" id="status_change_check" name="status_change_check" value="status_change_check" <?php if ($stat_date_type !="none") echo "checked";?>>
        <select id="status_date_type" name="status_date_type" class="stats">
          <option value="absolute" <?php if($stat_date_type == "absolute") echo "selected"; ?> >Absolute</option>
          <option value="relative" <?php if($stat_date_type == "relative") echo "selected"; ?> >Relative</option>
       </select>
      <label id="stat_change_label">Last Status Change  </label>
         <select id ="stat_time_type" name="stat_time_type" class="stats">
           <option value="before" <?php if($stat_time_type == "before") echo "selected"; ?> >Before</option>
           <option value="after" <?php if($stat_time_type == "after") echo "selected"; ?> >After</option>
           <option value="between" <?php if($stat_time_type == "between") echo "selected"; ?>  >Between</option>
        </select>
         <input type="text" name="status_date_start" maxlength="10" size="10" id="status_date_start" onchange="JavaScript:SetCheckbox(this.value, 'status_change_check')" class="stats stat_absolute" <?php if($stat_date_type == "absolute") echo "value=\"".$stat_date."\""; ?>>
         <input type="text" name="status_date_start_relative" size="3" id="status_date_start_relative" onchange="JavaScript:SetCheckbox(this.value, 'status_change_check')" class=" stats stat_relative" <?php if($stat_date_type == "relative" ) echo "value=\"".$stat_value."\""; ?>>
         <select id="stat_start_time" name="stat_start_time" class="stats stat_relative">
           <option value="days" <?php if($stat_time == "days") echo "selected"; ?>>Days</option>
           <option value="weeks" <?php if($stat_time == "weeks") echo "selected"; ?> >Weeks</option>
           <option value="months" <?php if($stat_time == "months") echo "selected"; ?>>Months</option>
           <option value="years" <?php if($stat_time == "years") echo "selected"; ?>>Years</option>
         </select>
         <span class ="status_between">and
         <input type="text" name="status_date_end" maxlength="10" size="10" id="status_date_end" class="stats stat_absolute" <?php if($stat_date_type == "absolute" && $stat_time_type == "between") echo "value=\"".$stat_date2."\""; ?>>
         <input type="text" name="status_date_end_relative" size="3" id="status_date_end_relative" class=" stats stat_relative" <?php if($stat_date_type == "relative" && $stat_time_type == "between") echo "value=\"".$stat_value2."\""; ?>>
         <select id="stat_end_time" name="stat_end_time" class="stats stat_relative">
           <option value="days" <?php if($stat_time2 == "days") echo "selected"; ?>>Days</option>
           <option value="weeks" <?php if($stat_time2 == "weeks") echo "selected"; ?> >Weeks</option>
           <option value="months" <?php if($stat_time2 == "months") echo "selected"; ?>>Months</option>
           <option value="years" <?php if($stat_time2 == "years") echo "selected"; ?>>Years</option>
         </select>
         </span>
         <label id="stat_change_label2" class="stats stat_relative"> ago</label>
         <img src='../../shared/images/question-mark-small.png' class="help" onclick="JavaScript:swal('Status Change','Use the calendar widget to select a date when copy status was last changed.', 'info');"/>
   <br/>
   </p>
     </div>
     </span>
   </span> <!-- end  not weeding -->


   <div>
   <div class="canned_new canned_shelf">
   <h5 class="topic_section"> Item Attributes    <hr class="topic_seperator"/></h5>

   </div>

   <div class="canned_new canned_shelf">
   <h3 class="weeding">Filter by Statistical Categories  <span class="note"> (Optional) </span>
   <img src='../../shared/images/question-mark-small.png' class="help" onclick="JavaScript:swal('Stat Cat','Select the statistical category to display all the possible values. Check off one or more of these and scroll to the bottom of the box and click Done.', 'info');"/> </h3>
	<div id="stat_cat_text">

	   <?php
	      if ($use_stat_cat)
	      {
	         //for each set

	         $stat_array = explode("*",$stat_cat);

	         foreach($stat_array as $stat)
	         {
	            if (strlen($stat) < 2 ) continue;
	            $open_paren = strpos($stat,"(");
                $curr_stat = substr($stat, 0, $open_paren);
                $curr_entry = trim(substr($stat, $open_paren+1), ")");

					//get the words for selected stat cat
				   $stat_cat_sql = "SELECT asset.stat_cat.name, asset.stat_cat_entry.value
											FROM asset.stat_cat
											INNER JOIN asset.stat_cat_entry ON asset.stat_cat_entry.stat_cat =  asset.stat_cat.id
											WHERE asset.stat_cat.id = $curr_stat
											AND asset.stat_cat_entry.id = $curr_entry";
					$stat_cat_result = pg_query($eg_db, $stat_cat_sql);

					$stat_cat_row = pg_fetch_row($stat_cat_result);

				   echo "<span class =\"stat\">".$stat_cat_row[0]." / ".$stat_cat_row[1]." <br /></span>\n";
             }

             echo "</div>";

	          echo "<input type=\"hidden\" id=\"stat_cats\" name=\"stat_cats\" value=\"".$stat_cat."\"/>";

	      }
	      else
	      {
	   ?>
	        </div>
	        <input type="hidden" id="stat_cats" name="stat_cats"/>
	   <?php
	   }?>
	   <p class="weeding">
	   <a href="JavaScript:configureStatCat()" class="stat_link">Configure Stat Cats</a>
	   </p>
   </div>

   <div class="canned_new canned_shelf">
   <span class="no-noble">
   <h3 class="weeding">Filter by Call Number  <span class="note"> (Optional) </span>
   <img src='../../shared/images/question-mark-small.png' class="help" onclick="JavaScript:swal('Call Number','Enter a call number range to only look at items within a certain range (not case sensitive). No Spaces.', 'info');"/></h3>
    <div class="weeding call">
          Call Number Class:
           <select name="call_class" id="call_class" class="stats" onchange="JavaScript:getBISACLevel1(this.value)">
            <option value="0"> Select </option>
            <option value="1" <?php if ($call_class== "1") echo "selected";?> > Generic </option>
            <option value="2" <?php if ($call_class== "2") echo "selected";?>  > Dewey </option>
            <option value="3" <?php if ($call_class== "3") echo "selected";?> > LC </option>
            <option value="4" <?php if ($call_class== "4") echo "selected";?> > BISAC </option>
          </select>
          <br/>
          <h4 class="call_num">Select A Method:</h4>
   </div>
   <div id="call_range" class="weeding">
          <hr class="call_num_seperator"/>
           <table class="call_num"><tbody>
           <tr><td class="call_select"><input type="radio" id="call_num_range" name="call_method" value="range" <?php if($use_call_range) echo "checked"; ?> > <label>Range </label></td></tr>
           <tr><td>Starting Call Number: </td>   <td> <input type="text" name="start_call" id ="start_call" class="stats" onchange="JavaScript:SetRadio(this.value, 'call_num_range')" <?php if($use_call_range) echo "value=\"".$call_start."\""; ?>></td></tr>
           <tr><td>End Call Number: </td>   <td> <input type="text" name="end_call" id ="end_call" class="stats"  onchange="JavaScript:SetRadio(this.value, 'call_num_range')" <?php if($use_call_range) echo "value=\"".$call_end."\""; ?>></td></tr>
           </tbody></table>

   </div>

   <div id="call_contains" class="weeding">
           <hr class="call_num_seperator"/>
           <table class="call_num"><tbody>
           <tr><td class="call_select"><input type="radio" id="call_num_contains" name="call_method" value="contains" <?php if($use_call_contains) echo "checked"; ?> > <label> Call Number Contains </label></td></tr>
           <tr><td>Text:</td>   <td>  <input type="text" name="contains_call" id ="contains_call" class="stats"  onchange="JavaScript:SetRadio(this.value, 'call_num_contains')" <?php if($use_call_contains) echo "value=\"".$call_contains."\""; ?> ></td></tr>
           </tbody></table>
   </div>
   </span>

    <span class="no-preview">
    <span class="noble-only">
       <h3 class="weeding">Filter by Collection Topic  <span class="note"> (Optional) </span></h3>
   </span>
   </span>

   <span class="no-preview">
   <div id="collection" class="weeding">
     <hr class="call_num_seperator no-noble"/>
     <table class="call_num"><tbody>
        <tr><td class="call_select"><input type="radio" id="coll_topic" name="call_method" value="coll_topic" <?php if($use_coll_topic) echo "checked"; ?> > <label>Collection Topic</label></td></tr>
        <tr><td class="no-noble"> Topics: </td>
       <td>
            <select id="coll_man" name="coll_man" class="stats" multiple size=3 onchange="JavaScript:SetRadio(this.value, 'coll_topic')" >
            </select>
            <br />
           	<input type="button"  value="Clear" onClick="JavaScript:ClearCollManTopics()"/>
      </td></tr>
      </tbody></table>
   </div>
   </span>

   <span class="no-noble">

   <div id="bisac" class="weeding">
      <hr class="call_num_seperator"/>
       <table class="call_num"><tbody>
       <tr><td class="call_select"><input type="radio" id="bisac_call" name="call_method" value="bisac" <?php if($bisac_set) echo "checked"; ?> > <label>Bisac Category </label></td></tr>
       <tr>
          <td> Level 1 Text: </td>
          <td>
            <select name="level1" id="level1" class="stats" onchange="JavaScript:getBISACLevel2(this.value)">
            <?php
              if ($call_class== "4")
              {
                 //get the first bisac category
                  $bisac1_sql = "SELECT noble.bisac_category.id, noble.bisac_category.category
                                 FROM noble.bisac_category
                                 INNER JOIN actor.org_unit ON actor.org_unit.id = noble.bisac_category.org_unit
                                 WHERE ( actor.org_unit.shortname = '$library' OR
                                        actor.org_unit.shortname IN (SELECT parent.shortname
                                                                     FROM actor.org_unit child
                                                                     INNER JOIN actor.org_unit parent ON parent.id = child.parent_ou
                                                                     WHERE child.shortname = '$library') )
                                 AND noble.bisac_category.level = 1
                                 ORDER BY noble.bisac_category.category";

                  $bisac_result = pg_query($eg_db, $bisac1_sql);

                  while ($row = pg_fetch_row($bisac_result))
						{
							$bisac_id = $row[0];
							$bisac_name = $row[1];

							echo "<option value=\"".$bisac_id."\"";

							if($bisac_id == $bisac_cats[0])
							{
								echo " selected";
							}

							echo ">".$bisac_name."</option>\n";
						}
              }
              ?>
           </select>

          </td>
       </tr>
       <tr>
          <td> Level 2 Text: </td>
          <td>
          <select name="level2" id="level2" class="stats" onchange="JavaScript:getBISACLevel3(this.value)">
              <?php
              if ($call_class== "4" && $bisac_cats[0])
              {
                 //get the first bisac category
                  $bisac2_sql = "SELECT noble.bisac_category.id, noble.bisac_category.category
                                 FROM noble.bisac_category
                                 WHERE noble.bisac_category.parent_category=$bisac_cats[0]
                                 AND noble.bisac_category.level = 2
                                 ORDER BY noble.bisac_category.category";

                  $bisac2_result = pg_query($eg_db, $bisac2_sql);

                  while ($row = pg_fetch_row($bisac2_result))
						{
							$bisac_id = $row[0];
							$bisac_name = $row[1];

							echo "<option value=\"".$bisac_id."\"";

							if($bisac_cats[1] && $bisac_id == $bisac_cats[1])
							{
								echo " selected";
							}

							echo ">".$bisac_name."</option>\n";
						}
              }
              ?>
          </select>
          </td>
       </tr>
       <tr>
          <td> Level 3 Text: </td>
          <td>
          <select name="level3" id="level3" class="stats">
             <?php
              if ($call_class== "4" && $bisac_cats[2])
              {
                  //get the first bisac category
                  $bisac3_sql = "SELECT noble.bisac_category.id, noble.bisac_category.category
                                 FROM noble.bisac_category
                                 WHERE noble.bisac_category.parent_category=$bisac_cats[2]
                                 AND noble.bisac_category.level = 3
                                 ORDER BY noble.bisac_category.category";

                  $bisac3_result = pg_query($eg_db, $bisac3_sql);

                  while ($row = pg_fetch_row($bisac3_result))
						{
							$bisac_id = $row[0];
							$bisac_name = $row[1];

							echo "<option value=\"".$bisac_id."\"";

							if($bisac_cats[2] && $bisac_id == $bisac_cats[2])
							{
								echo " selected";
							}

							echo ">".$bisac_name."</option>\n";
						}
              }
              ?>
          </select>
          </td>
       </tr>
       </tbody></table>
   </div>



   <div class="weeding call_bottom">
     <hr class="call_num_seperator"/>
   </div>
   </span>
   </div>

  <span class="no-noble">
   <div class="canned_new canned_shelf">
   <h3 class="weeding">Filter by Call Number Prefix  <span class="note"> (Optional) </span>
    <img src='../../shared/images/question-mark-small.png' class="help" onclick="JavaScript:swal('Call Number Prefix',' Limit your search by selecting one or more Call Number Prefixes.  The list will only include Call Number Prefixes that are in records in the copy locations you selected.', 'info');"/> </h3>
    <div id="prefixes" class="scrolling_cb weeding">
      <?php
         if ($use_filters)
         {
               if ($prefix_filter)  $prefix_arr =explode(",", $prefix);

               if ($use_db_id || $use_all_loc)
               {
							$prefix_sql = "SELECT asset.call_number_prefix.id, asset.call_number_prefix.label, asset.call_number_prefix.label_sortkey
						                  FROM asset.call_number_prefix
						                  JOIN actor.org_unit ON actor.org_unit.id=asset.call_number_prefix.owning_lib";
						  if ( $is_branch)
						  {
							  $prefix_sql .=" WHERE actor.org_unit.id = $parent_id OR actor.org_unit.shortname = '$library' ";
						  }
						  else
						  {
								$prefix_sql .=" WHERE actor.org_unit.id IN (SELECT child.id
														FROM actor.org_unit child
														JOIN actor.org_unit parent on child.parent_ou = parent.id
														WHERE parent.shortname='$library'
														ORDER BY child.id)
											OR actor.org_unit.shortname = '$library'";
						  }
						  $prefix_sql .= "ORDER BY asset.call_number_prefix.label_sortkey";


               }
               else
               {

                  if ($is_branch)
                  {
                     $prefix_sql = "SELECT DISTINCT asset.call_number_prefix.id, asset.call_number_prefix.label, asset.call_number_prefix.label_sortkey
								            FROM asset.copy
								            JOIN actor.org_unit ON actor.org_unit.id=asset.copy.circ_lib AND actor.org_unit.shortname = '$library'
								            JOIN asset.call_number ON asset.copy.call_number = asset.call_number.id AND asset.call_number.deleted = false
								            JOIN asset.call_number_prefix ON asset.call_number.prefix = asset.call_number_prefix.id
								            WHERE asset.copy.location IN $loc_string
								            AND asset.copy.deleted = false
							        	      AND asset.call_number_prefix.id != -1
								            ORDER BY asset.call_number_prefix.label_sortkey";
                  }
                  else
                  {

                     $prefix_sql = "SELECT DISTINCT asset.call_number_prefix.id, asset.call_number_prefix.label, asset.call_number_prefix.label_sortkey
											  FROM asset.copy
											  JOIN actor.org_unit ON actor.org_unit.id=asset.copy.circ_lib AND actor.org_unit.id IN
														(SELECT child.id
														 FROM actor.org_unit child
														 JOIN actor.org_unit parent on child.parent_ou = parent.id
														 WHERE parent.shortname='$library'
														 ORDER BY child.id)
											  JOIN asset.call_number ON asset.copy.call_number = asset.call_number.id AND asset.call_number.deleted = false
											  JOIN asset.call_number_prefix ON asset.call_number.prefix = asset.call_number_prefix.id
											  WHERE asset.copy.location IN $loc_string
											  AND asset.copy.deleted = false
											  AND asset.call_number_prefix.id != -1
											  ORDER BY asset.call_number_prefix.label_sortkey";
				   	}
               }

					$prefix_result = pg_query($eg_db, $prefix_sql);

					//if no results put none
					if (pg_num_rows($prefix_result) < 1)
					{
					   echo "NONE";
					}
					else
					{
						while ($row = pg_fetch_row($prefix_result))
						{
							$prefix_id = $row[0];
							$prefix_name = $row[1];

							echo "<input type=\"checkbox\" id=\"".$prefix_id."\" name=\"prefix_checkboxes[]\" value=\"".$prefix_id."\" class=\"multi_check\" ";

							if($prefix_filter && in_array($prefix_id, $prefix_arr))
							{
								echo " checked";
							}

							echo " /><label for=\"".$prefix_name."\" class=\"multi_cb_label\">".$prefix_name."</label><br/>\n";
						}
					}
         }
         else
         {
             echo "NONE\n";
         }
      ?>
     <br />
    </div>
    <span class ="clear_button">
      <input type="button"  value="Clear" onClick="ClearPrefix()"/>
   </span>
   </div>


   <div class="canned_new canned_shelf">
   <h3 class="weeding">Filter by Call Number Suffix  <span class="note"> (Optional) </span>
   <img src='../../shared/images/question-mark-small.png' class="help" onclick="JavaScript:swal('Call Number Suffix','Limit your search by selecting one or more Call Number Suffixes.  The list will only include Call Number Suffixes that are in records in the copy locations you selected.', 'info');"/> </h3>
      <div id="suffixes" class="scrolling_cb weeding">
      <?php
         if ($use_filters)
         {
               if ($suffix_filter) $suffix_arr =explode(",", $suffix);

               if ($use_db_id || $use_all_loc)
               {
							$suffix_sql = "SELECT asset.call_number_suffix.id, asset.call_number_suffix.label, asset.call_number_suffix.label_sortkey
						                  FROM asset.call_number_suffix
						                  JOIN actor.org_unit ON actor.org_unit.id=asset.call_number_suffix.owning_lib";
						  if ( $is_branch)
						  {
							  $suffix_sql .=" WHERE actor.org_unit.id = $parent_id OR actor.org_unit.shortname = '$library' ";
						  }
						  else
						  {
								$suffix_sql .=" WHERE actor.org_unit.id IN (SELECT child.id
														FROM actor.org_unit child
														JOIN actor.org_unit parent on child.parent_ou = parent.id
														WHERE parent.shortname='$library'
														ORDER BY child.id)
											OR actor.org_unit.shortname = '$library'";
						  }
						  $suffix_sql .= "ORDER BY asset.call_number_suffix.label_sortkey";


               }
               else
               {

                  if ($is_branch)
                  {
                     $suffix_sql = "SELECT DISTINCT asset.call_number_suffix.id, asset.call_number_suffix.label, asset.call_number_suffix.label_sortkey
								            FROM asset.copy
								            JOIN actor.org_unit ON actor.org_unit.id=asset.copy.circ_lib AND actor.org_unit.shortname = '$library'
								            JOIN asset.call_number ON asset.copy.call_number = asset.call_number.id AND asset.call_number.deleted = false
								            JOIN asset.call_number_suffix ON asset.call_number.suffix = asset.call_number_suffix.id
								            WHERE asset.copy.location IN $loc_string
								            AND asset.copy.deleted = false
							        	      AND asset.call_number_suffix.id != -1
								            ORDER BY asset.call_number_suffix.label_sortkey";
                  }
                  else
                  {

                     $suffix_sql = "SELECT DISTINCT asset.call_number_suffix.id, asset.call_number_suffix.label, asset.call_number_suffix.label_sortkey
											  FROM asset.copy
											  JOIN actor.org_unit ON actor.org_unit.id=asset.copy.circ_lib AND actor.org_unit.id IN
														(SELECT child.id
														 FROM actor.org_unit child
														 JOIN actor.org_unit parent on child.parent_ou = parent.id
														 WHERE parent.shortname='$library'
														 ORDER BY child.id)
											  JOIN asset.call_number ON asset.copy.call_number = asset.call_number.id AND asset.call_number.deleted = false
											  JOIN asset.call_number_suffix ON asset.call_number.suffix = asset.call_number_suffix.id
											  WHERE asset.copy.location IN $loc_string
											  AND asset.copy.deleted = false
											  AND asset.call_number_suffix.id != -1
											  ORDER BY asset.call_number_suffix.label_sortkey";
				   	}
               }

             	$suffix_result = pg_query($eg_db, $suffix_sql);

					//if no results put none
					if (pg_num_rows($suffix_result) < 1)
					{
					   echo "NONE";
					}
					else
					{

						while ($row = pg_fetch_row($suffix_result))
						{
							$suffix_id = $row[0];
							$suffix_name = $row[1];

							echo "<input type=\"checkbox\" id=\"".$suffix_id."\" name=\"suffix_checkboxes[]\" value=\"".$suffix_id."\" class=\"multi_check\" ";

							if($suffix_filter && in_array($suffix_id, $suffix_arr))
							{
								echo " checked";
							}

							echo " /><label for=\"".$suffix_name."\" class=\"multi_cb_label\">".$suffix_name."</label><br/>\n";
						}

					}
         }
         else
         {
             echo "NONE\n";
         }
      ?>
     <br />
    </div>
    <span class ="clear_button">
      <input type="button"  value="Clear" onClick="ClearSuffix()"/>
   </span>
   </div>

   <div class="canned_hide">
   <h3 class="weeding">Filter by Circ Modifier  <span class="note"> (Optional) </span>
   <img src='../../shared/images/question-mark-small.png' class="help" onclick="JavaScript:swal('Circ Modifier','Limit your search by selecting one or more Circ Modifiers.  The list will only include Circ Modifiers that are in records in the copy locations you selected.', 'info');"/> </h3>

    <div id="circ_mods" class="scrolling_cb weeding">
          <?php
         if ($use_filters)
         {
               if ($circ_mod_filter) $circ_mod_arr =explode(",", $circ_mod);

               if ($use_db_id || $use_all_loc)
               {
                  //this is a scheduled report use all statuses
                  $circ_mod_sql = "SELECT DISTINCT code
                                   FROM config.circ_modifier
                                   ORDER BY 1";

               }
               else
               {

				   	$circ_mod_sql = "SELECT DISTINCT asset.copy.circ_modifier
                                  FROM asset.copy
                                  JOIN actor.org_unit ON actor.org_unit.id=asset.copy.circ_lib  AND actor.org_unit.id IN
                                      (SELECT child.id
                                       FROM actor.org_unit child
                                       JOIN actor.org_unit parent on child.parent_ou = parent.id
                                       WHERE parent.shortname='$library' OR child.shortname='$library'
                                       ORDER BY child.id)
                            WHERE asset.copy.location IN $loc_string
                            AND asset.copy.deleted = false
                            AND asset.copy.circ_modifier IS NOT NULL
                            ORDER BY asset.copy.circ_modifier";
               }

					$circ_mod_result = pg_query($eg_db, $circ_mod_sql);

					if( pg_num_rows($circ_mod_result) < 1 )
					{
					   echo "NONE\n";
					}
					else
					{
						while ($row = pg_fetch_row($circ_mod_result))
						{
							$circ_mod_code = $row[0];

							echo "<input type=\"checkbox\" id=\"".$circ_mod_code."\" name=\"circ_mod_checkboxes[]\" value=\"".$circ_mod_code."\" class=\"multi_check\" ";

							if($circ_mod_filter && in_array($circ_mod_code, $circ_mod_arr))
							{
								echo " checked";
							}

							echo " /><label for=\"".$circ_mod_code."\" class=\"multi_cb_label\">".$circ_mod_code."</label><br/>\n";
						}
					}
         }
         else
         {
             echo "NONE\n";
         }
      ?>
     <br />
    </div>
    <span class ="clear_button">
      <input type="button"  value="Clear" onClick="ClearCircMod()"/>
   </span>
   </div>

   </span> <!-- end no-noble-->

    <h3 class="weeding">Filter by Item Tag <span class="note"> (Optional) </span>
    <img src='../../shared/images/question-mark-small.png' class="help" onclick="JavaScript:swal('Item Tag','Limit your search by selecting one or more item tags.', 'info');"/> </h3>
    <div id="copy_tag_text">

	   <?php
	      if ($copy_tag_filter)
	      {

	         $copy_tag_array = explode(",",$tags);

	         foreach($copy_tag_array as $tag)
	         {
                 //find the course words
                 $tag_sql = "SELECT config.copy_tag_type.label, asset.copy_tag.value
                             FROM asset.copy_tag
                             JOiN config.copy_tag_type ON config.copy_tag_type.code = asset.copy_tag.tag_type
                             WHERE asset.copy_tag.id = $tag ";

                 $tag_result = pg_query($eg_db, $tag_sql);
                 $tag_row = pg_fetch_row($tag_result);

                 $tag_words = $tag_row[0 ]."/".$tag_row[1];

				 echo "<span class =\"stat\">".$tag_words." <br /></span>\n";

             }

             echo "</div>";

	         echo "<input type=\"hidden\" id=\"tag_ids\" name=\"tag_ids\" value=\"".$tags."\"/>";

	      }
	      else
	      {
	   ?>
	        </div>
	        <input type="hidden" id="tag_ids" name="tag_ids"/>
	   <?php
	   }?>
	   <p class="weeding">
	   <a href="JavaScript:configureCopyTags()" class="copy_tags_link">Configure Item Tags</a>
	   </p>
   </div> <!-- end Item Attributes -->


  <div class="canned_hide no-preview no-noble">

   <h5 class="topic_section no-preview"> Activity   <hr class="topic_seperator"/> </h5>


  <h3 class="weeding">Filter by Circulation Count <span class="note"> (Optional)</span>
  <img src='../../shared/images/question-mark-small.png' class="help" onclick="JavaScript:swal('Circ Count','Limit your search by number of circulations of a copy.  ', 'info');"/> </h3>
   <p class="weeding">
      <input type="checkbox" id="use_circ_count" name="use_circ_count" value="use_circ_count" <?php if($circ_count != -1) echo  "checked"; ?> >
      <select name="circ_count_compare" id="circ_count_compare" class="stats">
         <option value="more" <?php if($circ_count != -1 && $circ_count_compare == "more") echo "selected";?> > More than </option>
         <option value="less" <?php if($circ_count != -1 && $circ_count_compare == "less") echo "selected";?>> Less than </option>
      </select>
      <input type="text" name="circ_count" id="circ_count" class="stats" size="3" onChange="JavaScript:SetCheckbox(this.value, 'use_circ_count')" <?php if($circ_count != -1) echo "value=\"".$circ_count."\""; ?>> in
      <select name="compare_date" id="compare_date" class="stats" onChange="JavaScript:UpdateSheetOptions(this.value)" >
         <option value=""> Select </option>
         <option value="lifetime" <?php if($circ_count != -1 && $circ_date_type == "none") echo "selected";?> > Lifetime Circs </option>
         <option value="circ_dates" <?php if($circ_count != -1 && $circ_date_type != "none") echo "selected";?>>Configurable Dates </option>
      </select>
   </p>
   </div>

  <div class="canned_hide no-preview no-noble">
  <span id="circ_dates">
  <h3 class="weeding">Filter by Circulation Date <span class="note"> (Optional)</span>
  <img src='../../shared/images/question-mark-small.png' class="help" onclick="JavaScript:swal('Circ Date','Limit your search to items that have circulated in this time period. NOTE: This only works on circulations since the migration to Evergreen on 5/26/2012. ', 'info');"/> </h3>
   <p class="weeding">
      <input type="checkbox" id="use_circ_dates" name="use_circ_dates" value="use_circ_dates" onChange="JavaScript:UpdateCircDates(this.checked)" <?php if ($circ_date_type !="none") echo "checked";?>>
      <select id="circ_date_type" name="circ_date_type" class="stats">
        <option value="absolute" <?php if($circ_date_type == "absolute") echo "selected"; ?>>Absolute</option>
        <option value="relative" <?php if($circ_date_type == "relative") echo "selected"; ?>  >Relative</option>
      </select>
      <label id="circ_date_label">Circulated </label>
         <select id ="circ_time_type" name="circ_time_type" class="stats">
           <option value="between" <?php if($circ_time_type == "between") echo "selected"; ?>>Between</option>
           <option value="before" <?php if($circ_time_type == "before") echo "selected"; ?> >Before</option>
           <option value="after" <?php if($circ_time_type == "after") echo "selected"; ?> >After</option>
        </select>

         <input type="text" name="circ_start" maxlength="10" size="10" id="circ_start" class="stats circ_absolute" onChange="JavaScript:SetCheckbox(this.value, 'use_circ_dates')" <?php if($circ_date_type == "absolute") echo "value=\"".$circ_date."\""; ?> >
         <input type="text" name="circ_start_relative" size="3" id="circ_start_relative"  class=" stats circ_relative" onChange="JavaScript:SetCheckbox(this.value, 'use_circ_dates')" <?php if($circ_date_type == "relative" ) echo "value=\"".$circ_value."\""; ?>>
         <select id="circ_start_time" name="circ_start_time"class="stats circ_relative">
           <option value="days" <?php if($circ_time == "days") echo "selected"; ?> >Days</option>
           <option value="weeks" <?php if($circ_time == "weeks") echo "selected"; ?> >Weeks</option>
           <option value="months" <?php if($circ_time == "months") echo "selected"; ?> >Months</option>
           <option value="years" <?php if($circ_time == "years") echo "selected"; ?> >Years</option>
         </select>
         <span class ="circ_between">and
         <input type="text" name="circ_end" maxlength="10" size="10" id="circ_end" class="stats circ_absolute " <?php if($circ_date_type == "absolute" && $circ_time_type == "between") echo "value=\"".$circ_date2."\""; ?>>
         <input type="text" name="circ_end_relative" size="3" id="circ_end_relative" class=" stats circ_relative " <?php if($circ_date_type == "relative" && $circ_time_type == "between") echo "value=\"".$circ_value2."\""; ?>>
         <select id="circ_end_time" name="circ_end_time" class="stats circ_relative">
            <option value="days" <?php if($circ_time2 == "days") echo "selected"; ?> >Days</option>
           <option value="weeks" <?php if($circ_time2 == "weeks") echo "selected"; ?> >Weeks</option>
           <option value="months" <?php if($circ_time2 == "months") echo "selected"; ?> >Months</option>
           <option value="years" <?php if($circ_time2 == "years") echo "selected"; ?> >Years</option>
         </select>
         </span>
         <label id="circ_label2" class="stats circ_relative"> ago</label>
   <br/>
   </p>
   </span>

  <div class="canned_hide no-preview no-noble">
  <span id="due_date">
  <h3 class="weeding">Filter by Due Date <span class="note"> (Optional)</span>
  <img src='../../shared/images/question-mark-small.png' class="help" onclick="JavaScript:swal('Due Date','Limit your search to items due within a certain period.', 'info');"/> </h3>
   <p class="weeding">
      <input type="checkbox" id="use_due_date" name="use_due_date" value="use_due_date" <?php if ($due_date_type !="none") echo "checked";?>>
      <select id="due_date_type" name="due_date_type" class="stats">
        <option value="absolute" <?php if($due_date_type == "absolute") echo "selected"; ?>>Absolute</option>
        <option value="relative" <?php if($due_date_type == "relative") echo "selected"; ?>  >Relative</option>
      </select>
      <label id="due_date_label">Due </label>
         <select id ="due_time_type" name="due_time_type" class="stats">
           <option value="between" <?php if($due_time_type == "between") echo "selected"; ?>>Between</option>
           <option value="before" <?php if($due_time_type == "before") echo "selected"; ?> >Before</option>
           <option value="after" <?php if($due_time_type == "after") echo "selected"; ?> >After</option>
        </select>

         <input type="text" name="due_start" maxlength="10" size="10" id="due_start" class="stats due_absolute" onChange="JavaScript:SetCheckbox(this.value, 'use_due_date')" <?php if($due_date_type == "absolute") echo "value=\"".$due_date."\""; ?> >
         <input type="text" name="due_start_relative" size="3" id="due_start_relative"  class=" stats due_relative" onChange="JavaScript:SetCheckbox(this.value, 'use_due_date')" <?php if($due_date_type == "relative" ) echo "value=\"".$due_value."\""; ?>>
         <select id="due_start_time" name="due_start_time"class="stats due_relative">
           <option value="days" <?php if($due_time == "days") echo "selected"; ?> >Days</option>
           <option value="weeks" <?php if($due_time == "weeks") echo "selected"; ?> >Weeks</option>
           <option value="months" <?php if($due_time == "months") echo "selected"; ?> >Months</option>
           <option value="years" <?php if($due_time == "years") echo "selected"; ?> >Years</option>
         </select>
         <span class ="due_between">and
         <input type="text" name="due_end" maxlength="10" size="10" id="due_end" class="stats due_absolute " <?php if($due_date_type == "absolute" && $due_time_type == "between") echo "value=\"".$due_date2."\""; ?>>
         <input type="text" name="due_end_relative" size="3" id="due_end_relative" class=" stats due_relative " <?php if($due_date_type == "relative" && $due_time_type == "between") echo "value=\"".$due_value2."\""; ?>>
         <select id="due_end_time" name="due_end_time" class="stats due_relative">
            <option value="days" <?php if($due_time2 == "days") echo "selected"; ?> >Days</option>
           <option value="weeks" <?php if($due_time2 == "weeks") echo "selected"; ?> >Weeks</option>
           <option value="months" <?php if($due_time2 == "months") echo "selected"; ?> >Months</option>
           <option value="years" <?php if($due_time2 == "years") echo "selected"; ?> >Years</option>
         </select>
         </span>
         <label id="due_label2" class="stats due_relative"> ago</label>
   <br/>
   </p>
   </span>
   </div>

  <div class="canned_hide no-preview no-noble">
  <h3 class="weeding">Filter by Hold Count <span class="note"> (Optional)</span>
  <img src='../../shared/images/question-mark-small.png' class="help" onclick="JavaScript:swal('Hold Count','Limit your search by number of holds of a copy.  ', 'info');"/> </h3>
   <p class="weeding">
      <input type="checkbox" id="use_hold_count" name="use_hold_count" value="use_hold_count" <?php if($hold_count != -1) echo  "checked"; ?> >
        More Than
      <input type="text" name="hold_count" id="hold_count" class="stats" size="3" onChange="JavaScript:SetCheckbox(this.value, 'use_hold_count')" <?php if($hold_count != -1) echo "value=\"".$hold_count."\""; ?>> in
      Holds at
      <select name="hold_loc" id="hold_loc" class="stats" onChange="JavaScript:UpdateSheetOptions(this.value)" >
         <option value=""> Select </option>
         <option value="my" <?php if($hold_count != -1 && $hold_loc == "my") echo "selected";?> > My Library </option>
         <option value="all" <?php if($hold_count != -1 && $hold_loc == "all") echo "selected";?>>All Libraries </option>
      </select>
   <br/>
   </p>
   </div>

   <div class="canned_hide no-preview no-noble">
  <span id="inventory_dates">
  <h3 class="weeding">Filter by Inventory Date <span class="note"> (Optional)</span>
  <img src='../../shared/images/question-mark-small.png' class="help" onclick="JavaScript:swal('Inventory Date','Limit your search to items that have been inventoried in this time period.', 'info');"/> </h3>
   <p class="weeding">
      <input type="checkbox" id="use_inventory_dates" name="use_inventory_dates" value="use_inventory_dates" <?php if ($inventory_date_type !="none" || $include_null_inventory) echo "checked";?>>
      <select id="inventory_date_type" name="inventory_date_type" class="stats">
        <option value="absolute" <?php if($inventory_date_type == "absolute") echo "selected"; ?>>Absolute</option>
        <option value="relative" <?php if($inventory_date_type == "relative") echo "selected"; ?>  >Relative</option>
      </select>
      <label id="inventory_date_label">Inventoried </label>
         <select id ="inventory_time_type" name="inventory_time_type" class="stats" onChange = "JavaScript:SetNoneCheckbox(this.value, 'use_inventory_dates')">
           <option value="between" <?php if($inventory_time_type == "between") echo "selected"; ?>>Between</option>
           <option value="before" <?php if($inventory_time_type == "before") echo "selected"; ?> >Before</option>
           <option value="after" <?php if($inventory_time_type == "after") echo "selected"; ?> >After</option>
           <option value="none" <?php if($include_null_inventory) echo "selected"; ?> >Does Not Have</option>
        </select>

         <span class = "inventory_start">
         <input type="text" name="inventory_start" maxlength="10" size="10" id="inventory_start" class="stats inventory_absolute" onChange="JavaScript:SetCheckbox(this.value, 'use_inventory_dates')" <?php if($inventory_date_type == "absolute") echo "value=\"".$inventory_date."\""; ?> >
         <input type="text" name="inventory_start_relative" size="3" id="inventory_start_relative"  class=" stats inventory_relative" onChange="JavaScript:SetCheckbox(this.value, 'use_inventory_dates')" <?php if($inventory_date_type == "relative" ) echo "value=\"".$inventory_value."\""; ?>>
         <select id="inventory_start_time" name="inventory_start_time"class="stats inventory_relative">
           <option value="days" <?php if($inventory_time == "days") echo "selected"; ?> >Days</option>
           <option value="weeks" <?php if($inventory_time == "weeks") echo "selected"; ?> >Weeks</option>
           <option value="months" <?php if($inventory_time == "months") echo "selected"; ?> >Months</option>
           <option value="years" <?php if($inventory_time == "years") echo "selected"; ?> >Years</option>
         </select>
         </span>

         <span class ="inventory_between">and
         <input type="text" name="inventory_end" maxlength="10" size="10" id="inventory_end" class="stats inventory_absolute " <?php if($inventory_date_type == "absolute" && $inventory_time_type == "between") echo "value=\"".$inventory_date2."\""; ?>>
         <input type="text" name="inventory_end_relative" size="3" id="inventory_end_relative" class=" stats inventory_relative " <?php if($inventory_date_type == "relative" && $inventory_time_type == "between") echo "value=\"".$inventory_value2."\""; ?>>
         <select id="inventory_end_time" name="inventory_end_time" class="stats inventory_relative">
            <option value="days" <?php if($inventory_time2 == "days") echo "selected"; ?> >Days</option>
           <option value="weeks" <?php if($inventory_time2 == "weeks") echo "selected"; ?> >Weeks</option>
           <option value="months" <?php if($inventory_time2 == "months") echo "selected"; ?> >Months</option>
           <option value="years" <?php if($inventory_time2 == "years") echo "selected"; ?> >Years</option>
         </select>
         </span>
         <label id="inventory_label2" class="stats inventory_relative"> ago</label>
   <br/>
      <span id ="null_inventory" class="include_null">
         <input type="checkbox" id="include_null_inventory" name="include_null_inventory" value="include_null_inventory" <?php if ($inventory_time_type == "before" && $include_null_inventory) echo "checked";?>> Include Items with No Inventory Date
      </span>
   </p>
   </span>

   </div>

   <div class="canned_hide no-preview ">

    <h5 class="topic_section"> Bibliographic Data     <hr class="topic_seperator"/></h5>


    <h3 class="weeding no-preview">Filter By Publication Year <span class="note"> (Optional) </span> </h3>
    <p class="weeding no-preview">
      <input type="checkbox" id="use_pub" name="use_pub" value="pub" <?php if ($pub_type !="none" || $include_null_pub_date) echo "checked";?>>
      <label id="pub_label">Published</label>
        <select id ="pub_time_type" class="stats" onChange = "JavaScript:SetNoneCheckbox(this.value, 'use_pub')">
         <option value="before" <?php if($pub_type == "before") echo "selected"; ?> >Before</option>
         <option value="after" <?php if($pub_type == "after") echo "selected"; ?> >After</option>
         <option value="between" <?php if($pub_type == "between") echo "selected"; ?> >Between</option>
         <option value="none" <?php if($include_null_pub_date) echo "selected"; ?> >Does Not Have</option>
        </select>
        <input type="text" name="pub_date" maxlength="4" size="4" id="pub_date" class="stats pub_start" oninput="JavaScript:SetCheckbox(this.value, 'use_pub')"  <?php if($pub_type != "none") echo "value=\"".$pub_date."\""; ?> >
        <label id="pub_label2" class="pub_between"> and </label>
        <input type="text" name="pub_date2" maxlength="4" size="4" id="pub_date2" class="stats pub_between" oninput="JavaScript:SetCheckbox(this.value, 'use_pub')" <?php if($pub_type == "between") echo "value=\"".$pub_date2."\""; ?> />
        <img src='../../shared/images/question-mark-small.png' class="help" onclick="JavaScript:swal('Pub Date','Enter the 4 digit year of last publication.', 'info');"/>
    <br/>
       <span id ="null_pub_date" class="include_null">
         <input type="checkbox" id="include_null_pub_date" name="include_null_pub_date" value="include_null_pub_date" <?php if ($pub_type == "before" && $include_null_pub_date) echo "checked";?>> Include Items with No Publication Date
      </span>
    </p>
    </div>

   <span class="no-noble">
   <div class="canned_hide">
   <h3 class="weeding no-preview">Filter By Only Holder <span class="note"> (Optional) </span>
   <img src='../../shared/images/question-mark-small.png' class="help" onclick="JavaScript:swal('Only HOlder','Limit your search based on whether or not your library is the only library in NOBLE that has items attached to the bib record.', 'info');"/></h3>
   <p class="weeding no-preview">
     <select id="only_holder" name="only_holder" class="stats no-preview" >
           <option value="all_items" <?php if($only_holder =="all") echo "selected";?> >All Items </option>
           <option value="true" <?php if($only_holder == "true") echo "selected";?> >Only Holder</option>
           <option value="false" <?php if($only_holder =="false") echo "selected";?>  >Not the Only Holder </option>
      </select>
    </p>
 </span>
 </div>
 </span> <!-- end no noble -->

</div>

<div class="canned_acq no-preview">

 <h5 class="topic_section canned_acq no-preview"> Acquisitions Data     <hr class="topic_seperator"/></h5>

<span id="order_dates">
  <h3 class="weeding">Filter by Order Date <span class="note"> (Optional)</span>
  <img src='../../shared/images/question-mark-small.png' class="help" onclick="JavaScript:swal('Order Date','Limit your search to items that have been ordered in this time period.', 'info');"/> </h3>
   <p class="weeding">
      <input type="checkbox" id="use_order_dates" name="use_order_dates" value="use_order_dates"  <?php if ($order_date_type !="none" || $include_null_order_date) echo "checked";?>>
      <select id="order_date_type" name="order_date_type" class="stats">
        <option value="absolute" <?php if($order_date_type == "absolute") echo "selected"; ?>>Absolute</option>
        <option value="relative" <?php if($order_date_type == "relative") echo "selected"; ?>  >Relative</option>
      </select>
      <label id="order_date_label">Ordered </label>
         <select id ="order_time_type" name="order_time_type" class="stats" onChange="JavaScript:SetNoneCheckbox(this.value, 'use_order_dates')">
           <option value="between" <?php if($order_time_type == "between") echo "selected"; ?>>Between</option>
           <option value="before" <?php if($order_time_type == "before") echo "selected"; ?> >Before</option>
           <option value="after" <?php if($order_time_type == "after") echo "selected"; ?> >After</option>
           <option value="none" <?php if($include_null_order_date) echo "selected"; ?> >Does Not Have</option>
        </select>

         <span class ="order_start">
         <input type="text" name="order_start" maxlength="10" size="10" id="order_start" class="stats order_absolute" onChange="JavaScript:SetCheckbox(this.value, 'use_order_dates')" <?php if($order_date_type == "absolute") echo "value=\"".$order_date."\""; ?> >
         <input type="text" name="order_start_relative" size="3" id="order_start_relative"  class=" stats order_relative" onChange="JavaScript:SetCheckbox(this.value, 'use_order_dates')" <?php if($order_date_type == "relative" ) echo "value=\"".$order_value."\""; ?>>
         <select id="order_start_time" name="order_start_time"class="stats order_relative">
           <option value="days" <?php if($order_time == "days") echo "selected"; ?> >Days</option>
           <option value="weeks" <?php if($order_time == "weeks") echo "selected"; ?> >Weeks</option>
           <option value="months" <?php if($order_time == "months") echo "selected"; ?> >Months</option>
           <option value="years" <?php if($order_time == "years") echo "selected"; ?> >Years</option>
         </select>
         </span>

         <span class ="order_between">and
         <input type="text" name="order_end" maxlength="10" size="10" id="order_end" class="stats order_absolute " <?php if($order_date_type == "absolute" && $order_time_type == "between") echo "value=\"".$order_date2."\""; ?>>
         <input type="text" name="order_end_relative" size="3" id="order_end_relative" class=" stats order_relative " <?php if($order_date_type == "relative" && $order_time_type == "between") echo "value=\"".$order_value2."\""; ?>>
         <select id="order_end_time" name="order_end_time" class="stats order_relative">
            <option value="days" <?php if($order_time2 == "days") echo "selected"; ?> >Days</option>
           <option value="weeks" <?php if($order_time2 == "weeks") echo "selected"; ?> >Weeks</option>
           <option value="months" <?php if($order_time2 == "months") echo "selected"; ?> >Months</option>
           <option value="years" <?php if($order_time2 == "years") echo "selected"; ?> >Years</option>
         </select>
         </span>
         <label id="order_label2" class="stats order_relative"> ago</label>
   <br/>
   </p>
   </span>

  <span id="invoice_dates">
  <h3 class="weeding">Filter by Invoice Date <span class="note"> (Optional)</span>
  <img src='../../shared/images/question-mark-small.png' class="help" onclick="JavaScript:swal('Invoice Date','Limit your search to items that have been invoiced in this time period.', 'info');"/> </h3>
   <p class="weeding">
      <input type="checkbox" id="use_invoice_dates" name="use_invoice_dates" value="use_invoice_dates" <?php if ($invoice_date_type !="none") echo "checked";?>>
      <select id="invoice_date_type" name="invoice_date_type" class="stats">
        <option value="absolute" <?php if($invoice_date_type == "absolute") echo "selected"; ?>>Absolute</option>
        <option value="relative" <?php if($invoice_date_type == "relative") echo "selected"; ?>  >Relative</option>
      </select>
      <label id="invoice_date_label">Invoiced </label>
         <select id ="invoice_time_type" name="invoice_time_type" class="stats">
           <option value="between" <?php if($invoice_time_type == "between") echo "selected"; ?>>Between</option>
           <option value="before" <?php if($invoice_time_type == "before") echo "selected"; ?> >Before</option>
           <option value="after" <?php if($invoice_time_type == "after") echo "selected"; ?> >After</option>
        </select>

         <input type="text" name="invoice_start" maxlength="10" size="10" id="invoice_start" class="stats invoice_absolute" onChange="JavaScript:SetCheckbox(this.value, 'use_invoice_dates')" <?php if($invoice_date_type == "absolute") echo "value=\"".$invoice_date."\""; ?> >
         <input type="text" name="invoice_start_relative" size="3" id="invoice_start_relative"  class=" stats invoice_relative" onChange="JavaScript:SetCheckbox(this.value, 'use_invoice_dates')" <?php if($invoice_date_type == "relative" ) echo "value=\"".$invoice_value."\""; ?>>
         <select id="invoice_start_time" name="invoice_start_time"class="stats invoice_relative">
           <option value="days" <?php if($invoice_time == "days") echo "selected"; ?> >Days</option>
           <option value="weeks" <?php if($invoice_time == "weeks") echo "selected"; ?> >Weeks</option>
           <option value="months" <?php if($invoice_time == "months") echo "selected"; ?> >Months</option>
           <option value="years" <?php if($invoice_time == "years") echo "selected"; ?> >Years</option>
         </select>
         <span class ="invoice_between">and
         <input type="text" name="invoice_end" maxlength="10" size="10" id="invoice_end" class="stats invoice_absolute " <?php if($invoice_date_type == "absolute" && $invoice_time_type == "between") echo "value=\"".$invoice_date2."\""; ?>>
         <input type="text" name="invoice_end_relative" size="3" id="invoice_end_relative" class=" stats invoice_relative " <?php if($invoice_date_type == "relative" && $invoice_time_type == "between") echo "value=\"".$invoice_value2."\""; ?>>
         <select id="invoice_end_time" name="invoice_end_time" class="stats invoice_relative">
            <option value="days" <?php if($invoice_time2 == "days") echo "selected"; ?> >Days</option>
           <option value="weeks" <?php if($invoice_time2 == "weeks") echo "selected"; ?> >Weeks</option>
           <option value="months" <?php if($invoice_time2 == "months") echo "selected"; ?> >Months</option>
           <option value="years" <?php if($invoice_time2 == "years") echo "selected"; ?> >Years</option>
         </select>
         </span>
         <label id="invoice_label2" class="stats invoice_relative"> ago</label>
   <br/>
   </p>
   </span>

 <span id="invoice_dates">
  <h3 class="weeding">Filter by Invoice Closed Date <span class="note"> (Optional)</span>
  <img src='../../shared/images/question-mark-small.png' class="help" onclick="JavaScript:swal('Invoice Date','Limit your search to items that have had their invoiced closed in this time period.', 'info');"/> </h3>
   <p class="weeding">
      <input type="checkbox" id="use_invoice_closed_dates" name="use_invoice_closed_dates" value="use_invoice_closed_dates" <?php if ($invoice_closed_date_type !="none" || $include_null_invoice_closed) echo "checked";?>>
      <select id="invoice_closed_date_type" name="invoice_closed_date_type" class="stats">
        <option value="absolute" <?php if($invoice_closed_date_type == "absolute") echo "selected"; ?>>Absolute</option>
        <option value="relative" <?php if($invoice_closed_date_type == "relative") echo "selected"; ?>  >Relative</option>
      </select>
      <label id="invoice_closed_date_label">Invoice Closed </label>
         <select id ="invoice_closed_time_type" name="invoice_closed_time_type" class="stats"  onChange="JavaScript:SetNoneCheckbox(this.value, 'use_invoice_closed_dates')">
           <option value="between" <?php if($invoice_closed_time_type == "between") echo "selected"; ?>>Between</option>
           <option value="before" <?php if($invoice_closed_time_type == "before") echo "selected"; ?> >Before</option>
           <option value="after" <?php if($invoice_closed_time_type == "after") echo "selected"; ?> >After</option>
           <option value="none" <?php if($include_null_invoice_closed) echo "selected"; ?> >Does Not Have</option>
        </select>

        <span class="invoice_closed_start">
         <input type="text" name="invoice_closed_start" maxlength="10" size="10" id="invoice_closed_start" class="stats invoice_closed_absolute" onChange="JavaScript:SetCheckbox(this.value, 'use_invoice_closed_dates')" <?php if($invoice_closed_date_type == "absolute") echo "value=\"".$invoice_closed_date."\""; ?> >
         <input type="text" name="invoice_closed_start_relative" size="3" id="invoice_closed_start_relative"  class=" stats invoice_closed_relative" onChange="JavaScript:SetCheckbox(this.value, 'use_invoice_closed_dates')" <?php if($invoice_closed_date_type == "relative" ) echo "value=\"".$invoice_closed_value."\""; ?>>
         <select id="invoice_closed_start_time" name="invoice_closed_start_time"class="stats invoice_closed_relative">
           <option value="days" <?php if($invoice_closed_time == "days") echo "selected"; ?> >Days</option>
           <option value="weeks" <?php if($invoice_closed_time == "weeks") echo "selected"; ?> >Weeks</option>
           <option value="months" <?php if($invoice_closed_time == "months") echo "selected"; ?> >Months</option>
           <option value="years" <?php if($invoice_closed_time == "years") echo "selected"; ?> >Years</option>
         </select>
         </span>
         <span class ="invoice_closed_between">and
         <input type="text" name="invoice_closed_end" maxlength="10" size="10" id="invoice_closed_end" class="stats invoice_closed_absolute " <?php if($invoice_closed_date_type == "absolute" && $invoice_closed_time_type == "between") echo "value=\"".$invoice_closed_date2."\""; ?>>
         <input type="text" name="invoice_closed_end_relative" size="3" id="invoice_closed_end_relative" class=" stats invoice_closed_relative " <?php if($invoice_closed_date_type == "relative" && $invoice_closed_time_type == "between") echo "value=\"".$invoice_closed_value2."\""; ?>>
         <select id="invoice_closed_end_time" name="invoice_closed_end_time" class="stats invoice_closed_relative">
            <option value="days" <?php if($invoice_closed_time2 == "days") echo "selected"; ?> >Days</option>
           <option value="weeks" <?php if($invoice_closed_time2 == "weeks") echo "selected"; ?> >Weeks</option>
           <option value="months" <?php if($invoice_closed_time2 == "months") echo "selected"; ?> >Months</option>
           <option value="years" <?php if($invoice_closed_time2 == "years") echo "selected"; ?> >Years</option>
         </select>
         </span>
         <label id="invoice_closed_label2" class="stats invoice_closed_relative"> ago</label>
   <br/>
       <span id ="null_invoice_closed" class="include_null">
         <input type="checkbox" id="include_null_invoice_closed" name="include_null_invoice_closed" value="include_null_invoice_closed" <?php if ($invoice_closed_time_type == "before" && $include_null_invoice_closed) echo "checked";?>> Include Items with No Invoice Closed Date
      </span>
   </p>
   </span>



   <h3 class="weeding">Filter by Lineitem Status  <span class="note"> (Optional) </span>
   <img src='../../shared/images/question-mark-small.png' class="help" onclick="JavaScript:swal('Lineitem Status','Filter by items with a certain line items status.', 'info');"/></h3>
    <div id="lineitem_status" class="scrolling_li_stat_cb weeding">
     <?php

         if ($line_item_status_filter) $line_item_status_array =explode(",", $line_item_status);

         $possible_line_item_status = array("cancelled", "on-order", "pending-order", "received");

         foreach ($possible_line_item_status as $li_status)
         {
				if ($li_status == "cancelled") $li_status_label = "cancelled (includes backordered)";
				else 	$li_status_label = $li_status;
			   echo "<input type=\"checkbox\" id=\"".$li_status."\" name=\"line_item_status_checkboxes[]\" value=\"".$li_status."\" class=\"multi_check\" ";

			   if($line_item_status_filter && in_array($li_status, $line_item_status_array)) echo " checked";

			   echo " /><label for=\"".$li_status."\" class=\"multi_cb_label\">".$li_status_label."</label><br/>\n";
			}
         ?>
     <br />
    </div>
    <span class ="clear_button">
      <input type="button"  value="Clear" onClick="ClearLineItemStatus()"/>
   </span>

    <h3 class="weeding">Filter by Fund <span class="note"> (Optional) </span>
   <img src='../../shared/images/question-mark-small.png' class="help" onclick="JavaScript:swal('Fund','Limit your search by selecting one or more Funds used to buy the item.', 'info');"/> </h3>
   <div id="fund_text">

	   <?php
	      if ($fund_filter)
	      {
	         //for each set

	         $fund_array = explode("*",$fund_list);

	         foreach($fund_array as $fund)
	         {
	            if (strlen($fund) < 2 ) continue;

					//get the words for selected stat cat
				   $fund_sql = "SELECT acq.fund.id, acq.fund.name, acq.fund.year
							       FROM acq.fund
							       WHERE acq.fund.id = $fund";
					$fund_result = pg_query($eg_db, $fund_sql);

					$fund_row = pg_fetch_row($fund_result);

				   echo "<span class =\"fund\">".$fund_row[2]."/".$fund_row[1]."<br /></span>\n";
             }

             echo "</div>";

	          echo "<input type=\"hidden\" id=\"funds\" name=\"funds\" value=\"".$fund_list."\"/>";

	      }
	      else
	      {
	   ?>
	        </div>
	        <input type="hidden" id="funds" name="funds"/>
	   <?php
	   }?>
	   <p class="weeding">
	   <a href="JavaScript:configureFunds()" class="fund_link">Configure Funds</a>
	   </p>

   </div> <!-- Acqusitions -->

   <div class="no-preview no-noble course_section">

   <h5 class="topic_section"> Course Reserves     <hr class="topic_seperator"/></h5>

    <h3 class="weeding">Filter by Course <span class="note"> (Optional) </span>
    <img src='../../shared/images/question-mark-small.png' class="help" onclick="JavaScript:swal('Course','Limit your search by selecting one or more courses.', 'info');"/> </h3>
    <div id="course_text">

	   <?php
	      if ($use_course)
	      {
	         //for each set

	         $course_array = explode("*",$course_list);

	         foreach($course_array as $course)
	         {
                 if (strlen($course) < 2 ) continue;
	             $open_paren = strpos($course,"(");
                 $curr_term = substr($course, 0, $open_paren);
                 $curr_course = trim(substr($course, $open_paren+1), ")");

				 $term_sql = "SELECT  asset.course_module_term.id, asset.course_module_term.name
			                  FROM asset.course_module_term
                              WHERE id = $curr_term ";

                 $term_result = pg_query($eg_db, $term_sql);
                 $term_row = pg_fetch_row($term_result);

                 $term_words = $term_row[1];

                 //find the course words
                 $course_sql = "SELECT DISTINCT asset.course_module_course.id, asset.course_module_course.name, asset.course_module_course.course_number, asset.course_module_course.section_number
                               FROM asset.course_module_course
                               WHERE asset.course_module_course.id = $curr_course ";

                 $course_result = pg_query($eg_db, $course_sql);
                 $course_row = pg_fetch_row($course_result);

                 if (strlen($course_row[3]) > 0) $course_words = $course_row[2]."-".$course_row[3].":".$course_row[1];
                 else  $course_words = $course_row[2].":".$course_row[1];

				  echo "<span class =\"stat\">".$term_words." / ".$course_words." <br /></span>\n";


             }

             echo "</div>";

	         echo "<input type=\"hidden\" id=\"course\" name=\"course\" value=\"".$course_list."\"/>";

	      }
	      else
	      {
	   ?>
	        </div>
	        <input type="hidden" id="course" name="course"/>
	   <?php
	   }?>
	   <p class="weeding">
	   <a href="JavaScript:configureCourses()" class="course_link">Configure Courses</a>
	   </p>

   </div> <!-- Course Reserves -->

</div>


   <h2> Choose and Configure Your Output:  <hr /><br/>
   <span class="note"> Click the gear icon <img src='https://ocean.noblenet.org/shared/images/gear.png' class="help" /> to change output settings.</span></h2>

   <div id="multiple_output">

   <table class="output">

     <thead>
     <tr>
       <th class="first">
         <input type="checkbox" id="html" name="html" onchange="JavaScript:AllowEmailOptOut()" <?php if($use_html) echo "checked";?>/>
         <label id="html_label"> HTML </label>
         <a href="JavaScript:configureHTML()" class="stat_link"><img src='https://ocean.noblenet.org/shared/images/gear.png' class="help" /><span class="configure">Configure</span></a>
       </th>
       <th>
        <input type="checkbox" id="spreadsheet" name="spreadsheet" onchange="JavaScript:SetCircDates(this.checked)"  <?php if($use_spreadsheet)  echo "checked";?>/>
        <label id="spreadsheet_label"> Spreadsheet </label>
         <a href="JavaScript:configureSpreadsheet()" class="stat_link"><img src='https://ocean.noblenet.org/shared/images/gear.png' class="help" /><span class="configure">Configure</span></a>
       </th>
       <th>
        <input type="checkbox" id="bookbag" name="bookbag"  onchange="JavaScript:AllowEmailOptOut()" <?php if($use_bookbag)  echo "checked";?>/>
        <label id="bookbag_label"> Bookbag/Bucket </label>
         <a href="JavaScript:configureBookbag()" class="stat_link"><img src='https://ocean.noblenet.org/shared/images/gear.png' class="help" /><span class="configure">Configure</span></a>
      </th>
      <th>
        <input type="checkbox" id="copy_bucket" name="copy_bucket"  onchange="JavaScript:AllowEmailOptOut()" <?php if($use_copy_bucket)  echo "checked";?>/>
        <label id="bookbag_label"> Item Bucket </label>
         <a href="JavaScript:configureCopyBucket()" class="stat_link"><img src='https://ocean.noblenet.org/shared/images/gear.png' class="help" /><span class="configure">Configure</span></a>
      </th>
      <th>
        <input type="checkbox" id="json" name="json"  onchange="JavaScript:SetRunNow(this.checked)" <?php if($use_json)  echo "checked";?>/>
        <label id="json_label"> JSON </label>
        <a href="JavaScript:configureJSON()" class="stat_link"><img src='https://ocean.noblenet.org/shared/images/gear.png' class="help" /><span class="configure">Configure</span></a>
      </th>
       <th>
        <input type="checkbox" id="rss" name="rss" onchange="JavaScript:SetCircDates(this.checked)" <?php if($use_rss)  echo "checked";?>/>
        <label id="rss_label"> RSS </label>
         <a href="JavaScript:configureRSS()" class="stat_link"><img src='https://ocean.noblenet.org/shared/images/gear.png' class="help" /><span class="configure">Configure</span></a>
      </th>
     </tr>
     </thead>

    <tbody>
     <tr>
        <td class="first">
           <div id="html_config">
              <table class="output_config">
                <tbody>
                  <tr>
                     <td style='width: 30%;'>Order By: </td>
                      <?php
                        if ($use_html && strlen($html_order) > 0)
                        {
                            echo "<td id=\"html_order\" style='width: 70%;'>".$html_order."</td>\n";
                        }
                        else
                        {
                           echo "<td id=\"html_order\" style='width: 70%;'>Call Number</td>\n";
                        }
                     ?>

                  </tr>

                  <tr>
                     <td>Display: </td>
                     <td id="html_display">
                        <ul>
                        <?php
                             if ($use_html && strlen($html_display) > 0)
                             {
                                 echo $html_display;
                             }
                             else
                             {
                          ?>
                          <li>Author</li>
                          <li>Call Number</li>
                          <li>Cover Image</li>
                          <li>Title</li>
                          <?php
                          }
                          ?>
                        </ul>
                     </td>
                  </tr>

                  <tr>
                     <td>Layout: </td>
                     <?php
                     if($use_html && strlen($html_layout) > 0)
                     {
                        echo "<td id=\"html_layout\">".$html_layout."</td>\n";
                     }
                     else
                     {
                        echo "<td id=\"html_layout\">Block</td>\n";
                     }
                     ?>
                  </tr>

                   <tr>
                     <td>Options: </td>
                     <td id="html_options">
                        <ul>
                        <?php
                             if ($use_html && strlen($html_options) > 0)
                             {
                                 echo $html_options;
                             }
                             else
                             {
                          ?>
                          <li>Group Items First</li>
                          <li>Image Size Medium </li>
                          <li>WordPress </li>
                          <?php
                          }
                          ?>
                        </ul>
                     </td>
                  </tr>

                 </tbody>
               </table>
           </div>
        </td>

        <td>
           <div id="spreadsheet_config">
            <table class="output_config">
                <tbody>

                  <tr>
                     <td style='width: 32%;'>Order By: </td>
                     <?php
                        if ($use_spreadsheet && strlen($sheet_order) > 0)
                        {
                            echo "<td id=\"spreadsheet_order\" style='width: 68%;'>".$sheet_order."</td>\n";
                        }
                        else
                        {
                           echo "<td id=\"spreadsheet_order\" style='width: 68%;'>Call Number</td>\n";
                        }
                     ?>

                  </tr>

                  <tr>
                     <td>Display: </td>
                     <td id="spreadsheet_display">
                        <ul>
                          <?php
                             if ($use_spreadsheet && strlen($sheet_display) > 0)
                             {
                                 echo $sheet_display;
                                 if ($circ_date_type !="none") echo " <li>Circs in Selected Dates</li>";
                             }
                             else
                             {
                          ?>
                          <li>Author</li>
                          <li>Barcode</li>
                          <li>Bib Id</li>
                          <li>Call Number</li>
                          <li>Shelving Location</li>
                          <li>Last Checkin</li>
                          <li>Lifetime Circs</li>
                          <li>Only Holder</li>
                          <li>Part</li>
                          <li>Prefix</li>
                          <li>Pub Date</li>
                          <li>Suffix</li>
                          <li>Title</li>
                          <?php
                          }
                          ?>
                        </ul>
                     </td>
                  </tr>

                  <tr>
                     <td>File Format: </td>
                     <?php
                        if ($use_spreadsheet && strlen($sheet_format) > 0)
                        {
                            echo "<td id=\"spreadsheet_format\">".$sheet_format."</td>\n";
                        }
                        else
                        {
                           echo "<td id=\"spreadsheet_format\"> Excel </td>\n";
                        }
                     ?>

                  </tr>

                   <tr>
                     <td>Options: </td>
                     <td id="spreadsheet_options">
                     <?php
                        if ($use_spreadsheet)
                        {
                           if (strlen($sheet_options) > 0) echo "<ul>\n".$sheet_options."\n</ul>\n";
                        }
                        else
                        {
                           echo "<ul><li>Item Sheet</li></ul>\n";
                           echo "<ul><li>Count Sheet</li></ul>\n";
                        }
                     ?>
                     </td>
                  </tr>

                 </tbody>
               </table>
           </div>
        </td>

        <td>
           <div id="bookbag_config">
               <table class="output_config">
                <tbody>

                <tr>
                    <td> Bookbag Update: </td>
                    <td id="bookbag_update">
                    <?php
                        if ($use_bookbag)
                        {
                           echo $bookbag_update;
                        }
                        else
                        {
                     ?>
                      <span class="unset">new</span>
                       <?php
                      }
                    ?>
                    </td>
                  </tr>

                   <tr>
                    <td> Bookbag Name: </td>
                    <td id="bookbag_name">
                      <?php
                        if ($use_bookbag && strlen($bookbag_name) > 0)
                        {
                           echo $bookbag_name;
                        }
                        else
                        {
                     ?>
                      <span class="unset">Not Set</span>
                       <?php
                      }
                    ?>
                    </td>
                  </tr>

                   <tr>
                    <td> Bookbag Desc: </td>
                    <td id="bookbag_description">
                    <?php
                        if ($use_bookbag && strlen($bookbag_desc) > 0 && $bookbag_desc != "none")
                        {
                           echo $bookbag_desc;
                        }
                        else
                        {
                     ?>
                      <span class="unset">Not Set</span>
                       <?php
                      }
                    ?>
                    </td>
                  </tr>

                  <tr>
                    <td> Bookbag Owner: </td>
                    <td id="bookbag_owner">
                    <?php
                        if ($use_bookbag && $bookbag_update == "new")
                        {
                           echo $bookbag_owner;
                        }
                        else
                        {
                     ?>
                      <span class="unset">Not Set</span>
                       <?php
                      }
                    ?>
                    </td>
                  </tr>

                   <tr>
                    <td> Bookbag Id: </td>
                    <td id="bookbag_id">
                    <?php
                        if ($use_bookbag && $bookbag_update != "new")
                        {
                           echo $bookbag_id;
                        }
                        else
                        {
                     ?>
                      <span class="unset">Not Set</span>
                       <?php
                      }
                    ?>
                    </td>
                  </tr>

                  <tr>
                    <td> Carousel: </td>
                    <td id="make_carousel">
                    <?php
                        if ($use_bookbag && $make_carousel)
                        {
                           echo "yes";
                        }
                        else
                        {
                     ?>
                        <span class="unset">no </span>
                       <?php
                      }
                    ?>
                    </td>
                  </tr>

                 </tbody>
               </table>
           </div>
        </td>

        <td>
           <div id="copy_bucket_config">
               <table class="output_config">
                <tbody>

                 <tr>
                    <td> Item Bucket Update: </td>
                    <td id="copy_bucket_update">
                    <?php
                        if ($use_copy_bucket)
                        {
                           echo $copy_bucket_update;
                        }
                        else
                        {
                     ?>
                      <span class="unset">new</span>
                       <?php
                      }
                    ?>
                    </td>
                  </tr>

                   <tr>
                    <td> Bucket Name: </td>
                    <td id="copy_bucket_name">
                      <?php
                        if ($use_copy_bucket && strlen($copy_bucket_name) > 0)
                        {
                           echo $copy_bucket_name;
                        }
                        else
                        {
                     ?>
                      <span class="unset">Not Set</span>
                       <?php
                      }
                    ?>
                    </td>
                  </tr>

                   <tr>
                    <td> Item Bucket Desc: </td>
                    <td id="copy_bucket_description">
                    <?php
                        if ($use_copy_bucket && strlen($copy_bucket_desc) > 0 && $copy_bucket_desc != "none")
                        {
                           echo $copy_bucket_desc;
                        }
                        else
                        {
                     ?>
                      <span class="unset">Not Set</span>
                       <?php
                      }
                    ?>
                    </td>
                  </tr>


                  <tr>
                    <td> Item Bucket Owner: </td>
                    <td id="copy_bucket_owner">
                    <?php
                        if ($use_copy_bucket && $copy_bucket_update == "new")
                        {
                           echo $copy_bucket_owner;
                        }
                        else
                        {
                     ?>
                      <span class="unset">Not Set</span>
                       <?php
                      }
                    ?>
                    </td>
                  </tr>

                   <tr>
                    <td> Item Bucket Id: </td>
                    <td id="copy_bucket_id">
                    <?php
                        if ($use_copy_bucket && $copy_bucket_update != "new")
                        {
                           echo $copy_bucket_id;
                        }
                        else
                        {
                     ?>
                      <span class="unset">Not Set</span>
                       <?php
                      }
                    ?>
                    </td>
                  </tr>

                 </tbody>
               </table>
           </div>
        </td>

         <td>
           <div id="json_config">
               <table class="output_config">
               <tbody>
                  <tr>
                     <td style='width: 40%;'>Type: </td>
                     <td id="json_type" style='width: 60%;'>WordPress</td>
                  </tr>
                  <tr>
                     <td style='width: 40%;'>Data Type: </td>
                     <td id="json_data_type" style='width: 60%;'>
                     <?php
                        if ($use_json) echo $json_data_type;
                        else echo "ISBN";
                     ?>
                     </td>
                  </tr>
               </tbody>
               </table>
            </div>
            </td>

        <td>
           <div id="rss_config">
               <table class="output_config">
                <tbody>
                  <tr>
                     <td style='width: 40%;'>Order By: </td>
                     <td id="rss_order" style='width: 60%;'>Title</td>
                  </tr>

                  <tr>
                     <td>Display: </td>
                     <td id="rss_display">
                        <ul>
                          <li>Title</li>
                          <li>Description</li>
                        </ul>
                     </td>
                  </tr>

                   <tr>
                    <td> RSS List Name: </td>
                    <td id="rss_list">
                      <?php
                        if ($use_rss && strlen($rss_list) > 0)
                        {
                           echo $rss_list;
                        }
                        else
                        {
                     ?>
                      <span class="unset">Not Set</span>
                       <?php
                      }
                    ?>
                    </td>
                  </tr>

                   <tr>
                    <td> RSS Desc: </td>
                    <td id="rss_description">
                    <?php
                        if ($use_rss && strlen($rss_desc) > 0)
                        {
                           echo $rss_desc;
                        }
                        else
                        {
                     ?>
                      <span class="unset">Not Set</span></td>
                       <?php
                      }
                    ?>
                    </td>
                  </tr>
                 </tbody>
               </table>
           </div>
        </td>

     </tr>

    </tbody>
   </table>

   </div>

   <input type = "hidden" name="input_bag_id" id = "input_bag_id" <?php if ($use_bookbag) echo "value=\"".$bookbag_id."\"";?> >
   <input type = "hidden" name="input_copy_bucket_id" id = "input_copy_bucket_id" <?php if ($use_copy_bucket) echo "value=\"".$copy_bucket_id."\"";?> >
   <input type = "hidden" name="input_carousel" id = "input_carousel" <?php if ($use_bookbag) echo "value=\"".$make_carousel."\"";?>  >

   <div id="preview_output">
     <input type="hidden" name="preview_text" id="preview_text" value="html call_sort author call_num cover title block group_copy 1 image_size medium" disabled>

     <table class="preview">
     <thead>
       <th>
        <label id="preview_label"> Preview </label>
         <a href="JavaScript:configurePreview()" class="stat_link"><img src='https://ocean.noblenet.org/shared/images/gear.png' class="help" /><span class="configure">Configure</span></a>
      </th>
     </thead>
       <tr>
        <td>
           <div id="preview_config">  <table class="output_config">
			 <tbody>
				<tr>
					<td style='width: 30%;'>Order By: </td>
					<td id="preview_order" style='width: 70%;'> Call Number </td>
				</tr>

				<tr>
					<td>Display: </td>
					<td id="preview_display">
						<ul>
						  <li> Author </li>
						  <li> Call Number </li>
						  <li> Cover Image </li>
						  <li> Title </li>
						</ul>
					</td>
				</tr>

				<tr>
					<td>Layout: </td>
					<td id="preview_layout"> Block </td>
				</tr>

				 <tr>
					<td>Options: </td>
					<td id="preview_options">
						<ul>
						  <li> Group Items First</li>
						  <li> Image Size Medium </li>
						</ul>
					</td>
				</tr>

			  </tbody>
			</table>
   </div>
        </td>
     </tr>
   </table>
   </div>

   <p class="weeding">
    <input type="checkbox" id="scope_links" name="scope_links" <?php if($use_scope)  echo "checked";?> />
    <label id="scope_label"> Scope links to my Library </label><br/>

    <span class="noble-only">
    <input type="checkbox" id="use_domain" name="use_domain"  <?php if($domain !="none")  echo "checked";?> />
     <label id="domain_label"> Use Subdomain  </label>
       <select name="domain" id="domain" class="stats" onchange="JavaScript:SetCheckbox(this.value, 'use_domain')">
         <option value="NOBLE">Select</option>
         <option value="BEVERLY" <?php if($domain =="BEVERLY") echo "selected";?> >Beverly</option>
         <option value="BUNKERHILL" <?php if($domain =="BUNKERHILL") echo "selected";?>>Bunker Hill</option>
         <option value="DANVERS" <?php if($domain =="DANVERS") echo "selected";?>>Danvers</option>
         <option value="ENDICOTT" <?php if($domain =="ENDICOTT") echo "selected";?>>Endicott</option>
         <option value="EVERETT" <?php if($domain =="EVERETT") echo "selected";?>>Everett</option>
         <option value="GLOUCESTER" <?php if($domain =="GLOUCESTER") echo "selected";?>>Gloucester</option>
         <option value="GORDON" <?php if($domain =="GORDON") echo "selected";?>>Gordon</option>
         <option value="LYNN" <?php if($domain =="LYNN") echo "selected";?>>Lynn</option>
         <option value="LYNNFIELD" <?php if($domain =="LYNNFIELD") echo "selected";?>>Lynnfield</option>
         <option value="MARBLEHEAD" <?php if($domain =="MARBLEHEAD") echo "selected";?>>Marblehead</option>
         <option value="BOARD" <?php if($domain =="BOARD") echo "selected";?>>MBLC Library</option>
         <option value="MELROSE" <?php if($domain =="MELROSE") echo "selected";?>>Melrose</option>
         <option value="MERRIMACK" <?php if($domain =="MERRIMACK") echo "selected";?>>Merrimack</option>
         <option value="MONTSERRAT" <?php if($domain =="MONTSERRAT") echo "selected";?>>Montserrat</option>
         <option value="PEABODY" <?php if($domain =="PEABODY") echo "selected";?>>Peabody</option>
         <option value="PHILLIPS" <?php if($domain =="PHILLIPS") echo "selected";?>>Phillips</option>
         <option value="READING" <?php if($domain =="READING") echo "selected";?>>Reading</option>
         <option value="REVERE" <?php if($domain =="REVERE") echo "selected";?>>Revere</option>
         <option value="SALEM" <?php if($domain =="SALEM") echo "selected";?>>Salem</option>
         <option value="SALEMSTATE" <?php if($domain =="SALEMSTATE") echo "selected";?>>Salem State</option>
         <option value="SAUGUS" <?php if($domain =="SAUGUS") echo "selected";?>>Saugus</option>
         <option value="STONEHAM" <?php if($domain =="STONEHAM") echo "selected";?>>Stoneham</option>
         <option value="SWAMPSCOTT" <?php if($domain =="SWAMPSCOTT") echo "selected";?>>Swampscott</option>
         <option value="WAKEFIELD" <?php if($domain =="WAKEFIELD") echo "selected";?>>Wakefield</option>
         <option value="WINTHROP" <?php if($domain =="WINTHROP") echo "selected";?>>Winthrop</option>
      </select>
     <br/>
    </span>

    <input type="checkbox" id="search_links" name="search_links" <?php if($use_search_links)  echo "checked";?> />
    <label id="search_links"> Use Author/Title Search Links   <img src='../../shared/images/question-mark-small.png' class="help" onclick="JavaScript:swal('Search Links','Creates links as author title searches instead of link to a specific bib.', 'info');" /></label>
  </p>



   <div class ="no-preview">

   <h2> Report Output: </h2>
   <h3 class="weeding"> Enter Recipient Email Address: <span class="note"> Separate multiples with comma </span>  </h3>
   <p class="weeding">
       <input type="text" name="email" id ="email" size=60 class="stats" <?php if ($use_email) echo "value=\"".$email."\"";?>/>
       <span id = "email_opt_out">
         <br />
         <input type="checkbox" id="no_email" name="no_email" onchange="JavaScript:SetRunNow(this.checked)" <?php if($no_email) echo "checked";?> />
         <label id="no_email_label"> Opt out of daily emails  <img src='../../shared/images/question-mark-small.png' class="help" onclick="JavaScript:swal('Email Opt Out','Don't send emails for a daily report'.', 'info');" /></label>
      </span>
   </p>

   <h3 class="weeding"> Output File Name: <span class="note"> (Optional) </span>
   <img src='../../shared/images/question-mark-small.png' class="help" onclick="JavaScript:swal('File Name','Use this to enter a specific name for your output report. Otherwise a generic name will be generated.', 'info');"/></h3>
   <p class="weeding">
       <input type="text" name="out_file" id ="out_file" class="stats" size ="50" autocomplete="new-password" <?php if ($use_out_file) echo "value=\"".$out_file."\" ";   if ($save_file_name) echo "disabled";?>  / >
   </p>


   <h3 class="weeding"> Report Name: <span class="note no_schedule"> (Optional) </span>  <span class="note schedule_only" <?php if ($use_name ) echo "value=\"".$report_name."\"";?>> (Required) </span>
   <img src='../../shared/images/question-mark-small.png' class="help" onclick="JavaScript:swal('Report Name','Use this to enter a specific name for your output report. Will be included in email every time your report runs.', 'info');"/>
   </h3>
   <p class="weeding">
    <input type="input" id="report_name" name="report_name" class="stats" size ="50" autocomplete="new-password"  <?php if ($use_name) echo "value=\"".$report_name."\"";?>/>
   </p>

   <!--<input type="input" id="debug" size=200/>-->

   </div>



	<p class="weeding">
   <?php
     if ($use_db_id & $use_filters)
     {
        echo "<span id=\"update_sched\"><input type=\"button\" value=\"Update Scheduled Report\" class=\"stats\" id=\"update_report\" onclick=\"JavaScript:CreateReport(true, false)\" >&nbsp; &nbsp;</span>";
        echo "<input type=\"button\" value=\"Schedule New Report\" class=\"stats\" id=\"create_report\" onclick=\"JavaScript:CreateReport(false, true)\" >&nbsp; &nbsp;";
     }
     else if ($use_filters)
     {
	     echo "<input type=\"button\" value=\"Generate Report\" class=\"stats\" id=\"create_report\" onclick=\"JavaScript:CreateReport(false, false)\" />&nbsp; &nbsp";
	  }
	  else
     {
	     echo "<input type=\"button\" value=\"Generate Report\" class=\"stats\" id=\"create_report\" onclick=\"JavaScript:CreateReport(false, false)\" disabled/>&nbsp; &nbsp";
	  }
	?>
	<input type="submit" value="Generate Preview" class="stats" id="create_preview" onSubmit="JavaScript:CheckPreviewForm()"/>&nbsp; &nbsp;
	<input type="button"  value="Clear" class="stats" onClick="JavaScript:ClearListForm()"/>
	</p>

</form>

  </div><!-- end contents -->

     <div id="footer">

      <div id="footer_links">
      <ul>
         <li><a href="https://www.noblenet.org/sis/" target="blank"> Staff Information System </a></li>
         <li><a href="https://evergreen.noblenet.org" target="blank"> Catalog </a></li>
         <li><a href="mailto:tools@noblenet.org?Subject=DashboardContactForm"> Contact</a></li>
      </ul>
      </div><!-- end links -->

   </div> <!-- end footer -->


</div><!-- end wrapper -->

</body>

</html>
