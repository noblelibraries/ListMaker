<?php


class GroupCounts
{
  
   public $age_protect;
   public $age_protect_list;
   
   public $call_class;
   public $call_class_list;
   
   public $circ_mod;   
   public $circ_mod_list;
   
   public $copy_location;
   public $copy_location_list;
   
   public $encumbered;
   public $encumbered_list;
   
   public $fine_level;
   public $fine_level_list;
   
   public $floating;
   public $floating_list;
   
   public $fund;
   public $fund_list;
   
   public $last_checkout_lib;
   public $last_checkout_lib_list;
   
   public $loan_duration;
   public $loan_duration_list;
   
   public $only_holder;
   public $only_holder_list;
   
   public $prefix;
   public $prefix_list;
   
   public $stat_cat;  
   public $stat_cat_list;
   
   public $status;
   public $status_list;
 

   function __construct()
   {
   
		$this->age_protect = false;
		$this->age_protect_list = array("14 days" => 0, "1 month" => 0, "3 months" => 0 , "--" => 0);
	
		$this->call_class = false;
		$this->call_class_list = array();
	
		$this->circ_mod = false;   
		$this->circ_mod_list = array();
	
		$this->copy_location = false;
		$this->copy_location_list = array();
	
		$this->encumbered = false;
		$this->encumbered_list = array("TRUE"=> 0,"FALSE"=> 0);
	
		$this->fine_level = false;
		$this->fine_level_list = array("low" => 0,"normal" => 0,"high" => 0);
	
		$this->floating = false;
		$this->floating_list = array("TRUE" => 0, "FALSE" => 0);
	
		$this->fund = false;
		$this->fund_list = array();
	
		$this->last_checkout_lib = false;
		$this->last_checkout_lib_list = array();
	
		$this->loan_duration = false;
		$this->loan_duration_list = array("short" => 0,"normal" => 0,"long" => 0);
	
		$this->only_holder = false;
		$this->only_holder_list = array("TRUE" => 0 ,"FALSE" => 0);
	
		$this->prefix = false;
		$this->prefix_list = array();
	
		$this->stat_cat = false;  
		$this->stat_cat_list = array();
	
		$this->status = false;
		$this->status_list = array();
   }
   
   function  __destruct()
   {
		unset($this->age_protect_list);
		unset($this->call_class_list);
		unset($this->circ_mod_list);
		unset($this->copy_location_list);
		unset($this->encumbered_list);
		unset($this->fine_level_list);
		unset($this->floating_list);
		unset($this->fund_list);
		unset($this->last_checkout_lib_list);
		unset($this->loan_duration_list);
		unset($this->only_holder_list);
		unset($this->prefix_list);
		unset($this->stat_cat_list);
		unset($this->status_list);
   }
   
   function SetGroupCountData($output)
   {
      //set the values of which ones are actually used
     if ($output->GetAgeProtect()) $this->age_protect = true;
     if ($output->GetCallClass()) $this->call_class = true;
     if ($output->GetCircModifier()) $this->circ_mod = true;
     if ($output->GetCopyLocation()) $this->copy_location = true;
     if ($output->GetEncumbered()) $this->encumbered = true;
     if ($output->GetFineLevel()) $this->fine_level = true;
     if ($output->GetFloating()) $this->floating = true;
     if ($output->GetFund()) $this->fund = true;
     if ($output->GetLastCheckoutLib())$this->last_checkout_lib = true;
     if ($output->GetLoanDuration()) $this->loan_duration = true;
     if ($output->GetOnlyHolder()) $this->only_holder = true;
     if ($output->GetPrefix()) $this->prefix = true;
     if ($output->GetStatCats()) $this->stat_cat = true;
     if ($output->GetStatus()) $this->status = true;
   }
   
