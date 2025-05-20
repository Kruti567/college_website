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

// Delete course
$stmt = $conn->prepare("DELETE FROM courses WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header("Location: manage_courses.php");
    exit;
} else {
    echo "Error deleting course: " . $stmt->error;
}
?>
