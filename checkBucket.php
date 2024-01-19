<?php

   $type = $_GET['type'];
   $id = $_GET['id'];

   include "/usr/local/noble/db_config/db_info.php";

   $db = pg_connect("host=$eg_host port=$eg_port dbname=$eg_database user=$eg_user password=$eg_password");
   if (!$db)
   {
      die("Error in connection: " . pg_last_error());
   }

   if ($type == "copy")
   {
      $sql = "SELECT id
              FROM container.copy_bucket
              WHERE id = $id";
   }
   else
   {
      $sql = "SELECT id
              FROM container.biblio_record_entry_bucket
              WHERE id = $id";
   }

   $result = pg_query($db, $sql);

   $row = pg_fetch_row($result);

   if($row[0])
   {
       echo "document.getElementById('bucket_exists').value=\"true\";";
   }
   else
   {
      echo "document.getElementById('bucket_exists').value=\"false\";";
   }

?>