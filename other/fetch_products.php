<?php
include("connectdb.php");

if (isset($_POST['query'])) {
  $src = $_POST['query'];
  $sql = "SELECT * FROM `products` WHERE (`barcode` LIKE '%{$src}%' OR `name` LIKE '%{$src}%') ORDER BY `products`.`type_id` ASC";
  $rs = mysqli_query($conn, $sql);
  $output = '';

  while ($data = mysqli_fetch_array($rs)) {
    $output .= '
    <div class="col-sm-12 col-md-3 col-lg-4">
      <div class="card">
        <img src="../assets/images/products_2/'.$data['id'].'.'.$data['img'].'" class="card-img-top" alt="" height="350px">
        <div class="card-body">
          <h8 class="card-title d-inline-block text-truncate" style="max-width: 150px;">'.$data['name'].'</h8>
          <p class="card-text">'.number_format($data['price'], ).' บาท</p>
          <a href="sale.php?id='.$data['id'].'" class="btn btn-primary">เพิ่ม</a>
        </div>
      </div>
    </div>
    ';
  }

  echo $output;
  mysqli_close($conn);
}
?>
