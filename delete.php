<?php include 'connection.php'; ?>

<?php
$id = $_GET['id'];

$sql = "DELETE FROM cars WHERE id=$id";

if (mysqli_query($conn, $sql)) {
    header("Location: index.php");
} else {
    echo "Error: " . mysqli_error($conn);
}
?>