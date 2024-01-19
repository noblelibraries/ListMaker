<?php

// contains all the records and statistics for a single library/branch
class LibCopyList
{
   public $lib_shortname;
   public $lib_id;
   public $system_id;
   public $has_branches; //set to true when the list contains all the records for system

   public $bib_copy_list; //Array of OneCopyBibRecs

   public $max_stat_cat;
   public $total_copies;
   public $total_bibs;
   public $total_circs;

   public $count_circs_between;
   public $circs_between;

   public $pub_years;
   public $num_excluded_pub;

   public $prices;
   public $num_excluded_price;
   public $include_price_summary;

   public $acq_costs;
   public $num_excluded_cost;
   public $include_cost_summary;

   public $circ_vals; //used to create mean/mode for circs
   public $unique_bibs;

   function __construct()
   {
      $this->lib_shortname="";
      $this->lib_id = -1;
      $this->system_id = -1;
      $this->has_branches = false;

      $this->bib_copy_list = array();
      $this->pub_years = array();
      $this->prices = array();
      $this->acq_costs = array();
      $this->circ_vals = array();
      $this->unique_bibs = array();

      $this->total_circs = 0;
      $this->total_bibs = 0;
      $this->total_copies = 0;
      $this->circs_between = 0;
      $this->max_stat_cat = 0;
      $this->num_excluded_pub = 0;
      $this->num_excluded_price = 0;
      $this->num_excluded_cost = 0;

      $this->count_circs_between = false;
      $this->include_price_summary = false;
      $this->inlude_cost_summary = false;

   }

   function __destruct()
   {
      unset($this->bib_copy_list);
      unset($this->pub_years);
      unset($this->prices);
      unset($this->acq_costs);
      unset($this->circ_vals);
      unset($this->unique_bibs);
   }

   function AddRecord($one_to_one) //add this one_to_one record to the LibCopyLIst
   {

     $this->bib_copy_list[] = $one_to_one;

     $bib_id = $one_to_one->GetBibId();
	  if (!in_array($bib_id, $this->unique_bibs))
	  {
		  $this->unique_bibs[] = $bib_id;
	     $this->total_bibs++;
	  }

	  $this->total_circs += $one_to_one->GetTotalCircs();
	  $this->total_copies++;

	  if($this->count_circs_between)
	  {
	     $this->circs_between += $one_to_one->GetCircsBetween();
	  }

	  $this->circ_vals[] =$one_to_one->GetTotalCircs();

	  if($one_to_one->GetPubYear() > 0) $this->pub_years[] = $one_to_one->GetPubYear();
	  else $this->num_excluded_pub++;

	  if ($this->include_price_summary)
	  {
	     if($one_to_one->GetPrice() > 0) $this->prices[] = $one_to_one->GetPrice();
	     else $this->num_excluded_price++;
	  }

	  if ($this->include_cost_summary)
	  {
	     if($one_to_one->GetAcqCost() > 0) $this->acq_costs[] = $one_to_one->GetAcqCost();
	     else $this->num_excluded_cost++;
	  }

	  if($this->max_stat_cat < $one_to_one->GetNumStatCats())
	  {
	     $this->max_stat_cat = $one_to_one->GetNumStatCats();
	  }

   }

   function SetIncludePrice($price)
   {
      $this->include_price_summary = $price;
   }

   function SetIncludeAcqCost($cost)
   {
      $this->include_cost_summary = $cost;
   }

   function SetLibrary($shortname, $id)
   {
      $this->lib_shortname = $shortname;
      $this->lib_id = $id;

      if ($shortname == "BEVERLY" || $shortname == "EVERETT"
       || $shortname == "PEABODY" || $shortname == "PHILLIPS" || $shortname == "SALEMSTATE")
      {
         $this->has_branches = true;
      }
   }

   function SetSystem($id)
   {
      $this->system_id = $id;
   }

   function GetSystem()
   {
      return $this->system_id;
   }

   function GetHasBranches()
   {
      return $this->has_branches;
   }

   function GetShortname()
   {
      return $this->lib_shortname;
   }

   function GetLibId()
   {
      return $this->lib_id;
   }

   function SetCircsBetween()
   {
      $this->count_circs_between = true;
   }

   function GetNumCircsBetween()
   {
      return $this->circs_between;
   }

   function GetNumCircs()
   {
      return $this->total_circs;
   }

   function GetNumCopies()
   {
      return $this->total_copies;
   }

   function GetNumBibs()
   {
      return $this->total_bibs;
   }

   function GetMedianPubYear()
   {
       //Sort array
       sort($this->pub_years, SORT_NUMERIC);
       $total_items = count($this->pub_years);

       $middle = round($total_items / 2);
       $median_pub_year = $this->pub_years[$middle-1];

       return $median_pub_year;
   }

   function GetMeanPubYear()
   {
        //Sort array
       $total_items = count($this->pub_years);

       $sum = array_sum($this->pub_years);
       $avg_pub_year = round($sum / $total_items);

       return $avg_pub_year;
   }

   function GetModePubYear()
   {
      $values = array_count_values($this->pub_years);
      $mode = array_search(max($values), $values);

      return $mode;
   }

   function GetMinPubYear()
   {
      return min($this->pub_years);
   }

   function GetMaxPubYear()
   {
      return max($this->pub_years);
   }

   function GetExcludedPubYears()
   {
      return $this->num_excluded_pub;
   }

   function GetMedianPrice()
   {
       //Sort array
       sort($this->prices, SORT_NUMERIC);
       $total_items = count($this->prices);

       $middle = round($total_items / 2);
       $median_price_year = $this->prices[$middle-1];

       return $median_price_year;
   }

   function GetMeanPrice()
   {
        //Sort array
       $total_items = count($this->prices);

       $sum = array_sum($this->prices);
       $avg_price_year = round($sum / $total_items);

       return $avg_price_year;
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

   function GetMedianAcqCost()
   {
       //Sort array
       sort($this->acq_costs, SORT_NUMERIC);
       $total_items = count($this->acq_costs);

       $middle = round($total_items / 2);
       $median_cost_year = $this->acq_costs[$middle-1];

       return $median_cost_year;
   }

   function GetMeanAcqCost()
   {
        //Sort array
       $total_items = count($this->acq_costs);

       $sum = array_sum($this->acq_costs);
       $avg_cost_year = round($sum / $total_items);

       return $avg_cost_year;
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

   function GetMaxStatCat()
   {
      return $this->max_stat_cat;
   }
}

?>