<?php include 'formconnection.php'; ?>

<?php

if (isset($_POST['username']) && isset($_POST['password'])) {

    $username = $_POST['username'];
    $password = $_POST['password'];

    // 🔐 Hash password using bcrypt
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    $sql = "INSERT INTO users (username, password)
            VALUES ('$username', '$hashedPassword')";

    if (mysqli_query($conn, $sql)) {

        echo "Registration successful ✔ You will be redirected to login page...";
        header("refresh:2; url=loginform.html");
        exit();

    } else {
        echo "Error: " . mysqli_error($conn);
    }

} else {
    echo "Please submit the form first ❌";
}

?>