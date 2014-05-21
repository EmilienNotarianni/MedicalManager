<?php
include('bdd_mp_user_mySql.php');

function remove_fchar($char){
      $char = str_replace("<", "", $char);
      $char = str_replace(">", "", $char);
      $char = str_replace("--", "", $char);
      return $char;
}

function isValid($char){
	if (strlen ($char) <= 255 and strlen ($char) != 0)
		return true;
	return false;
}


if (!isset($_SESSION)){
	header('location: index.php');
}
if (!isset($_SESSION['non'])){
	$_SESSION['non'] = 0;
}
if (!isset($_SESSION['temps'])){
        $_SESSION['temps'] = null;
}
if (!isset($_SESSION['connected'])){
        $_SESSION['connected'] = false;
}
else if ($_SESSION['connected'] == true){
        if ($_SESSION['email'] == null or $_SESSION['ip'] != hash('whirlpool',$_SERVER["REMOTE_ADDR"])){
                $_SESSION['connected'] = false;
        }
}

if (isset($_POST['connexion'])){
        $log = "";
        if($_SESSION['temps'] != null AND ($_SESSION['temps']+1)%60 < (integer)date("i")){
		 $_SESSION['non'] = 0;
		 $_SESSION['temps'] = null;
	}

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
                        if($recup['email'] == $email AND $recup['pass'] == $pass_post AND $_SESSION['non'] != 5){
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
				if ($_SESSION['temps'] == null){
					if ($_SESSION['non'] == 5){
						if (!isset($_SESSION['temps'])){
							$_SESSION['temps'] = (integer)date("i");
							$req = $bdd->prepare('INSERT into log VALUE (?,?,?);');
                                                      $req->execute(array(
								date('Y-m-s H:i:s'),
                                                                $email,
                                                                $_SERVER['REMOTE_ADDR']
                                                        ));

						}
						$log = "vous avez échoué 5 fois, veuillez attendre 1 minute afin que vous puissiez avoir de nouveau accès.";
					}else{
					$_SESSION['non']++;
					}
				}
				$log .= "<br />Email ou mot de passe non valide ".$_SESSION['non'];
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
                if(isValid($_POST['name'])){
                        $name = remove_fchar($_POST['name']);
                }
                else{
                        $log = "Caractère non valide";
                }
        }
        if (isset($_POST['prenom'])){
                if(isValid($_POST['prenom'])){
                        $prenom = remove_fchar($_POST['prenom']);
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
	}
       if (isset($_POST['jdn']) AND isset($_POST['mdn']) AND isset($_POST['adn'])){
                $date = $_POST['adn']."-".$_POST['mdn']."-".$_POST['jdn'];
                if(preg_match("#(^[0-9]{4}-[0-1]?[0-9]-[0-3]?[0-9]$)#",$date)){
			
                }
                else{
                        $log = "Date de naissance non valide $date";
                        $date = null;
                }
        }
        if (isset($_POST['anum'])){
                if(preg_match("#([0-9]+)#",$_POST['anum'])){
                        $anum = $_POST['anum'];
                }
                else{
                        $log = "Numéro de rue non valide";
                }
        }
        if (isset($_POST['arue'])){
                if(isValid($_POST['arue'])){ // !!
                        $arue = remove_fchar($_POST['arue']);
                }
                else{
                        $log = "Rue non valide";
                }
	}
        if (isset($_POST['aville'])){
                if(isValid($_POST['aville'])){
                        $aville = remove_fchar($_POST['aville']);
                }
                else{
                        $log = "Ville non valide";
                }
        }
        if (isset($_POST['acp'])){
                if(preg_match("*[0-9]*",$_POST['acp'])){
                        $acp = $_POST['acp'];
                }
                else{
                        $log = "Code postal non valide";
                }
        }
	if (isset($_POST['apays'])){
                if(isValid($_POST['apays'])){
                        $apays = remove_fchar($_POST['apays']);
                }
                else{
                        $log = "Pays non valide";
                }
        }
        if (isset($_POST['acmp'])){
                if(isValid($_POST['acmp'])){
                        $acmp = remove_fchar($_POST['acmp']);
                }
                else{
                        $log = "Complément d'addresse non valide";
                }
        }
        if (isset($_POST['antMedicaux'])){
        	$antMedicaux = remove_fchar($_POST['antMedicaux']);
        }
        if (isset($_POST['vaccinations'])){
                if(strlen($_POST['vaccinations']) <= 255){
                        $vaccinations = remove_fchar($_POST['vaccinations']);
                }
                else{
                        $log = "Vaccinations non valide";
                }
        }
	if ($log == ""){
                if($_SESSION['profil'] == 'Medecin' AND $_SESSION['email'] != $_SESSION['patient']['email']){
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
                                        $recup = $req->fetch();
                                        if($recup['antMedicaux'] == $_SESSION['patient']['antMedicaux'] AND
                                                $recup['vaccinations'] == $_SESSION['patient']['vaccinations']){
                                                        $req = $bdd->prepare('UPDATE mp_user SET antMedicaux = :antMedi, vaccinations = :vaccin WHERE email = :email');
                                                        $req->execute(array(
                                                                'antMedi' => $antMedicaux,
                                                                'vaccin' => $vaccinations,
                                                                'email' => $_SESSION['patient']['email']
                                                        ));
							$_SESSION['patient']['antMedicaux'] = $antMedicaux;
							$_SESSION['patient']['vaccinations'] = $vaccinations;
                                        }
                                        else{
                                                $log = "Impossible de mettre à jour, les données viennent d'être modifiées par un tierce médecin";
                                        }
                        }else{
                                $_SESSION['connected'] = false;
                                $_SESSION['email'] = null;
                                $_SESSION['ip'] = null;
                                $_SESSION['profil'] = null;
                        }
                }
                if($_SESSION['profil'] == 'Secretaire' or $_SESSION['profil'] == 'Employes'){

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
                                        $recup = $req->fetch();
					$dateRecup = date("Y", strtotime($recup['naissance'])).'-'.(integer)date("m", strtotime($recup['naissance'])).'-'.(integer)date("d", strtotime($recup['naissance']));
                                        $_SESSION['patient']['date'] = date("Y", strtotime($_SESSION['patient']['date'])).'-'.(integer)date("m", strtotime($_SESSION['patient']['date'])).'-'.(integer)date("d", strtotime($_SESSION['patient']['date']));

					if($recup['genre'] == $_SESSION['patient']['genre'] AND
                                                $recup['nom'] == $_SESSION['patient']['name'] AND
                                                $recup['prenom'] == $_SESSION['patient']['prenom'] AND
                                                $recup['email'] == $_SESSION['patient']['email'] AND
                                                $dateRecup == $_SESSION['patient']['date'] AND
                                                $recup['addr_num'] == $_SESSION['patient']['anum'] AND
                                                $recup['addr_rue'] == $_SESSION['patient']['arue'] AND
                                                $recup['addr_ville'] == $_SESSION['patient']['aville'] AND
                                                $recup['addr_dep'] == $_SESSION['patient']['acp'] AND
                                                $recup['addr_pays'] == $_SESSION['patient']['apays'] AND
                                                $recup['addr_compl'] == $_SESSION['patient']['acmp']){
                                                       $req = $bdd->prepare('UPDATE mp_user SET email = ?,nom = ?,prenom = ?,naissance = ?,genre = ?,addr_num = ?,addr_rue = ?,addr_ville = ?,addr_dep = ?,addr_pays = ?,addr_compl = ? WHERE email = ?');
                                                      $req->execute(array(
								$email,
                                                                $name,
                                                                $prenom,
                                                                $date,
                                                                $genre,
                                                                $anum,
                                                                $arue,
                                                                $aville,
                                                                $acp,
                                                                $apays,
                                                                $acmp,
                                                                $_SESSION['patient']['email']
                                                        ));

						$_SESSION['patient']['genre'] = $genre;
                                                $_SESSION['patient']['name'] = $name;
                                                $_SESSION['patient']['prenom'] = $prenom;
                                                $_SESSION['patient']['email'] = $email;
                                                $_SESSION['patient']['date'] = $date;
                                                $_SESSION['patient']['anum'] = $anum;
                                                $_SESSION['patient']['arue'] = $arue;
                                                $_SESSION['patient']['aville'] = $aville;
                                                $_SESSION['patient']['acp'] = $acp;
                                                $_SESSION['patient']['apays'] = $apays;
                                                $_SESSION['patient']['acmp'] = $acmp;

                                        }
                                        else{
                                                $log = "Impossible de mettre à jour, les données viennent d'être modifiées par une tierce personne";
                                        }
                                
                        }else{
                                        $_SESSION['connected'] = false;
                                        $_SESSION['email'] = null;
                                        $_SESSION['ip'] = null;
                                        $_SESSION['profil'] = null;
                        }
		}
                if($_SESSION['profil'] == 'Medecin' AND $_SESSION['patient']['email'] == $_SESSION['email']){

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
                                isset($_POST['antMedicaux']) AND
                                isset($_POST['vaccinations'])){

					$req = $bdd->prepare('SELECT * FROM mp_user WHERE email = ?');
                                        $req->execute(array($_SESSION['patient']['email']));
                                        $recup = $req->fetch();
					$dateRecup = date("Y", strtotime($recup['naissance'])).'-'.(integer)date("m", strtotime($recup['naissance'])).'-'.(integer)date("d", strtotime($recup['naissance']));
                                        $_SESSION['patient']['date'] = date("Y", strtotime($_SESSION['patient']['date'])).'-'.(integer)date("m", strtotime($_SESSION['patient']['date'])).'-'.(integer)date("d", strtotime($_SESSION['patient']['date']));


                                        if($recup['genre'] == $_SESSION['patient']['genre'] AND
                                                $recup['nom'] == $_SESSION['patient']['name'] AND
                                                $recup['prenom'] == $_SESSION['patient']['prenom'] AND
                                                $recup['email'] == $_SESSION['patient']['email'] AND
                                                $dateRecup == $_SESSION['patient']['date'] AND
                                                $recup['addr_num'] == $_SESSION['patient']['anum'] AND
                                                $recup['addr_rue'] == $_SESSION['patient']['arue'] AND
                                                $recup['addr_ville'] == $_SESSION['patient']['aville'] AND
                                                $recup['addr_dep'] == $_SESSION['patient']['acp'] AND
                                                $recup['addr_pays'] == $_SESSION['patient']['apays'] AND
                                                $recup['addr_compl'] == $_SESSION['patient']['acmp'] AND
						$recup['antMedicaux'] == $_SESSION['patient']['antMedicaux'] AND
                                                $recup['vaccinations'] == $_SESSION['patient']['vaccinations']){
                                                       $req = $bdd->prepare('UPDATE mp_user SET email = ?,nom = ?,prenom = ?,naissance = ?,genre = ?,addr_num = ?,addr_rue = ?,addr_ville = ?,addr_dep = ?,addr_pays = ?,addr_compl = ?, antMedicaux = ?, vaccinations = ? WHERE email = ?');
                                                      $req->execute(array(
								$email,
                                                                $name,
                                                                $prenom,
                                                                $date,
                                                                $genre,
                                                                $anum,
                                                                $arue,
                                                                $aville,
                                                                $acp,
                                                                $apays,
                                                                $acmp,
								$antMedicaux,
								$vaccinations,
                                                                $_SESSION['patient']['email']
                                                        ));

						$_SESSION['patient']['genre'] = $genre;
                                                $_SESSION['patient']['name'] = $name;
                                                $_SESSION['patient']['prenom'] = $prenom;
                                                $_SESSION['patient']['email'] = $email;
                                                $_SESSION['patient']['date'] = $date;
                                                $_SESSION['patient']['anum'] = $anum;
                                                $_SESSION['patient']['arue'] = $arue;
                                                $_SESSION['patient']['aville'] = $aville;
                                                $_SESSION['patient']['acp'] = $acp;
                                                $_SESSION['patient']['apays'] = $apays;
                                                $_SESSION['patient']['acmp'] = $acmp;
						$_SESSION['patient']['antMedicaux'] = $antMedicaux;
						$_SESSION['patient']['vaccinations'] = $vaccinations;

                                        }
                                        else{
                                                $log = "Impossible de mettre à jour, les données viennent d'être modifiées par une tierce personne";
                                        }
                                
                        }else{
                                        $_SESSION['connected'] = false;
                                        $_SESSION['email'] = null;
                                        $_SESSION['ip'] = null;
                                        $_SESSION['profil'] = null;
                        }
		}
        }
}
if (isset($_POST['deconnexion'])){
        $_SESSION['connected'] = false;
	$_SESSION['ip'] = null;
	$_SESSION['patient'] = null;
}
if (isset($_POST['view']) AND isset($_SESSION['profil']))
	if ($_SESSION['profil'] == 'Medecin' OR $_SESSION['profil'] == 'Secretaire'){
                        $req = $bdd->prepare('SELECT * FROM mp_user WHERE email = ?');
                        $req->execute(array($_POST['view']));
                        $recup = $req->fetch();
                        if($recup['email'] != null){
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
                        }else{
				$log = "Aucun collaborateur n'a été trouvé";
			}
	
}
if (isset($_POST['dossier']))
	if ($_SESSION['profil'] == 'Medecin' OR $_SESSION['profil'] == 'Secretaire'){
	$_SESSION['patient'] = null;
}
