<?php
include("connectdb.php");

if (isset($_POST['query'])) {
    $src = $_POST['query'];

    // Prepare the SQL statement to prevent SQL injection
    $sql = "SELECT products.*, MIN(size.price) AS min_price, MAX(size.price) AS max_price 
            FROM `products`
            JOIN `size` ON products.id = size.id
            WHERE (`products`.`barcode` LIKE ? OR `products`.`name` LIKE ?)
            GROUP BY products.id
            ORDER BY `products`.`type_id` ASC";

    // Prepare and execute the statement
    if ($stmt = $conn->prepare($sql)) {
        // Bind parameters (s for string, use two placeholders for query)
        $likeQuery = "%{$src}%";
        $stmt->bind_param("ss", $likeQuery, $likeQuery);
        
        // Execute the statement
        $stmt->execute();
        
        // Get the result
        $result = $stmt->get_result();
        
        $output = '';

        while ($data = $result->fetch_assoc()) {
            $min_price = number_format($data['min_price'], 2);
            $max_price = number_format($data['max_price'], 2);

            $output .= '
            <div class="col-sm-12 col-md-3 col-lg-4">
                <div class="card">
                    <img src="assets/images/products_2/'.$data['id'].'.'.$data['img'].'" class="card-img-top" alt="'.$data['name'].'" height="280px">
                    <div class="card-body">
                        <h8 class="card-title d-inline-block text-truncate" style="max-width: 150px;">'.$data['name'].'</h8>
                        <p class="card-text">';
            
            if ($data['min_price'] == $data['max_price']) {
                $output .= $min_price . ' บาท';
            } else {
                $output .= $min_price . ' - ' . $max_price . ' บาท';
            }

            $output .= '</p>
                        <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" data-product-id="'.$data['id'].'" data-product-name="'.$data['name'].'" data-product-min-price="'.$min_price.'" data-product-max-price="'.$max_price.'">เพิ่ม</a>
                    </div>
                </div>
            </div>
            ';
        }

        echo $output;

        // Close the statement
        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error;
    }

    mysqli_close($conn);
}
?>
