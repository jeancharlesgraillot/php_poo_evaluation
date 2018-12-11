<?php

include('includes/header.php');

?>

<div class="container">

	<header class="flex">
		<p class="margin-right">Bienvenue sur l'application Comptes Bancaires</p>
	</header>

	<h1>Mon application bancaire</h1>

	<form class="newAccount" action="index.php" method="post">
		<label>Sélectionner un type de compte</label>
		<select class="" name="name" required>
			<option value="" disabled>Choisissez le type de compte à ouvrir</option>
			// Listez les options possibles à choisir (compte courant, PEL, etc.) better with php 	
			<option value="Compte courant">Compte courant</option>
  			<option value="PEL">PEL</option>
			<option value="Livret A">Livret A</option>
			<option value="Compte joint">Compte joint</option>
		</select>
		<input type="submit" name="new" value="Ouvrir un nouveau compte">
	</form>

	<hr>

	<div class="main-content flex">

	<!-- For each account in database, we create a card-->

	<?php
	
		foreach ($accounts as $account) {
		
	?>

		<div class="card-container">

			<div class="card">
				<h3><strong><?php echo $account->getName(); ?></strong></h3>
				<div class="card-content">


					<p>Somme disponible : <?php echo $account->getBalance(); ?> €</p>

					<!-- Credit / debit form  -->
					<h4>Dépot / Retrait</h4>
					<form action="index.php" method="post">
						<input type="hidden" name="id" value=" <?php echo $account->getId(); ?>"  required>
						<label>Entrer une somme à débiter/créditer</label>
						<input type="number" name="balance" placeholder="Ex: 250" required>
						<input type="submit" name="payment" value="Créditer">
						<input type="submit" name="debit" value="Débiter">
					</form>


					<!-- Transfer form -->
			 		<form action="index.php" method="post">

						<h4>Transfert</h4>
						<label>Entrer une somme à transférer</label>
						<input type="number" name="balanceTransfer" placeholder="Ex: 300"  required>
						<input type="hidden" name="idDebit" value="<?php echo $account->getId(); ?>" required>
						<label for="">Sélectionner un compte pour le virement</label>
						<select name="idPayment" required>
							<option value="" disabled>Choisir un compte</option>

							<!-- A loop to display all accounts available for transfer -->
							<?php

							foreach ($transferAccounts as $transferAccount) 
								{
									if ($account->getName() !== $transferAccount->getName()) 
									{
							?>	
									<option value="<?php echo $transferAccount->getId();?>"><?php echo $transferAccount->getName();?></option>

							<?php
									}
								}
							?>
						</select>
						
						<input type="submit" name="transfer" value="Transférer l'argent">
					</form>

					<!-- Delete form -->
			 		<form class="delete" action="index.php" method="post">
				 		<input type="hidden" name="id" value="<?php echo $account->getId(); ?>"  required>
				 		<input type="submit" name="delete" value="Supprimer le compte">
			 		</form>

				</div>
			</div>
		</div>

	<?php 
	
		} 
	
	?>

	</div>

</div>

<?php

include('includes/footer.php');

 ?>
