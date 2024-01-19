<?php

class CopyRec
{
   public $db;

   public $acq_cost;
   public $active_date;
   public $age_protection_expire;
   public $age_protection_val;
   public $alert_message;
   public $barcode;
   public $copy_id;
   public $call_num;
   public $call_num_id;
   public $call_num_class;
   public $call_num_prefix;
   public $call_num_suffix;
   public $call_sort_key;
   public $circ_modifier;
   public $circs_between;
      public $circs_between_my;
      public $circs_between_other;
      public $circs_between_my_sys;
      public $circs_between_other_sys;
   public $circ_lib;
   public $circ_lib_name;
   public $circ_lib_shortname;
   public $course;
   public $course_circs;
   public $copy_location;
   public $copy_tag;
   public $create_date;
   public $deleted_item;
   public $deleted_date;
   public $deposit;
   public $due_date;
   public $encumbered;
   public $fine_level;
   public $floating;
   public $fund;
   public $fund_debit;
   public $fund_id;
   public $holds_other_lib;
   public $holds_my_lib;
   public $in_house_use;
   public $inventory_date;
   public $invoice_num;
   public $invoice_date;
   public $invoice_closed_date;
   public $item_status_link;
   public $last_in_house_use;
   public $last_checkin;
   public $last_checkout;
   public $last_checkout_lib;
   public $last_fy_circ;
      public $last_fy_circ_my;
      public $last_fy_circ_other;
      public $last_fy_circ_my_sys;
      public $last_fy_circ_other_sys;
   public $lifetime_circs;
     public $lifetime_circs_my;
     public $lifetime_circs_other;
     public $lifetime_circs_my_sys;
     public $lifetime_circs_other_sys;
   public $line_item_id;
   public $line_item_status;
   public $loan_duration;
   public $only_holder;
   public $order_date;
   public $other_library_copy_count;
   public $owning_lib;
   public $owning_lib_shortname;
   public $part;
   public $part_id;
   public $po_num;
   public $price;
   public $public_note;
   public $reference;
   public $staff_note;
   public $stat_cat_words;
   public $stat_cat_ids;
   public $status;
   public $status_changed_date;
   public $system_id;
   public $system_shortname;
   public $ytd_circ;
      public $ytd_circ_my;
      public $ytd_circ_other;
      public $ytd_circ_my_sys;
      public $ytd_circ_other_sys;

   function __construct()
   {
       $this->alert_message = array();
       $this->copy_tag = array();
       $this->course = array();
       $this->public_note = array();
       $this->staff_note = array();
       $this->stat_cat_words = array();
       $this->stat_cat_ids = array();

       $this->deleted_item = false;
       $this->deposit = false;
       $this->floating = false;
       $this->reference = false;

       $this->encumbered = "FALSE";

       $this->last_checkout_lib = '--';

       $this->holds = 0;

       $this->circs_between = -1; //give default

       $this->price = -1;
       $this->acq_cost = -1;
   }

   function __destruct()
   {
      unset($this->alert_message);
      unset($this->copy_tag);
      unset($this->course);
      unset($this->public_note);
      unset($this->staff_note);
      unset($this->stat_cat_words);
      unset($this->stat_cat_ids);
   }

   function SetDB($val)
   {
      $this->db = $val;
   }

   function SetAcqCost($val)
   {
      $this->acq_cost = $val;
   }

   function GetAcqCost()
   {
      return $this->acq_cost;
   }

   function SetActiveDate($active, $create)
   {
      if ($active) $active = date('m/d/Y', strtotime($active));
      else $active ="--";

      $create = date('m/d/Y', strtotime($create));
      $this->create_date = $create;

      if (strtotime($create) <= strtotime('06-01-2012') )
      {
         if (strtotime($create) < strtotime('01-01-2000') )
         {
            $this->active_date = "Before 2000";
            $this->create_date = "Before 2000";
         }
         else
         {
            if ($active) $this->active_date = $create;
         }
      }
      else
      {
         $this->active_date = $active;
      }

      $this->CalculateAgeProtectExpire();
   }

   function GetActiveDate()
   {
      return $this->active_date;
   }

   function GetCreateDate()
   {
      return $this->create_date;
   }

   function SetAgeProtect($val)
   {
      switch($val)
      {
         case 1:
            $this->age_protection_val= "1 month";
            break;
         case 2:
            $this->age_protection_val= "3 months";
            break;
         case 101:
            $this->age_protection_val= "14 days";
            break;
      }
      $this->CalculateAgeProtectExpire();
   }

   function GetAgeProtect()
   {
      return $this->age_protection_val;
   }

   function CalculateAgeProtectExpire()
   {
      if (isset($this->active_date) && $this->active_date !="--" &&  isset($this->age_protection_val))
      {
         $this->age_protection_expire = date('m/d/Y', strtotime($this->active_date."+".$this->age_protection_val));
      }
   }

   function GetAgeProtectExpire()
   {
      return $this->age_protection_expire;
   }

   function SetAlertMessage()
   {
      $sql = "SELECT config.copy_alert_type.name, asset.copy_alert.note
              FROM asset.copy_alert
              JOIN config.copy_alert_type ON asset.copy_alert.alert_type = config.copy_alert_type.id
              WHERE copy = $this->copy_id
              AND ack_time IS NULL";

      $result = pg_query($this->db, $sql);

      while ($alert_row = pg_fetch_row($result))
      {
          $this->alert_message[]  = $alert_row[0]."-".$alert_row[1];
      }
   }

   function GetAlertMessage($seperator)
   {
      return implode($seperator, $this->alert_message);
   }

