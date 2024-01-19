<?php

class BibRec
{
   public $db;

   public $amazon_direct;
   public $amazon_search;
   public $author;
   public $search_author;
   public $bib_id;
   public $catalog_link;
   public $client_link;
   public $cover_image;
   public $summary;
   public $fingerprint;
   public $goodreads_link;
   public $google_book_link;
   public $holds_my_lib;
   public $holds_other_lib;
   public $isbn;
   public $marc;
   public $novelist_link;
   public $oclc_number;
   public $overdrive_reserve_id;
   public $pub_year;
   public $publisher;
   public $title;
   public $tooltip_title;

   public $is_online;
   //public $links[]; //OnlineList Items
   public $sub_u;
   public $sub_y;
   public $sub_9;
   public $online_create_date;


   function __construct()
   {
      $this->summary = array();
      $this->isbn = array();
      $this->amazon_direct = null;
      $this->holds = 0;
      $this->is_online = false;
      $this->marc = array();
   }

   function __destruct()
   {
      unset($this->isbn);
      unset($this->summary);
   }

   function SetDB($val)
   {
      $this->db = $val;
   }

   function SetAmazonDirect($isbn)
   {
      if ($isbn)
      {
         $this->amazon_direct = "http://www.amazon.com/exec/obidos/ASIN/".$isbn;
      }
      else
      {
         $this->amazon_direct =null;
      }
   }

   function GetAmazonDirect()
   {
      return $this->amazon_direct;
   }

   function SetAmazonSearch($title)
   {
      $this->amazon_search = "http://www.amazon.com/s?index=books&field-title=".urlencode($title);
   }

   function GetAmazonSearch()
   {
      return $this->amazon_search;
   }

   function SetAuthor()
   {
       $sub_a ="";
       $sub_b ="";
       $sub_c ="";
       $sub_d ="";
       $sub_q ="";
       $sub_u ="";

       $sql = "SELECT marc
               FROM biblio.record_entry
               WHERE id = $this->bib_id";

       $result = pg_query($this->db,$sql);
       $row = pg_fetch_row($result);

       $doc = new DOMDocument();
       $doc->loadXML($row[0]);

       $datafields = $doc->getElementsByTagName('datafield');
       foreach ($datafields as $datafield)
       {
          if ($datafield->getAttribute('tag') == '100')
          {
              $subfields = $datafield->getElementsByTagName('subfield');
              foreach($subfields as $subfield)
              {
                 if($subfield->getAttribute('code') == 'a' )
                 {
                    $sub_a = trim($subfield->nodeValue);
                 }
                 else if($subfield->getAttribute('code') == 'b' )
                 {
                     $sub_b = trim($subfield->nodeValue);
                 }
                 else if($subfield->getAttribute('code') == 'c' )
                 {
                    $sub_c = trim($subfield->nodeValue);
                 }
              }
          }
      }

      $author = $sub_a." ".$sub_b." ".$sub_c;

      $this->author = rtrim(trim($author),",");

      $this->search_author = trim($sub_a);

      $this->search_author = rtrim($this->search_author, ", " );

   }

   function GetAuthor()
   {
      return $this->author;
   }

   function GetSearchAuthor()
   {
      return $this->search_author;
   }

   function SetBibId($val, $domain, $scope)
   {
      $this->bib_id = $val;
      $this->SetCatalogLink($val, $domain, $scope);
      $this->SetCoverImage($val);
      $this->SetClientLink($val, $domain, $scope);
   }

   function GetBibId()
   {
      return $this->bib_id;
   }

