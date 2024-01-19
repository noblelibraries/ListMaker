<?php

include "Excel_Output_Options.php";
include "HTML_Output_Options.php";
include "RSS_Output_Options.php";
include "Bucket_Output_Options.php";
include "JSON_Output_Options.php";

class Output_Options
{
   public $wrte_html;
   public $html;

   public $write_spreadsheet;
   public $spreadsheet;

   public $write_rss;
   public $rss;

   public $write_bucket;
   public $bucket;

   public $write_copy_bucket;
   public $copy_bucket;

   public $write_json;
   public $json;

   public $email_addresses;
   public $output_filename;
   public $use_custom_filename;
   public $save_file_name;

   public $use_report_name;
   public $report_name;

   public $show_deleted;
   public $no_email;

   public $collection;
   public $collection_code;
   public $recent;
   public $popular;

   function __construct()
   {
      $this->write_html = false;
      $this->write_spreadsheet = false;
      $this->write_rss = false;
      $this->write_bucket = false;
      $this->write_copy_bucket = false;
      $this->write_json = false;
      $this->use_custom_filename = false;

      $this->show_deleted = false;
      $this->no_email = false;

      $this->collection = false;
      $this->recent = false;
      $this->popular = false;

      $this->email_addresses = array();

      $this->use_report_name = false;
      $this->report_name = "";
      $this->save_report_name = true;
      $this->report_save_name ="";
   }

   function __destruct()
   {
      unset($this->email_addresses);
   }

   function SetShowDeleted()
   {
      $this->show_deleted = true;
   }

   function GetShowDeleted()
   {
      return $this->show_deleted;
   }

   function CreateOutputOptionsFromString($cmd_line)
   {
      $temp = explode(" ",$cmd_line);
      $this->CreateOutputOptions($temp);
   }

