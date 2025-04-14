<?php

require("connection.php");

$id = $_GET['edit'];
$sql = "SELECT * FROM user_information WHERE id = '$id'";
$query = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($query);

if (isset($_POST['submit'])) {
	$fullname = $_POST['fullname'];
	$address = $_POST['address'];
	$CellphoneNum = $_POST['CellphoneNum'];
	$gender = $_POST['gender'];
	$Birthdate = $_POST['Birthdate'];
	$role = $_POST['role'];

	$sql = "UPDATE user_information 
	        SET fullname = '$fullname', address = '$address', CellphoneNum = '$CellphoneNum', gender = '$gender', Birthdate = '$Birthdate', role = '$role' 
	        WHERE id = '$id'";
	$query = mysqli_query($con, $sql);

	if ($query) {
		header("Location: admin_users.php");
	} else {
		echo "error";
	}
}
?>



<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
</head>
<body>

	<form method="POST">
		<input type="text" name="fullname" value="<?php echo $row['fullname'];?>">
		<input type="text" name="address" value="<?php echo $row['address'];?>">
		<input type="text" name="CellphoneNum" value="<?php echo $row['CellphoneNum']; ?>">
		<input type="text" name="email" value="<?php echo $row['email']; ?>">
		<input type="text" name="gender" value="<?php echo $row['gender']; ?>">
		<input type="text" name="Birthdate"value="<?php echo $row['Birthdate']; ?>">
		<input type="text" name="gender" value="<?php echo $row['role']; ?>">
		<input type="submit" name="submit">
	</form>

</body>
</html>