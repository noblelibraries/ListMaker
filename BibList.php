<?php

//contains all the records and statistics for a system
class BibList
{
   public $db;

   //USED FOR HTML
   //both contain pointers the the same records but organized differently.
   public $multiple_copy_recs; //array of MultipleCopyBib - used for getting info at a bib level
   public $group_copies;

   //USED FOR SPREADSHEET
   public $one_bib_one_copy_recs; //array of LibCopyList - index is the lib_id (or system if NOBLE)
   public $single_copy_recs;
   public $unique_bibs;
   public $max_stat_cat;

   //ONLINE RECORDES
   public $online_recs; //array with Bib-id as key
   public $online_unique_bibs;

   //order of the arrays - author, active, call, circ, title, ytd
   public $multiple_order;
   public $one_to_one_order;
   public $online_order;

   public $total_copies;
   public $total_bibs;
   public $total_circs;
   public $total_online_bibs;
   public $total_online_links;

   public $count_circs_between;
   public $total_circs_between;

   public $pub_years;
   public $num_excluded_pub;

   public $prices;
   public $num_excluded_price;
   public $include_price_summary;

   public $acq_costs;
   public $num_excluded_cost;
   public $include_cost_summary;

   public $online_pub_years;
   public $num_excluded_pub_online;

   public $library; //name of the system being processed
   public $branch_ids; //ids of all the branches in this system

   public $get_grouped_count_data;
   public $grouped_data;

   function __construct()
   {
      $this->group_copies = true;
      $this->single_copy_recs = true;
      $this->multiple_copy_recs = array();
      $this->one_bib_one_copy_recs = array();
      $this->unique_bibs = array();
      $this->circ_vals = array();
      $this->pub_years = array();
      $this->prices = array();
      $this->acq_costs = array();
      $this->online_pub_years = array();
      $this->online_unique_bibs = array();
      $this->online_recs = array();
      $this->total_bibs = 0;
      $this->total_copies = 0;
      $this->total_circs = 0;
      $this->total_circs_between = 0;
      $this->count_circs_between = false;
      $this->total_online_bibs = 0;
      $this->total_online_links = 0;
      $this->num_excluded_pub = 0;
      $this->num_excluded_pub_online = 0;
      $this->num_excluded_price = 0;
      $this->num_excluded_cost = 0;
      $this->multiple_order ="call";
      $this->one_to_one_order = "call";
      $this->max_stat_cat = 0;
      $this->include_price_summary = false;
      $this->include_cost_summary = false;

      $this->library = "";
      $this->branch_ids = array();

      $this->get_grouped_count_data = false;
   }

   function __destruct()
   {
      unset($this->pub_years);
      unset($this->prices);
      unset($this->acq_costs);
      unset($this->online_pub_years);
      unset($this->online_unique_bibs);
      unset($this->unique_bibs);
      unset($this->circ_vals);
      unset($this->multiple_copy_recs);
      unset($this->one_bib_one_copy_recs);
      unset($this->branch_ids);
      if ($this->get_grouped_count_data)unset($this->grouped_data);
   }

   function SetDB($val)
   {
      $this->db = $val;
   }

   function SetLibrary($val)
   {
      $this->library = $val;

      $sql = "SELECT child.id
              FROM actor.org_unit parent
              JOIN actor.org_unit child ON child.parent_ou = parent.id
              WHERE parent.shortname = '$val'
              ORDER BY 1";

      $result = pg_query($this->db,$sql);

      $count =0;
      while($row = pg_fetch_row($result))
      {
         $this->branch_ids[] = $row[0];
         $count++;
      }

      //if this has no branchess, this is a branch
      if($count == 0 )
      {

         $sql = "SELECT id
                 FROM actor.org_unit
                 WHERE shortname = '$val'
                 ORDER BY 1";

         $result = pg_query($this->db,$sql);
         $row = pg_fetch_row($result);
         $this->branch_ids[] = $row[0];
      }

   }

   function GetLibrary()
   {
      return $this->library;
   }

   function GetBranchIds()
   {
      //return all the
      return implode(',', $this->branch_ids);
   }

   function GetNumBranches()
   {
      return count($this->branch_ids);
   }

