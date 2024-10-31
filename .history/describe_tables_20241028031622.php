<?php
// เชื่อมต่อกับฐานข้อมูล
$servername = "localhost"; // เปลี่ยนเป็น host ของคุณ
$username = "root"; // เปลี่ยนเป็นชื่อผู้ใช้ของคุณ
$password = ""; // เปลี่ยนเป็นรหัสผ่านของคุณ
$dbname = "shop"; // ชื่อฐานข้อมูลของคุณ

// สร้างการเชื่อมต่อ
$conn = new mysqli($servername, $username, $password, $dbname);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ดึงตารางทั้งหมด
$sql = "SHOW TABLES";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // วนลูปผ่านทุกตาราง
    while($row = $result->fetch_row()) {
        $tableName = $row[0];
        echo "Table: $tableName\n";
        
        // ใช้คำสั่ง DESCRIBE เพื่อแสดงข้อมูลของแอตทริบิวต์ในตารางนั้น
        $descSql = "DESCRIBE $tableName";
        $descResult = $conn->query($descSql);
        
        if ($descResult->num_rows > 0) {
            while ($descRow = $descResult->fetch_assoc()) {
                echo "Field: " . $descRow['Field'] . ", Type: " . $descRow['Type'] . ", Null: " . $descRow['Null'] . ", Key: " . $descRow['Key'] . ", Default: " . $descRow['Default'] . ", Extra: " . $descRow['Extra'] . "\n";
            }
        } else {
            echo "No description available for $tableName.\n";
        }
        echo "\n"; // เพิ่มบรรทัดใหม่เพื่อให้ดูง่ายขึ้น
    }
} else {
    echo "No tables found.";
}

// ปิดการเชื่อมต่อ
$conn->close();
?>
