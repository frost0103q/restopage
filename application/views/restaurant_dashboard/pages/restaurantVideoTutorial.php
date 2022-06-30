
<div class="container">

    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-header py-3 d-flex justify-content-between title-bar">
            <h1 class="h4 text-gray-900 mb-0"><?= $this->lang->line("Video")?> <?= $this->lang->line("Tutorial")?></h1>
        </div>
        <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
        
                <div class="col-lg-12">
                    <div class="p-sm-5 p-3">
                        <?php
                            foreach ($video_tutorials as $vkey => $video_tutorial) {
                            ?>
                                <div class="video-wrapper  my-4 p-2 p-md-4">
                                    <div class="row">
                                        <div class="col-md-4 update-video text-center">
                                            <?php
                                                if (isset($video_tutorial->video_url) && $video_tutorial->video_url !== ""){
                                                    $video_url = base_url("/assets/video_tutorials/").$video_tutorial->video_url;
                                                }else{
                                                    $video_url = "";
                                                }
                                            ?>
                                            <video width="100%" height="auto" controls>
                                                <source src="<?= $video_url?>">
                                            </video>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="input-group english-field <?= $_lang == 'english' ? '' : 'hide-field' ?>">
                                                <div><?= isset($video_tutorial) ? $video_tutorial->video_description_english : ""?></div>
                                            </div>
                                            <div class="input-group french-field <?= $_lang == 'french' ? '' : 'hide-field' ?>">
                                                <div><?= isset($video_tutorial) ? $video_tutorial->video_description_french : ""?></div>
                                            </div>
                                            <div class="input-group germany-field <?= $_lang == 'germany' ? '' : 'hide-field' ?>">
                                                <div><?= isset($video_tutorial) ? $video_tutorial->video_description_germany : ""?></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

