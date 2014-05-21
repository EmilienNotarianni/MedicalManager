<?php
require 'entete.php';
?> 

 <div class="jumbotron">
	<h1 style="text-align:center">ConneXion</h1>

	<form class="form-signin" role="form" method="post">
		<input type="email" class="form-control" name="email" placeholder="Email" required autofocus>
		<input type="password" class="form-control" name="pass" placeholder="Mot de passe" required>
		<button class="btn btn-lg btn-primary btn-block" type="submit" name="connexion">Connexion</button>
	</form>
  </div>
<?php
require 'footer.php';
?>
