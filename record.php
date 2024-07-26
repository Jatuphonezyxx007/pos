<meta charset="utf-8">
<?php
@session_start();
include("connectdb.php");

// ตรวจสอบว่ามีการส่งค่าจากฟอร์มหรือไม่
if (isset($_POST['payments'])) {
    // คำนวณยอดรวม
    foreach ($_SESSION['sid'] as $pid) {
        $sum[$pid] = $_SESSION['sprice'][$pid] * $_SESSION['sitem'][$pid];
        @$total += $sum[$pid];
    }

    // สร้างคำสั่ง SQL สำหรับการแทรกข้อมูลลงในตาราง orders
    $paymethod_id = $_POST['payments']; // รับค่าจากฟอร์ม
    $sql = "INSERT INTO `orders` (order_id, order_total, order_date, emp_id, paymethod_id) VALUES ('', '$total', CURRENT_TIMESTAMP, '002', '$paymethod_id')";
    mysqli_query($conn, $sql) or die("Insert error");

    // รับค่า ID ของการแทรกคำสั่งซื้อที่เพิ่มเข้ามา
    $id = mysqli_insert_id($conn);

    // แทรกข้อมูลลงในตาราง orders_detail และอัปเดตจำนวนสินค้าในตาราง Products
    foreach ($_SESSION['sid'] as $pid) {
        $sql2 = "INSERT INTO orders_detail (detail_id, order_id, p_id, item) VALUES ('', '$id', '".$_SESSION['sid'][$pid]."', '".$_SESSION['sitem'][$pid]."')";
        mysqli_query($conn, $sql2);

        // อัปเดตจำนวนสินค้าในตาราง Products
        $sql3 = "UPDATE Products SET qty = qty - '".$_SESSION['sitem'][$pid]."' WHERE id = '".$_SESSION['sid'][$pid]."'";
        mysqli_query($conn, $sql3) or die("Update error: " . mysqli_error($conn));
    }
    
    // ล้างค่าในเซสชัน
    session_unset(); // ล้างตัวแปรทั้งหมดในเซสชัน
    session_destroy(); // ทำลายเซสชัน

    
    // ปริ้นใบรับเงินและรีเฟรชหน้า sale.php
    echo "<script>

            window.location.href = 'sale.php';
    </script>";
} else {
    // หากไม่มีการส่งค่ามาให้แสดงข้อความข้อผิดพลาด
    die("ไม่มีการส่งข้อมูลการชำระเงิน");
}
?>
