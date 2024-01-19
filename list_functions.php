<?php

function GetFiscalStart($fy)
{
   $start = "7/1";

   $first_of_year = date('d-m-Y', strtotime(date($fy.'-1-1')));

   $year = date("Y", strtotime($first_of_year."-1 year"));

   $start_string = $start."/".$year;

   $fystart = date("Y-m-d", strtotime($start_string));

   return $fystart;
}

function GetFiscalEnd($fy)
{
   $end = "6/30";

   $first_of_year = date('d-m-Y', strtotime(date($fy.'-1-1')));

   $year = date("Y", strtotime($first_of_year));

   $end_string = $end."/".$year;

   $fyend = date("Y-m-d", strtotime($end_string));

   return $fyend;
}

function CalculateFiscalYear()
{
   $fyStart = "7/1";
   $fyEnd = "6/30";

   $date = strtotime( date("Y-m-d") );
   $inputyear = strftime('%Y',$date);

   $fystartdate = strtotime($fyStart.$inputyear);
   $fyenddate = strtotime($fyEnd.$inputyear);

   if($date < $fyenddate)
   {
       $fy = intval($inputyear);
   }
   else
   {
       $fy = intval(intval($inputyear) + 1);
   }

   return $fy;
}

function FindDomain($lib_name)
{
   switch($lib_name)
   {
      case "BEVERLY":
      {
         $domain ="beverly";
         break;
      }
      case "BEB":
      {
         $domain ="beverly";
         break;
      }
      case "BEF":
      {
         $domain ="beverly";
         break;
      }
      case "BEV":
      {
         $domain ="beverly";
         break;
      }
      case "BOARD":
      {
         $domain ="board";
         break;
      }
      case "BUNKERHILL":
      {
         $domain ="bunkerhill";
         break;
      }
      case "DANVERS":
      {
         $domain ="danvers";
         break;
      }
      case "ENDICOTT":
      {
         $domain ="endicott";
         break;
      }
      case "EVERETT":
      {
         $domain ="everett";
         break;
      }
      case "EVP":
      {
         $domain ="everett";
         break;
      }
      case "EVS":
      {
         $domain ="everett";
         break;
      }
      case "GLOUCESTER":
      {
         $domain ="gloucester";
         break;
      }
      case "GORDON":
      {
         $domain ="gordon";
         break;
      }
      case "LYNN":
      {
         $domain ="lynn";
         break;
      }
      case "LYNNFIELD":
      {
         $domain ="lynnfield";
         break;
      }
      case "MARBLEHEAD":
      {
         $domain ="marblehead";
         break;
      }
      case "MELROSE":
      {
         $domain ="melrose";
         break;
      }
      case "MERRIMACK":
      {
         $domain ="merrimack";
         break;
      }
      case "MONTESERRAT":
      {
         $domain ="montserrat";
         break;
      }
      case "NOBLE":
      {
         $domain ="evergreen";
         break;
      }
      case "PEABODY":
      {
         $domain ="peabody";
         break;
      }
     case "PEA":
     {
         $domain ="peabody";
         break;
      }
     case "PES":
      {
         $domain ="peabody";
         break;
      }
      case "PEW":
      {
         $domain ="peabody";
         break;
      }
      case "PHILLIPS":
      {
         $domain ="phillips";
         break;
      }
      case "PANA":
      {
         $domain ="phillips";
         break;
      }
      case "PANB":
      {
         $domain ="phillips";
         break;
      }
      case "PANC":
      {
         $domain ="PANG";
         break;
      }
      case "PANG":
      {
         $domain ="phillips";
         break;
      }
      case "PANI":
      {
         $domain ="phillips";
         break;
      }
      case "PANK":
      {
         $domain ="phillips";
         break;
      }
      case "PANO":
      {
         $domain ="phillips";
         break;
      }
      case "PANP":
      {
         $domain ="phillips";
        break;
      }
      case "READING":
      {
         $domain ="reading";
         break;
      }
      case "REVERE":
      {
         $domain ="revere";
         break;
      }
      case "SALEM":
      {
         $domain ="salem";
         break;
      }
      case "SALEMSTATE":
      {
         $domain ="salemstate";
         break;
      }
      case "SAUGUS":
      {
         $domain ="saugus";
         break;
      }
      case "STONEHAM":
      {
         $domain ="stoneham";
         break;
      }
      case "SWAMPSCOTT":
      {
         $domain ="swampscott";
         break;
      }
      case "WAKEFIELD":
      {
         $domain ="wakefield";
         break;
      }
      case "WINTHROP":
      {
         $domain ="winthrop";
         break;
      }
      default:
      {
         $domain ="evergreen";
         break;
      }
   }

   return $domain;
}

