<?php
// Include the database connection
require("connection.php");
// Start a session to access user data
session_start();

// Check if the user is logged in, otherwise redirect to login page
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Get the logged-in user's ID
$user_id = $_SESSION['user_id'];

// Query to get the user's information from the database
$sql = "SELECT * FROM user_information WHERE id = '$user_id'";
$query = mysqli_query($con, $sql);
$user = mysqli_fetch_assoc($query);

// Check if the user is a Teacher, if not, redirect to homepage
if ($user['role'] !== 'Teacher') {
    header("Location: homepage2.php");
    exit();
}

// Get the teacher's ID for later use
$teacher_id = $user['teacher_id'];

// Handle Add/Edit/Delete operations when the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Add a new classroom
    if (isset($_POST['add_classroom'])) {
        $name = $_POST['subject_name'];
        $code = $_POST['subject_code'];
        $time = $_POST['class_time'];

        // Insert the new classroom into the database
        $add_sql = "INSERT INTO classrooms (subject_name, subject_code, class_time, instructor_id)
            VALUES ('$name', '$code', '$time', '$teacher_id')";
        mysqli_query($con, $add_sql);
    }

    // Edit an existing classroom
    if (isset($_POST['edit_classroom'])) {
        $id = $_POST['classroom_id'];
        $name = $_POST['subject_name'];
        $code = $_POST['subject_code'];
        $time = $_POST['class_time'];

        // Update the classroom details in the database
        $edit_sql = "UPDATE classrooms SET subject_name = '$name', subject_code = '$code', class_time = '$time'
                     WHERE classroom_id = '$id' AND instructor_id = '$teacher_id'";
        mysqli_query($con, $edit_sql);
    }

    // Delete a classroom
    if (isset($_POST['delete_classroom'])) {
        $id = $_POST['classroom_id'];

        // Delete the classroom from the database
        $delete_sql = "DELETE FROM classrooms WHERE classroom_id = '$id' AND instructor_id = '$teacher_id'";
        mysqli_query($con, $delete_sql);
    }

    // After the operation, reload the page to reflect changes
    header("Location: tdash.php");
    exit();
}

// Fetch all classrooms associated with the teacher
$class_query = mysqli_query($con, "SELECT * FROM classrooms WHERE instructor_id = '$teacher_id'");
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Manage Classrooms</title>
  <!-- Include Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

  <style type="text/css">
    /* Styling for the body and background */
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

    /* Modal and container styling */
    .form-container {
      max-width: 400px;
      margin: 50px auto;
      padding: 20px;
      border: 1px solid #ccc;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      background-color: white;
    }

    /* Navigation bar styling */
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
      max-width: 50vw;
      height: auto;
      background-color: lightgrey;
      opacity: 80%;
      margin: auto;
      text-align: center;
      max-height: 500px;
      overflow-y: auto;
      padding: 10px;
    }

    /* More general styles for containers and modals */
    #container1 {
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

  <!-- Header Section -->
  <div class="jumbotron text-center text-white p-3" style="background-color: red;">
    <img src="http://localhost/my_website/Photos/CULOGO.png" alt="Logo" id="CULOGO">
    <h1 style="font-family: Oswald, serif; margin: 0;">CapEd Learning Management System</h1>
  </div>

  <!-- Navigation Bar -->
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
            <a class="nav-link" href="student.php" style="font-size: 1.3rem; font-weight: bold; color: white;">Classroom <i class="bi bi-book-fill"></i></a>
          </li>
          <li class="nav-item mx-3">
            <a class="nav-link active" href="tdash.php" style="font-weight: bold; color: white;">Manage Classrooms <i class="bi bi-gear-fill"></i></a>
          </li>
          <li class="nav-item dropdown mx-3" id="navitem1">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="font-size: 1.3rem; font-weight: bold; color: white;">
              Features 
            </a>
            <ul class="dropdown-menu">  
              <li><a class="dropdown-item" href="#">Notifications <i class="bi bi-bell-fill"></i></a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="#">Activities/Quizzes <i class="bi bi-clipboard2-data-fill"></i></a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item text-danger" href="#" data-bs-toggle="modal" data-bs-target="#logoutModal">LOG OUT</a></li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Classroom Management Section -->
  <div class="container mt-5">
    <div class="d-flex justify-content-between mb-3">
      <h2>Your Classrooms</h2>
      <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addModal">+ Add Classroom</button>
    </div>

    <!-- Table for displaying classrooms -->
    <table class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>Subject Name</th>
          <th>Code</th>
          <th>Time</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        
        <!-- Loop through each classroom and display its details -->
        <?php while($row = mysqli_fetch_assoc($class_query)): ?>
          <tr>
            <td><?php echo htmlspecialchars($row['subject_name']); ?></td>
            <td><?php echo htmlspecialchars($row['subject_code']); ?></td>
            <td><?php echo htmlspecialchars($row['class_time']); ?></td>
            <td>
              <!-- Edit Button (opens modal) -->
              <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal<?php echo $row['classroom_id']; ?>">Edit</button>

              <!-- Delete Button -->
              <form method="POST" class="d-inline">
                <input type="hidden" name="classroom_id" value="<?php echo $row['classroom_id']; ?>">
                <button type="submit" name="delete_classroom" class="btn btn-danger btn-sm" onclick="return confirm('Delete this classroom?');">Delete</button>
              </form>
            </td>
          </tr>

          <!-- Edit Modal for each classroom -->
          <div class="modal fade" id="editModal<?php echo $row['classroom_id']; ?>" tabindex="-1">
            <div class="modal-dialog">
              <div class="modal-content">
                <form method="POST">
                  <div class="modal-header">
                    <h5 class="modal-title">Edit Classroom</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                  </div>
                  <div class="modal-body">
                    <input type="hidden" name="classroom_id" value="<?php echo $row['classroom_id']; ?>">
                    <div class="mb-3">
                      <label>Subject Name</label>
                      <input type="text" class="form-control" name="subject_name" value="<?php echo $row['subject_name']; ?>" required>
                    </div>
                    <div class="mb-3">
                      <label>Subject Code</label>
                      <input type="text" class="form-control" name="subject_code" value="<?php echo $row['subject_code']; ?>" required>
                    </div>
                    <div class="mb-3">
                      <label>Class Time</label>
                      <input type="text" class="form-control" name="class_time" value="<?php echo $row['class_time']; ?>" required>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="submit" name="edit_classroom" class="btn btn-primary">Save Changes</button>
                  </div>
                </form>
              </div>
            </div>
          </div>

        <?php endwhile; ?>
      </tbody>
    </table>
  </div>

  <!-- Add Modal for adding new classrooms -->
  <div class="modal fade" id="addModal" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <form method="POST">
          <div class="modal-header">
            <h5 class="modal-title">Add Classroom</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label>Subject Name</label>
              <input type="text" class="form-control" name="subject_name" required>
            </div>
            <div class="mb-3">
              <label>Subject Code</label>
              <input type="text" class="form-control" name="subject_code" required>
            </div>
            <div class="mb-3">
              <label>Class Time</label>
              <input type="text" class="form-control" name="class_time" required>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" name="add_classroom" class="btn btn-success">Add Classroom</button>
          </div>
        </form>
      </div>
    </div>
  </div>

</body>
</html>
