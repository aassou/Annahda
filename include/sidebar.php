<?php
    $currentPage = basename($_SERVER['PHP_SELF']);
?>
<div class="page-sidebar nav-collapse collapse">
			<!-- BEGIN SIDEBAR MENU -->        	
			<ul>
				<li>
					<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
					<div class="sidebar-toggler hidden-phone"></div>
					<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
				</li>
				<li>
				</li>
				<!---------------------------- Dashboard Begin  -------------------------------------------->
				<li class="start <?php if($currentPage=="dashboard.php" 
				or $currentPage=="recherches.php"
				or $currentPage=="conges.php"
				or $currentPage=="statistiques.php"
				or $currentPage=="users.php"
				or $currentPage=="messages.php"
				or $currentPage=="user-profil.php"
				or $currentPage=="clients-search.php"
				or $currentPage=="fournisseurs-search.php"
				or $currentPage=="employes-projet-search.php"
				){echo "active ";} ?>">
					<a href="dashboard.php">
					<i class="icon-dashboard"></i> 
					<span class="title">Accueil</span>
					</a>
				</li>
				<!---------------------------- Dashboard End    -------------------------------------------->
				<!---------------------------- Gestion des projets Begin ----------------------------------->
				<?php 
					$gestionProjetClass="";
					if($currentPage=="projet-list.php" 
					or $currentPage=="projet-add.php"
					or $currentPage=="suivi-projets.php"  
					or $currentPage=="projet-update.php"
					or $currentPage=="projet-search.php"
					or $currentPage=="terrain.php"
					or $currentPage=="locaux.php"
					or $currentPage=="pieces-locaux.php"
					or $currentPage=="appartements.php"
					or $currentPage=="pieces-appartement.php"
					or $currentPage=="clients-add.php"
					or $currentPage=="contrats-add.php"
					or $currentPage=="contrat.php"
					or $currentPage=="contrats-list.php"
					or $currentPage=="contrat-details.php"
					or $currentPage=="operations.php"
					or $currentPage=="fournisseur-add.php"
					or $currentPage=="livraison.php"
					or $currentPage=="livraisons.php"
					or $currentPage=="livraisons2.php"
					or $currentPage=="livraisons-details.php"
					or $currentPage=="livraison-add.php"
					or $currentPage=="livraisons-list.php"
					or $currentPage=="fournisseur-reglement.php"
					or $currentPage=="employes-projet.php"
					or $currentPage=="employe-projet-profile.php"
					or $currentPage=="fournisseurs.php"
					or $currentPage=="livraison-fournisseur-list.php"
					or $currentPage=="fournisseurs-reglements.php"
					or $currentPage=="appartement-detail.php"
					or $currentPage=="locaux-detail.php"
					){
						$gestionProjetClass = "active ";
					}
				?> 
				<li class="<?= $gestionProjetClass; ?> has-sub" >
					<a href="javascript:;">
					<i class="icon-briefcase"></i> 
					<span class="title">Gestion des projets</span>
					<span class="arrow "></span>
					</a>
					<ul class="sub">
						<li <?php if($currentPage=="projet-add.php"){?> class="active" <?php } ?> >
							<a href="projet-add.php">Nouveau projet</a>
						</li>
						<li <?php if($currentPage=="projet-update.php"
						or $currentPage=="projet-search.php" 
						or $currentPage=="projet-list.php"
						or $currentPage=="suivi-projets.php"
						or $currentPage=="terrain.php"
						or $currentPage=="locaux.php"
						or $currentPage=="pieces-locaux.php"
						or $currentPage=="appartements.php"
						or $currentPage=="pieces-appartement.php"
						or $currentPage=="clients-add.php"
						or $currentPage=="contrats-add.php"
						or $currentPage=="contrat.php"
						or $currentPage=="contrats-list.php"
						or $currentPage=="contrat-details.php"
						or $currentPage=="operations.php"
						or $currentPage=="fournisseur-add.php"
						or $currentPage=="livraison.php"
						or $currentPage=="livraison-add.php"
						or $currentPage=="livraisons-list.php"
						or $currentPage=="fournisseur-reglement.php"
						or $currentPage=="employes-projet.php"
						or $currentPage=="employe-projet-profile.php"
						or $currentPage=="appartement-detail.php"
						or $currentPage=="locaux-detail.php"
						)
						{?> class="active" <?php } ?> >
							<a href="projet-list.php">Gérer les projets</a>
						</li>
						<li <?php if($currentPage=="fournisseurs.php"
						or $currentPage=="livraison-fournisseur-list.php"
						or $currentPage=="fournisseurs-reglements.php"
						)
						{?> class="active" <?php } ?> >
							<a href="fournisseurs.php">Gérer les fournisseurs</a>
						</li>
						<li <?php if($currentPage=="livraisons2.php" 
						or $currentPage=="livraisons-details.php")
						{?> class="active" <?php } ?> >
							<a href="livraisons2.php">Gérer les livraisons</a>
						</li>
					</ul>
				</li>
				<!---------------------------- Gestion des Projets End -------------------------------------->
				<!---------------------------- Charges Topographe Begin ------------------------------------->
				<?php 
					$gestionSocieteClass="";
					if($currentPage=="employes-societe.php"
					or $currentPage=="employe-societe-profile.php"
					or $currentPage=="caisse.php"
					or $currentPage=="caisse-entrees.php"
					or $currentPage=="caisse-sorties.php"
					){
						$gestionSocieteClass = "active ";
					} 
				?> 
				<li class="<?= $gestionSocieteClass; ?> has-sub ">
					<a href="javascript:;">
					<i class="icon-bar-chart"></i> 
					<span class="title">Gestion de la société</span>
					<span class="arrow "></span>
					</a>
					<ul class="sub">
						<li <?php if($currentPage=="employes-societe.php"
									or $currentPage=="employe-societe-profile.php"){?> class="active" <?php } ?> >
							<a href="employes-societe.php">Employés de la société</a>
						</li>
						<li <?php if($currentPage=="caisse.php"
									or $currentPage=="caisse-entrees.php"
									or $currentPage=="caisse-sorties.php" 
									){?> class="active" <?php } ?> >
							<a href="caisse.php">Gérer la caisse</a>
						</li>
					</ul>
				</li>
				<!---------------------------- Charges Topographe End ------------------------------------->
			</ul>
			<!-- END SIDEBAR MENU -->
		</div>