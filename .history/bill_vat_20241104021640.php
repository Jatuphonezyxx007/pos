<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ใบกำกับภาษี</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Sarabun&display=swap" rel="stylesheet">

<style>

    body {
        font-family: "Sarabun", sans-serif;
        font-weight: 400;
        font-style: normal;
        padding-top: 20px;
        padding-right: 20px;
        padding-left: 20px;
    }

    .font-table{
      font-size: 10px;
    }

.font-header{
  font-size: 12px;
}

.row1{
  height: 15px;;
}

.font-xsmall {
        font-size: 0.25rem; /* หรือคุณสามารถใช้ขนาดที่เล็กกว่าที่คุณต้องการ */
    }

</style>

</head>
<body>



    <!-- Heading -->

    <?php
include("connectdb.php");

// ตรวจสอบว่ามีค่า 'b' ใน URL หรือไม่
if (isset($_GET['b'])) {
    $order_id = $_GET['b'];

    // สร้าง SQL Query โดยใช้ Prepared Statements
    $sql = "SELECT o.*, ad.*, pay.*, com.com_phone, com.com_name, pay.paymethod_name, pm.emp_name, pm.emp_last
            FROM orders o
            JOIN employees pm ON o.emp_id = pm.emp_id
            JOIN paymethod pay ON o.paymethod_id = pay.paymethod_id
            JOIN company com ON pm.com_id = com.com_id
            JOIN address ad ON com.add_id = ad.add_id
            WHERE o.order_id = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $order_id); // ใช้ 's' สำหรับ string
    $stmt->execute();
    $rs = $stmt->get_result();

    // ตรวจสอบว่า Query สำเร็จหรือไม่
    if ($rs) {
        if (mysqli_num_rows($rs) > 0) {
            // วนลูปเพื่อแสดงผลข้อมูล
            while ($data = mysqli_fetch_array($rs)) {
                // แปลงรูปแบบวันที่
                $originalDate = $data['order_date'];
                $timestamp = strtotime($originalDate);
                // แปลงปี ค.ศ. เป็น พ.ศ.
                $thaiYear = date('Y', $timestamp) + 543;
                $formattedDate = date('d/m/', $timestamp) . $thaiYear . ' เวลา ' . date('H:i', $timestamp) . ' น.';
?>

<div class="row">
    <div class="col-12">
        <h5 class="text-center"><strong><?= htmlspecialchars($data['com_name']); ?></strong></h5>
    </div>
    <!-- <div class="col-5">
        <h5 class="text-end"><strong>ใบเสร็จรับเงิน / Receipt</strong></h5>
    </div> -->
</div>

<br>
<div class="row">
    <div class="col-12">
        <div class="text-center font-header">
            <p class="mb-1">ที่อยู่: 
            <?= htmlspecialchars($data['add_no']) . ' ' . htmlspecialchars($data['add_subdis']) . ' ' . htmlspecialchars($data['add_dis']) . ' ' . htmlspecialchars($data['add_pro']) . ' ' . htmlspecialchars($data['add_zip']); ?>
            </p>
            <p class="mb-1">เบอร์โทร: <?= htmlspecialchars($data['com_phone']); ?></p>
            <p class="mb-1">เลขที่ประจำตัวผู้เสียภาษีอากร: <?= htmlspecialchars($data['com_phone']); ?></p>

        </div>
    </div>
    <!-- <div class="col-4">
        <div class="text-end font-header"><p>วันที่ <?= htmlspecialchars($formattedDate); ?></p></div>
    </div> -->
</div>

<br>
<br>
<div class="row">
    <div class="col-12">
    <h5 class="text-center"><strong>ใบกำกับภาษี</strong></h5>
    </div>
</div>

<!-- <div class="row">
    <div class="col-5">
        <div class="text-start font-header">
            <p>หมายเลขคำซื้อ: <?= htmlspecialchars($data['order_id']); ?></p>
        </div>
    </div>
    <div class="col-7">
        <div class="text-end font-header">
            <p>พนักงานขาย: <?= htmlspecialchars($data['emp_name']); ?> <?= htmlspecialchars($data['emp_last']); ?></p>
        </div>
    </div>
</div> -->

<div class="row">
    <div class="col-12 text-end font-header">
    <p class="mb-1">เลขที่คำสั่งซื้อ: <?= htmlspecialchars($data['order_id']); ?></p>
    <p class="mb-1">วันที่: <?= htmlspecialchars($formattedDate); ?></p>
    </div>
</div>

<!-- <div class="row">
    <div class="col-5">
        <div class="text-start font-header">
            <p>&nbsp;</p>
        </div>
    </div>
    <div class="col-7">
        <div class="text-end font-header">
            <p>การชำระเงิน: <?= htmlspecialchars($data['paymethod_name']); ?></p>
        </div>
    </div>
</div> -->

<div class="row">
    <div class="col-6 text-start font-header">
    <!-- <p class="mb-1">นามผู้ซื้อ: ______________________________________________________________</p>
    <p class="mb-1">ที่อยู่: ______________________________________________________________</p> -->
    <!-- </div>
</div> -->


<table class="table table-bordered" width="100%">
  <thead>
  <!-- <tr>
            <td width="20%" class="text-start"><strong>นามผู้ซื้อ:</strong></td>
            <td width="80%" class="text-start small">ชื่อสินค้า</td>
            <td width="15%" class="text-center small">จำนวน</td>
            <td width="15%" class="text-center small">ราคา / หน่วย</td>
            <td width="15%" class="text-center small">รวม</td>
        </tr> -->
  </thead>
  <tbody>
    <tr>
      <th scope="row" width="20%">นามผู้ซื้อ:</th>
      <td width="80%"></td>
      <!-- <td>Otto</td>
      <td>@mdo</td> -->
    </tr>
    <tr>
      <th scope="row">2</th>
      <td>Jacob</td>
      <td>Thornton</td>
      <td>@fat</td>
    </tr>
    <tr>
      <th scope="row">3</th>
      <td colspan="2">Larry the Bird</td>
      <td>@twitter</td>
    </tr>
  </tbody>
</table>

</div>
</div>



    <br>


<table class="table" width="100%">
    <thead>
        <tr>
            <td width="5%" class="text-center small">ที่</td>
            <td width="50%" class="text-start small">ชื่อสินค้า</td>
            <td width="15%" class="text-center small">จำนวน</td>
            <td width="15%" class="text-center small">ราคา / หน่วย</td>
            <td width="15%" class="text-center small">รวม</td>
        </tr>
    </thead>
    <tbody>
    <?php
    include("connectdb.php");

    function convert_number_to_words($number) {
        $fmt = new NumberFormatter('th', NumberFormatter::SPELLOUT);
        return $fmt->format($number);
    }

    $order_id = $_GET['b']; // รับค่า order_id จาก URL

    // ดึงข้อมูลจาก orders_detail และ products พร้อมข้อมูลจาก size
    $sql = "
    SELECT 
        od.*,
        p.name,
        s.price,
        s.size_name
    FROM orders_detail od
    INNER JOIN products p ON od.p_id = p.id
    INNER JOIN size s ON od.s_id = s.size_id
    WHERE od.order_id = '$order_id'
";
    $rs = mysqli_query($conn, $sql);
    
    $i = 0;
    $total = 0; // Initialize total

    while ($data = mysqli_fetch_array($rs, MYSQLI_BOTH)) {
        $i++;
        $sum = $data['price'] * $data['item'];
        $total += $sum;
    ?>
        <tr>
            <td class="text-center small"><?=$i;?></td>
<td class="small">
    <?=$data['name'];?>
    <br>
    <span class="text-xsmall"><?=$data['size_name'];?></span>
</td>
            <td class="text-center small"><?=$data['item'];?></td>
            <td class="text-center small"><?=number_format($data['price'], 2);?></td>
            <td class="text-center small"><?=number_format($sum, 2);?></td>
        </tr>
    <?php } ?>
    <tr>
        <td colspan="2" class="text-start small"><?= convert_number_to_words($total); ?> บาทถ้วน</td>
        <td colspan="2" class="text-center small">รวมเงินทั้งสิ้น</td>
        <td class="text-center small"><strong><?=number_format($total, 2);?></strong> บาท</td>
    </tr>
    </tbody>
</table>




      <br><br>
      <div class="row">
        <div class="col-6">
          <div class="text-start">
          </div>
          </div>

          <div class="col-6">
          <div class="text-end">
          <!-- <p>__________________________</p> -->
          <!-- <p><?=$data['emp_name'];?></td> -->
          </p>

          </div>
        </div>

        <?php
        }
    } else {
        // แสดงข้อความข้อผิดพลาดหาก Query ล้มเหลว
        echo "เกิดข้อผิดพลาดในการ Query: " . mysqli_error($conn);
    }
} else {
    // แสดงข้อความข้อผิดพลาดหากไม่มีการส่งค่า 'b' มาใน URL
    echo "ไม่มีค่า 'b' ใน URL";
}
}
// ปิดการเชื่อมต่อฐานข้อมูล
mysqli_close($conn);
?>

</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</html>