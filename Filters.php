<?php

class Filters
{
    public $db;
    public $use_relative_dates;

    public $multiple_filters;

    public $use_shelf_sitting;
    public $shelf_sitting_date;

    public $filter_by_pub_date;
    public $published_before;
    public $published_after;
    public $pub_date_type;
    public $no_pub_date;

    public $filter_by_bib_file;
    public $filter_by_barcode_file;
    public $filter_by_isbn_file;
    public $input_filename;
    public $file_bibs; //array of bibd from file
    public $file_barcodes; //array of barcodes from file
    public $file_isbns; //array of isbns from file

    public $filter_by_added_date;
    public $added_date_before;
    public $added_date_after;
    public $added_date_type;

    //circ counts/dates
    public $filter_by_circ_date;
    public $circ_date_before;
    public $circ_date_after;
    public $circ_date_type;
    public $filter_by_circ_count;
    public $circ_count;
    public $circ_compare;

    public $filter_by_due_date;
    public $due_date_before;
    public $due_date_after;
    public $due_date_type;

    public $filter_by_hold_count;
    public $hold_count;
    public $hold_loc;

    public $filter_by_stat_cat;
    public $stat_cat_entries;
    //public $stat_cat_entry; //array of stat cat entries
    //public $use_all_stat_entry;

    public $filter_by_course;
    public $courses;
    public $course_copies;
    public $term_start;
    public $term_end;
    public $term_name;
    public $term_id;

    public $filter_by_item_tag;
    public $item_tags;

    //Call number
    public $filter_by_call_num;
    public $call_class;

    public $use_call_contains;
    public $call_contains;

    public $use_call_range;
    public $call_range; //array of start/stop pairs

    public $filter_by_call_num_prefix;
    public $call_num_prefix; //array of prefixes

    public $filter_by_call_num_suffix;
    public $call_num_suffix; //array of suffixes

    public $filter_by_collection_topic;
    public $collection_topic_names;

    public $filter_by_bisac;
    public $bisac_category;

    public $filter_by_circ_mod;
    public $circ_mod; //array of circ mod

    public $filter_by_status;
    public $status;//array of statuses

    public $filter_by_status_change;
    public $last_status_before;
    public $last_status_after;
    public $last_status_type;

    public $filter_by_only_holder;
    public $only_holder_option; //true or false

    public $active_items;
    public $deleted_items;
    public $filter_by_deleted_date;
    public $deleted_date_type;
    public $deleted_date_after;
    public $deleted_date_before;

    public $filter_by_inventory_date;
    public $inventory_date_type;
    public $inventory_date_after;
    public $inventory_date_before;
    public $no_inventory_date;

    //Acquisitions
    public $use_invoice_sql;
    public $use_po_sql;
    public $use_fund_sql;
    public $use_line_item_sql;

    public $filter_by_invoice_date;
    public $invoice_date_type;
    public $invoice_date_after;
    public $invoice_date_before;

    public $filter_by_invoice_closed_date;
    public $invoice_closed_date_type;
    public $invoice_closed_date_after;
    public $invoice_closed_date_before;
    public $no_invoice_closed_date;

    public $filter_by_order_date;
    public $order_date_type;
    public $order_date_after;
    public $order_date_before;
    public $no_order_date;

    public $filter_by_line_item_status;
    public $line_item_status;//array of statuses
    public $filter_by_fund;
    public $fund; //array of funds

    public $physical_items;
    public $electronic_items;

    public $use_all_copy_locations;
    public $copy_locations; //array of copy locations
    public $use_copy_location_group;
    public $copy_location_group_id;

    public $library_id;
    public $library_shortname;
    public $system_name;
    public $system_id;
    public $domain;
    public $scope;
    public $search_links;

    public $scheduled; //indicates if this report is scheduled
    public $collection; //indicates if this is a colelction report
    public $list_db_id;

    function __construct()
    {
       $this->use_relative_dates = false;

       $this->use_shelf_sitting = false;
       $this->shelf_sitting_date = "";
       $this->multiple_filters = false;

       $this->filter_by_pub_date = false;
       $this->published_before = "";
       $this->no_pub_date = false;

       $this->filter_by_bib_file = false;
       $this->filter_by_barcode_file = false;
       $this->filter_by_isbn_file = false;
       $this->input_filename = "";
       $this->file_bibs = array();
       $this->file_barcodes = array();
       $this->file_isbns = array();

       $this->filter_by_added_date = false;
       $this->added_date_after = "";
       $this->added_date_before= "";
       $this->added_date_type = "";

       $this->filter_by_circ_date = false;
       $this->circ_date_after = "";
       $this->circ_date_before= "";
       $this->circ_date_type = "";

       $this->filter_by_circ_count = false;
       $this->circ_count = -1;
       $this->circ_compare = "";

       $this->filter_by_hold_count = false;
       $this->hold_count = -1;
       $this->hold_loc = "my";

       $this->filter_by_stat_cat = false;
       $this->stat_cat_entries = array();

       $this->filter_by_course = false;
       $this->courses = array();
       $this->course_copies = array();
       $this->term_start="";
       $this->term_end= "";
       $this->term_name = "";
       $this->term_id = -1;

       $this->filter_by_item_tag = false;
       $this->item_tags = array();

       $this->filter_by_call_num = false;
       $this->call_class =-1;

       $this->use_call_contains = false;
       $this->call_contains = "";

       $this->use_call_range = false;
       $this->call_range = array();

       $this->filter_by_collection_topic = false;
       $this->collection_topic_names = array();

       $this->filter_by_circ_mod = false;
       $this->circ_mod = array();

       $this->filter_by_call_num_prefix = false;
       $this->call_num_prefix = array() ;

       $this->filter_by_call_num_suffix = false;
       $this->call_num_suffix = array();

       $this->filter_by_bisac = false;
       $this->bisac_category = array();

       $this->filter_by_status = false;
       $this->status = array();

       $this->filter_by_status_changed = false;
       $this->last_status_type = "";
       $this->last_status_after = "";
       $this->last_status_before = "";

       $this->filter_by_only_holder = false;

       $this->use_all_copy_locations = false;
       $this->copy_locations = array();
       $this->use_copy_location_group = false;
       $this->copy_location_group_id = -1;

       $this->deleted_items = false;
       $this->active_items = true;
       $this->filter_by_deleted_date = false;
       $this->deleted_date_type = "";
       $this->deleted_date_after = "";
       $this->deleted_date_before = "";

       $this->filter_by_inventory_date = false;
       $this->inventory_date_type = "";
       $this->inventory_date_after = "";
       $this->inventory_date_before = "";
       $this->no_inventory_date = false;

       $this->use_invoice_sql = false;
       $this->use_po_sql = false;
       $this->use_fund_sql = false;
       $this->use_line_item_sql = false;

       $this->filter_by_invoice_date = false;
       $this->invoice_date_type = "";
       $this->invoice_date_after = "";
       $this->invoice_date_before = "";

       $this->filter_by_invoice_closed_date = false;
       $this->invoice_closed_date_type = "";
       $this->invoice_closed_date_after = "";
       $this->invoice_closed_date_before = "";
       $this->no_invoice_closed_date = false;

       $this->filter_by_order_date = false;
       $this->order_date_type = "";
       $this->order_date_after = "";
       $this->order_date_before = "";
       $this->no_order_date = false;

       $this->filter_by_line_item_status = false;
       $this->line_item_status = array();//array of statuses
       $this->filter_by_fund = false;
       $this->fund = array(); //array of funds

       $this->physical_items = true;
       $this->electronic_items = false;

       $this->library_id = -1;
       $this->library_name = "";
       $this->system_name = "";
       $this->domain = "evergreen";
       $this->scope = 1;

       $this->search_links = false;

       $this->scheduled = false;
       $this->collection = false;

       $this->list_db_id =-1;
    }

    function __destruct()
    {
       unset($this->call_range);
       unset($this->call_num_prefix);
       unset($this->call_num_suffix);
       unset($this->collection_topic_names);
       unset($this->bisac_category);
       unset($this->circ_mod);
       unset($this->copy_locations);
       unset($this->file_bibs);
       unset($this->stat_cat_entries);
       unset($this->courses);
       unset($this->course_copies);
       unset($this->status);
       unset($this->file_bibs);
       unset($this->file_barcodes);
       unset($this->file_isbns);
       unset($this->line_item_status);
       unset($this->fund);
    }

    function SetDB($db)
    {
       $this->db = $db;
    }

    function SetRelativeDates()
    {
       $this->use_relative_dates = true;
    }

    function SetShelfSitter($date)
    {
       $this->use_shelf_sitting = true;
       $this->shelf_sitting_date = $date;
       $this->SetFilterByDeleted('active_only');
    }

    function SetShelfSitterRelative($timeframe)
    {
       $this->use_shelf_sitting = true;
       $this->SetFilterByDeleted('active_only');
       $timeframe = str_replace("_", " ", $timeframe);

       if ($this->use_relative_dates)
       {
          $this->shelf_sitting_date = $timeframe;
       }
       else
       {
          $today = date("y-m-d");
          $this->shelf_sitting_date = date("Y-m-d", strtotime($today."-".$timeframe)); //start
       }
    }

    function GetUseShelfSitter()
    {
       return $this->use_shelf_sitting;
    }

    function GetShelfSitter()
    {
       if ($this->use_shelf_sitting)
       {
          if ($this->use_relative_dates) return $this->shelf_sitting_date;
          else return  date("m/d/Y", strtotime($this->shelf_sitting_date));
       }
       else
       {
          return false;
       }
    }

    function ExcludeRecByCheckinDate($checkin, $active_date)
    {
       if($this->use_shelf_sitting)
       {
          if ($active_date == "Before 2000" && $checkin == "Before 2000")
          {
             return false;
          }

          if (date('Y-m-d', strtotime($active_date)) > date('Y-m-d', strtotime($this->shelf_sitting_date)) )
          {
             //this item didn't exist so exclude
            // echo "InExcludeByCheckin: excluded by active date ".date('Y-m-d', strtotime($active_date)).">".date('Y-m-d',strtotime($this->shelf_sitting_date))."\n";
             return true;
          }

          if ( date('Y-m-d', strtotime($checkin)) > date('Y-m-d',strtotime($this->shelf_sitting_date)) )
          {
             //echo "InExcludeByCheckin: excluded by checkin date ".date('Y-m-d', strtotime($checkin))."<". date('Y-m-d',strtotime($this->shelf_sitting_date))."\n";
             return true;
          }
          else return false;
       }
       else
       {
          return false;
       }
    }

    function SetFilterByPubDate($type, $after, $before, $relative=false)
    {
       $this->filter_by_pub_date = true;
       $this->pub_date_type = $type;

       if ($relative)
       {
          $today = date("Y-m-d");

          if($before)
          {
             $timeframe = str_replace("_", " ", $after);
             $after = date("Y", strtotime($today."-".$timeframe));
          }

          if ($after)
          {
             $timeframe = str_replace("_", " ", $after);
             $after = date("Y", strtotime($today."-".$timeframe));
          }
       }

       if ($before) $this->published_before = $before;
       if ($after) $this->published_after = $after;

    }

    function GetFilterByPubDate()
    {
       return  $this->filter_by_pub_date;
    }

    function GetPubDateType()
    {
       return $this->pub_date_type;
    }

    function GetPubDateBefore()
    {
       return  $this->published_before;
    }

    function GetPubDateAfter()
    {
       return  $this->published_after;
    }

    function SetPubDateNull()
    {
       $this->filter_by_pub_date = true;
       $this->no_pub_date = true;
    }

    function GetPubDateNull()
    {
       return $this->no_pub_date;
    }

    function GetFilterByPubDateText()
    {
       $out = "";

       if ($this->pub_date_type == "before")
       {
          $out = "Before = ".$this->published_before;
          if ($this->GetPubDateNull()) $out .= " -- Include Items with No Publication Date\n";
       }
       else if ($this->pub_date_type == "after")
       {
          $out = "After = ".$this->published_after;
       }
       else if ($this->pub_date_type == "between")
       {
          $out = "Between = ".$this->published_after."-".$this->published_before;
       }
       else if ($this->GetPubDateNull())
       {
          $out .= "No Pub Date";
       }
       return $out;
    }

    function ExcludeRecByPubDate($pub_date)
    {
       if($this->filter_by_pub_date)
       {

          if ($this->pub_date_type == "before")
          {
             if ($this->no_pub_date && $pub_date < 0) return false;

             if($pub_date > 0 && $pub_date < $this->published_before) return false;
             else return true;

          }
          else if ($this->pub_date_type == "after")
          {
             if($pub_date > 0 && $pub_date > $this->published_after) return false;
             else return true;
          }
          else if ($this->pub_date_type == "between")
          {
             if($pub_date > 0 && $pub_date <= $this->published_before && $pub_date >= $this->published_after) return false;
             else return true;
          }
          else if ($this->no_pub_date)
          {
             if  ($pub_date < 0) return false;
             else return true;
          }

       }
       else
       {
          return false;
       }
    }

    function SetFilterByBarcodeFile($type, $filename)
    {
       $this->filter_by_barcode_file = true;
       $this->input_filename = $filename;

       $filename_with_path = "/home/opensrf/list_upload/".$filename;
       $file = fopen($filename_with_path, 'r');

       if (!$file) return;

       if ($type == "csv")
       {
          $barcode_idx = -1;

          while ( ($data = fgetcsv($file) ) !== FALSE )
          {
             if ($barcode_idx == -1)
             {
                for( $i=0; $i < count($data); $i++ )
                {
                   if (strcasecmp($data[$i],"barcode") == 0 )
                   {
                      $barcode_idx = $i;
                      continue;
                   }
                }
             }
             else
             {
                $this->file_barcodes[] = $data[$barcode_idx];
             }
          }
       }
       else if ($type == "text")
       {
          while (($line = fgets($file, 4096)) !== false)
          {
             $this->file_barcodes[] = trim($line);
          }
       }

    }

    function GetFilterByBarcodeFile()
    {
       if ($this->filter_by_barcode_file)
       {
          return  $this->input_filename;
       }
       else
       {
          return false;
       }
    }

    function SetFilterByBibFile($type, $filename)
    {
       $this->filter_by_bib_file = true;
       $this->input_filename = $filename;

       $filename_with_path = "/home/opensrf/list_upload/".$filename;
       $file = fopen($filename_with_path, 'r');

       if (!$file) return;

       $bib_idx = -1;

       if ($type == "csv")
       {
			 while ( ($data = fgetcsv($file) ) !== FALSE )
			 {
				 if ($bib_idx == -1)
				 {
					 for( $i=0; $i < count($data); $i++ )
					 {
						 if (strcasecmp($data[$i] , "Document ID") == 0 || strcasecmp($data[$i], "Record ID") == 0)
						 {
							 $bib_idx = $i;
							 continue;
						 }
					 }
				 }
				 else
				 {
					 $this->file_bibs[] = $data[$bib_idx];
				 }
			 }
       }
       else if ($type == "text")
       {
          while (($line = fgets($file, 4096)) !== false)
          {
             $this->file_bibs[] = trim($line);
          }

       }

    }

