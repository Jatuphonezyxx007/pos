<?php
session_start();
include('connectdb.php');

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

// รับ emp_id และ paymethod_id จากฟอร์ม
$selected_type_id = isset($_POST['type_id']) ? $_POST['type_id'] : 0;
$selected_emp_id = isset($_POST['emp_id']) ? $_POST['emp_id'] : 0;
$selected_paymethod_id = isset($_POST['paymethod_id']) ? $_POST['paymethod_id'] : 0;
$selected_date = isset($_POST['selected_date']) ? $_POST['selected_date'] : '';

$sql = "SELECT e.emp_id, e.emp_name, DATE_FORMAT(o.order_date, '%d-%m-%Y') as formatted_date, SUM(o.order_total) as total_sales 
        FROM orders o
        JOIN orders_detail od ON o.order_id = od.order_id
        JOIN products p ON od.p_id = p.id
        JOIN employees e ON o.emp_id = e.emp_id
        JOIN type t ON p.type_id = t.type_id
        WHERE 1=1"; // เพื่อให้สามารถเติมเงื่อนไขได้

if (!empty($selected_date)) {
    $sql .= " AND DATE(o.order_date) = '$selected_date'";
}

if ($selected_type_id != 0) {
    $sql .= " AND t.type_id = $selected_type_id";
}

if ($selected_emp_id != 0) {
    $sql .= " AND o.emp_id = $selected_emp_id";
}

if ($selected_paymethod_id != 0) {
    $sql .= " AND o.paymethod_id = $selected_paymethod_id";
}

$sql .= " GROUP BY e.emp_id, formatted_date ORDER BY formatted_date, e.emp_id";






// if ($selected_date) {
//   $sql = "SELECT HOUR(o.order_time) AS sale_hour, SUM(od.quantity * od.price) AS total_sales
//           FROM orders o
//           JOIN order_detail od ON o.order_id = od.order_id
//           WHERE DATE(o.order_date) = '$selected_date'
//           GROUP BY sale_hour
//           ORDER BY sale_hour ASC";

//   $result = mysqli_query($conn, $sql);

//   $hours = [];
//   $sales = [];

//   while ($row = mysqli_fetch_assoc($result)) {
//       $hours[] = $row['sale_hour'];
//       $sales[] = $row['total_sales'];
//   }
// }

// $sql .= " GROUP BY formatted_date ORDER BY o.order_date";


$result = $conn->query($sql);

// $dates = [];
// $sales = [];
// $employees = [];

// // ตรวจสอบว่า query ดึงข้อมูลมาได้หรือไม่
// if ($result->num_rows > 0) {
//     while($row = $result->fetch_assoc()) {
//         // แปลงรูปแบบวันที่จาก Datetime เป็น DD/MM/YY
//         $date = $row['formatted_date']; // สมมติว่า 'formatted_date' เป็น Datetime
//         $formatted_date = date('d/m/y', strtotime($date)); // แปลงวันที่

//         $dates[] = $formatted_date;
//         $emp_id = $row['emp_id'];
//         $emp_name = $row['emp_name'];
        
//         if (!isset($sales[$emp_id])) {
//             $sales[$emp_id] = [];
//         }

//         $sales[$emp_id][$formatted_date] = $row['total_sales']; // ใช้ $formatted_date

//         if (!isset($employees[$emp_id])) {  // แก้ไขตรงนี้
//             $employees[$emp_id] = $emp_name; // แก้ไขตรงนี้
//         }
//     }
// }


// $datasets = [];
// $colors = ['rgb(75, 192, 192)', 'rgb(153, 102, 255)', 'rgb(255, 159, 64)', 'rgb(255, 99, 132)', 'rgb(0, 50, 133)', 'rgb(231, 41, 41)']; 

// foreach ($sales as $emp_id => $sales_data) {
//     // เช็คว่ามียอดขายหรือไม่
//     $total_sales = array_sum($sales_data);  // รวมยอดขายของพนักงานแต่ละคน
//     if ($total_sales > 0) {  // ถ้ามียอดขายมากกว่า 0 จึงเพิ่มในกราฟ
//         $datasets[] = [
//             'label' => $employees[$emp_id],  // แสดงชื่อพนักงานตาม emp_id
//             'data' => array_values(array_map(function($date) use ($sales_data) {
//                 return isset($sales_data[$date]) ? $sales_data[$date] : 0;
//             }, $dates)),
//             'fill' => false,
//             'borderColor' => $colors[array_search($emp_id, array_keys($sales)) % count($colors)],
//             'tension' => 0.1
//         ];
//     }
// }

