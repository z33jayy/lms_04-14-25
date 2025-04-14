<?php 
require("connection.php");
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM user_information WHERE id = '$user_id'";
$query = mysqli_query($con, $sql);
$user = mysqli_fetch_assoc($query);

// Role check
if ($user['role'] !== 'Teacher') {
    header("Location: homepage2.php");
    exit();
}

// Fetch classrooms owned by the teacher
$class_sql = "SELECT * FROM classrooms WHERE instructor_id = '{$user['teacher_id']}'";
$class_query = mysqli_query($con, $class_sql);
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Classrooms</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <style>
      body {
      background-image: url('http://localhost/my_website/Photos/COC.jpg');
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
      background-attachment: fixed;
      min-height: 100vh;
      margin: 0;
      display: flex;
      flex-direction: column;
    }

    .form-container {
      max-width: 400px;
      margin: 50px auto;
      padding: 20px;
      border: 1px solid #ccc;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      background-color: white;
      }

      .jumbotron {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 15px;
        }

      #CULOGO {
        width: 50px;
        height: auto;
        }
        #navigationtext{
          font-size: 1.3rem; 
          font-weight: bold; 
          color: white;
          border-left: solid;
          border-right: solid;
          border-radius:10px;
        }
        #navitem1:hover{
          transition: 0.3s;
          border-right: solid;
          border-top: solid;
          border-radius: 20px;
        }
        #container1 {
          border: solid;
          border-radius: 20px;
          max-width: 50vw;
          height: auto;
          background-color: lightgrey;
          opacity: 80%;
          margin: auto;
          text-align: center;
          max-height: 500px; /* Limit height */
          overflow-y: auto;
          padding: 10px;
        }
        #CULOGO {
        width: 50px;
        height: auto;
        }
        #navigationtext{
          font-size: 1.3rem; 
          font-weight: bold; 
          color: white;
          border-left: solid;
          border-right: solid;
          border-radius:10px;
        }
        #navitem1:hover{
          transition: 0.3s;
          border-right: solid;
          border-top: solid;
          border-radius: 20px;
        }
        #container1 {
        border: solid;
        border-radius: 20px;
        background-color: lightgrey;
        opacity: 80%;
        margin: auto;
        text-align: center;
        max-height: 100vh;
        padding: 10px;
        overflow-x: hidden; /* Disable horizontal scrollbar */
        overflow-y: auto;   /* Enable vertical scrollbar when content overflows */


        border: solid; 
        border-radius: 20px; 
        max-width: 95%; 
        height: auto; 
        background-color: lightgrey; 
        opacity: 80%; 
        max-height: 100vh;
      } 
    .card-box {
      background: white;
      border-radius: 12px;
      box-shadow: 0 4px 6px rgba(0,0,0,0.1);
      padding: 20px;
      margin-bottom: 20px;
      cursor: pointer;
    }
.classroom-header {
    background-color: #f1f1f1;
    padding: 10px 25px;
    border-radius: 10px;
    text-align: center;
    margin: 20px auto;
    display: inline-block;
    box-shadow: 0 1px 4px rgba(0, 0, 0, 0.1);
}

.classroom-header h2{
    margin: 0;
    font-weight: 600;
    font-size: 20px;
    color: #333;
}

  </style>
</head>
<body>

   <div class="jumbotron text-center text-white p-3" style="background-color: red;">
    <img src="http://localhost/my_website/Photos/CULOGO.png" alt="Logo" id="CULOGO">
    <h1 style="font-family: Oswald, serif; margin: 0;">CapEd Learning Management System</h1>
  </div>

