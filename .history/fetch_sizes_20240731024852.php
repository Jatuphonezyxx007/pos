<?php
include("connectdb.php");

if (isset($_POST['id'])) {
    $product_id = $_POST['id'];
    
    // Query to get sizes and prices for the selected product
    $sql = "SELECT size.size_name, size.price 
    FROM size 
    WHERE size.id = ?";
    
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $product_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    $output = '<div class="row">';
    
    $count = 0;
    while ($data = mysqli_fetch_assoc($result)) {
        if ($count > 0 && $count % 2 == 0) {
            $output .= '</div><div class="row">';
        }
        $output .= '<div class="col-6 mb-2">
            <button type="button" class="size-button w-100" data-price="'.$data['price'].'" data-size-name="'.$data['size_name'].'">'.$data['size_name'].'</button>
        </div>';
        $count++;
    }
    $output .= '</div>';
    
    echo $output;
    mysqli_close($conn);
}
?>
