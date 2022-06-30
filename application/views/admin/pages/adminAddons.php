        <!-- Begin Page Content -->
        <div class="container-fluid createAddon-page multi-lang-page" data-url ="<?= base_url('/')?>" >
            <div class="row">
                <div class="col-md-12 ">
                    <div class="content_wrap">
                        <form class="createAddon" method="post" enctype="multipart/form-data" id="createAddon">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3 d-flex justify-content-between title-bar">
                                    <h4 class="mb-0"><?= $this->lang->line("Add")?> <?= $this->lang->line("Addon")?></h4>
                                    <div class="lang-bar">
                                        <span class="<?= $_lang == 'english' ? 'active' : ''  ?> item-flag" data-flag="english"><img class="english-flag" src="<?= base_url('assets/flags/en-flag.png')?>"></span>
                                        <span class="<?= $_lang == 'french' ? 'active' : ''  ?> item-flag" data-flag="french"><img class="french-flag" src="<?= base_url('assets/flags/fr-flag.png')?>"></span>
                                        <span class="<?= $_lang == 'germany' ? 'active' : ''  ?> item-flag" data-flag="germany"><img class="germany-flag" src="<?= base_url('assets/flags/ge-flag.png')?>"></span>
                                    </div>
                                </div>
                                <div class="card-body mt-4 p-lg-5 p-md-4 p-2">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="addon-title form-group">
                                                <label class="" ><?= $this->lang->line("Title") ?></label>
                                                <div class="input-group french-field hide-field lang-field">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/fr-flag.png')?>" ></span>
                                                    </div>
                                                    <input type="text" class="form-control" name="addon_title_french"  placeholder = "" >
                                                </div>
                                                <div class="input-group english-field hide-field lang-field">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/en-flag.png')?>" ></span>
                                                    </div>
                                                    <input type="text" class="form-control" name="addon_title_english"  placeholder = "">
                                                </div>
                                                <div class="input-group germany-field hide-field lang-field">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/ge-flag.png')?>" ></span>
                                                    </div>
                                                    <input type="text" class="form-control" name="addon_title_germany"  placeholder = "">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group addon-title">
                                                <label class=""><?= $this->lang->line("Price") ?></label>
                                                <input type="number" class="form-control" min="0" step="0.01" name="addon_price"  placeholder = "10.00" >
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label><?= $this->lang->line("Currency")?></label>
                                            <?php 
                                                $countries = $this->db->where("NOT ISNULL(currency_code) AND currency_code <> ''")->get("tbl_countries")->result();
                                                $currency_id = 120;
                                                $current_currency_country = $this->db->where('id',$currency_id)->get("tbl_countries")->row();
                                            ?>
                                            <div class="row form-group">
                                                <div class="col-md-6">
                                                    <div class="input-group country_select_box">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="img-thumbnail flag flag-icon-background flag-icon-<?= strtolower($current_currency_country->abv) ?> country_flag"></i></span>
                                                        </div>
                                                        <select class="form-control form-control-user country_select currency_code_select_box" name="country">
                                                            <?php foreach ($countries as $key => $country) { ?>
                                                                <option value="<?= $country->id?>" data-country_code = "<?= strtolower($country->abv) ?>" data-currency_symbol = "<?= strtolower($country->currency_symbol) ?>" <?= $current_currency_country->id == $country->id ? "selected" : "" ?>><?= $country->name?></option>    
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="input-group currency_select_box">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text currency_symbol"> <?= $current_currency_country->currency_symbol ?></span>
                                                        </div>
                                                        <select class="form-control form-control-user currency_select currency_code_select_box" name="addon_price_currency_id">
                                                            <?php  foreach ($countries as $key => $country) { ?>
                                                                <option value="<?= $country->id?>" data-country_code = "<?= strtolower($country->abv) ?>" data-currency_symbol = "<?= strtolower($country->currency_symbol) ?>"  <?= $current_currency_country->id == $country->id ? "selected" : "" ?>><?= $country->currency_name?> (<?= $country->currency_symbol?>) </option>    
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
                                                    <option value="daily" ><?= $this->lang->line("daily") ?></option>
                                                    <option value="weekly"><?= $this->lang->line("weekly") ?></option>
                                                    <option value="monthly" selected><?= $this->lang->line("monthly") ?></option>
                                                    <option value="annually"><?= $this->lang->line("annually") ?></option>
                                                    <option value="lifetime"><?= $this->lang->line("lifetime") ?></option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group addon-trial">
                                                <label class="text-capitalize"><?= $this->lang->line("trial") ?> <?= $this->lang->line("period") ?> <em class="small text-lowercase"> ( <?= $this->lang->line("How many days for free") ?> ) </em></label>
                                                <div class="input-group">
                                                    <input type="number" class="form-control" min="0" step="1" name="addon_trial_period"  placeholder = "30" >
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
                                                    <input type="checkbox" data-plugin="switchery" name = "addon_status" data-color="#3DDCF7" checked/>
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
                                                                    <option value="<?=$gkey?>"><?= $gvalue?></option>
                                                                <?php
                                                                }
                                                            ?>
                                                                </optgroup>
                                                            <?php
                                                            }else{
                                                                ?>
                                                                    <option value="<?=$fkey?>"><?= $feature_group?></option>
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
                                                    <textarea class="addon_content_html summernote form-control" data-html_lang = "french" name="addon_content_html_french"  placeholder = "" ></textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-4 addon_html_preview" data-html_lang = "french">
                                            </div>
                                        </div>
                                        <div class="row english-field hide-field lang-field">
                                            <div class="col-md-8">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/en-flag.png')?>" ></span>
                                                    </div>
                                                    <textarea class="addon_content_html summernote form-control" data-html_lang = "english" name="addon_content_html_english"  placeholder = "" ></textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-4 addon_html_preview" data-html_lang = "english">
                                            </div>
                                        </div>
                                        <div class="row germany-field hide-field lang-field">
                                            <div class="col-md-8">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/ge-flag.png')?>" ></span>
                                                    </div>
                                                    <textarea class="addon_content_html summernote form-control" data-html_lang = "germany" name="addon_content_html_germany"  placeholder = "" ></textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-4 addon_html_preview" data-html_lang = "germany">
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
            <div class="content_wrap">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary text-capitalize"><?= $this->lang->line("All") ?> <?= $this->lang->line("Addons") ?></h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered dataTable dt-responsive nowrap"  width="100%" cellspacing="0">
                                <thead class="text-capitalize">
                                    <tr>
                                        <th><?= $this->lang->line("Addon") ?> <?= $this->lang->line("Title") ?></th>
                                        <th><?= $this->lang->line("Addon") ?> <?= $this->lang->line("Price") ?></th>
                                        <th><?= $this->lang->line("Addon") ?> <?= $this->lang->line("Lifecycle") ?></th>
                                        <th><?= $this->lang->line("Addon") ?> <?= $this->lang->line("trial")?> <?=$this->lang->line("period") ?></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        foreach ($addons as $akey => $addon) { 
                                            $addon_title = json_decode($addon->addon_title);
                                            $title_name_field = "value_" . $_lang;
                                            $title = $addon_title->$title_name_field == "" ? $addon_title->value: $addon_title->$title_name_field;
                                            
                                            $addon_content_html = json_decode($addon->addon_content_html);
                                            $content_html_field = "value_" . $_lang;
                                            $content_html = $addon_content_html->$content_html_field == "" ? $addon_content_html->value: $addon_content_html->$content_html_field;
                                            $addon_price_currency = $this->db->where("id",$addon->addon_price_currency_id)->get('tbl_countries')->row()->currency_symbol;
                                            $is_disabled_item = $addon->addon_status == "active" ? "" : "disable-item";
                                                    
                                        
                                        ?>
                                            <tr class="addon_row <?=$is_disabled_item?>" data-addon_id = "<?= $addon->addon_id?>" data-status="<?= $addon->addon_status?>">
                                                <td class="text-center text-capitalize"><?= $title ?></td>
                                                <td class="text-center text-capitalize"><?= $addon->addon_price ?> <?=$addon_price_currency?></td>
                                                <td class="text-center text-capitalize"><?= $addon->addon_lifecycle == "lifetime" ? "one time" : $addon->addon_lifecycle ?></td>
                                                <td class="text-center text-capitalize"><?= $addon->addon_trial_period > 0 ? $addon->addon_trial_period . " days" : "No" ?></td>
                                                <td class="text-center text-capitalize">
                                                    <a class="btn btn-primary" href="<?=base_url('Admin/addonDetail/').$addon->addon_id?>" title="<?= $this->lang->line('Edit')?> <?= $this->lang->line('Addon')?>"><i class="fas fa-eye"></i></a>
                                                    <a href="javascript:void(0)" title="<?= $this->lang->line('Remove')?> <?= $this->lang->line('Addon')?>" class=" btn btn-danger  remove_addon" d-addon_id="<?=$addon->addon_id?>"><i class="fas fa-trash"></i></a>
                                                    <input type="checkbox" data-plugin="switchery" name = "is_active_addon" data-color="#3DDCF7"  d-addon_id="<?=$addon->addon_id?>"  class = "handle_addon" <?= $addon->addon_status && $addon->addon_status == "active" ? "checked" : "" ?>/>
                                                </td>
                                            </tr>
                                        <?php }   
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End of Page Content -->
