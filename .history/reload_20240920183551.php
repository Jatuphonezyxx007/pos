<?php
// รับค่า order_id จาก URL
$order_id = $_GET['order_id'] ?? null;

if ($order_id) {
    // เพิ่มเลขศูนย์นำหน้าหมายเลข order_id ให้เป็น 7 หลัก
    $formatted_order_id = str_pad($order_id, 7, '0', STR_PAD_LEFT);

    echo "
    <script>
        // เปิดหน้าต่าง bill_print.php พร้อมส่ง order_id ที่มีเลข 0 นำหน้า
        window.open('bill_print.php?b=" . $formatted_order_id . "', '_blank');
        
        // หลังจากเปิดหน้าต่างแล้ว รีไดเรกไปที่หน้า sale.php
        window.location.href = 'sale.php';
    </script>";
} else {
    // หากไม่มี order_id ให้แสดงข้อความข้อผิดพลาด
    echo "ไม่พบหมายเลขคำสั่งซื้อ";
}
?>