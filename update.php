<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$name = $price = $model = $year = $quantity = $engine = $complectation = "";
$name_err = $price_err = $model_err = $year_err = $quantity_err = $engine_err = $complectation_err = "";
 
// Processing form data when form is submitted
if(isset($_POST["car_id"]) && !empty($_POST["car_id"])){
    // Get hidden input value
    $car_id = $_POST["car_id"];
    
      // Validate name
    $input_name = trim($_POST["name"]);
    if(empty($input_name)){
        $name_err = "Please enter a name.";
    } elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $name_err = "Please enter a valid name.";
    } else{
        $name = $input_name;
    }
    // Validate price
    $input_price = trim($_POST["price"]);
    if(empty($input_price)){
        $price_err = "Please enter the price.";     
    } elseif(!ctype_digit($input_price)){
        $price_err = "Please enter a positive integer value.";
    } else{
        $price = $input_price;
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
        $year_err = "Please enter the year.";     
    } elseif(!ctype_digit($input_year)){
        $year_err = "Please enter a positive integer value.";
    } else{
        $year = $input_year;
    }
    // Validate quantity
    $input_quantity = trim($_POST["quantity"]);
    if(empty($input_quantity)){
        $name_err = "Please enter a 5674839.";

        $quantity_err = "Please enter the quantity.";     
    } elseif(!ctype_digit($input_quantity)){
        $quantity_err = "Please enter a positive integer value.";
    } else{
        $quantity = $input_quantity;
    }
    // Validate engine
    $input_engine = trim($_POST["engine"]);
    if(empty($input_engine)){
        $engine_err = "Please enter the engine.";     
    } else{
        $engine = $input_engine;
    }
    
    // Validate complectation
    $input_complectation = trim($_POST["complectation"]);
    if(empty($input_complectation)){
        $complectation_err = "Please enter complectation.";     
    } else{
        $complectation = $input_complectation;
    }
    
    // Check input errors before inserting in database
    if(empty($name_err) && empty($price_err) && empty($model_err) && empty($year_err) && empty($year_err) && empty($quantity_err) && empty($engine_err) && empty($complectation_err)){
        // Prepare an update statement
        $sql = "UPDATE car SET name=?, price=?, model=?, year=?, quantity=?, engine=?, complectation=? WHERE car_id=?";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sisiidsi", $param_name, $param_price, $param_model,$param_year,$param_quantity,$param_engine, $param_complectation, $param_id);
            
            // Set parameters
            $param_name = $name;
            $param_price = $price;
            $param_model = $model;
            $param_year = $year;
            $param_quantity = $quantity;
            $param_engine = $engine;
            $param_complectation = $complectation;
            $param_id = $car_id;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records updated successfully. Redirect to landing page
                header("location: index.php");
                exit();
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($link);
} else{
    // Check existence of id parameter before processing further
    if(isset($_GET["car_id"]) && !empty(trim($_GET["car_id"]))){
        // Get URL parameter
        $car_id =  trim($_GET["car_id"]);
        
        // Prepare a select statement
        $sql = "SELECT * FROM car WHERE car_id = ?";
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $param_id);
            
            // Set parameters
            $param_id = $car_id;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);
    
                if(mysqli_num_rows($result) == 1){
                    /* Fetch result row as an associative array. Since the result set
                    contains only one row, we don't need to use while loop */
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    
                    // Retrieve individual field value
                    $name = $row["name"];
                    $price = $row["price"];
                    $model = $row["model"];
                    $year = $row["year"];
                    $quantity = $row["quantity"];
                    $engine = $row["engine"];
                    $complectation = $row["complectation"];
                } else{
                    // URL doesn't contain valid id. Redirect to error page
                    header("location: error.php");
                    exit();
                }
                
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        
        // Close statement
        mysqli_stmt_close($stmt);
        
        // Close connection
        mysqli_close($link);
    }  else{
        // URL doesn't contain id parameter. Redirect to error page
        header("location: error.php");
        exit();
    }
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Record</title>
     <link rel = "stylesheet" href="style.css">
    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5">Update Record</h2>
                    <p>Please edit the input values and submit to update the car record.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">

                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name; ?>">
                            <span class="invalid-feedback"><?php echo $name_err;?></span>
                        </div>

                        <div class="form-group">
                            <label>Price</label>
                            <textarea name="price" class="form-control <?php echo (!empty($price_err)) ? 'is-invalid' : ''; ?>"><?php echo $price; ?></textarea>
                            <span class="invalid-feedback"><?php echo $price_err;?></span>
                        </div>

                        <div class="form-group">
                            <label>Model</label>
                            <input type="text" name="model" class="form-control <?php echo (!empty($model_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $model; ?>">
                            <span class="invalid-feedback"><?php echo $model_err;?></span>
                        </div>

                        <div class="form-group">
                            <label>Year</label>
                            <input type="text" name="year" class="form-control <?php echo (!empty($year_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $year; ?>">
                            <span class="invalid-feedback"><?php echo $year_err;?></span>
                        </div>

                        <div class="form-group">
                            <label>Quantity</label>
                            <input type="text" name="quantity" class="form-control <?php echo (!empty($quantity_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $quantity; ?>">
                            <span class="invalid-feedback"><?php echo $quantity_err;?></span>
                        </div>

                        <div class="form-group">
                            <label>Engine</label>
                            <input type="text" name="engine" class="form-control <?php echo (!empty($engine_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $engine; ?>">
                            <span class="invalid-feedback"><?php echo $engine_err;?></span>
                        </div>

                        <div class="form-group">
                            <label>Complectation</label>
                            <input type="text" name="complectation" class="form-control <?php echo (!empty($complectation_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $complectation; ?>">
                            <span class="invalid-feedback"><?php echo $complectation_err;?></span>
                        </div>

                        <input type="hidden" name="car_id" value="<?php echo $car_id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>