<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<meta http-equiv="Cache-control" content="no-cache">
<meta http-equiv="Expires" content="-1">
<meta http-equiv="pragma" content="no-cache">

<title>Configure JSON output </title>

<link rel="stylesheet" type="text/css" href="../css/noble.css" />

<script type="text/javascript">


function setPreviousJSON()
{
   var data_type= "<?php echo $_GET['data_type'] ?>";

   document.getElementById('data_type').value = data_type;
}

function submitJSON()
{
   var data_type = document.getElementById('data_type').value;

   window.opener.HandleJSONResult(data_type);
   window.opener = self;
   window.close();
   return false;
}

function cancelJSON()
{
   window.close();
   return false;
}

</script>
</head>


<body onload="setPreviousJSON()">

<div id="content">

<h1 class="stat_cats">Configure JSON  Output </h1>

<form id="stats">
<div id="json_form">
     <p class="weeding">

        JSON Type: WordPress <br/> <br/>

        Data Type:
        <select id="data_type" class="stats">
          <option value="isbn"> ISBN </option>
          <option value="bib_id"> Bib Id </option>
        </select>
 </p>

<div id="done">
	<input type="button" value="Cancel" class="stats" onClick="return cancelJSON()"/>
	<input type="button" value="Done" class="stats" onClick="return submitJSON()"/>
</div>

</div> <!-- endstat form -->
</form>

</div><!--end content-->

</body>
</html>