   function CreateOutputOptions($cmd_line)
   {
       $html_opts = false;
       $sheet_opts = false;
       $rss_opts = false;
       $bucket_opts = false;
       $copy_bucket_opts = false;
       $json_opts = false;

       for ($i=0; $i < count($cmd_line); $i++)
       {
          $arg = $cmd_line[$i];

          if ($arg == "email")
          {
             $this->email_addresses[] = $cmd_line[++$i];
          }
          else if ($arg == "out_file")
          {
             $this->output_filename = $cmd_line[++$i];
             $this->use_custom_filename = true;
          }
          else if ($arg == "report_name")
          {
             $this->report_name = $cmd_line[++$i];
             $this->use_report_name = true;
          }
          else if ($arg == "save_file_name")
          {
             $this->save_file_name = true;
          }
          else if ($arg == "collection")
          {
             $this->collection = true;
             $this->collection_code =  $cmd_line[++$i];
          }
          else if ($arg == "recent")
          {
             $this->recent = true;
          }
          else if ($arg == "popular")
          {
             $this->popular = true;
          }
          else if ($arg == "html")
          {
             $html_opts = true;
             $sheet_opts = false;
             $rss_opts = false;
             $bucket_opts = false;

             $this->write_html = true;
             $this->html = new HTML_Output_Options();

          }
          else if ($arg == "spreadsheet")
          {
             $html_opts = false;
             $sheet_opts = true;
             $rss_opts = false;
             $bucket_opts = false;
             $copy_bucket_opts = false;
             $json_opts = false;

             $this->write_spreadsheet = true;
             $this->spreadsheet = new Excel_Output_Options();
          }
          else if ($arg == "rss")
          {
             $html_opts = false;
             $sheet_opts = false;
             $rss_opts = true;
             $bucket_opts = false;
             $copy_bucket_opts = false;
             $json_opts = false;

             $this->write_rss = true;
             $this->rss = new RSS_Output_Options();
          }
          else if ($arg == "bucket" || $arg == "bookbag")
          {
             $html_opts = false;
             $sheet_opts = false;
             $rss_opts = false;
             $bucket_opts = true;
             $copy_bucket_opts = false;
             $json_opts = false;

             $this->write_bucket = true;
             $this->bucket = new Bucket_Output_Options();
          }
          else if ($arg == "copy_bucket")
          {
             $html_opts = false;
             $sheet_opts = false;
             $rss_opts = false;
             $bucket_opts = false;
             $copy_bucket_opts = true;
             $json_opts = false;

             $this->write_copy_bucket = true;
             $this->copy_bucket = new Bucket_Output_Options();
             $this->copy_bucket->SetCopyBucket();
          }
          else if ($arg == "json")
          {
             $html_opts = false;
             $sheet_opts = false;
             $rss_opts = false;
             $bucket_opts = false;
             $copy_bucket_opts = false;
             $json_opts = true;

             $this->write_json = true;
             $this->json = new JSON_Output_Options();
          }
          else if ($arg == "author_sort")
          {
             if ($html_opts) $this->html->SetAuthorSort();
             else if ($sheet_opts) $this->spreadsheet->SetAuthorSort();
          }
          else if ($arg == "active_sort")
          {
             if ($html_opts) $this->html->SetActiveDateSort();
             else if ($sheet_opts) $this->spreadsheet->SetActiveDateSort();
          }
          else if ($arg == "call_sort")
          {
             if ($html_opts) $this->html->SetCallNumSort();
             else if ($sheet_opts) $this->spreadsheet->SetCallNumSort();
          }
          else if ($arg == "circ_sort")
          {
             if ($html_opts) $this->html->SetLifetimeCircSort();
             else if ($sheet_opts) $this->spreadsheet->SetLifetimeCircSort();
          }
          else if ($arg == "circ_between_sort")
          {
             if ($html_opts) $this->html->SetCircBetweenSort();
             else if ($sheet_opts) $this->spreadsheet->SetCircBetweenSort();
          }
          else if ($arg == "title_sort")
          {
             if ($html_opts) $this->html->SetTitleSort();
             else if ($sheet_opts) $this->spreadsheet->SetTitleSort();
          }
          else if ($arg == "ytd_sort")
          {
             if ($html_opts) $this->html->SetYTDCircSort();
             else if ($sheet_opts) $this->spreadsheet->SetYTDCircSort();
          }
          else if ($arg == "acq_cost")
          {
             if ($sheet_opts) $this->spreadsheet->SetAcqCost();
          }
          else if ($arg == "active")
          {
             if ($html_opts) $this->html->SetActiveDate();
             else if ($sheet_opts) $this->spreadsheet->SetActiveDate();
          }
          else if ($arg == "age_protect")
          {
             if ($html_opts) $this->html->SetAgeProtection();
             else if ($sheet_opts) $this->spreadsheet->SetAgeProtection();
          }
          else if ($arg == "alert")
          {
             if ($html_opts) $this->html->SetAlertMessage();
             else if ($sheet_opts) $this->spreadsheet->SetAlertMessage();
          }
          else if ($arg == "amz_direct")
          {
             if ($html_opts) $this->html->SetAmazonDirect();
             else if ($sheet_opts) $this->spreadsheet->SetAmazonDirect();
          }
          else if ($arg == "amz_search")
          {
             if ($html_opts) $this->html->SetAmazonSearch();
             else if ($sheet_opts) $this->spreadsheet->SetAmazonSearch();
          }
          else if ($arg == "author")
          {
             if ($html_opts) $this->html->SetAuthor();
             else if ($sheet_opts) $this->spreadsheet->SetAuthor();
          }
          else if ($arg == "barcode")
          {
             if ($html_opts) $this->html->SetBarcode();
             else if ($sheet_opts) $this->spreadsheet->SetBarcode();
          }
          else if ($arg == "bib_id")
          {
             if ($html_opts) $this->html->SetBibId();
             else if ($sheet_opts) $this->spreadsheet->SetBibId();
             else if($json_opts) $this->json->SetUseBib();
          }
          else if ($arg == "call_class")
          {
             if ($sheet_opts) $this->spreadsheet->SetCallClass();
          }
          else if ($arg == "call_num")
          {
             if ($html_opts) $this->html->SetCallNumber();
             else if ($sheet_opts) $this->spreadsheet->SetCallNumber();
          }
          else if ($arg == "prefix")
          {
             if ($sheet_opts) $this->spreadsheet->SetCallPrefix();
          }
          else if ($arg == "suffix")
          {
             if ($sheet_opts) $this->spreadsheet->SetCallSuffix();
          }
          else if ($arg == "cat_link_staff")
          {
             if ($sheet_opts) $this->spreadsheet->SetCatalogLink(true);
          }
          else if ($arg == "cat_link_opac")
          {
             if ($sheet_opts) $this->spreadsheet->SetCatalogLink(false);
          }
          else if ($arg == "title_link_staff")
          {
             if ($sheet_opts) $this->spreadsheet->SetTitleCatalogLink(true);
          }
          else if ($arg == "title_link_opac")
          {
             if ($sheet_opts) $this->spreadsheet->SetTitleCatalogLink(false);
          }
          else if ($arg == "checkout")
          {
             if ($sheet_opts) $this->spreadsheet->SetLastCheckout();
          }
          else if ($arg == "checkout_lib")
          {
             if ($sheet_opts) $this->spreadsheet->SetLastCheckoutLib();
          }
          else if ($arg == "circ_lib")
          {
             if ($html_opts) $this->html->SetCircLib();
             else if ($sheet_opts) $this->spreadsheet->SetCircLib();
          }
          else if ($arg == "circ_between")
          {
             if ($sheet_opts) $this->spreadsheet->SetCircsBetween($cmd_line[++$i],$cmd_line[++$i]);
          }
          else if ($arg == "circ_mod")
          {
             if ($html_opts) $this->html->SetCircModifier();
             else if ($sheet_opts) $this->spreadsheet->SetCircModifier();
          }
          else if ($arg == "circs_by_lib")
          {
             if ($sheet_opts) $this->spreadsheet->SetCircsByLib();
          }
          else if ($arg == "copy_id")
          {
             if ($sheet_opts) $this->spreadsheet->SetCopyId();
          }
          else if ($arg == "copy_loc")
          {
             if ($html_opts) $this->html->SetCopyLocation();
             else if ($sheet_opts) $this->spreadsheet->SetCopyLocation();
          }
          else if ($arg == "status")
          {
             if ($html_opts) $this->html->SetCopyStatus();
             else if ($sheet_opts) $this->spreadsheet->SetCopyStatus();
          }
          else if ($arg == "tag")
          {
             if ($sheet_opts) $this->spreadsheet->SetCopyTag();
          }
          else if ($arg == "course")
          {
             if ($sheet_opts) $this->spreadsheet->SetCourse();
          }
          else if ($arg == "course_circ")
          {
             if ($sheet_opts) $this->spreadsheet->SetCourseCirc();
          }
          else if ($arg == "cover")
          {
             if ($html_opts) $this->html->SetCoverImage();
             else if ($sheet_opts) $this->spreadsheet->SetCoverImage();
          }
          else if ($arg == "create_date")
          {
             if ($sheet_opts) $this->spreadsheet->SetCreateDate();
          }
          else if ($arg == "deposit")
          {
             if ($sheet_opts) $this->spreadsheet->SetDeposit();
          }
          else if ($arg == "due_date")
          {
             if ($sheet_opts) $this->spreadsheet->SetDueDate();
          }
          else if ($arg == "encumbered")
          {
             if ($sheet_opts) $this->spreadsheet->SetEncumbered();
          }
          else if ($arg == "fine")
          {
             if ($sheet_opts) $this->spreadsheet->SetFineLevel();
          }
          else if ($arg == "fingerprint")
          {
             if ($sheet_opts) $this->spreadsheet->SetFingerprint();
          }
          else if ($arg == "floating")
          {
             if ($sheet_opts) $this->spreadsheet->SetFloating();
          }
          else if ($arg == "fund")
          {
             if ($sheet_opts) $this->spreadsheet->SetFund();
          }
          else if ($arg == "fund_debit")
          {
             if ($sheet_opts) $this->spreadsheet->SetFundDebit();
          }
          else if ($arg == "goodreads")
          {
             if ($html_opts) $this->html->SetGoodreads();
             else if ($sheet_opts) $this->spreadsheet->SetGoodreads();
          }
          else if ($arg == "google")
          {
             if ($html_opts) $this->html->SetGoogleBooks();
          }
          else if ($arg == "holds")
          {
             if ($sheet_opts) $this->spreadsheet->SetHolds();
          }
          else if ($arg == "in_house")
          {
             if ($html_opts) $this->html->SetInHouseUse();
             else if ($sheet_opts) $this->spreadsheet->SetInHouseUse();
          }
          else if ($arg == "inventory")
          {
             if ($sheet_opts) $this->spreadsheet->SetInventory();
          }
          else if ($arg == "invoice_date")
          {
             if ($sheet_opts) $this->spreadsheet->SetInvoiceDate();
          }
          else if ($arg == "invoice_closed_date")
          {
             if ($sheet_opts) $this->spreadsheet->SetInvoiceClosedDate();
          }
          else if ($arg == "invoice_num")
          {
             if ($sheet_opts) $this->spreadsheet->SetInvoiceNum();
          }
          else if ($arg == "isbn")
          {
             if ($html_opts) $this->html->SetISBN();
             else if ($sheet_opts) $this->spreadsheet->SetISBN();
             else if($json_opts) $this->json->SetUseISBN();
          }
          else if ($arg == "isbn1")
          {
             if ($sheet_opts) $this->spreadsheet->SetOneISBN();
          }
          else if ($arg == "item_status_link")
          {
            if ($sheet_opts) $this->spreadsheet->SetItemStatusLink();
          }
          else if ($arg == "last_checkin")
          {
             if ($html_opts) $this->html->SetLastCheckin();
             else if ($sheet_opts) $this->spreadsheet->SetLastCheckin();
          }
          else if ($arg == "last_fy")
          {
             if ($sheet_opts) $this->spreadsheet->SetLastFYCirc();
          }
          else if ($arg == "sortkey")
          {
             if ($sheet_opts) $this->spreadsheet->SetCallSortKey();
          }
          else if ($arg == "life_circ")
          {
             if ($html_opts) $this->html->SetLifetimeCirc();
             else if ($sheet_opts) $this->spreadsheet->SetLifetimeCirc();
          }
          else if ($arg == "line_item_id")
          {
             if ($sheet_opts) $this->spreadsheet->SetLineItemId();
          }
          else if ($arg == "line_item_status")
          {
             if ($sheet_opts) $this->spreadsheet->SetLineItemStatus();
          }
          else if ($arg == "loan_dur")
          {
             if ($sheet_opts) $this->spreadsheet->SetLoanDuration();
          }
          else if ($arg == "marc")
          {
             if ($sheet_opts) $this->spreadsheet->SetMarcField($cmd_line[++$i],$cmd_line[++$i]);
          }
          else if ($arg == "novelist")
          {
             if ($html_opts) $this->html->SetNovelist();
             else if ($sheet_opts) $this->spreadsheet->SetNovelist();
          }
          else if ($arg == "oclc")
          {
             if ($html_opts) $this->html->SetOCLCNumber();
             else if ($sheet_opts) $this->spreadsheet->SetOCLCNumber();
          }
          else if ($arg == "only_holder")
          {
             if ($sheet_opts) $this->spreadsheet->SetOnlyHolder();
          }
          else if ($arg == "order_date")
          {
             if ($sheet_opts) $this->spreadsheet->SetOrderDate();
          }
          else if ($arg == "other_lib_count")
          {
             if ($sheet_opts) $this->spreadsheet->SetOtherLibraryCount();
          }
          else if ($arg == "owning_lib")
          {
             if ($sheet_opts) $this->spreadsheet->SetOwningLib();
          }
          else if ($arg == "part")
          {
             if ($html_opts) $this->html->SetPart();
             else if ($sheet_opts) $this->spreadsheet->SetPart();
          }
          else if ($arg == "po_num")
          {
             if ($sheet_opts) $this->spreadsheet->SetPONum();
          }
          else if ($arg == "price")
          {
             if ($sheet_opts) $this->spreadsheet->SetPrice();
          }
          else if ($arg == "pub_date")
          {
             if ($html_opts) $this->html->SetPubYear();
             else if ($sheet_opts) $this->spreadsheet->SetPubYear();
          }
          else if ($arg == "public_note")
          {
             if ($html_opts) $this->html->SetPublicNote();
             else if ($sheet_opts) $this->spreadsheet->SetPublicNote();
          }
          else if ($arg == "publisher")
          {
             if ($html_opts) $this->html->SetPublisher();
             else if ($sheet_opts) $this->spreadsheet->SetPublisher();
          }
          else if ($arg == "reference")
          {
             if ($sheet_opts) $this->spreadsheet->SetReference();
          }
          else if ($arg == "staff_note")
          {
             if ($html_opts) $this->html->SetStaffNote();
             else if ($sheet_opts) $this->spreadsheet->SetStaffNote();
          }
          else if ($arg == "stat_cat")
          {
             if ($html_opts) $this->html->SetStatCat();
             else if ($sheet_opts) $this->spreadsheet->SetStatCat();
          }
          else if ($arg == "stat_change")
          {
             if ($html_opts) $this->html->SetStatChange();
             else if ($sheet_opts) $this->spreadsheet->SetStatChange();
          }
          else if ($arg == "summary")
          {
             if ($html_opts) $this->html->SetSummary();
             else if ($sheet_opts) $this->spreadsheet->SetSummary();
          }
          else if ($arg == "title")
          {
             if ($html_opts) $this->html->SetTitle();
             else if ($sheet_opts) $this->spreadsheet->SetTitle();
          }
          else if ($arg == "ytd_circ")
          {
             if ($html_opts) $this->html->SetYTDCircs();
             else if ($sheet_opts) $this->spreadsheet->SetYTDCircs();
          }
          else if ($arg == "csv")
          {
             if ($sheet_opts) $this->spreadsheet->SetCSVFormat();
          }
          else if ($arg == "excel")
          {
             if ($sheet_opts) $this->spreadsheet->SetExcelFormat();
          }
          else if ($arg == "no_item_sheet")
          {
             if ($sheet_opts) $this->spreadsheet->SetNoItemSheet();
          }
          else if ($arg == "author_sheet")
          {
             if ($sheet_opts) $this->spreadsheet->SetAuthorSheet();
          }
          else if ($arg == "bib_sheet")
          {
             if ($sheet_opts) $this->spreadsheet->SetBibSheet();
          }
          else if ($arg == "single_sheet")
          {
             if ($sheet_opts) $this->spreadsheet->SetSingleSheet();
          }
          else if ($arg == "summary_sheet")
          {
             if ($sheet_opts) $this->spreadsheet->SetSummarySheet();
          }
          else if ($arg == "count_sheet")
          {
             if ($sheet_opts) $this->spreadsheet->SetCountsSheet();
          }
          else if ($arg == "block")
          {
             if ($html_opts) $this->html->SetBlockLayout();
          }
          else if ($arg == "grid")
          {
             if ($html_opts) $this->html->SetGridLayout($cmd_line[++$i]);
          }
          else if ($arg == "slider")
          {
             if ($html_opts) $this->html->SetSliderLayout();
          }
          else if ($arg == "inline")
          {
             if ($html_opts) $this->html->SetInlineLayout();
          }
          else if ($arg == "image_size")
          {
             if ($html_opts) $this->html->SetImageSize($cmd_line[++$i]);
          }
          else if ($arg == "group_copy")
          {
             if ($html_opts) $this->html->SetGroupCopies($cmd_line[++$i]);
          }
          else if ($arg == "save_html")
          {
             if ($html_opts) $this->html->SetSaveHTML();
          }
          else if ($arg == "word_press")
          {
             if ($html_opts) $this->html->SetWordPress();
          }
          else if ($arg == "rss_desc")
          {
             if ($rss_opts) $this->rss->SetDescription(str_replace("+", " ",$cmd_line[++$i]));
          }
          else if ($arg == "rss_list")
          {
             if ($rss_opts) $this->rss->SetListName(str_replace("+", " ",$cmd_line[++$i]));
          }
          else if ($arg == "bag_desc" || $arg == "bucket_desc")
          {
             $bucket_desc = str_replace("\!", "!",$cmd_line[++$i]);
             $bucket_desc = str_replace("+", " ",$bucket_desc);

             if ($bucket_opts) $this->bucket->SetBucketDescription($bucket_desc);
             else if ($copy_bucket_opts) $this->copy_bucket->SetBucketDescription($bucket_desc);
          }
          else if ($arg == "bag_name" || $arg == "bucket_name")
          {
             $bucket_name = str_replace("\!", "!",$cmd_line[++$i]);
             $bucket_name = str_replace("+", " ",$bucket_name);

             if ($bucket_opts) $this->bucket->SetBucketName($bucket_name);
             else if ($copy_bucket_opts) $this->copy_bucket->SetBucketName($bucket_name);
          }
          else if ($arg == "bag_id" || $arg == "bucket_id")
          {
             if ($bucket_opts) $this->bucket->SetBucketId($cmd_line[++$i]);
             else if ($copy_bucket_opts) $this->copy_bucket->SetBucketId($cmd_line[++$i]);
          }
          else if ($arg == "update_type")
          {
             if ($bucket_opts) $this->bucket->SetBucketUpdateType($cmd_line[++$i]);
             else if ($copy_bucket_opts) $this->copy_bucket->SetBucketUpdateType($cmd_line[++$i]);
          }
          else if ($arg == "bucket_owner")
          {
             if ($bucket_opts) $this->bucket->SetBucketOwner($cmd_line[++$i]);
             else if ($copy_bucket_opts) $this->copy_bucket->SetBucketOwner($cmd_line[++$i]);
          }
          else if ($arg == "carousel")
          {
              if ($bucket_opts) $this->bucket->SetCarousel();
          }
          else if ($arg == "no_email")
          {
              $this->SetNoEmail();
          }
      }
   }


