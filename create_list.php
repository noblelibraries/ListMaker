<?php

  require_once('/var/www/shared/PHPMailer/class.phpmailer.php');
  include "/usr/local/noble/db_config/db_info.php";
  include "list_functions.php";
  //include "../common/CopyRec.php";
  include "CopyRec.php";
  include "CopyList.php";
  include "LibCopyList.php";
  include "BibRec.php";
  include "BibList.php";
  include "Filters.php";
  include "Output_Options.php";
  include "GroupCounts.php";
  include "AuthorList.php";

  $filters = new Filters();
  $output = new Output_Options();
  $author_list = null;


  //Run Filters->SQL to get records
  $eg_db = pg_connect("host=$eg_host port=$eg_port dbname=$eg_database user=$eg_user password=$eg_password");
  if (!$eg_db)
  {
     die("Error in connection to circulation DB: " . pg_last_error());
  }

  $filters->SetDB($eg_db);

  //Create Filters from command line
  $filters->CreateFilters($argv);

  $domain =$filters->GetDomain();
  $scope = $filters->GetScope();

  //Create Filters from command line
  $output->CreateOutputOptions($argv);

  $update_report_link = MakeUpdateReportLink($argv);

  if ($filters->GetFilterByCircDate())
  {
     //make sure circs between is set in the output
     $output->SetCircsBetween($filters->GetCircAfter(), $filters->GetCircBefore());
  }

  if ($output->WriteBucket())
  {
     $output->SetWriteDB($eg_db);
  }

  //make sure there are filters set or the location contains less then 50000 items
  if ($filters->RequireCopyLocatonCheck())
  {
      $item_count = $filters->CheckFilters();
      if ($item_count > 50000)
      {
         $output->SendTooBigToRunEmail($item_count, $filters->GetTypeForEmail(), $filters->GetTextForEmail(), $filters->GetScheduled(), $update_report_link, $filters->GetListDBId());
         exit(1);
      }
  }

  if ($output->GetAuthorList())
  {
     echo "Make Author LIst in create list\n";
     $author_list = new AuthorList();
     if($output->GetCircsBetween()) $author_list->SetCircsBetween();
  }

  //Create a new bib list
  $bib_list = new BibList();

  $bib_list->SetDB($eg_db);

  $bib_list->SetLibrary($filters->GetLibrary());

  $bib_list->SetGroupCopies($output->GetGroupCopies());

  $bib_list->SetOneBibOneCopy($output->GetUngroupCopies());

  $bib_list->SetPriceSummary($output->GetPrice());

  $bib_list->SetAcqCostSummary($output->GetAcqCost());

  if ($filters->GetFilterByCircDate() || $output->GetCircsBetween())$bib_list->SetCircBetween();

  if ($filters->GetFilterByCourse())$output->SetTermData($filters->GetTermName(), $filters->GetTermStart(), $filters->GetTermEnd());

  $bib_list->SetGroupData($output);

  $result = pg_query($eg_db,$filters->CreateSQL());

  //exit(1);

  $count = 0;

  while($row = pg_fetch_row($result))
  {
      if (!$filters->LookForPhysicalCopies())
      {
         break;
      }
     //Loop through results
     /*            0         reporter.materialized_simple_record.title //not used but needed for sorting
                   1          asset.call_number.record,
                   2          asset.copy.cost,
                   3          asset.copy.active_date,
                   4          asset.copy.create_date,
                   5          asset.copy.age_protect,
                   6          *,
                   7          asset.copy.barcode,
                   8          asset.copy.id,
                   9          asset.call_number.label,
                  10          asset.call_number.label_class,
                  11          asset.call_number.prefix,
                  12          asset.call_number.suffix,
                  13          asset.call_number.label_sortkey,
                  14          asset.copy.circ_modifier,
                  15          asset.copy.circ_lib,
                  16          asset.copy.location,
                  17          asset.copy.deleted,
                  18          asset.copy.edit_date,
                  19          asset.copy.deposit,
                  20          asset.copy.fine_level,
                  21          asset.copy.floating,
                  22          asset.copy.loan_duration,
                  23          asset.call_number.owning_lib
                  24          asset.copy.price,
                  25          asset.copy.ref,
                  26          asset.copy.status,
                  27          asset.copy.status_changed_time,
                  28          reporter.materialized_simple_record.author,
                  29          reporter.materialized_simple_record.isbn,
                  30          reporter.materialized_simple_record.issn,
                  31          reporter.materialized_simple_record.publisher
                  32          asset.call_number.id
     */


     //echo "/****************** COPY #".$count."********************/\n";

     $count++;

     $bib_id = $row[1];

     $curr_copy = new CopyRec();
     $curr_copy->SetDB($eg_db);

     $curr_copy->SetAcqCost($row[2]);
     $curr_copy->SetActiveDate($row[3], $row[4]);
     $curr_copy->SetAgeProtect($row[5]);
     //$curr_copy->SetAlertMessage($row[6]);
     $curr_copy->SetBarcode($row[7]);
     $curr_copy->SetCopyId($row[8]);
     $curr_copy->SetCallNumber($row[9]);
     $curr_copy->SetCallClass($row[10]);
     $curr_copy->SetPrefix($row[11]);
     $curr_copy->SetSuffix($row[12]);
     $curr_copy->SetCallSortKey($row[13]);
     $curr_copy->SetCircMod($row[14]);
     $curr_copy->SetCircLib($row[15]);
     $curr_copy->SetCopyLocation($row[16]);
     $curr_copy->SetDeleted($row[17], $row[18]);
     $curr_copy->SetDeposit($row[19]);
     $curr_copy->SetFineLevel($row[20]);
     $curr_copy->SetFloating($row[21]);
     $curr_copy->SetLoanDuration($row[22]);
     $curr_copy->SetOwningLib($row[23]);
     $curr_copy->SetPrice($row[24]);
     $curr_copy->SetReference($row[25]);
     $curr_copy->SetStatus($row[26]);
     $curr_copy->SetStatusChange($row[27]);
     $curr_copy->SetCallNumberId($row[32]);

     $curr_copy->SetLifetimeCircs();//always get this data

     //Calculated from individual queiries - only do if care if need in output?
     if($output->GetAlertMessage()) $curr_copy->SetAlertMessage();
     if($output->GetCopyTag() || $filters->GetFilterByItemTag()) $curr_copy->SetCopyTag();
     if($output->GetDueDate() || $filters->GetFilterByDueDate()) $curr_copy->SetDueDate();
     if($output->GetInHouseUse()) $curr_copy->SetInHouseUse();
     if($output->GetInventory() || $filters->GetFilterByInventoryDate()) $curr_copy->SetInventoryDate();
     if($output->GetLastCheckin() || $filters->GetUseShelfSitter()) $curr_copy->SetLastCheckin();
     if($output->GetLastCheckout()|| $output->GetLastCheckoutLib()) $curr_copy->SetLastCheckout(); //do after checkin if that's chosen
     if($output->GetLastFYCirc()) $curr_copy->SetLastFyCirc();
     if($output->GetOnlyHolder() || $filters->GetOnlyHolder() || $output->GetOtherLibraryCount()) $curr_copy->SetOnlyHolder($bib_id);
     if($output->GetPart()) $curr_copy->SetPart();
     if($output->GetPublicNote()) $curr_copy->SetPublicNote();
     if($output->GetStaffNote()) $curr_copy->SetStaffNote();
     if($output->GetStatCats() || $filters->GetFilterByStatCats()) $curr_copy->SetStatCats();
     if($output->GetYTDCircs()) $curr_copy->SetYTDCirc();

     //acquisitions
     if($output->GetAcquisitionsInfo()) $curr_copy->SetAcquisitionsInfo();

     if ($filters->GetFilterByCircDate())
     {
        $curr_copy->SetCircsBetween($filters->GetCircAfter(), $filters->GetCircBefore());
     }
     else if($output->GetCircsBetween())
     {
        $curr_copy->SetCircsBetween($output->GetCircsBetweenStart(), $output->GetCircsBetweenEnd());
     }

     if($output->GetCourseCirc())
     {
        $curr_copy->SetCourseCirc($filters->GetTermStart(), $filters->GetTermEnd());
     }

     if ($output->GetCourse())
     {
        if ($filters->GetFilterByCourse() ) $curr_copy->SetCourseByTerm($filters->GetTermId(),$filters->GetCourseArray());
        else $curr_copy->SetCourse();
     }

     $curr_bib = new BibRec();

     $curr_bib->SetBibId($bib_id, $domain, $scope);
     $curr_bib->SetDB($eg_db);

     $curr_bib->SetISBN($row[29], $row[30]);
     $curr_bib->SetPublisher($row[31]);
     $curr_bib->SetAuthor(); //always get this
     $curr_bib->SetPubYear(); //always get this
     $curr_bib->SetTitle(); //always get this
     $curr_bib->SetGoodreadsLink();
     if($output->GetFingerprint())$curr_bib->SetFingerprint();
     //$curr_bib->SetNovelistLink();
     //$curr_bib->SetGoogleLink();

     if ($filters->GetSearchLinks()) $curr_bib->SetSearchLink($domain, $scope);

     //Calculated from individual queiries - only do if care if need in output?
     if($output->GetOCLCNumber()) $curr_bib->SetOCLCNumber();
     if($output->GetSummary()) $curr_bib->SetSummary();
     if ($output->GetMarcField())$curr_bib->SetMarc($output->GetMarcTag(), $output->GetMarcSubfield());

     if($output->GetHolds() || $filters->GetFilterByHolds())
     {
        $curr_bib->SetHolds($curr_copy->GetCircLibId());
        $curr_copy->SetHolds();
     }

     //execute filters that can't be done in the filter SQL
     if ($filters->ExcludeRecByAddedDate($curr_copy->GetActiveDate()) )
     {
        continue;
     }

    if ($filters->ExcludeRecByDueDate($curr_copy->GetDueDate()) )
     {
        continue;
     }


     if ( $filters->ExcludeRecByInventoryDate($curr_copy->GetInventoryDate()) )
     {
        continue;
     }

     if ( $filters->ExcludeRecByPubDate($curr_bib->GetPubYear()) )
     {
        continue;
     }

     if ( $filters->ExcludeRecByCheckinDate($curr_copy->GetLastCheckin(), $curr_copy->GetActiveDate()) )
     {
        continue;
     }

     if ($filters->GetOrderDateNull())
     {
        if ($filters->ExcludeRecByOrderDate($curr_copy->GetOrderDate())) continue;
     }

     if ($filters->GetInvoiceClosedNull())
     {
        if ($filters->ExcludeRecByInvoiceClosedDate($curr_copy->GetInvoiceClosedDate()) ) continue;
     }

     if ($filters->GetFilterByCircCount())
     {
        //if dates not set then use lifetime circ caount
        if ($filters->GetFilterByCircDate())
        {
           if ($filters->ExcludeRecByCircCount($curr_copy->GetCircsBetween())) continue;
        }
        else
        {
           if ($filters->ExcludeRecByCircCount($curr_copy->GetLifetimeCircs())) continue;
        }
     }

     if ( $filters->ExcludeRecByOnlyHolder($curr_copy->GetOnlyHolder()) )
     {
        continue;
     }

     if($filters->GetFilterByHolds())
     {
        $my_holds = $curr_copy->GetMyHolds() + $curr_bib->GetMyHolds();
        $other_holds = $curr_copy->GetOtherHolds() + $curr_bib->GetOtherHolds();
        if ( $filters->ExcludeRecByHoldCount($my_holds, $other_holds ) )
        {
           continue;
        }
     }

     //send the bib and copy to Bib list to add where it needs to go in the stored lists
     $bib_list->AddItem($curr_bib, $curr_copy);

     if ($output->GetAuthorList()) $author_list->AddAuthorItem($curr_bib, $curr_copy);
  }

  //NOw get any Online Records
  if ($filters->LookForOnlineRecords())
  {
     $result = pg_query($eg_db,$filters->CreateOnlineSQL());

     while($row = pg_fetch_row($result))
     {
        /*  0 = reporter.materialized_simple_record.title,
				1 = reporter.materialized_simple_record.author,
				2 = reporter.materialized_simple_record.isbn,
				3 = reporter.materialized_simple_record.issn,
				4 = reporter.materialized_simple_record.publisher,
				5 = asset.call_number.record
				6 = asset.uri.href
				7 = asset.uri.label
				8 = actor.org_unit.shortname
				9 = asset.call_number.create_date*/


	     $bib_id = $row[5];
	     $curr_bib = new BibRec();

        $curr_bib->SetOnline();
        $curr_bib->SetBibId($bib_id, $domain, $scope);
        $curr_bib->SetDB($eg_db);

        $curr_bib->SetAuthor();
        $curr_bib->SetISBN($row[2], $row[3]);
        $curr_bib->SetPublisher($row[4]);
        $curr_bib->SetOnlineSubU($row[6]);
        $curr_bib->SetOnlineSubY($row[7]);
        $curr_bib->SetOnlineSub9($row[8]);
        $curr_bib->SetPubYear(); //always get this
        $curr_bib->SetTitle(); //always get this
        $curr_bib->SetAuthor(); //always get this
        $curr_bib->SetGoodreadsLink();
        $curr_bib->SetOnlineCreateDate($row[9]);
        $curr_bib->SetOverdriveReserveID();
        //$curr_bib->SetNovelistLink();
        //$curr_bib->SetGoogleLink();


        if ($filters->GetSearchLinks()) $curr_bib->SetSearchLink($domain, $scope);

        //Calculated from individual queiries - only do if care if need in output?
        if($output->GetOCLCNumber()) $curr_bib->SetOCLCNumber();
        if($output->GetSummary()) $curr_bib->SetSummary();
        if ($output->GetMarcField())$curr_bib->SetMarc($output->GetMarcTag(), $output->GetMarcSubfield());

        if ( $filters->ExcludeRecByPubDate($curr_bib->GetPubYear()) )
        {
           continue;
        }
        else
        {
           //send the bib and copy to Bib list to add where it needs to go in the stored lists
           $bib_list->AddOnlineItem($curr_bib);
        }
     }//end while
  }//end online

  //check size of bib list. If too big return.
  $count = $bib_list->GetNumCopies();
  $bib_count = $bib_list->GetNumBibs();
  $online_bib_count = $bib_list->GetNumOnlineBibs();
  $online_link_count = $bib_list->GetNumOnlineLinks();

  echo "Num Copies = ".$count."\n";

  if($output->GetCollection())
  {
     $output->WriteCollectionOutputFiles($bib_list, $filters->GetLibrary(), $filters->GetSystemName(), $filters->GetFilterByCollection(""), $count);
  }
  else
  {
	  if ($count > 50000 || $online_bib_count > 50000)
	  {
		  $output->SendLargeReportEmail($count, $bib_count, $online_bib_count, $online_link_count, $filters->GetTypeForEmail(), $filters->GetTextForEmail(), $filters->GetScheduled(), $update_report_link, $filters->GetListDBId());
	  }
	  else if ($count == 0 && $online_bib_count == 0)
	  {
		  $output->SendEmptyReportEmail($filters->GetTypeForEmail(), $filters->GetTextForEmail(), $filters->GetScheduled(), $update_report_link, $filters->GetListDBId());
	  }
	  else
	  {
		  echo "Writing out Files\n";
		  //Write out files
		  $output->WriteOutputFiles($bib_list, $filters->GetLibrary(), $filters->GetSystemId(), $filters->GetShowDeleted(), $author_list);

		  //Write email
		  $output->SendCompletedEmail($count, $bib_count, $online_bib_count, $online_link_count, $filters->GetTypeForEmail(), $filters->GetTextForEmail(), $filters->GetScheduled(), $update_report_link, $filters->GetDomain(), $filters->GetListDBId());
	  }
  }


  ?>