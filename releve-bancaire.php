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
    if(isset($_SESSION['userMerlaTrav'])){
        //classes managers
        $releveBancaireManager = new ReleveBancaireManager($pdo);
        $releveBancaires = $releveBancaireManager->getReleveBancaires();
        $debit = $releveBancaireManager->getTotalDebit();
        $credit = $releveBancaireManager->getTotalCredit();
        $solde = $credit - $debit;
        
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
    <meta charset="UTF-8" />
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
        <?php 
        include("include/top-menu.php"); 
        $alerts = $alertManager->getAlerts();
        ?>   
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
                            Gestion des Relevés Bancaires 
                        </h3>
                        <ul class="breadcrumb">
                            <li>
                                <i class="icon-dashboard"></i>
                                <a href="dashboard.php">Accueil</a> 
                                <i class="icon-angle-right"></i>
                            </li>
                            <li>
                                <i class="icon-envelope"></i>
                                <a>Gestion des Relevés Bancaires</a>
                            </li>
                        </ul>
                        <!-- END PAGE TITLE & BREADCRUMB-->
                    </div>
                </div>
                <!-- END PAGE HEADER-->
                <!-- BEGIN PAGE CONTENT-->
                <!-- BEGIN PORTLET-->
                <div class="row-fluid">
                    <div class="span12">
                        <?php
                         if( isset($_SESSION['releveBancaire-action-message'])
                         and isset($_SESSION['releveBancaire-type-message']) ){ 
                            $message = $_SESSION['releveBancaire-action-message'];
                            $typeMessage = $_SESSION['releveBancaire-type-message'];    
                         ?>
                            <div class="alert alert-<?= $typeMessage ?>">
                                <button class="close" data-dismiss="alert"></button>
                                <?= $message ?>     
                            </div>
                         <?php } 
                            unset($_SESSION['releveBancaire-action-message']);
                            unset($_SESSION['releveBancaire-type-message']);
                         ?>
                        <div class="portlet">
                            <div class="portlet-title line">
                                <h4><i class="icon-envelope"></i>Ajouter un relevé bancaire</h4>
                                <!--div class="tools">
                                    <a href="javascript:;" class="collapse"></a>
                                    <a href="javascript:;" class="remove"></a>
                                </div-->
                            </div>
                            <div class="portlet-body" id="chats">
                                    <form action="controller/ReleveBancaireActionController.php" method="POST" enctype="multipart/form-data">
                                        <div class="control-group">   
                                            <input class="m-wrap" type="file" name="excelupload" />
                                        </div>
                                        <div class="btn-cont"> 
                                            <input type="hidden" name="action" value="add" />
                                            <button type="submit" class="btn blue icn-only"><i class="icon-save icon-white"></i>&nbsp;Enregistrer</button>
                                        </div>
                                    </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="span12">
                        <!-- BEGIN RELEVE PORTLET-->               
                        <div class="portlet box light-grey">
                            <div class="portlet-title">
                                <h4>Les Relevés Bancaires</h4>
                                <div class="tools">
                                    <a href="javascript:;" class="reload"></a>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <div class="clearfix">
                                    <!--div class="btn-group pull-right">
                                        <button class="btn dropdown-toggle" data-toggle="dropdown">Outils <i class="icon-angle-down"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a href="#">Print</a></li>
                                            <li><a href="#">Save as PDF</a></li>
                                            <li><a href="#">Export to Excel</a></li>
                                        </ul>
                                    </div-->
                                </div>
                                <table class="table table-striped table-bordered table-hover" id="sample_1">
                                    <thead>
                                        <tr>
                                            <th style="width:10%;">Actions</th>
                                            <th style="width:10%;">DateOpe</th>
                                            <th style="width:10%;">DateVal</th>
                                            <th style="width:20%;">Libelle</th>
                                            <th style="width:10%;">Reference</th>
                                            <th style="width:15%;">Débit</th>
                                            <th style="width:15%;">Crédit</th>
                                            <th style="width:10%;">Projet</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach($releveBancaires as $releve){
                                        ?>
                                        <tr class="odd gradeX">
                                            <td>
                                                <?php
                                                if ( $_SESSION['userMerlaTrav']->profil() == "admin" ) {
                                                ?>
                                                    <a href="#update<?= $releve->id() ?>" data-toggle="modal" data-id="<?= $releve->id() ?>" class="btn mini green"><i class="icon-refresh"></i></a>
                                                    <a href="#delete<?= $releve->id() ?>" data-toggle="modal" data-id="<?= $releve->id() ?>" class="btn mini red"><i class="icon-remove"></i></a>
                                                <?php  
                                                }
                                                ?>
                                            </td>    
                                            <!--td><?php //date('d/m/Y', strtotime($releve->dateOpe())) ?></td-->
                                            <!--td><?php //date('d/m/Y', strtotime($releve->dateVal())) ?></td-->
                                            <td><?= $releve->dateOpe() ?></td>
                                            <td><?= $releve->dateVal() ?></td>
                                            <td><?= $releve->libelle() ?></td>
                                            <td><?= $releve->reference() ?></td>
                                            <td><?= number_format($releve->debit(), 2, ',', ' ' ) ?></td>
                                            <td><?= number_format($releve->credit(), 2, ',', ' ') ?></td>
                                            <td><?= $releve->projet() ?></td>
                                        </tr>
                                        <!-- updateClient box begin-->
                                        <div id="update<?= $releve->id() ?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                <h3>Modifier les informations du relevé </h3>
                                            </div>
                                            <div class="modal-body">
                                                <form class="form-horizontal" action="controller/ReleveBancaireActionController.php" method="post">
                                                    <div class="control-group">
                                                        <label class="control-label">DateOpe</label>
                                                        <div class="controls date date-picker" data-date="" data-date-format="yyyy-mm-dd">
                                                            <input name="dateOpe" id="dateOpe" class="m-wrap m-ctrl-small date-picker" type="text" value="<?= $releve->dateOpe() ?>" />
                                                            <span class="add-on"><i class="icon-calendar"></i></span>
                                                         </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label class="control-label">DateVal</label>
                                                        <div class="controls date date-picker" data-date="" data-date-format="yyyy-mm-dd">
                                                            <input name="dateVal" id="dateVal" class="m-wrap m-ctrl-small date-picker" type="text" value="<?= $releve->dateVal() ?>" />
                                                            <span class="add-on"><i class="icon-calendar"></i></span>
                                                         </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label class="control-label">Libelle</label>
                                                        <div class="controls">
                                                            <input type="text" name="libelle" value="<?= $releve->libelle() ?>" />
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label class="control-label">Reference</label>
                                                        <div class="controls">
                                                            <input type="text" name="reference" value="<?= $releve->reference() ?>" />
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label class="control-label">Débit</label>
                                                        <div class="controls">
                                                            <input type="text" name="debit" value="<?= $releve->debit() ?>" />
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label class="control-label">Crédit</label>
                                                        <div class="controls">
                                                            <input type="text" name="credit" value="<?= $releve->credit() ?>" />
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label class="control-label">Projet</label>
                                                        <div class="controls">
                                                            <input type="text" name="projet" value="<?= $releve->projet() ?>" />
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <input type="hidden" name="idReleveBancaire" value="<?= $releve->id() ?>" />
                                                        <input type="hidden" name="action" value="update" />
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
                                        <div id="delete<?= $releve->id();?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                <h3>Supprimer Relevé</h3>
                                            </div>
                                            <div class="modal-body">
                                                <form class="form-horizontal loginFrm" action="controller/ReleveBancaireActionController.php" method="post">
                                                    <div class="control-group">
                                                        <label class="right-label"></label>
                                                        <input type="hidden" name="idReleveBancaire" value="<?= $releve->id() ?>" />
                                                        <input type="hidden" name="action" value="delete" />
                                                        <button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
                                                        <button type="submit" class="btn red" aria-hidden="true">Oui</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <!-- delete box end -->     
                                        <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                                <table class="table table-striped table-bordered table-advance table-hover">
                                    <tbody>
                                        <tr>
                                            <th style="width:60%;">Total Débit</th>
                                            <th style="width:20%"><a><?= number_format($debit, '2', ',', ' ') ?></a>&nbsp;DH</th>
                                            <th style="width:20%;"></th>
                                        </tr>
                                        <tr>
                                            <th style="width:60%;">Total Crédit</th>
                                            <th style="width:20%;"></th>
                                            <th style="width:20%"><a><?= number_format($credit, '2', ',', ' ') ?></a>&nbsp;DH</th>
                                        </tr>
                                        <tr>
                                            <th style="width:60%;">Solde</th>
                                            <th style="width:20%"><a><?= number_format($solde, '2', ',', ' ') ?></a>&nbsp;DH</th>
                                            <th style="width:20%;"></th>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>             
                        <!-- END RELEVE PORTLET-->
                    </div>
                </div>
                <!-- END PORTLET-->
                <!-- END PAGE CONTENT-->
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
            App.setPage("table_managed");
            App.init();
        });
    </script>
    <!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>
<?php
}
else{
    header('Location:index.php');    
}
?>