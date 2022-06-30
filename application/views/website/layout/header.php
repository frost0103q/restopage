<!DOCTYPE >
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>  -->
    <script type="text/javascript" src="<?=base_url('assets/additional_assets/jquery-ui-timepicker').'/include/jquery-1.9.0.min.js'?>"></script>

    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Parisienne&family=Satisfy&display=swap" rel="stylesheet">
   
    <link href="<?=base_url('assets/additional_assets/template/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css')?>" rel="stylesheet" type="text/css" />
    <link href="<?=base_url('assets/additional_assets/')?>css/chosen.css" rel="stylesheet" type="text/css" />
    <link href="<?=base_url('assets/additional_assets/')?>css/mobiscroll.jquery.min.css" rel="stylesheet" type="text/css" />
    <link href="<?=base_url('assets/additional_assets/')?>css/chosen.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="<?= base_url('assets/additional_assets/js')?>/mobiscroll.jquery.min.js"></script>
    <!-- modify by Jfrost load custom css-->
    <link href="<?=base_url('assets/additional_assets/')?>/css/nivo-slider.css" rel="stylesheet" type="text/css">
    <!-- modify by jfrost in 2nd stage -->
    <link href="<?=base_url('assets/additional_assets/wow-slider/')?>/engine1/style.css" rel="stylesheet" type="text/css">
    <!-- google map -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAVqwHQGAyMBx6u8BD_FMn1Qo3wSYvYflc&sensor=false&amp;libraries=places" type="text/javascript"></script>
    
    <?php if (isset($jquery_1_8_timepicker) && $jquery_1_8_timepicker == true){ ?>
        <!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/jquery-timepicker/1.8.9/jquery.timepicker.min.css" /> -->
        <link href="<?= base_url('assets/additional_assets/jquery-timepicker').'/jquery.1.8.9.timepicker.min.css'?>" rel="stylesheet">
    <?php }else{ ?>
        <link href="<?= base_url('assets/additional_assets/jquery-ui-timepicker').'/include/ui-1.10.0/ui-lightness/jquery-ui-1.10.0.custom.min.css'?>" rel="stylesheet">
        <link href="<?= base_url('assets/additional_assets/jquery-ui-timepicker').'/jquery.ui.timepicker.css'?>" rel="stylesheet">
    <?php } ?>
    <script>
    <?php
        if (isset($currentRestCurrencySymbol)){
            echo 'var cur_symbol = "'.$currentRestCurrencySymbol.'";';
        }else{
            echo 'var cur_symbol = "€";';
        }
    ?>
    </script>
    <link href="<?=base_url('assets/additional_assets/')?>/css/mystyle.css" rel="stylesheet" type="text/css">
    <!-- <script src="Scripts/jquery-latest.min.js"></script>   -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.qrcode/1.0/jquery.qrcode.min.js"></script>
    <script type="text/javascript" src="<?= base_url('assets/additional_assets/js')?>/sweetalert.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="<?=base_url('assets/web_assets/')?>css/style.css">
    <link rel="shortcut icon" type="image/jpg" href=""/>
    <?php
        if(isset($iframe) && $iframe == "iframe"){
            echo '<link rel="stylesheet" type="text/css" href="'. base_url('assets/additional_assets/').'css/iframe.css">';
        }
    ?>
    <?php
        $seo_header_content = "";
        $announcement_bg_color = "#FFFFFF";
        $announcement_bg_alpha = "1";
        if (isset($myRestId)){
            $seo_content = $this->db->where("seo_rest_id",$myRestId)->get("tbl_seo_settings")->row();
            $announcement = $this->db->where('rest_id' , $myRestId)->get('tbl_announcement')->row();
            if ($seo_content ){
                $header_content = "seo_header_content_" . $site_lang;
                $seo_header_content = isset($seo_content->$header_content) && ($seo_content->$header_content !== "") ? $seo_content->$header_content : $seo_content->seo_header_content; 
            }
            if($announcement){
                $announcement_bg_color =  $announcement->content_bg_color;
                $announcement_bg_alpha =  $announcement->content_bg_color_alpha;
            }
            $detail = $this->db->where("restaurant_id",$myRestId)->get("tbl_restaurant_details")->row();
            if ($rest_favicon = $detail->rest_favicon){
                echo '<link rel="shortcut icon" type="image/jpg" href="'.base_url('assets/rest_favicon/').$rest_favicon.'"/>';
            }
        }
    ?>
    <?= $seo_header_content ?>
    
    <?php 
        function percentToHex($p){
            $percent = max(0, min(100, $p)); // bound percent from 0 to 100
            $intValue = round($p / 100 * 255); // map percent to nearest integer (0 - 255)
            $hexValue = dechex($intValue); // get hexadecimal representation
            return str_pad($hexValue, 2, '0', STR_PAD_LEFT); // format with leading 0 and upper case characters
        }
        if (isset($myRestDetail)){
            $color_settings = json_decode($myRestDetail->color_settings);
            $font_settings = json_decode($myRestDetail->font_settings);
            $category_font_family = isset($font_settings->category_name_font_family) ? $font_settings->category_name_font_family : 'Parisienne' ;
        ?>

        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=<?=str_replace(" ","+",$category_font_family);?>" media="all">
        <style>
            body{
                color: <?=$color_settings->standard_color?><?=percentToHex( 100*$color_settings->standard_color_alpha)?>;
                background: <?=$color_settings->body_color?><?=percentToHex( 100*$color_settings->body_color_alpha)?>;
            }
            .jc-navigation{
                background: <?=$color_settings->navigation_bg_color?><?=percentToHex( 100*$color_settings->navigation_bg_color_alpha)?>;
            }
            .jc-menu{
                background: <?=$color_settings->menu_bg_color?><?=percentToHex( 100*$color_settings->menu_bg_color_alpha)?>;
                color: <?=$color_settings->menu_color?><?=percentToHex( 100*$color_settings->menu_color_alpha)?>;
            }
            .jc-loginbtn{
                background: <?=$color_settings->loginbtn_bg_color?><?=percentToHex( 100*$color_settings->loginbtn_bg_color_alpha)?>;
                color: <?=$color_settings->loginbtn_color?><?=percentToHex( 100*$color_settings->loginbtn_color_alpha)?>;
            }
            #wowslider-container1 .ws-title, #wowslider-container1 .ws-title p{
                color: <?=$color_settings->slider_color?><?=percentToHex( 100*$color_settings->slider_color_alpha)?>;
            }
            #wowslider-container1 .ws-title{
                background: <?=$color_settings->slider_bg_color?><?=percentToHex( 100*$color_settings->slider_bg_color_alpha)?>;
                color: <?=$color_settings->slider_color?><?=percentToHex( 100*$color_settings->slider_color_alpha)?>;
            }
            #wowslider-container1 .ws-title h3{
                color: <?=$color_settings->slider_title_color?><?=percentToHex( 100*$color_settings->slider_title_color_alpha)?>;
            }
            .jc-home-order-confirm{
                background: <?=$color_settings->home_view_menu_bg_color?><?=percentToHex( 100*$color_settings->home_view_menu_bg_color_alpha)?>;
            }
            .jc-home-order-confirm-wrap .jc-home_view_menubtn{
                color: <?=$color_settings->home_view_menubtn_color?><?=percentToHex( 100*$color_settings->home_view_menubtn_color_alpha)?>;
                background: <?=$color_settings->home_view_menubtn_bg_color?><?=percentToHex( 100*$color_settings->home_view_menubtn_bg_color_alpha)?>;
            }
            .jc-home-order-confirm-wrap .jc-home_view_text{
                color: <?=$color_settings->home_view_menu_color?><?=percentToHex( 100*$color_settings->home_view_menu_color_alpha)?>;
            }
            .jc-home-order-confirm-wrap .j-order_icon .st0{
                fill: <?=$color_settings->home_view_menu_icon_color?><?=percentToHex( 100*$color_settings->home_view_menu_icon_color_alpha)?>;
            }
            .jc-service{
                color: <?=$color_settings->service_color?><?=percentToHex( 100*$color_settings->service_color_alpha)?>;
            }
            .jc-servicebtn{
                color: <?=$color_settings->servicebtn_color?><?=percentToHex( 100*$color_settings->servicebtn_color_alpha)?>;
            }
            .jc-servicebtn .frost-icon svg circle.st0,.jc-servicebtn .frost-icon svg .st2{
                fill: <?=$color_settings->servicebtn_bg_color?><?=percentToHex( 100*$color_settings->servicebtn_bg_color_alpha)?> !important;
            }
            .jc-servicebtn .frost-icon svg .st1{
                fill: <?=$color_settings->servicebtn_color?><?=percentToHex( 100*$color_settings->servicebtn_color_alpha)?>;
            }
            .footer-bar{
                background: <?=$color_settings->footer_bg_color?><?=percentToHex( 100*$color_settings->footer_bg_color_alpha)?>;
            }
            .jc-footer_heading{
                color: <?=$color_settings->footer_heading_color?><?=percentToHex( 100*$color_settings->footer_heading_color_alpha)?>;
            }
            .jc-food_menu_big_tabs{
                background: <?=$color_settings->food_menu_big_tabs_bg_color?><?=percentToHex( 100*$color_settings->food_menu_big_tabs_bg_color_alpha)?>;
                color: <?=$color_settings->food_menu_big_tabs_color?><?=percentToHex( 100*$color_settings->food_menu_big_tabs_color_alpha)?>;
            }
            .jc-food_menu_big_tabs h4, .jc-food_menu_big_tabs p{
                color: <?=$color_settings->food_menu_big_tabs_color?><?=percentToHex( 100*$color_settings->food_menu_big_tabs_color_alpha)?>;
            }
            .jc-food_menu_heading{
                color: <?=$color_settings->food_menu_heading_color?><?=percentToHex( 100*$color_settings->food_menu_heading_color_alpha)?>;
            }
            .jc-address_time .address-bar{
                color: <?=$color_settings->address_time_color?><?=percentToHex( 100*$color_settings->address_time_color_alpha)?> !important;
            }
            .jc-enter_addressbtn{
                background: <?=$color_settings->enter_addressbtn_bg_color?><?=percentToHex( 100*$color_settings->enter_addressbtn_bg_color_alpha)?>;
                color: <?=$color_settings->enter_addressbtn_color?><?=percentToHex( 100*$color_settings->enter_addressbtn_color_alpha)?>;
            }
            .jc-food{
                color: <?=$color_settings->food_color?><?=percentToHex( 100*$color_settings->food_color_alpha)?>;
            }
            .jc-food_description{
                color: <?=$color_settings->food_description_color?><?=percentToHex( 100*$color_settings->food_description_color_alpha)?>;
            }
            .jc-food_info{
                color: <?=$color_settings->food_info_color?><?=percentToHex( 100*$color_settings->food_info_color_alpha)?> !important;
            }

            .prct {
                color: <?=$color_settings->price_color?><?=percentToHex( 100*$color_settings->price_color_alpha)?>;
            }
            .fnt14 {
                background: <?=$color_settings->blueline_color?><?=percentToHex(100*$color_settings->blueline_color_alpha)?>;
            }
            .MenU_li{
                border: 1px solid <?=$color_settings->blueline_color?><?=percentToHex(100*$color_settings->blueline_color_alpha)?>;
            }
            .MenU_li_title {
                background: <?=$color_settings->category_bg_color?><?=percentToHex(100*$color_settings->category_bg_color_alpha)?>;
                border: 1px solid <?=$color_settings->category_bg_color?><?=percentToHex(100*$color_settings->category_bg_color_alpha)?>;
            }
            .MenU_li_member:hover {
                background: <?=$color_settings->menu_card_hover_bg_color?><?=percentToHex(100*$color_settings->menu_card_hover_bg_color_alpha)?>;
            }
            .catStyle {
                color: <?=$color_settings->category_color?><?=percentToHex(100*$color_settings->category_color_alpha)?>;
                font-family:"<?=$category_font_family?>";
            }
            .nav.nav-tabs a {
                background: <?=$color_settings->tabbtn_bg_color?><?=percentToHex(100*$color_settings->tabbtn_bg_color_alpha)?>;
                color:<?=$color_settings->tabbtn_color?><?=percentToHex(100*$color_settings->tabbtn_color_alpha)?>;
            }
            .nav.nav-tabs a.active {
                background: <?=$color_settings->active_tabbtn_bg_color?><?=percentToHex(100*$color_settings->active_tabbtn_bg_color_alpha)?>;
                color:<?=$color_settings->active_tabbtn_color?><?=percentToHex(100*$color_settings->active_tabbtn_color_alpha)?>;
            }
            .wishlist_tab_panel, .mobile_bottom_bar {
                background: <?=$color_settings->wishlist_tab_bg_color?><?=percentToHex(100*$color_settings->wishlist_tab_bg_color_alpha)?>;
                color:<?=$color_settings->wishlist_tab_color?><?=percentToHex(100*$color_settings->wishlist_tab_color_alpha)?>;
            }
            .mobile_bottom_bar p{
                color:<?=$color_settings->wishlist_tab_color?><?=percentToHex(100*$color_settings->wishlist_tab_color_alpha)?>;
            }
            #reservationTable #reservation_setting{
                background-color:<?=$color_settings->reservation_page_bg?><?=percentToHex(100*$color_settings->reservation_page_bg_alpha)?> !important;
            }
            @media (min-width: 1004px){
                .jc-address_time>div{
                    background: <?=$color_settings->address_time_bg_color?><?=percentToHex( 100*$color_settings->address_time_bg_color_alpha)?> !important;
                }
            }
            @media (max-width: 1004px){
                .jc-address_time-container{
                    background: <?=$color_settings->address_time_bg_color?><?=percentToHex( 100*$color_settings->address_time_bg_color_alpha)?> !important;
                }
            }
        </style>

        <?php }?>
        <!-- announcement background color -->
        <style>
            .announcement_section {
                background: <?=$announcement_bg_color?><?=percentToHex( 100*$announcement_bg_alpha)?>;
            }
        </style>
        <?php
            $title = isset($seo_title) ? $seo_title : "Restopage" ;
            $description = isset($seo_description) ? $seo_description : "Order / Reservation - Delivery / Takeaway";
        ?>
        <title><?= $title?></title>
        <meta name="description" content="<?= $description ?>">
