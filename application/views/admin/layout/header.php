
<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="description" content="">
<meta name="author" content="">

<title><?= $this->lang->line('Admin - Dashboard')?></title>

<!-- Custom fonts for this template-->
<link href="<?=base_url('assets/comp_assets/')?>vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

<link href="<?=base_url('assets/comp_assets/')?>vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
<!-- Custom styles for this template-->
<link href="<?=base_url('assets/comp_assets/')?>css/sb-admin-2.min.css" rel="stylesheet">
<!-- switchery -->
<link href="<?=base_url('assets/additional_assets/')?>template/libs/switchery/switchery.min.css" rel="stylesheet" type="text/css" />
<link href="<?=base_url('assets/additional_assets/')?>template/libs/multiselect/multi-select.css" rel="stylesheet" type="text/css" />
<link href="<?=base_url('assets/additional_assets/')?>template/libs/select2/select2.min.css" rel="stylesheet" type="text/css" />

<!-- dropify -->
<link href="<?=base_url('assets/additional_assets/')?>css/dropify.min.css" rel="stylesheet" type="text/css" />
<link href="<?=base_url('assets/additional_assets/')?>css/flag-icon.min.css" rel="stylesheet" type="text/css" />
<!-- multiselect -->
<link href="<?=base_url('assets/additional_assets/')?>css/chosen.css" rel="stylesheet" type="text/css" />
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.16/dist/summernote.min.css" rel="stylesheet">
<!-- modify by Jfrost load custom css-->
<link href="<?=base_url('assets/additional_assets/')?>css/mystyle.css" rel="stylesheet" type="text/css">

<!-- ---------------- -->

<script src="<?=base_url('assets/additional_assets/')?>js/jscolor.js"></script>
<!-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> -->
<script type="text/javascript" src="<?= base_url('assets/additional_assets/js')?>/sweetalert.min.js"></script>

<script
src="https://code.jquery.com/jquery-3.5.0.js"
integrity="sha256-r/AaFHrszJtwpe+tHyNi/XCfMxYpbsRg2Uqn0x3s2zc="
crossorigin="anonymous"></script>
<script src="https://cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>
</head>

<body id="page-top">

<!-- Page Wrapper -->
<div id="wrapper">

    <!-- Sidebar -->
