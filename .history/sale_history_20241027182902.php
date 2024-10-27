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

$aid = $_SESSION['aid'];
$aname = $_SESSION['aname'];
$role_id = $_SESSION['role_id'];
$role_name = $_SESSION['role_name'];
$img = $_SESSION['img'];

if (empty($img)) {
    $img = 'default.jpg'; 
}

$imagePath = "assets/images/emp/" . $aid . "." . $img;

function thai_day($date) {
    $dayNames = array("อาทิตย์", "จันทร์", "อังคาร", "พุธ", "พฤหัสบดี", "ศุกร์", "เสาร์");
    return $dayNames[date('w', strtotime($date))];
}

function thai_month($date) {
    $monthNames = array(
        1 => "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", 
        "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"
    );
    return $monthNames[date('n', strtotime($date))];
}

function thai_year($date) {
    return date('Y', strtotime($date)) + 543;
}

// จำนวนแถวต่อหน้า
$limit = 10;
// ตรวจสอบหมายเลขหน้าปัจจุบัน
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $limit;

// ตรวจสอบค่าที่เลือกใน dropdown
$selectedMonth = isset($_GET['month']) ? (int)$_GET['month'] : 0;

// สร้าง SQL Query ตามบทบาทของผู้ใช้
if ($role_name == 'admin') {
    $sql = "SELECT o.*, pm.paymethod_name, ep.emp_name FROM orders o 
            JOIN paymethod pm ON o.paymethod_id = pm.paymethod_id
            JOIN employees ep ON o.emp_id = ep.emp_id";
    
    // ถ้าเลือกเดือน ให้ปรับ SQL query
    if ($selectedMonth > 0) {
        $sql .= " WHERE MONTH(o.order_date) = $selectedMonth";
    }

    $sql .= " ORDER BY o.order_id DESC LIMIT $start, $limit";
} elseif ($role_name == 'employee') {
    $sql = "SELECT o.*, pm.paymethod_name, ep.emp_name FROM orders o 
            JOIN paymethod pm ON o.paymethod_id = pm.paymethod_id
            JOIN employees ep ON o.emp_id = ep.emp_id
            WHERE o.emp_id = '$aid'";
    
    // ถ้าเลือกเดือน ให้ปรับ SQL query
    if ($selectedMonth > 0) {
        $sql .= " AND MONTH(o.order_date) = $selectedMonth";
    }

    $sql .= " ORDER BY o.order_id DESC LIMIT $start, $limit";
}

$rs = mysqli_query($conn, $sql);

// จำนวนแถวทั้งหมดสำหรับการคำนวณหน้า
$totalQuery = "SELECT COUNT(*) as total FROM orders";
if ($selectedMonth > 0) {
    $totalQuery .= " WHERE MONTH(order_date) = $selectedMonth";
}
$totalResult = mysqli_query($conn, $totalQuery);
$totalData = mysqli_fetch_assoc($totalResult);
$totalRows = $totalData['total'];
$totalPages = ceil($totalRows / $limit);
?>

<!DOCTYPE html>
<html lang="en">
<!-- [Head] start -->

<head>
  <title>Sample Page | Gradient Able Dashboard Template</title>
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


  <!-- <link rel="stylesheet" type="text/css" href="style.css"> -->

  <!-- [Favicon] icon -->
  <link rel="icon" href="assets/images/favicon.svg" type="image/x-icon"> <!-- [Google Font : Poppins] icon -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