</head>
<body>
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

        // $empty_item = true;
        // if (null !== $this->input->cookie('jfrost_carts')){
        //     $carts_array = explode(",", $this->input->cookie("jfrost_carts"));
        //     foreach ($carts_array as $key => $value) {
        //         $cart_each_item_info = explode(":", $value);
        //         $cart_each_item_id = $cart_each_item_info[0];
        //         if ($cart_item_detail = $this->db->query("select * from tbl_menu_card as mc join tbl_category as c on mc.category_id = c.category_id left join tbl_tax_settings as tx on tx.id = mc.item_tax_id where mc.rest_id = $myRestId and c.category_status = 'active' and  item_status <> 'Not Available' and menu_id = $cart_each_item_id")->row()){
        //             $empty_item = false;
        //         }                  
        //     }
        // }
    ?>
    <section class="lgblueBck" data-url="<?= base_url("/")?>" data-mode="<?= isset($menu_mode) ? $menu_mode : "" ?>">
        <div class="card  rounded-0 jc-navigation">
            <div class="row container mx-auto px-0 hide-field">
                <div class="col-sm-8 col-6">
                    <?php
                    if($myRestDetail->rest_logo!=""){
                        $logo=$myRestDetail->rest_logo;
                    }else{
                        $logo="";
                    }
                    ?>
                    <a class="navbar-brand" href="<?=base_url("main/$rest_url_slug").$url_surfix ?>"><img src="<?=base_url('assets/rest_logo/').$logo?>" onerror="this.onerror=null;this.src='https://mindd.org/wp-content/uploads/2016/05/blogpost-placeholder-100x100.png';" alt="" class="img-fluid p-2 W751" ></a>
                </div>
                <div class="col-sm-4 col-6 d-flex justify-content-end">
                    <!-- modify by Jfrost small changes -->
                    <a class="navbar-brand d-flex align-items-center justify-content-center" href="<?=base_url("main/$rest_url_slug") .$url_surfix?>"  style="float:right"><img src="<?=base_url('assets/web_assets/')?>images/restrologo.png" onerror="this.onerror=null;this.src='https://mindd.org/wp-content/uploads/2016/05/blogpost-placeholder-100x100.png';" class="img-fluid" style="height:25px;"></a>
                </div>
            </div>
            <div class="">
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
                <div class="d-flex d-md-none hide-on-website mx-auto">

                    <a class="nav-link p-1" href="#"  role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="position: absolute;left: 10px; top: 17px;">
                      <span><i class="fa fa-align-justify"></i></span>
                    </a>
                    <!-- Dropdown - User Information -->
                    <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                        <?php if (isset($myRestDetail)){ ?>
                            <?php if (in_array("home",explode(",",$myRestDetail->active_pages))){ 
                                if ($this->restUrlSlug !== "" && $this->restUrlSlug == $rest_url_slug){ ?>
                                    <a class="dropdown-item " href="<?= base_url("main/").$url_surfix ?>"> HOME</a>
                                <?php }else{ ?>
                                    <a class="dropdown-item " href="<?= base_url("main/").$rest_url_slug."/$iframe".$url_surfix?>"> HOME</a>
                                <?php } ?>
                            <?php } ?>
                            <?php if (in_array("menu",explode(",",$myRestDetail->active_pages))){ 
                                if ($this->restUrlSlug !== "" && $this->restUrlSlug == $rest_url_slug){ ?>
                                    <a class="dropdown-item " href="<?= base_url("view/").$url_surfix?>"> FOOD MENU</a>
                                <?php }else{ ?>
                                    <a class="dropdown-item " href="<?= base_url("view/").$rest_url_slug."/$iframe".$url_surfix?>"> FOOD MENU</a>
                                <?php } ?>
                            <?php } ?>
                            <?php if (in_array("reservation",explode(",",$myRestDetail->active_pages))){ 
                                if ($this->restUrlSlug !== "" && $this->restUrlSlug == $rest_url_slug){ ?>
                                    <a class="dropdown-item " href="<?= base_url("reservation/").$url_surfix?>"> RESERVATION</a>
                                <?php }else{ ?>
                                    <a class="dropdown-item " href="<?= base_url("reservation/").$rest_url_slug."/$iframe".$url_surfix?>"> RESERVATION</a>
                                <?php } ?>
                            <?php } ?>
                            <!-- <a class="dropdown-item " href="<?= base_url("help/").$rest_url_slug."/$iframe".$url_surfix?>"> HELP</a> -->
                            <?php if (in_array("contact",explode(",",$myRestDetail->active_pages))){ 
                                if ($this->restUrlSlug !== "" && $this->restUrlSlug == $rest_url_slug){ ?>
                                    <a class="dropdown-item " href="<?= base_url("contactus/").$url_surfix?>"> CONTACT</a>
                                <?php }else{ ?>
                                    <a class="dropdown-item " href="<?= base_url("contactus/").$rest_url_slug."/$iframe".$url_surfix?>"> CONTACT</a>
                                <?php } ?>
                            <?php }?>
                        <?php } ?>
                        <div class="dropdown-divider"></div>
                        <!-- <a class="dropdown-item " class = "login" href="<?= base_url("/")?>"> LOGIN/REGISTER</a> -->
                        <?php if (null !== $this->session->userdata("customer_Data")) {?>
                            <a class="dropdown-item" href="<?= base_url("Customer/dashboard/").$url_surfix?>"> Dashboard</a>
                        <?php }else{ ?>
                        <a class="dropdown-item customerlogin"> LOGIN/REGISTER</a>
                        <?php }?>
                    </div>
                    <a class="navbar-brand mx-auto" href="<?=base_url("main/$rest_url_slug/".$url_surfix)?>"><img src="<?=base_url('assets/rest_logo/').$logo?>" alt="" class="img-fluid p-2" width="100"></a>
                </div>
                <div class="d-md-flex d-none align-items-center col-sm-12 justify-content-between">
                    <a class="ml-4 navbar-brand  nav-logo" href="<?=base_url("main/$rest_url_slug")."/$iframe".$url_surfix?>"><img src="<?=base_url('assets/rest_logo/').$logo?>"  onerror="this.onerror=null;this.src='https://mindd.org/wp-content/uploads/2016/05/blogpost-placeholder-100x100.png';" alt="" class="img-fluid p-2" width="150"></a>
                    <div class="nav-items-links mr-auto ml-5">
                        <?php if (isset($myRestDetail)){ ?>
                            <?php if (in_array("home",explode(",",$myRestDetail->active_pages))){ 
                                if ($this->restUrlSlug !== "" && $this->restUrlSlug == $rest_url_slug){ ?>
                                    <a class="nav-item-link jc-menu btn" href="<?= base_url("main/").$url_surfix?>"> HOME</a>
                                <?php }else{ ?>
                                    <a class="nav-item-link jc-menu btn" href="<?= base_url("main/").$rest_url_slug."/$iframe".$url_surfix?>"> HOME</a>
                                <?php } ?>
                            <?php } ?>
                            <?php if (in_array("menu",explode(",",$myRestDetail->active_pages))){ 
                                if ($this->restUrlSlug !== "" && $this->restUrlSlug == $rest_url_slug){ ?>
                                    <a class="nav-item-link jc-menu btn" href="<?= base_url("view/").$url_surfix?>"> FOOD MENU</a>
                                <?php }else{ ?>
                                    <a class="nav-item-link jc-menu btn" href="<?= base_url("view/").$rest_url_slug."/$iframe".$url_surfix?>"> FOOD MENU</a>
                                <?php } ?>
                            <?php } ?>
                            <?php if (in_array("reservation",explode(",",$myRestDetail->active_pages))){ 
                                if ($this->restUrlSlug !== "" && $this->restUrlSlug == $rest_url_slug){ ?>
                                    <a class="nav-item-link jc-menu btn" href="<?= base_url("reservation/").$url_surfix?>"> RESERVATION</a>
                                <?php }else{ ?>
                                    <a class="nav-item-link jc-menu btn" href="<?= base_url("reservation/").$rest_url_slug."/$iframe".$url_surfix?>"> RESERVATION</a>
                                <?php } ?>
                            <?php } ?>
                            <!-- <a class="nav-item-link jc-menu btn" href="<?= base_url("help/").$rest_url_slug."/$iframe".$url_surfix?>"> HELP</a> -->
                            <?php if (in_array("contact",explode(",",$myRestDetail->active_pages))){ 
                                if ($this->restUrlSlug !== "" && $this->restUrlSlug == $rest_url_slug){ ?>
                                    <a class="nav-item-link jc-menu btn" href="<?= base_url("contactus/").$url_surfix?>"> CONTACT</a>
                                <?php }else{ ?>
                                    <a class="nav-item-link jc-menu btn" href="<?= base_url("contactus/").$rest_url_slug."/$iframe".$url_surfix?>"> CONTACT</a>
                                <?php } ?>
                            <?php } ?>
                        <?php } ?>
                    </div>
                    <div class="justify-content-end pl-0 d-none d-sm-flex px-4 show-on-website">
                        <ul class="lang-setting d-flex align-items-center">
                            <!-- Nav Item - User Information -->
                            <li class="nav-item dropdown no-arrow">
                                <a class="nav-link p-1" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <!-- modify by Jfrost rest-->
                                    <?php
                                        if ($this->input->get("lang") == "en" && in_array("english",explode(",",$myRestDetail->website_languages))){?>
                                            <img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/en-flag.png')?>">
                                            <?php 
                                        }elseif ($this->input->get("lang") == "de" && in_array("germany",explode(",",$myRestDetail->website_languages))){?>
                                            <img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/ge-flag.png')?>">
                                            <?php 
                                        }else{?>
                                            <img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/fr-flag.png')?>">
                                        <?php }
                                    ?>
                                    <!-- ------------------ -->
                                </a>
                                <!-- Dropdown - User Information -->
                                <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in">
                                    <!-- remove hide-field -->
                                    <?php 
                                        $website_lang_count = 0;
                                        $website_languages = explode(",",$myRestDetail->website_languages);
                                        $current_url_without_get_parameter =  $_SERVER['REQUEST_SCHEME'] .'://'. $_SERVER['HTTP_HOST'] . explode('?', $_SERVER['REQUEST_URI'], 2)[0];
                                        if ($this->input->get("lang") == "en"){
                                            $_get_lang = "english";
                                        }elseif ($this->input->get("lang") == "de"){
                                            $_get_lang = "germany";
                                        }else{
                                            $_get_lang = "french";
                                        }
                                        if (!empty($website_languages) && null !== $_get_lang && !in_array($_get_lang,$website_languages)){
                                            if ($website_languages[0] == "english"){
                                                $lang_surfix = "?lang="."en";
                                            }elseif ($website_languages[0] == "germany"){
                                                $lang_surfix = "?lang="."de";
                                            }else{
                                                $lang_surfix = "?lang="."fr";
                                            }
                                            redirect($current_url_without_get_parameter.$lang_surfix);
                                        }
                                        foreach ($website_languages as $website_lang) { 
                                            if ($website_lang == "english"){
                                                $abb_lang = "en";
                                            }elseif($website_lang == "germany"){
                                                $abb_lang = "ge";
                                            }else{
                                                $abb_lang = "fr";
                                            }
                                            $website_lang_count ++;
                                            ?>
                                            <div class="dropdown-divider <?= $website_lang_count == 1 ? "hide-field": ""?>"></div>
                                            <a class="dropdown-item <?= $website_lang ?>-flag text-capitalize" onclick = "change_language('<?= base_url('api/change_lang') ?>','<?= $website_lang ?>')">
                                                <img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/'.$abb_lang.'-flag.png')?>">
                                                <?= $website_lang ?>
                                            </a>
                                    <?php } ?>
                                </div>
                            </li>
                        </ul>
                        <?php
                            if (isset($menu_mode)){
                                if ($menu_mode == "table"){ ?>
                                    <div class="d-flex align-items-center justify-content-center text-danger ml-2 wishlist-icon">
                                        <a class="text-danger to-wishlist-page" href="<?= base_url('Home/wishList')."/$rest_url_slug/$iframe".$url_surfix?>" data-href="<?= base_url('Home/wishList')."/$rest_url_slug/$iframe".$url_surfix?>">
                                            <span>
                                                <i class="fa fa-heart"></i>
                                            </span>
                                        </a>
                                    </div>
                            <?php
                                }else{ ?>
                                    <div class="d-flex align-items-center justify-content-center text-danger ml-2 wishlist-icon">
                                        <a class="text-danger to-wishlist-page" href="<?= base_url('Home/cart')."/$rest_url_slug/$menu_mode/$iframe".$url_surfix?>" data-href="<?= base_url('Home/cart')."/$rest_url_slug/$menu_mode/$iframe".$url_surfix?>">
                                            <span>
                                                <?php
                                                    // if ($empty_item) {
                                                        // echo '<img src="'.base_url('assets/additional_assets/img/').'cart-img.gif" class="img-fluid" width="30">';
                                                    // }else{
                                                        echo '<i class="fa fa-shopping-cart"></i>';
                                                    // }
                                                ?>
                                            </span>
                                        </a>
                                    </div>
                            <?php
                                }
                            }
                        ?>
                    </div>
                    <div>
                        <!-- <a class="nav-item-link  btn"  href="<?= base_url("/").$url_surfix?>"> Register/Login</a> -->
                        <?php if ( null !== $this->session->userdata("customer_Data")) {?>
                            <a class="nav-item-link jc-loginbtn btn" href="<?= base_url("Customer/dashboard/").$url_surfix?>"> Dashboard</a>
                        <?php }else{ ?>
                            <a class="nav-item-link jc-loginbtn btn customerlogin"> Register/Login</a>
                        <?php }?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Begin of Announcement -->
    <?php

        $announcement = $this->db->where('rest_id',$myRestId)->get('tbl_announcement')->row();
        if (isset($announcement->content) && trim($announcement->content) !== ""){
            $content = "content_" . $_lang;
            $restaurant_message = $announcement->$content == "" ?  $announcement->content : $announcement->$content;
            echo '<div class="announcement_section alert mx-2 my-3">'.$restaurant_message.'</div>';
        }
    ?>
    <!-- End of Announcement -->
    <!-- Begin of Pre Order -->
    <?php if (isset($is_pre_order) && $is_pre_order == 1 && ( !isset($is_open_time) || (isset($is_open_time) && !$is_open_time))){ ?>
        <div class="pre_order_notify_section bg-warning p-3 p-md-4 text-center"><?= $this->lang->line("This restaurant is closed, but you can make pre-order") ?>.</div>
    <?php } ?>
    <!-- End of Pre Order -->