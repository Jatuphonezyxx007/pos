<?php
// เชื่อมต่อฐานข้อมูล
include('connectdb.php'); 

if (isset($_GET['id'])) {
    $emp_id = $_GET['id'];

    // เช็คว่ามีการขายของพนักงานคนนี้ในตาราง orders หรือไม่
    $checkOrders = "SELECT * FROM orders WHERE emp_id = '$emp_id'";
    $ordersResult = mysqli_query($conn, $checkOrders);
    
    if (mysqli_num_rows($ordersResult) > 0) {
        // ถ้ามีการขายให้ทำการอัปเดต emp_id ในตาราง orders เป็น '001'
        $updateOrders = "UPDATE orders SET emp_id = '001' WHERE emp_id = '$emp_id'";
        mysqli_query($conn, $updateOrders);
    }

    // ลบข้อมูลพนักงานในตาราง employees
    $deleteEmployee = "DELETE FROM employees WHERE emp_id = '$emp_id'";
    if (mysqli_query($conn, $deleteEmployee)) {
        // รีไดเรกต์ไปยังหน้า employee_list.php หลังจากลบเสร็จ
        header('Location: employee_list.php');
        exit(); // ทำการหยุดการทำงานต่อจากนี้
    } else {
        echo "เกิดข้อผิดพลาดในการลบข้อมูล";
    }
}
?>
