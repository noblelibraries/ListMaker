
var ajax = new sack();
var working = false;

function SetCheckbox(value, checkbox_name)
{
   if (value.length > 0 && value != "NOBLE")   document.getElementById(checkbox_name).checked = true;
   else  document.getElementById(checkbox_name).checked = false;

   if (checkbox_name =="use_active")
   {
       if (value.length > 0)
       {
          document.getElementById('electronic').disabled = false;
       }
       else
       {
          //check to see if file being used\
			 var file = $(document.getElementById("file_name")).text();
			 if (file.length > 0)
			 {
				 document.getElementById('electronic').disabled = false;
			 }
			 else
			 {
				 document.getElementById('electronic').disabled = true;
				 document.getElementById('electronic').value="physical_only";
			 }
       }
   }
}

function SetNoneCheckbox(value, checkbox_name)
{
   if (value == "none") document.getElementById(checkbox_name).checked = true;
   else  document.getElementById(checkbox_name).checked = false;
}


function SetElectronic(checked)
{
   if (checked)
   {
      document.getElementById('electronic').disabled = false;
   }
   else
   {
       //check to see if file being used\
       var file = $(document.getElementById("file_name")).text();
	    if (file.length > 0)
	    {
	       document.getElementById('electronic').disabled = false;
	    }
	    else
	    {
	       document.getElementById('electronic').disabled = true;
	       document.getElementById('electronic').value="physical_only";
	    }
   }
}

function SetRadio(value, radio_name)
{
   if (value.length > 0 )   document.getElementById(radio_name).checked = true;
   else  document.getElementById(radio_name).checked = false;
}

function UpdateSheetOptions(value)
{
   if (value == "lifetime" && document.getElementById('spreadsheet').checked)
   {
      var sheet_display = document.getElementById("spreadsheet_display").innerHTML;

	   //Take circs in selected dates out of the spreadhseet display
		if(sheet_display.includes("Circs in Selected Dates"))
		{
			sheet_display = sheet_display.replace("<li>Circs in Selected Dates</li>", "");
			document.getElementById("spreadsheet_display").innerHTML = sheet_display;

			if (document.getElementById("spreadsheet_order").innerHTML == "Circs in Selected Dates")
			{
				document.getElementById("spreadsheet_order").innerHTML ="Call Number";
			}

		}
   }
}

function UpdateCircDates(checked)
{
   var sheet_display = document.getElementById("spreadsheet_display").innerHTML;

   if (checked)
   {
      //if spreadsheet checked
      if (document.getElementById('spreadsheet').checked)
      {
			 //if circs between there remove it and add this one instaed
			 if(sheet_display.includes("Circs Between"))
			 {
			    var pos = sheet_display.indexOf("<li>Circs Between");
                var circ_between = sheet_display.substr(pos, 46);
                sheet_display = sheet_display.replace(circ_between, "");

			 }

			 //see if Circs in Selected DAtes already there if not add it
			 if(!sheet_display.includes("Circs in Selected Dates"))
			 {
				 sheet_display = sheet_display.substring(0, sheet_display.indexOf("</ul>"));

				 sheet_display += "<li>Circs in Selected Dates</li></ul>";
			 }

			 document.getElementById("spreadsheet_display").innerHTML = sheet_display;
       }
   }
   else
   {
		//take Circs in Selected Dates out of spreadsheet disple
		//if order by circs selected switch back to call number
		var sheet_display = document.getElementById("spreadsheet_display").innerHTML;

		if(sheet_display.includes("Circs in Selected Dates"))
		{
			sheet_display = sheet_display.replace("<li>Circs in Selected Dates</li>", "");
			document.getElementById("spreadsheet_display").innerHTML = sheet_display;

			if (document.getElementById("spreadsheet_order").innerHTML == "Circs in Selected Dates")
			{
				document.getElementById("spreadsheet_order").innerHTML ="Call Number";
			}

		}
	}
}

function SetCircDates(checked)
{
   if (checked && document.getElementById("use_circ_dates").checked)
   {
       var sheet_display = document.getElementById("spreadsheet_display").innerHTML;

       if(!sheet_display.includes("Circs in Selected Dates"))
       {
			 sheet_display = sheet_display.substring(0, sheet_display.indexOf("</ul>"));

			 sheet_display += "<li>Circs in Selected Dates</li></ul>";
			 document.getElementById("spreadsheet_display").innerHTML = sheet_display;
       }
   }
   if (checked) AllowEmailOptOut(false);
   else AllowEmailOptOut();
}


function SetLinkOptions(checked)
{
   if (document.getElementById('html').checked == false && document.getElementById('spreadsheet').checked == false && document.getElementById('rss').checked == false)
	{
		//set the link boxes to inactive
		document.getElementById('scope_links').disabled = true;
		document.getElementById('search_links').disabled = true;
		document.getElementById('use_domain').disabled = true;
	}
	else
	{
		document.getElementById('scope_links').disabled = false;
		document.getElementById('search_links').disabled = false;
		document.getElementById('use_domain').disabled = false;
	}
}

function getCopyLocationsList(LibName)
{
   document.getElementById('all_locations').checked = false;
   document.getElementById('copy_loc_group').options.length = 0;	// Empty copy location select box

   var filter_branch= document.getElementById('branch_filter');
   filter_branch.options.length = 0;

   document.getElementById('circ_mods').innerHTML="NONE";
   document.getElementById('prefixes').innerHTML="NONE";
   document.getElementById('suffixes').innerHTML="NONE";
   document.getElementById('statuses').innerHTML="NONE";

   //based on libName set the branch box
   if( LibName=="BEVERLY" || LibName=="EVERETT" || LibName=="PEABODY" || LibName=="PHILLIPS" || LibName=="SALEMSTATE" )
   {
      filter_branch.disabled = false;

      //set the branch box
      if(LibName=="BEVERLY")
      {
         filter_branch.options[filter_branch.options.length] = new Option('ALL','ALL');
         filter_branch.options[filter_branch.options.length] = new Option('Bookmobile','BEB');
         filter_branch.options[filter_branch.options.length] = new Option('Bev Farms','BEF');
         filter_branch.options[filter_branch.options.length] = new Option('Main','BEV');
      }
      else if (LibName=="EVERETT")
      {
        filter_branch.options[filter_branch.options.length] = new Option('ALL','ALL');
        filter_branch.options[filter_branch.options.length] = new Option('Parlin','EVP');
        filter_branch.options[filter_branch.options.length] = new Option('Shute','EVS');
      }
      else if(LibName=="PEABODY")
      {
         filter_branch.options[filter_branch.options.length] = new Option('ALL','ALL');
         filter_branch.options[filter_branch.options.length] = new Option('Main','PEA');
         filter_branch.options[filter_branch.options.length] = new Option('South','PES');
         filter_branch.options[filter_branch.options.length] = new Option('West','PEW');
      }
      else if(LibName=="PHILLIPS")
      {
         filter_branch.options[filter_branch.options.length] = new Option('ALL','ALL');
         filter_branch.options[filter_branch.options.length] = new Option('Addison','PANA');
         filter_branch.options[filter_branch.options.length] = new Option('CAMD','PANC');
         filter_branch.options[filter_branch.options.length] = new Option('Clift','PANG');
         filter_branch.options[filter_branch.options.length] = new Option('OWHL','PANO');
         filter_branch.options[filter_branch.options.length] = new Option('Peabody','PANP');
         filter_branch.options[filter_branch.options.length] = new Option('Polk','PANK');
      }
      else if(LibName=="SALEMSTATE")
      {
         filter_branch.options[filter_branch.options.length] = new Option('ALL','ALL');
         filter_branch.options[filter_branch.options.length] = new Option('SSU','SSU');
         filter_branch.options[filter_branch.options.length] = new Option('ERA','SSUE');
      }

   }
   else
   {
      filter_branch.options[filter_branch.options.length] = new Option('','NONE');
      filter_branch.disabled = true;
   }

   if (LibName=="PHILLIPS")
   {
      //change the datepicker
      $( "#last_checkin_date").datepicker( "option", "minDate", new Date(2004, 1 - 1, 1) );
      $( "#active_start").datepicker( "option", "minDate", new Date(2004, 1 - 1, 1) );
      $( "#active_end").datepicker( "option", "minDate", new Date(2004, 1 - 1, 1) );
   }
   else
   {
       //change the datepicker
      $( "#last_checkin_date").datepicker( "option", "minDate", new Date(2000, 1 - 1, 1) );
      $( "#active_start").datepicker( "option", "minDate", new Date(2000, 1 - 1, 1) );
      $( "#active_end").datepicker( "option", "minDate", new Date(2000, 1 - 1, 1) );
   }

   $( "#config_start").datepicker( "option", "minDate", new Date(2012, 5, 1) );
   $( "#config_end").datepicker( "option", "minDate", new Date(2012, 5, 1) );

   //do all copy location stuff
   document.getElementById('copy_loc').innerHTML= "";	// Empty copy location select box
   document.getElementById('stat_cats').value = "";
   document.getElementById('stat_cat_text').innerHTML= "";
   document.getElementById('funds').value = "";
   document.getElementById('fund_text').innerHTML= "";
   document.getElementById('course').value = "";
   document.getElementById('course_text').innerHTML= "";
   document.getElementById('file_name').innerHTML= "";
   document.getElementById('data_type').innerHTML= "";
   document.getElementById('file_type').innerHTML= "";

   if(LibName.length > 0 )
   {
      ajax.requestFile = "getCopyLocations.php?lib="+LibName;	// Specifying which file to get
      ajax.onCompletion = createCopyLocations;	// Specify function that will be executed after file has been found
      ajax.runAJAX();		// Execute AJAX function
   }

   if(LibName == "NOBLE")
   {
      document.getElementById('create_report').disabled = false;
	   document.getElementById('create_preview').disabled = false;
      document.getElementById('all_locations').checked = true;
      document.getElementById('copy_loc').innerHTML= "";
      document.getElementById("copy_loc").style.visibility = "hidden";

      //HTML
      //take out call number
      var html_out =document.getElementById("html_display").innerHTML;
      html_out= html_out.replace("<li>Call Number</li>", "");
      document.getElementById("html_display").innerHTML = html_out;
      //change sort to author
      document.getElementById("html_order").innerHTML ="Author";

      //SPREADSHEET
      var sheet_out =document.getElementById("spreadsheet_display").innerHTML;
      sheet_out = sheet_out.replace("<li>Only Holder</li>", "");
      //sheet_out = sheet_out.replace("</ul>", "");
      //sheet_out += "<li>Circulation Library</li></ul>";
      document.getElementById("spreadsheet_display").innerHTML = sheet_out;
      ///change sort to author
      document.getElementById("spreadsheet_order").innerHTML ="Author";

      //PREVIEW
      var prev_out =document.getElementById("html_display").innerHTML;
      prev_out = prev_out.replace("<li>Call Number</li>", "");
      document.getElementById("preview_display").innerHTML = prev_out;
      document.getElementById("preview_order").innerHTML ="Author";

   }
   else
   {
      document.getElementById("copy_loc").style.visibility = "visible";
      document.getElementById('create_report').disabled = true;
	   document.getElementById('create_preview').disabled = true;

      //set back to defaults
      document.getElementById("html_display").innerHTML = "<ul> <li>Author</li> <li>Call Number</li> <li>Cover Image</li><li>Title</li></ul>";
      document.getElementById("html_order").innerHTML ="Call Number";

      var sheet_display = "<ul><li>Author</li><li>Barcode</li><li>Bib Id</li><li>Call Number</li><li>Shelving Location</li><li>Last Checkin</li>";
      sheet_display += "<li>Lifetime Circs</li><li>Only Holder</li><li>Part</li><li>Prefix</li><li>Pub Date</li><li>Suffix</li><li>Title</li></ul>";

      document.getElementById("spreadsheet_display").innerHTML = sheet_display;
      document.getElementById("spreadsheet_order").innerHTML ="Call Number";

      document.getElementById("preview_display").innerHTML = "<ul> <li>Author</li> <li>Call Number</li> <li>Cover Image</li><li>Title</li></ul>";
      document.getElementById("preview_order").innerHTML ="Call Number";

   }
}

function createCopyLocations()
{
	var copy_loc = document.getElementById('copy_loc');
	var copy_loc_group = document.getElementById('copy_loc_group');
	eval(ajax.response);	// Executing the response from Ajax as Javascript code
}

function UpdateCopyLocations(BranchName)
{
    var LibName =  document.getElementById('library').value;

   document.getElementById('circ_mods').innerHTML="NONE";
   document.getElementById('prefixes').innerHTML="NONE";
   document.getElementById('suffixes').innerHTML="NONE";
   document.getElementById('statuses').innerHTML="NONE";

   document.getElementById('copy_loc').innerHTML="";	// Empty copy location select box
   document.getElementById('copy_loc_group').options.length = 0;	// Empty copy location select box

   if(BranchName == "ALL")
   {
      ajax.requestFile = "getCopyLocations.php?lib="+LibName;	// Specifying which file to get
      ajax.onCompletion = createCopyLocations;	// Specify function that will be executed after file has been found
      ajax.runAJAX();		// Execute AJAX function
   }
   else
   {
      ajax.requestFile = "getCopyLocations.php?lib="+LibName+"&branch="+BranchName;	// Specifying which file to get
      ajax.onCompletion = createCopyLocations;	// Specify function that will be executed after file has been found
      ajax.runAJAX();		// Execute AJAX function
   }
}

function CheckCopyLocation(value)
{
   if ( value == "electronic_only")
   {
      if (document.getElementById('all_locations').checked) return;

		if ( document.getElementById('copy_loc_group').value != "-1") return;

		//get the value for locations
		var copy_locs = document.getElementsByName('copy_loc_checkboxes[]');
		var checked = false;
		for(var i=0; i<copy_locs.length; i++)
		{
		   if (copy_locs[i].checked)
			{
			   return;
			}//end if
		}//end for

		//no copy location is checked so check all
		document.getElementById('all_locations').checked = true;
		document.getElementById('create_report').disabled = false;

	}//end if electronic only
}


function getCollManTopics(topic)
{
    ajax.requestFile = "getCollManTopics.php?topic="+topic;	// Specifying which file to get
    ajax.onCompletion = createCollManTopics;	// Specify function that will be executed after file has been found
    ajax.runAJAX();		// Execute AJAX function
}

function createCollManTopics()
{
   var obj = document.getElementById('coll_man');
	eval(ajax.response);	// Executing the response from Ajax as Javascript code
}

function getBISACLevel1(call_class)
{
   if (call_class == 4)
   {
      var lib = document.getElementById('library');
      var LibName =  lib.options[lib.selectedIndex].value;

      var branch = document.getElementById('branch_filter');
      var BranchName = branch.options[branch.selectedIndex].value;

      if (LibName =="PEABODY" && (BranchName =="PEW" || BranchName =="PES" || BranchName =="PEA") )
      {
         document.getElementById('level1').options.length = 0;	// Empty level 1 select box
         document.getElementById('level2').options.length = 0;	// Empty level 1 select box
         document.getElementById('level3').options.length = 0;

         ajax.requestFile = "getBISAC.php?lib="+BranchName+"&level=1";	// Specifying which file to get
         ajax.onCompletion = createBISACLevel1;	// Specify function that will be executed after file has been found
         ajax.runAJAX();		// Execute AJAX function
      }
      else
      {
         swal("Error", "Your library does not have any stored BISAC Categories. Please use a different filter", 'error');
      }
   }
}

function createBISACLevel1()
{
	var obj = document.getElementById('level1');
	eval(ajax.response);	// Executing the response from Ajax as Javascript code
}

function getBISACLevel2(level1)
{
   document.getElementById('bisac_call').checked = true;

   document.getElementById('level2').options.length = 0;	// Empty level 1 select box
   document.getElementById('level3').options.length = 0;

   ajax.requestFile = "getBISAC.php?level=2&parent="+level1;	// Specifying which file to get
   ajax.onCompletion = createBISACLevel2;	// Specify function that will be executed after file has been found
   ajax.runAJAX();		// Execute AJAX function
}

function createBISACLevel2()
{
	var obj = document.getElementById('level2');
	eval(ajax.response);	// Executing the response from Ajax as Javascript code
}

function getBISACLevel3(level2)
{
   document.getElementById('level3').options.length = 0;	// Empty level 1 select box

   ajax.requestFile = "getBISAC.php?level=3&parent="+level2;	// Specifying which file to get
   ajax.onCompletion = createBISACLevel3;	// Specify function that will be executed after file has been found
   ajax.runAJAX();		// Execute AJAX function
}

function createBISACLevel3()
{
	var obj = document.getElementById('level3');
	eval(ajax.response);	// Executing the response from Ajax as Javascript code
}


function getCircModifierList(is_group)
{
   if (document.getElementById('schedule_report').checked)
   {
      updateAllCircPreSuffix("schedule");
      return;
   }

   document.getElementById('all_locations').checked = false;

   var lib = document.getElementById('library');
   var LibName =  lib.options[lib.selectedIndex].value;

   if(LibName == "NOBLE")return;

   var branch = document.getElementById('branch_filter');
   var BranchName = branch.options[branch.selectedIndex].value;

   var loc_grp = -1;
   var locations = new Array();

   if (is_group)
   {
      loc_grp = document.getElementById('copy_loc_group').value;

      //uncheck all copy locations
      var copy_locs = document.getElementsByName('copy_loc_checkboxes[]');
      for(var i=0; i<copy_locs.length; i++)
      {
          copy_locs[i].checked = false;
      }

   }
   else
   {
      //get the value for locations
		var copy_locs = document.getElementsByName('copy_loc_checkboxes[]');
		for(var i=0; i<copy_locs.length; i++)
		{
			 if (copy_locs[i].checked)
			 {
				 locations.push(copy_locs[i].value);
			 }
		}

      document.getElementById('copy_loc_group').value = -1;
   }

   document.getElementById('circ_mods').innerHTML="LOADING......";
   document.getElementById('prefixes').innerHTML="LOADING......";
   document.getElementById('suffixes').innerHTML="LOADING......";
   document.getElementById('statuses').innerHTML="LOADING......";

   //disable submit
   document.getElementById('create_report').disabled = true;
   document.getElementById('create_preview').disabled = true;

   if(LibName.length > 0)
   {
      if (BranchName == "ALL" || BranchName == "NONE")
      {
         if(is_group)ajax.requestFile = "getCircModStatusAndPrefixSuffix.php?lib="+LibName+"&loc_grp="+loc_grp;
         else ajax.requestFile = "getCircModStatusAndPrefixSuffix.php?lib="+LibName+"&location="+locations;	// Specifying which file to get
      }
      else
      {
         if(is_group)ajax.requestFile = "getCircModStatusAndPrefixSuffix.php?lib="+LibName+"&branch="+BranchName+"&loc_grp="+loc_grp;
         else ajax.requestFile = "getCircModStatusAndPrefixSuffix.php?lib="+LibName+"&branch="+BranchName+"&location="+locations;	// Specifying which file to get
      }

      ajax.onCompletion = createCircModStatusAndPrefixSuffix;	// Specify function that will be executed after file has been found
      ajax.runAJAX();		// Execute AJAX function
   }
}

