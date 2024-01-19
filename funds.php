<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<meta http-equiv="Cache-control" content="no-cache">
<meta http-equiv="Expires" content="-1">
<meta http-equiv="pragma" content="no-cache">

<title>Configure Funds </title>

<link rel="stylesheet" type="text/css" href="../css/noble.css" />

<script type="text/javascript" src="../../shared/ajax/ajax.js"></script>
<script type="text/javascript">

var fund_ajax = new sack();

function getFundYearList()
{   
   var LibName = "<?php echo $_GET['lib'] ?>";
   var Branch = "<?php echo $_GET['branch'] ?>";
   
   var preset_fund = "<?php echo $_GET['fund'] ?>";
   
   if(preset_fund && preset_fund != '-1' && preset_fund != '0')
   { 
      document.getElementById('all').disabled = true; 
      document.getElementById('all_label').style.opacity=  0.6;
      
      fund_ajax.requestFile = "setPrevFunds.php?lib="+LibName+"&branch="+Branch+"&fund="+preset_fund;	// Specifying which file to get
      fund_ajax.onCompletion = setPreviousFunds;	// Specify function that will be executed after file has been found
      fund_ajax.runAJAX();		// Execute AJAX function
   }
   else
   {
      document.getElementById('all').disabled = true; 
      document.getElementById('all_label').style.opacity=  0.6;
      fund_ajax.requestFile = "getFundYears.php?lib="+LibName+"&branch="+Branch;	// Specifying which file to get
      fund_ajax.onCompletion = createFundYears;	// Specify function that will be executed after file has been found
      fund_ajax.runAJAX();		// Execute AJAX function
   } 
}

function createFundYears()
{
	var obj = document.getElementById('fund_years');
	eval(fund_ajax.response);	// Executing the response from Ajax as Javascript code
}

function setPreviousFunds()
{
	var fund_year_obj = document.getElementById('fund_years');
	var selected_funds = document.getElementById('selected_funds_div');
	eval(fund_ajax.response);	// Executing the response from Ajax as Javascript code
}

function getFundList(fund_year)
{     
   //get the value from the statCat words***value
   var val = fund_year.indexOf("***");
   var lib_id = fund_year.slice(val+3);
   var year = fund_year.slice(0,val);
    
   document.getElementById('checkboxes').innerHTML = "";
   
   document.getElementById('all').checked = false;
   if (year > -1)
   {
      document.getElementById('all').disabled = false; 
      document.getElementById('all_label').style.opacity=  1.0;
   }
   else
   {
      document.getElementById('all').disabled = true; 
      document.getElementById('all_label').style.opacity=  0.6;
   }
   
   
   //find any funds from this year that are selected so those can be checked 
   //look at the hidden boxes for that stat val as first part of string stat_vals
   var funds = "";
   var selected = document.getElementsByName("fund_vals");
   for (var i = 0; i < selected.length; i++)
   {
      funds += selected[i].value+"*";
   }  

   if(year > 0)
   {
      if (funds.length > 1) fund_ajax.requestFile = "getFunds.php?year="+year+"&funds="+funds+"&lib="+lib_id;	// Specifying which file to get
      else fund_ajax.requestFile = "getFunds.php?year="+year+"&lib="+lib_id;
      
      fund_ajax.onCompletion = createFundList;	// Specify function that will be executed after file has been found
      fund_ajax.runAJAX();		// Execute AJAX function
   }
}

function createFundList()
{
	var checkbox_div = document.getElementById('checkboxes');
	eval(fund_ajax.response);	// Executing the response from Ajax as Javascript code
}

function selectAll(all) 
{
   var checkbox_array = document.getElementsByName('fund_checkboxes');
   for(var i=0; i<checkbox_array.length; i++)
   {
      checkbox_array[i].checked = all.checked;
      if (all.checked)
      {
         //add to the bottom  
         AddFund(checkbox_array[i]);   
      }
      else
      {
         //remove from the bottom
         RemoveFund(checkbox_array[i].value);
      }
   }
}

