<?php
session_start();
if(!isset($_SESSION["loggedin"]) || $_SESSION["role"] !== 'admin'){
    header("location: index.php");
    exit;
}
// Process delete operation after confirmation
if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
    require_once "connection.php";
    
    // Prepare a delete statement
    $sql = "DELETE FROM cars WHERE id = ?";
    
    if($stmt = mysqli_prepare($conn, $sql)){
        mysqli_stmt_bind_param($stmt, "i", $param_id);
        
        $param_id = trim($_GET["id"]);
        
        if(mysqli_stmt_execute($stmt)){
            header("location: index.php");
            exit();
        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }
    }
     
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
} else{
    // Check existence of id parameter
    if(empty(trim($_GET["id"]))){
        // URL doesn't contain id parameter. Redirect to index page
        header("location: index.php");
        exit();
    }
}
?>
