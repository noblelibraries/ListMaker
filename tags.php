<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<meta http-equiv="Cache-control" content="no-cache">
<meta http-equiv="Expires" content="-1">
<meta http-equiv="pragma" content="no-cache">

<title>Configure Item Tags </title>

<link rel="stylesheet" type="text/css" href="../css/noble.css" />

<script type="text/javascript" src="../../shared/ajax/ajax.js"></script>
<script type="text/javascript">

var tag_ajax = new sack();

function getTagTypes()
{
   var LibName = "<?php echo $_GET['lib'] ?>";
   var Branch = "<?php echo $_GET['branch'] ?>";

   var preset_tags = "<?php echo $_GET['tags'] ?>";

   if(preset_tags && preset_tags != '-1' && preset_tags != '0')
   {
      document.getElementById('all').disabled = true;
      document.getElementById('all_label').style.opacity=  0.6;

      tag_ajax.requestFile = "setPrevCopyTags.php?lib="+LibName+"&branch="+Branch+"&tags="+preset_tags;	// Specifying which file to get
      tag_ajax.onCompletion = setPreviousTags;	// Specify function that will be executed after file has been found
      tag_ajax.runAJAX();		// Execute AJAX function
   }
   else
   {
      document.getElementById('all').disabled = true;
      document.getElementById('all_label').style.opacity=  0.6;
      tag_ajax.requestFile = "getCopyTagTypes.php?lib="+LibName+"&branch="+Branch;	// Specifying which file to get
      tag_ajax.onCompletion = createTagTypes;	// Specify function that will be executed after file has been found
      tag_ajax.runAJAX();		// Execute AJAX function
   }
}

function createTagTypes()
{
	var obj = document.getElementById('tag_types');
	eval(tag_ajax.response);	// Executing the response from Ajax as Javascript code
}

function setPreviousTags()
{
	var tag_type_obj = document.getElementById('tag_types');
	var selected_tags = document.getElementById('selected_tags_div');
	eval(tag_ajax.response);	// Executing the response from Ajax as Javascript code
}

function getCopyTags(tag_type)
{
    //get the value from the statCat words***value
   var val = tag_type.indexOf("***");
   tag_type = tag_type.slice(val+3);


   document.getElementById('tag_checkboxes').innerHTML = "";

   document.getElementById('all').checked = false;
   if (tag_type != -1)
   {
      document.getElementById('all').disabled = false;
      document.getElementById('all_label').style.opacity=  1.0;
   }
   else
   {
      document.getElementById('all').disabled = true;
      document.getElementById('all_label').style.opacity=  0.6;
   }

   //find any entries from this stat cat that are selected so those can be checked
   //look at the hidden boxes for that stat val as first part of string stat_vals
   var tags = "";
   var vals = document.getElementsByName("tag_vals");
   for (var i=0; i < vals.length; i++)
   {
      tags+= vals[i].value+"*";
   }

   var LibName = "<?php echo $_GET['lib'] ?>";
   var Branch = "<?php echo $_GET['branch'] ?>";

   if(tag_type !=-1)
   {

      if (tags.length > 0) tag_ajax.requestFile = "getCopyTags.php?type="+tag_type+"&tags="+tags+"&lib="+LibName+"&branch="+Branch;	// Specifying which file to get
      else tag_ajax.requestFile = "getCopyTags.php?type="+tag_type+"&lib="+LibName+"&branch="+Branch;
      tag_ajax.onCompletion = createTags;	// Specify function that will be executed after file has been found
      tag_ajax.runAJAX();		// Execute AJAX function
   }
}

function createTags()
{
	var checkbox_div = document.getElementById('tag_checkboxes');
	eval(tag_ajax.response);	// Executing the response from Ajax as Javascript code
}

