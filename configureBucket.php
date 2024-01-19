<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<meta http-equiv="Cache-control" content="no-cache">
<meta http-equiv="Expires" content="-1">
<meta http-equiv="pragma" content="no-cache">

<title>Configure Bookbag output </title>

<link rel="stylesheet" type="text/css" href="../css/noble.css" />

<script type="text/javascript" src="../../shared/ajax/ajax.js"></script>
<script src="../../shared/sweetalert2/dist/sweetalert2.min.js"></script>
<link rel="stylesheet" type="text/css" href="../../shared/sweetalert2/dist/sweetalert2.css">

<script type="text/javascript">

var bucket_ajax = new sack();

function UpdateForm(value)
{
  if (value == "new")
  {
      document.getElementById('bucket_owner').disabled = false;
      document.getElementById('bucket_id').disabled = true;
      document.getElementById('bucket_id').value = "";
  }
  else
  {
      document.getElementById('bucket_owner').disabled = true;
      document.getElementById('bucket_owner').value = "";
      document.getElementById('bucket_id').disabled = false;
  }
}

function setPreviousBucket()
{
   var name = "<?php echo $_GET['name'] ?>";
   var desc = "<?php echo $_GET['desc'] ?>";
   var update = "<?php echo $_GET['update'] ?>";
   var owner = "<?php echo $_GET['owner'] ?>";
   var id = "<?php echo $_GET['id'] ?>";
   var type = "<?php echo $_GET['type'] ?>";


   document.getElementById('bucket_name').value = name;
   document.getElementById('bucket_description').value = desc;
   document.getElementById('bucket_update').value = update;
   document.getElementById('bucket_owner').value = owner;
   document.getElementById('bucket_id').value = id;

   document.getElementById('bucket_type').value = type;

   if (type == "bookbag")
   {
      var carousel = "<?php echo $_GET['carousel'] ?>";

      if (carousel == "yes") document.getElementById('carousel').checked = true;
   }

  if (update == "new")
  {
     document.getElementById('bucket_owner').disabled = false;
     document.getElementById('bucket_id').disabled = true;
     document.getElementById('bucket_id').value = "";
  }
  else
  {
      document.getElementById('bucket_owner').disabled = true;
      document.getElementById('bucket_owner').value = "";
      document.getElementById('bucket_id').disabled = false;
  }
}

function submitBucket()
{
   var name = document.getElementById('bucket_name').value;
   var description = document.getElementById('bucket_description').value;
   var update = document.getElementById('bucket_update').value;
   var owner = document.getElementById('bucket_owner').value;
   var id = document.getElementById('bucket_id').value;
   var type =  document.getElementById('bucket_type').value;

   if (type == "bookbag")
   {
       var carousel = "no";
	   if (document.getElementById('carousel').checked)
	   {
		  //make sure the owner and name is set and type is new
		  if (update != "new" || owner.length < 4 || name.length < 4)
		  {
			 swal('Error', "When creating a carousel Bucket must be set to New. Owner and Name also need to be set." , 'error');
			 return false;
		  }
		  carousel = "yes";
	   }
   }

   if (owner.length < 4) owner = "Not Set";

   if(update!= "new" && document.getElementById("bucket_exists").value == "false")
   {
      swal('Error', "Bucket must exist to use "+update+"." , 'error');
      return false;
   }

   if ( document.getElementById('bucket_type').value == "bookbag") window.opener.HandleBookbagResult(name, description, update, owner, id, carousel);
   else if ( document.getElementById('bucket_type').value == "copy") window.opener.HandleCopyBucketResult(name, description, update, owner, id);

   window.opener = self;
   window.close();
   return false;
}

function CheckBucketExists()
{
   var update = document.getElementById('bucket_update').value;
   var id = document.getElementById('bucket_id').value;
   var type =  document.getElementById('bucket_type').value;

   if (update != "new")
   {
       //somehow check if the bucket entered actually exists
       bucket_ajax.requestFile = "checkBucket.php?type="+type+"&id="+id;	// Specifying which file to get
       bucket_ajax.onCompletion = setBucketError;	// Specify function that will be executed after file has been found
       bucket_ajax.runAJAX();		// Execute AJAX function
   }
}

function setBucketError()
{
	eval(bucket_ajax.response);	// Executing the response from Ajax as Javascript code
}

function cancelBucket()
{
   window.close();
   return false;
}

</script>
</head>


<body onload="setPreviousBucket()">

<div id="content">

<h1 class="stat_cats">Configure Bucket Output </h1>

<form id="stats" >

 <?php
          $type  = $_GET['type'];
          if  ($type =="bookbag")
          {
             echo "<h4> Helper words </h4>";
          }
          else if ($type =="copy")
          {
             echo "<h4> Item Bucket Helper words </h4>";
          }
       ?>

<div id="bookbag_form">
     <p class="weeding">

       <table class="weeding" cellspacing="12">


        <tr>
        <td>Bucket Update: </td>
        <td>
        <select id="bucket_update" name="bucket_update" class="stats" onchange="UpdateForm(this.value)">
        <option value="new"> New </option>
        <option value="replace">Replace (existing  bucket)</option>
        <option value="append">Append (existing bucket)</option>
        </select>
        </td>
        </tr>

        <tr>
        <td>Bucket Name:</td>
        <td>
        <input type="text" name="bucket_name" id="bucket_name" class="stats" size ="40" required><br/>
        <span class="note">(Title in Bucket)</span>
        </td>
        </tr>

        <tr>
        <td>Description:  </td>
        <td>
        <span class="bucket"><textarea rows="2" cols="30" id="bucket_description" class="stats"></textarea></span><br/>
        <span class="note"> (Description of the list to display in the Bucket)</span>
        </td>
        </tr>

        <tr>
        <td>Bucket Owner:</td>
        <td>
        <input type="text" name="bucket_owner" id="bucket_owner" class="stats" size ="20"><br/>
        <span class="note">(Only for New Buckets - Enter EG username)</span>
        </td>
        </tr>

        <tr>
        <td>Bucket Id: </td>
        <td>
        <input type="text" name="bucket_id" id="bucket_id" class="stats" size ="20" onChange="CheckBucketExists()" disabled><br/>
        <span class="note">(Only Old Buckets - Evergreen Bucket Id)</span>
        </td>
        </tr>

        <?php
           if ($type == "bookbag")
           {
              //add options to create a carosel
        ?>

        <tr>
        <td>Carousel: </td>
        <td>
        <input type="checkbox" name="carousel" id="carousel" class="carousel"><br/>
        </td>
        </tr>

        <?php
           }
        ?>

        </table>

        <input type="hidden" name="bucket_type" id="bucket_type" class="stats" size ="20">
        <input type="hidden" name="bucket_exists" id="bucket_exists" class="stats" value="">

 </p>

<div id="done">
	<input type="button" value="Cancel" class="stats" onClick="return cancelBucket()"/>
	<input type="button" value="Done" class="stats" onClick="return submitBucket()"/>
</div>

</div> <!-- endstat form -->
</form>

</div><!--end content-->

</body>
</html>