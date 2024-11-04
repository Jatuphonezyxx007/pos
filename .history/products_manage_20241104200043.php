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


  <!-- <link rel="stylesheet" type="text/css" href="style.css"> -->


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
      <input type="text" name="src" placeholder="ค้นหาสินค้า" class="search-input" autofocus>
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
  <div class="col-12 col-sm-8 col-md-12">
        <div class="pc-container px-1">
            <div class="pc-content">

            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
  <a href="add_product.php" class="btn btn-success">
    <i class="ph ph-plus-circle me-2"></i> เพิ่มรายการสินค้า
  </a>
</div>

                <br> 
                <div id="product-list" class="row g-2">



                <?php
include("connectdb.php");
@$src = $_POST['src'];
$sql = "SELECT products.*, MIN(size.price) AS min_price, MAX(size.price) AS max_price 
FROM `products`
JOIN `size` ON products.id = size.id
WHERE (`products`.`barcode` LIKE '%{$src}%' OR `products`.`name` LIKE '%{$src}%')
GROUP BY products.id
ORDER BY `id` ASC";

$rs = mysqli_query($conn, $sql);
while ($data = mysqli_fetch_array($rs)){
?>
                    <div class="col-sm-12 col-md-4 col-lg-3">
                        <div class="card">
                            <img src="assets/images/products_2/<?=$data['id'];?>.<?=$data['img'];?>" class="card-img-top" alt="" height="280px">
                            <div class="card-body">
                                <h8 class="card-title d-inline-block text-truncate" style="max-width: 150px;"><?=$data['name'];?></h8>
                                <p class="card-text">
                <?php if ($data['min_price'] == $data['max_price']) { ?>
                    <?= number_format($data['min_price'],); ?> บาท
                <?php } else { ?>
                    <?= number_format($data['min_price'],); ?> - <?= number_format($data['max_price'],); ?> บาท
                <?php } ?>
            </p>

            <form action="update_product.php" method="POST" style="display:inline;">

                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">

    <input type="hidden" name="id" value="<?= $id ?>">
    <a href="update_product.php?id=<?= $data['id']; ?>" type="button" class="btn btn-primary">แก้ไข</a>

                                    <!-- <button class="btn btn-primary me-md-2" type="button">แก้ไข</button> -->
                                    <a href="#" type="button" class="btn btn-danger" onClick="return confirm('ยืนยันการลบ ?');">ลบ</a>
                                    </div>
                                </form>


                            </div>
                        </div>
                    </div>
                    <?php
                    }
                    mysqli_close($conn);
                    ?> 
                </div>
            </div>
        </div>
    </div>



    </div>
    </div>  
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
</body>

</body>
<!-- [Body] end -->

</html>