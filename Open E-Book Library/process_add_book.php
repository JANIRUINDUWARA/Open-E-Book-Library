<?php
include 'config.php';

$title = $_POST['title'];
$author = $_POST['author'];
$genre = $_POST['genre'];
$year = $_POST['year'];
$description = $_POST['description'];
$pdf_path = "";
$successMessage = '';
$errorMessage= '';

// Check if a PDF file was uploaded
if (isset($_FILES['pdf']) && $_FILES['pdf']['error'] == 0) {
    $pdf_dir = "uploads/";
    if (!is_dir($pdf_dir)) {
        mkdir($pdf_dir, 0777, true); // Create the uploads directory if it doesn't exist
    }

    // Set the PDF file path
    $pdf_path = $pdf_dir . basename($_FILES['pdf']['name']);
    
//     // Move the uploaded file to the designated folder
//     if (move_uploaded_file($_FILES['pdf']['tmp_name'], $pdf_path)) {
//         echo "PDF uploaded successfully.<br>";
//     } else {
//         echo "Error uploading PDF file.<br>";
//     }
 }

$sql = "INSERT INTO books (title, author, genre, year, description, pdf_path)
VALUES ('$title', '$author', '$genre', '$year', '$description', '$pdf_path')";

if ($conn->query($sql) === TRUE) {
    $successMessage = "The book was successfully added!";
} else {
    $errorMessage = "Error adding the book";
}

$conn->close();
?>
