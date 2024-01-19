<?php

class JSON_Output_Options
{
   public $wp_bookshelf_format; // [["ISBN","TItle","Author"],["ISBN","TItle","Author"]]
   public $use_isbn;
   public $use_bib;

   function __construct()
   {
      $this->wp_bookself_format = true;
      $this->use_isbn = false;
      $this->use_bib = false;
   }

   function SetJSONFormat() //currently only one format option
   {
      $this->wp_bookself_format = true;
   }

   function SetUseBib()
   {
      $this->use_bib = true;
   }

   function SetUseISBN()
   {
      $this->use_isbn = true;
   }

   function GetJSONFormat()
   {
      return $this->wp_bookself_format;
   }

   function WriteJSON($bib_list, $relative_file_name)
   {
      //make a new bookbag with name and description created by list maker
      //save the bookbag id

      $write_filename = "/var/www/tools/wp_bookshelf/".$relative_file_name.".txt";
      $this->output_filename = "http://tools.noblenet.org/wp_bookshelf/".$relative_file_name.".txt";

      $output_data ="[";

		foreach ($bib_list->multiple_copy_recs as $curr_bib)
		{
			//Put all the bib ids into the bookbag

			if($this->use_bib)$output_data .= "[\"".$curr_bib->GetBibId()."\",";
			else if ($this->use_isbn) $output_data .= "[\"".$curr_bib->GetOneISBN()."\",";
			$output_data .= "\"".str_replace('"', '\"',$curr_bib->GetTitle())."\",";
			$output_data .= "\"".$curr_bib->GetAuthor()."\"],";

		}

		if ($bib_list->HasOnlineRecs())
		{
			foreach ($bib_list->online_recs  as $curr_bib)
			{
				//Put all the bib ids into the bucket
                if($this->use_bib)$output_data .= "[\"".$curr_bib->GetBibId()."\",";
			    else if ($this->use_isbn) $output_data .= "[\"".$curr_bib->GetOneISBN()."\",";
			    $output_data .= "\"".str_replace('"', '\"',$curr_bib->GetTitle())."\",";
			    $output_data .= "\"".$curr_bib->GetAuthor()."\"],";
			}
		}

		$output_data = substr($output_data, 0, -1);
		$output_data .="]";

		file_put_contents($write_filename, $output_data);
		chgrp($write_filename, "www-data");

   }

   function GetEmailText()
   {
       $message = "JSON OUTPUT\n";

       $message .="Options \n";

       if($this->use_bib)  $message .=" -- Use Bib id \n";
       else if ($this->use_isbn) $message .=" -- Use ISBN \n";

       $message .="File Name: ".$this->output_filename."\n";

       return $message;
   }

   function GetHTMLText()
   {
       $out ="<div class=\"output_block\">";
       $out .= "<h3>JSON</h3>";

       $out .= "<div class=\"bookbag_params\">";

      if($this->use_bib)  $out .=" -- Use Bib id \n";
       else if ($this->use_isbn) $out .=" -- Use ISBN \n";

       $out .="</div></div>";
       return $out;
   }

   function GetReportLinkText()
   {
      return $report_link;
   }

}


?>