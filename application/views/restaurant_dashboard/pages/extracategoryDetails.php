
        <!-- Begin Page Content -->
            <div class="container-fluid" id = "all_active_category" data-url = <?=base_url('/')?>>

                <!-- Page Heading -->
                <h1 class="h3 mb-2 text-gray-800"><?= $this->lang->line('Food Extra')?> <?= $this->lang->line('Category Details')?></h1>
                <?php 
                // print_r($jobApplications);
                ?>
                <form id="updateExtraCate">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary"><?= $this->lang->line('Food Extra')?> <?= $this->lang->line('Category')?></h6>
                                </div>
                                <div class="card-body">
                                    
                                        <div class="form-group row">
                                            <div class="col-sm-6 mb-2 mb-sm-0">
                                                <input type="hidden" class="form-control form-control-user" id="cat_id"  name="cat_id" value="<?=$CategoryDetails[0]->extra_category_id?>">
                                                <?php 
                                                    $en_f = true;
                                                    $ge_f = true;
                                                    $fr_f = true;
                                                ?>
                                                <?php if( in_array("english",explode(",",$this->myRestDetail->menu_languages))){ $en_f = false ; ?>
                                                <div class="input-group">
                                                    <input type="text" class="form-control form-control-user" placeholder="<?= $this->lang->line('Category Name')?>" name="cat_name_english" value="<?=$CategoryDetails[0]->extra_category_name_english?>">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/en-flag.png')?>"></span>
                                                    </div>
                                                </div>
                                                <?php }?>
                                                <?php if( in_array("french",explode(",",$this->myRestDetail->menu_languages))){ $fr_f = false ;  ?>
                                                <div class="input-group mt-2">
                                                    <input type="text" class="form-control form-control-user" placeholder="<?= $this->lang->line('Category Name')?>" name="cat_name_french" value="<?=$CategoryDetails[0]->extra_category_name_french?>">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/fr-flag.png')?>"></span>
                                                    </div>
                                                </div>
                                                <?php }?>
                                                <?php if( in_array("germany",explode(",",$this->myRestDetail->menu_languages))){ $ge_f = false ;  ?>
                                                <div class="input-group mt-2">
                                                    <input type="text" class="form-control form-control-user" placeholder="<?= $this->lang->line('Category Name')?>" name="cat_name_germany" value="<?=$CategoryDetails[0]->extra_category_name_germany?>">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/ge-flag.png')?>"></span>
                                                    </div>
                                                </div>
                                                <?php }?>
                                                <?php if (!(!$en_f || !$ge_f || !$fr_f)){ ?>
                                                    <a href=<?=base_url('Restaurant/setting/Language')?>><?= $this->lang->line('Click here to set Menu languages')?></a>
                                                <?php } ?>
                                                <input type="number" class="form-control form-control-user mt-2" id="category_sort_index" placeholder='Category Sort Index' name="category_sort_index" value="<?=$CategoryDetails[0]->extra_category_sort_index?>" min = "0" >
                                            </div>
                                            
                                            <div class="col-sm-6 mb-3 mb-sm-0 d-flex flex-column justify-content-between">
                                                <div class="mb-2 mb-sm-0">
                                                    <select class="form-control form-control-user" name="is_multi_select">
                                                        <option value="0" <?=$CategoryDetails[0]->is_multi_select == 0 ? "selected": ""?> ><?= $this->lang->line("Show as Dropdown Fields") ?></option>
                                                        <option value="1" <?=$CategoryDetails[0]->is_multi_select == 1 ? "selected": ""?>><?= $this->lang->line("Show as Multi Select Fields") ?></option>
                                                    </select>
                                                </div>
                                                <div class="">
                                                    <input type="submit" name="" value="<?= $this->lang->line('Update Category')?>" class="btn btn-primary btn-user btn-block">
                                                </div>
                                            </div>
                                            
                                        </div>
                                    
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary"><?= $this->lang->line('Food Extras')?></h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                                <th class="text-center"><?= $this->lang->line('S.No')?></th>
                                <th class="text-center"><?= $this->lang->line('English')?> <?= $this->lang->line('Name')?></th>
                                <th class="text-center"><?= $this->lang->line('French')?> <?= $this->lang->line('Name')?></th>
                                <th class="text-center"><?= $this->lang->line('Germany')?> <?= $this->lang->line('Name')?></th>
                                <th class="text-center"><?= $this->lang->line('Action')?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $i=1;?>
                            <?php foreach($FoodExtraDetails as $extra):?>
                                <tr>
                                <td class="text-center"><?=$i?></td>
                                <td class="text-center"><?=$extra->food_extra_name_english?></td>
                                <td class="text-center"><?=$extra->food_extra_name_french?></td>
                                <td class="text-center"><?=$extra->food_extra_name_germany?></td>
                                <td class="text-center">
                                    <a href="javascript:void(0)" class="edit_food_extra" title="<?= $this->lang->line('Edit Food Extra')?>" d-extra_id="<?=$extra->extra_id?>" d-food_extra_name_english="<?=$extra->food_extra_name_english?>" d-food_extra_name_french="<?=$extra->food_extra_name_french?>" d-food_extra_name_germany="<?=$extra->food_extra_name_germany?>"><i class="fas fa-eye"></i></a>
                                    <a href="javascript:void(0)" title="<?= $this->lang->line('Remove Food Extra')?>" class="text-danger removefood_extra" d-extra_id="<?=$extra->extra_id?>"><i class="fas fa-trash"></i></a>
                                </td>
                                </tr>
                            <?php $i++?>
                            <?php endforeach;?>
                            </tbody>
                        </table>
                        </div>
                    </div>
                </div>
            </div>
        <!-- /.container-fluid -->

        </div>
      <!-- End of Main Content -->
    <div id="editFoodExtra" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-body">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary"><?=$this->lang->line('Update Food Extra')?></h6>
                        </div>
                        <div class="card-body">
                            <form id="updateFoodExtra">
                                <div class="form-group row">
                                    <div class="col-sm-12 mb-3 mb-sm-0">
                                        <input type="hidden" class="form-control form-control-user foodExtra_id" name="foodExtra_id" value="">
                                        <?php 
                                            $en_f = true;
                                            $ge_f = true;
                                            $fr_f = true;
                                        ?>
                                        <?php if( in_array("english",explode(",",$this->myRestDetail->menu_languages))){ $en_f = false ; ?>
                                        <div class="input-group">
                                            <input type="text" class="form-control form-control-user" id="food_extra_name_english" placeholder='<?= $this->lang->line("Food Extra Name") ?>' name="food_extra_name_english" value="" >
                                            <div class="input-group-append">
                                                <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/en-flag.png')?>"></span>
                                            </div>
                                        </div>
                                        <?php }?>
                                        <?php if( in_array("french",explode(",",$this->myRestDetail->menu_languages))){ $fr_f = false ;  ?>
                                        <div class="input-group mt-2">
                                            <input type="text" class="form-control form-control-user" id="food_extra_name_french" placeholder='<?= $this->lang->line("Food Extra Name") ?>' name="food_extra_name_french" value="" >
                                            <div class="input-group-append">
                                                <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/fr-flag.png')?>"></span>
                                            </div>
                                        </div>
                                        <?php }?>
                                        <?php if( in_array("germany",explode(",",$this->myRestDetail->menu_languages))){ $ge_f = false ;  ?>
                                        <div class="input-group mt-2">
                                            <input type="text" class="form-control form-control-user" id="food_extra_name_germany" placeholder='<?= $this->lang->line("Food Extra Name") ?>' name="food_extra_name_germany" value="" >
                                            <div class="input-group-append">
                                                <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/ge-flag.png')?>"></span>
                                            </div>
                                        </div>
                                        <?php }?>
                                        <?php if (!(!$en_f || !$ge_f || !$fr_f)){ ?>
                                            <a href=<?=base_url('Restaurant/setting/Language')?>><?= $this->lang->line('Click here to set Menu languages')?></a>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-12 mb-3 mb-sm-0">
                                        <input type="submit" name="" value="<?=$this->lang->line('Update Food Extra')?>" class="btn btn-primary btn-user btn-block">
                                    </div>                         
                                </div>
                            
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?=$this->lang->line('Close')?></button>
                </div>
            </div>
        </div>
    </div>