   function SetAcquisitionsInfo()
   {
       $acq_sql = "SELECT acq.fund_debit.encumbrance, acq.fund.name, acq.fund.year, acq.lineitem_detail.lineitem, acq.lineitem.state,acq.purchase_order.order_date, acq.lineitem.purchase_order, acq.fund.id, acq.fund_debit.amount
                   FROM acq.lineitem_detail
                   INNER JOIN acq.lineitem ON acq.lineitem_detail.lineitem = acq.lineitem.id
                   LEFT OUTER JOIN acq.fund_debit ON acq.lineitem_detail.fund_debit = acq.fund_debit.id
                   LEFT OUTER JOIN acq.fund ON acq.lineitem_detail.fund = acq.fund.id
                   LEFT OUTER JOIN acq.purchase_order ON acq.lineitem.purchase_order = acq.purchase_order.id
                   WHERE acq.lineitem_detail.eg_copy_id =$this->copy_id";

      $acq_result = pg_query($this->db, $acq_sql);
      $acq_row = pg_fetch_row($acq_result);

      if (!$acq_row)return;

      if ($acq_row[0] == "t")$this->SetEncumbered("TRUE");
      else $this->SetEncumbered("FALSE");

      if ($acq_row[1] && $acq_row[2])
      {
         $this->SetFund($acq_row[1]."(".$acq_row[2].")");
         $this->SetFundId($acq_row[7]);
         $this->SetFundDebit($acq_row[8]);
      }

      $this->SetLineitemId($acq_row[3]);

      $lineitem_status = $acq_row[4];

      if ($lineitem_status == "cancelled")
      {
         $reason_sql = "SELECT acq.cancel_reason.label
                        FROM acq.cancel_reason
                        JOIN acq.lineitem_detail on acq.lineitem_detail.cancel_reason = acq.cancel_reason.id
                        WHERE acq.lineitem_detail.id = $acq_row[3] ";
         $reason_result = pg_query($this->db, $reason_sql);

         $reason_row = pg_fetch_row($reason_result);

         if($reason_row[0])
         {
           $lineitem_status .=" -".$reason_row[0];
         }
         else
         {
            $reason_sql = "SELECT acq.cancel_reason.label
                        FROM acq.cancel_reason
                        JOIN acq.lineitem on acq.lineitem.cancel_reason = acq.cancel_reason.id
                        WHERE acq.lineitem.id = $acq_row[3] ";
            $reason_result = pg_query($this->db, $reason_sql);

            $reason_row = pg_fetch_row($reason_result);

            if($reason_row[0]) $lineitem_status .=" -".$reason_row[0];
         }
      }
      $this->SetLineitemStatus($lineitem_status);

      $this->SetOrderDate($acq_row[5]);
      if ($acq_row[6]) $this->SetPONum($acq_row[6]);

       $acq_sql = "SELECT acq.invoice.inv_ident, acq.invoice.recv_date, acq.invoice.close_date
                   FROM acq.lineitem_detail
                   INNER JOIN acq.invoice_entry ON acq.invoice_entry.lineitem = acq.lineitem_detail.lineitem
                   INNER JOIN acq.invoice ON acq.invoice.id = acq.invoice_entry.invoice
                   WHERE acq.lineitem_detail.eg_copy_id = $this->copy_id ";

      $acq_result = pg_query($this->db, $acq_sql);
      $acq_row = pg_fetch_row($acq_result);

      if ($acq_row)
      {
         $this->SetInvoiceNum($acq_row[0]);
         $this->SetInvoiceDate($acq_row[1]);
         $this->SetInvoiceClosedDate($acq_row[2]);
      }
   }

   function SetBarcode($val)
   {
      $this->barcode = $val;
   }

   function GetBarcode()
   {
      return $this->barcode;
   }

   function SetCopyId($val)
   {
      $this->copy_id = $val;
      $this->item_status_link = "https://evergreen.noblenet.org/eg/staff/cat/item/".$this->copy_id;
   }

   function GetCopyId()
   {
      return $this->copy_id;
   }

   function SetCopyTag()
   {
      $tag_sql = "SELECT config.copy_tag_type.label, asset.copy_tag.value
                  FROM asset.copy_tag
                  JOIN config.copy_tag_type ON config.copy_tag_type.code = asset.copy_tag.tag_type
                  JOIN asset.copy_tag_copy_map ON asset.copy_tag_copy_map.tag = asset.copy_tag.id
                  WHERE asset.copy_tag_copy_map.copy = $this->copy_id";

      $tag_result = pg_query($this->db, $tag_sql);

      while( $tag_row = pg_fetch_row($tag_result))
      {
          $this->copy_tag[]= $tag_row[0]."/".$tag_row[1];
      }
   }

   function GetCopyTag($seperator)
   {
      return implode($seperator, $this->copy_tag);
   }

   function GetItemStatusLink()
   {
      return $this->item_status_link;
   }

   function SetCallNumber($val)
   {
      $this->call_num = $val;
   }

   function GetCallNumber()
   {
      return $this->call_num;
   }

   function SetCallNumberId($val)
   {
      $this->call_num_id = $val;
   }

   function GetCallNumberId()
   {
      return $this->call_num_id;
   }

   function SetCallClass($val)
   {
      $class = '';
      switch($val)
      {
         case 1:
           $class = "Generic";
           break;
         case 2:
           $class = "Dewey";
           break;
         case 3:
           $class = "LC";
           break;
         case 4:
           $class = "BISAC";
           break;
      }

      $this->call_num_class = $class;
   }

   function GetCallClass()
   {
      return $this->call_num_class;
   }

