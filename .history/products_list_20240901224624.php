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


/* .status-ready {
  color: green;
}
.status-almost {
  color: orangered;
}
.status-out {
  color: red;
} */




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

.img-icon{
  height: 70px;
  width: 70px;
  border-radius:20px;
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
    <form method="post" class="search-form" onsubmit="return false;">
      <input type="text" name="src2" placeholder="ค้นหาสินค้า" class="search-input" autofocus>
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
      <!-- [ breadcrumb ] start -->

      <div>


      <!-- <div class="col-md-6 col-xl-3">
          <div class="card bg-grd-primary order-card">
            <div class="card-body">
              <h6 class="text-white">สินค้าทั้งหมด</h6>
              <h2 class="text-end text-white"><i class="feather icon-shopping-cart float-start"></i><span>...</span>
              </h2>
              <p class="m-b-0">Completed Orders<span class="float-end">351</span></p>
            </div>
          </div>
        </div>
        </div> -->


      <div class="page-header">
        <div class="page-block card mb-0">
          <div class="card-body">
            <div class="row align-items-center">


              <div class="col-md-12">
                <div class="page-header-title border-bottom pb-2 mb-2">
                  <h4 class="mb-0">รายการสินค้า</h4>
                </div>
              </div>

              <div class="table-responsive">
              <table class="table" width="100%">
  <thead>
  <tr>
                    <td width="8%" class="text-center">รหัส</td>
                    <!-- <td width="15%" class="text-center">&nbsp;</td> -->
                    <td width="35%" class="text-start">ชื่อสินค้า</td>
                    <td width="12%" class="text-start">ขนาด</td>
                    <td width="10%" class="text-center">จำนวน<small>/Restock</small></td>
                    <td width="10%" class="text-center">ราคา (บาท)</td>
                    <td width="15%" class="text-start">หมวดหมู่</td>
                    <td width="10%" class="text-start">สถานะ</td>


                    <!-- <th width="5%">&nbsp;</th> -->
                  </tr>
  </thead>


<!-- old code -->
  <!-- <tbody>
    <?php
    include("connectdb.php");

    $sql = "SELECT 
        products.id, 
        products.name, 
        MIN(size.price) AS min_price, 
        MAX(size.price) AS max_price, 
        type.type_name AS type_name,
        size.id AS size_name,
        size.qty,
        CASE 
            WHEN size.qty > 7 THEN 'พร้อมขาย'
            WHEN size.qty > 0 AND size.qty <= 7 THEN 'ใกล้หมด'
            ELSE 'สินค้าหมด'
        END AS status
    FROM 
        `products`
    JOIN 
        `size` ON products.id = size.id
    JOIN 
        `type` ON products.type_id = type.type_id
    GROUP BY 
        products.id, size.id
    ORDER BY 
        products.id, size.id";

    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result) {
            $current_product_id = null;
            $product_row_started = false;

            while ($data = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                if ($data['id'] != $current_product_id) {
                    if ($product_row_started) {
                        echo '</tr>';
                    }

                    $current_product_id = $data['id'];
                    $product_row_started = true;

                    ?>
                    <tr>
                        <td class="text-center"><?=$data['id'];?></td>
                        <td class="text-center">
                            <img src="assets/images/products_2/<?=$data['id'];?>.jpg" class="card-img-top img-icon" alt="Product Image">
                        </td>
                        <td class="text-start"><?=$data['name'];?></td>
                        <td class="text-center">ขนาด</td>
                        <td class="text-end">จำนวน</td>
                            <td class="text-end"><?php if ($data['min_price'] == $data['max_price']) { ?>
                                <?= number_format($data['min_price']); ?>
                            <?php } else { ?>
                                <?= number_format($data['min_price']); ?> - <?= number_format($data['max_price']); ?>
                            <?php } ?></td>

                        <td class="text-center"><?=$data['type_name'];?></td>
                        <td><span class="text-center <?=$status_class;?>"><?=$data['status'];?></span></td>
                    </tr>
                    <?php
                }

                ?>
                
                <?php
            }

            if ($product_row_started) {
                echo '</tr>';
            }

            mysqli_stmt_close($stmt);
        } else {
            echo "<tr><td colspan='7' class='text-center'>Query failed: " . mysqli_error($conn) . "</td></tr>";
        }
    } else {
        die("Query preparation failed: " . mysqli_error($conn));
    }
    ?>
</tbody> -->