    function GetFilterByBibFile()
    {
       if ($this->filter_by_bib_file)
       {
          return  $this->input_filename;
       }
       else
       {
          return false;
       }
    }

    function SetFilterByISBNFile($type, $filename)
    {
       $this->filter_by_isbn_file = true;
       $this->input_filename = $filename;

       $filename_with_path = "/home/opensrf/list_upload/".$filename;
       $file = fopen($filename_with_path, 'r');

       if (!$file) return;

       $isbn_idx = -1;

       //for each isbn remove everythign after the space
       //remove any dashes
       //get the other version of it 10 or 13
       //add all to the isbn list

       if ($type == "csv")
       {
			 while ( ($data = fgetcsv($file) ) !== FALSE )
			 {
				 if ($isbn_idx == -1)
				 {
					 for( $i=0; $i < count($data); $i++ )
					 {
						 if (strcasecmp($data[$i] , "ISBN") == 0)
						 {
							 $isbn_idx = $i;
							 continue;
						 }
					 }
				 }
				 else
				 {

				     $replace_chars = array("\\", "/", "%", ":", "'", "*", "?", ":",  "<", ">", "|", "#", "$",")","(","&","!","@","#","$","^","\"","~","`","|", "=");
				     $temp = str_replace($replace_chars, "",$data[$isbn_idx]);

				     $temp = str_replace(",", ";",$temp);
				     $all_isbn = explode(";", $temp);

				     foreach ($all_isbn as $curr)
				     {
						 $test_isbn = trim(str_replace("-", "",$curr ));
						 //echo $test_isbn ."\n";
						 if(strlen($test_isbn) == 10)
						 {
							 $isbn10 = trim($test_isbn);

							 //find isbn 13
							 $isbn13 = isbn10to13($isbn10);
						 }
						 else if (strlen($test_isbn) == 13)
						 {
							 $isbn13 = trim($test_isbn);

							 //find isbn 10
							 $isbn10 = isbn13to10($isbn13);
						 }
						 else
						 {
							 continue;
						 }

						 $this->file_isbns[] = $isbn10;
						 $this->file_isbns[] = $isbn13;
					 }
				 }
			 }
       }
       else if ($type == "text")
       {
          while (($line = fgets($file, 4096)) !== false)
          {
             $line = str_replace("-", "", trim($line));
             $parts = explode(" ", $line);

             $test_isbn = trim($parts[0]);

             if(strlen($test_isbn) == 10)
             {
                $isbn10 = $test_isbn;

                //find isbn 13
                $isbn13 = isbn10to13($isbn10);
             }
             else if (strlen($test_isbn) == 13)
             {
                $isbn13 = $test_isbn;

                //find isbn 10
                $isbn10 = isbn13to10($isbn13);
             }
             else
             {
                continue;
             }

             $this->file_isbns[] = $isbn10;
             $this->file_isbns[] = $isbn13;

          }
       }

       //after getting all the ISBNs find the bib numbers assocaited with them in metabib.real_full_record 020 $a

       $isbn_string = "";
       $first = true;

       foreach($this->file_isbns as $curr_isbn)
       {
          if ($first)
          {
             $isbn_string .="value ilike '".$curr_isbn."%' ";
             $first = false;
          }
          else
          {
             $isbn_string .=" OR value ilike '".$curr_isbn."%' ";
          }
       }

		 $sql = "SELECT DISTINCT (record)
               FROM metabib.real_full_rec
               WHERE tag='020'
               AND subfield = 'a'
               AND ($isbn_string)";

       //echo $sql."\n\n";

       $result = pg_query($this->db,$sql);

       while($row = pg_fetch_row($result))
       {
          $this->file_bibs[]=$row[0];
       }
    }

    function GetFilterByISBNFile()
    {
       if ($this->filter_by_isbn_file)
       {
          return  $this->input_filename;
       }
       else
       {
          return false;
       }
    }

    function SetFilterByAddedType($type)
    {
       $this->added_date_type = $type;
    }

    function GetFilterByAddedType()
    {
       return $this->added_date_type;
    }

    function SetFilterByAdded($after, $before)
    {
       $this->filter_by_added_date = true;

       if ($after)
       {
          $this->added_date_after = $after; //start
       }
       else
       {
          $this->added_date_after =date("Y-m-d", strtotime("01/01/2000"));
       }

       if ($before)
       {
          $this->added_date_before = $before; //end
       }
       else
       {
          $this->added_date_before =date("Y-m-d");
       }
    }

    function SetFilterByAddedRelative($start, $end)
    {
       $this->filter_by_added_date = true;

       $today = date("y-m-d");

       //figure out the start and end dates
       if($start)
       {
          $start = str_replace("_", " ", $start);

          if ($this->use_relative_dates) $this->added_date_after = $start;
          else $this->added_date_after = date("Y-m-d", strtotime($today."-".$start)); //start
       }
       else
       {
          $this->added_date_after =date("Y-m-d", strtotime("01/01/2000"));
       }

       if ($end)
       {
          $end = str_replace("_", " ", $end);
          if ($this->use_relative_dates) $this->added_date_before = $end;
          else $this->added_date_before = date("Y-m-d", strtotime($today."-".$end)); //start
       }
       else
       {
           $this->added_date_before =date("Y-m-d");
       }
    }

    function GetFilterByAdded()
    {
       return $this->filter_by_added_date;
    }

    function GetAddedAfter()
    {
       if ($this->use_relative_dates) return $this->added_date_after;
       else return  date("m/d/Y", strtotime($this->added_date_after));
    }

    function GetAddedBefore()
    {
       if ($this->use_relative_dates) return $this->added_date_before;
       else return  date("m/d/Y", strtotime($this->added_date_before));
    }

    function ExcludeRecByAddedDate($active_date)
    {
       if($this->filter_by_added_date)
       {
          $after = date('Y-m-d', strtotime($this->added_date_after));
          $before = date('Y-m-d', strtotime($this->added_date_before));

          if ($active_date == "Before 2000")
          {
             if ($before >= "2000-01-01") return false;
             else return true;
          }

          $date = date('Y-m-d', strtotime($active_date));

          if ( $date >= $after && $date <= $before) return false;
          else return true;
       }
       else
       {
          return false;
       }

    }

    function SetCircCount($compare, $val)
    {
       $this->filter_by_circ_count = true;
       $this->circ_count = $val;
       $this->circ_compare = $compare;
    }

    function GetFilterByCircCount()
    {
       return $this->filter_by_circ_count;
    }

    function GetCircCountVal()
    {
       return $this->circ_count;
    }

    function GetCircCountCompare()
    {
        return $this->circ_compare;
    }

    function ExcludeRecByCircCount($count)
    {
       if($this->filter_by_circ_count)
       {
         if ($this->circ_compare == "less")
         {
            if ($count < $this->circ_count) return false;
            else return true;
         }
         else if ($this->circ_compare == "more")
         {
            if ($count > $this->circ_count) return false;
            else return true;
         }
       }
       else
       {
          return false;
       }
    }

    function SetFilterByCircDateType($type)
    {
       $this->circ_date_type = $type;
    }

    function SetFilterByCircDate($after, $before)
    {
       $this->filter_by_circ_date = true;

       if (!$this->filter_by_circ_count)
       {
         //if date and no circ count use 1
          $this->filter_by_circ_count = true;
          $this->circ_count = 0;
          $this->circ_compare = "more";
       }

       if ($after)
       {
          $this->circ_date_after = $after; //start
       }
       else
       {
          $this->circ_date_after =date("Y-m-d", strtotime("01/01/2000"));
       }

       if ($before)
       {
          $this->circ_date_before = $before; //end
       }
       else
       {
          $this->circ_date_before =date("Y-m-d");
       }
    }

    function SetFilterByCircDateRelative($start, $end)
    {
       $this->filter_by_circ_date = true;

       if (!$this->filter_by_circ_count)
       {
         //if date and no circ count use 1
          $this->filter_by_circ_count = true;
          $this->circ_count = 0;
          $this->circ_compare = "more";
       }

       $today = date("y-m-d");

       //figure out the start and end dates
       if($start)
       {
          $start = str_replace("_", " ", $start);

          if ($this->use_relative_dates) $this->circ_date_after = $start;
          else $this->circ_date_after = date("Y-m-d", strtotime($today."-".$start)); //start
       }
       else
       {
          $this->circ_date_after =date("Y-m-d", strtotime("01/01/2000"));
       }

       if ($end)
       {
          $end = str_replace("_", " ", $end);
          if ($this->use_relative_dates) $this->circ_date_before = $end;
          else $this->circ_date_before = date("Y-m-d", strtotime($today."-".$end)); //start
       }
       else
       {
           $this->circ_date_before =date("Y-m-d");
       }
    }

    function GetFilterByCircDate()
    {
       return $this->filter_by_circ_date;
    }

    function GetFilterByCircType()
    {
       return $this->circ_date_type;
    }

    function GetCircAfter()
    {
       if ($this->use_relative_dates) return $this->circ_date_after;
       else return  date("m/d/Y", strtotime($this->circ_date_after));
    }

    function GetCircBefore()
    {
       if ($this->use_relative_dates) return $this->circ_date_before;
       else return  date("m/d/Y", strtotime($this->circ_date_before));
    }

     function SetFilterByDueDateType($type)
    {
       $this->due_date_type = $type;
    }

    function GetFilterByDueDateType()
    {
       return $this->due_date_type;
    }

    function SetFilterByDueDate($after, $before)
    {
       $this->filter_by_due_date = true;

       if ($after)
       {
          $this->due_date_after = $after; //start
       }
       else
       {
          $this->due_date_after =date("Y-m-d", strtotime("01/01/2000"));
       }

       if ($before)
       {
          $this->due_date_before = $before; //end
       }
       else
       {
          $this->due_date_before =date("Y-m-d");
       }
    }

    function SetFilterByDueDateRelative($start, $end)
    {
       $this->filter_by_due_date = true;

       $today = date("y-m-d");

       //figure out the start and end dates
       if($start)
       {
          $start = str_replace("_", " ", $start);

          if ($this->use_relative_dates) $this->due_date_after = $start;
          else $this->due_date_after = date("Y-m-d", strtotime($today."-".$start)); //start
       }
       else
       {
          $this->due_date_after =date("Y-m-d", strtotime("01/01/2000"));
       }

       if ($end)
       {
          $end = str_replace("_", " ", $end);
          if ($this->use_relative_dates) $this->due_date_before = $end;
          else $this->due_date_before = date("Y-m-d", strtotime($today."-".$end)); //start
       }
       else
       {
           $this->due_date_before =date("Y-m-d");
       }
    }

    function GetFilterByDueDate()
    {
       return $this->filter_by_due_date;
    }

    function GetDueDateAfter()
    {
       if ($this->use_relative_dates) return $this->due_date_after;
       else return  date("m/d/Y", strtotime($this->due_date_after));
    }

    function GetDueDateBefore()
    {
       if ($this->use_relative_dates) return $this->due_date_before;
       else return  date("m/d/Y", strtotime($this->due_date_before));
    }

    function ExcludeRecByDueDate($due_date)
    {
       if($this->filter_by_due_date)
       {
          if ( strlen($due_date) < 2)
          {
             return true;
          }

          $after = date('Y-m-d', strtotime($this->due_date_after));
          $before = date('Y-m-d', strtotime($this->due_date_before));
          $date = date('Y-m-d', strtotime($due_date));

          if ( $date >= $after && $date <= $before) return false;
          else return true;
       }
       else
       {
          return false;
       }

    }

    function SetFilterByHolds($count, $loc)
    {
       $this->filter_by_hold_count = true;
       $this->hold_count = $count;
       $this->hold_loc = $loc;
    }

    function GetFilterByHolds()
    {
       return $this->filter_by_hold_count;
    }

    function GetHoldCount()
    {
       return $this->hold_count;
    }

    function GetHoldLocation()
    {
       return $this->hold_loc;
    }

    function ExcludeRecByHoldCount($my_holds, $other_holds)
    {

       if($this->filter_by_hold_count)
       {
          if ($this->hold_loc == "my")
          {
              if ($my_holds > $this->hold_count )return false;
              else return true;
          }
          else
          {
             $total_holds = $my_holds + $other_holds;
             if ($total_holds > $this->hold_count )return false;
             else return true;
          }
       }
       else
       {
          return false;
       }
    }

    function SetScheduled()
    {
       $this->scheduled = true;
    }

    function GetScheduled()
    {
       return $this->scheduled;
    }

    function SetFilterByStatCat($stat_cat, $entry)
    {
       $this->filter_by_stat_cat = true;
       $entries =  explode(',', $entry);
       $this->stat_cat_entries = array_merge($this->stat_cat_entries, $entries);
    }

    function GetFilterByStatCats()
    {
       return $this->filter_by_stat_cat;
    }

    function GetStatCats($seperator)
    {
       if ($this->filter_by_stat_cat)
       {
          $stat_entry_string = "(".implode(",",$this->stat_cat_entries).")";

		  $sql = "SELECT asset.stat_cat.name, asset.stat_cat_entry.value
				    FROM asset.stat_cat_entry
					JOIN asset.stat_cat ON asset.stat_cat.id = asset.stat_cat_entry.stat_cat
					WHERE asset.stat_cat_entry.id IN $stat_entry_string
					ORDER BY 1,2";

		   $result = pg_query($this->db,$sql);

		   $stat_cat_text = "";
		   while($row = pg_fetch_row($result))
		   {
		      $stat_cat_text .= $row[0]."/".$row[1].$seperator;
		   }

          return $stat_cat_text;
       }
       else
       {
         return false;
       }
    }

    function SetFilterByCourse($term, $course)
    {
       $this->filter_by_course = true;

       if ($this->term_id =! -1 && $this->term_id != $term)
       {
          //echo "THERE ARE  MIX oF TERMS in the Course Filter.\n";
       }
       $this->term_id = $term;

       $this->courses[] = $course;

       //get all the barcodes assocauted with this course
       $sql = "SELECT item
               FROM asset.course_module_course_materials
               WHERE course = $course
               AND item IS NOT NULL";

        $result = pg_query($this->db,$sql);

       while ($row = pg_fetch_row($result))
       {
          $this->course_copies[] = $row[0] ;
       }

        //all the courses should have the same Term -- get the term dates for finding circ stats
        $sql = "SELECT start_date, end_date, name
                FROM asset.course_module_term
                WHERE id = $term";

        $result = pg_query($this->db,$sql);
        $term_row = pg_fetch_row($result);

        $this->term_start = date("Y-m-d", strtotime($term_row[0]));
        $this->term_end = date("Y-m-d", strtotime($term_row[1]));
        $this->term_name = $term_row[2];
        $this->term_id = $term;

    }

