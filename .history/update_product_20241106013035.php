<?php
session_start();
include("connectdb.php");

if (empty($_SESSION['aid'])) {
  echo "<script>";
  echo "alert('Access Denied !!!');";
  echo "window.location.href='index.php';";
  echo "</script>";
  exit;
}

// ใช้งาน session
$aid = $_SESSION['aid'];
$aname = $_SESSION['aname'];
$role_id = $_SESSION['role_id'];
$role_name = $_SESSION['role_name'];
$img = $_SESSION['img'];

// ตรวจสอบว่าค่าที่เก็บใน session มีอยู่หรือไม่
if (empty($img)) {
  // กำหนดรูปภาพเริ่มต้นในกรณีที่ไม่มีรูปภาพ
  $img = 'default.jpg'; 
}

// สร้าง URL สำหรับรูปภาพ
$imagePath = "assets/images/emp/" . $aid . "." . $img;




// ตรวจสอบว่าตัวแปร $_GET['id'] ถูกกำหนดหรือไม่
if (isset($_GET['id'])) {
  $id = $_GET['id']; // เปลี่ยนจาก $emp_id เป็น $id เพื่อให้ตรงกับคำสั่ง SQL

  // สร้างคำสั่ง SQL เพื่อเชื่อมตาราง products และ size
  $sql = "SELECT products.*, size.size_name, size.qty, size.re_stock, size.price, type.type_name
          FROM products
          INNER JOIN size ON products.id = size.id
          LEFT JOIN type ON products.type_id = type.type_id
          WHERE products.id = '$id'";

$unitQuery = "SELECT unit FROM products WHERE id = '$id'";
$unitResult = mysqli_query($conn, $unitQuery);
$unitData = mysqli_fetch_assoc($unitResult);  // เก็บค่า unit แค่ครั้งเดียว

  // ดำเนินการคำสั่ง SQL
  $rs = mysqli_query($conn, $sql);

  if ($rs && mysqli_num_rows($rs) > 0) {
    $productData = mysqli_fetch_array($rs); // ดึงข้อมูลสินค้าและขนาด
    $p_type_id = $productData['type_id'];
} else {
    echo "Error in query: " . mysqli_error($conn);
}
} else {
echo "No Products available"; // แสดงข้อความเมื่อไม่พบ id ใน URL
}




