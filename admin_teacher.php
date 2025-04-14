<?php 
require("connection.php");
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit();
}

// Get the currently logged-in user
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM user_information WHERE id = '$user_id'";
$query = mysqli_query($con, $sql);
$user = mysqli_fetch_assoc($query);

// Role-based redirect
if (is_array($user) && isset($user['role']) == 'Teacher') {
    header("Location: Homepage2.php");
    exit();
}
if (is_array($user) && isset($user['role']) == 'Student') {
    header("Location: Homepage.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style type="text/css">
        body {
      background-color: lightgrey;
      min-height: 100vh;
      margin: 0;
      display: flex;
      flex-direction: column;
      font-family: 'Segoe UI', sans-serif;
    }

    .form-container {
      max-width: 400px;
      margin: 50px auto;
      padding: 20px;
      border: 1px solid #ccc;
      border-radius: 8px;
      background-color: white;
      }

      .jumbotron {
        display: flex;
        gap: 15px;
        }

      #CULOGO {
        width: 50px;
        height: auto;
        }
        /*table*/
       @media (max-width: 768px) {
      .table {
        font-size: 0.9rem;
      }
    }
    #crud:hover{
      cursor: pointer;
      text-decoration: underline;
    }
    .nav-link{
      font-size: 1rem;
    }
    .nav-link:hover{
     background-color: #d0d3d4;
     border-radius: 15px;
    }

    </style>
</head>
<body>


<div class="jumbotron text-white p-3" style="background-color: darkred;">
    <img src="http://localhost/my_website/Photos/CULOGO.png" alt="Logo" id="CULOGO">
    <h1 style=" margin: 0;">CapEd-LMS Admin Panel</h1>
</div>

<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand">Menu</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="admin_users.php">Users</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="admin_student.php">Students</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="admin_teacher.php">Teachers</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="admin_classroom.php">Classrooms</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="register.php">Register</a>
        </li>
       <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="logout.php">Logout</a>
        </li>
      </ul>
      
    </div>
  </div>
</nav>

  <!-- Main Content -->
  
    <div class="container">
  <div class="table-responsive">
    <table class="table table-striped table-bordered"> <!-- Bootstrap Table classes -->
      <thead>
        <tr>
          <th>ID</th>
          <th>Student ID</th>
          <th>Teacher ID</th>
          <th>Full Name</th>
          <th>Address</th>
          <th>Cell Phone Number</th>
          <th>Email</th>
          <th>Gender</th>
          <th>Birthdate</th>
          <th>Role</th>
          <th>Profile Pic</th>
          <th colspan="2">Update & Delete</th>
        </tr>
      </thead>
      <br>
      <tbody>
        <?php 
          $sql1 = "SELECT * FROM user_information WHERE role = 'Teacher'";
          $query = mysqli_query($con, $sql1);
          while($row = mysqli_fetch_assoc($query)){
        ?>
        <tr>
          <td><?php echo $row['id']; ?></td>
          <td><?php echo $row['student_id']; ?></td>
          <td><?php echo $row['teacher_id']; ?></td>
          <td><?php echo $row['fullname']; ?></td>
          <td><?php echo $row['address']; ?></td>
          <td><?php echo $row['CellphoneNum']; ?></td>
          <td><?php echo $row['email']; ?></td>
          <td><?php echo $row['gender']; ?></td>
          <td><?php echo $row['Birthdate']; ?></td>
          <td><?php echo $row['role']; ?></td>
          <td></td>
          <td style="color: green;" id="crud"><a href="edit.php?edit=<?php echo $row['id'];?>">Edit</a></td>
          <td style="color: red;" id="crud"><a href="delete.php?delete=<?php echo $row['id'];?>">Delete</a></td>
        </tr>
        <?php } ?>

      </tbody>
    </table>
  </div>
</div>

  
</div>



</body>
</html>