<?php
session_start();
require("connection.php");

// Redirect if not logged in or not a teacher
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'Teacher') {
    header("Location: login.php");
    exit();
}

// Get the teacher_id from the session
$teacher_id = $_SESSION['teacher_id'];

// Initialize error and success variables
$subjectNameErr = $subjectCodeErr = $classTimeErr = "";
$subjectName = $subjectCode = $classTime = "";
$successMsg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $valid = true;

    // Subject name validation
    if (empty($_POST["subject_name"])) {
        $subjectNameErr = "Subject Name is required";
        $valid = false;
    } else {
        $subjectName = test_input($_POST["subject_name"]);
    }

    // Subject code validation
    if (empty($_POST["subject_code"])) {
        $subjectCodeErr = "Subject Code is required";
        $valid = false;
    } else {
        $subjectCode = test_input($_POST["subject_code"]);
    }

    // Class time validation
    if (empty($_POST["class_time"])) {
        $classTimeErr = "Class Time is required";
        $valid = false;
    } else {
        $classTime = test_input($_POST["class_time"]);
    }

    // If valid, insert into the database
    if ($valid) {
        $subjectName = mysqli_real_escape_string($con, $subjectName);
        $subjectCode = mysqli_real_escape_string($con, $subjectCode);
        $classTime = mysqli_real_escape_string($con, $classTime);

        // Insert the classroom into the database with the foreign key (teacher_id)
        $sql = "INSERT INTO classrooms (subject_name, subject_code, class_time, instructor_id)
                VALUES ('$subjectName', '$subjectCode', '$classTime', '$teacher_id')";

        if (mysqli_query($con, $sql)) {
            $successMsg = "Classroom created successfully!";
            header("Location: try.php"); // Redirect to classrooms list page
            exit(); // Ensure no further code is executed after redirection
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($con);
        }
    }
}

mysqli_close($con);

function test_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Create Classroom</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .error { color: red; }
    </style>
</head>
<body class="p-4">

    <h2 class="mb-4">Create Classroom</h2>

    <?php if ($successMsg): ?>
        <div class="alert alert-success"><?php echo $successMsg; ?></div>
    <?php endif; ?>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div class="mb-3">
            <label class="form-label">Subject Name</label>
            <input type="text" class="form-control" name="subject_name" value="<?php echo $subjectName; ?>">
            <span class="error"><?php echo $subjectNameErr; ?></span>
        </div>

        <div class="mb-3">
            <label class="form-label">Subject Code</label>
            <input type="text" class="form-control" name="subject_code" value="<?php echo $subjectCode; ?>">
            <span class="error"><?php echo $subjectCodeErr; ?></span>
        </div>

        <div class="mb-3">
            <label class="form-label">Class Time</label>
            <input type="text" class="form-control" name="class_time" value="<?php echo $classTime; ?>">
            <span class="error"><?php echo $classTimeErr; ?></span>
        </div>

        <button type="submit" class="btn btn-primary">Create Classroom</button>
    </form>

</body>
</html>
