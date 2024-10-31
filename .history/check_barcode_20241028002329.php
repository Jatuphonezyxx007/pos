<?php
// connectdb.php - เชื่อมต่อฐานข้อมูล
$conn = mysqli_connect('localhost', 'root', '', 'shop'); // แทนที่ค่าตามที่คุณใช้

// include('connectdb.php');

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>ตรวจสอบบาร์โค้ด</title>
    <link rel="stylesheet" href="path/to/bootstrap.css"> <!-- ปรับให้ถูกต้อง -->
</head>
<body>
    <div class="container">
        <div class="row align-items-center">
            <div class="col-3">
                <p class="text-dark mb-0">เลขที่บาร์โค้ด</p>
            </div>
            <div class="col-6">
                <input id="barcodeInput" name="barcode" type="text" class="form-control"> 
            </div> 
            <div class="col-3">
                <button id="checkBarcodeBtn" type="button" class="btn btn-success w-100">ตรวจสอบ</button>
            </div>  
        </div>
        <div id="barcodeMessage"></div> <!-- สำหรับแสดงข้อความ -->
    </div>

    <script src="path/to/bootstrap.bundle.min.js"></script> <!-- ปรับให้ถูกต้อง -->
    <script>
        document.getElementById('checkBarcodeBtn').addEventListener('click', function(e) {
            e.preventDefault();

            var barcode = document.getElementById('barcodeInput').value;

            if (barcode === '') {
                document.getElementById('barcodeMessage').innerHTML = '<span class="text-danger">กรุณากรอกหมายเลขบาร์โค้ด</span>';
                return;
            }

            fetch('check_barcode.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'barcode=' + encodeURIComponent(barcode)
            })
            .then(response => response.json())
            .then(data => {
                var messageDiv = document.getElementById('barcodeMessage');
                if (data.exists) {
                    messageDiv.innerHTML = '<span class="text-danger">หมายเลขบาร์โค้ดนี้มีการใช้งานแล้ว</span>';
                } else {
                    messageDiv.innerHTML = '<span class="text-success">หมายเลขบาร์โค้ดนี้ยังไม่มีการใช้งาน</span>';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('barcodeMessage').innerHTML = '<span class="text-danger">เกิดข้อผิดพลาดในการตรวจสอบ</span>';
            });
        });
    </script>

<?php
// ตรวจสอบบาร์โค้ดหลังจากการส่งข้อมูล
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['barcode'])) {
    $barcode = $_POST['barcode'];
    error_log("Barcode received: $barcode"); // แสดงบาร์โค้ดที่ได้รับใน log

    $barcode = mysqli_real_escape_string($conn, $barcode);
    $sql = "SELECT COUNT(*) as count FROM products WHERE barcode = '$barcode'";
    $result = mysqli_query($conn, $sql);
    
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        error_log("Count found: " . $row['count']); // แสดงจำนวนที่พบใน log
        echo json_encode(['exists' => $row['count'] > 0]);
    } else {
        error_log("SQL error: " . mysqli_error($conn)); // แสดงข้อผิดพลาด SQL
        echo json_encode(['exists' => false]);
    }
    exit;
}
?>

</body>
</html>