   function GetMaxStatCat()
   {
      return $this->max_stat_cat;
   }

   function SetGroupCopies($val)
   {
      $this->group_copies = $val;
   }

   function SetOneBibOneCopy($val)
   {
      $this->single_copy_recs = $val;
   }

   function GetSingleCopy()
   {
      return $this->single_copy_recs;
   }

   function SetCircBetween()
   {
      $this->count_circs_between = true;
   }

   function SetGroupData($output)
   {
      if ($output->GetCountsSheet())
      {
         $this->get_grouped_count_data = true;
         $this->grouped_data = new GroupCounts();
         $this->grouped_data->SetGroupCountData($output);
      }
   }

   function GetGroupData()
   {
      if ($this->get_grouped_count_data)
      {
         return $this->grouped_data;
      }
      else
      {
         return false;
      }
   }

   function HasOnlineRecs()
   {
      if (count($this->online_recs) > 0 ) return true;
      else return false;
   }

   function AddOnlineItem($bib_rec)
   {
      $this->online_recs[] = $bib_rec;

      //update the number of bibs in biblist
      $bib_id = $bib_rec->GetBibId();
      if (!in_array($bib_id, $this->online_unique_bibs))
      {
         $this->online_unique_bibs[] = $bib_id;
         $this->total_online_bibs++;
      }
      $this->total_online_links++;

      if($bib_rec->GetPubYear() > 0) $this->online_pub_years[] = $bib_rec->GetPubYear();
      else $this->num_excluded_pub_online++;
   }

   function AddItem($bib_rec, $copy_rec)
   {
      //figure out if needs to go into the multiple copy list

      if ($this->group_copies)
      {
			$multiple = $this->FindInMultipleBibList($bib_rec->GetBibId());

			if ($multiple)
			{
				//this bib is in the multiple copy list
				//just addd the copy to mulitple copy per bib
				$multiple->AddCopy($copy_rec);
			}
			else
			{
				//make a new MUltipleCopyBib
				$multiple = new MultipleCopyBib();
				$multiple->CopyFromBib($bib_rec);

				//get the number of holds for this lib and not this lib
				$multiple->SetHoldCounts($this->branch_ids);

				//get the other library count for the system
				$multiple->SetOtherLibraryCount($this->branch_ids);

				//get the circ count for the system
				$multiple->SetTotalCircsBySys($this->branch_ids, $copy_rec);

				//Add the copy to multiple bib
				$multiple->AddCopy($copy_rec);

				//Add  bib to multiple list
				$this->multiple_copy_recs[]= $multiple;

				//update the number of bibs in biblist
				$this->total_bibs++;
			}

			if (!$this->single_copy_recs)
			{
			    $this->total_copies++;
			    $this->total_circs += $copy_rec->GetLifetimeCircs();

			    if($this->count_circs_between) $this->total_circs_between += $copy_rec->GetCircsBetween();

			    $this->circ_vals[] =$copy_rec->GetLifetimeCircs();

	   	        if($multiple->GetPubYear() > 0) $this->pub_years[] = $multiple->GetPubYear();
		   	    else $this->num_excluded_pub++;

                if ($this->include_price_summary )
                {
		   	       if($copy_rec->GetPrice() > 0) $this->prices[] = $copy_rec->GetPrice();
		           else $this->num_excluded_price++;
		        }

		        if ($this->include_cost_summary )
                {
		   	       if($copy_rec->GetAcqCost() > 0) $this->acq_costs[] = $copy_rec->GetAcqCost();
		           else $this->num_excluded_cost++;
		        }
			}
      }

      if ($this->single_copy_recs)
      {
         if (!$this->group_copies)
         {
            //count the number of bibs
			$bib_id = $bib_rec->GetBibId();
			if (!in_array($bib_id, $this->unique_bibs))
			{
			   $this->unique_bibs[] = $bib_id;
			   $this->total_bibs++;
			}
         }

         $one_to_one = new OneCopyBib();
		 $one_to_one->CopyFromBib($bib_rec);
		 $one_to_one->AddCopy($copy_rec);

         if($this->library == "NOBLE")
         {
            $lib_id = $copy_rec->GetSystemId();
            $shortname = $copy_rec->GetSystemShortname();
         }
         else
         {
            $lib_id = $copy_rec->GetCircLibId();
            $shortname = $copy_rec->GetCircLibShortname();
         }

		 if(!isset($this->one_bib_one_copy_recs[$lib_id]))
		 {
		      $library_list = new LibCopyList();
		      $library_list->SetLibrary($shortname, $lib_id);

		      $library_list->SetIncludePrice($this->include_price_summary);
		      $library_list->SetIncludeAcqCost($this->include_cost_summary);

		      if ($this->count_circs_between) $library_list->SetCircsBetween();

		      $this->one_bib_one_copy_recs[$lib_id] = $library_list;

		      ksort($this->one_bib_one_copy_recs);

   		 }

   		 $this->one_bib_one_copy_recs[$lib_id]->AddRecord($one_to_one);

   		 if($this->max_stat_cat < $this->one_bib_one_copy_recs[$lib_id]->GetMaxStatCat())
		 {
		    $this->max_stat_cat = $this->one_bib_one_copy_recs[$lib_id]->GetMaxStatCat();
		 }

   		 //Update all the values in the BIBLIst for the system
   		 $this->total_copies++;
		 $this->total_circs += $copy_rec->GetLifetimeCircs();

		 if($this->count_circs_between)
		 {
		    $this->total_circs_between += $copy_rec->GetCircsBetween();
		 }

		 $this->circ_vals[] =$copy_rec->GetLifetimeCircs();

		 if($one_to_one->GetPubYear() > 0) $this->pub_years[] = $one_to_one->GetPubYear();
		 else $this->num_excluded_pub++;

		 if( $this->include_price_summary )
		 {
		    if($copy_rec->GetPrice() > 0) $this->prices[] = $copy_rec->GetPrice();
		    else $this->num_excluded_price++;
		 }

		 if( $this->include_cost_summary )
		 {
		    if($copy_rec->GetAcqCost() > 0) $this->acq_costs[] = $copy_rec->GetAcqCost();
		    else $this->num_excluded_cost++;
		 }

		 if ($this->get_grouped_count_data)$this->grouped_data->AddItemInfo($copy_rec);

      }
   }

