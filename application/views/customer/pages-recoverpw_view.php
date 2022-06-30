<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>PERRO AMIGO 5X8</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
        <meta content="Coderthemes" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="assets/images/favicon.ico">

        <!-- App css -->
        <link href="<?php echo base_url('assets/template/css/bootstrap.min.css');?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url('assets/template/css/icons.min.css');?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url('assets/template/css/app.min.css');?>" rel="stylesheet" type="text/css" />
        <script src='https://www.google.com/recaptcha/api.js'></script>

    </head>

    <body class="authentication-bg">
        <div class="account-pages mt-5 mb-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="text-center">
                            <a href="<?= site_url()?>">
                            <span><img src="<?php echo base_url('assets/template/images/logo-dark.png');?>"  alt="" height="32"></span>
                            </a>
                            <p class="text-muted mt-2 mb-4"></p>
                        </div>
                        <div class="card">

                            <div class="card-body p-4">
                                <div style="float:right;">
                                <?php
                                    if ($this->session->userdata('site_lang') == "english"){?>
                                        <div style= "border-radius: 4px;display: inline-block;">
                                            <img src="<?= base_url('assets/flags/en-flag.png')?>" class="flag flag-en" style= "height: 20px;box-shadow: 2px 2px 4px #000000a6;width: 30px;opacity: 1; margin: 5px;" onclick = "change_language_('<?= base_url('Customer/change_lang') ?>','english')"/>
                                        </div>
                                        <div style= "border-radius: 4px;display: inline-block;">
                                            <img src="<?= base_url('assets/flags/ge-flag.png')?>" class="flag flag-es" style= "height: 20px;width: 30px;opacity: 0.2; margin: 5px;" onclick = "change_language_('<?= base_url('Customer/change_lang') ?>','germany')"/>
                                        </div>
                                        <div style= "border-radius: 4px;display: inline-block;">
                                            <img src="<?= base_url('assets/flags/fr-flag.png')?>" class="flag flag-es" style= "height: 20px;width: 30px;opacity: 0.2; margin: 5px;" onclick = "change_language_('<?= base_url('Customer/change_lang') ?>','french')"/>
                                        </div>
                                        <?php 
                                    }elseif ($this->session->userdata('site_lang') == "germany"){?>
                                        <div style= "border-radius: 4px;display: inline-block;">
                                            <img src="<?= base_url('assets/flags/en-flag.png')?>" class="flag flag-en" style= "height: 20px;box-shadow: 2px 2px 4px #000000a6;width: 30px;opacity: 0.2; margin: 5px;" onclick = "change_language_('<?= base_url('Customer/change_lang') ?>','english')"/>
                                        </div>
                                        <div style= "border-radius: 4px;display: inline-block;">
                                            <img src="<?= base_url('assets/flags/ge-flag.png')?>" class="flag flag-es" style= "height: 20px;width: 30px;opacity: 1; margin: 5px;" onclick = "change_language_('<?= base_url('Customer/change_lang') ?>','germany')"/>
                                        </div>
                                        <div style= "border-radius: 4px;display: inline-block;">
                                            <img src="<?= base_url('assets/flags/fr-flag.png')?>" class="flag flag-es" style= "height: 20px;width: 30px;opacity: 0.2; margin: 5px;" onclick = "change_language_('<?= base_url('Customer/change_lang') ?>','french')"/>
                                        </div>
                                        <?php 
                                    }else{?>
                                        <div style= "border-radius: 4px;display: inline-block;">
                                            <img src="<?= base_url('assets/flags/en-flag.png')?>" class="flag flag-en" style= "height: 20px;box-shadow: 2px 2px 4px #000000a6;width: 30px;opacity: 0.2; margin: 5px;" onclick = "change_language_('<?= base_url('Customer/change_lang') ?>','english')"/>
                                        </div>
                                        <div style= "border-radius: 4px;display: inline-block;">
                                            <img src="<?= base_url('assets/flags/ge-flag.png')?>" class="flag flag-es" style= "height: 20px;width: 30px;opacity: 1; margin: 5px;" onclick = "change_language_('<?= base_url('Customer/change_lang') ?>','germany')"/>
                                        </div>
                                        <div style= "border-radius: 4px;display: inline-block;">
                                            <img src="<?= base_url('assets/flags/fr-flag.png')?>" class="flag flag-es" style= "height: 20px;width: 30px;opacity: 1; margin: 5px;" onclick = "change_language_('<?= base_url('Customer/change_lang') ?>','french')"/>
                                        </div>
                                    <?php }
                                ?>
                                </div>
                                <div class="mb-4">
                                    <h4 class="text-uppercase mt-0 mb-3"><?= $this->lang->line("Reset Password")?></h4>
                                    <p class="text-muted mb-0 font-13"><?= $this->lang->line("Enter your email address and we'll send you an email with instructions to reset your password.")?>  </p>
                                </div>

                                <form action="<?= site_url('reset-password');?>" method="post">

                                    <div class="form-group mb-3">
                                        <label for="emailaddress"><?= $this->lang->line("Email address")?></label>
                                        <input class="form-control" type="email" id="emailaddress" required="" placeholder='<?= $this->lang->line("Email your email address")?>' name="email">
                                    </div>

                                    <?php echo $this->session->flashdata('msg');?></p>
                                    <div class="form-group mb-0 text-center">
                                        <button class="btn btn-primary btn-block" type="submit"> <?= $this->lang->line("Reset Password")?> </button>
                                    </div>

                                </form>        

                            </div> <!-- end card-body -->
                        </div>
                        <!-- end card -->

                        <div class="row mt-3">
                            <div class="col-12 text-center">
                                <p class="text-muted"><?= $this->lang->line("Back to")?> <a href="<?php echo site_url('login'); ?>" class="text-dark ml-1"><b><?= $this->lang->line("Log In")?> </b></a></p>
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
        <script src="<?php echo base_url('assets/template/js/vendor.min.js');?>"></script>

        <!-- App js -->
        <script src="<?php echo base_url('assets/template/js/app.min.js');?>"></script>       

        <!-- My script file -->
        <script src="<?php echo base_url('assets/template/js/myscript.js');?>"></script>
        
    </body>
</html>