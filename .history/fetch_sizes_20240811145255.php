<?php
include("connectdb.php");

if (isset($_POST['id'])) {
    $product_id = $_POST['id'];
    
    // Query to get sizes and their quantities for the selected product
    $sql = "SELECT size.size_name, size.qty, size.price 
    FROM size 
    WHERE size.id = ?";
    
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $output = '<div class="row">';

        $count = 0;
        while ($data = $result->fetch_assoc()) {
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
        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error;
    }

    mysqli_close($conn);
}
?>
