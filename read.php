<?php include 'connection.php'; ?>

<a href="create.php">Add New Car</a>

<table border="1">
<tr>
    <th>ID</th>
    <th>Name</th>
    <th>Brand</th>
    <th>Price</th>
    <th>Actions</th>
</tr>

<?php
$result = mysqli_query($conn, "SELECT * FROM cars");

while ($row = mysqli_fetch_assoc($result)) {
?>
<tr>
    <td><?php echo $row['id']; ?></td>
    <td><?php echo $row['name']; ?></td>
    <td><?php echo $row['brand']; ?></td>
    <td><?php echo $row['price']; ?></td>
    <td>
        <a href="edit.php?id=<?php echo $row['id']; ?>">Edit</a>
        <a href="delete.php?id=<?php echo $row['id']; ?>">Delete</a>
    </td>
</tr>
<?php } ?>
</table>