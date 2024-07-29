<?php
include("connectdb.php");

if (isset($_POST['query'])) {
    $src = $_POST['query'];
    $sql = "SELECT products.*, MIN(size.price) AS min_price, MAX(size.price) AS max_price 
    FROM `products`
    JOIN `size` ON products.id = size.id
    WHERE (`products`.`barcode` LIKE '%{$src}%' OR `products`.`name` LIKE '%{$src}%')
    GROUP BY products.id
    ORDER BY `products`.`type_id` ASC";  
    $rs = mysqli_query($conn, $sql);
    $output = '';

    while ($data = mysqli_fetch_array($rs)) {
        $min_price = number_format($data['min_price'],);
        $max_price = number_format($data['max_price'],);

        $output .= '
        <div class="col-sm-12 col-md-3 col-lg-4">
            <div class="card">
                <img src="assets/images/products_2/'.$data['id'].'.'.$data['img'].'" class="card-img-top" alt="" height="280px">
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
    mysqli_close($conn);
}
?>

