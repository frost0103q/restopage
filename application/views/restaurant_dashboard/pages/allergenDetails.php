
        <!-- Begin Page Content -->
            <div class="container-fluid">

                <!-- Page Heading -->
                <h1 class="h3 mb-2 text-gray-800"><?= $this->lang->line('Allergen Details')?></h1>
                <?php 
                // print_r($jobApplications);
                ?>
                <form id="updateAllergens" data-url = "<?=base_url('API/')?>">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary"><?= $this->lang->line('Update Allergen')?></h6>
                                </div>
                                <div class="card-body">
                                    
                                        <div class="form-group row">
                                            <div class="col-sm-8 mb-3 mb-sm-0">
                                                <input type="hidden" class="form-control form-control-user" id="allergen_id"  name="allergen_id" value="<?=$AllergenDetails[0]->allergen_id?>">
                                                <?php 
                                                    $en_f = true;
                                                    $ge_f = true;
                                                    $fr_f = true;
                                                ?>
                                                <?php if( in_array("english",explode(",",$this->myRestDetail->menu_languages))){ $en_f = false ; ?>
                                                <div class="input-group">
                                                    <input type="text" class="form-control form-control-user" placeholder="<?= $this->lang->line('Allergen Name')?>" name="allergen_name_english" value="<?=$AllergenDetails[0]->allergen_name_english?>">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/en-flag.png')?>"></span>
                                                    </div>
                                                </div>
                                                <?php }?>
                                                <?php if( in_array("french",explode(",",$this->myRestDetail->menu_languages))){ $fr_f = false ;  ?>
                                                <div class="input-group mt-2">
                                                    <input type="text" class="form-control form-control-user" placeholder="<?= $this->lang->line('Allergen Name')?>" name="allergen_name_french" value="<?=$AllergenDetails[0]->allergen_name_french?>">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/fr-flag.png')?>"></span>
                                                    </div>
                                                </div>
                                                <?php }?>
                                                <?php if( in_array("germany",explode(",",$this->myRestDetail->menu_languages))){ $ge_f = false ;  ?>
                                                <div class="input-group mt-2">
                                                    <input type="text" class="form-control form-control-user" placeholder="<?= $this->lang->line('Allergen Name')?>" name="allergen_name_germany" value="<?=$AllergenDetails[0]->allergen_name_germany?>">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/ge-flag.png')?>"></span>
                                                    </div>
                                                </div>
                                                <?php }?>
                                                <?php if (!(!$en_f || !$ge_f || !$fr_f)){ ?>
                                                    <a href=<?=base_url('Restaurant/setting/Language')?>><?= $this->lang->line('Click here to set Menu languages')?></a>
                                                <?php } ?>
                                            </div>
                                            <div class="col-sm-4 mb-3 mb-sm-0">
                                            <input type="submit" name="" value="<?= $this->lang->line('Update Allergen')?>" class="btn btn-primary btn-user btn-block">
                                            </div>
                                            
                                        </div>
                                    
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        <!-- /.container-fluid -->

        </div>
      <!-- End of Main Content -->
