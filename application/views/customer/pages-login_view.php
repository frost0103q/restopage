<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>My Restopage</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="assets/additional_assets/images/favicon.ico">

        <!-- App css -->
        <link href="<?php echo base_url('assets/additional_assets/template/css/bootstrap.min.css');?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url('assets/additional_assets/template/css/icons.min.css');?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url('assets/additional_assets/template/css/app.min.css');?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url('assets/additional_assets/template/css/mystyle.css');?>" rel="stylesheet" type="text/css" />

    </head>


    <body class="authentication-bg">
        <div id="preloader">
            <div id="status">
                <div class="spinner">Loading...</div>
            </div>
        </div>

        <div class="account-pages mt-5 mb-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="text-center">
                            <a href="<?= base_url()?>">
                            <span><img src="<?php echo base_url('assets/additional_assets/template/images/logo-dark.png');?>"  alt="" height="32"></span>
                            </a>
                            <p class="text-muted mt-2 mb-4"></p>
                        </div>
                        <div class="card">

                            <div class="card-body p-4">
                                
                                <div class=" mb-4">
                                    
                                    <div style="float:right;">
                                    <?php
                                    
                                        if ($this->session->userdata('site_lang') != "spanish"){?>
                                            
                                            <div style= "border-radius: 4px;display: inline-block;">
                                                <img src="<?= base_url('assets/flags/en-flag.png')?>" class="flag flag-en" style= "height: 20px;box-shadow: 2px 2px 4px #000000a6;width: 30px;opacity: 1; margin: 5px;" onclick = "change_language_('<?= base_url('login/change_lang') ?>','english')"/>
                                            </div>
                                            <div style= "border-radius: 4px;display: inline-block;">
                                                <img src="<?= base_url('assets/flags/en-flag.png')?>" class="flag flag-es" style= "height: 20px;width: 30px;opacity: 0.2; margin: 5px;" onclick = "change_language_('<?= base_url('login/change_lang') ?>','spanish')"/>
                                            </div>
                                            <?php 
                                        }else{?>
                                            <div style= "border-radius: 4px;display: inline-block;">
                                                <img src="<?= base_url('assets/flags/en-flag.png')?>" class="flag flag-en" style= "height: 20px;width: 30px;opacity: 0.2; margin: 5px;" onclick = "change_language_('<?= base_url('login/change_lang') ?>','english')"/>
                                            </div>
                                            <div style= "border-radius: 4px;display: inline-block;">
                                                <img src="<?= base_url('assets/flags/en-flag.png')?>" class="flag flag-es" style= "height: 20px;box-shadow: 2px 2px 4px #000000a6;width: 30px;opacity: 1; margin: 5px;" onclick = "change_language_('<?= base_url('login/change_lang') ?>','spanish')"/>
                                            </div>
                                        <?php }
                                    ?>
                                    </div>
                                    <h4 class="text-uppercase mt-0"><?= $this->lang->line("Sign In")?>
                                    </h4>
                                </div>
        

                                <form class="form-signin" action="<?php echo site_url('login/auth');?>" method="post">

                                    <div class="form-group mb-3">
                                        <label for="emailaddress"><?= $this->lang->line("Email address or Username")?></label>
                                        <input class="form-control" type="text" name = "email" id="emailaddress" required="" placeholder= '<?= $this->lang->line("Enter your email or Username")?>'>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="password"><?= $this->lang->line("Password")?></label>
                                        <input class="form-control" type="password" name = "password" required="" id="password" placeholder='<?= $this->lang->line("Enter your password")?>'>
                                    </div>
                                    <!-- <div class="g-recaptcha" data-sitekey="<?php echo $this->config->item('google_key') ?>"></div>  -->
                                    <div class="form-group mb-3">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="checkbox-signin" checked>
                                            <label class="custom-control-label" for="checkbox-signin"><?= $this->lang->line("Remember me")?></label>
                                        </div>
                                    </div>

                                    <?php echo $this->session->flashdata('msg');?></p>
                                    <div class="form-group mb-0 text-center">
                                        <button class="btn btn-primary btn-block" type="submit"> <?= $this->lang->line("Log In")?> </button>
                                    </div>

                                </form>

                            </div> <!-- end card-body -->
                        </div>
                        <!-- end card -->

                        <div class="row mt-3">
                            <div class="col-12 text-center">
                                <p> <a href="<?php echo site_url('forgot-password');?>" class="text-muted ml-1"><i class="fa fa-lock mr-1"></i><?= $this->lang->line("Forgot your password")?>?</a></p>
                                <p class="text-muted"><?= $this->lang->line("sign_up_message")?> <a href="<?php echo site_url('register');?>" class="text-dark ml-1"><b><?= $this->lang->line("Sign up")?></b></a></p>
                            </div> <!-- end col -->
                        </div>
                        <!-- end row -->

                    </div> <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <!-- end page -->
    

        <!-- Vendor js -->
        <script src="<?php echo base_url('assets/additional_assets/template/js/vendor.min.js');?>"></script>

        <!-- App js -->
        <script src="<?php echo base_url('assets/additional_assets/template/js/app.min.js');?>"></script>
        
        <!-- My script file -->
        <script src="<?php echo base_url('assets/additional_assets/template/js/myscript.js');?>"></script>
        
    </body>
</html>