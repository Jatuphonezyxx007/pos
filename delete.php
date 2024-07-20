<meta charset="UTF-8">

<?php
if(isset($_GET['id'])){
    include("connectdb.php");

    // เริ่มต้น transaction
    mysqli_begin_transaction($conn);
    
    try {
        // ลบข้อมูลจากตาราง orders_detail ที่มี order_id ตรงกับค่าที่ส่งมา
        $sql = "DELETE FROM `orders_detail` WHERE `order_id` = '{$_GET['id']}'";
        mysqli_query($conn, $sql) or throw new Exception("เกิดข้อผิดพลาด 01");

        // ลบข้อมูลจากตาราง orders ที่มี order_id ตรงกับค่าที่ส่งมา
        $sql2 = "DELETE FROM `orders` WHERE `order_id` = '{$_GET['id']}'";
        mysqli_query($conn, $sql2) or throw new Exception("เกิดข้อผิดพลาด 02");

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
