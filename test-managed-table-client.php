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
        $clientsManager = new ClientManager($pdo);
        $clientNumber = $clientsManager->getClientsNumber();
        if($clientNumber!=0){
            $clients = $clientsManager->getClients();     
        }
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
    <meta charset="utf-8" />
    <title>Metronic | Data Tables - Managed Tables</title>
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
        <div class="navbar-inner">
            <div class="container-fluid">
                <!-- BEGIN LOGO -->
                <a class="brand" href="index.html">
                <img src="assets/img/logo.png" alt="logo" />
                </a>
                <!-- END LOGO -->
                <!-- BEGIN RESPONSIVE MENU TOGGLER -->
                <a href="javascript:;" class="btn-navbar collapsed" data-toggle="collapse" data-target=".nav-collapse">
                <img src="assets/img/menu-toggler.png" alt="" />
                </a>          
                <!-- END RESPONSIVE MENU TOGGLER -->                
                <!-- BEGIN TOP NAVIGATION MENU -->                  
                <ul class="nav pull-right">
                    <!-- BEGIN NOTIFICATION DROPDOWN -->    
                    <li class="dropdown" id="header_notification_bar">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="icon-warning-sign"></i>
                        <span class="badge">6</span>
                        </a>
                        <ul class="dropdown-menu extended notification">
                            <li>
                                <p>You have 14 new notifications</p>
                            </li>
                            <li>
                                <a href="#">
                                <span class="label label-success"><i class="icon-plus"></i></span>
                                New user registered. 
                                <span class="time">Just now</span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                <span class="label label-important"><i class="icon-bolt"></i></span>
                                Server #12 overloaded. 
                                <span class="time">15 mins</span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                <span class="label label-warning"><i class="icon-bell"></i></span>
                                Server #2 not respoding.
                                <span class="time">22 mins</span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                <span class="label label-info"><i class="icon-bullhorn"></i></span>
                                Application error.
                                <span class="time">40 mins</span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                <span class="label label-important"><i class="icon-bolt"></i></span>
                                Database overloaded 68%. 
                                <span class="time">2 hrs</span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                <span class="label label-important"><i class="icon-bolt"></i></span>
                                2 user IP blocked.
                                <span class="time">5 hrs</span>
                                </a>
                            </li>
                            <li class="external">
                                <a href="#">See all notifications <i class="m-icon-swapright"></i></a>
                            </li>
                        </ul>
                    </li>
                    <!-- END NOTIFICATION DROPDOWN -->
                    <!-- BEGIN INBOX DROPDOWN -->
                    <li class="dropdown" id="header_inbox_bar">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="icon-envelope-alt"></i>
                        <span class="badge">5</span>
                        </a>
                        <ul class="dropdown-menu extended inbox">
                            <li>
                                <p>You have 12 new messages</p>
                            </li>
                            <li>
                                <a href="#">
                                <span class="photo"><img src="./assets/img/avatar2.jpg" alt="" /></span>
                                <span class="subject">
                                <span class="from">Lisa Wong</span>
                                <span class="time">Just Now</span>
                                </span>
                                <span class="message">
                                Vivamus sed auctor nibh congue nibh. auctor nibh
                                auctor nibh...
                                </span>  
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                <span class="photo"><img src="./assets/img/avatar3.jpg" alt="" /></span>
                                <span class="subject">
                                <span class="from">Richard Doe</span>
                                <span class="time">16 mins</span>
                                </span>
                                <span class="message">
                                Vivamus sed congue nibh auctor nibh congue nibh. auctor nibh
                                auctor nibh...
                                </span>  
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                <span class="photo"><img src="./assets/img/avatar1.jpg" alt="" /></span>
                                <span class="subject">
                                <span class="from">Bob Nilson</span>
                                <span class="time">2 hrs</span>
                                </span>
                                <span class="message">
                                Vivamus sed nibh auctor nibh congue nibh. auctor nibh
                                auctor nibh...
                                </span>  
                                </a>
                            </li>
                            <li class="external">
                                <a href="#">See all messages <i class="m-icon-swapright"></i></a>
                            </li>
                        </ul>
                    </li>
                    <!-- END INBOX DROPDOWN -->
                    <!-- BEGIN TODO DROPDOWN -->
                    <li class="dropdown" id="header_task_bar">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="icon-tasks"></i>
                        <span class="badge">5</span>
                        </a>
                        <ul class="dropdown-menu extended tasks">
                            <li>
                                <p>You have 12 pending tasks</p>
                            </li>
                            <li>
                                <a href="#">
                                <span class="task">
                                <span class="desc">New release v1.2</span>
                                <span class="percent">30%</span>
                                </span>
                                <span class="progress progress-success ">
                                <span style="width: 30%;" class="bar"></span>
                                </span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                <span class="task">
                                <span class="desc">Application deployment</span>
                                <span class="percent">65%</span>
                                </span>
                                <span class="progress progress-danger progress-striped active">
                                <span style="width: 65%;" class="bar"></span>
                                </span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                <span class="task">
                                <span class="desc">Mobile app release</span>
                                <span class="percent">98%</span>
                                </span>
                                <span class="progress progress-success">
                                <span style="width: 98%;" class="bar"></span>
                                </span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                <span class="task">
                                <span class="desc">Database migration</span>
                                <span class="percent">10%</span>
                                </span>
                                <span class="progress progress-warning progress-striped">
                                <span style="width: 10%;" class="bar"></span>
                                </span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                <span class="task">
                                <span class="desc">Web server upgrade</span>
                                <span class="percent">58%</span>
                                </span>
                                <span class="progress progress-info">
                                <span style="width: 58%;" class="bar"></span>
                                </span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                <span class="task">
                                <span class="desc">Mobile development</span>
                                <span class="percent">85%</span>
                                </span>
                                <span class="progress progress-success">
                                <span style="width: 85%;" class="bar"></span>
                                </span>
                                </a>
                            </li>
                            <li class="external">
                                <a href="#">See all tasks <i class="m-icon-swapright"></i></a>
                            </li>
                        </ul>
                    </li>
                    <!-- END TODO DROPDOWN -->
                    <!-- BEGIN USER LOGIN DROPDOWN -->
                    <li class="dropdown user">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img alt="" src="assets/img/avatar1_small.jpg" />
                        <span class="username">Bob Nilson</span>
                        <i class="icon-angle-down"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="extra_profile.html"><i class="icon-user"></i> My Profile</a></li>
                            <li><a href="calendar.html"><i class="icon-calendar"></i> My Calendar</a></li>
                            <li><a href="#"><i class="icon-tasks"></i> My Tasks</a></li>
                            <li class="divider"></li>
                            <li><a href="login.html"><i class="icon-key"></i> Log Out</a></li>
                        </ul>
                    </li>
                    <!-- END USER LOGIN DROPDOWN -->
                </ul>
                <!-- END TOP NAVIGATION MENU -->    
            </div>
        </div>
        <!-- END TOP NAVIGATION BAR -->
    </div>
    <!-- END HEADER -->
    <!-- BEGIN CONTAINER -->
    <div class="page-container row-fluid">
        <!-- BEGIN SIDEBAR -->
        <div class="page-sidebar nav-collapse collapse">
            <!-- BEGIN SIDEBAR MENU -->         
            <ul>
                <li>
                    <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
                    <div class="sidebar-toggler hidden-phone"></div>
                    <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
                </li>
                <li>
                    <!-- BEGIN RESPONSIVE QUICK SEARCH FORM -->
                    <form class="sidebar-search">
                        <div class="input-box">
                            <a href="javascript:;" class="remove"></a>
                            <input type="text" placeholder="Search..." />               
                            <input type="button" class="submit" value=" " />
                        </div>
                    </form>
                    <!-- END RESPONSIVE QUICK SEARCH FORM -->
                </li>
                <li class="start ">
                    <a href="index.html">
                    <i class="icon-home"></i> 
                    <span class="title">Dashboard</span>
                    </a>
                </li>
                <li class="has-sub ">
                    <a href="javascript:;">
                    <i class="icon-bookmark-empty"></i> 
                    <span class="title">UI Features</span>
                    <span class="arrow "></span>
                    </a>
                    <ul class="sub">
                        <li ><a href="ui_general.html">General</a></li>
                        <li ><a href="ui_buttons.html">Buttons</a></li>
                        <li ><a href="ui_tabs_accordions.html">Tabs & Accordions</a></li>
                        <li ><a href="ui_sliders.html">Sliders</a></li>
                        <li ><a href="ui_tiles.html">Tiles</a></li>
                        <li ><a href="ui_typography.html">Typography</a></li>
                        <li ><a href="ui_tree.html">Tree View</a></li>
                        <li ><a href="ui_nestable.html">Nestable List</a></li>
                    </ul>
                </li>
                <li class="has-sub ">
                    <a href="javascript:;">
                    <i class="icon-table"></i> 
                    <span class="title">Form Stuff</span>
                    <span class="arrow "></span>
                    </a>
                    <ul class="sub">
                        <li ><a href="form_layout.html">Form Layouts</a></li>
                        <li ><a href="form_samples.html">Advance Form Samples</a></li>
                        <li ><a href="form_component.html">Form Components</a></li>
                        <li ><a href="form_wizard.html">Form Wizard</a></li>
                        <li ><a href="form_validation.html">Form Validation</a></li>
                        <li ><a href="form_fileupload.html">Multiple File Upload</a></li>
                        <li ><a href="form_dropzone.html">Dropzone File Upload</a></li>
                    </ul>
                </li>
                <li class="active has-sub ">
                    <a href="javascript:;">
                    <i class="icon-th-list"></i> 
                    <span class="title">Data Tables</span>
                    <span class="selected"></span>
                    <span class="arrow open"></span>
                    </a>
                    <ul class="sub">
                        <li ><a href="table_basic.html">Basic Tables</a></li>
                        <li class="active"><a href="table_managed.html">Managed Tables</a></li>
                        <li ><a href="table_editable.html">Editable Tables</a></li>
                    </ul>
                </li>
                <li class="has-sub ">
                    <a href="javascript:;">
                    <i class="icon-th-list"></i> 
                    <span class="title">Portlets</span>
                    <span class="arrow "></span>
                    </a>
                    <ul class="sub">
                        <li ><a href="portlet_general.html">General Portlets</a></li>
                        <li ><a href="portlet_draggable.html">Draggable Portlets</a></li>
                    </ul>
                </li>
                <li class="has-sub ">
                    <a href="javascript:;">
                    <i class="icon-map-marker"></i> 
                    <span class="title">Maps</span>
                    <span class="arrow "></span>
                    </a>
                    <ul class="sub">
                        <li ><a href="maps_google.html">Google Maps</a></li>
                        <li ><a href="maps_vector.html">Vector Maps</a></li>
                    </ul>
                </li>
                <li class="">
                    <a href="charts.html">
                    <i class="icon-bar-chart"></i> 
                    <span class="title">Visual Charts</span>
                    </a>
                </li>
                <li class="">
                    <a href="calendar.html">
                    <i class="icon-calendar"></i> 
                    <span class="title">Calendar</span>
                    </a>
                </li>
                <li class="">
                    <a href="gallery.html">
                    <i class="icon-camera"></i> 
                    <span class="title">Gallery</span>
                    </a>
                </li>
                <li class="has-sub ">
                    <a href="javascript:;">
                    <i class="icon-briefcase"></i> 
                    <span class="title">Extra</span>
                    <span class="arrow "></span>
                    </a>
                    <ul class="sub">
                        <li ><a href="extra_profile.html">User Profile</a></li>
                        <li ><a href="extra_faq.html">FAQ</a></li>
                        <li ><a href="extra_search.html">Search Results</a></li>
                        <li ><a href="extra_invoice.html">Invoice</a></li>
                        <li ><a href="extra_pricing_table.html">Pricing Tables</a></li>
                        <li ><a href="extra_404.html">404 Page</a></li>
                        <li ><a href="extra_500.html">500 Page</a></li>
                        <li ><a href="extra_blank.html">Blank Page</a></li>
                        <li ><a href="extra_full_width.html">Full Width Page</a></li>
                    </ul>
                </li>
                <li class="">
                    <a href="login.html">
                    <i class="icon-user"></i> 
                    <span class="title">Login Page</span>
                    </a>
                </li>
            </ul>
            <!-- END SIDEBAR MENU -->
        </div>
        <!-- END SIDEBAR -->
        <!-- BEGIN PAGE -->
        <div class="page-content">
            <!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
            <div id="portlet-config" class="modal hide">
                <div class="modal-header">
                    <button data-dismiss="modal" class="close" type="button"></button>
                    <h3>portlet Settings</h3>
                </div>
                <div class="modal-body">
                    <p>Here will be a configuration form</p>
                </div>
            </div>
            <!-- END SAMPLE PORTLET CONFIGURATION MODAL FORM-->
            <!-- BEGIN PAGE CONTAINER-->            
            <div class="container-fluid">
                <!-- BEGIN PAGE HEADER-->
                <div class="row-fluid">
                    <div class="span12">
                        <!-- BEGIN STYLE CUSTOMIZER -->
                        <div class="color-panel hidden-phone">
                            <div class="color-mode-icons icon-color"></div>
                            <div class="color-mode-icons icon-color-close"></div>
                            <div class="color-mode">
                                <p>THEME COLOR</p>
                                <ul class="inline">
                                    <li class="color-black current color-default" data-style="default"></li>
                                    <li class="color-blue" data-style="blue"></li>
                                    <li class="color-brown" data-style="brown"></li>
                                    <li class="color-purple" data-style="purple"></li>
                                    <li class="color-white color-light" data-style="light"></li>
                                </ul>
                                <label class="hidden-phone">
                                <input type="checkbox" class="header" checked value="" />
                                <span class="color-mode-label">Fixed Header</span>
                                </label>                            
                            </div>
                        </div>
                        <!-- END BEGIN STYLE CUSTOMIZER -->  
                        <!-- BEGIN PAGE TITLE & BREADCRUMB-->           
                        <h3 class="page-title">
                            Managed Tables              <small>managed table samples</small>
                        </h3>
                        <ul class="breadcrumb">
                            <li>
                                <i class="icon-home"></i>
                                <a href="index.html">Home</a> 
                                <i class="icon-angle-right"></i>
                            </li>
                            <li>
                                <a href="#">Data Tables</a>
                                <i class="icon-angle-right"></i>
                            </li>
                            <li><a href="#">Managed Tables</a></li>
                        </ul>
                        <!-- END PAGE TITLE & BREADCRUMB-->
                    </div>
                </div>
                <!-- END PAGE HEADER-->
                <!-- BEGIN PAGE CONTENT-->
                <div class="row-fluid">
                    <div class="span12">
                        <!-- BEGIN EXAMPLE TABLE PORTLET-->
                        <div class="portlet box light-grey">
                            <div class="portlet-title">
                                <h4><i class="icon-globe"></i>Liste des clients</h4>
                                <div class="tools">
                                    <a href="javascript:;" class="reload"></a>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <!--div class="clearfix">
                                    <div class="btn-group pull-right">
                                        <button class="btn dropdown-toggle" data-toggle="dropdown">Outils <i class="icon-angle-down"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a href="#">Print</a></li>
                                            <li><a href="#">Save as PDF</a></li>
                                            <li><a href="#">Export to Excel</a></li>
                                        </ul>
                                    </div>
                                </div-->
                                <table class="table table-striped table-bordered table-hover" id="sample_1">
                                    <thead>
                                        <tr>
                                            <th style="width:8px;"><input type="checkbox" class="group-checkable" data-set="#sample_1 .checkboxes" /></th>
                                            <th>Nom</th>
                                            <th class="hidden-480">CIN</th>
                                            <th class="hidden-480">الاسم</th>
                                            <th class="hidden-480">العنوان</th>
                                            <th class="hidden-480">Adresse</th>
                                            <th class="hidden-480">Tel1</th>
                                            <th class="hidden-480">Email</th>
                                            <th ></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach($clients as $client){
                                        ?>
                                        <tr class="odd gradeX">
                                            <td><input type="checkbox" class="checkboxes" value="1" /></td>
                                            <td><?= $client->nom() ?></td>
                                            <td class="hidden-480"><?= $client->cin() ?></td>
                                            <td class="hidden-480"><?= $client->nomArabe() ?></td>
                                            <td class="hidden-480"><?= $client->adresseArabe() ?></td>
                                            <td class="hidden-480"><?= $client->adresse() ?></td>
                                            <td class="hidden-480"><?= $client->telephone1() ?></td>
                                            <td class="hidden-480"><a href="mailto:<?= $client->email() ?>"><?= $client->email() ?></a></td>
                                            <td ><a href="#update<?= $client->id() ?>" data-toggle="modal" data-id="<?= $client->id() ?>" class="btn mini green"><i class="icon-refresh"></i></a></td>
                                        </tr>
                                        <!-- updateClient box begin-->
                                        <div id="update<?= $client->id() ?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                <h3>Modifier les informations du client </h3>
                                            </div>
                                            <div class="modal-body">
                                                <form class="form-horizontal" action="controller/ClientActionController.php" method="post">
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
                                                        <label class="control-label">الاسم</label>
                                                        <div class="controls">
                                                            <input type="text" name="nomArabe" value="<?= $client->nomArabe() ?>" />
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label class="control-label">العنوان</label>
                                                        <div class="controls">
                                                            <input type="text" name="adresseArabe" value="<?= $client->adresseArabe() ?>" />
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label class="control-label">Adresse</label>
                                                        <div class="controls">
                                                            <input type="text" name="adresse" value="<?= $client->adresse() ?>" />
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label class="control-label">Tél.1</label>
                                                        <div class="controls">
                                                            <input type="text" name="telephone1" value="<?= $client->telephone1() ?>" />
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label class="control-label">Tél.2</label>
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
                                                        <input type="hidden" name="action" value="update" />
                                                        <input type="hidden" name="source" value="clients" />
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
                                        <div id="delete<?= $client->id();?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                <h3>Supprimer Client</h3>
                                            </div>
                                            <div class="modal-body">
                                                <form class="form-horizontal loginFrm" action="controller/ClientActionController.php" method="post">
                                                    <p>Êtes-vous sûr de vouloir supprimer ce client <?= $client->nom() ?> ?</p>
                                                    <div class="control-group">
                                                        <label class="right-label"></label>
                                                        <input type="hidden" name="idClient" value="<?= $client->id() ?>" />
                                                        <input type="hidden" name="action" value="delete" />
                                                        <input type="hidden" name="source" value="clients" />
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
                            </div>
                        </div>
                        <!-- END EXAMPLE TABLE PORTLET-->
                    </div>
                </div>
                <!-- END PAGE CONTENT-->
            </div>
            <!-- END PAGE CONTAINER-->
        </div>
        <!-- END PAGE -->
    </div>
    <!-- END CONTAINER -->
    <!-- BEGIN FOOTER -->
    <div class="footer">
        2015 &copy; ImmoERP.
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
</body>
<!-- END BODY -->
</html>
<?php
}
else{
    header("Location:index.php");
}
?>