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
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

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



.size-button {
    padding: 10px;
    margin: 5px;
    border: 1px solid #ccc;
    background-color: #fff;
    cursor: pointer;
}

.size-button.selected {
    background-color: #007bff;
    color: #fff;
    border-color: #007bff;
}



/* input[type="button-cal"] { 
    width: 100%; 
    padding: 20px 40px; 
    background-color: rgb(223, 223, 223); 
    color: black;
    font-size: 15px; 
    font-weight: bold; 
    border: none; 
    border-radius: 5px;
}  */



.custom-number-input {
    display: flex;
    align-items: center;
    border: 1px solid #ccc;
    border-radius: 5px;
    overflow: hidden;
    width: fit-content;
}

.custom-number-input button {
    background-color: #007bff; /* สีฟ้า */
    color: white;
    border: none;
    padding: 10px 15px;
    cursor: pointer;
    font-size: 16px;
}

.custom-number-input button.btn-plus {
    background-color: #808080; /* สีเทา */
}

.custom-number-input input {
    text-align: center;
    border: none;
    padding: 10px 0;
    width: 50px;
    font-size: 16px;
    outline: none;
    color: #333;
}


.calculator-btn {
            height: 60px;
            font-size: 1.2rem;
        }
        #totalDisplay {
            font-size: 0.9rem;
            color: #6c757d;
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
<!-- [ Sidebar Menu ] start -->
<nav class="pc-sidebar">
  <div class="navbar-wrapper">
    <div class="m-header">
      <a href="dashboard/index.html" class="b-brand text-primary">
        <!-- ========   Change your logo from here   ============ -->
        <img src="assets/images/logo/logo.png" alt="logo image" class="logo-lg">
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
        > -->

      <!-- </ul>
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
                  <!-- <li class="list-group-item">
                    <a href="https://codedthemes.com/item/gradient-able-admin-template/" class="dropdown-item">
                      <span class="d-flex align-items-center">
                        <i class="ph ph-arrow-circle-down"></i>
                        <span>Download</span>
                      </span>
                    </a>
                  </li> -->
                  <!-- <li class="list-group-item">
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
                  </li> -->
                  <li class="list-group-item">
                    <!-- <a href="#" class="dropdown-item">
                      <span class="d-flex align-items-center">
                        <i class="ph ph-plus-circle"></i>
                        <span>Add account</span>
                      </span>
                    </a> -->
                    <a href="logout.php" class="dropdown-item">
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
  <div class="col-12 col-md-9">
    <div class="pc-container px-1">
        <div class="pc-content">
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
            <!-- Product card responsive setup -->
            <div class="col-sm-12 col-md-6 col-lg-4">
                <div class="card h-100">
                    <img src="assets/images/products_2/<?=$data['id'];?>.<?=$data['img'];?>" class="card-img-top" alt="" height="240px">
                    <div class="card-body">
                        <h8 class="card-title d-inline-block text-truncate" style="max-width: 150px;"><?=$data['name'];?></h8>
                        <p class="card-text">
                            <?php if ($data['min_price'] == $data['max_price']) { ?>
                                <?= number_format($data['min_price'],); ?> บาท
                            <?php } else { ?>
                                <?= number_format($data['min_price'],); ?> - <?= number_format($data['max_price'],); ?> บาท
                            <?php } ?>
                        </p>

                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#exampleModal"
                            data-product-id="<?=$data['id'];?>"
                            data-product-name="<?=$data['name'];?>">
                            เพิ่ม
                        </button>
                    </div>
                </div>
            </div>
            <?php
                }
                mysqli_close($conn);
            ?>
            </div>

            <!-- Modal Section -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">ชื่อรายการสินค้า</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div id="size-buttons-container"></div>
                            <br><br>
                            <div class="row align-items-center">
                                <div class="col-2">
                                    <p class="mb-0">จำนวน</p>
                                </div>
                                <div class="col-5">
                                    <div class="custom-number-input">
                                        <button class="btn btn-secondary" onclick="decreaseQuantity()">-</button>
                                        <input type="text" id="quantity" value="0" readonly>
                                        <button class="btn btn-secondary" onclick="increaseQuantity()">+</button>
                                    </div>
                                </div>
                            </div>    
                            <br>
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <p class="mb-0 text-start">ราคา</p>
                                </div>
                                <div class="col">
                                    <p id="price-display" class="mb-0 text-start">0 บาท</p>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary w-100" id="add-to-order-button">
                              <i class="ph ph-check"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Fixed right-side order summary -->
