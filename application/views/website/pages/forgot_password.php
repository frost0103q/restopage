    <!doctype html>
    <html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
        
        <!-- modify by Jfrost load custom css-->
        <link href="<?=base_url('assets/additional_assets/')?>css/mystyle.css" rel="stylesheet" type="text/css">
        <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
        <style>  
            #divqrcode {  
                width: 102px;  
                height: 102px;  
                /*margin-top: 14px;  */
            }  
        </style> 
        <!-- <script src="Scripts/jquery-latest.min.js"></script>   -->
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.qrcode/1.0/jquery.qrcode.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
        <link rel="stylesheet" type="text/css" href="<?=base_url('assets/web_assets/')?>css/style.css">
        <title>Restaurant</title>
    </head>
    <body>
        <div id="forgotModal" class="" role="dialog" style = "z-index: 1050">
            <div class="modal-dialog">
                <img src="<?= base_url("assets/web_assets/images/restrologo.png") ?>" class="img-fluid d-flex mx-auto " style="width:30%; margin-bottom: 60px; margin-top: 30px;">
                <!-- Modal content-->
                <div class="row mb-5">
                    <div class="modal-left col-md-12">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title"><?= $this->lang->line("Restaurant Registration")?></h4>
                                <hr>
                                <!-- <button type="button" class="close" data-dismiss="modal">&times;</button> -->
                                
                            </div>
                            <div class="modal-body">
                                <form action="<?=base_url('API/forgotpassword')?>" method="post">
                                    <div class="form-group row">
                                        <div class="col-sm-12 mb-3 mb-sm-0">
                                            <input type="text" class="form-control form-control-user" id="rest_name" placeholder="<?= $this->lang->line("Restaurant Name")?>" name="rest_name" value="">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-12 mb-3 mb-sm-0">
                                            <input type="email" class="form-control form-control-user" id="rest_email" placeholder="<?= $this->lang->line("E-Mail")?>" name="rest_email" value="">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-5 offset-md-7 mb-3 mb-sm-0">
                                            <input type="submit" class="form-control form-control-user btn btn-danger text-white"  name="subcat_name" value="Send New Password">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <a href="<?= base_url("Home")?>"><?= $this->lang->line("Login Here")?></a>
                                    </div>
                                </form>
                            </div>  
                        </div>
                    </div>
                </div>
                <?php
                    if($this->session->flashdata('msg')){
                        echo $this->session->flashdata('msg');
                    }
                ?>
            </div>
        </div>
    <!-- modify by Jfrost index-->
    <script src="<?=base_url('assets/additional_assets/')?>js/myscript.js"></script>
    <!-- ---------------- -->
    </body>
    </html>