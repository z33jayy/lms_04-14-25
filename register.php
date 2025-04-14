<?php 
session_start();
require("connection.php");

// Initialize variables
$name = $role = $address = $CellphoneNum = $email = $password = $gender = $Birthdate = "";
$namerr = $roleerr = $addresserr = $numerr = $emailerr = $passworderr = $gendererr = $birtherr = "";

// Input sanitization
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Name
    if (empty($_POST["name"])) {
        $namerr = "* Name is required";
    } else {
        $name = test_input($_POST["name"]);
        if (!preg_match("/^[a-zA-Z-' ]*$/", $name)) {
            $namerr = "* Only letters and white space allowed";
        }
    }

    // Role
    if (empty($_POST["role"])) {
        $roleerr = "* Role is required";
    } else {
        $role = test_input($_POST["role"]);
    }

    // Address
    if (empty($_POST["address"])) {
        $addresserr = "* Address is required";
    } else {
        $address = test_input($_POST["address"]);
    }

    // Cellphone Number
    if (empty($_POST["CellphoneNum"])) {
        $numerr = "* Cellphone number is required";
    } else {
        $CellphoneNum = test_input($_POST["CellphoneNum"]);
        if (!preg_match("/^09\d{9}$/", $CellphoneNum)) {
            $numerr = "* Invalid format (example. 09123456789)";
        }
    }

    // Email
    if (empty($_POST["email"])) {
        $emailerr = "* Email is required";
    } else {
        $email = test_input($_POST["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailerr = "* Invalid email format";
        }
    }

    // Password
    if (empty($_POST["password"])) {
        $passworderr = "Password is required";
    } else {
        $password = test_input($_POST["password"]);
        if (strlen($password) < 6) {
            $passworderr = "* Password must be at least 6 characters";
        }
    }

    // Gender
    if (empty($_POST["gender"])) {
        $gendererr = "* Gender is required";
    } else {
        $gender = test_input($_POST["gender"]);
    }

    // Birthdate
    if (empty($_POST["Birthdate"])) {
        $birtherr = "* Birthdate is required";
    } else {
        $Birthdate = test_input($_POST["Birthdate"]);
    }

    // if All inputs are valid
    if (empty($namerr) && empty($roleerr) && empty($addresserr) && empty($numerr) && empty($emailerr) && empty($passworderr) && empty($gendererr) && empty($birtherr)) {

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        if ($role == 'Student') {
            $year = date("y");
            $randomNum = rand(1000, 9999);
            $student_id = intval($year . $randomNum);
            $sql = "INSERT INTO user_information (fullname, role, address, CellphoneNum, email, password, gender, Birthdate, student_id) 
                    VALUES ('$name', '$role', '$address', '$CellphoneNum', '$email', '$hashedPassword', '$gender', '$Birthdate', '$student_id')";
        } elseif ($role == 'Admin') {
            $sql = "INSERT INTO user_information (fullname, role, address, CellphoneNum, email, password, gender, Birthdate) 
                    VALUES ('$name', '$role', '$address', '$CellphoneNum', '$email', '$hashedPassword', '$gender', '$Birthdate')";
        } else {
            $year = date("y");
            $randomNum = rand(100, 999);
            $teacher_id = intval($year . $randomNum);
            $sql = "INSERT INTO user_information (fullname, role, address, CellphoneNum, email, password, gender, Birthdate, teacher_id) 
                    VALUES ('$name', '$role', '$address', '$CellphoneNum', '$email', '$hashedPassword', '$gender', '$Birthdate', '$teacher_id')";
        }

        $query = mysqli_query($con, $sql);
        if ($query) {
            header("Location: admin_users.php");
            exit();
        } else {
            echo "<script>alert('Registration failed. Please try again.');</script>";
            header("Location:register.php");
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <style>
        body {
            background-image: url('http://localhost/my_website/Photos/Friendship.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            filter: brightness(90%);
            margin: 0;
        }
        .jumbotron {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
            background-color: red;
            padding: 1rem;
            color: white;
        }
        .jumbotron img {
            width: 50px;
        }
        .form-container {
            max-height: 600px;
            overflow-y: auto;
            padding: 25px;
            max-width: 480px;
            margin: 30px auto;
            background-color: white;
            opacity: 95%;
        }
        .text-danger {
            font-size: 0.9rem;
        }
    </style>
</head>
<body class="bg-light">

<div class="jumbotron text-center">
    <img src="http://localhost/my_website/Photos/CULOGO.png" alt="Logo">
    <h1 style="font-family: Oswald, serif; margin: 0;">CapEd Learning Management System</h1>
</div>

<div class="container">
    <div class="form-wrapper">
        <form class="form-container" method="POST" action="">
            <h4 class="text-center mb-4">Register</h4>

            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" name="name" value="<?= htmlspecialchars($name) ?>">
                <small class="text-danger"><?= $namerr ?></small>
            </div>

            <div class="mb-3">
                <label for="role" class="form-label">Role</label>
                <select name="role" class="form-control">
                    <option value="">Select Role</option>
                    <option value="Student" <?= $role == "Student" ? "selected" : "" ?>>Student</option>
                    <option value="Teacher" <?= $role == "Teacher" ? "selected" : "" ?>>Teacher</option>
                    <option value="Admin" <?= $role == "Admin" ? "selected" : "" ?>>Admin</option>
                </select>
                <small class="text-danger"><?= $roleerr ?></small>
            </div>

            <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <input type="text" class="form-control" name="address" value="<?= htmlspecialchars($address) ?>">
                <small class="text-danger"><?= $addresserr ?></small>
            </div>

            <div class="mb-3">
                <label for="CellphoneNum" class="form-label">Cellphone Number</label>
                <input type="text" class="form-control" name="CellphoneNum" value="<?= htmlspecialchars($CellphoneNum) ?>">
                <small class="text-danger"><?= $numerr ?></small>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="text" class="form-control" name="email" value="<?= htmlspecialchars($email) ?>">
                <small class="text-danger"><?= $emailerr ?></small>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" name="password">
                <small class="text-danger"><?= $passworderr ?></small>
            </div>

            <div class="mb-3">
                <label for="gender" class="form-label">Gender</label>
                <select name="gender" class="form-control">
                    <option value="">Select Gender</option>
                    <option value="Male" <?= $gender == "Male" ? "selected" : "" ?>>Male</option>
                    <option value="Female" <?= $gender == "Female" ? "selected" : "" ?>>Female</option>
                    <option value="Other" <?= $gender == "Other" ? "selected" : "" ?>>Other</option>
                </select>
                <small class="text-danger"><?= $gendererr ?></small>
            </div>

            <div class="mb-3">
                <label for="Birthdate" class="form-label">Birthdate</label>
                <input type="date" class="form-control" name="Birthdate" value="<?= htmlspecialchars($Birthdate) ?>">
                <small class="text-danger"><?= $birtherr ?></small>
            </div>

            <button type="submit" class="btn btn-primary w-100">Register</button>

            <div class="ICONS d-flex justify-content-center mt-3">
                <a href="login.php"><i class="bi bi-box-arrow-left mx-2" style="font-size: 2rem;" title="Go Back"></i></a>
                <i class="bi bi-facebook mx-2" style="font-size: 2rem;" title="Facebook Page"></i>
                <i class="bi bi-envelope-at-fill mx-2" style="font-size: 2rem;" title="Email Us"></i>
            </div>
        </form>
    </div>
</div>

</body>
</html>
