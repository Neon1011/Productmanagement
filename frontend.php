<?php

require 'cont/_dbconnect.php';

?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>Xyz website!</title>
</head>

<body>


    <table>
        <?php
        $sql = "SELECT * FROM `product`";
        $result = mysqli_query($conn, $sql);
        $uid = 0;
        while ($row = mysqli_fetch_assoc($result)) {
            $uid = $uid + 1;
        ?>
            <div class="card-columns">
                <center>
                    <img class="card-img-top" src="<?php echo $row['p_img']; ?>" alt="Dress">
                    <div class="card-body">
                        <h5 class="card-title">
                            <center><?php echo $row['p_name']; ?></center>
                        </h5>
                        <h5 class="card-title">Brand <?php echo $row['d_name']; ?></h5>
                        <p class="card-text"><?php echo $row['p_desc']; ?></p>
                        <p class="card-title">Size:- <?php echo $row['p_size']; ?></p>
                        <h5 class="card-text">Price <?php echo $row['mrp']; ?></h5>
                        <a href="#" class="btn btn-primary">Buy</a>
                    </div>
                </center>
            </div>
        <?php
        }
        ?>


        </tbody>
    </table>
    </div>
    <hr>


    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>

</html>