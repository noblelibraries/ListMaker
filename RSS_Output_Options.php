<?php

class RSS_Output_Options
{
   //need for the RSS file
   public $list_name;
   public $description;

   public $output_filename;

   function __construct()
   {
      $this->output_filename = "";
      $this->list_name = "";
      $this->description = "";
   }

   function SetListName($name)
   {
      $this->list_name = $name;
   }

   function GetListName()
   {
      return $this->list_name;
   }

   function SetDescription($val)
   {
      $this->description = $val;
   }

   function GetDescription()
   {
      return $this->description;
   }

   function SortRSSListByTitle($bib_list)
   {
      $bib_list->SortByTitle("multiple");
   }

   function WriteRSS($bib_list, $relative_file_name)
   {
      $write_filename = "/var/www/tools/reports/".$relative_file_name.".xml";

      $this->output_filename = "http://tools.noblenet.org/reports/".$relative_file_name.".xml";

      $rss_file_data ="<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
      $rss_file_data .="<rss version=\"2.0\">\n";
      $rss_file_data .="<channel>\n";
      $rss_file_data .= "<title>".$this->GetListName()."</title>\n";
      $rss_file_data .= "<link>http://www.example.com/</link>";
      $rss_file_data .= "<description>".$this->GetDescription()."</description>\n";
      $rss_file_data .= "<lastBuildDate>".date(DATE_RFC2822)."</lastBuildDate>\n";
      $rss_file_data .= "<language>en-us</language>\n";

      foreach ($bib_list->multiple_copy_recs as $curr_bib)
      {
         $rss_file_data .="<item>\n";

			//title
			$rss_file_data .= "<title>".htmlentities($curr_bib->GetTitle())."</title>\n";
			$rss_file_data .= "<link>".$curr_bib->GetCatalogLink()."</link>\n";
			$rss_file_data .= "<guid>".$curr_bib->GetCatalogLink()."</guid>\n";

			//summary
			if (strlen($curr_bib->GetSummary()) > 0)
			{
				$rss_file_data .="<description>".htmlspecialchars($curr_bib->GetSummary())."</description>\n";
			}

         $rss_file_data .="</item>\n";
      }

       $rss_file_data .= "</channel>\n";
       $rss_file_data .="</rss>\n";

      echo "Writing HTML Report  -- ".$write_filename."\n";
      file_put_contents($write_filename, $rss_file_data);
      chgrp ($write_filename, "www-data");
   }

   function GetEmailText($include_link)
   {
       $message = "RSS OUTPUT\n";

       $message .="Options \n";

       $message .="List Name: ".$this->GetListName()."\n";
       $message .="Description: ".$this->GetDescription()."\n";


       if ($include_link)
       {
          $message .= "Download HTML ".$this->output_filename."\n\n";
       }

       return $message;
   }

   function GetHTMLText()
   {
       $rss_out ="<div class=\"output_block\">";
       $rss_out .= "<h3>RSS</h3>";

       $rss_out .= "<div class=\"rss_params\">";

       $rss_out .="List Name: ".$this->GetListName()."<br />";
       $rss_out .="Description: ".$this->GetDescription()."<br/>";


       $rss_out .="</div></div>";
       return $rss_out;

   }

   function GetReportLinkText()
   {
      $report_link = "rss*";
      $report_link .= "rss_list*".urlencode(str_replace("\"","",$this->GetListName()))."*";
      $report_link .= "rss_desc*".urlencode(str_replace("\"","",$this->GetDescription()))."*";

      return $report_link;
   }

}


?>