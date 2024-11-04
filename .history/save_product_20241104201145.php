<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include('connectdb.php'); // รวมการเชื่อมต่อกับฐานข้อมูล

    $barcode = $_POST['p_barcode'];
    $name = $_POST['p_name'];
    $unit = $_POST['unit_product'];
    $type = $_POST['p_type'];
    $newType = isset($_POST['new_type']) ? $_POST['new_type'] : '';
    $img = pathinfo($_FILES['p_pics']['name'], PATHINFO_EXTENSION);

    // ตรวจสอบและเพิ่มประเภทใหม่ในตาราง type หากเลือกประเภทเป็น "new"
    if ($type === 'new' && !empty($newType)) {
        // เพิ่มประเภทใหม่ลงในตาราง type
        $stmt = $conn->prepare("INSERT INTO type (type_name) VALUES (?)");
        $stmt->bind_param("s", $newType);
        $stmt->execute();
        $type_id = $stmt->insert_id; // รับค่า type_id ที่สร้างขึ้นใหม่
        $stmt->close();
    } else {
        // กรณีมีการเลือกประเภทที่มีอยู่แล้ว
        $type_id = intval($type); // กำหนดให้ type_id เป็นค่าจาก type ที่ส่งมา และแปลงเป็นตัวเลข
    }

    // เพิ่มสินค้าลงในตาราง products
    $stmt = $conn->prepare("INSERT INTO products (barcode, name, img, unit, type_id) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssi", $barcode, $name, $img, $unit, $type_id); // เปลี่ยน `$type` เป็น `$type_id`
    
    if ($stmt->execute()) {
        $productId = $stmt->insert_id; // ดึง id ของสินค้าที่เพิ่มใหม่

        // บันทึกไฟล์ภาพ
        move_uploaded_file($_FILES['p_pics']['tmp_name'], "assets/images/Products_2/{$productId}.{$img}");

        // เพิ่มไซส์ลงในตาราง size
        foreach ($_POST['size'] as $size) {
            $sizeName = $size['size'];
            $quantity = $size['quantity'];
            $restock = $size['restock'];
            $price = $size['price'];

            $stmt = $conn->prepare("INSERT INTO size (id, size_name, qty, re_stock, price) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("isiii", $productId, $sizeName, $quantity, $restock, $price);
            $stmt->execute();
        }

        $stmt->close();
        $conn->close();

        // หลังจากบันทึกข้อมูลเสร็จสิ้น นำผู้ใช้ไปยังหน้า product_manage.php
        header("Location: products_manage.php");
        exit();
    } else {
        die('Error: ' . $stmt->error);
    }
}
?>
