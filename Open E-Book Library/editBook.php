<?php
include 'config.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM books WHERE id = $id";
    $result = mysqli_query($conn, $query);
    $book = mysqli_fetch_assoc($result);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $genre = $_POST['genre'];
    $year = $_POST['year'];

    $updateQuery = "UPDATE books SET title='$title', author='$author', genre='$genre', year='$year' WHERE id=$id";
    if(mysqli_query($conn, $updateQuery)){
        $successMessage = "The book was update sucessfully!";
    }
    else{
        $errorMessage = "Error Update the book."; 
    }

   
    header("Location: admin_dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Book</title>
    <link rel="stylesheet" href="navbar.css">
    <link rel="stylesheet" href="dashboard.css">
    <link rel="stylesheet" href ="addbook.css"> 
    <script src="validation.js" defer></script>
    <link rel="stylesheet" href ="modal.css">
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="form-container">
<h1>Edit Book</h1>

<form action="" method="post" onsubmit="return validateForm()">
    <label for="title">Title:</label>
    <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($book['title']); ?>" required>

    <label for="author">Author:</label>
    <input type="text" id="author" name="author" value="<?php echo htmlspecialchars($book['author']); ?>" required>

    <label for="genre">Genre:</label>
    <select id="genre" name="genre" required>
        <option value="">Select Genre</option>
        <option value="Adventure" <?php echo $book['genre'] == 'Adventure' ? 'selected' : ''; ?>>Adventure</option>
        <option value="Romance" <?php echo $book['genre'] == 'Romance' ? 'selected' : ''; ?>>Romance</option>
        <option value="Educational" <?php echo $book['genre'] == 'Educational' ? 'selected' : ''; ?>>Educational</option>
        <!-- Add more genres here as needed -->
    </select>

    <label for="year">Year:</label>
    <input type="number" id="year" name="year" value="<?php echo htmlspecialchars($book['year']); ?>" required>

    <button type="submit">Update Book</button>
</form>
</div>


<?php include 'modal.php'; ?>

<div id="phpMessages" 
     data-success-message="<?php echo htmlspecialchars($successMessage); ?>"
     data-error-message="<?php echo htmlspecialchars($errorMessage); ?>" 
     style="display:none;"></div>
</body>
</html>