   function SetPrefix($val)
   {
      $sql = "SELECT label
              FROM asset.call_number_prefix
              WHERE id = $val";

      $result = pg_query($this->db, $sql);
      $row = pg_fetch_row($result);
      $this->call_num_prefix = $row[0];
   }

   function GetPrefix()
   {
      return $this->call_num_prefix;
   }

   function SetSuffix($val)
   {
      $sql = "SELECT label
              FROM asset.call_number_suffix
              WHERE id = $val";

      $result = pg_query($this->db, $sql);
      $row = pg_fetch_row($result);
      $this->call_num_suffix = $row[0];
   }

   function GetSuffix()
   {
      return $this->call_num_suffix;
   }

   function SetCallSortKey($val)
   {
      $this->call_sort_key = $val;
   }

   function GetCallSortKey()
   {
      return $this->call_sort_key;
   }

   function SetLastCheckout()
   {
       $this->last_checkout = date('m/d/Y', strtotime('01-01-1950'));
       //checkin/due date
       $checkout_sql = "SELECT MAX(xact_start), shortname
                       FROM action.all_circulation
                       JOIN actor.org_unit ON actor.org_unit.id = action.all_circulation.circ_lib
                       WHERE target_copy= '$this->copy_id'
                       GROUP BY 2
                       ORDER BY 1 DESC";

       $checkout_result = pg_query($this->db, $checkout_sql);
       $checkout_row = pg_fetch_row($checkout_result);

       if ($checkout_row)
       {
          $checkout =$checkout_row[0];
          $this->last_checkout = date('m/d/Y', strtotime($checkout) ) ;
          $this->last_checkout_lib = $checkout_row[1];
       }

       if (strtotime($this->last_checkout) < strtotime('01-01-1990') )
       {
          $checkout_sql = "SELECT loutdate
                          FROM extend_reporter.legacy_iii_data
                          WHERE copy = $this->copy_id";
          $checkout_result = pg_query($this->db, $checkout_sql);
          $checkout_row = pg_fetch_row($checkout_result);

          if ($checkout_row)
          {
             $checkout =$checkout_row[0];
             $this->last_checkout = date('m/d/Y', strtotime($checkout) ) ;
          }
       }

       if (strtotime($this->last_checkout) < strtotime('01-01-1990') )
       {
          if (isset($this->lifetime_circs) && $this->lifetime_circs == 0)
          {
             $this->last_checkout = "--";
          }
          else if (strtotime($this->active_date) > strtotime('12-31-2000') )
          {
              $this->last_checkout = "--";
          }
          else if (isset($this->last_checkin) && strtotime($this->last_checkin) > strtotime('12-31-2000') )
          {
            $this->last_checkout = "--";
          }
          else
          {
             $this->last_checkout = "Before 2000";
          }
      }
   }

   function GetLastCheckout()
   {
      return $this->last_checkout;
   }

   function GetLastCheckoutLib()
   {
      return $this->last_checkout_lib;
   }

   function SetCircMod($val)
   {
      $this->circ_modifier = $val;
   }

   function GetCircMod()
   {
      return $this->circ_modifier;
   }

   function SetCircsBetween($start, $end)
   {
      $start_date = date('Y-m-d', strtotime($start));
      $end_date = date('Y-m-d', strtotime($end));


		 //Circs count
		$config_circs_my_sql = "SELECT COUNT(*)
										FROM action.all_circulation
										WHERE target_copy= '$this->copy_id '
										AND DATE(xact_start) BETWEEN '$start_date' AND '$end_date'
										AND circ_lib = $this->circ_lib";

		$config_circs_my_result = pg_query($this->db, $config_circs_my_sql);
		$config_circs_my_row = pg_fetch_row($config_circs_my_result);
		$this->circs_between_my = $config_circs_my_row[0];

		 //Circs count
		$config_circs_other_sql = "SELECT COUNT(*)
						   				FROM action.all_circulation
											WHERE target_copy= '$this->copy_id '
											AND DATE(xact_start) BETWEEN '$start_date' AND '$end_date'
											AND circ_lib != $this->circ_lib";

		$config_circs_other_result = pg_query($this->db, $config_circs_other_sql);
		$config_circs_other_row = pg_fetch_row($config_circs_other_result);
		$this->circs_between_other = $config_circs_other_row[0];

		$this->circs_between = $this->circs_between_my + $this->circs_between_other;


         /*Circs count
         $config_circs_sql = "SELECT COUNT(*)
                              FROM action.all_circulation
                              WHERE target_copy= '$this->copy_id '
                              AND DATE(xact_start) BETWEEN '$start_date' AND '$end_date'";

         $config_circs_result = pg_query($this->db, $config_circs_sql);
         $config_circs_row = pg_fetch_row($config_circs_result);
         $this->circs_between = $config_circs_row[0];*/
   }

   function GetCircsBetween()
   {
      return $this->circs_between;
   }

   function GetCircsBetweenMy()
   {
      return $this->circs_between_my;
   }

   function GetCircsBetweenOther()
   {
      return $this->circs_between_other;
   }

   function GetCircsBetweenMySys()
   {
      return $this->circs_between_my_sys;
   }

   function GetCircsBetweenOtherSys()
   {
      return $this->circs_between_other_sys;
   }

   function SetCircLib($id)
   {
      $this->circ_lib = $id;

      $sql = "SELECT shortname, name, parent_ou
             FROM actor.org_unit
             WHERE id = $id";

      $result = pg_query($this->db, $sql);
      $row = pg_fetch_row($result);
      $this->circ_lib_shortname = $row[0];
      $this->circ_lib_name = $row[1];

      $this->system_id = $row[2];


      $sql = "SELECT shortname
              FROM actor.org_unit
              WHERE id = $this->system_id";

      $result = pg_query($this->db, $sql);
      $row = pg_fetch_row($result);
      $this->system_shortname = $row[0];

   }

