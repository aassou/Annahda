<?php
	//classes loading begin
    function classLoad ($myClass) {
        if(file_exists('model/'.$myClass.'.php')){
            include('model/'.$myClass.'.php');
        }
        elseif(file_exists('controller/'.$myClass.'.php')){
            include('controller/'.$myClass.'.php');
        }
    }
    spl_autoload_register("classLoad"); 
    include('config.php');  
	include('lib/pagination.php');
    //classes loading end
    session_start();
    if(isset($_SESSION['userMerlaTrav']) and $_SESSION['userMerlaTrav']->profil()=="admin"){
    	$idProjet = 0;
    	$projetManager = new ProjetManager($pdo);
		$clientManager = new ClientManager($pdo);
		$contratManager = new ContratManager($pdo);
		$operationManager = new OperationManager($pdo);
		if(isset($_GET['codeContrat']) and (bool)$contratManager->getCodeContrat($_GET['codeContrat']) ){
			$codeContrat = $_GET['codeContrat'];
			$contrat = $contratManager->getContratByCode($codeContrat);
			$projet = $projetManager->getProjetById($contrat->idProjet());
			$client = $clientManager->getClientById($contrat->idClient());
			$sommeOperations = $operationManager->sommeOperations($contrat->id());
			$biens = "";
			$niveau = "";
			if($contrat->typeBien()=="appartement"){
				$appartementManager = new AppartementManager($pdo);
				$biens = $appartementManager->getAppartementById($contrat->idBien());
				$niveau = $biens->niveau();
			}
			else if($contrat->typeBien()=="localCommercial"){
				$locauxManager = new LocauxManager($pdo);
				$biens = $locauxManager->getLocauxById($contrat->idBien());
			}
			$operations = "";
			//test the locaux object number: if exists get operations else do nothing
			$operationsNumber = $operationManager->getOpertaionsNumberByIdContrat($contrat->id());
			if($operationsNumber != 0){
				$operations = $operationManager->getOperationsByIdContrat($contrat->id());	
			}
		}
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
	<meta charset="utf-8" />
	<title>ImmoERP - Management Application</title>
	<meta content="width=device-width, initial-scale=1.0" name="viewport" />
	<meta content="" name="description" />
	<meta content="" name="author" />
	<link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
	<link href="assets/css/metro.css" rel="stylesheet" />
	<link href="assets/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" />
	<link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
	<link href="assets/css/style.css" rel="stylesheet" />
	<link href="assets/css/style_responsive.css" rel="stylesheet" />
	<link href="assets/css/style_default.css" rel="stylesheet" id="style_color" />
	<link href="assets/fancybox/source/jquery.fancybox.css" rel="stylesheet" />
	<link rel="stylesheet" type="text/css" href="assets/uniform/css/uniform.default.css" />
	<link rel="stylesheet" type="text/css" href="assets/bootstrap-datepicker/css/datepicker.css" />
	<link rel="stylesheet" type="text/css" href="assets/chosen-bootstrap/chosen/chosen.css" />
	<link rel="stylesheet" href="assets/data-tables/DT_bootstrap.css" />
	<link rel="stylesheet" type="text/css" href="assets/uniform/css/uniform.default.css" />
	<link rel="shortcut icon" href="favicon.ico" />
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body class="fixed-top">
	<!-- BEGIN HEADER -->
	<div class="header navbar navbar-inverse navbar-fixed-top">
		<!-- BEGIN TOP NAVIGATION BAR -->
		<?php include("include/top-menu.php"); ?>	
		<!-- END TOP NAVIGATION BAR -->
	</div>
	<!-- END HEADER -->
	<!-- BEGIN CONTAINER -->
	<div class="page-container row-fluid">
		<!-- BEGIN SIDEBAR -->
		<?php include("include/sidebar.php"); ?>
		<!-- END SIDEBAR -->
		<!-- BEGIN PAGE -->
		<div class="page-content">
			<!-- BEGIN PAGE CONTAINER-->			
			<div class="container-fluid">
				<!-- BEGIN PAGE HEADER-->
				<div class="row-fluid">
					<div class="span12">
						<!-- BEGIN PAGE TITLE & BREADCRUMB-->			
						<h3 class="page-title">
							Gestion des Clients et Contrats
						</h3>
						<ul class="breadcrumb">
							<li>
								<i class="icon-home"></i>
								<a>Accueil</a> 
								<i class="icon-angle-right"></i>
							</li>
							<li>
								<i class="icon-briefcase"></i>
								<a>Gestion des projets</a>
								<i class="icon-angle-right"></i>
							</li>
							<li><a>Gestion des clients/contrats</a></li>
							<?php 
								$clientManager = new ClientManager($pdo);
							?>
						</ul>
						<!-- END PAGE TITLE & BREADCRUMB-->
					</div>
				</div>
				<!-- END PAGE HEADER-->
				<!-- BEGIN PAGE CONTENT-->
				<div class="row-fluid">
					<div class="span12">
						<?php if(isset($_GET['codeContrat']) and (bool)$contratManager->getCodeContrat($_GET['codeContrat']) ){
						?>
						<div class="row-fluid add-portfolio">
							<div class="pull-left">
								<a href="contrats-list.php?idProjet=<?= $projet->id() ?>" class="btn icn-only green"><i class="m-icon-swapleft m-icon-white"></i> Retour vers Liste des contrats du projet : <strong><?= $projet->nom() ?></strong></a>
							</div>
							<div class="pull-right">
								<a href="projet-list.php" class="btn icn-only green">Aller vers Liste des projets <i class="m-icon-swapright m-icon-white"></i></a>
							</div>
						</div>
	                     <?php if(isset($_SESSION['contrat-add-success'])){ ?>
	                     	<div class="alert alert-success">
								<button class="close" data-dismiss="alert"></button>
								<?= $_SESSION['contrat-add-success'] ?>		
							</div>
	                     <?php } 
	                     	unset($_SESSION['contrat-add-success']);
	                     ?>
	                     <?php if(isset($_SESSION['client-update-success'])){ ?>
	                     	<div class="alert alert-success">
								<button class="close" data-dismiss="alert"></button>
								<?= $_SESSION['client-update-success'] ?>		
							</div>
	                     <?php } 
	                     	unset($_SESSION['client-update-success']);
	                     ?>
	                     <?php if(isset($_SESSION['client-update-error'])){ ?>
	                     	<div class="alert alert-error">
								<button class="close" data-dismiss="alert"></button>
								<?= $_SESSION['client-update-error'] ?>		
							</div>
	                     <?php } 
	                     	unset($_SESSION['client-update-error']);
	                     ?>
	                     <?php if(isset($_SESSION['contrat-update-success'])){ ?>
	                     	<div class="alert alert-success">
								<button class="close" data-dismiss="alert"></button>
								<?= $_SESSION['contrat-update-success'] ?>		
							</div>
	                     <?php } 
	                     	unset($_SESSION['contrat-update-success']);
	                     ?>
	                      <?php if(isset($_SESSION['contrat-update-error'])){ ?>
	                     	<div class="alert alert-error">
								<button class="close" data-dismiss="alert"></button>
								<?= $_SESSION['contrat-update-error'] ?>		
							</div>
	                     <?php } 
	                     	unset($_SESSION['contrat-update-error']);
	                     ?>
	                     <?php
	                     //progress bar processing
	                     $statistiquesResult = ceil((($operationManager->sommeOperations($contrat->id()) )/$contrat->prixVente())*100);
						 $statusBar = "";
						 if( $statistiquesResult>0 and $statistiquesResult<25 ){
						 	$statusBar = "progress-danger";
						 }
						 else if( $statistiquesResult>=25 and $statistiquesResult<50 ){
						 	$statusBar = "progress-warning";
						 }
						 else if( $statistiquesResult>=50 and $statistiquesResult<75 ){
						 	$statusBar = "progress-success";
						 }
	                     ?>
	                    <h3>Résumé du Contrat&nbsp;&nbsp;
	                    	<a class="btn big blue" href="controller/ContratClientSituationPrintController.php?codeContrat=<?= $contrat->code() ?>">
	                    		<i class="icon-print"></i>&nbsp;Version Imprimable
	                    	</a>
	                    </h3>
	                    <hr>
	                    <h4>Avancement du contrat</h4>
	                    <div class="progress <?= $statusBar ?>">
    						<div class="bar" style="width: <?= $statistiquesResult ?>%;"><?= $statistiquesResult ?>%</div>
						</div>
                       <div class="span5">
						<div class="portlet sale-summary">
							<div class="portlet-title">
								<h4>Informations du client</h4>
								<a href="#updateClient<?= $client->id() ?>" class="pull-right btn red hidden-phone" data-toggle="modal" data-id="<?= $client->id(); ?>">
									Modifier <i class="icon-refresh icon-white"></i>
								</a>
								<br><br>	
							</div>
							<ul class="unstyled">
								<li>
									<span class="sale-info">Client</span> 
									<span class="sale-num"><?= $client->nom() ?></span>
								</li>
								<li>
									<span class="sale-info">CIN</span> 
									<span class="sale-num"><?= $client->cin() ?></span>
								</li>
								<li>
									<span class="sale-info">Téléphone 1</span> 
									<span class="sale-num"><?= $client->telephone1() ?></span>
								</li>
								<li>
									<span class="sale-info">Téléphone 2</span> 
									<span class="sale-num"><?= $client->telephone2() ?></span>
								</li>
								<li>
									<span class="sale-info">Adresse</span> 
									<span class="sale-num"><?= $client->adresse() ?></span>
								</li>
								<li>
									<span class="sale-info"><i class="icon-envelope"></i></span> 
									<span class="sale-num"><?= $client->email() ?></span>
								</li>
							</ul>
							<!--a href="controller/ClientFichePrintController.php?idContrat=<?= $contrat->id() ?>" class="btn big purple">
									<i class="icon-print"></i> Fiche Client
								</a-->
						</div>
					 </div>
					 <div class="span6">
						<div class="portlet sale-summary">
							<div class="portlet-title">
								<h4>Informations du contrat</h4>
								<a href="#updateContrat<?= $contrat->id() ?>" class="pull-right btn red hidden-phone" data-toggle="modal" data-id="<?= $contrat->id(); ?>">
									Modifier <i class="icon-refresh icon-white"></i>
								</a>
								<br><br>
							</div>
							<ul class="unstyled">
								<li>
									<span class="sale-info">Type</span> 
									<span class="sale-num">
									<?php 
										if($contrat->typeBien()=="localCommercial"){
											echo "Local commercial"; 
										} 
										else{
											echo "Appartement";
										} 
									?>
									</span>
								</li>
								<li>
									<span class="sale-info">Nom du Bien</span> 
									<span class="sale-num"><?= $biens->nom() ?></span>
								</li>
								<li>
									<span class="sale-info">Superficie</span> 
									<span class="sale-num"><?= $biens->superficie() ?>&nbsp;m<sup>2</sup></span>
								</li>
								<li>
									<span class="sale-info">Niveau</span> 
									<span class="sale-num"><?= $niveau ?></span>
								</li>
								<li>
									<span class="sale-info">Prix de Vente</span> 
									<span class="sale-num"><?= number_format($contrat->prixVente(), 2, ',', ' ') ?>&nbsp;DH</span>
								</li>
								<li>
									<?php
									//if($contrat->avance()!=0 or $contrat->avance()!='NULL' ){
									?>
									<span class="sale-info">Réglements</span> 
									<span class="sale-num">
										<?= number_format($sommeOperations, 2, ',', ' ') ?>&nbsp;DH
									</span>
									<?php
									//}
									?>
								</li>
								<li>
									<span class="sale-info">Reste</span> 
									<span class="sale-num">
										<?= number_format($contrat->prixVente()-($sommeOperations), 2, ',', ' ') ?>&nbsp;DH
									</span>
								</li>
								<li>
									<span class="sale-info">Echéance</span> 
									<span class="sale-num"><?= number_format($contrat->echeance(), 2, ',', ' ') ?>&nbsp;DH</span>
								</li>
							</ul>
							<!--a href="controller/ContratPrintController.php?idContrat=<?= $contrat->id() ?>" class="btn big blue">
									<i class="icon-print"></i> Contrat Client
								</a>
							<a href="controller/QuittanceAvancePrintController.php?idContrat=<?= $contrat->id() ?>" class="btn big black">
									<i class="icon-print"></i> Quittance Avance
								</a-->
						</div>
					 </div>
					 <h3>Détails des réglements</h3>
					<hr>
					<div class="portlet-body">
							<table class="table table-striped table-bordered table-advance table-hover">
								<thead>
									<tr>
										<th style="width: 25%">Date opération</th>
										<th style="width: 25%">Montant</th>
										<th style="width: 25%" class="hidden-phone">Quittance</th>
										<th style="width: 25%" class="hidden-phone">Mode Paiement</th>
									</tr>
								</thead>
								<tbody>
									<?php
									if($operationsNumber != 0){
									foreach($operations as $operation){
									?>		
									<tr>
										<td><a><?= date('d/m/Y', strtotime($operation->date())) ?></a></td>
										<td><?= number_format($operation->montant(), 2, ',', ' ') ?>&nbsp;DH</td>
										<td class="hidden-phone">
											<a class="btn mini blue" href="controller/OperationPrintController.php?idOperation=<?= $operation->id() ?>"> 
												<i class="m-icon-white icon-print"></i> Imprimer
											</a>
										</td>
										<td class="hidden-phone"><?= $operation->modePaiement() ?></td>
									</tr>	
									<?php
									}//end of loop
									}//end of if
									?>
									<!--tr>
										<td><a><?= date('d/m/Y', strtotime($contrat->dateCreation())) ?></a></td>											
										<?php
										if($contrat->avance()!=0 or $contrat->avance()!='NULL' ){
										?> 
											<td><?= number_format($contrat->avance(), 2, ',', ' ')." DH";?></td>
										<?php
										}
										?>
										<td class="hidden-phone">
											<a class="btn mini blue" href="controller/QuittanceAvancePrintController.php?idContrat=<?= $contrat->id() ?>"> 
												<i class="m-icon-white icon-print"></i> Imprimer
											</a>
										</td>
										<td class="hidden-phone"><?= $contrat->modePaiement() ?></td>
									</tr-->
									<tr>
										<td><strong>Somme Réglements</strong></td>
										<td>
											<strong>
												<?= number_format($operationManager->sommeOperations($contrat->id()), 2, ',', ' ')." DH";?>
											</strong>		
										</td>
										<td class="hidden-phone">
										</td>
										<td class="hidden-phone"></td>
									</tr>
									<tr>
										<td><strong>Reste</strong></td>
										<td>
											<strong>
												<?= number_format($contrat->prixVente()-$operationManager->sommeOperations($contrat->id()), 2, ',', ' ')." DH";?>
											</strong>		
										</td>
										<td class="hidden-phone">
										</td>
										<td class="hidden-phone"></td>
									</tr>
								</tbody>
							</table>
						</div>
						<br /><br />
					 </div>
				   </div>
				</div>
				<!-- updateClient box begin-->
				<div id="updateClient<?= $client->id() ?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
						<h3>Modifier les informations du client </h3>
					</div>
					<div class="modal-body">
						<form class="form-horizontal" action="controller/ClientUpdateController.php" method="post">
							<p>Êtes-vous sûr de vouloir modifier les infos du client <strong><?= $client->nom() ?></strong> ?</p>
							<div class="control-group">
								<label class="control-label">Nom</label>
								<div class="controls">
									<input type="text" name="nom" value="<?= $client->nom() ?>" />
								</div>
							</div>
							<div class="control-group">
								<label class="control-label">CIN</label>
								<div class="controls">
									<input type="text" name="cin" value="<?= $client->cin() ?>" />
								</div>
							</div>	
							<div class="control-group">
								<label class="control-label">Adresse</label>
								<div class="controls">
									<input type="text" name="adresse" value="<?= $client->adresse() ?>" />
								</div>
							</div>
							<div class="control-group">
								<label class="control-label">Tél.Fix</label>
								<div class="controls">
									<input type="text" name="telephone1" value="<?= $client->telephone1() ?>" />
								</div>
							</div>
							<div class="control-group">
								<label class="control-label">Tél.Mobil</label>
								<div class="controls">
									<input type="text" name="telephone2" value="<?= $client->telephone2() ?>" />
								</div>
							</div>
							<div class="control-group">
								<label class="control-label">Email</label>
								<div class="controls">
									<input type="text" name="email" value="<?= $client->email() ?>" />
								</div>	
							</div>
							<div class="control-group">
								<input type="hidden" name="idClient" value="<?= $client->id() ?>" />
								<input type="hidden" name="codeContrat" value="<?= $contrat->code() ?>" />
								<div class="controls">	
									<button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
									<button type="submit" class="btn red" aria-hidden="true">Oui</button>
								</div>
							</div>
						</form>
					</div>
				</div>
				<!-- updateClient box end -->
				<!-- updateContrat box begin-->
				<div id="updateContrat<?= $contrat->id() ?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
						<h3>Modifier les informations du contrat </h3>
					</div>
					<div class="modal-body">
						<form class="form-horizontal" action="controller/ContratUpdateController.php" method="post">
							<p>Êtes-vous sûr de vouloir modifier le contrat <strong>N°<?= $contrat->id() ?></strong>  ?</p>
							<div class="control-group">
								<label class="control-label">Date Création</label>
								<div class="controls">
									<input type="text" name="dateCreation" value="<?= $contrat->dateCreation() ?>" />
								</div>
							</div>
							<div class="control-group">
								<label class="control-label">Prix Vente</label>
								<div class="controls">
									<input type="text" name="prixVente" value="<?= $contrat->prixVente() ?>" />
								</div>
							</div>	
							<div class="control-group">
								<label class="control-label">avance</label>
								<div class="controls">
									<input type="text" name="avance" value="<?= $contrat->avance() ?>" />
								</div>
							</div>
							<div class="control-group">
								<label class="control-label">Mode de paiement</label>
								<div class="controls">
									<select name="modePaiement">
										<option value="<?= $contrat->modePaiement() ?>"><?= $contrat->modePaiement() ?></option>
										<option disabled="disabled">-----------</option>
										<option value="Especes">Espèces</option>
										<option value="Cheque">Chèque</option>
										<option value="Versement">Versement</option>
										<option value="Virement">Virement</option>
										<option value="Lettre de change">Lettre de change</option>
									</select>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label">Durée de paiement</label>
								<div class="controls">
									<input type="text" name="dureePaiement" value="<?= $contrat->dureePaiement() ?>" />
								</div>
							</div>
							<div class="control-group">
								<label class="control-label">Echéance</label>
								<div class="controls">
									<input type="text" name="echeance" value="<?= $contrat->echeance() ?>" />
								</div>
							</div>
							<div class="control-group">
								<label class="control-label">Note Client</label>
								<div class="controls">
									<textarea name="note"><?= $contrat->note() ?></textarea>
								</div>
							</div>
							<div class="control-group">
                             	<div class="alert alert-error">
									<strong>Remarque</strong> : Ne toucher à cette zone sauf si vous voulez changer le bien.		
								</div>
                            	<label class="control-label">Changer Type du bien ?</label>
                            	<div class="controls">
                                	<label class="radio">
                                 	<input type="radio" class="typeBien" name="typeBien" value="localCommercial" />
                                 	Local commercial
                                	</label>
                                	<label class="radio">
                                 	<input type="radio" class="typeBien" name="typeBien" value="appartement" />
                                 	Appartement
                                	</label>
                             	</div>
                          	</div>
                          	<div class="control-group hidenBlock">
                          		<label class="control-label" for="" id="nomBienLabel"></label>
                             	<div class="controls">
                             		<select class="m-wrap" name="bien" id="bien">
                             		</select>
                            	</div>
                          	</div>
							<div class="control-group">
								<input type="hidden" name="codeContrat" value="<?= $contrat->code() ?>" />
								<input type="hidden" name="idContrat" value="<?= $contrat->id() ?>" />
								<div class="controls">	
									<button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
									<button type="submit" class="btn red" aria-hidden="true">Oui</button>
								</div>
							</div>
						</form>
					</div>
				</div>
				<!-- updateContrat box end -->		
				<?php 
				}
				else{
				?>
				<div class="alert alert-error">
					<button class="close" data-dismiss="alert"></button>
					<strong>Erreur système : </strong>Ce projet n'existe pas sur votre système. Pour plus d'informations consulter votre administrateur.		
				</div>
				<?php
				}
				?>
				<!-- END PAGE CONTENT -->
			</div>
			<!-- END PAGE CONTAINER-->
		</div>
		<!-- END PAGE -->
	</div>
	<!-- END CONTAINER -->
	<!-- BEGIN FOOTER -->
	<div class="footer">
		2015 &copy; MerlaTravERP. Management Application.
		<div class="span pull-right">
			<span class="go-top"><i class="icon-angle-up"></i></span>
		</div>
	</div>
	<!-- END FOOTER -->
	<!-- BEGIN JAVASCRIPTS -->
	<!-- Load javascripts at bottom, this will reduce page load time -->
	<script src="assets/js/jquery-1.8.3.min.js"></script>	
	<script src="assets/breakpoints/breakpoints.js"></script>	
	<script src="assets/bootstrap/js/bootstrap.min.js"></script>		
	<script src="assets/js/jquery.blockui.js"></script>
	<script src="assets/js/jquery.cookie.js"></script>
	<script src="assets/fancybox/source/jquery.fancybox.pack.js"></script>
	<script src="assets/fullcalendar/fullcalendar/fullcalendar.min.js"></script>	
	<script type="text/javascript" src="assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
	<script type="text/javascript" src="assets/bootstrap-daterangepicker/date.js"></script>
	<!-- ie8 fixes -->
	<!--[if lt IE 9]>
	<script src="assets/js/excanvas.js"></script>
	<script src="assets/js/respond.js"></script>
	<![endif]-->	
	<script type="text/javascript" src="assets/uniform/jquery.uniform.min.js"></script>
	<script type="text/javascript" src="assets/data-tables/jquery.dataTables.js"></script>
	<script type="text/javascript" src="assets/data-tables/DT_bootstrap.js"></script>
	<script src="assets/js/app.js"></script>		
	<script>
		jQuery(document).ready(function() {			
			// initiate layout and plugins
			//App.setPage("table_editable");
			$('.hidenBlock').hide();
			App.init();
		});
	</script>
	<script>
		$(document).ready(function() {
			$('.typeBien').change(function(){
				$('.hidenBlock').show();
				var typeBien = $(this).val();
				var idProjet = <?= $projet->id() ?>;
				var data = 'typeBien='+typeBien+'&idProjet='+idProjet;
				$.ajax({
					type: "POST",
					url: "types-biens.php",
					data: data,
					cache: false,
					success: function(html){
						$('#bien').html(html);
						if(typeBien=="appartement"){
							$('#nomBienLabel').text("Appartements");	
						}
						else{
							$('#nomBienLabel').text("Locaux commerciaux");
						}
					}
				});
			});
		});
	</script>
</body>
<!-- END BODY -->
</html>
<?php
}
else if(isset($_SESSION['userMerlaTrav']) and $_SESSION->profil()!="admin"){
	header('Location:dashboard.php');
}
else{
    header('Location:index.php');    
}

?>