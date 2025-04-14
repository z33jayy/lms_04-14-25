<?php
require("connection.php");

$sql = "CREATE DATABASE users_table";
$query = mysqli_query($con, $sql);

// if ($query) {
// 	echo "Created";
// }else{
// 	echo "Failed";
// }
?>