   function SetHolds($circ_lib)
   {
      $holds_sql = "SELECT count(*)
                    FROM action.hold_request
                    WHERE target= $this->bib_id
                    AND hold_type = 'T'
                    AND fulfillment_time IS NULL
                    AND cancel_time IS NULL
                    AND (expire_time > now() OR expire_time IS NULL)
                    AND pickup_lib = $circ_lib";

      $holds_result = pg_query($this->db, $holds_sql);
      $holds_row = pg_fetch_row($holds_result);

      $this->holds_my_lib = $holds_row[0];

      $holds_sql = "SELECT count(*)
                    FROM action.hold_request
                    WHERE target= $this->bib_id
                    AND hold_type = 'T'
                    AND fulfillment_time IS NULL
                    AND cancel_time IS NULL
                    AND (expire_time > now() OR expire_time IS NULL)
                    AND pickup_lib != $circ_lib";

      $holds_result = pg_query($this->db, $holds_sql);
      $holds_row = pg_fetch_row($holds_result);

      $this->holds_other_lib = $holds_row[0];

   }

   function GetMyHolds()
   {
      return $this->holds_my_lib;
   }

   function GetOtherHolds()
   {
      return $this->holds_other_lib;
   }

   function GetTotalHoldCount()
   {
      return ($this->holds_other_lib + $this->holds_my_lib);
   }

   function SetCatalogLink($val, $domain, $scope)
   {
      $this->catalog_link = "https://".$domain.".noblenet.org/eg/opac/record/".$val."?locg=".$scope;
   }

   function SetSearchLink($domain, $scope)
   {
      $this->catalog_link = "https://".$domain.".noblenet.org/eg/opac/results?bool=and&qtype=title&contains=contains&query=".urlencode("\"".$this->GetTitleForTooltip()."\"")."&bool=and&qtype=author&contains=contains&query=".urlencode($this->GetSearchAuthor())."&query=&_adv=1&detail_record_view=0&locg=".$scope;
   }

   function GetCatalogLink($use_staff=false)
   {
      if ($use_staff) return  $this->client_link;
      else return $this->catalog_link;
   }

   function SetClientLink($val, $domain, $scope)
   {
      $this->client_link = "https://evergreen.noblenet.org/eg/staff/cat/catalog/record/".$val;
   }

   function SetCoverImage($val)
   {
      $this->cover_image = "https://evergreen.noblenet.org/opac/extras/ac/jacket/medium/r/".$val;
   }

   function GetCoverImage($size=null)
   {

      if ($size && $size !="medium")
      {
         return str_replace("medium", $size, $this->cover_image);
      }
      else
      {
         return $this->cover_image;
      }
   }

   function SetSummary()
   {
      $sql = "SELECT marc
               FROM biblio.record_entry
               WHERE id = $this->bib_id";

      $result = pg_query($this->db,$sql);
      $row = pg_fetch_row($result);

      $doc = new DOMDocument();
      $doc->loadXML($row[0]);

      $datafields = $doc->getElementsByTagName('datafield');
      foreach ($datafields as $datafield)
      {
         if ($datafield->getAttribute('tag') == '520')
         {
             $subfields = $datafield->getElementsByTagName('subfield');
             foreach($subfields as $subfield)
             {
                if($subfield->getAttribute('code') == 'a' )
                {
                   $this->summary[] = $subfield->nodeValue;
                }// end if subfield a
             }//end for each subfield
         }//end if datafield 520
      }//end for each datafield
   }

   function GetSummary()
   {
      return implode(",",$this->summary);
   }

   function SetFingerprint()
   {
       $sql = "SELECT fingerprint
               FROM biblio.record_entry
               WHERE id = $this->bib_id";

      $result = pg_query($this->db,$sql);
      $row = pg_fetch_row($result);

      $this->fingerprint = $row[0];
   }

   function GetFingerprint()
   {
      return $this->fingerprint;
   }

   function SetGoodreadsLink()
   {
      $title_author= "";
      $title = urlencode(strtolower(str_replace(" ", "+",$this->GetTitle())));
      $author = urlencode(strtolower(str_replace(" ", "+",$this->GetAuthor())));
      $this->goodreads_link = "http://www.goodreads.com/search?q=".$title."+".$author."&search_type=books";
   }

   function GetGoodreadsLink()
   {
      return $this->goodreads_link;
   }

   function SetGoogleLink($val)
   {
      //REMEMBER HOW TO DO THIS
      //$this->google_book_link = $val;
   }

