<?php
include("connectdb.php");

if (isset($_POST['id'])) {
    $product_id = $_POST['id'];
    
    // Query to get sizes for the selected product
    $sql = "SELECT size.size_name 
    FROM size 
    WHERE size.id = {$product_id}";
    
    $rs = mysqli_query($conn, $sql);
    $output = '';

    while ($data = mysqli_fetch_array($rs)) {
        $output .= '<button type="button" class="btn btn-outline-secondary">'.$data['size_name'].'</button><br>';
    }

    echo $output;
    mysqli_close($conn);
}
?>
