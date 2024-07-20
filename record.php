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
    $sql = "INSERT INTO `orders` (order_id, order_total, order_date, paymethod_id) VALUES ('', '$total', CURRENT_TIMESTAMP, '$paymethod_id')";
    mysqli_query($conn, $sql) or die("Insert error");

    // รับค่า ID ของการแทรกคำสั่งซื้อที่เพิ่มเข้ามา
    $id = mysqli_insert_id($conn);

    // แทรกข้อมูลลงในตาราง orders_detail
    foreach ($_SESSION['sid'] as $pid) {
        $sql2 = "INSERT INTO orders_detail (detail_id, order_id, p_id, item) VALUES ('', '$id', '".$_SESSION['sid'][$pid]."', '".$_SESSION['sitem'][$pid]."')";
        mysqli_query($conn, $sql2);
    }

    // ล้างค่าในเซสชัน
    session_unset(); // ล้างตัวแปรทั้งหมดในเซสชัน
    session_destroy(); // ทำลายเซสชัน

    // เปลี่ยนเส้นทางไปที่หน้า sale.php
    echo "<meta http-equiv=\"refresh\" content=\"0;URL=sale.php\">";
} else {
    // หากไม่มีการส่งค่ามาให้แสดงข้อความข้อผิดพลาด
    die("ไม่มีการส่งข้อมูลการชำระเงิน");
}
?>
