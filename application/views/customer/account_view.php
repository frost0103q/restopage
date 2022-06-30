<div class="content-page">
    <div class="content">

        <div class="container-fluid">
            <div class="card-box">
                <div class="">
                    <h4 class="header-title mt-0 mb-4 text-warning">Account Settings</h4>
                    <form id = "updateUserAccount" action = "post" data-url="<?= base_url("/") ?>">
                        <div class="row">
                            <div class="col-sm-6 mb-3">
                                <label><?= $this->lang->line('Full Name')?><span class="text-danger"> *</span></label>
                                <input type="text" class="form-control form-control-user required-field"  placeholder="<?= $this->lang->line('Full Name')?>" name="name" id = "name" value="<?= $customer ? $customer->customer_name : "" ?>" required >
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 mb-3">
                                <label><?= $this->lang->line('E-Mail')?><span class="text-danger"> *</span></label>
                                <input type="email" class="form-control form-control-user required-field"  placeholder="<?= $this->lang->line('E-Mail')?>" name="email" id="email" value="<?= $this->userEmail ?>" required readonly>
                            </div>
                            <div class="col-sm-6 mb-3">
                                <label><?= $this->lang->line('Phone Number')?><span class="text-danger"> *</span></label>
                                <input type="text" class="form-control form-control-user required-field"  placeholder="<?= $this->lang->line('Phone Number')?>" name="phone" id="phone" value="<?= $customer ? $customer->customer_phone : "" ?>" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 mb-3">
                                <label><?= $this->lang->line('Country')?></label>
                                <select class="form-control" name = "country" id="country">
                                    <option><?=$this->lang->line("Select Country")?></option>
                                    <?php
                                        $countries = $this->db->get("tbl_countries")->result();
                                        foreach ($countries as $ckey => $cvalue) {
                                            $select = "";
                                            if ($customer){
                                                if ($customer->customer_country_abv == $cvalue->abv){
                                                    $select = "selected";
                                                }
                                            }
                                            echo "<option value = '".$cvalue->abv."' ".$select.">".$cvalue->name."</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 mb-3">
                                <label><?= $this->lang->line('City')?> </label>
                                <input type="text" class="form-control form-control-user"  placeholder="<?= $this->lang->line('City')?>" name="city" id="city" value="<?= $customer ? $customer->customer_city : "" ?>">
                            </div>
                            <div class="col-sm-6 mb-3">
                                <label><?= $this->lang->line('Address')?> ( Street and Number ) </label>
                                <input type="text" class="form-control form-control-user"  placeholder="<?= $this->lang->line('Address')?>" name="address" id="address" value="<?= $customer ? $customer->customer_address : "" ?>">
                            </div>
                            <div class="col-sm-6 mb-3">
                                <label><?= $this->lang->line('Floor')?> </label>
                                <input type="text" class="form-control form-control-user"  placeholder="<?= $this->lang->line('Floor')?>" name="floor" id="floor" value="<?= $customer ? $customer->customer_floor : "" ?>">
                            </div>
                            <div class="col-sm-6 mb-3">
                                <label>Postcode</label>
                                <input type="text" class="form-control form-control-user"  placeholder="<?= $this->lang->line('Post Code')?>" name="postcode" id="postcode" value="<?= $customer ? $customer->customer_postcode : "" ?>" >
                            </div>
                            <div class="col-sm-6 mb-3">
                                <label>Current <?= $this->lang->line('Password')?>  </label>
                                <input type="password" class="form-control form-control-user"  placeholder="Current <?= $this->lang->line('Password')?>" name="current_password" id = "current_password" >
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 mb-3">
                                <label>New <?= $this->lang->line('Password')?>  </label>
                                <input type="password" class="form-control form-control-user"  placeholder="New <?= $this->lang->line('Password')?>" name="new_password" id = "new_password" >
                            </div>
                            <div class="col-sm-6 mb-3">
                                <label>Confirm <?= $this->lang->line('Password')?>  </label>
                                <input type="password" class="form-control form-control-user"  placeholder="Confirm <?= $this->lang->line('Password')?>" id="confirm_password" name="confirm_password" >
                            </div>
                        </div>
                        <div class="row justify-content-center mt-5">
                            <button type="submit" class="btn btn-primary  px-5">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

