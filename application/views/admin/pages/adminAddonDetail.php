        <!-- Begin Page Content -->
        <div class="container-fluid editAddon-page multi-lang-page" data-url ="<?= base_url('/')?>" >
            <div class="row">
                <div class="col-md-12 ">
                    <div class="content_wrap">
                        <form class="editAddon" method="post" enctype="multipart/form-data" id="editAddon">
                            <input type="hidden" name="addon_id" value="<?=$addon->addon_id?>">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3 d-flex justify-content-between title-bar">
                                    <h4 class="mb-0"><?= $this->lang->line("Edit")?> <?= $this->lang->line("Addon")?></h4>
                                    <div class="lang-bar">
                                        <span class="<?= $_lang == 'english' ? 'active' : ''  ?> item-flag" data-flag="english"><img class="english-flag" src="<?= base_url('assets/flags/en-flag.png')?>"></span>
                                        <span class="<?= $_lang == 'french' ? 'active' : ''  ?> item-flag" data-flag="french"><img class="french-flag" src="<?= base_url('assets/flags/fr-flag.png')?>"></span>
                                        <span class="<?= $_lang == 'germany' ? 'active' : ''  ?> item-flag" data-flag="germany"><img class="germany-flag" src="<?= base_url('assets/flags/ge-flag.png')?>"></span>
                                    </div>
                                </div>
                                <div class="card-body mt-4 p-lg-5 p-md-4 p-2">
                                    <div class="row">
                                        <?php
                                            $addon_title = json_decode($addon->addon_title);
                                            $addon_content_html = json_decode($addon->addon_content_html);
                                            $addon_features_arr = $addon->addon_features == "" ? [] :explode(",",$addon->addon_features);
                                            $content_html_field = "value_" . $_lang;
                                            $content_html = $addon_content_html->$content_html_field == "" ? $addon_content_html->value: $addon_content_html->$content_html_field;
                                            $addon_price_currency = $this->db->where("id",$addon->addon_price_currency_id)->get('tbl_countries')->row()->currency_symbol;
                                        ?>
                                        <div class="col-md-4">
                                            <div class="addon-title form-group">
                                                <label class="" ><?= $this->lang->line("Title") ?></label>
                                                <div class="input-group french-field hide-field lang-field">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/fr-flag.png')?>" ></span>
                                                    </div>
                                                    <input type="text" class="form-control" name="addon_title_french"  placeholder = ""  value="<?=$addon_title->value_french?>">
                                                </div>
                                                <div class="input-group english-field hide-field lang-field">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/en-flag.png')?>" ></span>
                                                    </div>
                                                    <input type="text" class="form-control" name="addon_title_english"  placeholder = "" value="<?=$addon_title->value_english?>">
                                                </div>
                                                <div class="input-group germany-field hide-field lang-field">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/ge-flag.png')?>" ></span>
                                                    </div>
                                                    <input type="text" class="form-control" name="addon_title_germany"  placeholder = "" value="<?=$addon_title->value_germany?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group addon-title">
                                                <label class=""><?= $this->lang->line("Price") ?></label>
                                                <input type="number" class="form-control" min="0" step="0.01" name="addon_price"  placeholder = "10.00" value="<?=$addon->addon_price?>">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label><?= $this->lang->line("Currency")?></label>
                                            <?php 
                                                $countries = $this->db->where("NOT ISNULL(currency_code) AND currency_code <> ''")->get("tbl_countries")->result();
                                                $currency_id = $addon->addon_price_currency_id;
                                                $c_country = $this->db->where('id',$currency_id)->get("tbl_countries")->row();
                                                $addon_price_currency = $c_country->currency_symbol ;
                                            ?>
                                            <div class="row form-group">
                                                <div class="col-md-6">
                                                    <div class="input-group country_select_box">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="img-thumbnail flag flag-icon-background flag-icon-<?= strtolower($c_country->abv) ?> country_flag"></i></span>
                                                        </div>
                                                        <select class="form-control form-control-user country_select currency_code_select_box" name="country">
                                                            <?php foreach ($countries as $key => $country) {  ?>
                                                                <option value="<?= $country->id?>" data-country_code = "<?= strtolower($country->abv) ?>" data-currency_symbol = "<?= strtolower($country->currency_symbol) ?>" <?= $c_country->id == $country->id ? "selected" : "" ?>><?= $country->name?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="input-group currency_select_box">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text currency_symbol"> <?= $c_country->currency_symbol ?></span>
                                                        </div>
                                                        <select class="form-control form-control-user currency_select currency_code_select_box" name="addon_price_currency_id">
                                                            <?php  foreach ($countries as $key => $country) { ?>
                                                                <option value="<?= $country->id?>" data-country_code = "<?= strtolower($country->abv) ?>" data-currency_symbol = "<?= strtolower($country->currency_symbol) ?>"  <?= $c_country->id == $country->id ? "selected" : "" ?>><?= $country->currency_name?> (<?= $country->currency_symbol?>) </option>    
                                                            <?php  } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group addon-lifecycle">
                                                <label class=""><?= $this->lang->line("Lifecycle") ?></label>
                                                <select class="form-control text-capitalize" name="addon_lifecycle">
                                                    <option value="daily" <?=$addon->addon_lifecycle == "daily" ? "selected" : "" ?>><?= $this->lang->line("daily") ?></option>
                                                    <option value="weekly" <?=$addon->addon_lifecycle == "weekly" ? "selected" : "" ?>><?= $this->lang->line("weekly") ?></option>
                                                    <option value="monthly" <?=$addon->addon_lifecycle == "monthly" ? "selected" : "" ?>><?= $this->lang->line("monthly") ?></option>
                                                    <option value="annually" <?=$addon->addon_lifecycle == "annually" ? "selected" : "" ?>><?= $this->lang->line("annually") ?></option>
                                                    <option value="lifetime" <?=$addon->addon_lifecycle == "lifetime" ? "selected" : "" ?>><?= $this->lang->line("lifetime") ?></option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group addon-trial">
                                                <label class="text-capitalize"><?= $this->lang->line("trial") ?> <?= $this->lang->line("period") ?> <em class="small text-lowercase"> ( <?= $this->lang->line("How many days for free") ?> ) </em></label>
                                                <div class="input-group">
                                                    <input type="number" class="form-control" min="0" step="1" name="addon_trial_period"  placeholder = "30" value="<?= $addon->addon_trial_period ?>">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text">day(s)</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-1 ml-auto">
                                            <div class="form-group addon-status">
                                                <label class="text-capitalize"><?= $this->lang->line("Status") ?></label>
                                                <div class="input-group">
                                                    <input type="checkbox" data-plugin="switchery" name = "addon_status" data-color="#3DDCF7" <?= $addon->addon_status == "active" ? "checked" : "" ?>/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group addon-features">
                                                <label class="text-capitalize"><?= $this->lang->line("Features") ?></label>
                                                <select class="select2 select2-multiple text-capitalize" multiple="multiple" multiple data-placeholder="Choose Features" name = "addon_features[]">
                                                    <?php 
                                                        $select_features = array(
                                                            $this->lang->line("Payment")   =>  array(
                                                                "online_payments"   =>  $this->lang->line("Online")." ".$this->lang->line("Payment"),
                                                                "direct_payments"   =>  $this->lang->line("Direct")." ".$this->lang->line("Payment"),
                                                            ),
                                                            $this->lang->line("Order") ." ". $this->lang->line("Setting")         =>  array(
                                                                "delivery_zones"    =>  $this->lang->line("Delivery")." ".$this->lang->line("Zones"),
                                                                "order_management"  =>  $this->lang->line("Order")." ".$this->lang->line("Management"),
                                                                "client_management" =>  $this->lang->line("Client")." ".$this->lang->line("Management"),
                                                                "tax_setting"       =>  $this->lang->line("Tax")." ".$this->lang->line("Setting"),
                                                                "loyalty_points"    =>  $this->lang->line("Loyalty Points"),
                                                            ),
                                                            $this->lang->line("Language") . " / " . $this->lang->line("Date")." & ". $this->lang->line("Time")." ". $this->lang->line("Setting")   =>  array(
                                                                "multilingual"      =>  $this->lang->line("Multilingual"),
                                                                "date_time"         =>  $this->lang->line("Date")." & ". $this->lang->line("Time")." ". $this->lang->line("Setting"),
                                                            ),
                                                                $this->lang->line("Support")   =>  array(
                                                                "free_support"   =>  $this->lang->line("Free Support"),
                                                            ),
                                                            $this->lang->line("Upload") . " " . $this->lang->line("My") . " " . $this->lang->line("Data")=>  array(
                                                                "domain_integration"   =>  $this->lang->line("Domain Integration"),
                                                                "website_color_font"   =>  $this->lang->line("Website Color / Font"),
                                                                "food_menu"   =>  $this->lang->line("Food Menu"),
                                                                "upload_images"   =>  $this->lang->line("Upload Images"),
                                                            ),
                                                        );
                                                        foreach ($select_features as $fkey => $feature_group) {
                                                            if (is_array($feature_group)){
                                                            ?> 
                                                                <optgroup label="<?= $fkey?>">
                                                            <?php 
                                                                foreach ($feature_group as $gkey => $gvalue) {
                                                                ?>
                                                                    <option value="<?=$gkey?>" <?=in_array($gkey,$addon_features_arr) ? "selected": "" ?>><?= $gvalue?></option>
                                                                <?php
                                                                }
                                                            ?>
                                                                </optgroup>
                                                            <?php
                                                            }else{
                                                                ?>
                                                                    <option value="<?=$fkey?>" <?=in_array($fkey,$addon_features_arr) ? "selected": "" ?>><?= $feature_group?></option>
                                                                <?php
                                                            }
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                       
                                    </div>
                                    <div class="form-group addon-content">
                                        <label class="text-capitalize"><?= $this->lang->line("content") ?> HTML</label>
                                        <div class="row french-field hide-field lang-field">
                                            <div class="col-md-8">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/fr-flag.png')?>" ></span>
                                                    </div>
                                                    <textarea class="addon_content_html summernote form-control" data-html_lang="french" name="addon_content_html_french"  placeholder = "" ><?=$addon_content_html->value_french?></textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-4 addon_html_preview" data-html_lang = "french">
                                                <div class="plan-package">
                                                    <div class="item pb-0">
                                                        <!-- item body -->
                                                        <div class="item-body px-md-3">
                                                            <?= $addon_content_html->value_french ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row english-field hide-field lang-field">
                                            <div class="col-md-8">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/en-flag.png')?>" ></span>
                                                    </div>
                                                    <textarea class="addon_content_html summernote form-control" data-html_lang="english" name="addon_content_html_english"  placeholder = "" ><?=$addon_content_html->value_english?></textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-4 addon_html_preview" data-html_lang = "english">
                                                <div class="plan-package">
                                                    <div class="item pb-0">
                                                        <!-- item body -->
                                                        <div class="item-body px-md-3">
                                                            <?= $addon_content_html->value_english ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row  germany-field hide-field lang-field">
                                            <div class="col-md-8">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/ge-flag.png')?>" ></span>
                                                    </div>
                                                    <textarea class="addon_content_html summernote form-control" data-html_lang="germany" name="addon_content_html_germany"  placeholder = "" ><?=$addon_content_html->value_germany?></textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-4 addon_html_preview" data-html_lang = "germany">
                                                <div class="plan-package">
                                                    <div class="item pb-0">
                                                        <!-- item body -->
                                                        <div class="item-body px-md-3">
                                                            <?= $addon_content_html->value_germany ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group mt-3">
                                        <input type="submit" name="" value="<?= $this->lang->line('SAVE')?>" class="btn btn-danger btn-user btn-block submit-btn">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- End of Page Content -->