   function WriteHTML()
   {
      return $this->write_html;
   }

   function WriteSpreadsheet()
   {
      return $this->write_spreadsheet;
   }

   function WriteRSS()
   {
      return $this->write_rss;
   }

   function WriteBucket()
   {
      if ($this->write_bucket || $this->write_copy_bucket)return true;
      else return false;
   }

   function WriteJSON()
   {
      if ($this->write_json)return true;
      else return false;
   }

   function SetWriteDB($db)
   {
      if ($this->write_bucket) $this->bucket->SetDB($db);
      if ($this->write_copy_bucket) $this->copy_bucket->SetDB($db);
   }

   function GetAgeProtect()
   {
      if ($this->write_spreadsheet && $this->spreadsheet->GetAgeProtection()) return true;
      else return false;
   }

   function GetAlertMessage()
   {
      if ($this->write_spreadsheet && $this->spreadsheet->GetAlertMessage()) return true;
      else return false;
   }

   function GetCallClass()
   {
      if ($this->write_spreadsheet && $this->spreadsheet->GetCallClass()) return true;
      else return false;
   }

   function GetCircsBetween()
   {
      if ($this->write_spreadsheet && $this->spreadsheet->GetCircsBetween()) return true;
      else return false;
   }

   function GetCircsBetweenStart()
   {
      if ($this->write_spreadsheet && $this->spreadsheet->GetCircsBetweenStart()) return $this->spreadsheet->GetCircsBetweenStart();
      else return -1;
   }