// เก็บค่าเดือนและปีปัจจุบัน
$current_month = date('m');
$current_year = date('Y');

// SQL query เพื่อดึงข้อมูลยอดขายรวมในเดือนปัจจุบัน
$sql = "
    SELECT 
        o.emp_id,
        e.emp_name,
        DATE_FORMAT(o.order_date, '%d/%m/%Y') AS formatted_date,
        SUM(o.order_total) AS total_sales
    FROM orders o
    JOIN employees e ON o.emp_id = e.emp_id
    WHERE MONTH(o.order_date) = $current_month AND YEAR(o.order_date) = $current_year
    GROUP BY o.emp_id, formatted_date
    ORDER BY o.emp_id, formatted_date";
$result = $conn->query($sql);

$dates = [];
$sales = [];
$employees = [];

// ตรวจสอบว่า query ดึงข้อมูลมาได้หรือไม่
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $formatted_date = $row['formatted_date'];
        
        if (!in_array($formatted_date, $dates)) {
            $dates[] = $formatted_date; // เพิ่มวันที่ถ้ายังไม่ถูกเก็บไว้
        }

        $emp_id = $row['emp_id'];
        $emp_name = $row['emp_name'];

        if (!isset($sales[$emp_id])) {
            $sales[$emp_id] = [];
        }

        $sales[$emp_id][$formatted_date] = $row['total_sales'];

        if (!isset($employees[$emp_id])) {
            $employees[$emp_id] = $emp_name;
        }
    }
}

// ทำให้วันที่ไม่ซ้ำกันและเรียงลำดับ
$dates = array_unique($dates);
sort($dates);  // เรียงลำดับวันที่


$datasets = [];
$colors = ['rgb(75, 192, 192)', 'rgb(153, 102, 255)', 'rgb(255, 159, 64)', 'rgb(255, 99, 132)', 'rgb(0, 50, 133)', 'rgb(231, 41, 41)'];

foreach ($sales as $emp_id => $sales_data) {
    // เช็คว่ามียอดขายหรือไม่
    $total_sales = array_sum($sales_data);  // รวมยอดขายของพนักงานแต่ละคน
    if ($total_sales > 0) {  // ถ้ามียอดขายมากกว่า 0 จึงเพิ่มในกราฟ
        $datasets[] = [
            'label' => $employees[$emp_id],  // แสดงชื่อพนักงานตาม emp_id
            'data' => array_values(array_map(function($date) use ($sales_data) {
                return isset($sales_data[$date]) ? $sales_data[$date] : 0;
            }, $dates)),
            'fill' => false,
            'borderColor' => $colors[array_search($emp_id, array_keys($sales)) % count($colors)],
            'tension' => 0.1
        ];
    }
}








// ดึงยอดขายรวมทั้งหมด
$sql_total_sales = "SELECT SUM(order_total) AS total_sales FROM orders";
$result_total_sales = $conn->query($sql_total_sales);

$total_sales = 0;
if ($result_total_sales->num_rows > 0) {
    $row_total_sales = $result_total_sales->fetch_assoc();
    $total_sales = $row_total_sales['total_sales'];
}




// ดึงยอดขายรวมทั้งหมด
$sql_total_sales = "SELECT SUM(order_total) AS total_sales FROM orders";
$result_total_sales = $conn->query($sql_total_sales);

$total_sales = 0;
if ($result_total_sales->num_rows > 0) {
    $row_total_sales = $result_total_sales->fetch_assoc();
    $total_sales = $row_total_sales['total_sales'];
}


// ดึงจำนวนการขายทั้งหมด
$sql_total_sales_count = "SELECT COUNT(*) AS total_sales_count FROM orders";
$result_total_sales_count = $conn->query($sql_total_sales_count);

$total_sales_count = 0;
if ($result_total_sales_count->num_rows > 0) {
    $row_total_sales_count = $result_total_sales_count->fetch_assoc();
    $total_sales_count = $row_total_sales_count['total_sales_count'];
}




