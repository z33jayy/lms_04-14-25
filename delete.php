<?php
require("connection.php");
$id = $_GET['delete'];
$sql = "DELETE FROM user_information WHERE id = '$id'";
$query = mysqli_query($con, $sql);

if($query){
    header("Location: admin_users.php");
}else{
    echo "Error";
}
?>