function getAllCircPreSuffix(all_loc)
{

   if (all_loc.checked == false)
   {
      document.getElementById('circ_mods').innerHTML="NONE";
      document.getElementById('prefixes').innerHTML="NONE";
      document.getElementById('suffixes').innerHTML="NONE";
      document.getElementById('statuses').innerHTML="NONE";

      return;
   }

   var lib = document.getElementById('library');
   var LibName =  lib.options[lib.selectedIndex].value;

   document.getElementById('copy_loc_group').value = -1;
  //uncheck all copy locations
	var copy_locs = document.getElementsByName('copy_loc_checkboxes[]');
	for(var i=0; i<copy_locs.length; i++)
	{
		 copy_locs[i].checked = false;
	}

   if(LibName == "NOBLE")
   {
	   return;
   }

   //clear any selections in the copy locaiton selector

   var branch = document.getElementById('branch_filter');
   var BranchName = branch.options[branch.selectedIndex].value;

   document.getElementById('circ_mods').innerHTML="LOADING......";
   document.getElementById('prefixes').innerHTML="LOADING......";
   document.getElementById('suffixes').innerHTML="LOADING......";
   document.getElementById('statuses').innerHTML="LOADING......";

   //disable submit
   document.getElementById('create_report').disabled = true;
   document.getElementById('create_preview').disabled = true;

   if(LibName.length > 0)
   {
      if (BranchName == "ALL" || BranchName == "NONE")
      {
         ajax.requestFile = "getCircModStatusAndPrefixSuffix.php?lib="+LibName+"&location=all";	// Specifying which file to get
      }
      else
      {
         ajax.requestFile = "getCircModStatusAndPrefixSuffix.php?lib="+LibName+"&branch="+BranchName+"&location=all";	// Specifying which file to get
      }

      ajax.onCompletion = createCircModStatusAndPrefixSuffix;	// Specify function that will be executed after file has been found
      ajax.runAJAX();		// Execute AJAX function
   }
}

function createCircModStatusAndPrefixSuffix()
{
	var circ_mod = document.getElementById('circ_mods');
	var prefix = document.getElementById('prefixes');
	var suffix = document.getElementById('suffixes');
	var status = document.getElementById('statuses');
	eval(ajax.response);	// Executing the response from Ajax as Javascript code

	//enable submit
	document.getElementById('create_report').disabled = false;
	document.getElementById('create_preview').disabled = false;
}

function updateAllCircPreSuffix(scheduled)
{
   if (scheduled == "once")
   {
      //if all is checked do nothing
      if (document.getElementById('all_locations').checked == false)
      {
         //else get the data for this copy location
         getCircModifierList(false);
      }
   }
   else if (scheduled == "schedule")
   {
		var lib = document.getElementById('library');
		var LibName =  lib.options[lib.selectedIndex].value;

		var branch = document.getElementById('branch_filter');
		var BranchName = branch.options[branch.selectedIndex].value;

	   document.getElementById('circ_mods').innerHTML="LOADING......";
	   document.getElementById('prefixes').innerHTML="LOADING......";
	   document.getElementById('suffixes').innerHTML="LOADING......";
	   document.getElementById('statuses').innerHTML="LOADING......";

		//disable submit
		document.getElementById('create_report').disabled = true;
		document.getElementById('create_preview').disabled = true;

		if(LibName.length > 0)
		{
			if (BranchName == "ALL" || BranchName == "NONE")
			{
				ajax.requestFile = "getCircModStatusAndPrefixSuffix.php?lib="+LibName+"&location=all";	// Specifying which file to get
			}
			else
			{
				ajax.requestFile = "getCircModStatusAndPrefixSuffix.php?lib="+LibName+"&branch="+BranchName+"&location=all";	// Specifying which file to get
			}

			ajax.onCompletion = createCircModStatusAndPrefixSuffix;	// Specify function that will be executed after file has been found
			ajax.runAJAX();		// Execute AJAX function
		}
   }
}

function ClearListForm()
{
   var url = window.location.href.split('?')[0];

   window.location = url;
}

function ClearCollManTopics()
{
    var selectElement = document.getElementById('coll_man');
    var options = selectElement.options;

    var length=options.length;
    // Look for a default selected option
    for (var i=0; i<length; i++)
    {
       options[i].selected = false;
    }
}

function ClearCircMod()
{
   var circ_mods = document.getElementsByName('circ_mod_checkboxes[]');
   for(var i=0; i<circ_mods.length; i++)
   {
       circ_mods[i].checked = false;
   }
}

function ClearPrefix()
{
   var prefixes = document.getElementsByName('prefix_checkboxes[]');
   for(var i=0; i<prefixes.length; i++)
   {
       prefixes[i].checked = false;
   }
}

function ClearSuffix()
{
   var suffixes = document.getElementsByName('suffix_checkboxes[]');
   for(var i=0; i<suffixes.length; i++)
   {
       suffixes[i].checked = false;
   }
}

function ClearStatus()
{
   var statuses = document.getElementsByName('status_checkboxes[]');
   for(var i=0; i<statuses.length; i++)
   {
       statuses[i].checked = false;
   }
}

function ClearLineItemStatus()
{
   var li_stat = document.getElementsByName('line_item_status_checkboxes[]');
   for(var i=0; i<li_stat.length; i++)
   {
       li_stat[i].checked = false;
   }
}

function ClearDates()
{
   document.getElementById('last_checkin_date').value ="";
}


function configureStatCat()
{
   var lib = document.getElementById('library');
   var LibName = lib.options[lib.selectedIndex].value;

   var branch = document.getElementById('branch_filter');
   var BranchName = branch.options[branch.selectedIndex].value;

   if (BranchName == "ALL" || BranchName == "NONE")
   {
      BranchName = "none";
   }


   if(LibName=="NONE")
   {
      swal("Error", "You must first select a Library before Configuring a Statistical Category", 'error');
   }
   else
   {
      if (document.getElementById('stat_cats').value.length > 0)
      {
         var stat = document.getElementById('stat_cats').value;

         stat = stat.substring(0, stat.length - 1);

         //var myWindow =window.open('stat_cat.php?lib='+LibName+'&branch='+BranchName+'&stat='+stat+'&entry='+stat_entry,'name','height=350,width=800,left=10,top=10,resizable=yes,scrollbars=yes,toolbar=no,menubar=yes,location=no,directories=no,status=yes');
         var myWindow =window.open('stat_cat.php?lib='+LibName+'&branch='+BranchName+'&stat='+stat,'name','height=800,width=1100,left=10,top=10,resizable=yes,scrollbars=yes,toolbar=no,menubar=yes,location=no,directories=no,status=yes');

      }
      else
      {
         document.getElementById('stat_cat_text').innerHTML="";
	      //var myWindow =window.open('stat_cat.php?lib='+LibName+'&branch='+BranchName+'&stat=0','name','height=350,width=800,left=10,top=10,resizable=yes,scrollbars=yes,toolbar=no,menubar=no,location=no,directories=no,status=yes');
	      var myWindow =window.open('stat_cat.php?lib='+LibName+'&branch='+BranchName,'name','height=800,width=1100,left=10,top=10,resizable=yes,scrollbars=yes,toolbar=no,menubar=no,location=no,directories=no,status=yes');

	   }
	}
}

function HandleStatCatResult(stat_vals, stat_words)
{
   document.getElementById('stat_cat_text').innerHTML="";

   if (!stat_words)
   {
      document.getElementById("stat_cats").value = "";
      document.getElementById('stat_cat_text').innerHTML="<span class=\"stat\">None Selected</span>";
   }
   else
   {
      document.getElementById("stat_cats").value =""+stat_vals;

      var words = stat_words.split("%");
      for (var i=0; i < words.length-1; i++)
      {
         document.getElementById('stat_cat_text').innerHTML+="<span class=\"stat\">"+words[i].replace("*","'")+"<br /></span>";
      }
   }
}

function configureFunds()
{
   var lib = document.getElementById('library');
   var LibName = lib.options[lib.selectedIndex].value;

   var branch = document.getElementById('branch_filter');
   var BranchName = branch.options[branch.selectedIndex].value;

   if (BranchName == "ALL" || BranchName == "NONE")
   {
      BranchName = "none";
   }


   if(LibName=="NONE")
   {
      swal("Error", "You must first select a Library before Configuring a Fund", 'error');
   }
   else
   {
      if (document.getElementById('funds').value.length > 0)
      {
         var fund = document.getElementById('funds').value;

         fund = fund.substring(0, fund.length - 1);

         //var myWindow =window.open('stat_cat.php?lib='+LibName+'&branch='+BranchName+'&stat='+stat+'&entry='+stat_entry,'name','height=350,width=800,left=10,top=10,resizable=yes,scrollbars=yes,toolbar=no,menubar=yes,location=no,directories=no,status=yes');
         var myWindow =window.open('funds.php?lib='+LibName+'&branch='+BranchName+'&fund='+fund,'name','height=800,width=1100,left=10,top=10,resizable=yes,scrollbars=yes,toolbar=no,menubar=yes,location=no,directories=no,status=yes');

      }
      else
      {
         document.getElementById('fund_text').innerHTML="";
	      //var myWindow =window.open('stat_cat.php?lib='+LibName+'&branch='+BranchName+'&stat=0','name','height=350,width=800,left=10,top=10,resizable=yes,scrollbars=yes,toolbar=no,menubar=no,location=no,directories=no,status=yes');
	      var myWindow =window.open('funds.php?lib='+LibName+'&branch='+BranchName,'name','height=800,width=1100,left=10,top=10,resizable=yes,scrollbars=yes,toolbar=no,menubar=no,location=no,directories=no,status=yes');

	   }
	}
}

function HandleFundResult(fund_vals, fund_words)
{
   document.getElementById('fund_text').innerHTML="";

   if (!fund_words)
   {
      document.getElementById("funds").value = "";
      document.getElementById('fund_text').innerHTML="<span class=\"stat\">None Selected</span>";
   }
   else
   {
      document.getElementById("funds").value =""+fund_vals;

      var words = fund_words.split("%");
      for (var i=0; i < words.length-1; i++)
      {
         document.getElementById('fund_text').innerHTML+="<span class=\"stat\">"+words[i].replace("*","'")+"<br /></span>";
      }
   }
}

function configureCopyTags()
{
   var lib = document.getElementById('library');
   var LibName = lib.options[lib.selectedIndex].value;

   var branch = document.getElementById('branch_filter');
   var BranchName = branch.options[branch.selectedIndex].value;

   if (BranchName == "ALL" || BranchName == "NONE")
   {
      BranchName = "none";
   }


   if(LibName=="NONE")
   {
      swal("Error", "You must first select a Library before Configuring a Copy Tag", 'error');
   }
   else
   {
      if (document.getElementById('tag_ids').value.length > 0)
      {
         var tag = document.getElementById('tag_ids').value;

         tag = tag.substring(0, tag.length);

         //var myWindow =window.open('stat_cat.php?lib='+LibName+'&branch='+BranchName+'&stat='+stat+'&entry='+stat_entry,'name','height=350,width=800,left=10,top=10,resizable=yes,scrollbars=yes,toolbar=no,menubar=yes,location=no,directories=no,status=yes');
         var myWindow =window.open('tags.php?lib='+LibName+'&branch='+BranchName+'&tags='+tag,'name','height=800,width=1100,left=10,top=10,resizable=yes,scrollbars=yes,toolbar=no,menubar=yes,location=no,directories=no,status=yes');

      }
      else
      {
         document.getElementById('copy_tag_text').innerHTML="";
	      //var myWindow =window.open('stat_cat.php?lib='+LibName+'&branch='+BranchName+'&stat=0','name','height=350,width=800,left=10,top=10,resizable=yes,scrollbars=yes,toolbar=no,menubar=no,location=no,directories=no,status=yes');
	      var myWindow =window.open('tags.php?lib='+LibName+'&branch='+BranchName,'name','height=800,width=1100,left=10,top=10,resizable=yes,scrollbars=yes,toolbar=no,menubar=no,location=no,directories=no,status=yes');

	   }
	}
}

function HandleCopyTagResult(copy_tag_vals, copy_tag_words)
{
   document.getElementById('copy_tag_text').innerHTML="";

   if (!copy_tag_words)
   {
      document.getElementById("tag_ids").value = "";
      document.getElementById('copy_tag_text').innerHTML="<span class=\"stat\">None Selected</span>";
   }
   else
   {
      document.getElementById("tag_ids").value =""+copy_tag_vals;

      var words = copy_tag_words.split("%");
      for (var i=0; i < words.length-1; i++)
      {
         document.getElementById('copy_tag_text').innerHTML+="<span class=\"stat\">"+words[i].replace("*","'")+"<br /></span>";
      }
   }
}

function configureCourses()
{
   var lib = document.getElementById('library');
   var LibName = lib.options[lib.selectedIndex].value;

   var branch = document.getElementById('branch_filter');
   var BranchName = branch.options[branch.selectedIndex].value;

   if (BranchName == "ALL" || BranchName == "NONE")
   {
      BranchName = "none";
   }


   if(LibName=="NONE")
   {
      swal("Error", "You must first select a Library before Configuring Courses", 'error');
   }
   else
   {
      if (document.getElementById('course').value.length > 0)
      {
         var course = document.getElementById('course').value;

         course = course.substring(0, course.length - 1);

         var myWindow =window.open('courses.php?lib='+LibName+'&branch='+BranchName+'&course='+course,'name','height=800,width=1100,left=10,top=10,resizable=yes,scrollbars=yes,toolbar=no,menubar=yes,location=no,directories=no,status=yes');

      }
      else
      {
         document.getElementById('course_text').innerHTML="";
	     var myWindow =window.open('courses.php?lib='+LibName+'&branch='+BranchName,'name','height=800,width=1100,left=10,top=10,resizable=yes,scrollbars=yes,toolbar=no,menubar=no,location=no,directories=no,status=yes');

	   }
	}
}

function HandleCourseResult(course_vals, course_words)
{
   document.getElementById('course_text').innerHTML="";

   if (!course_words)
   {
      document.getElementById("course").value = "";
      document.getElementById('course_text').innerHTML="<span class=\"stat\">None Selected</span>";
   }
   else
   {
      document.getElementById("course").value =""+course_vals;

      var words = course_words.split("%");
      for (var i=0; i < words.length-1; i++)
      {
         document.getElementById('course_text').innerHTML+="<span class=\"stat\">"+words[i].replace("*","'")+"<br /></span>";
      }

      var sheet_display = document.getElementById("spreadsheet_display").innerHTML;

      if(!sheet_display.includes("Course Circulation"))
      {
	     sheet_display = sheet_display.substring(0, sheet_display.indexOf("</ul>"));

		 sheet_display += "<li>Course Circulation</li></ul>";
		 document.getElementById("spreadsheet_display").innerHTML = sheet_display;
      }

   }
}



function configureHTML()
{
   var php_file = 'configureHTML.php';

    var order= $(document.getElementById("html_order")).text();
    php_file +="?order="+order.trim();

    var display = $(document.getElementById("html_display")).text();
    display = display.replace(/\s+/g, '');
    php_file +="&display="+display;

    var layout = $(document.getElementById("html_layout")).text();
    layout = layout.replace(/\s+/g, '');
    php_file +="&layout="+layout;

    var options = $(document.getElementById("html_options")).text();
    options = options.replace(/\s+/g, '');
    php_file +="&options="+options;

    window.open(php_file,'name','height=800,width=900,left=10,top=10,resizable=yes,scrollbars=yes,toolbar=no,menubar=no,location=no,directories=no,status=yes');
}

function HandleHTMLResult(order=null, display=null, layout=null, options=null)
{
   if (!order && !display && !layout && !options) return;

   if (order) document.getElementById("html_order").innerHTML = order.toString();
   if (layout)
   {
      var values = layout.split('*');

      var html_layout="";

      for(var i = 0; i< values.length; i++)
      {
         html_layout += values[i];
         if (i < (values.length-1) ) html_layout += "<br/>";
      }
      document.getElementById("html_layout").innerHTML = html_layout;

   }

   if (display)
   {
      var html_display="<ul>";
      var values = display.split('*');

      for(var i = 0; i < values.length; i++)
      {
         switch(values[i])
         {
           case 'author':
              html_display +="<li>Author</li>";
              break;
            case 'callnum':
              html_display +="<li>Call Number</li>";
              break;
           case 'cover':
              html_display +="<li>Cover Image</li>";
              break;
            case 'title':
              html_display +="<li>Title</li>";
              break;
            case 'active':
              html_display +="<li>Active Date</li>";
              break;
            case 'ageprotection':
              html_display +="<li>Age Protection</li>";
              break;
            case 'adirect':
              html_display +="<li>Amazon Direct</li>";
              break;
            case 'asearch':
              html_display +="<li>Amazon Search</li>";
              break;
            case 'barcode':
              html_display +="<li>Barcode</li>";
              break;
            case 'bibid':
              html_display +="<li>Bib Id</li>";
              break;
            case 'circlib':
              html_display +="<li>Circ Lib</li>";
              break;
            case 'circmod':
              html_display +="<li>Circ Modifier</li>";
              break;
            case 'copyloc':
              html_display +="<li>Shelving Location</li>";
              break;
            case 'copystatus':
              html_display +="<li>Item Status</li>";
              break;
            case 'goodreads':
              html_display +="<li>Goodreads Link</li>";
              break;
            case 'google':
              html_display +="<li>Google Books</li>";
              break;
            case 'inhouse':
              html_display +="<li>In House Use</li>";
              break;
            case 'isbn':
              html_display +="<li>ISBN</li>";
              break;
            case 'lastcheckin':
              html_display +="<li>Last Checkin</li>";
              break;
            case 'lifetimecirc':
              html_display +="<li>Lifetime Circs</li>";
              break;
            case 'oclc':
              html_display +="<li>OCLC Number</li>";
              break;
               break;
            case 'part':
              html_display +="<li>Part</li>";
              break;
            case 'pubdate':
              html_display +="<li>Pub Date</li>";
              break;
            case 'publicnote':
              html_display +="<li>Public Note</li>";
              break;
            case 'publisher':
              html_display +="<li>Publisher</li>";
              break;
            case 'staffnote':
              html_display +="<li>Staff Note</li>";
              break;
            case 'statcat':
              html_display +="<li>Stat Cat</li>";
              break;
            case 'statuschange':
              html_display +="<li>Last Status Change</li>";
              break;
            case 'summary':
              html_display +="<li>Summary</li>";
              break;
            case 'ytdcirc':
              html_display +="<li>YTD Circs</li>";
              break;
         }

      }
      html_display += "</ul>";

      document.getElementById("html_display").innerHTML = html_display;

      document.getElementById('html').checked = true;

   }

   if (options)
   {
      var html_options="<ul>";
      var values = options.split('*');

      for(var i = 0; i< values.length; i++)
      {
         switch(values[i])
         {
           case 'imagesmall':
              html_options +="<li>Image Size Small</li>";
              break;
           case 'imagemedium':
              html_options +="<li>Image Size Medium</li>";
              break;
          case 'imagelarge':
              html_options +="<li>Image Size Large</li>";
              break;
           case 'groupfirst':
              html_options +="<li>Group Items First</li>";
              break;
            case 'groupall':
              html_options +="<li>Group Items All</li>";
              break;
           case 'wordpress':
              html_options +="<li>WordPress</li>";
              break;
            case 'savehtml':
              html_options +="<li>Embeddable URL</li>";
              //check if this is scheduled, if so check run now
              if(document.getElementById("schedule_report").checked) document.getElementById("run_now").checked = true;
              break;
         }
      }
      html_options += "</ul>";

      document.getElementById("html_options").innerHTML = html_options;
   }
   else
   {
      document.getElementById("html_options").innerHTML = "";
   }

   AllowEmailOptOut(false);

}