// ดึงจำนวนสินค้าคงเหลือทั้งหมดจากตาราง size
$sql_total_qty = "SELECT SUM(qty) AS total_qty FROM size";
$result_total_qty = $conn->query($sql_total_qty);

$total_qty = 0;
if ($result_total_qty->num_rows > 0) {
    $row_total_qty = $result_total_qty->fetch_assoc();
    $total_qty = $row_total_qty['total_qty'];
}


// Query รวมยอดขายของพนักงานแต่ละคนในเดือนปัจจุบัน แล้วหาพนักงานที่มียอดขายสูงสุด
$sql_max_sales_emp = "
    SELECT o.emp_id, e.emp_name, SUM(o.order_total) AS total_sales
    FROM orders o
    JOIN employees e ON o.emp_id = e.emp_id
    WHERE MONTH(o.order_date) = MONTH(CURRENT_DATE())  -- เงื่อนไขเดือนปัจจุบัน
    AND YEAR(o.order_date) = YEAR(CURRENT_DATE())  -- เงื่อนไขปีปัจจุบัน
    GROUP BY o.emp_id  -- รวมยอดขายตามพนักงาน
    ORDER BY total_sales DESC  -- จัดเรียงยอดขายจากมากไปน้อย
    LIMIT 1";  // จำกัดให้ดึงพนักงานที่มียอดขายรวมสูงสุด

$result_max_sales_emp = $conn->query($sql_max_sales_emp);

if ($result_max_sales_emp->num_rows > 0) {
    $row_max_sales_emp = $result_max_sales_emp->fetch_assoc();
    $max_total_sales = $row_max_sales_emp['total_sales'];  // ยอดขายรวมมากที่สุด
    $emp_name = $row_max_sales_emp['emp_name'];  // ชื่อพนักงานที่มียอดขายสูงสุด
    $emp_id = $row_max_sales_emp['emp_id'];  // ID พนักงาน
}

// SQL query เพื่อคำนวณยอดขายรวมของเดือนปัจจุบัน
$sql_total_sales = "
    SELECT SUM(order_total) AS total_sales
    FROM orders
    WHERE MONTH(order_date) = $current_month
    AND YEAR(order_date) = $current_year";
$result_total_sales = $conn->query($sql_total_sales);

$total_sales = 0;
$total_days = 0;

if ($result_total_sales->num_rows > 0) {
    $row_total_sales = $result_total_sales->fetch_assoc();
    $total_sales = $row_total_sales['total_sales'];
}

$conn->close();
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


<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.min.js" integrity="sha512-L0Shl7nXXzIlBSUUPpxrokqq4ojqgZFQczTYlGjzONGTDAcLremjwaWv5A+EDLnxhQzY5xUZPWLOLqYRkY0Cbw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

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
        > -->

      </ul>
      <!-- <div class="card nav-action-card bg-brand-color-9">
        <div class="card-body" style="background-image: url('assets/images/layout/nav-card-bg.svg')">

        </div>
      </div> -->
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
  <div class="col-12 col-md-12">
        <div class="pc-container px-1">
            <div class="pc-content">

                
                <div class="col-12 col-md-12">
                <h5>Dashboard</h5>
                </div>

                <div class="row">

                <div class="col-md-6 col-xl-3">
    <div class="card bg-grd-danger order-card">
        <div class="card-body">
            <h6 class="text-white">ยอดขายรวม</h6>
            <h2 class="text-end text-white fs-3"><i class="feather icon-shopping-cart float-start"></i><span><?php echo number_format($total_sales, 2); ?> บาท</span></h2>
            <p class="m-b-0">รายการสินค้าที่ขายไปทั้งหมด<span class="float-end"><?php echo number_format($total_sales_count,); ?></span></p>
        </div>
    </div>
</div>
<div class="col-md-6 col-xl-3">
    <div class="card bg-grd-success order-card">
        <div class="card-body">
            <h6 class="text-white">จำนวนสินค้าพร้อมขายในสต๊อก</h6>
            <h2 class="text-end text-white fs-3"><i class="feather icon-tag float-start"></i><span><?php echo number_format($total_qty); ?> ชิ้น</span></h2>
            <p class="m-b-0"><span class="float-end">&nbsp;</span></p>
        </div>
    </div>
