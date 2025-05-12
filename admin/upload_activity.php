<?php
// Start the session
session_start();

// Check if user is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit;
}

// Include database connection
require_once 'db_conn.php';

// Initialize variables
$caption = "";
$captionErr = "";
$fileErr = "";
$successMessage = "";
$errorMessage = "";
$uploadedFiles = [];

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate caption
    if (empty($_POST["caption"])) {
        $captionErr = "Caption is required";
    } else {
        $caption = $_POST["caption"];
    }
    
    // Check if files were uploaded
    if (!isset($_FILES["activity_images"]) || empty($_FILES["activity_images"]["name"][0])) {
        $fileErr = "Please select at least one image";
    } else {
        // Create directory if it doesn't exist
        $uploadDir = "../activities/";
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        
        // Count total files
        $countFiles = count($_FILES["activity_images"]["name"]);
        
        // Loop through all files
        for($i = 0; $i < $countFiles; $i++) {
            // Get file details
            $fileName = $_FILES["activity_images"]["name"][$i];
            $fileTmpName = $_FILES["activity_images"]["tmp_name"][$i];
            $fileSize = $_FILES["activity_images"]["size"][$i];
            $fileError = $_FILES["activity_images"]["error"][$i];
            
            // Skip if there was an error
            if ($fileError !== 0) {
                continue;
            }
            
            // Get file extension
            $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            
            // Allowed file types
            $allowed = ["jpg", "jpeg", "png", "gif"];
            
            // Check if file type is allowed
            if (!in_array($fileExt, $allowed)) {
                $errorMessage .= "File type not allowed for: " . $fileName . "<br>";
                continue;
            }
            
            // Check file size (max 5MB)
            if ($fileSize > 5000000) {
                $errorMessage .= "File too large: " . $fileName . "<br>";
                continue;
            }
            
            // Generate unique filename
            $newFileName = "activity_" . time() . "_" . $i . "." . $fileExt;
            $uploadPath = $uploadDir . $newFileName;
            $relativePath = "activities/" . $newFileName;
            
            // Upload file
            if (move_uploaded_file($fileTmpName, $uploadPath)) {
                // Add to uploaded files array
                $uploadedFiles[] = [
                    'name' => $newFileName,
                    'original_name' => $fileName,
                    'path' => $uploadPath,
                    'relative_path' => $relativePath
                ];
                
                // Insert into database
                $sql = "INSERT INTO activities (caption, image_path, upload_date) VALUES (?, ?, NOW())";
                $stmt = $conn->prepare($sql);
                if ($stmt) {
                    $stmt->bind_param("ss", $caption, $relativePath);
                    $stmt->execute();
                    $stmt->close();
                } else {
                    $errorMessage .= "Database error: " . $conn->error . "<br>";
                }
            } else {
                $errorMessage .= "Failed to upload: " . $fileName . "<br>";
            }
        }
        
        // Set success message if files were uploaded
        if (count($uploadedFiles) > 0) {
            $successMessage = "Successfully uploaded " . count($uploadedFiles) . " file(s)!";
        } else if (empty($errorMessage)) {
            $errorMessage = "No files were uploaded";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Activities - Admin Dashboard</title>
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
        .page-title {
            font-size: 24px;
        }
        .back-link a {
            color: #0066cc;
            text-decoration: none;
        }
        .form-container {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            max-width: 800px;
            margin: 0 auto;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input[type="text"], textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        textarea {
            height: 100px;
            resize: vertical;
        }
        .error {
            color: red;
            font-size: 14px;
        }
        button {
            background-color: #0066cc;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background-color: #0055aa;
        }
        .success-message {
            background-color: #dff0d8;
            color: #3c763d;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
        }
        .error-message {
            background-color: #f8d7da;
            color: #721c24;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
        }
        .uploaded-files {
            margin-top: 20px;
        }
        .file-item {
            background-color: #f9f9f9;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 4px;
            display: flex;
            align-items: center;
        }
        .file-item img {
            width: 100px;
            height: 75px;
            object-fit: cover;
            margin-right: 15px;
            border-radius: 3px;
        }
        .file-info {
            flex: 1;
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
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </div>
        
        <div class="main-content">
            <div class="header">
                <div class="page-title">Upload College Activities</div>
                <div class="back-link"><a href="dashboard.php">← Back to Dashboard</a></div>
            </div>
            
            <div class="form-container">
                <?php if($successMessage): ?>
                    <div class="success-message"><?php echo $successMessage; ?></div>
                <?php endif; ?>
                
                <?php if($errorMessage): ?>
                    <div class="error-message"><?php echo $errorMessage; ?></div>
                <?php endif; ?>
                
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="caption">Activity Caption:</label>
                        <textarea id="caption" name="caption"><?php echo htmlspecialchars($caption); ?></textarea>
                        <span class="error"><?php echo $captionErr; ?></span>
                    </div>
                    
                    <div class="form-group">
                        <label for="activity_images">Activity Images (JPG, JPEG, PNG, GIF):</label>
                        <input type="file" id="activity_images" name="activity_images[]" accept=".jpg,.jpeg,.png,.gif" multiple>
                        <span class="error"><?php echo $fileErr; ?></span>
                    </div>
                    
                    <button type="submit">Upload Activities</button>
                </form>
                
                <?php if(count($uploadedFiles) > 0): ?>
                    <div class="uploaded-files">
                        <h3>Uploaded Files:</h3>
                        <p><strong>Caption:</strong> <?php echo htmlspecialchars($caption); ?></p>
                        
                        <?php foreach($uploadedFiles as $file): ?>
                            <div class="file-item">
                                <img src="../<?php echo $file['relative_path']; ?>" alt="Activity Image">
                                <div class="file-info">
                                    <p><strong>Filename:</strong> <?php echo htmlspecialchars($file['name']); ?></p>
                                    <p><strong>Original Name:</strong> <?php echo htmlspecialchars($file['original_name']); ?></p>
                                    <p><strong>Path:</strong> <?php echo htmlspecialchars($file['relative_path']); ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>