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
    	//les services
    	$clients = "";
    	$clientManager = new ClientManager($pdo);
		$projetManager = new ProjetManager($pdo);
		$contratsManager = new ContratManager($pdo);
		$operationManager = new OperationManager($pdo); 
		$locauxManager = new LocauxManager($pdo);
		$appartementManager = new AppartementManager($pdo);
        if(isset($_SESSION['searchClientResult'])){
            $clients = $_SESSION['searchClientResult'];
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
							Les recherches
						</h3>
						<ul class="breadcrumb">
							<li>
								<i class="icon-home"></i>
								<a>Accueil</a> 
								<i class="icon-angle-right"></i>
							</li>
							<li>
								<i class="icon-search"></i>
								<a>Rechercher</a>
								<i class="icon-angle-right"></i>
							</li>
							<li><a>Clients</a></li>
						</ul>
						<!-- END PAGE TITLE & BREADCRUMB-->
					</div>
				</div>
				<!-- END PAGE HEADER-->
				<!-- BEGIN PAGE CONTENT-->
				<div class="row-fluid">
					<div class="span12">
						<a href="recherches.php" class="btn big yellow">
							<i class="m-icon-big-swapleft m-icon-white"></i> 
							Page recherches
							<i class="icon-search"></i>
						</a>
						<br><br>
						<div class="tab-pane active" id="tab_1">
                           <div class="portlet box blue">
                              <div class="portlet-title">
                                 <h4><i class="icon-search"></i>Chercher un client</h4>
                                 <div class="tools">
                                    <a href="javascript:;" class="collapse"></a>
                                    <a href="javascript:;" class="remove"></a>
                                 </div>
                              </div>
                              <div class="portlet-body form">
                                 <!-- BEGIN FORM-->
                                 <?php if(isset($_SESSION['client-search-error'])){ ?>
                                 	<div class="alert alert-error">
    									<button class="close" data-dismiss="alert"></button>
    									<?= $_SESSION['client-search-error'] ?>		
    								</div>
                                 <?php } 
                                 	unset($_SESSION['client-search-error']);
                                 ?>
                                 <form action="controller/SearchClientController.php" method="POST" class="horizontal-form">
                                    <div class="row-fluid">
                                       <div class="span6 ">
                                          <div class="control-group">
                                             <label class="control-label">Recherche par</label>
				                              <div class="controls">
				                                 <label class="radio">
				                                 <input type="radio" name="searchOption" value="searchByName" checked />
				                                 Nom
				                                 </label>
				                                 <label class="radio">
				                                 <input type="radio" name="searchOption" value="searchByCIN" />
				                                 CIN
				                                 </label>  
				                              </div>
                                          </div>
                                       </div>
                                       <!--/span-->
                                       <div class="span6 ">
                                          <div class="control-group autocomplet_container">
                                             <label class="control-label" for="nomClient">Tapez votre recherche</label>
                                             <div class="controls">
                                                <input type="text" id="nomClient" name="search" class="m-wrap span12" onkeyup="autocompletClient()">
                                                <ul id="clientList"></ul>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="form-actions">
                                       <button type="submit" class="btn green"><i class="icon-search"></i>Lancer la recherche</button>
                                    </div>
                                 </form>
                                 <!-- END FORM--> 
                              </div>
                           </div>
                        </div>
						<!-- BEGIN EXAMPLE TABLE PORTLET-->
						<div class="portlet box blue">
							<div class="portlet-title">
								<h4><i class="icon-reorder"></i>Les clients</h4>
								<div class="tools">
									<a href="javascript:;" class="collapse"></a>
									<a href="javascript:;" class="remove"></a>
								</div>
							</div>
							<div class="portlet-body">
								<div class="clearfix">
								</div>
								<?php if((bool)$clients){ ?>
										<?php foreach ($clients as $client){ 
											$contrats = $contratsManager->getContratsByIdClient($client->id());	
										?>	
										<h3><?= $client->nom()?></h3>
										<?php if((bool)$contrats){ ?>
										<table class="table table-striped table-hover table-bordered" id="sample_editable_1">
											<thead>
												<tr>
													<th>Contrat</th>
													<th class="hidden-phone">Type</th>
													<th>Bien</th>
													<th>Prix Vente</th>
													<th>Réglements</th>
													<th>Reste</th>
													<th class="hidden-phone">Paiements</th>
													<!--th class="hidden-phone">Désister</th>
													<th class="hidden-phone">Supprimer</th-->
												</tr>
											</thead>
											<tbody>
												<?php foreach ($contrats as $contrat) {
													$sommeOperations = $operationManager->sommeOperations($contrat->id());
													$bien = "";
													$typeBien = "";
													if($contrat->typeBien()=="appartement"){
														$bien = $appartementManager->getAppartementById($contrat->idBien());
														$typeBien = "Appartement";
													}
													else{
														$bien = $locauxManager->getLocauxById($contrat->idBien());
														$typeBien = "Local commercial";
													}	
												?>	
												<tr class="">
													<td>
														<div class="btn-group">
														    <a style="width: 200px;height: 30px" class="btn mini dropdown-toggle" href="#" data-toggle="dropdown">
														    	<?= $clientManager->getClientById($contrat->idClient())->nom() ?> - N°&nbsp;<?= $contrat->numero() ?>
																<br>														    	
														    	<strong><?= $projetManager->getProjetById($contrat->idProjet())->nom() ?></strong>	 
														        <i class="icon-angle-down"></i>
														    </a>
														    <ul class="dropdown-menu">
														        <li>
														        	<a target="_blank" href="contrat.php?codeContrat=<?= $contrat->code() ?>">
																		Consulter Contrat
																	</a>
														        	<a href="#addReglement<?= $contrat->id() ?>" data-toggle="modal" data-id="<?= $contrat->id() ?>">
														        		Nouveau réglement
														        	</a>
														        	<a target="_blank" href="controller/ContratPrintController.php?idContrat=<?= $contrat->id() ?>">
														        		Imprimer Contrat
														        	</a>
														        	<a target="_blank" href="controller/ClientFichePrintController.php?idContrat=<?= $contrat->id() ?>">
														        		Imprimer Fiche Client
														        	</a>
														        	<?php if($contrat->status()=="actif"){
																	?>
																	<a style="color:red" href="#desisterContrat<?= $contrat->id() ?>" data-toggle="modal" data-id="<?= $contrat->id() ?>">
																		Désister
																	</a>
																	<?php 
																	}
																	else{
																	?>	
																	<a href="#activerContrat<?= $contrat->id() ?>" data-toggle="modal" data-id="<?= $contrat->id() ?>">
																		Activer
																	</a>	
																	<?php	
																	}
																	?>
																	<a href="#updateContrat<?= $contrat->id() ?>" data-toggle="modal" data-id="<?= $contrat->id() ?>">
																		Modifier
																	</a>
																	<a href="#deleteContrat<?= $contrat->id() ?>" data-toggle="modal" data-id="<?= $contrat->id() ?>">
																		Supprimer
																	</a>
														        </li>
														    </ul>
														</div>
													</td>
													<td class="hidden-phone" style="width: 15%"><?= $typeBien ?></td>
													<td><?= $bien->nom() ?></td>
													<td style="width: 15%"><?= number_format($contrat->prixVente(), 2, ',', ' ') ?></td>
													<td><?= number_format($sommeOperations, 2, ',', ' ') ?></td>
													<td><?= number_format($contrat->prixVente()-$sommeOperations, 2, ',', ' ') ?></td>
													<td class="hidden-phone">
														<a style="height: 30px" target="_blank" class="btn mini red" href="operations.php?idContrat=<?= $contrat->id() ?>&idProjet=<?= $contrat->idProjet() ?>" data-toggle="modal" data-id="">
															<i class="icon-folder-open"></i><br>Voir
														</a>
													</td>
													<?php if(isset($_SESSION['print-quittance'])){ ?>
														<td>
															<a style="height: 30px" class="btn mini blue" href="controller/OperationPrintController.php?idOperation=<?= $operationManager->getLastIdByIdContrat($contrat->id()) ?>"> 
																<i class="m-icon-white icon-print"></i><br>Quittance
															</a>
														</td>
													<?php 
													} ?>
												</tr>	
												<!-- desistement box begin-->
												<div id="desisterContrat<?= $contrat->id() ?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
													<div class="modal-header">
														<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
														<h3>Désister le contrat </h3>
													</div>
													<div class="modal-body">
														<form class="form-horizontal loginFrm" action="controller/ContratDesistementController.php?p=99" method="post">
															<p>Êtes-vous sûr de vouloir désister le contrat <strong>N°<?= $contrat->id() ?></strong> ?</p>
															<div class="control-group">
																<label class="right-label"></label>
																<input type="hidden" name="idContrat" value="<?= $contrat->id() ?>" />
																<button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
																<button type="submit" class="btn red" aria-hidden="true">Oui</button>
															</div>
														</form>
													</div>
												</div>
												<!-- desistement box end -->
												<!-- addReglement box begin-->
												<div id="addReglement<?= $contrat->id() ?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
													<div class="modal-header">
														<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
														<h3>Nouveau réglement </h3>
													</div>
													<div class="modal-body">
														<form class="form-horizontal loginFrm" action="controller/OperationAddController.php?p=999" method="post">
															<p>Êtes-vous sûr de vouloir ajouter un réglement pour le contrat <strong>N°<?= $contrat->id() ?></strong> ?</p>
															<div class="control-group">
					                                             <label class="control-label" for="code">Date opération</label>
					                                             <div class="controls">
					                                                <div class="input-append date date-picker" data-date="" data-date-format="yyyy-mm-dd">
									                                    <input name="dateOperation" id="dateOperation" class="m-wrap m-ctrl-small date-picker" type="text" value="<?= date('Y-m-d') ?>" />
									                                    <span class="add-on"><i class="icon-calendar"></i></span>
									                                 </div>
					                                             </div>
					                                          </div>
															<div class="control-group">
																<label class="control-label">Montant</label>
																<div class="controls">
																	<input type="text" id="montant" name="montant" />
																</div>
															</div>
															<div class="control-group">
					                                             <label class="control-label" for="modePaiement">Mode de paiement</label>
					                                             <div class="controls">
					                                                <div class="controls">
																		<select name="modePaiement" id="modePaiement">
																			<option value="Especes">Espèces</option>
																			<option value="Cheque">Chèque</option>
																			<option value="Versement">Versement</option>
																			<option value="Virement">Virement</option>
																		</select>
																	</div>
					                                             </div>
					                                          </div>
															<div class="control-group">
																<label class="right-label"></label>
																<input type="hidden" name="idContrat" value="<?= $contrat->id() ?>" />
																<button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
																<button type="submit" class="btn red" aria-hidden="true">Oui</button>
															</div>
														</form>
													</div>
												</div>
												<!-- addReglement box end -->
												<!-- activation box begin-->
												<div id="activerContrat<?= $contrat->id() ?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
													<div class="modal-header">
														<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
														<h3>Activer le contrat </h3>
													</div>
													<div class="modal-body">
														<form class="form-horizontal loginFrm" action="controller/ContratActivationController.php?p=99" method="post">
															<p>Êtes-vous sûr de vouloir activer le contrat <strong>N°<?= $contrat->id() ?></strong> ?</p>
															<div class="control-group">
																<label class="right-label"></label>
																<input type="hidden" name="idContrat" value="<?= $contrat->id() ?>" />
																<button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
																<button type="submit" class="btn red" aria-hidden="true">Oui</button>
															</div>
														</form>
													</div>
												</div>
												<!-- activation box end -->	
												<!-- updateContrat box begin-->
												<div id="updateContrat<?= $contrat->id() ?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
													<div class="modal-header">
														<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
														<h3>Modifier les informations du contrat </h3>
													</div>
													<div class="modal-body">
														<form class="form-horizontal" action="controller/ContratUpdateController.php?p=99" method="post">
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
																	<input type="text" name="echance" value="<?= $contrat->echeance() ?>" />
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
												<!-- delete box begin-->
												<div id="deleteContrat<?= $contrat->id() ?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
													<div class="modal-header">
														<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
														<h3>Supprimer le contrat </h3>
													</div>
													<div class="modal-body">
														<form class="form-horizontal loginFrm" action="controller/ContratDeleteController.php?p=99" method="post">
															<p>Êtes-vous sûr de vouloir supprimer le contrat <strong>N°<?= $contrat->id() ?></strong> ?</p>
															<div class="control-group">
																<label class="right-label"></label>
																<input type="hidden" name="idContrat" value="<?= $contrat->id() ?>" />
																<button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
																<button type="submit" class="btn red" aria-hidden="true">Oui</button>
															</div>
														</form>
													</div>
												</div>
												<!-- delete box end -->	
												<?php 
												}//end foreach contrats
										}//end foreach clients ?>
											</tbody>
										</table>
										<?php 
										}//end if contrats ?>
								<?php } 
									else{
								?>		
								<div class="alert alert-error">
    									<button class="close" data-dismiss="alert"></button>
    									Aucun résultat trouvé.
    								</div>
								<?php		
									}
								?>
							</div>
						</div>
						<br><br><br><br><br><br>
						<!-- END EXAMPLE TABLE PORTLET-->
					</div>
				</div>
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
	<!-- ie8 fixes -->
	<!--[if lt IE 9]>
	<script src="assets/js/excanvas.js"></script>
	<script src="assets/js/respond.js"></script>
	<![endif]-->	
	<script type="text/javascript" src="assets/uniform/jquery.uniform.min.js"></script>
	<script type="text/javascript" src="assets/data-tables/jquery.dataTables.js"></script>
	<script type="text/javascript" src="assets/data-tables/DT_bootstrap.js"></script>
	<script src="assets/js/app.js"></script>
	<script type="text/javascript" src="script.js"></script>		
	<script>
		jQuery(document).ready(function() {			
			// initiate layout and plugins
			//App.setPage("table_editable");
			App.init();
		});
	</script>
</body>
<!-- END BODY -->
</html>
<?php
}
else{
    header('Location:index.php');    
}
?>