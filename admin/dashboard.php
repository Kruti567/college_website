<?php
// Start the session
session_start();

// Check if user is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit;
}

// For demonstration purposes - this would normally come from a database
$adminName = isset($_SESSION['admin_name']) ? $_SESSION['admin_name'] : 'Admin User';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .dashboard-container {
            display: flex;
            min-height: 100vh;
        }
        .sidebar {
            width: 250px;
            background-color: #333;
            color: white;
            padding: 20px 0;
        }
        .sidebar h2 {
            text-align: center;
            margin-bottom: 30px;
        }
        .sidebar ul {
            list-style-type: none;
            padding: 0;
        }
        .sidebar li {
            padding: 10px 20px;
        }
        .sidebar li a {
            color: white;
            text-decoration: none;
            display: block;
        }
        .sidebar li:hover {
            background-color: #444;
        }
        .main-content {
            flex: 1;
            padding: 20px;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-bottom: 20px;
            border-bottom: 1px solid #ddd;
            margin-bottom: 20px;
        }
        .welcome {
            font-size: 24px;
        }
        .logout a {
            background-color: #f44336;
            color: white;
            padding: 8px 16px;
            text-decoration: none;
            border-radius: 4px;
        }
        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        .stat-card {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            text-align: center;
        }
        .stat-card h3 {
            margin-top: 0;
            color: #333;
        }
        .stat-card p {
            font-size: 24px;
            font-weight: bold;
            color: #0066cc;
            margin: 10px 0;
        }
        .recent-activity {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .recent-activity h3 {
            margin-top: 0;
            color: #333;
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
        }
        .activity-item {
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }
        .activity-item:last-child {
            border-bottom: none;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <div class="sidebar">
            <h2>Admin Panel</h2>
            <ul>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="add_course.php">Course Management</a></li>
                <li><a href="upload_activity.php">Upload Activities</a></li>
                <li><a href="login.php">Logout</a></li>
            </ul>
        </div>
        
        <div class="main-content">
            <div class="header">
                <div class="welcome">Welcome, <?php echo htmlspecialchars($adminName); ?>!</div>
                <div class="logout"><a href="logout.php">Logout</a></div>
            </div>
            
            <div class="stats-container">
                <div class="stat-card">
                    <h3>Total Students</h3>
                    <p>250</p>
                </div>
                <div class="stat-card">
                    <h3>Active Courses</h3>
                    <p>12</p>
                </div>
                <div class="stat-card">
                    <h3>Faculty Members</h3>
                    <p>18</p>
                </div>
                <div class="stat-card">
                    <h3>New Inquiries</h3>
                    <p>5</p>
                </div>
            </div>
            
            <div class="recent-activity">
                <h3>Recent Activity</h3>
                <div class="activity-item">
                    <strong>New student registration:</strong> John Doe - B.Sc. IT
                    <div class="timestamp">Today, 10:45 AM</div>
                </div>
                <div class="activity-item">
                    <strong>Course updated:</strong> Data Science Fundamentals
                    <div class="timestamp">Yesterday, 3:30 PM</div>
                </div>
                <div class="activity-item">
                    <strong>New inquiry:</strong> Regarding BCA admission
                    <div class="timestamp">Yesterday, 11:15 AM</div>
                </div>
                <div class="activity-item">
                    <strong>Content uploaded:</strong> Semester 3 syllabus
                    <div class="timestamp">Aug 15, 2023, 2:00 PM</div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>