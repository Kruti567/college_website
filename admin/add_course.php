<?php
// Start the session
session_start();

// Check if user is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit;
}

// Initialize variables for course form
$title = $desc = $duration = "";
$titleErr = $descErr = $durationErr = "";
$fileErr = "";
$formSubmitted = false;
$success = false;
$successMessage = "";
$errorMessage = "";

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_course'])) {
    $formSubmitted = true;
    
    // Validate title
    if (empty($_POST["title"])) {
        $titleErr = "Course title is required";
    } else {
        $title = $_POST["title"];
    }
    
    // Validate description
    if (empty($_POST["description"])) {
        $descErr = "Course description is required";
    } else {
        $desc = $_POST["description"];
    }
    
    // Validate duration
    if (empty($_POST["duration"])) {
        $durationErr = "Course duration is required";
    } else {
        $duration = $_POST["duration"];
    }
    
    // Process syllabus file if uploaded
    $syllabusPath = null;
    $relativePath = null;
    if (isset($_FILES["syllabus_file"]) && $_FILES["syllabus_file"]["error"] == 0) {
        // Get file details
        $file = $_FILES["syllabus_file"];
        $fileName = $file["name"];
        $fileTmpName = $file["tmp_name"];
        $fileSize = $file["size"];
        $fileError = $file["error"];
        
        // Get file extension
        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        
        // Check if file is a PDF
        if ($fileExt !== "pdf") {
            $fileErr = "Only PDF files are allowed";
        } 
        else {
            // Create directory if it doesn't exist
            $uploadDir = "../syllabus/";
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            
            // Generate unique filename
            $newFileName = "syllabus_" . time() . "_" . rand(1000, 9999) . "." . $fileExt;
            $uploadPath = $uploadDir . $newFileName;
            $relativePath = "syllabus/" . $newFileName; // Store relative path for database
            
            // Upload file
            if (move_uploaded_file($fileTmpName, $uploadPath)) {
                $syllabusPath = $relativePath; // Store relative path instead of full path
            } else {
                $fileErr = "There was an error uploading the file";
            }
        }
    }
    
    // If no errors, add the course
    if (empty($titleErr) && empty($descErr) && empty($durationErr) && empty($fileErr)) {
        $success = addCourse($title, $desc, $duration, $syllabusPath);
        if ($success) {
            // Reset form after successful submission
            $title = $desc = $duration = "";
        }
    }
}

// Real function to add a course
function addCourse($title, $desc, $duration, $syllabusPath = null) {
    require 'db_conn.php';  // Include DB connection
    
    $sql = "INSERT INTO courses (title, description, duration, syllabus_path) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("ssis", $title, $desc, $duration, $syllabusPath);

        if ($stmt->execute()) {
            echo "<div class='success-message'>Course Added Successfully!</div>";
            return true;
        } else {
            echo "<div class='error-message'>Failed to execute: " . $stmt->error . "</div>";
            return false;
        }
    } else {
        echo "<div class='error-message'>Prepare failed: " . $conn->error . "</div>";
        return false;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Management - Admin Dashboard</title>
    <link rel="stylesheet" href="css/admin-style.css">
</head>
<body>
    <div class="dashboard-container">
        <div class="sidebar">
            <h2>Admin Panel</h2>
            <ul>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="add_course.php">Course Management</a></li>
                <li><a href="upload_activity.php">Upload Activities</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </div>
        
        <div class="main-content">
            <div class="header">
                <div class="page-title">Course Management</div>
                <div class="back-link"><a href="dashboard.php">← Back to Dashboard</a></div>
            </div>
            
            <div class="form-container">
                <h3>Add New Course</h3>
                
                <?php if($errorMessage): ?>
                    <div class="error-message"><?php echo $errorMessage; ?></div>
                <?php endif; ?>
                
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="title">Course Title:</label>
                        <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($title); ?>">
                        <span class="error"><?php echo $titleErr; ?></span>
                    </div>
                    
                    <div class="form-group">
                        <label for="description">Course Description:</label>
                        <textarea id="description" name="description"><?php echo htmlspecialchars($desc); ?></textarea>
                        <span class="error"><?php echo $descErr; ?></span>
                    </div>
                    
                    <div class="form-group">
                        <label for="duration">Duration:</label>
                        <input type="text" id="duration" name="duration" value="<?php echo htmlspecialchars($duration); ?>">
                        <span class="error"><?php echo $durationErr; ?></span>
                    </div>
                    
                    <div class="form-group">
                        <label for="syllabus_file">Course Syllabus (PDF):</label>
                        <input type="file" id="syllabus_file" name="syllabus_file" accept=".pdf">
                        <span class="error"><?php echo $fileErr; ?></span>
                        <small>Optional</small>
                    </div>
                    
                    <button type="submit" name="add_course">Add Course</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>