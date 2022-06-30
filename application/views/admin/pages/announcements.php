
<?php
function percentToHex($p){
    $percent = max(0, min(100, $p)); // bound percent from 0 to 100
    $intValue = round($p / 100 * 255); // map percent to nearest integer (0 - 255)
    $hexValue = dechex($intValue); // get hexadecimal representation
    return str_pad($hexValue, 2, '0', STR_PAD_LEFT); // format with leading 0 and upper case characters
}
?>
<div class="container-fluid multi-lang-page">

    <div class="content_wrap tab-content">
        <h1 class="h3 mb-4 text-gray-800"><?=$this->lang->line("Admin")?> <?=$this->lang->line("Announcements")?></h1>
        <section>
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary"><?=$this->lang->line("Add")?> <?=$this->lang->line("Announcement")?></h6>
                    <div class="lang-bar">
                        <span class="<?= $_lang == 'english' ? 'active' : ''  ?> item-flag" data-flag="english"><img class="english-flag" src="<?= base_url('assets/flags/en-flag.png')?>"></span>
                        <span class="<?= $_lang == 'french' ? 'active' : ''  ?> item-flag" data-flag="french"><img class="french-flag" src="<?= base_url('assets/flags/fr-flag.png')?>"></span>
                        <span class="<?= $_lang == 'germany' ? 'active' : ''  ?> item-flag" data-flag="germany"><img class="germany-flag" src="<?= base_url('assets/flags/ge-flag.png')?>"></span>
                    </div>
                </div>
                <div class="card-body">
                    <form id = "announcement-setting" class="announcement-setting">
                        <input type="hidden" value = "0" name = "rest_id" class = "rest_id" >
                        <div class="form-group row justify-content-between">
                            <div class="col-md-8">
                                <div class="input-group english-field hide-field content-editor lang-field">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/en-flag.png')?>" ></span>
                                    </div>
                                    <textarea class="summernote form-control" name="announcement_english" ></textarea>
                                </div>
                                <div class="input-group french-field hide-field content-editor lang-field">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/fr-flag.png')?>" ></span>
                                    </div>
                                    <textarea class="summernote form-control" name="announcement_french"  ></textarea>
                                </div>
                                <div class="input-group germany-field hide-field content-editor lang-field">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/ge-flag.png')?>" ></span>
                                    </div>
                                    <textarea class="summernote form-control" name="announcement_germany" ></textarea>
                                </div>
                            </div>
                            <div class="col-md-3 mt-4">
                                <label><?= $this->lang->line("Announcement")?> <?= $this->lang->line("Background")?> <?= $this->lang->line("Color")?></label>
                                <div class="row mx-0">
                                    <input class="form-control col-9" name="announce_bg_color" data-jscolor="{alphaElement:'#ac1'}">
                                    <input class="form-control col-3" id="ac1"  name="announce_bg_color_alpha">
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
        
            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3  d-flex justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary"><?= $this->lang->line("All")?> <?= $this->lang->line("Announcements")?></h6>
                    <div class="lang-bar">
                        <span class="<?= $_lang == 'english' ? 'active' : ''  ?> item-flag" data-flag="english"><img class="english-flag" src="<?= base_url('assets/flags/en-flag.png')?>"></span>
                        <span class="<?= $_lang == 'french' ? 'active' : ''  ?> item-flag" data-flag="french"><img class="french-flag" src="<?= base_url('assets/flags/fr-flag.png')?>"></span>
                        <span class="<?= $_lang == 'germany' ? 'active' : ''  ?> item-flag" data-flag="germany"><img class="germany-flag" src="<?= base_url('assets/flags/ge-flag.png')?>"></span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th class="text-center"><?= $this->lang->line("S.No")?></th>
                                <th class="text-center"><?= $this->lang->line("Announcements")?></th>
                                <th class="text-center"><?= $this->lang->line("Action")?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i=1;?>
                            <?php foreach($announcements as $announcement):
                                ?>
                                <tr>
                                    <td class="text-center"><?=$i?></td>
                                    <td class="text-center english-field lang-field hide-field">
                                        <div class="p-3" style="border-radius:8px;background: <?= trim($announcement->content_bg_color) !== "" ? $announcement->content_bg_color : "#FFFFFF" ?><?=percentToHex( 100*floatval($announcement->content_bg_color_alpha)) ?>"><div> <?= $announcement->content_english ?> </div></div>
                                    </td>
                                    <td class="text-center french-field lang-field hide-field">
                                        <div class="p-3" style="border-radius:8px;background: <?= trim($announcement->content_bg_color) !== "" ? $announcement->content_bg_color : "#FFFFFF" ?><?=percentToHex( 100*floatval($announcement->content_bg_color_alpha)) ?>"><div><?= $announcement->content_french ?> </div></div>
                                    </td>
                                    <td class="text-center germany-field lang-field hide-field">
                                        <div class="p-3" style="border-radius:8px;background: <?= trim($announcement->content_bg_color) !== "" ? $announcement->content_bg_color : "#FFFFFF" ?><?=percentToHex( 100*floatval($announcement->content_bg_color_alpha)) ?>"> <div><?= $announcement->content_germany ?> </div></div>
                                    </td>
                                    <td class="text-center">
                                        <a href="<?=base_url('Admin/announcementDetails/').$announcement->id?>" title="<?= $this->lang->line('Edit')?> <?= $this->lang->line('Announcement')?>"><i class="fas fa-eye"></i></a>
                                        <a href="javascript:void(0)" title="<?= $this->lang->line('Remove')?> <?= $this->lang->line('Announcement')?>" class="text-danger remove_announcement" d-announcement_id="<?=$announcement->id?>"><i class="fas fa-trash"></i></a>
                                    </td>
                                </tr>
                                <?php $i++ ; ?>
                            <?php endforeach;?>
                        </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