if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // รับข้อมูลจากฟอร์ม
  $p_name = $_POST['p_name'];
  $product_id = $_GET['id']; // รหัสผลิตภัณฑ์จาก URL
  $unit = $_POST['unit']; // รับข้อมูลหน่วยนับ
  $size_name = $_POST['size_name']; // size_name ต้องเป็น array
  $size_qty = $_POST['size_qty']; // size_qty ต้องเป็น array
  $size_restock = $_POST['size_restock']; // size_restock ต้องเป็น array
  $size_price = $_POST['size_price']; // size_price ต้องเป็น array
  $p_type = $_POST['p_type']; // รับข้อมูลประเภทสินค้า

  // ตรวจสอบว่าค่าต่างๆ เป็นอาเรย์หรือไม่
  if (!is_array($size_name) || !is_array($size_qty) || !is_array($size_restock) || !is_array($size_price)) {
      echo "<script>alert('ค่าข้อมูลขนาดต้องเป็นอาเรย์');</script>";
      exit;
  }

  // จัดการการอัปโหลดภาพ
  $img_sql = "";
  if ($_FILES['p_pics']['name'] != "") {
      $allowed = array('gif', 'png', 'jpg', 'jpeg', 'jfif', 'webp');
      $filename = $_FILES['ep_pic']['name'];
      $ext = pathinfo($filename, PATHINFO_EXTENSION);

      // ตรวจสอบนามสกุลไฟล์
      if (!in_array($ext, $allowed)) {
          echo "<script>alert('ไฟล์ภาพต้องเป็น jpg, gif หรือ png เท่านั้น');</script>";
          exit;
      }

      // ลบภาพเก่าออก ถ้ามีภาพเก่าอยู่ในระบบ
      $old_image_path = "assets/images/Product_2/" . $product_id . "." . $ext;
      if (file_exists($old_image_path)) {
          unlink($old_image_path); // ลบไฟล์ภาพเก่า
      }

      // อัปโหลดไฟล์ภาพใหม่
      $target_file = "assets/images/Product_2/" . $product_id . "." . $ext;
      if (move_uploaded_file($_FILES['ep_pic']['tmp_name'], $target_file)) {
          // อัปเดตนามสกุลไฟล์ในฐานข้อมูล
          $img_sql = ", img='$ext'";
      } else {
          echo "<script>alert('เกิดข้อผิดพลาดในการอัปโหลดไฟล์');</script>";
          exit;
      }
  }

  // อัปเดทข้อมูลในตาราง products รวมถึงหน่วยนับ (unit)
  $sql_product = "UPDATE products SET name='$p_name', type_id='$p_type', unit='$unit' $img_sql WHERE id='$product_id'";
  mysqli_query($conn, $sql_product);

  // อัปเดทหรือเพิ่มข้อมูลในตาราง size
  for ($i = 0; $i < count($size_name); $i++) {
      $current_size_name = $size_name[$i];
      $current_qty = $size_qty[$i];
      $current_restock = $size_restock[$i];
      $current_price = $size_price[$i];

      // ตรวจสอบว่ามีขนาดนี้ในฐานข้อมูลหรือไม่
      $size_query = "SELECT size_id FROM size WHERE size_name='$current_size_name' AND id='$product_id'";
      $result = mysqli_query($conn, $size_query);

      if (mysqli_num_rows($result) > 0) {
          // ถ้ามีขนาดอยู่แล้ว อัปเดท
          $size_id = mysqli_fetch_assoc($result)['size_id'];
          $update_size = "UPDATE size SET qty='$current_qty', re_stock='$current_restock', price='$current_price' WHERE size_id='$size_id'";
          mysqli_query($conn, $update_size);
      } else {
          // ถ้าไม่มีขนาดนี้ เพิ่มขนาดใหม่
          $insert_size = "INSERT INTO size (id, size_name, qty, re_stock, price) VALUES ('$product_id', '$current_size_name', '$current_qty', '$current_restock', '$current_price')";
          mysqli_query($conn, $insert_size);
      }
  }

  // แสดงข้อความยืนยันหลังการอัปเดตข้อมูลสำเร็จ
  echo "<script>
  alert('อัปเดตข้อมูลสำเร็จ');
  window.location.href = 'products_manage.php'; // เปลี่ยนไปยังหน้ารายการผลิตภัณฑ์
  </script>";
}






?>






<!DOCTYPE html>
<html lang="en">
<!-- [Head] start -->

<head>
  <title>POS | Point of Sale</title>
  <!-- [Meta] -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="description" content="Gradient Able is trending dashboard template made using Bootstrap 5 design framework. Gradient Able is available in Bootstrap, React, CodeIgniter, Angular,  and .net Technologies.">
  <meta name="keywords" content="Bootstrap admin template, Dashboard UI Kit, Dashboard Template, Backend Panel, react dashboard, angular dashboard">
  <meta name="author" content="codedthemes">


<!-- [Template CSS Files] -->
<link rel="stylesheet" href="assets/css/style.css" id="main-style-link" >
<link rel="stylesheet" href="assets/css/style-preset.css" >

<!-- Google Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Thai+Looped:wght@500&display=swap" rel="stylesheet">

  <!-- Phosphor Icons CSS -->
  <link href="https://unpkg.com/phosphor-icons/css/phosphor.css" rel="stylesheet">
  <!-- <link rel="stylesheet" type="text/css" href="style.css"> -->

  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">

