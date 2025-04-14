<?php
session_start();
require("connection.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$user_sql = "SELECT * FROM user_information WHERE id = '$user_id'";
$user_query = mysqli_query($con, $user_sql);
$user = mysqli_fetch_assoc($user_query);

if ($user['role'] !== 'Student') {
    header("Location: login.php");
    exit();
}

$class_query = "
    SELECT c.*, u.fullname AS instructor_name
    FROM classrooms c
    INNER JOIN classroom_students cs ON c.classroom_id = cs.classroom_id
    INNER JOIN user_information u ON c.instructor_id = u.teacher_id
    WHERE cs.student_id = '$user_id'
";
$class_result = mysqli_query($con, $class_query);
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Student Classrooms</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

  <style>
    body {
      background-image: url('http://localhost/my_website/Photos/COC.jpg');
      background-size: cover;
      background-position: center;
      background-attachment: fixed;
      min-height: 100vh;
    }
    .jumbotron {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 15px;
      background-color: red;
    }
    #CULOGO {
      width: 50px;
      height: auto;
    }
    #navigationtext {
      font-size: 1.3rem; 
      font-weight: bold; 
      color: white;
      border-left: solid;
      border-right: solid;
      border-radius:10px;
    }
    #navitem1:hover {
      transition: 0.3s;
      border-right: solid;
      border-top: solid;
      border-radius: 20px;
    }
    #container1 {
      border: solid;
      border-radius: 20px;
      background-color: lightgrey;
      opacity: 90%;
      margin: 20px auto;
      text-align: center;
      max-height: 90vh;
      overflow-y: auto;
      padding: 20px;
      max-width: 95%;
    }
  </style>
</head>
<body>

  <div class="jumbotron text-white p-3">
    <img src="http://localhost/my_website/Photos/CULOGO.png" alt="Logo" id="CULOGO">
    <h1 style="font-family: Oswald, serif; margin: 0;">CapEd Learning Management System</h1>
  </div>

  <nav class="navbar navbar-expand-lg" style="background-color: green;">
    <div class="container">
      <a class="navbar-brand" id="navigationtext">Navigation <i class="bi bi-compass"></i></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-center" id="navbarSupportedContent">
        <ul class="navbar-nav">
          <li class="nav-item mx-3" id="navitem1">
            <a class="nav-link active" href="Homepage.php" style="font-size: 1.3rem; font-weight: bold; color: white;">Home <i class="bi bi-house-door-fill"></i></a>
          </li>
          <li class="nav-item mx-3" id="navitem1">
            <a class="nav-link" href="Classroom.php" style="font-size: 1.3rem; font-weight: bold; color: white;">Classroom <i class="bi bi-book-fill"></i></a>
          </li>
          <li class="nav-item dropdown mx-3" id="navitem1">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" style="font-size: 1.3rem; font-weight: bold; color: white;">Features</a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="#">Notifications <i class="bi bi-bell-fill"></i></a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="#">Activities/Quizzes <i class="bi bi-clipboard2-data-fill"></i></a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item text-danger" href="#" data-bs-toggle="modal" data-bs-target="#logoutModal">LOG OUT</a></li>
            </ul>
            <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="logoutModalLabel">Confirm Logout</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                  </div>
                  <div class="modal-body">Are you sure you want to log out?</div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <a href="logout.php" class="btn btn-danger">Yes, Logout</a>
                  </div>
                </div>
              </div>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <div class="container" id="container1">
    <h2 class="mb-4">Enrolled Classrooms</h2>
    <div class="row">
      <?php if (mysqli_num_rows($class_result) > 0): ?>
        <?php while ($class = mysqli_fetch_assoc($class_result)): ?>
          <div class="col-md-4 mb-4">
            <div class="card shadow">
              <div class="card-body">
                <h5 class="card-title"><?php echo htmlspecialchars($class['subject_name']); ?></h5>
                <p class="card-text"><strong>Code:</strong> <?php echo htmlspecialchars($class['subject_code']); ?></p>
                <p class="card-text"><strong>Time:</strong> <?php echo htmlspecialchars($class['class_time']); ?></p>
                <p class="card-text"><strong>Instructor:</strong> 
                  <span style="color: black;">Professor <?php echo htmlspecialchars($class['instructor_name']); ?></span>
                </p>
              </div>
            </div>
          </div>
        <?php endwhile; ?>
      <?php else: ?>
        <p>No classrooms found.</p>
      <?php endif; ?>
    </div>
  </div>

</body>
</html>
