<?php include 'connection`.php'; ?>

<form method="POST">
    Name: <input type="text" name="name"><br>
    Brand: <input type="text" name="brand"><br>
    Price: <input type="text" name="price"><br>
    <button type="submit" name="submit">Add Car</button>
</form>

<?php
if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $brand = $_POST['brand'];
    $price = $_POST['price'];

    $sql = "INSERT INTO cars (name, brand, price) VALUES ('$name', '$brand', '$price')";
    
    if (mysqli_query($conn, $sql)) {
        echo "Car added successfully";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>