   function AddItemInfo($copy_rec)
   {
     if ($this->age_protect)
     {
         $key = $copy_rec->GetAgeProtect();
         if (strlen($key) < 1)$key = "--";
         $this->age_protect_list[$key]++;
     }
     
     if ($this->call_class)
     {
        $key = $copy_rec->GetCallClass();
        if (strlen($key) < 1)$key = "--";
        
        if(array_key_exists($key, $this->call_class_list))
        {
           $this->call_class_list[$key]++;
        }
        else
        {
           $this->call_class_list[$key] = 1;
           ksort($this->call_class_list);
        }
     }
     
     if ($this->circ_mod)
     {
        $key = $copy_rec->GetCircMod();
        if (strlen($key) < 1)$key = "--";
        
        if(array_key_exists($key, $this->circ_mod_list))
        {
           $this->circ_mod_list[$key]++;
        }
        else
        {
           $this->circ_mod_list[$key] = 1;
           ksort($this->circ_mod_list);
        }
     }
     
     
     if ($this->copy_location)
     {
        $key = $copy_rec->GetCopyLocation();
        if (strlen($key) < 1)$key = "--";
        
        if(array_key_exists($key, $this->copy_location_list))
        {
           $this->copy_location_list[$key]++;
        }
        else
        {
           $this->copy_location_list[$key] = 1;
           ksort($this->copy_location_list);
        }
     }
     
     if ($this->encumbered)
     {
         $key = $copy_rec->GetEncumbered();
         $this->encumbered_list[$key]++;
     }
     
     if ($this->fine_level)
     {
         $key = $copy_rec->GetFineLevel();
         $this->fine_level_list[$key]++;
     }
     
     if ($this->floating)
     {
         $key = $copy_rec->GetFloating();
         if (strlen($key) < 1)$key = "FALSE";
         $this->floating_list[$key]++;
     }
     
     if ($this->fund)
     {
        $key = $copy_rec->GetFund();
        if (strlen($key) < 1)$key = "--";
        
        if(array_key_exists($key, $this->fund_list))
        {
           $this->fund_list[$key]++;
        }
        else
        {
           $this->fund_list[$key] = 1;
           ksort($this->fund_list);
        }
     }
     
     if ($this->last_checkout_lib)
     {
        $key = $copy_rec->GetLastCheckoutLib();
        if (strlen($key) < 1)$key = "--";
        
        if(array_key_exists($key, $this->last_checkout_lib_list))
        {
           $this->last_checkout_lib_list[$key]++;
        }
        else
        {
           $this->last_checkout_lib_list[$key] = 1;
           ksort($this->last_checkout_lib_list);
        }
     }
     
     if ($this->loan_duration)
     {
         $key = $copy_rec->GetLoanDuration();
         $this->loan_duration_list[$key]++;
     }
     
     if ($this->only_holder)
     {
        $key = $copy_rec->GetOnlyHolder();
        if (strlen($key) < 1)$key = "FALSE";
        $this->only_holder_list[$key]++;
     }
     
     if ($this->prefix)
     {
        $key = $copy_rec->GetPrefix();
        if (strlen($key) < 1)$key = "--";
        
        if(array_key_exists($key, $this->prefix_list))
        {
           $this->prefix_list[$key]++;
        }
        else
        {
           $this->prefix_list[$key] = 1;
           ksort($this->prefix_list);
        }
     }
     
     if ($this->status)
     {
        $key = $copy_rec->GetStatus();
        if (strlen($key) < 1)$key = "--";
        
        if(array_key_exists($key, $this->status_list))
        {
           $this->status_list[$key]++;
        }
        else
        {
           $this->status_list[$key] = 1;
           ksort($this->status_list);
        }
     }
     
     if ($this->stat_cat)
     {
        $stat_cats = $copy_rec->GetStatCatArray();
        
        foreach($stat_cats as $cat)
        {
			  if(array_key_exists($cat, $this->stat_cat_list))
			  {
				  $this->stat_cat_list[$cat]++;
			  }
			  else
			  {
				  $this->stat_cat_list[$cat] = 1;
				  ksort($this->stat_cat_list);
			  }
        }
     }
   }
   
   function GetAgeProtectList()
   {
      if ($this->age_protect) return $this->age_protect_list;
      else return false;
   }
   
   function GetCallClassList()
   {
      if ($this->call_class) return $this->call_class_list;
      else return false;
   }
   
   function GetCircModifierList()
   {
      if ($this->circ_mod) return $this->circ_mod_list;
      else return false;
   }
   
   function GetCopyLocationList()
   {
      if ($this->copy_location) return $this->copy_location_list;
      else return false;
   }
   
   function GetEncumberedList()
   {
      if ($this->encumbered) return $this->encumbered_list;
      else return false;
   }
   
   function GetFineLevelList()
   {
      if ($this->fine_level) return $this->fine_level_list;
      else return false;
   }
   
   function GetFloatingList()
   {
      if ($this->floating) return $this->floating_list;
      else return false;
   }
   
   function GetFundList()
   {
      if ($this->fund) return $this->fund_list;
      else return false;
   }
   
   function GetLastCheckoutLibList()
   {
      if ($this->last_checkout_lib) return $this->last_checkout_lib_list;
      else return false;
   }
   
   function GetLoanDurationList()
   {
      if ($this->loan_duration) return $this->loan_duration_list;
      else return false;
   }
   
   function GetOnlyHolderList()
   {
      if ($this->only_holder) return $this->only_holder_list;
      else return false;
   }
   
   function GetPrefixList()
   {
      if ($this->prefix) return $this->prefix_list;
      else return false;
   }
   
   function GetStatCatList()
   {
      if ($this->stat_cat) return $this->stat_cat_list;
      else return false;
   }
   
   function GetStatusList()
   {
      if ($this->status) return $this->status_list;
      else return false;
   }
}

?>