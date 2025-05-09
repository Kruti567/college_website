<?php
// Start the session
session_start();

// Initialize variables to store form data and error messages
$email = $password = "";
$emailErr = $passwordErr = "";
$formSubmitted = false;
$loginError = "";

// Predefined admin credentials
$adminEmail = "admin@example.com";
$adminPassword = "admin123"; // In a real application, this would be hashed
$adminName = "Admin User";

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $formSubmitted = true;
    
    // Validate email
    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
    } else {
        $email = test_input($_POST["email"]);
        // Check if email is valid
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
        }
    }
    
    // Validate password
    if (empty($_POST["password"])) {
        $passwordErr = "Password is required";
    } else {
        $password = test_input($_POST["password"]);
        // Check if password is at least 6 characters
        if (strlen($password) < 6) {
            $passwordErr = "Password must be at least 6 characters";
        }
    }
    
    // If no validation errors, check credentials
    if (empty($emailErr) && empty($passwordErr)) {
        // Check if credentials match
        if ($email === $adminEmail && $password === $adminPassword) {
            // Set session variables
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_name'] = $adminName;
            $_SESSION['admin_email'] = $email;
            
            // Redirect to dashboard
            header("Location: dashboard.php");
            exit;
        } else {
            $loginError = "Invalid email or password";
        }
    }
}

// Function to sanitize form data
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .login-container {
            max-width: 400px;
            margin: 50px auto;
            background: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
            color: #333;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input[type="email"], input[type="password"] {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        .error {
            color: red;
            font-size: 14px;
        }
        .login-error {
            background-color: #f8d7da;
            color: #721c24;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 4px;
            text-align: center;
        }
        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
        }
        button:hover {
            background-color: #45a049;
        }
        .result {
            margin-top: 20px;
            padding: 15px;
            background-color: #e7f3fe;
            border-left: 6px solid #2196F3;
        }
        .admin-hint {
            margin-top: 15px;
            font-size: 12px;
            color: #666;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Admin Login</h2>
        
        <?php if (!empty($loginError)): ?>
            <div class="login-error"><?php echo $loginError; ?></div>
        <?php endif; ?>
        
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo $email; ?>">
                <span class="error"><?php echo $emailErr; ?></span>
            </div>
            
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password">
                <span class="error"><?php echo $passwordErr; ?></span>
            </div>
            
            <button type="submit">Login</button>
        </form>
        
        <div class="admin-hint">
            Default admin: <?php echo $adminEmail; ?> / <?php echo str_repeat("*", strlen($adminPassword)); ?>
        </div>
    </div>
</body>
</html>