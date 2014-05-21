	<?php
	session_set_cookie_params ( 900);
	session_start();

	require 'traitment.php';	
	if(isset($log)){
		echo '<p><br /><br />'.$log.'</p>';
	}
	if (!isset($_SESSION['connected']) OR !$_SESSION['connected']){
		require 'conneXion.php';
	}
	else if ($_SESSION['profil'] == 'Employes' OR $_SESSION['patient'] != null) {
		require 'detail.php';
	}
	else if ($_SESSION['profil'] == 'Secretaire' OR $_SESSION['profil'] == 'Medecin'){
		require 'table.php';
	}

	?>