<!-- Script -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>


  <!-- Add jQuery library -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    $(document).ready(function() {
      // Function to fetch and display products
      function fetchProducts(query) {
        $.ajax({
          url: "fetch_products2.php",
          method: "POST",
          data: { query: query },
          success: function(data) {
            $("#product-list").html(data);
          }
        });
      }

      // Event listener for input in search box
      $(".search-input").on("input", function() {
        var query = $(this).val();
        fetchProducts(query);
      });
    });

        
  </script>



<style>
body {
  font-family: "IBM Plex Sans Thai Looped", sans-serif;
}

.fixed-col {
  position: fixed;
  top: 70px; /* เพิ่ม px */
  right: 0;
  width: 25%;
  height: 100%;
  background-color: #f8f9fa;
  overflow-y: auto;
  padding: 1rem;
  padding-bottom: 5rem; /* เพิ่ม padding ที่ด้านล่าง */
}

.fixed-col h1 {
  font-size: 1rem;
  color: black;
}

    /*
*
* ==========================================
* CUSTOM UTIL CLASSES
* ==========================================
*
*/

.form-control:focus {
  box-shadow: none;
}

.form-control-underlined {
  border-width: 0;
  border-bottom-width: 0px;
  border-radius: 0;
  padding-left: 0;
  padding-top: 5px;
}

/*
*
* ==========================================
* FOR DEMO PURPOSE
* ==========================================
*
*/


.form-control::placeholder {
  font-size: 0.95rem;
  color: #aaa;
  font-style: italic;
}


.pc-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
}

.search-form {
  flex: 1;
  display: flex;
  justify-content: center;
  margin: 5px 5px 5px 5px; /* เพิ่ม margin ด้านบน ด้านซ้ายและขวา */
}

.search-input {
  width: 100%;
  max-width: 600px; /* กำหนดขนาดสูงสุดตามที่คุณต้องการ */
  padding: 0.5em;
  /* padding-top: 5px; */
  border: 1px solid #ccc;
  border-radius: 4px;
}

.pc-link {
    font-weight: normal;
    text-decoration: none;
}

.pc-link.active {
    font-weight: bold;
}

.pic{
  height: 300px;
  width: 250px;
  display: block;
  margin-left: auto;
  margin-right: auto
}


.custom-input {
            display: none;
        }

  </style>

<link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">

</head>
<!-- [Head] end -->
<!-- [Body] Start -->

<body data-pc-header="header-1" data-pc-preset="preset-1" data-pc-sidebar-theme="light" data-pc-sidebar-caption="true" data-pc-direction="ltr" data-pc-theme="light">
  <!-- [ Pre-loader ] start -->
<div class="loader-bg">
  <div class="loader-track">
    <div class="loader-fill"></div>
  </div>
</div>
<!-- [ Pre-loader ] End -->
<!-- [ Sidebar Menu ] start -->
<nav class="pc-sidebar">
  <div class="navbar-wrapper">
    <div class="m-header">
      <a href="dashboard/index.html" class="b-brand text-primary">
        <!-- ========   Change your logo from here   ============ -->
        <img src="assets/images/logo-white.svg" alt="logo image" class="logo-lg">
      </a>
    </div>
    <div class="navbar-content">
      <ul class="pc-navbar">

      <?php if ($role_name == 'admin') : ?>
      <li class="pc-item">
          <a href="dashboard.php" class="pc-link">
            <span class="pc-micon"><i class="ph ph-gauge"></i></span>
            <span class="pc-mtext">Dashboard</span>
          </a>
        </li>
        <?php endif; ?>


        <li class="pc-item pc-hasmenu">
          <a href="#!" class="pc-link"
            ><span class="pc-micon">
            <i class="ph ph-basket"></i> </span
            ><span class="pc-mtext">หน้าร้าน</span><span class="pc-arrow"><i data-feather="chevron-right"></i></span
          ></a>

          <ul class="pc-submenu">
    <li class="pc-item">
        <a class="pc-link <?= ($_SERVER['PHP_SELF'] == '/sale.php' ? 'active' : '') ?>" href="sale.php">หน้าขาย</a>
    </li>
    <li class="pc-item">
        <a class="pc-link <?= ($_SERVER['PHP_SELF'] == '/sale_history.php' ? 'active' : '') ?>" href="sale_history.php">ประวัติการขาย</a>
    </li>
