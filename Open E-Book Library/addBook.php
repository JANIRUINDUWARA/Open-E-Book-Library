<?php
session_start();
include 'config.php';
$successMessage = '';
$errorMessage = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $genre = $_POST['genre'];
    $year = $_POST['year'];
    $pdf = $_FILES['pdf']['name'];
    $image = $_FILES['image']['name'];
    $description = $_POST['description'];
    $pdf_path = "";

    // Upload PDF file to server (basic upload handling)

    if (!file_exists('uploads/pdfs')) {
        mkdir('uploads/pdfs', 0777, true);
    }
    
    if (!file_exists('uploads/images/')) {
        mkdir('uploads/images', 0777, true);
    }
    
    $targetDir = "uploads/pdfs/";
    $targetFile = $targetDir . basename($_FILES["pdf"]["name"]);
    $uploadOk = 1;
    $pdfFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
    $pdf_path = $targetDir . basename($_FILES['pdf']['name']);

    $imageTargetDir = "uploads/images/";
    $imageTargetFile = $imageTargetDir . basename($_FILES["image"]["name"]);
    $imageUploadOk = 1;
    $imageFileType = strtolower(pathinfo($imageTargetFile, PATHINFO_EXTENSION));
    $imagePath = $imageTargetDir . basename($_FILES["image"]["name"]);
    // Check if file is a PDF
    if ($pdfFileType != "pdf") {
        $errorMessage = "Sorry, only PDF files are allowed.";
        $uploadOk = 0;
    }

    if ($uploadOk == 0) {
        // File not uploaded
        $errorMessage = "Sorry, your file was not uploaded.";
    } else {
        // Upload the file
        if (move_uploaded_file($_FILES["pdf"]["tmp_name"], $targetFile) && move_uploaded_file($_FILES["image"]["tmp_name"], $imageTargetFile)) {
            // Insert book details into the database
            $query = "INSERT INTO books (title, author, genre, year, pdf_path, image_path,description) 
                      VALUES ('$title', '$author', '$genre', '$year', '$pdf_path', '$imagePath','$description')";
            if (mysqli_query($conn, $query)) {
                $successMessage = "The book was successfully added!";
            } else {
                $errorMessage = "Error adding the book.";
            }
        } else {
            $errorMessage = "Sorry, there was an error uploading your file.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add New Book</title>
    <link rel="stylesheet" href ="addbook.css">
    <link rel="stylesheet" href ="navbar.css">
    <link rel="stylesheet" href ="modal.css">
    <script src="validation.js" defer></script>
    <script src="model.js" defer></script>
</head>
<body>
<?php include 'navbar.php'; ?>
<div class="form-container">
    <h1>Add a New Book</h1>
    <form action="" method="post" enctype="multipart/form-data" onsubmit="return validateForm()" >
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" required>

        <label for="author">Author:</label>
        <input type="text" id="author" name="author" required>

        <label for="genre">Genre:</label>
        <select id="genre" name="genre" required>
        <option value="">Select Genre</option>
        <option value="Adventure" >Adventure</option>
        <option value="Romance" >Romance</option>
        <option value="Educational" >Educational</option>
        
    </select>


        <label for="year">Year:</label>
        <input type="number" id="year" name="year">

        <label for="description">Description:</label>
        <textarea id="description" name="description"></textarea>

        <label for="pdf">Upload PDF:</label>
        <input type="file" id="pdf" name="pdf" accept="application/pdf">

        <label for="image">Book Image (Cover):</label>
        <input type="file" name="image" id="image" accept="image/*" required><br>

        <button type="submit">Add Book</button>
    </form>
</div>

<?php include 'modal.php'; ?>

<div id="phpMessages" 
     data-success-message="<?php echo htmlspecialchars($successMessage); ?>"
     data-error-message="<?php echo htmlspecialchars($errorMessage); ?>" 
     style="display:none;"></div>

</body>
</html>
