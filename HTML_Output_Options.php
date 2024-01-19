<?php

class HTML_Output_Options
{
   public $active_date;
   public $age_protection;
   public $alert_messgae;
   public $amazon_direct;
   public $amazon_search;
   public $author;
   public $barcode;
   public $bib_id;
   public $call_number;
   public $catalog_link;
   public $circ_modifier;
   public $circ_lib; //branch
   public $copy_location;
   public $copy_status;
   public $cover_image;
   public $goodreads;
   public $google_books;
   public $in_house_use;
   public $isbn;
   public $last_checkin;
   public $lifetime_circ;
   public $novelist;
   public $oclc_number;
   public $part;
   public $public_note;
   public $pub_year;
   public $publisher;
   public $staff_note;
   public $stat_cat;
   public $status_change_date;
   public $summary; //description
   public $title;
   public $ytd_circs;

   //sort order;
   public $author_sort;
   public $active_date_sort;
   public $call_number_sort;
   public $circ_between_sort;
   public $lifetime_circ_sort;
   public $ytd_circ_sort;
   public $title_sort;

   //layout
   public $block_layout;
   public $inline_layout;
   public $slider_layout;
   public $cover_grid;
   public $grid_width;

   //Options
   public $image_size;
   public $group_copies;
      public $show_first_copy;
      public $show_all_copies;
   public $word_press;
   public $save_html;

   public $output_filenames;

   function __construct()
   {
      $this->active_date = false;
      $this->age_protection = false;
      $this->alert_message = false;
      $this->amazon_direct = false;
      $this->amazon_search = false;
      $this->author = false;
      $this->barcode = false;
      $this->bib_id = false;
      $this->call_number = false;
      $this->call_number_class = false;
      $this->catalog_link = false;
      $this->circ_modifier = false;
      $this->circ_lib = false;
      $this->copy_location = false;
      $this->copy_status = false;
      $this->cover_image = false;
      $this->goodreads = false;
      $this->google_books = false;
      $this->in_house_use = false;
      $this->isbn = false;
      $this->last_checkin = false;
      $this->lifetime_circ = false;
      $this->novelist = false;
      $this->oclc_number = false;
      $this->part = false;
      $this->pub_year = false;
      $this->public_note = false;
      $this->publisher = false;
      $this->staff_note = false;
      $this->stat_cat = false;
      $this->status_change_date = false;
      $this->summary = false;
      $this->title = false;
      $this->ytd_circs = false;

      $this->author_sort = false;
      $this->active_date_sort = false;
      $this->call_number_sort = false;
      $this->circ_between_sort = false;
      $this->lifetime_circ_sort = false;
      $this->ytd_circ_sort = false;
      $this->title_sort = false;

      $this->block_layout = false;
      $this->inline_layout = false;
      $this->slider_layout = false;
      $this->cover_grid = false;
      $this->grid_width = -1;

      $this->image_size = "medium";
      $this->group_copies = false;
      $this->show_first_copy = false.
      $this->show_all_copies = false;
      $this->save_html = false;
      $this->word_press = false;

      $this->output_filenames = array();
   }

   function SetActiveDate()
   {
      $this->active_date = true;
   }

   function GetActiveDate()
   {
      return $this->active_date;
   }

   function SetAgeProtection()
   {
      $this->age_protection = true;
   }

   function GetAgeProtection()
   {
      return $this->age_protection;
   }

   function SetAlertMessage()
   {
      $this->alert_message = true;
   }

   function GetAlertMessage()
   {
      return $this->alert_message;
   }

   function SetAmazonDirect()
   {
      $this->amazon_direct = true;
   }

   function GetAmazonDirect()
   {
      return $this->amazon_direct;
   }

   function SetAmazonSearch()
   {
      $this->amazon_search = true;
   }

   function GetAmazonSearch()
   {
      return $this->amazon_search;
   }

   function SetAuthor()
   {
      $this->author = true;
   }

   function GetAuthor()
   {
      return $this->author;
   }

   function SetBarcode()
   {
      $this->barcode = true;
   }

   function GetBarcode()
   {
      return $this->barcode;
   }

   function SetBibId()
   {
      $this->bib_id = true;
   }

   function GetBibId()
   {
      return $this->bib_id;
   }

   function SetCallNumber()
   {
      $this->call_number = true;
   }

   function GetCallNumber()
   {
      return $this->call_number;
   }

   function SetCircModifier()
   {
      $this->circ_modifier = true;
   }

   function GetCircModifier()
   {
      return $this->circ_modifier;
   }

   function SetCircLib()
   {
      $this->circ_lib = true;
   }

   function GetCircLib()
   {
      return $this->circ_lib;
   }

   function SetCopyLocation()
   {
      $this->copy_location = true;
   }

   function GetCopyLocation()
   {
      return $this->copy_location;
   }

   function SetCopyStatus()
   {
      $this->copy_status = true;
   }

   function GetCopyStatus()
   {
      return $this->copy_status;
   }

   function SetCoverImage()
   {
      $this->cover_image = true;
   }

   function GetCoverImage()
   {
      return $this->cover_image;
   }

   function SetGoodreads()
   {
      $this->goodreads = true;
   }

   function GetGoodreads()
   {
      return $this->goodreads;
   }

   function SetGoogleBooks()
   {
      $this->google_books = true;
   }

   function GetGoogleBooks()
   {
      return $this->google_books;
   }

   function SetInHouseUse()
   {
      $this->in_house_use = true;
   }

   function GetInHouseUse()
   {
      return $this->in_house_use;
   }

   function SetISBN()
   {
      $this->isbn = true;
   }

   function GetISBN()
   {
      return $this->isbn;
   }

   function SetLastCheckin()
   {
      $this->last_checkin = true;
   }

   function GetLastCheckin()
   {
      return $this->last_checkin;
   }

   function SetLifetimeCirc()
   {
      $this->lifetime_circ = true;
   }

   function GetLifetimeCirc()
   {
      return $this->lifetime_circ;
   }

   function SetPublicNote()
   {
      $this->public_note = true;
   }

   function GetPublicNote()
   {
      return $this->public_note;
   }

   function SetStaffNote()
   {
      $this->staff_note = true;
   }

   function GetStaffNote()
   {
      return $this->staff_note;
   }

   function SetNovelist()
   {
      $this->novelist = true;
   }

   function GetNovelist()
   {
      return $this->novelist;
   }

   function SetOCLCNumber()
   {
      $this->oclc_number = true;
   }

   function GetOCLCNumber()
   {
      return $this->oclc_number;
   }

   function SetPart()
   {
      $this->part = true;
   }

   function GetPart()
   {
      return $this->part;
   }

   function SetPubYear()
   {
      $this->pub_year = true;
   }

   function GetPubYear()
   {
      return $this->pub_year;
   }

   function SetPublisher()
   {
      $this->publisher = true;
   }

   function GetPublisher()
   {
      return $this->publisher;
   }

   function SetStatCat()
   {
      $this->stat_cat = true;
   }

   function GetStatCat()
   {
      return $this->stat_cat;
   }

   function SetStatChange()
   {
      $this->status_change_date = true;
   }

   function GetStatChange()
   {
      return $this->status_change_date;
   }

   function SetSummary()
   {
      $this->summary = true;
   }

   function GetSummary()
   {
      return $this->summary;
   }

   function SetTitle()
   {
      $this->title = true;
   }

   function GetTitle()
   {
      return $this->title;
   }

   function SetYTDCircs()
   {
      $this->ytd_circs = true;
   }

   function GetYTDCircs()
   {
      return $this->ytd_circs;
   }

   function SetBlockLayout()
   {
      $this->block_layout = true;
   }

   function GetBlockLayout()
   {
      return $this->block_layout;
   }

   function SetInlineLayout()
   {
      $this->inline_layout = true;
   }

   function GetInlineLayout()
   {
      return $this->inline_layout;
   }

   function SetGridLayout($val)
   {
      $this->cover_grid = true;
      $this->grid_width = $val;
   }

   function GetGridLayout()
   {
      return $this->cover_grid;
   }

   function GetGridWidth()
   {
      return $this->grid_width;
   }

   function SetSliderLayout()
   {
      $this->slider_layout = true;
   }

   function GetSliderLayout()
   {
      return $this->slider_layout;
   }

   function SetImageSize($size)
   {
      $this->image_size = $size;
   }

   function GetImageSize()
   {
      return $this->image_size;
   }

   function SetGroupCopies($type)
   {
      $this->group_copies = true;
      if ($type == "1")$this->show_first_copy = true;
      else if ($type == "all")$this->show_all_copies = true;
   }

   function GetGroupCopies()
   {
      return $this->group_copies;
   }

   function SetSaveHTML()
   {
      $this->save_html = true;
   }

   function GetSaveHTML()
   {
      return $this->save_html;
   }

   function SetWordPress()
   {
      $this->word_press = true;
   }

   function GetWordPress()
   {
      return $this->word_press;
   }

   function SetAuthorSort()
   {
      $this->author_sort = true;
   }

   function GetAuthorSort()
   {
      return $this->author_sort;
   }

   function SetActiveDateSort()
   {
      $this->active_date_sort = true;
   }