    function GetFilterByCourse()
    {
       return $this->filter_by_course;
    }

    function GetCourseArray()
    {
       return  $this->courses;
    }

    function GetCourses($seperator)
    {
       if ($this->filter_by_course)
       {
          $course_text ="";

          			  //find the term words
		  $term_sql = "SELECT  asset.course_module_term.name
						  FROM asset.course_module_term
						  WHERE id = $this->term_id ";

		  $term_result = pg_query($this->db, $term_sql);
		  $term_row = pg_fetch_row($term_result);

		  $term_words = $term_row[0];


          foreach($this->courses as $course)
          {

			  $course_sql = "SELECT DISTINCT asset.course_module_course.name, asset.course_module_course.course_number, asset.course_module_course.section_number
                             FROM asset.course_module_course
                              WHERE asset.course_module_course.id = $course ";

			  $course_result = pg_query($this->db, $course_sql);
			  $course_row = pg_fetch_row($course_result);

			  if (strlen($course_row[2]) > 0) $course_words = $course_row[1]."-".$course_row[2].":".$course_row[0];
			  else  $course_words = $course_row[1].":".$course_row[0];

			  $course_text .= $term_words." / ".$course_words.$seperator;
          }

          return $course_text;
       }
       else
       {
         return false;
       }
    }

    function GetTermStart()
    {
       return $this->term_start;
    }

    function GetTermEnd()
    {
       return $this->term_end;
    }

    function GetTermName()
    {
       return $this->term_name;
    }

    function GetTermId()
    {
       return $this->term_id;
    }

    function SetFilterByItemTag($input) //list of tags
    {
       $this->filter_by_item_tag = true;

       $tags = explode(",", $input);
       $this->item_tags = array_merge($this->item_tags, $tags);
    }

    function GetFilterByItemTag()
    {
       return $this->filter_by_item_tag;
    }

    function GetItemTags($seperator)
    {
       if ($this->filter_by_item_tag)
       {
          //need to return the words not the ids
          $tag_string = "(".implode(",",$this->item_tags).")";
          $sql = "SELECT config.copy_tag_type.label, asset.copy_tag.value
                  FROM asset.copy_tag
                  JOIN config.copy_tag_type ON config.copy_tag_type.code =asset.copy_tag.tag_type
                  WHERE asset.copy_tag.id in $tag_string
                  ORDER BY 1,2";

          $result = pg_query($this->db,$sql);

          $tag_list = "";
          while($row = pg_fetch_row($result))
          {
             $tag_list .= $row[0]."/".$row[1].$seperator;
          }

          return $tag_list;
       }
       else
       {
          return false;
       }
    }


    function GetCallClass()
    {
       if ($this->filter_by_call_num)
       {
          //need to return the words not the ids
          $sql = "SELECT name
                  FROM asset.call_number_class
                  WHERE id = $this->call_class";

          $result = pg_query($this->db,$sql);

          $row = pg_fetch_row($result);

          return $row[0];
       }
       else
       {
          return false;
       }
    }

    function SetFilterByCallContains($class, $text)
    {
       $this->filter_by_call_num = true;
       $this->use_call_contains = true;
       $this->call_class = $class;
       $this->call_contains = str_replace("_", " ",$text);
    }

    function GetCallContains()
    {
       if ($this->use_call_contains)
       {
          return $this->call_contains;
       }
       else
       {
          return false;
       }
    }

    function SetFilterByCallRange($class, $call_start, $call_end)
    {
       $this->filter_by_call_num = true;
       $this->use_call_range = true;
       $this->call_class = $class;

       $this->call_range[] = array('start' => $call_start,
                                   'end'   => $call_end);

    }

    function GetCallRange()
    {
       if ($this->use_call_range)
       {
          $pairs = "";
          foreach ($this->call_range as $curr_range)
          {
             $pairs .= "(".$curr_range['start']."-". $curr_range['end'].") ";
          }

          return $pairs;
       }
       else
       {
          return false;
       }
    }

    function SetFilterByCollectionTopics($class, $topics)
    {
       $this->filter_by_collection_topic = true;
       $this->filter_by_call_num = true;
       $this->use_call_range = true;

       if ($class > -1) $this->call_class = $class;


       $topic_ids = "(".$topics.")";

       $conspectus_sql = "SELECT id, name, code
                          FROM noble.coll_man_conspectus
                          WHERE id IN $topic_ids";

       $cons_result = pg_query($this->db, $conspectus_sql);

       while($row = pg_fetch_row($cons_result))
       {
          $conspectus_id = $row[0];
          $report_name = $row[1];
          $report_code = trim($row[2]);

          $this->collection_topic_names[] = $report_name;

          //get the call number range

          if ( $this->call_class == 3 || $this->library_shortname == "NOBLE")
          {
              //get LC ranges
              $call_sql = "SELECT lc.start, lc.end
                           FROM noble.coll_man_lc_range lc
                           WHERE lc.conspectus_id = $conspectus_id";

              $result = pg_query($this->db, $call_sql);

			   while ($row = pg_fetch_row($result) )
			  {
			     $start =  $row[0];
				 $end = $row[1];
				 $this->call_range[] = array('start' => $start,
						   					  'end'  => $end,
											  'class' => "LC");
				  }
          }//end lc

          if ( $this->call_class == 2 || $this->library_shortname == "NOBLE")
          {
             //get dewey ranges
              $call_sql = "SELECT ddc.start, ddc.end
                           FROM noble.coll_man_dewey_range ddc
                           WHERE ddc.conspectus_id = $conspectus_id";

              $result = pg_query($this->db, $call_sql);

			  while ($row = pg_fetch_row($result) )
			  {
			     $start =  $row[0];
				 $end = $row[1];
				 $this->call_range[] = array('start' => $start,
						   					 'end'  => $end,
											 'class' => "DEWEY");
			   }
           }//end dewey

       }//end while
    }

    function GetFilterByCollection($seperator)
    {
       if ($this->filter_by_collection_topic)
       {
          return implode($seperator, $this->collection_topic_names);
       }
       else
       {
         return false;
       }
    }

    function SetFilterByBisac($class, $category)
    {
       $this->filter_by_bisac = true;
       $this->filter_by_call_num = true;
       $this->call_class = $class;

       $category = "(".str_replace("-",",",$category).")";

       //echo "Bisac is ".$category."\n";

       //get the words for the category from the DB
       $sql = "SELECT category, level
               FROM noble.bisac_category
               WHERE id IN $category
               ORDER BY level";

       $result = pg_query($this->db,$sql);

       while($row = pg_fetch_row($result))
       {
          $this->bisac_category[] = $row[0];
       }

    }

    function GetFilterByBisac($seperator)
    {
       if ($this->filter_by_bisac)
       {
          return implode($seperator, $this->bisac_category);
       }
       else
       {
          return false;
       }
    }

    function SetFilterByCallPrefix($input) //list of ids
    {
       $this->filter_by_call_num_prefix = true;
       $prefixes = explode(",", $input);
       $this->call_num_prefix = array_merge($this->call_num_prefix, $prefixes);
    }

    function GetFilterByCallPrefix($seperator)
    {
       if ($this->filter_by_call_num_prefix)
       {
          //need to return the words not the ids
          $prefix_string = "(".implode(",",$this->call_num_prefix).")";
          $sql = "SELECT label
                  FROM asset.call_number_prefix
                  WHERE id IN $prefix_string";

          $result = pg_query($this->db,$sql);

          $prefix_list = "";
          while($row = pg_fetch_row($result))
          {
             $prefix_list .= $row[0].$seperator;
          }

          return $prefix_list;
       }
       else
       {
          return false;
       }
    }

    function SetFilterByCallSuffix($input) //list of ids
    {
       $this->filter_by_call_num_suffix = true;
       $suffixes = explode(",", $input);
       $this->call_num_suffix = array_merge($this->call_num_suffix, $suffixes);
    }

    function GetFilterByCallSuffix($seperator)
    {
       if ($this->filter_by_call_num_suffix)
       {
          //need to return the words not the ids
          $suffix_string = "(".implode(",",$this->call_num_suffix).")";
          $sql = "SELECT label
                  FROM asset.call_number_suffix
                  WHERE id IN $suffix_string";

          $result = pg_query($this->db,$sql);

          $suffix_list = "";
          while($row = pg_fetch_row($result))
          {
             $suffix_list .= $row[0].$seperator;
          }

          return $suffix_list;
       }
       else
       {
          return false;
       }
    }

    function SetFilterByCircMod($input) //list of ids
    {
       $this->filter_by_circ_mod = true;
       $circ_mods = explode(",",$input);
       $this->circ_mod = array_merge($this->circ_mod, $circ_mods);
    }


    function GetFilterByCircMod($seperator)
    {
       if ($this->filter_by_circ_mod)
       {
          return implode($seperator, $this->circ_mod);
       }
       else
       {
          return false;
       }
    }

    function SetFilterByStatus($input) //list of codes
    {
       $this->filter_by_status = true;

       $statuses = explode(",", $input);
       $this->status = array_merge($this->status, $statuses);
    }

    function GetFilterByStatus($seperator)
    {
       if ($this->filter_by_status)
       {
          //need to return the words not the ids
          $status_string = "(".implode(",",$this->status).")";
          $sql = "SELECT name
                  FROM config.copy_status
                  WHERE id IN $status_string";

          $result = pg_query($this->db,$sql);

          $status_list = "";
          while($row = pg_fetch_row($result))
          {
             $status_list .= $row[0].$seperator;
          }

          return $status_list;
       }
       else
       {
          return false;
       }
    }


    function SetFilterByLastStatusType($type)
    {
       $this->last_status_type = $type;
    }

    function GetFilterByLastStatusType()
    {
       return $this->last_status_type;
    }

    function SetFilterByStatusChanged($after, $before)
    {
       $this->filter_by_status_change = true;

       if ($after)
       {
          $this->last_status_after = $after; //start
       }
       else
       {
          $this->last_status_after =date("Y-m-d", strtotime("05/25/2012"));
       }

       if ($before)
       {
          $this->last_status_before = $before; //end
       }
       else
       {
          $this->last_status_before =date("Y-m-d");
       }
    }


    function SetFilterByStatusChangedRelative($start, $end)
    {
       $this->filter_by_status_change = true;

        $today = date("y-m-d");

       //figure out the start and end dates
       if($start)
       {
          $start = str_replace("_", " ", $start);
          if ($this->use_relative_dates) $this->last_status_after = $start;
          else $this->last_status_after = date("Y-m-d", strtotime($today."-".$start)); //start
       }
       else
       {
           $this->last_status_after =date("Y-m-d", strtotime("05/25/2012"));
       }

       if ($end)
       {
          $end = str_replace("_", " ", $end);
          if ($this->use_relative_dates) $this->last_status_before = $end;
          else $this->last_status_before = date("Y-m-d", strtotime($today."-".$end)); //start
       }
       else
       {
           $this->last_status_before =date("Y-m-d");
       }
    }


    function GetFilterByStatusChanged()
    {
       return $this->filter_by_status_change;
    }

    function GetStatusChangeAfter()
    {
       if ($this->use_relative_dates) return $this->last_status_after;
       else return  date("m/d/Y", strtotime($this->last_status_after));
    }

    function GetStatusChangeBefore()
    {
       if ($this->use_relative_dates) return $this->last_status_before;
       else return  date("m/d/Y", strtotime($this->last_status_before));
    }

    function SetFilterByDeleted($type)
    {
       if ($type == "active_only")
       {
          $this->deleted_items = false;
          $this->active_items = true;
       }
       else if ($type == "deleted_only")
       {
          $this->deleted_items = true;
          $this->active_items = false;
       }
       else if ($type == "active_deleted")
       {
          $this->deleted_items = true;
          $this->active_items = true;
       }
    }

    function SetFilterByDeletedDateType($type)
    {
       $this->deleted_date_type = $type;
    }

    function GetFilterByDeletedDateType()
    {
       return $this->deleted_date_type;
    }

    function SetFilterByDeletedDate($after, $before)
    {
       $this->filter_by_deleted_date = true;

       if ($after)
       {
          $this->deleted_date_after = $after; //start
       }
       else
       {
          $this->deleted_date_after =date("Y-m-d", strtotime("05/25/2012"));
       }

       if ($before)
       {
          $this->deleted_date_before = $before; //end
       }
       else
       {
          $this->deleted_date_before =date("Y-m-d");
       }
    }


    function SetFilterByDeletedDateRelative($start, $end)
    {
        $this->filter_by_deleted_date = true;

       $today = date("y-m-d");

       //figure out the start and end dates
       if($start)
       {
          $start = str_replace("_", " ", $start);
          if ($this->use_relative_dates) $this->deleted_date_after = $start;
          else $this->deleted_date_after = date("Y-m-d", strtotime($today."-".$start)); //start
       }
       else
       {
           $this->deleted_date_after =date("Y-m-d", strtotime("05/25/2012"));
       }

       if ($end)
       {
          $end = str_replace("_", " ", $end);
          if ($this->use_relative_dates) $this->deleted_date_before = $end;
          else $this->deleted_date_before = date("Y-m-d", strtotime($today."-".$end)); //start
       }
       else
       {
           $this->deleted_date_before =date("Y-m-d");
       }
    }

    function GetFilterByDeletedDate()
    {
       return $this->filter_by_deleted_date;
    }

    function GetFilterByDeletedDateAfter()
    {
       if ($this->use_relative_dates) return $this->deleted_date_after;
       else return  date("m/d/Y", strtotime($this->deleted_date_after));
    }

    function GetFilterByDeletedDateBefore()
    {
       if ($this->use_relative_dates) return $this->deleted_date_before;
       else return  date("m/d/Y", strtotime($this->deleted_date_before));
    }

    function GetFilterByDeleted()
    {
       if ($this->active_items && !$this->deleted_items)
       {
          return "Active Only";
       }
       else if (!$this->active_items && $this->deleted_items)
       {
          return "Deleted Only";
       }
       else if($this->active_items && $this->deleted_items)
       {
          return "ALL";
       }
    }

    function GetShowDeleted()
    {
        if ($this->deleted_items)return true;
        else return false;
    }


    function SetFilterByElectronic($type)
    {
       if ($type == "physical_only")
       {
          $this->electronic_items = false;
          $this->physical_items = true;
       }
       else if ($type == "electronic_only")
       {
          $this->electronic_items = true;
          $this->physical_items = false;
       }
       else if ($type == "physical_electronic")
       {
          $this->electronic_items = true;
          $this->physical_items = true;
       }
    }