<tbody>
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

      if ($result) {
          $current_product_id = null;

          while ($data = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
              // Determine status class
              $status_class = '';
              if ($data['status'] == 'พร้อมขาย') {
                  $status_class = 'badge bg-success';
              } elseif ($data['status'] == 'ใกล้หมด') {
                  $status_class = 'badge bg-warning';
              } else {
                  $status_class = 'badge bg-danger';
              }

              // Check if we need to start a new product row
              if ($data['id'] != $current_product_id) {
                  // If we were displaying a product, close its row
                  if ($current_product_id !== null) {
                      echo '</tr>';
                  }

                  // Start a new product row
                  $current_product_id = $data['id'];

                  // Output the product row
                  ?>
                    <tr class="table-light">
                        <td class="text-center"><?=$data['id'];?></td>
                        <!-- <td class="text-center">&nbsp;</td> -->
                        <td colspan="4" class="text-start"><?=$data['name'];?></td>
                        <!-- <td class="text-start">&nbsp;</td>
                        <td class="text-center">&nbsp;</td>
                        <td class="text-end">&nbsp;</td> -->
                        <td colspan="2" class="text-start"><?=$data['type_name'];?></td>
                        <td class="text-start">&nbsp;</td>
                    </tr>
                    <?php
                }

                // Output size row
                ?>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <!-- <td>&nbsp;</td> -->
                    <td class="text-start"><small><?=$data['size_name'];?></small></td>
                    <td class="text-center"><?=$data['qty'];?><small>/<?=$data['re_stock'];?></small></td>
                    <td class="text-center"><?=number_format($data['price']);?></td>
                    <td class="text-center">&nbsp;</td>
                    <td class="text-start"><span class="badge <?=$status_class;?>"><?=$data['status'];?></span></td>                
                  </tr>
                <?php
            }

            // Close the last product row if it was started
            if ($current_product_id !== null) {
                echo '</tr>';
            }

            mysqli_stmt_close($stmt);
        } else {
            echo "<tr><td colspan='8' class='text-center'>Query failed: " . mysqli_error($conn) . "</td></tr>";
        }
    } else {
        die("Query preparation failed: " . mysqli_error($conn));
    }
    ?>
</tbody>


