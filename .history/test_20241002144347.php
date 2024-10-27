<?php
include('connectdb.php');

// สร้างคำสั่ง SQL เพื่อดึงข้อมูลจากตาราง company
$sql = "SELECT * FROM company";
$result = $conn->query($sql);

// ตรวจสอบว่ามีผลลัพธ์หรือไม่
if ($result->num_rows > 0) {
    // วนลูปแสดงข้อมูลแต่ละแถว
    while($row = $result->fetch_assoc()) {
        echo "ID: " . $row["com_id"] . " - Name: " . $row["com_name"] . "<br>";
    }
} else {
    echo "0 results";
}

// ปิดการเชื่อมต่อ
$conn->close();
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">


</head>
<body>
    <div class="container">
    <div class="card" style="width: 18rem;">
  <img src="..." class="card-img-top" alt="...">
  <div class="card-body">
    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
  </div>
</div>
    </div>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>
</html>