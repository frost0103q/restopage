<!Doctype html>
    <html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
        <!-- modify by Jfrost load custom css-->
        <link href="<?=base_url('assets/additional_assets/')?>css/mystyle.css" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css2?family=Parisienne&family=Satisfy&display=swap" rel="stylesheet">
        <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
        <link rel="stylesheet" type="text/css" href="<?=base_url('assets/web_assets/')?>css/style.css">
        <title>Restaurant</title>
    </head>
    <body>
        <div class="login-register-form p-2 p-md-4">
            <div class="row">
                <div class="col-md-4 j-sign-in form-section">
                    <div class="row">
                        <form action="<?=base_url('API/resLoginValidate')?>" method="post" class="col-md-12" id="restaurant_login">
                            <div class="form-group">
                                <div class="mb-3 mb-sm-0 text-center">
                                    <h4 class="form-control form-title"><?= $this->lang->line("Restaurant Log In")?></h4>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="mb-3 mb-sm-0">
                                    <input type="email" class="form-control" id="rest_email" placeholder="Enter your email.." name="rest_email" value="">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="mb-3 mb-sm-0">
                                    <input type="password" class="form-control" id="rest_pass" placeholder="password.." name="rest_pass" value="">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="mb-3 mb-sm-0 ">
                                    <input type="submit" class="form-control btn login-form-btn-style text-white"  name="login" value="Log In">
                                </div>
                            </div>
                            <hr>
                            <div class="form-group d-flex justify-content-between">
                                <a href="<?= base_url("Home/forgot")?>"><?= $this->lang->line("Forgot Password")?>?</a>
                                <a href="<?= base_url("Home/register")?>"><?= $this->lang->line("New? Register Here")?>..</a>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-md-4 j-sign-up form-section">
                    <div class="row">
                        <form action="<?=base_url('API/resRegister')?>" method="post" id="restaurant_register" class="col-sm-12">
                            <div class="form-group">
                                <div class="mb-3 mb-sm-0 text-center">
                                    <h4 class="form-control form-title"><?= $this->lang->line("Restaurant")?> <?= $this->lang->line("Register")?></h4>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="mb-3 mb-sm-0">
                                    <input type="text" class="form-control"  placeholder="<?= $this->lang->line("Restaurant Name")?>" name="rest_name" value="" autocomplete="off" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="mb-3 mb-sm-0">
                                    <input type="email" class="form-control"  placeholder="<?= $this->lang->line("E-Mail")?>" name="rest_email" value="" autocomplete="off" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="mb-3 mb-sm-0">
                                    <input type="password" class="form-control"  placeholder="<?= $this->lang->line("Password")?>" name="rest_pass" value="" autocomplete="off" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="mb-3 mb-sm-0" >
                                    <input type="password" class="form-control"  placeholder="<?= $this->lang->line("Confirm Password")?>" name="rest_confirm_pass" autocomplete="off" value="" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="mb-3 mb-sm-0 small d-flex">
                                    <div class="mt-1 mr-2"><input type="checkbox" required></div>
                                    <div>I agree to the restopage Terms of Service and Privacy Policy</div>
                                    <!-- This site is protected by reCAPTCHA and the Google<a href="https://policies.google.com/privacy"> Privacy Policy </a> and <a href="https://policies.google.com/terms"> Terms of Service </a> apply. -->
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="mb-3 mb-sm-0 ">
                                    <input type="submit" class="form-control btn login-form-btn-style text-white"  name="Register" value="Register" required>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-md-4 j-why-us form-section">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="">
                                <div class="text-center">
                                    <h4 class="form-control text-white mb-0 border-0 form-title"><?= $this->lang->line("Why Us")?> ?</h4>
                                </div>
                                <div class="p-3 supported-packages">
                                    <ul>
                                        <li>✔ <?= $this->lang->line("Free Registration")?></li>
                                        <li>✔ <?= $this->lang->line("Free Website")?></li>
                                        <li>✔ <?= $this->lang->line("Free Support")?></li>
                                        <li>✔ <?= $this->lang->line("More Orders")?></li>
                                        <li>✔ <?= $this->lang->line("More Sales")?></li>
                                        <li>✔ <?= $this->lang->line("More Customers")?></li>
                                        <li>✔ <?= $this->lang->line("0% Commission")?></li>
                                        <li>✔ <?= $this->lang->line("Order System 10€ monthly")?></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-footer text-right">
                <p class="my-2"><em>The best solution for your restaurant</em></p>
                <img src="<?= base_url("assets/web_assets/images/White-Logo.png") ?>">
            
            </div>
        </div>

        <script>
            $(document).ready(function () {
                grecaptcha.ready(function() {
                    grecaptcha.execute('6LcQbNsaAAAAALyY3W-KNEpem4zuRZJOoah3uVTT', {action: 'restaurant_signup'}).then(function(token) {
                        $('#restaurant_register').prepend('<input type="hidden" name="g-recaptcha-response" value="' + token + '">');
                    });
                });
            });
        </script>
        <script src="https://www.google.com/recaptcha/api.js?render=6LcQbNsaAAAAALyY3W-KNEpem4zuRZJOoah3uVTT"></script>
        <script src="<?=base_url('assets/additional_assets/')?>js/myscript.js"></script>
    </body>
    </html>