function SetRunNow(checked)
{
   if (checked)
   {
      if(document.getElementById("schedule_report").checked)
      {
         document.getElementById("run_now").checked = true;
      }
   }
   AllowEmailOptOut();
}

function AllowEmailOptOut(val)
{
     var often = document.getElementById('how_often');
     var how_often = often.options[often.selectedIndex].value;

     if (val === false)
     {
        document.getElementById('no_email').checked = false;
        document.getElementById('email_opt_out').style.display = 'none';
     }
     else if ( document.getElementById("schedule_report").checked && how_often == "daily"
              && document.getElementById("spreadsheet").checked ==  false && document.getElementById("html").checked == false &&
             (document.getElementById('json').checked || document.getElementById('bookbag').checked || document.getElementById('copy_bucket').checked ))
     {
         document.getElementById('email_opt_out').style.display = 'inline';
     }
     else
     {
        //hide the email box
         document.getElementById('no_email').checked = false;
         document.getElementById('email_opt_out').style.display = 'none';
     }
}

function configureSpreadsheet()
{
    var php_file = 'configureSpreadsheet.php';

    var order= $(document.getElementById("spreadsheet_order")).text();
    php_file +="?order="+order.trim();

    var display = $(document.getElementById("spreadsheet_display")).text();
    display = display.replace(/\s+/g, '');
    php_file +="&display="+display;

    var format = $(document.getElementById("spreadsheet_format")).text();
    php_file +="&format="+format;

    var options = $(document.getElementById("spreadsheet_options")).text();
    options = options.replace(/\s+/g, '');
    php_file +="&options="+options;

    var course = document.getElementById('course').value;
	if (course.length > 0) php_file +="&course=yes";
	else php_file +="&course=no";

    window.open(php_file,'name','height=800,width=1100,left=10,top=10,resizable=yes,scrollbars=yes,toolbar=no,menubar=no,location=no,directories=no,status=yes');
}

function HandleSpreadsheetResult(order=null, display=null, format=null, options=null)
{
   if (!order && !display && !format) return;

   if (order) document.getElementById("spreadsheet_order").innerHTML = order.toString();
   if (format) document.getElementById("spreadsheet_format").innerHTML = format.toString();

   if (options)
   {
      var sheet_options="<ul>";
      var vals = options.split('*');

      for(var j = 0; j< vals.length; j++)
      {
         switch(vals[j])
         {
            case 'itemsheet':
              sheet_options +="<li>Item Sheet</li>";
              break;
            case 'circsbylib':
              sheet_options +="<li>Circs By Library</li>";
              break;
           case 'summarysheet':
              sheet_options +="<li>Summary Sheet</li>";
              break;
           case 'singlesheet':
              sheet_options +="<li>Single Sheet</li>";
              break;
         case 'bibsheet':
              sheet_options +="<li>Bib Sheet</li>";
              break;
          case 'authorsheet':
              sheet_options +="<li>Author Sheet</li>";
              break;
         case 'countsheet':
              sheet_options +="<li>Count Sheet</li>";
              break;
         }
      }
      sheet_options += "</ul>";

      document.getElementById("spreadsheet_options").innerHTML = sheet_options;
   }
   else
   {
      document.getElementById("spreadsheet_options").innerHTML = "";
   }

   if (display)
   {
      var sheet_display="<ul>";
      var values = display.split('*');

      for(var i = 0; i< values.length; i++)
      {
         switch(values[i])
         {
           case 'author':
              sheet_display +="<li>Author</li>";
              break;
            case 'barcode':
              sheet_display +="<li>Barcode</li>";
              break;
            case 'bibid':
              sheet_display +="<li>Bib Id</li>";
              break;
            case 'callnum':
              sheet_display +="<li>Call Number</li>";
              break;
            case 'copyloc':
              sheet_display +="<li>Shelving Location</li>";
              break;
            case 'lastcheckin':
              sheet_display +="<li>Last Checkin</li>";
              break;
            case 'lifetimecirc':
              sheet_display +="<li>Lifetime Circs</li>";
              break;
            case 'onlyholder':
              sheet_display +="<li>Only Holder</li>";
              break;
            case 'part':
              sheet_display +="<li>Part</li>";
              break;
            case 'prefix':
              sheet_display +="<li>Prefix</li>";
              break;
            case 'pubdate':
              sheet_display +="<li>Pub Date</li>";
              break;
            case 'suffix':
              sheet_display +="<li>Suffix</li>";
              break;
            case 'title':
              sheet_display +="<li>Title</li>";
              break;

            case 'active':
              sheet_display +="<li>Active Date</li>";
              break;
            case 'ageprotection':
              sheet_display +="<li>Age Protection</li>";
              break;
            case 'alert':
              sheet_display +="<li>Alert Message</li>";
              break;
            case 'adirect':
              sheet_display +="<li>Amazon Direct</li>";
              break;
            case 'asearch':
              sheet_display +="<li>Amazon Search</li>";
              break;
            case 'cost':
              sheet_display +="<li>Acquisition Cost</li>";
              break;
            case 'branch':
              sheet_display +="<li>Branch</li>";
              break;
            case 'class':
              sheet_display +="<li>Call Number Class</li>";
              break;
            case 'sortkey':
              sheet_display +="<li>Call Num Sort Key</li>";
              break;
            case 'catlinkstaff':
              sheet_display +="<li>Catalog Staff Link</li>";
              break;
            case 'catlinkopac':
              sheet_display +="<li>Catalog OPAC Link</li>";
              break;
            case 'titlelinkstaff':
              sheet_display +="<li>Title Staff Link</li>";
              break;
            case 'titlelinkopac':
              sheet_display +="<li>Title OPAC Link</li>";
              break;
            case 'circlib':
              sheet_display +="<li>Circulation Library</li>";
              break;
            case 'circselected':
              sheet_display +="<li>Circs in Selected Dates</li>";
              break;
            case 'circbetween':
              var start = values[++i];
              var end = values[++i];
              sheet_display +="<li>Circs Between "+start+" - "+end+"</li>";
              break;
            case 'circmod':
              sheet_display +="<li>Circ Modifier</li>";
              break;
            case 'copyid':
              sheet_display +="<li>Item Id</li>";
              break;
            case 'copystatus':
              sheet_display +="<li>Item Status</li>";
              break;
            case 'copytag':
              sheet_display +="<li>Item Tag</li>";
              break;
            case 'course':
              sheet_display +="<li>Course</li>";
              break;
             case 'coursecirc':
              sheet_display +="<li>Course Circulation</li>";
              break;
             case 'coverimage':
              sheet_display +="<li>Cover Image</li>";
              break;
             case 'createdate':
              sheet_display +="<li>Create Date</li>";
              break;
            case 'debitamount':
              sheet_display +="<li>Debit Amount</li>";
              break;
            case 'deposit':
              sheet_display +="<li>Deposit</li>";
              break;
            case 'duedate':
              sheet_display +="<li>Due Date</li>";
              break;
            case 'encumbered':
              sheet_display +="<li>Encumbered</li>";
              break;
            case 'finelevel':
              sheet_display +="<li>Fine Level</li>";
              break;
            case 'fingerprint':
              sheet_display +="<li>Fingerprint</li>";
              break;
            case 'floating':
              sheet_display +="<li>Floating</li>";
              break;
            case 'fund':
              sheet_display +="<li>Fund</li>";
              break;
            case 'goodreads':
              sheet_display +="<li>Goodreads Link</li>";
              break;
            case 'holds':
               sheet_display +="<li>Hold Count</li>";
               break
            case 'inhouse':
              sheet_display +="<li>In House Use</li>";
              break;
            case 'inventory':
              sheet_display +="<li>Inventory</li>";
              break;
             case 'invoicedate':
              sheet_display +="<li>Invoice Date</li>";
              break;
             case 'invoicecloseddate':
              sheet_display +="<li>Invoice Closed Date</li>";
              break;
            case 'invoicenum':
              sheet_display +="<li>Invoice Number</li>";
              break;
            case 'itemstatuslink':
              sheet_display +="<li>Item Status Link</li>";
              break;
            case 'allisbns':
              sheet_display +="<li>All ISBNs</li>";
              break;
            case 'firstisbn':
              sheet_display +="<li>First ISBN</li>";
              break;
            case 'checkout':
              sheet_display +="<li>Last Checkout Date</li>";
              break;
            case 'checkoutlib':
              sheet_display +="<li>Last Checkout Library</li>";
              break;
            case 'lastfy':
              sheet_display +="<li>Last FY Circs</li>";
              break;
            case 'lineitemid':
              sheet_display +="<li>Lineitem Id</li>";
              break;
            case 'lineitemstatus':
              sheet_display +="<li>Lineitem Status</li>";
              break;
            case 'loanduration':
              sheet_display +="<li>Loan Duration</li>";
              break;
            case 'marc':
              var tag = values[++i];
              var subfield = values[++i];
              sheet_display +="<li>MARC "+tag+" $"+subfield+"</li>";
              break;
            case 'oclc':
              sheet_display +="<li>OCLC Number</li>";
              break;
            case 'orderdate':
              sheet_display +="<li>Order Date</li>";
              break;
            case 'otherlibcount':
              sheet_display +="<li>Other Library Count</li>";
              break;
            case 'owninglib':
              sheet_display +="<li>Owning Library</li>";
              break;
            case 'ponum':
              sheet_display +="<li>Purchase Order Number</li>";
              break;
            case 'price':
              sheet_display +="<li>Price</li>";
              break;
            case 'publicnote':
              sheet_display +="<li>Public Note</li>";
              break;
            case 'publisher':
              sheet_display +="<li>Publisher</li>";
              break;
            case 'reference':
              sheet_display +="<li>Reference</li>";
              break;
            case 'staffnote':
              sheet_display +="<li>Staff Note</li>";
              break;
            case 'statcat':
              sheet_display +="<li>Stat Cat</li>";
              break;
            case 'statchange':
              sheet_display +="<li>Last Status Change</li>";
              break;
            case 'summary':
              sheet_display +="<li>Summary</li>";
              break;
            case 'ytdcirc':
              sheet_display +="<li>YTD Circs</li>";
              break;
         }

      }
      sheet_display += "</ul>";

      document.getElementById("spreadsheet_display").innerHTML = sheet_display;

      document.getElementById('spreadsheet').checked = true;

   }
   AllowEmailOptOut(false);

}

function configureRSS()
{
    var php_file = 'configureRSS.php';

    var rss_list_name = $(document.getElementById("rss_list")).text().trim();
    if ( !rss_list_name.includes('Not Set'))
    {
       if (php_file.includes('?')) php_file +="&list="+rss_list_name;
       else php_file +="?list="+rss_list_name;
    }

    var rss_description = $(document.getElementById("rss_description")).text().trim();
    if ( !rss_description.includes('Not Set'))
    {
       if (php_file.includes('?')) php_file +="&desc="+rss_description;
       else php_file +="?desc="+rss_description;
    }

    window.open(php_file,'name','height=350,width=800,left=10,top=10,resizable=yes,scrollbars=yes,toolbar=no,menubar=no,location=no,directories=no,status=yes');

}

function HandleRSSResult(list=null, description=null)
{
   if (!list && !description) return;

   if (list) document.getElementById("rss_list").innerHTML = list.toString();
   if (description) document.getElementById("rss_description").innerHTML = description.toString();

   document.getElementById('rss').checked = true; 
}

function configureJSON()
{
    var php_file = 'configureJSON.php';

    var data_type = $(document.getElementById("json_data_type")).text().trim();
    if (data_type =="Bib Id") data_type = "bib_id";
    else if (data_type =="ISBN") data_type = "isbn";
    php_file +="?data_type="+data_type;

    window.open(php_file,'name','height=350,width=800,left=10,top=10,resizable=yes,scrollbars=yes,toolbar=no,menubar=no,location=no,directories=no,status=yes');

}

function HandleJSONResult(data_type=null)
{
   if (!data_type) return;

   if (data_type == "bib_id") document.getElementById("json_data_type").innerHTML = "Bib Id";
   else if (data_type == "isbn") document.getElementById("json_data_type").innerHTML = "ISBN";

   document.getElementById('json').checked = true; 
   AllowEmailOptOut();
}

function configureBookbag()
{
    var php_file = 'configureBucket.php';

    php_file +="?type=bookbag";

    var bookbag_name = $(document.getElementById("bookbag_name")).text().trim();
    if ( !bookbag_name.includes('Not Set'))
    {
       php_file +="&name="+bookbag_name;
    }

    var bookbag_description = $(document.getElementById("bookbag_description")).text().trim();
    if ( !bookbag_description.includes('Not Set'))
    {
        php_file +="&desc="+bookbag_description;
    }

    var bookbag_update = $(document.getElementById("bookbag_update")).text().trim();
    if ( !bookbag_update.includes('Not Set'))
    {
       php_file +="&update="+bookbag_update;
    }

   var bookbag_owner = $(document.getElementById("bookbag_owner")).text().trim();
    if ( !bookbag_owner.includes('Not Set'))
    {
       php_file +="&owner="+bookbag_owner;
    }

    var bookbag_id = $(document.getElementById("bookbag_id")).text().trim();
    if ( !bookbag_id.includes('Not Set'))
    {
        php_file +="&id="+bookbag_id;
    }

    var carousel = $(document.getElementById("make_carousel")).text().trim();
    php_file +="&carousel="+carousel;

    window.open(php_file,'name','height=500,width=800,left=10,top=10,resizable=yes,scrollbars=yes,toolbar=no,menubar=no,location=yes,directories=no,status=yes');

}

function HandleBookbagResult(name=null, description=null, update=null, owner=null, id=null, carousel=null)
{
   if (name) document.getElementById("bookbag_name").innerHTML = name.toString();
   if (description) document.getElementById("bookbag_description").innerHTML = description.toString();
   if (update) document.getElementById("bookbag_update").innerHTML = update.toString();
   if (owner) document.getElementById("bookbag_owner").innerHTML = owner.toString();
   if (id) document.getElementById("bookbag_id").innerHTML = id.toString();
   if (carousel) document.getElementById("make_carousel").innerHTML = carousel.toString();

   document.getElementById('bookbag').checked = true; 
   AllowEmailOptOut();
}

function configureCopyBucket()
{
    var php_file = 'configureBucket.php';

    php_file +="?type=copy";

    var copy_bucket_name = $(document.getElementById("copy_bucket_name")).text().trim();
    if ( !copy_bucket_name.includes('Not Set'))
    {
       php_file +="&name="+copy_bucket_name;
    }

    var copy_bucket_description = $(document.getElementById("copy_bucket_description")).text().trim();
    if ( !copy_bucket_description.includes('Not Set'))
    {
        php_file +="&desc="+copy_bucket_description;
    }

    var copy_bucket_update = $(document.getElementById("copy_bucket_update")).text().trim();
    if ( !copy_bucket_update.includes('Not Set'))
    {
       php_file +="&update="+copy_bucket_update;
    }

   var copy_bucket_owner = $(document.getElementById("copy_bucket_owner")).text().trim();
    if ( !copy_bucket_owner.includes('Not Set'))
    {
       php_file +="&owner="+copy_bucket_owner;
    }

    var copy_bucket_id = $(document.getElementById("copy_bucket_id")).text().trim();
    if ( !copy_bucket_id.includes('Not Set'))
    {
        php_file +="&id="+copy_bucket_id;
    }

    window.open(php_file,'name','height=500,width=800,left=10,top=10,resizable=yes,scrollbars=yes,toolbar=no,menubar=no,location=yes,directories=no,status=yes');

}

function HandleCopyBucketResult(name=null, description=null, update=null, owner=null, id=null)
{
   if (name) document.getElementById("copy_bucket_name").innerHTML = name.toString();
   if (description) document.getElementById("copy_bucket_description").innerHTML = description.toString();
   if (update) document.getElementById("copy_bucket_update").innerHTML = update.toString();
   if (owner) document.getElementById("copy_bucket_owner").innerHTML = owner.toString();
   if (id) document.getElementById("copy_bucket_id").innerHTML = id.toString();

   document.getElementById('copy_bucket').checked = true; 
   AllowEmailOptOut();
}



function configurePreview()
{
   var php_file = 'configurePreview.php';

    var order= $(document.getElementById("preview_order")).text();
    php_file +="?order="+order.trim();

    var display = $(document.getElementById("preview_display")).text();
    display = display.replace(/\s+/g, '');
    php_file +="&display="+display;

    var layout = $(document.getElementById("preview_layout")).text();
    layout = layout.replace(/\s+/g, '');
    php_file +="&layout="+layout;

    var options = $(document.getElementById("preview_options")).text();
    options = options.replace(/\s+/g, '');
    php_file +="&options="+options;

    window.open(php_file,'name','height=800,width=900,left=10,top=10,resizable=yes,scrollbars=yes,toolbar=no,menubar=no,location=no,directories=no,status=yes');
}

