<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />

<link rel="stylesheet" type="text/css" href="../css/noble.css" />
<link rel="stylesheet" type="text/css" href="../common/booklist.css" />
<link rel="icon"  type="image/png" href="../favicon.ico">


<title> List Maker Preview </title>

</head>

<body>
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
       <h1> List Maker Preview </h1>
       </div><!-- end header text-->

      <div id ="page_nav">
      <ul>
        <li><a href="edit_scheduled.php" target="_blank">Edit Scheduled</a></li>
        <li><a href="https://www.noblenet.org/sis/evergreen/tools/" target="_blank">Cool Tools</a></li>
        <!--<li><a href="https://docs.google.com/a/noblenet.org/document/d/1eCN_JjnpSpY3xBxaO_-fAVLf-Fv9VJUo_CBUfkdiXG4/edit?usp=sharing" target="_blank">Changelog</a></li>-->
      <ul>
    </div><!-- end page nav -->

  </div> <!-- end header -->

  <div id ="content">

       <br/>
        <a href="list_form.php" class="top_link"> Generate New List </a>
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
	$output  = new Output_Options();

	//Run Filters->SQL to get records
	$eg_db = pg_connect("host=$eg_host port=$eg_port dbname=$eg_database user=$eg_user password=$eg_password");
	if (!$eg_db)
	{
		die("Error in connection to circulation DB: " . pg_last_error());
	}

	$filters->SetDB($eg_db);
	echo "Line 71";

	//Create Filters from post variables
	//Filters
	$filters->SetLibrary($_POST['library']);

	if (isset($_POST['branch_filter']))
	{
		if ($_POST['branch_filter'] != "NONE" && $_POST['branch_filter'] != "ALL")
		{
			$filters->SetLibrary($_POST['branch_filter']);
		}
	}

	if (isset($_POST['all_locations']))
	{
		$filters->SetCopyLocations("all");
	}
	else if (isset($_POST['copy_loc_group']) && $_POST['copy_loc_group'] != -1)
	{
		$filters->SetCopyLocationGroup($_POST['copy_loc_group']);
	}
	else
	{
		//get the copy locations
		$copy_locs = array();
		// Loop to store and display values of individual checked checkbox.
		foreach ($_POST['copy_loc_checkboxes'] as $loc)
		{
			$copy_locs[] = $loc;
		}

		$filters->SetCopyLocations(implode(",", $copy_locs));
	}

	if (isset($_POST['use_active']))
	{

		$added_date_type = $_POST['added_date_type'];
		$added_time_type = $_POST['added_time_type'];


		$filters->SetFilterByAddedType($added_time_type);

		if ($added_date_type == "absolute")
		{

			$start        = $_POST['active_start'];
			$active_start = date('Y-m-d', strtotime("$start"));

			if ($added_time_type == "before")
			{
				$filters->SetFilterByAdded(null, $active_start);
			}
			else if ($added_time_type == "after")
			{
				$filters->SetFilterByAdded($active_start, null);
			}
			else if ($added_time_type == "between")
			{
				$end        = $_POST['active_end'];
				$active_end = date('Y-m-d', strtotime("$end"));
				$filters->SetFilterByAdded($active_start, $active_end);
			}

		}
		else if ($added_date_type == "relative")
		{

			$start        = $_POST['active_start_relative'];
			$start_time   = $_POST['added_start_time'];
			$active_start = $start . "_" . $start_time;

			if ($added_time_type == "before")
				$filters->SetFilterByAddedRelative(null, $active_start);
			else if ($added_time_type == "after")
				$filters->SetFilterByAddedRelative($active_start, null);
			else if ($added_time_type == "between")
			{
				$end        = $_POST['active_end_relative'];
				$end_time   = $_POST['added_end_time'];
				$active_end = $end . "_" . $end_time;

				if ($start_time == $end_time)
				{
					if ($start > $end)
						$filters->SetFilterByAddedRelative($active_start, $active_end);
					else
						$filters->SetFilterByAddedRelative($active_end, $active_start);
				}
				else
				{
					if ($start_time == "days")
					{
						$filters->SetFilterByAddedRelative($active_end, $active_start);
					}
					else if ($start_time == "weeks")
					{
						if ($end_time == "days")
							$filters->SetFilterByAddedRelative($active_start, $active_end);
						else if ($end_time == "months" || $end_time == "years")
							$filters->SetFilterByAddedRelative($active_end, $active_start);
					}
					else if ($start_time == "months")
					{
						if ($end_time == "days" || $end_time == "weeks")
							$filters->SetFilterByAddedRelative($active_start, $active_end);
						else if ($end_time == "years")
							$filters->SetFilterByAddedRelative($active_end, $active_start);
					}
					else if ($start_time == "years")
					{
						$filters->SetFilterByAddedRelative($active_start, $active_end);
					}

				}

			}
		}
	}

	if (isset($_POST['status_change']))
	{
		$status_date_type = $_POST['status_date_type'];
		$stat_time_type   = $_POST['stat_time_type'];

		$filters->SetFilterByLastStatusType($stat_time_type);

		if ($status_date_type == "absolute")
		{
			$start        = $_POST['status_date_start'];
			$status_start = date('Y-m-d', strtotime("$start"));

			if ($stat_time_type == "before")
				$filters->SetFilterByStatusChanged(null, $status_start);
			else if ($stat_time_type == "after")
				$filters->SetFilterByStatusChanged($status_start, null);
			else if ($stat_time_type == "between")
			{
				$end        = $_POST['status_date_end'];
				$status_end = date('Y-m-d', strtotime("$end"));
				$filters->SetFilterByStatusChanged($status_start, $status_end);
			}

		}
		else if ($status_date_type == "relative")
		{
			$start        = $_POST['status_date_start_relative'];
			$start_time   = $_POST['stat_start_time'];
			$status_start = $start . "_" . $start_time;

			if ($added_time_type == "before")
				$filters->SetFilterByStatusChangedRelative(null, $status_start);
			else if ($added_time_type == "after")
				$filters->SetFilterByStatusChangedRelative($status_start, null);
			else if ($added_time_type == "between")
			{
				$end        = $_POST['status_date_end_relative'];
				$end_time   = $_POST['stat_end_time'];
				$status_end = $end . "_" . $end_time;

				if ($start_time == $end_time)
				{
					if ($start > $end)
						$filters->SetFilterByStatusChangedRelative($status_start, $status_end);
					else
						$filters->SetFilterByStatusChangedRelative($status_end, $status_start);
				}
				else
				{
					if ($start_time == "days")
					{
						$filters->SetFilterByStatusChangedRelative($status_end, $status_start);
					}
					else if ($start_time == "weeks")
					{
						if ($end_time == "days")
							$filters->SetFilterByStatusChangedRelative($status_start, $status_end);
						else if ($end_time == "months" || $end_time == "years")
							$filters->SetFilterByStatusChangedRelative($status_end, $status_start);
					}
					else if ($start_time == "months")
					{
						if ($end_time == "days" || $end_time == "weeks")
							$filters->SetFilterByStatusChangedRelative($status_start, $status_end);
						else if ($end_time == "years")
							$filters->SetFilterByStatusChangedRelative($status_end, $status_start);
					}
					else if ($start_time == "years")
					{
						$filters->SetFilterByStatusChangedRelative($status_start, $status_end);
					}

				}
			}
		}
	}

	if (!empty($_POST['status_checkboxes']))
	{
		$statuses = array();
		// Loop to store and display values of individual checked checkbox.
		foreach ($_POST['status_checkboxes'] as $stat)
		{
			$statuses[] = $stat;
		}

		$filters->SetFilterByStatus(implode(",", $statuses));
	}

	if (!empty($_POST['prefix_checkboxes']))
	{
		$prefixes = array();
		// Loop to store and display values of individual checked checkbox.
		foreach ($_POST['prefix_checkboxes'] as $pre)
		{
			$prefixes[] = $pre;
		}

		$filters->SetFilterByCallPrefix(implode(",", $prefixes));
	}

	if (!empty($_POST['suffix_checkboxes']))
	{
		$suffixes = array();
		// Loop to store and display values of individual checked checkbox.
		foreach ($_POST['suffix_checkboxes'] as $suf)
		{
			$suffixes[] = $suf;
		}

		$filters->SetFilterByCallSuffix(implode(",", $suffixes));
	}

	if (!empty($_POST['circ_mod_checkboxes']))
	{
		$circ_mods = array();
		// Loop to store and display values of individual checked checkbox.
		foreach ($_POST['circ_mod_checkboxes'] as $mod)
		{
			$circ_mods[] = $mod;
		}

		$filters->SetFilterByCircMod(implode(",", $circ_mods));
	}

	if (!empty($_POST['stat_cats']))
	{
		$new_stat_cat   = $_POST['stat_cats'];
		$open_paren     = strpos($new_stat_cat, "(");
		$stat_cat       = substr($new_stat_cat, 0, $open_paren);
		$stat_cat_entry = trim(substr($new_stat_cat, $open_paren + 1), ")*");

		$filters->SetFilterByStatCat($stat_cat, $stat_cat_entry, true);
	}

	if ($_POST['input_file_name'] != -1)
	{
		if ($_POST['input_data_type'] == 'bib')
		{
			$filters->SetFilterByBibFile($_POST['input_file_type'], $_POST['input_file_name']);
		}
		else if ($_POST['input_data_type'] == 'barcode')
		{
			$filters->SetFilterByBarcodeFile($_POST['input_file_type'], $_POST['input_file_name']);
		}
		else
		{
			$filters->SetFilterByISBNFile($_POST['input_file_type'], $_POST['input_file_name']);
			;
		}
	}

	if (isset($_POST['electronic']))
	{
		$filters->SetFilterByElectronic($_POST['electronic']);
	}


	//call number
	$call_class = $_POST['call_class'];

	if ($call_class != 0)
	{
		if ($call_class == '4') //BISAC
		{
			if ($_POST['call_method'] == "bisac")
			{

				$level1 = $_POST['level1'];
				$level2 = $_POST['level2'];
				$level3 = $_POST['level3'];

				$bisac_cats = $level1;
				if ($level2 != -1)
				{
					$bisac_cats .= "-" . $level2;
					if ($level3 != -1)
						$bisac_cats .= "-" . $level3;
				}

				$bisac_cats = str_replace(" ", "", $bisac_cats);

				$filters->SetFilterByBisac($call_class, $bisac_cats);
			}
			else if ($_POST['call_method'] == "contains")
			{
				$contains = $_POST['contains_call'];
				$filters->SetFilterByCallContains($call_class, $contains);
			}

		}
		else if ($call_class == '2' || $call_class == '3') //BISAC
		{
			if ($_POST['call_method'] == "range")
			{
				$start_call = $_POST['start_call'];
				$end_call   = $_POST['end_call'];
				$filters->SetFilterByCallRange($call_class, $start_call, $end_call);
			}
		}
		else
		{
			if ($_POST['call_method'] == "contains")
			{
				$contains = $_POST['contains_call'];
				$filters->SetFilterByCallContains($call_class, $contains);
			}
			else if ($_POST['call_method'] == "range")
			{
				$start_call = $_POST['start_call'];
				$end_call   = $_POST['end_call'];
				$filters->SetFilterByCallRange($call_class, $start_call, $end_call);
			}
		}
	}

	if (isset($_POST['scope_links']))
	{
		$filters->SetScope();
	}

	if (isset($_POST['use_domain']))
	{
		$filters->SetDomain($_POST['domain']);
	}

	if (isset($_POST['search_links']))
	{
		$filters->SetSearchLinks();
	}

	$domain = $filters->GetDomain();
	$scope  = $filters->GetScope();

	echo "line 405";

	//Create Output from post variables
	$output_array = explode(' ', $_POST['preview_text']);
	$output->CreateOutputOptions($output_array);

	//Create a new bib list
	$bib_list = new BibList();

	$bib_list->SetDB($eg_db);

	$bib_list->SetLibrary($filters->GetLibrary());

	$bib_list->SetGroupCopies($output->GetGroupCopies());

	$bib_list->SetOneBibOneCopy($output->GetUngroupCopies());

	$result = pg_query($eg_db, $filters->CreateSQL());

	$count = 1;

	while ($row = pg_fetch_row($result))
	{
		if (!$filters->LookForPhysicalCopies())
		{
			break;
		}

		/*Loop through results
		0         reporter.materialized_simple_record.title //not used but needed for sorting
		1          asset.call_number.record,
		2          asset.copy.cost,
		3          asset.copy.active_date,
		4          asset.copy.create_date,
		5          asset.copy.age_protect,
		6          1
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



		echo "/****************** COPY #".$count."*******************\n"; */

		$count++;

		$bib_id = $row[1];

		$curr_copy = new CopyRec();
		$curr_copy->SetDB($eg_db);

		$curr_copy->SetAcqCost($row[2]);
		$curr_copy->SetActiveDate($row[3], $row[4]);
		$curr_copy->SetAgeProtect($row[5]);
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

		$curr_bib = new BibRec();

		$curr_bib->SetBibId($bib_id, $domain, $scope);
		$curr_bib->SetDB($eg_db);

		$curr_bib->SetISBN($row[29], $row[30]);
		$curr_bib->SetPublisher($row[31]);
		$curr_bib->SetAuthor(); //always get this
		$curr_bib->SetPubYear(); //always get this
		$curr_bib->SetTitle(); //always get this
		$curr_bib->SetGoodreadsLink();
		//$curr_bib->SetNovelistLink();
		//$curr_bib->SetGoogleLink();
		if ($output->GetSummary())$curr_bib->SetSummary();

		if ($filters->GetSearchLinks())
		{
			$curr_bib->SetSearchLink($domain, $scope);
		}

		//execute filters that can't be done in the filter SQL
		if ($filters->ExcludeRecByAddedDate($curr_copy->GetActiveDate()))
		{
			continue;
		}

		$bib_list->AddItem($curr_bib, $curr_copy);
	}

	//NOw get any Online Records
	if ($filters->LookForOnlineRecords())
	{
		$result = pg_query($eg_db, $filters->CreateOnlineSQL());

		while ($row = pg_fetch_row($result))
		{
			/*  0 = reporter.materialized_simple_record.title,
			1 = reporter.materialized_simple_record.author,
			2 = reporter.materialized_simple_record.isbn,
			3 = reporter.materialized_simple_record.issn,
			4 = reporter.materialized_simple_record.publisher,
			5 = asset.call_number.record
			6 = asset.uri.href
			7 = asset.uri.label
			8 = actor.org_unit.shortname */


			$bib_id   = $row[5];
			$curr_bib = new BibRec();

			$curr_bib->SetOnline();
			$curr_bib->SetBibId($bib_id, $domain, $scope);
			$curr_bib->SetDB($eg_db);

			$curr_bib->SetISBN($row[2], $row[3]);
			$curr_bib->SetPublisher($row[4]);
			$curr_bib->SetOnlineSubU($row[6]);
			$curr_bib->SetOnlineSubY($row[7]);
			$curr_bib->SetPubYear(); //always get this
			$curr_bib->SetTitle(); //always get this
			$curr_bib->SetAuthor();
			$curr_bib->SetGoodreadsLink();
			//$curr_bib->SetNovelistLink();
			//$curr_bib->SetGoogleLink();

			if ($filters->GetSearchLinks())$curr_bib->SetSearchLink($domain, $scope);

			//Calculated from individual queiries - only do if care if need in output?
			if ($output->GetOCLCNumber())$curr_bib->SetOCLCNumber();
			if ($output->GetSummary())$curr_bib->SetSummary();

			if ($filters->ExcludeRecByPubDate($curr_bib->GetPubYear()))
			{
				continue;
			}
			else
			{
				//send the bib and copy to Bib list to add where it needs to go in the stored lists
				$bib_list->AddOnlineItem($curr_bib);
			}
		} //end while
	} //end online

	//check size of bib list. If too big return.
	$count             = $bib_list->GetNumCopies();
	$bib_count         = $bib_list->GetNumBibs();
	$online_bib_count  = $bib_list->GetNumOnlineBibs();
	$online_link_count = $bib_list->GetNumOnlineLinks();

	$total_bibs = $bib_count + $online_bib_count;
	if ($total_bibs > 5000)
	{
		echo "<h3>Your completed report contains" . number_format($total_bibs) . " records which is larger than the Maximum of 5,000.";
		echo "Please try your Quick Preview with more filters. Or run as an Inventory/Booklist which allows for 50,000 record output";
		echo "</h3>";

		echo "<div class=\"preview_out\">";
		echo "<p>" . $filters->GetTextForPreview() . "</p>";
		echo "<p>" . $output->GetTextForPreview() . "</p>";
		echo "</div>";

	}
	else
	{
		//Text to list the count and bib count
		echo "<h3>Your completed report is below. It contains " . number_format($count) . " copies attached to " . number_format($bib_count) . " unique bibs.";
		if ($online_bib_count > 0)echo "<br/>There are " . number_format($online_link_count) . " links attached to " . number_format($online_bib_count) . " unique online bibs.";
		echo "</h3>";

		echo "<div class=\"preview_out\">";
		echo "<p>" . $filters->GetTextForPreview() . "</p>";
		echo "<p>" . $output->GetTextForPreview() . "</p>";
		echo "</div>";


		//Prints HTML to the display
		echo $output->GetHTML($bib_list);
	}

	?>

       <a href="list_form.php" class="top_link"> Generate New List </a>
       <br/><br />

  </div><!-- end contents -->

     <div id="footer">

      <div id="footer_links">
      <ul>
         <li><a href="https://www.noblenet.org/sis/" target="blank"> Staff Information System </a></li>
         <li><a href="https://evergreen.noblenet.org" target="blank"> Catalog </a></li>
         <li><a href="mailto:tools@noblenet.org?Subject=Dashboard Contact Form"> Contact</a></li>
      </ul>
      </div><!-- end links -->

   </div> <!-- end footer -->


</div><!-- end wrapper -->

</body>

</html>
