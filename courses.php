<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<meta http-equiv="Cache-control" content="no-cache">
<meta http-equiv="Expires" content="-1">
<meta http-equiv="pragma" content="no-cache">

<title>Configure Courses </title>

<link rel="stylesheet" type="text/css" href="../css/noble.css" />

<link rel="stylesheet" href="https://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
<script src="https://code.jquery.com/jquery-1.9.1.js"></script>
<script src="https://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<script type="text/javascript" src="../../shared/ajax/ajax.js"></script>
<script src="../../shared/sweetalert2/dist/sweetalert2.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script type="text/javascript" src="form_functions.js"></script>

<script type="text/javascript" src="../../shared/ajax/ajax.js"></script>
<script type="text/javascript">

var course_ajax = new sack();

function getCourseTerms()
{
   var LibName = "<?php echo $_GET['lib'] ?>";
   var Branch = "<?php echo $_GET['branch'] ?>";

   var preset_course= "<?php echo $_GET['course'] ?>";

   if(preset_course && preset_course != '-1' && preset_course != '0')
   {
      document.getElementById('all').disabled = true;
      document.getElementById('all_label').style.opacity=  0.6;

      course_ajax.requestFile = "setPrevCourses.php?lib="+LibName+"&branch="+Branch+"&course="+preset_course;	// Specifying which file to get
      course_ajax.onCompletion = setPreviousCourses;	// Specify function that will be executed after file has been found
      course_ajax.runAJAX();		// Execute AJAX function
   }
   else
   {
      document.getElementById('all').disabled = true;
      document.getElementById('all_label').style.opacity=  0.6;
      course_ajax.requestFile = "getTerms.php?lib="+LibName+"&branch="+Branch;	// Specifying which file to get
      course_ajax.onCompletion = createCourseTerms;	// Specify function that will be executed after file has been found
      course_ajax.runAJAX();		// Execute AJAX function
   }


}

function createCourseTerms()
{
	var obj = document.getElementById('course_terms');
	eval(course_ajax.response);	// Executing the response from Ajax as Javascript code
}

function setPreviousCourses()
{
	var course_obj = document.getElementById('course_terms');
	var selected_courses = document.getElementById('selected_course_div');
		var checkbox_div = document.getElementById('course_checkboxes');
	eval(course_ajax.response);	// Executing the response from Ajax as Javascript code
}

function updateCourses(course_term)
{
   //get the value from the statCat words***value
   var val = course_term.indexOf("***");
   var term = course_term.slice(val+3);

   document.getElementById('course_checkboxes').innerHTML = "";
   document.getElementById('curr_term').value = course_term;

   document.getElementById('all').checked = false;
   if (term > -1)
   {
	  document.getElementById('all').disabled = false;
	  document.getElementById('all_label').style.opacity=  1.0;
   }
   else
   {
	  document.getElementById('all').disabled = true;
	  document.getElementById('all_label').style.opacity=  0.6;
   }

   var course = "";
   var selected = document.getElementsByName("course_vals");
   for (var i = 0; i < selected.length; i++)
   {
	  course += selected[i].value+"*";
   }

   if(term > 0)
   {
	  if (course.length > 1) course_ajax.requestFile = "getCourses.php?term="+term+"&courses="+course;	// Specifying which file to get
	  else course_ajax.requestFile = "getCourses.php?term="+term;
	  course_ajax.onCompletion = createCourseList;	// Specify function that will be executed after file has been found
	  course_ajax.runAJAX();		// Execute AJAX function
   }
}

function getCourseList(course_term)
{
   //see if there is anything selected in he selected_course_div
   if ( document.getElementsByName('course_vals').length > 0)
   {
	   // div has no other tags inside it
	   swal({title: "Term Error",
             text: "Courses can only be added from a single term in order to provide accurate circulation statistics.",
             icon: "error",
             buttons:["Keep this Term", "Switch Terms"],
             dangerMode: true,
          })
          .then((switchterms) => {
               if (switchterms)
               {
                    document.getElementById("selected_course_div").innerHTML = '';
                    updateCourses(course_term);
               }
               else
               {
                  //set this select back to what it was
                  document.getElementById("course_terms").value = document.getElementById('curr_term').value;
                  return false;
               }
          });
   }
   else
   {
      updateCourses(course_term);
   }

}

function createCourseList()
{
	var checkbox_div = document.getElementById('course_checkboxes');
	eval(course_ajax.response);	// Executing the response from Ajax as Javascript code
}

