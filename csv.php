<?php

require 'cont/_dbconnect.php';

if (isset($_POST["submit"])) {

    if ($_FILES['product_file']['name']) {
        $filename = explode(".", $_FILES['product_file']['name']);

        if ($filename[1] == "csv") {
            $handle = fopen($_FILES['product_file']['tmp_name'], "r");
            $file_data = [];
            while ($data = fgetcsv($handle)) {

                $p_name = mysqli_real_escape_string($conn, $data[0]);
                $p_desc = mysqli_real_escape_string($conn, $data[1]);
                $d_name = mysqli_real_escape_string($conn, $data[2]);
                $p_img = mysqli_real_escape_string($conn, $data[3]);
                // $folder = mysqli_real_escape_string($conn, $data[4]);
                $category  = mysqli_real_escape_string($conn, $data[5]);
                $p_size = mysqli_real_escape_string($conn, $data[6]);
                $mrp = mysqli_real_escape_string($conn, $data[7]);
                $d_price = mysqli_real_escape_string($conn, $data[8]);
                $d_percent = mysqli_real_escape_string($conn, $data[9]);

                $sql = "INSERT INTO `product` (`p_name`, `p_desc`, `d_name`,`p_img`,`category`, `p_size`, `mrp`, `d_price`, `d_percent`) VALUES ('$p_name','$p_desc','$d_name','$folder','$category','$p_size','$mrp','$d_price','$d_percent')";

                $result = mysqli_query($conn, $sql);
            }
            fclose($handle);
            header("location: /PRODUCT_MANAGEMENT/index.php?updation=1");
        } else {
            echo  '<label class="text-danger">Please Select File</label>';
        }
    } else {
        echo '<label class="text-danger">Please Select CSV File only</label>';
    }
}
