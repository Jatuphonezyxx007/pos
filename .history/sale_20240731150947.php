<?php
error_reporting(E_NOTICE);

	@session_start();
	include("connectdb.php");
	$sql = "select * from products where id ='{$_GET['id']}' ";
	$rs = mysqli_query($conn, $sql) ;
	$data = mysqli_fetch_array($rs);
	$id = $_GET['id'] ;
	
	if(isset($_GET['id'])) {
		$_SESSION['sid'][$id] = $data['id'];
		$_SESSION['sname'][$id] = $data['name'];
		$_SESSION['sprice'][$id] = $data['price'];
		// $_SESSION['ssize'][$id] = $data['size'];
		// $_SESSION['spicture'][$id] = $data['img'];
		@$_SESSION['sitem'][$id]++;
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

    <li class="pc-item">
        <a class="pc-link <?= ($_SERVER['PHP_SELF'] == 'products_manage.php' ? 'active' : '') ?>" href="products_manage.php">จัดการรายการสินค้า</a>
    </li>

</ul>
        </li>

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
<!-- [ Sidebar Menu ] end --> <!-- [ Header Topbar ] start -->

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
            <img src="assets/images/user/avatar-2.jpg" alt="user-image" class="user-avtar">
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
    <div class="col-sm-12 col-md-3 col-lg-4">
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

                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal"
                    data-product-id="<?=$data['id'];?>"
                    data-product-name="<?=$data['name'];?>">
                    เพิ่ม
                </button>

                <!-- Modal -->
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
        <div class="input-group input-group-sm">
            <button class="btn btn-outline-secondary btn-sm" type="button" onclick="decreaseQuantity()"><i class="ph ph-minus-circle"></i></button>
            <input class="form-control form-control-sm mx-2" type="number" id="quantity" min="1" value="1" readonly>
            <button class="btn btn-outline-secondary btn-sm" type="button" onclick="increaseQuantity()"><i class="ph ph-plus-circle"></i></button>
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
    <?php
    }
    mysqli_close($conn);
    ?> 
</div>



        </div>
    </div>
</div>


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

    
    <div class="col-6 col-md-3 fixed-col">
          <div class="row">
            <center>
            <h1>รายการสินค้า</h1>
            </center>

            <div class="table-responsive">
    <table class="table table-sm">
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
                <td class="text-center" id="total-price"><strong>0</strong></td>
            </tr>
        </tfoot>
    </table>
</div>



          <!-- ปุ่มที่กดเพื่อเปิด Modal -->
<p class="d-grid gap-1">
  <button class="btn btn-success" type="button" id="pay-button">
    ชำระเงิน
  </button>
</p>




          <p class="d-inline-flex gap-1">

  <!-- <a href="clear.php" class="btn btn-danger">ล้างทั้งหมด</a> -->

  <a href="#" class="btn btn-danger" onclick="window.location.reload(); return false;">ล้างทั้งหมด</a>

</p>
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
        priceContainer.textContent = totalPrice.toLocaleString() + ' บาท';
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
    let quantityInput = document.getElementById('quantity'); // ค่าของจำนวน
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
        existingRow.querySelector('.price').textContent = newPrice.toLocaleString() + ' บาท';
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
    $('#exampleModal').modal('hide');
});

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

    document.getElementById('total-price').textContent = total.toLocaleString();
}

document.getElementById('pay-button').addEventListener('click', function(event) {
    event.preventDefault(); // ป้องกันการรีเฟรชหน้า
    var paymentModal = new bootstrap.Modal(document.getElementById('paymentModal'));
    paymentModal.show(); // แสดง modal
});



document.getElementById('paymentButton').addEventListener('click', function() {
    // รับค่าจากตาราง
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

    // รับค่าจากวิธีการชำระเงินที่เลือก
    var paymentMethod = document.getElementById('paymentMethod').value;

    if (paymentMethod) {
        // สร้างฟอร์มแบบไดนามิก
        var form = document.createElement('form');
        form.method = 'POST';
        form.action = 'record.php';
        
        // เพิ่มข้อมูลการชำระเงิน
        var paymentInput = document.createElement('input');
        paymentInput.type = 'hidden';
        paymentInput.name = 'payments';
        paymentInput.value = paymentMethod;
        form.appendChild(paymentInput);

        // เพิ่มข้อมูลการสั่งซื้อ
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





// ฟังก์ชันสำหรับคำนวณราคารวม
function calculateTotalPrice() {
    let totalPrice = 0;
    let rows = document.querySelectorAll('#order-list tr');

    rows.forEach(row => {
        let quantity = parseInt(row.querySelector('.quantity').textContent);
        let price = parseFloat(row.querySelector('.price').textContent.replace(/[^0-9.-]+/g, ""));
        totalPrice += price;
    });

    return totalPrice.toLocaleString(); // ใช้ใน URL จะได้ราคารวมที่ไม่ใช้จุดทศนิยม
}

// ฟังก์ชันที่เรียกเมื่อเลือกวิธีการชำระเงิน
document.getElementById('paymentMethod').addEventListener('change', function() {
    var selectedValue = this.value;
    var qrCodeContainer = document.getElementById('qrCodeContainer');
    var qrCodeImage = document.getElementById('qrCodeImage');

    if (selectedValue == '2') { // 2 คือ paymethod_id ของ PromtPay
        var totalPrice = calculateTotalPrice();
        qrCodeImage.src = `https://promptpay.io/0955426971/${totalPrice}.png`; // เปลี่ยน URL ให้มีราคารวม
        qrCodeContainer.style.display = 'block'; // แสดง QR Code
    } else {
        qrCodeContainer.style.display = 'none'; // ซ่อน QR Code
    }
});

// ฟังก์ชันที่เรียกเมื่อปิดหรือออกจาก modal
document.getElementById('paymentModal').addEventListener('hide.bs.modal', function() {
    document.getElementById('paymentMethod').value = '1'; // ตั้งค่า select เป็น id 1
    document.getElementById('qrCodeImage').src = ''; // เคลียร์ QR Code
    document.getElementById('qrCodeContainer').style.display = 'none'; // ซ่อน QR Code
});




});







</script>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>

</body>
<!-- [Body] end -->

</html>