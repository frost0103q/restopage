<div class="container">
	<div class="card o-hidden border-0 shadow-lg my-5">
		<div class="card-body p-md-5 p-3">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="h4 text-gray-900 mb-4"><?= $this->lang->line('Delivery Area')?></h1>
                    <hr>
                </div>
            </div>
            <form id="updatedDeliveryAreaDetail">
                <div class="row">
                    <div class="col-md-4  mt-4">
                        <label><?= $this->lang->line('Country')?> <span class="text-danger">*</span></label>
                        <select class="form-control form-control-user" name="country_for_postcode" id="country_for_postcode">
                            <option >Select Country</option>
                            <?php
                                $countries = $this->db->get("tbl_countries")->result();
                                foreach ($countries as $ck => $cvalue) {
                                    if ($areaDetail->area_country == $cvalue->name){
                                        echo '<option value = "'.$cvalue->name.'" selected >'.$cvalue->name.'</option>';
                                    }else{
                                        echo '<option value = "'.$cvalue->name.'"  >'.$cvalue->name.'</option>';
                                    }
                                }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-4 mt-4">
                        <label><?= $this->lang->line('Post Code')?> <span class="text-danger">*</span></label>
                        <input type="hidden" class="form-control form-control-user" id="area_id" name="area_id" required value="<?= $areaDetail->id?>">
                        <input type="hidden" class="form-control form-control-user" id="rest_id" name="rest_id" value="<?=$myRestId?>">
                        <input type="text" class="form-control form-control-user" id="postcode" placeholder="<?= $this->lang->line('Enter ZipCode / PostCode')?>" name="postcode" required value="<?= $areaDetail->post_code?>">
                    </div>                
                </div>
                <div class="row">
                    <div class="col-md-4 mt-4">
                        <label><?= $this->lang->line('Area Name')?>(English)</label>
                        <div class="input-group">
                            <input type="text" class="form-control form-control-user" id="areaname_english" name="areaname_english" value="<?= $areaDetail->area_name_english?>">
                            <div class="input-group-append">
                                <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/en-flag.png')?>"></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mt-4">
                        <label><?= $this->lang->line('Area Name')?>(French)</label>
                        <div class="input-group">
                            <input type="text" class="form-control form-control-user" id="areaname_french" name="areaname_french" value="<?= $areaDetail->area_name_french?>">
                            <div class="input-group-append">
                                <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/fr-flag.png')?>"></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mt-4">
                        <label><?= $this->lang->line('Area Name')?>(Germany)</label>
                        <div class="input-group">
                            <input type="text" class="form-control form-control-user" id="areaname_germany"  name="areaname_germany" value="<?= $areaDetail->area_name_germany?>">
                            <div class="input-group-append">
                                <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/ge-flag.png')?>"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 mt-4">
                        <label><?= $this->lang->line('Minimum Order Amount')?> <span class="text-danger">*</span></label>
                        <input type="number" class="form-control form-control-user" id="minimum_order_amount" placeholder="<?= $this->lang->line('Enter Min Order')?>" name="minimum_order_amount" required min="0" step="0.01" value="<?= $areaDetail->min_order_amount?>">
                    </div>
                    <div class="col-md-4 mt-4">
                        <label><?= $this->lang->line('Delivery Charge')?> <span class="text-danger">*</span></label>
                        <input type="number" class="form-control form-control-user" id="delivery_charge" placeholder="<?= $this->lang->line('Enter Delivery Charge')?>" name="delivery_charge" required min="0" step="0.01" value="<?= $areaDetail->delivery_charge?>">
                    </div>
                    <div class="col-md-4 mt-4">
                        <label><?= $this->lang->line('Delivery Time')?></label>
                        <input type="text" class="form-control form-control-user" id="delivery_time" placeholder="<?= $this->lang->line('Enter Delivery Time')?>" name="delivery_time" value="<?= $areaDetail->delivery_time?>">
                    </div>
                    <div class="col-md-6 mt-4">
                        <label><?= $this->lang->line('Minimum Order Amount for Free Delivery Charge')?></label>
                        <input type="number" class="form-control form-control-user" id="min_order_amount_free_delivery" placeholder="<?= $this->lang->line('Minimum Order Amount for Free Delivery Charge')?>" name="min_order_amount_free_delivery" min="0" step="0.01" value="<?= $areaDetail->min_order_amount_free_delivery?>">
                    </div>
                    <div class="col-md-6 mt-4">
                        <label><?= $this->lang->line('Status')?></label>
                        <select class="form-control form-control-user" id="status" name="status">
                            <option value = "active" <?=$areaDetail->status == "active" ? "selected" : "" ?>> <?= $this->lang->line("Active")?> </option>
                            <option value = "deactive" <?=$areaDetail->status !== "active" ? "selected" : "" ?>> <?= $this->lang->line("Deactive")?>  </option>
                        </select>
                    </div>
                </div>
                <input type="submit"  value="<?= $this->lang->line('Update Data')?>" class="btn btn-primary mt-5">
            </form>
        </div>
    </div>
</div>


