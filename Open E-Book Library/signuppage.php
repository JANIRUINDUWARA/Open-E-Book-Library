<?php
session_start();
// Database connection settings
$servername = "localhost";  // Database server, typically "localhost"
$username = "root";         // Your MySQL username
$password = "";             // Your MySQL password
$dbname = "library";        // The database name you created

// Create a MySQL connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection to the database
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission and insert data into the database
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the form data
    $email = $_POST['email'];
    $user_name = $_POST['user_name'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if passwords match
    if ($password !== $confirm_password) {
        echo "<script>alert('Passwords do not match. Please try again.'); window.history.back();</script>";
        exit;
    }

    // Check if password is at least 8 characters long (optional, for security)
    if (strlen($password) < 8) {
        echo "<script>alert('Password must be at least 8 characters long.'); window.history.back();</script>";
        exit;
    }
    
    // Prepare and execute SQL to insert user data
    $stmt = $conn->prepare("INSERT INTO users (email, user_name, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $email, $user_name, $password);

    // Check if the query was successful
    if ($stmt->execute()) {
        // Redirect to login page after successful signup
        header('Location: index.php');
        exit(); // Stop further script execution after redirection
    } else {
        echo "Error: " . $stmt->error;
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
    <title>Book Lovers Signup</title>
    <link rel="stylesheet" href="signuppage.css"> <!-- Check if the file exists -->
    <script>
        function validateForm() {
            const password = document.getElementById("password").value;
            const confirmPassword = document.getElementById("confirm_password").value;
            
            if (password !== confirmPassword) {
                alert("Passwords do not match. Please try again.");
                return false;
            }
            return true;
        }
    </script>
</head>
<body>   
<?php include 'navbar.php'; ?>
    <div class="container">
        <div class="signuppage-form"> <!-- Ensure this class matches your CSS -->
            <h2>Sign Up</h2><br/>
            <p>Log in to use your free Open Library card to borrow digital books</p><br/>
            <form action="signuppage.php" method="POST" onsubmit="return validateForm()">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Email" required>
                
                <label for="user_name">User Name</label>
                <input type="text" id="user_name" name="user_name" placeholder="User Name" required>
                
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Password" required>

                <label for="confirm_password">Confirm Password</label>
                <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm Password" required>

                <button class="signup-btn" type="submit">Sign Up</button>
            </form>
            <br>
            <p>Already have an account? <a href="index.php">Log in</a></p>
        </div>
    </div>
</body>
</html>

