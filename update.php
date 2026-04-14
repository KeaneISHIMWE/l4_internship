<?php include 'connection.php'; ?>

<?php
// ✅ Check if ID exists
if (!isset($_GET['id'])) {
    die("Error: No ID provided in URL");
}

$id = intval($_GET['id']); // convert to integer (important)

// ✅ Run query
$result = mysqli_query($conn, "SELECT * FROM cars WHERE id=$id");

// ✅ Check query success
if (!$result) {
    die("SQL Error: " . mysqli_error($conn));
}

// ✅ Fetch data
$row = mysqli_fetch_assoc($result);

// ✅ Check if record exists
if (!$row) {
    die("Car not found");
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