<!-- [Tabler Icons] https://tablericons.com -->
<link rel="stylesheet" href="assets/fonts/tabler-icons.min.css" >
<!-- [Feather Icons] https://feathericons.com -->
<link rel="stylesheet" href="assets/fonts/feather.css" >
<!-- [Font Awesome Icons] https://fontawesome.com/icons -->
<link rel="stylesheet" href="assets/fonts/fontawesome.css" >
<!-- [Material Icons] https://fonts.google.com/icons -->
<link rel="stylesheet" href="assets/fonts/material.css" >
<!-- [Template CSS Files] -->
<link rel="stylesheet" href="assets/css/style.css" id="main-style-link" >
<link rel="stylesheet" href="assets/css/style-preset.css" >



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
          url: "fetch_products.php",
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



        <!-- <li class="pc-item pc-caption">
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
        <div class="card-body" style="background-image: url('assets/images/layout/nav-card-bg.svg')"> -->

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
    <form method="post" class="search-form" onsubmit="return false;">
      <input type="text" name="src2" placeholder="ค้นหาเลขที่ใบสั่งซื้อ" class="search-input" autofocus>
      <a class="btn btn-primary"><i class="ph ph-magnifying-glass"></i></a>
    </form>




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

  <!-- [ Main Content ] start -->

  <!-- [ Main Content ] start -->

  <div class="pc-container">
    <div class="pc-content">
        <div class="page-header">
            <div class="page-block card mb-0">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <div class="page-header-title border-bottom pb-2 mb-2 d-flex justify-content-between align-items-center">
                                <h4 class="mb-0">ประวัติการขาย</h4>

                                <div class="col-12 col-md-3">
                                    <form method="get" action="">
                                        <select class="form-select" name="month" aria-label="เลือกเดือน" onchange="this.form.submit()">
                                            <option value="0">ยอดขายของทุกเดือน</option>
                                            <?php
                                            // สร้าง array ของชื่อเดือน
                                            $months = [
                                                1 => 'มกราคม',
                                                2 => 'กุมภาพันธ์',
                                                3 => 'มีนาคม',
                                                4 => 'เมษายน',
                                                5 => 'พฤษภาคม',
                                                6 => 'มิถุนายน',
                                                7 => 'กรกฎาคม',
                                                8 => 'สิงหาคม',
                                                9 => 'กันยายน',
                                                10 => 'ตุลาคม',
                                                11 => 'พฤศจิกายน',
                                                12 => 'ธันวาคม'
                                            ];

                                            // แสดงตัวเลือกเดือน
                                            foreach ($months as $month_num => $month_name) {
                                                echo "<option value=\"$month_num\" " . ($month_num == $selectedMonth ? 'selected' : '') . ">$month_name</option>";
                                            }
                                            ?>
                                        </select>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <table class="table table-striped table-sm-gap" width="100%">
                            <thead>
                                <tr>
                                    <td width="10%" class="text-center"></td>
                                    <td width="10%" class="text-center">เลขที่บิล</td>
                                    <td width="21%" class="text-start">วันที่ (สร้าง)</td>
                                    <td width="16%" class="text-end">ราคารวม (บาท)</td>
                                    <td width="13%" class="text-center">พนักงาน</td>
                                    <td width="10%" class="text-center">ชำระโดย</td>
                                    <td width="20%" class="text-center">รายการ</td>
                                </tr>
                            </thead>

                            <tbody>
                            <?php
                            // ตรวจสอบว่ามีผลลัพธ์หรือไม่
                            if (mysqli_num_rows($rs) > 0) {
                                while ($data = mysqli_fetch_array($rs, MYSQLI_BOTH)) {
                            ?>
                                <tr>
                                    <td class="text-center">
                                        <small>
                                        <a href="history_detail.php?a=<?=$data['order_id'];?>">รายละเอียด</a>
                                        </small>
                                    </td>
                                    <td class="text-center"><?=$data['order_id'];?></td>
                                    <td class="text-start text-muted">
                                        <small><?= "วัน" . thai_day($data['order_date']) . " " . date('d', strtotime($data['order_date'])) . " " . thai_month($data['order_date']) . " " . thai_year($data['order_date']) . " " . date('H:i', strtotime($data['order_date'])) . " น."; ?>
                                        </small>
                                    </td>          
                                    <td class="text-end"><?=number_format($data['order_total'], 2);?></td>
                                    <td class="text-center"><small><?=$data['emp_name'];?></small></td>
                                    <td class="text-center"><?=$data['paymethod_name'];?></td>
                                    <td class="text-center">
                                        <a href="delete.php?id=<?=$data['order_id'];?>" type="button" class="btn btn-danger" onClick="return confirm('ยืนยันการลบ ?');"><i class="ph ph-trash"></i>ลบ</a>
                                        <a type="button" class="btn btn-success" onClick="window.open('bill_print.php?b=<?=$data['order_id'];?>', '_blank', 'width=760,height=560')"><i class="ph ph-printer"></i> ใบเสร็จ</a>

                                    </td>
                                </tr>
                            <?php  
                                }
                            } else {
                                echo '<tr><td colspan="7" class="text-center">ไม่มีรายการการขาย</td></tr>';
                            }
                            ?>
                            </tbody>
                        </table>

                        <!-- แสดงลิงก์สำหรับเปลี่ยนหน้า -->
                        <div class="pagination-container text-center mt-3">
                            <?php if($page > 1): ?>
                                <a href="?page=<?= $page - 1; ?>&month=<?= $selectedMonth; ?>" class="btn btn-outline-secondary">ก่อนหน้า</a>
                            <?php endif; ?>

                            <?php for($i = 1; $i <= $totalPages; $i++): ?>
                                <a href="?page=<?= $i; ?>&month=<?= $selectedMonth; ?>" class="btn btn-outline-secondary <?= $i == $page ? 'active' : ''; ?>"><?= $i; ?></a>
                            <?php endfor; ?>

                            <?php if($page < $totalPages): ?>
                                <a href="?page=<?= $page + 1; ?>&month=<?= $selectedMonth; ?>" class="btn btn-outline-secondary">ถัดไป</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


  <footer class="pc-footer">
    <div class="footer-wrapper container-fluid">
      <div class="row">






  
        <div class="col-sm-6 ms-auto my-1">
          <ul class="list-inline footer-link mb-0 justify-content-sm-end d-flex">
          <a href="#top" class="text-end">กลับไปบนสุด</a>
          </ul>
        </div>
      </div>
    </div>
  </footer>

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


</script>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>



<script src="../assets/js/plugins/popper.min.js"></script>
<script src="../assets/js/plugins/simplebar.min.js"></script>
<script src="../assets/js/plugins/bootstrap.min.js"></script>
<script src="../assets/js/fonts/custom-font.js"></script>
<script src="../assets/js/pcoded.js"></script>
<script src="../assets/js/plugins/feather.min.js"></script>





<script>layout_change('light');</script>




<script>layout_sidebar_change('light');</script>



<script>change_box_container('false');</script>


<script>layout_caption_change('true');</script>




<script>layout_rtl_change('false');</script>


<script>preset_change("preset-1");</script>


<script>header_change("header-1");</script>


</body>


<!-- [Body] end -->

</html>