   function FindInMultipleBibList($bib_id)
   {
      foreach($this->multiple_copy_recs as $bib)
      {
         if ($bib->GetBibId() == $bib_id) return $bib;
      }

      return null;
   }

   function GetNumCopies()
   {
      return $this->total_copies;
   }

   function GetNumBibs()
   {
      return $this->total_bibs;
   }

   function GetNumOnlineBibs()
   {
      return $this->total_online_bibs;
   }

   function GetNumOnlineLinks()
   {
      return $this->total_online_links;
   }

   function GetNumCircsBetween()
   {
      return $this->total_circs_between;
   }

   function GetNumCircs()
   {
      return $this->total_circs;
   }

   function GetMedianPubYear()
   {
       //Sort array
       sort($this->pub_years, SORT_NUMERIC);
       $total_items = count($this->pub_years);

       $middle = round($total_items / 2);
       if ($total_items > 1) $median_pub_year = $this->pub_years[$middle-1];
       else $median_pub_year = $this->pub_years[0];

       return $median_pub_year;
   }

   function GetOnlineMedianPubYear()
   {
       //Sort array
       sort($this->online_pub_years, SORT_NUMERIC);
       $total_items = count($this->online_pub_years);

       $middle = round($total_items / 2);
       $median_pub_year = $this->online_pub_years[$middle-1];

       return $median_pub_year;
   }

   function GetMeanPubYear()
   {
        //Sort array
       $total_items = count($this->pub_years);
       if ($total_items > 1)
       {
          $sum = array_sum($this->pub_years);
          $avg_pub_year = round($sum / $total_items);
       }
       else $avg_pub_year = '';

       return $avg_pub_year;
   }

   function GetOnlineMeanPubYear()
   {
        //Sort array
       $total_items = count($this->online_pub_years);

       $sum = array_sum($this->online_pub_years);
       $avg_pub_year = round($sum / $total_items);

       return $avg_pub_year;
   }