<div class="col-12 col-md-3 fixed-col">
    <div class="row">
        <center>
            <h5 class="text-muted">รายการสินค้า</h5> <!-- ลดขนาด h1 เป็น h5 -->
        </center>
        <div class="table-responsive">
            <table class="table table-sm table-borderless small"> <!-- เพิ่ม class "small" -->
                <thead>
                    <tr>
                        <th width="5%" class="text-center fst-normal">ที่</th>
                        <th width="55%" class="text-start fst-normal">สินค้า</th>
                        <th width="20%" class="text-center fst-normal">จำนวน</th>
                        <th width="20%" class="text-center fst-normal">ราคา</th>
                    </tr>
                </thead>
                <tbody id="order-list">
                    <!-- สินค้าจะถูกเพิ่มที่นี่ -->
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" class="text-end"><strong>รวม</strong></td>
                        <td class="text-center" id="total-price">0 บาท</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <!-- ปุ่มที่กดเพื่อเปิด Modal -->
    <div class="d-grid gap-1 mt-2">
        <button class="btn btn-success btn-sm" type="button" id="pay-button">
            ชำระเงิน
        </button>
    </div>

    <div class="d-grid gap-1 mt-1">
        <a href="#" class="btn btn-danger btn-sm" id="clear-order-button">ล้างทั้งหมด</a>
    </div>
</div>

        </div>
      </div>
    
    
    </div>


    

<!-- Modal for Payment -->
<!-- Modal -->
<div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="paymentModalLabel">การชำระเงิน</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <div class="col-md">
          <div class="form-floating">
            <select class="form-select" id="paymentMethod" aria-label="payment" name="payments">
            <option value="" disabled selected>กรุณาเลือกการชำระเงิน</option>
              <?php
              include("connectdb.php");
              $sql2 = "SELECT * FROM `paymethod`";
              $rs2 = mysqli_query($conn, $sql2);
              while ($data2 = mysqli_fetch_array($rs2)){
              ?>
                <option value="<?=$data2['PayMethod_id'];?>">
                  <?=$data2['PayMethod_name'];?>
                </option>  
              <?php } ?>
            </select>
            <label for="payment">ประเภทการชำระ</label>
          </div>
        </div>

        <br>

        <!-- <div class="container"> -->

        <div id="calContainer" style="display: none;">
    <div class="card">
        <div class="card-body">
            <div class="mb-3">
            <input type="text" class="form-control text-end fs-4 mb-3 display" value="0" disabled />
                <div id="totalDisplay" class="text-end mt-1"></div>
            </div>


            <div class="container mt-4">
    <div class="row g-2">
        <div class="col-3">
            <button class="btn btn-danger w-100" data-value="AC">AC</button>
        </div>
        <div class="col-3">
            <button class="btn btn-warning w-100" data-value="DEL">DEL</button>
        </div>
        <div class="col-3">
            <button class="btn btn-danger w-100" data-value="%">%</button>
        </div>
        <div class="col-3">
            <button class="btn btn-danger w-100" data-value="/">/</button>
        </div>
    </div>

    <div class="row g-2 mt-2">
        <div class="col-3">
            <button class="btn btn-outline-secondary w-100" data-value="7">7</button>
        </div>
        <div class="col-3">
            <button class="btn btn-outline-secondary w-100" data-value="8">8</button>
        </div>
        <div class="col-3">
            <button class="btn btn-outline-secondary w-100" data-value="9">9</button>
        </div>
        <div class="col-3">
            <button class="btn btn-info w-100" data-value="*">*</button>
        </div>
    </div>

    <div class="row g-2 mt-2">
        <div class="col-3">
            <button class="btn btn-outline-secondary w-100" data-value="4">4</button>
        </div>
        <div class="col-3">
            <button class="btn btn-outline-secondary w-100" data-value="5">5</button>
        </div>
        <div class="col-3">
            <button class="btn btn-outline-secondary w-100" data-value="6">6</button>
        </div>
        <div class="col-3">
            <button class="btn btn-info w-100" data-value="-">-</button>
        </div>
    </div>

    <div class="row g-2 mt-2">
        <div class="col-3">
            <button class="btn btn-outline-secondary w-100" data-value="1">1</button>
        </div>
        <div class="col-3">
            <button class="btn btn-outline-secondary w-100" data-value="2">2</button>
        </div>
        <div class="col-3">
            <button class="btn btn-outline-secondary w-100" data-value="3">3</button>
        </div>
        <div class="col-3">
            <button class="btn btn-info w-100" data-value="+">+</button>
        </div>
    </div>

    <div class="row g-2 mt-2">
        <div class="col-3">
            <button class="btn btn-outline-secondary w-100" data-value="0">0</button>
        </div>
        <div class="col-3">
            <button class="btn btn-outline-secondary w-100" data-value="00">00</button>
        </div>
        <div class="col-3">
            <button class="btn btn-outline-secondary w-100" data-value=".">.</button>
        </div>
        <div class="col-3">
            <button class="btn btn-success w-100" data-value="=">=</button>
        </div>
    </div>
