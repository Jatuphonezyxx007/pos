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
		$_SESSION['sdetail'][$id] = $data['detail'];
		$_SESSION['spicture'][$id] = $data['img'];
		@$_SESSION['sitem'][$id]++;
	}


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

  <!-- [Favicon] icon -->
  <!-- <link rel="icon" href="../assets/images/favicon.svg" type="image/x-icon">  -->
  <!-- [Google Font : Poppins] icon -->
<!-- <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet"> -->

<!-- [Tabler Icons] https://tablericons.com -->
<!-- <link rel="stylesheet" href="../assets/fonts/tabler-icons.min.css" > -->
<!-- [Feather Icons] https://feathericons.com -->
<!-- <link rel="stylesheet" href="../assets/fonts/feather.css" > -->
<!-- [Font Awesome Icons] https://fontawesome.com/icons -->
<!-- <link rel="stylesheet" href="../assets/fonts/fontawesome.css" > -->
<!-- [Material Icons] https://fonts.google.com/icons -->
<!-- <link rel="stylesheet" href="../assets/fonts/material.css" > -->

<!-- [Template CSS Files] -->
<link rel="stylesheet" href="../assets/css/style.css" id="main-style-link" >
<link rel="stylesheet" href="../assets/css/style-preset.css" >

<!-- Google Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Thai+Looped:wght@500&display=swap" rel="stylesheet">


  <!-- <link rel="stylesheet" type="text/css" href="style.css"> -->


<!-- Script -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>


<style>
    body {
  font-family: "IBM Plex Sans Thai Looped", sans-serif;
}

    .fixed-col {
      position: fixed;
      top: 70;
      right: 0;
      width: 16.666667%;
      height: 100%;
      background-color: #f8f9fa;
      overflow-y: auto;
      padding: 1rem;
    }
    .fixed-col h1 {
      font-size: 1rem;
      color: black;
    }
/* .order{
position: sticky;
top: 0;
} */
/* .nav-right {
  background-color: lightgrey;
  position: sticky;
}

.nav-right div {
  position: fixed;
  top: 60px;
} */



  </style>


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
      <a href="../dashboard/index.html" class="b-brand text-primary">
        <!-- ========   Change your logo from here   ============ -->
        <img src="../assets/images/logo-white.svg" alt="logo image" class="logo-lg">
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
            <li class="pc-item"><a class="pc-link" href="sample-page.php">หน้าขาย</a></li>
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





        <li class="pc-item pc-hasmenu">
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
        </li>

                <li class="pc-item pc-hasmenu">
          <a href="#!" class="pc-link"
            ><span class="pc-micon">
            <i class="ph ph-package"></i> </span>
            <span class="pc-mtext">สินค้า</span><span class="pc-arrow"><i data-feather="chevron-right"></i></span
          ></a>
          <ul class="pc-submenu">
            <li class="pc-item"><a class="pc-link" href="../products_list.php">รายการสินค้า</a></li>
            <li class="pc-item"><a class="pc-link" href="#!">เพิ่มรายการสินค้า</a></li>
            <li class="pc-item"><a class="pc-link" href="#!">นำเข้า/รับซื้อ</a></li>
          </ul>
        </li>




        <!-- <li class="pc-item pc-caption"> -->


            <!-- <label>UI Components</label> -->
            <!-- <i class="ph ph-compass-tool"></i> -->
        <!-- </li>
        <li class="pc-item">
          <a href="../elements/bc_typography.html" class="pc-link">
            <span class="pc-micon"><i class="ph ph-text-aa"></i></span>
            <span class="pc-mtext">Typography</span>
          </a>
        </li>
        <li class="pc-item">
          <a href="../elements/bc_color.html" class="pc-link">
            <span class="pc-micon"><i class="ph ph-palette"></i></span>
            <span class="pc-mtext">Color</span>
          </a>
        </li>
        <li class="pc-item">
          <a href="../elements/icon-feather.html" class="pc-link">
            <span class="pc-micon"><i class="ph ph-flower-lotus"></i></span>
            <span class="pc-mtext">Icons</span>
          </a>
        </li> -->



        <li class="pc-item pc-caption">
            <label>UI Components</label>
            <i class="ph ph-compass-tool"></i>
        </li>
        <li class="pc-item">
          <a href="../elements/bc_typography.html" class="pc-link">
            <span class="pc-micon"><i class="ph ph-text-aa"></i></span>
            <span class="pc-mtext">Typography</span>
          </a>
        </li>
        <li class="pc-item">
          <a href="../elements/bc_color.html" class="pc-link">
            <span class="pc-micon"><i class="ph ph-palette"></i></span>
            <span class="pc-mtext">Color</span>
          </a>
        </li>
        <li class="pc-item">
          <a href="../elements/icon-feather.html" class="pc-link">
            <span class="pc-micon"><i class="ph ph-flower-lotus"></i></span>
            <span class="pc-mtext">Icons</span>
          </a>
        </li>


        <li class="pc-item pc-caption">
          <label>Pages</label>
          <i class="ph ph-devices"></i>
        </li>
        <li class="pc-item">
          <a href="../pages/login-v1.html" class="pc-link">
            <span class="pc-micon"><i class="ph ph-lock"></i></span>
            <span class="pc-mtext">Login</span>
          </a>
        </li>
        <li class="pc-item">
          <a href="../pages/register-v1.html" class="pc-link">
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
          ><a href="../other/sample-page.html" class="pc-link">
            <span class="pc-micon">
              <i class="ph ph-desktop"></i>
            </span>
            <span class="pc-mtext">Sample page</span></a
          ></li
        >

      </ul>
      <div class="card nav-action-card bg-brand-color-9">
        <div class="card-body" style="background-image: url('../assets/images/layout/nav-card-bg.svg')">

        <!-- <h5 id="clock" class="text-white text-center">00:00:00</h5>
        <h8 class="text-white text-center" id="date"></h8> -->

          <!-- <h5 class="text-white">Upgrade to Pro</h5>
          <p class="text-white text-opacity-75">To get more features and components</p>
          <a href="https://codedthemes.com/item/gradient-able-admin-template/" class="btn btn-light" target="_blank">Buy now</a> -->
        </div>
      </div>
    </div>
  </div>
