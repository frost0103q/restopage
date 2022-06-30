<?php if (isset($common_bottom_bar) && !$common_bottom_bar){}else{ ?>
    <section class="hide-on-website">
        <div class="row d-flex justify-content-around m-0 mobile_bottom_bar_wrap">
            <div class="lang-setting col-4 align-items-center">
                <!-- Nav Item - User Information -->
                <div class="pr-2">
                    <span class="mobile_bottom_bar" id="bottom_language_parent" role="button">
                        <!-- modify by Jfrost rest-->
                        <?php
                            if (explode(",",$myRestDetail->website_languages)[0] == "english"){?>
                                <img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/en-flag.png')?>">
                                <?php 
                            }elseif (explode(",",$myRestDetail->website_languages)[0] == "germany"){?>
                                <img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/ge-flag.png')?>">
                                <?php 
                            }else{?>
                                <img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/fr-flag.png')?>">
                            <?php }
                        ?>
                    </span>
                    <div class="bottom_language_child hide-field" id = "bottom_language_child">
                        <?php 
                            $website_lang_count = 0;
                            $website_languages = explode(",",$myRestDetail->website_languages);
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
                                <a class="lang-item dropdown-item <?= $website_lang ?>-flag text-capitalize" onclick = "change_language('<?= base_url('api/change_lang') ?>','<?= $website_lang ?>')">
                                    <img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/'.$abb_lang.'-flag.png')?>">
                                    <?= $website_lang ?>
                                </a>
                        <?php } ?>
                    </div>
                </div>
                
            </div>
            <div class="col-8 p-0">
                <?php if ($this->restUrlSlug !== "" && $this->restUrlSlug == $rest_url_slug){ ?>
                    <a class="mobile_bottom_bar text-danger wishlist-icon to-wishlist-page" href="<?= base_url('view')?>" data-href="<?= base_url('Home/main')."/$rest_url_slug/$iframe"?>" >
                <?php }else{ ?>
                    <a class="mobile_bottom_bar text-danger wishlist-icon to-wishlist-page" href="<?= base_url('view')."/$rest_url_slug/$iframe"?>" data-href="<?= base_url('Home/main')."/$rest_url_slug/$iframe"?>" >
                <?php } ?>
                    <p class="text-capitalize ml-3" style="color:white">View the Food Menu</p>
                </a>
            </div>
        </div>
    </section>
