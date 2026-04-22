
<?php

// Connect to database
$conn = mysqli_connect("localhost", "root", "", "login_system");//"host","user","password","database name"

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
} else{
    echo "connected successfully";
}
?>