   function GetCircLibId()
   {
      return $this->circ_lib;
   }

   function GetCircLibShortname()
   {
      return $this->circ_lib_shortname;
   }

   function GetCircLibName()
   {
      return $this->circ_lib_name;
   }

   function GetSystemId()
   {
      return  $this->system_id;
   }

   function GetSystemShortname()
   {
      return  $this->system_shortname;
   }

   function SetCopyLocation($val)
   {
      $this->copy_location = $val;
   }

   function GetCopyLocation()
   {
      return $this->copy_location;
   }

   function SetCourseByTerm($term_filter, $course_array)
   {
       //only set courses that appear in this arrray
       $sql = "SELECT DISTINCT asset.course_module_course.id, asset.course_module_course.name, asset.course_module_course.course_number, asset.course_module_course.section_number
              FROM asset.course_module_course_materials
              JOIN asset.course_module_course ON asset.course_module_course_materials.course = asset.course_module_course.id
              WHERE asset.course_module_course_materials.item = $this->copy_id";

      $result = pg_query($this->db, $sql);

      while ($course_row = pg_fetch_row($result))
      {
          $course_id = $course_row[0];
          $course_name = $course_row[1];
          $course_number = $course_row[2];
          $section_number = $course_row[3];

          //now get the instrustor if there is onExecute()
          $use_instructor = false;
          $instructor_name = "";

          $instructor_sql = "SELECT actor.usr.family_name
                             FROM asset.course_module_course_users
                              JOIN actor.usr ON actor.usr.id  = asset.course_module_course_users.usr
                              WHERE asset.course_module_course_users.course = $course_id
                              AND asset.course_module_course_users.usr_role = 1";
         $instructor_result = pg_query($this->db, $instructor_sql);

         while ($instructor_row = pg_fetch_row($instructor_result))
         {
             $use_instructor = true;
             $instructor_name = $instructor_row[0];
         }

         if (strlen($section_number) > 0) $course_display_name = $course_number."-".$section_number.":".$course_name;
         else  $course_display_name = $course_number.":".$course_name;

         if ($use_instructor) $course_display_name .= "-".$instructor_name;

          //now get all the terms this courtse is in
          $term_sql = "SELECT DISTINCT asset.course_module_term.name, asset.course_module_term.id
                       FROM asset.course_module_term
                       JOIN asset.course_module_term_course_map ON asset.course_module_term_course_map.term = course_module_term.id
                       WHERE asset.course_module_term_course_map.course = $course_id";

          $term_result = pg_query($this->db, $term_sql);

          while ($term_row = pg_fetch_row($term_result))
          {
             $term_name = $term_row[0];
             $term = $term_row[1];

             //only add if in the input array
             if ($term == $term_filter && in_array($course_id, $course_array) )
             {
                 $this->course[]  = $course_display_name;
             }
          }
      }

   }

   function SetCourse()
   {

      $sql = "SELECT DISTINCT asset.course_module_course.id, asset.course_module_course.name, asset.course_module_course.course_number, asset.course_module_course.section_number
              FROM asset.course_module_course_materials
              JOIN asset.course_module_course ON asset.course_module_course_materials.course = asset.course_module_course.id
              WHERE asset.course_module_course_materials.item = $this->copy_id";

      $result = pg_query($this->db, $sql);

      while ($course_row = pg_fetch_row($result))
      {
          $course_id = $course_row[0];
          $course_name = $course_row[1];
          $course_number = $course_row[2];
          $section_number = $course_row[3];

         if (strlen($section_number) > 0) $course_display_name = $course_number."-".$section_number.":".$course_name;
         else  $course_display_name = $course_number.":".$course_name;

          //now get all the terms this courtse is in
          $term_sql = "SELECT DISTINCT asset.course_module_term.name
                       FROM asset.course_module_term
                       JOIN asset.course_module_term_course_map ON asset.course_module_term_course_map.term = course_module_term.id
                       WHERE asset.course_module_term_course_map.course = $course_id";

          $term_result = pg_query($this->db, $term_sql);

          while ($term_row = pg_fetch_row($term_result))
          {
             $term = $term_row[0];
             $this->course[]  = $term."/".$course_display_name;
          }
      }
   }

   function GetCourse($seperator)
   {
      return implode($seperator, $this->course);
   }

   function SetCourseCirc($start_date, $end_date)
   {
      $course_circ_sql = "SELECT COUNT(*)
                           FROM action.all_circulation
                           WHERE target_copy= '$this->copy_id '
                           AND DATE(xact_start) BETWEEN '$start_date' AND '$end_date'";

      $course_circ_result = pg_query($this->db, $course_circ_sql);
      if ($course_circ_row)
      {
         $course_circ_row = pg_fetch_row($course_circ_result);
         $this->course_circs = $course_circ_row[0];
      }
   }

   function GetCourseCirc()
   {
      return $this->course_circs;
   }

   function SetDeleted($deleted, $date)
   {
      if ($deleted == "f")
      {
         $this->deleted_item = false;
         return;
      }
      $this->deleted_item = true;
      if ($this->deleted_item)$this->deleted_date = date('m/d/Y', strtotime($date));
   }

   function GetIsDeleted()
   {
       if ($this->deleted_item)return true;
       else return false;
   }

   function GetDeletedDate()
   {
      return $this->deleted_date;
   }

   function SetDeposit($val)
   {
      if ($val == "t")
      {
         $this->deposit = true;
      }
      else
      {
         $this->deposit = "";
      }
   }

