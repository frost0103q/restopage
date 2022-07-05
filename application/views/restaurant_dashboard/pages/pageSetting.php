        <!-- Begin Page Content -->
        <div class="container-fluid pageSetting-page multi-lang-page" data-url ="<?= base_url('/')?>" data-active_lang = "<?=explode(",",$this->myRestDetail->website_languages)[0] ?>">

            <!-- Page Heading -->
            <h1 class="h3 mb-2 text-gray-800"><?= $this->lang->line("Edit your main page")?></h1>
            <div class="row">

                <div class="col-md-12 ">
                    <?php
                    if($this->session->flashdata('msg')){
                        echo '<div class="alert alert-danger">'.$this->session->flashdata('msg').'</div>';
                    }
                    ?>
                    <div class="content_wrap tab-content">
                        <!-- Welcome Section -->
                        <?php
                            if (isset($page_content->content_image) && $page_content->content_image !== ""){
                                $content_image = base_url("assets/home_images/").$page_content->content_image;
                            }else{
                                $content_image = "";
                            }
                            $welcome_section = '
                                <form class="editHomepage" action="'.base_url('Restaurant/editMainPage').'" method="post" enctype="multipart/form-data">
                                    <input type="hidden" name="rest_id" value = "'. $myRestId.'">
                                    <input type="hidden" name="what_setting" value = "homepage">
                                    <input type="hidden" name="section_type" value= "homepage-welcome">
                                    <div class="card shadow mb-4">
                                        <div class="card-header py-3 d-flex justify-content-between title-bar">
                                            <div class="d-flex justify-content-between align-items-center left-bar">
                                                <span class="sort-section-btn mr-2 ctrl-btn sort-down-btn">
                                                    <img class="tar-icon" src="'. base_url("assets/additional_assets/svg/arrow-alt-down.svg") .'">
                                                </span>
                                                <span class="sort-section-btn mr-2 ctrl-btn sort-up-btn">
                                                    <img class="tar-icon" src="'. base_url("assets/additional_assets/svg/arrow-alt-up.svg") .'">
                                                </span>
                                                <div class="v-splite-line"></div>
                                                <input type="checkbox" data-plugin="switchery" name = "is_show_welcome" data-color="#3DDCF7"  '. ( (isset($page_content->is_show_welcome) && $page_content->is_show_welcome == 1) ? "checked" : "" ) .'/>
                                                <a class="text-uppercase font-weight-bold j-font-size-18px mx-2" data-toggle="collapse" href="#homepage-welcome-body" role="button" aria-expanded="true" aria-controls="homepage-welcome-body">Welcome</a>
                                            </div>
                                            <div class="right-bar">
                                                <div class="lang-bar">
                                                    <span class="'. (explode(",",$this->myRestDetail->website_languages)[0] == 'english' ? 'active' : '')  .' item-flag" data-flag="english"><img class="english-flag" src="'. base_url('assets/flags/en-flag.png').'"></span>
                                                    <span class="'. (explode(",",$this->myRestDetail->website_languages)[0] == 'french' ? 'active' : '')  .' item-flag" data-flag="french"><img class="french-flag" src="'. base_url('assets/flags/fr-flag.png').'"></span>
                                                    <span class="'. (explode(",",$this->myRestDetail->website_languages)[0] == 'germany' ? 'active' : '')  .' item-flag" data-flag="germany"><img class="germany-flag" src="'. base_url('assets/flags/ge-flag.png').'"></span>
                                                </div>
                                                <div class="v-splite-line hide-field"></div>
                                                <span class="close-section-btn hide-field">
                                                    <i class="fa fa-times-circle"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="card-body collapse show" id="homepage-welcome-body">
                                            <div class="form-group row">
                                                <label class="col-md-4 text-center section_heading_label">'. $this->lang->line('Section Heading') .'</label>
                                                <div class="input-group french-field hide-field col-md-8 lang-field">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="'. base_url('assets/flags/fr-flag.png').'" ></span>
                                                    </div>
                                                    <input type="text" class="form-control" name="section_heading_french" placeholder="Welcome" value="'. (isset($page_content->section_heading_french) ? $page_content->section_heading_french : "") .'">
                                                </div>
                                                <div class="input-group germany-field hide-field col-md-8 lang-field">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="'. base_url('assets/flags/ge-flag.png').'" ></span>
                                                    </div>
                                                    <input type="text" class="form-control" name="section_heading_germany" placeholder="Welcome" value="'.(isset($page_content->section_heading_germany) ? $page_content->section_heading_germany:"").'">
                                                </div>
                                                <div class="input-group english-field hide-field col-md-8 lang-field">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="'. base_url('assets/flags/en-flag.png').'" ></span>
                                                    </div>
                                                    <input type="text" class="form-control" name="section_heading_english" placeholder="Welcome" value="'.(isset($page_content->section_heading_english) ? $page_content->section_heading_english:"").'">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-4 update-image">
                                                    
                                                    <input type="file" class="dropify" name="content_img" data-slider-index="_content" data-default-file = "'. $content_image .'" value = "'. $content_image .'"/>
    
                                                    <input type="hidden" name="is_update_content" value = "'. ($content_image == "" ? "1" : "0").'" />
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="input-group english-field hide-field content-editor lang-field">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="'. base_url('assets/flags/en-flag.png').'" ></span>
                                                        </div>
                                                        <textarea class="summernote form-control" name="page_content_english"  placeholder ="'. $this->lang->line('Item Description').'">'. (isset($page_content) ? $page_content->content_english : "").'</textarea>
                                                    </div>
                                                    <div class="input-group french-field hide-field content-editor lang-field">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="'. base_url('assets/flags/fr-flag.png').'" ></span>
                                                        </div>
                                                        <textarea class="summernote form-control" name="page_content_french"  placeholder ="'. $this->lang->line('Item Description').'" >'. (isset($page_content) ? $page_content->content_french : "") .'</textarea>
                                                    </div>
                                                    <div class="input-group germany-field hide-field content-editor lang-field">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="'. base_url('assets/flags/ge-flag.png').'" ></span>
                                                        </div>
                                                        <textarea class="summernote form-control" name="page_content_germany" placeholder ="'. $this->lang->line('Item Description').'" >'. (isset($page_content) ? $page_content->content_germany : "").'</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-sm-12 mx-auto mb-3 mb-sm-0">
                                                    <input type="submit" name="" value="'. $this->lang->line('SAVE') .'" class="btn btn-danger btn-user btn-block submit-btn">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            ';

                            if ($page_content && $page_content->service_section_background !== ""){
                                $service_section_background = base_url("assets/home_service_background/").$page_content->service_section_background;
                            }else{
                                $service_section_background = "";
                            }
                            $service_items_part = "";
                            if (sizeof($homepage_services) > 0){
                                $hs_index = 0;
                                foreach ($homepage_services as $hs_key => $hs_value) { 
                                    $hs_index ++; 
                                    $service_items_part .='
                                        <div class="col-md-2 mt-3">
                                            <label class="'. ($hs_value->service_status == 1 ? "active" : "") .' d-flex justify-content-center flex-column text-center homepage-services btn" alt="'.$hs_value->service_alt.'">
                                                <span class="active-signal badge badge-primary">ACTIVE</span>
                                                <i class="fa frost-icon '.$hs_value->service_alt .' mb-2 mx-auto">'. $hs_value->icon_svg.'</i>
                                                <p class="mb-0 text-capitalize">'.$hs_value->service_name.'</p>
                                                <input type="checkbox" class="d-none" name="homepage_service_status['.$hs_value->id.']" '. ($hs_value->service_status == 1 ? "checked" : "") .'>
                                                <input type="hidden" name="homepage_service_id['.$hs_value->id.']" value="'.$hs_value->hs_id.'">
                                                <input type="hidden" name="service_id['.$hs_value->id.']" value="'.$hs_value->id.'">
                                            </label>
                                        </div>
                                    ';
                                } 
                            }
                            $service_section = '
                                <form class="editHomepage" action="'.base_url('Restaurant/editMainPage').'" method="post" enctype="multipart/form-data">
                                    <input type="hidden" name="rest_id" value = "'. $myRestId.'">
                                    <input type="hidden" name="what_setting" value = "homepage">
                                    <input type="hidden" name="section_type" value="homepage-my-service">
                                    <div class="card shadow mb-4">
                                        <div class="card-header py-3 d-flex justify-content-between title-bar">
                                            <div class="d-flex justify-content-between align-items-center left-bar">
                                                <span class="sort-section-btn mr-2 ctrl-btn sort-down-btn">
                                                    <img class="tar-icon" src="'. base_url("assets/additional_assets/svg/arrow-alt-down.svg") .'">
                                                </span>
                                                <span class="sort-section-btn mr-2 ctrl-btn sort-up-btn">
                                                    <img class="tar-icon" src="'. base_url("assets/additional_assets/svg/arrow-alt-up.svg") .'">
                                                </span>
                                                <div class="v-splite-line"></div>
                                                <input type="checkbox" data-plugin="switchery" name = "is_show_service" data-color="#3DDCF7"   '.($page_content && $page_content->is_show_service == 1 ? "checked" : "") .'/>
                                                <a class="text-uppercase font-weight-bold j-font-size-18px mx-2" data-toggle="collapse" href="#homepage-my-service-body" role="button" aria-expanded="true" aria-controls="homepage-my-service-body">My Services</a>
                                                <span class="j-font-size-13px">(Click on the different buttons, to activate)</span>
                                            </div>
                                            <div class="right-bar">
                                                <div class="lang-bar">
                                                    <span class="'. (explode(",",$this->myRestDetail->website_languages)[0] == 'english' ? 'active' : '')  .' item-flag" data-flag="english"><img class="english-flag" src="'. base_url('assets/flags/en-flag.png').'"></span>
                                                    <span class="'. (explode(",",$this->myRestDetail->website_languages)[0] == 'french' ? 'active' : '')  .' item-flag" data-flag="french"><img class="french-flag" src="'. base_url('assets/flags/fr-flag.png').'"></span>
                                                    <span class="'. (explode(",",$this->myRestDetail->website_languages)[0] == 'germany' ? 'active' : '')  .' item-flag" data-flag="germany"><img class="germany-flag" src="'. base_url('assets/flags/ge-flag.png').'"></span>
                                                </div>
                                                <div class="v-splite-line hide-field"></div>
                                                <span class="close-section-btn hide-field">
                                                    <i class="fa fa-times-circle"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="card-body collapse show" id="homepage-my-service-body">
                                            <div class="form-group row my-4">
                                                <div class="col-md-4 update-service_section_background">
                                                    
                                                    <input type="file" class="dropify" name="service_section_background" data-default-file = "'. $service_section_background .'" value = "'. $service_section_background .'"/>

                                                    <input type="hidden" name="is_update_service_section_background" value = "'. ($service_section_background == "" ? "1" : "0").'" />
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="form-group row">
                                                        <label class="col-md-4 text-center">'. $this->lang->line('Service Top Subject').'</label>
                                                        <div class="input-group french-field hide-field col-md-8 lang-field">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="'. base_url('assets/flags/fr-flag.png').'" ></span>
                                                            </div>
                                                            <input type="text" class="form-control" name="service_top_subject_french" placeholder="EXPÉRIENCE" value="'. (isset($page_content->service_top_subject_french) ? $page_content->service_top_subject_french : "") .'">
                                                        </div>
                                                        <div class="input-group germany-field hide-field col-md-8 lang-field">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="'. base_url('assets/flags/ge-flag.png').'" ></span>
                                                            </div>
                                                            <input type="text" class="form-control" name="service_top_subject_germany" placeholder="ERFAHRUNG" value="'. (isset($page_content->service_top_subject_germany) ? $page_content->service_top_subject_germany:"") .'">
                                                        </div>
                                                        <div class="input-group english-field hide-field col-md-8 lang-field">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="'. base_url('assets/flags/en-flag.png').'" ></span>
                                                            </div>
                                                            <input type="text" class="form-control" name="service_top_subject_english" placeholder="EXPERIENCE" value="'. (isset($page_content->service_top_subject_english) ? $page_content->service_top_subject_english:"") .'">
                                                        </div>
                                                        
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-md-4 text-center">'. $this->lang->line('Service Main Subject').'</label>
                                                        <div class="input-group french-field hide-field col-md-8 lang-field">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="'. base_url('assets/flags/fr-flag.png').'" ></span>
                                                            </div>
                                                            <input type="text" class="form-control" name="service_main_subject_french" placeholder="NOTRE SERVICE" value="'. (isset($page_content->service_main_subject_french) ? $page_content->service_main_subject_french:"" ).'">
                                                        </div>
                                                        <div class="input-group germany-field hide-field col-md-8 lang-field">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="'. base_url('assets/flags/ge-flag.png').'" ></span>
                                                            </div>
                                                            <input type="text" class="form-control" name="service_main_subject_germany" placeholder="UNSER SERVICE" value="'. (isset($page_content->service_main_subject_germany) ? $page_content->service_main_subject_germany:"") .'">
                                                        </div>
                                                        <div class="input-group english-field hide-field col-md-8 lang-field">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="'. base_url('assets/flags/en-flag.png').'" ></span>
                                                            </div>
                                                            <input type="text" class="form-control" name="service_main_subject_english" placeholder="OUR SERVICE" value="'. (isset($page_content->service_main_subject_english) ? $page_content->service_main_subject_english:"") .'">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-md-4 text-center">'. $this->lang->line('Service Description').'</label>
                                                        <div class="input-group french-field hide-field col-md-8 lang-field">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="'. base_url('assets/flags/fr-flag.png').'" ></span>
                                                            </div>
                                                            <input type="text" class="form-control" name="service_description_french" placeholder="LOREM IPSUM DOLOR SIT AMET, CONSECTETUR ADIPISCING ELIT. ALIQUAM CONVALLIS ELEIFEND AUGUE, ID CONSEQUAT EX DICTUM AT." value="'. (isset($page_content->service_description_french) ?$page_content->service_description_french:"") .'">
                                                        </div>
                                                        <div class="input-group germany-field hide-field col-md-8 lang-field">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="'. base_url('assets/flags/ge-flag.png').'" ></span>
                                                            </div>
                                                            <input type="text" class="form-control" name="service_description_germany" placeholder="LOREM IPSUM DOLOR SIT AMET, CONSECTETUR ADIPISCING ELIT. ALIQUAM CONVALLIS ELEIFEND AUGUE, ID CONSEQUAT EX DICTUM AT." value="'. (isset($page_content->service_description_germany) ?$page_content->service_description_germany : "") .'">
                                                        </div>
                                                        <div class="input-group english-field hide-field col-md-8 lang-field">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="'. base_url('assets/flags/en-flag.png').'" ></span>
                                                            </div>
                                                            <input type="text" class="form-control" name="service_description_english" placeholder="LOREM IPSUM DOLOR SIT AMET, CONSECTETUR ADIPISCING ELIT. ALIQUAM CONVALLIS ELEIFEND AUGUE, ID CONSEQUAT EX DICTUM AT." value="'. (isset($page_content->service_description_english) ?$page_content->service_description_english:"") .'">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                '.$service_items_part.'
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            ';
                            
                        ?>
                        <?php if (! $is_welcome_section_exist){ ?> 
                            <!-- Welcome Section -->
                            <section class="homepage-welcome" id="homepage-welcome" data-sort_id="1" data-section_type="homepage-welcome">
                            <?= $welcome_section ?>
                            </section>
                        <?php } ?>
                        <?php if (! $is_service_section_exist){ ?> 
                            <!-- My services Section -->
                            <section class="homepage-my-service" id="homepage-my-service" data-sort_id="2" data-section_type="homepage-my-service">
                            <?= $service_section ?>
                            </section>
                        <?php } ?>
                        <?php foreach ($sectionSort as $skey => $svalue) { 
                            if ($svalue->section_id == "homepage-welcome"){ ?>
                                <section class="homepage-welcome" id="homepage-welcome" data-sort_id="<?=$svalue->sort_num?>" data-section_type="homepage-welcome">
                                    <?= $welcome_section ?>
                                </section>
                            <?php }else if ($svalue->section_id == "homepage-my-service"){ ?>
                                <section class="homepage-my-service" id="homepage-my-service" data-sort_id="<?=$svalue->sort_num?>" data-section_type="homepage-my-service">
                                <?= $service_section ?>
                                </section>
                            <?php }else if ($svalue->section_type == "homepage-text" && $svalue->sSection_id !== NULL){
                                $active_lang = explode(",",$this->myRestDetail->website_languages)[0];
                                $_label = $active_lang . "_content";
                                $section_id = $svalue->section_id;
                                $sort_num = $svalue->sort_num;
                                $text_section_type = $svalue->sType; 
                                $section_heading_label = isset(json_decode($svalue->sHeading)->$_label) ? json_decode($svalue->sHeading)->$_label : json_decode($svalue->sHeading)->content;
                                $url = base_url();
                                if (isset($svalue->sImage) && $svalue->sImage !== ""){
                                    $content_image = base_url("assets/home_images/").$svalue->sImage;
                                }else{
                                    $content_image = "";
                                }
                                $left_align = '
                                    <div class="col-md-4 update-image">
                                        <input type="file" class="dropify" name="home_section_img" data-default-file = "'. $content_image .'" value = "'. $content_image .'"/>

                                        <input type="hidden" name="is_update_home_section_img" value = "" class="is_update_content"/>
                                    </div>
                                ';
                                $right_align_length = 8;
                                if ($text_section_type == '0'){
                                    $left_align = "";
                                    $right_align_length = 12;
                                }
                                $right_align = '
                                    <div class="col-md-'.$right_align_length.'">
                                        <div class="input-group english-field hide-field content-editor lang-field">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="'.$url.'assets/flags/en-flag.png"></span>
                                            </div>
                                            <textarea class="summernote form-control home_section_content" name="page_content_english">'.(isset(json_decode($svalue->sDescription)->english_content) ? json_decode($svalue->sDescription)->english_content : json_decode($svalue->sDescription)->content).'</textarea>
                                        </div>
                                        <div class="input-group french-field hide-field content-editor lang-field">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="'.$url.'assets/flags/fr-flag.png"></span>
                                            </div>
                                            <textarea class="summernote form-control home_section_content" name="page_content_french">'.(isset(json_decode($svalue->sDescription)->french_content) ? json_decode($svalue->sDescription)->french_content : json_decode($svalue->sDescription)->content).'</textarea>
                                        </div>
                                        <div class="input-group germany-field hide-field content-editor lang-field">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="'.$url.'assets/flags/ge-flag.png"></span>
                                            </div>
                                            <textarea class="summernote form-control home_section_content" name="page_content_germany">'.(isset(json_decode($svalue->sDescription)->germany_content) ? json_decode($svalue->sDescription)->germany_content : json_decode($svalue->sDescription)->content).'</textarea>
                                        </div>
                                    </div>
                                ';
                                $is_row_reverse = "";
                                if ($text_section_type == '2'){
                                    $is_row_reverse = "flex-row-reverse";
                                }else if ($text_section_type == '3'){
                                    if (isset($svalue->sImage) && $svalue->sImage !== ""){
                                        if (json_decode($svalue->sImage)[0] !== ""){
                                            $content_image0 = base_url("assets/home_images/").json_decode($svalue->sImage)[0];
                                        }else{
                                            $content_image0 = "";
                                        }
                                        if (json_decode($svalue->sImage)[1] !== ""){
                                            $content_image1 = base_url("assets/home_images/").json_decode($svalue->sImage)[1];
                                        }else{
                                            $content_image1 = "";
                                        }
                                        if (json_decode($svalue->sImage)[2] !== ""){
                                            $content_image2 = base_url("assets/home_images/").json_decode($svalue->sImage)[2];
                                        }else{
                                            $content_image2 = "";
                                        }
                                        if (json_decode($svalue->sImage)[3] !== ""){
                                            $content_image3 = base_url("assets/home_images/").json_decode($svalue->sImage)[3];
                                        }else{
                                            $content_image3 = "";
                                        }
                                    }
                                    $left_align = '
                                        <div class="col-md-4">
                                            <div class="row">
                                                <div class="col-md-6 mb-1  update-image">
                                                    <input type="file" class="dropify" name="home_section_img0" data-default-file = "'.$content_image0.'" value = "'.$content_image0.'"/>
                                                    <input type="hidden" name="is_update_home_section_img0" value = "0" class="is_update_content"/>
                                                </div>
                                                <div class="col-md-6 mb-1  update-image">
                                                    <input type="file" class="dropify" name="home_section_img1" data-default-file = "'.$content_image1.'" value = "'.$content_image1.'"/>
                                                    <input type="hidden" name="is_update_home_section_img1" value = "0" class="is_update_content"/>
                                                </div>
                                                <div class="col-md-6  update-image">
                                                    <input type="file" class="dropify" name="home_section_img2" data-default-file = "'.$content_image2.'" value = "'.$content_image2.'"/>
                                                    <input type="hidden" name="is_update_home_section_img2" value = "0" class="is_update_content"/>
                                                </div>
                                                <div class="col-md-6  update-image">
                                                    <input type="file" class="dropify" name="home_section_img3" data-default-file = "'.$content_image3.'" value = "'.$content_image3.'"/>
                                                    <input type="hidden" name="is_update_home_section_img3" value = "0" class="is_update_content"/>
                                                </div>
                                            </div>
                                        </div> 
                                    ';
                                }else{

                                }
                                $text_section = '
                                    <form class="updateHomepageTextSection" method="post" enctype="multipart/form-data">
                                        <input type="hidden" name="home_text_section_type" value="'.$text_section_type.'">
                                        <input type="hidden" name="sort_num" value="'.$sort_num.'">
                                        <input type="hidden" name="section_type" value="'.$svalue->section_type.'">
                                        <input type="hidden" name="section_id" value="'.$section_id.'">
                                        <input type="hidden" name="sId" value="'.$svalue->sId.'">
                                        <div class="card shadow mb-4">
                                            <div class="card-header py-3 d-flex justify-content-between title-bar">
                                                <div class="d-flex justify-content-between align-items-center left-bar">
                                                    <span class="sort-section-btn mr-2 ctrl-btn sort-down-btn">
                                                        <img class="tar-icon" src="'.$url.'assets/additional_assets/svg/arrow-alt-down.svg">
                                                    </span>
                                                    <span class="sort-section-btn mr-2 ctrl-btn sort-up-btn">
                                                        <img class="tar-icon" src="'.$url.'assets/additional_assets/svg/arrow-alt-up.svg">
                                                    </span>
                                                    <div class="v-splite-line"></div>
                                                    <input type="checkbox" data-plugin="switchery" name = "is_show_section" data-color="#3DDCF7" '. ( (isset($svalue->is_show_section) && $svalue->is_show_section == 1) ? "checked" : "" ) .'/>
                                                    <a class="section_title text-uppercase font-weight-bold j-font-size-18px mx-2" data-toggle="collapse" href="#'.$section_id.'-body" role="button" aria-expanded="true" aria-controls="'.$section_id.'-body">'.$section_heading_label.'</a>
                                                </div>
                                                <div class="right-bar">
                                                    <div class="lang-bar">
                                                        <span class="'. (explode(",",$this->myRestDetail->website_languages)[0] == 'english' ? 'active' : '')  .' item-flag" data-flag="english"><img class="english-flag" src="'. base_url('assets/flags/en-flag.png').'"></span>
                                                        <span class="'. (explode(",",$this->myRestDetail->website_languages)[0] == 'french' ? 'active' : '')  .' item-flag" data-flag="french"><img class="french-flag" src="'. base_url('assets/flags/fr-flag.png').'"></span>
                                                        <span class="'. (explode(",",$this->myRestDetail->website_languages)[0] == 'germany' ? 'active' : '')  .' item-flag" data-flag="germany"><img class="germany-flag" src="'. base_url('assets/flags/ge-flag.png').'"></span>
                                                    </div>
                                                    <div class="v-splite-line"></div>
                                                    <span class="close-section-btn">
                                                        <i class="fa fa-times-circle"></i>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="card-body collapse show" id="'.$section_id.'-body">
                                                <div class="form-group row">
                                                    <label class="col-md-4 text-center">'.$this->lang->line("Section Heading").'</label>
                                                    <div class="input-group french-field hide-field col-md-8 lang-field">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="'.$url.'assets/flags/fr-flag.png"></span>
                                                        </div>
                                                        <input type="text" class="form-control home_section_heading" name="section_heading_french" placeholder="Welcome" value="'.(isset(json_decode($svalue->sHeading)->french_content) ? json_decode($svalue->sHeading)->french_content : json_decode($svalue->sHeading)->content).'">
                                                    </div>
                                                    <div class="input-group germany-field hide-field col-md-8 lang-field">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="'.$url.'assets/flags/ge-flag.png"></span>
                                                        </div>
                                                        <input type="text" class="form-control home_section_heading" name="section_heading_germany" placeholder="Welcome" value="'.(isset(json_decode($svalue->sHeading)->germany_content) ? json_decode($svalue->sHeading)->germany_content : json_decode($svalue->sHeading)->content).'">
                                                    </div>
                                                    <div class="input-group english-field hide-field col-md-8 lang-field">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="'.$url.'assets/flags/en-flag.png">
                                                            </span>
                                                        </div>
                                                        <input type="text" class="form-control home_section_heading" name="section_heading_english" placeholder="Welcome" value="'.(isset(json_decode($svalue->sHeading)->english_content) ? json_decode($svalue->sHeading)->english_content : json_decode($svalue->sHeading)->content).'">
                                                    </div>
                                                </div>
                                                <div class="form-group row '.$is_row_reverse.'">
                                                    '.$left_align.'
                                                    '.$right_align.'
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-sm-12 mx-auto mb-3 mb-sm-0">
                                                        <input type="submit" name="" value="SAVE" class="btn btn-danger btn-user btn-block submit-btn">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                '; ?>
                                <section class="homepage-text" id="<?=$section_id?>" data-sort_id="<?=$sort_num?>" data-section_type="<?=$svalue->section_type?>">
                                <?= $text_section ?>
                                </section>
                            <?php }else if ($svalue->section_type == "homepage-gallery" && $svalue->gSection_id !== NULL){ 
                                $active_lang = explode(",",$this->myRestDetail->website_languages)[0];
                                $_label = $active_lang . "_content";
                                $section_id = $svalue->section_id;
                                $sort_num = $svalue->sort_num;
                                $section_heading_label = isset(json_decode($svalue->gHeading)->$_label) ? json_decode($svalue->gHeading)->$_label : json_decode($svalue->gHeading)->content;
                                $url = base_url();
                                $gallerImgDivList = "";
                                $gGalleryArr = json_decode($svalue->gGallery);
                                foreach ($gGalleryArr as $gkey => $gvalue) {
                                    if (isset($gvalue->img) && $gvalue->img !== ""){
                                        $content_image = base_url("assets/home_images/gallery/").$gvalue->img;
                                    }else{
                                        $content_image = "";
                                    }
                                    $gallerImgDivList .= '
                                        <div class="col-sm-4 col-md-2 gallerImgDiv">
                                            <input type="file" class="dropify" name="home_gallery_img[]" value = "'.$content_image.'" data-default-file = "'. $content_image .'" />
                                            <input type="text" class="form-control mt-1 mb-3" placeholder="Image Text" name="home_gallery_text[]" value="'.$gvalue->txt.'">
                                            <input type="hidden" name="is_update_gallery_img[]" value="0" class="is_update_gallery_img">
                                            <input type="hidden" name="gallery_old_img[]" value="'.$gvalue->img.'" class="gallery_old_img">
                                            <i class="fa fa-times imgDivDelBtn"></i>
                                        </div>
                                    ';
                                }
                                $gallery_section = '
                                    <form class="updateHomepageGallerySection" method="post" enctype="multipart/form-data">
                                        <input type="hidden" name="sort_num" value="'.$sort_num.'">
                                        <input type="hidden" name="section_id" value="'.$section_id.'">
                                        <input type="hidden" name="gId" value="'.$svalue->gId.'">
                                        <input type="hidden" name="section_type" value="'.$svalue->section_type.'">
                                        <div class="card shadow mb-4">
                                            <div class="card-header py-3 d-flex justify-content-between title-bar">
                                                <div class="d-flex justify-content-between align-items-center left-bar">
                                                    <span class="sort-section-btn mr-2 ctrl-btn sort-down-btn">
                                                        <img class="tar-icon" src="'.$url.'assets/additional_assets/svg/arrow-alt-down.svg">
                                                    </span>
                                                    <span class="sort-section-btn mr-2 ctrl-btn sort-up-btn">
                                                        <img class="tar-icon" src="'.$url.'assets/additional_assets/svg/arrow-alt-up.svg">
                                                    </span>
                                                    <div class="v-splite-line"></div>
                                                    <input type="checkbox" data-plugin="switchery" name = "is_show_section" data-color="#3DDCF7" '. ( (isset($svalue->is_show_section) && $svalue->is_show_section == 1) ? "checked" : "" ) .'/>
                                                    <a class="section_title text-uppercase font-weight-bold j-font-size-18px mx-2" data-toggle="collapse" href="#'.$section_id.'-body" role="button" aria-expanded="true" aria-controls="'.$section_id.'-body">'.$section_heading_label.'</a>
                                                </div>
                                                <div class="right-bar">
                                                    <div class="lang-bar">
                                                        <span class="'. (explode(",",$this->myRestDetail->website_languages)[0] == 'english' ? 'active' : '')  .' item-flag" data-flag="english"><img class="english-flag" src="'. base_url('assets/flags/en-flag.png').'"></span>
                                                        <span class="'. (explode(",",$this->myRestDetail->website_languages)[0] == 'french' ? 'active' : '')  .' item-flag" data-flag="french"><img class="french-flag" src="'. base_url('assets/flags/fr-flag.png').'"></span>
                                                        <span class="'. (explode(",",$this->myRestDetail->website_languages)[0] == 'germany' ? 'active' : '')  .' item-flag" data-flag="germany"><img class="germany-flag" src="'. base_url('assets/flags/ge-flag.png').'"></span>
                                                    </div>
                                                    <div class="v-splite-line"></div>
                                                    <span class="close-section-btn">
                                                        <i class="fa fa-times-circle"></i>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="card-body collapse show" id="'.$section_id.'-body">
                                                <div class="form-group row">
                                                    <label class="col-md-4 text-center">'.$this->lang->line("Section Heading").'</label>
                                                    <div class="input-group french-field hide-field col-md-8 lang-field">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="'.$url.'assets/flags/fr-flag.png"></span>
                                                        </div>
                                                        <input type="text" class="form-control home_section_heading" name="section_heading_french" placeholder="Welcome" value="'.(isset(json_decode($svalue->gHeading)->french_content) ? json_decode($svalue->gHeading)->french_content : json_decode($svalue->gHeading)->content).'">
                                                    </div>
                                                    <div class="input-group germany-field hide-field col-md-8 lang-field">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="'.$url.'assets/flags/ge-flag.png"></span>
                                                        </div>
                                                        <input type="text" class="form-control home_section_heading" name="section_heading_germany" placeholder="Welcome" value="'.(isset(json_decode($svalue->gHeading)->germany_content) ? json_decode($svalue->gHeading)->germany_content : json_decode($svalue->gHeading)->content).'">
                                                    </div>
                                                    <div class="input-group english-field hide-field col-md-8 lang-field">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="'.$url.'assets/flags/en-flag.png">
                                                            </span>
                                                        </div>
                                                        <input type="text" class="form-control home_section_heading" name="section_heading_english" placeholder="Welcome" value="'.(isset(json_decode($svalue->gHeading)->english_content) ? json_decode($svalue->gHeading)->english_content : json_decode($svalue->gHeading)->content).'">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="container">
                                                        <div class="row">
                                                            '.$gallerImgDivList.'
                                                            <span class="imgAddBtnSpan"><i class="fa fa-plus-circle imgAddBtn text-primary"></i></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-sm-12 mx-auto mb-3 mb-sm-0">
                                                        <input type="submit" name="" value="SAVE" class="btn btn-danger btn-user btn-block submit-btn">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                '; ?>
                                <section class="homepage-gallery" id="<?=$section_id?>" data-sort_id="<?=$sort_num?>" data-section_type="<?=$svalue->section_type?>">
                                <?= $gallery_section ?>
                                </section>
                            <?php }
                        } ?>
                
                        <section class="new_section">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3 d-flex justify-content-center">
                                    <button type = "button" class="btn bg-secondary text-white" id="add_new_section_btn">+ <?= $this->lang->line("Add Section")?></button>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            
            </div>
        </div>
        <!-- /.container-fluid -->

        <div id="new-section-type-select" class="modal fade" role="dialog">
            <div class="modal-dialog">

            <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="card shadow">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary"><?= $this->lang->line("Select New Section Type") ?></h6>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <div class="col-sm-12 mb-3 mb-sm-0">
                                        <?php 
                                            $section_type = array(
                                                'homepage-text'         => $this->lang->line("Text section"),
                                                'homepage-gallery'      => $this->lang->line("Gallery Section"),
                                                'homepage-delivery'     => $this->lang->line("Delivery Section"),
                                                'homepage-announcement' => $this->lang->line("Announcement Section"),
                                                'homepage-jobs' => $this->lang->line("Jobs Section"),
                                            );
                                            foreach ($section_type as $stkey => $stvalue) { ?>
                                                <div class="radio align-items-center d-flex mb-3">
                                                    <input type="radio" class="section_type" name="section_type" id="<?= $stkey?>" value="<?= $stkey?>"  <?= $stkey == "homepage-text" ? "checked" : "" ?>>
                                                    <label for="<?= $stkey?>" class="mb-0 ml-3">
                                                        <?= $stvalue?>
                                                    </label>
                                                </div>
                                                <?php if ($stkey == "homepage-text"){ ?>
                                                    <div class="d-flex justify-content-around mb-3 homepage-text-div">
                                                    <?php for ($tt=0; $tt < 4; $tt++) { ?>
                                                        <label class="home-text-type <?= $tt == 1 ? "active" : "" ?> mb-0">
                                                            <input type="radio" class="d-none home-text-type-box" name="home-text-type-box" value="<?= $tt?>" id="home-text-type-box-<?= $tt?>" <?= $tt == 1 ? "checked" : "" ?>>
                                                            <img src="<?= base_url("assets/additional_assets/svg/text-section-".$tt.".svg") ?>">
                                                        </label>
                                                    <?php } ?>
                                                    </div>
                                                <?php } ?>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-between">
                        <button type="button" class="btn btn-primary" data-dismiss="modal" id="select_section_type_btn"><?=$this->lang->line('Add Section')?></button>
                        <button type="button" class="btn btn-default" data-dismiss="modal"><?=$this->lang->line('Close')?></button>
                    </div>
                </div>
            </div>
        </div>
<script type="text/javascript">
    $(document).on('click','.update-service_section_background .dropify-clear',function(){
        $("input[name='is_update_service_section_background']").val("1");
    });
    $(document).on('click','.update-image .dropify-clear',function(){
        $("input[name='is_update_content']").val("1");
        $(this).parents('.update-image').find(".is_update_content").val("1");
    });
    $(document).on('click','.gallerImgDiv .dropify-clear',function(){
        $(this).parents('.gallerImgDiv').find('.gallery_old_img').val("");
        $(this).parents('.gallerImgDiv').find('.is_update_gallery_img').val("1");
    });
    $(document).on('click','.gallerImgDiv .dropify-clear',function(){
        $(this).parents('.gallerImgDiv').find('.gallery_old_img').val("");
        $(this).parents('.gallerImgDiv').find('.is_update_gallery_img').val("1");
    });
</script>
