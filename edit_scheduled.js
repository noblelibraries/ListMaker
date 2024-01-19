var ajax = new sack;

function getBranches(LibName)
{   
   
   var filter_branch= document.getElementById('branch');
   filter_branch.options.length = 0;
   
    
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
         filter_branch.options[filter_branch.options.length] = new Option('Brace','PANB');
         filter_branch.options[filter_branch.options.length] = new Option('CAMD','PANC');
         filter_branch.options[filter_branch.options.length] = new Option('Clift','PANG');
         filter_branch.options[filter_branch.options.length] = new Option('IFC','PANI');
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
}

function CheckForm()
{
   var library = document.getElementById('library').value;
   var email = document.getElementById('email').value;
   
   if (library == "NONE" && email.length < 1)
   {
       sweetAlert('Error', "Must Select a Library And/OR an email address", 'error');
       return;
   }
   
   if (email.length > 0 )
   {
      if (email.indexOf('@') == -1)
      {
         sweetAlert('Error', "Please Enter an valid Email Address", 'error');
         return false;
      }
   }
}

function ActivateReport(db_id, on)
{
   var status =""; 
	if (on) 
	{
		status += "<h3 style=\"color:green;\">Active";
		status +=  "<input type=\"button\" name=\"active\" id=\"active\" class=\"stats on_button\" value=\"Turn Off\" onclick=\"ActivateReport("+db_id+",false);\">";
		status +=  "</h3>";

	}
	else 
	{
		status +=  "<h3 style=\"color:red;\">Inactive";
		status +=  "<input type=\"button\" name=\"active\" id=\"active\" class=\"stats on_button\" value=\"Turn On\" onclick=\"ActivateReport("+db_id+",true);\">";
		status +=  "</h3>";
	}
	 
   document.getElementById('activate_status_'+db_id).innerHTML = status;
	
   ajax.requestFile = "activateLists.php?db_id="+db_id+"&status="+on;	// Specifying which file to get
   ajax.onCompletion = activateList;	// Specify function that will be executed after file has been found
   ajax.runAJAX();		// Execute AJAX function
}
   
   
function activateList()
{
	eval(ajax.response);	// Executing the response from Ajax as Javascript code
}


