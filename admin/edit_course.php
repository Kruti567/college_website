<?php
session_start();
require 'db_conn.php';

// Check if user is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

// Get course ID
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: manage_courses.php");
    exit;
}

$id = intval($_GET['id']);
$title = $desc = $duration = "";
$titleErr = $descErr = $durationErr = "";
$fileErr = "";

// Fetch existing course data
$stmt = $conn->prepare("SELECT * FROM courses WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$course = $result->fetch_assoc();

if (!$course) {
    echo "Course not found.";
    exit;
}

$title = $course['title'];
$desc = $course['description'];
$duration = $course['duration'];
$syllabusPath = $course['syllabus_path'];

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate inputs
    if (empty($_POST["title"])) {
        $titleErr = "Course title is required";
    } else {
        $title = $_POST["title"];
    }

    if (empty($_POST["description"])) {
        $descErr = "Course description is required";
    } else {
        $desc = $_POST["description"];
    }

    if (empty($_POST["duration"])) {
        $durationErr = "Course duration is required";
    } else {
        $duration = $_POST["duration"];
    }

    // Process syllabus file if uploaded
    if (isset($_FILES["syllabus_file"]) && $_FILES["syllabus_file"]["error"] == 0) {
        $file = $_FILES["syllabus_file"];
        $fileName = $file["name"];
        $fileTmpName = $file["tmp_name"];
        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        if ($fileExt !== "pdf") {
            $fileErr = "Only PDF files are allowed";
        } else {
            $uploadDir = "../syllabus/";
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $newFileName = "syllabus_" . time() . "_" . rand(1000, 9999) . "." . $fileExt;
            $uploadPath = $uploadDir . $newFileName;
            $relativePath = "syllabus/" . $newFileName;

            if (move_uploaded_file($fileTmpName, $uploadPath)) {
                $syllabusPath = $relativePath;
            } else {
                $fileErr = "There was an error uploading the file";
            }
        }
    }

    // Update course if no errors
    if (empty($titleErr) && empty($descErr) && empty($durationErr) && empty($fileErr)) {
        $stmt = $conn->prepare("UPDATE courses SET title = ?, description = ?, duration = ?, syllabus_path = ? WHERE id = ?");
        $stmt->bind_param("ssisi", $title, $desc, $duration, $syllabusPath, $id);

        if ($stmt->execute()) {
            header("Location: manage_courses.php");
            exit;
        } else {
            echo "Error updating course: " . $stmt->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Course</title>
    <link rel="stylesheet" href="css/admin-style.css">
</head>
<body>
    <div class="main-content">
        <h2>Edit Course</h2>
        <form method="post" action="" enctype="multipart/form-data">
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
                <small>Leave blank to keep existing file.</small>
            </div>

            <button type="submit">Update Course</button>
        </form>
    </div>
</body>
</html>
