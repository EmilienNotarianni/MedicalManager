<?php
session_start();
include('bdd_mp_user_mySql.php');
if (!isset($_SESSION['connected'])){
	$_SESSION['connected'] = false;
}
else if ($_SESSION['connected'] == true){
	$_SESSION['email'] != null;
	if($_SESSION['ip'] != hash('whirlpool',$_SERVER["REMOTE_ADDR"])){
		$_SESSION['connected'] = false;
	}
}
if (isset($_POST['connexion'])){
	$log = "";
	
	if(isset($_POST['email']) AND isset($_POST['pass'])){
		$email = $_POST['email'];
		$pass  = $_POST['pass'];
		//Check email
		if(filter_var($email, FILTER_VALIDATE_EMAIL)){
			// Récupération du billet
			$req = $bdd->prepare('SELECT * FROM mp_user WHERE email = ?');
			$req->execute(array($email));
			$recup = $req->fetch();
			$pass_post = hash('whirlpool',$pass);
			if($recup['email'] == $email AND $recup['pass'] == $pass_post){
				$_SESSION['connected'] = true;
				$_SESSION['email'] = $email;
				$_SESSION['ip'] = hash('whirlpool',$_SERVER["REMOTE_ADDR"]);
				$_SESSION['profil'] = $recup['categorie'];
				if ($recup['categorie'] == 'Employes'){
					$_SESSION['patient']['email'] = $recup['email'];
					$_SESSION['patient']['genre'] = $recup['genre'];
					$_SESSION['patient']['name'] = $recup['nom'];
					$_SESSION['patient']['prenom'] = $recup['prenom'];
					$_SESSION['patient']['email'] = $recup['email'];
					$_SESSION['patient']['date'] = $recup['naissance'];
					$_SESSION['patient']['anum'] = $recup['addr_num'];
					$_SESSION['patient']['arue'] = $recup['addr_rue'];
					$_SESSION['patient']['aville'] = $recup['addr_ville'];
					$_SESSION['patient']['acp'] = $recup['addr_dep'];
					$_SESSION['patient']['apays'] = $recup['addr_pays'];
					$_SESSION['patient']['acmp'] = $recup['addr_compl'];
					$_SESSION['patient']['antMedicaux'] = $recup['antMedicaux'];
					$_SESSION['patient']['vaccinations'] = $recup['vaccinations'];
				}
			}
			else{
				$log = "Email ou mot de passe invalide";
			}
		}
		else{
			$log = "Entrez un email valide";
		}
	}
	else{
		$log = "Veuillez entrez votre email et votre mot de passe administrateur";
	}
}
if (isset($_POST['update'])){
	$log = "";
	if(isset($_POST['genre'])){
		if ($_POST['genre'] == 'Monsieur'
				or $_POST['genre'] == 'Madame'
				or $_POST['genre'] == 'Mademoiselle'){
			$genre = $_POST['genre'];
		}
		else{
			$log = "Problème de genre";
		}
	}
	if (isset($_POST['name'])){
		if(preg_match("^[a-zA-Z]+$", $_POST['name'])
				or preg_match("[a-zA-Z]+\-[a-zA-Z]+", $_POST['name'])){
			$name = $_POST['name'];
		}
		else{
			$log = "Caractère non valide";
		}
	}
	if (isset($_POST['prenom'])){
		if(preg_match("^[a-zA-Z]+$", $_POST['prenom'])
				or preg_match("[a-zA-Z]+\-[a-zA-Z]+", $_POST['prenom'])){
			$prenom = $_POST['prenom'];
		}
		else{
			$log = "Caractère non valide";
		}
	}
	if (isset($_POST['email'])){
		if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
			$email = $_POST['email'];
		}
		else{
			$log = "Email non valide";
		}
	if (isset($_POST['jdn']) AND isset($_POST['mdn']) AND isset($_POST['adn'])){
		$date = $_POST['adn']."-".$_POST['mdn']."-".$_POST['jdn'];
		if(preg_match("^[0-9]{4}-[0-1][0-9]-[0-3][0-9]$",$date)){
			
		}
		else{
			$log = "Date de naissance non valide";
			$date = null;
		}
	}
	if (isset($_POST['anum'])){
		if(preg_match("^[0-9]+$",$_POST['anum']) AND strlen($_POST['anum']) <= 4){
			$anum = $_POST['anum'];
		}
		else{
			$log = "Numéro de rue non valide";
		}
	}
	if (isset($_POST['arue'])){
		if($_POST['arue'] >= 255){ // !!
			$arue = $_POST['arue'];
		}
		else{
			$log = "Rue non valide";
		}
	}
	if (isset($_POST['aville'])){
		if(preg_match("<>?",$_POST['aville']) AND $_POST['aville'] >= 255){ // !!
			$aville = $_POST['aville'];
		}
		else{
			$log = "Ville non valide";
		}
	}
	if (isset($_POST['acp'])){
		if(preg_match("[0-5]{5}",$_POST['acp'])){ // !!
			$acp = $_POST['acp'];
		}
		else{
			$log = "Code postal non valide";
		}
	}
	if (isset($_POST['apays'])){
		if(preg_match("<>?",$_POST['apays']) AND $_POST['apays'] >= 255){ // !!
			$apays = $_POST['apays'];
		}
		else{
			$log = "Pays non valide";
		}
	}
	if (isset($_POST['acmp'])){
		if(preg_match("<>?",$_POST['acmp']) AND $_POST['acmp'] >= 255){ // !!
			$acmp = $_POST['acmp'];
		}
		else{
			$log = "Complément d'addresse non valide";
		}
	}
	if (isset($_POST['antMedicaux'])){
		if(preg_match("<>?",$_POST['antMedicaux'])){ // !!
			$antMedicaux = $_POST['antMedicaux'];
		}
		else{
			$log = "Antécédent médicaux non valide";
		}
	}
	if (isset($_POST['vaccinations'])){
		if(preg_match("<>?",$_POST['vaccinations']) AND $_POST['vaccinations'] >= 255){ // !!
			$vaccinations = $_POST['vaccinations'];
		}
		else{
			$log = "Vaccinations non valide";
		}
	}
	if ($log != ""){
		if($_SESSION['profil'] = 'Medecin'){
			if (!isset($_POST['genre']) AND
				!isset($_POST['name']) AND
				!isset($_POST['prenom']) AND
				!isset($_POST['email']) AND
				!isset($_POST['jdn']) AND
				!isset($_POST['mdn']) AND
				!isset($_POST['adn']) AND
				!isset($_POST['anum']) AND
				!isset($_POST['arue']) AND
				!isset($_POST['aville']) AND
				!isset($_POST['acp']) AND
				!isset($_POST['apays']) AND
				!isset($_POST['acmp']) AND
				isset($_POST['antMedicaux']) AND
				isset($_POST['vaccinations'])){
				
					$req = $bdd->prepare('SELECT antMedicaux, vaccinations FROM mp_user WHERE email = ?');
					$req->execute(array($_SESSION['patient']['email']));
					if($recup['antMedicaux'] == $_SESSION['patient']['antMedicaux'] AND
						$recup['vaccinations'] == $_SESSION['patient']['vaccinations']){
							$req = $bdd->prepare('UPDATE mp_user SET antMedicaux = :antMedi, vaccinations = :vaccin WHERE email = :email');
							$req->execute(array(
								'antMedi' => $entMedicaux,
								'vaccin' => $vaccinations,
								'email' => $_SESSION['patient']['email']
							));
					}
					else{
						$log = "Impossible de mettre à jour, les données viennent d'être modifiées par un tierce médecin";
					}
				}
			}else{
				$_SESSION['connected'] = false;
				$_SESSION['email'] = null;
				$_SESSION['ip'] = null;
				$_SESSION['profil'] = null;
			}
		}
		if($_SESSION['profil'] = 'Secretaire' or $_SESSION['profil'] = 'Employees'){
			if (isset($_POST['genre']) AND
				isset($_POST['name']) AND
				isset($_POST['prenom']) AND
				isset($_POST['email']) AND
				isset($_POST['jdn']) AND
				isset($_POST['mdn']) AND
				isset($_POST['adn']) AND
				isset($_POST['anum']) AND
				isset($_POST['arue']) AND
				isset($_POST['aville']) AND
				isset($_POST['acp']) AND
				isset($_POST['apays']) AND
				isset($_POST['acmp']) AND
				!isset($_POST['antMedicaux']) AND
				!isset($_POST['vaccinations'])){

					$req = $bdd->prepare('SELECT * FROM mp_user WHERE email = ?');
					$req->execute(array($_SESSION['patient']['email']));
					if($recup['genre'] == $_SESSION['patient']['genre'] AND
						$recup['name'] == $_SESSION['patient']['name'] AND
						$recup['prenom'] == $_SESSION['patient']['prenom'] AND
						$recup['email'] == $_SESSION['patient']['email'] AND
						$recup['naissance'] == $_SESSION['patient']['date'] AND
						$recup['anum'] == $_SESSION['patient']['anum'] AND
						$recup['erue'] == $_SESSION['patient']['arue'] AND
						$recup['eville'] == $_SESSION['patient']['aville'] AND
						$recup['acp'] == $_SESSION['patient']['acp'] AND
						$recup['apays'] == $_SESSION['patient']['apays'] AND
						$recup['acmp'] == $_SESSION['patient']['acmp']){
						
							$req = $bdd->prepare('UPDATE mp_user SET email = ?,pass = ?,categorie = ?,nom = ?,prenom = ?,naissance = ?,genre = ?,addr_num = ?,addr_rue = ?,addr_ville = ?,addr_dep = ?,addr_pays = ?,addr_compl = ? WHERE email = ?');
							$req->execute(array(
								genre,
								name,
								prenom,
								email,
								naissance,
								anum,
								erue,
								eville,
								acp,
								apays,
								acmp,
								$_SESSION['patient']['email']
							));
					}
					else{
						$log = "Impossible de mettre à jour, les données viennent d'être modifiées par une tierce personne";
					}
				}
			}else{
					$_SESSION['connected'] = false;
					$_SESSION['email'] = null;
					$_SESSION['ip'] = null;
					$_SESSION['profil'] = null;
			}
	}		
}
if (isset($_POST['deconnexion'])){
	$_SESSION['connected'] = false;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="shortcut icon" href="../../assets/ico/favicon.ico">

  <title>Medical Manager</title>

  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="css/perso.css" rel="stylesheet">

    </head>

    <body>

      <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Gestionnaire de dossiers médicaux</a>
          </div>
		<?php
		  if (isset($_SESSION['connected']) AND $_SESSION['connected']){?>
			<div class="navbar-collapse collapse">
				<form class="navbar-form navbar-right" method="post">
					<button type="submit" class="btn btn-danger" name="deconnexion">Déconnection</button>
				</form>
			</div>
		<?php
		}
		?>
        </div>
      </div>