</ul>


        </li>

        <!-- <li class="pc-item pc-hasmenu">
          <a href="#!" class="pc-link"
            ><span class="pc-micon">
            <i class="ph ph-folder"></i> </span>
            <span class="pc-mtext">เอกสาร/รายงาน</span><span class="pc-arrow"><i data-feather="chevron-right"></i></span
          ></a>
          <ul class="pc-submenu">
            <li class="pc-item"><a class="pc-link" href="#!">แดชบอร์ด</a></li>
            <li class="pc-item"><a class="pc-link" href="#!">เอกสาร</a></li>
            <li class="pc-item"><a class="pc-link" href="#!">ประวัติการขาย</a></li>
          </ul>
        </li> -->

        <li class="pc-item pc-hasmenu">
          <a href="#!" class="pc-link"
            ><span class="pc-micon">
            <i class="ph ph-package"></i> </span>
            <span class="pc-mtext">สินค้า</span><span class="pc-arrow"><i data-feather="chevron-right"></i></span
          ></a>

          <ul class="pc-submenu">
    <li class="pc-item">
        <a class="pc-link <?= ($_SERVER['PHP_SELF'] == '/products_list.php' ? 'active' : '') ?>" href="products_list.php">รายการสินค้า</a>
    </li>

    <?php if ($role_name == 'admin') : ?>
    <li class="pc-item">
        <a class="pc-link <?= ($_SERVER['PHP_SELF'] == 'products_manage.php' ? 'active' : '') ?>" href="products_manage.php">จัดการรายการสินค้า</a>
    </li>
    <?php endif; ?>

</ul>
        </li>


        <?php if ($role_name == 'admin') : ?>
        <li class="pc-item pc-hasmenu">
          <a href="#!" class="pc-link"
            ><span class="pc-micon">
            <i class="ph ph-users"></i> </span>
            <span class="pc-mtext">การจัดการ</span><span class="pc-arrow"><i data-feather="chevron-right"></i></span
          ></a>

          <ul class="pc-submenu">
    <li class="pc-item">
        <a class="pc-link <?= ($_SERVER['PHP_SELF'] == '/employee_list.php' ? 'active' : '') ?>" href="employee_list.php">พนักงาน</a>
    </li>
    <!-- <li class="pc-item">
        <a class="pc-link <?= ($_SERVER['PHP_SELF'] == '/sample-page2.php' ? 'active' : '') ?>" href="sale_history.php">ประวัติการขาย</a>
    </li> -->
</ul>
        </li>
        <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</nav>
<!-- [ Sidebar Menu ] end -->

<!-- [ Header Topbar ] start -->

