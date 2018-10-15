<?php
    include('../autoload.php');
    session_start();
    if(isset($_SESSION['userMerlaTrav']) and $_SESSION['userMerlaTrav']->profil()=="admin"){
    	//les sources
    	$usersManager = new UserManager($pdo);
		$users = $usersManager->getUsers(); 
        
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
	<link rel="stylesheet" type="text/css" href="../assets/bootstrap-datepicker/css/datepicker.css" />
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
							Gestion des projets
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
							<li><a>Nouveau projet</a></li>
						</ul>
						<!-- END PAGE TITLE & BREADCRUMB-->
					</div>
				</div>
				<!-- END PAGE HEADER-->
				<!-- BEGIN PAGE CONTENT-->
				<div class="row-fluid">
					<div class="span12">
                         <?php
                        if(isset($_SESSION['projet-action-message']) and isset($_SESSION['projet-type-message'])){
                            $message = $_SESSION['projet-action-message'];
                            $typeMessage = $_SESSION['projet-type-message'];
                        ?>
                            <div class="alert alert-<?= $typeMessage ?>">
                                <button class="close" data-dismiss="alert"></button>
                                <?= $message ?>     
                            </div>
                         <?php 
                         } 
                         unset($_SESSION['projet-action-message']);
                         unset($_SESSION['projet-type-message']);
                         ?>
						<div class="tab-pane active" id="tab_1">
                           <div class="portlet box grey">
                              <div class="portlet-title">
                                 <h4><i class="icon-edit"></i>Ajouter un nouveau projet</h4>
                                 <div class="tools">
                                    <a href="javascript:;" class="collapse"></a>
                                    <a href="javascript:;" class="remove"></a>
                                 </div>
                              </div>
                              <div class="portlet-body form">
                                 <!-- BEGIN FORM-->
                                 <form id="addProjetForm" action="../controller/ProjetActionController.php" method="POST" class="horizontal-form">
                                    <div class="row-fluid">
                                        <div class="span3">
                                           <div class="control-group">
                                               <label class="control-label" for="nomArabe">اسم المشروع <sup class="dangerous-action">*</sup></label>
                                               <div class="controls">
                                                   <input type="text" id="nomArabe" name="nomArabe" class="m-wrap span12" />
                                               </div>
                                           </div>
                                       </div>
                                       <div class="span3">
                                           <div class="control-group">
                                               <label class="control-label" for="adresseArabe">عنوان المشروع <sup class="dangerous-action">*</sup></label>
                                               <div class="controls">
                                                   <input type="text" id="adresseArabe" name="adresseArabe" class="m-wrap span12" />
                                               </div>
                                           </div>
                                       </div>
                                       <div class="span3">
                                           <div class="control-group">
                                               <label class="control-label">Nom <sup class="dangerous-action">*</sup></label>
                                               <div class="controls">
                                                   <input type="text" name="nom" class="m-wrap span12" />
                                               </div>
                                           </div>
                                       </div>
                                       <div class="span3">
                                           <div class="control-group">
                                               <label class="control-label">Titre</label>
                                               <div class="controls">
                                                   <input type="text" name="titre" class="m-wrap span12" />
                                               </div>
                                           </div>
                                       </div>
                                    </div>
                                    <div class="row-fluid">
                                       <div class="span3">
                                          <div class="control-group">
                                             <label class="control-label" for="superficie">Superficie</label>
                                             <div class="controls">
                                                <input type="text" id="superficie" name="superficie" class="m-wrap span12">
                                             </div>
                                          </div>
                                       </div>
                                       <div class="span3">
                                          <div class="control-group">
                                             <label class="control-label" for="budget">Budget</label>
                                             <div class="controls">
                                                <input type="text" id="budget" name="budget" class="m-wrap span12">
                                             </div>
                                          </div>
                                       </div>
                                       <div class="span3">
                                           <div class="control-group">
                                               <label class="control-label" for="numeroLot">Numero Lot</label>
                                               <div class="controls">
                                                   <input type="text" id="numeroLot" name="numeroLot" class="m-wrap span12" />
                                               </div>
                                           </div>
                                       </div>
                                       <div class="span3">
                                           <div class="control-group">
                                               <label class="control-label" for="numeroAutorisation">Numero Autorisation</label>
                                               <div class="controls">
                                                   <input type="text" id="numeroAutorisation" name="numeroAutorisation" class="m-wrap span12" />
                                               </div>
                                           </div>
                                       </div>
                                    </div>
                                    <div class="row-fluid">
                                       <div class="span3">
                                          <div class="control-group">
                                             <label class="control-label" for="dateAutorisation">Date d'Autorisation</label>
                                             <div class="controls">
                                                <div class="input-append date date-picker" data-date="" data-date-format="yyyy-mm-dd">
                                                    <input name="dateAutorisation" id="dateAutorisation" class="m-wrap m-ctrl-small date-picker" type="text" value="<?= date('Y-m-d') ?>" />
                                                    <span class="add-on"><i class="icon-calendar"></i></span>
                                                 </div>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="span3">
                                          <div class="control-group">
                                               <label class="control-label" for="nombreEtages">Nombre Etages</label>
                                               <div class="controls">
                                                   <input type="text" id="nombreEtages" name="nombreEtages" class="m-wrap span12" />
                                               </div>
                                           </div>
                                       </div>
                                       <div class="span3">
                                          <div class="control-group">
                                               <label class="control-label" for="sousSol">Surface Sous-Sol</label>
                                               <div class="controls">
                                                   <input type="text" id="sousSol" name="sousSol" class="m-wrap span12" />
                                               </div>
                                           </div>
                                       </div>
                                       <div class="span3">
                                          <div class="control-group">
                                               <label class="control-label" for="rezDeChausser">Surface Rez De Chausser</label>
                                               <div class="controls">
                                                   <input type="text" id="rezDeChausser" name="rezDeChausser" class="m-wrap span12" />
                                               </div>
                                           </div>
                                       </div>
                                    </div>
                                    <div class="row-fluid">
                                       <div class="span3">
                                          <div class="control-group">
                                               <label class="control-label" for="mezzanin">Surface Mezzanin</label>
                                               <div class="controls">
                                                   <input type="text" id="mezzanin" name="mezzanin" class="m-wrap span12" />
                                               </div>
                                           </div>
                                       </div>
                                       <div class="span3">
                                           <div class="control-group">
                                               <label class="control-label" for="cageEscalier">Surface Cage Escaliers</label>
                                               <div class="controls">
                                                   <input type="text" id="cageEscalier" name="cageEscalier" class="m-wrap span12" />
                                               </div>
                                           </div>
                                       </div>
                                       <div class="span3">
                                           <div class="control-group">
                                               <label class="control-label" for="terrase">Surface Terrasse</label>
                                               <div class="controls">
                                                   <input type="text" id="terrase" name="terrase" class="m-wrap span12" />
                                               </div>
                                           </div>
                                       </div>
                                       <div class="span3">
                                          <div class="control-group">
                                               <label class="control-label" for="superficieEtages">Surface 1er-Nème Etage</label>
                                               <div class="controls">
                                                   <input type="text" id="superficieEtages" name="superficieEtages" class="m-wrap span12" />
                                               </div>
                                           </div>
                                       </div>
                                    </div>
                                    <div class="row-fluid">
                                       <div class="span3">
                                          <div class="control-group">
                                               <label class="control-label" for="delai">Delai/Mois</label>
                                               <div class="controls">
                                                   <input type="text" id="delai" name="delai" class="m-wrap span12" />
                                               </div>
                                           </div>
                                       </div>
                                       <div class="span3">
                                          <div class="control-group">
                                               <label class="control-label" for="prixParMetreHT">Prix/m² HT</label>
                                               <div class="controls">
                                                   <input type="text" id="prixParMetreHT" name="prixParMetreHT" class="m-wrap span12" />
                                               </div>
                                           </div>
                                       </div>
                                       <div class="span3">
                                          <div class="control-group">
                                               <label class="control-label" for="TVA">TVA</label>
                                               <div class="controls">
                                                   <input type="text" id="TVA" name="TVA" class="m-wrap span12" />
                                               </div>
                                           </div>
                                       </div>
                                       <div class="span3">
                                          <div class="control-group">
                                               <label class="control-label" for="prixParMetreTTC">Prix/m² TTC</label>
                                               <div class="controls">
                                                   <input type="text" id="prixParMetreTTC" name="prixParMetreTTC" class="m-wrap span12" />
                                               </div>
                                           </div>
                                       </div>
                                    </div>
                                    <div class="row-fluid">
                                       <div class="span3">
                                          <div class="control-group">
                                             <label class="control-label" for="adresse">Adresse <sup class="dangerous-action">*</sup></label>
                                             <div class="controls">
                                             	<textarea style="width:270px;" name="adresse" class="m-wrap span12" rows="3"></textarea>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="span3">
                                          <div class="control-group">
                                             <label class="control-label" for="description">Description</label>
                                             <div class="controls">
    											<textarea style="width:270px;" name="description" class="m-wrap span12" rows="3"></textarea>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="span3">
                                          <div class="control-group">
                                             <label class="control-label" for="architecte">Architecte</label>
                                             <div class="controls">
                                                <textarea style="width:270px;" id="architecte" name="architecte" class="m-wrap span12" rows="3"></textarea>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="span3">
                                          <div class="control-group">
                                             <label class="control-label" for="bet">Bet</label>
                                             <div class="controls">
                                                <textarea style="width:270px;" id="bet" name="bet" class="m-wrap span12" rows="3"></textarea>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="form-actions">
                                        <input type="hidden" name="action" value="add" />  
                                        <p class="dangerous-action">* : Champs obligatoires</p>
                                    	<a href="projets.php" class="btn red"><i class="m-icon-swapleft m-icon-white"></i>&nbsp;Retour</a>
                                       	<button type="submit" class="btn black">Ajouter <i class="icon-plus-sign"></i></button>
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
	<script src="../assets/js/jquery-1.8.3.min.js"></script>
	<script src="../assets/breakpoints/breakpoints.js"></script>
	<script src="../assets/bootstrap/js/bootstrap.min.js"></script>
	<script src="../assets/js/jquery.blockui.js"></script>
	<script src="../assets/js/jquery.cookie.js"></script>
	<script src="../assets/fullcalendar/fullcalendar/fullcalendar.min.js"></script>
    <script type="text/javascript" src="../assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
    <script type="text/javascript" src="../assets/bootstrap-daterangepicker/date.js"></script>
	<!-- ie8 fixes -->
	<!--[if lt IE 9]>
    <script src="../assets/js/excanvas.js"></script>
    <script src="../assets/js/respond.js"></script>
    <![endif]-->
	<script type="text/javascript" src="../assets/uniform/jquery.uniform.min.js"></script>
	<script type="text/javascript" src="../assets/data-tables/jquery.dataTables.js"></script>
	<script type="text/javascript" src="../assets/data-tables/DT_bootstrap.js"></script>
	<script src="../assets/jquery-validation/jquery.validate.js" type="text/javascript"></script>
	<script src="../assets/js/app.js"></script>
	<script>
		jQuery(document).ready(function() {			
			// initiate layout and plugins
			//App.setPage("table_editable");
			App.init();
			$('#prixParMetreHT, #TVA').change(function(){
                var prixParMetreHT = +$('#prixParMetreHT').val();
                var TVA = +$('#TVA').val();
                var prixParMetreTTC = prixParMetreHT + TVA;
                $('#prixParMetreTTC').val(prixParMetreTTC);
            });
            //validate form begins
            $("#addProjetForm").validate({
                 rules:{
                   nom: {
                       required: true
                   },
                   nomArabe: {
                       required: true
                   },
                   adresse: {
                       required: true
                   },
                   adresseArabe: {
                       required: true
                   },
                   superficie: {
                       number: true
                   },
                   budget: {
                       number: true
                   },
                   nombreEtages: {
                       number: true
                   },
                   sousSol: {
                       number: true
                   },
                   rezDeChausser: {
                       number: true
                   },
                   mezzanin: {
                       number: true
                   },
                   cageEscalier: {
                       number: true
                   },
                   terrase: {
                       number: true
                   },
                   budget: {
                       number: true
                   },
                   superficieEtages: {
                       number: true
                   },
                   delai: {
                       number: true
                   },
                   prixParMetreHT: {
                       number: true
                   },
                   prixParMetreTTC: {
                       number: true
                   },
                   TVA: {
                       number: true
                   }
                 },
                 errorClass: "error-class",
                 validClass: "valid-class"
            });
            //validate form ends
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