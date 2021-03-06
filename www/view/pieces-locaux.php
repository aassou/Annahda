<?php
	include('../autoload.php');
    session_start();
    if(isset($_SESSION['userMerlaTrav']) ){
    	//les sources
    	$idProjet = 0;
		$idLocaux = 0;
    	$projetManager = new ProjetManager($pdo);
		$locauxManager = new LocauxManager($pdo);
		if((isset($_GET['idProjet']) and ($_GET['idProjet'])>0 and $_GET['idProjet']<=$projetManager->getLastId())
			and (isset($_GET['idLocaux']) and($_GET['idLocaux']>0 and $_GET['idLocaux']<=$locauxManager->getLastId()))){
			$idProjet = $_GET['idProjet'];
			$idLocaux = $_GET['idLocaux'];
			$projet = $projetManager->getProjetById($idProjet);
			$local = $locauxManager->getLocauxById($idLocaux);
			$piecesManager = new PiecesLocauxManager($pdo);
			$piecesLocaux = "";
			//test the terrain object number: if exists get terrain else do nothing
			$piecesNumber = $piecesManager->getPiecesLocauxNumberByIdLocaux($idLocaux);
			if($piecesNumber != 0){
				$piecesLocaux = $piecesManager->getPiecesLocauxByIdLocaux($idLocaux);
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
	<link href="../assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
	<link href="../assets/css/metro.css" rel="stylesheet" />
	<link href="../assets/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" />
	<link href="../assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
	<link href="../assets/css/style.css" rel="stylesheet" />
	<link href="../assets/css/style_responsive.css" rel="stylesheet" />
	<link href="../assets/css/style_default.css" rel="stylesheet" id="style_color" />
	<link href="../assets/fancybox/source/jquery.fancybox.css" rel="stylesheet" />
	<link rel="stylesheet" type="text/css" href="../assets/uniform/css/uniform.default.css" />
	<link rel="stylesheet" type="text/css" href="../assets/chosen-bootstrap/chosen/chosen.css" />
	<link rel="stylesheet" href="../assets/data-tables/DT_bootstrap.css" />
	<link rel="stylesheet" type="text/css" href="../assets/uniform/css/uniform.default.css" />
	<link rel="shortcut icon" href="favicon.ico" />
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body class="fixed-top">
	<!-- BEGIN HEADER -->
	<div class="header navbar navbar-inverse navbar-fixed-top">
		<!-- BEGIN TOP NAVIGATION BAR -->
		<?php include("../include/top-menu.php"); ?>
		<!-- END TOP NAVIGATION BAR -->
	</div>
	<!-- END HEADER -->
	<!-- BEGIN CONTAINER -->
	<div class="page-container row-fluid">
		<!-- BEGIN SIDEBAR -->
		<?php include("../include/sidebar.php"); ?>
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
							Gestion des Locaux Commerciaux
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
							<li>
								<a>Gestion des locaux commerciaux</a>
								<i class="icon-angle-right"></i>
							</li>
							<li>
								<a>Gestion des pièces</a>
							</li>
						</ul>
						<!-- END PAGE TITLE & BREADCRUMB-->
					</div>
				</div>
				<!-- END PAGE HEADER-->
				<!-- BEGIN PAGE CONTENT-->
				<?php if($idProjet!=0 and $idLocaux!=0){ ?>
				<div class="row-fluid">
					<div class="span12">
						<div class="tab-pane active" id="tab_1">
							<div class="row-fluid add-portfolio">
								<div class="pull-left">
									<a href="locaux.php?idProjet=<?= $idProjet ?>" class="btn icn-only green">
										<i class="m-icon-swapleft m-icon-white"></i>
										Retour vers Liste des Locaux Commerciaux  : <strong><?= $projetManager->getProjetById($idProjet)->nom() ?></strong>
									</a>
								</div>
								<div class="pull-right">
									<a href="projet-list.php" class="btn icn-only green"> 
										Aller vers liste des projets
										<i class="m-icon-swapright m-icon-white"></i>	 
									</a>
								</div>
							</div>
							<?php if(isset($_SESSION['locaux-add-success'])){ ?>
                         	<div class="alert alert-success">
								<button class="close" data-dismiss="alert"></button>
								<?= $_SESSION['locaux-add-success'] ?>		
							</div>
	                         <?php } 
	                         	unset($_SESSION['locaux-add-success']);
	                         ?>
	                         <?php if(isset($_SESSION['locaux-update-success'])){ ?>
                         	<div class="alert alert-success">
								<button class="close" data-dismiss="alert"></button>
								<?= $_SESSION['locaux-update-success'] ?>		
							</div>
	                         <?php } 
	                         	unset($_SESSION['locaux-update-success']);
	                         ?>
	                         <?php if(isset($_SESSION['locaux-delete-success'])){ ?>
                         	<div class="alert alert-success">
								<button class="close" data-dismiss="alert"></button>
								<?= $_SESSION['locaux-delete-success'] ?>		
							</div>
	                         <?php } 
	                         	unset($_SESSION['locaux-delete-success']);
	                         ?>
	                         <?php if(isset($_SESSION['locaux-add-error'])){ ?>
	                         	<div class="alert alert-error">
									<button class="close" data-dismiss="alert"></button>
									<?= $_SESSION['locaux-add-error'] ?>		
								</div>
	                         <?php } 
	                         	unset($_SESSION['locaux-add-error']);
	                         ?>
	                         <?php if(isset($_SESSION['locaux-update-error'])){ ?>
	                         	<div class="alert alert-error">
									<button class="close" data-dismiss="alert"></button>
									<?= $_SESSION['locaux-update-error'] ?>		
								</div>
	                         <?php } 
	                         	unset($_SESSION['locaux-update-error']);
	                         ?>
                        </div>
					</div>
				</div>
				<!-- BEGIN PicesTerrain GALLERY PORTLET-->
				<div class="row-fluid">
					<div class="span12">
						<div class="portlet">
							<div class="portlet-title">
								<h4>Pièces du Local Commercial : <?= $local->nom() ?></h4>
								<div class="tools">
									<a href="javascript:;" class="collapse"></a>
									<a href="javascript:;" class="remove"></a>
								</div>
							</div>
							<div class="portlet-body">
								<?php
								if($piecesNumber != 0){
								foreach($piecesLocaux as $pieces){
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
										<h3>Supprimer Pièce du Local</h3>
									</div>
									<div class="modal-body">
										<form class="form-horizontal loginFrm" action="../controller/LocauxPiecesDeleteController.php" method="post">
											<p>Êtes-vous sûr de vouloir supprimer cette pièce ?</p>
											<div class="control-group">
												<label class="right-label"></label>
												<input type="hidden" name="idPieceLocaux" value="<?= $pieces->id() ?>" />
												<input type="hidden" name="idProjet" value="<?= $idProjet ?>" />
												<input type="hidden" name="idLocaux" value="<?= $idLocaux ?>" />
												<button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
												<button type="submit" class="btn red" aria-hidden="true">Oui</button>
											</div>
										</form>
									</div>
								</div>
								<!-- delete box end -->
								<?php 
								}//end of loop : terrains
								}//end of if : terrainNumber
								?>
							</div>
						</div>
					</div>
				</div>
				<!-- END PicesTerrain GALLERY PORTLET-->
				<?php }
				else{
				?>
				<div class="alert alert-error">
					<button class="close" data-dismiss="alert"></button>
					<strong>Erreur système : </strong>Ce projet ou ce local n'existe pas sur votre système. Pour plus d'informations consulter votre administrateur.		
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
	<script src="../assets/js/jquery-1.8.3.min.js"></script>
	<script src="../assets/breakpoints/breakpoints.js"></script>
	<script src="../assets/bootstrap/js/bootstrap.min.js"></script>
	<script src="../assets/js/jquery.blockui.js"></script>
	<script src="../assets/js/jquery.cookie.js"></script>
	<script src="../assets/fancybox/source/jquery.fancybox.pack.js"></script>
	<!-- ie8 fixes -->
	<!--[if lt IE 9]>
    <script src="../assets/js/excanvas.js"></script>
    <script src="../assets/js/respond.js"></script>
    <![endif]-->
	<script type="text/javascript" src="../assets/uniform/jquery.uniform.min.js"></script>
	<script type="text/javascript" src="../assets/data-tables/jquery.dataTables.js"></script>
	<script type="text/javascript" src="../assets/data-tables/DT_bootstrap.js"></script>
	<script src="../assets/js/app.js"></script>
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
/*else if(isset($_SESSION['userMerlaTrav']) and $_SESSION->profil()!="admin"){
	header('Location:dashboard.php');
}*/
else{
    header('Location:index.php');    
}
?>