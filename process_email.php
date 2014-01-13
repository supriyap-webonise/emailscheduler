<?php
include ("common.php");
$common = new DBConnection();
$connection = $common->dbconnection();
$records = $common->process_email($connection);
?>