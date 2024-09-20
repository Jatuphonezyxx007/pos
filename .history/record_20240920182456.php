<?php
session_start(); // เริ่มต้น session
include("connectdb.php");

// ตรวจสอบว่ามีการส่งค่าจากฟอร์มหรือไม่
if (isset($_POST['payments']) && isset($_POST['orderDetails'])) {
    // รับข้อมูลจากฟอร์ม
    $paymethod_id = $_POST['payments'];
    $orderDetails = json_decode($_POST['orderDetails'], true);

    // ตรวจสอบการแปลง JSON ว่าถูกต้องหรือไม่
    if (!$orderDetails) {
        die("การแปลง JSON ผิดพลาด");
    }

    // คำนวณยอดรวม
    $total = 0;
    foreach ($orderDetails as $item) {
        $total += $item['price'];
    }

    // ดึง emp_id ของพนักงานจาก session
    $emp_id = $_SESSION['aid'];

    // สร้างคำสั่ง SQL สำหรับการแทรกข้อมูลลงในตาราง orders
    $sql = "INSERT INTO `orders` (order_total, order_date, emp_id, paymethod_id) 
            VALUES ('$total', CURRENT_TIMESTAMP, '$emp_id', '$paymethod_id')";
    if (!mysqli_query($conn, $sql)) {
        die("Insert error in orders: " . mysqli_error($conn));
    }

    // รับค่า ID ของการแทรกคำสั่งซื้อที่เพิ่มเข้ามา
    $orderId = mysqli_insert_id($conn);

    // แทรกข้อมูลลงในตาราง orders_detail และอัปเดตจำนวนสินค้าในตาราง Products
    foreach ($orderDetails as $item) {
        // หา product_id และ size_id จากชื่อและขนาดสินค้า
        $productName = $item['productName'];
        $productSize = $item['productSize'];
        $quantity = $item['quantity'];

        $sqlProduct = "SELECT p.id AS product_id, s.size_id AS size_id 
                       FROM products p 
                       JOIN size s ON p.id = s.id 
                       WHERE p.name = ? AND s.size_name = ?";
        $stmt = $conn->prepare($sqlProduct);
        $stmt->bind_param("ss", $productName, $productSize);
        $stmt->execute();
        $resultProduct = $stmt->get_result();

        if ($resultProduct && mysqli_num_rows($resultProduct) > 0) {
            $product = mysqli_fetch_assoc($resultProduct);
            $productId = $product['product_id'];
            $sizeId = $product['size_id'];

            // แทรกข้อมูลลงในตาราง orders_detail
            $sql2 = "INSERT INTO orders_detail (order_id, p_id, s_id, item) VALUES (?, ?, ?, ?)";
            $stmt2 = $conn->prepare($sql2);
            $stmt2->bind_param("iiii", $orderId, $productId, $sizeId, $quantity);
            if (!$stmt2->execute()) {
                die("Insert error in orders_detail: " . mysqli_error($conn));
            }

            // อัปเดตจำนวนสินค้าในตาราง Products
            $sql3 = "UPDATE size SET qty = qty - ? WHERE size_id = ?";
            $stmt3 = $conn->prepare($sql3);
            $stmt3->bind_param("ii", $quantity, $sizeId);
            if (!$stmt3->execute()) {
                die("Update error in size: " . mysqli_error($conn));
            }
        } else {
            die("ค้นหาสินค้าไม่พบ");
        }
    }

    // ปริ้นใบรับเงินและรีเฟรชหน้า sale.php
//     echo "<script>
//             localStorage.clear(); // ล้างข้อมูลทั้งหมดจาก Local Storage
//             window.location.href = 'sale.php';
//           </script>";
// } else {
//     // หากไม่มีการส่งค่ามาให้แสดงข้อความข้อผิดพลาด
//     die("ไม่มีการส่งข้อมูลการชำระเงิน");
// }

$query = "SELECT order_id FROM orders ORDER BY order_id DESC LIMIT 1";
$stmt = $conn->prepare($query);
$stmt->execute();
$order = $stmt->fetch(PDO::FETCH_ASSOC);

if ($order) {
    $order_id = $order['order_id']; // ดึง order_id ล่าสุด

    // ส่ง order_id ไปที่ bill_print.php
    echo "<script>
            localStorage.clear(); // ล้างข้อมูลทั้งหมดจาก Local Storage
            window.open('bill_print.php?b=" . $order_id . "', '_blank'); // เปิดหน้าพิมพ์ใบเสร็จในแท็บใหม่
            window.location.href = 'sale.php'; // กลับไปหน้า sale.php
          </script>";
} else {
    die('ไม่พบคำสั่งซื้อที่บันทึก');
}
?>