   function GetActiveDateSort()
   {
      return $this->active_date_sort;
   }

   function SetCallNumSort()
   {
      $this->call_number_sort = true;
   }

   function GetCallNumSort()
   {
      return $this->call_number_sort;
   }

   function SetCircBetweenSort()
   {
      $this->circ_between_sort = true;
   }

   function GetCircBetweenSort()
   {
      return $this->circ_between_sort;
   }

   function SetLifetimeCircSort()
   {
      $this->lifetime_circ_sort = true;
   }

   function GetLifetimeCircSort()
   {
      return $this->lifetime_circ_sort;
   }

   function SetTitleSort()
   {
      $this->title_sort = true;
   }

   function GetTitleSort()
   {
      return $this->title_sort;
   }

   function SetYTDCircSort()
   {
      $this->ytd_circ_sort = true;
   }

   function GetYtdCircSort()
   {
      return $this->ytd_circ_sort;
   }

   function SortList($bib_list)
   {
      if ($this->GetGroupCopies())$arg="multiple";
      else $arg="single";

      if ($this->GetAuthorSort()) $bib_list->SortyByAuthor($arg);
      else if ($this->GetActiveDateSort()) $bib_list->SortByActiveDate($arg);
      else if ($this->GetCallNumSort()) $bib_list->SortByCallNum($arg);
      else if ($this->GetCircBetweenSort()) $bib_list->SortByCircBetween($arg);
      else if ($this->GetLifetimeCircSort()) $bib_list->SortByLifetimeCircs($arg);
      else if ($this->GetTitleSort()) $bib_list->SortByTitle($arg);
      else if ($this->GetYTDCircSort()) $bib_list->SortByYTDCircs($arg);
   }

   function WriteHTML($bib_list, $relative_file_name)
   {

      if ($relative_file_name)
      {
         $links_new_window = false;
         if ($this->save_html)
			{
				$write_filename_start = "/var/www/tools/wp_html/".$relative_file_name.".html";
				$save_filename_start = "http://tools.noblenet.org/wp_html/".$relative_file_name.".html";
			}
			else
			{
				$write_filename_start = "/var/www/tools/reports/".$relative_file_name;
				$save_filename_start = "http://tools.noblenet.org/reports/".$relative_file_name;
			}

			if ($this->GetBlockLayout())
			{
				 $file_data = $this->WriteBlockLayout($bib_list, $links_new_window);

				 if ($this->save_html) $filename = $write_filename_start."_block.html";
				 else $filename = $write_filename_start."_block.txt";

				 $write_filename = $write_filename_start."_block.txt";;
		         $this->output_filenames[] = $save_filename_start."_block.txt";

				 echo "Writing HTML Report  -- ".$write_filename."\n";
                 file_put_contents($write_filename, $file_data);
                 chgrp($write_filename, "www-data");
			}

			if ($this->GetInlineLayout())
			{
				$file_data = $this->WriteInlineLayout($bib_list, $links_new_window);

				 if ($this->save_html) $filename = $write_filename_start."_inline.txt";
				 else $filename = $write_filename_start."_inilne.txt";

				 $write_filename = $write_filename_start."_inline.txt";
		         $this->output_filenames[] = $save_filename_start."_inline.txt";

				 echo "Writing HTML Report  -- ".$write_filename."\n";
                file_put_contents($write_filename, $file_data);
                chgrp($write_filename, "www-data");
			}

			if ($this->GetGridLayout())
			{
				 $file_data = $this->WriteGridLayout($bib_list, $links_new_window);

			     if ($this->save_html) $filename = $write_filename_start."_grid.html";
				 else $filename = $write_filename_start."_grid.txt";

				 $write_filename = $write_filename_start."_grid.txt";
		         $this->output_filenames[] = $save_filename_start."_grid.txt";

				 echo "Writing HTML Report  -- ".$write_filename."\n";
                file_put_contents($write_filename, $file_data);
                chgrp($write_filename, "www-data");
			}

      }
      else
      {
         $links_new_window = true;

         if ($this->GetBlockLayout()) $file_data = $this->WriteBlockLayout($bib_list, $links_new_window);
         else if ($this->GetInlineLayout()) $file_data = $this->WriteInlineLayout($bib_list, $links_new_window);
         else if ($this->GetGridLayout()) $file_data = $this->WriteGridLayout($bib_list, $links_new_window);
         else if ($this->GetSliderLayout()) $file_data = $this->WriteSliderLayout($bib_list, $links_new_window);

         return $file_data;
      }
   }

   function WriteBlockLayout($bib_list, $links_new_window)
   {
      $html_file_data = "<p><ul class=\"block\">\n";

      if ($this->GetGroupCopies() && $this->show_all_copies)
      {
			//this is true for the grouped copies
			foreach ($bib_list->multiple_copy_recs as $curr_bib)
			{
			   $title = str_replace("--", " ", $curr_bib->GetTitle());//do this to prevent any issues with comments
			   $html_file_data .="<!-- START ".$title."  -->\n";
				$html_file_data .="<hr /><li class=\"book_list\"><div class=\"book_block\">\n";

				$html_file_data .= $this->WriteCopyTableBlock($curr_bib, $links_new_window);

				$html_file_data .= "</div></div></li>\n";
				$html_file_data .="<!-- END ".$title."  -->\n";

			}

      }
      else if ($this->GetGroupCopies() && $this->show_first_copy)
      {
         foreach ($bib_list->multiple_copy_recs as $curr_bib)
			{
			   $title = str_replace("--", " ", $curr_bib->GetTitle());//do this to prevent any issues with comments
			   $html_file_data .="<!-- START ".$title."  -->\n";
				$html_file_data .="<hr /><li class=\"book_list\"><div class=\"book_block\">\n";
			   $curr_copy =  $curr_bib->GetFirstCopyRec();

            $html_file_data .= $this->WriteSingleCopyBlock($curr_bib, $curr_copy, true, $links_new_window);

				$html_file_data .= "</div></div></li>\n";
				$html_file_data .="<!-- END ".$title."  -->\n";
			}
      }
      else
      {
			foreach ($bib_list->one_bib_one_copy_recs as $curr_lib)
			{
           $bibs = $curr_lib->bib_copy_list;

				foreach($bibs as $curr_bib)
            {
               $title = str_replace("--", " ", $curr_bib->GetTitle());//do this to prevent any issues with comments
               $html_file_data .="<!-- START ".$title."  -->\n";
               $html_file_data .="<hr /><li class=\"book_list\"><div class=\"book_block\">\n";
               $curr_copy =  $curr_bib->GetCopyRec();

               $html_file_data .= $this->WriteSingleCopyBlock($curr_bib, $curr_copy, false, $links_new_window);

					$html_file_data .= "</div></div></li>\n";
					$html_file_data .="<!-- END ".$title."  -->\n";

				}

			}
      }

      if ($bib_list->HasOnlineRecs())
      {
         foreach($bib_list->online_recs as $curr_bib)
         {
            $title = str_replace("--", " ", $curr_bib->GetTitle());//do this to prevent any issues with comments
            $html_file_data .="<!-- START ".$title."  -->\n";
            $html_file_data .="<hr /><li class=\"book_list\"><div class=\"book_block\">\n";

            $html_file_data .= $this->WriteOnlineRecBlock($curr_bib, $links_new_window);

            $html_file_data .= "</div></div></li>\n";
				$html_file_data .="<!-- END ".$title."  -->\n";
         }
      }

      $html_file_data .="<hr /></ul></p>\n";

      return $html_file_data;
   }

