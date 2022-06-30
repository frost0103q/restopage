
<div class="container">
    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="py-5 px-md-5 px-3">
                        <form class="user" id="restaurantSetting" data-rest_id = "<?=$restDetails->rest_id?>">
                            <section>
                                <div class="">
                                    <h1 class="h4 text-gray-900 mb-4"><?= $this->lang->line('Choose your Backend Admin Language')?></h1>
                                    <hr>
                                </div>
                                <div class=" row">
                                    <div class="col-sm-4">
                                        <label>
                                            <input type="radio" id ="set_admin_french" name="admin_lang_option" value = "french" <?=$restDetails->admin_language == "french" ? "checked": "" ?>>
                                            <img class="rounded-circle mx-3" width="20" height="20" src="<?= base_url('assets/flags/fr-flag.png')?>">
                                            French 
                                        </label>
                                    </div>
                                    <div class="col-sm-4">
                                        <label>
                                            <input type="radio" id ="set_admin_germany" name="admin_lang_option" value = "germany" <?=$restDetails->admin_language == "germany" ? "checked": "" ?>>
                                            <img class="rounded-circle mx-3" width="20" height="20" src="<?= base_url('assets/flags/ge-flag.png')?>">
                                            Germany 
                                        </label>
                                    </div>
                                    <div class="col-sm-4">
                                        <label>
                                            <input type="radio" id ="set_admin_english" name="admin_lang_option" value = "english" <?=($restDetails->admin_language !== "french" ) && ($restDetails->admin_language !== "germany" ) ? "checked": "" ?>>
                                            <img class="rounded-circle mx-3" width="20" height="20" src="<?= base_url('assets/flags/en-flag.png')?>">
                                            English 
                                        </label>
                                    </div>
                                </div>
                            </section>
                            <section>
                                <div class="mt-5" id="set_website_language">
                                    <h1 class="h4 text-gray-900 mb-4 text-capitalize"><?= $this->lang->line('choose your website languages')?></h1>
                                    <hr>
                                </div>
                                <div class=" row">
                                    <div class="col-sm-4">
                                        <label>
                                            <input type="checkbox" id ="set_website_french" name="website_lang_option" value = "french" <?= in_array("french",explode(",",$restDetails->website_languages)) ? "checked" : "" ?>>
                                            <img class="rounded-circle mx-3" width="20" height="20" src="<?= base_url('assets/flags/fr-flag.png')?>">
                                            French 
                                        </label>
                                    </div>
                                    <div class="col-sm-4">
                                        <label>
                                            <input type="checkbox" id ="set_website_germany" name="website_lang_option" value = "germany" <?= in_array("germany",explode(",",$restDetails->website_languages)) ? "checked" : "" ?>>
                                            <img class="rounded-circle mx-3" width="20" height="20" src="<?= base_url('assets/flags/ge-flag.png')?>">
                                            Germany 
                                        </label>
                                    </div>
                                    <div class="col-sm-4">
                                        <label>
                                            <input type="checkbox" id ="set_website_english" name="website_lang_option" value = "english" <?= in_array("english",explode(",",$restDetails->website_languages)) ? "checked" : "" ?>>
                                            <img class="rounded-circle mx-3" width="20" height="20" src="<?= base_url('assets/flags/en-flag.png')?>">
                                            English 
                                        </label>
                                    </div>
                                </div>
                            </section>
                            <section>
                                <div class="mt-5" id="set_menu_language">
                                    <h1 class="h4 text-gray-900 mb-4 text-capitlize"><?= $this->lang->line('Choose in which languages you want to add your Food Menu')?></h1>
                                    <hr>
                                </div>
                                <div class=" row">
                                    <div class="col-sm-4">
                                        <label>
                                            <input type="checkbox" id ="set_menu_french" name="menu_lang_option" value = "french" <?= in_array("french",explode(",",$restDetails->menu_languages)) ? "checked" : "" ?>>
                                            <img class="rounded-circle mx-3" width="20" height="20" src="<?= base_url('assets/flags/fr-flag.png')?>">
                                            French 
                                        </label>
                                    </div>
                                    <div class="col-sm-4">
                                        <label>
                                            <input type="checkbox" id ="set_menu_germany" name="menu_lang_option" value = "germany" <?= in_array("germany",explode(",",$restDetails->menu_languages)) ? "checked" : "" ?>>
                                            <img class="rounded-circle mx-3" width="20" height="20" src="<?= base_url('assets/flags/ge-flag.png')?>">
                                            Germany 
                                        </label>
                                    </div>
                                    <div class="col-sm-4">
                                        <label>
                                            <input type="checkbox" id ="set_menu_english" name="menu_lang_option" value = "english" <?= in_array("english",explode(",",$restDetails->menu_languages)) ? "checked" : "" ?>>
                                            <img class="rounded-circle mx-3" width="20" height="20" src="<?= base_url('assets/flags/en-flag.png')?>">
                                            English 
                                        </label>
                                    </div>
                                </div>
                            </section>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