<?php } ?>
<section class="footer-bar">
    <div class="container row mx-auto pt-md-5 p-0">
        <div class="col-lg-4 col-md-6 p-0 p-md-3">
            <div class="footer-section">
                <h5 class="jc-footer_heading j-blue-color  mb-3"> 
                    Opening Hours 
                    <div class="jc-footer_heading_bottom_1st_line"></div>
                    <div class="jc-footer_heading_bottom_2nd_line"></div>
                </h5>
                <div class="jc-footer_wrap">
                    <?php
                        $time_format = $myRestDetail->time_format;
                        $date_format = $myRestDetail->date_format;

                        $openingTimes = $this->db->where("rest_id",$myRestId)->get("tbl_opening_times")->row();

                        if (isset($openingTimes)){
                            $opening_hours = $openingTimes->opening_hours;
                            $opening_hours = json_decode($opening_hours);
                        }
                        $rest_opening_times_in_footer = "";

                        // $weekdays = ['Mon','Tue','Wed','Thu','Fri','Sat','Sun'];
                        $weekdays = ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'];
                        
                        $now_weekday= (date("N") + 6) % 7;
                        
                        foreach ($weekdays as $key => $day) {
                            if ($now_weekday ==  $key){
                                $is_today = "style='color: red;'";
                            }else{
                                $is_today = "";
                            }

                            $ohour= "";
                            if(isset($opening_hours[$key])){
                                foreach ($opening_hours[$key] as $okey => $ovalue) {
                                    if ($okey > 0){
                                        $rest_opening_times_in_footer .=  " | " . date($time_format, strtotime($ovalue->start))  ." - ". date($time_format, strtotime($ovalue->end)) ;
                                    }else{
                                        $rest_opening_times_in_footer .= "<p $is_today class='d-flex justify-content-between'><span>$day </span><span>  ".date($time_format, strtotime($ovalue->start))  ." - ". date($time_format, strtotime($ovalue->end)) ;
                                    }
                                }
                                $rest_opening_times_in_footer .= " </span></p>";
                            }
                        }

                        echo "<div class='week-schedule'>".$rest_opening_times_in_footer."</div>";
                    ?>
                </div>
            </div>
        </div>
        <div class="col-lg-1 d-md-none d-lg-block"></div>
        <div class="col-lg-4 col-md-6 p-0 p-md-3">
            <div class="footer-section">
                <h5 class="j-blue-color jc-footer_heading  mb-3"> 
                    <?= $this->lang->line("Contact")?>           
                    <div class="jc-footer_heading_bottom_1st_line"></div>
                    <div class="jc-footer_heading_bottom_2nd_line"></div> 
                </h5>
                <div class="jc-footer_wrap">
                    <p class="mb-1"> <?= $myRestDetail->address1?> <?= $myRestDetail->address2 == "" ? "" : " | " . $myRestDetail->address2 ?> </p>
                    <div class=""> 
                        <span> Tel : </span> 
                        <span> <?= $myRestDetail->rest_contact_no?> </span>
                    </div>
                </div>
            </div>
            <div class="mt-md-4 mt-3 footer-section">
                <h5 class="j-blue-color jc-footer_heading  mb-3 text-capitalize"> 
                    <?= $this->lang->line("follow us")?>
                    <?= $this->restUrlSlug?>
                    <div class="jc-footer_heading_bottom_1st_line"></div>
                    <div class="jc-footer_heading_bottom_2nd_line"></div> 
                </h5>
                <div class="jc-footer_wrap">
                    <div class="social-medias d-flex justify-content-start">
                        <?php
                            $social_setting=$this->db->where("rest_id",$myRestId)->get('tbl_social_settings')->row();
                            if (isset($social_setting->social_media)){
                                $social_medias = json_decode($social_setting->social_media);
                            }else{
                                $social_medias = null;
                            }
                            if ($social_medias !== null) {
                            foreach ($social_medias as $social_name => $social) { 
                                if ($social->status == "on" && $social->url !== ""){
                                ?>
                                <a class="social-media-in-footer text-white" href="<?= $social->url?>" target="_blank"><i class="fab fa-<?=$social_name?>"></i></a>
                            <?php } } }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 p-0 p-md-3 d-md-none d-block">
            <div class="footer-section">
                <h5 class="j-blue-color jc-footer_heading  mb-3"> 
                    <?= $this->lang->line("Legal")?>           
                    <div class="jc-footer_heading_bottom_1st_line"></div>
                    <div class="jc-footer_heading_bottom_2nd_line"></div> 
                </h5>
                <div class="jc-footer_wrap">
                    <ul class="m-0 p-0">
                        <li  class=""><a class="text-white" href="<?= base_url("legal") . "/$rest_url_slug/imprint"?>"> <?= $this->lang->line("Imprint") ?> </a></li>
                        <li  class=""><a class="text-white" href="<?= base_url("legal") . "/$rest_url_slug/data-protection"?>"> <?= $this->lang->line("Data Protection") ?> </a></li>
                        <?php if (in_array("tc",explode(",",$myRestDetail->active_pages))){ ?>
                            <li  class=""><a class="text-white" href="<?= base_url("legal") . "/$rest_url_slug/terms-conditions"?>"> <?= $this->lang->line("Terms and Conditions") ?> </a></li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 p-0 p-md-3">
            <div class="footer-section">
                <h5 class="j-blue-color jc-footer_heading mb-3"> 
                    Design & Hosting 
                    <div class="jc-footer_heading_bottom_1st_line"></div>
                    <div class="jc-footer_heading_bottom_2nd_line"></div> 
                </h5>
                <div class="jc-footer_wrap">
                    <a class="d-block" href="https://restopage.eu"><img src="<?=base_url('assets/web_assets/')?>images/White-Logo.png" class="img-fluid" width="200"></a>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="legal-page-bar p-2  d-md-block d-none">
    <ul class="d-flex justify-content-center m-0 p-0">
        <li  class="text-center mx-2"><a class="text-white" href="<?= base_url("legal") . "/$rest_url_slug/imprint"?>"> <?= $this->lang->line("Imprint") ?> </a></li>
        <li  class="text-center mx-2"><a class="text-white" href="<?= base_url("legal") . "/$rest_url_slug/data-protection"?>"> <?= $this->lang->line("Data Protection") ?> </a></li>
        <?php if (in_array("tc",explode(",",$myRestDetail->active_pages))){ ?>
            <li  class="text-center mx-2"><a class="text-white" href="<?= base_url("legal") . "/$rest_url_slug/terms-conditions"?>"> <?= $this->lang->line("Terms and Conditions") ?> </a></li>
        <?php } ?>
    </ul>
</section>
<section class="copyright-bar p-2">
    <?php 
        $myrest = $this->db->where("rest_id",$myRestId)->get("tbl_restaurant")->row();
    ?>
    Copyright <?= $myrest->rest_name?>
</section>
<div id="customerloginModal" class="modal fade align-items-md-center justify-content-center user-modal" role="dialog">
    <div class="modal-dialog">
        <div class="row mb-5">
            <div class="modal-left">
                <div class="modal-content">
                    <div class="modal-header d-none">
                        <h4 class="modal-title">User Log In</a></h4>
                        <hr>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 usersign-in-form">
                                <div>
                                    <form id = "userLogin" method="post" data-url = "<?=base_url('/')?>" data-rest_url_slug = "<?= $rest_url_slug?>">
                                        <div class="form-group">
                                            <div class="mt-3 mb-sm-0 text-center">
                                                <h4 class="form-control form-title">User Log In</h4>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="mb-sm-0">
                                                <input type="email" class="form-control"  id="user_email" placeholder="Enter your email.." name="user_email" value="">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="mb-sm-0">
                                                <input type="password" class="form-control"  id="user_pass" placeholder="password.." name="user_pass" value="">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="mb-sm-0 ">
                                                <input type="submit" disabled class="form-control btn login-form-btn-style text-white"  name="subcat_name" value="Log In">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <hr>
                                <div class="">
                                    <a class="forgot_btn_in_modal text-right"  role="button"><?= $this->lang->line("Forgot Password")?>?</a>
                                </div>
                                <div class="form-footer">
                                    <p class="text-center my-2"><em>Powered by</em></p>
                                    <div class="logos-bar d-flex justify-content-between px-3 py-1">
                                        <img src="<?= base_url("assets/additional_assets/svg/where2eatLogo.svg") ?>">
                                        <img src="<?= base_url("assets/additional_assets/svg/machmichsatt.svg") ?>">
                                        <img src="<?= base_url("assets/additional_assets/svg/easymeal.svg") ?>">
                                    </div>
                                    <div class="small form-footer-text">If you have already an account, you can simply log in. </div>
                                </div>
                            </div>
                            <div class="col-md-6 usersign-up-form">
                                <form id = "userRegister" method="post" data-url = "<?=base_url('/')?>">
                                    <div class="input-field-section">
                                        <div class="form-group">
                                            <div class="mt-3 mb-sm-0 text-center">
                                                <h4 class="form-control form-title">No Account yet?</h4>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="mb-sm-0">
                                                <input type="text" class="form-control required_field" id="user_name_register" placeholder="Enter your name.." name="user_name_register" value="">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="mb-sm-0">
                                                <input type="email" class="form-control required_field" id="user_email_register" placeholder="Enter your email.." name="user_email_register" value="">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="mb-sm-0">
                                                <input type="password" class="form-control required_field" id="user_password_register" placeholder="Password.." name="user_password_register" value="">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="mb-sm-0">
                                                <input type="password" class="form-control required_field" id="user_password_confirm_register" placeholder="Confirm password.." name="user_password_confirm_register" value="">
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                        $myRest=$this->db->where("rest_id",$myRestId)->get('tbl_restaurant')->row();
                                    ?>
                                    <div class="form-group">
                                        <div class="my-3 mb-sm-0 small">
                                            This site is protected by reCAPTCHA and the Google<a href="https://policies.google.com/privacy"> Privacy Policy </a> and <a href="https://policies.google.com/terms"> Terms of Service </a> apply.
                                            <div class="mt-3 mb-sm-0 d-flex">
                                                <div class="mt-1 mr-2"><input type="checkbox" required></div>
                                                <div>I agree to the <?=$myRest->rest_name?> <?= in_array("tc",explode(",",$myRestDetail->active_pages)) ? '<a href="'. base_url("legal") . "/$rest_url_slug/terms-conditions".'">Terms of Service</a> and' : ''?> <a href="<?= base_url("legal") . "/$rest_url_slug/data-protection"?>">Privacy Policy</a></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="mb-sm-0 ">
                                            <input type="submit" disabled class="form-control btn login-form-btn-style text-white"  name="subcat_name" value="Sign Up">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between d-none">
                            <a class="register_btn_in_modal"  role="button"><?= $this->lang->line("New? Register Here")?>..</a>
                        </div>
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
<div id="customerForgotModal" class="modal fade align-items-center justify-content-center user-modal"  role="dialog">
    <div class="modal-dialog">
        <div class="row mb-5">
            <div class="modal-left">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Forgot Password?</a></h4>
                        <hr>
                    </div>
                    <div class="modal-body">
                        <form id = "userForgot" method="post" data-url = "<?=base_url('/')?>" >
                            <div class="form-group row">
                                <div class="col-sm-12 mb-3 mb-sm-0">
                                    <input type="email" class="form-control form-control-user" id="user_email_forgot" placeholder="Enter your email.." name="user_email_forgot" value="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-3 offset-md-9 mb-3 mb-sm-0 ">
                                    <input type="submit" disabled class="form-control form-control-user btn btn-danger text-white"  name="subcat_name" value="Send">
                                </div>
                            </div>
                        </form>
                        <div class="modal-footer justify-content-between">
                            <span class="forgot_btn_in_modal pointer-hand"  role="button">Register Here..</span>
                            <span class="customerlogin"  role="button">Log In Here..</span>
                        </div>
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
<?php if (null == $this->input->cookie('jfrost_allow_cookie')){
    if ($cookie = $this->db->where("rest_id",$myRestId)->get("tbl_legal_settings")->row()){
        $cookie_note_field = "cookie_note_" . $site_lang;
        if (isset($cookie->$cookie_note_field) && $cookie->$cookie_note_field !== ""){
            $cookie_content = $cookie->$cookie_note_field;
        }else{
            $cookie_content = $cookie->cookie_note;
        } 
        if ($cookie_content && $cookie_content !=="") {
        ?>
    <div class="cookie-section d-flex p-3 px-md-5 justify-content-between">
        <div class="cookie-content">
            <?= $cookie_content ?>
        </div>
        <a class="btn btn-primary accept_cookie" data-url="<?= base_url()?>">Okay, I agree</a>
    </div>
<?php } } }?>
<?php
    if(isset($externalScript)){
        echo $externalScript;
    }
?>
<?php if (isset($jquery_1_8_timepicker) && $jquery_1_8_timepicker == true){ ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-timepicker/1.8.9/jquery.timepicker.min.js"></script>
<?php }else{ ?>
    <script type="text/javascript" src="<?=base_url('assets/additional_assets/jquery-ui-timepicker').'/include/ui-1.10.0/jquery.ui.core.min.js'?>"></script>
    <script type="text/javascript" src="<?=base_url('assets/additional_assets/jquery-ui-timepicker').'/include/ui-1.10.0/jquery.ui.widget.min.js'?>"></script>
    <script type="text/javascript" src="<?=base_url('assets/additional_assets/jquery-ui-timepicker').'/include/ui-1.10.0/jquery.ui.tabs.min.js'?>"></script>
    <script type="text/javascript" src="<?=base_url('assets/additional_assets/jquery-ui-timepicker').'/include/ui-1.10.0/jquery.ui.position.min.js'?>"></script>
    <script type="text/javascript" src="<?=base_url('assets/additional_assets/jquery-ui-timepicker').'/jquery.ui.timepicker.js?v=0.3.3'?>"></script>
<?php } ?>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="<?=base_url('assets/additional_assets/').'js/chosen.jquery.js'?>"></script>
<script src="<?=base_url('assets/additional_assets/template').'/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js'?>"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script src="https://checkout.stripe.com/checkout.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.16/dist/summernote.min.js"></script>
<script src="<?=base_url('assets/additional_assets/').'js/jquery.nivo.slider.js'?>"></script>
<!-- modify by jfrost in 2nd stage -->
<script src="<?=base_url('assets/additional_assets/wow-slider/engine1').'/wowslider.js'?>"></script>
<script src="<?=base_url('assets/additional_assets/wow-slider/engine1').'/script.js'?>"></script>
<script src="https://www.google.com/recaptcha/api.js?render=6LcQbNsaAAAAALyY3W-KNEpem4zuRZJOoah3uVTT"></script>
<script src="<?=base_url('assets/additional_assets/').'js/myscript.js'?>"></script>
<script type="text/javascript">
// modify by jfrost in 2nd stage
    <?php if(isset($sliders) && isset($page_contents)){ ?>
        jQuery("#wowslider-container1").wowSlider({
            // effect: "louvers,book,domino",
            effect: "<?= $page_contents->slider_effects?>",
            prev: "",
            next: "",
            duration: <?= isset($page_contents->slider_duration) && ($page_contents->slider_duration > 0) ? $page_contents->slider_duration : 2 ?> * 1000,
            delay: <?= isset( $page_contents->slider_delay) && ($page_contents->slider_delay> 0) ? $page_contents->slider_delay: 2  ?> * 1000,
            width: 1560,
            height: 720,
            autoPlay: true,
            autoPlayVideo: false,
            playPause: false,
            stopOnHover: false,
            loop: false,
            bullets: 1,
            caption: true,
            captionEffect: "fade",
            controls: true,
            controlsThumb: false,
            responsive: 1,
            fullScreen: true,
            gestures: 2,
            onBeforeStep: 0,
            images: [
                <?php 
                    $site_lang == "" ? "french" : $site_lang ;
                    $slider_caption_title_field = "slider_caption_title_" . $site_lang;
                    $slider_caption_content_field = "slider_caption_content_" . $site_lang;
                    foreach ($sliders as $skey => $slider) {
                        if ($slider->image_name !== ""){ ?>
                            {
                                src: "<?= base_url("assets/home_slider_images/").$slider->image_name?>",
                                <?php 
                                if (trim($slider->slider_caption_title) !== "" || trim($slider->slider_caption_content) !== "") { ?>
                                    title: "<h3><?=$slider->$slider_caption_title_field == "" ? $slider->slider_caption_title : $slider->$slider_caption_title_field ?></h3><p><?=$slider->$slider_caption_content_field == "" ? $slider->slider_caption_content : $slider->$slider_caption_content_field ?></p>"
                                <?php }else{?>
                                    title:""
                                <?php }?>
                            },
                        <?php }
                    }
                ?>
            ]
        });
    <?php } ?>
</script>
<?php
    $seo_footer_content= "";
    if (isset($myRestId)){
        $seo_content = $this->db->where("seo_rest_id",$myRestId)->get("tbl_seo_settings")->row();
        if ($seo_content ){
            $footer_content = "seo_footer_content_" . $site_lang;
            $seo_footer_content = isset($seo_content->$footer_content) && ($seo_content->$footer_content !== "") ? $seo_content->$footer_content : $seo_content->seo_footer_content; 
        }
    }
?>
<?= $seo_footer_content ?>

</body>
</html>