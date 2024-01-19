<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<meta http-equiv="Cache-control" content="no-cache">
<meta http-equiv="Expires" content="-1">
<meta http-equiv="pragma" content="no-cache">


<link rel="stylesheet" type="text/css" href="../css/noble.css" />

<script type="text/javascript">

function submitFile(filename, data_type, file_type)
{
   if (document.getElementById('failure').value == "failure")
   {
      return false;
   }

   window.opener.HandleFileResult(filename, data_type, file_type);
   window.opener = self;
   window.close();
   return false;
}

</script>

<title>File Upload </title>
</head>
<?php
    $data_type = $_POST['data_type'];
    $file_type = $_POST['file_type'];
    $display_name = $_FILES['data_file']['name'];
    

    echo "<body onunload=\"return submitFile('".$display_name."','".$data_type ."','".$file_type."')\">\n";

    echo "<div id=\"content\">";

    echo "<h1 class=\"stat_cats\"> File Upload </h1>\n";

    $error_message = "";
    
    if ( strpos($display_name, '(') !== false || strpos($display_name, ')') !== false) 
    {
         echo "<h3>Filenames cannot contain parenteses<br />";
         echo "<a href=\"upload_file.php\">Try Again</a></h3>";

         echo "<input type=\"hidden\" id=\"failure\" value=\"failure\" >";
    }

    //Read from file
    if (is_uploaded_file($_FILES['data_file']['tmp_name']))
    {
       $filename = $_FILES['data_file']['tmp_name'];

       $file = fopen($filename, "r");

       //check that the file has proper formatting
       if ($file_type == "csv")
       {
          if ($data_type == "barcode")$header = "Barcode";
          else if ($data_type == "isbn")$header = "ISBN";

          $idx = -1;
          $data = fgetcsv($file);

			 for( $i=0; $i < count($data); $i++ )
			 {
			    if ($data_type == "bib")
			    {
			       if (strcasecmp($data[$i], "Document ID") == 0 || strcasecmp($data[$i], "Record ID") == 0)
                {
                   $idx = $i;
                   //echo "Found ".$header." id= ".$idx."<br />";
                   break;
                }
			    }
			    else
			    {
                if (strcasecmp($data[$i], $header) == 0)
                {
                   $idx = $i;
                   //echo "Found ".$header." id= ".$idx."<br />";
                   break;
                }
				 }
		    }

		    if ($idx < 0) $error_message = "No column ".$header." in file.";
       }
       else if ($file_type == "txt")
       {
          //make sure there are line seperators.
       }

       if (strlen($error_message) > 0)
       {
          //the file isn't formatted right print error message
          echo "<h3> File ".$display_name." was not uploaded. Error: ".$error_message."<br />";
          echo "<a href=\"upload_file.php\">Try Again</a></h3>";
       }
       else
       {
          $replace_chars = array("\\", "/", "%", ":", "'", "*", "?", ":", ";", "<", ">", "|", " ", ")", "(");
          $file_destination= str_replace($replace_chars, "_",$_FILES['data_file']['name'] );

          $file_destination = "/home/opensrf/list_upload/".$file_destination;
          move_uploaded_file($filename, $file_destination);


          echo "<h3> File ".$display_name." was successfully uploaded. </h3><br />";

          echo "<input type=\"hidden\" id=\"failure\" value=\"success\" >";

          echo "<input type=\"button\" value=\"Done\" class=\"stats\" onClick=\"return submitFile('".$display_name."','".$data_type ."','".$file_type."')\"/>";

       }

    }
    else
    {
       //no file uploaded print error
         echo "<h3>No File was supplied! <br />";
         echo "<a href=\"upload_file.php\">Try Again</a></h3>";

         echo "<input type=\"hidden\" id=\"failure\" value=\"failure\" >";
    }
?>



</div><!--end content-->

</body>
</html>