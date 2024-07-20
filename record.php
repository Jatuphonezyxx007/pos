<meta charset="utf-8">
<?php
	@session_start();
	include("connectdb.php");
	
		foreach($_SESSION['sid'] as $pid) {
			$sum[$pid] = $_SESSION['sprice'][$pid] * $_SESSION['sitem'][$pid] ;
			@$total += $sum[$pid] ;
		}
	
	$sql = "insert into `orders` values('', '$total', CURRENT_TIMESTAMP, '{$_POST['payments']}');" ;
	mysqli_query($conn, $sql) or die ("insert error") ;
	$id = mysqli_insert_id($conn);
	
	foreach($_SESSION['sid'] as $pid) {
		$sql2 = "insert into orders_detail values('', '$id', '".$_SESSION['sid'][$pid]."', '".$_SESSION['sitem'][$pid]."');" ;
		mysqli_query($conn, $sql2);
	}

	// ล้างค่าในเซสชัน
session_unset(); // ล้างตัวแปรทั้งหมดในเซสชัน
session_destroy(); // ทำลายเซสชัน

echo "<meta http-equiv=\"refresh\" content=\"0;URL=sale.php\">";
?>