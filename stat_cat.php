<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<meta http-equiv="Cache-control" content="no-cache">
<meta http-equiv="Expires" content="-1">
<meta http-equiv="pragma" content="no-cache">

<title>Configure Statistical Categories </title>

<link rel="stylesheet" type="text/css" href="../css/noble.css" />

<script type="text/javascript" src="../../shared/ajax/ajax.js"></script>
<script type="text/javascript">

var stat_ajax = new sack();

function getStatCatList()
{   
   var LibName = "<?php echo $_GET['lib'] ?>";
   var Branch = "<?php echo $_GET['branch'] ?>";
   
   var preset_stat = "<?php echo $_GET['stat'] ?>";
   
   if(preset_stat && preset_stat != '-1' && preset_stat != '0')
   { 
      document.getElementById('all').disabled = true; 
      document.getElementById('all_label').style.opacity=  0.6;
      
      stat_ajax.requestFile = "setPrevStatCats.php?lib="+LibName+"&branch="+Branch+"&stat="+preset_stat;	// Specifying which file to get
      stat_ajax.onCompletion = setPreviousStatCats;	// Specify function that will be executed after file has been found
      stat_ajax.runAJAX();		// Execute AJAX function
     
   }
   else
   {
      document.getElementById('all').disabled = true; 
      document.getElementById('all_label').style.opacity=  0.6;
      stat_ajax.requestFile = "getStatCats.php?lib="+LibName+"&branch="+Branch;	// Specifying which file to get
      stat_ajax.onCompletion = createStatCats;	// Specify function that will be executed after file has been found
      stat_ajax.runAJAX();		// Execute AJAX function
   } 
}

function createStatCats()
{
	var obj = document.getElementById('stat_cat');
	eval(stat_ajax.response);	// Executing the response from Ajax as Javascript code
}

function setPreviousStatCats()
{
	var stat_obj = document.getElementById('stat_cat');
	var selected_stats = document.getElementById('selected_stat_div');
	eval(stat_ajax.response);	// Executing the response from Ajax as Javascript code
}

function getStatCatEntries(statCat)
{     
   //get the value from the statCat words***value
   var val = statCat.indexOf("***");
   statCat = statCat.slice(val+3);
    
   document.getElementById('checkboxes').innerHTML = "";
   
   document.getElementById('all').checked = false;
   if (statCat > -1)
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
   var entries = "";
   var selected = document.getElementsByName("stat_vals");
   var value;
   for (var i = 0; i < selected.length; i++)
   {
      value = selected[i].value;
      if (value.indexOf(statCat) == 0)
      {
         //this category has some preselected items
         //get the entry values for an array
         var start = value.indexOf("(");
         var end = value.indexOf(")");
         entries += value.slice(start+1, end)+"*"; 
      }
   }  
   

   if(statCat > 0)
   {
      if (entries.length > 1) stat_ajax.requestFile = "getStatCatEntryList.php?statCat="+statCat+"&entries="+entries;	// Specifying which file to get
      else stat_ajax.requestFile = "getStatCatEntryList.php?statCat="+statCat;
      stat_ajax.onCompletion = createStatCatEntries;	// Specify function that will be executed after file has been found
      stat_ajax.runAJAX();		// Execute AJAX function
   }
}

function createStatCatEntries()
{
	var checkbox_div = document.getElementById('checkboxes');
	eval(stat_ajax.response);	// Executing the response from Ajax as Javascript code
}

function selectAll(all) 
{
   var checkbox_array = document.getElementsByName('SC_entries');
   for(var i=0; i<checkbox_array.length; i++)
   {
      checkbox_array[i].checked = all.checked;
      if (all.checked)
      {
         //add to the bottom  
         AddStatCat(checkbox_array[i]);   
      }
      else
      {
         //remove from the bottom
         RemoveStatCat(checkbox_array[i].value);
      }
   }
}

