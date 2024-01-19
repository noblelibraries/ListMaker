<?php

if(isset($_GET["term"]) )
{
   include "/usr/local/noble/db_config/db_info.php";

   $db = pg_connect("host=$eg_host port=$eg_port dbname=$eg_database user=$eg_user password=$eg_password");
   if (!$db)
   {
      die("Error in connection: " . pg_last_error());
   }

   $check_courses = false;
   $term = $_GET["term"];

   if (isset($_GET["courses"]))
   {
      $check_courses = true;
      $course_list = explode("*", $_GET["courses"]);
   }


   $sql = "SELECT DISTINCT asset.course_module_course.id, asset.course_module_course.name, asset.course_module_course.course_number, asset.course_module_course.section_number
           FROM asset.course_module_course
           JOIN asset.course_module_term_course_map ON asset.course_module_term_course_map.course = asset.course_module_course.id
           WHERE asset.course_module_term_course_map.term = $term
           AND asset.course_module_course.is_archived = false
           ORDER BY asset.course_module_course.course_number";

   $result = pg_query($db, $sql);

   while($row = pg_fetch_row($result))
   {
      if( strlen($row[1]) > 0)
      {
         if (strlen($row[3]) > 0) $course_display_name = $row[2]."-".$row[3].":".$row[1];
         else  $course_display_name = $row[2].":".$row[1];

         $cb_val = str_replace("'","*",$course_display_name)."***".$row[0];
         echo "var checkbox = \"<input type='checkbox' name='course_checkboxes' value='".$cb_val."' id='".$cb_val."_cb' ";
         if (in_array($row[0], $course_list)) echo "checked=checked ";
         echo "onClick='AddCourse(this)'/>\";";
         echo "checkbox_div.innerHTML+=checkbox +\"".$course_display_name."\"+ \"<br/>\";";
      }
   }
}

?>