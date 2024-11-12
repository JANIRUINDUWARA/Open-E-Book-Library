<?php
include 'config.php';
session_start();

$successMessage = '';
$errorMessage = '';
// Check if form data is received via POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepare and execute SQL to retrieve the user data
    $stmt = $conn->prepare("SELECT password, role,joined_date,user_name  FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    
    // Check if email exists in the database
    if ($stmt->num_rows > 0) {
        // Bind the result to a variable
        $stmt->bind_result($db_password, $role,$joinedDate,$user_name);
        $stmt->fetch();

        // Verify the password
        if ($password === $db_password) {
            $three_months_ago = date('Y-m-d H:i:s', strtotime('-3 months'));
          
            // Check if the registration date is older than 3 months
            if ($joinedDate >= $three_months_ago) {
                $_SESSION['can_add_books'] = false;  // User can add books
                
                
            } else {
                $_SESSION['can_add_books'] = true; 
                
              
            }

            $_SESSION['email'] = $email;
            $_SESSION['name'] = $user_name;
            $_SESSION['role'] = $role;
            if ($role === 'admin') {
                // Redirect to admin dashboard
                echo "<script>window.location.href = 'admin_dashboard.php';</script>";
            } else {
                // Redirect to user page (or another page for non-admins)
                echo "<script>window.location.href = 'homepage.php';</script>";
            }
        } else {
            
            $errorMessage = 'Incorrect user name or password. Please try again.';
        }
    } else {
        $errorMessage = 'Incorrect user name or password. Please try again.';
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Lovers Login</title>
    <link rel="stylesheet" href="loginPage.css">
    <script src="model.js" defer></script>
    <link rel="stylesheet" href ="modal.css">
    <script src="model.js" defer></script>
</head>
<body>
<?php include 'navbar.php'; ?>
    <div class="container">
        <h2>Log In</h2>
        <p>Log in to use your free Open Library card to borrow digital books</p>
        
        <!-- Login form with PHP action -->
        <form action="" method="POST">
            <div class="input-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Email" required>
                <a href="#">Forgot your email?</a>
            </div>

            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Password" required>
                <a href="#">Forgot your Password?</a>
            </div>

            <div class="checkbox-group">
                <input type="checkbox" id="remember-me" name="remember-me">
                <label for="remember-me">Remember me</label>
            </div>

            <button class="login-btn" type="submit">Log In</button>
        </form>

        <div class="signup">
            Don't have an account? <a href="signuppage.php">Sign up now.</a>
        </div>
    </div>

    <?php include 'modal.php'; ?>

<div id="phpMessages" 
     data-success-message="<?php echo htmlspecialchars($successMessage); ?>"
     data-error-message="<?php echo htmlspecialchars($errorMessage); ?>" 
     style="display:none;"></div>


</body>
</html>