   function GetDeposit()
   {
      return $this->deposit;
   }

   function SetDueDate()
   {
       if (  $this->status == "Checked out" || $this->status == "Lost"
          || $this->status == "Long Overdue" || $this->status == "Claimed returned")
       {
          $due_sql = "SELECT  MAX(due_date)
                      FROM action.all_circulation
                      WHERE target_copy= '$this->copy_id'
                      AND action.all_circulation.xact_finish IS NULL";

          $due_result = pg_query($this->db, $due_sql);
          $due_row = pg_fetch_row($due_result);

          $this->due_date =date('m/d/Y', strtotime($due_row[0]));
       }
       else
       {
          $this->due_date = "";
       }

   }

   function GetDueDate()
   {
      return $this->due_date;
   }

   function SetEncumbered($val)
   {
       $this->encumbered = $val;
   }

   function GetEncumbered()
   {
      return $this->encumbered;
   }

   function SetFineLevel($val)
   {
      switch($val)
      {
         case 1:
            $this->fine_level = "low";
            break;
         case 2:
            $this->fine_level = "normal";
            break;
         case 3:
            $this->fine_level = "high";
            break;
      }
   }

   function GetFineLevel()
   {
      return $this->fine_level;
   }

   function SetFloating($val)
   {
      if ($val == "t")
      {
         $this->floating = true;
      }
      else
      {
         $this->floating = "";
      }
   }

   function GetFloating()
   {
      return $this->floating;
   }

   function SetFund($val)
   {
      $this->fund = $val;
   }

   function GetFund()
   {
      return $this->fund;
   }

   function SetFundDebit($val)
   {
      $this->fund_debit = $val;
   }

   function GetFundDebit()
   {
      return $this->fund_debit;
   }

   function SetFundId($val)
   {
      $this->fund_id = $val;
   }

   function GetFundId()
   {
      return $this->fund_id;
   }

   function SetHolds()
   {
      $this->holds_my_lib = 0;

      //check copy holds
      $copy_sql = "SELECT count(*)
                    FROM action.hold_request
                    WHERE target= $this->copy_id
                    AND (hold_type = 'C' OR hold_type = 'F')
                    AND fulfillment_time IS NULL
                    AND cancel_time IS NULL
                    AND (expire_time > now() OR expire_time IS NULL)
                    AND pickup_lib = $this->circ_lib";

      $copy_result = pg_query($this->db, $copy_sql);
      $copy_row = pg_fetch_row($copy_result);

      $this->holds_my_lib += $copy_row[0];

      //check volume holds
      $vol_sql = "SELECT count(*)
                    FROM action.hold_request
                    WHERE target= $this->call_num_id
                    AND hold_type = 'V'
                    AND fulfillment_time IS NULL
                    AND cancel_time IS NULL
                    AND (expire_time > now() OR expire_time IS NULL)
                    AND pickup_lib = $this->circ_lib";

      $vol_result = pg_query($this->db, $vol_sql);
      $vol_row = pg_fetch_row($vol_result);

      $this->holds_my_lib += $vol_row[0];

      if (isset($this->part_id))
      {
         $part_sql = "SELECT count(*)
                       FROM action.hold_request
                       WHERE target= $this->part_id
                       AND hold_type = 'P'
                       AND fulfillment_time IS NULL
                       AND cancel_time IS NULL
                       AND (expire_time > now() OR expire_time IS NULL)
                       AND pickup_lib = $this->circ_lib";

         $part_result = pg_query($this->db, $part_sql);
         $part_row = pg_fetch_row($part_result);

         $this->holds_my_lib += $part_row[0];
      }

      $this->holds_other_lib = 0;

      //check copy holds
      $copy_sql = "SELECT count(*)
                    FROM action.hold_request
                    WHERE target= $this->copy_id
                    AND (hold_type = 'C' OR hold_type = 'F')
                    AND fulfillment_time IS NULL
                    AND cancel_time IS NULL
                    AND (expire_time > now() OR expire_time IS NULL)
                    AND pickup_lib != $this->circ_lib";

      $copy_result = pg_query($this->db, $copy_sql);
      $copy_row = pg_fetch_row($copy_result);

      $this->holds_other_lib += $copy_row[0];

      //check volume holds
      $vol_sql = "SELECT count(*)
                    FROM action.hold_request
                    WHERE target= $this->call_num_id
                    AND hold_type = 'V'
                    AND fulfillment_time IS NULL
                    AND cancel_time IS NULL
                    AND (expire_time > now() OR expire_time IS NULL)
                    AND pickup_lib != $this->circ_lib";

      $vol_result = pg_query($this->db, $vol_sql);
      $vol_row = pg_fetch_row($vol_result);

      $this->holds_other_lib += $vol_row[0];

      if (isset($this->part_id))
      {
         $part_sql = "SELECT count(*)
                       FROM action.hold_request
                       WHERE target= $this->part_id
                       AND hold_type = 'P'
                       AND fulfillment_time IS NULL
                       AND cancel_time IS NULL
                       AND (expire_time > now() OR expire_time IS NULL)
                       AND pickup_lib != $this->circ_lib";

         $part_result = pg_query($this->db, $part_sql);
         $part_row = pg_fetch_row($part_result);

         $this->holds_other_lib += $part_row[0];
      }


   }

   function GetMyHolds()
   {
      return $this->holds_my_lib;
   }

   function GetOtherHolds()
   {
      return $this->holds_other_lib;
   }

