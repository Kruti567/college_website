<?php
// Retrieve form data
$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$city = $_POST['city'];
$course = $_POST['course'];
$message = $_POST['message'];

// Connect to MySQL database
$servername = "localhost";
$username = "your_username";
$password = "your_password";
$dbname = "college_admission";

$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Insert data into the database
$sql = "INSERT INTO admissions (name, email, phone, city, course, message) VALUES ('$name', '$email', '$phone', '$city', '$course', '$message')";

if (mysqli_query($conn, $sql)) {
    $response = array('success' => true);
    echo json_encode($response);
} else {
    $response = array('success' => false, 'message' => "Error: " . $sql . "<br>" . mysqli_error($conn));
    echo json_encode($response);
}

mysqli_close($conn);
?>