<ul class="navbar-nav bg-dark sidebar sidebar-dark accordion" id="accordionSidebar" style="
    border-radius: 0 70px 0px 0px;">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?=base_url('Admin')?>">
        <div class="sidebar-brand-icon rotate-n-15">
        
        </div>
        <div class="sidebar-brand-text mx-3"><img src="<?=base_url('assets/web_assets/images/White-Logo.png')?>" width="100%" ></sup></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="<?=base_url('Admin/dashboard')?>">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span><?= $this->lang->line('Dashboard')?></span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        <?= $this->lang->line('Interface')?>
    </div>
    <!--  <li class="nav-item">
        <a class="nav-link" href="<?=base_url('Admin')?>">
        <i class="fas fa-fw fa-chart-area"></i>
        <span>Company Details</span></a>
    </li> -->

    <!-- Nav Item - Utilities Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseDetails" aria-expanded="false" aria-controls="collapseUtilities">
        <i class="fas fa-fw fa-home"></i>
        <?php
            if($mis_rest = $this->db->query("SELECT COUNT(rest_id) cnt FROM `tbl_restaurant` 
            JOIN `tbl_restaurant_details` ON `tbl_restaurant_details`.`restaurant_id` = `tbl_restaurant`.`rest_id` 
            WHERE `tbl_restaurant`.`rest_domain` <> '' 
            AND `tbl_restaurant_details`.`activation_status` = 'Accepted' 
            AND `tbl_restaurant_details`.`resto_plan` = 'pro' 
            AND `tbl_restaurant_details`.`domain_status` = 'inactive'")->row()){

                $mis_domain_count = $mis_rest->cnt;
            }
        ?>
        <span><?= $this->lang->line('Restaurant')?><em class="badge badge-success p-1 ml-2 <?= $mis_domain_count > 0 ? "" : "d-none" ?>"> <?= $mis_domain_count > 0 ? $mis_domain_count : "" ?> </em></span>
        </a>
        <div id="collapseDetails" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header"><?= $this->lang->line('Restaurant')?>:</h6>
            <a class="collapse-item" href="<?=base_url('Admin/addRestaurant')?>"><?= $this->lang->line('Add Restaurant')?></a>
            <a class="collapse-item" href="<?=base_url('Admin/allRestaurant')?>"><?= $this->lang->line('All Restaurant')?></a>
            <a class="collapse-item" href="<?=base_url('Admin/pendingRestaurant')?>"><?= $this->lang->line('Pending Restaurant')?></a>
            <!-- <a class="collapse-item" href="<?=base_url('Admin/rejectedRestaurant')?>">Rejected Restaurant</a> -->
            <!-- <a class="collapse-item" href="utilities-animation.html">Animations</a>
            <a class="collapse-item" href="utilities-other.html">Other</a> -->
        </div>
        </div>
    </li>
    
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseCategories" aria-expanded="true" aria-controls="collapseUtilities">
            <i class="fas fa-fw fa-list-alt"></i>
            <span><?= $this->lang->line('Categories')?></span>
        </a>
        <div id="collapseCategories" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header"><?= $this->lang->line('Categories')?>:</h6>
                <a class="collapse-item" href="<?=base_url('Admin/Category')?>"><?= $this->lang->line('Add/View Categories')?></a>
                <a class="collapse-item" href="<?=base_url('Admin/rejectedCategory')?>"><?= $this->lang->line('Rejected')?> <?= $this->lang->line('Categories')?></a>
            </div>
        </div>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="<?=base_url('Admin/allergen')?>">
        <i class="fas fa-fw  fa-wind"></i>
        <span> Allergens</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseMenu" aria-expanded="true" aria-controls="collapseUtilities">
            <i class="fas fa-fw  fa-hamburger"></i>
            <span><?= $this->lang->line('Menu')?></span>
        </a>
        <div id="collapseMenu" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header"><?= $this->lang->line('Menu')?>:</h6>
                <a class="collapse-item" href="<?=base_url('Admin/Menu')?>"><?= $this->lang->line('Add/View')?> <?= $this->lang->line('Menu')?></a>
                <a class="collapse-item" href="<?=base_url('Admin/rejectedMenu')?>"><?= $this->lang->line('Rejected')?> <?= $this->lang->line('Menu')?></a>
            </div>
        </div>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="<?=base_url('Admin/addon')?>">
        <i class="fas fa-fw fa-gem"></i>
        <span><?= $this->lang->line('Addon')?></span></a>
    </li>
    <li class="nav-item d-flex justify-content-center align-items-center">
        <a class="nav-link" href="<?=base_url('Admin/restaurant_addons')?>">
        <i class="fas fa-fw fa-luggage-cart"></i>
        <span><?= $this->lang->line('Restaurant')?> <?= $this->lang->line('Addons')?></span></a>
        <?php if($mis_addon_request = $this->db->query("SELECT COUNT(rest_id) cnt FROM `tbl_restaurant_addons` WHERE status='pending';")->row()){  if ($mis_addon_request->cnt > 0) {?>
            <span class="badge mr-2 addon_count"><?= $mis_addon_request->cnt?></span>
        <?php } } ?>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="<?=base_url('Admin/Kitchens')?>">
        <i class="fas fa-fw fa-utensils"></i>
        <span><?= $this->lang->line('Kitchens')?></span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="<?=base_url('Admin/legalPageSetting')?>">
        <i class="fas fa-fw fa-gavel"></i>
        <span><?= $this->lang->line('Legal')?> <?= $this->lang->line('Page Settings')?></span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="<?=base_url('Admin/mobilePageSetting')?>">
        <i class="fas fa-fw fa-mobile"></i>
        <span class="text-capitalize"><?= $this->lang->line('Mobile')?> <?= $this->lang->line('Page Settings')?></span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="<?=base_url('Admin/Announcements')?>">
        <i class="fas fa-fw fa-bullhorn"></i>
        <span><?= $this->lang->line('Announcements')?></span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="<?=base_url('Admin/fileUploadingSetting')?>">
        <i class="fas fa-fw fa-upload"></i>
        <span class="text-capitalize"><?= $this->lang->line('file')?> <?= $this->lang->line('uploading')?> <?= $this->lang->line('Setting')?></span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="<?=base_url('Admin/Setting')?>">
        <i class="fas fa-fw fa-cog"></i>
        <span><?= $this->lang->line("Restaurant Setting")?></span></a>
    </li> 
    <li class="nav-item">
        <a class="nav-link" href="<?=base_url('Admin/videoTutorials')?>">
        <i class="fas fa-fw fa-film"></i>
        <span><?= $this->lang->line("Video Tutorials")?></span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="<?=base_url('Admin/freeSupport')?>">
        <i class="fas fa-fw fa-question"></i>
        <span><?= $this->lang->line("Free Support")?></span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="<?=base_url('Admin/supportTicket')?>">
        <i class="fas fa-fw fa-info"></i>
        <span><?= $this->lang->line("Support Ticket")?></span></a>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

    <!-- Main Content -->
    <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

        <!-- Sidebar Toggle (Topbar) -->
        <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
        </button>

        <!-- modify by Jfrost header-->
        <ul class="navbar-nav ml-auto lang-setting">
            <div class="topbar-divider d-none d-sm-block"></div>
            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <!-- modify by Jfrost header-->
                <?php
                    if ($this->session->userdata('site_lang_admin') == "germany"){?>
                        <img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/ge-flag.png')?>">
                        <?php 
                    }elseif ($this->session->userdata('site_lang_admin') == "french"){?>
                        <img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/fr-flag.png')?>">
                        <?php 
                    }else{?>
                        <img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/en-flag.png')?>">
                    <?php }
                ?>
                <!-- ------------------ -->
                <span class="ml-2 d-none d-lg-inline text-gray-600 small"><i class="fas fa-language noti-icon"></i></span>
            </a>
            <!-- Dropdown - User Information -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" onclick = "change_language('<?= base_url('API/change_lang_admin') ?>','english')">
                <img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/en-flag.png')?>">
                English
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" onclick = "change_language('<?= base_url('API/change_lang_admin') ?>','germany')">
                <img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/ge-flag.png')?>">
                Germany
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" onclick = "change_language('<?= base_url('API/change_lang_admin') ?>','french')">
                <img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/fr-flag.png')?>">
                French
                </a>
            </div>
            </li>

        </ul>
        <!-- ------------------- -->
        <!-- Topbar Navbar -->
        <ul class="navbar-nav">
            

            <div class="topbar-divider d-none d-sm-block"></div>
            
            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?= $this->lang->line("Admin Dashboard")?></span>
                <!-- <img class="img-profile rounded-circle" src="https://source.unsplash.com/QAB-WJcbgJk/60x60"> -->
                <span class="mr-2 d-lg-none text-gray-600 small"><i class="fa fa-angle-down"></i></span>
            </a>
            <!-- Dropdown - User Information -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
          
                <a class="dropdown-item" href="<?=base_url('Admin/logOut')?>" >
                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                Logout
                </a>
            </div>

            </li>

        </ul>

        </nav>
        <!-- End of Topbar -->