<nav class="navbar navbar-expand-lg" style="background-color: green;">
  <div class="container">
    <a class="navbar-brand" id="navigationtext">Navigation <i class="bi bi-compass"></i></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-center" id="navbarSupportedContent">
      <ul class="navbar-nav">
        <li class="nav-item mx-3" id="navitem1">
          <a class="nav-link active" aria-current="page" href="Homepage2.php" style="font-size: 1.3rem; font-weight: bold; color: white;">Home <i class="bi bi-house-door-fill"></i></a>
        </li>
        <li class="nav-item mx-3" id="navitem1">
          <a class="nav-link" href="student.php"style="font-size: 1.3rem; font-weight: bold; color: white;">Classroom <i class="bi bi-book-fill"></i></a>
        </li>
        <li class="nav-item mx-3">
          <a class="nav-link active" href="tdash.php" style="font-weight: bold; color: white;">Manage Classrooms <i class="bi bi-gear-fill"></i></a>
        </li>

        <li class="nav-item dropdown mx-3" id="navitem1">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"style="font-size: 1.3rem; font-weight: bold; color: white;">
            Features 
          </a>
          <ul class="dropdown-menu">  
            <li><a class="dropdown-item" href="#">Notifications <i class="bi bi-bell-fill"></i></a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">Acitvities/Quizzes <i class="bi bi-clipboard2-data-fill"></i></a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item text-danger" href="#" data-bs-toggle="modal" data-bs-target="#logoutModal">LOG OUT</a>
            </li>
                </ul>
                  <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
                      <div class="modal-dialog">
                          <div class="modal-content">
                              <div class="modal-header">
                                  <h5 class="modal-title" id="logoutModalLabel">Confirm Logout</h5>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <div class="modal-body">
                                  Are you sure you want to log out?
                              </div>
                              <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                  <a href="logout.php" class="btn btn-danger">Yes, Logout</a>
                              </div>
                          </div>
                      </div>
                  </div>
            </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>

<br>

<div class="jumbotron classroom-header">
    <h2>Your Classroom</h2>
</div>

<div class="container mt-4">
  <!-- <h2 class="text-center mb-4">Your Classrooms</h2> -->

  <div class="row">
    <?php while($row = mysqli_fetch_assoc($class_query)): ?>
      <div class="col-md-4">
        <div class="card-box" data-bs-toggle="modal" data-bs-target="#classModal<?php echo $row['classroom_id']; ?>">
          <h5><?php echo htmlspecialchars($row['subject_name']); ?></h5>
          <p><strong>Code:</strong> <?php echo htmlspecialchars($row['subject_code']); ?></p>
          <p><strong>Time:</strong> <?php echo htmlspecialchars($row['class_time']); ?></p>
        </div>
      </div>

      <!-- Class Modal -->
      <div class="modal fade" id="classModal<?php echo $row['classroom_id']; ?>" tabindex="-1">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <form method="POST" action="add_student.php">
              <div class="modal-header">
                <h5 class="modal-title"><?php echo htmlspecialchars($row['subject_name']); ?> - Manage Students</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
              </div>
              <div class="modal-body">
                <!-- Add Student Input -->
                <div class="input-group mb-3">
                  <input type="text" name="student_name" class="form-control" placeholder="Enter Student Full Name">
                  <input type="hidden" name="classroom_id" value="<?php echo $row['classroom_id']; ?>">
                  <button class="btn btn-success" type="submit" name="add_student">Add</button>
                </div>

                <!-- Students Table -->
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>Name</th>
                      <th>Gender</th>
                      <th>Birthdate</th>
                      <th>Email</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $c_id = $row['classroom_id'];
                    $student_sql = "
                      SELECT ui.*
                      FROM user_information ui
                      JOIN classroom_students cs ON ui.id = cs.student_id
                      WHERE cs.classroom_id = $c_id
                    ";

                    $students = mysqli_query($con, $student_sql);
                    while($stu = mysqli_fetch_assoc($students)):
                    ?>
                      <tr>
                        <td><?php echo htmlspecialchars($stu['fullname']); ?></td>
                        <td><?php echo $stu['gender']; ?></td>
                        <td><?php echo $stu['Birthdate']; ?></td>
                        <td><?php echo $stu['email']; ?></td>
                        <td>
                          <form method="POST" action="manage_students.php" class="d-inline">
                            <input type="hidden" name="remove_id" value="<?php echo $stu['id']; ?>">
                            <input type="hidden" name="classroom_id" value="<?php echo $c_id; ?>">
                            <button type="submit" name="remove_student" class="btn btn-danger btn-sm">Remove</button>
                          </form>
                        </td>
                      </tr>
                    <?php endwhile; ?>
                  </tbody>
                </table>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    <?php endwhile; ?>
  </div>
</div>

</body>
</html>
