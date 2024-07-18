<meta charset="utf-8">
<?php
	@session_start();
	$id2 = $_GET['id'] ;
	unset($_SESSION['sid'][$id2]) ;
	unset($_SESSION['sname'][$id2]) ;
	unset($_SESSION['sprice'][$id2]) ;
	unset($_SESSION['sdetail'][$id2]) ;
	unset($_SESSION['spicture'][$id2]) ;
	unset($_SESSION['sitem'][$id2]) ;
	echo "<meta http-equiv=\"refresh\" content=\"0;URL=sample-page2.php\">";

?>