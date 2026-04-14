<?php include 'connection.php'; ?>

<?php
if (!isset($_GET['id'])) {
    die("Error: ID not provided");
}

$id = $_GET['id'];
$result = mysqli_query($conn, "SELECT * FROM cars WHERE id='$id'");

if (!$result) {
    die("Error: " . mysqli_error($conn));
}

$row = mysqli_fetch_assoc($result);

if (!$row) {
    die("Error: Car not found");
}
?>

<form method="POST">
    Name: <input type="text" name="name" value="<?php echo $row['name']; ?>"><br>
    Brand: <input type="text" name="brand" value="<?php echo $row['brand']; ?>"><br>
    Price: <input type="text" name="price" value="<?php echo $row['price']; ?>"><br>
    <button type="submit" name="update">Update</button>
</form>

<?php
if (isset($_POST['update'])) {
    $name = $_POST['name'];
    $brand = $_POST['brand'];
    $price = $_POST['price'];

    $sql = "UPDATE cars SET name='$name', brand='$brand', price='$price' WHERE id=$id";

    if (mysqli_query($conn, $sql)) {
        echo "Updated successfully";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>