   function GetGoogleLink()
   {
      return $this->google_book_link;
   }

   function SetISBN($isbn, $issn)
   {
      $isbn = str_replace(array("{", "}","NULL"), "", $isbn);
      $issn = str_replace(array("{", "}","NULL"), "", $issn);

      if (strlen($isbn)> 0 ) $this->isbn = explode(",", $isbn);
      else if (strlen($issn) > 0 ) $this->isbn = explode(",", $issn);

      if ($this->isbn)
      {
         $this->SetAmazonDirect($this->isbn[0]);
         $this->SetGoogleLink($this->isbn[0]);
      }
   }

   function GetISBN($seperator)
   {
      return implode($seperator, $this->isbn);
   }

   function GetOneISBN()
   {
       //remove quotes, spaces and anything between parantheses
       $clean_isbn = $this->isbn[0];
       $paren = strpos($clean_isbn, "(");
       if ($paren != false) $clean_isbn = substr($clean_isbn, 0, $paren-1);

       $colon = strpos($clean_isbn, ":");
       if ($colon !=false) $clean_isbn = substr($clean_isbn, 0, $colon-1);

       $clean_isbn = str_replace('"', "", $clean_isbn);
       return trim($clean_isbn);
   }

   function SetMarc($input_tag, $input_subfield)
   {
      //get the tag from the marc and add it to the record
       $sql = "SELECT marc
               FROM biblio.record_entry
               WHERE id = $this->bib_id";

       $result = pg_query($this->db,$sql);
       $row = pg_fetch_row($result);

       $doc = new DOMDocument();
       $doc->loadXML($row[0]);

       if ($input_tag == '001' || $input_tag == '003'|| $input_tag == '0085' || $input_tag == '006' || $input_tag == '007' || $input_tag == '008')
       {
           $controlfields =   $doc->getElementsByTagName('controlfield');
           foreach ($controlfields as $controlfield)
           {
               if ($controlfield->getAttribute('tag')  == $input_tag)
               {
                   $this->marc[] = $controlfield->nodeValue;
               }
           }
       }
       else
       {
           $datafields = $doc->getElementsByTagName('datafield');
           foreach ($datafields as $datafield)
           {
               if ($datafield->getAttribute('tag') == $input_tag)
               {
                   $subfields = $datafield->getElementsByTagName('subfield');
                   $marc_string = "".str_replace(" ","\\",$datafield->getAttribute('ind1')).str_replace(" ","\\",$datafield->getAttribute('ind2'));

                   foreach($subfields as $subfield)
                   {
                       if ($input_subfield == "ALL" || $input_subfield == "all")
                       {
                           $marc_string .= "$".$subfield->getAttribute('code').$subfield->nodeValue;
                       }
                       else
                       {
                           if($subfield->getAttribute('code') ==   $input_subfield )
                           {
                               $this->marc[]   = $subfield->nodeValue;
                           }// end if subfield a
                       }//end specifc subfield


                   }//end for each subfield

                   if ($input_subfield == "ALL" || $input_subfield == "all") $this->marc[] = $marc_string;
               }//end if datafield 520
           }
       }

   }

   function GetMarc($seperator)
   {
      return implode($seperator, $this->marc);
   }

   function SetNovelistLink()
   {
      $this->novelist_link = "";
   }

   function GetNovelistLink()
   {
      return $this->novelist_link;
   }

   function SetOCLCNumber()
   {
      //get 035
      $oclc_sql = "SELECT value
                   FROM metabib.real_full_rec
                   WHERE tag = '035'
                   AND record= $this->bib_id";

      $oclc_result = pg_query($this->db, $oclc_sql);

      while ($oclc_row = pg_fetch_row($oclc_result))
      {
         $oclc = $oclc_row[0];
         $pos = strpos($oclc, 'ocolc');
         if ( $pos !== false)
         {
            //this is the oclc number get the value after oclc
            $this->oclc_number = trim(substr($oclc, $pos+5));
         }
         else
         {
            $this->oclc_number = "";
         }
      }
   }

