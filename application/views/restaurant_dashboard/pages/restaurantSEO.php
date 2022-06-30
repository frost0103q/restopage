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
<div class="container multi-lang-page">
    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-header py-3 d-flex justify-content-between title-bar">
            <h1 class="h4 text-gray-900 mb-0"><?= $this->lang->line('Restaurant')?> <?= $this->lang->line('SEO')?> <?= $this->lang->line('Setting')?></h1>
            <div class="lang-bar">
                <span class="<?= explode(",",$this->myRestDetail->website_languages)[0] == 'english' ? 'active' : ''  ?> item-flag" data-flag="english"><img class="english-flag" src="<?= base_url('assets/flags/en-flag.png')?>"></span>
                <span class="<?= explode(",",$this->myRestDetail->website_languages)[0] == 'french' ? 'active' : ''  ?> item-flag" data-flag="french"><img class="french-flag" src="<?= base_url('assets/flags/fr-flag.png')?>"></span>
                <span class="<?= explode(",",$this->myRestDetail->website_languages)[0] == 'germany' ? 'active' : ''  ?> item-flag" data-flag="germany"><img class="germany-flag" src="<?= base_url('assets/flags/ge-flag.png')?>"></span>
            </div>
        </div>
        <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="py-5 px-md-5 px-3">
                        <form class="user" id="restaurantSEOSetting">
                            <input type="hidden" name="rest_id" value="<?= $myRestId?>">
                            <section class="home-page-setting mt-5">
                                <h4> <?=$this->lang->line("Homepage")?> </h4>
                                <hr/>
                                <div class="form-group row english-field hide-field lang-field">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <label><?= $this->lang->line('Title')?></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/en-flag.png')?>" ></span>
                                            </div>
                                            <input type="text" name="home_title_english" class="form-control" value="<?= isset($seo_titles->home_title_english) ? $seo_titles->home_title_english : "" ?>">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <label><?= $this->lang->line('Description')?></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/en-flag.png')?>" ></span>
                                            </div>
                                            <input type="text" name="home_desc_english" class="form-control"  value="<?= isset($seo_descriptions->home_desc_english) ? $seo_descriptions->home_desc_english : "" ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row french-field hide-field lang-field">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <label><?= $this->lang->line('Title')?></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/fr-flag.png')?>" ></span>
                                            </div>
                                            <input type="text" name="home_title_french" class="form-control"  value="<?= isset($seo_titles->home_title_french) ? $seo_titles->home_title_french : "" ?>">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <label><?= $this->lang->line('Description')?></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/fr-flag.png')?>" ></span>
                                            </div>
                                            <input type="text" name="home_desc_french" class="form-control"  value="<?= isset($seo_descriptions->home_desc_french) ? $seo_descriptions->home_desc_french : "" ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row germany-field hide-field lang-field">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <label><?= $this->lang->line('Title')?></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/ge-flag.png')?>" ></span>
                                            </div>
                                            <input type="text" name="home_title_germany" class="form-control"  value="<?= isset($seo_titles->home_title_germany) ? $seo_titles->home_title_germany : "" ?>">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <label><?= $this->lang->line('Description')?></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/ge-flag.png')?>" ></span>
                                            </div>
                                            <input type="text" name="home_desc_germany" class="form-control"  value="<?= isset($seo_descriptions->home_desc_germany) ? $seo_descriptions->home_desc_germany : "" ?>">
                                        </div>
                                    </div>
                                </div>
                               
                            </section>
                            <section class="reservation-page-setting mt-5">
                                <h4> <?=$this->lang->line("Reservation")?>  <?=$this->lang->line("Page")?> </h4>
                                <hr/>
                                <div class="form-group row english-field hide-field lang-field">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <label><?= $this->lang->line('Title')?></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/en-flag.png')?>" ></span>
                                            </div>
                                            <input type="text" name="reservation_title_english" class="form-control"  value="<?= isset($seo_titles->reservation_title_english) ? $seo_titles->reservation_title_english : "" ?>">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <label><?= $this->lang->line('Description')?></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/en-flag.png')?>" ></span>
                                            </div>
                                            <input type="text" name="reservation_desc_english" class="form-control"  value="<?= isset($seo_descriptions->reservation_desc_english) ? $seo_descriptions->reservation_desc_english : "" ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row french-field hide-field lang-field">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <label><?= $this->lang->line('Title')?></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/fr-flag.png')?>" ></span>
                                            </div>
                                            <input type="text" name="reservation_title_french" class="form-control"  value="<?= isset($seo_titles->reservation_title_french) ? $seo_titles->reservation_title_french : "" ?>">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <label><?= $this->lang->line('Description')?></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/fr-flag.png')?>" ></span>
                                            </div>
                                            <input type="text" name="reservation_desc_french" class="form-control"  value="<?= isset($seo_descriptions->reservation_desc_french) ? $seo_descriptions->reservation_desc_french : "" ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row germany-field hide-field lang-field">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <label><?= $this->lang->line('Title')?></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/ge-flag.png')?>" ></span>
                                            </div>
                                            <input type="text" name="reservation_title_germany" class="form-control"  value="<?= isset($seo_titles->reservation_title_germany) ? $seo_titles->reservation_title_germany : "" ?>">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <label><?= $this->lang->line('Description')?></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/ge-flag.png')?>" ></span>
                                            </div>
                                            <input type="text" name="reservation_desc_germany" class="form-control"  value="<?= isset($seo_descriptions->reservation_desc_germany) ? $seo_descriptions->reservation_desc_germany : "" ?>">
                                        </div>
                                    </div>
                                </div>
                               
                            </section>
                            <section class="menu-page-setting mt-5">
                                <h4> <?=$this->lang->line("Menu")?> & <?=$this->lang->line("Order")?> <?=$this->lang->line("Page")?> </h4>
                                <hr/>
                                <div class="form-group row english-field hide-field lang-field">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <label><?= $this->lang->line('Title')?></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/en-flag.png')?>" ></span>
                                            </div>
                                            <input type="text" name="menu_title_english" class="form-control"  value="<?= isset($seo_titles->menu_title_english) ? $seo_titles->menu_title_english : "" ?>">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <label><?= $this->lang->line('Description')?></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/en-flag.png')?>" ></span>
                                            </div>
                                            <input type="text" name="menu_desc_english" class="form-control"  value="<?= isset($seo_descriptions->menu_desc_english) ? $seo_descriptions->menu_desc_english : "" ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row french-field hide-field lang-field">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <label><?= $this->lang->line('Title')?></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/fr-flag.png')?>" ></span>
                                            </div>
                                            <input type="text" name="menu_title_french" class="form-control"  value="<?= isset($seo_titles->menu_title_french) ? $seo_titles->menu_title_french : "" ?>">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <label><?= $this->lang->line('Description')?></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/fr-flag.png')?>" ></span>
                                            </div>
                                            <input type="text" name="menu_desc_french" class="form-control"  value="<?= isset($seo_descriptions->menu_desc_french) ? $seo_descriptions->menu_desc_french : "" ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row germany-field hide-field lang-field">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <label><?= $this->lang->line('Title')?></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/ge-flag.png')?>" ></span>
                                            </div>
                                            <input type="text" name="menu_title_germany" class="form-control"  value="<?= isset($seo_titles->menu_title_germany) ? $seo_titles->menu_title_germany : "" ?>">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <label><?= $this->lang->line('Description')?></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/ge-flag.png')?>" ></span>
                                            </div>
                                            <input type="text" name="menu_desc_germany" class="form-control"  value="<?= isset($seo_descriptions->menu_desc_germany) ? $seo_descriptions->menu_desc_germany : "" ?>">
                                        </div>
                                    </div>
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

