<?php
include("connectdb.php");

if (isset($_POST['id'])) {
    $product_id = $_POST['id'];
    
    // Query to get sizes and their quantities for the selected product
    $sql = "SELECT size.size_name, size.qty, size.price 
    FROM size 
    WHERE size.id = {$product_id}";
    
    $rs = mysqli_query($conn, $sql);
    $output = '<div class="row">';

    $count = 0;
    while ($data = mysqli_fetch_array($rs)) {
        // Set price to 0 if qty is 0
        if ($data['qty'] == 0) {
            $data['price'] = 0;
        }
        
        if ($count > 0 && $count % 2 == 0) {
            $output .= '</div><div class="row">';
        }
        $output .= '<div class="col-6 mb-2">
            <button type="button" class="size-button w-100" data-size-name="'.$data['size_name'].'" data-price="'.$data['price'].'" data-qty="'.$data['qty'].'">'.$data['size_name'].'</button>
        </div>';
        $count++;
    }
    $output .= '</div>';

    echo $output;
    mysqli_close($conn);
}
?>
