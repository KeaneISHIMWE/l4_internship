<?php
session_start();
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
require_once "connection.php";

$brand = $model = $year = $color = "";
$brand_err = $model_err = $year_err = $color_err = "";

// Processing form data when form is submitted
if(isset($_POST["id"]) && !empty($_POST["id"])){
    $id = $_POST["id"];
    
    // Validate brand
    $input_brand = trim($_POST["brand"]);
    if(empty($input_brand)){
        $brand_err = "Please enter brand.";
    } else{
        $brand = $input_brand;
    }
    
    // Validate model
    $input_model = trim($_POST["model"]);
    if(empty($input_model)){
        $model_err = "Please enter model.";
    } else{
        $model = $input_model;
    }
    
    // Validate year
    $input_year = trim($_POST["year"]);
    if(empty($input_year)){
        $year_err = "Please enter year.";
    } else{
        $year = $input_year;
    }

    // Validate color
    $input_color = trim($_POST["color"]);
    if(empty($input_color)){
        $color_err = "Please enter color.";
    } else{
        $color = $input_color;
    }
    
    // Check input errors before inserting in database
    if(empty($brand_err) && empty($model_err) && empty($year_err) && empty($color_err)){
        $sql = "UPDATE cars SET brand=?, model=?, year=?, color=? WHERE id=?";
         
        if($stmt = mysqli_prepare($conn, $sql)){
            mysqli_stmt_bind_param($stmt, "ssssi", $param_brand, $param_model, $param_year, $param_color, $param_id);
            
            $param_brand = $brand;
            $param_model = $model;
            $param_year = $year;
            $param_color = $color;
            $param_id = $id;
            
            if(mysqli_stmt_execute($stmt)){
                header("location: index.php");
                exit();
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
         
        mysqli_stmt_close($stmt);
    }
    
    mysqli_close($conn);
} else {
    // Check existence of id parameter before processing further
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        $id =  trim($_GET["id"]);
        
        $sql = "SELECT * FROM cars WHERE id = ?";
        if($stmt = mysqli_prepare($conn, $sql)){
            mysqli_stmt_bind_param($stmt, "i", $param_id);
            $param_id = $id;
            
            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);
    
                if(mysqli_num_rows($result) == 1){
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    
                    $brand = $row["brand"];
                    $model = $row["model"];
                    $year = $row["year"];
                    $color = $row["color"];
                } else{
                    // URL doesn't contain valid id
                    header("location: index.php");
                    exit();
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
    }  else{
        // URL doesn't contain id parameter
        header("location: index.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Car</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .error { color: #dc3545; font-size: 14px; }
    </style>
</head>
<body>   
    <div class="container" style="max-width: 500px;">
        <h2>Update Car</h2>
        <p>Please edit the input values and submit to update the car record.</p>
        <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
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
            <input type="hidden" name="id" value="<?php echo $id; ?>"/>
            <input type="submit" value="Submit">
            <a href="index.php" class="btn btn-warning" style="margin-left: 10px;">Cancel</a>
        </form>
    </div>
</body>
</html>
