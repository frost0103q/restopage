        <!-- ========== Left Sidebar Start ========== -->
        <div class="left-side-menu">

            <div class="slimscroll-menu">
                <?php 
                    if ($this->session->userdata('site_lang')){
                        $_lang = $this->session->userdata('site_lang');
                    }else{
                        $_lang = "french";
                    }
                    if ($_lang == "english"){
                        $url_surfix = "?lang="."en";
                    }elseif ($_lang == "germany"){
                        $url_surfix = "?lang="."de";
                    }else{
                        $url_surfix = "/?lang="."fr";
                    }
                ?>
                <!-- User box -->
                <div class="user-box text-center">
                    <i class="fa fa-user h2"></i>
                    <div class="dropdown">
                        <a href="#" class="text-dark dropdown-toggle h5 mt-2 mb-1 d-block" data-toggle="dropdown"><?= $customer ? $customer->customer_name : "customer" ?></a>
                    </div>
                    <p class="text-muted">role</p>
                    <ul class="list-inline">
                        

                        <li class="list-inline-item">
                            <a href="<?php echo base_url('Customer/logout');?>" class="text-custom">
                                <i class="mdi mdi-power"></i>
                            </a>
                        </li>
                    </ul>
                </div>

                <!--- Sidemenu -->
                <div id="sidebar-menu">

                    <ul class="metismenu" id="side-menu">

                        <li class="menu-title"><?= ('Navigation') ?></li>

                        <li>
                            <a href="<?= base_url('Customer/dashboard').$url_surfix ?>">
                                <i class="mdi mdi-view-dashboard"></i>
                                <span><?= ('Overview') ?></span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= base_url('Customer/myorders').$url_surfix ?>">
                                <i class="mdi mdi-library-books"></i>
                                <span><?= ('My Orders') ?></span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= base_url('Customer/account').$url_surfix ?>">
                                <i class="mdi mdi-account-edit"></i>
                                <span><?= ('Account Settings') ?></span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= base_url('Customer/loyaltyPoints').$url_surfix ?>">
                                <i class="mdi mdi-coins"></i>
                                <span><?= ('Loyalty Points') ?></span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= base_url('Customer/logout')?>">
                                <i class="mdi mdi-logout"></i>
                                <span><?= ('Sign Out') ?></span>
                            </a>
                        </li>
                    </ul>

                </div>
                <!-- End Sidebar -->
                <div class="sidebar-footer">
                    <p class="text-center mt-3"><em>Powered by</em></p>
                    <div class="logos-bar d-flex justify-content-between flex-column align-items-center">
                        <img src="<?= base_url("assets/additional_assets/svg/where2eatLogo.svg") ?>">
                        <img src="<?= base_url("assets/additional_assets/svg/machmichsatt.svg") ?>">
                        <img src="<?= base_url("assets/additional_assets/svg/easymeal.svg") ?>">
                    </div>
                </div>
                <div class="clearfix"></div>

            </div>
            <!-- Sidebar -left -->

        </div>
        <!-- Left Sidebar End -->