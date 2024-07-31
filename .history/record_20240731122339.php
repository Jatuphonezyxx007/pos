<?php
include("connectdb.php");

// ตรวจสอบว่ามีการส่งค่าจากฟอร์มหรือไม่
if (isset($_POST['payments']) && isset($_POST['orderDetails'])) {
    // รับข้อมูลจากฟอร์ม
    $paymethod_id = $_POST['payments'];
    $orderDetails = json_decode($_POST['orderDetails'], true);

    // คำนวณยอดรวม
    $total = 0;
    foreach ($orderDetails as $item) {
        $total += $item['price'] * $item['quantity'];
    }

    // สร้างคำสั่ง SQL สำหรับการแทรกข้อมูลลงในตาราง orders
    $sql = "INSERT INTO `orders` (order_total, order_date, emp_id, paymethod_id, status) VALUES ('$total', CURRENT_TIMESTAMP, '002', '$paymethod_id', 1)";
    mysqli_query($conn, $sql) or die("Insert error: " . mysqli_error($conn));

    // รับค่า ID ของการแทรกคำสั่งซื้อที่เพิ่มเข้ามา
    $orderId = mysqli_insert_id($conn);

    // แทรกข้อมูลลงในตาราง orders_detail และอัปเดตจำนวนสินค้าในตาราง Products
    foreach ($orderDetails as $item) {
        // หา product_id และ size_id จากชื่อและขนาดสินค้า (ปรับตามฐานข้อมูลของคุณ)
        // สมมติว่า `Products` มี `name` และ `size`
        $productName = $item['productName'];
        $productSize = $item['productSize'];
        $quantity = $item['quantity'];

        $sqlProduct = "SELECT id, size_id FROM Products WHERE name='$productName' AND size='$productSize'";
        $resultProduct = mysqli_query($conn, $sqlProduct);
        $product = mysqli_fetch_assoc($resultProduct);
        $productId = $product['id'];
        $sizeId = $product['size_id'];

        // แทรกข้อมูลลงในตาราง orders_detail
        $sql2 = "INSERT INTO orders_detail (order_id, p_id, s_id, item) VALUES ('$orderId', '$productId', '$sizeId', '$quantity')";
        mysqli_query($conn, $sql2);

        // อัปเดตจำนวนสินค้าในตาราง Products
        $sql3 = "UPDATE Products SET qty = qty - '$quantity' WHERE id = '$productId'";
        mysqli_query($conn, $sql3) or die("Update error: " . mysqli_error($conn));
    }

    // ปริ้นใบรับเงินและรีเฟรชหน้า sale.php
    echo "<script>
            window.location.href = 'sale.php';
          </script>";
} else {
    // หากไม่มีการส่งค่ามาให้แสดงข้อความข้อผิดพลาด
    die("ไม่มีการส่งข้อมูลการชำระเงิน");
}
?>
