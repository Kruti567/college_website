<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

require 'db_conn.php';

// Delete course if delete ID is passed
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $stmt = $conn->prepare("DELETE FROM courses WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header("Location: manage_courses.php");
    exit;
}

// Fetch all courses
$sql = "SELECT * FROM courses ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Courses</title>
    <link rel="stylesheet" href="css/admin-style.css">
    <style>
/* Base reset for your table */
table {
  width: 100%;
  border-collapse: collapse;
  font-family: Arial, sans-serif;
  margin-top: 20px;
  background: #fff;
  box-shadow: 0 2px 5px rgba(0,0,0,0.1);

  /* round the corners */
  border-radius: 5px;
  overflow: hidden;
}

/* Header row */
table thead {
  background-color: #0066cc;
  color: #fff;
}
table thead th {
  padding: 12px 15px;
  text-align: left;
}

/* Body rows */
table tbody tr {
  transition: background-color 0.2s ease;
}


table tbody tr:hover {
  background-color: #eaeaea;
}

/* Cells */
table td {
  padding: 12px 15px;
  border-bottom: 1px solid #ddd;
}

/* Action links/buttons */
table a {
  color: #0066cc;
  text-decoration: none;
  font-weight: bold;
}
table a:hover {
  text-decoration: underline;
}


    </style>
</head>
<body>
<div class="dashboard-container">
    <div class="sidebar">
        <h2>Admin Panel</h2>
        <ul>
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="add_course.php">Add Course</a></li>
            <li><a href="manage_courses.php">Manage Courses</a></li>
            <li><a href="upload_activity.php">Upload Activities</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>

    <div class="main-content">
        <h2>All Courses</h2>
        <table border="1px" cellpadding="10" cellspacing="0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Duration</th>
                    <th>Syllabus</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo htmlspecialchars($row['title']); ?></td>
                            <td><?php echo htmlspecialchars($row['description']); ?></td>
                            <td><?php echo htmlspecialchars($row['duration']); ?></td>
                            <td>
                                <?php if ($row['syllabus_path']): ?>
                                    <a href="../<?php echo $row['syllabus_path']; ?>" target="_blank">View PDF</a>
                                <?php else: ?>
                                    N/A
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="edit_course.php?id=<?php echo $row['id']; ?>">Edit</a> |
                                <a href="manage_courses.php?delete=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this course?');">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="6">No courses found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
