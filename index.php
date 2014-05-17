	<?php
	include ("entete.php");
	
	if(isset($log)){
		echo '<p><br /><br />'.$log.'</p>';
	}
	if (!isset($_SESSION['connected']) OR !$_SESSION['connected']){
		include("connexion.php");
	}
	else{
		include ('detail.php');
	}

	include ('footer.php');
	?>