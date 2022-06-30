
<div class="container">
    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="p-5">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4"><?= $this->lang->line('Restaurant')?> <?= $this->lang->line('Page')?> <?= $this->lang->line('Banner')?></h1>
                            <hr>
                        </div>
                        <form class="user" id="uploadBannersForm">
                            <input type="hidden" class="form-control form-control-user"   name="rest_id" value="<?=$myRestId?>">
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <!-- <input type="file" name="rest_logo"> -->
                                    <?php
                                        if (isset($banner_settings->delivery_banner_url) && $banner_settings->delivery_banner_url !== ""){
                                            $delivery_banner_url = base_url("assets/rest_banner/").$banner_settings->delivery_banner_url;
                                        }else{
                                            $delivery_banner_url = "";
                                        }
                                    ?>
                                    <label><h5><?= $this->lang->line("Delivery")?> <?= $this->lang->line("Page")?> </h5></label>
                                    <input type="file" class="dropify" name="delivery_banner" data-default-file = "<?= $delivery_banner_url ?>" value = "<?= $delivery_banner_url ?>"/>
                                    <input type="hidden" name="is_update_delivery_banner" value = "<?= $delivery_banner_url == "" ? "1" : "0"?>" />
                                </div>
                                <div class="col-md-4">
                                    <?php
                                        if (isset($banner_settings->pickup_banner_url) && $banner_settings->pickup_banner_url !== ""){
                                            $pickup_banner_url = base_url("assets/rest_banner/").$banner_settings->pickup_banner_url;
                                        }else{
                                            $pickup_banner_url = "";
                                        }
                                    ?>
                                    <label><h5><?= $this->lang->line("Pickup")?> <?= $this->lang->line("Page")?> </h5></label>
                                    <input type="file" class="dropify" name="pickup_banner" data-default-file = "<?= $pickup_banner_url ?>" value = "<?= $pickup_banner_url ?>"/>
                                    <input type="hidden" name="is_update_pickup_banner" value = "<?= $pickup_banner_url == "" ? "1" : "0"?>" />
                                </div>
                                <div class="col-md-4">
                                    <?php
                                        if (isset($banner_settings->table_banner_url) && $banner_settings->table_banner_url !== ""){
                                            $table_banner_url = base_url("assets/rest_banner/").$banner_settings->table_banner_url;
                                        }else{
                                            $table_banner_url = "";
                                        }
                                    ?>
                                    <label><h5><?= $this->lang->line("Table")?> <?= $this->lang->line("Page")?> </h5></label>
                                    <input type="file" class="dropify" name="table_banner" data-default-file = "<?= $table_banner_url ?>" value = "<?= $table_banner_url ?>"/>
                                    <input type="hidden" name="is_update_table_banner" value = "<?= $table_banner_url == "" ? "1" : "0"?>" />
                                </div>
                            </div>
                            <input type="submit" value="<?= $this->lang->line('Update Data')?>" class="btn btn-primary btn-user btn-block">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

