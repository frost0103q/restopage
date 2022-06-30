<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Matrix</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="A referal system paid by e-currency." name="description" />
        <meta content="jfrost" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="assets/images/favicon.ico">

        <!-- App css -->
        <link href="<?php echo base_url('assets/template/css/bootstrap.min.css');?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url('assets/template/css/icons.min.css');?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url('assets/template/css/app.min.css');?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url('assets/template/css/mystyle.css');?>" rel="stylesheet" type="text/css" />
        <script src='https://www.google.com/recaptcha/api.js'></script>
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
                            <a href="<?= base_url("Customer/dashboard")?>">
                                <span><img src="<?php echo base_url('assets/template/images/logo-dark.png');?>" alt="" height="36"></span>
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
                                    <h4 class="text-uppercase mt-0"><?= $this->lang->line("Register")?></h4>
                                </div>

                                <form action="<?php echo site_url('login/register_user');?>" method="post">

                                    <?php
                                        if (isset($_GET['ref'])){
                                            $ref = $_GET['ref'];  
                                        }else{
                                            $ref = "";
                                        }
                                    ?>
                                    <div class="form-group">
                                        <label for="fullname"><?= $this->lang->line("Sponsor Username")?></label>
                                        <input class="form-control" type="text" id="firstname" name = "sponsor" placeholder='<?= $this->lang->line("Enter Sponsor name")?>' value = <?= $sponsor ?> >
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="fullname"><?= $this->lang->line("First name")?></label>
                                            <input class="form-control" type="text" id="firstname" name = "firstname" placeholder='<?= $this->lang->line("Enter your first name")?>' required>
                                        </div>
                                        
                                        <div class="form-group col-md-6">
                                            <label for="fullname"><?= $this->lang->line("Last name")?></label>
                                            <input class="form-control" type="text" id="lastname" name = "lastname" placeholder='<?= $this->lang->line("Enter your last name")?>' required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="username"><?= $this->lang->line("Username")?></label>
                                            <input class="form-control" type="text" id="username" name = "username" placeholder='<?= $this->lang->line("Enter your username")?>' required>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="emailaddress"><?= $this->lang->line("Email address")?></label>
                                            <input class="form-control" type="email" id="emailaddress" name = "emailaddress" required placeholder='<?= $this->lang->line("Enter your email")?>'>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="password">Password</label>
                                            <input class="form-control" type="password" required id="password" name="password" placeholder='<?= $this->lang->line("Enter your password")?>'>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="password"><?= $this->lang->line("Confirm Password")?></label>
                                            <input class="form-control" type="password" data-parsley-equalto="#password" required id="confirm_password" name="confirm_password" placeholder='<?= $this->lang->line("Confirm your password")?>'>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="password"><?= $this->lang->line("Country")?></label>
                                        <select class="form-control" required id="country" name="country">
                                            <option value=""><?= $this->lang->line("Select Country")?></option>
                                            <?php
                                                foreach ($country as $key => $value) {
                                                    echo '<option value="'.$value->countryname.'">'.$value->countryname.'</option>';
                                                }
                                            ?>
                                        </select>
                                    </div>
                                    
                                    <!-- <div class="g-recaptcha" data-sitekey="<?php echo $this->config->item('google_key') ?>"></div>  -->
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="checkbox-signup" required>
                                            <label class="custom-control-label" for="checkbox-signup"><?= $this->lang->line("I accept")?> <a href="javascript: void(0);" class="text-dark"><?= $this->lang->line("Terms and Conditions")?></a></label>
                                        </div>
                                    </div>
                                    
                                    <?php echo $this->session->flashdata('msg');?></p>
                                    <div class="form-group mb-0 text-center">
                                        <button class="btn btn-primary btn-block" type="submit"> <?= $this->lang->line("Sign up")?> </button>
                                    </div>

                                </form>

                            </div> <!-- end card-body -->
                        </div>
                        <!-- end card -->

                        <div class="row mt-3">
                            <div class="col-12 text-center">
                                <p class="text-muted"><?= $this->lang->line("Already have account")?>  <a href="<?php echo site_url('login');?>" class="text-dark ml-1"><b><?= $this->lang->line("Sign In")?></b></a></p>
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

        <!-- Validation js (Parsleyjs) -->
        <script src="<?php echo base_url('assets/template/libs/parsleyjs/parsley.min.js');?>"></script>

        <!-- validation init -->
        <script src="<?php echo base_url('assets/template/js/pages/form-validation.init.js');?>"></script>

        <!-- My script file -->
        <script src="<?php echo base_url('assets/template/js/myscript.js');?>"></script>

        
        
    </body>
</html>