</nav>
<!-- [ Sidebar Menu ] end --> <!-- [ Header Topbar ] start -->

<header class="pc-header">
  <div class="m-header">

    <a href="sample-page.php" class="b-brand text-primary">
      <!-- ========   Change your logo from here   ============ -->
      <img src="../assets/images/logo/logo_homeware.png" alt="logo image" class="logo-lg" height="45">
    </a>
  </div>

  <div class="header-wrapper"> <!-- [Mobile Media Block] start -->
<div class="me-auto pc-mob-drp">
  <ul class="list-unstyled">
    <!-- ======= Menu collapse Icon ===== -->
    <!-- <li class="pc-h-item pc-sidebar-collapse">
      <a href="#" class="pc-head-link ms-0" id="sidebar-hide">
        <i class="ph ph-list"></i>
      </a>
    </li> -->
    
    <li class="pc-h-item pc-sidebar-popup">
      <a href="#" class="pc-head-link ms-0" id="mobile-collapse">
        <i class="ph ph-list"></i>
      </a>
    </li>

    <li class="dropdown pc-h-item">

      <a class="pc-head-link dropdown-toggle arrow-none m-0" data-bs-toggle="dropdown" href="#" role="button"
        aria-haspopup="false" aria-expanded="false">
        <i class="ph ph-magnifying-glass"></i>
      </a>

      <!-- <form class="p-2 flex-grow-1 bd-highlight">
      <input class="form-control" type="text" placeholder="Default input" aria-label="default input example">          
      <button class="btn btn-outline-success" type="submit">Search</button>
        </form> -->


          <!-- <form class="d-flex">
            <input class="form-control" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-success" type="submit">Search</button>
          </form> -->



      <div class="dropdown-menu pc-h-dropdown drp-search">
        <form method="post" action="" class="px-3" role="search">
          <div class="form-group mb-0 d-flex align-items-center">
            <input type="search" class="form-control border-0 shadow-none" name="src" placeholder="Search here. . .">
            <button class="btn btn-light-secondary btn-search">Search</button>
          </div>
        </form>
      </div>


    </li>

  </ul>
</div>