   function GetCircsBetweenEnd()
   {
      if ($this->write_spreadsheet && $this->spreadsheet->GetCircsBetweenEnd()) return $this->spreadsheet->GetCircsBetweenEnd();
      else return -1;
   }

   function GetCircsByLib()
   {
      if ($this->spreadsheet->GetCircsByLib()) return true;
      else return false;
   }

   function GetCircModifier()
   {
      if ($this->write_spreadsheet && $this->spreadsheet->GetCircModifier()) return true;
      else return false;
   }

   function GetCollection()
   {
      return $this->collection;
   }

   function GetCollectionCode()
   {
      return $this->collection_code;
   }

   function GetCopyLocation()
   {
      if ($this->write_spreadsheet && $this->spreadsheet->GetCopyLocation()) return true;
      else return false;
   }

   function GetCopyTag()
   {
       if ($this->write_spreadsheet && $this->spreadsheet->GetCopyTag()) return true;
       else return false;
   }

   function GetCourse()
   {
       if ($this->write_spreadsheet && $this->spreadsheet->GetCourse()) return true;
       else return false;
   }

   function GetCourseCirc()
   {
       if ($this->write_spreadsheet && $this->spreadsheet->GetCourseCirc()) return true;
       else return false;
   }

   function GetDueDate()
   {
      if ($this->write_spreadsheet && $this->spreadsheet->GetDueDate()) return true;
      else return false;
   }

