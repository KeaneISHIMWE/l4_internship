<?php include 'connection.php'; ?>

<?php
// ✅ Check if ID exists
if (!isset($_GET['id'])) {
    die("Error: No ID provided");
}

// ✅ Convert to integer (important for safety)
$id = intval($_GET['id']);

// ✅ Run delete query
$sql = "DELETE FROM cars WHERE id=$id";

if (mysqli_query($conn, $sql)) {
    header("Location: read.php");
    exit();
} else {
    echo "Error: " . mysqli_error($conn);
}
?>