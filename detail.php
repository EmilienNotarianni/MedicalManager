<?php
if (!isset($_SESSION)){
	header('location: index.php');
}
require 'entete.php';
?>
<div class="jumbotron center-block">
        <?php
        if ($_SESSION['profil'] == 'Medecin' OR $_SESSION['profil'] == 'Secretaire'){?>
        <form class="form" method="POST" action="index.php">
                <button class="btn btn-lg btn-default" type="submit" name="dossier">Consulter tous les dossiers</button>
        </form>
        <?php } ?>

	<h1>Information</h1>
	<form class="form" method="POST" action="index.php">
		<table class="table">
			<tr>
				<td>Civilité</td>
				<td>
				<div class="row">
					  <div class="col-xs-4">
						<?php if ($_SESSION['profil'] == 'Medecin'){?>
							<?php echo $_SESSION['patient']['genre'];?>
						<?php }else{?>
							<select class="form-control" name="genre">
							  <option value="Monsieur" <?php if($_SESSION['patient']['genre'] == 'Monsieur')echo "selected";?>;>Monsieur</option>
							  <option value="Madame" <?php if($_SESSION['patient']['genre'] == 'Madame')echo "selected";?>;>Madame</option>
							  <option value="Mademoiselle" <?php if($_SESSION['patient']['genre'] == 'Mademoiselle')echo "selected";?>;>Mademoiselle</option>
							</select>
						<?php } ?>
						</div>
					</div>
				</td>
			</tr>
			<tr>
				<td>Nom</td>
				<td>
					<?php if ($_SESSION['profil'] != 'Medecin'){?>
						<input type="text" class="form-control" value="<?php echo $_SESSION['patient']['name'];?>" name="name"/>
					<?php }else{ echo $_SESSION['patient']['name'];}?>
						
			</tr>
			<tr>
				<td>Prénom</td>
				<td>
					<?php if ($_SESSION['profil'] != 'Medecin'){?>
						<input type="text" class="form-control" value="<?php echo $_SESSION['patient']['prenom'];?>" name="prenom"/>
					<?php }else{ echo $_SESSION['patient']['prenom'];}?>
				</td>
			</tr>
			<tr>
				<td>Email</td>
				<td>
				<?php if ($_SESSION['profil'] != 'Medecin'){?>
					<input type="text" class="form-control" value="<?php echo $_SESSION['patient']['email'];?>" name="email"/>
				<?php }else{ echo $_SESSION['patient']['email'];}?>
				</td>
			</tr>
			<tr>
				<td>Date de naissance</td>
				<td>
				<?php if ($_SESSION['profil'] != 'Medecin'){?>
					<div class="row">
					  <div class="col-xs-2">
						<select class="form-control" name="jdn">
							<?php for ($i = 1; $i<=31; $i++){
									if (date("d", strtotime($_SESSION['patient']['date'])) == $i)
										echo '<option value="'.$i.'" selected>'.$i.'</option>';
									else
										echo '<option value="'.$i.'" >'.$i.'</option>';
								}
							?>
						</select>
					  </div>
					  <div class="col-xs-1">/
					  </div>
					  <div class="col-xs-2">
						<select class="form-control" name="mdn">
							<?php for ($i = 1; $i<=12; $i++){
									if (date("m", strtotime($_SESSION['patient']['date'])) == $i)
										echo '<option value="'.$i.'" selected>'.$i.'</option>';
									else
										echo '<option value="'.$i.'" >'.$i.'</option>';
								}
							?>
						</select>
					  </div>
					  <div class="col-xs-1">/
					  </div>
					  <div class="col-xs-3">
						<select class="form-control" name="adn">
							<?php for ($i = 1900; $i<=2000; $i++){
									if (date("Y", strtotime($_SESSION['patient']['date'])) == $i)
										echo '<option value="'.$i.'" selected>'.$i.'</option>';
									else
										echo '<option value="'.$i.'" >'.$i.'</option>';
								}
							?>						</select>
					  </div>
					</div>
				<?php }else{ echo date("d / m / Y", strtotime($_SESSION['patient']['date'])); }?>
				</td>
			</tr>
			<tr>
				<td>Addresse</td>
				<td>
					<div class="row">
					  <div class="col-xs-2">
						<?php if ($_SESSION['profil'] != 'Medecin'){?>
							<input type="text" class="form-control" value="<?php echo $_SESSION['patient']['anum'];?>" name="anum"/>
						<?php }else{ echo $_SESSION['patient']['anum'];}?>
					  </div>
					  <div class="col-xs-10">
						<?php if ($_SESSION['profil'] != 'Medecin'){?>
							<input type="text" class="form-control" value="<?php echo $_SESSION['patient']['arue'];?>" name="arue"/>
						<?php }else{ echo $_SESSION['patient']['arue'];}?>
					  </div>
					</div>
				</td>
			</tr>
			<tr>

				<td>Complément d'Addresse</td>
				<td>
				<?php if ($_SESSION['profil'] != 'Medecin'){?>
					<input type="text" class="form-control" value="<?php echo $_SESSION['patient']['acmp'];?>" name="acmp"/>
				<?php }else{ echo $_SESSION['patient']['acmp'];}?>
				</td>
			</tr>
			<tr>
				<td>CP - Ville</td>
				<td>
					<div class="row">
					  <div class="col-xs-2">
						<?php if ($_SESSION['profil'] != 'Medecin'){?>
							<input type="text" class="form-control" value="<?php echo $_SESSION['patient']['acp'];?>" name="acp"/>
						<?php }else{ echo $_SESSION['patient']['acp'];}?>
					  </div>
					  <div class="col-xs-10">
						<?php if ($_SESSION['profil'] != 'Medecin'){?>
							<input type="text" class="form-control" value="<?php echo $_SESSION['patient']['aville'];?>" name="aville"/>
						<?php }else{ echo $_SESSION['patient']['aville'];}?>
					  </div>
					</div>
				</td>
			</tr>
			<tr>
				<td>Pays</td>
				<td>
				<?php if ($_SESSION['profil'] != 'Medecin'){?>
					<input type="text" class="form-control" value="<?php echo $_SESSION['patient']['apays'];?>" name="apays"/>
				<?php }else{ echo $_SESSION['patient']['apays'];}?>
				</td>
			</tr>
			<tr>
				<td>Antédédents médicaux</td>
				<td>
				<?php if ($_SESSION['profil'] == 'Medecin'){?>
					<textarea type="text" class="form-control" name="antMedicaux"/><?php echo $_SESSION['patient']['antMedicaux'];?></textarea>
				<?php }else if ($_SESSION['profil'] == 'Employes'){ echo $_SESSION['patient']['antMedicaux'];}?>
				</td>
			</tr>
			<tr>
				<td>Vaccinations</td>
				<td>
				<?php if ($_SESSION['profil'] == 'Medecin'){?>
					<textarea type="text" class="form-control" name="vaccinations"/><?php echo $_SESSION['patient']['vaccinations'];?></textarea>
				<?php }else if ($_SESSION['profil'] == 'Employes'){ echo $_SESSION['patient']['vaccinations'];}?>
				</td>
			</tr>
			<tr>
				<td></td>
				<td><button class="btn btn-lg btn-primary btn-block" type="submit" name="update">Mise à jour des informations</button></td>
			</tr>
		</table>
	</form>


<?php
require 'footer.php';
?>
