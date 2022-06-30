
<div class="container-fluid multi-lang-page">

    <div class="content_wrap tab-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="py-5 px-3">
                    <form class="user" id="announcement-setting-update-form" data-rest_id = "<?=$restDetails->rest_id?>">
                        <input type="hidden" value = "<?=$restDetails->rest_id?>" name = "rest_id" class = "rest_id" >
                        <section class="announcement-setting ">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3 d-flex justify-content-between title-bar">
                                    <?=$this->lang->line("Restaurant")?> <?=$this->lang->line("Announcements")?>
                                    <div class="lang-bar">
                                        <span class="<?= explode(",",$this->myRestDetail->website_languages)[0] == 'english' ? 'active' : ''  ?> item-flag" data-flag="english"><img class="english-flag" src="<?= base_url('assets/flags/en-flag.png')?>"></span>
                                        <span class="<?= explode(",",$this->myRestDetail->website_languages)[0] == 'french' ? 'active' : ''  ?> item-flag" data-flag="french"><img class="french-flag" src="<?= base_url('assets/flags/fr-flag.png')?>"></span>
                                        <span class="<?= explode(",",$this->myRestDetail->website_languages)[0] == 'germany' ? 'active' : ''  ?> item-flag" data-flag="germany"><img class="germany-flag" src="<?= base_url('assets/flags/ge-flag.png')?>"></span>
                                    </div>
                                </div>
                                <div class="card-body">
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
                                                <textarea class="summernote form-control" name="announcement_french"  ><?= isset($announcement) ? $announcement->content_french : "" ?></textarea>
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
                                        <div class="col-sm-6 mx-auto mb-3 mb-sm-0 mt-4">
                                            <input type="submit" name="" value="<?= $this->lang->line('SAVE')?>" class="btn btn-success btn-user btn-block submit-btn">
                                        </div>
                                        <div class="col-sm-6 mx-auto mb-3 mb-sm-0 mt-4 <?= isset($announcement->id) ? "" : "hide-field" ?>">
                                            <a href="#" class="btn btn-danger btn-user btn-block remove_announcement" d-announcement_id="<?= isset($announcement->id) ? $announcement->id : "" ?>"><?= $this->lang->line('Remove')?></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