   function WriteSingleCopyBlock($curr_bib, $curr_copy, $use_bib_data, $links_new_window)
   {
      $html_file_data = "";

      if($links_new_window) $new_window = " target=\"_blank\" ";
      else $new_window = "";

		if ($this->GetCoverImage() && strlen($curr_bib->GetCatalogLink()) > 0)
		{
			 $html_file_data .="<br /><div class=\"cover_div\"><a href=\"".$curr_bib->GetCatalogLink()."\"".$new_window."><img src =\"".$curr_bib->GetCoverImage($this->GetImageSize())."\" class=\"cover\" /></a></div>\n";
		}

		$html_file_data .="<div class=\"book_attr\">\n";

		if ( $this->GetCallNumber() &&
		     ( strlen($curr_copy->GetCallNumber()) > 0 ||  strlen($curr_copy->GetPrefix()) > 0 ||  strlen($curr_copy->GetSuffix()) > 0  ) )
		{
			 $html_file_data .= "<span class=\"call_num\">".$curr_copy->GetPrefix()." ".$curr_copy->GetCallNumber()." ".$curr_copy->GetSuffix()."</span>\n";
			 if (!$this->GetWordPress()) $html_file_data .= "<br />";
		}

		//author
		if ($this->GetAuthor() && strlen($curr_bib->GetAuthor()) > 0 )
		{
			$html_file_data .="<span class=\"author\">".htmlentities($curr_bib->GetAuthor())."</span>\n";
			if (!$this->GetWordPress()) $html_file_data .= "<br />";
		}

		//title
		if ($this->GetTitle() && strlen($curr_bib->GetTitle()) > 0 )
		{
			$html_file_data .= "<a href=\"".$curr_bib->GetCatalogLink()."\" class=\"title\"".$new_window.">".htmlentities($curr_bib->GetTitle())."</a>\n";
			if (!$this->GetWordPress()) $html_file_data .= "<br />";
		}

		//publisher
		if ($this->GetPublisher() && $this->GetPubYear() && strlen($curr_bib->GetPublisher()) > 0 && strlen($curr_bib->GetPubYear()) > 0)
		{
			$html_file_data .="<span class=\"label\">Publisher:</span><span class=\"publisher\">".htmlentities($curr_bib->GetPublisher())."</span>, ";
			$html_file_data .="<span class=\"pubdate\">".$curr_bib->GetPubYear()."</span>\n";
			if (!$this->GetWordPress()) $html_file_data .= "<br />";
		}
		else if ($this->GetPubYear() && strlen($curr_bib->GetPubYear()) > 0)
		{
			$html_file_data .="<span class=\"label\">Publication Year:</span><span class=\"pubdate\">".$curr_bib->GetPubYear()."</span>\n";
			if (!$this->GetWordPress()) $html_file_data .= "<br />";
		}
		else if($this->GetPublisher() && strlen($curr_bib->GetPublisher()) > 0)
		{
			$html_file_data .="<span class=\"label\">Publisher:</span><span class=\"publisher\">".htmlentities($curr_bib->GetPublisher())."</span>\n";
			if (!$this->GetWordPress()) $html_file_data .= "<br />";
		}

		//summary
		if ($this->GetSummary() && strlen($curr_bib->GetSummary()) > 0)
		{
			$html_file_data .="<span class=\"label\">Summary:</span><span class=\"description\">".htmlentities($curr_bib->GetSummary())."</span>\n";
			if (!$this->GetWordPress()) $html_file_data .= "<br />";
		}

		//oclc number
		if ($this->GetOCLCNumber() && strlen($curr_bib->GetOCLCNumber()) > 0)
		{
			$html_file_data .="<span class=\"label\">OCLC Number:</span><span class=\"oclc\">".$curr_bib->GetOCLCNumber()."</span>\n";
			if (!$this->GetWordPress()) $html_file_data .= "<br />";
		}

		//isbn
		if ($this->GetISBN() && strlen($curr_bib->GetISBN("")) > 0)
		{
			$html_file_data .="<span class=\"label\">ISBN:</span><span class=\"isbn10\">".$curr_bib->GetISBN(", ")."</span>\n";
			if (!$this->GetWordPress()) $html_file_data .= "<br />";
		}

		//google books
		if ($this->GetGoogleBooks() && strlen($curr_bib->GetGoogleLink()) > 0)
		{
			$html_file_data .="<span class=\"google\">".$curr_bib->GetGoogleLink()."</span>\n";
			if (!$this->GetWordPress()) $html_file_data .= "<br />";
		}

		//goodreads
		if ($this->GetGoodreads() && strlen($curr_bib->GetGoodreadsLink()) > 0)
		{
			$html_file_data .="<a href=\"".$curr_bib->GetGoodreadsLink()."\" class=\"goodreads\"".$new_window.">View on Goodreads</a>\n";
			if (!$this->GetWordPress()) $html_file_data .= "<br />";
		}

		//novelist
		if ($this->GetNovelist() && strlen($curr_bib->GetNovelistLink()) > 0)
		{
			$html_file_data .="<a href=\"".$curr_bib->GetNovelistLink()."\" class=\"novelist\"".$new_window.">View on Novelist</a>\n";
			if (!$this->GetWordPress()) $html_file_data .= "<br />";
		}

		//bib id
		if ($this->GetBibId() && strlen($curr_bib->GetBibId()) > 0)
		{
			$html_file_data .="<span class=\"label\">Bib Id:</span><span class=\"bib_id\">".$curr_bib->GetBibId()."</span>\n";
			if (!$this->GetWordPress()) $html_file_data .= "<br />";
		}

		//all the copy stuff
		//circ library
		if ($this->GetCircLib() && strlen($curr_copy->GetCircLibName()) > 0  )
		{
			$html_file_data .= "<span class=\"label\">Branch:</span><span class=\"branch\">".$curr_copy->GetCircLibName()."</span>\n";
			if (!$this->GetWordPress()) $html_file_data .= "<br />";
		}

		//part
		if ($this->GetPart() && strlen($curr_copy->GetPart()) > 0 )
		{
			$html_file_data .= "<span class=\"label\">Part:</span><span class=\"part\">".$curr_copy->GetPart()."</span>\n";
			if (!$this->GetWordPress()) $html_file_data .= "<br />";
		}

		//copy location
		if ($this->GetCopyLocation() && strlen($curr_copy->GetCopyLocation()) > 0 )
		{
			$html_file_data .= "<span class=\"label\">Shelving Location:</span><span class=\"copy_loc\">".$curr_copy->GetCopyLocation()."</span>\n";
			if (!$this->GetWordPress()) $html_file_data .= "<br />";
		}

		//active date
		if ($this->GetActiveDate() && strlen($curr_copy->GetActiveDate()) > 0 )
		{
			$html_file_data .= "<span class=\"label\">Active Date:</span><span class=\"active\">".$curr_copy->GetActiveDate()."</span>\n";
			if (!$this->GetWordPress()) $html_file_data .= "<br />";
		}

		//age protection
		if ($this->GetAgeProtection() && strlen($curr_copy->GetAgeProtect()) > 0 )
		{
			$html_file_data .= "<span class=\"label\">Age Protection:</span><span class=\"age_protect\">".$curr_copy->GetAgeProtect()."</span>\n";
			if (!$this->GetWordPress()) $html_file_data .= "<br />";
			$html_file_data .= "<span class=\"label\">Age Protection Expire:</span><span class=\"age_protect\">".$curr_copy->GetAgeProtectExpire()."</span>\n";
			if (!$this->GetWordPress()) $html_file_data .= "<br />";
		}

		//barcode
		if ($this->GetBarcode() && strlen($curr_copy->GetBarcode()) > 0 )
		{
			$html_file_data .= "<span class=\"label\">Barcode:</span><span class=\"barcode\">".$curr_copy->GetBarcode()."</span>\n";
			if (!$this->GetWordPress()) $html_file_data .= "<br />";
		}

		//circ modieier
		if ($this->GetCircModifier() && strlen($curr_copy->GetCircMod()) > 0 )
		{
			$html_file_data .= "<span class=\"label\">Circ Modifier:</span><span class=\"circ_mod\">".$curr_copy->GetCircMod()."</span>\n";
			if (!$this->GetWordPress()) $html_file_data .= "<br />";
		}

		//copy status
		if ($this->GetCopyStatus() && strlen($curr_copy->GetStatus()) > 0 )
		{
			$html_file_data .= "<span class=\"label\">Status:</span><span class=\"status\">".$curr_copy->GetStatus()."</span>\n";
			if (!$this->GetWordPress()) $html_file_data .= "<br />";
		}

		//status change date
		if ($this->GetStatChange() && strlen($curr_copy->GetStatusChange()) > 0 )
		{
			$html_file_data .= "<span class=\"label\">Last Status Change:</span><span class=\"status_change\">".$curr_copy->GetStatusChange()."</span>\n";
			if (!$this->GetWordPress()) $html_file_data .= "<br />";
		}

		//in house use
		if ($this->GetInHouseUse() && strlen($curr_copy->GetInHouseUse()) > 0 )
		{
			$html_file_data .= "<span class=\"label\">In House Use:</span><span class=\"in_house\">".$curr_copy->GetInHouseUse()."</span>\n";
			if (!$this->GetWordPress()) $html_file_data .= "<br />";
			$html_file_data .= "<span class=\"label\">Last In House Use:</span><span class=\"in_house\">".$curr_copy->GetLastInHouseUse()."</span>\n";
			if (!$this->GetWordPress()) $html_file_data .= "<br />";
		}

		//last checkin
		if ($this->GetLastCheckin() && strlen($curr_copy->GetLastCheckin()) > 0 )
		{
			$html_file_data .= "<span class=\"label\">Last Checkin:</span><span class=\"checkin\">".$curr_copy->GetLastCheckin()."</span>\n";
			if (!$this->GetWordPress()) $html_file_data .= "<br />";
		}

		//lifetime circs
		if ($this->GetLifetimeCirc())
		{
		   if (!$use_bib_data && strlen($curr_copy->GetLifetimeCircs()) > 0)
		   {
			   $html_file_data .= "<span class=\"label\">Lifetime Circs:</span><span class=\"circs\">".$curr_copy->GetLifetimeCircs()."</span>\n";
			}
			else if ($use_bib_data)
			{
			   $html_file_data .= "<span class=\"label\">Lifetime Circs:</span><span class=\"circs\">".$curr_bib->GetTotalCircs()."</span>\n";
			}
			if (!$this->GetWordPress()) $html_file_data .= "<br />";
		}


		//public note
		if ($this->GetPublicNote() && strlen($curr_copy->GetPublicNote("")) > 0 )
		{
			$html_file_data .= "<span class=\"label\">Public Note:</span><span class=\"public_note\">".$curr_copy->GetPublicNote(",")."</span>\n";
			if (!$this->GetWordPress()) $html_file_data .= "<br />";
		}

		//staff note
		if ($this->GetStaffNote() && strlen($curr_copy->GetStaffNote("")) > 0 )
		{
			$html_file_data .= "<span class=\"label\">Staff Note:</span><span class=\"staff_note\">".$curr_copy->GetStaffNote(",")."</span>\n";
			if (!$this->GetWordPress()) $html_file_data .= "<br />";
		}
		//stat cat
		if ($this->GetStatCat() && strlen($curr_copy->GetStatCats("")) > 0 )
		{
			$html_file_data .= "<span class=\"label\">Stat Cat:</span><span class=\"stat_cat\">".$curr_copy->GetStatCats(", ")."</span>\n";
			if (!$this->GetWordPress()) $html_file_data .= "<br />";
		}

		//ytd circs
		if ($this->GetYTDCircs())
		{
		   if (!$use_bib_data 	&& strlen($curr_copy->GetYTDCirc()) > 0 )
		   {
			   $html_file_data .= "<span class=\"label\">YTD Circs:</span><span class=\"ytd_circs\">".$curr_copy->GetYTDCirc()."</span>\n";
			}
			else if ($use_bob_data)
			{
			   $html_file_data .= "<span class=\"label\">YTD Circs:</span><span class=\"ytd_circs\">".$curr_bib->GetYTDCircs()."</span>\n";
			}
			if (!$this->GetWordPress()) $html_file_data .= "<br />";
		}

		//Amazon search
		if ($this->GetAmazonSearch())
		{
			 $html_file_data .="<a href=\"".$curr_bib->GetAmazonSearch()."\" class=\"amazon_link\"".$new_window.">View on Amazon</a>\n";
			 if (!$this->GetWordPress()) $html_file_data .= "<br />";
		}

		//amazon Direct
		if ($this->GetAmazonDirect())
		{
			$html_file_data .="<a href=\"".$curr_bib->GetAmazonDirect()."\" class=\"amazon_link\"".$new_window.">Search Title on Amazon</a>\n";
			if (!$this->GetWordPress()) $html_file_data .= "<br />";
		}


      return $html_file_data;
   }

