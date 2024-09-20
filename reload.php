<?php
// รับค่า order_id จาก URL
$order_id = $_GET['order_id'] ?? null;

if ($order_id) {
    // เพิ่มเลขศูนย์นำหน้าหมายเลข order_id ให้เป็น 7 หลัก
    $formatted_order_id = str_pad($order_id, 7, '0', STR_PAD_LEFT);

    echo "
    <script>
        // กำหนดขนาดหน้าต่างของ bill_print.php (เช่น กว้าง 800px และสูง 600px)
        var width = 760;
        var height = 560;
        var left = (screen.width / 2) - (width / 2);
        var top = (screen.height / 2) - (height / 2);
        
        // เปิดหน้าต่าง bill_print.php พร้อมส่ง order_id ที่มีเลข 0 นำหน้า
        var printWindow = window.open(
            'bill_print.php?b=" . $formatted_order_id . "', 
            '_blank', 
            'width=' + width + ',height=' + height + ',top=' + top + ',left=' + left
        );

        // ตรวจสอบว่า popup ถูกบล็อกหรือไม่
        if (printWindow) {
            printWindow.focus(); // นำหน้าต่าง popup ไปไว้ด้านหน้า
        } else {
            alert('Popup ถูกบล็อก กรุณาปิดการบล็อก popup แล้วลองใหม่อีกครั้ง');
        }

        // หลังจากเปิดหน้าต่างแล้ว รีไดเรกไปที่หน้า sale.php
        localStorage.clear(); // ล้างข้อมูลทั้งหมดจาก Local Storage
        window.location.href = 'sale.php';
    </script>";
} else {
    // หากไม่มี order_id ให้แสดงข้อความข้อผิดพลาด
    echo "ไม่พบหมายเลขคำสั่งซื้อ";
}
?>


