<?php

//Default Settings
$insert = false;
$update = false;
$delete = false;
// $size = false;

// Connect to the Database 
require 'cont/_dbconnect.php';

//Deleting the product
if (isset($_GET['delete'])) {
    $uid = $_GET['delete'];
    $delete = true;
    $sql = "DELETE FROM `product` WHERE `uid` = $uid";
    $result = mysqli_query($conn, $sql);
}
//Update the product
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['uid_Edit'])) {
        // Update the record
        // echo "hello";
        // exit;
        $uid = $_POST['uid_Edit'];
        $p_name = $_POST['p_name_Edit'];
        $p_desc = $_POST['p_desc_Edit'];
        $d_name = $_POST['d_name_Edit'];
        $filename = $_FILES['p_img_Edit']['name'];
        $fileSize = $_FILES['p_img_Edit']['size'];
        $tmp_name = $_FILES['p_img_Edit']['tmp_name'];
        $folder =  "img/" . $filename;
        move_uploaded_file($tmp_name, $folder);
        $category = $_POST['category_Edit'];
        $p_size = $_POST['p_size_Edit'];
        $mrp = $_POST['mrp_Edit'];
        $d_price = $_POST['d_price_Edit'];
        $d_percent = $_POST['d_percent_Edit'];

        // Sql query to be executed for UPDATE
        $sql = "UPDATE `product` SET p_name = '$p_name' , p_desc = '$p_desc' , d_name='$d_name',p_img='$folder',category='$category', p_size='$p_size',mrp='$mrp',d_price='$d_price',d_percent='$d_percent' WHERE `product`.`uid` = $uid";
        // echo $sql;
        // die();
        $result = mysqli_query($conn, $sql);
        /* if ($result) {
            $update = true;
        } else {
            echo "We could not update the product successfully";
        }*/
    } else {
        //$u_id = $_POST["u_id"];
        $p_name = $_POST["p_name"];
        $p_desc = $_POST["p_desc"];
        $d_name = $_POST["d_name"];
        $filename = $_FILES["p_img"]["name"];
        $fileSize = $_FILES["p_img"]["size"];
        $tmp_name = $_FILES["p_img"]["tmp_name"];
        //validation of img

        $f = explode(".", $filename);
        // $fileExt = strtolower($f[1]);
        //$allowedExt = array("jpg", "jpeg", "png");
        //if (in_array($fileExt, $allowedExt)) {
        if ($fileSize < 200000) {
            $folder =  "img/" . $filename;
            move_uploaded_file($tmp_name, $folder);
            $category = $_POST["category"];
            $p_size = $_POST["p_size"];
            $mrp = $_POST["mrp"];
            $d_price = $_POST["d_price"];
            $d_percent = $_POST["d_percent"];

            // Sql query to be executed for INSERTING the VALUE
            $sql = "INSERT INTO `product` (`p_name`, `p_desc`, `d_name`,`p_img`,`category`, `p_size`, `mrp`, `d_price`, `d_percent`) VALUES ('$p_name','$p_desc','$d_name','$folder','$category','$p_size','$mrp','$d_price','$d_percent')";
            $result = mysqli_query($conn, $sql);


            if ($result) {
                $insert = true;
            } else {
                echo "The product was not inserted successfully because of this error ---> " . mysqli_error($conn);
            }
        } else {
            // $size = false;
            echo "file size should be less than 200kb";
        }
        // } else {
        //     echo "Please Upload img in jpg, jpeg , png format only";
        // }
    }
}




// define variables to empty values  
$nameErr = $imgErr = $mrp = "";
$p_name = $p_desc = $d_name = $p_img = $category = $mrp = $d_price = "";

//Input fields validation  
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //String Validation  
    if (empty($_POST["p_name"])) {
        $nameErr = "Name is required";
    } else {
        $name = input_data($_POST["p_name"]);
        // check if name only contains letters and whitespace  
        if (!preg_match("/^[a-zA-Z ]*$/", $name)) {
            $nameErr = "Only alphabets and white space are allowed";
        }
    }
}


function input_data($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}



?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <title>Product Management</title>

</head>