   function WriteCopyTableBlock($curr_bib, $links_new_window)
   {
      $html_file_data="";

      if($links_new_window) $new_window = " target=\"_blank\" ";
      else $new_window = "";

	   if ($this->GetCoverImage() && strlen($curr_bib->GetCatalogLink()) > 0)
		{
			 $html_file_data .="<br /><div class=\"cover_div\"><a href=\"".$curr_bib->GetCatalogLink()."\"".$new_window."><img src =\"".$curr_bib->GetCoverImage($this->GetImageSize())."\" class=\"cover\" /></a></div>\n";
		}

		$html_file_data .="<div class=\"book_attr\">\n";

		//title
		if ($this->GetTitle() && strlen($curr_bib->GetTitle()) > 0)
		{
			$html_file_data .= "<a href=\"".$curr_bib->GetCatalogLink()."\" class=\"title\"".$new_window.">".$curr_bib->GetTitle()."</a>\n";
			if (!$this->GetWordPress()) $html_file_data .= "<br />";
		}

		//author
		if ($this->GetAuthor() && strlen($curr_bib->GetAuthor()) > 0)
		{
			$html_file_data .="<span class=\"author\">".$curr_bib->GetAuthor()."</span>\n";
			if (!$this->GetWordPress()) $html_file_data .= "<br />";
		}

		//publisher
		if ($this->GetPublisher() && $this->GetPubYear() && strlen($curr_bib->GetPublisher()) > 0 && strlen($curr_bib->GetPubYear()) > 0)
		{
			$html_file_data .="<span class=\"label\">Publisher:</span><span class=\"publisher\">".$curr_bib->GetPublisher()."</span>, ";
			$html_file_data .="<span class=\"pubdate\">".$curr_bib->GetPubYear()."</span>\n";
			if (!$this->GetWordPress()) $html_file_data .= "<br />";
		}
		else if ($this->GetPubYear() && strlen($curr_bib->GetPubYear()) > 0 )
		{
			$html_file_data .="<span class=\"label\">Publication Year:</span><span class=\"pubdate\">".$curr_bib->GetPubYear()."</span>\n";
			if (!$this->GetWordPress()) $html_file_data .= "<br />";
		}
		else if($this->GetPublisher() && strlen($curr_bib->GetPubYear()) > 0)
		{
			$html_file_data .="<span class=\"label\">Publisher:</span><span class=\"publisher\">".$curr_bib->GetPublisher()."</span>\n";
			if (!$this->GetWordPress()) $html_file_data .= "<br />";
		}

		//summary
		if ($this->GetSummary() && strlen($curr_bib->GetSummary()) > 0)
		{
			$html_file_data .="<span class=\"label\">Summary:</span><span class=\"description\">".$curr_bib->GetSummary()."</span>\n";
			if (!$this->GetWordPress()) $html_file_data .= "<br />";
		}

		//oclc number
		if ($this->GetOCLCNumber() && strlen($curr_bib->GetOCLCNumber()) > 0)
		{
			$html_file_data .="<span class=\"label\">OCLC Number:</span><span class=\"oclc\">".$curr_bib->GetOCLCNumber()."</span>\n";
			if (!$this->GetWordPress()) $html_file_data .= "<br />";
		}

		//isbn
		if ($this->GetISBN() && strlen($curr_bib->GetISBN("")) > 0)
		{
			$html_file_data .="<span class=\"label\">ISBN:</span><span class=\"isbn10\">".$curr_bib->GetISBN(", ")."</span>\n";
			if (!$this->GetWordPress()) $html_file_data .= "<br />";
		}

		//google books
		if ($this->GetGoogleBooks() && strlen($curr_bib->GetGoogleLink()) > 0)
		{
			$html_file_data .="<span class=\"google\">".$curr_bib->GetGoogleLink()."</span>\n";
			if (!$this->GetWordPress()) $html_file_data .= "<br />";
		}

		//goodreads
		if ($this->GetGoodreads() && strlen($curr_bib->GetGoodreadsLink()) > 0)
		{
			$html_file_data .="<a href=\"".$curr_bib->GetGoodreadsLink()."\" class=\"goodreads\"".$new_window.">View on Goodreads</a>\n";
			if (!$this->GetWordPress()) $html_file_data .= "<br />";
		}

		//novelist
		if ($this->GetNovelist() && strlen($curr_bib->GetNovelistLink()) > 0)
		{
			$html_file_data .="<a href=\"".$curr_bib->GetNovelist()."\" class=\"novelist\"".$new_window.">View on Novelist</a>\n";
			if (!$this->GetWordPress()) $html_file_data .= "<br />";
		}

		//bib id
		if ($this->GetBibId() && strlen($curr_bib->GetBibId()) > 0)
		{
			$html_file_data .="<span class=\"label\">Bib Id:</span><span class=\"bib_id\">".$curr_bib->GetBibId()."</span>\n";
			if (!$this->GetWordPress()) $html_file_data .= "<br />";
		}

		//Amazon search
		if ($this->GetAmazonSearch() && strlen($curr_bib->GetAmazonSearch()) > 0)
		{
			 $html_file_data .="<a href=\"".$curr_bib->GetAmazonSearch()."\" class=\"amazon_link\"".$new_window.">View on Amazon</a>\n";
			 if (!$this->GetWordPress()) $html_file_data .= "<br />";
		}

		//amazon Direct
		if ($this->GetAmazonDirect() && strlen($curr_bib->GetAmazonDirect()) > 0)
		{
			$html_file_data .="<a href=\"".$curr_bib->GetAmazonDirect()."\" class=\"amazon_link\"".$new_window.">Search Title on Amazon</a>\n";
			if (!$this->GetWordPress()) $html_file_data .= "<br />";
		}

		$html_file_data .="<div class=\"table_div\">";

		$html_file_data .= "<table class=\"copy_table\">\n";
		$html_file_data .= "<thead>\n";

		//circ library
		if ($this->GetCircLib())  $html_file_data .= "<th>Library</th>\n";

		//call number
		 if ($this->GetCallNumber())  $html_file_data .= "<th>Call Number</th>\n";

		//part
		if ($this->GetPart())  $html_file_data .= "<th>Part</th>\n";

		//copy location
		if ($this->GetCopyLocation())  $html_file_data .= "<th>Shelving Location</th>\n";

		//active date
		if ($this->GetActiveDate())  $html_file_data .= "<th>Active Date</th>\n";

		//age protection
		if ($this->GetAgeProtection())
		{
			$html_file_data .= "<th>Age Protection</th>\n";
			$html_file_data .= "<th>Age Protect Expire</th>\n";
		}

		//barcode
		if ($this->GetBarcode())  $html_file_data .= "<th>Barcode</th>\n";

		//circ modieier
		if ($this->GetCircModifier())  $html_file_data .= "<th>Circ Modifier</th>\n";

		//copy status
		if ($this->GetCopyStatus())  $html_file_data .= "<th>Status</th>\n";

		//status change date
		if ($this->GetStatChange())  $html_file_data .= "<th>Last Status Change</th>\n";

		//in house use
		if ($this->GetInHouseUse())
		{
			$html_file_data .= "<th>In House Count</th>\n";
			$html_file_data .= "<th>Last In House Use</th>\n";
		}

		//last checkin
		if ($this->GetLastCheckin())  $html_file_data .= "<th>Last Checkin</th>\n";

		//lifetime circs
		if ($this->GetLifetimeCirc())  $html_file_data .= "<th>Lifetime Circs</th>\n";

		//stat cat

		//public note
		if ($this->GetPublicNote())  $html_file_data .= "<th>Public Note</th>\n";

		//staff note
		if ($this->GetStaffNote())  $html_file_data .= "<th>Staff Note</th>\n";

		//stat cat
		if ($this->GetStatCat())  $html_file_data .= "<th>Stat Cats</th>\n";

		//ytd circs
		if ($this->GetYtdCircs())  $html_file_data .= "<th>Ytd Circs</th>\n";

		$html_file_data .="</thead><tbody>\n";

		//loop through the items
		//Loop through the copies and add copy info
		foreach ($curr_bib->lib_copies as $curr_library)
		{
			foreach($curr_library->copies as $curr_copy)
			{
				$html_file_data .= "<tr>\n";
				//circ library
				if ($this->GetCircLib())  $html_file_data .= "<td>".$curr_copy->GetCircLibName()."</td>\n";

				//call number
				 if ($this->GetCallNumber())  $html_file_data .= "<td>".$curr_copy->GetPrefix()." ".$curr_copy->GetCallNumber()." ".$curr_copy->GetSuffix()."</td>\n";

				//part
				if ($this->GetPart())  $html_file_data .= "<td>".$curr_copy->GetPart()."</td>\n";

				//copy location
				if ($this->GetCopyLocation())  $html_file_data .= "<td>".$curr_copy->GetCopyLocation()."</td>\n";

				//active date
				if ($this->GetActiveDate())  $html_file_data .= "<td>".$curr_copy->GetActiveDate()."</td>\n";

				//age protection
				if ($this->GetAgeProtection())
				{
					$html_file_data .= "<td>".$curr_copy->GetAgeProtect()."</td>\n";
					$html_file_data .= "<td>".$curr_copy->GetAgeProtectExpire()."</td>\n";
				}

				//barcode
				if ($this->GetBarcode())  $html_file_data .= "<td>".$curr_copy->GetBarcode()."</td>\n";

				//circ modieier
				if ($this->GetCircModifier())  $html_file_data .= "<td>".$curr_copy->GetCircMod()."</td>\n";

				//copy status
				if ($this->GetCopyStatus())  $html_file_data .= "<td>".$curr_copy->GetStatus()."</td>\n";

				//status change date
				if ($this->GetStatChange())  $html_file_data .= "<td>".$curr_copy->GetStatusChange()."</td>\n";


				//in house use
				if ($this->GetInHouseUse())
				{
					$html_file_data .= "<td>".$curr_copy->GetInHouseUse()."</td>\n";
					$html_file_data .= "<td>".$curr_copy->GetLastInHouseUse()."</td>\n";
				}

				//last checkin
				if ($this->GetLastCheckin())  $html_file_data .= "<td>".$curr_copy->GetLastCheckin()."</td>\n";

				//lifetime circs
				if ($this->GetLifetimeCirc())  $html_file_data .= "<td>".$curr_copy->GetLifetimeCircs()."</td>\n";

				//public note
				if ($this->GetPublicNote())  $html_file_data .= "<td>".$curr_copy->GetPublicNote(",")."</td>\n";

				//staff note
				if ($this->GetStaffNote())  $html_file_data .= "<td>".$curr_copy->GetStaffNote(",")."</td>\n";

				//stat cat
				if ($this->GetStatCat())  $html_file_data .= "<td>".$curr_copy->GetStatCats("<br />")."</td>\n";

				//ytd circs
				if ($this->GetYTDCircs())  $html_file_data .= "<td>".$curr_copy->GetYTDCirc()."</td>\n";

				$html_file_data .= "</tr>\n";
			}
		}

		$html_file_data .="</tbody></table></div>\n";

		return $html_file_data;

   }

