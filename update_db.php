<?php
$conn = mysqli_connect("localhost", "root", "", "car_management");
if (!$conn) { die("Connection failed: " . mysqli_connect_error()); }

$sql = "CREATE TABLE IF NOT EXISTS users (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(20) DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if (mysqli_query($conn, $sql)) {
    echo "Table users created successfully\n";
    // Insert default admin
    $password = password_hash("admin123", PASSWORD_DEFAULT);
    // Use INSERT IGNORE to prevent error if admin already exists
    $admin_sql = "INSERT IGNORE INTO users (username, password, role) VALUES ('admin', '$password', 'admin')";
    mysqli_query($conn, $admin_sql);
}

mysqli_close($conn);
?>
