
<div class="container">
    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="py-5 px-md-5 px-3">
                        <form class="user" id="restaurantSetting" data-rest_id = "<?=$restDetails->rest_id?>">
                            <section class="free-support">
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
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