   function WriteOnlineRecBlock($curr_bib, $links_new_window)
   {
      $html_file_data = "";

      if($links_new_window) $new_window = " target=\"_blank\" ";
      else $new_window = "";

		if ($this->GetCoverImage() && strlen($curr_bib->GetCatalogLink()) > 0)
		{
			 $html_file_data .="<br /><div class=\"cover_div\"><a href=\"".$curr_bib->GetCatalogLink()."\"".$new_window."><img src =\"".$curr_bib->GetCoverImage($this->GetImageSize())."\" class=\"cover\" /></a></div>\n";
		}

		$html_file_data .="<div class=\"book_attr\">\n";

		//author
		if ($this->GetAuthor() && strlen($curr_bib->GetAuthor()) > 0 )
		{
			$html_file_data .="<span class=\"author\">".$curr_bib->GetAuthor()."</span>\n";
			if (!$this->GetWordPress()) $html_file_data .= "<br />";
		}

		//title
		if ($this->GetTitle() && strlen($curr_bib->GetTitle()) > 0 )
		{
			$html_file_data .= "<a href=\"".$curr_bib->GetCatalogLink()."\" class=\"title\"".$new_window.">".$curr_bib->GetTitle()."</a>\n";
			if (!$this->GetWordPress()) $html_file_data .= "<br />";
		}

		//publisher
		if ($this->GetPublisher() && $this->GetPubYear() && strlen($curr_bib->GetPublisher()) > 0 && strlen($curr_bib->GetPubYear()) > 0)
		{
			$html_file_data .="<span class=\"label\">Publisher:</span><span class=\"publisher\">".$curr_bib->GetPublisher()."</span>, ";
			$html_file_data .="<span class=\"pubdate\">".$curr_bib->GetPubYear()."</span>\n";
			if (!$this->GetWordPress()) $html_file_data .= "<br />";
		}
		else if ($this->GetPubYear() && strlen($curr_bib->GetPubYear()) > 0)
		{
			$html_file_data .="<span class=\"label\">Publication Year:</span><span class=\"pubdate\">".$curr_bib->GetPubYear()."</span>\n";
			if (!$this->GetWordPress()) $html_file_data .= "<br />";
		}
		else if($this->GetPublisher() && strlen($curr_bib->GetPublisher()) > 0)
		{
			$html_file_data .="<span class=\"label\">Publisher:</span><span class=\"publisher\">".$curr_bib->GetPublisher()."</span>\n";
			if (!$this->GetWordPress()) $html_file_data .= "<br />";
		}

		//summary
		if ($this->GetSummary() && strlen($curr_bib->GetSummary()) > 0)
		{
			$html_file_data .="<span class=\"label\">Summary:</span><span class=\"description\">".$curr_bib->GetSummary()."</span>\n";
			if (!$this->GetWordPress()) $html_file_data .= "<br />";
		}

		//oclc number
		if ($this->GetOCLCNumber() && strlen($curr_bib->GetOCLCNumber()) > 0)
		{
			$html_file_data .="<span class=\"label\">OCLC Number:</span><span class=\"oclc\">".$curr_bib->GetOCLCNumber()."</span>\n";
			if (!$this->GetWordPress()) $html_file_data .= "<br />";
		}

		//isbn
		if ($this->GetISBN() && strlen($curr_bib->GetISBN("")) > 0)
		{
			$html_file_data .="<span class=\"label\">ISBN:</span><span class=\"isbn10\">".$curr_bib->GetISBN(", ")."</span>\n";
			if (!$this->GetWordPress()) $html_file_data .= "<br />";
		}

		//goodreads
		if ($this->GetGoodreads() && strlen($curr_bib->GetGoodreadsLink()) > 0)
		{
			$html_file_data .="<a href=\"".$curr_bib->GetGoodreadsLink()."\" class=\"goodreads\"".$new_window.">View on Goodreads</a>\n";
			if (!$this->GetWordPress()) $html_file_data .= "<br />";
		}

		//novelist
		if ($this->GetNovelist() && strlen($curr_bib->GetNovelistLink()) > 0)
		{
			$html_file_data .="<a href=\"".$curr_bib->GetNovelistLink()."\" class=\"novelist\"".$new_window.">View on Novelist</a>\n";
			if (!$this->GetWordPress()) $html_file_data .= "<br />";
		}

		//bib id
		if ($this->GetBibId() && strlen($curr_bib->GetBibId()) > 0)
		{
			$html_file_data .="<span class=\"label\">Bib Id:</span><span class=\"bib_id\">".$curr_bib->GetBibId()."</span>\n";
			if (!$this->GetWordPress()) $html_file_data .= "<br />";
		}

		//Amazon search
		if ($this->GetAmazonSearch())
		{
			 $html_file_data .="<a href=\"".$curr_bib->GetAmazonSearch()."\" class=\"amazon_link\"".$new_window.">View on Amazon</a>\n";
			 if (!$this->GetWordPress()) $html_file_data .= "<br />";
		}

		//amazon Direct
		if ($this->GetAmazonDirect())
		{
			$html_file_data .="<a href=\"".$curr_bib->GetAmazonDirect()."\" class=\"amazon_link\"".$new_window.">Search Title on Amazon</a>\n";
			if (!$this->GetWordPress()) $html_file_data .= "<br />";
		}


      return $html_file_data;
   }

