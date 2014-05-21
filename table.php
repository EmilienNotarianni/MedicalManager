<?php
if (!isset($_SESSION)){
	header('location: index.php');
}
require 'entete.php';

?>
<div class="jumbotron center-block">
	<h1>Sélectionner un dossier</h1>
	
	<form class="form" method="POST" action="index.php">
		<table class="table">
			<?php
			$req = $bdd->prepare('SELECT email FROM mp_user');
                        $req->execute(array($email));
                        
                        while ($recup = $req->fetch()){
			?>
			<tr>
				<td><button class="btn btn-lg btn-primary btn-block" type="submit" value="<?php echo $recup['email']; ?>" name="view"><?php echo $recup['email']; ?></button></td>
			</tr>
			<?php } ?>
		</table>
	</form>


<?php
require 'footer.php';
?>