   function GetOCLCNumber()
   {
      return $this->oclc_number;
   }

   function SetOnline()
   {
      $this->is_onilne = true;
   }

   function GetOnline()
   {
      return $this->is_online;
   }

   function SetOnlineSubU($val)
   {
      $this->sub_u = $val;
   }

   function GetOnlineSubU()
   {
      return $this->sub_u;
   }

   function SetOnlineSubY($val)
   {
      $this->sub_y = $val;
   }

   function GetOnlineSubY()
   {
      return $this->sub_y;
   }

   function SetOnlineSub9($val)
   {
      $this->sub_9 = $val;
   }

   function GetOnlineSub9()
   {
      return $this->sub_9;
   }

   function SetOnlineCreateDate($val)
   {
      if (date('Y-m-d', strtotime($val)) > date('Y-m-d', strtotime("06-05-2020")) )
      {
         $this->online_create_date = date('m/d/Y', strtotime($val));
      }
      else
      {
         $this->online_create_date = "--";
      }

   }

   function GetOnlineCreateDate()
   {
      return $this->online_create_date;
   }

   function SetOverdriveReserveID()
   {
       $reserve_sql ="SELECT reserve_id
                      FROM overdrive.title
                      WHERE eg_bib_id = '$this->bib_id'";

       $reserve_result = pg_query($this->db, $reserve_sql);
       $reserve_row = pg_fetch_row($reserve_result);

       if($reserve_row) $this->overdrive_reserve_id =  $reserve_row[0];
       else $this->overdrive_reserve_id = "";
   }

   function GetOverdriveReserveID()
   {
      return $this->overdrive_reserve_id;
   }

   function SetPubYear()
   {
       //Pub Date from date 1 in MARC
       $pubdate_sql ="SELECT value
                      FROM metabib.real_full_rec
                      WHERE record = '$this->bib_id'
                      AND tag = '008' ";

       $pubdate_result = pg_query($this->db, $pubdate_sql);
       $pubdate_row = pg_fetch_row($pubdate_result);
       if ($pubdate_row) $pub_test = substr($pubdate_row[0], 7, 4);
       else $pub_test = '';

       if (ctype_digit($pub_test))
       {
          $this->pub_year = (int)$pub_test;
       }
       else
       {
          $this->pub_year = -1;
       }
   }

   function GetPubYear()
   {
      return $this->pub_year;
   }

   function GetPubYearForDisplay()
   {
      if ($this->pub_year < 0)return "";
      return $this->pub_year;
   }

   function SetPublisher($val)
   {
      $this->publisher = ucwords($val);
   }

   function GetPublisher()
   {
      return $this->publisher;
   }

   function SetTitle()
   {
       $sub_a ="";
       $sub_b ="";
       $sub_n ="";
       $sub_p ="";

       $sql = "SELECT marc
               FROM biblio.record_entry
               WHERE id = $this->bib_id";

       $result = pg_query($this->db,$sql);
       $row = pg_fetch_row($result);

       $doc = new DOMDocument();
       $doc->loadXML($row[0]);

       $curr_subfield = "";
       $before_c = "";

       $datafields = $doc->getElementsByTagName('datafield');
       foreach ($datafields as $datafield)
       {
          if ($datafield->getAttribute('tag') == '245')
          {
              $subfields = $datafield->getElementsByTagName('subfield');
              foreach($subfields as $subfield)
              {
                 if($subfield->getAttribute('code') == 'a' )
                 {
                    $sub_a = trim($subfield->nodeValue);
                    $curr_subfield = "a";
                 }
                 else if($subfield->getAttribute('code') == 'b' )
                 {
                     $sub_b = trim($subfield->nodeValue);
                     $curr_subfield = "b";
                 }
                 else if($subfield->getAttribute('code') == 'n' )
                 {
                    $sub_n = trim($subfield->nodeValue);
                    $curr_subfield = "n";
                 }
                 else if($subfield->getAttribute('code') == 'p' )
                 {
                    $sub_p = trim($subfield->nodeValue);
                    $curr_subfield = "p";
                 }
                 else if($subfield->getAttribute('code') == 'c' )
                 {
                    $before_c = $curr_subfield;
                 }
              }
          }
      }

      if ($before_c == "a") $sub_a= rtrim($sub_a, "/");
      else if ($before_c == "b") $sub_b= rtrim($sub_b, "/");
      else if ($before_c == "p") $sub_p= rtrim($sub_p, "/");
      else if ($before_c == "n") $sub_n= rtrim($sub_n, "/");

      $title = $sub_a." ".$sub_b." ".$sub_p." ".$sub_n;

      $this->title = rtrim(trim($title),"/");

      $this->tooltip_title = trim($sub_a);

      $this->tooltip_title = rtrim($this->tooltip_title, ": " );

      $this->SetAmazonSearch($this->title);
   }

