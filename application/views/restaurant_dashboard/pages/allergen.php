
        <!-- Begin Page Content -->

        <div class="container-fluid multi-lang-page menu-lang-page">

            <!-- Page Heading -->
            <!-- <h1 class="h3 mb-2 text-gray-800"><?= $this->lang->line("Allergens") ?></h1> -->

            <div class="content_wrap tab-content">
                <section>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary  d-flex justify-content-between"><?= $this->lang->line("New Allergen") ?>
                                        <div class="lang-bar">
                                            <?php 
                                                $en_f = true;
                                                $ge_f = true;
                                                $fr_f = true;
                                            ?>
                                            <?php if( in_array("english",explode(",",$this->myRestDetail->menu_languages))){ $en_f = false ; ?>
                                                <span class="<?= explode(",",$this->myRestDetail->menu_languages)[0] == 'english' ? 'active' : ''  ?> item-flag" data-flag="english"><img class="english-flag" src="<?= base_url('assets/flags/en-flag.png')?>"></span>
                                            <?php }?>
                                            <?php if( in_array("french",explode(",",$this->myRestDetail->menu_languages))){ $fr_f = false ;  ?>
                                                <span class="<?= explode(",",$this->myRestDetail->menu_languages)[0] == 'french' ? 'active' : ''  ?> item-flag" data-flag="french"><img class="french-flag" src="<?= base_url('assets/flags/fr-flag.png')?>"></span>
                                            <?php }?>
                                            <?php if( in_array("germany",explode(",",$this->myRestDetail->menu_languages))){ $ge_f = false ;  ?>
                                                <span class="<?= explode(",",$this->myRestDetail->menu_languages)[0] == 'germany' ? 'active' : ''  ?> item-flag" data-flag="germany"><img class="germany-flag" src="<?= base_url('assets/flags/ge-flag.png')?>"></span>
                                            <?php }?>
                                            <?php if (!(!$en_f || !$ge_f || !$fr_f)){ ?>
                                                <a href=<?=base_url('Restaurant/setting/Language')?>><?= $this->lang->line('Click here to set Menu languages')?></a>
                                            <?php } ?>
                                        </div>
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <form id = "addNewAllergen" class="addNewAllergen" data-url = "<?=base_url('API/')?>">
                                        <div class="form-group row">
                                            <div class="col-sm-8 mb-3 mb-sm-0">
                                                <input type="hidden" class="form-control form-control-user" id="added_by_<?= $allergen_lang?>"  name="added_by" value="<?=$myRestId?>" readonly>
                                                <div class="input-group french-field hide-field lang-field">
                                                    <input type="text" class="form-control form-control-user" id="allergen_name_french" placeholder='<?= $this->lang->line("Allergen Name") ?>' name="allergen_name_french" value="" >
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/fr-flag.png')?>"></span>
                                                    </div>
                                                </div>
                                                <div class="input-group germany-field hide-field lang-field">
                                                    <input type="text" class="form-control form-control-user" id="allergen_name_germany" placeholder='<?= $this->lang->line("Allergen Name") ?>' name="allergen_name_germany" value="" >
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/ge-flag.png')?>"></span>
                                                    </div>
                                                </div>
                                                <div class="input-group english-field hide-field lang-field">
                                                    <input type="text" class="form-control form-control-user" id="allergen_name_english" placeholder='<?= $this->lang->line("Allergen Name") ?>' name="allergen_name_english" value="" >
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/en-flag.png')?>"></span>
                                                    </div>
                                                </div>
                                              
                                            </div>
                                            <div class="col-sm-4 mb-3 mb-sm-0">
                                                <input type="submit" name="" value='<?= $this->lang->line("Add New Allergen") ?>' class="btn btn-primary btn-user btn-block">
                                            </div>
                                            
                                        </div>
                                    
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary"><?= $this->lang->line("All Allergens")?></h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th class="text-center"><?= $this->lang->line("S.No")?></th>
                                        <th class="text-center"><?= $this->lang->line("Name")?></th>
                                        <th class="text-center"><?= $this->lang->line("Action")?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i=1;?>
                                    <?php foreach($allergens as $allergen):
                                            $allergen_field_name = 'allergen_name_' . $allergen_lang;
                                            $allergentitle = trim($allergen->$allergen_field_name) == "" ? $allergen->allergen_name : $allergen->$allergen_field_name;
                                        ?>
                                        <tr>
                                            <td class="text-center"><?=$i?></td>
                                            <td class="text-center"><?= $allergentitle?></td>
                                            <td class="text-center">
                                                <a href="<?=base_url('Restaurant/allergenDetails/').$allergen->allergen_id?>" title="<?= $this->lang->line('Edit Allergen')?>"><i class="fas fa-eye"></i></a>
                                                <a href="javascript:void(0)" title="<?= $this->lang->line('Remove Allergen')?>" class="text-danger remove_allergen" d-allergen_id="<?=$allergen->allergen_id?>"><i class="fas fa-trash"></i></a>
                                            </td>
                                        </tr>
                                        <?php $i++ ; ?>
                                    <?php endforeach;?>
                                </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
        <!-- /.container-fluid -->

    </div>
      <!-- End of Main Content -->