    function GetFilterByElectronic()
    {
       if ($this->physical_items && !$this->electronic_items)
       {
          return "Physical Only";
       }
       else if (!$this->physical_items && $this->electronic_items)
       {
          return "Electronic Only";
       }
       else if($this->physical_items && $this->electronic_items)
       {
          return "ALL";
       }
    }

    function SetFilterByInventoryDateType($type)
    {
       $this->inventory_date_type = $type;
    }

    function GetFilterByInventoryDateType()
    {
       return $this->inventory_date_type;
    }

    function SetFilterByInventoryDate($after, $before)
    {
       $this->filter_by_inventory_date = true;

       if ($after)
       {
          $this->inventory_date_after = $after; //start
       }
       else
       {
          $this->inventory_date_after =date("Y-m-d", strtotime("05/25/2012"));
       }

       if ($before)
       {
          $this->inventory_date_before = $before; //end
       }
       else
       {
          $this->inventory_date_before =date("Y-m-d");
       }
    }

    function SetFilterByInventoryDateRelative($start, $end)
    {
        $this->filter_by_inventory_date = true;

       $today = date("y-m-d");

       //figure out the start and end dates
       if($start)
       {
          $start = str_replace("_", " ", $start);
          if ($this->use_relative_dates) $this->inventory_date_after = $start;
          else $this->inventory_date_after = date("Y-m-d", strtotime($today."-".$start)); //start
       }
       else
       {
           $this->inventory_date_after =date("Y-m-d", strtotime("05/25/2012"));
       }

       if ($end)
       {
          $end = str_replace("_", " ", $end);
          if ($this->use_relative_dates) $this->inventory_date_before = $end;
          else $this->inventory_date_before = date("Y-m-d", strtotime($today."-".$end)); //start
       }
       else
       {
           $this->inventory_date_before =date("Y-m-d");
       }
    }

    function GetFilterByInventoryDate()
    {
       return $this->filter_by_inventory_date;
    }

    function GetFilterByInventoryDateAfter()
    {
       if ($this->use_relative_dates) return $this->inventory_date_after;
       else return  date("m/d/Y", strtotime($this->inventory_date_after));
    }

    function GetFilterByInventoryDateBefore()
    {
       if ($this->use_relative_dates) return $this->inventory_date_before;
       else return  date("m/d/Y", strtotime($this->inventory_date_before));
    }

    function SetInventoryNull()
    {
       $this->filter_by_inventory_date = true;
       $this->no_inventory_date = true;
    }

    function GetInventoryNull()
    {
       return $this->no_inventory_date;
    }

    function ExcludeRecByInventoryDate($inventory_date)
    {
       if($this->filter_by_inventory_date)
       {
          if ($inventory_date == "--")
          {
             if ($this->no_inventory_date)return false;
             else return true;
          }

          $after = date('Y-m-d', strtotime($this->inventory_date_after));
          $before = date('Y-m-d', strtotime($this->inventory_date_before));
          $date = date('Y-m-d', strtotime($inventory_date));

          if ( $date >= $after && $date <= $before) return false;
          else return true;
       }
       else
       {
          return false;
       }

    }

    function SetCopyLocations($input_loc)
    {
       if ($input_loc == "all")
       {
          $this->use_all_copy_locations = true;
       }
       else
       {
           //make this an array first
           $locations = explode(",", $input_loc);
           $this->copy_locations = array_merge($this->copy_locations, $locations);
       }
    }

    function GetCopyLocations($seperator)
    {
       if ($this->use_all_copy_locations)
       {
          return "All Locations";
       }
       else
       {
          //need to return the words not the ids
          $loc_string = "(".implode(",",$this->copy_locations).")";
          $sql = "SELECT name
                  FROM asset.copy_location
                  WHERE id IN $loc_string";

          $result = pg_query($this->db,$sql);

          $loc_list = "";
          while($row = pg_fetch_row($result))
          {
             $loc_list .= $row[0].$seperator;
          }

          return $loc_list;
       }
    }

    function SetCopyLocationGroup($input_loc_grp)
    {
       $this->use_copy_location_group = true;
       $this->copy_location_group_id = $input_loc_grp;

       //need to return the words not the ids
       $sql = "SELECT location
               FROM asset.copy_location_group_map
               WHERE lgroup = $this->copy_location_group_id";

       $result = pg_query($this->db,$sql);

       $locations = array();
       while($row = pg_fetch_row($result))
       {
          $locations[] = $row[0];
       }

       $this->copy_locations = array_merge($this->copy_locations, $locations);

    }

    function SetCollection()
    {
       $this->collection = true;
    }

    function GetCollection()
    {
       return $this->collection;
    }

    function SetListDBId($id)
    {
       $this->list_db_id = $id;
    }

    function GetListDBId()
    {
       return $this->list_db_id;
    }

    function GetFilterByCopyLocationGroup()
    {
       return $this->use_copy_location_group;
    }

    function GetCopyLocationGroupName()
    {
       if ($this->use_copy_location_group)
       {
          //need to return the words not the ids
          $sql = "SELECT name
                  FROM asset.copy_location_group
                  WHERE id = $this->copy_location_group_id";

          $result = pg_query($this->db,$sql);

          $row = pg_fetch_row($result);

          return $row[0];
       }
       else
       {
          return false;
       }
    }

   //Acquisitions
    function SetFilterByInvoiceDateType($type)
    {
       $this->invoice_date_type = $type;
    }

    function GetFilterByInvoiceDateType()
    {
       return $this->invoice_date_type;
    }

    function SetFilterByInvoiceDate($after, $before)
    {
       $this->filter_by_invoice_date = true;
       $this->use_invoice_sql = true;

       if ($after)
       {
          $this->invoice_date_after = $after; //start
       }
       else
       {
          $this->invoice_date_after =date("Y-m-d", strtotime("05/25/2012"));
       }

       if ($before)
       {
          $this->invoice_date_before = $before; //end
       }
       else
       {
          $this->invoice_date_before =date("Y-m-d");
       }
    }

    function SetFilterByInvoiceDateRelative($start, $end)
    {
       $this->filter_by_invoice_date = true;
       $this->use_invoice_sql = true;

       $today = date("y-m-d");

       //figure out the start and end dates
       if($start)
       {
          $start = str_replace("_", " ", $start);
          if ($this->use_relative_dates) $this->invoice_date_after = $start;
          else $this->invoice_date_after = date("Y-m-d", strtotime($today."-".$start)); //start
       }
       else
       {
           $this->invoice_date_after =date("Y-m-d", strtotime("05/25/2012"));
       }

       if ($end)
       {
          $end = str_replace("_", " ", $end);
          if ($this->use_relative_dates) $this->invoice_date_before = $end;
          else $this->invoice_date_before = date("Y-m-d", strtotime($today."-".$end)); //start
       }
       else
       {
           $this->invoice_date_before =date("Y-m-d");
       }
    }

    function GetFilterByInvoiceDate()
    {
       return $this->filter_by_invoice_date;
    }

    function GetFilterByInvoiceDateAfter()
    {
       if ($this->use_relative_dates) return $this->invoice_date_after;
       else return  date("m/d/Y", strtotime($this->invoice_date_after));
    }

    function GetFilterByInvoiceDateBefore()
    {
       if ($this->use_relative_dates) return $this->invoice_date_before;
       else return  date("m/d/Y", strtotime($this->invoice_date_before));
    }

    function ExcludeRecByInvoiceDate($invoice_date)
    {
       if($this->filter_by_invoice_date)
       {
          if ($invoice_date == "--")
          {
             return true;
          }

          $after = date('Y-m-d', strtotime($this->invoice_date_after));
          $before = date('Y-m-d', strtotime($this->invoice_date_before));
          $date = date('Y-m-d', strtotime($invoice_date));

          if ( $date >= $after && $date <= $before) return false;
          else return true;
       }
       else
       {
          return false;
       }

    }

    function SetFilterByInvoiceClosedDateType($type)
    {
       $this->invoice_closed_date_type = $type;
    }

    function GetFilterByInvoiceClosedDateType()
    {
       return $this->invoice_closed_date_type;
    }

    function SetFilterByInvoiceClosedDate($after, $before)
    {
       $this->filter_by_invoice_closed_date = true;
       $this->use_invoice_sql = true;

       if ($after)
       {
          $this->invoice_closed_date_after = $after; //start
       }
       else
       {
          $this->invoice_closed_date_after =date("Y-m-d", strtotime("05/25/2012"));
       }

       if ($before)
       {
          $this->invoice_closed_date_before = $before; //end
       }
       else
       {
          $this->invoice_closed_date_before =date("Y-m-d");
       }
    }

    function SetFilterByInvoiceClosedDateRelative($start, $end)
    {
        $this->filter_by_invoice_closed_date = true;
        $this->use_invoice_sql = true;

       $today = date("y-m-d");

       //figure out the start and end dates
       if($start)
       {
          $start = str_replace("_", " ", $start);
          if ($this->use_relative_dates) $this->invoice_closed_date_after = $start;
          else $this->invoice_closed_date_after = date("Y-m-d", strtotime($today."-".$start)); //start
       }
       else
       {
           $this->invoice_closed_date_after =date("Y-m-d", strtotime("05/25/2012"));
       }

       if ($end)
       {
          $end = str_replace("_", " ", $end);
          if ($this->use_relative_dates) $this->invoice_closed_date_before = $end;
          else $this->invoice_closed_date_before = date("Y-m-d", strtotime($today."-".$end)); //start
       }
       else
       {
           $this->invoice_closed_date_before =date("Y-m-d");
       }
    }

    function GetFilterByInvoiceClosedDate()
    {
       return $this->filter_by_invoice_closed_date;
    }

    function GetFilterByInvoiceClosedDateAfter()
    {
       if ($this->use_relative_dates) return $this->invoice_closed_date_after;
       else return  date("m/d/Y", strtotime($this->invoice_closed_date_after));
    }

    function GetFilterByInvoiceClosedDateBefore()
    {
       if ($this->use_relative_dates) return $this->invoice_closed_date_before;
       else return  date("m/d/Y", strtotime($this->invoice_closed_date_before));
    }

    function SetInvoiceClosedNull()
    {
       $this->filter_by_invoice_closed_date = true;
       $this->no_invoice_closed_date = true;
    }

    function GetInvoiceClosedNull()
    {
       return $this->no_invoice_closed_date;
    }

    function ExcludeRecByInvoiceClosedDate($invoice_closed_date)
    {
       if($this->filter_by_invoice_closed_date)
       {
          if ($invoice_closed_date == "--")
          {
              if ($this->no_invoice_closed_date)return false;
             else return true;
          }

          $after = date('Y-m-d', strtotime($this->invoice_closed_date_after));
          $before = date('Y-m-d', strtotime($this->invoice_closed_date_before));
          $date = date('Y-m-d', strtotime($invoice_closed_date));

          if ( $date >= $after && $date <= $before) return false;
          else return true;
       }
       else
       {
          return false;
       }

    }

    function SetFilterByOrderDateType($type)
    {
       $this->order_date_type = $type;
    }

    function GetFilterByOrderDateType()
    {
       return $this->order_date_type;
    }

    function SetFilterByOrderDate($after, $before)
    {
       $this->filter_by_order_date = true;
       $this->use_po_sql = true;

       if ($after)
       {
          $this->order_date_after = $after; //start
       }
       else
       {
          $this->order_date_after =date("Y-m-d", strtotime("05/25/2012"));
       }

       if ($before)
       {
          $this->order_date_before = $before; //end
       }
       else
       {
          $this->order_date_before =date("Y-m-d");
       }
    }

    function SetOrderDateNull()
    {
       $this->filter_by_order_date = true;
       $this->no_order_date = true;
    }

    function GetOrderDateNull()
    {
       return $this->no_order_date;
    }


    function SetFilterByOrderDateRelative($start, $end)
    {
        $this->filter_by_order_date = true;
        $this->use_po_sql = true;

       $today = date("y-m-d");

       //figure out the start and end dates
       if($start)
       {
          $start = str_replace("_", " ", $start);
          if ($this->use_relative_dates) $this->order_date_after = $start;
          else $this->order_date_after = date("Y-m-d", strtotime($today."-".$start)); //start
       }
       else
       {
           $this->order_date_after =date("Y-m-d", strtotime("05/25/2012"));
       }

       if ($end)
       {
          $end = str_replace("_", " ", $end);
          if ($this->use_relative_dates) $this->order_date_before = $end;
          else $this->order_date_before = date("Y-m-d", strtotime($today."-".$end)); //start
       }
       else
       {
           $this->order_date_before =date("Y-m-d");
       }
    }

    function GetFilterByOrderDate()
    {
       return $this->filter_by_order_date;
    }

    function GetFilterByOrderDateAfter()
    {
       if ($this->use_relative_dates) return $this->order_date_after;
       else return  date("m/d/Y", strtotime($this->order_date_after));
    }

    function GetFilterByOrderDateBefore()
    {
       if ($this->use_relative_dates) return $this->order_date_before;
       else return  date("m/d/Y", strtotime($this->order_date_before));
    }

    function ExcludeRecByOrderDate($order_date)
    {
       if($this->filter_by_order_date)
       {
          if ($order_date == "--")
          {
              if ($this->no_order_date)return false;
              else return true;
          }


          $after = date('Y-m-d', strtotime($this->order_date_after));
          $before = date('Y-m-d', strtotime($this->order_date_before));
          $date = date('Y-m-d', strtotime($order_date));

          if ( $date >= $after && $date <= $before) return false;
          else return true;
       }
       else
       {
          return false;
       }

    }

    function SetFilterByLineItemStatus($input) //list of ids
    {
       $this->filter_by_line_item_status = true;
       $this->use_line_item_sql = true;
       $statuses = explode(",", $input);
       $this->line_item_status = array_merge($this->line_item_status, $statuses);
    }

    function GetFilterByLineItemStatus($seperator)
    {
       if ($this->filter_by_line_item_status)
       {
          $li_status = implode($seperator, $this->line_item_status);
          $li_status = str_replace("cancelled", "cancelled(includes backordered)", $li_status);
          return $li_status;
       }
       else
       {
          return false;
       }
    }

    function ExcludeRecByLineItemStatus($line_item_status)
    {
       if($this->filter_by_line_item_status)
       {
          if (in_array($line_item_status, $this->line_item_status))return false;
          else return true;

       }
       else
       {
          return false;
       }
    }

    function SetFilterByFund($input) //list of ids
    {
       $this->filter_by_fund = true;
       $this->use_fund_sql = true;
       $funds = explode(",", $input);
       $this->fund = array_merge($this->fund, $funds);
    }