   function WriteInlineLayout($bib_list)
   {
      $html_file_data ="";
      $width = $this->GetGridWidth();

      $html_file_data .="<ul>\n";

      if ($this->GetGroupCopies())
      {
			//this is true for the grouped copies
			foreach ($bib_list->multiple_copy_recs as $curr_bib)
			{
			   $html_file_data .= "<li>\n";
			   if ($this->author_sort)
			   {
			      if ($this->GetAuthor() && strlen($curr_bib->GetAuthor()) > 0 )
		         {
                  $html_file_data .="<span class=\"author\">".$curr_bib->GetAuthor()."</span>&nbsp;\n";
               }

			      if ($this->GetTitle() && strlen($curr_bib->GetTitle()) > 0 )
		         {
		            $html_file_data .= "<a href=\"".$curr_bib->GetCatalogLink()."\" class=\"title\">".$curr_bib->GetTitle()."</a>&nbsp;\n";
               }

               if ( $this->GetCallNumber() &&
		              ( strlen($curr_copy->GetCallNumber()) > 0 ||  strlen($curr_copy->GetPrefix()) > 0 ||  strlen($curr_copy->GetSuffix()) > 0  ) )
		         {
		            $html_file_data .= "<span class=\"call_num\">".$curr_copy->GetPrefix()." ".$curr_copy->GetCallNumber()." ".$curr_copy->GetSuffix()."</span>&nbsp;\n";
			      }
			   }
			   else if ($this->call_number_sort)
			   {
			      if ( $this->GetCallNumber() &&
		              ( strlen($curr_copy->GetCallNumber()) > 0 ||  strlen($curr_copy->GetPrefix()) > 0 ||  strlen($curr_copy->GetSuffix()) > 0  ) )
		         {
		            $html_file_data .= "<span class=\"call_num\">".$curr_copy->GetPrefix()." ".$curr_copy->GetCallNumber()." ".$curr_copy->GetSuffix()."</span>&nbsp;\n";
			      }

			      if ($this->GetAuthor() && strlen($curr_bib->GetAuthor()) > 0 )
		         {
                  $html_file_data .="<span class=\"author\">".$curr_bib->GetAuthor()."</span>&nbsp;\n";
               }

			      if ($this->GetTitle() && strlen($curr_bib->GetTitle()) > 0 )
		         {
		            $html_file_data .= "<a href=\"".$curr_bib->GetCatalogLink()."\" class=\"title\">".$curr_bib->GetTitle()."</a>&nbsp;\n";
               }

			   }
			   else if ($this->title_sort)
			   {
			      if ($this->GetTitle() && strlen($curr_bib->GetTitle()) > 0 )
		         {
		            $html_file_data .= "<a href=\"".$curr_bib->GetCatalogLink()."\" class=\"title\">".$curr_bib->GetTitle()."</a>&nbsp;\n";
               }

               if ($this->GetAuthor() && strlen($curr_bib->GetAuthor()) > 0 )
		         {
                  $html_file_data .="<span class=\"author\">".$curr_bib->GetAuthor()."</span>&nbsp;\n";
               }

               if ( $this->GetCallNumber() &&
		              ( strlen($curr_copy->GetCallNumber()) > 0 ||  strlen($curr_copy->GetPrefix()) > 0 ||  strlen($curr_copy->GetSuffix()) > 0  ) )
		         {
		            $html_file_data .= "<span class=\"call_num\">".$curr_copy->GetPrefix()." ".$curr_copy->GetCallNumber()." ".$curr_copy->GetSuffix()."</span>&nbsp;\n";
			      }
			   }
			   $html_file_data .="</li>\n";
			}
		}
		else
      {
			foreach ($bib_list->one_bib_one_copy_recs as $curr_lib)
			{
            $bibs = $curr_lib->bib_copy_list;

				foreach($bibs as $curr_bib)
            {
               $html_file_data .= "<li>\n";
					if ($this->author_sort)
					{
						if ($this->GetAuthor() && strlen($curr_bib->GetAuthor()) > 0 )
						{
							$html_file_data .="<span class=\"author\">".$curr_bib->GetAuthor()."</span>&nbsp;\n";
						}

						if ($this->GetTitle() && strlen($curr_bib->GetTitle()) > 0 )
						{
							$html_file_data .= "<a href=\"".$curr_bib->GetCatalogLink()."\" class=\"title\"".$new_window.">".$curr_bib->GetTitle()."</a>&nbsp;\n";
						}

						if ( $this->GetCallNumber() &&
							  ( strlen($curr_copy->GetCallNumber()) > 0 ||  strlen($curr_copy->GetPrefix()) > 0 ||  strlen($curr_copy->GetSuffix()) > 0  ) )
						{
							$html_file_data .= "<span class=\"call_num\">".$curr_copy->GetPrefix()." ".$curr_copy->GetCallNumber()." ".$curr_copy->GetSuffix()."</span>&nbsp;\n";
						}
					}
					else if ($this->call_number_sort)
					{
						if ( $this->GetCallNumber() &&
							  ( strlen($curr_copy->GetCallNumber()) > 0 ||  strlen($curr_copy->GetPrefix()) > 0 ||  strlen($curr_copy->GetSuffix()) > 0  ) )
						{
							$html_file_data .= "<span class=\"call_num\">".$curr_copy->GetPrefix()." ".$curr_copy->GetCallNumber()." ".$curr_copy->GetSuffix()."</span>&nbsp;\n";
						}

						if ($this->GetAuthor() && strlen($curr_bib->GetAuthor()) > 0 )
						{
							$html_file_data .="<span class=\"author\">".$curr_bib->GetAuthor()."</span>&nbsp;\n";
						}

						if ($this->GetTitle() && strlen($curr_bib->GetTitle()) > 0 )
						{
							$html_file_data .= "<a href=\"".$curr_bib->GetCatalogLink()."\" class=\"title\"".$new_window.">".$curr_bib->GetTitle()."</a>&nbsp;\n";
						}

					}
					else if ($this->title_sort)
					{
						if ($this->GetTitle() && strlen($curr_bib->GetTitle()) > 0 )
						{
							$html_file_data .= "<a href=\"".$curr_bib->GetCatalogLink()."\" class=\"title\"".$new_window.">".$curr_bib->GetTitle()."</a>&nbsp;\n";
						}

						if ($this->GetAuthor() && strlen($curr_bib->GetAuthor()) > 0 )
						{
							$html_file_data .="<span class=\"author\">".$curr_bib->GetAuthor()."</span>&nbsp;\n";
						}

						if ( $this->GetCallNumber() &&
							  ( strlen($curr_copy->GetCallNumber()) > 0 ||  strlen($curr_copy->GetPrefix()) > 0 ||  strlen($curr_copy->GetSuffix()) > 0  ) )
						{
							$html_file_data .= "<span class=\"call_num\">".$curr_copy->GetPrefix()." ".$curr_copy->GetCallNumber()." ".$curr_copy->GetSuffix()."</span>&nbsp;\n";
						}
					}
					$html_file_data .="</li>\n";
            }
         }
      }

      if ($bib_list->HasOnlineRecs())
      {
         foreach ($bib_list->online_recs as $curr_bib)
			{
			   $html_file_data .= "<li>\n";
				if ($this->author_sort)
				{
					if ($this->GetAuthor() && strlen($curr_bib->GetAuthor()) > 0 )
					{
						$html_file_data .="<span class=\"author\">".$curr_bib->GetAuthor()."</span>&nbsp;\n";
					}

					if ($this->GetTitle() && strlen($curr_bib->GetTitle()) > 0 )
					{
						$html_file_data .= "<a href=\"".$curr_bib->GetCatalogLink()."\" class=\"title\"".$new_window.">".$curr_bib->GetTitle()."</a>&nbsp;\n";
					}

					if ( $this->GetCallNumber() &&
						  ( strlen($curr_copy->GetCallNumber()) > 0 ||  strlen($curr_copy->GetPrefix()) > 0 ||  strlen($curr_copy->GetSuffix()) > 0  ) )
					{
						$html_file_data .= "<span class=\"call_num\">".$curr_copy->GetPrefix()." ".$curr_copy->GetCallNumber()." ".$curr_copy->GetSuffix()."</span>&nbsp;\n";
					}
				}
				else if ($this->call_number_sort)
				{
					if ( $this->GetCallNumber() &&
						  ( strlen($curr_copy->GetCallNumber()) > 0 ||  strlen($curr_copy->GetPrefix()) > 0 ||  strlen($curr_copy->GetSuffix()) > 0  ) )
					{
						$html_file_data .= "<span class=\"call_num\">".$curr_copy->GetPrefix()." ".$curr_copy->GetCallNumber()." ".$curr_copy->GetSuffix()."</span>&nbsp;\n";
					}

					if ($this->GetAuthor() && strlen($curr_bib->GetAuthor()) > 0 )
					{
						$html_file_data .="<span class=\"author\">".$curr_bib->GetAuthor()."</span>&nbsp;\n";
					}

					if ($this->GetTitle() && strlen($curr_bib->GetTitle()) > 0 )
					{
						$html_file_data .= "<a href=\"".$curr_bib->GetCatalogLink()."\" class=\"title\"".$new_window.">".$curr_bib->GetTitle()."</a>&nbsp;\n";
					}

				}
				else if ($this->title_sort)
				{
					if ($this->GetTitle() && strlen($curr_bib->GetTitle()) > 0 )
					{
						$html_file_data .= "<a href=\"".$curr_bib->GetCatalogLink()."\" class=\"title\"".$new_window.">".$curr_bib->GetTitle()."</a>&nbsp;\n";
					}

					if ($this->GetAuthor() && strlen($curr_bib->GetAuthor()) > 0 )
					{
						$html_file_data .="<span class=\"author\">".$curr_bib->GetAuthor()."</span>&nbsp;\n";
					}

					if ( $this->GetCallNumber() &&
						  ( strlen($curr_copy->GetCallNumber()) > 0 ||  strlen($curr_copy->GetPrefix()) > 0 ||  strlen($curr_copy->GetSuffix()) > 0  ) )
					{
						$html_file_data .= "<span class=\"call_num\">".$curr_copy->GetPrefix()." ".$curr_copy->GetCallNumber()." ".$curr_copy->GetSuffix()."</span>&nbsp;\n";
					}
				}
				$html_file_data .="</li>\n";
			}
      }

      $html_file_data .="</ul>\n";

      return $html_file_data;
   }

