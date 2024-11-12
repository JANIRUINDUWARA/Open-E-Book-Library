<?php
include 'config.php';
session_start();
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
            echo "<p>Incorrect password. Please try again.</p>";
        }
    } else {
        echo "<p>Email not found. Please try again.</p>";
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>