    function GetFilterByFund($seperator)
    {
       if ($this->filter_by_fund)
       {
          //need to return the words not the ids
          $fund_string = "(".implode(",",$this->fund).")";
          $sql = "SELECT name, year
                  FROM acq.fund
                  WHERE id IN $fund_string";

          $result = pg_query($this->db,$sql);

          $fund_list = "";
          while($row = pg_fetch_row($result))
          {
             $fund_list .= $row[0]."(".$row[1].")".$seperator;
          }

          return $fund_list;
       }
       else
       {
          return false;
       }
    }

    function ExcludeRecByFund($fund)
    {
       if($this->filter_by_fund)
       {
          if (in_array($fund, $this->fund))return false;
          else return true;

       }
       else
       {
          return false;
       }
    }

    function SetLibrary($lib)
    {
       $sql = "SELECT id, ou_type, parent_ou
               FROM actor.org_unit
               WHERE shortname = '$lib'";

       $result = pg_query($this->db,$sql);
       $row = pg_fetch_row($result);

       $this->library_id = $row[0];

       $org_unit_type = $row[1];
       $parent = $row[2];

       $this->library_shortname = $lib;

       $this->SetDomain($this->library_shortname);

       if ($org_unit_type <= 2) //consortia or system
       {
          $this->system_name = $lib;
          $this->SetSystemId($this->library_id);
       }
       else
       {
          $this->SetSystemName($parent);
          $this->SetSystemId($parent);
       }

    }

    function GetLibrary()
    {
       return  $this->library_shortname;
    }

    function SetOnlyHolder($val)
    {
       $this->filter_by_only_holder = true;
       if ($val == "true")$this->only_holder_option = true;
       else if ($val == "false")$this->only_holder_option = false;
    }

    function GetOnlyHolder()
    {
       return $this->filter_by_only_holder;
    }

    function ExcludeRecByOnlyHolder($only_holder)
    {
       if($this->filter_by_only_holder)
       {

          if($this->only_holder_option)
          {
             if ($only_holder == "TRUE") return false;
             else return true;
          }
          else if (!$this->only_holder_option)
          {
             if ($only_holder == "") return false;
             else return true;
          }

       }
       else
       {
          return false;
       }
    }

    function SetDomain($domain)
    {
       $this->domain = FindDomain($domain);
    }

    function GetDomain()
    {
       return $this->domain;
    }

    function SetSearchLinks()
    {
       $this->search_links = true;
    }

    function GetSearchLinks()
    {
      return $this->search_links;
    }

    function SetScope()
    {
       $this->scope = FindScope($this->library_shortname);
    }

    function GetScope()
    {
      return $this->scope;
    }

    function SetSystemName($parent_ou)
    {
       $sql = "SELECT shortname
               FROM actor.org_unit
               WHERE id = $parent_ou";

       $result = pg_query($this->db,$sql);
       $row = pg_fetch_row($result);

       $this->system_name = $row[0];
    }

    function GetSystemName()
    {
      return $this->system_name;
    }

    function SetSystemId($sys)
    {
       $this->system_id = $sys;
    }

    function GetSystemId()
    {
       return $this->system_id;
    }

    function CreateFiltersFromString($filter_string)
    {
       $temp = explode(" ", $filter_string);
       $this->CreateFilters($temp);
    }

    function CreateFilters($cmd_line)
    {

       for ($i=0; $i < count($cmd_line); $i++)
       {
          $arg = $cmd_line[$i];

          if ($arg == "lib")
          {
             $this->SetLibrary($cmd_line[++$i]);
          }
          else if ($arg == "db_id")
          {
             $this->SetListDBId($cmd_line[++$i]);
          }
          else if ($arg == "copy_loc")
          {
             $this->SetCopyLocations($cmd_line[++$i]);
          }
          else if ($arg == "copy_loc_grp")
          {
             $this->SetCopyLocationGroup($cmd_line[++$i]);
          }
          else if ($arg == "shelf")
          {
              $this->SetShelfSitter($cmd_line[++$i]);
              $this->multiple_filters = true;
          }
          else if ($arg == "shelf_relative")
          {
              $this->SetShelfSitterRelative($cmd_line[++$i]);
              $this->multiple_filters = true;
          }
          else if ($arg =="pub_before")
          {
             $this->SetFilterByPubDate("before",null, $cmd_line[++$i]);
             $this->multiple_filters = true;
          }
          else if ($arg =="pub_after")
          {
             $this->SetFilterByPubDate("after", $cmd_line[++$i], null);
             $this->multiple_filters = true;
          }
          else if ($arg =="pub_after_relative")
          {
             $this->SetFilterByPubDate("after", $cmd_line[++$i], null, true);
             $this->multiple_filters = true;
          }
          else if ($arg =="pub_between")
          {
             $this->SetFilterByPubDate("between", $cmd_line[++$i], $cmd_line[++$i] );
             $this->multiple_filters = true;
          }
          else if ($arg =="pub_null")
          {
             $this->SetPubDateNull();
             $this->multiple_filters = true;
          }
          else if ($arg =="active_only" || $arg =="deleted_only" || $arg =="active_deleted" )
          {
             $this->SetFilterByDeleted($arg);
             if ($arg =="deleted_only") $this->multiple_filters = true;
          }
          else if ($arg =="physical_only" || $arg =="electronic_only" || $arg =="physical_electronic" )
          {
             $this->SetFilterByElectronic($arg);
             $this->multiple_filters = true;
          }
          else if ($arg =="delete_date")
          {
             $delete_type = $cmd_line[++$i];
             $this->SetFilterByDeletedDateType($delete_type);

             if ($delete_type == "before") $this->SetFilterByDeletedDate(null, $cmd_line[++$i]);
             else if ($delete_type == "after") $this->SetFilterByDeletedDate($cmd_line[++$i], null);
             else if ($delete_type == "between") $this->SetFilterByDeletedDate($cmd_line[++$i], $cmd_line[++$i]);

             $this->multiple_filters = true;
          }
          else if ($arg =="delete_date_relative")
          {
             $delete_type = $cmd_line[++$i];
             $this->SetFilterByDeletedDateType($delete_type);

             if ($delete_type == "before") $this->SetFilterByDeletedDateRelative(null, $cmd_line[++$i]);
             else if ($delete_type == "after") $this->SetFilterByDeletedDateRelative($cmd_line[++$i], null);
             else if ($delete_type == "between") $this->SetFilterByDeletedDateRelative($cmd_line[++$i], $cmd_line[++$i]);

             $this->multiple_filters = true;
          }
          else if ($arg =="inventory_date")
          {
             $inventory_type = $cmd_line[++$i];
             $this->SetFilterByInventoryDateType($inventory_type);

             if ($inventory_type == "before") $this->SetFilterByInventoryDate(null, $cmd_line[++$i]);
             else if ($inventory_type == "after") $this->SetFilterByInventoryDate($cmd_line[++$i], null);
             else if ($inventory_type == "between") $this->SetFilterByInventoryDate($cmd_line[++$i], $cmd_line[++$i]);

             $this->multiple_filters = true;
          }
          else if ($arg =="inventory_date_relative")
          {
             $inventory_type = $cmd_line[++$i];
             $this->SetFilterByInventoryDateType($inventory_type);

             if ($inventory_type == "before") $this->SetFilterByInventoryDateRelative(null, $cmd_line[++$i]);
             else if ($inventory_type == "after") $this->SetFilterByInventoryDateRelative($cmd_line[++$i], null);
             else if ($inventory_type == "between") $this->SetFilterByInventoryDateRelative($cmd_line[++$i], $cmd_line[++$i]);

             $this->multiple_filters = true;
          }
          else if ($arg == "inventory_null")
          {
             $this->SetInventoryNull();
             $this->multiple_filters = true;
          }
          else if ($arg =="tag")
          {
             $this->SetFilterByItemTag($cmd_line[++$i]);
             $this->multiple_filters = true;
          }
          else if ($arg =="status")
          {
             $this->SetFilterByStatus($cmd_line[++$i]);
             $this->multiple_filters = true;
          }
          else if ($arg =="stat_change")
          {
             $stat_type = $cmd_line[++$i];
             $this->SetFilterByLastStatusType($stat_type);

             if ($stat_type == "before") $this->SetFilterByStatusChanged(null, $cmd_line[++$i]);
             else if ($stat_type == "after") $this->SetFilterByStatusChanged($cmd_line[++$i], null);
             else if ($stat_type == "between") $this->SetFilterByStatusChanged($cmd_line[++$i], $cmd_line[++$i]);

             $this->multiple_filters = true;
          }
          else if ($arg =="stat_change_relative")
          {
             $stat_type = $cmd_line[++$i];
             $this->SetFilterByLastStatusType($stat_type);

             if ($stat_type == "before") $this->SetFilterByStatusChangedRelative(null, $cmd_line[++$i]);
             else if ($stat_type == "after") $this->SetFilterByStatusChangedRelative($cmd_line[++$i], null);
             else if ($stat_type == "between") $this->SetFilterByStatusChangedRelative($cmd_line[++$i], $cmd_line[++$i]);

             $this->multiple_filters = true;
          }
          else if ($arg =="bib_file")
          {
             $this->SetFilterByBibFile($cmd_line[++$i], $cmd_line[++$i]);

             $this->multiple_filters = true;
          }
          else if ($arg =="barcode_file")
          {
             $this->SetFilterByBarcodeFile($cmd_line[++$i], $cmd_line[++$i]);

             $this->multiple_filters = true;
          }
          else if ($arg =="isbn_file")
          {
             $this->SetFilterByISBNFile($cmd_line[++$i], $cmd_line[++$i]);

             $this->multiple_filters = true;
          }
          else if ($arg =="added")
          {
             $added_type = $cmd_line[++$i];
             $this->SetFilterByAddedType($added_type);

             if ($added_type == "before") $this->SetFilterByAdded(null, $cmd_line[++$i]);
             else if ($added_type == "after") $this->SetFilterByAdded($cmd_line[++$i], null);
             else if ($added_type == "between") $this->SetFilterByAdded($cmd_line[++$i], $cmd_line[++$i]);

             $this->multiple_filters = true;
          }
          else if ($arg =="added_relative")
          {
             $added_type = $cmd_line[++$i];
             $this->SetFilterByAddedType($added_type);

             if ($added_type == "before") $this->SetFilterByAddedRelative(null, $cmd_line[++$i]);
             else if ($added_type == "after") $this->SetFilterByAddedRelative($cmd_line[++$i], null);
             else if ($added_type == "between") $this->SetFilterByAddedRelative($cmd_line[++$i], $cmd_line[++$i]);

             $this->multiple_filters = true;
          }
          else if ($arg =="stat_cat")
          {
             $this->SetFilterByStatCat($cmd_line[++$i], $cmd_line[++$i]);

             $this->multiple_filters = true;
          }
          else if ($arg =="course")
          {
             $this->SetFilterByCourse($cmd_line[++$i], $cmd_line[++$i]);
             $this->multiple_filters = true;
          }
          else if ($arg =="call_contain")
          {
             $this->SetFilterByCallContains($cmd_line[++$i], $cmd_line[++$i]);
             $this->multiple_filters = true;
          }
          else if ($arg =="call_range")
          {
             $this->SetFilterByCallRange($cmd_line[++$i], $cmd_line[++$i], $cmd_line[++$i]);
             $this->multiple_filters = true;
          }
          else if ($arg =="coll_topic")
          {
             if($this->library_shortname == "NOBLE")$this->SetFilterByCollectionTopics(-1, $cmd_line[++$i]);
             else $this->SetFilterByCollectionTopics($cmd_line[++$i], $cmd_line[++$i]);

             $this->multiple_filters = true;
          }
          else if ($arg == "circ_count")
          {
             $this->SetCircCount($cmd_line[++$i], $cmd_line[++$i]);
             $this->multiple_filters = true;
          }
          else if ($arg =="circ_date")
          {
             $circ_type = $cmd_line[++$i];
             $this->SetFilterByCircDateType($circ_type);

             if ($circ_type == "before") $this->SetFilterByCircDate(null, $cmd_line[++$i]);
             else if ($circ_type == "after") $this->SetFilterByCircDate($cmd_line[++$i], null);
             else if ($circ_type == "between") $this->SetFilterByCircDate($cmd_line[++$i], $cmd_line[++$i]);

             $this->multiple_filters = true;
          }
          else if ($arg == "circ_date_relative")
          {
             $circ_type = $cmd_line[++$i];
             $this->SetFilterByCircDateType($circ_type);

             if ($circ_type == "before") $this->SetFilterByCircDateRelative(null, $cmd_line[++$i]);
             else if ($circ_type == "after") $this->SetFilterByCircDateRelative($cmd_line[++$i], null);
             else if ($circ_type == "between") $this->SetFilterByCircDateRelative($cmd_line[++$i], $cmd_line[++$i]);
             $this->multiple_filters = true;
          }
          else if ($arg =="bisac")
          {
             $this->SetFilterByBisac($cmd_line[++$i], $cmd_line[++$i]);
             $this->multiple_filters = true;
          }
          else if ($arg =="circ_mod")
          {
             $this->SetFilterByCircMod($cmd_line[++$i]);
             $this->multiple_filters = true;

          }
          else if ($arg =="due_date")
          {
             $due_type = $cmd_line[++$i];
             $this->SetFilterByDueDateType($due_type);

             if ($due_type == "before") $this->SetFilterByDueDate(null, $cmd_line[++$i]);
             else if ($due_type == "after") $this->SetFilterByDueDate($cmd_line[++$i], null);
             else if ($due_type == "between") $this->SetFilterByDueDate($cmd_line[++$i], $cmd_line[++$i]);

             $this->multiple_filters = true;
          }
          else if ($arg =="due_date_relative")
          {
             $due_type = $cmd_line[++$i];
             $this->SetFilterByDueDateType($due_type);

             if ($due_type == "before") $this->SetFilterByDueDateRelative(null, $cmd_line[++$i]);
             else if ($due_type == "after") $this->SetFilterByDueDateRelative($cmd_line[++$i], null);
             else if ($due_type == "between") $this->SetFilterByDueDateRelative($cmd_line[++$i], $cmd_line[++$i]);

             $this->multiple_filters = true;
          }
          else if ($arg =="prefix")
          {
             $this->SetFilterByCallPrefix($cmd_line[++$i]);
             $this->multiple_filters = true;
          }
          else if ($arg =="suffix")
          {
              $this->SetFilterByCallSuffix($cmd_line[++$i]);
              $this->multiple_filters = true;
          }
          else if ($arg =="only_holder")
          {
             $this->SetOnlyHolder($cmd_line[++$i]);
             $this->multiple_filters = true;
          }
          else if ($arg =="hold_count")
          {
             $this->SetFilterByHolds($cmd_line[++$i], $cmd_line[++$i]);
             $this->multiple_filters = true;
          }
          else if ($arg =="invoice_date")
          {
             $invoice_type = $cmd_line[++$i];
             $this->SetFilterByInvoiceDateType($invoice_type);

             if ($invoice_type == "before") $this->SetFilterByInvoiceDate(null, $cmd_line[++$i]);
             else if ($invoice_type == "after") $this->SetFilterByInvoiceDate($cmd_line[++$i], null);
             else if ($invoice_type == "between") $this->SetFilterByInvoiceDate($cmd_line[++$i], $cmd_line[++$i]);

             $this->multiple_filters = true;
          }
          else if ($arg == "invoice_date_relative")
          {
             $invoice_type = $cmd_line[++$i];
             $this->SetFilterByInvoiceDateType($invoice_type);

             if ($invoice_type == "before") $this->SetFilterByInvoiceDateRelative(null, $cmd_line[++$i]);
             else if ($invoice_type == "after") $this->SetFilterByInvoiceDateRelative($cmd_line[++$i], null);
             else if ($invoice_type == "between") $this->SetFilterByInvoiceDateRelative($cmd_line[++$i], $cmd_line[++$i]);

             $this->multiple_filters = true;
          }
          else if ($arg =="invoice_closed_date")
          {
             $invoice_closed_type = $cmd_line[++$i];
             $this->SetFilterByInvoiceClosedDateType($invoice_closed_type);

             if ($invoice_closed_type == "before") $this->SetFilterByInvoiceClosedDate(null, $cmd_line[++$i]);
             else if ($invoice_closed_type == "after") $this->SetFilterByInvoiceClosedDate($cmd_line[++$i], null);
             else if ($invoice_closed_type == "between") $this->SetFilterByInvoiceClosedDate($cmd_line[++$i], $cmd_line[++$i]);

             $this->multiple_filters = true;
          }
          else if ($arg == "invoice_closed_null")
          {
             $this->SetInvoiceClosedNull();
             $this->multiple_filters = true;
          }
          else if ($arg == "invoice_closed_date_relative")
          {
             $invoice_closed_type = $cmd_line[++$i];
             $this->SetFilterByInvoiceClosedDateType($invoice_closed_type);

             if ($invoice_closed_type == "before") $this->SetFilterByInvoiceClosedDateRelative(null, $cmd_line[++$i]);
             else if ($invoice_closed_type == "after") $this->SetFilterByInvoiceClosedDateRelative($cmd_line[++$i], null);
             else if ($invoice_closed_type == "between") $this->SetFilterByInvoiceClosedDateRelative($cmd_line[++$i], $cmd_line[++$i]);
             $this->multiple_filters = true;
          }
          else if ($arg =="order_date")
          {
             $order_type = $cmd_line[++$i];
             $this->SetFilterByOrderDateType($order_type);

             if ($order_type == "before") $this->SetFilterByOrderDate(null, $cmd_line[++$i]);
             else if ($order_type == "after") $this->SetFilterByOrderDate($cmd_line[++$i], null);
             else if ($order_type == "between") $this->SetFilterByOrderDate($cmd_line[++$i], $cmd_line[++$i]);
             $this->multiple_filters = true;
          }
          else if ($arg == "order_date_relative")
          {
             $order_type = $cmd_line[++$i];
             $this->SetFilterByOrderDateType($order_type);

             if ($order_type == "before") $this->SetFilterByOrderDateRelative(null, $cmd_line[++$i]);
             else if ($order_type == "after") $this->SetFilterByOrderDateRelative($cmd_line[++$i], null);
             else if ($order_type == "between") $this->SetFilterByOrderDateRelative($cmd_line[++$i], $cmd_line[++$i]);
             $this->multiple_filters = true;
          }
          else if ($arg == "order_date_null")
          {
             $this->SetOrderDateNull();
             $this->multiple_filters = true;
          }
          else if ($arg == "fund")
          {
              $this->SetFilterByFund($cmd_line[++$i]);
              $this->multiple_filters = true;
          }
          else if ($arg == "line_item_status")
          {
              $this->SetFilterByLineItemStatus($cmd_line[++$i]);
              $this->multiple_filters = true;
          }
          else if ($arg =="scope")
          {
             $this->SetScope();
          }
          else if ($arg == "domain")
          {
             $this->SetDomain($cmd_line[++$i]);
          }
          else if ($arg =="search_links")
          {
             $this->SetSearchLinks();
          }
          else if ($arg =="scheduled")
          {
             $this->SetScheduled();
          }
          else if ($arg == "collection")
          {
             $this->SetCollection();
          }
          else if ($arg == "popular")
          {
             //$this->SetCircDatesForPopular();
          }
          else if ($arg == "html" || $arg == "spreadsheet" || $arg == "rss" || $arg == "bucket" || $arg == "bookbag" || $arg == "copy_bucket" || $arg == "json")
          {
             //gone through all the filters ignore all output
             return;
          }
       }
    }