   function SetInHouseUse()
   {
      $in_house_sql = "SELECT  COUNT(*), MAX(use_time)
                       FROM action.in_house_use
                       WHERE item= '$this->copy_id' ";

      $in_house_result = pg_query($this->db, $in_house_sql);
      $in_house_row = pg_fetch_row($in_house_result);
      $this->in_house_use = $in_house_row[0];

       if ($in_house_row[1])
       {
          $this->last_in_house_use = date('m/d/Y', strtotime($in_house_row[1]) );
       }
       else
       {
           $this->last_in_house_use = "NOT USED";
       }
   }

   function GetInHouseUse()
   {
      return $this->in_house_use;
   }

   function GetLastInHouseUse()
   {
      return $this->last_in_house_use;
   }

   function SetInventoryDate()
   {
      $inventory_sql = "SELECT MAX(inventory_date)
                        FROM asset.latest_inventory
                        JOIN actor.workstation ON actor.workstation.id = asset.latest_inventory.inventory_workstation
                        WHERE asset.latest_inventory.copy = '$this->copy_id'
                        AND actor.workstation.owning_lib = $this->circ_lib ";

      $inventory_result = pg_query($this->db, $inventory_sql);
      $inventory_row = pg_fetch_row($inventory_result);

       if ($inventory_row[0])
       {
          $this->inventory_date = date('m/d/Y', strtotime($inventory_row[0]) );
       }
       else
       {
           $this->inventory_date = "--";
       }
   }

   function GetInventoryDate()
   {
      return $this->inventory_date;
   }

   function SetInvoiceDate($val)
   {
      if ($val)$this->invoice_date =date('m/d/Y', strtotime($val) );
      else $this->invoice_date ="--";
   }

   function GetInvoiceDate()
   {
      return $this->invoice_date;
   }

   function SetInvoiceClosedDate($val)
   {
       if ($val) $this->invoice_closed_date =date('m/d/Y', strtotime($val) );
       else $this->invoice_closed_date ="--";
   }

   function GetInvoiceClosedDate()
   {
      return $this->invoice_closed_date;
   }

   function SetInvoiceNum($val)
   {
      if ($val) $this->invoice_num = $val;
      else $this->invoice_num = "No Invoice";
   }

   function GetInvoiceNum()
   {
      return $this->invoice_num;
   }

   function SetLastCheckin()
   {
       //checkin/due date
       $checkin_sql = "SELECT MAX(checkin_time)
                       FROM action.all_circulation
                       WHERE target_copy= '$this->copy_id' ";

       $checkin_result = pg_query($this->db, $checkin_sql);
       $checkin_row = pg_fetch_row($checkin_result);

       $checkin =$checkin_row[0];
       $this->last_checkin = date('m/d/Y', strtotime($checkin) ) ;

       if (strtotime($this->last_checkin) < strtotime('01-01-1990') )
       {
          $checkin_sql = "SELECT lchkin
                          FROM extend_reporter.legacy_iii_data
                          WHERE copy = $this->copy_id";
          $checkin_result = pg_query($this->db, $checkin_sql);
          $checkin_row = pg_fetch_row($checkin_result);
          if ($checkin_row)
          {
             $checkin =$checkin_row[0];
             $this->last_checkin = date('m/d/Y', strtotime($checkin) ) ;
          }
          else
          {
             $checkin = NULL;
          }
       }

      $this->UpdateLastCheckin();
   }

   function UpdateLastCheckin()
   {
      //should do math here to get the right value
      if (isset($this->last_checkin) && strtotime($this->last_checkin) < strtotime('01-01-1990') )
      {
          if (isset($this->lifetime_circs) && $this->lifetime_circs == 0)
          {
             $this->last_checkin = "--";
          }
          else if (isset($this->status) &&
                   ($this->status == "Checked out" || $this->status  == "Lost" ||  $this->status  == "Long Overdue" ||
                    $this->status  == "In transit" || $this->status  == "Lost and Paid" || $this->status  == "Claimed returned" ) )
          {
             //if checked out, claimed returns, long overdue, lost or lost and paid
             $this->last_checkin = "N/A";
          }
          else
          {
             $this->last_checkin = "Before 2000";
          }
      }
   }

   function GetLastCheckin()
   {
      return $this->last_checkin;
   }

   function SetLastFYCirc()
   {
      $today = date("Y-m-d");
      $fy = CalculateFiscalYear();

      $fy_start = GetFiscalStart($fy);
      $fy_end = GetFiscalEnd($fy);

      $ly_start = date("Y-m-d", strtotime("$fy_start -1 year"));
      $ly_end = date("Y-m-d", strtotime("$fy_end -1 year"));

	  //Last Year Circs
		$ly_my_sql = "SELECT COUNT(*)
						  FROM action.all_circulation
						  WHERE target_copy= '$this->copy_id '
						  AND DATE(xact_start) BETWEEN '$ly_start' AND '$ly_end'
						  AND circ_lib = $this->circ_lib";

		$ly_my_result = pg_query($this->db, $ly_my_sql);
		$ly_my_row = pg_fetch_row($ly_my_result);
		$this->last_fy_circ_my = $ly_my_row[0];

		//Last Year Circs
		$ly_other_sql = "SELECT COUNT(*)
							  FROM action.all_circulation
							  WHERE target_copy= '$this->copy_id '
							  AND DATE(xact_start) BETWEEN '$ly_start' AND '$ly_end'
							  AND circ_lib != $this->circ_lib";

		$ly_other_result = pg_query($this->db, $ly_other_sql);
		$ly_other_row = pg_fetch_row($ly_other_result);
		$this->last_fy_circ_other = $ly_other_row[0];

		$this->last_fy_circ =  $this->last_fy_circ_my +  $this->last_fy_circ_other;

         /*Last Year Circs
         $ly_sql = "SELECT COUNT(*)
                    FROM action.all_circulation
                    WHERE target_copy= '$this->copy_id '
                    AND DATE(xact_start) BETWEEN '$ly_start' AND '$ly_end'";

         $ly_result = pg_query($this->db, $ly_sql);
         $ly_row = pg_fetch_row($ly_result);
         $this->last_fy_circ = $ly_row[0];*/
   }