   function GetTitle()
   {
      return $this->title;
   }

   function GetTitleForTooltip()
   {
      return $this->tooltip_title;
   }

}

class MultipleCopyBib extends BibRec
{
   public $lib_copies; //CopyList Items -- one list for each branch

   public $most_recent_active_date;
   public $other_library_count;

   public $total_circs_my_sys;
   public $total_circs_other_sys;

   function __construct()
   {
      parent::__construct();
      $this->lib_copies = array();
      $this->most_recent_active_date = '1970-01-01';
      $this->total_circs_my_sys = 0;
      $this->total_circs_other_sys = 0;

   }

   function __destruct()
   {
      parent::__destruct();
      unset($this->lib_copies);
   }

   function CopyFromBib($input_bib)
   {
      $this->db                 = $input_bib->db;
      $this->amazon_direct       = $input_bib->amazon_direct;
      $this->amazon_search       = $input_bib->amazon_search;
      $this->author              = $input_bib->author;
      $this->search_author       = $input_bib->search_author;
      $this->bib_id              = $input_bib->bib_id;
      $this->catalog_link        = $input_bib->catalog_link;
      $this->client_link         = $input_bib->client_link;
      $this->cover_image         = $input_bib->cover_image;
      $this->summary             = $input_bib->summary;
      $this->fingerprint         = $input_bib->fingerprint;
      $this->goodreads_link      = $input_bib->goodreads_link;
      $this->google_book_link    = $input_bib->google_book_link;
      $this->isbn                = $input_bib->isbn;
      $this->marc                = $input_bib->marc;
      $this->novelist_link       = $input_bib->novelist_link;
      $this->oclc_number         = $input_bib->oclc_number;
      $this->pub_year            = $input_bib->pub_year;
      $this->publisher           = $input_bib->publisher;
      $this->title               = $input_bib->title;
      $this->tooltip_title       = $input_bib->tooltip_title;
      $this->is_online           = $input_bib->is_online;
      $this->sub_u               = $input_bib->sub_u;
      $this->sub_y               = $input_bib->sub_y;
      $this->sub_9               = $input_bib->sub_9;
      $this->online_create_date  = $input_bib->online_create_date;
      $this->overdrive_reserve_id = $input_bib->overdrive_reserve_id;

      //Dont copy hold data. Want to recalculate since this is a record for the system
   }

   function AddCopy($copy_rec)
   {
      $lib_id = $copy_rec->GetCircLibId();
      $shortname = $copy_rec->GetCircLibShortname();

      if(!isset($this->lib_copies[$lib_id]))
      {
         $this->lib_copies[$lib_id] = new CopyList();
         $this->lib_copies[$lib_id]->SetLibrary($shortname, $lib_id);
      }

      $this->lib_copies[$lib_id]->AddCopy($copy_rec);

      if (date('Y-m-d',strtotime($copy_rec->GetActiveDate())) > date('Y-m-d',strtotime($this->most_recent_active_date)) )
      {
         $this->most_recent_active_date = date('Y-m-d',strtotime($copy_rec->GetActiveDate()));
      }
   }

   function GetFirstCopyRec()
   {
      reset ($this->lib_copies);
      $curr_library = current($this->lib_copies);

      reset($curr_library->copies);
	  return current($curr_library->copies);
   }

