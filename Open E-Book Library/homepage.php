<?php
// Start the session to access session variables
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Lovers Home</title>
    <link rel="stylesheet" href="homepage.css">
    <link rel="stylesheet" href ="navbar.css">
<body>
<?php include 'navbar.php'; ?>

    <div class="book-list">
    <?php
    include 'config.php';

    $sql = "SELECT * FROM books";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div class='book'>";
            echo "<img src='" . htmlspecialchars($row['image_path']) . "' alt='Book Cover' style='width:200px; height:auto;'>";
            echo "<h3>" . htmlspecialchars($row['title']) . "</h3>";
            echo "<p><strong>Author:</strong> " . htmlspecialchars($row['author']) . "</p>";
            echo "<p><strong>Genre:</strong> " . htmlspecialchars($row['genre']) . "</p>";
            echo "<p><strong>Year:</strong> " . htmlspecialchars($row['year']) . "</p>";
            echo "<p><strong>Description:</strong> " . htmlspecialchars($row['description']) . "</p>";

            // Show a link to view the PDF if it exists
            if (!empty($row['pdf_path'])) {
                echo "<a href='" . htmlspecialchars($row['pdf_path']) . "' target='_blank'>View PDF</a>";
            } else {
                echo "<p>No PDF available</p>";
            }
            
            echo "</div>";
        }
    } else {
        echo "<p>No books available.</p>";
    }

    $conn->close();
    ?>
    </div>

</body>
</html>