function FindScope($lib_name)
{
   switch($lib_name)
   {
      case "BEVERLY":
      {
         $locg=2;
         break;
      }
      case "BEB":
      {
         $locg=3;
         break;
      }
      case "BEF":
      {
         $locg=4;
         break;
      }
      case "BEV":
      {
         $locg=5;
         break;
      }
      case "BOARD":
      {
         $locg=9;
         break;
      }
      case "BUNKERHILL":
      {
         $locg=7;
         break;
      }
      case "DANVERS":
      {
         $locg=11;
         break;
      }
      case "ENDICOTT":
      {
         $locg=13;
         break;
      }
      case "EVERETT":
      {
         $locg=14;
         break;
      }
      case "EVP":
      {
         $locg=15;
         break;
      }
      case "EVS":
      {
         $locg=16;
         break;
      }
      case "GLOUCESTER":
      {
         $locg=18;
         break;
      }
      case "GORDON":
      {
         $locg=20;
         break;
      }
      case "LYNN":
      {
         $locg=24;
         break;
      }
      case "LYNNFIELD":
      {
         $locg=22;
         break;
      }
      case "MARBLEHEAD":
      {
         $locg=26;
         break;
      }
      case "MELROSE":
      {
         $locg=28;
         break;
      }
      case "MERRIMACK":
      {
         $locg=30;
         break;
      }
      case "MONTESERRAT":
      {
         $locg=35;
         break;
      }
      case "NOBLE":
      {
         $locg=1;
         break;
      }
      case "PEABODY":
      {
         $locg=45;
         break;
      }
     case "PEA":
     {
         $locg=46;
         break;
      }
     case "PES":
      {
         $locg=47;
         break;
      }
      case "PEW":
      {
         $locg=48;
         break;
      }
      case "PHILLIPS":
      {
         $locg=49;
         break;
      }
      case "PANA":
      {
         $locg=50;
         break;
      }
      case "PANB":
      {
         $locg=51;
         break;
      }
      case "PANC":
      {
         $locg=52;
         break;
      }
      case "PANG":
      {
         $locg=53;
         break;
      }
      case "PANI":
      {
         $locg=54;
         break;
      }
      case "PANK":
      {
         $locg=55;
         break;
      }
      case "PANO":
      {
         $locg=56;
         break;
      }
      case "PANP":
      {
         $locg=57;
        break;
      }
      case "READING":
      {
         $locg=58;
         break;
      }
      case "REVERE":
      {
         $locg=61;
         break;
      }
      case "SALEM":
      {
         $locg=63;
         break;
      }
      case "SALEMSTATE":
      {
         $locg=64;
         break;
      }
      case "SAUGUS":
      {
         $locg=68;
         break;
      }
      case "STONEHAM":
      {
         $locg=70;
         break;
      }
      case "SWAMPSCOTT":
      {
         $locg=72;
         break;
      }
      case "WAKEFIELD":
      {
         $locg=74;
         break;
      }
      case "WINTHROP":
      {
         $locg=76;
         break;
      }
      default:
      {
         $locg=1;
         break;
      }
   }

   return $locg;
}