</div>




</div>
</div>
</div>
<!-- </div> -->


        
        <div id="qrCodeContainer" style="display: none;">
          <img class="rounded mx-auto d-block" id="qrCodeImage" src="" alt="QR Code" />
        </div>
      </div>

      <div class="modal-footer">
        <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ย้อนกลับ</button> -->
        <button type="button" class="btn btn-primary w-100" id="paymentButton">ดำเนินการต่อ</button>
      </div>
    </div>
  </div>
</div>


        <!-- <form method="post" action="record.php">
  <div class="modal-body">
    <div class="col-md">
      <div class="form-floating">
        <select class="form-select" id="payment" aria-label="payment" name="payments">
          <?php
            include("connectdb.php");
            $sql2 = "SELECT * FROM `paymethod`";
            $rs2 = mysqli_query($conn, $sql2);
            while ($data2 = mysqli_fetch_array($rs2)) {
          ?>
            <option value="<?=$data2['PayMethod_id'];?>"<?=($data2['PayMethod_id'] == $data['paymethod']) ? "selected" : ""; ?>>
              <?=$data2['PayMethod_name'];?>
            </option>
          <?php } ?>
        </select>
        <label for="payment">ประเภทการชำระ</label>
      </div>
    </div>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ย้อนกลับ</button>
    <button type="submit" class="btn btn-primary">ชำระเงิน</button>
  </div>
</form> -->

        


        <!-- <button type="button" class="btn btn-primary">เลือก</button> -->
        
      <!-- </div>
    </div>
  </div> -->



  <!-- [ Main Content ] end -->
  <!-- <footer class="pc-footer">
    <div class="footer-wrapper container-fluid">
      <div class="row">
  
        <div class="col-sm-6 ms-auto my-1">
          <ul class="list-inline footer-link mb-0 justify-content-sm-end d-flex">
          <a href="#top" class="text-end">กลับไปบนสุด</a>
          </ul>
        </div>
      </div>
    </div>
  </footer> -->

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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>



<script>

  //เวลา
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

function addItem(productId) {
    // บันทึกสัญญาณรีเฟรชใน localStorage
    localStorage.setItem('refreshTable', 'true');

    // ส่งข้อความไปยังหน้าต่างที่เปิดอยู่ของ table_sale.php
    const openTableSaleWindow = window.open('', 'tableSale');
    if (openTableSaleWindow) {
        openTableSaleWindow.postMessage('refreshTable', '*');
    }

    // รีเฟรชหน้า sale.php พร้อมส่ง productId
    window.location.href = 'sale.php?id=' + encodeURIComponent(productId);
}

