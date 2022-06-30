        <!-- Topbar Start -->
        <div class="navbar-custom <?= $this->session->userdata('id')== 1 ? 'navbar-custom-dark' : '' ?>">

            <!-- LOGO -->
            <div class="logo-box">
                <?php
                    if($myRestDetail->rest_logo!=""){
                        $logo=$myRestDetail->rest_logo;
                    }else{
                        $logo="";
                    }
                ?>
                <a href="<?= base_url('main/$rest_url_slug')?>" class="logo text-center">
                    <span class="logo-lg">
                        <img src="<?= base_url('assets/rest_logo/').$logo?>" alt="" height="35">
                        <!-- <span class="logo-lg-text-light">Xeria</span> -->
                    </span>
                    <span class="logo-sm">
                        <!-- <span class="logo-sm-text-dark">X</span> -->
                        <img src="<?= base_url('assets/rest_logo/').$logo?>" alt="" height="24">
                    </span>
                </a>
            </div>

            <ul class="list-unstyled topnav-menu topnav-menu-left m-0">
                <li>
                    <button class="button-menu-mobile disable-btn waves-effect">
                        <i class="fe-menu"></i>
                    </button>
                </li>

                <li>
                    <h4 class="page-title-main"><?= $customer ? "Welcome ". $customer->customer_name : "<span class='text-danger h5'>Please add your profile by clicking <a class='' href='".base_url('Customer/account')."'>here...</a></span>" ?></h4>
                    
                </li>
            </ul>
        </div>

        <section class=" lgblueBck navbar-custom " data-url="<?= base_url("/")?>" data-mode="<?= isset($menu_mode) ? $menu_mode : "" ?>" style="height:70px;padding: 0;">
            <div class="rounded-0" style="background :white;">
                <div class="row container mx-auto px-0 hide-field">
                    <div class="col-sm-8 col-6">
                        <?php
                        if($myRestDetail->rest_logo!=""){
                            $logo=$myRestDetail->rest_logo;
                        }else{
                            $logo="";
                        }
                        ?>
                        <a class="navbar-brand" href="<?=base_url("main/$rest_url_slug")?>"><img src="<?=base_url('assets/rest_logo/').$logo?>" alt="" class="img-fluid p-2 W751" ></a>
                    </div>
                    <div class="col-sm-4 col-6 d-flex justify-content-end">
                        <!-- modify by Jfrost small changes -->
                        <a class="navbar-brand d-flex align-items-center justify-content-center" href="<?=base_url("main/$rest_url_slug")?>" style="float:right"><img src="<?=base_url('assets/web_assets/')?>images/restrologo.png" class="img-fluid" style="height:25px;"></a>
                    </div>
                </div>
                <div class="row mx-auto px-3">
                    <?php
                        if (isset($myRestDetail)){
                            if($myRestDetail->rest_logo!=""){
                                $logo = $myRestDetail->rest_logo;
                            }else{
                                $logo = "";
                            }
                        }else{
                            $logo = "";
                        }
                    ?>
                    <div class="d-flex d-sm-none hide-on-website mx-auto">
                        <button class="button-menu-mobile disable-btn waves-effect" style="position: absolute;left: 10px; ">
                            <i class="mdi mdi-dots-vertical"></i>
                        </button>
                        <a class="nav-link p-1" href="#"  role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="position: absolute;right: 10px; top: 17px;">
                        <span><i class="fa fa-align-justify"></i></span>
                        </a>
                        <!-- Dropdown - User Information -->
                        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                            <a class="dropdown-item " href="<?= base_url("main/").$rest_url_slug."/$iframe"?>"> HOME</a>
                            <a class="dropdown-item " href="<?= base_url("view/").$rest_url_slug."/$iframe"?>"> FOOD MENU</a>
                            <a class="dropdown-item " href="<?= base_url("reservation/").$rest_url_slug."/$iframe"?>"> RESERVATION</a>
                            <!-- <a class="dropdown-item " href="<?= base_url("help/").$rest_url_slug."/$iframe"?>"> HELP</a> -->
                            <!-- <a class="dropdown-item "> REVIEWS</a> -->
                            <a class="dropdown-item " href="<?= base_url("contactus/").$rest_url_slug."/$iframe"?>"> CONTACT</a>
                            <div class="dropdown-divider"></div>
                            <!-- <a class="dropdown-item " class = "login" href="<?= base_url("/")?>"> LOGIN/REGISTER</a> -->
                            <?php if (null !== $this->session->userdata("customer_Data")) {?>
                                <a class="dropdown-item" href="<?= base_url("Customer/dashboard")?>"> Dashboard</a>
                            <?php }else{ ?>
                            <a class="dropdown-item customerlogin"> LOGIN/REGISTER</a>
                            <?php }?>
                        </div>
                        <a class="navbar-brand" href="<?=base_url("main/$rest_url_slug")?>"><img src="<?=base_url('assets/rest_logo/').$logo?>" alt="" class="img-fluid p-2" width="100"></a>
                    </div>
                    <div class="d-sm-flex d-none align-items-center col-sm-12 justify-content-between">
                        <a class="navbar-brand" href="<?=base_url("main/$rest_url_slug")."/$iframe"?>"><img src="<?=base_url('assets/rest_logo/').$logo?>" alt="" class="img-fluid p-2" width="150"></a>
                        <div class="nav-items-links">
                            <a class="nav-item-link btn" href="<?= base_url("main/").$rest_url_slug."/$iframe"?>"> HOME</a>
                            <a class="nav-item-link btn" href="<?= base_url("view/").$rest_url_slug."/$iframe"?>"> FOOD MENU</a>
                            <a class="nav-item-link btn" href="<?= base_url("reservation/").$rest_url_slug."/$iframe"?>"> RESERVATION</a>
                            <!-- <a class="nav-item-link btn" href="<?= base_url("help/").$rest_url_slug."/$iframe"?>"> HELP</a> -->
                            <!-- <a class="nav-item-link btn"> REVIEWS</a> -->
                            <a class="nav-item-link btn" href="<?= base_url("contactus/").$rest_url_slug."/$iframe"?>"> CONTACT</a>
                        </div>
                        <div class="justify-content-end pl-0 d-none d-sm-flex pr-4 show-on-website">
                            <ul class="lang-setting d-flex align-items-center">
                                <!-- Nav Item - User Information -->
                                <li class="nav-item dropdown no-arrow">
                                    <a class="nav-link p-1" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <!-- modify by Jfrost rest-->
                                        <?php
                                            if ($site_lang == "english"){?>
                                                <img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/en-flag.png')?>">
                                                <?php 
                                            }elseif ($site_lang == "germany"){?>
                                                <img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/ge-flag.png')?>">
                                                <?php 
                                            }else{?>
                                                <img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/fr-flag.png')?>">
                                            <?php }
                                        ?>
                                        <!-- ------------------ -->
                                    </a>
                                    <!-- Dropdown - User Information -->
                                    <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                        <!-- remove hide-field -->
                                        <a class="dropdown-item french-flag" onclick = "change_language('<?= base_url('api/change_lang') ?>','french')">
                                            <img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/fr-flag.png')?>">
                                            French
                                        </a>
                                        <div class="dropdown-divider french-flag"></div>
                                        <a class="dropdown-item germany-flag" onclick = "change_language('<?= base_url('api/change_lang') ?>','germany')">
                                            <img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/ge-flag.png')?>">
                                            Germany
                                        </a>
                                        <div class="dropdown-divider germany-flag"></div>
                                        <a class="dropdown-item english-flag" onclick = "change_language('<?= base_url('api/change_lang') ?>','english')">
                                            <img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/en-flag.png')?>">
                                            English
                                        </a>
                                    </div>
                                </li>
                            </ul>
                            <?php
                                if (isset($menu_mode)){
                                    if ($menu_mode == "table"){ ?>
                                        <div class="d-flex align-items-center justify-content-center text-danger ml-2 wishlist-icon">
                                            <a class="text-danger to-wishlist-page" href="<?= base_url('Home/wishList')."/$rest_url_slug/$iframe"?>" data-href="<?= base_url('Home/wishList')."/$rest_url_slug/$iframe"?>">
                                                <span>
                                                    <i class="fa fa-heart"></i>
                                                </span>
                                            </a>
                                        </div>
                                <?php
                                    }else{ ?>
                                        <div class="d-flex align-items-center justify-content-center text-danger ml-2 wishlist-icon">
                                            <a class="text-danger to-wishlist-page" href="<?= base_url('Home/cart')."/$rest_url_slug/$menu_mode/$iframe"?>" data-href="<?= base_url('Home/cart')."/$rest_url_slug/$menu_mode/$iframe"?>">
                                                <span>
                                                    <i class="fa fa-shopping-cart"></i>
                                                </span>
                                            </a>
                                        </div>
                                <?php
                                    }
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- end Topbar -->
        