   function GetModePubYear()
   {
      $values = array_count_values($this->pub_years);
      $mode = array_search(max($values), $values);

      return $mode;
   }

   function GetOnlineModePubYear()
   {
      $values = array_count_values($this->online_pub_years);
      $mode = array_search(max($values), $values);

      return $mode;
   }

   function GetMinPubYear()
   {
      return min($this->pub_years);
   }

   function GetOnlineMinPubYear()
   {
      return min($this->online_pub_years);
   }

   function GetMaxPubYear()
   {
      return max($this->pub_years);
   }

   function GetOnlineMaxPubYear()
   {
      return max($this->online_pub_years);
   }

   function GetExcludedPubYears()
   {
      return $this->num_excluded_pub;
   }

   function GetOnlineExcludedPubYears()
   {
      return $this->num_excluded_pub_online;
   }

   function SetPriceSummary($price)
   {
      $this->include_price_summary = $price;
   }

   function GetMedianPrice()
   {
       //Sort array
       sort($this->prices, SORT_NUMERIC);
       $total_items = count($this->prices);

       $middle = round($total_items / 2);
       if ($total_items > 1) $median_price = $this->prices[$middle-1];
       else $median_price = $this->prices[0];

       return $median_price;
   }

   function GetMeanPrice()
   {
        //Sort array
       $total_items = count($this->prices);
       if ($total_items > 1)
       {
          $sum = array_sum($this->prices);
          $avg_price = round($sum / $total_items);
       }
       else $avg_price = '';

       return $avg_price;
   }


   function GetModePrice()
   {
      $values = array_count_values($this->prices);
      $mode = array_search(max($values), $values);

      return $mode;
   }

   function GetMinPrice()
   {
      return min($this->prices);
   }

   function GetMaxPrice()
   {
      return max($this->prices);
   }

   function GetExcludedPrices()
   {
      return $this->num_excluded_price;
   }

   function SetAcqCostSummary($cost)
   {
      $this->include_cost_summary = $cost;
   }

   function GetMedianAcqCost()
   {
       //Sort array
       sort($this->acq_costs, SORT_NUMERIC);
       $total_items = count($this->acq_costs);

       $middle = round($total_items / 2);
       if ($total_items > 1) $median_cost = $this->acq_costs[$middle-1];
       else $median_cost = $this->acq_costs[0];

       return $median_cost;
   }

   function GetMeanAcqCost()
   {
        //Sort array
       $total_items = count($this->acq_costs);
       if ($total_items > 1)
       {
          $sum = array_sum($this->acq_costs);
          $avg_cost = round($sum / $total_items);
       }
       else $avg_cost = '';

       return $avg_cost;
   }

   function GetModeAcqCost()
   {
      $values = array_count_values($this->acq_costs);
      $mode = array_search(max($values), $values);

      return $mode;
   }

   function GetMinAcqCost()
   {
      return min($this->acq_costs);
   }

   function GetMaxAcqCost()
   {
      return max($this->acq_costs);
   }

   function GetExcludedAcqCosts()
   {
      return $this->num_excluded_cost;
   }

   function GetMedianCircCount()
   {
       if (count($this->circ_vals) == 0 )  return "N/A";

       //Sort array
       sort($this->circ_vals, SORT_NUMERIC);
       $total_items = count($this->circ_vals);

       $middle = round($total_items / 2);
       $median_circ = $this->circ_vals[$middle-1];

       return $median_circ;
   }

   function GetMeanCircCount()
   {
       if (count($this->circ_vals) == 0 )  return "N/A";

       //Sort array
       $total_items = count($this->circ_vals);

       $sum = array_sum($this->circ_vals);
       $avg_circ = round($sum / $total_items);

       return $avg_circ;
   }

   function GetModeCircCount()
   {
      if (count($this->circ_vals) == 0 )  return "N/A";

      $values = array_count_values($this->circ_vals);
      $mode = array_search(max($values), $values);

      return $mode;
   }

   function GetMinCircCount()
   {
      if (count($this->circ_vals) > 0 ) return min($this->circ_vals);
      else return "N/A";
   }

   function GetMaxCircCount()
   {
      if (count($this->circ_vals) > 0 ) return max($this->circ_vals);
      else return "N/A";
   }