function refreshPage(btn_clear){
    // บันทึกสัญญาณรีเฟรชใน localStorage
    localStorage.setItem('refreshTable', 'true');

    // ส่งข้อความไปยังหน้าต่างที่เปิดอยู่ของ table_sale.php
    const openTableSaleWindow = window.open('', 'tableSale');
    if (openTableSaleWindow) {
        openTableSaleWindow.postMessage('refreshTable', '*');
    }


    function updateModalTitle(productName) {
    document.getElementById('exampleModalLabel').textContent = productName;
}

  
};








document.addEventListener('DOMContentLoaded', function() {
    var modal = document.getElementById('exampleModal');
    var priceContainer = modal.querySelector('#price-display');
    var quantityInput = document.getElementById("quantity");
    var pricePerUnit = 0;
    var maxQuantity = 0;
    var productName = '';
    var productSize = '';

    function setPricePerUnit(price, qty) {
        pricePerUnit = price;
        maxQuantity = qty;
        quantityInput.max = maxQuantity;

        if (maxQuantity === 0) {
            pricePerUnit = 0;
            quantityInput.value = 0;
        } else {
            quantityInput.value = 1;
        }

        updatePriceDisplay();
    }

    function updatePriceDisplay() {
        let quantity = parseInt(quantityInput.value);
        let totalPrice = pricePerUnit * quantity;
        priceContainer.textContent = totalPrice.toLocaleString();
    }

    modal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var productId = button.getAttribute('data-product-id');
        productName = button.getAttribute('data-product-name');

        var modalTitle = modal.querySelector('.modal-title');
        modalTitle.textContent = productName;

        priceContainer.textContent = '0';
        pricePerUnit = 0;
        maxQuantity = 0;

        fetch('fetch_sizes.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'id=' + productId
        })
        .then(response => response.text())
        .then(data => {
            var sizeButtonsContainer = modal.querySelector('#size-buttons-container');
            sizeButtonsContainer.innerHTML = data;
        })
        .catch(error => console.error('Error:', error));
    });

    modal.addEventListener('hide.bs.modal', function () {
        priceContainer.textContent = '0 บาท';
        pricePerUnit = 0;
        maxQuantity = 0;
        quantityInput.value = 1;
        quantityInput.max = 1;
    });

    $(document).on('click', '.size-button', function() {
        $('.size-button').removeClass('selected');
        $(this).addClass('selected');

        var price = $(this).data('price');
        var qty = $(this).data('qty');
        productSize = $(this).data('size-name');
        setPricePerUnit(price, qty);
    });

    window.decreaseQuantity = function() {
        let quantity = parseInt(quantityInput.value);
        if (quantity > 1 && maxQuantity > 0) {
            quantityInput.value = quantity - 1;
            updatePriceDisplay();
        }
    };

    window.increaseQuantity = function() {
        let quantity = parseInt(quantityInput.value);
        if (quantity < maxQuantity) {
            quantityInput.value = quantity + 1;
            updatePriceDisplay();
        }
    };







