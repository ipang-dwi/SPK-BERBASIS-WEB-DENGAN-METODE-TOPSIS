<?php
	@session_start();
	$_SESSION['judul'] = 'SPK TOPSIS DAVID';
	$_SESSION['welcome'] = 'SISTEM PENGAMBIL KEPUTUSAN BERBASIS WEB DENGAN METODE TOPSIS';
	$_SESSION['by'] = 'Mas bro David punya ^___^b';
	$mysqli = new mysqli('localhost','root','1717','topsis');
	if($mysqli->connect_errno){
		echo $mysqli->connect_errno." - ".$mysqli->connect_error;
		exit();
	}
?>