<header class="pc-header">
  <div class="m-header">
    <a href="sale.php" class="b-brand text-primary">
      <img src="assets/images/logo/logo.png" alt="logo image" class="logo-lg" height="45">
    </a>
  </div>

  <div class="header-wrapper">
    <div class="me-auto pc-mob-drp">
      <ul class="list-unstyled">
        <li class="pc-h-item pc-sidebar-popup">
          <a href="#" class="pc-head-link ms-0" id="mobile-collapse">
            <i class="ph ph-list"></i>
          </a>
        </li>
      </ul>
    </div>

    <!-- เพิ่ม form control ตรงนี้ -->
    <!-- <form method="post" class="search-form" onsubmit="return false;">
      <input type="text" name="src" placeholder="ค้นหาสินค้า" class="search-input" autofocus>
      <a class="btn btn-primary"><i class="ph ph-magnifying-glass"></i></a>
    </form> -->

    <div class="ms-auto">
      <h7 id="clock" class="text-white text-center">00:00:00</h7>
      <ul class="list-unstyled">
        <li class="dropdown pc-h-item header-user-profile">
          <h8>|</h8>
          <h8 class="text-white text-center" id="date"></h8>
          <a class="pc-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown" href="#" role="button"
            aria-haspopup="false" data-bs-auto-close="outside" aria-expanded="false">
            <img src="<?php echo $imagePath; ?>" alt="user-image" class="user-avtar" style="height: 40px">
          </a>
          <div class="dropdown-menu dropdown-user-profile dropdown-menu-end pc-h-dropdown">
            <div class="dropdown-body">
              <div class="profile-notification-scroll position-relative" style="max-height: calc(100vh - 225px)">
                <ul class="list-group list-group-flush w-100">
                  <li class="list-group-item">
                    <a href="https://codedthemes.com/item/gradient-able-admin-template/" class="dropdown-item">
                      <span class="d-flex align-items-center">
                        <i class="ph ph-arrow-circle-down"></i>
                        <span>Download</span>
                      </span>
                    </a>
                  </li>
                  <li class="list-group-item">
                    <a href="#" class="dropdown-item">
                      <span class="d-flex align-items-center">
                        <i class="ph ph-user-circle"></i>
                        <span>Edit profile</span>
                      </span>
                    </a>
                    <a href="#" class="dropdown-item">
                      <span class="d-flex align-items-center">
                        <i class="ph ph-bell"></i>
                        <span>Notifications</span>
                      </span>
                    </a>
                    <a href="#" class="dropdown-item">
                      <span class="d-flex align-items-center">
                        <i class="ph ph-gear-six"></i>
                        <span>Settings</span>
                      </span>
                    </a>
                  </li>
                  <li class="list-group-item">
                    <a href="#" class="dropdown-item">
                      <span class="d-flex align-items-center">
                        <i class="ph ph-plus-circle"></i>
                        <span>Add account</span>
                      </span>
                    </a>
                    <a href="#" class="dropdown-item">
                      <span class="d-flex align-items-center">
                        <i class="ph ph-power"></i>
                        <span>Logout</span>
                      </span>
                    </a>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </li>
      </ul>
    </div> 
  </div>
</header>
<!-- [ Header ] end -->