    function RequireCopyLocatonCheck()
    {
        if ($this->multiple_filters)
        {
           return false;
        }
        else
        {
           return true;
        }
    }

    function CheckFilters()
    {
       if ($this->use_all_copy_locations)
       {
           $sql ="SELECT COUNT (*)
	   		      FROM asset.copy
			      WHERE asset.copy.circ_lib IN (SELECT id FROM actor.org_unit where id = $this->library_id OR parent_ou = $this->library_id)  ";

	      if (!$this->deleted_items)        $sql.=" AND asset.copy.deleted = false ";

       }
       else
       {
          $location_string = "(".implode(",",$this->copy_locations).")";

          $sql ="SELECT COUNT (*)
	   		    FROM asset.copy
			    WHERE asset.copy.location IN $location_string ";

	      if (!$this->deleted_items)        $sql.=" AND asset.copy.deleted = false ";
       }

	   $result = pg_query($this->db,$sql);

       $row = pg_fetch_row($result);

       $loc_count = $row[0];

       return $loc_count ;

    }

    function CreateSQL()
    {
       //all copy vals, then all bib vals
       $sql="SELECT DISTINCT reporter.materialized_simple_record.title,
                             asset.call_number.record,
                             asset.copy.cost,
                             asset.copy.active_date,
                             asset.copy.create_date,
                             asset.copy.age_protect,
                             1,
                             asset.copy.barcode,
                             asset.copy.id,
                             asset.call_number.label,
                             asset.call_number.label_class,
                             asset.call_number.prefix,
                             asset.call_number.suffix,
                             asset.call_number.label_sortkey,
                             asset.copy.circ_modifier,
                             asset.copy.circ_lib,
                             asset.copy_location.name,
                             asset.copy.deleted,
                             asset.copy.edit_date,
                             asset.copy.deposit,
                             asset.copy.fine_level,
                             asset.copy.floating,
                             asset.copy.loan_duration,
                             asset.call_number.owning_lib,
                             asset.copy.price,
                             asset.copy.ref,
                             asset.copy.status,
                             asset.copy.status_changed_time,
                             reporter.materialized_simple_record.author,
                             reporter.materialized_simple_record.isbn,
                             reporter.materialized_simple_record.issn,
                             reporter.materialized_simple_record.publisher,
                             asset.call_number.id
                             FROM asset.copy
                             JOIN asset.call_number ON asset.copy.call_number = asset.call_number.id
                             JOIN reporter.materialized_simple_record ON reporter.materialized_simple_record.id = asset.call_number.record
                             JOIN asset.copy_location ON asset.copy.location = asset.copy_location.id ";

	    if ($this->filter_by_stat_cat)
		 {
			 $sql .=   "JOIN asset.stat_cat_entry_copy_map ON asset.stat_cat_entry_copy_map.owning_copy = asset.copy.id ";
		 }

		 if ($this->filter_by_item_tag)
		 {
		    $sql .="JOIN asset.copy_tag_copy_map ON asset.copy_tag_copy_map.copy = asset.copy.id ";
		 }

		 if ($this->use_invoice_sql || $this->use_po_sql || $this->use_line_item_sql || $this->use_fund_sql)
		 {
		     $sql .=" JOIN acq.lineitem_detail ON acq.lineitem_detail.eg_copy_id = asset.copy.id ";

		     if ($this->use_invoice_sql)
		     {
		        $sql .= "JOIN acq.invoice_entry ON acq.invoice_entry.lineitem = acq.lineitem_detail.lineitem
                       JOIN acq.invoice ON acq.invoice.id = acq.invoice_entry.invoice ";
		     }

		     if($this->use_po_sql || $this->use_line_item_sql)
		     {
		         $sql .="JOIN acq.lineitem ON acq.lineitem_detail.lineitem = acq.lineitem.id ";

		        if($this->use_po_sql)
		        {
		            $sql .="JOIN acq.purchase_order ON acq.lineitem.purchase_order = acq.purchase_order.id ";
		        }
		     }

		     if($this->use_fund_sql)
		     {
		         $sql .= "JOIN acq.fund ON acq.lineitem_detail.fund = acq.fund.id ";
		     }
		 }

	    if ($this->library_shortname == "NOBLE")
	    {
	       $sql .= "WHERE asset.copy.circ_lib NOT IN (36,37,38) "; //NOBLE OFFICE And COMCAT

		    if ($this->filter_by_pub_date)
		    {
		       if ($this->pub_date_type == "before")
             {
                $sql .= "AND reporter.materialized_simple_record.pubdate < '$this->published_before' ";
             }
             else if ($this->pub_date_type == "after")
             {
                $sql .= "AND reporter.materialized_simple_record.pubdate > '$this->published_after' ";
             }
             else if ($this->pub_date_type == "between")
             {
                $sql .= "AND reporter.materialized_simple_record.pubdate <= '$this->published_before' ";
                $sql .= "AND reporter.materialized_simple_record.pubdate >= '$this->published_after' ";
             }
         }
		 }
		 else
		 {
		    $sql .="WHERE asset.copy.circ_lib IN (SELECT id FROM actor.org_unit where id = $this->library_id OR parent_ou = $this->library_id) ";
		 }

		 if (!$this->use_all_copy_locations)
		 {
			 $location_string = "(".implode(",",$this->copy_locations).")";
			 $sql .="AND asset.copy.location IN $location_string ";
		 }
		 if ($this->active_items && !$this->deleted_items)
		 {
				$sql .= "AND asset.copy.deleted = false ";
		 }
		 else if (!$this->active_items && $this->deleted_items)
		 {
			  $sql .= "AND asset.copy.deleted = true ";

			  //add the filter by deleted date
			  if ($this->filter_by_deleted_date)
			  {
				  $after = date('Y-m-d', strtotime($this->deleted_date_after));
				  $before = date('Y-m-d', strtotime($this->deleted_date_before));
				  $sql .= "AND DATE(asset.copy.edit_date) BETWEEN '$after' AND '$before' ";
			  }
		 }

		 if ($this->filter_by_item_tag)
		 {
		     $tag_string = "(".implode(",",$this->item_tags).")";
		     $sql .= "AND asset.copy_tag_copy_map.tag IN $tag_string ";
		 }

		 if ($this->filter_by_status_change)
		 {
			 $after = date('Y-m-d', strtotime($this->last_status_after));
			 $before = date('Y-m-d', strtotime($this->last_status_before));
			 $sql .= "AND DATE(asset.copy.status_changed_time) BETWEEN '$after' AND '$before' ";
		 }

		 if ($this->use_shelf_sitting)
		 {
			  $sql .= "AND asset.copy.status = 0 ";
		 }
		 else if ($this->filter_by_status)
		 {
			 $status_string = "(".implode(",",$this->status).")";
			 $sql .= "AND asset.copy.status IN $status_string ";
		 }
		 else if ($this->filter_by_due_date)
		 {
			 $sql .= "AND asset.copy.status IN (1,16,3) ";
		 }

		 if ($this->filter_by_circ_mod)
		 {
			 $circ_mod_string = "('".implode("','",$this->circ_mod)."')";
			 $sql .= "AND asset.copy.circ_modifier IN $circ_mod_string ";
		 }

		 if ($this->filter_by_call_num_prefix)
		 {
			 $prefix_string = "(".implode(",",$this->call_num_prefix).")";
			 $sql .= "AND asset.call_number.prefix IN $prefix_string ";
		 }

		 if ($this->filter_by_call_num_suffix)
		 {
			 $suffix_string = "(".implode(",",$this->call_num_suffix).")";
			 $sql .= "AND asset.call_number.suffix IN $suffix_string ";
		 }

		 if ($this->filter_by_bib_file || $this->filter_by_isbn_file)
		 {
			 $bib_string = "(".implode(",",$this->file_bibs).")";
			 $sql .= "AND asset.call_number.record IN $bib_string ";
		 }

		 if ($this->filter_by_barcode_file)
		 {
			 $barcode_string = "('".implode("','",$this->file_barcodes)."')";
			 $sql .= "AND asset.copy.barcode IN $barcode_string ";
		 }

		 if ($this->filter_by_course)
		 {
		     $course_string = "(".implode(",",$this->course_copies).")";
		     $sql .= "AND asset.copy.id IN $course_string ";
		 }

		 if ($this->filter_by_added_date)
		 {
			 //if the dates are after the EG migration 5/1/12, then add to the SQL
			 $after = date('Y-m-d', strtotime($this->added_date_after));
			 $before = date('Y-m-d', strtotime($this->added_date_before));
			 $migration = date('Y-m-d', strtotime("5/25/2012"));

			 if ($migration < $after && $migration < $before)
			 {
				 $sql .="AND DATE(asset.copy.active_date) BETWEEN '$after' AND '$before' ";
			 }
		 }

		 if ($this->library_shortname == "NOBLE" && $this->filter_by_collection_topic)
		 {
		       $call_sql = "";
		       $sql .=" AND ( (asset.call_number.label_class = 3 ";

		       //Loop through all the LC Ones and make SQL
				 foreach ($this->call_range as $range)
				 {
					 if ($range['class'] == "LC" )//LC
					 {
						  $cmd = " perl /var/www/shared/perl/normalize_call.pl \"".$range['start']."\"";
						  $start= exec($cmd);

						  $cmd = " perl /var/www/shared/perl/normalize_call.pl \"".$range['end']."\"";
						  $end = exec($cmd);

						  $call_sql .= "( asset.call_number.label_sortkey >= '$start'
										   AND asset.call_number.label_sortkey < '$end' ) OR ";
					 }
				 }

				 //remove the last OR
				 $call_sql = rtrim($call_sql, "OR ");

				 $call_sql .= ")";

				 $sql .=" AND ( ".$call_sql. ") ";

				 $call_sql = "";
		         $sql .=" OR (asset.call_number.label_class = 2 ";

		         reset($this->call_range);
		         //Loop through all the LC Ones and make SQL
				 foreach ($this->call_range as $range)
				 {
					 if ($range['class'] == "DEWEY" )//Dewey
					 {
						  $start = $range['start'];
						  $end = $range['end'];

						  $call_sql .= "( asset.call_number.label_sortkey >= '$start'
										   AND asset.call_number.label_sortkey < '$end' ) OR ";
					 }
				 }