   function GetCopyCount()
   {
      $count = 0;
      foreach($this->lib_copies as $lib)
      {
         $count += $lib->GetTotalCopies();
      }
      return $count;
   }

   function GetCopyCountByLibrary($shortname)
   {
      foreach($this->lib_copies as $lib)
      {
         if ($lib->GetShortname() == $shortname)
         {
            return $lib->GetTotalCopies();
         }
      }

      return -1;
   }

   function GetTotalCircs()
   {
      $count = 0;
      foreach($this->lib_copies as $lib)
      {
         $count += $lib->GetTotalCircs();
      }
      return $count;
   }

   function SetTotalCircsBySys($branch_ids, $copy_rec)
   {
       $branches = '('.implode(',', $branch_ids).')';
       //echo $branches;

       $copy_id = $copy_rec->GetCopyId();

       $my_sql = "SELECT COUNT(*)
				  FROM action.all_circulation
				  WHERE target_copy= '$copy_id '
				  AND circ_lib IN $branches";

		$my_result = pg_query($this->db, $my_sql);
		$my_row = pg_fetch_row($my_result);
		$this->total_circs_my_sys += $my_row[0];

		$other_sql = "SELECT COUNT(*)
					  FROM action.all_circulation
					  WHERE target_copy= '$copy_id '
					  AND circ_lib NOT IN $branches";

		$other_result = pg_query($this->db, $other_sql);
		$other_row = pg_fetch_row($other_result);
		$this->total_circs_other_sys += $other_row[0];
   }

   function GetTotalCircsMySys()
   {
      return $this->total_circs_my_sys;
   }

   function GetTotalCircsOtherSys()
   {
      return $this->total_circs_other_sys;
   }

   function GetYTDCircs()
   {
      $count = 0;
      foreach($this->lib_copies as $lib)
      {
         $count += $lib->GetYTDCircs();
      }
      return $count;
   }

   function GetCircsBetween()
   {
      $count = 0;
      foreach($this->lib_copies as $lib)
      {
         $count += $lib->GetCircsBetween();
      }
      return $count;
   }

  function GetCourseCircs()
   {
      $count = 0;
      foreach($this->lib_copies as $lib)
      {
         $count += $lib->GetCourseCirc();
      }
      return $count;
   }

   function GetTotalCircsByLibrary($shortname)
   {
      foreach($this->lib_copies as $lib)
      {
         if ($lib->GetShortname() == $shortname)
         {
            return $lib->GetTotalCircs();
         }
      }

      return -1;
   }

   function GetCircsPerCopy()
   {
      return round($this->GetTotalCircs()/$this->GetCopyCount(), 2);
   }

   function GetCircsBetweenPerCopy()
   {
      return round($this->GetCircsBetween()/$this->GetCopyCount(), 2);
   }

   function GetActiveDate()//format -- YYYY-mm-dd
   {
      return date('Y-m-d', strtotime($this->most_recent_active_date));
   }

   function SetHoldCounts($branch_ids)
   {
       $branches = '('.implode(',', $branch_ids).')';
       //echo $branches;
       $holds_sql = "SELECT count(*)
                    FROM action.hold_request
                    WHERE target= $this->bib_id
                    AND hold_type = 'T'
                    AND fulfillment_time IS NULL
                    AND cancel_time IS NULL
                    AND (expire_time > now() OR expire_time IS NULL)
                    AND pickup_lib IN $branches";


      $holds_result = pg_query($this->db, $holds_sql);

      if ($holds_result)
      {
         $holds_row = pg_fetch_row($holds_result);

         $this->holds_my_lib = $holds_row[0];
      }
      else
      {
         $this->holds_my_lib = 0;
      }

      $holds_sql = "SELECT count(*)
                    FROM action.hold_request
                    WHERE target= $this->bib_id
                    AND hold_type = 'T'
                    AND fulfillment_time IS NULL
                    AND cancel_time IS NULL
                    AND (expire_time > now() OR expire_time IS NULL)
                    AND pickup_lib NOT IN $branches";

      $holds_result = pg_query($this->db, $holds_sql);
      if ($holds_result)
      {
         $holds_row = pg_fetch_row($holds_result);
         $this->holds_other_lib = $holds_row[0];
      }
      else
      {
         $this->holds_other_lib = 0;
      }
   }

