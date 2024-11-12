<?php
// Include database connection
session_start();
include 'config.php'; // This file should contain your database connection setup

// Fetch all books from the database
$query = "SELECT * FROM books";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="navbar.css">
    <link rel="stylesheet" href="admin_dashboard.css"> <!-- Link to dashboard styles -->
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="dashboard-container">
    <h1>Admin Dashboard</h1>
    <a href="addBook.php" class="button">Add New Book</a>

    <table>
        <thead>
            <tr>
                <th>Title</th>
                <th>Author</th>
                <th>Genre</th>
                <th>Year</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['title']); ?></td>
                <td><?php echo htmlspecialchars($row['author']); ?></td>
                <td><?php echo htmlspecialchars($row['genre']); ?></td>
                <td><?php echo htmlspecialchars($row['year']); ?></td>
                <td>
                    <a href="editBook.php?id=<?php echo $row['id']; ?>" class="button">Edit</a>
                    <a href="deleteBook.php?id=<?php echo $row['id']; ?>" class="button delete-button" onclick="return confirm('Are you sure you want to delete this book?');">Delete</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

</body>
</html>
