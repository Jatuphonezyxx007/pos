<?php
// รับค่า order_id จาก URL
$order_id = $_GET['order_id'] ?? null;

if ($order_id) {
    echo "
    <script>
        // เปิดหน้าต่าง bill_print.php พร้อมส่ง order_id
        window.open('bill_print.php?b=" . $order_id . "', '_blank');
        
        // หลังจากเปิดหน้าต่างแล้ว รีไดเรกไปที่หน้า sale.php
        window.location.href = 'sale.php';
    </script>";
} else {
    // หากไม่มี order_id ให้แสดงข้อความข้อผิดพลาด
    echo "ไม่พบหมายเลขคำสั่งซื้อ";
}
?>