				 //remove the last OR
				 $call_sql = rtrim($call_sql, "OR ");

				 $call_sql .= ")";

				 $sql .=" AND ( ".$call_sql. ")) ";

		 }
		 else if ($this->filter_by_call_num)
		 {
			 if ($this->use_call_range)
			 {
				 $call_sql = "";
				 foreach ($this->call_range as $range)
				 {
					 if ($this->call_class == 3 )//LC
					 {
						  $cmd = " perl /var/www/tools/common/normalize_call.pl \"".$range['start']."\"";
						  $start= exec($cmd);

						  $cmd = " perl /var/www/tools/common/normalize_call.pl \"".$range['end']."\"";
						  $end = exec($cmd);
					 }
					 else
					 {
						 $start = strtoupper($range['start']);
						 $end = strtoupper($range['end']);
					 }

					 $call_sql .= "( asset.call_number.label_sortkey >= '$start'
									 AND asset.call_number.label_sortkey < '$end' )";

					 //this isn't the last element
					 if(end($this->call_range) != $range)
					 {
						 $call_sql .=" OR ";
					 }
				 }

				 $call_sql .= ")";

				 $sql .=" AND asset.call_number.label_class = $this->call_class
						  AND ( ".$call_sql. " ";

			 }
			 else if ($this->use_call_contains)
			 {
				 $sql .="AND asset.call_number.label_class = $this->call_class
						 AND asset.call_number.label_sortkey ILIKE '%$this->call_contains%' ";
			 }
			 else if ($this->filter_by_bisac)
			 {
				 $bisac = implode(" ", $this->bisac_category);
				 $bisac = preg_replace('/[^A-Za-z0-9. -]/', '', $bisac);
                 $bisac = preg_replace('/\s+/', ' ', $bisac);
				 $sql .="AND asset.call_number.label_class = $this->call_class
						 AND asset.call_number.label_sortkey ILIKE '$bisac%' ";
			 }
		 }

	    if ($this->filter_by_stat_cat)
		 {
			 $stat_string = "(".implode(",",$this->stat_cat_entries).")";
		     $sql .= "AND asset.stat_cat_entry_copy_map.stat_cat_entry IN $stat_string ";
		 }

		 if ($this->filter_by_invoice_date)
		 {
		    $after = date('Y-m-d', strtotime($this->invoice_date_after));
			 $before = date('Y-m-d', strtotime($this->invoice_date_before));

			 $sql .="AND DATE(acq.invoice.recv_date) BETWEEN '$after' AND '$before' ";
		 }

		 if($this->filter_by_invoice_closed_date && strlen($this->invoice_closed_date_after) > 0)
		 {
		     $after = date('Y-m-d', strtotime($this->invoice_closed_date_after));
			 $before = date('Y-m-d', strtotime($this->invoice_closed_date_before));

			 $sql .="AND DATE(acq.invoice.close_date) BETWEEN '$after' AND '$before' ";
		 }

		 if($this->filter_by_order_date  && !$this->no_order_date)
		 {
		     $after = date('Y-m-d', strtotime($this->order_date_after));
			 $before = date('Y-m-d', strtotime($this->order_date_before));

			 $sql .="AND DATE(acq.purchase_order.order_date) BETWEEN '$after' AND '$before' ";
		 }

		 if($this->filter_by_line_item_status)
		 {
		    $lineitem_status_string = "('".implode("','",$this->line_item_status)."')";
			 $sql .= "AND acq.lineitem.state IN $lineitem_status_string ";
		 }

		 if($this->filter_by_fund)
		 {
		    $fund_string = "(".implode(",",$this->fund).")";
			 $sql .= "AND acq.fund.id IN $fund_string ";
		 }

		 if($this->GetCollection())
		 {
		    $sql .="ORDER BY asset.call_number.label_sortkey, reporter.materialized_simple_record.author, reporter.materialized_simple_record.title";
		 }
		 else
		 {
		    $sql .="ORDER BY asset.copy_location.name, asset.call_number.label_sortkey, reporter.materialized_simple_record.author, reporter.materialized_simple_record.title";
		 }
		 //$sql .= " LIMIT 40 ";

		 //echo $sql."\n\n";

		 return $sql;

    }

    function LookForPhysicalCopies()
    {
       return $this->physical_items;
    }

    function LookForOnlineRecords()
    {
       if ($this->electronic_items)
       {
          if ($this->GetFilterByBibFile() || $this->GetFilterByISBNFile() || $this->GetFilterByAdded()) return true;
          else return false;
       }
       else
       {
          return false;
       }
    }

    function CreateOnlineSQL()
    {
		 $sql="SELECT DISTINCT  reporter.materialized_simple_record.title,
										reporter.materialized_simple_record.author,
										reporter.materialized_simple_record.isbn,
										reporter.materialized_simple_record.issn,
										reporter.materialized_simple_record.publisher,
										asset.call_number.record,
										asset.uri.href,
										asset.uri.label,
										actor.org_unit.shortname,
										asset.call_number.create_date
										FROM asset.call_number
										JOIN reporter.materialized_simple_record ON reporter.materialized_simple_record.id = asset.call_number.record
										JOIN asset.uri_call_number_map ON asset.call_number.id = asset.uri_call_number_map.call_number
                              JOIN asset.uri ON asset.uri_call_number_map.uri = asset.uri.id
                              JOIN actor.org_unit ON asset.call_number.owning_lib = actor.org_unit.id
										WHERE asset.call_number.deleted = false
										AND  asset.call_number.label ILIKE '%URI%' ";

	    if ($this->library_shortname != "NOBLE")
	    {
	       $sql .= "AND (asset.call_number.owning_lib  IN (SELECT id FROM actor.org_unit where id = $this->library_id OR parent_ou = $this->library_id)
	                OR asset.call_number.owning_lib = 1) ";
	    }

		 if ($this->filter_by_bib_file || $this->filter_by_isbn_file)
		 {
			 $bib_string = "(".implode(",",$this->file_bibs).")";
			 $sql .= "AND asset.call_number.record IN $bib_string ";
		 }

	    if ($this->filter_by_added_date)
		 {
			 //if either date is before 6/5/2020, set to that
			 $update = date('Y-m-d', strtotime("6/05/2020"));
			 $after = date('Y-m-d', strtotime($this->added_date_after));
			 if ($after < $update) $after = $update;
			 $before = date('Y-m-d', strtotime($this->added_date_before));

			 $sql .="AND DATE(asset.call_number.create_date) BETWEEN '$after' AND '$before' ";
		 }

		 $sql .="ORDER BY reporter.materialized_simple_record.title, reporter.materialized_simple_record.author";
		 //$sql .= " LIMIT 1000 ";

		 echo $sql."\n\n";
		 return $sql;
    }


    function GetTypeForEmail()
    {
        if($this->GetShelfSitter()) return "Shelf Sitter";
        else return "Inventory/Booklist";
    }

    function GetTextForEmail()
    {
       $message = "FILTERS\n";

       $message .="Library = ".$this->GetLibrary()."\n";
       if ($this->GetFilterByCopyLocationGroup())
       {
          $message .="Shelving Location Group = ".$this->GetCopyLocationGroupName()."\n";
       }
       else
       {
          $message .="Shelving Location = ".$this->GetCopyLocations(' , ')."\n";
       }

       if ( $this->GetShelfSitter() ) $message .="Sitting on Shelf since = ".$this->GetShelfSitter()."\n";
       if ( $this->GetFilterByPubDate() ) $message .="Published ".$this->GetFilterByPubDateText()."\n";//will return the right string
       if ( $this->GetFilterByBibFile() ) $message .="Input Bib File = ".$this->GetFilterByBibFile()."\n";
       if ( $this->GetFilterByBarcodeFile() ) $message .="Input Barcode File = ".$this->GetFilterByBarcodeFile()."\n";
       if ( $this->GetFilterByISBNFile() ) $message .="Input ISBN File = ".$this->GetFilterByISBNFile()."\n";
       if ( $this->GetFilterByAdded() )
       {
          if ($this->GetFilterByAddedType() == "after") $message .="Added After = ".$this->GetAddedAfter()."\n";
          else if ($this->GetFilterByAddedType() == "before") $message .="Added Before = ".$this->GetAddedBefore()."\n";
          else if ($this->GetFilterByAddedType() == "between") $message .="Added Between = ".$this->GetAddedAfter()." and ".$this->GetAddedBefore()."\n";

       }
       if ( $this->GetStatCats('') ) $message .="Stat Cats = ".$this->GetStatCats(' , ')."\n";
       if ( $this->GetCallClass() ) $message .="Call Number Class = ".$this->GetCallClass()."\n";
       if ( $this->GetCallContains() ) $message .="Call Number Contains = ".$this->GetCallContains()."\n";
       if ( $this->GetCallRange() ) $message .="Call Number Range = ".$this->GetCallRange()."\n";
       if ( $this->GetFilterByBisac('') ) $message .="Bisac Call Number = ".$this->GetFilterByBisac('/')."\n";
       if ( $this->GetFilterByCollection('') ) $message .="Collection Topics = ".$this->GetFilterByCollection(' , ')."\n";
       if ( $this->GetFilterByCallPrefix('') ) $message .="Call Number Prefix = ".$this->GetFilterByCallPrefix(' , ')."\n";
       if ( $this->GetFilterByCallSuffix('') ) $message .="Call Number Suffix = ".$this->GetFilterByCallSuffix(' , ')."\n";
       if ( $this->GetFilterByCircMod('') ) $message .="Circ Modifier = ".$this->GetFilterByCircMod(' , ')."\n";
       if ( $this->GetFilterByItemTag('') ) $message .="Item Tags = ".$this->GetItemTags(' , ')."\n";
       if ( $this->GetFilterByStatus('') ) $message .="Status = ".$this->GetFilterByStatus(' , ')."\n";

       if ( $this->GetFilterByStatusChanged() )
       {
          if ($this->GetFilterByLastStatusType() == "after") $message .="Last Status Change After = ".$this->GetStatusChangeAfter()."\n";
          else if ($this->GetFilterByLastStatusType() == "before") $message .="Last Status Change Before = ".$this->GetStatusChangeBefore()."\n";
          else if ($this->GetFilterByLastStatusType() == "between") $message .="Last Status Change Between = ".$this->GetStatusChangeAfter()." and ".$this->GetStatusChangeBefore()."\n";

       }

       if ($this->GetFilterByCircCount())
       {
          if ($this->GetCircCountCompare() == "less") $message .="Less than ".$this->GetCircCountVal()." Circs\n";
          else if ($this->GetCircCountCompare() == "more") $message .="More than ".$this->GetCircCountVal()." Circs\n";
       }

       if ( $this->GetFilterByCircDate() )
       {
          if ($this->GetFilterByCircType() == "after") $message .="Circulated After = ".$this->GetCircAfter()."\n";
          else if ($this->GetFilterByCircType() == "before") $message .="Circulated Before = ".$this->GetCircBefore()."\n";
          else if ($this->GetFilterByCircType() == "between") $message .="Circulated Between = ".$this->GetCircAfter()." and ".$this->GetCircBefore()."\n";

       }

       if ( $this->GetFilterByDueDate() )
       {
          if ($this->GetFilterByDueDateType() == "after") $message .="Due Date After = ".$this->GetDueDateAfter()."\n";
          else if ($this->GetFilterByDueDateType() == "before") $message .="Due Date Before = ".$this->GetDueDateBefore()."\n";
          else if ($this->GetFilterByDueDateType() == "between") $message .="Due Date Between = ".$this->GetDueDateAfter()." and ".$this->GetDueDateBefore()."\n";
       }

       if ( $this->GetFilterByCourse() ) $message .="Courses = ".$this->GetCourses(' , ')."\n";


       $message .="Deleted? = ".$this->GetFilterByDeleted()."\n";
       if ( $this->GetFilterByDeletedDate() )
       {
          if ($this->GetFilterByDeletedDateType() == "after") $message .="Deleted After = ".$this->GetFilterByDeletedDateAfter()."\n";
          else if ($this->GetFilterByDeletedDateType() == "before") $message .="Deleted Before = ".$this->GetFilterByDeletedDateBefore()."\n";
          else if ($this->GetFilterByDeletedDateType() == "between") $message .="Deleted Between = ".$this->GetFilterByDeletedDateAfter()." and ".$this->GetFilterByDeletedDateBefore()."\n";

       }

       if ( $this->GetFilterByHolds() )
       {
          if ($this->GetHoldLocation() == "my") $message .= "Holds= More than ".$this->GetHoldCount()." at My Library\n";
          else if ($this->GetHoldLocation() == "all") $message .="Holds= More than   ".$this->GetHoldCount()." at Any Library\n";
       }

       if ( $this->GetFilterByInventoryDate() )
       {
          if ($this->GetFilterByInventoryDateType() == "after")
          {
             $message .="Inventoried After = ".$this->GetFilterByInventoryDateAfter()."\n";
          }
          else if ($this->GetFilterByInventoryDateType() == "before")
          {
             $message .="Inventoried Before = ".$this->GetFilterByInventoryDateBefore()."\n";
             if ($this->GetInventoryNull()) $message .= "Include Items with No Inventory Date\n";
          }
          else if ($this->GetFilterByInventoryDateType() == "between")
          {
             $message .="Inventoried Between = ".$this->GetFilterByInventoryDateAfter()." and ".$this->GetFilterByInventoryDateBefore()."\n";
          }
          else if ($this->GetInventoryNull())
          {
             $message .= "Inventory Date: NONE \n";
          }
       }

       if ( $this->GetFilterByInvoiceDate() )
       {
          if ($this->GetFilterByInvoiceDateType() == "after") $message .="Invoice Date After = ".$this->GetFilterByInvoiceDateAfter()."\n";
          else if ($this->GetFilterByInvoiceDateType() == "before") $message .="Invoice Date Before = ".$this->GetFilterByInvoiceDateBefore()."\n";
          else if ($this->GetFilterByInvoiceDateType() == "between") $message .="Invoice Date Between = ".$this->GetFilterByInvoiceDateAfter()." and ".$this->GetFilterByInvoiceDateBefore()."\n";

       }

       if ( $this->GetFilterByInvoiceClosedDate() )
       {
          if ($this->GetFilterByInvoiceClosedDateType() == "after")
          {
             $message .="Invoice Closed Date After = ".$this->GetFilterByInvoiceClosedDateAfter()."\n";
          }
          else if ($this->GetFilterByInvoiceClosedDateType() == "before")
          {
             $message .="Invoice Closed Date Before = ".$this->GetFilterByInvoiceClosedDateBefore()."\n";
             if ($this->GetInvoiceClosedNull()) $message .= "Include Items with No Invoice Closed Date\n";
          }
          else if ($this->GetFilterByInvoiceClosedDateType() == "between")
          {
             $message .="Invoice Closed Date Between = ".$this->GetFilterByInvoiceClosedDateAfter()." and ".$this->GetFilterByInvoiceClosedDateBefore()."\n";
          }
          else if ($this->GetInvoiceClosedNull())
          {
             $message .= "Invoice Closed Date: NONE\n";
          }
       }

       if ( $this->GetFilterByOrderDate() )
       {
          if ($this->GetFilterByOrderDateType() == "after") $message .="Order Date After = ".$this->GetFilterByOrderDateAfter()."\n";
          else if ($this->GetFilterByOrderDateType() == "before") $message .="Order Date Before = ".$this->GetFilterByOrderDateBefore()."\n";
          else if ($this->GetFilterByOrderDateType() == "between") $message .="Order Date Between = ".$this->GetFilterByOrderDateAfter()." and ".$this->GetFilterByOrderDateBefore()."\n";
          else if ($this->GetOrderDateNull()) $message .= "Order Date: NONE \n";
       }

       if ($this->GetFilterByLineItemStatus(''))  $message .="Lineitem Status = ".$this->GetFilterByLineItemStatus(' , ')."\n";
       if ($this->GetFilterByFund('')) $message .="Fund = ".$this->GetFilterByFund(' , ')."\n";

       if ($this->GetFilterByBibFile() || $this->GetFilterByISBNFile() || $this->GetFilterByAdded())
       {
          $message .="Electronic? = ".$this->GetFilterByElectronic()."\n";
       }

       if($this->GetOnlyHolder())
       {
          if($this->only_holder_option)
          {
             $message .="Filter By Only Holder\n";
          }
          else if (!$this->only_holder_option)
          {
             $message .="Filter By NOT Only Holder\n";
          }

       }

       if ($this->GetScope() > 1)  $message .="Scoped Links\n";
       if ($this->GetDomain() != "evergreen" )  $message .="SubDomain =".$this->GetDomain()."\n";
       if ($this->GetSearchLinks())  $message .="Search Links\n";

       return $message;

    }

    function GetTextForPreview()
    {
       $message = "FILTERS<br/>";

       $message .="Library = ".$this->GetLibrary()."<br/>";

       if ($this->GetFilterByCopyLocationGroup())
       {
          $message .="Shelving Location Group = ".$this->GetCopyLocationGroupName()."<br/>";
       }
       else
       {
          $message .="Shelving Location = ".$this->GetCopyLocations(', ')."<br/>";
       }

       if ( $this->GetShelfSitter() ) $message .="Sitting on Shelf since = ".$this->GetShelfSitter()."<br/>";
       if ( $this->GetFilterByPubDate() ) $message .="Published Before = ".$this->GetFilterByPubDate()."<br/>";
       if ( $this->GetFilterByBibFile() ) $message .="Input Bib File = ".$this->GetFilterByBibFile()."<br/>";
       if ( $this->GetFilterByBarcodeFile() ) $message .="Input Barcode File = ".$this->GetFilterByBarcodeFile()."<br/>";
       if ( $this->GetFilterByISBNFile() ) $message .="Input ISBN File = ".$this->GetFilterByISBNFile()."<br />";
       if ( $this->GetFilterByAdded() ) $message .="Added Between = ".$this->GetAddedAfter()." and ".$this->GetAddedBefore()."<br/>";
       if ( $this->GetStatCats('') ) $message .="Stat Cats = ".$this->GetStatCats(' , ')."<br/>";
       if ( $this->GetCallClass() ) $message .="Call Number Class = ".$this->GetCallClass()."<br/>";
       if ( $this->GetCallContains() ) $message .="Call Number Contains = ".$this->GetCallContains()."<br/>";
       if ( $this->GetCallRange() ) $message .="Call Number Range = ".$this->GetCallRange()."<br/>";
       if ( $this->GetFilterByBisac('') ) $message .="Bisac Call Number = ".$this->GetFilterByBisac('/')."\n";
       if ( $this->GetFilterByCollection('') ) $message .="Collection Topics = ".$this->GetFilterByCollection(' , ')."<br/>";
       if ( $this->GetFilterByCallPrefix('') ) $message .="Call Number Prefix = ".$this->GetFilterByCallPrefix(' , ')."<br/>";
       if ( $this->GetFilterByCallSuffix('') ) $message .="Call Number Suffix = ".$this->GetFilterByCallSuffix(' , ')."<br/>";
       if ( $this->GetFilterByCircMod('') ) $message .="Circ Modifier = ".$this->GetFilterByCircMod(' , ')."<br/>";
       if ( $this->GetFilterByStatus('') ) $message .="Status = ".$this->GetFilterByStatus(' , ')."<br/>";
       if ( $this->GetFilterByStatusChanged() ) $message .="Last Status Change Before = ".$this->GetFilterByStatusChanged()."<br/>";

       $message .="Deleted? = ".$this->GetFilterByDeleted()."<br/>";;
       $message .="Electronic? = ".$this->GetFilterByElectronic()."<br/>";

       if ($this->GetScope() > 1)  $message .="Scoped Links<br/>";
       if ($this->GetDomain() != "evergreen")  $message .="SubDomain =".$this->GetDomain()."<br/>";
       if ($this->GetSearchLinks())  $message .="Search Links<br/>";

       return $message;

    }

    function GetHTMLText()
    {
       $html = "<h3>Filters</h3>";

       if ($this->GetFilterByCopyLocationGroup())
       {
          $html .="Shelving Location Group = ".$this->GetCopyLocationGroupName()."<br/>";
       }
       else
       {
          $html .="Shelving Location = ".$this->GetCopyLocations(', ')."<br/>";
       }

       if ( $this->GetShelfSitter() ) $html .="Sitting on Shelf since: ".$this->GetShelfSitter()."<br />";
       if ( $this->GetFilterByPubDate() ) $html .="Published: ".$this->GetFilterByPubDateText()."<br />";//will return the right string
       if ( $this->GetFilterByBibFile() ) $html .="Input Bib File:".$this->GetFilterByBibFile()."<br />";
       if ( $this->GetFilterByBarcodeFile() ) $html .="Input Barcode File: ".$this->GetFilterByBarcodeFile()."<br />";
       if ( $this->GetFilterByISBNFile() ) $html .="Input ISBN File = ".$this->GetFilterByISBNFile()."<br />";
       if ( $this->GetFilterByAdded() )
       {
          if ($this->GetFilterByAddedType() == "after") $html .="Added After: ".$this->GetAddedAfter()."<br />";
          else if ($this->GetFilterByAddedType() == "before") $html .="Added Before: ".$this->GetAddedBefore()."<br />";
          else if ($this->GetFilterByAddedType() == "between") $html .="Added Between: ".$this->GetAddedAfter()." and ".$this->GetAddedBefore()."<br />";

       }
       if ( $this->GetStatCats('') ) $html .="Stat Cats: ".$this->GetStatCats(' , ')."<br />";
       if ( $this->GetCallClass() ) $html .="Call Number Class: ".$this->GetCallClass()."<br />";
       if ( $this->GetCallContains() ) $html .="Call Number Contains: ".$this->GetCallContains()."<br />";
       if ( $this->GetCallRange() ) $html .="Call Number Range: ".$this->GetCallRange()."<br />";
       if ( $this->GetFilterByBisac('') ) $html .="Bisac Call Number: ".$this->GetFilterByBisac('/')."<br />";
       if ( $this->GetFilterByCollection('') ) $html .="Collection Topics: ".$this->GetFilterByCollection(' , ')."<br />";
       if ( $this->GetFilterByCallPrefix('') ) $html .="Call Number Prefix: ".$this->GetFilterByCallPrefix(' , ')."<br />";
       if ( $this->GetFilterByCallSuffix('') ) $html .="Call Number Suffix: ".$this->GetFilterByCallSuffix(' , ')."<br />";
       if ( $this->GetFilterByCircMod('') ) $html .="Circ Modifier: ".$this->GetFilterByCircMod(' , ')."<br />";
       if ( $this->GetFilterByItemTag('') ) $html .="Item Tag: ".$this->GetItemTags(' , ')."<br />";
       if ( $this->GetFilterByStatus('') ) $html .="Status: ".$this->GetFilterByStatus(' , ')."<br />";

       if ( $this->GetFilterByStatusChanged() )
       {
          if ($this->GetFilterByLastStatusType() == "after") $html .="Last Status Change After: ".$this->GetStatusChangeAfter()."<br />";
          else if ($this->GetFilterByLastStatusType() == "before") $html .="Last Status Change Before: ".$this->GetStatusChangeBefore()."<br />";
          else if ($this->GetFilterByLastStatusType() == "between") $html .="Last Status Change Between: ".$this->GetStatusChangeAfter()." and ".$this->GetStatusChangeBefore()."<br />";

       }

       if ($this->GetFilterByCircCount())
       {
          if ($this->GetCircCountCompare() == "less") $html .="Less than ".$this->GetCircCountVal()." Circs<br />";
          else if ($this->GetCircCountCompare() == "more") $html .="More than ".$this->GetCircCountVal()." Circs<br />";
       }

       if ( $this->GetFilterByCircDate() )
       {
          if ($this->GetFilterByCircType() == "after") $html .="Circulated After = ".$this->GetCircAfter()."<br />";
          else if ($this->GetFilterByCircType() == "before") $html .="Circulated Before = ".$this->GetCircBefore()."<br />";
          else if ($this->GetFilterByCircType() == "between") $html .="Circulated Between = ".$this->GetCircAfter()." and ".$this->GetCircBefore()."<br />";
       }

       $html .="Deleted?: ".$this->GetFilterByDeleted()."<br />";
       if ( $this->GetFilterByDeletedDate() )
       {
          if ($this->GetFilterByDeletedDateType() == "after") $html .="Deleted After: ".$this->GetFilterByDeletedDateAfter()."<br />";
          else if ($this->GetFilterByDeletedDateType() == "before") $html .="Deleted Before: ".$this->GetFilterByDeletedDateBefore()."<br />";
          else if ($this->GetFilterByDeletedDateType() == "between") $html .="Deleted Between: ".$this->GetFilterByDeletedDateAfter()." and ".$this->GetFilterByDeletedDateBefore()."<br />";
       }

       if ( $this->GetFilterByDueDate() )
       {
          if ($this->GetFilterByDueDateType() == "after") $html .="Due Date After = ".$this->GetDueDateAfter()."<br />";
          else if ($this->GetFilterByDueDateType() == "before") $html .="Due Date Before = ".$this->GetDueDateBefore()."<br />";
          else if ($this->GetFilterByDueDateType() == "between") $html .="Due Date Between = ".$this->GetDueDateAfter()." and ".$this->GetDueDateBefore()."<br />";

       }

       if ( $this->GetFilterByHolds() )
       {
          if ($this->GetHoldLocation() == "my") $html .= "Holds= More than ".$this->GetHoldCount()." at My Library<br />";
          else if ($this->GetHoldLocation() == "all") $html .="Holds= More than   ".$this->GetHoldCount()." at Any Library<br />";
       }

       if ( $this->GetFilterByInventoryDate() )
       {
          if ($this->GetFilterByInventoryDateType() == "after")
          {
             $html .="Inventoried After = ".$this->GetFilterByInventoryDateAfter()."<br />";
          }
          else if ($this->GetFilterByInventoryDateType() == "before")
          {
             $html .="Inventoried Before = ".$this->GetFilterByInventoryDateBefore()."<br />";
             if ($this->GetInventoryNull()) $html .= "Include Items with No Inventory Date<br />";
          }
          else if ($this->GetFilterByInventoryDateType() == "between")
          {
             $html .="Inventoried Between = ".$this->GetFilterByInventoryDateAfter()." and ".$this->GetFilterByInventoryDateBefore()."<br />";
          }
          else if ($this->GetInventoryNull())
          {
             $html .= "Inventory Date: NONE <br />";
          }
       }

       if ( $this->GetFilterByInvoiceDate() )
       {
          if ($this->GetFilterByInvoiceDateType() == "after") $html .="Invoice Date After = ".$this->GetInvoiceAfter()."<br />";
          else if ($this->GetFilterByInvoiceDateType() == "before") $html .="Invoice Date Before = ".$this->GetInvoiceBefore()."<br />";
          else if ($this->GetFilterByInvoiceDateType() == "between") $html .="Invoice Date Between = ".$this->GetInvoiceAfter()." and ".$this->GetInvoiceBefore()."<br />";
          if ($this->GetInvoiceClosedNull()) $html .= "Include Items with No Invoice Closed Date <br />";
       }

       if ( $this->GetFilterByInvoiceClosedDate() )
       {
          if ($this->GetFilterByInvoiceClosedDateType() == "after")
          {
             $html .="Invoice Closed Date After = ".$this->GetFilterByInvoiceClosedDateAfter()."<br />";
          }
          else if ($this->GetFilterByInvoiceClosedDateType() == "before")
          {
             $html .="Invoice Closed Date Before = ".$this->GetFilterByInvoiceClosedDateBefore()."<br />";
             if ($this->GetInvoiceClosedNull()) $html .= "Include Items with No Invoice Closed Date <br />";
          }
          else if ($this->GetFilterByInvoiceClosedDateType() == "between")
          {
             $html .="Invoice Closed Date Between = ".$this->GetFilterByInvoiceClosedDateAfter()." and ".$this->GetFilterByInvoiceClosedDateBefore()."<br />";
          }
          else if ($this->GetInvoiceClosedNull())
          {
             $html .= "Invoice Closed Date: NONE <br />";
          }
       }

       if ( $this->GetFilterByOrderDate() )
       {
          if ($this->GetFilterByOrderDateType() == "after") $html .="Order Date After = ".$this->GetFilterByOrderDateAfter()."<br />";
          else if ($this->GetFilterByOrderDateType() == "before") $html .="Order Date Before = ".$this->GetFilterByOrderDateBefore()."<br />";
          else if ($this->GetFilterByOrderDateType() == "between") $html .="Order Date Between = ".$this->GetFilterByOrderDateAfter()." and ".$this->GetFilterByOrderDateBefore()."<br />";
          else if ($this->GetOrderDateNull()) $html .= "Order Date: NONE <br />";
       }

       if ($this->GetFilterByLineItemStatus('')) $html .="Lineitem Status: ".$this->GetFilterByLineItemStatus(' , ')."<br />";
       if ($this->GetFilterByFund(''))$html .="Fund: ".$this->GetFilterByFund(' , ')."<br />";


       $html .="Electronic? = ".$this->GetFilterByElectronic()."<br />";

       if ($this->GetScope() > 1)  $html .="Scoped Links<br />";
       if ($this->GetDomain() != "evergreen")  $html .="SubDomain =".$this->GetDomain()."<br />";
       if ($this->GetSearchLinks())  $html .="Search Links<br />";

       return $html;

    }

}

?>