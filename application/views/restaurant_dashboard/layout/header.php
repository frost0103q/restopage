
<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="description" content="">
<meta name="author" content="">

<title>Restaurant - Dashboard</title>

<!-- Custom fonts for this template-->

<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

<!-- Custom styles for this template-->
<link href="<?=base_url('assets/comp_assets/')?>css/sb-admin-2.min.css" rel="stylesheet">

<link href="<?=base_url('assets/comp_assets/')?>vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
<link href="<?=base_url('assets/additional_assets/')?>template/libs/datatables/responsive.bootstrap4.css" rel="stylesheet" type="text/css" />

<!-- dropify -->
<link href="<?=base_url('assets/additional_assets/')?>css/dropify.min.css" rel="stylesheet" type="text/css" />
<link href="<?=base_url('assets/additional_assets/')?>css/flag-icon.min.css" rel="stylesheet" type="text/css" />
<!-- date picker -->
<link href="<?=base_url('assets/additional_assets/')?>template/libs/bootstrap-datepicker/bootstrap-datepicker.css" rel="stylesheet" type="text/css" />
<!-- switchery -->
<link href="<?=base_url('assets/additional_assets/')?>template/libs/switchery/switchery.min.css" rel="stylesheet" type="text/css" />
<!-- multiselect -->
<link href="<?=base_url('assets/additional_assets/')?>css/chosen.css" rel="stylesheet" type="text/css" />
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.16/dist/summernote.min.css" rel="stylesheet">
<!-- modify by Jfrost load custom css-->
<link href="<?=base_url('assets/additional_assets/')?>css/mystyle.css" rel="stylesheet" type="text/css">
<!-- ---------------- -->

<!-- <script src="https://www.googleapis.com/webfonts/v1/webfonts?key=AIzaSyB8Ua6XIfe-gqbkE8P3XL4spd0x8Ft7eWo"></script> -->
<script src="<?=base_url('assets/additional_assets/')?>js/jscolor.js"></script>
<!-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> -->
<script src="https://code.jquery.com/jquery-3.5.0.js" integrity="sha256-r/AaFHrszJtwpe+tHyNi/XCfMxYpbsRg2Uqn0x3s2zc=" crossorigin="anonymous"></script>
<script type="text/javascript" src="<?= base_url('assets/additional_assets/js')?>/sweetalert.min.js"></script>
<!-- modify by Jfrost disconnect jquery server -->
<!-- <script type="text/javascript" src="<?= base_url('assets/additional_assets/js')?>/jquery.js"></script> -->
<script src="https://cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>
<!-- thermal printer -->
<script type="text/javascript" src="<?= base_url('assets/additional_assets/js')?>/JSPrintManager.js"></script>
<script type="text/javascript" src="<?= base_url('assets/additional_assets/js')?>/zip.js"></script>
<script type="text/javascript" src="<?= base_url('assets/additional_assets/js')?>/zip-ext.js"></script>
<script type="text/javascript" src="<?= base_url('assets/additional_assets/js')?>/deflate.js"></script>
<!-- --------------- -->
<!-- HTMLTOCANVAS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
<!-- <link href="<?=base_url('assets/comp_assets/')?>vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css"> -->
<!-- <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"> -->
<link href="<?=base_url('assets/additional_assets/').'template/css/icons.min.css' ?>" rel="stylesheet" type="text/css" />
<?php
    if(isset($externalStyle)){
        echo $externalStyle;
    }
?>
<script>
<?php
    if (isset($currentRestCurrencySymbol)){
        echo 'var cur_symbol = "'.$currentRestCurrencySymbol.'";';
    }else{
        echo 'var cur_symbol = "€";';
    }
?>
</script>
<!--Start of Tawk.to Script-->
<!-- <script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/60de9cd265b7290ac6390204/1f9ip96ae';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script> -->
<!--End of Tawk.to Script-->

</head>

<body id="page-top" class="<?=$this->session->userdata("site_lang_admin")?>">

<!-- Page Wrapper -->
<?php
    if ($this->session->userdata('site_lang_admin')){
        $_lang = $this->session->userdata('site_lang_admin');
    }else{
        $_lang = "french";
    }
    
    if ($_lang == "english"){
        $url_surfix = "/?lang="."en";
    }elseif ($_lang == "germany"){
        $url_surfix = "/?lang="."de";
    }else{
        $url_surfix = "/?lang="."fr";
    }