// ฟังก์ชันเพื่อเพิ่มรายการใหม่ในตาราง
document.getElementById('add-to-order-button').addEventListener('click', function() {
    let quantity = parseInt(quantityInput.value);
    let totalPrice = pricePerUnit * quantity;

    if (maxQuantity === 0 || pricePerUnit === 0) {
        alert("สินค้านี้หมด");
        return;
    }

    let orderList = document.getElementById('order-list');
    let existingRow = orderList.querySelector(`tr[data-product-name="${productName}"][data-product-size="${productSize}"]`);

    if (existingRow) {
        // ถ้ามีสินค้านี้อยู่ในตารางแล้ว
        let existingQuantity = parseInt(existingRow.querySelector('.quantity').textContent);
        let newQuantity = existingQuantity + quantity;
        existingRow.querySelector('.quantity').textContent = newQuantity;

        let existingPrice = parseFloat(existingRow.querySelector('.price').textContent.replace(/[^0-9.-]+/g, ""));
        let newPrice = (existingPrice / existingQuantity) * newQuantity;
        existingRow.querySelector('.price').textContent = newPrice.toLocaleString();
    } else {
        // ถ้าไม่มีสินค้านี้ในตาราง
        let newRow = document.createElement('tr');
        newRow.setAttribute('data-product-name', productName);
        newRow.setAttribute('data-product-size', productSize);
        newRow.innerHTML = `
            <td class="text-center">${orderList.rows.length + 1}</td>
            <td class="text-start fst-normal">${productName}<br><small class="text-muted">${productSize}</small>
                <a href="#" class="ph ph-trash text-danger delete-button"></a>
            </td>
            <td class="text-center quantity">${quantity}</td>
            <td class="text-end price">${totalPrice.toLocaleString()}</td>
        `;
        orderList.appendChild(newRow);
    }

    updateTotalPrice();

    // เก็บรายการสินค้าลงใน Local Storage
    saveOrderList();

    // รีเฟรชหน้า
    window.location.reload();  // รีเฟรชหน้า sale.php
});

// ฟังก์ชันเพื่อเก็บรายการสินค้าลงใน Local Storage
function saveOrderList() {
    let orderList = document.getElementById('order-list').innerHTML;
    localStorage.setItem('orderList', orderList);
}

// ฟังก์ชันเพื่อโหลดรายการสินค้าจาก Local Storage เมื่อเปิดหน้า
function loadOrderList() {
    let savedOrderList = localStorage.getItem('orderList');
    if (savedOrderList) {
        document.getElementById('order-list').innerHTML = savedOrderList;
        updateTotalPrice(); // อัปเดตราคาทั้งหมดหลังจากโหลดรายการ
    }
}

// ฟังก์ชันเพื่อเคลียร์ Local Storage และรีเฟรชหน้า
function clearOrderList() {
    localStorage.removeItem('orderList'); // ล้างข้อมูลใน Local Storage
    window.location.reload(); // รีเฟรชหน้า sale.php
}

// เรียกใช้ฟังก์ชันโหลดรายการสินค้าทันทีที่หน้าเว็บโหลดเสร็จ
window.onload = loadOrderList;

// เรียกใช้ฟังก์ชัน clearOrderList เมื่อคลิกปุ่ม "ล้างทั้งหมด"
document.getElementById('clear-order-button').addEventListener('click', clearOrderList);













// ใช้ event delegation เพื่อให้สามารถลบได้จากปุ่ม delete-button
document.getElementById('order-list').addEventListener('click', function(event) {
    if (event.target.classList.contains('delete-button')) {
        removeRow(event);
    }
});

// ฟังก์ชันลบแถวจากตาราง
function removeRow(event) {
    event.preventDefault(); // ป้องกันการรีเฟรชหน้า
    let row = event.target.closest('tr'); // หาตำแหน่งของแถว
    if (row) {
        row.remove(); // ลบแถวออกจากตาราง
        updateTotalPrice(); // อัปเดตราคารวม
    }
}

// ฟังก์ชันอัปเดตราคารวม
function updateTotalPrice() {
    let orderList = document.getElementById('order-list');
    let total = 0;

    for (let row of orderList.rows) {
        let priceText = row.cells[3].textContent;
        let price = parseFloat(priceText.replace(/[^0-9.-]+/g, ""));
        total += price;
    }

    document.getElementById('total-price').textContent = total.toLocaleString() + " บาท";
  }

document.getElementById('pay-button').addEventListener('click', function(event) {
    event.preventDefault(); // ป้องกันการรีเฟรชหน้า
    var paymentModal = new bootstrap.Modal(document.getElementById('paymentModal'));
    paymentModal.show(); // แสดง modal
});



