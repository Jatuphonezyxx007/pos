<?php
include("connectdb.php");

if (isset($_POST['id'])) {
    $product_id = $_POST['id'];
    
    // Query to get sizes for the selected product
    $sql = "SELECT size.size_name 
    FROM size 
    WHERE size.id = {$product_id}";
    
    $rs = mysqli_query($conn, $sql);
    $output = '<div class="row">';

    $count = 0;
    while ($data = mysqli_fetch_array($rs)) {
        if ($count > 0 && $count % 2 == 0) {
            $output .= '</div><div class="row">';
        }
        $output .= '<div class="col-6 mb-2">
            <button type="button" class="size-button w-100" data-size-name="'.$data['size_name'].'">'.$data['size_name'].'</button>
        </div>';
        $count++;
    }
    $output .= '</div>';

    echo $output;
    mysqli_close($conn);
}
?>