<div class="col-12 col-sm-8 col-md-12">
  <div class="pc-container px-1">
  <form method="post" enctype="multipart/form-data">
    <div class="pc-content">
      <?php if (isset($productData)) { ?>
        <div class="row">
          <div class="col-md-12">
            <div class="page-header-title border-bottom pb-2 mb-2 d-flex align-items-center">
              <a href="products_manage.php" class="breadcrumb-item me-2">
                <i class="ph ph-arrow-left fs-3"></i>
              </a>
              <h4 class="mb-0">แก้ไขข้อมูลสินค้า</h4>
    </div>
</div>

<div class="col-md-4">
  <div class="card">
    <div class="card-body pc-component">
      <p class="lead m-t-0">รูปภาพ</p>
      <div class="pic">
        <img src="assets/images/products_2/<?=$productData['id'];?>.<?=$productData['img'];?>" class="card-img-top rounded mx-auto d-block" alt="">
      </div>
      <br><br><br>
      <div class="col">
        <label for="formFile" class="form-label">เปลี่ยนรูปภาพ</label>
        <input class="form-control" type="file" name="p_pics">
        <br>
        <h6 class="card-subtitle fw-normal mb-4">สำคัญ : สามารถอัพโหลดรูปภาพเฉพาะไฟล์ png, jpg, gif, tfif และ webp</h6>
      </div>
    </div>
  </div>
</div>


<div class="col-md-8">
  <div class="card">
    <div class="card-header">
      <div class="row align-items-center">
        <div class="col-2">
          <h5 class="mb-0">รหัสสินค้า</h5>
        </div>
        <div class="col-10">
          <input class="form-control" type="text" name="ep_id" placeholder="<?= $productData['id']; ?>" aria-label="Disabled input example" disabled>              
        </div>          
      </div>
    </div>
    <div class="card-body pc-component">
      <div class="row align-items-center">
        <div class="col-2">
          <p class="text-dark mb-0">เลขที่บาร์โค้ด</p>
        </div>
        <div class="col-10">
          <input id="barcodeInput" name="barcode" type="text" class="form-control" value="<?= $productData['barcode']; ?>" aria-label="Disabled input example" disabled> 
        </div> 
      </div>
      <div id="barcodeMessage"></div>
      <br>
      <div class="row align-items-center">
        <div class="col-2">
          <p class="text-dark mb-0">ชื่อสินค้า</p>
        </div>
        <div class="col-10">
          <input name="p_name" type="text" class="form-control" value="<?= $productData['name']; ?>"> 
        </div>          
      </div>
      <br>
    
    </div>
    </div>


    <div class="card">
    <div class="card-header">
      <div class="row align-items-center">
        <div class="col-2">
          <h5 class="mb-0">ขนาด</h5>
        </div>

      </div>
    </div>

    <div class="card-body pc-component">
  <div class="row align-items-center">
    <?php do { ?>
      <div class="row mb-3">
        <div class="col-3">
          <div class="form-floating">
            <input type="text" name="size_name[]" class="form-control" id="size_name" placeholder="ชื่อขนาด" value="<?= htmlspecialchars($productData['size_name']); ?>" required>
            <label for="size_name">ชื่อขนาด</label>
          </div>
        </div>
        <div class="col-2">
          <div class="form-floating">
            <input type="number" name="size_qty[]" class="form-control" id="size_qty" placeholder="จำนวน" value="<?= htmlspecialchars($productData['qty']); ?>" required>
            <label for="size_qty">จำนวน</label>
          </div>
        </div>
        <div class="col-2">
          <div class="form-floating">
            <input type="number" name="size_restock[]" class="form-control" id="size_restock" placeholder="จุดรีสต๊อก" value="<?= htmlspecialchars($productData['re_stock']); ?>" required>
            <label for="size_restock">จุดรีสต๊อก</label>
          </div>
        </div>
        <div class="col-3">
          <div class="form-floating">
            <input type="text" name="size_price[]" class="form-control" id="size_price" placeholder="ราคารวมภาษี" value="<?= htmlspecialchars($productData['price']); ?>" required>
            <label for="size_price">ราคารวมภาษี</label>
          </div>
        </div>
      </div>
    <?php } while ($productData = mysqli_fetch_array($rs)); ?>

    <div class="col-md">
      <div id="sizeContainer"></div>
      <button type="button" class="btn btn-secondary mt-2" onclick="addSize()">เพิ่มขนาดสินค้า</button>
    </div>
  </div>
</div>


    
    </div>


<br>


    
    
<div class="card">
  <div class="card-header">
    <!-- Start Section: หน่วยนับ และ หมวดหมู่ -->
    <div class="row align-items-center text-start">
      
      <!-- หน่วยนับ -->
      <div class="col-2">
        <p class="text-dark mb-0">หน่วยนับ</p>
      </div>
      <div class="col-10">
        <input name="ep_user" type="text" class="form-control" value="<?= htmlspecialchars($unitData['unit']); ?>"> 
      </div>

      <!-- หมวดหมู่ -->
      <div class="col-2 mt-3">
        <p class="text-dark mb-0">หมวดหมู่</p>
      </div>
      <div class="col-10 mt-3">
        <select class="form-select" id="role" aria-label="role" name="p_type" onchange="toggleOtherInput()">
          <?php
            // ดึงข้อมูลหมวดหมู่จากตาราง type
            $sql2 = "SELECT * FROM `type`";
            $rs2 = mysqli_query($conn, $sql2);
            if ($rs2) {
              while ($data2 = mysqli_fetch_array($rs2)) {
                // ตั้งค่า selected ถ้า type_id ตรงกับ type_id ของสินค้า
                $selected = ($data2['type_id'] == $p_type_id) ? "selected" : "";
                echo "<option value='{$data2['type_id']}' $selected>{$data2['type_name']}</option>";
              }
            } else {
              echo "<option>ไม่สามารถดึงข้อมูลได้</option>";
            }
          ?>
          <!-- <option value="">ไม่ระบุ</option> -->
          <option value="other">อื่นๆ</option>
        </select>
        
        <!-- ช่องกรอกข้อมูลสำหรับ "อื่นๆ" -->
        <input type="text" class="form-control mt-2" id="otherInput" name="other_role" placeholder="กรุณากรอกหมวดหมู่" style="display: none;">
      </div>

    </div>
    <!-- End Section: หน่วยนับ และ หมวดหมู่ -->
  </div>

  <div class="card-body pc-component">
    <!-- ใส่ข้อมูลอื่นๆของสินค้า -->
  </div>
</div>

      <div class="d-grid gap-2 d-md-flex justify-content-md-end">
        <button type="submit" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">บันทึกข้อมูล</button>
      </div>
    </div>
  </div>
</div>

<?php } else  { ?>
  <p>No product data found.</p>
  <?php } ?>