   function GetLastFYCirc()
   {
      return $this->last_fy_circ;
   }

   function GetLastFYCircMy()
   {
      return $this->last_fy_circ_my;
   }

   function GetLastFYCircOther()
   {
      return $this->last_fy_circ_other;
   }

   function GetLastFYCircMySys()
   {
      return $this->last_fy_circ_my_sys;
   }

   function GetLastFYCircOtherSys()
   {
      return $this->last_fy_circ_other_sys;
   }

   function SetLifetimeCircs()
   {

		$my_sql = "SELECT COUNT(*)
					  FROM action.all_circulation
					  WHERE target_copy= '$this->copy_id '
					  AND circ_lib = $this->circ_lib";

		$my_result = pg_query($this->db, $my_sql);
		$my_row = pg_fetch_row($my_result);
		$this->lifetime_circs_my = $my_row[0];

		$other_sql = "SELECT COUNT(*)
						  FROM action.all_circulation
						  WHERE target_copy= '$this->copy_id '
						  AND circ_lib != $this->circ_lib";

		$other_result = pg_query($this->db, $other_sql);
		$other_row = pg_fetch_row($other_result);
		$this->lifetime_circs_other = $other_row[0];


      //always do this since it includes pre-evergreen circs
      $total_sql ="SELECT circ_count
                   FROM extend_reporter.full_circ_count
                   WHERE id = $this->copy_id ";

      $total_result = pg_query($this->db, $total_sql);
      $total_row = pg_fetch_row($total_result);
      $this->lifetime_circs = $total_row[0];

      $this->UpdateLastCheckin(); //may change the text
   }

   function GetLifetimeCircs()
   {
      return $this->lifetime_circs;
   }

   function GetLifetimeCircsMy()
   {
      return $this->lifetime_circs_my;
   }

   function GetLifetimeCircsOther()
   {
      return $this->lifetime_circs_other;
   }

   function GetLifetimeCircsMySys()
   {
      return $this->lifetime_circs_my_sys;
   }

   function GetLifetimeCircsOtherSys()
   {
      return $this->lifetime_circs_other_sys;
   }

   function SetLineItemId($val)
   {
      $this->line_item_id = $val;
   }

   function GetLineItemId()
   {
      return $this->line_item_id;
   }

   function SetLineItemStatus($val)
   {
      $this->line_item_status = $val;
   }

   function GetLineItemStatus()
   {
      return $this->line_item_status;
   }

   function SetLoanDuration($val)
   {
      switch($val)
      {
         case 1:
            $this->loan_duration = "short";
            break;
         case 2:
            $this->loan_duration = "normal";
            break;
         case 3:
            $this->loan_duration = "long";
            break;
      }
   }

   function GetLoanDuration()
   {
      return $this->loan_duration;
   }

   function SetPublicNote()
   {
      //get copy notes
      $note_sql = "SELECT value
                   FROM asset.copy_note
                   WHERE owning_copy = $this->copy_id
                   AND pub = true";

      $note_result = pg_query($this->db, $note_sql);

      $note = "";
      while ($note_row = pg_fetch_row($note_result))
      {
          $this->public_note[]  = $note_row[0];
      }

   }

   function GetPublicNote($seperator)
   {
      return implode($seperator, $this->public_note);
   }

   function SetStaffNote()
   {
      //get copy notes
      $note_sql = "SELECT value
                   FROM asset.copy_note
                   WHERE owning_copy = $this->copy_id
                   AND pub = false";

      $note_result = pg_query($this->db, $note_sql);

      $note = "";
      while ($note_row = pg_fetch_row($note_result))
      {
          $this->staff_note[]  = $note_row[0];
      }

   }

   function GetStaffNote($seperator)
   {
      return implode($seperator, $this->staff_note);
   }

   function SetOnlyHolder($bib_id)
   {
       $only_sql = "SELECT count(*)
                    FROM asset.copy
                    INNER JOIN asset.call_number ON asset.call_number.id = asset.copy.call_number
                    WHERE asset.call_number.record = '$bib_id'
                    AND asset.copy.deleted = false
                    AND asset.copy.circ_lib != $this->circ_lib ";

       $only_result = pg_query($this->db, $only_sql);
       $only_row = pg_fetch_row($only_result);

       if ($only_row[0] > 0 )
       {
          $this->only_holder = "";
       }
       else
       {
          $this->only_holder = "TRUE";
       }

       $this->other_library_copy_count = $only_row[0];
   }

   function GetOnlyHolder()
   {
      return $this->only_holder;
   }

   function SetOrderDate($val)
   {

      if (strtotime($val) < strtotime('01-01-1990') )
      {
         $this->order_date = "";
      }
      else
      {
         $this->order_date = date('m/d/Y', strtotime($val) );
      }
   }

   function GetOrderDate()
   {
      return $this->order_date;
   }

   function GetOtherLibraryCount()
   {
      return $this->other_library_copy_count;
   }

   function SetOwningLib($id)
   {
      $this->owning_lib= $id;
      $sql = "SELECT shortname
             FROM actor.org_unit
             WHERE id = $id";

      $result = pg_query($this->db, $sql);
      $row = pg_fetch_row($result);
      $this->owning_lib_shortname = $row[0];
   }