function selectAll(all)
{
   var checkbox_array = document.getElementsByName('tag_checkboxes');
   for(var i=0; i<checkbox_array.length; i++)
   {
      checkbox_array[i].checked = all.checked;
      if (all.checked)
      {
         //add to the bottom
         AddTag(checkbox_array[i]);
      }
      else
      {
         //remove from the bottom
         RemoveTag(checkbox_array[i].value);
      }
   }
}

function submitTags()
{

   var tag_vals ="";

   //get all nodes named stat_vals
   //use values to create stat_vals variable
   var vals = document.getElementsByName("tag_vals");
   for (var i=0; i < vals.length; i++)
   {
      tag_vals+= vals[i].value;
      if (i != vals.length-1) tag_vals+=","
   }

   var tag_words="";
   var words = document.getElementsByName("tag_words");
   for (var j=0; j < words.length; j++)
   {
       tag_words+=words[j].getAttribute("id")+"%";
   }

   //get all the nodes named stat_words
   //use the ids to create stat_words variable
   window.opener.HandleCopyTagResult(tag_vals, tag_words);
   window.opener = self;
   window.close();
   return false;

}

function cancelTags()
{
   window.opener.HandleCopyTagResult('0');
   window.close();
   return false;
}

function AddTag(tag)
{

   //get whether check is checked
   var checkbox_val = tag.value;
   var seperator = checkbox_val.indexOf("***");
   var tag_id = checkbox_val.slice(seperator+3);
   var tag_words = checkbox_val.slice(0, seperator);

   var display_tag_words = checkbox_val.slice(0, seperator).replace("*","'");

   var type = document.getElementById("tag_types").value;
   var sep = type.indexOf("***");
   var type_val = type.slice(0, sep);
   var type_words = type.slice(0, sep);

   //if checked -- add this plus stat cat to selected stats
   //store the
   if(tag.checked)
   {
      //Check that this one isn't already in the list due to an all situation
      var elementExists = document.getElementById(checkbox_val);
      if (elementExists) return;

      var new_html ="";

      //create a span
      new_html += "<span id='"+checkbox_val+"' class='stat_row'>";

      //create words for the stat
      new_html += "<span id='"+type_val+"/"+tag_words+"' name='tag_words'>"+type_val+"/"+display_tag_words+"</span>";

      //create hidden input for the values to return to
      new_html += "<input type='hidden' name='tag_vals' value='"+tag_id+"'/>";

      //create a button to remove with checkbox_val ans val
      new_html +="<input type=\"button\"  value=\"Remove\" class=\"remove_stat\" onClick=\"RemoveTag('"+checkbox_val+"')\"/>";

      //end span
      new_html += "</span>";

      document.getElementById("selected_tags_div").innerHTML += new_html;

   }
   else
   {
      RemoveTag(checkbox_val);
   }

}

function RemoveTag(name)
{
   var tag = document.getElementById(name);

   if (document.getElementById(name+"_cb")) document.getElementById(name+"_cb").checked = false;

   if (document.getElementById('all').checked == true) document.getElementById('all').checked = false;

   tag.parentNode.removeChild(tag);
}

</script>
</head>


<body onload="getTagTypes()">

<div id="content">

<h1 class="tags">Configure Item Tags </h1>

<form id="stats">

<div id="tag_form">
<label id="select_label"> Tag Types: </label>
<select id="tag_types" name="tag_types"  onchange="getCopyTags(this.value)" class="stats">
</select>
      <input type="checkbox" id="all" name="all" onClick="selectAll(this)"/>
      <label id="all_label"> Select All</label>
<br /><br />
<div id="tag_checkboxes">
</div><!--end checkboxes -->

<hr />
<h2 class="weeding"> Selected Item Tags</h2>
<div id="selected_tags_div" class="tag_list weeding">

</div>

 <!--<textarea id = "debug" ></textarea>-->

<div id="done">
	<input type="button" value="Cancel" class="stats" onClick="return cancelTags()"/>
	<input type="button" value="Done" class="stats" onClick="return submitTags()"/>
</div>

</div> <!-- endstat cat form -->
</form>

</div><!--end content-->

</body>
</html>