   function GetGroupCopies()
   {
      if ( ($this->write_html && $this->html->GetGroupCopies()) ||
           ($this->write_spreadsheet && $this->spreadsheet->GetBibSheet()) ||
           $this->write_rss ||
           $this->write_bucket ||
           $this->write_json) return true;
      else return false;
   }

   function GetUngroupCopies()
   {
      if ( $this->collection && $this->popular ) return false;
      else if ( ($this->write_spreadsheet && $this->spreadsheet->GetItemSheet() ) ||
                 $this->write_copy_bucket ||
                ($this->write_html && !$this->html->GetGroupCopies()) ) return true;
      else return false;
   }

   function GetAuthorList()
   {
      if ($this->write_spreadsheet && $this->spreadsheet->GetAuthorSheet()) return true;
      else return false;
   }

   function GetAcquisitionsInfo()
   {
      if ($this->write_spreadsheet)
      {
         if ($this->spreadsheet->GetEncumbered()) return true;
         if ($this->spreadsheet->GetFund()) return true;
         if ($this->spreadsheet->GetFundDebit()) return true;
         if ($this->spreadsheet->GetInvoiceDate()) return true;
         if ($this->spreadsheet->GetInvoiceClosedDate()) return true;
         if ($this->spreadsheet->GetInvoiceNum()) return true;
         if ($this->spreadsheet->GetLineItemId()) return true;
         if ($this->spreadsheet->GetLineItemStatus()) return true;
         if ($this->spreadsheet->GetOrderDate()) return true;
         if ($this->spreadsheet->GetPONum()) return true;
      }
      else
      {
         return false;
      }
   }


   function GetEncumbered()
   {
      if ($this->write_spreadsheet && $this->spreadsheet->GetEncumbered()) return true;
      else return false;
   }

   function GetFineLevel()
   {
      if ($this->write_spreadsheet && $this->spreadsheet->GetFineLevel()) return true;
      else return false;
   }

   function GetFingerprint()
   {
      if ($this->write_spreadsheet && $this->spreadsheet->GetFingerprint()) return true;
      else return false;
   }

   function GetFloating()
   {
      if ($this->write_spreadsheet && $this->spreadsheet->GetFloating()) return true;
      else return false;
   }

   function GetFund()
   {
      if ($this->write_spreadsheet && $this->spreadsheet->GetFund()) return true;
      else return false;
   }

   function GetFundDebit()
   {
      if ($this->write_spreadsheet && $this->spreadsheet->GetFundDebit()) return true;
      else return false;
   }

   function GetHolds()
   {
      if ($this->write_spreadsheet && $this->spreadsheet->GetHolds()) return true;
      else return false;
   }

   function GetInHouseUse()
   {
      if ( ($this->write_html && $this->html->GetInHouseUse()) ||
           ($this->write_spreadsheet && $this->spreadsheet->GetInHouseUse()) )return true;
      else return false;
   }

   function GetInventory()
   {
      if ($this->write_spreadsheet && $this->spreadsheet->GetInventory()) return true;
      else return false;
   }

   function GetInvoiceDate()
   {
      if ($this->write_spreadsheet && $this->spreadsheet->GetInvoiceDate()) return true;
      else return false;
   }

   function GetInvoiceClosedDate()
   {
      if ($this->write_spreadsheet && $this->spreadsheet->GetInvoiceClosedDate()) return true;
      else return false;
   }

   function GetInvoiceNum()
   {
      if ($this->write_spreadsheet && $this->spreadsheet->GetInvoiceNum()) return true;
      else return false;
   }

   function GetLastCheckin()
   {
      if ( ($this->write_html && $this->html->GetLastCheckin()) ||
           ($this->write_spreadsheet && $this->spreadsheet->GetLastCheckin())) return true;
      else return false;
   }

   function GetLastCheckout()
   {
      if ($this->write_spreadsheet && $this->spreadsheet->GetLastCheckout()) return true;
      else return false;
   }

   function GetLastCheckoutLib()
   {
      if ($this->write_spreadsheet && $this->spreadsheet->GetLastCheckoutLib()) return true;
      else return false;
   }

   function GetLastFYCirc()
   {
      if ( $this->write_spreadsheet &&  $this->spreadsheet->GetLastFYCirc()) return true;
      else return false;
   }

   function GetLineItemId()
   {
      if ($this->write_spreadsheet && $this->spreadsheet->GetLineItemId()) return true;
      else return false;
   }

   function GetLineItemStatus()
   {
      if ($this->write_spreadsheet && $this->spreadsheet->GetLineItemStatus()) return true;
      else return false;
   }

   function GetLoanDuration()
   {
      if ($this->write_spreadsheet && $this->spreadsheet->GetLoanDuration()) return true;
      else return false;
   }

   function GetMarcField()
   {
      if ($this->write_spreadsheet && $this->spreadsheet->GetMarcField()) return true;
      else return false;
   }

   function GetMarcTag()
   {
      if ($this->write_spreadsheet && $this->spreadsheet->GetMarcField()) return $this->spreadsheet->GetMarcTag();
      else return "NONE";
   }

   function GetMarcSubfield()
   {
      if ($this->write_spreadsheet && $this->spreadsheet->GetMarcField()) return $this->spreadsheet->GetMarcSubfield();
      else return "NONE";
   }

   function GetOrderDate()
   {
      if ($this->write_spreadsheet && $this->spreadsheet->GetOrderDate()) return true;
      else return false;
   }

   function GetPONum()
   {
      if ($this->write_spreadsheet && $this->spreadsheet->GetPONum()) return true;
      else return false;
   }

   function GetPrefix()
   {
      if ($this->write_spreadsheet && $this->spreadsheet->GetCallPrefix()) return true;
      else return false;
   }

   function GetPrice()
   {
      if ($this->write_spreadsheet && $this->spreadsheet->GetPrice()) return true;
      else return false;
   }

   function GetAcqCost()
   {
      if ($this->write_spreadsheet && $this->spreadsheet->GetAcqCost()) return true;
      else return false;
   }

   function GetPublicNote()
   {
      if ( ($this->write_html && $this->html->GetPublicNote()) ||
           ($this->write_spreadsheet && $this->spreadsheet->GetPublicNote() ) ) return true;
      else return false;
   }

