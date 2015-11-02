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
    	//les sources
    	$fournisseursManager = new FournisseurManager($pdo);
		$fournisseurNumber = $fournisseursManager->getFournisseurNumbers();
		if($fournisseurNumber!=0){
			$fournisseurPerPage = 10;
	        $pageNumber = ceil($fournisseurNumber/$fournisseurPerPage);
	        $p = 1;
	        if(isset($_GET['p']) and ($_GET['p']>0 and $_GET['p']<=$pageNumber)){
	            $p = $_GET['p'];
	        }
	        else{
	            $p = 1;
	        }
	        $begin = ($p - 1) * $fournisseurPerPage;
	        $pagination = paginate('fournisseurs.php', '?p=', $pageNumber, $p);
			$fournisseurs = $fournisseursManager->getFournisseursByLimits($begin, $fournisseurPerPage);	 
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
							Gestion des fournisseurs
						</h3>
						<ul class="breadcrumb">
							<li>
								<i class="icon-home"></i>
								<a>Accueil</a> 
								<i class="icon-angle-right"></i>
							</li>
							<li>
								<i class="icon-truck"></i>
								<a>Gestion des fournisseurs</a>
							</li>
						</ul>
						<!-- END PAGE TITLE & BREADCRUMB-->
					</div>
				</div>
				<!-- END PAGE HEADER-->
				<!-- BEGIN PAGE CONTENT-->
				<div class="row-fluid">
					<div class="span12">
						<!-- BEGIN EXAMPLE TABLE PORTLET-->
						<?php if(isset($_SESSION['fournisseur-delete-success'])){ ?>
                         	<div class="alert alert-success">
								<button class="close" data-dismiss="alert"></button>
								<?= $_SESSION['fournisseur-delete-success'] ?>		
							</div>
                         <?php } 
                         	unset($_SESSION['fournisseur-delete-success']);
                         ?>
                         <?php if(isset($_SESSION['fournisseur-update-success'])){ ?>
                         	<div class="alert alert-success">
								<button class="close" data-dismiss="alert"></button>
								<?= $_SESSION['fournisseur-update-success'] ?>		
							</div>
                         <?php } 
                         	unset($_SESSION['fournisseur-update-success']);
                         ?>
						<div class="portlet" id="listFournisseurs">
							<div class="portlet-title">
								<h4>Les fournisseurs</h4>
								<div class="tools">
									<a href="javascript:;" class="collapse"></a>
									<a href="javascript:;" class="remove"></a>
								</div>
							</div>
							<div class="portlet-body">
								<table class="table table-striped table-bordered table-advance table-hover" id="sample_editable_1">
									<thead>
										<tr>
											<th style="width:20%">Nom</th>
											<th style="width:20%" class="hidden-phone">Adresse</th>
											<th style="width:30%" class="hidden-phone">Date</th>
											<th style="width:4%" class="hidden-phone">Tél1</th>
											<th style="width:4%" class="hidden-phone">Tél2</th>
											<th style="width:4%" class="hidden-phone">Fax</th>
											<th style="width:18%" class="hidden-phone">Email</th>
										</tr>
									</thead>
									<tbody>
										<?php 
										if($fournisseurNumber!=0){
										foreach ($fournisseurs as $fournisseur) {
										?>	
										<tr>
											<td>
												<div class="btn-group">
												    <a style="width: 200px" class="btn mini black dropdown-toggle" href="#" data-toggle="dropdown">
												    	<?= $fournisseur->nom()?> 
												        <i class="icon-angle-down"></i>
												    </a>
												    <ul class="dropdown-menu">
												        <li>
												        	<a href="livraison-add.php?idFournisseur=<?= $fournisseur->id() ?>">
												        		Nouvelle Livraison
												        	</a>
												        	<a href="livraison-fournisseur-list.php?idFournisseur=<?= $fournisseur->id() ?>">
												        		Liste des livraisons
												        	</a>
												        	<a href="fournisseurs-reglements.php?idFournisseur=<?= $fournisseur->id() ?>">
												        		Réglement
												        	</a>
												        	<a href="#update<?= $fournisseur->id();?>" data-toggle="modal" data-id="<?= $fournisseur->id(); ?>">
																Modifier
															</a>
															<a href="#delete<?= $fournisseur->id();?>" data-toggle="modal" data-id="<?= $fournisseur->id(); ?>">
																Supprimer
															</a>
												        </li>
												    </ul>
												</div>
											</td>
											<td class="hidden-phone"><?= $fournisseur->adresse()?></td>
											<td class="hidden-phone"><?= date('d/m/Y', strtotime($fournisseur->dateCreation())) ?></td>
											<td class="hidden-phone"><?= $fournisseur->telephone1() ?></td>
											<td class="hidden-phone"><?= $fournisseur->telephone2() ?></td>
											<td class="hidden-phone"><?= $fournisseur->fax() ?></td>
											<td class="hidden-phone"><?= $fournisseur->email() ?></td>
										</tr>
										<!-- updateFournisseur box begin-->
										<div id="update<?= $fournisseur->id() ?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
												<h3>Modifier les informations du fournisseur </h3>
											</div>
											<div class="modal-body">
												<form class="form-horizontal" action="controller/FournisseurUpdateController.php" method="post">
													<p>Êtes-vous sûr de vouloir modifier les infos du fournisseur <strong><?= $fournisseur->nom() ?></strong> ?</p>
													<div class="control-group">
														<label class="control-label">Nom</label>
														<div class="controls">
															<input type="text" name="nom" value="<?= $fournisseur->nom() ?>" />
														</div>
													</div>
													<div class="control-group">
														<label class="control-label">Adresse</label>
														<div class="controls">
															<input type="text" name="adresse" value="<?= $fournisseur->adresse() ?>" />
														</div>
													</div>
													<div class="control-group">
														<label class="control-label">Tél.1</label>
														<div class="controls">
															<input type="text" name="telephone1" value="<?= $fournisseur->telephone1() ?>" />
														</div>
													</div>
													<div class="control-group">
														<label class="control-label">Tél.2</label>
														<div class="controls">
															<input type="text" name="telephone2" value="<?= $fournisseur->telephone2() ?>" />
														</div>
													</div>
													<div class="control-group">
														<label class="control-label">Fax</label>
														<div class="controls">
															<input type="text" name="fax" value="<?= $fournisseur->fax() ?>" />
														</div>
													</div>
													<div class="control-group">
														<label class="control-label">Email</label>
														<div class="controls">
															<input type="text" name="email" value="<?= $fournisseur->email() ?>" />
														</div>	
													</div>
													<div class="control-group">
														<input type="hidden" name="idFournisseur" value="<?= $fournisseur->id() ?>" />
														<div class="controls">	
															<button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
															<button type="submit" class="btn red" aria-hidden="true">Oui</button>
														</div>
													</div>
												</form>
											</div>
										</div>
										<!-- updateFournisseur box end -->
										<!-- delete box begin-->
										<div id="delete<?= $fournisseur->id();?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
												<h3>Supprimer Fournisseur</h3>
											</div>
											<div class="modal-body">
												<form class="form-horizontal loginFrm" action="controller/FournisseurDeleteController.php" method="post">
													<p>Êtes-vous sûr de vouloir supprimer ce fournisseur <?= $fournisseur->nom() ?> ?</p>
													<div class="control-group">
														<label class="right-label"></label>
														<input type="hidden" name="idFournisseur" value="<?= $fournisseur->id() ?>" />
														<button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
														<button type="submit" class="btn red" aria-hidden="true">Oui</button>
													</div>
												</form>
											</div>
										</div>
										<!-- delete box end -->				
										<?php }
										} ?>
									</tbody>
									<?php
									if($fournisseurNumber != 0){
										echo $pagination;	
									}
									?>
								</table>
							</div>
						</div>
						<!-- END EXAMPLE TABLE PORTLET-->
						 <?php if(isset($_SESSION['fournisseur-add-success'])){ ?>
                         	<div class="alert alert-success">
								<button class="close" data-dismiss="alert"></button>
								<?= $_SESSION['fournisseur-add-success'] ?>		
							</div>
                         <?php } 
                         	unset($_SESSION['fournisseur-add-success']);
                         ?>
                         <?php if(isset($_SESSION['fournisseur-add-error'])){ ?>
                         	<div class="alert alert-error">
								<button class="close" data-dismiss="alert"></button>
								<?= $_SESSION['fournisseur-add-error'] ?>		
							</div>
                         <?php } 
                         	unset($_SESSION['fournisseur-add-error']);
                         ?>
						<div class="tab-pane active" id="tab_1">
                           <div class="portlet box blue">
                              <div class="portlet-title">
                                 <h4><i class="icon-edit"></i>Ajouter un fournisseur</h4>
                                 <div class="tools">
                                    <a href="javascript:;" class="collapse"></a>
                                    <a href="javascript:;" class="remove"></a>
                                 </div>
                              </div>
                              <div class="portlet-body form">
                                 <!-- BEGIN FORM-->
                                 <form action="controller/FournisseurAddController.php" method="POST" class="horizontal-form">
                                    <div class="row-fluid">
                                       <div class="span4">
                                          <div class="control-group autocomplet_container">
                                             <label class="control-label" for="nom">Nom</label>
                                             <div class="controls">
                                                <input type="text" id="nomFournisseur" name="nom" class="m-wrap span12" onkeyup="autocompletFournisseur()">
                                                <ul id="fournisseurList"></ul>
                                             </div>
                                          </div>
                                       </div>
                                       <!--/span-->
                                       <div class="span4">
                                          <div class="control-group">
                                             <label class="control-label" for="adresse">Adresse</label>
                                             <div class="controls">
                                                <input type="text" id="adresse" name="adresse" class="m-wrap span12">
                                             </div>
                                          </div>
                                       </div>
                                       <div class="span4">
                                          <div class="control-group">
                                             <label class="control-label" for="telephone1">Téléphone1</label>
                                             <div class="controls">
                                                <input type="text" id="telephone1" name="telephone1" class="m-wrap span12">
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="row-fluid">
                                    	<div class="span4">
                                          <div class="control-group">
                                             <label class="control-label" for="telephone2">Téléphone2</label>
                                             <div class="controls">
                                                <input type="text" id="telephone2" name="telephone2" class="m-wrap span12">
                                             </div>
                                          </div>
                                       </div>
                                       <div class="span4">
                                          <div class="control-group">
                                             <label class="control-label" for="fax">Fax</label>
                                             <div class="controls">
                                                <input type="text" id="fax" name="fax" class="m-wrap span12">
                                             </div>
                                          </div>
                                       </div>
                                       <!--/span-->
                                       <div class="span4">
                                          <div class="control-group">
                                             <label class="control-label" for="email">Email</label>
                                             <div class="controls">
                                                <input type="text" id="email" name="email" class="m-wrap span12">
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="form-actions">
                                       <button type="submit" class="btn blue">Enregistrer <i class="icon-save"></i></button>
                                       <button type="reset" class="btn red">Annuler</button>
                                    </div>
                                 </form>
                                 <!-- END FORM--> 
                              </div>
                           </div>
                        </div>
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
else if(isset($_SESSION['userMerlaTrav']) and $_SESSION->profil()!="admin"){
	header('Location:dashboard.php');
}
else{
    header('Location:index.php');    
}
?>