   function GetOwningLibId()
   {
      return $this->owning_lib;
   }

   function GetOwningLibShortname()
   {
      return $this->owning_lib_shortname;
   }

   function SetPart()
   {
      $part_sql = "SELECT biblio.monograph_part.label,  biblio.monograph_part.id
                   FROM asset.copy_part_map
                   JOIN biblio.monograph_part ON asset.copy_part_map.part = biblio.monograph_part.id
                   WHERE asset.copy_part_map.target_copy= '$this->copy_id' ";

      $part_result = pg_query($this->db, $part_sql);
      $part_row = pg_fetch_row($part_result);

      if ($part_row && $part_row[0])
      {
         $this->part = $part_row[0];
         $this->part_id = $part_row[1];
      }
      else
      {
         $this->part = NULL;
         $this->part_id = NULL;
      }

   }

   function GetPart()
   {
      return $this->part;
   }

   function SetPONum($val)
   {
      $this->po_num = $val;
   }

   function GetPONum()
   {
      return $this->po_num;
   }

   function SetPrice($val)
   {
      $this->price = $val;
   }

   function GetPrice()
   {
      return $this->price;
   }

   function SetReference($val)
   {
      if ($val == "t")
      {
         $this->reference = true;
      }
      else
      {
         $this->reference = "";
      }
   }

   function GetReference()
   {
      return $this->reference;
   }

   function SetStatCats()
   {
      $stat_sql = "SELECT asset.stat_cat.name, asset.stat_cat_entry.value, asset.stat_cat.id, asset.stat_cat_entry.id
                   FROM asset.stat_cat_entry_copy_map
                   JOIN asset.stat_cat ON asset.stat_cat_entry_copy_map.stat_cat = asset.stat_cat.id
                   JOIN asset.stat_cat_entry ON asset.stat_cat_entry_copy_map.stat_cat_entry = asset.stat_cat_entry.id
                   WHERE asset.stat_cat_entry_copy_map.owning_copy= $this->copy_id
                   ORDER BY asset.stat_cat.id";

      $stat_result = pg_query($this->db, $stat_sql);

      while( $stat_row = pg_fetch_row($stat_result))
      {
          $this->stat_cat_words[]= $stat_row[0]."/".$stat_row[1];

			 $stat_cat = $stat_row[2];
			 $stat_entry = $stat_row[3];
			 $this->stat_cat_ids[$stat_cat] = $stat_entry;
      }
   }

   function GetStatCats($seperator)
   {
      return implode($seperator, $this->stat_cat_words);
   }

   function GetStatCatIds()
   {
      return $this->stat_cat_ids;
   }

   function GetStatCatArray()
   {
      return $this->stat_cat_words;
   }

   function GetNumStatCats()
   {
      return count($this->stat_cat_words);
   }

   function SetStatus($val)
   {
      $sql = "SELECT name, id
              FROM config.copy_status
              WHERE id = $val";

      $result = pg_query($this->db, $sql);
      $row = pg_fetch_row($result);
      $this->status = $row[0];

      $this->UpdateLastCheckin(); //may change the text

      if ($row[1] == 8) //if on holds shelf say where
      {
         $holds_sql = "SELECT shortname, shelf_time
                       FROM action.hold_request
                       JOIN actor.org_unit ON actor.org_unit.id = action.hold_request.current_shelf_lib
                       WHERE current_copy = $this->copy_id
                       ORDER BY shelf_time DESC";

         $hold_result = pg_query($this->db, $holds_sql);
         $hold_row = pg_fetch_row($hold_result);
         $this->status .= "--".$hold_row[0];
      }
   }

   function GetStatus()
   {
      return $this->status;
   }

   function SetStatusChange($val)
   {
      $this->status_changed_date = date('m/d/Y', strtotime($val));
   }

   function GetStatusChange()
   {
      return $this->status_changed_date;
   }

   function SetYTDCirc()
   {
      $today = date("Y-m-d");
      $fy = CalculateFiscalYear();

      $fy_start = GetFiscalStart($fy);
      $fy_end = GetFiscalEnd($fy);

		$ytd_my_sql = "SELECT COUNT(*)
							FROM action.all_circulation
							WHERE target_copy= '$this->copy_id '
							AND DATE(xact_start) BETWEEN '$fy_start' AND '$today'
							AND circ_lib = $this->circ_lib";

		$ytd_my_result = pg_query($this->db, $ytd_my_sql);
		$ytd_my_row = pg_fetch_row($ytd_my_result);
		$this->ytd_circ_my = $ytd_my_row[0];

		$ytd_other_sql = "SELECT COUNT(*)
								FROM action.all_circulation
								WHERE target_copy= '$this->copy_id '
								AND DATE(xact_start) BETWEEN '$fy_start' AND '$today'
								AND circ_lib != $this->circ_lib";

		$ytd_other_result = pg_query($this->db, $ytd_other_sql);
		$ytd_other_row = pg_fetch_row($ytd_other_result);
		$this->ytd_circ_other = $ytd_other_row[0];

		$this->ytd_circ = $this->ytd_circ_my + $this->ytd_circ_other;

   }

   function GetYTDCirc()
   {
      return $this->ytd_circ;
   }

   function GetYTDCircMy()
   {
      return $this->ytd_circ_my;
   }

   function GetYTDCircOther()
   {
      return $this->ytd_circ_other;
   }

   function GetYTDCircMySys()
   {
      return $this->ytd_circ_my_sys;
   }

   function GetYTDCircOtherSys()
   {
      return $this->ytd_circ_other_sys;
   }
}



?>