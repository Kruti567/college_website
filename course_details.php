<?php
// Include database connection
require_once "admin/db_conn.php";

// Get course ID from URL
$course_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch course details
$course = null;
if ($course_id > 0) {
    $sql = "SELECT * FROM courses WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $course_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result && $result->num_rows > 0) {
        $course = $result->fetch_assoc();
    } else {
        // Redirect to courses page if course not found
        header("Location: courses.php");
        exit;
    }
} else {
    // Redirect to courses page if no ID provided
    header("Location: courses.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nirmiti College | <?php echo htmlspecialchars($course['title']); ?></title>
    <link rel="shortcut icon" type="images" href="images/logonimriti.PNG">

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/style.css">

    <style>
        .course-details {
            max-width: 1000px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        .course-details h2 {
            color: #0eb582;
            margin-bottom: 20px;
            font-size: 2.5rem;
        }
        
        .course-details .info {
            margin-bottom: 30px;
        }
        
        .course-details .info p {
            margin-bottom: 10px;
            font-size: 1.1rem;
            line-height: 1.6;
        }
        
        .course-details .syllabus {
            margin-top: 30px;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 5px;
        }
        
        .course-details .syllabus h3 {
            color: #0eb582;
            margin-bottom: 15px;
        }
        
        .course-details .syllabus a {
            display: inline-block;
            padding: 10px 20px;
            background-color: #0eb582;
            color: #fff;
            border-radius: 5px;
            text-decoration: none;
            margin-top: 10px;
            transition: background-color 0.3s;
        }
        
        .course-details .syllabus a:hover {
            background-color: #0c9c6e;
        }
    </style>
</head>

<body>

    <!-- header section starts  -->

    <?php include "common/header.php";?>

    <!-- header section ends -->

    <section class="heading">
        <h3><?php echo htmlspecialchars($course['title']); ?></h3>
        <p><a href="index.php">Home >></a> <a href="courses.php">Courses >></a> <?php echo htmlspecialchars($course['title']); ?></p>
    </section>

    <section class="course-details">
        <h2><?php echo htmlspecialchars($course['title']); ?></h2>
        
        <div class="info">
            <p><strong>Duration:</strong> <?php echo htmlspecialchars($course['duration']); ?> months</p>
            <p><strong>Description:</strong></p>
            <p><?php echo nl2br(htmlspecialchars($course['description'])); ?></p>
        </div>
        
        <?php if (!empty($course['syllabus_path'])): ?>
        <div class="syllabus">
            <h3>Course Syllabus</h3>
            <p>Download the complete syllabus for this course to learn more about the curriculum, learning outcomes, and assessment methods.</p>
            <a href="<?php echo htmlspecialchars($course['syllabus_path']); ?>" target="_blank">
                <i class="fas fa-file-pdf"></i> Download Syllabus PDF
            </a>
        </div>
        <?php endif; ?>
    </section>

    <!-- footer section starts  -->

    <?php include "common/footer.php";?>

    <!-- custom js file link  -->
    <script src="js/script.js"></script>

</body>

</html>