function submitStatCat()
{
   var stat_vals ="";

   
   //get all nodes named stat_vals
   //use values to create stat_vals variable
   var vals = document.getElementsByName("stat_vals");
   for (var i=0; i < vals.length; i++)
   {
      stat_vals+=vals[i].value+"*"; 
   }
    
   var stat_words="";
   var words = document.getElementsByName("stat_words");
   for (var j=0; j < words.length; j++)
   {
      stat_words+=words[j].getAttribute("id")+"%"; 
   }
  
   //get all the nodes named stat_words
   //use the ids to create stat_words variable
   //document.getElementById("debug").value = stat_vals+"\n"+stat_words;
   
   window.opener.HandleStatCatResult(stat_vals, stat_words);
   window.opener = self;
   window.close();
   return false;
}

function cancelStatCat()
{
   window.opener.HandleStatCatResult('0');
   window.close();
   return false;
}

function AddStatCat(entry)
{
   //get whether check is checked 
   var checkbox_val = entry.value;
   var seperator = checkbox_val.indexOf("***");
   var entry_val = checkbox_val.slice(seperator+3);
   var entry_words = checkbox_val.slice(0, seperator);
   
   var display_entry_words = checkbox_val.slice(0, seperator).replace("*","'");  
    
   var cat = document.getElementById("stat_cat").value;
   var sep = cat.indexOf("***");
   var cat_val = cat.slice(sep+3);
   var cat_words = cat.slice(0, sep);

   
   //if checked -- add this plus stat cat to selected stats
   //store the   
   if(entry.checked)
   {
      //Check that this one isn't already in the list due to an all situation
      var elementExists = document.getElementById(checkbox_val); 
      if (elementExists) return;
      
      var new_html ="";
      
      //create a span
      new_html += "<span id='"+checkbox_val+"' class='stat_row'>";
      
      //create words for the stat
      new_html += "<span id='"+cat_words+"/"+entry_words+"' name='stat_words'>"+cat_words+"/"+display_entry_words+"</span>";
      
      //create hidden input for the values with common name
      new_html += "<input type='hidden' name='stat_vals' value='"+cat_val+"("+entry_val+")' />";

      //create a button to remove with checkbox_val ans val
      new_html +="<input type=\"button\"  value=\"Remove\" class=\"remove_stat\" onClick=\"RemoveStatCat('"+checkbox_val+"')\"/>";
      
      //end span
      new_html += "</span>";
    
      document.getElementById("selected_stat_div").innerHTML += new_html;
     
   }
   else
   {  
      RemoveStatCat(checkbox_val);
   }

}

function RemoveStatCat(name)
{
   var stat = document.getElementById(name);
      
   if (document.getElementById(name+"_cb")) document.getElementById(name+"_cb").checked = false;
    
   if (document.getElementById('all').checked == true)
   {
      var cat = document.getElementById("stat_cat").value;
      var sep = cat.indexOf("***");
      var cat_val = cat.slice(sep+3);
      var cat_words = cat.slice(0, sep);
      
      var words = stat.firstChild.getAttribute("id");
      
      if(words.indexOf(cat_words) > -1) document.getElementById('all').checked = false;
   }
      
   stat.parentNode.removeChild(stat);   
}

</script>
</head>


<body onload="getStatCatList()">

<div id="content">

<h1 class="stat_cats">Configure Statistical Categories </h1>

<form id="stats">

<div id="stat_cat_form">
<label id="select_label"> Stat Cat: </label>
<select id="stat_cat" name="stat_cat"  onchange="getStatCatEntries(this.value)" class="stats">
</select>
      <input type="checkbox" id="all" name="all" onClick="selectAll(this)"/> 
      <label id="all_label"> Select All</label>
<br /><br />
<div id="checkboxes">
</div><!--end checkboxes -->

<hr />
<h2 class="weeding"> Selected Stat Cats</h2>
<div id="selected_stat_div" class="stat_cat_list weeding">
 
</div>

<!--<textarea id = "debug" ></textarea>-->

<div id="done">
	<input type="button" value="Cancel" class="stats" onClick="return cancelStatCat()"/>
	<input type="button" value="Done" class="stats" onClick="return submitStatCat()"/>
</div>

</div> <!-- endstat cat form -->
</form>

</div><!--end content-->

</body>
</html>