</div>
        <div class="col-md-6 col-xl-3">
          <div class="card bg-grd-warning order-card">
            <div class="card-body">
              <h6 class="text-white">ยอดขายมากที่สุด</h6>
              <h2 class="text-end text-white"><i class="feather icon-repeat float-start"></i><span><?php echo number_format($max_total_sales, decimals:2); ?> บาท</span></h2>
              <p class="m-b-0">พนักงานขาย<span class="float-end"><?php echo ($emp_name); ?></span></p>
            </div>
          </div>
        </div>

        <div class="col-md-6 col-xl-3">
          <div class="card bg-grd-primary order-card">
            <div class="card-body">
              <h6 class="text-white">ยอดขายเฉลี่ย</h6>
              <h2 class="text-end text-white"><i class="feather icon-award float-start"></i><span>$9,562</span></h2>
              <p class="m-b-0">This Month<span class="float-end">$542</span></p>
            </div>
          </div>
        </div>
        <!-- Recent Orders end -->
      </div>


      
                <br>

                <form action="" method="post">

                <div class="row">

                <div class="col-2 col-md-2">
                <select class="form-select" name="type_id" aria-label="Default select example">
        <option value="0">ประเภทสินค้า</option>
        <?php
        include("connectdb.php");

        // ดึงชื่อพนักงานจากตาราง employees
        $sql = "SELECT * FROM type";
        $result = mysqli_query($conn, $sql);

        while ($row = mysqli_fetch_array($result)) {
          $type_id = $row['type_id'];
          ?>
          <option value="<?=$type_id;?>" <?=($selected_type_id == $type_id) ? 'selected' : '';?>>
            <?=$row['type_name'];?>
          </option>
        <?php } ?>
      </select>
                </div>

                <div class="col-2 col-md-2">
                <select class="form-select" name="paymethod_id" aria-label="Default select example">
        <option value="0">การชำระเงิน</option>
        <?php
        include("connectdb.php");

        // ดึงชื่อพนักงานจากตาราง employees
        $sql = "SELECT paymethod_id, paymethod_name FROM paymethod";
        $result = mysqli_query($conn, $sql);

        while ($row = mysqli_fetch_array($result)) {
          $paymethod_id = $row['paymethod_id'];
          ?>
          <option value="<?=$paymethod_id;?>" <?=($selected_paymethod_id == $paymethod_id) ? 'selected' : '';?>>
            <?=$row['paymethod_name'];?>
          </option>
        <?php } ?>
      </select>
                </div>

                <div class="col-2 col-md-2">
                
                <select class="form-select" name="emp_id" aria-label="Default select example">
        <option value="0">พนักงานทั้งหมด</option>
        <?php
        include("connectdb.php");

        // ดึงชื่อพนักงานจากตาราง employees
        $sql = "SELECT emp_id, emp_name FROM employees";
        $result = mysqli_query($conn, $sql);

        while ($row = mysqli_fetch_array($result)) {
          $emp_id = $row['emp_id'];
          ?>
          <option value="<?=$emp_id;?>" <?=($selected_emp_id == $emp_id) ? 'selected' : '';?>>
            <?=$row['emp_name'];?>
          </option>
        <?php } ?>
      </select>
                </div>

                <div class="col-2 col-md-2">
    <input class="form-control" type="date" name="selected_date" placeholder="เลือกวัน">
</div>


                <div class="col-4 col-md-4 d-flex justify-content-end">
      <button class="btn btn-primary text-white" type="submit">ค้นหา</button>
    </div>

                </div>
                </form>

                <br>



                <div class="card">
            <div class="card-header">
            </div>
            <div class="card-body">
              <div id="world-map-markers" class="set-map" style="height:365px;">
              <canvas id="myChart" style="width: 100%; height: 100%;"></canvas>
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


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>



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

  
};






const labels = <?php echo json_encode($dates); ?>;
    const datasets = <?php echo json_encode($datasets); ?>;

    const data = {
        labels: labels,
        datasets: datasets
    };

    const config = {
        type: 'line',
        data: data,
    };

    const ctx = document.getElementById('myChart').getContext('2d');
    new Chart(ctx, config);



</script>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>



</body>

</body>
<!-- [Body] end -->

</html>