<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<meta http-equiv="Cache-control" content="no-cache">
<meta http-equiv="Expires" content="-1">
<meta http-equiv="pragma" content="no-cache">

<title>Upload File </title>

<link rel="stylesheet" type="text/css" href="../css/noble.css" />

<script type="text/javascript">

function cancelFile()
{
   window.opener.HandleFileResult(null);
   window.close();
   return false;
}

</script>
</head>


<body>

<div id="content">

<h1 class="stat_cats"> Upload File </h1>

<form action="upload_confirm.php" method="post" enctype="multipart/form-data" id="stats">

   <h3 class="weeding">File Contains </h3>
   <p class="weeding">
     <input type="radio" name="data_type" id="bibs" class="report_type" value="bib" checked="checked"><label class="report_type">Bib Record IDs</label>
     <input type="radio" name="data_type" id="barcodes" class="report_type" value="barcode" ><label class="report_type">Barcodes</label>
     <input type="radio" name="data_type" id="isbns" class="report_type" value="isbn" ><label class="report_type">ISBNs</label>
     
   </p>
   
   <h3 class="weeding">File Type
    <span class="note"> <br />CSV file must have header row with "Record ID", "Barcode", or "ISBN" as column heading</span></h3>
   <p class="weeding">
      <input type="radio" name="file_type" id="csv" class="report_type" value="csv" checked="checked"><label class="report_type">CSV</label>
     <input type="radio" name="file_type" id="text" class="report_type" value="text" ><label class="report_type">Text</label
   </p>
   
   <h3 class="weeding">File </h3>
   <p class="weeding">
       <input type="file" name="data_file" /> <br />
       <span class="note"> <br />NOTE: Save or rename files to avoid file name conflicts.  File names should not have spaces or parentheses. </span>
   </p>


   <p class="weeding">
	 <input type="submit" value="Upload File" name="submit" class="stats">
	 <input type="button" value="Cancel" class="stats" onClick="return cancelFile()"/>
	</p>
	
</div> <!-- endstat form -->
</form>

</div><!--end content-->

</body>
</html>