<!-- [Mobile Media Block end] -->
<div class="ms-auto">
<h7 id="clock" class="text-white text-center">00:00:00</h7>
  <ul class="list-unstyled">
    <li class="dropdown pc-h-item header-user-profile">


    <h8>|</h8>
    <h8 class="text-white text-center" id="date"></h8>


      <a class="pc-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown" href="#" role="button"
        aria-haspopup="false" data-bs-auto-close="outside" aria-expanded="false">
        <img src="../assets/images/user/avatar-2.jpg" alt="user-image" class="user-avtar">
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

<!-- <div class="col-12 col-md-10">
  <div class="pc-container px-1">
    <div class="pc-content">
      <br> 
          <div class="row g-2">
          <?php
                  include("connectdb.php");
                  @$src = $_POST['src'];
                  $sql = "SELECT * FROM `products`  WHERE (`name` LIKE '%{$src}%' OR `detail` LIKE '%{$src}%') ORDER BY `products`.`type` ASC";
                  $rs = mysqli_query($conn, $sql);
                  while ($data = mysqli_fetch_array($rs)){
                    ?>
            <div class="col-sm-12 col-md-3 col-lg-4">
              <div class="card">
                <img src="../assets/images/products/<?=$data['id'];?>.<?=$data['img'];?>" class="card-img-top" alt="" height="350px">
                <div class="card-body">
                  <h8 class="card-title d-inline-block text-truncate" style="max-width: 150px;"><?=$data['name'];?></h8>
                  <p class="card-text"><?= number_format($data['price'], );?> บาท</p>                  
                  <a href="checkout.php?id=<?=$data['id'];?>" class="btn btn-primary">เพิ่มลงตะกร้า</a>
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

  <div class="col-6 col-md-2">
    <div class="pc-container px-1">
      <div class="pc-content">
        <div class="row">
          <h1>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Itaque, delectus provident a, accusamus labore veritatis dolore consequuntur assumenda, exercitationem eum deserunt temporibus error? Optio totam a magnam laborum minima perspiciatis.</h1>
        </div>
      </div>
    </div>
  </div> -->

<div class="col-12 col-md-10">
  <div class="pc-container px-1">
        <div class="pc-content">
          <br> 
          <div class="row g-2">
            <?php
              include("connectdb.php");
              @$src = $_POST['src'];
              $sql = "SELECT * FROM `products`  WHERE (`name` LIKE '%{$src}%' OR `detail` LIKE '%{$src}%') ORDER BY `products`.`type` ASC";
              $rs = mysqli_query($conn, $sql);
              while ($data = mysqli_fetch_array($rs)){
            ?>
            <div class="col-sm-12 col-md-3 col-lg-4">
              <div class="card">
                <img src="../assets/images/products/<?=$data['id'];?>.<?=$data['img'];?>" class="card-img-top" alt="" height="350px">
                <div class="card-body">
                  <h8 class="card-title d-inline-block text-truncate" style="max-width: 150px;"><?=$data['name'];?></h8>
                  <p class="card-text"><?= number_format($data['price'], );?> บาท</p>                  
                  <a href="checkout.php?id=<?=$data['id'];?>" class="btn btn-primary">เพิ่มลงตะกร้า</a>
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

    <div class="col-6 col-md-2 fixed-col">
          <div class="row">
            <center>
            <h1>รายการสินค้า</h1>
            </center>

            <table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">First</th>
      <th scope="col">Last</th>
      <th scope="col">Handle</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">1</th>
      <td>Mark</td>
      <td>Otto</td>
      <td>@mdo</td>
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
            
            <button type="button" class="btn btn-success">ชำระเงิน</button>
          </div>
      </div>



  <!-- [ Main Content ] end -->
  <footer class="pc-footer">
    <div class="footer-wrapper container-fluid">
      <div class="row">

        <!-- <div class="col-sm-6 my-1">
          <p class="m-0">Gradient Able &#9829; crafted by Team <a href="https://codedthemes.com/"
              target="_blank">Codedthemes</a></p>
        </div> -->

        <div class="col-sm-6 ms-auto my-1">
          <ul class="list-inline footer-link mb-0 justify-content-sm-end d-flex">
          <a href="#top" class="text-end">กลับไปบนสุด</a>
          </ul>
        </div>
      </div>
    </div>
  </footer>

  <!-- Required Js -->
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

<!-- <style>
 @import "style.css";
 @import url("style.css");
</style> -->


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
</script>




</body>
<!-- [Body] end -->

</html>