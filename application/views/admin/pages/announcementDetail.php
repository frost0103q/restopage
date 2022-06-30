
<div class="container-fluid multi-lang-page">

    <div class="content_wrap tab-content">
        <h1 class="h3 mb-4 text-gray-800"><?=$this->lang->line("Admin")?> <?=$this->lang->line("Announcement")?> <?=$this->lang->line("Detail")?></h1>
        <section>
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary"><?=$this->lang->line("Update")?> <?=$this->lang->line("Announcement")?></h6>
                    <div class="lang-bar">
                        <span class="<?= $_lang == 'english' ? 'active' : ''  ?> item-flag" data-flag="english"><img class="english-flag" src="<?= base_url('assets/flags/en-flag.png')?>"></span>
                        <span class="<?= $_lang == 'french' ? 'active' : ''  ?> item-flag" data-flag="french"><img class="french-flag" src="<?= base_url('assets/flags/fr-flag.png')?>"></span>
                        <span class="<?= $_lang == 'germany' ? 'active' : ''  ?> item-flag" data-flag="germany"><img class="germany-flag" src="<?= base_url('assets/flags/ge-flag.png')?>"></span>
                    </div>
                </div>
                <div class="card-body">
                    <form id = "announcement-setting-update-form" class="announcement-setting">
                        <input type="hidden" value = "0" name = "rest_id" class = "rest_id" >
                        <input type="hidden" value = "<?=$announcement_id?>" name = "announcement_id" class = "announcement_id" >
                        <div class="form-group row justify-content-between">
                            <div class="col-md-8">
                                <div class="input-group english-field hide-field content-editor lang-field">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/en-flag.png')?>" ></span>
                                    </div>
                                    <textarea class="summernote form-control" name="announcement_english" ><?= isset($announcement) ? $announcement->content_english : ""?></textarea>
                                </div>
                                <div class="input-group french-field hide-field content-editor lang-field">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/fr-flag.png')?>" ></span>
                                    </div>
                                    <textarea class="summernote form-control" name="announcement_french"  ><?= isset($announcement) ? $announcement->content_french : ""?></textarea>
                                </div>
                                <div class="input-group germany-field hide-field content-editor lang-field">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/ge-flag.png')?>" ></span>
                                    </div>
                                    <textarea class="summernote form-control" name="announcement_germany" ><?= isset($announcement) ? $announcement->content_germany : ""?></textarea>
                                </div>
                            </div>
                            <div class="col-md-3 mt-4">
                                <label><?= $this->lang->line("Announcement")?> <?= $this->lang->line("Background")?> <?= $this->lang->line("Color")?></label>
                                <div class="row mx-0">
                                    <input class="form-control col-9" name="announce_bg_color" data-jscolor="{alphaElement:'#ac1'}" value = "<?= isset($announcement) ? $announcement->content_bg_color : ""?>">
                                    <input class="form-control col-3" id="ac1"  name="announce_bg_color_alpha" value = "<?= isset($announcement) ? $announcement->content_bg_color_alpha : ""?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-12 mx-auto my-4 mb-sm-0">
                                <input type="submit" name="" value="<?= $this->lang->line('SAVE')?>" class="btn btn-danger btn-user btn-block submit-btn">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
</div>

