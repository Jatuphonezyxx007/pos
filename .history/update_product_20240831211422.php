<?php
// error_reporting(E_NOTICE);
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
  $sql = "SELECT products.*, size.*
          FROM products
          INNER JOIN size ON products.id = size.id
          WHERE products.id = '$id'";

  // ดำเนินการคำสั่ง SQL
  $rs = mysqli_query($conn, $sql);

  if ($rs) {
      $data = mysqli_fetch_array($rs); // ดึงข้อมูลที่ได้จากการ query
  } else {
      echo "Error in query: " . mysqli_error($conn); // แสดงข้อความข้อผิดพลาดหาก query ไม่สำเร็จ
  }
} else {
  echo "No Products available"; // แสดงข้อความเมื่อไม่พบ id ใน URL
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $emp_name = $_POST['ep_name'];
  $emp_user = $_POST['ep_user'];
  $emp_pwd = md5($_POST['ep_pwd']);  
  // แปลงรหัสผ่านเป็น MD5
  $emp_email = $_POST['ep_email'];
  $emp_phone = $_POST['ep_phone'];
  $role_id = $_POST['ep_role'];
  $com_id = $data['com_id']; // Assuming com_id is already set and should not be changed

  $img_sql = "";
  if($_FILES['ep_pic']['name'] != ""){
    $allowed = array('gif', 'png', 'jpg', 'jpeg', 'jfif', 'webp');
    $filename = $_FILES['ep_pic']['name'];
    $ext = pathinfo($filename, PATHINFO_EXTENSION);

    if (!in_array($ext, $allowed)) {
      echo "<script>";
      echo "alert('แก้ไขข้อมูลสินค้าไม่สำเร็จ! ไฟล์รูปต้องเป็น jpg gif หรือ png เท่านั้น');";
      echo "</script>";
      exit;
    } 
    $target_file = "assets/images/emp/" . $emp_id . "." . $ext;
    if(move_uploaded_file($_FILES['ep_pic']['tmp_name'], $target_file)) {
      $img_sql = ", img='$ext'";
    } else {
      echo "Error uploading file.";
      exit;
    }
  }

  $sql = "UPDATE employees SET 
      emp_name='$emp_name', 
      emp_user='$emp_user', 
      emp_pwd='$emp_pwd', 
      emp_email='$emp_email', 
      emp_phone='$emp_phone', 
      role_id='$role_id'
      $img_sql
  WHERE emp_id='$emp_id'";

  if (mysqli_query($conn, $sql)) {
      echo "<script>";
      echo "document.addEventListener('DOMContentLoaded', function() {";
      echo "  var myModal = new bootstrap.Modal(document.getElementById('exampleModal'), {});";
      echo "document.getElementById('modalMessage').innerHTML = '<div class=\"d-flex justify-content-center align-items-center\" style=\"height: 100px;\"><div class=\"text-center\"><div class=\"spinner-border text-success\" role=\"status\" id=\"spinner\"><span class=\"visually-hidden\">Loading...</span></div><div class=\"mt-2\">กำลังบันทึกข้อมูล</div></div></div>';";
      echo "  myModal.show();";
      echo "  setTimeout(function() {";
      echo "    document.getElementById('modalMessage').innerHTML = '<div class=\"d-flex justify-content-center align-items-center\" style=\"height: 100px;\"><div class=\"text-success\"><i class=\"bi bi-check-circle-fill\"></i> ข้อมูลถูกอัปเดตเรียบร้อยแล้ว</div></div>';";
      echo "    setTimeout(function() {";
      echo "      window.location.href = 'employee_list.php';";
      echo "    }, 1000);"; // เปลี่ยน 1000 ให้เป็นเวลาที่ต้องการในมิลลิวินาที
      echo "  }, 2000);"; // เปลี่ยน 2000 ให้เป็นเวลาที่ต้องการในมิลลิวินาที
      echo "});";
      echo "</script>";
  } else {
      echo "Error updating record: " . mysqli_error($conn);
  }
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



        <li class="pc-item pc-caption">
            <label>UI Components</label>
            <i class="ph ph-compass-tool"></i>
        </li>
        <li class="pc-item">
          <a href="elements/bc_typography.html" class="pc-link">
            <span class="pc-micon"><i class="ph ph-text-aa"></i></span>
            <span class="pc-mtext">Typography</span>
          </a>
        </li>
        <li class="pc-item">
          <a href="elements/bc_color.html" class="pc-link">
            <span class="pc-micon"><i class="ph ph-palette"></i></span>
            <span class="pc-mtext">Color</span>
          </a>
        </li>
        <li class="pc-item">
          <a href="elements/icon-feather.html" class="pc-link">
            <span class="pc-micon"><i class="ph ph-flower-lotus"></i></span>
            <span class="pc-mtext">Icons</span>
          </a>
        </li>


        <li class="pc-item pc-caption">
          <label>Pages</label>
          <i class="ph ph-devices"></i>
        </li>
        <li class="pc-item">
          <a href="pages/login-v1.html" class="pc-link">
            <span class="pc-micon"><i class="ph ph-lock"></i></span>
            <span class="pc-mtext">Login</span>
          </a>
        </li>
        <li class="pc-item">
          <a href="pages/register-v1.html" class="pc-link">
            <span class="pc-micon"><i class="ph ph-user-circle-plus"></i></span>
            <span class="pc-mtext">Register</span>
          </a>
        </li>
        <li class="pc-item pc-caption">
          <label>Other</label>
          <i class="ph ph-suitcase"></i>
        </li>
        <li class="pc-item pc-hasmenu">
          <a href="#!" class="pc-link"
            ><span class="pc-micon">
              <i class="ph ph-tree-structure"></i> </span
            ><span class="pc-mtext">Menu levels</span><span class="pc-arrow"><i data-feather="chevron-right"></i></span
          ></a>
          <ul class="pc-submenu">
            <li class="pc-item"><a class="pc-link" href="#!">Level 2.1</a></li>
            <li class="pc-item pc-hasmenu">
              <a href="#!" class="pc-link"
                >Level 2.2<span class="pc-arrow"><i data-feather="chevron-right"></i></span
              ></a>
              <ul class="pc-submenu">
                <li class="pc-item"><a class="pc-link" href="#!">Level 3.1</a></li>
                <li class="pc-item"><a class="pc-link" href="#!">Level 3.2</a></li>
                <li class="pc-item pc-hasmenu">
                  <a href="#!" class="pc-link"
                    >Level 3.3<span class="pc-arrow"><i data-feather="chevron-right"></i></span
                  ></a>
                  <ul class="pc-submenu">
                    <li class="pc-item"><a class="pc-link" href="#!">Level 4.1</a></li>
                    <li class="pc-item"><a class="pc-link" href="#!">Level 4.2</a></li>
                  </ul>
                </li>
              </ul>
            </li>
            <li class="pc-item pc-hasmenu">
              <a href="#!" class="pc-link"
                >Level 2.3<span class="pc-arrow"><i data-feather="chevron-right"></i></span
              ></a>
              <ul class="pc-submenu">
                <li class="pc-item"><a class="pc-link" href="#!">Level 3.1</a></li>
                <li class="pc-item"><a class="pc-link" href="#!">Level 3.2</a></li>
                <li class="pc-item pc-hasmenu">
                  <a href="#!" class="pc-link"
                    >Level 3.3<span class="pc-arrow"><i data-feather="chevron-right"></i></span
                  ></a>
                  <ul class="pc-submenu">
                    <li class="pc-item"><a class="pc-link" href="#!">Level 4.1</a></li>
                    <li class="pc-item"><a class="pc-link" href="#!">Level 4.2</a></li>
                  </ul>
                </li>
              </ul>
            </li>
          </ul>
        </li>
        <li class="pc-item"
          ><a href="other/sample-page.html" class="pc-link">
            <span class="pc-micon">
              <i class="ph ph-desktop"></i>
            </span>
            <span class="pc-mtext">Sample page</span></a
          ></li
        >

      </ul>
      <div class="card nav-action-card bg-brand-color-9">
        <div class="card-body" style="background-image: url('assets/images/layout/nav-card-bg.svg')">

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
      <img src="assets/images/logo/logo_homeware.png" alt="logo image" class="logo-lg" height="45">
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
      

    <?php if (isset($data)) { ?>

      <div class="row">

      <h5 class="card-title fw-semibold mb-4">แก้ไขขข้อมูลสินค้า</h5>


      <div class="col-md-6">
          <div class="card">
            <!-- <div class="card-header">
              <h5>Inline Text Elements</h5>
            </div> -->
            <div class="card-body pc-component">
              <p class="lead m-t-0">รูปภาพ</p>

              <div class="pic">
                        <img src="assets/images/products_2/<?=$data['id'];?>.<?=$data['img'];?>" class="card-img-top rounded mx-auto d-block" alt="">
                      </div>

                      <br><br><br>

                      <div class="col">
                        <label for="formFile" class="form-label">เปลี่ยนรูปภาพ</label>
                        <input class="form-control" type="file" name="ep_pic">
                        <br>
                        <h6 class="card-subtitle fw-normal mb-4">สำคัญ : สามารถอัพโหลดรูปภาพเฉพาะไฟล์ png, jpg, gif, tfif และ webp</h6>
                      </div>


            </div>
          </div>
        </div>

        
        <div class="col-md-6">
          <div class="card">
            
          <div class="card-header">
            <div class="row align-items-center">
              <div class="col-3">
                <h5 class="mb-0">รหัสสินค้า</h5>
              </div>
              <div class="col-9">
              <input class="form-control" type="text" name="ep_id" placeholder="<?= $data['id']; ?>" aria-label="Disabled input example" disabled>              
            </div>          
            </div>
          </div>

            <div class="card-body pc-component">

              <div class="row align-items-center">
              <div class="col-3">
                <p class="text-dark mb-0">เลขที่บาร์โค้ด</p>
              </div>
              <div class="col-6">
                <input name="ep_name" type="text" class="form-control" value="<?= $data['barcode']; ?>"> 
              </div> 

              <div class="col-3">
              <a href="#" type="button" class="btn btn-success w-100">ตรวจสอบ</a>
              </div>                   
            </div>

            <br>
            <div class="row align-items-center">
              <div class="col-3">
                <p class="text-dark mb-0">ชื่อสินค้า</p>
              </div>
              <div class="col-9">
                <input name="ep_email" type="text" class="form-control" value="<?= $data['name']; ?>"> 
              </div>          
            </div>
            
            <br>
            <div class="row align-items-center">
              <div class="col-3">
                <p class="text-dark mb-0">ขนาด</p>
              </div>
              <div class="col-3">
              <button type="button" class="btn btn-outline-secondary">Secondary</button>
              </div>
              <div class="col-3">
              <button type="button" class="btn btn-outline-secondary">Secondary</button>
              </div>          
              <div class="col-3">
              <button type="button" class="btn btn-outline-secondary">Secondary</button>
              </div>          
          
            </div>


              </div>


              
            </div>


            <div class="card">
            
            <div class="card-header">
              <div class="row align-items-center">
                <div class="col-3">
                  <h5 class="mb-0">หมวดหมู่</h5>
                </div>
                <div class="col-9">

                <select class="form-select" id="role" aria-label="role" name="ep_role" onchange="toggleOtherInput()">
  <?php
    include("connectdb.php");
    $sql2 = "SELECT * FROM `type`";
    $rs2 = mysqli_query($conn, $sql2);
    while ($data2 = mysqli_fetch_array($rs2)) {
  ?>
    <option value="<?=$data2['type_id'];?>"><?=$data2['type_name'];?></option>
  <?php } ?>
  <option>ไม่ระบุ</option>
    <option value="other">อื่นๆ</option>
</select>

<!-- ช่องกรอกข้อมูลสำหรับ "อื่นๆ" -->
<input type="text" class="form-control mt-2" id="otherInput" name="other_role" placeholder="กรุณากรอกหมวดหมู่" style="display: none;">


              </div>          
              </div>
            </div>
  
              <div class="card-body pc-component">
  
                <div class="row align-items-center">
                <div class="col-3">
                  <p class="text-dark mb-0">ชื่อผู้ใช้</p>
                </div>
                <div class="col-9">
                  <input name="ep_user" type="text" class="form-control" value="<?= $data['emp_user']; ?>"> 
                </div>          
              </div>
  
              <br>
              <div class="row align-items-center">
                <div class="col-3">
                  <p class="text-dark mb-0">รหัสผ่านใหม่</p>
                </div>
                <div class="col-9">
                  <input name="ep_pwd" type="password" class="form-control" value="<?= $data['emp_pwd']; ?>"> 
                </div>          
              </div>
                </div>               
              </div>
  

              <div class="d-grid gap-2 d-md-flex justify-content-md-end">
  <button type="submit" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">บันทึกข้อมูล</button>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">บันทึกข้อมูล</h5>
        <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
      </div>
      <div class="modal-body" id="modalMessage">
        ...
      </div>

    </div>
  </div>
</div>

            </div>
          </div>
        </div>

        <?php } else  { ?>
          <p>No employee data found.</p>

          </form>
          
      </div>

      <?php } ?>


    </div>

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


</script>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

</body>

</body>
<!-- [Body] end -->

</html>