   function GetStaffNote()
   {
      if ( ($this->write_html && $this->html->GetStaffNote()) ||
           ($this->write_spreadsheet && $this->spreadsheet->GetStaffNote()) ) return true;
      else return false;
   }

   function GetStatus()
   {
      if ($this->write_spreadsheet && $this->spreadsheet->GetCopyStatus()) return true;
      else return false;
   }

   function GetOCLCNumber()
   {
      if ( ($this->write_html && $this->html->GetOCLCNumber() ) ||
           ($this->write_spreadsheet && $this->spreadsheet->GetOCLCNumber())) return true;
      else return false;
   }

   function GetOnlyHolder()
   {
      if ($this->write_spreadsheet && $this->spreadsheet->GetOnlyHolder()) return true;
      else return false;
   }

   function GetOtherLibraryCount()
   {
      if ($this->write_spreadsheet && $this->spreadsheet->GetOtherLibraryCount()) return true;
      else return false;
   }

   function GetPart()
   {
      if ( ($this->write_html && $this->html->GetPart() ) ||
           ($this->write_spreadsheet &&  $this->spreadsheet->GetPart())) return true;
      else return false;
   }

   function GetStatCats()
   {
      if ( ($this->write_html && $this->html->GetStatCat() ) ||
           ($this->write_spreadsheet && $this->spreadsheet->GetStatCat())) return true;
      else return false;
   }

   function GetSummary()
   {
      if ( ($this->write_html && $this->html->GetSummary() ) ||
           ($this->write_spreadsheet && $this->spreadsheet->GetSummary()) ||
            $this->write_rss ) return true;
      else return false;
   }

   function GetYTDCircs()
   {
      if ( ($this->write_html && $this->html->GetYTDCircs() ) ||
           ($this->write_html && $this->html->GetYTDCircSort()) ||
           ($this->write_spreadsheet && $this->spreadsheet->GetYTDCircs()) ||
           ($this->write_spreadsheet && $this->spreadsheet->GetYTDCircSort())  )
      {
         return true;
      }
      else return false;
   }

   function GetCountsSheet()
   {
      if($this->write_spreadsheet) return $this->spreadsheet->GetCountsSheet();
      else return false;
   }

   function GetHTML($bib_list)
   {
      $this->html->SortList($bib_list);
      return $this->html->WriteHTML($bib_list, null);
   }

   function SetNoEmail()
   {
       $this->no_email = true;
   }

   function GetNoEmail()
   {
      return $this->no_email;
   }

   function WriteCollectionOutputFiles($bib_list, $lib_name, $system_name, $collection_name, $count)
   {
      $fy = CalculateFiscalYear();
      $directory_name = "/var/www/coll_man/reports/FY".$fy;
      // $directory_name = "/var/www/tools/list_maker_working/test";

      if(!is_dir($directory_name) )
		{
			//if not there, make one
			mkdir($directory_name);
		}

		$directory_name .="/".strtolower($system_name);
		//check for lib system dir in FY
		if(! is_dir($directory_name) )
		{
			//if not there make one
			mkdir($directory_name);
		}

		$topic_name = preg_replace("/[^A-Za-z0-9 ]/", '', $collection_name);
      $topic = str_replace(" ", "_", $topic_name);
      $topic = strtolower($topic);

      $directory_name .="/".$topic;
      //check for topic path
      if(! is_dir($directory_name) )
      {
         //if not there make one
         mkdir($directory_name);
      }

      $filename = $directory_name."/".$lib_name."_".$this->collection_code."_";

      if($this->popular)
      {
         $filename .="popular";

         $this->spreadsheet->SetCircBetweenSort();
         $this->spreadsheet->SortList($bib_list);
         $this->spreadsheet->SetBibSheetLimit(150);
      }
      else if ($this->recent)
      {
         $filename .="recent";
      }
      else
      {
         $filename .="shelf_report";
      }

      echo "Filename is ".$filename."\n";

      $this->spreadsheet->WriteExcel($bib_list, $filename, false, $lib_name, null, true);
   }

   function WriteOutputFiles($bib_list, $lib_name, $system_id, $show_deleted, $author_list)
   {
      //figure out filename
      $today = date("U");
      $rand = rand(0, 2000);
      $file_path = "/var/www/tools/reports/";

      if ($this->use_custom_filename)
      {
         if ($this->save_file_name)$relative_name = $this->output_filename;
         else $relative_name = $this->output_filename."_".$rand;
      }
      else
      {
         $relative_name ="list_".$lib_name."_".$today."_".$rand;
      }

      $this->output_filename = $file_path.$relative_name;

      echo "Filename prefix is ".$relative_name."\n";

      $spreadsheet_done = false;
      $html_done = false;

      if ($author_list) $author_list->SortByName();

       //anything call number sorted should go first since it comes out of DB that way.
      if ($this->write_spreadsheet && $this->spreadsheet->GetCallNumSort())
      {
         if ($this->spreadsheet->GetExcelFormat())
         {
            if ($this->spreadsheet->GetSingleSheet())$this->spreadsheet->WriteSingleExcel($bib_list, $relative_name, $show_deleted, $lib_name);
            else $this->spreadsheet->WriteExcel($bib_list, $relative_name, $show_deleted, $lib_name, $author_list);

         }
         else if ($this->spreadsheet->GetCSVFormat())
         {
             if ($this->spreadsheet->GetSingleSheet())$this->spreadsheet->WriteSingleCSV($bib_list, $relative_name, $show_deleted);
             else $this->spreadsheet->WriteCSV($bib_list, $relative_name, $show_deleted, $author_list);
         }
         $spreadsheet_done = true;
      }

      if ($this->write_html && $this->html->GetCallNumSort() && !$this->html->GetGroupCopies())
      {
          $this->html->WriteHTML($bib_list, $relative_name);
          $html_done = true;
      }

      //Not necessarily sorted by call number
      if ($this->write_html && !$html_done )
      {
         //determine sort order
         //write html (with filename)
         $this->html->SortList($bib_list);
         $this->html->WriteHTML($bib_list, $relative_name);
      }

      if ($this->write_spreadsheet && !$spreadsheet_done)
      {
         //determine sort order
         //write spreadsheet(with file-prefix)
         $this->spreadsheet->SortList($bib_list);

		   if ($this->spreadsheet->GetExcelFormat())
		   {
				if ($this->spreadsheet->GetSingleSheet())$this->spreadsheet->WriteSingleExcel($bib_list, $relative_name, $show_deleted, $lib_name);
				else $this->spreadsheet->WriteExcel($bib_list, $relative_name, $show_deleted, $lib_name, $author_list);
			}
			else if ($this->spreadsheet->GetCSVFormat())
			{
				 if ($this->spreadsheet->GetSingleSheet())$this->spreadsheet->WriteSingleCSV($bib_list, $relative_name, $show_deleted);
				 else $this->spreadsheet->WriteCSV($bib_list, $relative_name, $show_deleted);
			}
      }

      if ($this->write_rss)
      {
         //Sort by Title -- same as html
         $this->rss->SortRSSListByTitle($bib_list);
         $this->rss->WriteRSS($bib_list, $relative_name);
      }

      if($this->write_bucket)
      {
         $this->bucket->WriteBucket($bib_list, $system_id );
      }

      if($this->write_copy_bucket)
      {
         $this->copy_bucket->WriteCopyBucket($bib_list, $system_id );
      }

      if($this->write_json)
      {
         $this->json->WriteJSON($bib_list, $relative_name);
      }

   }