   function GetTurnoverRate()
   {
      if ($this->total_copies > 0 )return $this->total_circs/$this->total_copies;
      else return "N/A";
   }


   function SortByActiveDate($type)
   {
      if ($type == "single")
      {
         if ($this->one_to_one_order == "active") return;

         foreach($this->one_bib_one_copy_recs as $lib_id => $lib)
         {
            //look a the bibs for this library and sort
            $bib_data = $lib->bib_copy_list;

            usort($bib_data, array("BibList", "ActiveCompareSingle"));

            $this->one_bib_one_copy_recs[$lib_id]->bib_copy_list = $bib_data;
         }

         $this->one_to_one_order = "active";
      }
      else if ($type == "multiple")
      {
         if ($this->multiple_order == "active") return;

         usort($this->multiple_copy_recs, array("BibList", "ActiveCompare"));

         $this->multiple_order = "active";
      }
   }

   function ActiveCompareSingle($rec1, $rec2)
   {
      //compare the date $rec1->copy->GetActiveDate();
      //return strcasecmp($rec1->GetTitle(), $rec2->GetTitle());
   }


   function SortyByAuthor($type)
   {
      if ($type == "single")
      {
         if ($this->one_to_one_order == "author") return;

         foreach($this->one_bib_one_copy_recs as $lib_id => $lib)
         {
            //look a the bibs for this library and sort
            $bib_data = $lib->bib_copy_list;;

            usort($bib_data, array("BibList", "AuthorCompare"));

            $this->one_bib_one_copy_recs[$lib_id]->bib_copy_list = $bib_data;
         }

         $this->one_to_one_order = "author";
      }
      else if ($type == "multiple")
      {
         if ($this->multiple_order == "author") return;

         usort($this->multiple_copy_recs, array("BibList", "AuthorCompare"));

         $this->multiple_order = "author";
      }
   }

   function AuthorCompare($rec1, $rec2)
   {
      return strcasecmp($rec1->GetAuthor(), $rec2->GetAuthor());
   }


   function SortByCallNum($type)
   {
      if ($type == "single")
      {
         if ($this->one_to_one_order == "call") return;

         foreach($this->one_bib_one_copy_recs as $lib_id => $lib)
         {
            //look a the bibs for this library and sort
            $bib_data = $lib->bib_copy_list;

            usort($bib_data, array("BibList", "CallCompareSingle"));

            $this->one_bib_one_copy_recs[$lib_id]->bib_copy_list = $bib_data;
         }

         $this->one_to_one_order = "call";
      }
      else if ($type == "multiple")
      {
         if ($this->multiple_order == "call") return;

         usort($this->multiple_copy_recs, array("BibList", "CallCompare"));

         $this->multiple_order = "call";
      }
   }

   function CallCompareSingle($rec1, $rec2)
   {
      return strcasecmp($rec1->copy->GetCallSortKey(), $rec2->copy->GetCallSortKey());
   }

   function SortByCircBetween($type)
   {
      if ($type == "single")
      {
         echo "In Circ Between -- Single .\n";
         if ($this->one_to_one_order == "circ_between") return;

         foreach($this->one_bib_one_copy_recs as $lib_id => $lib)
         {
            //look a the bibs for this library and sort
            $bib_data = $lib->bib_copy_list;

            usort($bib_data, array("BibList", "CircBetweenCompareSingle"));

            $this->one_bib_one_copy_recs[$lib_id]->bib_copy_list = $bib_data;
         }

         $this->one_to_one_order = "circ_between";
      }
      else if ($type == "multiple")
      {
         echo "In Circ Between-- Multiple .\n";
         if ($this->multiple_order == "circ_between") return;

         usort($this->multiple_copy_recs, array("BibList", "CircBetweenCompareMultiple"));

         $this->multiple_order = "circ_between";
      }
   }

   function CircBetweenCompareSingle($rec1, $rec2)
   {
      if ($rec1->copy->GetCircsBetween() == $rec2->copy->GetCircsBetween())
      {
         return 0;
      }
      else
      {
         return ($rec1->copy->GetCircsBetween() > $rec2->copy->GetCircsBetween()) ? -1 : 1;
      }
   }