function MakeUpdateReportLink($cmd_line)
{
   $link = "https://tools.noblenet.org/list_maker/list_form.php?";

   $filter_str = "filters=";
   $report_name = "";
   $emails= array();
   $output_str = "output=";


   $get_filters = false;
   $get_name = false;
   $get_email = false;
   $get_output = false;

   //get filters
   for ($i=0; $i < count($cmd_line); $i++)
   {
      $arg = $cmd_line[$i];

      if ($arg == "report_name")
      {
         $get_filters = false;
         $get_email = false;
         $get_output = false;

         $report_name = "name=".urlencode($cmd_line[++$i]);
      }
      else if ($arg == "email")
      {
         $get_filters = false;
         $get_output = false;
         $get_email = true;
         $emails[] =urlencode($cmd_line[++$i]);
         //check for extra emails
      }
      else if ($arg == "lib")
      {
         $get_filters = true;
         $filter_str .= $arg."*";
      }
      else if ($arg == "spreadsheet" || $arg == "html" || $arg == "rss" || $arg == "bookbag" || $arg == "bucket" || $arg == "copy_bucket" || $arg == "json")
      {
          $get_filters = false;
          $get_email = false;
          $get_output = true;

          $output_str .= $arg."*";
      }
      else if ($arg == "rss_list" || $arg == "rss_desc" || $arg == "bag_name" || $arg == "bag_desc" || $arg == "bucket_name" || $arg == "bucket_desc")
      {
          $output_str .= $arg."*".urlencode($cmd_line[++$i])."*";
      }
      else if ($get_filters)
      {
         $filter_str .= $arg."*";
      }
      else if ($get_output)
      {
         $output_str .= $arg."*";
      }

   }

   $email_str = "email=".implode(",",$emails);
   $link .=$filter_str."&".$email_str."&".$output_str;
   if(strlen($report_name))
   {
      $link.="&".$report_name;
   }

   return $link;
}

 /**
	*	Function accepts either 12 or 13 digit number, and either provides or checks the validity of the 13th checksum digit
	*    Optionally converts to ISBN 10 as well.
	*/
	function isbn13checker($input, $convert = FALSE)
	{
		$output = FALSE;
		if (strlen($input) < 12)
		{
			$output = array('error'=>'ISBN too short.');
		}
		if (strlen($input) > 13)
		{
			$output = array('error'=>'ISBN too long.');
		}
		if (!$output)
		{
			$runningTotal = 0;
			$r = 1;
			$multiplier = 1;

			for ($i = 0; $i < 13 ; $i++)
			{
				$nums[$r] = substr($input, $i, 1);
				$r++;
			}
			$inputChecksum = array_pop($nums);

			foreach($nums as $key => $value)
			{
				$runningTotal += $value * $multiplier;
				$multiplier = $multiplier == 3 ? 1 : 3;
			}

			$div = $runningTotal / 10;
			$remainder = $runningTotal % 10;

			$checksum = $remainder == 0 ? 0 : 10 - substr($div, -1);

			$output = array('checksum'=>$checksum);
			$output['isbn13'] = substr($input, 0, 12) . $checksum;

			if ($convert)
			{
				$output['isbn10'] = isbn13to10($output['isbn13']);
			}
			if (is_numeric($inputChecksum) && $inputChecksum != $checksum)
			{
				$output['error'] = 'Input checksum digit incorrect: ISBN not valid';
				$output['input_checksum'] = $inputChecksum;
			}
		}
		return $output;
	}

	/**
	*	Function accepts either 10 or 9 digit number, and either provides or checks the validity of the 10th checksum digit
	*    Optionally converts to ISBN 13 as well.
	*/
	function isbn10checker($input, $convert = FALSE)
	{
		$output = FALSE;
		if (strlen($input) < 9)
		{
			$output = array('error'=>'ISBN too short.');
		}
		if (strlen($input) > 10)
		{
			$output = array('error'=>'ISBN too long.');
		}

		if (!$output)
		{
			$runningTotal = 0;
			$r = 1;
			$multiplier = 10;

			for ($i = 0; $i < 10 ; $i++)
			{
				$nums[$r] = substr($input, $i, 1);
				$r++;
			}

			$inputChecksum = array_pop($nums);
			foreach($nums as $key => $value)
			{
				$runningTotal += $value * $multiplier;
				//echo $value . 'x' . $multiplier . ' + ';
				$multiplier --;
				if ($multiplier === 1)
				{
					break;
				}
			}

			//echo ' = ' . $runningTotal;
			$remainder = $runningTotal % 11;
			$checksum = $remainder == 1 ? 'X' : 11 - $remainder;
			$checksum = $checksum == 11 ? 0 : $checksum;
			$output = array('checksum'=>$checksum);
			$output['isbn10'] = substr($input, 0, 9) . $checksum;

			if ($convert)
			{
				$output['isbn13'] = isbn10to13($output['isbn10']);
			}
			if ((is_numeric($inputChecksum) || $inputChecksum == 'X') && $inputChecksum != $checksum)
			{
				$output['error'] = 'Input checksum digit incorrect: ISBN not valid';
				$output['input_checksum'] = $inputChecksum;
			}
		}
		return $output;
	}

	function isbn10to13($isbn10)
	{
		$isbnStem = strlen($isbn10) == 10 ? substr($isbn10, 0,9) : $isbn10;
		$isbn13data = isbn13checker('978' . $isbnStem);
		return $isbn13data['isbn13'];
	}

	function isbn13to10($isbn13)
	{
		$isbnStem = strlen($isbn13) == 13 ? substr($isbn13, 12) : $isbn13;
		$isbnStem = substr($isbn13, -10);
		$isbn10data = isbn10checker($isbnStem);
		return $isbn10data['isbn10'];
	}


   function GetListMakerUserId($system_id)
   {
      switch($system_id)
      {
         case 1:
         {
            //nobe
            $id =2132485;
            break;
         }
         case 2:
         {
            //beverly
            $id =2536094;
            break;
         }
         case 6:
         {
            //bunkerhill
            $id =2536096;
            break;
         }
         case 8:
         {
            //board
            $id =2536095;
            break;
         }
         case 10:
         {
            //danvers
            $id =2536097;
            break;
         }
         case 12:
         {
            //endicott
            $id =2536098;
            break;
         }
         case 14:
         {
            //everett
            $id =2536099;
            break;
         }
         case 17:
         {
            //gloucester
            $id =2536100;
            break;
         }
         case 19:
         {
            //gordon
            $id =2536101;
            break;
         }
         case 21:
         {
            //lynnfield
            $id =2536103;
            break;
         }
         case 23:
         {
            //lynn
            $id =2536104;
            break;
         }
         case 25:
         {
            //marblehead
            $id =2536105;
            break;
         }
         case 27:
         {
            //melrose
            $id =2536106;
            break;
         }
         case 29:
         {
            //merrimack
            $id =2536108;
            break;
         }
         case 34:
         {
            //montserrat
            $id =2536109;
            break;
         }
         case 45:
         {
            //peabody
            $id =2536111;
            break;
         }
         case 49:
         {
            //phillips
            $id =2536112;
            break;
         }
         case 58:
         {
            //reading
            $id =2536113;
            break;
         }
         case 60:
         {
            //revere
            $id =2536114;
            break;
         }
         case 62:
         {
            //salem
            $id =2536115;
            break;
         }
         case 64:
         {
            //salemstate
            $id =2536116;
            break;
         }
         case 67:
         {
            //saugus
            $id =2536117;
            break;
         }
         case 69:
         {
            //stoneham
            $id =2536118;
            break;
         }
         case 71:
         {
            //swampscott
            $id =2536119;
            break;
         }
         case 73:
         {
            //wakefield
            $id =2536120;
            break;
         }
         case 75:
         {
            //winthrop
            $id =2536121;
            break;
         }
         default:
         {
             $id =2132485;
            break;
         }

      }

      return $id;
   }

   function GetListMakerUserIdFromName($library)
   {
      switch($library)
      {
         case "NOBLE":
         {
            //nobe
            $id =2132485;
            break;
         }
         case "BEVERLY":
         case "BEB":
         case "BEF":
         case "BEV":
         {
            //beverly
            $id =2536094;
            break;
         }
         case "BUNKERHILL":
         {
            //bunkerhill
            $id =2536096;
            break;
         }
         case "BOARD":
         {
            //board
            $id =2536095;
            break;
         }
         case "DANVERS":
         {
            //danvers
            $id =2536097;
            break;
         }
         case "ENDICOTT":
         {
            //endicott
            $id =2536098;
            break;
         }
         case "EVERETT":
         case "EVP":
         case "EVS":
         {
            //everett
            $id =2536099;
            break;
         }
         case "GLOUCESTER":
         {
            //gloucester
            $id =2536100;
            break;
         }
         case "GORDON":
         {
            //gordon
            $id =2536101;
            break;
         }
         case "LYNNFIELD":
         {
            //lynnfield
            $id =2536103;
            break;
         }
         case "LYNN":
         {
            //lynn
            $id =2536104;
            break;
         }
         case "MARBLEHEAD":
         {
            //marblehead
            $id =2536105;
            break;
         }
         case "MELROSE":
         {
            //melrose
            $id =2536106;
            break;
         }
         case "MERRIMACK":
         {
            //merrimack
            $id =2536108;
            break;
         }
         case "MONTESERRAT":
         {
            //montserrat
            $id =2536109;
            break;
         }
         case "PEABODY":
         case "PEA":
         case "PES":
         case "PEW":
         {
            //peabody
            $id =2536111;
            break;
         }
         case "PHILLIPS":
         case "PANA":
         case "PANB":
         case "PANC":
         case "PANG":
         case "PANI":
         case "PANK":
         case "PANO":
         case "PANP":
         {
            //phillips
            $id =2536112;
            break;
         }
         case "READING":
         {
            //reading
            $id =2536113;
            break;
         }
         case "REVERE":
         {
            //revere
            $id =2536114;
            break;
         }
         case "SALEM":
         {
            //salem
            $id =2536115;
            break;
         }
         case "SALEMSTATE":
         {
            //salemstate
            $id =2536116;
            break;
         }
         case "SAUGUS":
         {
            //saugus
            $id =2536117;
            break;
         }
         case "STONEHAM":
         {
            //stoneham
            $id =2536118;
            break;
         }
         case "SWAMPSCOTT":
         {
            //swampscott
            $id =2536119;
            break;
         }
         case "WAKEFIELD":
         {
            //wakefield
            $id =2536120;
            break;
         }
         case "WINTHROP":
         {
            //winthrop
            $id =2536121;
            break;
         }
         default:
         {
             $id =2132485;
            break;
         }

      }

      return $id;
   }


?>
