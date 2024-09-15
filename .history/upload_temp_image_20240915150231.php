<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['ep_pic'])) {
    $allowed = array('gif', 'png', 'jpg', 'jpeg', 'jfif', 'webp');
    $filename = $_FILES['ep_pic']['name'];
    $ext = pathinfo($filename, PATHINFO_EXTENSION);

    if (!in_array($ext, $allowed)) {
        echo json_encode(array('status' => 'error', 'message' => 'ไฟล์รูปต้องเป็น jpg, gif หรือ png เท่านั้น'));
        exit;
    }

    $newFilename = uniqid() . "." . $ext;
    $targetPath = "assets/images/temp/" . $newFilename;

    if (move_uploaded_file($_FILES['ep_pic']['tmp_name'], $targetPath)) {
        echo json_encode(array('status' => 'success', 'img' => $newFilename));
    } else {
        echo json_encode(array('status' => 'error', 'message' => 'Failed to move uploaded file'));
    }
}
?>