document.getElementById('paymentButton').addEventListener('click', function() {
    var orderList = document.getElementById('order-list');
    var orderDetails = [];
    
    for (let row of orderList.rows) {
        var productName = row.getAttribute('data-product-name');
        var productSize = row.getAttribute('data-product-size');
        var quantity = row.querySelector('.quantity').textContent;
        var price = row.querySelector('.price').textContent.replace(/[^0-9.-]+/g, "");
        
        orderDetails.push({
            productName: productName,
            productSize: productSize,
            quantity: quantity,
            price: price
        });
    }

    // ตรวจสอบข้อมูลใน orderDetails
    console.log(orderDetails);

    var paymentMethod = document.getElementById('paymentMethod').value;

    if (paymentMethod) {
        var form = document.createElement('form');
        form.method = 'POST';
        form.action = 'record.php';
        
        var paymentInput = document.createElement('input');
        paymentInput.type = 'hidden';
        paymentInput.name = 'payments';
        paymentInput.value = paymentMethod;
        form.appendChild(paymentInput);

        var orderDetailsInput = document.createElement('input');
        orderDetailsInput.type = 'hidden';
        orderDetailsInput.name = 'orderDetails';
        orderDetailsInput.value = JSON.stringify(orderDetails);
        form.appendChild(orderDetailsInput);
        
        document.body.appendChild(form);
        form.submit();
    } else {
        alert('กรุณาเลือกวิธีการชำระเงิน');
    }
});















    // // ฟังก์ชันสำหรับเพิ่มตัวเลขไปยังหน้าจอ
    // function addToDisplay(value) {
    //     let display = document.getElementById('display');
    //     if (display.value === '0') {
    //         display.value = value;
    //     } else {
    //         display.value += value;
    //     }
    // }

    //     // ฟังก์ชันสำหรับเพิ่มตัวเลขไปยังหน้าจอ
    //     function addToDisplay(value) {
    //     let display = document.getElementById('display');
    //     if (display.value === '0') {
    //         display.value = value;
    //     } else {
    //         display.value += value;
    //     }
    // }

    // // ฟังก์ชันสำหรับเรียกใช้เมื่อกดปุ่มเลข
    // function addNumber(value) {
    //     addToDisplay(value);
    // }

    // // ฟังก์ชันสำหรับลบตัวเลขสุดท้าย
    // function deleteLastChar() {
    //     let display = document.getElementById('display');
    //     display.value = display.value.slice(0, -1) || '0';
    // }

    // // ฟังก์ชันสำหรับดำเนินการเมื่อกดปุ่ม "เต็ม"
    // function handleAction() {
    //     // คุณสามารถใส่โค้ดที่ต้องการทำเมื่อกดปุ่ม "เต็ม" ได้ที่นี่
    //     alert("ดำเนินการแล้ว: " + document.getElementById('display').value);
    // }


// const display = document.querySelector(".display");
// const buttons = document.querySelectorAll("button");
// const specialChars = ["%", "*", "/", "-", "+", "="];
// let output = "";

// //Define function to calculate based on button clicked.
// const calculate = (btnValue) => {
//   display.focus();
//   if (btnValue === "=" && output !== "") {
//     //If output has '%', replace with '/100' before evaluating.
//     output = eval(output.replace("%", "/100"));
//   } else if (btnValue === "AC") {
//     output = "";
//   } else if (btnValue === "DEL") {
//     //If DEL button is clicked, remove the last character from the output.
//     output = output.toString().slice(0, -1);
//   } else {
//     //If output is empty and button is specialChars then return
//     if (output === "" && specialChars.includes(btnValue)) return;
//     output += btnValue;
//   }
//   display.value = output;
// };

// //Add event listener to buttons, call calculate() on click.
// buttons.forEach((button) => {
//   //Button click listener calls calculate() with dataset value as argument.
//   button.addEventListener("click", (e) => calculate(e.target.dataset.value));
// });



