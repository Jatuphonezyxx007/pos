<?php
include("connectdb.php");

$data = json_decode(file_get_contents("php://input"), true);

$order_id = $data['order_id'];
$emp_id = $data['emp_id'];
$paymethod_id = $data['paymethod_id'];
$items = $data['items'];
$order_total = 0;

foreach ($items as $item) {
    $order_total += $item['price'] * $item['quantity'];
}

// Insert into orders table
$sql = "INSERT INTO orders (order_id, order_total, order_date, emp_id, paymethod_id, status) VALUES ('$order_id', '$order_total', NOW(), '$emp_id', '$paymethod_id', 1)";
if (mysqli_query($conn, $sql)) {
    // Insert into order_detail table
    foreach ($items as $item) {
        $detail_id = uniqid();
        $p_id = $item['product_id'];
        $s_id = $item['size_id'];
        $quantity = $item['quantity'];
        $sql_detail = "INSERT INTO order_detail (detail_id, order_id, p_id, s_id, item) VALUES ('$detail_id', '$order_id', '$p_id', '$s_id', '$quantity')";
        mysqli_query($conn, $sql_detail);
    }
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false]);
}

mysqli_close($conn);
?>