<body>


    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit this Product</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="/PRODUCT_MANAGEMENT/index.php" id="edit_product" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <input type="hidden" name="uid_Edit" id="uid_Edit">
                        <div class="form-group">
                            <label for="p_name">Product Name</label>
                            <input type="text" class="form-control" id="p_name_Edit" name="p_name_Edit">
                        </div>

                        <div class="form-group">
                            <label for="desc">Product Description</label>
                            <textarea class="form-control" id="p_desc_Edit" name="p_desc_Edit" rows="3"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="d_name">Brand</label>
                            <input type="text" class="form-control" id="d_name_Edit" name="d_name_Edit">
                        </div>
                        <div class="form-group">
                            <label for="p_img_Edit">Product Img</label>
                            <input type="file" class="form-control" id="p_img_Edit" name="p_img_Edit">
                        </div>
                        <div class="form-group">
                            <label for="category_Edit">Category</label>
                            <input type="text" class="form-control" id="category_Edit" name="category_Edit">
                        </div>
                        <div class="form-group">
                            <label for="p_size_Edit">Size</label>
                            <input type="text" class="form-control" id="p_size_Edit" name="p_size_Edit">
                        </div>
                        <div class="form-group">
                            <label for="mrp_Edit">MRP</label>
                            <input type="number" class="form-control" id="price" name="mrp_Edit">
                        </div>
                        <div class="form-group">
                            <label for="d_percent">Discount</label>
                            <input type="number" class="form-control" id="discount" name="d_percent_Edit">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="d_price">Total</label>
                        <input type="number" class="form-control" id="total" name="d_price_Edit" onclick="getPrice()">
                    </div>
                    <div class="form-group">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" onclick="saveForm()" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>

            <!-- <div class="modal-footer d-block mr-auto">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" onclick="saveForm()" class="btn btn-primary">Save changes</button>
            </div> -->
            <!-- </form> -->
        </div>
    </div>
    </div>
    <!-- <script>
        getPrice = function() {
            var numVal1 = Number(document.getElementById("price").value);
            var numVal2 = Number(document.getElementById("discount").value) / 100;
            var totalValue = numVal1 - (numVal1 * numVal2)
            document.getElementById("total").value = totalValue.toFixed(2);
        }
    </script> -->
    <!-----ALERT_MESSEAGE----!--->

    <?php
    if ($insert) {
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
    <strong>Success!</strong> Your Product has been inserted successfully
    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
      <span aria-hidden='true'>×</span>
    </button>
  </div>";
    }
    ?>
    <?php
    if ($delete) {
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
    <strong>Success!</strong> Your Product has been deleted successfully
    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
      <span aria-hidden='true'>×</span>
    </button>
  </div>";
    }
    ?>
    <?php
    if ($update) {
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
    <strong>Success!</strong> Your Product has been updated successfully
    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
      <span aria-hidden='true'>×</span>
    </button>
  </div>";
    }
    ?>
    <!--WELCOME PAGE---!-->
    <div class="container my-4">

        <div class="container">
            <div class="alert alert-success" role="alert">
                <h1 class="alert-heading" <h1>
                    <center>WELCOME ADMIN<center>
                </h1>
                <hr>.
                <h2>
                    <center>Product Management<center>
                </h2>
            </div>
        </div>

        <!---FORM---!-->

        <form action="/PRODUCT_MANAGEMENT/index.php" method="POST" enctype="multipart/form-data">

            <div class="form-group">
                <label for="p_name">Product Name</label>
                <input type="text" class="form-control" id="p_name" name="p_name">
                <span class="error">* <?php echo $nameErr; ?> </span>
            </div>
            <div class="form-group">
                <label for="p_desc">Product Description</label>
                <textarea class="form-control" id="p_desc" name="p_desc" rows="3"></textarea>
                <span class="error">* <?php echo $nameErr; ?> </span>
            </div>
            <div class="form-group">
                <label for="d_name">Brand</label>
                <input type="text" class="form-control" id="d_name" name="d_name">
                <span class="error">* <?php echo $nameErr; ?> </span>
            </div>
            <div class="form-group">
                <label for="p_img">Product Img</label>
                <input type="file" class="form-control" id="p_img" name="p_img">
                <span class="error">* <?php echo $imgErr; ?> </span>
            </div>
            <!-- <div class="form-group">
                <label for="c_name">Category</label>
                <input type="text" class="form-control" id="category" name="category">
                <span class="error">* <?php  ?> //</span>
            </div> -->
            <div class="form-group">
                <label>Category</label>
                <select class="form-control" id="category" name="category">
                    <option>Men</option>
                    <option>Women</option>
                    <option>Kid</option>
                </select>
            </div>

            <!-- <div class="form-group">
                <label for="size">Size</label>
                <input type="text" class="form-control" id="p_size" name="p_size">
            </div> -->
            <div class="form-group">
                <label>Size</label>
                <select class="form-control" id="p_size" name="p_size">
                    <option>S</option>
                    <option>M</option>
                    <option>L</option>
                </select>
            </div>
            <div class="form-group">
                <label for="mrp">MRP</label>
                <input type="number" class="form-control" id="price_product" name="mrp">

            </div>
            <div class="form-group">
                <label for="d_percent">Discount</label>
                <span>&#37;</span>
                <input type="number" class="form-control" id="discount_product" name="d_percent">
            </div>

            <div class="form-group">
                <label for="d_price">Total</label>
                <span>&#8377;</span> <input type="number" class="form-control" id="total_product" name="d_price" onclick="getPrice()">
            </div>

            <!-- <script>
                getPrice = function() {
                    var numVal1 = Number(document.getElementById("price").value);
                    var numVal2 = Number(document.getElementById("discount").value) / 100;
                    var totalValue = numVal1 - (numVal1 * numVal2)
                    document.getElementById("total").value = totalValue.toFixed(2);
                }
            </script> -->
            <!----
      <div class="form-group">
        <label for="create_date">Create Date</label>
        <input type="date" class="form-control" id="create_date" name="create_date" aria-describedby="emailHelp">
      </div>
      <div class="form-group">
        <label for="update_date">Update Date</label>
        <input type="date" class="form-control" id="update_date" name="update_date" aria-describedby="emailHelp">
      </div>
      --!-->

            <button type="submit" class="btn btn-primary">Upload</button>
        </form>
    </div>

    <!---For Uploading CSV file---!--->
    <form action="csv.php" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="p_img">Import CSV file</label>
            <input type="file" class="form-control" id="product_file" name="product_file">
            <button type="submit" name="submit" class="btn btn-primary">Import</button>
        </div>
        <!-- <label>Import CSV file</label>
        <input type="file" id="product_file" name="product_file" />
        <button type="submit" name="submit" class="btn btn-primary">Import</button> -->
    </form>



    <!---Product Listing in tabular format---!-->
    <div class="container my-4">
        <table class="table" id="myTable">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Name</th>
                    <th scope="col"> Description</th>
                    <th scope="col">Brand</th>
                    <th scope="col">Img</th>
                    <th scope="col">Category</th>
                    <th scope="col">Size</th>
                    <th scope="col">MRP</th>
                    <th scope="col">Discount</th>
                    <th scope="col">Total</th>
                    <th scope="col">Create Date</th>
                    <th scope="col">Update Date</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>


                <!-----SQL Query TO DISPLAY THE TABLE --!---->
                <?php
                $sql = "SELECT * FROM `product`";
                $result = mysqli_query($conn, $sql);
                $uid = 0;
                while ($row = mysqli_fetch_assoc($result)) {
                    $uid = $uid + 1;
                    echo "<tr>
            <th scope='row'>" . $uid . "</th>
            <td>" . $row['p_name'] . "</td>
            <td>" . $row['p_desc'] . "</td>
            <td>" . $row['d_name'] . "</td>
            <td><img src='" . $row['p_img'] . "' height='100' width='100'/></td>
            <td>" . $row['category'] . "</td>
            <td>" . $row['p_size'] . "</td>
            <td>" . $row['mrp'] . "</td>
            <td>" . $row['d_price'] . "</td>
            <td>" . $row['d_percent'] . "</td>
            <td>" . $row['create_date'] . "</td>
            <td>" . $row['update_date'] . "</td>
            <td> <button class='edit btn btn-sm btn-primary' id=" . $row['uid'] . ">Edit</button> <br>
            <br>
            <button class='delete btn btn-sm btn-primary' id=d" . $row['uid'] . ">Delete</button>  </td>
          </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    <hr>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable();

        });
    </script>
    <script>
        edits = document.getElementsByClassName('edit');
        Array.from(edits).forEach((element) => {
            element.addEventListener("click", (e) => {
                console.log("edit ");
                tr = e.target.parentNode.parentNode;
                p_name = tr.getElementsByTagName("td")[0].innerText;
                p_desc = tr.getElementsByTagName("td")[1].innerText;
                d_name = tr.getElementsByTagName("td")[2].innerText;
                p_img = tr.getElementsByTagName("td")[3].innerText;
                category = tr.getElementsByTagName("td")[4].innerText;
                p_size = tr.getElementsByTagName("td")[5].innerText;
                mrp = tr.getElementsByTagName("td")[6].innerText;
                d_price = tr.getElementsByTagName("td")[7].innerText;
                d_percent = tr.getElementsByTagName("td")[8].innerText;
                console.log(p_name, p_desc, d_name, p_img, category, p_size, mrp, d_price, d_percent);
                p_name_Edit.value = p_name;
                p_desc_Edit.value = p_desc;
                d_name_Edit.value = d_name;
                p_img_Edit.value = p_img;
                category_Edit.value = category;
                p_size_Edit.value = p_size;
                price.value = mrp;
                discount.value = d_percent;
                total.value = d_price;
                uid_Edit.value = e.target.id;
                console.log(e.target.id)
                $('#editModal').modal('toggle');





            })
        })

        function saveForm() {
            // alert();
            document.getElementById('edit_product').submit();
        }

        deletes = document.getElementsByClassName('delete');
        Array.from(deletes).forEach((element) => {
            element.addEventListener("click", (e) => {
                console.log("edit ");
                uid = e.target.id.substr(1);

                if (confirm("Are you sure you want to delete this Product!")) {
                    console.log("yes");
                    window.location = `/PRODUCT_MANAGEMENT/index.php?delete=${uid}`;
                    // TODO: Create a form and use post request to submit a form
                } else {
                    console.log("no");
                }
            })
        })
    </script>

    <script>
        getPrice = function() {
            var numVal1 = Number(document.getElementById("price").value);
            var numVal2 = Number(document.getElementById("discount").value) / 100;
            var totalValue = numVal1 - (numVal1 * numVal2)
            document.getElementById("total").value = totalValue.toFixed(2);
        }
    </script>

    <script>
        getPrice = function() {
            var numVal1 = Number(document.getElementById("price_product").value);
            var numVal2 = Number(document.getElementById("discount_product").value) / 100;
            var totalValue = numVal1 - (numVal1 * numVal2)
            document.getElementById("total_product").value = totalValue.toFixed(2);
        }
    </script>
</body>

</html>