   function CircBetweenCompareMultiple($rec1, $rec2)
   {
      if ($rec1->GetCircsBetween() == $rec2->GetCircsBetween())
      {
         return 0;
      }
      else
      {
         return ($rec1->GetCircsBetween() > $rec2->GetCircsBetween()) ? -1 : 1;
      }
   }

   function SortByLifetimeCircs($type)
   {
      if ($type == "single")
      {
         echo "In Lifetime circ-- Single .\n";
         if ($this->one_to_one_order == "circ") return;

         foreach($this->one_bib_one_copy_recs as $lib_id => $lib)
         {
            //look a the bibs for this library and sort
            $bib_data = $lib->bib_copy_list;

            usort($bib_data, array("BibList", "CircCompareSingle"));

            $this->one_bib_one_copy_recs[$lib_id]->bib_copy_list = $bib_data;
         }

         $this->one_to_one_order = "circ";
      }
      else if ($type == "multiple")
      {
         echo "In Lifetime circ-- Multiple .\n";
         if ($this->multiple_order == "circ") return;

         usort($this->multiple_copy_recs, array("BibList", "CircCompareMultiple"));

         $this->multiple_order = "circ";
      }
   }

   function CircCompareSingle($rec1, $rec2)
   {
      if ($rec1->copy->GetLifetimeCircs() == $rec2->copy->GetLifetimeCircs())
      {
         return 0;
      }
      else
      {
         return ($rec1->copy->GetLifetimeCircs() > $rec2->copy->GetLifetimeCircs()) ? -1 : 1;
      }
   }

   function CircCompareMultiple($rec1, $rec2)
   {
      if ($rec1->GetTotalCircs() == $rec2->GetTotalCircs())
      {
         return 0;
      }
      else
      {
         return ($rec1->GetTotalCircs() > $rec2->GetTotalCircs()) ? -1 : 1;
      }
   }

   function SortByTitle($type)
   {
      if ($type == "single")
      {
         if ($this->one_to_one_order == "title") return;

         foreach($this->one_bib_one_copy_recs as $lib_id => $lib)
         {
            //look a the bibs for this library and sort
            $bib_data = $lib->bib_copy_list;

            usort($bib_data, array("BibList", "TitleCompare"));

            $this->one_bib_one_copy_recs[$lib_id]->bib_copy_list = $bib_data;
         }

         $this->one_to_one_order = "title";
      }
      else if ($type == "multiple")
      {
         if ($this->multiple_order == "title") return;

         usort($this->multiple_copy_recs, array("BibList", "TitleCompare"));

         $this->multiple_order = "title";
      }
   }

   function TitleCompare($rec1, $rec2)
   {
      return strcasecmp($rec1->GetTitle(), $rec2->GetTitle());
   }


   function SortByYTDCircs($type)
   {
      if ($type == "single")
      {
         if ($this->one_to_one_order == "ytd") return;

         foreach($this->one_bib_one_copy_recs as $lib_id => $lib)
         {
            //look a the bibs for this library and sort
            $bib_data = $lib->bib_copy_list;

            usort($bib_data, array("BibList", "YTDCompareSingle"));

            $this->one_bib_one_copy_recs[$lib_id]->bib_copy_list = $bib_data;
         }

         $this->one_to_one_order = "ytd";
      }
      else if ($type == "multiple")
      {
         if ($this->multiple_order == "ytd") return;

         usort($this->multiple_copy_recs, array("BibList", "YTDCompareMultiple"));

         $this->multiple_order = "ytd";
      }
   }

   function YTDCompareSingle($rec1, $rec2)
   {
      if ($rec1->copy->GetYTDCirc() == $rec2->copy->GetYTDCirc())
      {
         return 0;
      }
      else
      {
         return ($rec1->copy->GetYTDCirc() > $rec2->copy->GetYTDCirc()) ? -1 : 1;
      }
   }

   function YTDCompareMultiple($rec1, $rec2)
   {
      if ($rec1->GetYTDCircs() == $rec2->GetYTDCircs())
      {
         return 0;
      }
      else
      {
         return ($rec1->GetYTDCircs() > $rec2->GetYTDCircs()) ? -1 : 1;
      }
   }

}