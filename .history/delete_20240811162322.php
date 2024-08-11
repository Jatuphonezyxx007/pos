<meta charset="UTF-8">

<?php
if (isset($_GET['id'])) {
    include("connectdb.php");

    // เริ่มต้น transaction
    mysqli_begin_transaction($conn);
    
    try {
        // ดึงข้อมูลสินค้าที่ถูกขายออกจากตาราง orders_detail
        $sql = "SELECT p_id, item FROM `orders_detail` WHERE `order_id` = '{$_GET['id']}'";
        $result = mysqli_query($conn, $sql) or throw new Exception("เกิดข้อผิดพลาดในการดึงข้อมูลสินค้า");

        // อัปเดตจำนวนสินค้าคืนกลับไปที่ตาราง Products
        while ($row = mysqli_fetch_assoc($result)) {
            $pid = $row['p_id'];
            $item = $row['item'];
            $sql_update = "UPDATE `size` SET `qty` = `qty` + $item WHERE `size_id` = '$pid'";
            mysqli_query($conn, $sql_update) or throw new Exception("เกิดข้อผิดพลาดในการอัปเดตจำนวนสินค้า");
        }

        // ลบข้อมูลจากตาราง orders_detail ที่มี order_id ตรงกับค่าที่ส่งมา
        $sql_delete_detail = "DELETE FROM `orders_detail` WHERE `order_id` = '{$_GET['id']}'";
        mysqli_query($conn, $sql_delete_detail) or throw new Exception("เกิดข้อผิดพลาด 01");

        // ลบข้อมูลจากตาราง orders ที่มี order_id ตรงกับค่าที่ส่งมา
        $sql_delete_order = "DELETE FROM `orders` WHERE `order_id` = '{$_GET['id']}'";
        mysqli_query($conn, $sql_delete_order) or throw new Exception("เกิดข้อผิดพลาด 02");

        // คอมมิต transaction
        mysqli_commit($conn);

        echo "<script>";
        echo "window.location='sale_history.php?reload=1';";
        echo "</script>";
    } catch (Exception $e) {
        // โรลแบ็ค transaction ในกรณีที่มีข้อผิดพลาด
        mysqli_rollback($conn);
        die($e->getMessage());
    }
}
?>
