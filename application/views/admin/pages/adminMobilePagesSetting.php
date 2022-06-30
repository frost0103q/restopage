        <!-- Begin Page Content -->
        <?php
            $mobile_about_page_content_english = $mobile_about_page_content_french = $mobile_about_page_content_germany = $mobile_about_page_content = "";
            if (isset($mobile_about_page)){
                $mobile_about_page_text = json_decode($mobile_about_page->option_value);
                if ($mobile_about_page_text->mobile_about_page_content){
                    $mobile_about_page_content_english = $mobile_about_page_content_french = $mobile_about_page_content_germany = $mobile_about_page_content = $mobile_about_page_text->mobile_about_page_content;
                }
            }      

            $mobile_terms_page_content_english = $mobile_terms_page_content_french = $mobile_terms_page_content_germany = $mobile_terms_page_content = "";
            if (isset($mobile_terms_page)){
                $mobile_terms_page_text = json_decode($mobile_terms_page->option_value);
                if ($mobile_terms_page_text->mobile_terms_page_content){
                    $mobile_terms_page_content_english = $mobile_terms_page_content_french = $mobile_terms_page_content_germany = $mobile_terms_page_content = $mobile_terms_page_text->mobile_terms_page_content;
                }
            }        
        ?>
        <div class="container-fluid legalSetting-page multi-lang-page" data-url ="<?= base_url('/')?>" >
            <div class="row">
                <div class="col-md-12 ">
                    <div class="content_wrap tab-content">
                        <form action="updateMobilePageSetting" method="post" enctype="multipart/form-data" id="updateMobilePageSetting">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3 d-flex justify-content-between title-bar">
                                    <h4 class="mb-0 text-capitalize"><?= $this->lang->line("mobile")?> <?= $this->lang->line("Page Settings")?></h4>
                                    <div class="lang-bar">
                                        <span class="<?= $_lang == 'english' ? 'active' : ''  ?> item-flag" data-flag="english"><img class="english-flag" src="<?= base_url('assets/flags/en-flag.png')?>"></span>
                                        <span class="<?= $_lang == 'french' ? 'active' : ''  ?> item-flag" data-flag="french"><img class="french-flag" src="<?= base_url('assets/flags/fr-flag.png')?>"></span>
                                        <span class="<?= $_lang == 'germany' ? 'active' : ''  ?> item-flag" data-flag="germany"><img class="germany-flag" src="<?= base_url('assets/flags/ge-flag.png')?>"></span>
                                    </div>
                                </div>
                                <div class="card-body mt-4 p-lg-5 p-md-4 p-2">
                                    <div class="form-group">
                                        <section class="mobile-about-section">

                                            <h6 class="text-capitalize"><?= $this->lang->line("mobile") ?> <?= $this->lang->line("about") ?> <?= $this->lang->line("Page") ?></h6>
                                            <hr>
                                            <div class="input-group french-field hide-field lang-field">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/fr-flag.png')?>" ></span>
                                                </div>
                                                <textarea class=" summernote form-control" name="mobile_about_content_french"  placeholder = "" ><?=isset($mobile_about_page) && isset($mobile_about_page_text->mobile_about_page_content_french ) && ($mobile_about_page_text->mobile_about_page_content_french !== "") ? $mobile_about_page_text->mobile_about_page_content_french : $mobile_about_page_content_french?></textarea>
                                            </div>
                                            <div class="input-group english-field hide-field lang-field">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/en-flag.png')?>" ></span>
                                                </div>
                                                <textarea class=" summernote form-control" name="mobile_about_content_english"  placeholder = "" ><?=isset($mobile_about_page) && isset($mobile_about_page_text->mobile_about_page_content_english ) && ($mobile_about_page_text->mobile_about_page_content_english !== "") ? $mobile_about_page_text->mobile_about_page_content_english : $mobile_about_page_content_english?></textarea>
                                            </div>
                                            <div class="input-group germany-field hide-field lang-field">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/ge-flag.png')?>" ></span>
                                                </div>
                                                <textarea class=" summernote form-control" name="mobile_about_content_germany"  placeholder = "" ><?=isset($mobile_about_page) && isset($mobile_about_page_text->mobile_about_page_content_germany ) && ($mobile_about_page_text->mobile_about_page_content_germany !== "") ? $mobile_about_page_text->mobile_about_page_content_germany : $mobile_about_page_content_germany?></textarea>
                                            </div>
                                        </section>
                                        <section class="mobile-terms-section mt-5">

                                            <h6 class="text-capitalize"><?= $this->lang->line("mobile") ?> <?= $this->lang->line("terms") ?> <?= $this->lang->line("Page") ?></h6>
                                            <hr>
                                            <div class="input-group french-field hide-field lang-field">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/fr-flag.png')?>" ></span>
                                                </div>
                                                <textarea class=" summernote form-control" name="mobile_terms_content_french"  placeholder = "" ><?=isset($mobile_terms_page) && isset($mobile_terms_page_text->mobile_terms_page_content_french ) && ($mobile_terms_page_text->mobile_terms_page_content_french !== "") ? $mobile_terms_page_text->mobile_terms_page_content_french : $mobile_terms_page_content_french?></textarea>
                                            </div>
                                            <div class="input-group english-field hide-field lang-field">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/en-flag.png')?>" ></span>
                                                </div>
                                                <textarea class=" summernote form-control" name="mobile_terms_content_english"  placeholder = "" ><?=isset($mobile_terms_page) && isset($mobile_terms_page_text->mobile_terms_page_content_english ) && ($mobile_terms_page_text->mobile_terms_page_content_english !== "") ? $mobile_terms_page_text->mobile_terms_page_content_english : $mobile_terms_page_content_english?></textarea>
                                            </div>
                                            <div class="input-group germany-field hide-field lang-field">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/ge-flag.png')?>" ></span>
                                                </div>
                                                <textarea class=" summernote form-control" name="mobile_terms_content_germany"  placeholder = "" ><?=isset($mobile_terms_page) && isset($mobile_terms_page_text->mobile_terms_page_content_germany ) && ($mobile_terms_page_text->mobile_terms_page_content_germany !== "") ? $mobile_terms_page_text->mobile_terms_page_content_germany : $mobile_terms_page_content_germany?></textarea>
                                            </div>
                                        </section>
                                    </div>
                                    <div class="col-sm-12 mx-auto mb-3 mt-md-5 mt-3 mb-sm-0">
                                        <input type="submit" name="" value="<?= $this->lang->line('SAVE')?>" class="btn btn-danger btn-user btn-block submit-btn">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            
            </div>
        </div>
        <!-- /.container-fluid -->
        </div>
        <!-- End of Main Content -->
