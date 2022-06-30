        <!-- Begin Page Content -->
        <div class="container-fluid legalSetting-page multi-lang-page" data-url ="<?= base_url('/')?>" >
            <div class="row">
                <div class="col-md-12 ">
                    <div class="content_wrap tab-content">
                        <form action="updateLegalSetting" method="post" enctype="multipart/form-data" id="updateLegalSetting">
                            <input type="hidden" name="rest_id" value = "<?= $myRestId?>">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3 d-flex justify-content-between title-bar">
                                    <h4 class="mb-0"><?= $this->lang->line("Legal")?> <?= $this->lang->line("Page Settings")?></h4>
                                    <div class="lang-bar">
                                        <span class="<?= explode(",",$this->myRestDetail->website_languages)[0] == 'english' ? 'active' : ''  ?> item-flag" data-flag="english"><img class="english-flag" src="<?= base_url('assets/flags/en-flag.png')?>"></span>
                                        <span class="<?= explode(",",$this->myRestDetail->website_languages)[0] == 'french' ? 'active' : ''  ?> item-flag" data-flag="french"><img class="french-flag" src="<?= base_url('assets/flags/fr-flag.png')?>"></span>
                                        <span class="<?= explode(",",$this->myRestDetail->website_languages)[0] == 'germany' ? 'active' : ''  ?> item-flag" data-flag="germany"><img class="germany-flag" src="<?= base_url('assets/flags/ge-flag.png')?>"></span>
                                    </div>
                                </div>
                                <div class="card-body mt-4 p-lg-5 p-md-4 p-2">
                                    <div class="form-group">
                                        <section class="imprint-section">

                                            <h6 class=""><?= $this->lang->line("Imprint") ?> <?= $this->lang->line("Page") ?></h6>
                                            <hr>
                                            <div class="input-group french-field hide-field lang-field">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/fr-flag.png')?>" ></span>
                                                </div>
                                                <textarea class=" summernote form-control" name="imprint_page_content_french"  placeholder = "" ><?=isset($legal_page_settings) ? $legal_page_settings->imprint_page_content_french : ($standard_legal_page_settings ? $standard_legal_page_settings->imprint_page_content_french : "")?></textarea>
                                            </div>
                                            <div class="input-group english-field hide-field lang-field">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/en-flag.png')?>" ></span>
                                                </div>
                                                <textarea class=" summernote form-control" name="imprint_page_content_english"  placeholder = "" ><?=isset($legal_page_settings) ? $legal_page_settings->imprint_page_content_english : ($standard_legal_page_settings ? $standard_legal_page_settings->imprint_page_content_english : "")?></textarea>
                                            </div>
                                            <div class="input-group germany-field hide-field lang-field">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/ge-flag.png')?>" ></span>
                                                </div>
                                                <textarea class=" summernote form-control" name="imprint_page_content_germany"  placeholder = "" ><?=isset($legal_page_settings) ? $legal_page_settings->imprint_page_content_germany : ($standard_legal_page_settings ? $standard_legal_page_settings->imprint_page_content_germany : "")?></textarea>
                                            </div>
                                        </section>
                                        <section class="data-protect-section mt-5">
                                            <h6 class=""><?= $this->lang->line("Data Protection") ?> <?= $this->lang->line("Page") ?></h6>
                                            <hr>
                                            <div class="input-group french-field hide-field lang-field">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/fr-flag.png')?>" ></span>
                                                </div>
                                                <textarea class=" summernote form-control" name="data_protection_page_content_french"  placeholder = "" ><?=isset($legal_page_settings) ? $legal_page_settings->data_protection_page_content_french : ($standard_legal_page_settings ? $standard_legal_page_settings->data_protection_page_content_french : "")?></textarea>
                                            </div>
                                            <div class="input-group english-field hide-field lang-field">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/en-flag.png')?>" ></span>
                                                </div>
                                                <textarea class=" summernote form-control" name="data_protection_page_content_english"  placeholder = "" ><?=isset($legal_page_settings) ? $legal_page_settings->data_protection_page_content_english : ($standard_legal_page_settings ? $standard_legal_page_settings->data_protection_page_content_english : "")?></textarea>
                                            </div>
                                            <div class="input-group germany-field hide-field lang-field">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/ge-flag.png')?>" ></span>
                                                </div>
                                                <textarea class=" summernote form-control" name="data_protection_page_content_germany"  placeholder = "" ><?=isset($legal_page_settings) ? $legal_page_settings->data_protection_page_content_germany : ($standard_legal_page_settings ? $standard_legal_page_settings->data_protection_page_content_germany : "")?></textarea>
                                            </div>
                                        </section>
                                        <section class="tc-section mt-5">
                                            <h6 class=""><?= $this->lang->line("Terms and Conditions") ?> <?= $this->lang->line("Page") ?></h6>
                                            <hr>
                                            <div class="input-group french-field hide-field lang-field">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/fr-flag.png')?>" ></span>
                                                </div>
                                                <textarea class=" summernote form-control" name="tc_page_content_french"  placeholder = "" ><?=isset($legal_page_settings) ? $legal_page_settings->tc_page_content_french : ($standard_legal_page_settings ? $standard_legal_page_settings->tc_page_content_french : "")?></textarea>
                                            </div>
                                            <div class="input-group english-field hide-field lang-field">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/en-flag.png')?>" ></span>
                                                </div>
                                                <textarea class=" summernote form-control" name="tc_page_content_english"  placeholder = "" ><?=isset($legal_page_settings) ? $legal_page_settings->tc_page_content_english : ($standard_legal_page_settings ? $standard_legal_page_settings->tc_page_content_english : "")?></textarea>
                                            </div>
                                            <div class="input-group germany-field hide-field lang-field">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/ge-flag.png')?>" ></span>
                                                </div>
                                                <textarea class=" summernote form-control" name="tc_page_content_germany"  placeholder = "" ><?=isset($legal_page_settings) ? $legal_page_settings->tc_page_content_germany : ($standard_legal_page_settings ? $standard_legal_page_settings->tc_page_content_germany : "")?></textarea>
                                            </div>
                                        </section>
                                        <section class="cookie-text-section mt-5">
                                            <h6 class=""><?= $this->lang->line("Cookie Note") ?> </h6>
                                            <hr>
                                            <div class="input-group french-field hide-field lang-field">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/fr-flag.png')?>" ></span>
                                                </div>
                                                <textarea class=" summernote form-control" name="cookie_note_french"  placeholder = "" ><?=isset($legal_page_settings) ? $legal_page_settings->cookie_note_french : ($standard_legal_page_settings ? $standard_legal_page_settings->cookie_note_french : "")?></textarea>
                                            </div>
                                            <div class="input-group english-field hide-field lang-field">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/en-flag.png')?>" ></span>
                                                </div>
                                                <textarea class=" summernote form-control" name="cookie_note_english"  placeholder = "" ><?=isset($legal_page_settings) ? $legal_page_settings->cookie_note_english : ($standard_legal_page_settings ? $standard_legal_page_settings->cookie_note_english : "")?></textarea>
                                            </div>
                                            <div class="input-group germany-field hide-field lang-field">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/ge-flag.png')?>" ></span>
                                                </div>
                                                <textarea class=" summernote form-control" name="cookie_note_germany"  placeholder = "" ><?=isset($legal_page_settings) ? $legal_page_settings->cookie_note_germany : ($standard_legal_page_settings ? $standard_legal_page_settings->cookie_note_germany : "")?></textarea>
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
        
<script type="text/javascript">

$(document).on('click','.update-image .dropify-clear',function(){
    slider_index = $(this).parent().find(".dropify").attr("data-slider-index");
    $("input[name='is_update"+slider_index+"']").val("1");
});
</script>