// ฟังก์ชันสำหรับคำนวณราคารวม
function calculateTotalPrice() {
    let totalPrice = 0;
    let rows = document.querySelectorAll('#order-list tr');

    rows.forEach(row => {
        let quantity = parseInt(row.querySelector('.quantity').textContent);
        let price = parseFloat(row.querySelector('.price').textContent.replace(/[^0-9.-]+/g, ""));
        totalPrice += quantity * price; // ต้องคูณด้วยจำนวนสินค้าที่ขาย
    });

    return totalPrice; // ส่งคืนราคารวม
}

// ฟังก์ชันที่เรียกเมื่อเลือกวิธีการชำระเงิน
document.getElementById('paymentMethod').addEventListener('change', function() {
    var selectedValue = this.value;
    var qrCodeContainer = document.getElementById('qrCodeContainer');
    var qrCodeImage = document.getElementById('qrCodeImage');
    var calContainer = document.getElementById('calContainer');

    if (selectedValue == '2') { // 2 คือ paymethod_id ของ PromtPay
        var totalPrice = calculateTotalPrice().toFixed(2); // คำนวณราคารวมและรูปแบบทศนิยมสองตำแหน่ง
        qrCodeImage.src = `https://promptpay.io/0955426971/${totalPrice}.png?filename=QRCode_${totalPrice}.png`; // ใช้ราคารวมเป็นชื่อไฟล์
        qrCodeContainer.style.display = 'block'; // แสดง QR Code
        calContainer.style.display = 'none'; // ซ่อน Calculator Container
    } else if (selectedValue == '1') { // 1 คือ paymethod_id ของ Cash
        qrCodeContainer.style.display = 'none'; // ซ่อน QR Code
        calContainer.style.display = 'block'; // แสดง Calculator Container
        
        // แสดงค่าเริ่มต้นใน display
        const display = document.querySelector(".display");
        display.value = '0'; // ตั้งค่าเริ่มต้นเป็น 0

        const buttons = document.querySelectorAll("button");
        const specialChars = ["%", "*", "/", "-", "+", "="];
        let output = "";

        // Define function to calculate based on button clicked.
        const calculate = (btnValue) => {
            display.focus();
            if (btnValue === "=") {
                // คำนวณเมื่อกด '='
                let totalPrice = calculateTotalPrice().toFixed(2);
                output = totalPrice; // นำราคาที่คำนวณได้มาแสดง
            } else if (btnValue === "AC") {
                output = "";
            } else if (btnValue === "DEL") {
                output = output.toString().slice(0, -1);
            } else {
                // If output is empty and button is specialChars then return
                if (output === "" && specialChars.includes(btnValue)) return;
                output += btnValue;
            }
            display.value = output;
        };

        // Add event listener to buttons, call calculate() on click.
        buttons.forEach((button) => {
            button.addEventListener("click", (e) => calculate(e.target.dataset.value));
        });

    } else {
        qrCodeContainer.style.display = 'none'; // ซ่อน QR Code
        calContainer.style.display = 'none'; // ซ่อน Calculator Container
    }
});

// ฟังก์ชันคำนวณเมื่อกดปุ่ม "เต็ม"
function calculateTotal() {
    let totalPrice = calculateTotalPrice();
    document.getElementById('display').value = totalPrice; // แสดงราคารวมในเครื่องคิดเลข
}

// ฟังก์ชันที่เรียกเมื่อปิดหรือออกจาก modal
document.getElementById('paymentModal').addEventListener('hide.bs.modal', function() {
    document.getElementById('paymentMethod').value = '1'; // ตั้งค่า select เป็น id 1
    document.getElementById('qrCodeImage').src = ''; // เคลียร์ QR Code
    document.getElementById('qrCodeContainer').style.display = 'none'; // ซ่อน QR Code
    document.getElementById('calContainer').style.display = 'block'; // แสดง Calculator Container

    const display = document.querySelector(".display");
    display.value = '0'; // ตั้งค่า display เป็น 0 เมื่อปิด modal
});








