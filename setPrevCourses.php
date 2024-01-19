<?php

if(isset($_GET["lib"]) && isset($_GET["course"]))
{
   include "/usr/local/noble/db_config/db_info.php";

   $db = pg_connect("host=$eg_host port=$eg_port dbname=$eg_database user=$eg_user password=$eg_password");
   if (!$db)
   {
      die("Error in connection: " . pg_last_error());
   }

   $all_courses = $_GET["course"];

   $library = $_GET["lib"];
   $courses = explode("*",$all_courses);
   $course2 = $all_courses;
   $branch = $_GET["branch"];

   $selected_term = substr($all_courses, 0, strpos($all_courses,"("));
   $term_value = "";

   //Get all the Possible Terms for this library
  if ($library == "NOBLE")
   {
      $sql = "SELECT  asset.course_module_term.id, asset.course_module_term.name, asset.course_module_term.start_date
			    FROM asset.course_module_term
			    ORDER BY asset.course_module_term.start_date DESC";
   }
   else if ($branch == 'none')
   {
      	$sql = "SELECT  asset.course_module_term.id, asset.course_module_term.name, asset.course_module_term.start_date
			    FROM asset.course_module_term
			    JOIN actor.org_unit ON actor.org_unit.id = asset.course_module_term.owning_lib
			    WHERE actor.org_unit.shortname IN (SELECT child.shortname
											 FROM actor.org_unit child
											 JOIN actor.org_unit parent on child.parent_ou = parent.id
											 WHERE parent.shortname='$library' OR child.shortname='$library')
			  ORDER BY asset.course_module_term.start_date DESC";
   }
   else
   {
      $sql = "SELECT  asset.course_module_term.id, asset.course_module_term.name, asset.course_module_term.start_date
			    FROM asset.course_module_term
			    JOIN actor.org_unit ON actor.org_unit.id = asset.course_module_term.owning_lib
			    WHERE actor.org_unit.shortname = '$branch' OR actor.org_unit.shortname = '$library'
			    ORDER BY asset.course_module_term.start_date DESC";
   }
   $result = pg_query($db, $sql);

   echo "course_obj.options[course_obj.options.length] = new Option('Select','-1');\n";

   while($row = pg_fetch_row($result))
   {
      if( strlen($row[1]) > 0)
      {
         if ($row[0] == $selected_term) $term_value = $row[1]."***".$row[0];
         echo "course_obj.options[course_obj.options.length] = new Option(\"".$row[1]."\",\"".$row[1]."***".$row[0]."\");\n";
      }
   }

   echo "course_obj.value = \"".$term_value."\";\n";

   //Get the course ids into an array
   //remove the term id(
   //remove (

    $text = sprintf("%d%s", $selected_term, "(");
    $delete = array(")", $text);
    $temp = str_replace($delete, "", $all_courses);

    $course_list = explode("*", $temp);

    $checkbox_sql = "SELECT DISTINCT asset.course_module_course.id, asset.course_module_course.name, asset.course_module_course.course_number, asset.course_module_course.section_number
            FROM asset.course_module_course
            JOIN asset.course_module_term_course_map ON asset.course_module_term_course_map.course = asset.course_module_course.id
            WHERE asset.course_module_term_course_map.term = $selected_term
           AND asset.course_module_course.is_archived = false
           ORDER BY asset.course_module_course.course_number";

   $checkbox_result = pg_query($db, $checkbox_sql);

   while($checkbox_row = pg_fetch_row($checkbox_result))
   {
      if( strlen($checkbox_row[1]) > 0)
      {
         if (strlen($checkbox_row[3]) > 0) $course_display_name = $checkbox_row[2]."-".$checkbox_row[3].":".$checkbox_row[1];
         else  $course_display_name = $checkbox_row[2].":".$checkbox_row[1];

         $cb_val = str_replace("'","*",$course_display_name)."***".$checkbox_row[0];
         echo "var checkbox = \"<input type='checkbox' name='course_checkboxes' value='".$cb_val."' id='".$cb_val."_cb' ";
         if (in_array($checkbox_row[0], $course_list)) echo "checked=checked ";
         echo "onClick='AddCourse(this)'/>\";";
         echo "checkbox_div.innerHTML+=checkbox +\"".$course_display_name."\"+ \"<br/>\";";
      }
   }

   reset($courses);
  $remove = array("(", ")");


   //loop thorugh the selected stat cats
   foreach($courses as $curr)
   {
      //get the term id
      $term_id = substr($curr, 0, strpos($curr,"("));

      //find the term words
      $term_sql = "SELECT  asset.course_module_term.id, asset.course_module_term.name
			      FROM asset.course_module_term
                  WHERE id = $term_id ";

      $term_result = pg_query($db, $term_sql);
      $term_row = pg_fetch_row($term_result);

      $term_words = $term_row[1];

      //get the course id
      $course_id = str_replace($remove,"",strstr($curr,"("));
      //find the course words
      $course_sql = "SELECT DISTINCT asset.course_module_course.id, asset.course_module_course.name, asset.course_module_course.course_number, asset.course_module_course.section_number
                     FROM asset.course_module_course
                     WHERE asset.course_module_course.id = $course_id ";

      $course_result = pg_query($db, $course_sql);
      $course_row = pg_fetch_row($course_result);

      if (strlen($course_row[3]) > 0) $course_words = $course_row[2]."-".$course_row[3].":".$course_row[1];
      else  $course_words = $course_row[2].":".$course_row[1];

      $node_name = str_replace("'","*",$course_words)."***".$course_row[0];

      //echo "NODE NAME =".$node_name;
      //add new nodes to the bottom

      echo "var new_html ='';\n";

      //create a span ew_html += "<span id='"+checkbox_val+"' class='stat_row'>";
      echo "new_html  += \"<span id='".$node_name."' class='stat_row'>\";\n";

      //create words for the stat
      echo "new_html += \"<span id='".$term_words."/".str_replace("'","*", $course_words)."' name='course_words'>".$term_words."/".$course_words."</span>\";\n";

      //create hidden input for the values with common name
      echo "new_html += \"<input type='hidden' name='course_vals' value='".$term_id."(".$course_id.")' />\";";

      //create a button to remove with checkbox_val ans val
      echo "new_html +=\"<input type=\\\"button\\\"  value=\\\"Remove\\\" class=\\\"remove_stat\\\" onClick=\\\"RemoveCourse('".$node_name."')\\\"/>\";";

      //end span
      echo "new_html += \"</span>\";";

      echo "selected_courses.innerHTML += new_html;";

   }

}

?>