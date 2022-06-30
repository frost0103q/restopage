    <!-- modify by Jfrost -->

    <div class="row container mx-auto">
        <div class="main-wrap col-md-8 p-0 pb-sm-5 mx-auto">
            <section class="my-5">
                <div class="d-flex justify-content-center">
                    <span class="text-center j-blue-color jc-food_menu_heading"><h3><?=$this->lang->line("Please Choose")?></h3></span>
                    
                </div>
            </section>
            <!-- ------------------- -->
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
                    $url_surfix = "?lang="."fr";
                }
            ?>
            <div class="tab-content pb-5 row">
                <?php if($myRestDetail->resto_plan !== "pro" || ($myRestDetail->resto_plan == "pro" && $myRestDetail->ontable_show)){ ?>
                    <div class="col-lg-4 p-2 <?= $is_dp_choose_page ? "hide-field" : "" ?>">
                        <a class="choose-menu-card text-center p-4 btn w-100 jc-food_menu_big_tabs " href = "<?= base_url("onTable/").$rest_url_slug."/".$iframe. $url_surfix ?>">
                            <h4 class="choose-menu-title mb-4"><?=$this->lang->line("Food")?> <?=$this->lang->line("Menu")?></h4>
                            <img class="choose-menu-icon" src="<?=base_url("assets/additional_assets/img/")."foodmenu_icon.svg"?>">
                            <!-- <p class="choose-menu-desc"><?=$this->lang->line("Please click this button")?>,</p> -->
                            <p class="choose-menu-desc"><?=$this->lang->line("You want to eat in Restaurant")?></p>
                        </a>
                    </div>
                <?php } ?>
                <?php 
                    if($myRestDetail->dp_option > 0 && $myRestDetail->resto_plan == "pro"){
                        if($myRestDetail->dp_option == 1 ||  $myRestDetail->dp_option == 3){ 
                            if ($delivery_open) {?>
                            <div class="col-lg-<?= $is_dp_choose_page ? "6" : "4" ?> p-2">
                                <a class="choose-menu-card text-center p-4 btn w-100 jc-food_menu_big_tabs" href = "<?= base_url("Delivery/").$rest_url_slug."/".$iframe .$url_surfix?>">
                                    <h4 class="choose-menu-title mb-4"><?=$this->lang->line("Delivery")?></h4>
                                    <img class="choose-menu-icon" src="<?=base_url("assets/additional_assets/img/")."delivery_icon.svg"?>">
                                    <!-- <p class="choose-menu-desc"><?=$this->lang->line("Please click this button")?>,</p> -->
                                    <p class="choose-menu-desc"><?=$this->lang->line("You want the food delivered")?></p>
                                </a>
                            </div>
                            <?php }elseif($myRestDetail->pre_order == 1){ ?>
                            <div class="col-lg-<?= $is_dp_choose_page ? "6" : "4" ?> p-2">
                                <a class="choose-menu-card text-center p-4 btn w-100 bg-info" href = "<?= base_url("Delivery/").$rest_url_slug."/".$iframe. $url_surfix?>">
                                    <h4 class="choose-menu-title mb-4"><?=$this->lang->line("Delivery")?></h4>
                                    <img class="choose-menu-icon" src="<?=base_url("assets/additional_assets/img/")."delivery_icon.svg"?>">
                                    <p class="choose-menu-desc"><?=$this->lang->line("It was closed but pre order is available")?>.</p>
                                </a>
                            </div>
                            <?php }else{ ?>
                            <div class="col-lg-<?= $is_dp_choose_page ? "6" : "4" ?> p-2">
                                <div class="choose-menu-card text-center p-4 btn w-100 bg-warning">
                                    <h4 class="choose-menu-title mb-4"><?=$this->lang->line("Delivery")?></h4>
                                    <img class="choose-menu-icon" src="<?=base_url("assets/additional_assets/img/")."delivery_icon.svg"?>">
                                    <p class="choose-menu-desc"><?=$this->lang->line("It is not allowed to open this restaurant at this time")?>.</p>
                                </div>
                            </div>
                            <?php }
                        }
                        if($myRestDetail->dp_option == 2 ||  $myRestDetail->dp_option == 3){ 
                            if ($pickup_open) {?>
                            <div class="col-lg-<?= $is_dp_choose_page ? "6" : "4" ?> p-2">
                                <a class="choose-menu-card text-center p-4 btn w-100 jc-food_menu_big_tabs" href = "<?= base_url("Pickup/").$rest_url_slug."/". $url_surfix?>">
                                    <h4 class="choose-menu-title mb-4"><?=$this->lang->line("Pickup")?></h4>
                                    <img class="choose-menu-icon" src="<?=base_url("assets/additional_assets/img/")."takeaway_icon.svg"?>">
                                    <!-- <p class="choose-menu-desc"><?=$this->lang->line("Please click this button")?>,</p> -->
                                    <p class="choose-menu-desc"><?=$this->lang->line("You want to pickup the food")?></p>
                                </a>
                            </div>                            
                            <?php }elseif($myRestDetail->pre_order == 1){ ?>
                            <div class="col-lg-<?= $is_dp_choose_page ? "6" : "4" ?> p-2">
                                <a class="choose-menu-card text-center p-4 btn w-100 bg-info" href = "<?= base_url("Pickup/").$rest_url_slug."/".$iframe. $url_surfix?>">
                                    <h4 class="choose-menu-title mb-4"><?=$this->lang->line("Pickup")?></h4>
                                    <img class="choose-menu-icon" src="<?=base_url("assets/additional_assets/img/")."takeaway_icon.svg"?>">
                                    <p class="choose-menu-desc"><?=$this->lang->line("It was closed but pre order is available")?>.</p>
                                </a>
                            </div>
                            <?php }else{ ?>
                            <div class="col-lg-<?= $is_dp_choose_page ? "6" : "4" ?> p-2">
                                <div class="choose-menu-card text-center p-4 btn w-100 bg-warning">
                                    <h4 class="choose-menu-title mb-4"><?=$this->lang->line("Pickup")?></h4>
                                    <img class="choose-menu-icon" src="<?=base_url("assets/additional_assets/img/")."takeaway_icon.svg"?>">
                                    <p class="choose-menu-desc"><?=$this->lang->line("It is not allowed to open this restaurant at this time")?>.</p>
                                </div>
                            </div>
                            <?php }
                        }
                    }
                ?>
            </div>
        </div>
    </div>