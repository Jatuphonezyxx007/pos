<?php
session_start();

// ล้างข้อมูลทั้งหมดใน session
session_unset();
session_destroy();

// เปลี่ยนเส้นทางไปยังหน้าเข้าสู่ระบบ
header("Location: index.php");
exit();
?>