</form>
</div>
</div>

  <!-- [ Main Content ] end -->
  <footer class="pc-footer">
    <div class="footer-wrapper container-fluid">
      <div class="row">
        <div class="col-sm-6 ms-auto my-1">
          <ul class="list-inline footer-link mb-0 justify-content-sm-end d-flex">
          <!-- <a href="#top" class="text-end">กลับไปบนสุด</a> -->
          </ul>
        </div>
      </div>
    </div>
  </footer>


  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css">

  <!-- Required Js -->
<script src="assets/js/plugins/popper.min.js"></script>
<script src="assets/js/plugins/simplebar.min.js"></script>
<script src="assets/js/plugins/bootstrap.min.js"></script>
<script src="assets/js/fonts/custom-font.js"></script>
<script src="assets/js/pcoded.js"></script>
<script src="assets/js/plugins/feather.min.js"></script>
<script>layout_change('light');</script>
<script>layout_sidebar_change('light');</script>
<script>change_box_container('false');</script>
<script>layout_caption_change('true');</script>
<script>layout_rtl_change('false');</script>
<script>preset_change("preset-1");</script>
<script>header_change("header-1");</script>




<script>
$(document).ready(function() {
setInterval(function() {
var date = new Date();
var hours = date.getHours();
var minutes = date.getMinutes();
var seconds = date.getSeconds();
var secondsString = seconds.toString();
if (secondsString.length === 1) {
  secondsString = "0" + secondsString;
}
  var minutesString = minutes.toString();
if (minutesString.length === 1) {
  minutesString = "0" + minutesString;
}

$("#clock").html(hours + ":" + minutesString + ":" + secondsString);
}, 1000);
});
moment.locale('th');
document.getElementById('date').innerHTML = moment().format('dddd D MMMM YYYY');


document.addEventListener('DOMContentLoaded', function() {
  var modal = document.getElementById('exampleModal');
  modal.addEventListener('show.bs.modal', function (event) {
    var button = event.relatedTarget; // Button that triggered the modal
    var productName = button.getAttribute('data-name'); // Extract info from data-* attributes

    var modalTitle = modal.querySelector('.modal-title');
    modalTitle.textContent = productName; // Update the modal's title with the product name
  });
});

document.getElementById('okButton').addEventListener('click', function() {
  window.location.href = 'employee_list.php';
});




