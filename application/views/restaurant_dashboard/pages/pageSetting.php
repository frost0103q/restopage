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
                                <section class="homepage-welcome" id="homepage-welcome" data-sort_id="1">
                                    <form class="editHomepage" action="'.base_url('Restaurant/editMainPage').'" method="post" enctype="multipart/form-data">
                                        <input type="hidden" name="rest_id" value = "'. $myRestId.'">
                                        <input type="hidden" name="what_setting" value = "homepage">
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
                                                    <div class="v-splite-line"></div>
                                                    <span class="close-section-btn">
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
                                </section>
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
                                <section class="homepage-my-service" id="homepage-my-service" data-sort_id="2">
                                    <form class="editHomepage" action="'.base_url('Restaurant/editMainPage').'" method="post" enctype="multipart/form-data">
                                        <input type="hidden" name="rest_id" value = "'. $myRestId.'">
                                        <input type="hidden" name="what_setting" value = "homepage">
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
                                                    <div class="v-splite-line"></div>
                                                    <span class="close-section-btn">
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
                                </section>
                            ';
                            
                        ?>
                        <?php if (! $is_welcome_section_exist){ ?> 
                            <!-- Welcome Section -->
                            <?= $welcome_section ?>
                        <?php } ?>
                        <?php if (! $is_service_section_exist){ ?> 
                            <!-- My services Section -->
                            <?= $service_section ?>
                        <?php } ?>
                        <?php foreach ($sectionSort as $skey => $svalue) { 
                            if ($svalue->section_id == "homepage-welcome"){ ?>
                                <?= $welcome_section ?>
                            <?php }else if ($svalue->section_id == "homepage-my-service"){ ?>
                                <?= $service_section ?>
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
    });
</script>
