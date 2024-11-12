<?php
include 'config.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "DELETE FROM books WHERE id = $id";
    mysqli_query($conn, $query);
    header("Location: admin_dashboard.php");
    exit;
}
?>
