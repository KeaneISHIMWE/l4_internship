<?php
session_start();
require_once "connection.php";

$sql = "SELECT * FROM cars ORDER BY created_at DESC";
$result = mysqli_query($conn, $sql);

$isAdmin = isset($_SESSION["role"]) && $_SESSION["role"] === 'admin';
$isLoggedIn = isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Management System</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <h2>Car Management System <?php if($isAdmin) echo "- Admin Portal"; ?></h2>
            <div>
                <?php if($isLoggedIn): ?>
                    <span>Welcome, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b></span>
                    <a href="logout.php" class="btn btn-warning" style="margin-left: 10px;">Logout</a>
                <?php else: ?>
                    <a href="login.php" class="btn btn-primary">Login</a>
                    <a href="register.php" class="btn btn-warning" style="margin-left: 5px;">Register</a>
                <?php endif; ?>
            </div>
        </div>
        
        <?php if($isAdmin): ?>
        <a href="create.php" class="btn btn-success">+ Add New Car</a>
        <?php endif; ?>
        
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Brand</th>
                    <th>Model</th>
                    <th>Year</th>
                    <th>Color</th>
                    <?php if($isAdmin): ?>
                    <th>Actions</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $row['id'] . "</td>";
                        echo "<td>" . htmlspecialchars($row['brand']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['model']) . "</td>";
                        echo "<td>" . $row['year'] . "</td>";
                        echo "<td>" . htmlspecialchars($row['color']) . "</td>";
                        
                        if($isAdmin) {
                            echo "<td>
                                    <a href='update.php?id=" . $row['id'] . "' class='btn btn-warning'>Edit</a> 
                                    <a href='delete.php?id=" . $row['id'] . "' class='btn btn-danger' onclick='return confirm(\"Are you sure you want to delete this car?\")'>Delete</a>
                                  </td>";
                        }
                        echo "</tr>";
                    }
                } else {
                    $cols = $isAdmin ? 6 : 5;
                    echo "<tr><td colspan='$cols' style='text-align:center;'>No cars found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