function submitFunds()
{

   var fund_vals ="";

   
   //get all nodes named stat_vals
   //use values to create stat_vals variable
   var vals = document.getElementsByName("fund_vals");
   for (var i=0; i < vals.length; i++)
   {
      fund_vals+=vals[i].value+"*"; 
   }
    
   var fund_words="";
   var words = document.getElementsByName("fund_words");
   for (var j=0; j < words.length; j++)
   {
      fund_words+=words[j].getAttribute("id")+"%"; 
   }
  
   //get all the nodes named stat_words
   //use the ids to create stat_words variable
   //document.getElementById("debug").value = fund_vals+"\n"+fund_words;
   
   window.opener.HandleFundResult(fund_vals, fund_words);
   window.opener = self;
   window.close();
   return false;
   
}

function cancelFunds()
{
   window.opener.HandleFundResult('0');
   window.close();
   return false;
}

function AddFund(fund)
{

   //get whether check is checked 
   var checkbox_val = fund.value;
   var seperator = checkbox_val.indexOf("***");
   var fund_id = checkbox_val.slice(seperator+3);
   var fund_words = checkbox_val.slice(0, seperator);
   
   var display_fund_words = checkbox_val.slice(0, seperator).replace("*","'");  
    
   var year = document.getElementById("fund_years").value;
   var sep = year.indexOf("***");
   var year_val = year.slice(0, sep);
   
   //if checked -- add this plus stat cat to selected stats
   //store the   
   if(fund.checked)
   {
      //Check that this one isn't already in the list due to an all situation
      var elementExists = document.getElementById(checkbox_val); 
      if (elementExists) return;
      
      var new_html ="";
      
      //create a span
      new_html += "<span id='"+checkbox_val+"' class='stat_row'>";
      
      //create words for the stat
      new_html += "<span id='"+year_val+"/"+fund_words+"' name='fund_words'>"+year_val+"/"+display_fund_words+"</span>";
      
      //create hidden input for the values with common name
      new_html += "<input type='hidden' name='fund_vals' value='"+fund_id+"'/>";

      //create a button to remove with checkbox_val ans val
      new_html +="<input type=\"button\"  value=\"Remove\" class=\"remove_stat\" onClick=\"RemoveFund('"+checkbox_val+"')\"/>";
      
      //end span
      new_html += "</span>";
    
      document.getElementById("selected_fund_div").innerHTML += new_html;
     
   }
   else
   {  
      RemoveFund(checkbox_val);
   }

}

function RemoveFund(name)
{
   var fund = document.getElementById(name);
      
   if (document.getElementById(name+"_cb")) document.getElementById(name+"_cb").checked = false;
    
   if (document.getElementById('all').checked == true)
   {
      var year = document.getElementById("fund_years").value;
      var sep = year.indexOf("***");
      var year_val = year.slice(0, sep);
      
      var words = fund.firstChild.getAttribute("id");
      
      if(words.indexOf(year_val) > -1) document.getElementById('all').checked = false;
      
   }
      
   fund.parentNode.removeChild(fund);   
}

</script>
</head>


<body onload="getFundYearList()">

<div id="content">

<h1 class="funds">Configure Funds </h1>

<form id="stats">

<div id="fund_form">
<label id="select_label"> Fund Years: </label>
<select id="fund_years" name="fund_years"  onchange="getFundList(this.value)" class="stats">
</select>
      <input type="checkbox" id="all" name="all" onClick="selectAll(this)"/> 
      <label id="all_label"> Select All</label>
<br /><br />
<div id="checkboxes">
</div><!--end checkboxes -->

<hr />
<h2 class="weeding"> Selected Funds</h2>
<div id="selected_fund_div" class="fund_list weeding">
 
</div>

<!--<textarea id = "debug" ></textarea>-->

<div id="done">
	<input type="button" value="Cancel" class="stats" onClick="return cancelFunds()"/>
	<input type="button" value="Done" class="stats" onClick="return submitFunds()"/>
</div>

</div> <!-- endstat cat form -->
</form>

</div><!--end content-->

</body>
</html>