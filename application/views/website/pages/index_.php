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
        <div hidden>
            <section class="lgblueBck">
                <div class="backImg ">
                    <nav class="navbar navbar-expand-lg container navbar-light">
                        <a class="navbar-brand" href="<?=base_url()?>"><img src="<?=base_url('assets/web_assets/')?>images/White-Logo.png" class="img-fluid"></a>
                        <!-- modify by Jfrost index-->
                        <ul class="lang-setting">
                            <!-- Nav Item - User Information -->
                            <li class="nav-item dropdown no-arrow">
                                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <!-- modify by Jfrost index-->
                                    <?php
                                        if ($this->session->userdata('site_lang') == "germany"){?>
                                            <img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/ge-flag.png')?>">
                                            <?php 
                                        }elseif ($this->session->userdata('site_lang') == "french"){?>
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
                        <!-- ------------------- -->
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>

                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav margAuto">
                                <li class="nav-item active">
                                <a class="nav-link" href="#">Home </a>
                                </li>
                                <li class="nav-item">
                                <a class="nav-link" href="#">Function</a>
                                </li>
                                <li class="nav-item">
                                <a class="nav-link" href="#">Prizes</a>
                                </li>
                                <li class="nav-item">
                                <a class="nav-link" href="#">Support</a>
                                </li>
                                <!-- <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Dropdown
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="#">Action</a>
                                    <a class="dropdown-item" href="#">Another action</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="#">Something else here</a>
                                </div>
                                </li> -->

                            </ul>

                            <div class="form-inline my-2 my-lg-0">
                                <?php
                                if($this->session->userdata('rest_user_Data')){
                                    ?>
                                    <a href="<?=base_url('Restaurant')?>" class="btn whiteBtn">Dashboard</a>
                                    <?php
                                }else{
                                    ?>
                                    <button class="btn whiteBtn login" type="submit">LOG IN</button>
                                    <?php
                                }
                                ?>
                                
                            </div>
                        </div>
                    </nav>
                    <nav>

                    </nav>
                    <div class="text-center mt-3">
                        <div class=" text-white p-2">
                            <h1 class="fnt700 mb-3 HiyT">Your Digital Menu</h1>
                            <span>Turn your restaurant, cafe or bistro into a virus-proof <br>zone and digital your menu</span>

                        </div>
                        <div class="">
                            <img src="<?=base_url('assets/web_assets/')?>images/Slider-Phone.png" class="img-fluid W30 marg_btm">
                        </div>
                    </div>
                </div>
                <div class="p-5 my-5">
                    <div class="TopHd text-center">
                        <span>KNOW THIS FIRST</span>
                        <h2 class="fnt700">As a restauranteur you benefit from<br> the <span class="">web menu</span></h2>
                    </div>
                </div>
            </section>
        
        
            <section class="container w_50 margAuto">
                <div class="row">
                    <div class="col-md-6 mt-4 ">
                    <div class="TexT_Lft">
                        <div class="mnuHedBox">
                            <img src="<?=base_url('assets/web_assets/')?>images/Professionalism.png" class="img-fluid">
                        </div>
                        <div class="">
                            <h5 class="fnt700">Professionalism</h5>
                            <p class="MnuHed_p">Get a new, high-quality designed website that's right for your business, including the text and images of your choice. Convince your customers with a professional online presence.</p>
                        </div>
                    </div>
                    </div>
                    <div class="col-md-6 mt-4 ">
                    <div class="TexT_Lft">
                        <div class="mnuHedBox">
                            <img src="<?=base_url('assets/web_assets/')?>images/Discount.png" class="img-fluid">
                        </div>
                        <div class="">
                            <h5 class="fnt700">Additional Discounts</h5>
                            <p class="MnuHed_p">Take advantage of discounts on catering supplies, work clothes, menus, canvases and much more…</p>
                        </div>
                    </div>
                    </div>
                    <div class="col-md-6 mt-4 ">
                    <div class="TexT_Lft">
                        <div class="mnuHedBox">
                            <img src="<?=base_url('assets/web_assets/')?>images/No-Entry-Fee.png" class="img-fluid">
                        </div>
                        <div class="">
                            <h5 class="fnt700">No Entry Fee</h5>
                            <p class="MnuHed_p">You pay 39 euros / month (can be canceled monthly)</p>
                        </div>
                    </div>
                    </div>
                    <div class="col-md-6 mt-4 ">
                    <div class="TexT_Lft">
                        <div class="mnuHedBox">
                            <img src="<?=base_url('assets/web_assets/')?>images/Corporate-Emails.png" class="img-fluid">
                        </div>
                        <div class="">
                            <h5 class="fnt700">Corporate Emails</h5>
                            <p class="MnuHed_p">included in our rates: 4 corporate emails, according to your wishes. Example: kontakt@domain.lu.</p>
                        </div>
                    </div>
                    </div>
                    <div class="col-md-6 mt-4 ">
                    <div class="TexT_Lft">
                        <div class="mnuHedBox">
                            <img src="<?=base_url('assets/web_assets/')?>images/Always-Up-to-date.png" class="img-fluid">
                        </div>
                        <div class="">
                            <h5 class="fnt700">Always Up To Date</h5>
                            <p class="MnuHed_p">You have the right to daily changes to your texts, menus, photos or other information.</p>
                        </div>
                    </div>
                    </div>
                    <div class="col-md-6 mt-4 ">
                    <div class="TexT_Lft">
                        <div class="mnuHedBox">
                            <img src="<?=base_url('assets/web_assets/')?>images/Menu-online.png" class="img-fluid">
                        </div>
                        <div class="">
                            <h5 class="fnt700">Safety</h5>
                            <p class="MnuHed_p">Your site will be hosted on our servers to ensure daily backups of all sites. Hacker and other attacks are fine!</p>
                        </div>
                    </div>
                    </div>
                </div>
                <div class="text-center my-5">
                    <a href=""><button class="btn redBtn">Read More</button></a>
                </div>
            </section> 
            <?php if($this->session->userdata('rest_user_Data')): ?>
            <section class="container w_50 margAuto">
                <div class="row">
                    <div class="col-md-6  offset-md-3 mt-4 ">
                    <div class="TexT_Lft">
                        <div class="mnuHedBox">
                            Scan Our Qr Code View Our Menu
                            <div id="divqrcode"></div> 
                        </div>
                        
                    </div>
                    </div>
                    
                    
                </div>
                
            </section>  
            <?php 
                $seSData=unserialize($this->session->userdata('rest_user_Data')); 
            ?>
            <script type="text/javascript">  
                
                $('#divqrcode').qrcode({
                text:"<?=base_url('Home/viewMenu/').$seSData[0]->rest_id?>"
                });

                </script>
            <?php endif;?>

        
            <section class="lgblueBck py-5">
                <div class="TopHd text-center mb-5">
                    <span>KNOW THIS FIRST</span>
                    <h2 class="fnt700">Some of the best features</h2>
                </div>
                <div class="container">
                    <div class="row">
                    <div class="col-md-6">
                        <div class="">
                        <div id="accordion" class="myaccordion">
                <div class="card">
                    <div class="card-header p-0" id="headingOne">
                    <h2 class="mb-0">
                        <button class="d-flex align-items-center text_P justify-content-between btn btn-link  py-2 px-4" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                        <div class="text-left"><img src="<?=base_url('assets/web_assets/')?>images/Pocket-Friendly-Prise.png" class="img-fluid w-25">Pocket Friendly Price</div>
                        <span class="fa-stack fa-sm">
                            <i class="fas fa-circle fa-stack-2x"></i>
                            <i class="fas fa-plus fa-stack-1x fa-inverse"></i>
                        </span>
                        </button>
                    </h2>
                    </div>
                    <div id="collapseOne" class="collapse backcolblue text-white show" aria-labelledby="headingOne" data-parent="#accordion">
                    <div class="card-body">
                        <ul>
                        <li>Computer Science</li>
                        <li>Economics</li>
                        <li>Sociology</li>
                        <li>Nursing</li>
                        <li>English</li>
                        </ul>
                    </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header p-0" id="headingTwo">
                    <h2 class="mb-0">
                        <button class="d-flex align-items-center text_P justify-content-between btn btn-link py-2 px-4 collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        <div class="text-left"><img src="<?=base_url('assets/web_assets/')?>images/Always-Up-to-date-features.png" class="img-fluid w-25">Always Up to date!</div>
                        <span class="fa-stack fa-2x">
                            <i class="fas fa-circle fa-stack-2x"></i>
                            <i class="fas fa-plus fa-stack-1x fa-inverse"></i>
                        </span>
                        </button>
                    </h2>
                    </div>
                    <div id="collapseTwo" class="collapse backcolblue text-white" aria-labelledby="headingTwo" data-parent="#accordion">
                    <div class="card-body">
                        <ul>
                        <li>Informatics</li>
                        <li>Mathematics</li>
                        <li>Greek</li>
                        <li>Biostatistics</li>
                        <li>English</li>
                        <li>Nursing</li>
                        </ul>
                    </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header p-0" id="heading3">
                    <h2 class="mb-0">
                        <button class="d-flex align-items-center text_P justify-content-between btn btn-link py-2 px-4 collapsed" data-toggle="collapse" data-target="#collapse3" aria-expanded="false" aria-controls="collapse3">
                        <div class="text-left"><img src="<?=base_url('assets/web_assets/')?>images/Menu-online.png" class="img-fluid w-25"> Menu online!</div>
                        <span class="fa-stack fa-2x">
                            <i class="fas fa-circle fa-stack-2x"></i>
                            <i class="fas fa-plus fa-stack-1x fa-inverse"></i>
                        </span>
                        </button>
                    </h2>
                    </div>
                    <div id="collapse3" class="collapse backcolblue text-white" aria-labelledby="heading3" data-parent="#accordion">
                    <div class="card-body">
                        <ul>
                        <li>Informatics</li>
                        <li>Mathematics</li>
                        <li>Greek</li>
                        <li>Biostatistics</li>
                        <li>English</li>
                        <li>Nursing</li>
                        </ul>
                    </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header p-0" id="heading4">
                    <h2 class="mb-0">
                        <button class="d-flex align-items-center text_P justify-content-between btn btn-link py-2 px-4 collapsed" data-toggle="collapse" data-target="#collapse4" aria-expanded="false" aria-controls="collapse4">
                        <div class="text-left"><img src="<?=base_url('assets/web_assets/')?>images/Discount.png" class="img-fluid w-25">Useful discount!</div>
                        <span class="fa-stack fa-2x">
                            <i class="fas fa-circle fa-stack-2x"></i>
                            <i class="fas fa-plus fa-stack-1x fa-inverse"></i>
                        </span>
                        </button>
                    </h2>
                    </div>
                    <div id="collapse4" class="collapse backcolblue text-white" aria-labelledby="heading4" data-parent="#accordion">
                    <div class="card-body">
                        <ul>
                        <li>Informatics</li>
                        <li>Mathematics</li>
                        <li>Greek</li>
                        <li>Biostatistics</li>
                        <li>English</li>
                        <li>Nursing</li>
                        </ul>
                    </div>
                    </div>
                </div>
                
                </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="fsaaOO">
                        <img src="<?=base_url('assets/web_assets/')?>images/Multi-mobile-card.png" class="img-fluid W75">
                        </div>
                    </div>
                    </div>
                </div>
            </section> 
            <section class="container py-5 my-4">
                <div class="TopHd text-center mb-5">
                    <span>YOUR DIGITAL MENU</span>
                    <h2 class="fnt700">ONLY once 35.10 euros!</h2>
                    <span class="">(VAT included)</span>
                </div>
                <div class="row">
                    <div class="col-md-4">
                    <div class="TexT_Rgt mt-3">
                        <div class="mnuHedBox">
                            <img src="<?=base_url('assets/web_assets/')?>images/QR-Code.png" class="img-fluid">
                        </div>
                        <div class="">
                            <h5 class="fnt700">Callable with QR code</h5>
                            <p class="MnuHed_p">Your digital menu can be easily accessed using a QR code or web address.</p>
                        </div>
                    </div>
                    <div class="TexT_Rgt mt-3">
                        <div class="mnuHedBox">
                            <img src="<?=base_url('assets/web_assets/')?>images/Clear-Design.png" class="img-fluid">
                        </div>
                        <div class="">
                            <h5 class="fnt700">Clear design</h5>
                            <p class="MnuHed_p">Your digital menu is very clear and can also be filtered by categories. The search for a court is also possible.</p>
                        </div>
                    </div>
                    <div class="TexT_Rgt mt-3">
                        <div class="mnuHedBox">
                            <img src="<?=base_url('assets/web_assets/')?>images/Quick-Changes.png" class="img-fluid">
                        </div>
                        <div class="">
                            <h5 class="fnt700">Quick changes</h5>
                            <p class="MnuHed_p">You can edit or deactivate your dishes yourself quickly and easily.</p>
                        </div>
                    </div>
                    </div>
                    <div class="col-md-4">
                    <div class="">
                    <img src="<?=base_url('assets/web_assets/')?>images/Middle-Phone.png" class="img-fluid">
                    </div>
                    </div>
                    <div class="col-md-4">
                    <div class="TexT_Lft mt-3">
                        <div class="mnuHedBox">
                            <img src="<?=base_url('assets/web_assets/')?>images/Multilingual.png" class="img-fluid">
                        </div>
                        <div class="">
                            <h5 class="fnt700">Multilingual</h5>
                            <p class="MnuHed_p">We offer you the opportunity to offer your digital menu in several languages.</p>
                        </div>
                    </div>
                    <div class="TexT_Lft mt-3">
                        <div class="mnuHedBox">
                            <img src="<?=base_url('assets/web_assets/')?>images/Image-of-the-court.png" class="img-fluid">
                        </div>
                        <div class="">
                            <h5 class="fnt700">Image of the court</h5>
                            <p class="MnuHed_p">You can add a picture for each dish. (but do not have to)</p>
                        </div>
                    </div>
                    <div class="TexT_Lft mt-3">
                        <div class="mnuHedBox">
                            <img src="<?=base_url('assets/web_assets/')?>images/Responsive.png" class="img-fluid">
                        </div>
                        <div class="">
                            <h5 class="fnt700">Responsive</h5>
                            <p class="MnuHed_p">Your website always adapts perfectly to any mobile device and is therefore always easy to read.</p>
                        </div>
                    </div>
                    </div>
                </div>
                <div class="text-center my-5">
                    <a href=""><button class="btn redBtn">Learn More</button></a>
                </div>
            </section>


            <section class="backcolRd py-5">
                <div class="container px-5">
                    <div class="text-white text-center mb-5">
                    <span>CONTACT US</span>
                    <h2 class="fnt700">Request A Quick Quote</h2>
                    </div>
                    <form class="w-100">    
                    <div class="row">
                        <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" class="form-control inpt" placeholder="Enter Name" name="" required="">
                        </div>
                        </div>
                        <div class="col-md-6">
                        <div class="form-group">
                            <input type="email" class="form-control inpt" placeholder="Enter Email" name="" required="">
                        </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" class="form-control inpt" placeholder="Enter Subject" name="" >
                        </div>
                        </div>
                        <div class="col-md-6">
                        <div class="form-group">
                            <input type="tel" class="form-control inpt" placeholder="Enter Phone" name="" >
                        </div>
                        </div>
                    </div>
                    <div class="">
                        <textarea placeholder="Enter Message" class="w-100 " rows="5"></textarea>
                    </div>
                    <div class="text-center my-4">
                        <button class="btn whiteBtn">GET A QUOTE</button>
                    </div>
                    </form>
                </div>  
            </section>


            <section class="container py-5">
                <div class="row">
                <div class="col-md-3">
                    <div class="">
                    <div class="">
                        <img src="<?=base_url('assets/web_assets/')?>images/Color-Logo.png" class="img-fluid">
                    </div>
                        <div class="mt-3 ml-4">
                        <h5 class="">(+352) 486886</h5>
                        <small>info@restopage.eu</small><br>
                        <small>16, Grand-Rue</small><br>
                        <small>L-6630 Wasserbillig</small>
                        </div>
                        <div class="ml-3 mt-2">
                        <ul class="list-unstyled d-flex m-0">
                            <li>
                            <span class="">
                                <a href=""><img src="<?=base_url('assets/web_assets/')?>images/Facebook-Icon.png" class="img-fluid"></a>
                            </span>
                            </li>
                            <li>
                            <span class="">
                                <a href=""><img src="<?=base_url('assets/web_assets/')?>images/Pintrest.png" class="img-fluid"></a>
                            </span>
                            </li>
                            <li>
                            <span class="">
                                <a href=""><img src="<?=base_url('assets/web_assets/')?>images/Instagram.png" class="img-fluid"></a>
                            </span>
                            </li>
                            <li>
                            <span class="">
                                <a href=""><img src="<?=base_url('assets/web_assets/')?>images/Twitter.png" class="img-fluid"></a>
                            </span>
                            </li>
                        </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="_foothed">
                    <h5>Navigation</h5>
                    <div class="mt-4">
                        <ul class="list-unstyled m-0 p-0">
                        <li> 
                            <a href="">Search Listing</a>
                        </li>
                        <li> 
                            <a href="">FAQ</a>
                        </li>
                        <li> 
                            <a href="">Add listing</a>
                        </li>
                        <li> 
                            <a href="">Own website</a>
                        </li>
                        </ul>
                    </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="_foothed">
                    <h5>Legal</h5>
                    <div class="mt-4">
                        <ul class="list-unstyled m-0 p-0">
                        <li> 
                            <a href="">Imprints</a>
                        </li>
                        <li> 
                            <a href="">Terms and Conditions</a>
                        </li>
                        <li> 
                            <a href="">Privacy & Policy</a>
                        </li>
                    
                        </ul>
                    </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="_foothed">
                    <h5>Latest News</h5>
                    <div class="mt-4">
                        <ul class="list-unstyled m-0  p-0">
                        <li class="diBLin"> 
                            <div class="">
                            <span class="">The Best in digital card Services in the world.</span><br>
                            <small>Date</small>
                            </div>
                        </li>
                        <li class="diBLin"> 
                            <div class="">
                            <span class="">The Best in digital card Services in the world.</span><br>
                            <small>Date</small>
                            </div>
                        </li>
                        
                    
                        </ul>
                    </div>
                    </div>
                </div>
                </div>
            </section>
            
            <section class="text-center text-white backcolRd py-3">
                <span>Copyright 2020 © TopRestro. All Right Reserved.</span>
            </section>
        </div>
        <!-- Modal -->
        <!-- <div id="loginModal" class="modal fade" role="dialog"> -->
        <div id="loginModal" class="" role="dialog" style = "z-index: 1050">
            <div class="modal-dialog">
            <img src="<?= base_url("assets/web_assets/images/restrologo.png") ?>" class="img-fluid d-flex mx-auto " style="width:30%; margin-bottom: 60px; margin-top: 30px;">
            <!-- Modal content-->
                <div class="row mb-5">
                    <div class="modal-left col-md-7">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title"><?= $this->lang->line("Restaurant Log In")?></a></h4>
                                <hr>
                                <!-- <button type="button" class="close" data-dismiss="modal">&times;</button> -->
                                
                            </div>
                            <div class="modal-body">
                                <form action="<?=base_url('API/resLoginValidate')?>" method="post">
                                    <div class="form-group row">
                                        <div class="col-sm-12 mb-3 mb-sm-0">
                                            <input type="email" class="form-control form-control-user" id="rest_email" placeholder="Enter your email.." name="rest_email" value="">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-12 mb-3 mb-sm-0">
                                            <input type="password" class="form-control form-control-user" id="rest_pass" placeholder="password.." name="rest_pass" value="">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-3 offset-md-9 mb-3 mb-sm-0 ">
                                            <input type="submit" class="form-control form-control-user btn btn-danger text-white"  name="subcat_name" value="Log In">
                                        </div>
                                    </div>
                                </form>
                                <div class="modal-footer justify-content-between">
                                    <a href="<?= base_url("Home/forgot")?>"><?= $this->lang->line("Forgot Password")?>?</a>
                                    <a href="<?= base_url("Home/register")?>"><?= $this->lang->line("New? Register Here")?>..</a>
                                </div>
                            </div>  
                        </div>
                    </div>
                    <div class="model-right col-md-5 d-none d-md-block" style="pointer-events: auto;">
                        <div class="text-center">
                            <h5 class="mt-5 my-2"> <?= $this->lang->line("New User")?> ?</h5>    
                            <a href = "<?= base_url("Home/register")?>" class="btn w-100 btn-info my-2" style="color:white; background: #00c2ff;"> <?= $this->lang->line("Register here")?> </a>    
                            <p class= "text-uppercase my-5 text-bold" style="color:#00c2ff; font-size: 24px;"> <b><?= $this->lang->line("Free Registration")?> </b></p>
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
        <!-- <div id="qRcode"></div> -->

    <script type="text/javascript">
    $("#accordion").on("hide.bs.collapse show.bs.collapse", e => {
    $(e.target)
        .prev()
        .find("i:last-child")
        .toggleClass("fa-minus fa-plus");
        });
        $(document).on('click','.login',function(){
        $('#loginModal').modal('show');
        });
        $(document).on('submit','#loginForm',function(e){
        e.preventDefault();
        var formData= new FormData($(this)[0]);
        $.ajax({
            url:"<?=base_url('API/resLoginValidate')?>",
            type:"post",
            cache:false,
            contentType:false,
            processData:false,
            data:formData,
            success:function(response){
            console.log(response);
            }
        });
        });

    </script>
    <!-- modify by Jfrost index-->
    <script src="<?=base_url('assets/additional_assets/')?>js/myscript.js"></script>
    <!-- ---------------- -->
    </body>
    </html>