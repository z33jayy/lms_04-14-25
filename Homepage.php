<?php
session_start();
require("connection.php"); // Make sure this file connects to your database

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit();
}

// Get the logged-in user's ID
$user_id = $_SESSION['user_id'];

// Fetch user data from database
$sql = "SELECT * FROM user_information WHERE id = '$user_id'";
$query = mysqli_query($con, $sql);
$user = mysqli_fetch_assoc($query); // Fetch user details

if ($user['role'] !== 'Student') {
    header("Location: login.php"); //  //to teacher file, if not student
    exit();
}
?>



<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Homepage</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

  <style type="text/css">
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
 


  
  </style>
</head>
<body>

  <div class="jumbotron text-center text-white p-3" style="background-color: red;">
    <img src="http://localhost/my_website/Photos/CULOGO.png" alt="Logo" id="CULOGO">
    <h1 style="font-family: Oswald, serif; margin: 0;">CapEd Learning Management System</h1>
  </div>

<!-- Navbar -->

<nav class="navbar navbar-expand-lg" style="background-color: green;">
  <div class="container">
    <a class="navbar-brand" id="navigationtext">Navigation <i class="bi bi-compass"></i></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-center" id="navbarSupportedContent">
      <ul class="navbar-nav">
        <li class="nav-item mx-3" id="navitem1">
          <a class="nav-link active" aria-current="page" href="Homepage.php" style="font-size: 1.3rem; font-weight: bold; color: white;">Home <i class="bi bi-house-door-fill"></i></a>
        </li>
        <li class="nav-item mx-3" id="navitem1">
          <a class="nav-link" href="Classroom.php"style="font-size: 1.3rem; font-weight: bold; color: white;">Classroom <i class="bi bi-book-fill"></i></a>
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



<div class="container" id="container1" >
      <br>
  <div class="jumbotron text-center">
    <img src="http://localhost/my_website/Photos/ICON.jpg" class="img-fluid" style="border-radius: 100%; max-width: 150px; height: auto;">
  </div>
  <br>
  <!--Drop Down -->
  <form action="upload_process.php" method="post" enctype="multipart/form-data" class="text-center">
  <div class="mb-3" style="display: flex; justify-content: center; align-items: center; gap: 15px; padding: 15px;">
    <label for="image_file" class="form-label fw-bold" style="font-size: 1.1rem; color: #333; width: 120px;">Change PFP</label>
    <input type="file" class="form-control" id="image_file" name="image_file" accept="image/*" required style="max-width: 250px; padding: 5px; border-radius: 8px; border: 1px solid #ccc;">
    <button type="submit" class="btn btn-primary px-4" style="background-color: #007bff; border-radius: 8px; border: none; padding: 8px 20px; font-size: 0.9rem;">Upload Image</button>
  </div>
</form>



<br>
<hr style="border: solid;">
<br>
<div class="row">
  <div> 
      <h3 style="font-size: 1.5rem; font-family: Georgia, serif;">Name: <?php echo htmlspecialchars($user['fullname']); ?></h3>
    </div>
<hr>
    <div>
      <h3 style="font-size: 1.5rem; font-family: Georgia, serif;">Role: <?php echo htmlspecialchars($user['role']); ?></h3>
    </div>  
<hr>
    <div>
      <h3 style="font-size: 1.5rem; font-family: Georgia, serif;">gender: <?php echo htmlspecialchars($user['gender']); ?></h3>
    </div>
<hr>
    <div>
      <h3 style="font-size: 1.5rem; font-family: Georgia, serif;">Birthdate:<?php echo htmlspecialchars($user['Birthdate']); ?></h3>
    </div>
    <hr>
</div>
<div class="row">
    <div>
      <h3 style="font-size: 1.5rem; font-family: Georgia, serif;">
        Age: 
        <?php 
            $birthdate = new DateTime($user['Birthdate']); // Convert birthdate to DateTime object
            $today = new DateTime(); // Get today's date
            $age = $today->diff($birthdate)->y; // Calculate age
            echo $age; 
        ?>
    </h3>
    </div>
    <hr>
    <div>
      <h3 style="font-size: 1.5rem; font-family: Georgia, serif;">Course: N/A</h3>
    </div>
<hr>
    <div>
      <h3 style="font-size: 1.5rem; font-family: Georgia, serif;">Birthdate:<?php echo htmlspecialchars($user['CellphoneNum']); ?></h3>
    </div>
    <hr>
    <div>
      <h3 style="font-size: 1.5rem; font-family: Georgia, serif;">Student ID: <?php echo htmlspecialchars($user['student_id']); ?><h3>
    </div>
<hr>
    <div>
      <h3 style="font-size: 1.5rem; font-family: Georgia, serif;">Email: <?php echo htmlspecialchars($user['email']); ?></h3>
      <br>
    </div>
  </div>
</div>

<br><br>

</body>
</html>