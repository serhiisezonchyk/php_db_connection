<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel = "stylesheet" href="style.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();   
        });
    </script>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="mt-5 mb-3 clearfix">
                        <h2 class="pull-left" align="center">Cars Details</h2>
                        <a href="create.php" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Add New Car</a>
                    </div>
                    <?php
                    // Include config file
                    require_once "config.php";
                    
                    // Attempt select query execution
                    $sql = "SELECT * FROM car";
                    if($result = mysqli_query($link, $sql)){
                        if(mysqli_num_rows($result) > 0){
                            echo '<table class="table table-bordered table-striped">';
                                echo "<thead>";
                                    echo "<tr>";
                                        echo "<th>#</th>";
                                        echo "<th>Name</th>";
                                        echo "<th>Price</th>";
                                        echo "<th>Model</th>";
                                        echo "<th>Year</th>";
                                        echo "<th>Quantity</th>";
                                        echo "<th>Engine</th>";
                                        echo "<th>Complectation</th>";
                                        echo "<th>ACTION</th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while($row = mysqli_fetch_array($result)){
                                    echo "<tr>";
                                        echo "<td>" . $row['car_id'] . "</td>";
                                        echo "<td>" . $row['name'] . "</td>";
                                        echo "<td>" . $row['price'] . "</td>";
                                        echo "<td>" . $row['model'] . "</td>";
                                        echo "<td>" . $row['year'] . "</td>";
                                        echo "<td>" . $row['quantity'] . "</td>";
                                        echo "<td>" . $row['engine'] . "</td>";
                                        echo "<td>" . $row['complectation'] . "</td>";
                                        echo "<td>";
                                            echo '<a href="update.php?car_id='. $row['car_id'] .'" class="mr-3" title="Update" data-toggle="tooltip"><span class="fa fa-pencil"></span>U</a>';
                                            echo '<a href="delete.php?car_id='. $row['car_id'] .'" title="Delete" data-toggle="tooltip"><span class="fa fa-trash"></span>D</a>';
                                        echo "</td>";
                                    echo "</tr>";
                                }
                                echo "</tbody>";                            
                            echo "</table>";
                            // Free result set
                            mysqli_free_result($result);
                        } else{
                            echo '<div class="alert alert-danger"><em>No records were found.</em></div>';
                        }
                    } else{
                        echo "Oops! Something went wrong. Please try again later.";
                    }
 
                    // Close connection
                    mysqli_close($link);
                    ?>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>