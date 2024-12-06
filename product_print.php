<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>รายการสินค้า</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Sarabun&display=swap" rel="stylesheet">

<style>

    body {
        font-family: "Sarabun", serif;
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


<?php
    include("connectdb.php");

    // Prepare SQL query
    $sql = "SELECT 
        products.id AS id, 
        products.name AS name, 
        type.type_name AS type_name,
        size.size_name, 
        size.qty, 
        size.price,
        size.re_stock,
        CASE 
            WHEN size.qty > re_stock THEN 'พร้อมขาย'
            WHEN size.qty > 0 AND size.qty <= re_stock THEN 'ใกล้หมด'
            ELSE 'สินค้าหมด'
        END AS status
    FROM 
        size
    JOIN 
        products ON size.id = products.id
    JOIN 
        type ON products.type_id = type.type_id
    ORDER BY 
        products.id, size.size_name";


    // Prepare and execute the query
    if ($stmt = mysqli_prepare($conn, $sql)) {
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);

    //   if ($result) {
    //       $current_product_id = null;

    //       while ($data = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
    //           // Determine status class
    //           $status_class = '';
    //           if ($data['status'] == 'พร้อมขาย') {
    //               $status_class = 'badge bg-success';
    //           } elseif ($data['status'] == 'ใกล้หมด') {
    //               $status_class = 'badge bg-warning';
    //           } else {
    //               $status_class = 'badge bg-danger';
    //           }

              // Check if we need to start a new product row
            //   if ($data['id'] != $current_product_id) {
            //       // If we were displaying a product, close its row
            //       if ($current_product_id !== null) {
            //           echo '</tr>';
            //       }

                  // Start a new product row
                //   $current_product_id = $data['id'];

                  // Output the product row
                  ?>



<div class="row">
    <div class="col-7">
        <h5 class="text-start">บริษัท <?= htmlspecialchars($data['com_name']); ?></h5>
    </div>
    <div class="col-5">
        <h5 class="text-end"><strong>ใบเสร็จรับเงิน / Receipt</strong></h5>
    </div>
</div>

<div class="row">
    <div class="col-8">
        <div class="text-start font-header">
            <p class="mb-1">ที่อยู่: 
            <?= htmlspecialchars($data['add_no']) . ' ' . htmlspecialchars($data['add_subdis']) . ' ' . htmlspecialchars($data['add_dis']) . ' ' . htmlspecialchars($data['add_pro']) . ' ' . htmlspecialchars($data['add_zip']); ?>
            </p>
            <p class="mb-1">เบอร์โทร: <?= htmlspecialchars($data['com_phone']); ?></p>
        </div>
    </div>
    <div class="col-4">
        <div class="text-end font-header"><p>วันที่ <?= htmlspecialchars($formattedDate); ?></p></div>
    </div>
</div>

<br>

<div class="row">
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
</div>

<div class="row">
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
    // } else {
    //     // แสดงข้อความข้อผิดพลาดหาก Query ล้มเหลว
    //     echo "เกิดข้อผิดพลาดในการ Query: " . mysqli_error($conn);
    // }
// } else {
//     // แสดงข้อความข้อผิดพลาดหากไม่มีการส่งค่า 'b' มาใน URL
//     echo "ไม่มีค่า 'b' ใน URL";
// }
// }
// ปิดการเชื่อมต่อฐานข้อมูล
mysqli_close($conn);
?>

</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</html>