function selectAll(all)
{
   var checkbox_array = document.getElementsByName('course_checkboxes');
   for(var i=0; i<checkbox_array.length; i++)
   {
      checkbox_array[i].checked = all.checked;
      if (all.checked)
      {
         //add to the bottom
         AddCourse(checkbox_array[i]);
      }
      else
      {
         //remove from the bottom
         RemoveCourse(checkbox_array[i].value);
      }
   }
}

function submitCourses()
{

   var course_vals ="";


   //get all nodes named stat_vals
   //use values to create stat_vals variable
   var vals = document.getElementsByName("course_vals");
   for (var i=0; i < vals.length; i++)
   {
      course_vals+=vals[i].value+"*";
   }

   var course_words="";
   var words = document.getElementsByName("course_words");
   for (var j=0; j < words.length; j++)
   {
      course_words+=words[j].getAttribute("id")+"%";
   }

   //get all the nodes named stat_words
   //use the ids to create stat_words variable
   //document.getElementById("debug").value = course_vals+"\n"+course_words;

   window.opener.HandleCourseResult(course_vals, course_words);
   window.opener = self;
   window.close();
   return false;

}

function cancelCourses()
{
   window.opener.HandleCourseResult('0');
   window.close();
   return false;
}

function AddCourse(course)
{

   //get whether check is checked
   var checkbox_val = course.value;
   var seperator = checkbox_val.indexOf("***");
   var term_sep = checkbox_val.indexOf("!!");
   var course_id = checkbox_val.slice(seperator+3);
   var course_words = checkbox_val.slice(0, seperator);

   var display_course_words = checkbox_val.slice(0, seperator).replace("*","'");

   var term = document.getElementById("course_terms").value;
   var sep = term.indexOf("***");
   var term_val = term.slice(sep+3);
   var term_words = term.slice(0, sep);

   //if checked -- add this plus stat cat to selected stats
   //store the
   if(course.checked)
   {
      //Check that this one isn't already in the list due to an all situation
      var elementExists = document.getElementById(checkbox_val);
      if (elementExists) return;

      var new_html ="";

      //create a span
      new_html += "<span id='"+checkbox_val+"' class='stat_row'>";

      //create words for the stat
      new_html += "<span id='"+term_words+"/"+course_words+"' name='course_words'>"+term_words+"/"+display_course_words+"</span>";

      //create hidden input for the values with common name
      new_html += "<input type='hidden' name='course_vals' value='"+ term_val+"("+course_id+")'/>";

      //create a button to remove with checkbox_val ans val
      new_html +="<input type=\"button\"  value=\"Remove\" class=\"remove_stat\" onClick=\"RemoveCourse('"+checkbox_val+"')\"/>";

      //end span
      new_html += "</span>";

      document.getElementById("selected_course_div").innerHTML += new_html;

   }
   else
   {
      RemoveCourse(checkbox_val);
   }

}

function RemoveCourse(name)
{
   var course = document.getElementById(name);

   if (document.getElementById(name+"_cb")) document.getElementById(name+"_cb").checked = false;

   if (document.getElementById('all').checked == true)
   {
      var term = document.getElementById("course_terms").value;
      var sep = term.indexOf("***");
      var term_val = term.slice(0, sep);

      var words = course.firstChild.getAttribute("id");

      if(words.indexOf(term_val) > -1) document.getElementById('all').checked = false;

   }
   course.parentNode.removeChild(course);
}

</script>
</head>


<body onload="getCourseTerms()">

<div id="content">

<h1 class="courses">Configure Courses </h1>

<form id="stats">

<div id="course_form">
<label id="select_label"> Course terms: </label>
<select id="course_terms" name="course_terms"  onchange="getCourseList(this.value)" class="stats">
</select>
      <input type="checkbox" id="all" name="all" onClick="selectAll(this)"/>
      <label id="all_label"> Select All</label>
      <input type ="hidden" id="curr_term">
<br /><br />
<div id="course_checkboxes">
</div><!--end checkboxes -->

<hr />
<h2 class="weeding"> Selected Courses</h2>
<div id="selected_course_div" class="course_list weeding">

</div>

<!--<textarea id = "debug" ></textarea>-->

<div id="done">
	<input type="button" value="Cancel" class="stats" onClick="return cancelCourses()"/>
	<input type="button" value="Done" class="stats" onClick="return submitCourses()"/>
</div>

</div> <!-- endstat cat form -->
</form>

</div><!--end content-->

</body>
</html>