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
          <a class="nav-link active" aria-current="page" href="admin_users.php">Class_ID</a>
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
          <th>Class_ID</th>
          <th>Subject_Name</th>
          <th>Subject_Code</th>
          <th>Full Name</th>
          <th>Class_Time</th>
          <th>Instructor in charge</th>
          <th>Instructor_Email</th>
          <th>Instructor_ID</th>
          <th colspan="2">Update & Delete</th>
        </tr>
      </thead>
      <br>
      <tbody>
        <?php 
$sql = "
    SELECT 
        c.classroom_id, 
        c.subject_name, 
        c.subject_code, 
        c.class_time, 
        c.instructor_id, 
        u.fullname AS instructor_fullname, 
        u.email AS instructor_email
    FROM classrooms c
    INNER JOIN user_information u ON c.instructor_id = u.teacher_id
    ORDER BY c.classroom_id DESC
";

$result = mysqli_query($con, $sql);

while ($row = mysqli_fetch_assoc($result)) {
?>
<tr>
  <td><?php echo $row['classroom_id']; ?></td>
  <td><?php echo $row['subject_name']; ?></td>
  <td><?php echo $row['subject_code']; ?></td>
  <td><?php echo $row['instructor_fullname']; ?></td>
  <td><?php echo $row['class_time']; ?></td>
  <td><?php echo $row['instructor_fullname']; ?></td>
  <td><?php echo $row['instructor_email']; ?></td>
  <td><?php echo $row['instructor_id']; ?></td>
  <td style="color: green;" id="crud"><a href="edit_room.php?edit_room=<?php echo $row['classroom_id'];?>">Edit</a></td>
  <td style="color: red;" id="crud"><a href="delete_room.php?delete_room=<?php echo $row['classroom_id'];?>">Delete Room</a></td>
</tr>
<?php } ?>


      </tbody>
    </table>
  </div>
</div>

  
</div>



</body>
</html>