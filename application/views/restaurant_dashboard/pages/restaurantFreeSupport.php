
	<div class="container">

<div class="card o-hidden border-0 shadow-lg my-5">
    <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">
     
            <div class="col-lg-12">
                <div class="p-2 p-sm-5">
                    <div class="text-center">
                        <h1 class="h4 text-gray-900 mb-4"><?= $this->lang->line("Free Support")?></h1>
                        <hr>
                    </div>
                    <?php if (isset($admin->admin_is_other_info) && $admin->admin_is_other_info == 1){ 
                        $admin_other_info_field = "admin_other_info_" . $_lang;
                        ?>
                    <div class="admin-info my-3">
                        <?= $admin->$admin_other_info_field?>
                    </div>
                    <?php } ?>
                    
                    <?php if (isset($admin->admin_is_contact_email) && $admin->admin_is_contact_email == 1){ ?>
                    <div class="admin-info my-3">
                        <label><?= $this->lang->line("Admin")?> <?= $this->lang->line("Email")?></label>
                        <div class="form-group row">
                            <div class="col-12 mb-3">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                                    </div>
                                    <input type="email" class="form-control" name="admin_contact_email" value="<?= $admin->admin_contact_email?>" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php } ?>

                    <?php if (isset($admin->admin_is_fax) && $admin->admin_is_fax == 1){ ?>
                    <div class="admin-info">
                        <label><?= $this->lang->line("Admin")?> <?= $this->lang->line("Fax")?></label>
                        <div class="form-group row">
                            <div class="col-12 mb-3">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-fax"></i></span>
                                    </div>
                                    <input type="text" class="form-control" name="admin_fax" value="<?= $admin->admin_fax?>" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                    
                    <?php if (isset($admin->admin_is_phone) && $admin->admin_is_phone == 1){ ?>
                    <div class="admin-info">
                        <label><?= $this->lang->line("Admin")?> <?= $this->lang->line("Phone")?></label>
                        <div class="form-group row">
                            <div class="col-12 mb-3">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-phone"></i></span>
                                    </div>
                                    <input type="text" class="form-control" name="admin_phone" value="<?= $admin->admin_phone ?>" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                    
                    <?php 
                    $rest_details = $this->db->where('restaurant_id',$myRestId)->get('tbl_restaurant_details')->row();
                    if (isset($admin->admin_is_whatsapp) && $admin->admin_is_whatsapp == 1){ ?>
                    <div class="admin-info">
                        <label><?= $this->lang->line("Admin")?> Whatsapp</label>
                        <div class="form-group row">
                            <div class="col-12 mb-3">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-phone-square"></i></span>
                                    </div>
                                    <input type="text" class="form-control" name="admin_whatsapp" value="<?= $admin->admin_whatsapp ?>" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                    <hr>
                </div>
            </div>
        </div>
    </div>
</div>

</div>