   function SetEmail($address)
   {
       $this->email_addresses[] = $address;
   }

   function SendEmail($subject, $message_body)
   {
      //Semd email
       $email = new PHPMailer();
       $email->From      = 'evergreen@noblenet.org';
       $email->FromName  = 'Report Generator';
       $email->Subject   = $subject;
       $email->AddReplyTo('evergreen@noblenet.org', 'Report Generator');

       $email->Body      = $message_body;

       foreach($this->email_addresses as $curr_address)
       {
          $email->AddAddress( $curr_address);
       }

       $email->Send();
   }

   function GetTextForPreview()
   {
      return $this->html->GetPreviewText();
   }

   function GetHTMLText()
   {
       $html_out = "";
       //each needs it's own block

       if ($this->write_html) $html_out .= "<hr/>".$this->html->GetHTMLText(true)."\n";
       if ($this->write_spreadsheet)  $html_out .= "<hr/>".$this->spreadsheet->GetHTMLText(true)."\n";
       if ($this->write_rss)  $html_out .= "<hr/>".$this->rss->GetHTMLText(true)."\n";
       if ($this->write_bucket)  $html_out .= "<hr/>".$this->bucket->GetHTMLText()."\n";
       if ($this->write_copy_bucket) $html_out .= "<hr/>".$this->copy_bucket->GetHTMLText()."\n";
       if ($this->write_json) $html_out .= "<hr/>".$this->json->GetHTMLText()."\n";

       return $html_out;
   }

   function GetReportLinkParams()
   {
       $out_string = "";
       //each needs it's own block

       if ($this->write_rss)  $out_string .= $this->rss->GetReportLinkText()."*";
       if ($this->write_bucket)  $out_string .= $this->bucket->GetReportLinkText()."*";
       if ($this->write_copy_bucket)  $out_string .= $this->copy_bucket->GetReportLinkText()."*";
       if ($this->json)  $out_string .= $this->bucket->GetReportLinkText()."*";

       if ($this->GetNoEmail()) $out_string .= "no_email";

       return $out_string;
   }

   function SendCompletedEmail($count, $bib_count, $online_bib_count, $online_link_count, $type, $filter_text, $scheduled, $update_report_link, $domain, $db_id)
   {
      if ($this->collection || $this->GetNoEmail()) return;

      $subject="";
      //Semd email
      if ($scheduled) $subject .= "Scheduled ";
      $subject  .= $type;

       if ($this->use_report_name) $subject .= " ".$this->report_name." ";
       $subject .= ": COMPLETE ";

       $message_body = "Your completed report is below. It contains ".number_format($count)." copies attached to ".number_format($bib_count)." unique bibs.\n";
       if ($online_bib_count > 0 ) $message_body .= "There are ".number_format($online_link_count)." links attached to ".number_format($online_bib_count)." unique online bibs.\n";
       $message_body .= "\nThis report was created with the following parameters.\n";

       $message_body .= $filter_text."\n";
       if ($this->write_html) $message_body .= $this->html->GetEmailText(true)."\n";
       if ($this->write_spreadsheet)  $message_body .= $this->spreadsheet->GetEmailText(true)."\n";
       if ($this->write_rss)  $message_body .= $this->rss->GetEmailText(true)."\n";

       $remove_date = date("m/d/Y", strtotime("+30 days"));
       if ($this->write_html || $this->write_spreadsheet || $this->write_rss)
       {
          if ($this->html && $this->html->GetSaveHTML())
          {
             $message_body .= "NOTE: Embeddable HTML will not be deleted\n\n";
             if ( $this->write_spreadsheet) $message_body .= "NOTE: This Spreadsheet report will be removed from the server on ".$remove_date.".\n\n";
          }
          else
          {
             $message_body .= "NOTE: These reports will be removed from the server on ".$remove_date.".\n\n";
          }

       }
       if ($this->write_bucket || $this->write_copy_bucket)
       {
           if ($this->write_bucket)$message_body .= $this->bucket->GetEmailText(true, $domain)."\n";
           if ($this->write_copy_bucket)$message_body .= $this->copy_bucket->GetEmailText(true, $domain)."\n";
           $message_body .=  "NOTE: Buckets will not be deleted.\n\n";
       }

       if($this->write_json)
       {
          $message_body .= $this->json->GetEmailText()."\n";
       }

       if($scheduled)
       {
          $message_body .= "This is a Scheduled Report.  If you want to view the report details, edit or turn off the scheduled report, use this link https://tools.noblenet.org/list_maker/edit_scheduled_out.php?id=".$db_id.".\n\n";

          $message_body .= "If you want to rerun or edit just this specific report, you can use this link: ".$update_report_link;
       }
       else
       {
          if ($db_id > 0) $message_body .= "This is a run of a Scheduled report.  If you want to view the report details, edit or turn off the scheduled report, use this link https://tools.noblenet.org/list_maker/edit_scheduled_out.php?id=".$db_id.".\n\n";

          $message_body .= "Run Report with same parameters ".$update_report_link;
       }

       $this->SendEmail($subject, $message_body);
   }