function HandlePreviewResult(order=null, display=null, layout=null, options=null)
{
   var preview_text = "html ";

   if (!order && !display && !layout && !options) return;

   if (order)
   {
      document.getElementById("preview_order").innerHTML = order.toString();
      if (order == "Call Number") preview_text += "call_sort ";
      else if (order == "Author") preview_text += "author_sort ";
      else if (order == "Title") preview_text += "title_sort ";
   }

   if (layout)
   {
      document.getElementById("preview_layout").innerHTML = layout.toString();
      if (layout == "Block")  preview_text += "block ";
      else if (layout == "Inline")  preview_text += "inline ";
      else
      {
         var pos = layout.indexOf("Grid");
         pos +=5;
         var width = layout.substring(pos, pos+1);
         preview_text += "grid "+width+" ";
      }
   }

   if (display)
   {
      var preview_display="<ul>";
      var values = display.split('*');

      for(var i = 0; i < values.length; i++)
      {
         switch(values[i])
         {
           case 'author':
              preview_display +="<li>Author</li>";
              preview_text += "author ";
              break;
            case 'callnum':
              preview_display +="<li>Call Number</li>";
              preview_text += "call_num ";
              break;
           case 'cover':
              preview_display +="<li>Cover Image</li>";
              preview_text += "cover ";
              break;
            case 'title':
              preview_display +="<li>Title</li>";
              preview_text += "title ";
              break;
            case 'active':
              preview_display +="<li>Active Date</li>";
              preview_text += "active ";
              break;
            case 'ageprotection':
              preview_display +="<li>Age Protection</li>";
              preview_text += "age_protect ";
              break;
            case 'adirect':
              preview_display +="<li>Amazon Direct</li>";
              preview_text += "amz_direct ";
              break;
            case 'asearch':
              preview_display +="<li>Amazon Search</li>";
              preview_text += "amz_search ";
              break;
            case 'barcode':
              preview_display +="<li>Barcode</li>";
              preview_text += "barcode ";
              break;
            case 'bibid':
              preview_display +="<li>Bib Id</li>";
              preview_text += "bib_id ";
              break;
            case 'circlib':
              preview_display +="<li>Circ Lib</li>";
              preview_text += "circ_lib ";
              break;
            case 'circmod':
              preview_display +="<li>Circ Modifier</li>";
              preview_text += "circ_mod ";
              break;
            case 'copyloc':
              preview_display +="<li>Shelving Location</li>";
              preview_text += "copy_loc ";
              break;
            case 'copystatus':
              preview_display +="<li>Item Status</li>";
              preview_text += "status ";
              break;
            case 'goodreads':
              preview_display +="<li>Goodreads Link</li>";
              preview_text += "goodreads ";
              break;
            case 'google':
              preview_display +="<li>Google Books</li>";
              preview_text += "google ";
              break;
            case 'part':
              preview_display +="<li>Part</li>";
              preview_text += "part ";
              break;
            case 'pubdate':
              preview_display +="<li>Pub Date</li>";
              preview_text += "pub_date ";
              break;
            case 'publisher':
              preview_display +="<li>Publisher</li>";
              preview_text += "publisher ";
              break;
            case 'statcat':
              preview_display +="<li>Stat Cat</li>";
              preview_text += "stat_cat ";
              break;
            case 'statuschange':
              preview_display +="<li>Last Status Change</li>";
              preview_text += "stat_change ";
              break;
            case 'summary':
              preview_display +="<li>Summary</li>";
              preview_text += "summary ";
              break;
         }

      }
      preview_display += "</ul>";

      document.getElementById("preview_display").innerHTML = preview_display;

   }

   if (options)
   {
      var preview_options="<ul>";
      var values = options.split('*');

      for(var i = 0; i< values.length; i++)
      {
         switch(values[i])
         {
           case 'imagesmall':
              preview_options +="<li>Image Size Small</li>";
              preview_text += "image_size small ";
              break;
           case 'imagemedium':
              preview_options +="<li>Image Size Medium</li>";
              preview_text += "image_size medium ";
              break;
          case 'imagelarge':
              preview_options +="<li>Image Size Large</li>";
              preview_text += "image_size large ";
              break;
           case 'groupfirst':
              preview_options +="<li>Group Items First</li>";
              preview_text += "group_copy 1 ";
              break;
            case 'groupall':
              preview_options +="<li>Group Items All</li>";
              preview_text += "group_copy all ";
              break;
         }
      }
      preview_options += "</ul>";

      document.getElementById("preview_options").innerHTML = preview_options;
   }
   else
   {
      document.getElementById("preview_options").innerHTML = "";
   }

   document.getElementById("preview_text").value = preview_text;

}

function uploadFile()
{
    var php_file = 'upload_file.php';

    window.open(php_file,'name','height=700,width=800,left=10,top=10,resizable=yes,scrollbars=yes,toolbar=no,menubar=no,location=no,directories=no,status=yes');

}

function HandleFileResult(filename, data_type, file_type)
{
  if (filename)
  {
     document.getElementById('file_name').innerHTML= "File: "+filename+"<br />";
     document.getElementById('data_type').innerHTML= "Data: "+data_type+"<br />";
     document.getElementById('file_type').innerHTML= "Format: "+file_type+"<br />";

     document.getElementById('input_file_name').value = filename;
     document.getElementById('input_data_type').value = data_type;
     document.getElementById('input_file_type').value = file_type;

     document.getElementById('upload_button').style.display = 'none';
     document.getElementById('clear_file_button').style.display = 'block';
     //change button to be a clear file button

     //if the file is bib - allow electroic to be real
     if (data_type == "bib" || data_type == "isbn")
     {
        document.getElementById('electronic').disabled = false;
        document.getElementById('electronic').value="physical_electronic";
     }
  }
}

function clearFile()
{
   document.getElementById('file_name').innerHTML= "";
   document.getElementById('data_type').innerHTML= "";
   document.getElementById('file_type').innerHTML= "";

   document.getElementById('input_file_name').value = -1;
   document.getElementById('input_data_type').value = -1;
   document.getElementById('input_file_type').value = -1;

   document.getElementById('upload_button').style.display = 'block';
   document.getElementById('clear_file_button').style.display = 'none';

   //make electronic unselectable
   if (document.getElementById('use_active').checked == false)
   {
      document.getElementById('electronic').disabled = true;
      document.getElementById('electronic').value="physical_only";
   }
}


// Validates that the input string is a valid date formatted as "mm/dd/yyyy"
function isValidDate(dateString, future_allowed=false)
{
    // First check for the pattern
    if(!/^\d{1,2}\/\d{1,2}\/\d{4}$/.test(dateString))
        return false;

    // Parse the date parts to integers
    var parts = dateString.split("/");
    var day = parseInt(parts[1], 10);
    var month = parseInt(parts[0], 10);
    var year = parseInt(parts[2], 10);

    var today = new Date();

    if (!future_allowed)
    {
       if (today.getFullYear() < year)
       {
         return false;
       }
       else if (today.getFullYear() == year )
       {
         if(today.getMonth() < (month-1))
         {
            return false;
         }
         else if (today.getMonth() == (month-1))
         {
            if (today.getDate() < day) return false;
         }
       }
    }

    // Check the ranges of month and year
    if(year < 2000 || year > 3000 || month == 0 || month > 12) return false;

    var monthLength = [ 31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31 ];

    // Adjust for leap years
    if(year % 400 == 0 || (year % 100 != 0 && year % 4 == 0))  monthLength[1] = 29;

    // Check the range of the day
    return day > 0 && day <= monthLength[month - 1];
}


function CheckPreviewForm()
{
  //check that all that required boxes have been filled
   //if not throw error about the what isn't right

   if (!document.getElementById("preview_report").checked && !document.getElementById("preview_out").checked)
   {
      CreateReport();
      return false;
   }

   var using_filters = false;
   var lib = document.getElementById('library');
   var LibName = lib.options[lib.selectedIndex].value;

   //check library
   if(LibName == "NONE")
   {
      //select a library
      swal('Error', "Please Select a Library.", 'error');
      return false;
   }

   var locations = new Array();
	var copy_locs = document.getElementsByName('copy_loc_checkboxes[]');
	for(var i=0; i<copy_locs.length; i++)
	{
		 if (copy_locs[i].checked)
		 {
			 locations.push(copy_locs[i].value);
		 }
	}


   var all_loc = document.getElementById('all_locations').checked;

   var loc_grp = document.getElementById('copy_loc_group').value;

   //check copy location
   if (all_loc == false && locations.length < 1 && loc_grp == '-1')
   {
      //select a copy location
      swal('Error', "Please select a Shelving Location or Group.", "error");
      return false;
   }

	//last status change
	if (document.getElementById("status_change_check").checked)
	{
	   var status_date_type = document.getElementById('status_date_type').value;
		var stat = document.getElementById('stat_time_type');
		var stat_time =  stat.options[stat.selectedIndex].value;

		//checked for errors before
		if (status_date_type == "absolute")
		{
			 var stat_start = document.getElementById('status_date_start').value;
			 if (!isValidDate(stat_start))
			 {
				 swal('Error', "Please format status date as MM/DD/YYYY or use datepicker. Dates cannot be before 2012 and cannot be in the future.", 'error');
				 return false;
			 }

			 var stat_end = document.getElementById('status_date_end').value;
			 if (stat_time == "between" && !isValidDate(stat_end))
			 {
				 swal('Error', "Please format status date as MM/DD/YYYY or use datepicker. Dates cannot be before 2012 and cannot be in the future.", 'error');
				 return false;
			 }

			 var start = new Date(stat_start);
			 var end = new Date(stat_end);

			 if (stat_time == "between" && start > end )
			 {
				 swal('Error', "The range of status dates is invalid. Please set first date earlier than the second.", 'error');
				 return false;
			 }
		}
		else if(status_date_type == "relative")
		{
			 var stat_start = document.getElementById('status_date_start_relative').value;
			 var time1 = document.getElementById('stat_start_time');
			 var start_time =  time1.options[time1.selectedIndex].value;
			 var start_out = stat_start+"_"+start_time;

			 var stat_end = document.getElementById('status_date_end_relative').value;
			 var time2 = document.getElementById('stat_end_time');
			 var end_time =  time2.options[time2.selectedIndex].value;
			 var end_out = stat_end+"_"+end_time;

			 if (stat_start.length < 1 || (stat_time =="between" && stat_end.length < 1 ) )
			 {
				 swal('Error', "Please complete all values for filter by status date .", 'error');
				 return false;
			 }
		}

		using_filters = true;
	}

   //look at active date
   if (document.getElementById("use_active").checked)
   {
       var added_date_type = document.getElementById('added_date_type').value;
       var add = document.getElementById('added_time_type');
       var added_time =  add.options[add.selectedIndex].value;

       //checked for errors before
       if(added_date_type == "absolute")
       {
			 var active_start = document.getElementById('active_start').value;
			 if (!isValidDate(active_start))
			 {
				 swal('Error', "Please format added date as MM/DD/YYYY or use datepicker. Dates cannot be before 2000 and cannot be in the future.", 'error');
				 return false;
			 }

			 var active_end = document.getElementById('active_end').value;
			 if (added_time == "between" && !isValidDate(active_end))
			 {
				 swal('Error', "Please format added date as MM/DD/YYYY or use datepicker. Dates cannot be before 2000 and cannot be in the future.", 'error');
			  	 return false;
			 }

			 var start = new Date(active_start);
			 var end = new Date(active_end);

			 if (added_time == "between" && start > end )
			 {
		   	 swal('Error', "The range of added dates is invalid. Please set first date earlier than the second.", 'error');
			 	 return false;
			 }

			 using_filters = true;
		 }
		 else if(added_date_type == "relative")
       {
          var active_start = document.getElementById('active_start_relative').value;
          var time1 = document.getElementById('added_start_time');
          var start_time =  time1.options[time1.selectedIndex].value;
          var start_out = active_start+"_"+start_time;

          var active_end = document.getElementById('active_end_relative').value;
          var time2 = document.getElementById('added_end_time');
          var end_time =  time2.options[time2.selectedIndex].value;
          var end_out = active_end+"_"+end_time;

          if (active_start.length < 1 || (added_time =="between" && active_end.length < 1 ) )
          {
             swal('Error', "Please complete all values for filter by active date .", 'error');
			 	 return false;
          }

          using_filters = true;
      }

   }

    //*******************************************
   var call_class = document.getElementById('call_class');
   var ClassVal = call_class.options[call_class.selectedIndex].value;

   if (ClassVal != "0")
   {
      //a call class was chosen, so a check which filter was picked
      if (ClassVal == "4")//Bisac
      {
         if (!document.getElementById("bisac_call").checked && !document.getElementById("call_num_contains").checked)
         {
             swal('Error', "Please Select a Call Number Method", 'error');
             return false;
         }
         else if (document.getElementById("bisac_call").checked)
         {
             var level1 = document.getElementById('level1');
             var Value1 = level1.options[level1.selectedIndex].value;

             if (Value1 < 1)
             {
                swal('Error', "Please Select a BISAC Category ", 'error');
                return false;
             }

             using_filters = true;
         }
         else if (document.getElementById("call_num_contains").checked)
         {
            var contains_call = document.getElementById('contains_call').value;
            if (contains_call.length > 1)
            {
                 //only contains selected
                using_filters = true;
            }
            else
            {
                swal('Error', "Please Enter a Call Contains Value ", 'error');
                return false;
            }
         }
      }
      else if (ClassVal == "2" || ClassVal == "3")//LC or Dewey
      {
         if (!document.getElementById("call_num_range").checked)
         {
             swal('Error', "Please Select a Call Number Method", 'error');
             return false;
         }
         else if (document.getElementById("call_num_range").checked)
         {
            var start_call = document.getElementById('start_call').value;
				var end_call = document.getElementById('end_call').value;

				if( (start_call.length > 0 && end_call.length > 0) )
				{
					//prevent people from entering the entire call range
					if ((ClassVal == 3 && start_call.toLowerCase().indexOf("a") === 0 && end_call.toLowerCase().indexOf("z") === 0) ||
						 (ClassVal == 2 && start_call.indexOf("0") === 0 && end_call.indexOf("9") === 0 ) )
					{
						swal('Error', "Please Enter a subset of Call Number Range", 'error');
						return false;
					}
					else
					{
						using_filters = true;
					}

				}//has range
				else
				{
				   swal('Error', "Please Enter a Call Number Range  ", 'error');
               return false;
				}
         }

      }
      else if (ClassVal == "1" )//Generic
      {

         if (!document.getElementById("call_num_range").checked && !document.getElementById("call_num_contains").checked)
         {
             swal('Error', "Please Select a Call Number Method", 'error');
             return false;
         }
         else if (document.getElementById("call_num_range").checked)
         {
            var start_call = document.getElementById('start_call').value;
				var end_call = document.getElementById('end_call').value;

				if( (start_call.length > 0 && end_call.length > 0) )
				{
					//prevent people from entering the entire call range
					if (start_call.toLowerCase().indexOf("a") === 0 && end_call.toLowerCase().indexOf("z") === 0)
					{
						swal('Error', "Please Enter a subset of Call Number Range", 'error');
						return false;
					}
					else
					{
						using_filters = true;
					}

				}//has range
				else
				{
				   swal('Error', "Please Enter a Call Number Range  ", 'error');
               return false;
				}
         }
         else if(document.getElementById("call_num_contains").checked)
         {
            var contains_call = document.getElementById('contains_call').value;
            if (contains_call.length > 1)
            {
                using_filters = true;
            }
            else
            {
                swal('Error', "Please Enter a Call Contains Value ", 'error');
                return false;
            }

         }
      }


   }//call class is set

   var stat_cat = document.getElementById('stat_cats').value;
	if (stat_cat.length > 0)
	{
	    var num_stats = stat_cat.split('*').length - 1;
	    if (num_stats > 1)
	    {
	       swal('Error', "Only one stat cat can be used with Preview.", 'error');
          return false;
	    }
	    if (stat_cat != -1)using_filters = true;
	}

   var temp = $(document.getElementById("file_name")).text();
	if (temp.length > 0)
	{
	   using_filters = true;
	}

   if (!using_filters && LibName == "NOBLE")
   {
      swal('Error', "With NOBLE option at least one filter MUST be chosen.", 'error');
      return false;
   }
}

