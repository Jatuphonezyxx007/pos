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
		// $_SESSION['sbarcode'][$id] = $data['barcode'];
		// $_SESSION['spicture'][$id] = $data['img'];
		@$_SESSION['sitem'][$id]++;
	}


?>



<!DOCTYPE html>
<html>
<head>
    <title>ข้อมูลตาราง</title>
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

.top{
    padding-top: 50px;
}
  </style>

<link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>
<div class="container top">
          <div class="row">
            <center>
            <h1 class="text-start">รายการสินค้า</h1>
            </center>

            <table class="table">
              <thead>
                <tr>
                  <td width="5%" class="text-center">ที่</td>
                  <td width="70%" class="text-start">สินค้า</td>
                  <td width="10%" class="text-center">จำนวน</td>
                  <td width="15%" class="text-end">ราคา (บาท)</td>
              </tr>
              
              <?php
              if(!empty($_SESSION['sid'])) {
                foreach($_SESSION['sid'] as $pid) {
                  @$i++;
                  $sum[$pid] = $_SESSION['sprice'][$pid] * $_SESSION['sitem'][$pid] ;
                  @$total += $sum[$pid] ;
                  ?>

              <tr>
                  <td style="vertical-align: top;" class="text-center"><?=$i;?></td>
                  <td style="vertical-align: top;" class="text-start"><?=$_SESSION['sname'][$pid];?><br>
                  <!-- <a href="clear_product.php?id=<?=$pid;?>" class="ph ph-trash text-danger"></a> -->
                </td>
                  <td style="vertical-align: top;" class="text-center"><?=$_SESSION['sitem'][$pid];?></td>
                  <td style="vertical-align: top;" class="text-end"><?=number_format($_SESSION['sprice'][$pid],0);?></td>
                </tr>
                <?php } // end foreach ?>

              <tr>
                  <td colspan="2"><strong>รวม</strong></td>
                  <td></td>
                  <td style="vertical-align: top;" class="text-end"><strong><?= number_format($total, 2); ?></strong></td>
                  <td></td>
                  </tr>
                
                <?php 
                } else {
                  ?>
                  
                  <tr>
                    <td colspan="7" height="50" align="center">ไม่มีสินค้าในรายการ</td>
                  </tr>
                  <?php } // end if ?>
            </thead>

          </table>



        </div>
      </div>
</body>

<script>
window.addEventListener('message', function(event) {
    if (event.data === 'refreshTable') {
        console.log('Received refreshTable message. Refreshing table_sale.php');
        // รีเฟรชหน้าปัจจุบัน
        location.reload();
    }
});

// ตรวจสอบสัญญาณการรีเฟรชจาก localStorage เมื่อหน้าโหลด
window.addEventListener('load', function() {
    if (localStorage.getItem('refreshTable') === 'true') {
        console.log('Refreshing table_sale.php because refreshTable is true');

        // ลบสัญญาณการรีเฟรชหลังจากรีเฟรชแล้ว
        localStorage.removeItem('refreshTable');

        // รีเฟรชหน้าปัจจุบัน
        location.reload();
    } else {
        console.log('No refresh needed. refreshTable is false or not set.');
    }
});

    // ฟังก์ชันรีเฟรชหน้า
    function refreshPage() {
        location.reload();
    }

    window.addEventListener('load', function() {
        // ตรวจสอบสัญญาณการรีเฟรชจาก localStorage
        if (localStorage.getItem('refreshTable') === 'true') {
            console.log('Refreshing table_sale.php because refreshTable is true');

            // ลบสัญญาณการรีเฟรชหลังจากรีเฟรชแล้ว
            localStorage.removeItem('refreshTable');

            // รีเฟรชหน้าปัจจุบัน
            refreshPage();
        } else {
            console.log('No refresh needed. refreshTable is false or not set.');
        }
    });

    
</script>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</html>