   function SendEmptyReportEmail($type, $filter_text, $scheduled, $update_report_link, $db_id)
   {
       if ($this->collection || $this->GetNoEmail()) return;

       $subject="";
       if ($scheduled) $subject  .= "Scheduled ";
       $subject  .= $type;

       if ($this->use_report_name) $subject  .= " ".$this->report_name." ";
       $subject .= ": NO RECORDS FOUND ";

       $message_body = "No items were found with the parameters below.\n\n";

       $message_body .= $filter_text."\n";
       if ($this->write_html) $message_body .= $this->html->GetEmailText(false)."\n";
       if ($this->write_spreadsheet)  $message_body .= $this->spreadsheet->GetEmailText(false)."\n";
       if ($this->write_rss)  $message_body .= $this->rss->GetEmailText(false)."\n";
       if ($this->write_bucket)  $message_body .= $this->bucket->GetEmailText(false,"")."\n";
       if ($this->write_copy_bucket) $message_body .= $this->copy_bucket->GetEmailText(false,"")."\n";

       if($scheduled)
       {
          $message_body .= "This is a Scheduled Report.  If you want to view the report details, edit or turn off the scheduled report, use this link https://tools.noblenet.org/list_maker/edit_scheduled_out.php?id=".$db_id."\n\n";

          $message_body .= "If you want to rerun or edit just this specific report, you can use this link: ".$update_report_link;

       }
       else
       {
          if ($db_id > 0) $message_body .= "This is a run of a Scheduled report.  If you want to view the report details, edit or turn off the scheduled report, use this link https://tools.noblenet.org/list_maker/edit_scheduled_out.php?id=".$db_id.".\n\n";

          $message_body .= "Run Report with same parameters ".$update_report_link;
       }

       $this->SendEmail($subject, $message_body);
   }

   function SendLargeReportEmail($count, $bib_count, $online_bib_count, $online_link_count, $type, $filter_text, $scheduled, $update_report_link, $db_id)
   {
       if ($this->collection || $this->GetNoEmail()) return;

       $subject="";
       if ($scheduled) $subject  .= "Scheduled ";
       $subject  .= $type;

       if ($this->use_report_name) $subject  .= " ".$this->report_name." ";
       $subject .= ": EXCEEDED LIMIT ";

       $message_body =  number_format($count)." copies attached to ".number_format($bib_count)." unique bibs were identified for your report.\n";
       if ($online_bib_count > 0 ) $message_body .= "As well as ".number_format($online_link_count)." links attached to ".number_format($online_bib_count)." unique online bibs.\n";
       $message_body .= "This exceeds the 50,000 limit.\n";
       $message_body .= "Please retry using more filters.\n\n";

       $message_body .= $filter_text."\n";
       if ($this->write_html) $message_body .= $this->html->GetEmailText(false)."\n";
       if ($this->write_spreadsheet)  $message_body .= $this->spreadsheet->GetEmailText(false)."\n";
       if ($this->write_rss)  $message_body .= $this->rss->GetEmailText(false)."\n";
       if ($this->write_bucket)  $message_body .= $this->bucket->GetEmailText(false)."\n";
       if ($this->write_copy_bucket)  $message_body .= $this->copy_bucket->GetEmailText(false)."\n";

       if($scheduled)
       {
           $message_body .= "This is a Scheduled Report.  If you want to view the report details, edit or turn off the scheduled report, use this link https://tools.noblenet.org/list_maker/edit_scheduled_out.php?id=".$db_id.".\n\n";

           $message_body .= "If you want to rerun or edit just this specific report, you can use this link: ".$update_report_link;
       }
       else
       {
          if ($db_id > 0) $message_body .= "This is a run of a Scheduled report.  If you want to view the report details, edit or turn off the scheduled report, use this link https://tools.noblenet.org/list_maker/edit_scheduled_out.php?id=".$db_id.".\n\n";

          $message_body .= "Run Report with same parameters ".$update_report_link;
       }

       $this->SendEmail($subject, $message_body);
   }

   function SendTooBigToRunEmail($loc_count, $type, $filter_text, $scheduled, $update_report_link, $db_id)
   {
       if ($this->collection || $this->GetNoEmail()) return;

       $subject="";
       if ($scheduled) $subject  .= "Scheduled ";
       $subject  .= $type;

       if ($this->use_report_name) $subject  .= " ".$this->report_name." ";
       $subject .= ": EXCEEDED LIMIT - ADD ADDITIONAL FILTERS ";

       $message_body =  " The copy location you are running contains ".number_format($loc_count)." items. The List Maker cannot write reports greater than 50,000\n";
       $message_body .= "Please retry using more filters.\n\n";

       $message_body .= $filter_text."\n";
       if ($this->write_html) $message_body .= $this->html->GetEmailText(false)."\n";
       if ($this->write_spreadsheet)  $message_body .= $this->spreadsheet->GetEmailText(false)."\n";
       if ($this->write_rss)  $message_body .= $this->rss->GetEmailText(false)."\n";
       if ($this->write_bucket)  $message_body .= $this->bucket->GetEmailText(false)."\n";
       if ($this->write_copy_bucket)  $message_body .= $this->copy_bucket->GetEmailText(false)."\n";

       if($scheduled)
       {
           $message_body .= "This is a Scheduled Report.  If you want to view the report details, edit or turn off the scheduled report, use this link https://tools.noblenet.org/list_maker/edit_scheduled_out.php?id=".$db_id."\n\n";

           $message_body .= "If you want to rerun or edit just this specific report, you can use this link: ".$update_report_link;
       }
       else
       {
          if ($db_id > 0) $message_body .= "This is a run of a Scheduled report.  If you want to view the report details, edit or turn off the scheduled report, use this link https://tools.noblenet.org/list_maker/edit_scheduled_out.php?id=".$db_id.".\n\n";

          $message_body .= "Run Report with same parameters ".$update_report_link;
       }

       $this->SendEmail($subject, $message_body);
   }


   function SetCircsBetween($start, $end)
   {
      $this->spreadsheet->SetCircsBetween($start, $end);
   }

   function SetTermData($term_name, $start, $end)
   {
      $this->spreadsheet->SetTermData($term_name, $start, $end);
   }


}


?>