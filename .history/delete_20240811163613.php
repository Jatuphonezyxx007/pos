<meta charset="UTF-8">

<?php
if (isset($_GET['id'])) {
    include("connectdb.php");

    // เริ่มต้น transaction
    mysqli_begin_transaction($conn);

    try {
        $order_id = $_GET['id'];

        // ดึงข้อมูลสินค้าที่ถูกขายออกจากตาราง orders_detail
        $sql = "SELECT p_id, s_id, item FROM `orders_detail` WHERE `order_id` = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $order_id);
        $stmt->execute();
        $result = $stmt->get_result();

        // อัปเดตจำนวนสินค้าคืนกลับไปที่ตาราง size
        while ($row = $result->fetch_assoc()) {
            $pid = $row['p_id'];
            $item = $row['item'];
            $sid = $row['s_id'];

            $sql_update = "UPDATE `size` SET `qty` = `qty` + ? WHERE `size_id` = ?";
            $stmt_update = $conn->prepare($sql_update);
            $stmt_update->bind_param("ii", $item, $sid);

            if (!$stmt_update->execute()) {
                throw new Exception("เกิดข้อผิดพลาดในการอัปเดตจำนวนสินค้า: " . $stmt_update->error);
            }
        }

        // ลบข้อมูลจากตาราง orders_detail ที่มี order_id ตรงกับค่าที่ส่งมา
        $sql_delete_detail = "DELETE FROM `orders_detail` WHERE `order_id` = ?";
        $stmt_delete_detail = $conn->prepare($sql_delete_detail);
        $stmt_delete_detail->bind_param("i", $order_id);

        if (!$stmt_delete_detail->execute()) {
            throw new Exception("เกิดข้อผิดพลาดในการลบข้อมูลจาก orders_detail: " . $stmt_delete_detail->error);
        }

        // ลบข้อมูลจากตาราง orders ที่มี order_id ตรงกับค่าที่ส่งมา
        $sql_delete_order = "DELETE FROM `orders` WHERE `order_id` = ?";
        $stmt_delete_order = $conn->prepare($sql_delete_order);
        $stmt_delete_order->bind_param("i", $order_id);

        if (!$stmt_delete_order->execute()) {
            throw new Exception("เกิดข้อผิดพลาดในการลบข้อมูลจาก orders: " . $stmt_delete_order->error);
        }

        // คอมมิต transaction
        mysqli_commit($conn);

        echo "<script>";
        echo "window.location='sale_history.php?reload=1';";
        echo "</script>";
    } catch (Exception $e) {
        // โรลแบ็ค transaction ในกรณีที่มีข้อผิดพลาด
        mysqli_rollback($conn);
        die("Error: " . $e->getMessage());
    }
} else {
    die("ไม่มีการระบุ order_id");
}

mysqli_close($conn);
?>
