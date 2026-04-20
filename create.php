<?php
session_start();
if(!isset($_SESSION["loggedin"]) || $_SESSION["role"] !== 'admin'){
    header("location: index.php");
    exit;
}
require_once "connection.php";

$brand = $model = $year = $color = "";
$brand_err = $model_err = $year_err = $color_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate brand
    if (empty(trim($_POST["brand"]))) {
        $brand_err = "Please enter brand.";
    } else {
        $brand = trim($_POST["brand"]);
    }
    
    // Validate model
    if (empty(trim($_POST["model"]))) {
        $model_err = "Please enter model.";
    } else {
        $model = trim($_POST["model"]);
    }
    
    // Validate year
    if (empty(trim($_POST["year"]))) {
        $year_err = "Please enter year.";
    } else {
        $year = trim($_POST["year"]);
    }

    // Validate color
    if (empty(trim($_POST["color"]))) {
        $color_err = "Please enter color.";
    } else {
        $color = trim($_POST["color"]);
    }
    
    // Check input errors before inserting in database
    if (empty($brand_err) && empty($model_err) && empty($year_err) && empty($color_err)) {
        $sql = "INSERT INTO cars (brand, model, year, color) VALUES (?, ?, ?, ?)";
         
        if ($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmt, "ssss", $param_brand, $param_model, $param_year, $param_color);
            
            $param_brand = $brand;
            $param_model = $model;
            $param_year = $year;
            $param_color = $color;
            
            if (mysqli_stmt_execute($stmt)) {
                header("location: index.php");
                exit();
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
         
        mysqli_stmt_close($stmt);
    }
    
    mysqli_close($conn);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Car</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .error { color: #dc3545; font-size: 14px; }
    </style>
</head>
<body>
    <div class="container" style="max-width: 500px;">
        <h2>Add New Car</h2>
        <p>Please fill this form and submit to add car record to the database.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Brand</label>
                <input type="text" name="brand" value="<?php echo $brand; ?>">
                <span class="error"><?php echo $brand_err; ?></span>
            </div>
            <div class="form-group">
                <label>Model</label>
                <input type="text" name="model" value="<?php echo $model; ?>">
                <span class="error"><?php echo $model_err; ?></span>
            </div>
            <div class="form-group">
                <label>Year</label>
                <input type="number" name="year" value="<?php echo $year; ?>">
                <span class="error"><?php echo $year_err; ?></span>
            </div>
            <div class="form-group">
                <label>Color</label>
                <input type="text" name="color" value="<?php echo $color; ?>">
                <span class="error"><?php echo $color_err; ?></span>
            </div>
            <input type="submit" value="Submit">
            <a href="index.php" class="btn btn-warning" style="margin-left: 10px;">Cancel</a>
        </form>
    </div>
</body>
</html>
