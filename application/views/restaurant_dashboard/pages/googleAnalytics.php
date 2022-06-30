<?php
    if (isset($seo->seo_titles)){
        $seo_titles = json_decode($seo->seo_titles);
    }else{
        $seo_titles = null;
    }
    if (isset($seo->seo_descriptions)){
        $seo_descriptions = json_decode($seo->seo_descriptions);
    }else{
        $seo_titles = null;
    }

?>
<div class="container">
    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-header py-3 d-flex justify-content-between title-bar">
            <h1 class="h4 text-gray-900 mb-0 text-capitalize"><?= $this->lang->line('Restaurant')?> google <?= $this->lang->line('analytics')?></h1>
        </div>
        <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="py-5 px-md-5 px-3">
                        <form class="user" id="restaurantSEOSetting">
                            <input type="hidden" name="rest_id" value="<?= $myRestId?>">
                            <input type="hidden" name="is_google_analytics" value="true">
                            <section class="header-setting my-2">
                                <h4> <?=$this->lang->line("Header")?> </h4>
                                <hr/>
                                <div class="input-group english-field hide-field lang-field">
                                    <textarea class="summernote form-control" name="header_seo_content_english"><?= isset($seo) ? $seo->seo_header_content_english : "" ?></textarea>
                                </div>
                                <div class="input-group french-field hide-field lang-field">
                                    <textarea class="summernote form-control" name="header_seo_content_french"><?= isset($seo) ? $seo->seo_header_content_french : "" ?></textarea>
                                </div>
                                <div class="input-group germany-field hide-field lang-field">
                                    <textarea class="summernote form-control" name="header_seo_content_germany"><?= isset($seo) ? $seo->seo_header_content_germany : "" ?></textarea>
                                </div>
                            </section>
                            <section class="footer-setting mt-5">
                                <h4> <?=$this->lang->line("Footer")?> </h4>
                                <hr/>
                                <div class="input-group english-field hide-field lang-field">
                                    <textarea class="summernote form-control" name="footer_seo_content_english"><?= isset($seo) ? $seo->seo_footer_content_english : "" ?></textarea>
                                </div>
                                <div class="input-group french-field hide-field lang-field">
                                    <textarea class="summernote form-control" name="footer_seo_content_french"><?= isset($seo) ? $seo->seo_footer_content_french : "" ?></textarea>
                                </div>
                                <div class="input-group germany-field hide-field lang-field">
                                    <textarea class="summernote form-control" name="footer_seo_content_germany"><?= isset($seo) ? $seo->seo_footer_content_germany : "" ?></textarea>
                                </div>
                            </section>
                            <input type="submit" value="Update Setting" class="btn btn-primary btn-user btn-block mt-4">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

