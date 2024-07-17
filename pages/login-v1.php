<?php
session_start();

?>


<!DOCTYPE html>
<html lang="en">
<!-- [Head] start -->

<head>
  <title>Login | Gradient Able Dashboard Template</title>
  <!-- [Meta] -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="description" content="Gradient Able is trending dashboard template made using Bootstrap 5 design framework. Gradient Able is available in Bootstrap, React, CodeIgniter, Angular,  and .net Technologies.">
  <meta name="keywords" content="Bootstrap admin template, Dashboard UI Kit, Dashboard Template, Backend Panel, react dashboard, angular dashboard">
  <meta name="author" content="codedthemes">

  <!-- [Favicon] icon -->
  <link rel="icon" href="../assets/images/favicon.svg" type="image/x-icon"> <!-- [Google Font : Poppins] icon -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

<!-- Google Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Thai+Looped:wght@500&display=swap" rel="stylesheet">

<!-- [Tabler Icons] https://tablericons.com -->
<link rel="stylesheet" href="../assets/fonts/tabler-icons.min.css" >
<!-- [Feather Icons] https://feathericons.com -->
<link rel="stylesheet" href="../assets/fonts/feather.css" >
<!-- [Font Awesome Icons] https://fontawesome.com/icons -->
<link rel="stylesheet" href="../assets/fonts/fontawesome.css" >
<!-- [Material Icons] https://fonts.google.com/icons -->
<link rel="stylesheet" href="../assets/fonts/material.css" >
<!-- [Template CSS Files] -->
<link rel="stylesheet" href="../assets/css/style.css" id="main-style-link" >
<link rel="stylesheet" href="../assets/css/style-preset.css" >

<style>
  body {
font-family: "IBM Plex Sans Thai Looped", sans-serif;
}
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

  <div class="auth-main v1 bg-grd-primary">
    <div class="auth-wrapper">
      <div class="auth-form">
        <div class="card my-5">
          <div class="card-body">
            <div class="text-center">
              <img src="../assets/images/logo-dark.svg" alt="images" class="img-fluid mb-4">
              <h4 class="f-w-500 mb-1">เข้าสู่ระบบ</h4>
              <p class="mb-4">หากลืมรหัสผ่านโปรดติดต่อ 
                <!-- <a href="../pages/register-v1.html" class="link-primary ms-1">Create Account</a> -->
              </p>
            </div>
            
            <form method="post" action="">
            <div class="form-group mb-3">
              <input type="text" class="form-control" id="floatingInput" name="usr" placeholder="รหัสพนักงาน">
            </div>
            <div class="form-group mb-3">
              <input type="password" class="form-control" id="floatingInput1" name="pwd" placeholder="รหัสผ่าน">
            </div>

            <!-- <div class="d-flex mt-1 justify-content-between align-items-center">
              <div class="form-check">
                <input class="form-check-input input-primary" type="checkbox" id="customCheckc1" checked="">
                <label class="form-check-label text-muted" for="customCheckc1">Remember me?</label>
              </div>
              <a href="../pages/forgot-password-v1.html"><h6 class="f-w-400 mb-0">Forgot Password?</h6></a>
            </div> -->

            <div class="d-grid mt-4">
              <button type="submit" class="btn btn-primary" name="Submit">Login</button>
            </div>

            </form>

             <!-- <div class="saprator my-3">
              <span>Or continue with</span>
            </div> -->

            <!-- <div class="text-center">
              <ul class="list-inline mx-auto mt-3 mb-0">
                <li class="list-inline-item">
                  <a href="https://www.facebook.com/" class="avtar avtar-s rounded-circle bg-facebook" target="_blank">
                    <i class="fab fa-facebook-f text-white"></i>
                  </a>
                </li>
                <li class="list-inline-item">
                  <a href="https://twitter.com/" class="avtar avtar-s rounded-circle bg-twitter" target="_blank">
                    <i class="fab fa-twitter text-white"></i>
                  </a>
                </li>
                <li class="list-inline-item">
                  <a href="https://myaccount.google.com/" class="avtar avtar-s rounded-circle bg-googleplus" target="_blank">
                    <i class="fab fa-google text-white"></i>
                  </a>
                </li>
              </ul>
            </div> -->

          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- [ Main Content ] end -->
  <!-- Required Js -->
  <script src="../assets/js/plugins/popper.min.js"></script>
  <script src="../assets/js/plugins/simplebar.min.js"></script>
  <script src="../assets/js/plugins/bootstrap.min.js"></script>
  <script src="../assets/js/fonts/custom-font.js"></script>
  <script src="../assets/js/pcoded.js"></script>
  <script src="../assets/js/plugins/feather.min.js"></script>


  <?php
if(isset($_POST['Submit'])){
    include("connectdb.php");
    $sql = "SELECT * FROM `admin` WHERE `a_usr`='{$_POST['usr']}' AND `a_pwd`='".md5($_POST['pwd'])."' LIMIT 1 ";
    $rs = mysqli_query($conn, $sql) or die ("select ไม่ได้");
    $num = mysqli_num_rows($rs);
    //var_dump($num); 
    if($num>0){
        $data = mysqli_fetch_array($rs);
        $_SESSION['aid'] = $data['a_id'];
        $_SESSION['aname'] = $data['a_name'];
        echo "<script>";
        echo "window.location='../other/sample-page.php';";
        echo "</script>";
    } else {
        echo "<script>";
        echo "alert('รหัสพนักงาน หรือ รหัสผ่าน ไม่ถูกต้อง');";
        echo "</script>";
        exit;
    }
}
?>

  
  
  
  
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