function addSize() {
  // ค้นหา container ที่ต้องการเพิ่มแถวใหม่
  const container = document.getElementById("sizeContainer");

  // สร้างโครงสร้างแถวใหม่เหมือนกับโครงสร้างเดิม
  const row = document.createElement("div");
  row.className = "row mb-3 align-items-center";

  // สร้าง input ขนาด
  row.innerHTML = `
    <div class="col-3">
      <div class="form-floating">
        <input type="text" name="size_name[]" class="form-control" placeholder="ชื่อขนาด" required>
        <label for="size_name">ชื่อขนาด</label>
      </div>
    </div>
    <div class="col-2">
      <div class="form-floating">
        <input type="number" name="size_qty[]" class="form-control" placeholder="จำนวน" required>
        <label for="size_qty">จำนวน</label>
      </div>
    </div>
    <div class="col-2">
      <div class="form-floating">
        <input type="number" name="size_restock[]" class="form-control" placeholder="จุดรีสต๊อก" required>
        <label for="size_restock">จุดรีสต๊อก</label>
      </div>
    </div>
    <div class="col-3">
      <div class="form-floating">
        <input type="text" name="size_price[]" class="form-control" placeholder="ราคารวมภาษี" required>
        <label for="size_price">ราคารวมภาษี</label>
      </div>
    </div>
    <div class="col-2 d-flex align-items-center justify-content-center">
      <button type="button" class="btn btn-danger form-control remove-row">
        <i class="ph ph-trash"></i>
      </button>
    </div>
  `;

  // เพิ่ม row ใหม่ลงใน container
  container.appendChild(row);

  // ตั้งค่า event listener สำหรับปุ่มลบ
  row.querySelector('.remove-row').addEventListener('click', function() {
    row.remove();
  });
}






function toggleOtherInput() {
    var select = document.getElementById("role");
    var otherInput = document.getElementById("otherInput");

    if (select.value === "other") {
        otherInput.style.display = "block";  // แสดงช่องกรอกข้อมูล
        otherInput.required = true; // ตั้งค่าให้เป็น required หากเลือก "อื่นๆ"
    } else {
        otherInput.style.display = "none";  // ซ่อนช่องกรอกข้อมูล
        otherInput.required = false; // ยกเลิก required หากไม่ได้เลือก "อื่นๆ"
    }
}



// ฟังก์ชันสำหรับใส่คอมม่าคั่นหลักพัน
function formatNumber(input) {
    let value = input.value.replace(/,/g, ''); // ลบคอมม่าก่อน
    if (!isNaN(value) && value !== '') {
        input.value = Number(value).toLocaleString('en'); // ใส่คอมม่าคั่นตัวเลขใหม่
    } else {
        input.value = ''; // ถ้าไม่ใช่ตัวเลข, รีเซ็ตเป็นค่าว่าง
    }
}




// function toggleStatus(switchElement) {
//     // ตรวจสอบสถานะที่ถูกเปลี่ยน
//     const newStatus = switchElement.checked ? 'active' : 'inactive';

//     // ส่งคำขอ AJAX เพื่อเปลี่ยนสถานะในฐานข้อมูล
//     fetch('update_status.php', {
//         method: 'POST',
//         body: JSON.stringify({ id: <?php echo $id; ?>, status: newStatus }),
//         headers: {
//             'Content-Type': 'application/json'
//         }
//     })
//     .then(response => response.json())
//     .then(data => {
//         if (data.success) {
//             // อัปเดตข้อความใน label ตามสถานะใหม่
//             const label = document.querySelector('label[for="statusSwitch"]');
//             label.textContent = newStatus === 'active' ? 'เปิดขาย' : 'ปิดการขาย';
//         } else {
//             alert('ไม่สามารถเปลี่ยนสถานะได้: ' + data.message);
//             // หากไม่สามารถเปลี่ยนสถานะได้ ให้คืนค่า switch กลับไป
//             switchElement.checked = !switchElement.checked; // คืนค่าสวิตช์กลับ
//         }
//     })
//     .catch(error => console.error('Error:', error));
// }










</script>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

</body>

</body>
<!-- [Body] end -->

</html>