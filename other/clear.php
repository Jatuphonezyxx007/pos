<?php
	@session_start();
	session_destroy();
	echo "กำลังลบรายการสินค้า กรุณารอสักครู่";
	echo "<meta http-equiv=\"refresh\" content=\"2;URL=sample-page.php\">";
	//header("Location: index.php");
?>
<meta charset="utf-8">