?>
<div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav j-bg-dark sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= base_url("Restaurant").$url_surfix?>">
        <div class="sidebar-brand-icon rotate-n-15">
        
        </div>
        <div class="sidebar-brand-text mx-3"><img src="<?=base_url('assets/web_assets/images/White-Logo.png')?>" width="100%" ></sup></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">
    <?php
        // $addon_features = $this->MODEL->getAddonFeatures_by_rest_id($this->myRestId);
    ?>
    <!-- Nav Item - Dashboard -->
    <li class="nav-item j-blue-title active">
        <a class="nav-link pb-1" href="<?=base_url('Restaurant').$url_surfix?>">
        <!-- <i class="fas fa-fw fa-tachometer-alt"></i> -->
        <!-- <span><?= $this->lang->line('Dashboard').$url_surfix?></span></a> -->
        <span class=""><?= $myRestName ?></span></a>
    </li>
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        <?= $this->lang->line('INTERFACE')?>
    </div>
    <?php if (in_array("order_management",$addon_features)){ ?>
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseOrders" aria-expanded="true" aria-controls="collapseUtilities">
                <i class="fas fa-fw fa-building"></i>
                <span><?= $this->lang->line('Orders Management')?></span>
            </a>
            <div id="collapseOrders" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header"><?= $this->lang->line('Orders Management')?>:</h6>
                    <a class="collapse-item" href="<?=base_url('Restaurant/orderManagement').$url_surfix?>"><?= $this->lang->line('All Orders')?></a>
                    <a class="collapse-item" href="<?=base_url('Restaurant/acceptedOrders').$url_surfix?>"><?= $this->lang->line('Accepted')?> <?= $this->lang->line('Orders')?></a>
                    <a class="collapse-item" href="<?=base_url('Restaurant/pendingOrders').$url_surfix?>"><?= $this->lang->line('Pending')?> <?= $this->lang->line('Orders')?></a>
                    <a class="collapse-item" href="<?=base_url('Restaurant/rejectedOrders').$url_surfix?>"><?= $this->lang->line('Rejected')?> <?= $this->lang->line('Orders')?></a>
                </div>
            </div>
        </li> 
    <?php } ?>

    <li class="nav-item">
        <a class="nav-link" href="<?=base_url('Restaurant/Reservation').$url_surfix?>">
        <i class="fas fa-fw fa-ticket-alt"></i>
        <span><?= $this->lang->line('Table')?> <?= $this->lang->line('Reservations')?></span></a>
    </li>

    <?php if (in_array("delivery_zones",$addon_features)){ ?>
        <li class="nav-item">
            <a class="nav-link" href="<?=base_url('Restaurant/deliveryArea').$url_surfix?>">
            <i class="fas fa-fw fa-truck"></i>
            <span><?= $this->lang->line('Delivery Area')?></span></a>
        </li>
    <?php } ?>

    <?php if (in_array("client_management",$addon_features)){ ?>
    <li class="nav-item">
        <a class="nav-link" href="<?=base_url('Restaurant/clients').$url_surfix?>">
        <i class="fas fa-fw fa-users"></i>
        <span><?= $this->lang->line('Clients')?></span></a>
    </li>
    <?php } ?>
    <li class="nav-item">
        <a class="nav-link" href="<?=base_url('Restaurant/myQrCode').$url_surfix?>">
        <i class="fas fa-fw fa-qrcode"></i>
        <span><?= $this->lang->line('My QR Code')?></span></a>
    </li>

    <li class="nav-item j-blue-title active">
        <a class="nav-link pb-1" href="#">
        <span class=""><?= $this->lang->line("Menu") ?> <?=$this->lang->line("Options")?></span></a>
    </li>
    <hr class="sidebar-divider my-0">
    <li class="nav-item">
        <a class="nav-link" href="<?=base_url('Restaurant/Category').$url_surfix?>">
        <i class="fas fa-fw fa-list-alt"></i>
        <span> <?= $this->lang->line('Categories')?></span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="<?=base_url('Restaurant/FoodExtra').$url_surfix?>">
        <i class="fas fa-fw fa-burn"></i>
        <span> <?= $this->lang->line('Food Extras')?></span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="<?=base_url('Restaurant/allergens').$url_surfix?>">
        <i class="fas fa-fw  fa-wind"></i>
        <span> Allergens</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="<?=base_url('Restaurant/Menu').$url_surfix?>">
        <i class="fas fa-fw  fa-hamburger"></i>
        <span> <?= $this->lang->line('Menu')?></span></a>
    </li>
    <li class="nav-item j-blue-title active">
        <a class="nav-link pb-1" href="#">
        <span class=""><?=$this->lang->line("Setting")?></span></a>
    </li>
    <hr class="sidebar-divider my-0">

    <li class="nav-item">
        <a class="nav-link" href="<?=base_url('Restaurant/setting').$url_surfix?>">
        <i class="fas fa-fw fa-edit"></i>
        <span><?= $this->lang->line('Restaurant Details')?></span></a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="<?=base_url('Restaurant/setting/Kitchen').$url_surfix?>">
        <i class="fas fa-fw fa-american-sign-language-interpreting"></i>
        <span><?= $this->lang->line('Restaurant')?> <?= $this->lang->line('Kitchen')?></span></a>
    </li>

    <?php if (in_array("domain_integration",$addon_features)){ ?>
    <li class="nav-item">
        <a class="nav-link" href="<?=base_url('Restaurant/setting/MyDomain').$url_surfix?>">
        <i class="fas fa-fw fa-globe"></i>
        <span><?= $this->lang->line('My Domain')?></span></a>
    </li>
    <?php } ?>
    <li class="nav-item">
        <a class="nav-link" href="<?=base_url('Restaurant/setting/Announcements').$url_surfix?>">
        <i class="fas fa-fw fa-bullhorn"></i>
        <span><?= $this->lang->line('Announcements')?></span></a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="<?=base_url('Restaurant/openingTime').$url_surfix?>">
        <i class="fas fa-fw fa-clock"></i>
        <span><?= $this->lang->line('Opening Time')?></span></a>
    </li>
    <?php if (in_array("online_payments",$addon_features)){ ?>
        <li class="nav-item">
            <a class="nav-link" href="<?=base_url('Restaurant/paymentSetting').$url_surfix?>">
            <i class="fas fa-fw fa-credit-card"></i>
            <span><?= $this->lang->line('Payment')?> <?= $this->lang->line('Setting')?></span></a>
        </li>
    <?php } ?>    
    
    <li class="nav-item">
        <a class="nav-link" href="<?=base_url('Restaurant/pageSetting/Slider').$url_surfix?>">
        <i class="fas fa-fw fa-images"></i>
        <span><?= $this->lang->line('Slider')?> <?= $this->lang->line('Setting')?></span></a>
    </li>
    
    <li class="nav-item">
        <a class="nav-link" href="<?=base_url('Restaurant/pageSetting').$url_surfix?>">
        <i class="fas fa-fw fa-cogs"></i>
        <span><?= $this->lang->line('Homepage')?> <?= $this->lang->line('Setting')?></span></a>
    </li>
    
    <?php if (in_array("upload_images",$addon_features)){ ?>
    <li class="nav-item">
        <a class="nav-link" href="<?=base_url('Restaurant/bannerSetting').$url_surfix?>">
        <i class="fas fa-fw fa-image"></i>
        <span><?= $this->lang->line('Food')?> <?= $this->lang->line('Menu')?> <?= $this->lang->line('Banner')?></span></a>
    </li>
    <?php } ?>

    <?php if (in_array("multilingual",$addon_features)){ ?>
    <li class="nav-item">
        <a class="nav-link" href="<?=base_url('Restaurant/setting/Language').$url_surfix?>">
        <i class="fas fa-fw fa-language"></i>
        <span><?= $this->lang->line('Language')?> <?= $this->lang->line('Setting')?></span></a>
    </li>
    <?php } ?>
    <li class="nav-item">
        <a class="nav-link" href="<?=base_url('Restaurant/setting/ActivePage').$url_surfix?>">
        <i class="fas fa-fw fa-low-vision"></i>
        <span><?= $this->lang->line('Activate / Deactivate Pages')?></span></a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="<?=base_url('Restaurant/socialSetting').$url_surfix?>">
        <i class="fab fa-fw fa-facebook"></i>
        <span class="text-capitalize"><?= $this->lang->line('social')?> <?= $this->lang->line('Setting')?></span></a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="<?=base_url('Restaurant/legalPageSetting').$url_surfix?>">
        <i class="fas fa-fw fa-gavel"></i>
        <span><?= $this->lang->line('Legal')?> <?= $this->lang->line('Page Settings')?></span></a>
    </li>
    
    <?php if (in_array("website_color_font",$addon_features)){ ?>
    <li class="nav-item">
        <a class="nav-link" href="<?=base_url('Restaurant/colorSetting').$url_surfix?>">
        <i class="fas fa-fw fa-brush"></i>
        <span><?= $this->lang->line('Design')?> <?= $this->lang->line('Setting')?></span></a>
    </li>
    <?php }?>
    <?php if (in_array("tax_setting",$addon_features)){ ?>
    <li class="nav-item">
        <a class="nav-link" href="<?=base_url('Restaurant/taxSetting').$url_surfix?>">
        <i class="fas fa-fw fa-newspaper"></i>
        <span><?= $this->lang->line('Tax Setting')?></span></a>
    </li>
    <?php } ?>
    
    <?php if (in_array("loyalty_points",$addon_features)){ ?>
    <li class="nav-item">
        <a class="nav-link" href="<?=base_url('Restaurant/loaltyPoints').$url_surfix?>">
        <i class="fas fa-fw fa-coins"></i>
        <span><?= $this->lang->line('Loyalty Points')?></span></a>
    </li>
    <?php }?>

    <li class="nav-item">
        <a class="nav-link" href="<?=base_url('Restaurant/SEOSettings').$url_surfix?>">
        <i class="fas fa-fw fa-cloud"></i>
        <span><?= $this->lang->line('SEO')?> <?= $this->lang->line('Setting')?></span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="<?=base_url('Restaurant/googleAnalytics').$url_surfix?>">
        <i class="fas fa-fw fa-chart-area"></i>
        <span class="text-capitalize">Google <?= $this->lang->line('analytics')?></span></a>
    </li>

    <li class="nav-item j-blue-title active">
        <a class="nav-link pb-1" href="#">
        <span class=""><?=$this->lang->line("Pro")?></span></a>
    </li>
    <hr class="sidebar-divider my-0">

    <li class="nav-item hide-field">
        <a class="nav-link" href="<?=base_url('Restaurant/setting/Package').$url_surfix?>">
        <i class="fas fa-fw fa-gift"></i>
        <span><?= $this->lang->line('Restaurant')?> <?= $this->lang->line('Package')?></span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="<?=base_url('Restaurant/Addon').$url_surfix?>">
        <i class="fas fa-fw fa-gift"></i>
        <span><?= $this->lang->line('Restaurant')?> <?= $this->lang->line('Addons')?></span></a>
    </li>
    <li class="nav-item hide-field">
        <a class="nav-link" href="<?=base_url('Restaurant/setting/CancelPackage').$url_surfix?>">
        <i class="fas fa-fw fa-coffee"></i>
        <span><?= $this->lang->line('Cancel')?> <?= $this->lang->line('Pro')?> <?= $this->lang->line('Package')?></span></a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="<?=base_url('Restaurant/AddonInvoices').$url_surfix?>">
        <i class="fas fa-fw fa-wrench"></i>
        <span><?= $this->lang->line('My')?> <?= $this->lang->line('Invoices')?></span></a>
    </li>

    <li class="nav-item j-blue-title active">
        <a class="nav-link pb-1" href="#">
        <span class=""><?=$this->lang->line("Help")?></span></a>
    </li>
    <hr class="sidebar-divider my-0">

    <?php if (in_array("free_support",$addon_features)){ ?>
    <li class="nav-item">
        <a class="nav-link" href="<?=base_url('Restaurant/FreeSupport').$url_surfix?>">
        <i class="fas fa-fw fa-question"></i>
        <span><?= $this->lang->line('Free Support')?></span></a>
    </li>
    <?php } ?>
    <li class="nav-item">
        <a class="nav-link" href="<?=base_url('Restaurant/videoTutorials').$url_surfix?>">
        <i class="fas fa-fw fa-film"></i>
        <span><?= $this->lang->line('Video Tutorials')?></span></a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="<?=base_url('Restaurant/setting/SupportTicket').$url_surfix?>">
        <i class="fas fa-fw fa-info"></i>
        <span><?= $this->lang->line('Support Ticket')?></span></a>
    </li>

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseSetting" aria-expanded="true" aria-controls="collapseUtilities">
            <i class="fas fa-fw fa-cogs"></i>
            <span><?= $this->lang->line('Setting')?></span>
        </a>
        <div id="collapseSetting" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header"><?= $this->lang->line('Setting')?>:</h6>
                <a class="collapse-item" href="<?=base_url('Restaurant/setting').$url_surfix?>"><?= $this->lang->line('General')?> <?= $this->lang->line('Setting')?></a>
                <?php
                    if (in_array("online_payments",$addon_features)){ ?>
                        <a class="collapse-item" href="<?=base_url('Restaurant/paymentSetting').$url_surfix?>"><?= $this->lang->line('Payment')?> <?= $this->lang->line('Setting')?></a>
                    <?php }
                ?>
		        <!-- modify by Jfrost in 2nd stage -->
                <a class="collapse-item" href="<?=base_url('Restaurant/pageSetting').$url_surfix?>"><?= $this->lang->line('Page Settings')?></a>
                <a class="collapse-item" href="<?=base_url('Restaurant/colorSetting').$url_surfix?>"><?= $this->lang->line('WebSite Color')?></a>
                <a class="collapse-item" href="<?=base_url('Restaurant/openingTime').$url_surfix?>"><?= $this->lang->line('Opening Time')?></a>
                <a class="collapse-item" href="<?=base_url('Restaurant/taxSetting').$url_surfix?>"><?= $this->lang->line('Tax Setting')?></a>
            </div>
        </div>
    </li>
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
        <nav class="navbar navbar-expand navbar-light j-bg-dark topbar mb-4 static-top shadow">

        <!-- Sidebar Toggle (Topbar) -->
        <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
        </button>
        <!-- modify by Jfrost header-->
        <ul class="navbar-nav ml-auto lang-setting hide-field">
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
                <a class="dropdown-item" onclick = "change_language('<?= base_url('api/change_lang') ?>','english')">
                <img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/en-flag.png')?>">
                English
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" onclick = "change_language('<?= base_url('api/change_lang') ?>','germany')">
                <img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/ge-flag.png')?>">
                Germany
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" onclick = "change_language('<?= base_url('api/change_lang') ?>','french')">
                <img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/fr-flag.png')?>">
                French
                </a>
            </div>
            </li>

        </ul>
        <!-- modify by Jfrost Next stage No1 show on shop link and preview-->
        <div class="mr-auto">
            <ul class="navbar-nav">
                <!-- Nav Item - User Information -->
                <li class="nav-item dropdown no-arrow d-md-flex d-none">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="small px-4  bg-success text-white input-control rounded form-control"><?= $this->lang->line("Help") ?></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-center shadow animated--grow-in" aria-labelledby="userDropdown">
                        <a class="dropdown-item" href = "#"><?= $this->lang->line("Free Support") ?></a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href = "#"><?= $this->lang->line("Video Tutorials") ?></a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href = "#"><?= $this->lang->line("Support Ticket") ?></a>
                    </div>
                </li>
                
                <li class="nav-item dropdown no-arrow d-md-flex d-none" style="width:500px;">
                    <div class="input-group nav-link m-0">
                        <?php 
                            $UrlSlug = $this->db->where('rest_id',$this->myRestId)->get('tbl_restaurant')->row()->rest_url_slug;
                        ?>
                        <input type="text" class="preview-link form-control" read-only value="<?= base_url("main/").$UrlSlug.$url_surfix ?>" width= "100">
                        <div class="input-group-append">
                            <a href="<?= base_url("main/").$UrlSlug.$url_surfix ?>" class="input-group-text text-decoration-none btn btn-success" target="_block"><?= $this->lang->line("Preview") ?></a>
                        </div>
                    </div>
                </li>
                <li class="nav-item dropdown no-arrow   d-md-none d-flex">
                    <a class="nav-link" href="<?= base_url("main/").$UrlSlug.$url_surfix ?>" >
                        <span class="small px-2  bg-success text-white input-control rounded form-control"><?= $this->lang->line("Preview") ?></span>
                    </a>
                </li>
            </ul>
        </div>
        <!-- ------------------- -->
        <?php
            $announcements = $this->db->where('rest_id',0)->get('tbl_announcement')->result();
            $ann_arr = array();
            if (null !== $this->input->cookie('jfrost_announcement_closed_str')){
                $ann_arr = explode(",", $this->input->cookie("jfrost_announcement_closed_str"));
            }
        ?>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="notificationDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="mr-2 d-none d-lg-inline text-gray-600 small"><i class="fas fa-bell fa-fw"></i></span>
                    <!-- <span class="badge badge-danger badge-counter">7</span> -->
                </a>
                <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in notificationDropdown" aria-labelledby="notificationDropdown">
                    <?php
                        $ann_count = 0;
                        foreach ($announcements as $ankey => $ann) {
                            $ann_count++;
                            if (trim($ann->content) !== ""){
                                $content = "content_" . $_lang;
                                $restaurant_message = $ann->$content == "" ?  $ann->content : $ann->$content;
                                $is_hide = "";
                                if (in_array($ann->id,$ann_arr)){
                                    $is_hide = "hide-field";
                                }
                                $hide_first_notification = $ann_count == 1 ? "hide-field" : "" ;
                                echo '<div class="dropdown-divider '.$hide_first_notification.'"></div>';
                                echo '<div class="dropdown-item announcement-notification-btn" data-announcement-id = "'.$ann->id.'"><div style="background:'. ((trim($ann->content_bg_color) !== "") ? $ann->content_bg_color : "#FFFFFF") . percentToHex( 100*floatval($ann->content_bg_color_alpha)) .'">'.$restaurant_message.'</div></div>';
                            }
                        }
                    ?>
                </div>
            </li>
            <div class="topbar-divider d-none d-sm-block"></div>
            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
                <a class="nav-link dropdown-toggle" href="#" id="userDropdown1" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?=$this->lang->line("My Account")?></span>
                    <span class="mr-2 d-lg-none text-gray-600 small"><i class="fa fa-angle-down"></i></span>
                </a>
                <!-- Dropdown - User Information -->
                <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown1">
                    <a class="dropdown-item" href="<?=base_url('Restaurant/Setting').$url_surfix?>">
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                    Profile
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="<?=base_url('Restaurant/logOut')?>" >
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Logout
                    </a>
                </div>
            </li>

        </ul>

        </nav>
        <!-- End of Topbar -->
        <!-- Begin of Announcement -->
        <?php
            function percentToHex($p){
                $percent = max(0, min(100, $p)); // bound percent from 0 to 100
                $intValue = round($p / 100 * 255); // map percent to nearest integer (0 - 255)
                $hexValue = dechex($intValue); // get hexadecimal representation
                return str_pad($hexValue, 2, '0', STR_PAD_LEFT); // format with leading 0 and upper case characters
            }
            foreach ($announcements as $akey => $announcement) {
                if (trim($announcement->content) !== ""){
                    $content = "content_" . $_lang;
                    $restaurant_message = $announcement->$content == "" ?  $announcement->content : $announcement->$content;
                    $is_hide = "";
                    if (in_array($announcement->id,$ann_arr)){
                        $is_hide = "hide-field";
                    }
                    echo '<div class="alert m-4 container mx-auto pt-4 j-annnouncement-'.$announcement->id.' '.$is_hide.'" style="background:'. ((trim($announcement->content_bg_color) !== "") ? $announcement->content_bg_color : "#FFFFFF") . percentToHex( 100*floatval($announcement->content_bg_color_alpha)) .'"><i class="close-announcement-btn fa fa-times" data-announcement-id = "'.$announcement->id.'" ></i><span>'.$restaurant_message.'</span></div>';
                }
            }
        ?>
        <!-- End of Announcement -->

