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
    //classes loading end
    session_start();
    if(isset($_SESSION['userMerlaTrav']) and $_SESSION['userMerlaTrav']->profil()=="admin"){
    	//les sources
    	$idProjet = 0;
    	$projetManager = new ProjetManager($pdo);
		if(isset($_GET['idProjet']) and ($_GET['idProjet'])>0 and $_GET['idProjet']<=$projetManager->getLastId()){
			$idProjet = $_GET['idProjet'];
			$projet = $projetManager->getProjetById($idProjet);
			$terrainManager = new TerrainManager($pdo);
			$piecesTerrainManager = new PiecesTerrainManager($pdo);
			$terrains = "";
			//test the terrain object number: if exists get terrain else do nothing
			$terrainNumber = $terrainManager->getTerrainNumberByIdProjet($idProjet);
			if($terrainNumber!=0){
				$terrains = $terrainManager->getTerrainByIdProjet($idProjet);	
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
	<title>AnnahdaERP - Management Application</title>
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
	<div class="page-container row-fluid sidebar-closed">
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
							Gestion des terrains - Projet : <?= $projet->nom() ?>
						</h3>
						<ul class="breadcrumb">
							<li>
								<i class="icon-home"></i>
								<a href="dashboard.php">Accueil</a> 
								<i class="icon-angle-right"></i>
							</li>
							<li>
								<i class="icon-briefcase"></i>
								<a href="projets.php">Gestion des projets</a>
								<i class="icon-angle-right"></i>
							</li>
							<li>
                                <a href="projet-details.php?idProjet=<?= $projet->id() ?>">Projet <strong><?= $projet->nom() ?></strong></a>
                                <i class="icon-angle-right"></i>
                            </li>
							<li><a>Gestion des terrains</a></li>
						</ul>
						<!-- END PAGE TITLE & BREADCRUMB-->
					</div>
				</div>
				<!-- END PAGE HEADER-->
				<!-- BEGIN PAGE CONTENT-->
				<?php if($idProjet!=0){ ?>
				<div class="row-fluid">
					<div class="span12">
					    <div class="pull-right get-down">
                            <a href="#addTerrain" class="btn icn-only green">Ajouter Nouveau Terrain</a>
                        </div>
						<div class="tab-pane active" id="tab_1">
							<?php if(isset($_SESSION['terrain-add-success'])){ ?>
                         	<div class="alert alert-success">
								<button class="close" data-dismiss="alert"></button>
								<?= $_SESSION['terrain-add-success'] ?>		
							</div>
	                         <?php } 
	                         	unset($_SESSION['terrain-add-success']);
	                         ?>
	                         <?php if(isset($_SESSION['terrain-add-error'])){ ?>
	                         	<div class="alert alert-error">
									<button class="close" data-dismiss="alert"></button>
									<?= $_SESSION['terrain-add-error'] ?>		
								</div>
	                         <?php } 
	                         	unset($_SESSION['terrain-add-error']);
	                         ?>
                           <div class="portlet box grey">
                              <div class="portlet-title">
                                 <h4><i class="icon-edit"></i>Ajouter un nouveau terrain dans le projet : <strong><?= $projet->nom() ?></strong></h4>
                                 <div class="tools">
                                    <a href="javascript:;" class="collapse"></a>
                                    <a href="javascript:;" class="remove"></a>
                                 </div>
                              </div>
                              <div class="portlet-body form">
                                 <!-- BEGIN FORM-->
                                 <form action="controller/TerrainAddController.php" method="POST" class="horizontal-form">
                                    <div class="row-fluid">
                                       <div class="span3 ">
                                          <div class="control-group">
                                             <label class="control-label" for="vendeur">Vendeur</label>
                                             <div class="controls">
                                                <input type="text" id="vendeur" name="vendeur" class="m-wrap span12">
                                             </div>
                                          </div>
                                       </div>
                                       <div class="span3 ">
                                          <div class="control-group">
                                             <label class="control-label" for="prix">Prix</label>
                                             <div class="controls">
                                                <input type="text" id="prix" name="prix" class="m-wrap span12">
                                             </div>
                                          </div>
                                       </div>
                                       <div class="span3 ">
                                          <div class="control-group">
                                             <label class="control-label" for="fraisAchat">Frais d'achat</label>
                                             <div class="controls">
                                                <input type="text" id="fraisAchat" name="fraisAchat" class="m-wrap span12">
                                             </div>
                                          </div>
                                       </div>
                                       <div class="span3 ">
                                          <div class="control-group">
                                             <label class="control-label" for="superficie">Superficie</label>
                                             <div class="controls">
    											<input type="text" id="superficie" name="superficie" class="m-wrap span12">
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="row-fluid">
                                       <div class="span6 ">
                                          <div class="control-group">
                                             <label class="control-label" for="emplacement">Emplacement</label>
                                             <div class="controls">
                                             	<input type="text" id="emplacement" name="emplacement" class="m-wrap span12">
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="form-actions">
                                    	<input type="hidden" id="idProjet" name="idProjet" value="<?= $idProjet ?>" class="m-wrap span12">
                                    	<button type="submit" class="btn black">Enregistrer <i class="icon-save"></i></button>
                                    	<button type="reset" class="btn red">Annuler</button>
                                    </div>
                                 </form>
                                 <!-- END FORM--> 
                              </div>
                           </div>
                        </div>
					</div>
				</div>
				<div class="row-fluid"> 
					<div class="span12">
						<!-- BEGIN Terrain TABLE PORTLET-->
						<?php if(isset($_SESSION['terrain-update-error'])){ ?>
                         	<div class="alert alert-error">
								<button class="close" data-dismiss="alert"></button>
								<?= $_SESSION['terrain-update-error'] ?>		
							</div>
                         <?php } 
                         	unset($_SESSION['terrain-update-error']);
                         ?>
						<?php if(isset($_SESSION['terrain-update-success'])){ ?>
                     	<div class="alert alert-success">
							<button class="close" data-dismiss="alert"></button>
							<?= $_SESSION['terrain-update-success'] ?>		
						</div>
                         <?php } 
                         	unset($_SESSION['terrain-update-success']);
                         ?>
                         <?php if(isset($_SESSION['terrain-delete-success'])){ ?>
                     	<div class="alert alert-success">
							<button class="close" data-dismiss="alert"></button>
							<?= $_SESSION['terrain-delete-success'] ?>		
						</div>
                         <?php } 
                         	unset($_SESSION['terrain-delete-success']);
                         ?>
						<?php if(isset($_SESSION['pieces-add-success'])){ ?>
                         	<div class="alert alert-success">
								<button class="close" data-dismiss="alert"></button>
								<?= $_SESSION['pieces-add-success'] ?>		
							</div>
                         <?php } 
                         	unset($_SESSION['pieces-add-success']);
                         ?>
						<?php if(isset($_SESSION['pieces-add-error'])){ ?>
                         	<div class="alert alert-error">
								<button class="close" data-dismiss="alert"></button>
								<?= $_SESSION['pieces-add-error'] ?>		
							</div>
                         <?php } 
                         	unset($_SESSION['pieces-add-error']);
                         ?>
                         <?php if(isset($_SESSION['pieces-delete-success'])){ ?>
                         	<div class="alert alert-success">
								<button class="close" data-dismiss="alert"></button>
								<?= $_SESSION['pieces-delete-success'] ?>		
							</div>
                         <?php } 
                         	unset($_SESSION['pieces-delete-success']);
                         ?>
						<div class="portlet" id="listTerrain">
							<div class="portlet-title">
								<h4>Informations Térrain</h4>
								<div class="tools">
									<a href="javascript:;" class="collapse"></a>
									<a href="javascript:;" class="remove"></a>
								</div>
							</div>
							<div class="portlet-body">
								<table class="table table-striped table-bordered table-advance table-hover">
									<thead>
										<tr>
											<th style="width: 40%" class="hidden-phone">Emplacement</th>
											<th style="width: 20%">Vendeur</th>
											<th style="width: 10%" class="hidden-phone">Superficie</th>
											<th style="width: 15%" >Prix</th>
											<th style="width: 15%" class="hidden-phone">Frais</th>
										</tr>
									</thead>
									<tbody>
										<?php
										if($terrainNumber != 0){
										foreach($terrains as $terrain){
										?>		
										<tr>
											<td class="hidden-phone">
												<div class="btn-group">
												    <a class="btn mini dropdown-toggle" href="#" data-toggle="dropdown">
												    	<?= $terrain->emplacement() ?> 
												        <i class="icon-angle-down"></i>
												    </a>
												    <ul class="dropdown-menu">
												        <li>
												        	<a href="#addPieces<?= $terrain->id() ?>" data-toggle="modal" data-id="<?= $terrain->id() ?>">
																Ajouter Document
															</a>
												        	<a href="#updateTerrain<?= $terrain->id();?>" data-toggle="modal" data-id="<?= $terrain->id(); ?>">
																Modifier
															</a>
															<a href="#deleteTerrain<?= $terrain->id();?>" data-toggle="modal" data-id="<?= $terrain->id(); ?>">
																Supprimer
															</a>
												        </li>
												    </ul>
												</div>
											</td>
											<td><?= $terrain->vendeur() ?></td>
											<td class="hidden-phone"><?= $terrain->superficie() ?></td>
											<td><?= number_format($terrain->prix(),2, ',', ' ') ?></td>
											<td class="hidden-phone"><?= number_format($terrain->fraisAchat(),2, ',', ' ') ?></td>
										</tr>
										<!-- add file box begin-->
										<div id="addPieces<?= $terrain->id();?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
												<h3>Ajouter des pièces pour ce terrain</h3>
											</div>
											<div class="modal-body">
												<form class="form-horizontal" action="controller/TerrainPiecesAddController.php" method="post" enctype="multipart/form-data">
													<p>Êtes-vous sûr de vouloir ajouter des pièces pour ce terrain terrain ?</p>
													<div class="control-group">
														<label class="right-label">Nom Pièce</label>
														<input type="text" name="nom" />
														<label class="right-label">Lien</label>
														<input type="file" name="url" />
														<input type="hidden" name="idTerrain" value="<?= $terrain->id() ?>" />
														<input type="hidden" name="idProjet" value="<?= $idProjet ?>" />
														<label class="right-label"></label>
														<button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
														<button type="submit" class="btn red" aria-hidden="true">Oui</button>
													</div>
												</form>
											</div>
										</div>
										<!-- add files box end -->	
										<!-- update box begin-->
										<div id="updateTerrain<?= $terrain->id();?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
												<h3>Modifier Infos Terrain</h3>
											</div>
											<div class="modal-body">
												<form class="form-horizontal" action="controller/TerrainUpdateController.php" method="post">
													<p>Êtes-vous sûr de vouloir modifier les informations du terrain ?</p>
													<div class="control-group">
														<label class="right-label">Vendeur</label>
														<input type="text" name="vendeur" value="<?= $terrain->vendeur() ?>" />
														<label class="right-label">Prix</label>
														<input type="text" name="prix" value="<?= $terrain->prix() ?>" />
														<label class="right-label">Frais d'achats</label>
														<input type="text" name="fraisAchat" value="<?= $terrain->fraisAchat() ?>" />
														<label class="right-label">Superficie</label>
														<input type="text" name="superficie" value="<?= $terrain->superficie() ?>" />
														<label class="right-label">Emplacement</label>
														<input type="text" name="emplacement" value="<?= $terrain->emplacement() ?>" />
														<input type="hidden" name="idTerrain" value="<?= $terrain->id() ?>" />
														<input type="hidden" name="idProjet" value="<?= $idProjet ?>" />
														<label class="right-label"></label>
														<button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
														<button type="submit" class="btn red" aria-hidden="true">Oui</button>
													</div>
												</form>
											</div>
										</div>
										<!-- update box end -->	
										<!-- delete box begin-->
										<div id="deleteTerrain<?php echo $terrain->id();?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
												<h3>Supprimer Terrain</h3>
											</div>
											<div class="modal-body">
												<form class="form-horizontal loginFrm" action="controller/TerrainDeleteController.php" method="post">
													<p>Êtes-vous sûr de vouloir supprimer le terrain <strong><?= $terrain->emplacement() ?></strong> ?</p>
													<div class="control-group">
														<label class="right-label"></label>
														<input type="hidden" name="idTerrain" value="<?= $terrain->id() ?>" />
														<input type="hidden" name="idProjet" value="<?= $idProjet ?>" />
														<button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
														<button type="submit" class="btn red" aria-hidden="true">Oui</button>
													</div>
												</form>
											</div>
										</div>
										<!-- delete box end -->	
										<?php
										}//end of loop
										}//end of if
										?>
									</tbody>
								</table>
							</div>
						</div>
						<!-- END Terrain TABLE PORTLET-->
						<!-- BEGIN PicesTerrain GALLERY PORTLET-->
						<div class="row-fluid">
							<div class="span12">
								<div class="portlet">
									<div class="portlet-title">
										<h4>Pièces Térrain</h4>
										<div class="tools">
											<a href="javascript:;" class="collapse"></a>
											<a href="javascript:;" class="remove"></a>
										</div>
									</div>
									<div class="portlet-body">
										<?php
										if($terrainNumber != 0){
										foreach($terrains as $terrain){
											$piecesTerrainNumber = $piecesTerrainManager->getPiecesTerrainNumberByIdTerrain($terrain->id());
											if($piecesTerrainNumber!=0){
												$piecesTerrain = $piecesTerrainManager->getPiecesTerrainByIdTerrain($terrain->id());
												foreach($piecesTerrain as $pieces){
										?>
										<div class="span3">
											<div class="item">
												<a class="fancybox-button" data-rel="fancybox-button" title="<?= $pieces->nom() ?>" href="<?= $pieces->url() ?>">
													<div class="zoom">
														<img style="height: 100px; width: 200px" src="<?= $pieces->url() ?>" alt="<?= $pieces->nom() ?>" />							
														<div class="zoom-icon"></div>
													</div>
												</a>
											</div>
											<a class="btn mini red" href="#deletePiece<?= $pieces->id() ?>" data-toggle="modal" data-id="<?= $pieces->id() ?>">
												Supprimer
											</a>
											<br><br>	
										</div>
										<!-- delete box begin-->
										<div id="deletePiece<?php echo $pieces->id();?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
												<h3>Supprimer Pièce du Terrain</h3>
											</div>
											<div class="modal-body">
												<form class="form-horizontal loginFrm" action="controller/TerrainPiecesDeleteController.php" method="post">
													<p>Êtes-vous sûr de vouloir supprimer cette pièce ?</p>
													<div class="control-group">
														<label class="right-label"></label>
														<input type="hidden" name="idPieceTerrain" value="<?= $pieces->id() ?>" />
														<input type="hidden" name="idProjet" value="<?= $idProjet ?>" />
														<button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
														<button type="submit" class="btn red" aria-hidden="true">Oui</button>
													</div>
												</form>
											</div>
										</div>
										<!-- delete box end -->	
										<?php		
												}//end of loop : piecesTerrain
											}//end of if : piecesTerrainNumber
										?>
										<?php 
										}//end of loop : terrains
										}//end of if : terrainNumber
										?>
									</div>
								</div>
							</div>
						</div>
						<!-- END PicesTerrain GALLERY PORTLET-->
					</div>
				</div>
				<?php }
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
			App.init();
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