
<div class="container">
    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="py-5 px-md-5 px-3">
                        <form class="user" id="restaurantSetting">
                            <section class="plan-package">
                                <div class="">
                                    <h1 class="h4 text-gray-900 mb-4"><?= $this->lang->line('Restaurant')?> <?= $this->lang->line('Addons')?></h1>
                                    <hr>
                                </div>
                                <div class="row">
                                    <?php
                                        foreach ($addons as $addon) { 
                                            $addon_title = json_decode($addon->addon_title);
                                            $title_name_field = "value_" . $_lang;
                                            $title = $addon_title->$title_name_field == "" ? $addon_title->value: $addon_title->$title_name_field;
                                            
                                            $addon_content_html = json_decode($addon->addon_content_html);
                                            $content_html_field = "value_" . $_lang;
                                            $content_html = $addon_content_html->$content_html_field == "" ? $addon_content_html->value: $addon_content_html->$content_html_field;
                                            $addon_price_currency = $this->db->where("id",$addon->addon_price_currency_id)->get('tbl_countries')->row()->currency_symbol;
                                            $current_addon_ids_arr = explode(",",$currentRestDetail->addon_ids);
                                            if (!empty($current_addon_ids_arr) && in_array($addon->addon_id,$current_addon_ids_arr)){
                                                $is_mine = true;
                                            }else{
                                                $is_mine = false;
                                            }
                                            $status = 'inactive';
                                            if ($rest_addon = $this->db->where("rest_id",$rest_id)->where("addon_id",$addon->addon_id)->get('tbl_restaurant_addons')->row()){
                                                $status = $rest_addon->status;
                                            }
                                    ?>
                                        <div class="col-lg-4 col-sm-12 p-lg-3 mb-lg-0 mb-4 addon-plan <?= $is_mine ? "active-addon" : "inactive-addon" ?>">
                                            <!-- item -->
                                            <div class="item">
                                                <!-- item head -->
                                                <div class="item-head px-4">
                                                    <!-- name -->
                                                    <h5 class="name p-0"><?= $title?></h5>
                                                    <!-- price -->
                                                    <div class="price">
                                                        <div class="d-flex align-items-center justify-content-start flex-wrap">
                                                            <!-- count -->
                                                            <div class="count"><?= str_replace(".",",",number_format($addon->addon_price,2)) ?></div>
                                                            <!-- currency -->
                                                            <div class="currency mx-1"> <?= $addon_price_currency?></div>
                                                            <!-- commnet -->
                                                            <div class="comment ml-1">/ <?= $addon->addon_lifecycle == "lifetime" ? "one time" : $addon->addon_lifecycle ?></div>
                                                        </div>
                                                    </div>
                                                    <?php if ($addon->addon_trial_period > 0) { ?>
                                                        <em class="free-time">first <span class="free-time-day"><?=$addon->addon_trial_period?></span> days for free</em>
                                                    <?php } ?>
                                                </div>
                                                <!-- item body -->
                                                <div class="item-body px-md-3 px-2">
                                                    <?= $content_html ?>
                                                </div>
                                                <!-- item footer -->
                                                <div class="item-footer">
                                                    <?php
                                                        if ($is_mine){
                                                    ?>
                                                    <span class="th-btn-fill-primary text-uppercase w-100 bg-warning btn-warning plan-btn cancel-addon-btn btn" role="button" d-addon_id = "<?=$addon->addon_id?>">
                                                        Cancel
                                                    </span>
                                                    <?php
                                                        }else if ($status=='inactive') {
                                                    ?>
                                                    <a class="th-btn-fill-primary text-uppercase w-100 bg-success btn-success plan-btn activate-addon-btn btn" role="button" d-addon_id = "<?= $addon->addon_id?>" href="<?= base_url("Restaurant/AddonPayout/").$addon->addon_id ?>">
                                                        Activate
                                                    </a>
                                                    <?php
                                                        }else{
                                                    ?>
                                                        <a class="th-btn-fill-primary text-uppercase w-100 bg-danger btn-danger plan-btn activate-addon-btn btn disabled" d-addon_id = "<?= $addon->addon_id?>">
                                                            <?= $status?>
                                                        </a>
                                                    <?php
                                                        }
                                                    ?>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                        }
                                    ?>
                                </div>
                                <hr>
                                <div class="text-center">
                                    17% tax included in prices
                                </div>
                            </section>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