</table>
</div>



            </div>
          </div>
        </div>
      </div>
      <!-- [ breadcrumb ] end -->

      <!-- [ Main Content ] start -->
      <div class="row">
        <!-- [ Typography ] start -->
        <!-- <div class="col-sm-12">
          <div class="card">
            <div class="card-header">
              <h5>Headings</h5>
              <p><span class="badges">.h1</span> through .h6 classes are also available, for when you want to match
                the font styling of a heading
                but cannot use the associated HTML element.</p>
            </div>
            <div class="card-body pc-component">
              <h1>h1. Heading</h1>
              <div class="clearfix"></div>
              <h2>h2. Heading</h2>
              <div class="clearfix"></div>
              <h3>This is a H3</h3>
              <div class="clearfix"></div>
              <h4>This is a H4</h4>
              <div class="clearfix"></div>
              <h5>This is a H5</h5>
              <div class="clearfix"></div>
              <h6>This is a H6</h6>
            </div>
          </div>
        </div> -->
        <!-- <div class="col-sm-12">
          <div class="card">
            <div class="card-header">
              <h5>Display Headings</h5>
            </div>
            <div class="card-body pc-component">
              <h1 class="display-1">Display 1</h1>
              <h1 class="display-2">Display 2</h1>
              <h1 class="display-3">Display 3</h1>
              <h1 class="display-4">Display 4</h1>
              <h1 class="display-5">Display 5</h1>
              <h1 class="display-6">Display 6</h1>
            </div>
          </div>
        </div> -->
        <!-- <div class="col-md-6">
          <div class="card">
            <div class="card-header">
              <h5>Inline Text Elements</h5>
            </div>
            <div class="card-body pc-component">
              <p class="lead m-t-0">Your title goes here</p>
              You can use the mark tag to
              <mark>highlight</mark> text.
              <br>
              <del>This line of text is meant to be treated as deleted text.</del>
              <br>
              <ins>This line of text is meant to be treated as an addition to the document.</ins>
              <br>
              <strong>rendered as bold text</strong>
              <br>
              <em>rendered as italicized text</em>
            </div>
          </div>
        </div> -->
        <!-- <div class="col-md-6">
          <div class="card">
            <div class="card-header">
              <h5>Contextual Text Colors</h5>
            </div>
            <div class="card-body pc-component">
              <p class="text-muted mb-1"> Fusce dapibus, tellus ac cursus commodo, tortor mauris nibh. </p>
              <p class="text-primary mb-1"> Nullam id dolor id nibh ultricies vehicula ut id elit. </p>
              <p class="text-success mb-1"> Duis mollis, est non commodo luctus, nisi erat porttitor ligula. </p>
              <p class="text-info mb-1"> Maecenas sed diam eget risus varius blandit sit amet non magna. </p>
              <p class="text-warning mb-1"> Etiam porta sem malesuada magna mollis euismod. </p>
              <p class="text-danger mb-1"> Donec ullamcorper nulla non metus auctor fringilla. </p>
              <p class="text-dark mb-1"> Nullam id dolor id nibh ultricies vehicula ut id elit. </p>
            </div>
          </div>
        </div> -->
        <!-- <div class="col-md-6 col-lg-4">
          <div class="card">
            <div class="card-header">
              <h5>Unordered</h5>
            </div>
            <div class="card-body pc-component">
              <ul>
                <li>Lorem ipsum dolor sit amet</li>
                <li>Consectetur adipiscing elit</li>
                <li>Integer molestie lorem at massa</li>
                <li>Facilisis in pretium nisl aliquet</li>
                <li>Nulla volutpat aliquam velit
                  <ul>
                    <li>Phasellus iaculis neque</li>
                    <li>Purus sodales ultricies</li>
                    <li>Vestibulum laoreet porttitor sem</li>
                    <li>Ac tristique libero volutpat at</li>
                  </ul>
                </li>
                <li>Faucibus porta lacus fringilla vel</li>
                <li>Aenean sit amet erat nunc</li>
                <li>Eget porttitor lorem</li>
              </ul>
            </div>
          </div>
        </div> -->
        <!-- <div class="col-md-6 col-lg-4">
          <div class="card">
            <div class="card-header">
              <h5>Ordered</h5>
            </div>
            <div class="card-body pc-component">
              <ol>
                <li>Lorem ipsum dolor sit amet</li>
                <li>Consectetur adipiscing elit</li>
                <li>Integer molestie lorem at massa</li>
                <li>Facilisis in pretium nisl aliquet</li>
                <li>Nulla volutpat aliquam velit
                  <ul>
                    <li>Phasellus iaculis neque</li>
                    <li>Purus sodales ultricies</li>
                    <li>Vestibulum laoreet porttitor sem</li>
                    <li>Ac tristique libero volutpat at</li>
                  </ul>
                </li>
                <li>Faucibus porta lacus fringilla vel</li>
                <li>Aenean sit amet erat nunc</li>
                <li>Eget porttitor lorem</li>
              </ol>
            </div>
          </div>
        </div> -->
        <!-- <div class="col-md-12 col-lg-4">
          <div class="card">
            <div class="card-header">
              <h5>Unstyled</h5>
            </div>
            <div class="card-body pc-component">
              <ul class="list-unstyled">
                <li>Lorem ipsum dolor sit amet</li>
                <li>Integer molestie lorem at massa
                  <ul>
                    <li>Phasellus iaculis neque</li>
                  </ul>
                </li>
                <li>Faucibus porta lacus fringilla vel</li>
                <li>Eget porttitor lorem</li>
              </ul>
              <h5>Inline</h5>
              <hr>
              <ul class="list-inline m-b-0">
                <li class="list-inline-item">Lorem ipsum</li>
                <li class="list-inline-item">Phasellus iaculis</li>
                <li class="list-inline-item">Nulla volutpat</li>
              </ul>
            </div>
          </div>
        </div> -->
        <!-- <div class="col-md-6">
          <div class="card">
            <div class="card-header">
              <h5>Blockquotes</h5>
            </div>
            <div class="card-body pc-component">
              <p class="text-muted mb-1"> Your awesome text goes here. </p>
              <blockquote class="blockquote">
                <p class="mb-2">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a
                  ante.</p>
                <footer class="blockquote-footer">Someone famous in <cite title="Source Title">Source Title</cite>
                </footer>
              </blockquote>
              <p class="text-muted m-b-15 m-t-20"> Add <code>.text-end</code> for a blockquote with right-aligned
                content. </p>
              <blockquote class="blockquote text-end">
                <p class="mb-2">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a
                  ante.</p>
                <footer class="blockquote-footer">Someone famous in <cite title="Source Title">Source Title</cite>
                </footer>
              </blockquote>
            </div>
          </div>
        </div> -->
        <!-- <div class="col-md-6">
          <div class="card">
            <div class="card-header">
              <h5>Horizontal Description</h5>
            </div>
            <div class="card-body pc-component">
              <dl class="dl-horizontal row">
                <dt class="col-sm-3">Description lists</dt>
                <dd class="col-sm-9">A description list is perfect for defining terms.</dd>

                <dt class="col-sm-3">Euismod</dt>
                <dd class="col-sm-9">Vestibulum id ligula porta felis euismod semper eget lacinia odio sem nec elit.
                </dd>
                <dd class="col-sm-9">Donec id elit non mi porta gravida at eget metus.</dd>

                <dt class="col-sm-3">Malesuada porta</dt>
                <dd class="col-sm-9">Etiam porta sem malesuada magna mollis euismod.</dd>

                <dt class="col-sm-3 text-truncate">Truncated term is truncated</dt>
                <dd class="col-sm-9">Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut
                  fermentum massa justo sit amet risus.</dd>
              </dl>
            </div>
          </div>
        </div> -->
        <!-- [ Typography ] end -->
      </div>
      <!-- [ Main Content ] end -->
    </div>


  </div>
  <!-- [ Main Content ] end -->

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