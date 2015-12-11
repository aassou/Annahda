<?php
    $currentPage = basename($_SERVER['PHP_SELF']);
?>
<div class="page-sidebar nav-collapse collapse">
			<!-- BEGIN SIDEBAR MENU -->        	
			<ul>
			    <li>
                    <!-- BEGIN RESPONSIVE QUICK SEARCH FORM -->
                    <form class="sidebar-search" action="controller/ClientActionController.php" method="post">
                        <div class="input-box">
                            <a href="javascript:;" class="remove"></a>
                            <input type="hidden" name="action" value="search">
                            <input type="hidden" name="source" value="clients-search">
                            <input type="text" name="clientName" placeholder="Chercher un client">             
                            <input type="button" class="submit" value="">
                        </div>
                    </form>
                    <!-- END RESPONSIVE QUICK SEARCH FORM -->
                </li>
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
				or $currentPage=="compte-bancaire.php"
				or $currentPage=="conges.php"
				or $currentPage=="statistiques.php"
				or $currentPage=="messages.php"
				or $currentPage=="user-profil.php"
				or $currentPage=="clients-search.php"
				or $currentPage=="fournisseurs-search.php"
				or $currentPage=="clients.php"
				or $currentPage=="employes-projet-search.php"
				or $currentPage=="contrat-status.php"
				or $currentPage=="tasks.php"
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
					or $currentPage=="projets.php"
					or $currentPage=="projet-details.php"
					or $currentPage=="projet-charges.php"
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
					or $currentPage=="fournisseur-reglement.php"
					or $currentPage=="employes-projet.php"
					or $currentPage=="employe-projet-profile.php"
					or $currentPage=="fournisseurs-reglements.php"
					or $currentPage=="appartement-detail.php"
					or $currentPage=="locaux-detail.php"
					or $currentPage=="projet-charges-grouped.php"
					or $currentPage=="projet-charges-type.php"
					or $currentPage=="projet-contrat-employe.php"
					or $currentPage=="contrat-employe-detail.php"
					){
						$gestionProjetClass = "active ";
					}
				?> 
				<li class="<?= $gestionProjetClass; ?>" >
					<a href="projets.php">
					<i class="icon-briefcase"></i> 
					<span class="title">Gestion des projets</span>
					<span class="arrow "></span>
					</a>
				</li>
				<!---------------------------- Gestion des Projets End -------------------------------------->
				<!---------------------------- Livraisons Begin  -------------------------------------------->
                <li class="start <?php if($currentPage=="livraisons-group.php" 
                or $currentPage=="livraisons-fournisseur.php"
                or $currentPage=="livraisons-details.php"
                ){echo "active ";} ?>">
                    <a href="livraisons-group.php">
                    <i class="icon-truck"></i> 
                    <span class="title">Livraisons</span>
                    </a>
                </li>
                <!---------------------------- Livraisons End    -------------------------------------------->
				<!---------------------------- Caisse Begin ------------------------------------->
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
				<!---------------------------- Caisse End ------------------------------------->
				<!---------------------------- Parametrage Begin  -------------------------------------------->
                <li class="start <?php if($currentPage=="configuration.php" 
                or $currentPage=="history.php"
                or $currentPage=="clients-list.php"
                or $currentPage=="employes-contrats.php"
                or $currentPage=="users.php"
                or $currentPage=="type-charges.php"
                or $currentPage=="fournisseurs.php"
                ){echo "active ";} ?>">
                    <a href="configuration.php">
                    <i class="icon-wrench"></i> 
                    <span class="title">Paramètrages</span>
                    </a>
                </li>
                <!---------------------------- Parametrage End    -------------------------------------------->
			</ul>
			<!-- END SIDEBAR MENU -->
		</div>