   function SetOtherLibraryCount($branch_ids)
   {
      $branches = '('.implode(',', $branch_ids).')';
      $only_sql = "SELECT count(*)
                    FROM asset.copy
                    INNER JOIN asset.call_number ON asset.call_number.id = asset.copy.call_number
                    WHERE asset.call_number.record = '$this->bib_id'
                    AND asset.copy.deleted = false
                    AND asset.copy.circ_lib NOT IN $branches ";

       $only_result = pg_query($this->db, $only_sql);

       if ($only_result)
       {
          $only_row = pg_fetch_row($only_result);
          $this->other_library_count = $only_row[0];
       }
       else
       {
          $this->other_library_count =0;
       }
   }

   function GetOtherLibraryCount()
   {
      return $this->other_library_count;
   }

}

class OneCopyBib extends BibRec
{
   public $copy; //CopyRec Items -- one
   public $num_stat_cat;

   function __construct()
   {
      parent::__construct();
      $this->num_stat_cat = 0;
   }

   function __destruct()
   {
      parent::__destruct();
   }

   function CopyFromBib($input_bib)
   {
      $this->amazon_direct       = $input_bib->amazon_direct;
      $this->amazon_search       = $input_bib->amazon_search;
      $this->author              = $input_bib->author;
      $this->search_author       = $input_bib->search_author;
      $this->bib_id              = $input_bib->bib_id;
      $this->catalog_link        = $input_bib->catalog_link;
      $this->client_link         = $input_bib->client_link;
      $this->cover_image         = $input_bib->cover_image;
      $this->summary             = $input_bib->summary;
      $this->fingerprint         = $input_bib->fingerprint;
      $this->goodreads_link      = $input_bib->goodreads_link;
      $this->google_book_link    = $input_bib->google_book_link;
      $this->holds_my_lib        = $input_bib->holds_my_lib;
      $this->holds_other_lib     = $input_bib->holds_other_lib;
      $this->isbn                = $input_bib->isbn;
      $this->marc                = $input_bib->marc;
      $this->novelist_link       = $input_bib->novelist_link;
      $this->oclc_number         = $input_bib->oclc_number;
      $this->pub_year            = $input_bib->pub_year;
      $this->publisher           = $input_bib->publisher;
      $this->title               = $input_bib->title;
      $this->tooltip_title       = $input_bib->tooltip_title;
      $this->is_online           = $input_bib->is_online;
      $this->sub_u               = $input_bib->sub_u;
      $this->sub_y               = $input_bib->sub_y;
      $this->sub_9               = $input_bib->sub_9;
      $this->online_create_date  = $input_bib->online_create_date;
      $this->overdrive_reserve_id = $input_bib->overdrive_reserve_id;
   }

   function AddCopy($copy_rec)
   {
      $this->copy = $copy_rec;
      $this->num_stat_cat = $copy_rec->GetNumStatCats();
   }

   function GetCopyCount()
   {
      return 1;
   }

   function GetTotalCircs()
   {
      return $this->copy->GetLifetimeCircs();
   }

   function GetcircsBetween()
   {
      return $this->copy->GetCircsBetween();
   }

   function GetLibaryId()
   {
      return $this->copy->GetCircLibId();
   }

   function GetActiveDate()//format -- YYYY-mm-dd
   {
      return date('Y-m-d', strtotime($this->copy->GetActiveDate()));
   }

   function GetNumStatCats()
   {
      return $this->num_stat_cat;
   }

   function GetCopyRec()
   {
      return $this->copy;
   }

   function GetPrice()
   {
      return $this->copy->GetPrice();
   }

   function GetAcqCost()
   {
      return $this->copy->GetAcqCost();
   }

}


?>