// ฟังก์ชันคำนวณราคารวม (ต้องสร้างฟังก์ชันนี้ให้ทำงานได้ตามต้องการ)







          //เครื่องคิดเลข
//           document.addEventListener('DOMContentLoaded', function() {
//     const resultField = document.getElementById('result');
//     const buttons = document.querySelectorAll('#calcu input[type="button"]');

//     buttons.forEach(button => {
//         button.addEventListener('click', function() {
//             const value = this.value;

//             if (value === 'เต็ม') {
//                 // Calculate and display result
//                 try {
//                     resultField.value = eval(resultField.value);
//                 } catch (e) {
//                     resultField.value = 'Error';
//                 }
//             } else if (value === 'ลบ') {
//                 // Remove the last character from the result field
//                 if (resultField.value.length > 1) {
//                     resultField.value = resultField.value.slice(0, -1);
//                 } else {
//                     resultField.value = '0'; // Reset to 0 if only one character left
//                 }
//             } else {
//                 // Append value to result field
//                 if (resultField.value === '0') {
//                     resultField.value = value;
//                 } else {
//                     resultField.value += value;
//                 }
//             }
//         });
//     });
// });







function addToResult(value) {
            let result = document.getElementById("result");
            if (result.value === "0" && value !== ".") {
                result.value = value; // แสดงค่าที่กดแทนที่ 0
            } else {
                result.value += value; // เพิ่มค่าที่กดเข้ามา
            }
        }

        function deleteLastChar() {
            let result = document.getElementById("result");
            if (result.value.length > 1) {
                result.value = result.value.slice(0, -1); // ลบตัวเลขตัวสุดท้าย
            } else {
                result.value = "0"; // ถ้าลบแล้วเหลือเพียงตัวเลขเดียว ให้แสดงเป็น 0
            }
        }

        // function calculateTotal() {
        //     // ตัวอย่างการคำนวณ: แสดงผลรวมของค่าที่กรอก
        //     let result = document.getElementById("result");
        //     try {
        //         // คำนวณค่าผลลัพธ์ ถ้าค่าที่กรอกเป็นการคำนวณที่ถูกต้อง
        //         result.value = eval(result.value);
        //     } catch {
        //         result.value = "Error"; // แสดงข้อความผิดพลาด
        //     }
        // }



});







// let display = document.getElementById('display');
//         let totalDisplay = document.getElementById('totalDisplay');
//         let actionButton = document.getElementById('actionButton');
//         let total = 0;
//         let isPaymentMode = false;

//         function addNumber(num) {
//             if (display.value === '0' && num !== '.') {
//                 display.value = num;
//             } else {
//                 display.value += num;
//             }
//         }

//         function deleteLastChar() {
//             if (display.value.length === 1) {
//                 display.value = '0';
//             } else {
//                 display.value = display.value.slice(0, -1);
//             }
//         }

//         function handleAction() {
//             if (!isPaymentMode) {
//                 เมื่อกดปุ่ม "เต็ม"
//                 total = parseFloat(display.value);
//                 totalDisplay.textContent = `ยอดที่ต้องชำระ: ${total.toFixed(2)} บาท`;
//                 display.value = '0';
//                 actionButton.textContent = 'คำนวณ';
//                 isPaymentMode = true;
//             } else {
//                 เมื่อกดปุ่ม "คำนวณ"
//                 let payment = parseFloat(display.value);
//                 let change = payment - total;
                
//                 if (change >= 0) {
//                     display.value = change.toFixed(2);
//                     totalDisplay.textContent = `เงินทอน: ${change.toFixed(2)} บาท`;
//                 } else {
//                     display.value = 'ยอดเงินไม่พอ';
//                     setTimeout(() => {
//                         display.value = payment.toFixed(2);
//                     }, 1000);
//                 }
                
//                 actionButton.textContent = 'เต็ม';
//                 isPaymentMode = false;
//             }
//         }




</script>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</body>
<!-- [Body] end -->

</html>