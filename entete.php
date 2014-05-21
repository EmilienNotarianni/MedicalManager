<?php
if (!isset($_SESSION)){
        header('location: index.php');
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
					<button type="submit" class="btn btn-danger" name="deconnexion">Déconnexion</button>
				</form>
			</div>
		<?php
		}
		?>
        </div>
      </div>
