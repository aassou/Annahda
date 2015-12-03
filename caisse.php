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
    if( isset($_SESSION['userMerlaTrav']) ){
    	//les sources
		$employeManager = new EmployeSocieteManager($pdo);
		$projetManager = new ProjetManager($pdo);
		$caisseEntreesManager = new CaisseEntreesManager($pdo);
		$caisseSortiesManager = new CaisseSortiesManager($pdo);
		$projets = $projetManager->getProjets();
		$employes = "";
		//test the employeSociete object number: if exists get terrain else do nothing
		$employeNumber = $employeManager->getEmployeSocieteNumber();
		if($employeNumber!=0){
			$employeSocietePerPage = 10;
	        $pageNumber = ceil($employeNumber/$employeSocietePerPage);
	        $p = 1;
	        if(isset($_GET['p']) and ($_GET['p']>0 and $_GET['p']<=$pageNumber)){
	            $p = $_GET['p'];
	        }
	        else{
	            $p = 1;
	        }
	        $begin = ($p - 1) * $employeSocietePerPage;
	        $pagination = paginate('employes-societe.php', '?p=', $pageNumber, $p);
			$employesSociete = $employeManager->getEmployesSocieteByLimits($begin, $employeSocietePerPage);	
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
	<link rel="stylesheet" type="text/css" href="assets/bootstrap-datepicker/css/datepicker.css" />
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
							Gestion de la caisse
						</h3>
						<ul class="breadcrumb">
							<li>
								<i class="icon-home"></i>
								<a href="dashboard.php">Accueil</a> 
								<i class="icon-angle-right"></i>
							</li>
							<li>
								<i class="icon-money"></i>
								<a>Gestion de la caisse</a>
							</li>
						</ul>
						<!-- END PAGE TITLE & BREADCRUMB-->
					</div>
				</div>
				<!-- END PAGE HEADER-->
				<!-- BEGIN PAGE CONTENT-->
				<!--div class="row-fluid">
					<div class="span12 responsive">
						<div class="dashboard-stat purple">
							<div class="visual hidden-phone">
								<i class="icon-money"></i>
							</div>
							<div class="details">
								<div class="number">
									<?= 
									number_format($caisseEntreesManager->getTotalCaisseEntrees()-$caisseSortiesManager->getTotalCaisseSorties(), 2, ',', ' ')
									?>
									DH
								</div>
								<div class="desc">									
									Bilan de la caisse<br> (Les Entrées - Les Sorties)
								</div>
							</div>
							<a class="more" href="#">
								Générer le rapport des transactions <i class="m-icon-swapright m-icon-white"></i>
							</a>						
						</div>
					</div>
				</div-->
				<div class="row-fluid">
					<div class="span12">
						<div class="tab-pane active" id="tab_1">
							<?php if(isset($_SESSION['entrees-add-success'])){ ?>
                         	<div class="alert alert-success">
								<button class="close" data-dismiss="alert"></button>
								<?= $_SESSION['entrees-add-success'] ?>		
							</div>
	                         <?php } 
	                         	unset($_SESSION['entrees-add-success']);
	                         ?>
	                         <?php if(isset($_SESSION['entrees-add-error'])){ ?>
                         	<div class="alert alert-error">
								<button class="close" data-dismiss="alert"></button>
								<?= $_SESSION['entrees-add-error'] ?>		
							</div>
	                         <?php } 
	                         	unset($_SESSION['entrees-add-error']);
	                         ?>
                           <div class="portlet box grey">
                              <div class="portlet-title">
                                 <h4><i class="icon-signin"></i>Gestion des Entreés de la Caisse</h4>
                                 <div class="tools">
                                    <a href="javascript:;" class="collapse"></a>
                                    <a href="javascript:;" class="remove"></a>
                                 </div>
                              </div>
                              <div class="portlet-body form">
                                 <!-- BEGIN FORM-->
                                 <!-- BEGIN FORM Entrées Mohamed-->
									<form action="controller/CaisseEntreesAddController.php" method="POST" class="horizontal-form">
	                                 <div class="row-fluid">	
	                                 	<div class="span3">
                                          <div class="control-group">
                                             <label class="control-label" for="montant">Montant</label>
                                             <div class="controls">
                                                <input type="text" id="montant" name="montant" class="m-wrap span12" placeholder="">
                                             </div>
                                          </div>
	                                 	</div>
	                                 	<div class="span3">
                                          <div class="control-group">
                                          	<label class="control-label" for="designation">Désignation</label>
                                             <div class="controls">
                                                <input type="text" id="designation" name="designation" class="m-wrap span12" placeholder="">
                                             </div>
                                          </div>
	                                 	</div>
	                                 	<div class="span3 ">
                                          <div class="control-group">
                                          	<label class="control-label" for="dateOperation">Date opération</label>
                                             <div class="controls">
    											<div class="input-append date date-picker" data-date="" data-date-format="yyyy-mm-dd">
				                                    <input name="dateOperation" id="dateOperation" class="m-wrap m-ctrl-small date-picker" type="text" value="<?= date('Y-m-d') ?>" />
				                                    <span class="add-on"><i class="icon-calendar"></i></span>
				                                </div>
                                             </div>
                                          </div>
                                       </div>
	                                 </div>
	                                 <div class="row-fluid">
	                                 	<div class="span3">
	                                          <div class="control-group">
	                                             <div class="controls">
	                                                <input type="submit" class="m-wrap span12 btn black" value="OK +">
	                                                <input type="hidden" name="utilisateur" value="<?= $_SESSION['userMerlaTrav']->login() ?>">
	                                             </div>
	                                          </div>
	                                 	</div>
	                                 </div>
                                 </form>
                                 <!-- END FORM Entrées Mohamed-->
								<hr>
								<div class="row-fluid hidden-phone">
									<a class="btn blue big">
										Les entrées = 
										<?= 
											number_format($caisseEntreesManager->getTotalCaisseEntrees(), 2, ',', ' ')
											 
										?>
									</a>
									<a class="btn yellow big pull-right" href="caisse-entrees.php">
										Détails des entrées 
										<i class="m-icon-big-swapright m-icon-white"></i>									
									</a>
								</div>
								<div class="row-fluid hidden-desktop">
									<div class="pull-left">
										<a class="btn blue big">
											Les entrées = 
											<?= 
												number_format($caisseEntreesManager->getTotalCaisseEntrees(), 2, ',', ' ')
												 
											?>
										</a>
									</div>
									<br /><br /><br />
									<div class="pull-left">
										<a class="btn yellow big pull-right" href="caisse-entrees.php">
											Détails des entrées 
											<i class="m-icon-big-swapright m-icon-white"></i>									
										</a>
									</div>
								</div>
								<br>
                              </div>
                           </div>
							<!-- END Charges TABLE PORTLET-->
                                 <!-- END FORM--> 
                              </div>
						<div class="tab-pane active" id="tab_1">
							<?php if(isset($_SESSION['sorties-add-success'])){ ?>
                         	<div class="alert alert-success">
								<button class="close" data-dismiss="alert"></button>
								<?= $_SESSION['sorties-add-success'] ?>		
							</div>
	                         <?php } 
	                         	unset($_SESSION['sorties-add-success']);
	                         ?>
	                         <?php if(isset($_SESSION['sorties-add-error'])){ ?>
                         	<div class="alert alert-error">
								<button class="close" data-dismiss="alert"></button>
								<?= $_SESSION['sorties-add-error'] ?>		
							</div>
	                         <?php } 
	                         	unset($_SESSION['sorties-add-error']);
	                         ?>
                           <div class="portlet box grey">
                              <div class="portlet-title">
                                 <h4><i class="icon-signout"></i>Gestion des Sorties de la Caisse</h4>
                                 <div class="tools">
                                    <a href="javascript:;" class="collapse"></a>
                                    <a href="javascript:;" class="remove"></a>
                                 </div>
                              </div>
                              <div class="portlet-body form">
                                 <!-- BEGIN FORM-->
                                 <!-- BEGIN FORM Entrées Mohamed-->
									<form action="controller/CaisseSortiesAddController.php" method="POST" class="horizontal-form">
	                                 <div class="row-fluid">	
	                                 	<div class="span3">
                                          <div class="control-group">
                                             <label class="control-label" for="montant">Montant</label>
                                             <div class="controls">
                                                <input type="text" id="montant" name="montant" class="m-wrap span12" placeholder="">
                                             </div>
                                          </div>
	                                 	</div>
	                                 	<div class="span4">
                                          <div class="control-group">
                                          	<label class="control-label" for="designation">Désignation</label>
                                             <div class="controls">
                                                <input type="text" id="designation" name="designation" class="m-wrap span12" placeholder="">
                                             </div>
                                          </div>
	                                 	</div>
	                                 	<div class="span3">
                                          <div class="control-group">
                                          	<label class="control-label" for="dateOperation">Date opération</label>
                                             <div class="controls">
    											<div class="input-append date date-picker" data-date="" data-date-format="yyyy-mm-dd">
				                                    <input name="dateOperation" id="dateOperation" class="m-wrap m-ctrl-small date-picker" type="text" value="<?= date('Y-m-d') ?>" />
				                                    <span class="add-on"><i class="icon-calendar"></i></span>
				                                </div>
                                             </div>
                                          </div>
                                       </div>
	                                 </div>
	                                 <div class="row-fluid">
	                                 	<div class="span4">
	                                      <div class="control-group">
	                                      	<label class="control-label" for="destination">Pour</label>
	                                         <div class="controls">
	                                         	<select style="width:200px" name="destination" style="width:200px" class="m-wrap">
	                                         		<option value="Bureau">Bureau</option>
	                                         		<?php
	                                         		foreach($projets as $projet){
	                                         		?>
	                                         		<option value="<?= $projet->id() ?>"><?= $projet->nom() ?></option>	
	                                         		<?php	
	                                         		}
	                                         		?>	
	                                         	</select>		
	                                         </div>
	                                      </div>
	                                 	</div>
	                                 	<div class="span3">
	                                          <div class="control-group">
	                                          	 <label>&nbsp;</label>
	                                             <div class="controls">
	                                                <input type="submit" class="m-wrap span12 btn black" value="OK -">
	                                                <input type="hidden" name="utilisateur" value="<?= $_SESSION['userMerlaTrav']->login() ?>">
	                                             </div>
	                                          </div>
	                                 	</div>
	                                 </div>
                                 </form>
                                 <!-- END FORM Entrées Mohamed-->
                                 <hr>
                                 <div class="row-fluid hidden-phone">
	                                 <a class="btn green big">
	                                 	Les sorties = 
	                                 	<?= number_format($caisseSortiesManager->getTotalCaisseSorties(), 2, ',', ' ') ?>
	                                 </a>
	                                 <a class="btn yellow big pull-right" href="caisse-sorties.php">
										Détails des sorties 
										<i class="m-icon-big-swapright m-icon-white"></i>									
									</a>
								</div>
								<div class="row-fluid hidden-desktop">
									<div class="pull-left">
	                                 <a class="btn green big">
	                                 	Les sorties = 
	                                 	<?= number_format($caisseSortiesManager->getTotalCaisseSorties(), 2, ',', ' ') ?>
	                                 </a>
	                                </div>
	                                <br><br><br>
	                                <div class="pull-left">
	                                 <a class="btn yellow big" href="caisse-sorties.php">
										Détails des sorties 
										<i class="m-icon-big-swapright m-icon-white"></i>									
									 </a>
									</div>
								</div>
								<br>
                              </div>
                           </div>
							<!-- END Charges TABLE PORTLET-->
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
		2015 &copy; ImmoERP. Management Application.
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