   function WriteGridLayout($bib_list, $links_new_window)
   {
      $html_file_data ="";
      $width = $this->GetGridWidth();

      if($links_new_window) $new_window = " target=\"_blank\" ";
      else $new_window = "";

      $html_file_data .="<table class=\"cover_grid\"><tbody>\n";
      $count = 0;

      if ($this->GetGroupCopies())
      {
			//this is true for the grouped copies
			foreach ($bib_list->multiple_copy_recs as $curr_bib)
			{
			   if ( $count == 0 || ($count % $width) == 0 ) $html_file_data .= "<tr>\n";

			   $title = str_replace("\"", "&quot;", $curr_bib->GetTitle());//do this to prevent any issues with comments
			   $html_file_data .="<td>\n";
            $html_file_data .="<a href=\"".$curr_bib->GetCatalogLink()."\"".$new_window."><img src =\"".$curr_bib->GetCoverImage($this->GetImageSize())."\" class=\"cover\" title=\"".$title."\" /></a>\n";
			   $html_file_data .="</td>\n";

			   if ($count > 0 &&  (($count % $width) == ($width-1))) $html_file_data .= "</tr>\n";

			   $count++;

			}
		}
		else
      {
			foreach ($bib_list->one_bib_one_copy_recs as $curr_lib)
			{
				$bibs = $curr_lib->bib_copy_list;

				foreach($bibs as $curr_bib)
            {
               if ( $count == 0 || ($count % $width) == 0 ) $html_file_data .= "<tr>\n";

			      $title = str_replace("\"", "&quot;", $curr_bib->GetTitle());//do this to prevent any issues with comments
			      $html_file_data .="<td>\n";
               $html_file_data .="<a href=\"".$curr_bib->GetCatalogLink()."\"".$new_window."><img src =\"".$curr_bib->GetCoverImage($this->GetImageSize())."\" class=\"cover\" title=\"".$title."\" /></a>\n";
			      $html_file_data .="</td>\n";

			      if ($count > 0 &&  (($count % $width) == ($width-1))) $html_file_data .= "</tr>\n";

			      $count++;
            }
         }
      }

      if ($bib_list->HasOnlineRecs())
      {
         foreach ($bib_list->online_recs as $curr_bib)
			{
			   if ( $count == 0 || ($count % $width) == 0 ) $html_file_data .= "<tr>\n";

			   $title = str_replace("\"", "&quot;", $curr_bib->GetTitle());//do this to prevent any issues with comments
			   $html_file_data .="<td>\n";
            $html_file_data .="<a href=\"".$curr_bib->GetCatalogLink()."\"".$new_window."><img src =\"".$curr_bib->GetCoverImage($this->GetImageSize())."\" class=\"cover\" title=\"".$title."\" /></a>\n";
			   $html_file_data .="</td>\n";

			   if ($count > 0 &&  (($count % $width) == ($width-1))) $html_file_data .= "</tr>\n";

			   $count++;

			}
      }

      $html_file_data .="</tbody></table>\n";

      return $html_file_data;
   }

   function WriteSliderLayout($bib_list, $links_new_window)
   {
      $html_file_data ="";

      if($links_new_window) $new_window = " target=\"_blank\" ";
      else $new_window = "";

      $html_file_data .="<div class=\"slider\">\n";

      if ($this->GetGroupCopies())
      {
			//this is true for the grouped copies
			foreach ($bib_list->multiple_copy_recs as $curr_bib)
			{
			   $title = str_replace("\"", "&quot;", $curr_bib->GetTitle());//do this to prevent any issues with comments
            $html_file_data .="<div><a href=\"".$curr_bib->GetCatalogLink()."\"".$new_window."><img src =\"".$curr_bib->GetCoverImage($this->GetImageSize())."\" class=\"cover\" title=\"".$title."\" /></a></div>\n";
			}
		}
		else
      {
			foreach ($bib_list->one_bib_one_copy_recs as $curr_lib)
			{
				$bibs = $curr_lib->bib_copy_list;

				foreach($bibs as $curr_bib)
            {
               $title = str_replace("\"", "&quot;", $curr_bib->GetTitle());//do this to prevent any issues with comments
               $html_file_data .="<div><a href=\"".$curr_bib->GetCatalogLink()."\"".$new_window."><img src =\"".$curr_bib->GetCoverImage($this->GetImageSize())."\" class=\"cover\" title=\"".$title."\" /></a></div>\n";
            }
         }
      }

      if ($bib_list->HasOnlineRecs())
      {
         foreach ($bib_list->online_recs as $curr_bib)
			{
            $title = str_replace("\"", "&quot;", $curr_bib->GetTitle());//do this to prevent any issues with comments
            $html_file_data .="<div><a href=\"".$curr_bib->GetCatalogLink()."\"".$new_window."><img src =\"".$curr_bib->GetCoverImage($this->GetImageSize())."\" class=\"cover\" title=\"".$title."\" /></a></div>\n";
			}
      }

      $html_file_data .="\n</div>\n";

      return $html_file_data;
   }

   function GetEmailText($include_link)
   {
       $message = "HTML OUTPUT\n";

       if ($this->GetAuthorSort())$message .="Sorted By = Author \n";
       else if ($this->GetActiveDateSort())$message .="Sorted By = Active Date \n";
       else if ($this->GetCallNumSort())$message .="Sorted By = Call Number \n";
       else if ($this->GetLifetimeCircSort())$message .="Sorted By = Lifetime Circs \n";
       else if ($this->GetTitleSort())$message .="Sorted By = Title \n";
       else if ($this->GetYTDCircSort())$message .="Sorted By = YTD Circs \n";

       if ($this->GetBlockLayout())$message .="Layout = Block\n";
       if ($this->GetInlineLayout())$message .="Layout = Inline\n";
       if ($this->GetGridLayout())$message .="Layout = Grid Width ".$this->GetGridWidth()."\n";
       if ($this->GetSliderLayout())$message .="Layout = Slider \n";

       if ($this->GetGroupCopies())
       {
          if ($this->show_first_copy) $message .="Group Items First\n";
          else if ($this->show_all_copies) $message .="Group Items All\n";
       }

       if ($this->GetImageSize()) $message .="Image Size ".ucwords($this->GetImageSize())."\n";
       if ($this->GetWordPress())$message .="WordPress\n";
       if ($this->GetSaveHTML()) $message .="Embeddable HMTL\n";

       $message .="Display Options \n";

       if ( $this->GetAuthor() )        $message .=" -- Author\n";
       if ( $this->GetCoverImage() )    $message .=" -- Cover Image\n";
       if ( $this->GetTitle() )         $message .=" -- Title\n";
       if ( $this->GetPart() )          $message .=" -- Part\n";

       if ( $this->GetActiveDate() )    $message .=" -- Active Date\n";
       if ( $this->GetAgeProtection() ) $message .=" -- Age Protection\n";
       if ( $this->GetAmazonDirect() )  $message .=" -- Amazon Direct\n";
       if ( $this->GetAmazonSearch() )  $message .=" -- Amazon Search\n";
       if ( $this->GetBarcode() )       $message .=" -- Barcode\n";
       if ( $this->GetBibId() )         $message .=" -- Bib Id\n";
       if ( $this->GetCallNumber() )    $message .=" -- Call Number\n";
       if ( $this->GetCircModifier() )  $message .=" -- Circ Modifier\n";
       if ( $this->GetCircLib() )       $message .=" -- Circ Library\n";
       if ( $this->GetCopyLocation() )  $message .=" -- Shelving Location\n";
       if ( $this->GetCopyStatus() )    $message .=" -- Item Status\n";
       if ( $this->GetStatChange() )    $message .=" -- Last Status Change\n";
       if ( $this->GetGoogleBooks() )   $message .=" -- Google Books Link\n";
       if ( $this->GetInHouseUse() )    $message .=" -- In House Use\n";
       if ( $this->GetISBN() )          $message .=" -- ISBN\n";
       if ( $this->GetLastCheckin() )   $message .=" -- Last Checkin\n";
       if ( $this->GetLifetimeCirc() )  $message .=" -- Lifetime Circs\n";
       if ( $this->GetOCLCNumber() )    $message .=" -- OCLC Number\n";
       if ( $this->GetPubYear() )       $message .=" -- Pub Year\n";
       if ( $this->GetPublicNote() )    $message .=" -- Public Note\n";
       if ( $this->GetPublisher() )     $message .=" -- Publisher\n";
       if ( $this->GetStaffNote() )     $message .=" -- Staff Note\n";
       if ( $this->GetStatCat() )       $message .=" -- Stat Cats\n";
       if ( $this->GetSummary() )       $message .=" -- Summary\n";
       if ( $this->GetYTDCircs() )      $message .=" -- YTD Circs\n";

       if ($include_link)
       {
          if ($this->save_html)
          {
             //for each filename
             foreach($this->output_filenames as $file)
             {
                $message .= "Embeddable HTML Link ".$file."\n\n";
             }
          }
          else
          {
             //for eac file name
             foreach($this->output_filenames as $file)
             {
                $message .= "Download HTML ".$file."\n\n";
             }
          }
       }

       $message .="WEBMASTER NOTE: http://tools.noblenet.org/css/booklist.css must be added to your website to allow for correct formatting. \n Please see http://www.noblenet.org/sis/evergreen/tools/listmaker/htmlfiles/ for further instructions.\n";

       return $message;

   }

