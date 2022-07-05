        <!-- Begin Page Content -->
        <div class="container-fluid pageSetting-page multi-lang-page" data-url ="<?= base_url('/')?>" >
            <div class="row">
                <div class="col-md-12 ">
                    <?php
                    if($this->session->flashdata('msg')){
                        echo '<div class="alert alert-danger">'.$this->session->flashdata('msg').'</div>';
                    }
                    ?>
                    <div class="content_wrap tab-content">
                        <form action="<?=base_url('Restaurant/editMainPage')?>" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="rest_id" value = "<?= $myRestId?>">
                            <input type="hidden" name="what_setting" value = "slider">
                            <section>
                                <div class="card shadow mb-4">
                                    <div class="card-header py-3 d-flex align-items-center title-bar">
                                        <label class="j-switch">
                                            <input type="checkbox" name = "is_show_slider" id ="slider_section_option_slider" <?=( (isset($page_content->is_show_slider) && $page_content->is_show_slider == 1) ? "checked" : "" ) ?>>
                                            <span class="j-slider round"></span>
                                        </label>
                                        <span class="ml-2"><?= $this->lang->line("Page Sliders")?></span>
                                    </div>
                                    <div class="card-body update-image">
                                        <div class="form-group row mt-5">
                                            <?php
                                                foreach ($sliders as $skey => $slider) {
                                                    if ($slider->image_name !== ""){
                                                        $image_value = base_url("assets/home_slider_images/").$slider->image_name;
                                                    }else{
                                                        $image_value = "";
                                                    }
                                                    echo '
                                                        <div class="col-sm-6 col-md-3 mb-3 mb-sm-0">
                                                            <input type="file" class="dropify" name="slider'.$slider->slider_index.'" data-default-file = "'.$image_value.'" value = "'.$image_value.'" data-slider-index = "'.$slider->slider_index.'" />
                                                            <input type="hidden" name="is_update'.$slider->slider_index.'" value = "0"/>
                                                        </div>
                                                    ';
                                                }
                                                if (empty($sliders)){
                                                    for ($i=0; $i < 4; $i++) { 
                                                        echo '
                                                            <div class="col-sm-6 col-md-3 mb-3 mb-sm-0">
                                                                <input type="file" class="dropify" name="slider'.$i.'" data-slider-index ="'.$i.'"/>
                                                                <input type="hidden" name="is_update'.$i.'" value = "1" />
                                                            </div>
                                                        ';
                                                    }
                                                }
                                            ?>
                                        </div>
                                        <h5 class="h5 mt-5">Page Slider Effects</h5>

                                        <div class="form-group row mt-5">
                                            <div class="col-md-3">
                                                <label>
                                                    <input type="checkbox" class="ml-3 mr-4" value="louvers" name="slider_effect[]" <?= isset($page_content->slider_effects) && in_array("louvers",explode(",",$page_content->slider_effects)) ? "checked" : "" ?>>
                                                    <span class="text-capitalize">louvers</span>
                                                </label>
                                            </div>
                                            <div class="col-md-3">
                                                <label>
                                                    <input type="checkbox" class="ml-3 mr-4" value="domino" name="slider_effect[]" <?= isset($page_content->slider_effects) && in_array("domino",explode(",",$page_content->slider_effects)) ? "checked" : "" ?>>
                                                    <span class="text-capitalize">domino</span>
                                                </label>
                                            </div>
                                            <div class="col-md-3">
                                                <label>
                                                    <input type="checkbox" class="ml-3 mr-4" value="book" name="slider_effect[]" <?= isset($page_content->slider_effects) && in_array("book",explode(",",$page_content->slider_effects)) ? "checked" : "" ?>>
                                                    <span class="text-capitalize">book</span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-group row slider-setting">
                                            <div class="col-md-6 mt-4">
                                                <label>Slider Effect Duration ( seconds )</label>
                                                <input type= "number" class="form-control" name="slider_duration" value="<?= isset($page_content->slider_duration) ? $page_content->slider_duration : "" ?>" placeholder="2.0" required step="0.01" min="0">
                                            </div>
                                            <div class="col-md-6 mt-4">
                                                <label>Slider Effect Delay ( seconds )</label>
                                                <input type= "number" class="form-control" name="slider_delay" value="<?= isset($page_content->slider_delay) ? $page_content->slider_delay : "" ?>" placeholder="2.0" required step="0.01" min="0">
                                            </div>
                                            <div class="col-md-6 mt-4">
                                                <label>Slider Overlay</label>
                                                <div class="row m-0 p-0">
                                                    <?php
                                                        $slider_overlay_alpha = "0.7";
                                                        $slider_overlay_color = "#282828";
                                                    ?>
                                                    <input class="form-control col-9" value="<?=isset($page_content->slider_overlay_color) ? $page_content->slider_overlay_color : $slider_overlay_color ?>" name="slider_overlay_color" data-jscolor="{alphaElement:'#slider_overlay_alpha'}">
                                                    <input class="form-control col-3" id="slider_overlay_alpha" value="<?=isset($page_content->slider_overlay_alpha) ? $page_content->slider_overlay_alpha : $slider_overlay_alpha ?>" name="slider_overlay_alpha">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                            <section>
                                <div class="card shadow mb-4">
                                    <div class="card-header py-3 d-flex justify-content-between title-bar">
                                        <div>Text on Photo Slider</div>
                                        <div class="lang-bar">
                                            <span class="<?= explode(",",$this->myRestDetail->website_languages)[0] == 'english' ? 'active' : ''  ?> item-flag" data-flag="english"><img class="english-flag" src="<?= base_url('assets/flags/en-flag.png')?>"></span>
                                            <span class="<?= explode(",",$this->myRestDetail->website_languages)[0] == 'french' ? 'active' : ''  ?> item-flag" data-flag="french"><img class="french-flag" src="<?= base_url('assets/flags/fr-flag.png')?>"></span>
                                            <span class="<?= explode(",",$this->myRestDetail->website_languages)[0] == 'germany' ? 'active' : ''  ?> item-flag" data-flag="germany"><img class="germany-flag" src="<?= base_url('assets/flags/ge-flag.png')?>"></span>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3 d-flex align-items-center title-bar">
                                            <label class="j-switch">
                                                <input type="checkbox" name = "is_show_search_on_slider" id="slider_section_option_search" <?=( (isset($page_content->is_show_slider) && $page_content->is_show_slider == 1) ? "" : "checked" ) ?>>
                                                <span class="j-slider round"></span>
                                            </label>
                                            <span class="ml-3">Delivery / Pickup Search on Slider</span>
                                        </div>

                                        <div class="slider-text-section">
                                        <?php
                                            $slider_index = 0; 
                                            foreach ($sliders as $skey => $slider) { 
                                                $slider_index++; ?>
                                                <div class="form-group row">
                                                    <label class="col-md-3 text-center">Image <?= $slider_index?></label>
                                                    <div class="col-md-3 mx-md-2 ">
                                                        <div class="input-group french-field hide-field lang-field">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/fr-flag.png')?>" ></span>
                                                            </div>
                                                            <input type="text" class="form-control" name="slider-caption-<?= $slider_index?>-title_french"  placeholder = "Titre sur l'image <?= $slider_index?>" value="<?=$slider->slider_caption_title_french?>">
                                                        </div>
                                                        <div class="input-group germany-field hide-field lang-field">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/ge-flag.png')?>" ></span>
                                                            </div>
                                                            <input type="text" class="form-control" name="slider-caption-<?= $slider_index?>-title_germany"  placeholder = "Titel auf Bild <?= $slider_index?>" value="<?=$slider->slider_caption_title_germany?>">
                                                        </div>
                                                        <div class="input-group english-field hide-field lang-field">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/en-flag.png')?>" ></span>
                                                            </div>
                                                            <input type="text" class="form-control" name="slider-caption-<?= $slider_index?>-title_english"  placeholder = "Title on Image <?= $slider_index?>" value="<?=$slider->slider_caption_title_english?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-5">
                                                        <div class="input-group french-field hide-field lang-field">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/fr-flag.png')?>" ></span>
                                                            </div>
                                                            <input type="text" class="form-control" name="slider-caption-<?= $slider_index?>-content_french"  placeholder = "Contenu sur l'image <?= $slider_index?>" value="<?=$slider->slider_caption_content_french?>">
                                                        </div>
                                                        <div class="input-group germany-field hide-field lang-field">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/ge-flag.png')?>" ></span>
                                                            </div>
                                                            <input type="text" class="form-control" name="slider-caption-<?= $slider_index?>-content_germany"  placeholder = "Inhalt auf Bild <?= $slider_index?>" value="<?=$slider->slider_caption_content_germany?>">
                                                        </div>
                                                        <div class="input-group english-field hide-field lang-field">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/en-flag.png')?>" ></span>
                                                            </div>
                                                            <input type="text" class="form-control" name="slider-caption-<?= $slider_index?>-content_english"  placeholder = "Content on Image <?= $slider_index?>" value="<?=$slider->slider_caption_content_english?>">
                                                        </div>
                                                    </div>
                                                </div>
                                        <?php } ?>
                                        </div>
                                        <div class="col-sm-12 mx-auto mb-3 mt-md-5 mt-3 mb-sm-0">
                                            <input type="submit" name="" value="<?= $this->lang->line('SAVE')?>" class="btn btn-danger btn-user btn-block submit-btn">
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </form>
                    </div>
                </div>
            
            </div>
        </div>
        <!-- /.container-fluid -->
        <!-- End of Main Content -->
        
<script type="text/javascript">
$(document).on('click','.update-image .dropify-clear',function(){
    slider_index = $(this).parent().find(".dropify").attr("data-slider-index");
    $("input[name='is_update"+slider_index+"']").val("1");
});
</script>
