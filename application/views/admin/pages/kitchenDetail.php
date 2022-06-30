
        <!-- Begin Page Content -->
        <div class="container-fluid multi-lang-page">

            <!-- Page Heading -->
            <h1 class="h3 mb-2 text-gray-800"><?= $this->lang->line("Kitchen") ?> <?= $this->lang->line("Detail") ?></h1>
            <div class="content_wrap tab-content">
                <section>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3 d-flex justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary"><?= $this->lang->line("New") ?> <?= $this->lang->line("Kitchens") ?></h6>
                                    <div class="lang-bar">
                                        <span class="<?= $_lang == 'english' ? 'active' : ''  ?> item-flag" data-flag="english"><img class="english-flag" src="<?= base_url('assets/flags/en-flag.png')?>"></span>
                                        <span class="<?= $_lang == 'french' ? 'active' : ''  ?> item-flag" data-flag="french"><img class="french-flag" src="<?= base_url('assets/flags/fr-flag.png')?>"></span>
                                        <span class="<?= $_lang == 'germany' ? 'active' : ''  ?> item-flag" data-flag="germany"><img class="germany-flag" src="<?= base_url('assets/flags/ge-flag.png')?>"></span>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <form id = "updateKitchen" class="updateKitchen" data-url = "<?=base_url('/')?>">
                                        <input type="hidden" class="form-control form-control-user" name="kitchen_id" value="<?= $kitchen->kitchen_id?>" >
                                        <div class="form-group row">
                                            <div class="col-sm-8 mb-3 mb-sm-0">
                                                <section>
                                                    <div class="input-group french-field hide-field lang-field">
                                                        <input type="text" class="form-control form-control-user" id="kitchen_name_french" placeholder='<?= $this->lang->line("Kitchen") ?> <?= $this->lang->line("Name") ?>' name="kitchen_name_french" value="<?= $kitchen->kitchen_name_french ?>" >
                                                        <div class="input-group-append">
                                                            <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/fr-flag.png')?>"></span>
                                                        </div>
                                                    </div>
                                                    <div class="input-group germany-field hide-field lang-field">
                                                        <input type="text" class="form-control form-control-user" id="kitchen_name_germany" placeholder='<?= $this->lang->line("Kitchen") ?> <?= $this->lang->line("Name") ?>' name="kitchen_name_germany" value="<?= $kitchen->kitchen_name_germany ?>" >
                                                        <div class="input-group-append">
                                                            <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/ge-flag.png')?>"></span>
                                                        </div>
                                                    </div>
                                                    <div class="input-group english-field hide-field lang-field">
                                                        <input type="text" class="form-control form-control-user" id="kitchen_name_english" placeholder='<?= $this->lang->line("Kitchen") ?> <?= $this->lang->line("Name") ?>' name="kitchen_name_english" value="<?= $kitchen->kitchen_name_english ?>" >
                                                        <div class="input-group-append">
                                                            <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/en-flag.png')?>"></span>
                                                        </div>
                                                    </div>
                                                </section>
                                                <section class="mt-3">
                                                    <div class="input-group french-field hide-field lang-field">
                                                        <textarea class="form-control form-control-user" id="kitchen_description_french" placeholder='<?= $this->lang->line("Kitchen") ?> <?= $this->lang->line("Description") ?>' name="kitchen_description_french"><?=$kitchen->kitchen_description_french?></textarea>
                                                        <div class="input-group-append">
                                                            <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/fr-flag.png')?>"></span>
                                                        </div>
                                                    </div>
                                                    <div class="input-group germany-field hide-field lang-field">
                                                        <textarea class="form-control form-control-user" id="kitchen_description_germany" placeholder='<?= $this->lang->line("Kitchen") ?> <?= $this->lang->line("Description") ?>' name="kitchen_description_germany"><?=$kitchen->kitchen_description_germany?></textarea>
                                                        <div class="input-group-append">
                                                            <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/ge-flag.png')?>"></span>
                                                        </div>
                                                    </div>
                                                    <div class="input-group english-field hide-field lang-field">
                                                        <textarea class="form-control form-control-user" id="kitchen_description_english" placeholder='<?= $this->lang->line("Kitchen") ?> <?= $this->lang->line("Description") ?>' name="kitchen_description_english"><?=$kitchen->kitchen_description_english?></textarea>
                                                        <div class="input-group-append">
                                                            <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/en-flag.png')?>"></span>
                                                        </div>
                                                    </div>
                                                </section>
                                            </div>
                                            <div class="col-sm-4 mb-3 mb-sm-0">
                                                <input type="submit" name="" value='<?= $this->lang->line("Update")?>' class="btn btn-primary btn-user btn-block">
                                            </div>
                                            
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
        <!-- /.container-fluid -->
    </div>
    
    <!-- End of Main Content -->