<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include('connectdb.php');
    
    $barcode = $_POST['p_barcode'];
    $name = $_POST['p_name'];
    $unit = $_POST['unit_product'];
    $type = $_POST['p_type'];
    $newType = isset($_POST['new_type']) ? $_POST['new_type'] : '';
    $img = pathinfo($_FILES['p_pics']['name'], PATHINFO_EXTENSION);

    if ($type == 'new' && !empty($newType)) {
        // เพิ่มประเภทใหม่ลงในฐานข้อมูล
        $stmt = $conn->prepare("INSERT INTO type (type_name) VALUES (?)");
        $stmt->bind_param("s", $newType);
        $stmt->execute();
        $type = $stmt->insert_id; // ดึง type_id ของประเภทใหม่
        $stmt->close();
    }

    if ($type !== 'new') {
        // เพิ่มสินค้าลงในตาราง products
        $stmt = $conn->prepare("INSERT INTO products (barcode, name, img, unit, type_id) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssi", $barcode, $name, $img, $unit, $type);
        $stmt->execute();
        $productId = $stmt->insert_id; // ดึง id ของสินค้าที่เพิ่มใหม่

        // บันทึกไฟล์ภาพ
        move_uploaded_file($_FILES['p_pics']['tmp_name'], "pos/assets/images/Products_2/{$productId}.{$img}");

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
        header("Location: product_manage.php");
        exit();
    }
}
?>
