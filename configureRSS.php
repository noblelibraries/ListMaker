<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<meta http-equiv="Cache-control" content="no-cache">
<meta http-equiv="Expires" content="-1">
<meta http-equiv="pragma" content="no-cache">

<title>Configure RSS output </title>

<link rel="stylesheet" type="text/css" href="../css/noble.css" />

<script type="text/javascript">


function setPreviousRSS()
{
   var list = "<?php echo $_GET['list'] ?>";
   var desc = "<?php echo $_GET['desc'] ?>";
  
   document.getElementById('rss_list_name').value = list;
   document.getElementById('rss_description').value = desc;
}

function submitRSS()
{
   var list = document.getElementById('rss_list_name').value;
   var description = document.getElementById('rss_description').value;
   
   window.opener.HandleRSSResult(list, description);
   window.opener = self;
   window.close();
   return false;
}

function cancelRSS()
{
   window.close();
   return false;
}

</script>
</head>


<body onload="setPreviousRSS()">

<div id="content">

<h1 class="stat_cats">Configure RSS Feed Output </h1>

<form id="stats" >
<div id="rss_form">
     <p class="weeding">
        
        List Name: &nbsp;&nbsp;<input type="text" name="rss_list_name" id="rss_list_name" class="stats" required>
        <span class="note">(Title in RSS file)</span><br />
        
        Description:  <span class="note"> (Description of the list to display in the RSS)</span> 
        <br /> <span class="rss"><textarea rows="2" cols="30" id="rss_description" class="stats"></textarea></span>
 </p>

<div id="done">
	<input type="button" value="Cancel" class="stats" onClick="return cancelRSS()"/>
	<input type="button" value="Done" class="stats" onClick="return submitRSS()"/>
</div>

</div> <!-- endstat form -->
</form>

</div><!--end content-->

</body>
</html>