   function GetPreviewText()
   {
       $message = "OUTPUT<br/>";

       if ($this->GetAuthorSort())$message .="Sorted By = Author <br/>";
       else if ($this->GetActiveDateSort())$message .="Sorted By = Active Date <br/>";
       else if ($this->GetCallNumSort())$message .="Sorted By = Call Number <br/>";
       else if ($this->GetTitleSort())$message .="Sorted By = Title <br/>";

       if ($this->GetBlockLayout())$message .="Layout = Block<br/>";
       else if ($this->GetInlineLayout())$message .="Format = Inline<br/>";
       else if ($this->GetGridLayout())$message .="Format = Grid Width=".$this->GetGridWidth()."<br/>";

       if ($this->GetGroupCopies())
       {
          if ($this->show_first_copy) $message .="Group Items First<br/>";
          else if ($this->show_all_copies) $message .="Group Items All<br/>";
       }

       if ($this->GetImageSize()) $message .="Image Size ".ucwords($this->GetImageSize())."<br/>";

       $message .="Display Options <br/>";

       if ( $this->GetAuthor() )        $message .=" -- Author<br/>";
       if ( $this->GetCoverImage() )    $message .=" -- Cover Image<br/>";
       if ( $this->GetTitle() )         $message .=" -- Title<br/>";
       if ( $this->GetPart() )          $message .=" -- Part<br/>";

       if ( $this->GetActiveDate() )    $message .=" -- Active Date<br/>";
       if ( $this->GetAgeProtection() ) $message .=" -- Age Protection<br/>";
       if ( $this->GetAmazonDirect() )  $message .=" -- Amazon Direct<br/>";
       if ( $this->GetAmazonSearch() )  $message .=" -- Amazon Search<br/>";
       if ( $this->GetBarcode() )       $message .=" -- Barcode<br/>";
       if ( $this->GetBibId() )         $message .=" -- Bib Id<br/>";
       if ( $this->GetCallNumber() )    $message .=" -- Call Number<br/>";
       if ( $this->GetCircModifier() )  $message .=" -- Circ Modifier<br/>";
       if ( $this->GetCircLib() )       $message .=" -- Circ Library<br/>";
       if ( $this->GetCopyLocation() )  $message .=" -- Shelving Location<br/>";
       if ( $this->GetCopyStatus() )    $message .=" -- Item Status<br/>";
       if ( $this->GetStatChange() )    $message .=" -- Last Status Change<br/>";
       if ( $this->GetGoogleBooks() )   $message .=" -- Google Books Link<br/>";
       if ( $this->GetPubYear() )       $message .=" -- Pub Year<br/>";
       if ( $this->GetPublisher() )     $message .=" -- Publisher<br/>";
       if ( $this->GetStatCat() )       $message .=" -- Stat Cats<br/>";
       if ( $this->GetSummary() )       $message .=" -- Summary<br/>";

       return $message;

   }

   function GetHTMLText()
   {
       $html_out ="<div class=\"output_block\">";
       $html_out .= "<h3>HTML</h3>";

       $html_out .= "<div class=\"out_params\">";

       if ($this->GetAuthorSort())$html_out .="Sorted By: Author <br />";
       else if ($this->GetActiveDateSort())$html_out .="Sorted By: Active Date <br />";
       else if ($this->GetCallNumSort())$html_out .="Sorted By: Call Number <br />";
       else if ($this->GetLifetimeCircSort())$html_out .="Sorted By: Lifetime Circs <br />";
       else if ($this->GetTitleSort())$html_out .="Sorted By: Title <br />";
       else if ($this->GetYTDCircSort())$html_out .="Sorted By: YTD Circs <br />";

       if ($this->GetBlockLayout())$html_out .="Layout: Block<br />";
       else if ($this->GetInlineLayout())$html_out .="Format: Inline<br />";
       else if ($this->GetGridLayout())$html_out .="Format: Grid Width ".$this->GetGridWidth()."<br />";

       if ($this->GetGroupCopies())
       {
          if ($this->show_first_copy) $html_out .="Group Items First<br />";
          else if ($this->show_all_copies) $html_out .="Group Items All<br />";
       }

       if ($this->GetImageSize()) $html_out .="Image Size: ".ucwords($this->GetImageSize())."<br />";
       if ($this->GetWordPress())$html_out .="WordPress<br />";
       if ($this->GetSaveHTML()) $html_out .="Embeddable HMTL<br />";

       $html_out .="</div>";

       $html_out .= "<div class=\"display_params\">";
       $html_out .= "<span class=\"display_text\">Display Options:</span>";
       $html_out .= "<ul>";
       if ( $this->GetAuthor() )        $html_out .="<li>Author</li>";
       if ( $this->GetCoverImage() )    $html_out .="<li>Cover Image</li>";
       if ( $this->GetTitle() )         $html_out .="<li>Title</li>";
       if ( $this->GetPart() )          $html_out .="<li>Part</li>";

       if ( $this->GetActiveDate() )    $html_out .="<li>Active Date</li>";
       if ( $this->GetAgeProtection() ) $html_out .="<li>Age Protection</li>";
       if ( $this->GetAmazonDirect() )  $html_out .="<li>Amazon Direct</li>";
       if ( $this->GetAmazonSearch() )  $html_out .="<li>Amazon Search</li>";
       if ( $this->GetBarcode() )       $html_out .="<li>Barcode</li>";
       if ( $this->GetBibId() )         $html_out .="<li>Bib Id</li>";
       if ( $this->GetCallNumber() )    $html_out .="<li>Call Number</li>";
       if ( $this->GetCircModifier() )  $html_out .="<li>Circ Modifier</li>";
       if ( $this->GetCircLib() )       $html_out .="<li>Circ Library</li>";
       if ( $this->GetCopyLocation() )  $html_out .="<li>Shelving Location</li>";
       if ( $this->GetCopyStatus() )    $html_out .="<li>Item Status</li>";
       if ( $this->GetStatChange() )    $html_out .="<li>Last Status Change</li>";
       if ( $this->GetGoogleBooks() )   $html_out .="<li>Google Books Link</li>";
       if ( $this->GetInHouseUse() )    $html_out .="<li>In House Use</li>";
       if ( $this->GetISBN() )          $html_out .="<li>ISBN</li>";
       if ( $this->GetLastCheckin() )   $html_out .="<li>Last Checkin</li>";
       if ( $this->GetLifetimeCirc() )  $html_out .="<li>Lifetime Circs</li>";
       if ( $this->GetOCLCNumber() )    $html_out .="<li>OCLC Number</li>";
       if ( $this->GetPubYear() )       $html_out .="<li>Pub Year</li>";
       if ( $this->GetPublicNote() )    $html_out .="<li>Public Note</li>";
       if ( $this->GetPublisher() )     $html_out .="<li>Publisher</li>";
       if ( $this->GetStaffNote() )     $html_out .="<li>Staff Note</li>";
       if ( $this->GetStatCat() )       $html_out .="<li>Stat Cats</li>";
       if ( $this->GetSummary() )       $html_out .="<li>Summary</li>";
       if ( $this->GetYTDCircs() )      $html_out .="<li>YTD Circs</li>";

      $html_out .= "</ul>";
      $html_out .="</div></div>";
      return $html_out;

   }


}


?>