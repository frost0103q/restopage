<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>My Restopage</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="<?php echo base_url('assets/web_assets/images/Fav-Icon.png');?>">
        <?php
            if (isset($extra_style)){
                foreach ($extra_style as $key => $value) {
                    echo $value;
                }
            }
        ?>
        <!--Morris Chart-->
        <link rel="stylesheet" href="<?php echo base_url('assets/additional_assets/template/libs/morris-js/morris.css');?>" />
        <!-- Custom box css -->
        <link href="<?php echo base_url('assets/additional_assets/template/libs/custombox/custombox.min.css');?>" rel="stylesheet">
        
        <!-- App css -->
        <link href="<?php echo base_url('assets/additional_assets/template/css/bootstrap.min.css');?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url('assets/additional_assets/template/css/icons.min.css');?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url('assets/additional_assets/template/css/app.min.css');?>" rel="stylesheet" type="text/css" />
        <link href="https://fonts.googleapis.com/css2?family=Parisienne&family=Satisfy&display=swap" rel="stylesheet">
        <!-- My style css -->
        <link href="<?php echo base_url('assets/additional_assets/css/mystyle.css');?>" rel="stylesheet" type="text/css" />

    </head>
    <body class = "<?php if ($this->session->userdata('id') == 1) {echo 'left-side-menu-dark topbar-dark'; } ?>">
        <!-- Begin page -->
        <div id="wrapper" class="customer-panel-side">