function CreateReport(update, copy_report)
{

   //check that all that required boxes have been filled
   //if not throw error about the what isn't right
   var using_filters = false;
   var lib = document.getElementById('library');
   var LibName = lib.options[lib.selectedIndex].value;
   var ignore_out_name = false;
   var is_noble = false;
   var has_ok_noble_filter = false;
   var noble_filter_count = 0;

   //check library
   if(LibName == "NONE")
   {
      //select a library
      swal('Error', "Please Select a Library.", 'error');
      return false;
   }

   if (LibName == "NOBLE") is_noble = true;

   var all_loc = document.getElementById('all_locations').checked;

   //get the value for locations
   var locations = new Array();
	var copy_locs = document.getElementsByName('copy_loc_checkboxes[]');
	for(var i=0; i<copy_locs.length; i++)
	{
		 if (copy_locs[i].checked)
		 {
			 locations.push(copy_locs[i].value);
		 }
	}

   var loc_grp = document.getElementById('copy_loc_group').value;

   //check copy location
   if (all_loc == false && locations.length < 1 && loc_grp == '-1')
   {
      //select a copy location
      swal('Error', "Please select a Shelving Location or Group.", "error");
      return false;
   }

   if ( document.getElementById("weeding_report").checked ||  document.getElementById("shelf_sitter").checked)
   {
      var checkin_date_type = document.getElementById('checkin_date_type').value;
      var checkindate = document.getElementById('last_checkin_date').value;
      var rel_checkin = document.getElementById('checkin_date_relative').value;

      if (checkin_date_type == "absolute" && !isValidDate(checkindate))
      {
         swal('Error', "Please format checkout date as MM/DD/YYYY or use datepicker. Dates cannot be before 2000 and cannot be in the future.", 'error');
         return false;
      }
      else if (checkin_date_type == "relative" && rel_checkin.length < 1)
      {
          swal('Error', "Please enter an number for relative checkin date", 'error');
         return false;
      }
   }

   var email_address = document.getElementById('email').value;
   //check check in date
   if (email_address.length < 1 || email_address.indexOf('@') == -1)
   {
      swal('Error', "Please Enter an Email Address", 'error');
      return false;
   }

   if (!document.getElementById('spreadsheet').checked && !document.getElementById('html').checked &&
       !document.getElementById('rss').checked && !document.getElementById('bookbag').checked  && !document.getElementById('copy_bucket').checked
       && !document.getElementById('json').checked)
   {
      swal('Error', "Please Select an Output Format", 'error');
      return false;
   }


   //else send a message to say it has worked and you will be getting an email
   //then clear the form

   //call a php file  to call command line and send email
   var branch = document.getElementById('branch_filter');
   var BranchName = branch.options[branch.selectedIndex].value;

   if (BranchName == "ALL" || BranchName == "NONE")
   {
      ajax.setVar("lib",LibName);
   }
   else
   {
      ajax.setVar("lib",BranchName);
   }

   if (all_loc == true)
   {
      selected_copy_loc = "all";
      ajax.setVar("loc",selected_copy_loc);
   }
   else if(loc_grp != '-1')
   {
      //using a group instead of location
       ajax.setVar("loc_grp",loc_grp);
   }
   else
   {
      ajax.setVar("loc",locations);
   }


   ajax.setVar("email",email_address);

   var report_type ;
   if (document.getElementById("weeding_report").checked || document.getElementById("shelf_sitter").checked)
   {
      var checkin_date_type = document.getElementById('checkin_date_type').value;

      //checked for errors before
      if (checkin_date_type == "absolute")
      {
         var checkindate = document.getElementById('last_checkin_date').value;
         ajax.setVar("checkin_date", checkindate);
      }
      else if (checkin_date_type == "relative")
      {
         var rel_checkin = document.getElementById('checkin_date_relative').value;
         var time = rel_checkin+"_"+document.getElementById('checkin_time').value;
         ajax.setVar("checkin_date_relative", time);
      }
      ajax.setVar("report_type","weeding");

   }
   else if (document.getElementById("inventory_report").checked || document.getElementById("new_items").checked
            || document.getElementById("file_upload").checked || document.getElementById("status_change").checked)
   {
      ajax.setVar("report_type","inventory");

      //now look at status
      var selected_status = new Array();
      var status = document.getElementsByName('status_checkboxes[]');
      for(var i=0; i<status.length; i++)
      {
          if (status[i].checked)
          {
             selected_status.push(status[i].value);
          }
      }

      if(selected_status.length > 0)
      {
          ajax.setVar("status",selected_status);
          using_filters = true;
      }

      //last status change
      if (document.getElementById("status_change_check").checked)
      {
         var status_date_type = document.getElementById('status_date_type').value;
         var stat = document.getElementById('stat_time_type');
         var stat_time =  stat.options[stat.selectedIndex].value;

         //checked for errors before
         if (status_date_type == "absolute")
         {
             var stat_start = document.getElementById('status_date_start').value;
				 if (!isValidDate(stat_start))
				 {
					 swal('Error', "Please format status date as MM/DD/YYYY or use datepicker. Dates cannot be before 2012 and cannot be in the future.", 'error');
					 return false;
				 }

				 var stat_end = document.getElementById('status_date_end').value;
				 if (stat_time == "between" && !isValidDate(stat_end))
				 {
					 swal('Error', "Please format status date as MM/DD/YYYY or use datepicker. Dates cannot be before 2012 and cannot be in the future.", 'error');
					 return false;
				 }

				 var start = new Date(stat_start);
				 var end = new Date(stat_end);

				 if (stat_time == "between" && start > end )
				 {
					 swal('Error', "The range of status dates is invalid. Please set first date earlier than the second.", 'error');
					 return false;
				 }

				 ajax.setVar("stat_date_type", "absolute");
				 ajax.setVar("stat_start",stat_start);
				 ajax.setVar("stat_time_type", stat_time);
				 if( stat_time == "between")ajax.setVar("stat_end",stat_end);

         }
         else if(status_date_type == "relative")
         {
				 var stat_start = document.getElementById('status_date_start_relative').value;
				 var time1 = document.getElementById('stat_start_time');
				 var start_time =  time1.options[time1.selectedIndex].value;
				 var start_out = stat_start+"_"+start_time;

				 var stat_end = document.getElementById('status_date_end_relative').value;
				 var time2 = document.getElementById('stat_end_time');
				 var end_time =  time2.options[time2.selectedIndex].value;
				 var end_out = stat_end+"_"+end_time;

				 if (stat_start.length < 1 || (stat_time =="between" && stat_end.length < 1 ) )
				 {
					 swal('Error', "Please complete all values for filter by status date .", 'error');
					 return false;
				 }

				 if (stat_time =="between")
				 {
					 if (start_time == end_time)
					 {
						 if (stat_start > stat_end)
						 {
							 ajax.setVar("stat_start",start_out);
							 ajax.setVar("stat_end",end_out);
						 }
						 else
						 {
							 ajax.setVar("stat_start",end_out);
							 ajax.setVar("stat_end",start_out);
						 }
					 }
					 else //they are not the same unit
					 {
						 if (start_time == "days")
						 {
							 //the end time is weeks or months so end is really start cause it's further in past
							 ajax.setVar("stat_start",end_out);
							 ajax.setVar("stat_end",start_out);
						 }
						 else if (start_time == "weeks")
						 {
							 if (end_time == "days")
							 {
								 //the end time is days so the start time of weeks is further in past
								 ajax.setVar("stat_start",start_out);
								 ajax.setVar("stat_end",end_out);
							 }
							 else if (end_time == "months" || end_time == "years" )
							 {
								 //weeks is less than months so end time is really start cause it's further in past
								 ajax.setVar("stat_start",end_out);
								 ajax.setVar("stat_end",start_out);
							 }
						 }
						 else if (start_time == "months")
						 {
							 if (end_time == "days" || end_time == "weeks")
							 {
								 //the end time is days so the start time of weeks is further in past
								 ajax.setVar("stat_start",start_out);
								 ajax.setVar("stat_end",end_out);
							 }
							 else if (end_time == "years" )
							 {
								 //weeks is less than months so end time is really start cause it's further in past
								 ajax.setVar("stat_start",end_out);
								 ajax.setVar("stat_end",start_out);
							 }
						 }
						 else if (start_time == "years")
						 {
							 //the end time is days or weeks so the start time is further in past
							 ajax.setVar("stat_start",start_out);
							 ajax.setVar("stat_end",end_out);
						 }
					 }
				 }
				 else
				 {
					 ajax.setVar("stat_start",start_out);
				 }

				 ajax.setVar("stat_time_type", stat_time);
				 ajax.setVar("stat_date_type", "relative");
         }

         using_filters = true;
      }


      //deleted
      var del = document.getElementById('deleted');
      var act_del = del.options[del.selectedIndex].value;
      ajax.setVar("deleted",act_del);

      if (document.getElementById("use_deleted_date").checked)
      {
         var deleted_date_type = document.getElementById('deleted_date_type').value;
         var del = document.getElementById('deleted_time_type');
         var del_time =  del.options[del.selectedIndex].value;

         //checked for errors before
         if (deleted_date_type == "absolute")
         {
            var del_start = document.getElementById('deleted_date_start').value;
				 if (!isValidDate(del_start))
				 {
					 swal('Error', "Please format deleted date as MM/DD/YYYY or use datepicker. Dates cannot be before 2012 and cannot be in the future.", 'error');
					 return false;
				 }

				 var del_end = document.getElementById('deleted_date_end').value;
				 if (stat_time == "between" && !isValidDate(del_end))
				 {
					 swal('Error', "Please format deleted date as MM/DD/YYYY or use datepicker. Dates cannot be before 2012 and cannot be in the future.", 'error');
					 return false;
				 }

				 var start = new Date(del_start);
				 var end = new Date(del_end);

				 if (del_time == "between" && start > end )
				 {
					 swal('Error', "The range of deleted dates is invalid. Please set first date earlier than the second.", 'error');
					 return false;
				 }

				 ajax.setVar("deleted_date_type", "absolute");
				 ajax.setVar("deleted_start",del_start);
				 ajax.setVar("deleted_time_type", del_time);
				 if( del_time == "between")ajax.setVar("deleted_end",del_end);
         }
         else if(deleted_date_type == "relative")
          {
				 var del_start = document.getElementById('deleted_date_start_relative').value;
				 var time1 = document.getElementById('deleted_start_time');
				 var start_time =  time1.options[time1.selectedIndex].value;
				 var start_out = del_start+"_"+start_time;

				 var del_end = document.getElementById('deleted_date_end_relative').value;
				 var time2 = document.getElementById('deleted_end_time');
				 var end_time =  time2.options[time2.selectedIndex].value;
				 var end_out = del_end+"_"+end_time;

				 if (del_start.length < 1 || (del_time =="between" && del_end.length < 1 ) )
				 {
					 swal('Error', "Please complete all values for filter by deleted date .", 'error');
					 return false;
				 }

				 if (del_time =="between")
				 {
					 if (start_time == end_time)
					 {
						 if (del_start > del_end)
						 {
							 ajax.setVar("deleted_start",start_out);
							 ajax.setVar("deleted_end",end_out);
						 }
						 else
						 {
							 ajax.setVar("deleted_start",end_out);
							 ajax.setVar("deleted_end",start_out);
						 }
					 }
					 else //they are not the same unit
					 {
						 if (start_time == "days")
						 {
							 //the end time is weeks or months so end is really start cause it's further in past
							 ajax.setVar("deleted_start",end_out);
							 ajax.setVar("deleted_end",start_out);
						 }
						 else if (start_time == "weeks")
						 {
							 if (end_time == "days")
							 {
								 //the end time is days so the start time of weeks is further in past
								 ajax.setVar("deleted_start",start_out);
								 ajax.setVar("deleted_end",end_out);
							 }
							 else if (end_time == "months" || end_time == "years" )
							 {
								 //weeks is less than months so end time is really start cause it's further in past
								 ajax.setVar("deleted_start",end_out);
								 ajax.setVar("deleted_end",start_out);
							 }
						 }
						 else if (start_time == "months")
						 {
							 if (end_time == "days" || end_time == "weeks")
							 {
								 //the end time is days so the start time of weeks is further in past
								 ajax.setVar("deleted_start",start_out);
								 ajax.setVar("deleted_end",end_out);
							 }
							 else if (end_time == "years" )
							 {
								 //weeks is less than months so end time is really start cause it's further in past
								 ajax.setVar("deleted_start",end_out);
								 ajax.setVar("deleted_end",start_out);
							 }
						 }
						 else if (start_time == "years")
						 {
							 //the end time is days or weeks so the start time is further in past
							 ajax.setVar("deleted_start",start_out);
							 ajax.setVar("deleted_end",end_out);
						 }
					 }
				 }
				 else
				 {
					 ajax.setVar("deleted_start",start_out);
				 }

				 ajax.setVar("deleted_time_type", del_time);
				 ajax.setVar("deleted_date_type", "relative");
         }

         using_filters = true;
      }

      //electronic
      //var ele = document.getElementById('electronic');
      //var phys_ele = ele.options[ele.selectedIndex].value;
      //ajax.setVar("electronic",phys_ele);
   }

   if (document.getElementById("use_pub").checked)
   {
      var pub = document.getElementById('pub_time_type');
      var pub_time =  pub.options[pub.selectedIndex].value;

      var pubdate = document.getElementById('pub_date').value;
      if (pub_time != "none" && pubdate.length < 4 )
      {
         swal('Error', "Please enter a 4 digit pub date.", 'error');
         return false;
      }

      if (pub_time == "none")
      {
          ajax.setVar("include_null_pub_date", "include_null_pub_date");
      }
      else if (pub_time == "before")
      {
         ajax.setVar("pub_before",pubdate);
         if (document.getElementById("include_null_pub_date").checked) ajax.setVar("include_null_pub_date", "include_null_pub_date");

      }
      else if (pub_time == "after")
      {
         ajax.setVar("pub_after",pubdate);
      }
      else if (pub_time == "between")
      {
         var pubdate2 = document.getElementById('pub_date2').value;

         if (pubdate2.length < 4 )
         {
            swal('Error', "Please enter a 4 digit pub date.", 'error');
            return false;
         }
         ajax.setVar("pub_between_start",pubdate);
         ajax.setVar("pub_between_end",pubdate2);

      }


      using_filters = true;
      if (is_noble) noble_filter_count++;
   }

   //look at active date
   if (document.getElementById("use_active").checked)
   {
       var added_date_type = document.getElementById('added_date_type').value;
       var add = document.getElementById('added_time_type');
       var added_time =  add.options[add.selectedIndex].value;

       var ele = document.getElementById('electronic');
       var phy_ele = ele.options[ele.selectedIndex].value;
       ajax.setVar("electronic",phy_ele);

       //checked for errors before
       if(added_date_type == "absolute")
       {
			 var active_start = document.getElementById('active_start').value;
			 if (!isValidDate(active_start))
			 {
				 swal('Error', "Please format added date as MM/DD/YYYY or use datepicker. Dates cannot be before 2000 and cannot be in the future.", 'error');
				 return false;
			 }

			 var active_end = document.getElementById('active_end').value;
			 if (added_time == "between" && !isValidDate(active_end))
			 {
				 swal('Error', "Please format added date as MM/DD/YYYY or use datepicker. Dates cannot be before 2000 and cannot be in the future.", 'error');
			  	 return false;
			 }

			 var start = new Date(active_start);
			 var end = new Date(active_end);

			 if (added_time == "between" && start > end )
			 {
		   	 swal('Error', "The range of added dates is invalid. Please set first date earlier than the second.", 'error');
			 	 return false;
			 }


			 ajax.setVar("active_type", "absolute");
			 ajax.setVar("active_start",active_start);
			 ajax.setVar("active_time_type", added_time);
			 if( added_time == "between")ajax.setVar("active_end",active_end);

       }
       else if(added_date_type == "relative")
       {
          var active_start = document.getElementById('active_start_relative').value;
          var time1 = document.getElementById('added_start_time');
          var start_time =  time1.options[time1.selectedIndex].value;
          var start_out = active_start+"_"+start_time;

          var active_end = document.getElementById('active_end_relative').value;
          var time2 = document.getElementById('added_end_time');
          var end_time =  time2.options[time2.selectedIndex].value;
          var end_out = active_end+"_"+end_time;

          if (active_start.length < 1 || (added_time =="between" && active_end.length < 1 ) )
          {
             swal('Error', "Please complete all values for filter by active date .", 'error');
			 	 return false;
          }

          if (added_time =="between")
          {
				 if (start_time == end_time)
				 {
					 if (active_start > active_end)
					 {
						 ajax.setVar("active_start",start_out);
						 ajax.setVar("active_end",end_out);
					 }
					 else
					 {
						 ajax.setVar("active_start",end_out);
						 ajax.setVar("active_end",start_out);
					 }
				 }
				 else //they are not the same unit
				 {
					 if (start_time == "days")
					 {
						 //the end time is weeks or months so end is really start cause it's further in past
						 ajax.setVar("active_start",end_out);
						 ajax.setVar("active_end",start_out);
					 }
					 else if (start_time == "weeks")
					 {
						 if (end_time == "days")
						 {
							 //the end time is days so the start time of weeks is further in past
							 ajax.setVar("active_start",start_out);
							 ajax.setVar("active_end",end_out);
						 }
						 else if (end_time == "months" || end_time == "years" )
						 {
							 //weeks is less than months so end time is really start cause it's further in past
							 ajax.setVar("active_start",end_out);
							 ajax.setVar("active_end",start_out);
						 }
					 }
					 else if (start_time == "months")
					 {
						 if (end_time == "days" || end_time == "weeks")
						 {
							 //the end time is days so the start time of weeks is further in past
							 ajax.setVar("active_start",start_out);
							 ajax.setVar("active_end",end_out);
						 }
						 else if (end_time == "years" )
						 {
							 //weeks is less than months so end time is really start cause it's further in past
							 ajax.setVar("active_start",end_out);
							 ajax.setVar("active_end",start_out);
						 }
					 }
					 else if (start_time == "years")
					 {
						 //the end time is days or weeks so the start time is further in past
						 ajax.setVar("active_start",start_out);
						 ajax.setVar("active_end",end_out);
					 }
				 }
          }
          else
          {
             ajax.setVar("active_start",start_out);
          }

          ajax.setVar("active_time_type", added_time);
          ajax.setVar("active_type", "relative");
       }

      using_filters = true;
      if (is_noble)
      {
         noble_filter_count++;
         has_ok_noble_filter = true;
      }
   }

   var selected_circ_mod = new Array();
   var circ_mods = document.getElementsByName('circ_mod_checkboxes[]');
   for(var i=0; i<circ_mods.length; i++)
   {
       if (circ_mods[i].checked)
       {
          selected_circ_mod.push(circ_mods[i].value);
       }
   }

   if (selected_circ_mod.length > 0)
   {
      ajax.setVar("circ_mod",selected_circ_mod);
      using_filters = true;
   }

   var selected_prefix = new Array();
   var prefixes = document.getElementsByName('prefix_checkboxes[]');
   for(var i=0; i<prefixes.length; i++)
   {
       if (prefixes[i].checked)
       {
          selected_prefix.push(prefixes[i].value);
       }
   }

   if (selected_prefix.length > 0)
   {
      ajax.setVar("prefix",selected_prefix);
      using_filters = true;
   }


   var selected_suffix = new Array();
   var suffixes = document.getElementsByName('suffix_checkboxes[]');
   for(var i=0; i<suffixes.length; i++)
   {
       if (suffixes[i].checked)
       {
          selected_suffix.push(suffixes[i].value);
       }
   }

   if (selected_suffix.length > 0)
   {
      ajax.setVar("suffix",selected_suffix);
      using_filters = true;
   }

   //*******************************************
   var call_class = document.getElementById('call_class');
   var ClassVal = call_class.options[call_class.selectedIndex].value;

   if (ClassVal != "0")
   {
      //a call class was chosen, so a check which filter was picked
      if (ClassVal == "4")//Bisac
      {
         if (!document.getElementById("bisac_call").checked && !document.getElementById("call_num_contains").checked)
         {
             swal('Error', "Please Select a Call Number Method", 'error');
             return false;
         }
         else if (document.getElementById("bisac_call").checked)
         {
             var level1 = document.getElementById('level1');
             var Value1 = level1.options[level1.selectedIndex].value;
             var bisac_cats = Value1;

             if (Value1 < 1)
             {
                swal('Error', "Please Select a BISAC Category ", 'error');
                return false;
             }

            //only contains selected
             var level2 = document.getElementById('level2');
             var Value2 = level2.options[level2.selectedIndex].value;

             if (Value2 != "-1")
             {
                bisac_cats +="-"+Value2;
                var level3= document.getElementById('level3');
                var Value3 = level3.options[level3.selectedIndex].value;

                if(Value3 != "-1")
                {
                   bisac_cats +="-"+Value3;
                }
             }

             ajax.setVar("call_class",ClassVal);
             ajax.setVar("bisac",bisac_cats);
             using_filters = true;
         }
         else if (document.getElementById("call_num_contains").checked)
         {
            var contains_call = document.getElementById('contains_call').value;
            if (contains_call.length > 1)
            {
                 //only contains selected
                ajax.setVar("call_class",ClassVal);
                ajax.setVar("contains_call",contains_call);
                using_filters = true;
            }
            else
            {
                swal('Error', "Please Enter a Call Contains Value ", 'error');
                return false;
            }


         }
      }
      else if (ClassVal == "2" || ClassVal == "3")//LC or Dewey
      {
         if (!document.getElementById("call_num_range").checked && !document.getElementById("coll_topic").checked)
         {
             swal('Error', "Please Select a Call Number Method", 'error');
             return false;
         }
         else if (document.getElementById("call_num_range").checked)
         {
            var start_call = document.getElementById('start_call').value;
				var end_call = document.getElementById('end_call').value;

				if( (start_call.length > 0 && end_call.length > 0) )
				{
					//prevent people from entering the entire call range
					if ((ClassVal == 3 && start_call.toLowerCase().indexOf("a") === 0 && end_call.toLowerCase().indexOf("z") === 0) ||
						 (ClassVal == 2 && start_call.indexOf("0") === 0 && end_call.indexOf("9") === 0 ) )
					{
						swal('Error', "Please Enter a subset of Call Number Range", 'error');
						return false;
					}
					else
					{
						ajax.setVar("call_class",ClassVal);
						ajax.setVar("start_call",start_call);
						ajax.setVar("end_call",end_call);
						using_filters = true;
					}

				}//has range
				else
				{
				   swal('Error', "Please Enter a Call Number Range  ", 'error');
               return false;
				}
         }
         else if (document.getElementById("coll_topic").checked)
         {
            var coll = document.getElementById('coll_man');

            selected_coll = new Array();
            for (var i = 0; i < coll.options.length; i++)
            {
               if (coll.options[ i ].selected)
               {
                  selected_coll.push(coll.options[ i ].value);
               }
            }

            if (selected_coll.length > 0)
            {
               ajax.setVar("call_class",ClassVal);
               ajax.setVar("coll_man",selected_coll);
               using_filters = true;
            }
            else
            {
                swal('Error', "Please Select Collection Topic ", 'error');
                return false;
            }
         }

      }
      else if (ClassVal == "1" )//Generic
      {

         if (!document.getElementById("call_num_range").checked && !document.getElementById("call_num_contains").checked)
         {
             swal('Error', "Please Select a Call Number Method", 'error');
             return false;
         }
         else if (document.getElementById("call_num_range").checked)
         {
            var start_call = document.getElementById('start_call').value;
				var end_call = document.getElementById('end_call').value;

				if( (start_call.length > 0 && end_call.length > 0) )
				{
					//prevent people from entering the entire call range
					if (start_call.toLowerCase().indexOf("a") === 0 && end_call.toLowerCase().indexOf("z") === 0)
					{
						swal('Error', "Please Enter a subset of Call Number Range", 'error');
						return false;
					}
					else
					{
						ajax.setVar("call_class",ClassVal);
						ajax.setVar("start_call",start_call);
						ajax.setVar("end_call",end_call);
						using_filters = true;
					}

				}//has range
				else
				{
				   swal('Error', "Please Enter a Call Number Range  ", 'error');
               return false;
				}
         }
         else if(document.getElementById("call_num_contains").checked)
         {
            var contains_call = document.getElementById('contains_call').value;
            if (contains_call.length > 1)
            {
                 //only contains selected
                ajax.setVar("call_class",ClassVal);
                ajax.setVar("contains_call",contains_call);
                using_filters = true;
            }
            else
            {
                swal('Error', "Please Enter a Call Contains Value ", 'error');
                return false;
            }

         }
      }


   }//call class is set
   else if (LibName == "NOBLE" && ClassVal == "0")
   {
      var coll = document.getElementById('coll_man');

		selected_coll = new Array();
		for (var i = 0; i < coll.options.length; i++)
		{
			if (coll.options[ i ].selected)
			{
				selected_coll.push(coll.options[ i ].value);
			}
		}

		if (selected_coll.length > 0)
		{
			ajax.setVar("coll_man",selected_coll);
         using_filters = true;
         if (is_noble)
         {
            noble_filter_count++;
            has_ok_noble_filter = true;
         }
		}
   }

   //***************************************

   //figure out what it says in the stat cat box
   var stat_cat = document.getElementById('stat_cats').value;
	if (stat_cat.length > 0)
	{
	    ajax.setVar("stat_cats",stat_cat);
	    if (stat_cat != -1)
	    {
	       using_filters = true;
	       if (is_noble)
          {
             noble_filter_count++;
             has_ok_noble_filter = true;
          }
	    }
	}

   //figure out what it says in the course box
   var course = document.getElementById('course').value;
	if (course.length > 0)
	{
	    ajax.setVar("courses",course);
	    if (course != -1)
	    {
	       using_filters = true;
	       if (is_noble)
           {
              noble_filter_count++;
              has_ok_noble_filter = true;
           }
	    }
	}

  //figure out what it says in the  tag box
   var tags = document.getElementById('tag_ids').value;
	if (tags.length > 0)
	{
	    ajax.setVar("tags",tags);
	    if (tags != -1)
	    {
	       using_filters = true;
	       if (is_noble)
           {
              noble_filter_count++;
              has_ok_noble_filter = true;
           }
	    }
	}


	var temp = $(document.getElementById("file_name")).text();
	if (temp.length > 0)
	{
	  	var filename = temp.split(':')[1];
	   filename= filename.trim();

	   temp = $(document.getElementById("data_type")).text();
	   var data_type = temp.split(':')[1];
	   data_type= data_type.trim();


   	temp = $(document.getElementById("file_type")).text();
   	var file_type = temp.split(':')[1];
   	file_type= file_type.trim();

	   //using a file
	   ajax.setVar('filename', filename);
	   ajax.setVar('data_type', data_type);
	   ajax.setVar('file_type', file_type);

	   if (document.getElementById("use_active").checked == false && (data_type == "bib" || data_type == "isbn"))//look at the electronic
	   {
	      var ele = document.getElementById('electronic');
         var phy_ele = ele.options[ele.selectedIndex].value;
         ajax.setVar("electronic",phy_ele);
	   }

	   using_filters = true;
	   if (is_noble)
      {
         noble_filter_count++;
         has_ok_noble_filter = true;
      }
	}

	var use_lifetime_count = false;

   if (document.getElementById("use_circ_count").checked)
   {
      var circ_count = document.getElementById('circ_count').value;
      if (isNaN(circ_count) )
      {
         swal('Error', "Please use a number for Filter by Circulation Count.", 'error');
         return false;
      }

      ajax.setVar("circ_count", circ_count);

      var compare = document.getElementById('circ_count_compare');
      var compareType= compare.options[compare.selectedIndex].value;
	   ajax.setVar("circ_count_compare", compareType);

	   var count_compare = document.getElementById('compare_date');
      var date_compare= count_compare.options[count_compare.selectedIndex].value;
      if (!date_compare )
      {
         swal('Error', "Please select a comparison value for Filter by Circulation Count.", 'error');
         return false;
      }
	   ajax.setVar("circ_compare_date", date_compare);

	   if (date_compare == "lifetime") use_lifetime_count = false;

	   using_filters = true;

   }

	if (!use_lifetime_count && document.getElementById("use_circ_dates").checked)
   {
       var circ_date_type = document.getElementById('circ_date_type').value;
       var circ = document.getElementById('circ_time_type');
       var circ_time =  circ.options[circ.selectedIndex].value;

       //checked for errors before
       if(circ_date_type == "absolute")
       {
			 var circ_start = document.getElementById('circ_start').value;
			 if (!isValidDate(circ_start))
			 {
				 swal('Error', "Please format circulation date as MM/DD/YYYY or use datepicker. Dates cannot be before 2000 and cannot be in the future.", 'error');
				 return false;
			 }

			 var circ_end = document.getElementById('circ_end').value;
			 if (circ_time == "between" && !isValidDate(circ_end))
			 {
				 swal('Error', "Please format circulation date as MM/DD/YYYY or use datepicker. Dates cannot be before 2000 and cannot be in the future.", 'error');
			  	 return false;
			 }

			 var start = new Date(circ_start);
			 var end = new Date(circ_end);

			 if (circ_time == "between" && start > end )
			 {
		   	 swal('Error', "The range of circulation dates is invalid. Please set first date earlier than the second.", 'error');
			 	 return false;
			 }


			 ajax.setVar("circ_date_type", "absolute");
			 ajax.setVar("circ_start",circ_start);
			 ajax.setVar("circ_time_type", circ_time);
			 if( circ_time == "between")ajax.setVar("circ_end",circ_end);
       }
       else if(circ_date_type == "relative")
       {
          var circ_start = document.getElementById('circ_start_relative').value;
          var time1 = document.getElementById('circ_start_time');
          var start_time =  time1.options[time1.selectedIndex].value;
          var start_out = circ_start+"_"+start_time;

          var circ_end = document.getElementById('circ_end_relative').value;
          var time2 = document.getElementById('circ_end_time');
          var end_time =  time2.options[time2.selectedIndex].value;
          var end_out = circ_end+"_"+end_time;

          if (circ_start.length < 1 || (circ_time =="between" && circ_end.length < 1 ) )
          {
             swal('Error', "Please complete all values for filter by circ date .", 'error');
			 	 return false;
          }

          if (circ_time =="between")
          {
				 if (start_time == end_time)
				 {
					 if (circ_start > circ_end)
					 {
						 ajax.setVar("circ_start",start_out);
						 ajax.setVar("circ_end",end_out);
					 }
					 else
					 {
						 ajax.setVar("circ_start",end_out);
						 ajax.setVar("circ_end",start_out);
					 }
				 }
				 else //they are not the same unit
				 {
					 if (start_time == "days")
					 {
						 //the end time is weeks or months so end is really start cause it's further in past
						 ajax.setVar("circ_start",end_out);
						 ajax.setVar("circ_end",start_out);
					 }
					 else if (start_time == "weeks")
					 {
						 if (end_time == "days")
						 {
							 //the end time is days so the start time of weeks is further in past
							 ajax.setVar("circ_start",start_out);
							 ajax.setVar("circ_end",end_out);
						 }
						 else if (end_time == "months" || end_time == "years" )
						 {
							 //weeks is less than months so end time is really start cause it's further in past
							 ajax.setVar("circ_start",end_out);
							 ajax.setVar("circ_end",start_out);
						 }
					 }
					 else if (start_time == "months")
					 {
						 if (end_time == "days" || end_time == "weeks")
						 {
							 //the end time is days so the start time of weeks is further in past
							 ajax.setVar("circ_start",start_out);
							 ajax.setVar("circ_end",end_out);
						 }
						 else if (end_time == "years" )
						 {
							 //weeks is less than months so end time is really start cause it's further in past
							 ajax.setVar("circ_start",end_out);
							 ajax.setVar("circ_end",start_out);
						 }
					 }
					 else if (start_time == "years")
					 {
						 //the end time is days or weeks so the start time is further in past
						 ajax.setVar("circ_start",start_out);
						 ajax.setVar("circ_end",end_out);
					 }
				 }
          }
          else
          {
             ajax.setVar("circ_start",start_out);
          }

          ajax.setVar("circ_time_type", circ_time);
          ajax.setVar("circ_date_type", "relative");
       }

      using_filters = true;
   }

   if (document.getElementById("use_due_date").checked)
   {
       var due_date_type = document.getElementById('due_date_type').value;
       var due = document.getElementById('due_time_type');
       var due_time =  due.options[due.selectedIndex].value;

       //checked for errors before
       if(due_date_type == "absolute")
       {
			 var due_start = document.getElementById('due_start').value;
			 if (!isValidDate(due_start))
			 {
				 swal('Error', "Please format due date as MM/DD/YYYY or use datepicker. Dates cannot be before 2012 and cannot be in the future.", 'error');
				 return false;
			 }

			 var due_end = document.getElementById('due_end').value;
			 if (due_time == "between" && !isValidDate(due_end))
			 {
				 swal('Error', "Please format due date as MM/DD/YYYY or use datepicker. Dates cannot be before 2012 and cannot be in the future.", 'error');
			  	 return false;
			 }

			 var start = new Date(due_start);
			 var end = new Date(due_end);

			 if (due_time == "between" && start > end )
			 {
		   	 swal('Error', "The range of due dates is invalid. Please set first date earlier than the second.", 'error');
			 	 return false;
			 }


			 ajax.setVar("due_date_type", "absolute");
			 ajax.setVar("due_start",due_start);
			 ajax.setVar("due_time_type", due_time);
			 if( due_time == "between")ajax.setVar("due_end",due_end);
       }
       else if(due_date_type == "relative")
       {
          var due_start = document.getElementById('due_start_relative').value;
          var time1 = document.getElementById('due_start_time');
          var start_time =  time1.options[time1.selectedIndex].value;
          var start_out = due_start+"_"+start_time;

          var due_end = document.getElementById('due_end_relative').value;
          var time2 = document.getElementById('due_end_time');
          var end_time =  time2.options[time2.selectedIndex].value;
          var end_out = due_end+"_"+end_time;

          if (due_start.length < 1 || (due_time =="between" && due_end.length < 1 ) )
          {
             swal('Error', "Please complete all values for filter by due date .", 'error');
			 	 return false;
          }

          if (due_time =="between")
          {
				 if (start_time == end_time)
				 {
					 if (due_start > due_end)
					 {
						 ajax.setVar("due_start",start_out);
						 ajax.setVar("due_end",end_out);
					 }
					 else
					 {
						 ajax.setVar("due_start",end_out);
						 ajax.setVar("due_end",start_out);
					 }
				 }
				 else //they are not the same unit
				 {
					 if (start_time == "days")
					 {
						 //the end time is weeks or months so end is really start cause it's further in past
						 ajax.setVar("due_start",end_out);
						 ajax.setVar("due_end",start_out);
					 }
					 else if (start_time == "weeks")
					 {
						 if (end_time == "days")
						 {
							 //the end time is days so the start time of weeks is further in past
							 ajax.setVar("due_start",start_out);
							 ajax.setVar("due_end",end_out);
						 }
						 else if (end_time == "months" || end_time == "years" )
						 {
							 //weeks is less than months so end time is really start cause it's further in past
							 ajax.setVar("due_start",end_out);
							 ajax.setVar("due_end",start_out);
						 }
					 }
					 else if (start_time == "months")
					 {
						 if (end_time == "days" || end_time == "weeks")
						 {
							 //the end time is days so the start time of weeks is further in past
							 ajax.setVar("due_start",start_out);
							 ajax.setVar("due_end",end_out);
						 }
						 else if (end_time == "years" )
						 {
							 //weeks is less than months so end time is really start cause it's further in past
							 ajax.setVar("due_start",end_out);
							 ajax.setVar("due_end",start_out);
						 }
					 }
					 else if (start_time == "years")
					 {
						 //the end time is days or weeks so the start time is further in past
						 ajax.setVar("due_start",start_out);
						 ajax.setVar("due_end",end_out);
					 }
				 }
          }
          else
          {
             ajax.setVar("due_start",start_out);
          }

          ajax.setVar("due_time_type", due_time);
          ajax.setVar("due_date_type", "relative");
       }

      using_filters = true;
   }

   if (document.getElementById("use_hold_count").checked)
   {
      var hold_count = document.getElementById('hold_count').value;
      if (isNaN(hold_count))
      {
         swal('Error', "Please use a number for Filter by Hold Count.", 'error');
         return false;
      }

      ajax.setVar("hold_count", hold_count);

	  var hold_location = document.getElementById('hold_loc');
      var hold_loc= hold_location.options[hold_location.selectedIndex].value;
      if (!hold_loc )
      {
         swal('Error', "Please select a Library for Filter by Hold Count.", 'error');
         return false;
      }
	   ajax.setVar("hold_loc", hold_loc);

	   using_filters = true;

   }

   if (document.getElementById("use_inventory_dates").checked)
   {
       var inventory_date_type = document.getElementById('inventory_date_type').value;
       var inventory = document.getElementById('inventory_time_type');
       var inventory_time =  inventory.options[inventory.selectedIndex].value;

       //checked for errors before
       if(inventory_date_type == "absolute")
       {
             if (inventory_time == "none")
             {
                ajax.setVar("include_null_inventory", "include_null_inventory");
             }
             else
             {
				 var inventory_start = document.getElementById('inventory_start').value;
				 if (!isValidDate(inventory_start))
				 {
					 swal('Error', "Please format Inventory date as MM/DD/YYYY or use datepicker. Dates cannot be before 2018 and cannot be in the future.", 'error');
					 return false;
				 }

				 var inventory_end = document.getElementById('inventory_end').value;
				 if (inventory_time == "between" && !isValidDate(inventory_end))
				 {
					 swal('Error', "Please format Inventory date as MM/DD/YYYY or use datepicker. Dates cannot be before 2018 and cannot be in the future.", 'error');
					 return false;
				 }

				 var start = new Date(inventory_start);
				 var end = new Date(inventory_end);

				 if (inventory_time == "between" && start > end )
				 {
					 swal('Error', "The range of Inventory dates is invalid. Please set first date earlier than the second.", 'error');
					 return false;
				 }

				 if (inventory_time == "before")
				 {
					if (document.getElementById("include_null_inventory").checked) ajax.setVar("include_null_inventory", "include_null_inventory");
				 }


					ajax.setVar("inventory_date_type", "absolute");
					ajax.setVar("inventory_start",inventory_start);
					ajax.setVar("inventory_time_type", inventory_time);
					if( inventory_time == "between")ajax.setVar("inventory_end",inventory_end);
			 }

       }
       else if(inventory_date_type == "relative")
       {
          var inventory_start = document.getElementById('inventory_start_relative').value;
          var time1 = document.getElementById('inventory_start_time');
          var start_time =  time1.options[time1.selectedIndex].value;
          var start_out = inventory_start+"_"+start_time;

          var inventory_end = document.getElementById('inventory_end_relative').value;
          var time2 = document.getElementById('inventory_end_time');
          var end_time =  time2.options[time2.selectedIndex].value;
          var end_out = inventory_end+"_"+end_time;

          if (inventory_time =="none")
          {
             ajax.setVar("include_null_inventory", "include_null_inventory");
          }
          else
          {
			  if (inventory_start.length < 1 || (inventory_time =="between" && inventory_end.length < 1 ) )
			  {
				 swal('Error', "Please complete all values for filter by inventory date .", 'error');
				 return false;
			  }

			  if (inventory_time == "before")
			  {
				 if (document.getElementById("include_null_inventory").checked) ajax.setVar("include_null_inventory", "include_null_inventory");
			  }

			  if (inventory_time =="between")
			  {
					 if (start_time == end_time)
					 {
						 if (inventory_start > inventory_end)
						 {
							 ajax.setVar("inventory_start",start_out);
							 ajax.setVar("inventory_end",end_out);
						 }
						 else
						 {
							 ajax.setVar("inventory_start",end_out);
							 ajax.setVar("inventory_end",start_out);
						 }
					 }
					 else //they are not the same unit
					 {
						 if (start_time == "days")
						 {
							 //the end time is weeks or months so end is really start cause it's further in past
							 ajax.setVar("inventory_start",end_out);
							 ajax.setVar("inventory_end",start_out);
						 }
						 else if (start_time == "weeks")
						 {
							 if (end_time == "days")
							 {
								 //the end time is days so the start time of weeks is further in past
								 ajax.setVar("inventory_start",start_out);
								 ajax.setVar("inventory_end",end_out);
							 }
							 else if (end_time == "months" || end_time == "years" )
							 {
								 //weeks is less than months so end time is really start cause it's further in past
								 ajax.setVar("inventory_start",end_out);
								 ajax.setVar("inventory_end",start_out);
							 }
						 }
						 else if (start_time == "months")
						 {
							 if (end_time == "days" || end_time == "weeks")
							 {
								 //the end time is days so the start time of weeks is further in past
								 ajax.setVar("inventory_start",start_out);
								 ajax.setVar("inventory_end",end_out);
							 }
							 else if (end_time == "years" )
							 {
								 //weeks is less than months so end time is really start cause it's further in past
								 ajax.setVar("inventory_start",end_out);
								 ajax.setVar("inventory_end",start_out);
							 }
						 }
						 else if (start_time == "years")
						 {
							 //the end time is days or weeks so the start time is further in past
							 ajax.setVar("inventory_start",start_out);
							 ajax.setVar("inventory_end",end_out);
						 }
					 }
			  }
			  else
			  {
				 ajax.setVar("inventory_start",start_out);
			  }

			  ajax.setVar("inventory_time_type", inventory_time);
			  ajax.setVar("inventory_date_type", "relative");
          }
       }

      using_filters = true;
   }

   if (document.getElementById("use_invoice_dates").checked)
   {
       var invoice_date_type = document.getElementById('invoice_date_type').value;
       var invoice = document.getElementById('invoice_time_type');
       var invoice_time =  invoice.options[invoice.selectedIndex].value;

       //checked for errors before
       if(invoice_date_type == "absolute")
       {
			 var invoice_start = document.getElementById('invoice_start').value;
			 if (!isValidDate(invoice_start))
			 {
				 swal('Error', "Please format invoice date as MM/DD/YYYY or use datepicker. Dates cannot be before 2018 and cannot be in the future.", 'error');
				 return false;
			 }

			 var invoice_end = document.getElementById('invoice_end').value;
			 if (invoice_time == "between" && !isValidDate(invoice_end))
			 {
				 swal('Error', "Please format invoice date as MM/DD/YYYY or use datepicker. Dates cannot be before 2018 and cannot be in the future.", 'error');
			  	 return false;
			 }

			 var start = new Date(invoice_start);
			 var end = new Date(invoice_end);

			 if (invoice_time == "between" && start > end )
			 {
		   	 swal('Error', "The range of invoice dates is invalid. Please set first date earlier than the second.", 'error');
			 	 return false;
			 }


			 ajax.setVar("invoice_date_type", "absolute");
			 ajax.setVar("invoice_start",invoice_start);
			 ajax.setVar("invoice_time_type", invoice_time);
			 if( invoice_time == "between")ajax.setVar("invoice_end",invoice_end);
       }
       else if(invoice_date_type == "relative")
       {
          var invoice_start = document.getElementById('invoice_start_relative').value;
          var time1 = document.getElementById('invoice_start_time');
          var start_time =  time1.options[time1.selectedIndex].value;
          var start_out = invoice_start+"_"+start_time;

          var invoice_end = document.getElementById('invoice_end_relative').value;
          var time2 = document.getElementById('invoice_end_time');
          var end_time =  time2.options[time2.selectedIndex].value;
          var end_out = invoice_end+"_"+end_time;

          if (invoice_start.length < 1 || (invoice_time =="between" && invoice_end.length < 1 ) )
          {
             swal('Error', "Please complete all values for filter by invoice date .", 'error');
			 	 return false;
          }

          if (invoice_time =="between")
          {
				 if (start_time == end_time)
				 {
					 if (invoice_start > invoice_end)
					 {
						 ajax.setVar("invoice_start",start_out);
						 ajax.setVar("invoice_end",end_out);
					 }
					 else
					 {
						 ajax.setVar("invoice_start",end_out);
						 ajax.setVar("invoice_end",start_out);
					 }
				 }
				 else //they are not the same unit
				 {
					 if (start_time == "days")
					 {
						 //the end time is weeks or months so end is really start cause it's further in past
						 ajax.setVar("invoice_start",end_out);
						 ajax.setVar("invoice_end",start_out);
					 }
					 else if (start_time == "weeks")
					 {
						 if (end_time == "days")
						 {
							 //the end time is days so the start time of weeks is further in past
							 ajax.setVar("invoice_start",start_out);
							 ajax.setVar("invoice_end",end_out);
						 }
						 else if (end_time == "months" || end_time == "years" )
						 {
							 //weeks is less than months so end time is really start cause it's further in past
							 ajax.setVar("invoice_start",end_out);
							 ajax.setVar("invoice_end",start_out);
						 }
					 }
					 else if (start_time == "months")
					 {
						 if (end_time == "days" || end_time == "weeks")
						 {
							 //the end time is days so the start time of weeks is further in past
							 ajax.setVar("invoice_start",start_out);
							 ajax.setVar("invoice_end",end_out);
						 }
						 else if (end_time == "years" )
						 {
							 //weeks is less than months so end time is really start cause it's further in past
							 ajax.setVar("invoice_start",end_out);
							 ajax.setVar("invoice_end",start_out);
						 }
					 }
					 else if (start_time == "years")
					 {
						 //the end time is days or weeks so the start time is further in past
						 ajax.setVar("invoice_start",start_out);
						 ajax.setVar("invoice_end",end_out);
					 }
				 }
          }
          else
          {
             ajax.setVar("invoice_start",start_out);
          }

          ajax.setVar("invoice_time_type", invoice_time);
          ajax.setVar("invoice_date_type", "relative");
       }

      using_filters = true;
   }

   if (document.getElementById("use_invoice_closed_dates").checked)
   {
       var invoice_closed_date_type = document.getElementById('invoice_closed_date_type').value;
       var invoice_closed = document.getElementById('invoice_closed_time_type');
       var invoice_closed_time =  invoice_closed.options[invoice_closed.selectedIndex].value;

       //checked for errors before
       if(invoice_closed_date_type == "absolute")
       {
             if (invoice_closed_time == "none")
             {
                ajax.setVar("include_null_invoice_closed", "include_null_invoice_closed");
             }
             else
             {
				 var invoice_closed_start = document.getElementById('invoice_closed_start').value;
				 if (!isValidDate(invoice_closed_start))
				 {
					 swal('Error', "Please format invoice_closed date as MM/DD/YYYY or use datepicker. Dates cannot be before 2018 and cannot be in the future.", 'error');
					 return false;
				 }

				 var invoice_closed_end = document.getElementById('invoice_closed_end').value;
				 if (invoice_closed_time == "between" && !isValidDate(invoice_closed_end))
				 {
					 swal('Error', "Please format invoice_closed date as MM/DD/YYYY or use datepicker. Dates cannot be before 2018 and cannot be in the future.", 'error');
					 return false;
				 }

				 var start = new Date(invoice_closed_start);
				 var end = new Date(invoice_closed_end);

				 if (invoice_closed_time == "between" && start > end )
				 {
					 swal('Error', "The range of invoice_closed dates is invalid. Please set first date earlier than the second.", 'error');
					 return false;
				 }

				 if (invoice_closed_time == "before")
				 {
					if (document.getElementById("include_null_invoice_closed").checked) ajax.setVar("include_null_invoice_closed", "include_null_invoice_closed");
				 }


					ajax.setVar("invoice_closed_date_type", "absolute");
					ajax.setVar("invoice_closed_start",invoice_closed_start);
					ajax.setVar("invoice_closed_time_type", invoice_closed_time);
					if( invoice_closed_time == "between")ajax.setVar("invoice_closed_end",invoice_closed_end);
			 }
       }
       else if(invoice_closed_date_type == "relative")
       {
          var invoice_closed_start = document.getElementById('invoice_closed_start_relative').value;
          var time1 = document.getElementById('invoice_closed_start_time');
          var start_time =  time1.options[time1.selectedIndex].value;
          var start_out = invoice_closed_start+"_"+start_time;

          var invoice_closed_end = document.getElementById('invoice_closed_end_relative').value;
          var time2 = document.getElementById('invoice_closed_end_time');
          var end_time =  time2.options[time2.selectedIndex].value;
          var end_out = invoice_closed_end+"_"+end_time;

          if (invoice_closed_time =="none")
          {
             ajax.setVar("include_null_invoice_closed", "include_null_invoice_closed");
          }
          else
          {
			  if (invoice_closed_start.length < 1 || (invoice_closed_time =="between" && invoice_closed_end.length < 1 ) )
			  {
					 swal('Error', "Please complete all values for filter by invoice_closed date .", 'error');
					 return false;
			  }

			  if (invoice_closed_time == "before")
			  {
				 if (document.getElementById("include_null_invoice_closed").checked) ajax.setVar("include_null_invoice_closed", "include_null_invoice_closed");
			  }

			  if (invoice_closed_time =="between")
			  {
					 if (start_time == end_time)
					 {
						 if (invoice_closed_start > invoice_closed_end)
						 {
							 ajax.setVar("invoice_closed_start",start_out);
							 ajax.setVar("invoice_closed_end",end_out);
						 }
						 else
						 {
							 ajax.setVar("invoice_closed_start",end_out);
							 ajax.setVar("invoice_closed_end",start_out);
						 }
					 }
					 else //they are not the same unit
					 {
						 if (start_time == "days")
						 {
							 //the end time is weeks or months so end is really start cause it's further in past
							 ajax.setVar("invoice_closed_start",end_out);
							 ajax.setVar("invoice_closed_end",start_out);
						 }
						 else if (start_time == "weeks")
						 {
							 if (end_time == "days")
							 {
								 //the end time is days so the start time of weeks is further in past
								 ajax.setVar("invoice_closed_start",start_out);
								 ajax.setVar("invoice_closed_end",end_out);
							 }
							 else if (end_time == "months" || end_time == "years" )
							 {
								 //weeks is less than months so end time is really start cause it's further in past
								 ajax.setVar("invoice_closed_start",end_out);
								 ajax.setVar("invoice_closed_end",start_out);
							 }
						 }
						 else if (start_time == "months")
						 {
							 if (end_time == "days" || end_time == "weeks")
							 {
								 //the end time is days so the start time of weeks is further in past
								 ajax.setVar("invoice_closed_start",start_out);
								 ajax.setVar("invoice_closed_end",end_out);
							 }
							 else if (end_time == "years" )
							 {
								 //weeks is less than months so end time is really start cause it's further in past
								 ajax.setVar("invoice_closed_start",end_out);
								 ajax.setVar("invoice_closed_end",start_out);
							 }
						 }
						 else if (start_time == "years")
						 {
							 //the end time is days or weeks so the start time is further in past
							 ajax.setVar("invoice_closed_start",start_out);
							 ajax.setVar("invoice_closed_end",end_out);
						 }
					 }
			  }
			  else
			  {
				 ajax.setVar("invoice_closed_start",start_out);
			  }

			  ajax.setVar("invoice_closed_time_type", invoice_closed_time);
			  ajax.setVar("invoice_closed_date_type", "relative");
		   }
       }

      using_filters = true;
   }

   if (document.getElementById("use_order_dates").checked)
   {
       var order_date_type = document.getElementById('order_date_type').value;
       var order = document.getElementById('order_time_type');
       var order_time =  order.options[order.selectedIndex].value;

       //checked for errors before
       if(order_date_type == "absolute")
       {
             if (order_time == "none")
             {
                ajax.setVar("include_null_order_date", "include_null_order_date");
             }
             else
             {
				 var order_start = document.getElementById('order_start').value;
				 if (!isValidDate(order_start))
				 {
					 swal('Error', "Please format order date as MM/DD/YYYY or use datepicker. Dates cannot be before 2018 and cannot be in the future.", 'error');
					 return false;
				 }

				 var order_end = document.getElementById('order_end').value;
				 if (order_time == "between" && !isValidDate(order_end))
				 {
					 swal('Error', "Please format order date as MM/DD/YYYY or use datepicker. Dates cannot be before 2018 and cannot be in the future.", 'error');
					 return false;
				 }

				 var start = new Date(order_start);
				 var end = new Date(order_end);

				 if (order_time == "between" && start > end )
				 {
					 swal('Error', "The range of order dates is invalid. Please set first date earlier than the second.", 'error');
					 return false;
				 }

			    ajax.setVar("order_date_type", "absolute");
			    ajax.setVar("order_start",order_start);
			    ajax.setVar("order_time_type", order_time);
			    if( order_time == "between")ajax.setVar("order_end",order_end);
			 }
       }
       else if(order_date_type == "relative")
       {
          var order_start = document.getElementById('order_start_relative').value;
          var time1 = document.getElementById('order_start_time');
          var start_time =  time1.options[time1.selectedIndex].value;
          var start_out = order_start+"_"+start_time;

          var order_end = document.getElementById('order_end_relative').value;
          var time2 = document.getElementById('order_end_time');
          var end_time =  time2.options[time2.selectedIndex].value;
          var end_out = order_end+"_"+end_time;

          if (order_time =="none")
          {
             ajax.setVar("include_null_order_date", "include_null_order_date");
          }
          else
          {
			  if (order_start.length < 1 || (order_time =="between" && order_end.length < 1 ) )
			  {
					swal('Error', "Please complete all values for filter by order date .", 'error');
					return false;
			  }

			  if (order_time =="between")
			  {
					 if (start_time == end_time)
					 {
						 if (order_start > order_end)
						 {
							 ajax.setVar("order_start",start_out);
							 ajax.setVar("order_end",end_out);
						 }
						 else
						 {
							 ajax.setVar("order_start",end_out);
							 ajax.setVar("order_end",start_out);
						 }
					 }
					 else //they are not the same unit
					 {
						 if (start_time == "days")
						 {
							 //the end time is weeks or months so end is really start cause it's further in past
							 ajax.setVar("order_start",end_out);
							 ajax.setVar("order_end",start_out);
						 }
						 else if (start_time == "weeks")
						 {
							 if (end_time == "days")
							 {
								 //the end time is days so the start time of weeks is further in past
								 ajax.setVar("order_start",start_out);
								 ajax.setVar("order_end",end_out);
							 }
							 else if (end_time == "months" || end_time == "years" )
							 {
								 //weeks is less than months so end time is really start cause it's further in past
								 ajax.setVar("order_start",end_out);
								 ajax.setVar("order_end",start_out);
							 }
						 }
						 else if (start_time == "months")
						 {
							 if (end_time == "days" || end_time == "weeks")
							 {
								 //the end time is days so the start time of weeks is further in past
								 ajax.setVar("order_start",start_out);
								 ajax.setVar("order_end",end_out);
							 }
							 else if (end_time == "years" )
							 {
								 //weeks is less than months so end time is really start cause it's further in past
								 ajax.setVar("order_start",end_out);
								 ajax.setVar("order_end",start_out);
							 }
						 }
						 else if (start_time == "years")
						 {
							 //the end time is days or weeks so the start time is further in past
							 ajax.setVar("order_start",start_out);
							 ajax.setVar("order_end",end_out);
						 }
					 }
			  }
			  else
			  {
				 ajax.setVar("order_start",start_out);
			  }

			  ajax.setVar("order_time_type", order_time);
			  ajax.setVar("order_date_type", "relative");
          }
       }

      using_filters = true;
   }

   var selected_lineitem_status = new Array();
   var lineitem_status = document.getElementsByName('line_item_status_checkboxes[]');
   for(var i=0; i<lineitem_status.length; i++)
   {
       if (lineitem_status[i].checked)
       {
          selected_lineitem_status.push(lineitem_status[i].value);
       }
   }

   if (selected_lineitem_status.length > 0)
   {
      ajax.setVar("lineitem_status",selected_lineitem_status);
      using_filters = true;
   }

   var funds = document.getElementById('funds').value;
	if (funds.length > 0)
	{
	    ajax.setVar("fund",funds);
	    if (funds != -1)using_filters = true;
	}

	if (all_loc && !using_filters)
	{
	    swal('ERROR!', "When using all copy locations, a filter must be used. ", 'error');
       return false;
	}

	if (loc_grp != '-1' && !using_filters)
	{
	    swal('ERROR!', "When using a copy location group, a filter must be used. ", 'error');
        return false;
	}

	if (is_noble)
	{
	   if (has_ok_noble_filter == false && noble_filter_count < 2)
	   {
	      swal('ERROR!', "Please select additional filters for NOBLE. Your current selections will yield a report too large to process. ", 'error');
         return false;
	   }
	}

   //only Holder
   var only = document.getElementById('only_holder');
   var only_holder = only.options[only.selectedIndex].value;
   if (only_holder != "all_items")
   {
      ajax.setVar("only_holder",only_holder);
   }

	if (document.getElementById('scope_links').checked)
	{
	   ajax.setVar("scope","scope");
	}

	if (LibName == "NOBLE" && document.getElementById('use_domain').checked)
	{
	   var domain = document.getElementById('domain');
      var DomainName = domain.options[domain.selectedIndex].value;
	   ajax.setVar("domain", DomainName);
	}

	if (document.getElementById('search_links').checked)
	{
	   ajax.setVar("search_links","search_links");
	}

	if (document.getElementById('no_email').checked)
	{
	   ajax.setVar("no_email","no_email");
	}

	//Spreadsheet
	if (document.getElementById('spreadsheet').checked)
	{
	   ajax.setVar("spreadsheet","sheet");

		var order = $(document.getElementById("spreadsheet_order")).text();
		var format =  $(document.getElementById("spreadsheet_format")).text();
		var options =  $(document.getElementById("spreadsheet_options")).text();
		var display = $(document.getElementById("spreadsheet_display")).text();
		display = display.replace(/\s+/g, '');

		if (order.includes('Title')) ajax.setVar("sheet_order","title_sort");
		else if (order.includes('Author')) ajax.setVar("sheet_order","author_sort");
		else if (order.includes('Call')) ajax.setVar("sheet_order","call_sort");
		else if (order.includes('Active')) ajax.setVar("sheet_order","active_sort");
		else if (order.includes('Lifetime')) ajax.setVar("sheet_order","circ_sort");
		else if (order.includes('Selected')) ajax.setVar("sheet_order","circ_between_sort");
		else if (order.includes('YTD')) ajax.setVar("sheet_order","ytd_sort");

		if (format.includes('Excel')) ajax.setVar("sheet_format","excel");
		else if (format.includes('CSV')) ajax.setVar("sheet_format","csv");

      var sheet_options='';
        if (!options.includes('Item'))  sheet_options += "no_item_sheet ";
        if (options.includes('Bib'))  sheet_options += "bib_sheet ";
        if (options.includes('Author'))  sheet_options += "author_sheet ";
		if (options.includes('Count'))  sheet_options += "count_sheet ";
		if (options.includes('Summary')) sheet_options += "summary_sheet ";
		if (options.includes('Circs')) sheet_options += "circs_by_lib ";
		if (options.includes('Single'))  sheet_options += "single_sheet ";



		if (sheet_options.length > 1 )
		{
		   ajax.setVar("sheet_options",sheet_options);
		}

		//pull apart the display string and figure out what needs to be checked
		var sheet_display ='';

		if (display.includes('Author')) sheet_display +="author*";
		if (display.includes('Barcode')) sheet_display +="barcode*";
		if (display.includes('BibId')) sheet_display +="bib_id*";
		if (display.includes('CallNumber')) sheet_display +="call_num*";
		if (display.includes('LastCheckin')) sheet_display +="last_checkin*";
		if (display.includes('LifetimeCirc')) sheet_display +="life_circ*";
		if (display.includes('OnlyHolder')) sheet_display +="only_holder*";
		if (display.includes('Part')) sheet_display +="part*";
		if (display.includes('Prefix')) sheet_display +="prefix*";
		if (display.includes('PubDate')) sheet_display +="pub_date*";
		if (display.includes('Suffix')) sheet_display +="suffix*";
		if (display.includes('Title'))  sheet_display +="title*";

		if (display.includes('Active')) sheet_display +="active*";
		if (display.includes('AgeProtection')) sheet_display +="age_protect*";
		if (display.includes('AlertMessage')) sheet_display +="alert*";
		if (display.includes('AmazonDirect')) sheet_display +="amz_direct*";
		if (display.includes('AmazonSearch')) sheet_display +="amz_search*";
		if (display.includes('AcquisitionCost')) sheet_display +="acq_cost*";
		if (display.includes('CallNumberClass')) sheet_display +="call_class*";
		if (display.includes('CatalogStaffLink')) sheet_display +="cat_link_staff*";
		if (display.includes('CatalogOPACLink')) sheet_display +="cat_link_opac*";
		if (display.includes('TitleStaffLink')) sheet_display +="title_link_staff*";
		if (display.includes('TitleOPACLink')) sheet_display +="title_link_opac*";
		if (display.includes('CircModifier')) sheet_display +="circ_mod*";
		if (display.includes('CirculationLibrary')) sheet_display +="circ_lib*";
		if (display.includes('CircsBetween'))
		{
			//add the dates
			//GET THE NEXT TWO PARAMETERS
         var pos = display.indexOf("CircsBetween");
         pos +=12;
         var between_start = display.substring(pos, pos+10);
         var end_pos = pos+11;
         var between_end = display.substring(end_pos, end_pos+10);

         ajax.setVar("circ_between_start", between_start);
         ajax.setVar("circ_between_end", between_end);

		}
		if (display.includes('ItemId')) sheet_display +="copy_id*";
		if (display.includes('ShelvingLocation')) sheet_display +="copy_loc*";
		if (display.includes('ItemStatus')) sheet_display +="status*";
		if (display.includes('ItemTag')) sheet_display +="tag*";
		if (display.includes('Course')) sheet_display +="course*";
		if (display.includes('CourseCirculation')) sheet_display +="course_circ*";
		if (display.includes('CoverImage')) sheet_display +="cover*";
		if (display.includes('CreateDate')) sheet_display +="create_date*";
		if (display.includes('DebitAmount')) sheet_display +="fund_debit*";
		if (display.includes('DueDate')) sheet_display +="due_date*";
		if (display.includes('Encumbered')) sheet_display +="encumbered*";
		if (display.includes('FineLevel')) sheet_display +="fine*";
		if (display.includes('Fingerprint')) sheet_display +="fingerprint*";
		if (display.includes('Floating')) sheet_display +="floating*";
		if (display.includes('Fund')) sheet_display +="fund*";
		if (display.includes('Goodreads')) sheet_display +="goodreads*";
		if (display.includes('HoldCount')) sheet_display +="holds*";
		if (display.includes('InHouse')) sheet_display +="in_house*";
		if (display.includes('Inventory')) sheet_display +="inventory*";
		if (display.includes('InvoiceDate')) sheet_display +="invoice_date*";
		if (display.includes('InvoiceClosedDate')) sheet_display +="invoice_closed_date*";
		if (display.includes('InvoiceNumber')) sheet_display +="invoice_num*";
		if (display.includes('ItemStatusLink')) sheet_display +="item_status_link*";
		if (display.includes('AllISBNs')) sheet_display +="isbn*";
		if (display.includes('FirstISBN')) sheet_display +="isbn1*";
		if (display.includes('LastCheckoutDate')) sheet_display +="checkout*";
		if (display.includes('LastCheckoutLibrary')) sheet_display +="checkout_lib*";
		if (display.includes('LastFYCirc')) sheet_display +="last_fy*";
		if (display.includes('LineitemId')) sheet_display +="line_item_id*";
		if (display.includes('LineitemStatus')) sheet_display +="line_item_status*";
		if (display.includes('SortKey')) sheet_display +="sortkey*";
		if (display.includes('LoanDuration')) sheet_display +="loan_dur*";
		if (display.includes('MARC'))
		{
		   //get the tag and subfield
		   var pos = display.indexOf("MARC");
           pos +=4;

           var tag = display.substring(pos, pos+3);
           var sub_pos = pos+4;
           var subfield = display.substring(sub_pos, sub_pos+3);

           if (subfield != "ALL" )subfield = display.substring(sub_pos, sub_pos+1);

           sheet_display +="marc*"+tag+"*"+subfield+"*";
		}
		if (display.includes('OCLCNumber')) sheet_display +="oclc*";
		if (display.includes('OrderDate')) sheet_display +="order_date*";
		if (display.includes('OtherLibraryCount')) sheet_display +="other_lib_count*";
		if (display.includes('OwningLib')) sheet_display +="owning_lib*";
		if (display.includes('PurchaseOrderNumber')) sheet_display +="po_num*";
		if (display.includes('Price')) sheet_display +="price*";
		if (display.includes('PublicNote')) sheet_display +="public_note*";
		if (display.includes('Publisher')) sheet_display +="publisher*";
		if (display.includes('Reference')) sheet_display +="reference*";
		if (display.includes('StaffNote')) sheet_display +="staff_note*";
		if (display.includes('StatCat')) sheet_display +="stat_cat*";
		if (display.includes('StatusChange')) sheet_display +="stat_change*";
		if (display.includes('Summary')) sheet_display +="summary*";
		if (display.includes('YTDCirc')) sheet_display +="ytd_circ*";

	   ajax.setVar("sheet_display",sheet_display);

   }

    if (document.getElementById('html').checked)
	{
	   ajax.setVar("html","html");

		var order = $(document.getElementById("html_order")).text();
		var layout =  $(document.getElementById("html_layout")).text();
		var options =  $(document.getElementById("html_options")).text();
		var display = $(document.getElementById("html_display")).text();
		display = display.replace(/\s+/g, '');
		options = options.replace(/\s+/g, '');

		if (order.includes('Title')) ajax.setVar("html_order","title_sort");
		else if (order.includes('Author')) ajax.setVar("html_order","author_sort");
		else if (order.includes('Call')) ajax.setVar("html_order","call_sort");
		else if (order.includes('Active')) ajax.setVar("html_order","active_sort");
		else if (order.includes('Lifetime')) ajax.setVar("html_order","circ_sort");
		else if (order.includes('YTD')) ajax.setVar("html_order","ytd_sort");

		if (layout.includes('Block')) ajax.setVar("block_layout","block");
		if (layout.includes('Inline')) ajax.setVar("inline_layout","inline");
		if (layout.includes('Grid'))
		{
		   ajax.setVar("grid_layout","grid");
		   //get and set grid width
         var pos = layout.indexOf("Grid");
         pos +=5;
         var width = layout.substring(pos, pos+1);

         ajax.setVar("html_grid_width", width);
		}

		if (options.includes('GroupItemsFirst')) ajax.setVar("html_group",1);
		else if (options.includes('GroupItemsAll')) ajax.setVar("html_group","all");

		if(options.includes('ImageSizeSmall')) ajax.setVar("image_size", "small");
		else if (options.includes('ImageSizeMedium')) ajax.setVar("image_size", "medium");
		else if (options.includes('ImageSizeLarge')) ajax.setVar("image_size", "large");

		if (options.includes('WordPress')) ajax.setVar("html_word_press",1);
      if (options.includes('EmbeddableURL'))
      {
         ajax.setVar("save_html",1);
         if (copy_report) ignore_out_name = true;
      }

		//pull apart the display string and figure out what needs to be checked
		var html_display ='';

		if (display.includes('Author')) html_display +="author*";
		if (display.includes('CallNumber')) html_display +="call_num*";
		if (display.includes('CoverImage')) html_display +="cover*";
		if (display.includes('Part')) html_display +="part*";
		if (display.includes('Title'))  html_display +="title*";

		if (display.includes('Active')) html_display +="active*";
		if (display.includes('AgeProtection')) html_display +="age_protect*";
		if (display.includes('AmazonDirect')) html_display +="amz_direct*";
		if (display.includes('AmazonSearch')) html_display +="amz_search*";
		if (display.includes('Barcode')) html_display +="barcode*";
		if (display.includes('BibId')) html_display +="bib_id*";
		if (display.includes('CircLib')) html_display +="circ_lib*";
		if (display.includes('CircModifier')) html_display +="circ_mod*";
		if (display.includes('ShelvingLocation')) html_display +="copy_loc*";
		if (display.includes('ItemStatus')) html_display +="status*";
		if (display.includes('Goodreads')) html_display +="goodreads*";
		if (display.includes('InHouse')) html_display +="in_house*";
		if (display.includes('ISBN')) html_display +="isbn*";
		if (display.includes('LastCheckin')) html_display +="last_checkin*";
		if (display.includes('LifetimeCirc')) html_display +="life_circ*";
		if (display.includes('OCLCNumber')) html_display +="oclc*";
		if (display.includes('PublicNote')) html_display +="public_note*";
		if (display.includes('Publisher')) html_display +="publisher*";
		if (display.includes('PubDate')) html_display +="pub_date*";
		if (display.includes('StaffNote')) html_display +="staff_note*";
		if (display.includes('StatCat')) html_display +="stat_cat*";
		if (display.includes('StatusChange')) html_display +="stat_change*";
		if (display.includes('Summary')) html_display +="summary*";
		if (display.includes('YTDCirc')) html_display +="ytd_circ*";

	   ajax.setVar("html_display",html_display);

   }

    if (document.getElementById('rss').checked)
	{
	    ajax.setVar("rss","rss");

		var listname = $(document.getElementById("rss_list")).text();
		var description =  $(document.getElementById("rss_description")).text();

		ajax.setVar("rss_list",listname);
		ajax.setVar("rss_desc",description);

   }

    if (document.getElementById('bookbag').checked)
	{
	   ajax.setVar("bookbag","bookbag");

	   var bagupdate = $(document.getElementById("bookbag_update")).text();
	   bagupdate = bagupdate.trim();
       ajax.setVar("bag_update",bagupdate);

		var bagname =$(document.getElementById("bookbag_name")).text();
		bagname = bagname.trim();
		//Make sure there's a bag name
		if ( bagupdate.includes("new") && bagname.includes('Not Set'))
		{
		   swal('ERROR!', "New Bookbag must be given a name. ", 'error');
         return false;
		}
		else
		{
		   if (!bagname.includes('Not Set'))ajax.setVar("bag_name",bagname);
		}

		var id =  $(document.getElementById("bookbag_id")).text();
		id = id.trim();
		var orig_bag_id = document.getElementById("input_bag_id").value;

		if (copy_report)
		{
		    //let code generate a new bag id
		    if (bagupdate != "new")
		    {
		       //if this is a copy make sure the user changed the bag id or it will overwrite the original bucket
		       if (id == orig_bag_id)
		       {
		          swal('ERROR!', "Bookbag id identical to orignal report. Configure Bookbag to prevent overwriting original report bookbag. ", 'error').then((value) => {configureBookbag();});
                  return false;
		       }
		    }
		}
		else if (update)
		{

           //check that that not switching from carosel to non-carousel
           var carousel =  $(document.getElementById("make_carousel")).text();
		   carousel = carousel.trim();
		   if (carousel == "yes") carousel = 1;
		   else carousel = 0;
		   var orig_carousel = document.getElementById("input_carousel").value;

		   if (carousel != orig_carousel)
		   {
		      swal('ERROR!', "Lists cannot be changed from carousel to bookbag or vice versa. Please choose Schedule New Report. ", 'error');
              return false;
		   }

		   ajax.setVar("bag_id",orig_bag_id);
		}
		else if (bagupdate != "new" &&  id.includes('Not Set'))
		{
		   swal('ERROR!', "Need an id to update Bookbag. ", 'error');
         return false;
		}
		else
		{
		   if (!id.includes('Not Set'))ajax.setVar("bag_id",id);
		}


		var description =  $(document.getElementById("bookbag_description")).text();
		description = description.trim();
		if ( !description.includes('Not Set'))
		{
		   ajax.setVar("bag_desc",description);
		}

		var owner =  $(document.getElementById("bookbag_owner")).text();
		owner = owner.trim();
		if ( !owner.includes('Not Set'))
		{
		    ajax.setVar("bag_owner",owner);
		}

		var carousel = $(document.getElementById("make_carousel")).text();
		carousel = carousel.trim();
		if ( carousel == "yes")
		{
		   ajax.setVar("carousel","yes");
		}

   }

   if (document.getElementById('copy_bucket').checked)
	{
	   ajax.setVar("copy_bucket","copy_bucket");

	   var copy_update = $(document.getElementById("copy_bucket_update")).text();
	   copy_update = copy_update.trim();
      ajax.setVar("copy_bucket_update",copy_update);

		var copy_bucket_name =$(document.getElementById("copy_bucket_name")).text();
		copy_bucket_name = copy_bucket_name.trim();
		//Make sure there's a bag name
		if ( copy_update.includes("new") && copy_bucket_name.includes('Not Set'))
		{
		   swal('ERROR!', "New Item Bucket must be given a name. ", 'error');
         return false;
		}
		else
		{
		   if (!copy_bucket_name.includes('Not Set')) ajax.setVar("copy_bucket_name",copy_bucket_name);
		}

		var description =  $(document.getElementById("copy_bucket_description")).text();
		description = description.trim();
		if ( !description.includes('Not Set'))
		{
		   ajax.setVar("copy_bucket_desc",description);
		}

		var owner =  $(document.getElementById("copy_bucket_owner")).text();
		owner = owner.trim();
		if ( !owner.includes('Not Set'))
		{
		    ajax.setVar("copy_bucket_owner",owner);
		}

		var id =  $(document.getElementById("copy_bucket_id")).text();
		id = id.trim();
		var orig_bucket_id = document.getElementById("input_copy_bucket_id").value;

		if (copy_report)
		{
		    //let code generate a new bag id
		    if (copy_update != "new")
		    {
		       //if this is a copy make sure the user changed the bag id or it will overwrite the original bucket
		       if (id == orig_bucket_id)
		       {
		          swal('ERROR!', "Item Bucket id identical to orignal report. Configure Item Bucket to prevent overwriting original report bookbag. ", 'error').then((value) => {configureCopyBucket();});
                return false;
		       }
		    }
		}
		else if (update)
		{
		   ajax.setVar("copy_bucket_id",orig_bucket_id);
		}
		else if (copy_update != "new" &&  id.includes('Not Set'))
		{
		   swal('ERROR!', "Need an id to update Item Bucket. ", 'error');
         return false;
		}
		else
		{
		   if (!id.includes('Not Set'))ajax.setVar("copy_bucket_id",id);
		}
   }

   if (document.getElementById('json').checked)
	{
	   ajax.setVar("json","json");
	   if (copy_report) ignore_out_name = true;

	   var json_data_type = $(document.getElementById("json_data_type")).text();
	   json_data_type = json_data_type.trim();

	   ajax.setVar("json_data_type", json_data_type);
	}


	var out_file = document.getElementById('out_file').value;

	if (out_file.length > 1)
	{
	    if (!(copy_report && ignore_out_name))
	    {
	       ajax.setVar("out_file",out_file);
	    }
	}



   //if not scheduled call run_list_report
   if (document.getElementById("one_report").checked)
   {
      var report_name = document.getElementById('report_name').value;
      if (report_name.length > 1 )
      {
         ajax.setVar("report_name",report_name);
      }

      ajax.requestFile = "run_list_report.php";
      ajax.runAJAX();


      if (working)
      {
         swal('Success!', "Your Report has been configured. You will receive an email with the report shortly.", 'success');
      }
      else
      {
         swal('Success!', "Your Report has been configured. You will receive an email with the report shortly.", 'success').then((value) => { var url = window.location.href.split('?')[0]; window.location = url; });
      }

   }
   else if (document.getElementById("schedule_report").checked)
   {
      //go get all the specifics of when
      var often = document.getElementById('how_often');
      var how_often = often.options[often.selectedIndex].value;

       if (update == true && copy_report == false)
       {
           //get db_id
           var db_id = document.getElementById('use_db').value;
           if (db_id > -1 )
           {
              ajax.setVar("db_id", db_id);
           }
       }

      if (how_often == "none" )
      {
         swal('ERROR!', "Select Frequency of Scheduled reports. ", 'error');
         return false;
      }
      else if (how_often == "monthly" )
      {
         var specific_days = document.getElementById('specific_days').value;
         var interval = document.getElementById('first_last');
         var first_last = interval.options[interval.selectedIndex].value;

         var week_day = document.getElementById('month_days');
         var month_days = week_day.options[week_day.selectedIndex].value;

         if (specific_days.length < 1 )
         {
            if (month_days =="none" && first_last == "none")
            {
               swal('ERROR!', "Select frequency of scheduled reports. " , 'error');
               return false;
            }
         }
         else
         {
            ajax.setVar("run_specific_days",specific_days);
         }

         if (first_last != "none" && month_days != "none" )
         {
            ajax.setVar("preset_first_last",first_last);
            ajax.setVar("preset_month_day",month_days);
         }


      }
      else if (how_often == "daily" )
      {
         ajax.setVar("run_daily","daily");
      }
      else if (how_often == "weekly" )
      {
         var days="";

         if (document.getElementById('monday').checked) days+="monday*";
         if (document.getElementById('tuesday').checked) days+="tuesday*";
         if (document.getElementById('wednesday').checked) days+="wednesday*";
         if (document.getElementById('thursday').checked) days+="thursday*";
         if (document.getElementById('friday').checked) days+="friday*";
         if (document.getElementById('saturday').checked) days+="saturday*";
         if (document.getElementById('sunday').checked) days+="sunday*";

         if (days.length < 1)
         {
            swal('ERROR!', "Select the days of week you want to run the weekly report. ", 'error');
            return false;
         }
         else
         {
            ajax.setVar("run_weekly",days);
         }


      }
      else if (how_often == "configure" )
      {
         var run_relative = document.getElementById('relative_time').value;

         if (run_relative.length < 1)
         {
            swal('ERROR!', "Please enter a value for configuring report run frequency. ", 'error');
            return false;
         }
         else
         {
            var config = document.getElementById('relative_measure');
            var config_time = config.options[config.selectedIndex].value;
            var config_out = run_relative+"_"+config_time;

            ajax.setVar('run_configure', config_out);

               var run_start = document.getElementById('relative_start_date').value;
			   if (!isValidDate(run_start, true))
			   {
			   	 swal('Error', "Please format start date as MM/DD/YYYY or use datepicker.", 'error');
		   		 return false;
		   	}

		   	ajax.setVar('run_configure_start', run_start);

         }
      }

      if (document.getElementById('run_now').checked)
      {
         ajax.setVar("run_now","now");
      }

      var report_name = document.getElementById('report_name').value;
      if (report_name.length > 1 )
      {
         ajax.setVar("report_name",report_name);
      }
      else
      {
         swal('ERROR!', "Report name is required for Scheduled reports. Please enter a value report name. ", 'error');
         return false;
      }

      ajax.requestFile = "add_scheduled_report.php";
      ajax.runAJAX();

       if (working)
       {
          swal('Success!', "Your Report has been scheduled.", 'success');
       }
       else
       {
          if (db_id) swal('Updated!', "Your Report has been updated.", 'success').then((value) => { var url = window.location.href.split('?')[0]; window.location = url; });
          else swal('Success!', "Your Report has been scheduled.", 'success').then((value) => { var url = window.location.href.split('?')[0]; window.location = url; });
       }


   }
}




