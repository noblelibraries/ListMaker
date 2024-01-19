<?php

  include "/usr/local/noble/db_config/db_info.php";

  $db = pg_connect("host=$eg_host port=$eg_port dbname=$eg_database user=$eg_user password=$eg_password");
  if (!$db)
  {
     die("Error in connection: " . pg_last_error());
  }

  $db_id = $_GET['db_id'];
  $status = $_GET['status'];

  $sql = "UPDATE noble.scheduled_list
          SET active = $status
          WHERE id = $db_id";


  $result = pg_query($db, $sql);


?>