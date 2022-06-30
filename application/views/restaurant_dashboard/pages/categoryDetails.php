
        <!-- Begin Page Content -->
            <div class="container-fluid multi-lang-page menu-lang-page" id = "all_active_category" data-url = <?=base_url('/')?>>

                <!-- Page Heading -->
                <h1 class="h3 mb-2 text-gray-800"><?= $this->lang->line('Category Details')?></h1>
                <?php 
                // print_r($jobApplications);
                ?>
                <form id="updateCate">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary  d-flex justify-content-between"><?= $this->lang->line('Update Category') ?>
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
                                    <div class="form-group row">
                                        <div class="col-sm-8 mb-3 mb-sm-0">
                                            <input type="hidden" class="form-control form-control-user" id="cat_id"  name="cat_id" value="<?=$CategoryDetails[0]->category_id?>">
                                            
                                            <section>
                                                <div class="input-group english-field hide-field lang-field">
                                                    <input type="text" class="form-control form-control-user" placeholder='<?= $this->lang->line("Category Name") ?>' name="cat_name_english" value="<?=$CategoryDetails[0]->category_name_english?>" >
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/en-flag.png')?>"></span>
                                                    </div>
                                                </div>
                                                <div class="input-group french-field hide-field lang-field">
                                                    <input type="text" class="form-control form-control-user" placeholder='<?= $this->lang->line("Category Name") ?>' name="cat_name_french" value="<?=$CategoryDetails[0]->category_name_french?>" >
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/fr-flag.png')?>"></span>
                                                    </div>
                                                </div>
                                                <div class="input-group germany-field hide-field lang-field">
                                                    <input type="text" class="form-control form-control-user" placeholder='<?= $this->lang->line("Category Name") ?>' name="cat_name_germany" value="<?=$CategoryDetails[0]->category_name_germany?>" >
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/ge-flag.png')?>"></span>
                                                    </div>
                                                </div>
                                            </section>
                                            <section class="mt-2">
                                                <div class="input-group english-field hide-field lang-field">
                                                    <textarea type="text" class="form-control form-control-user" placeholder='<?= $this->lang->line("Category") ?> <?= $this->lang->line("Description") ?>' name="cat_description_english" ><?=$CategoryDetails[0]->category_description_english?></textarea>
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/en-flag.png')?>"></span>
                                                    </div>
                                                </div>
                                                <div class="input-group french-field hide-field lang-field">
                                                    <textarea type="text" class="form-control form-control-user" placeholder='<?= $this->lang->line("Category") ?> <?= $this->lang->line("Description") ?>' name="cat_description_french" ><?=$CategoryDetails[0]->category_description_french?></textarea>
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/fr-flag.png')?>"></span>
                                                    </div>
                                                </div>
                                                <div class="input-group germany-field hide-field lang-field">
                                                    <textarea type="text" class="form-control form-control-user" placeholder='<?= $this->lang->line("Category") ?> <?= $this->lang->line("Description") ?>' name="cat_description_germany" ><?=$CategoryDetails[0]->category_description_germany?></textarea>
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/ge-flag.png')?>"></span>
                                                    </div>
                                                </div>
                                            </section>
                                            <input type="number" class="form-control form-control-user mt-2" id="category_sort_index" placeholder='Category Sort Index' name="category_sort_index" value="<?=$CategoryDetails[0]->category_sort_index?>" min = "0" >
                                        </div>
                                        
                                        <div class="col-sm-4 mb-3 mb-sm-0">
                                            <input type="submit" name="" value="<?= $this->lang->line('Update Category')?>" class="btn btn-primary btn-user btn-block">
                                        </div>
                                        
                                    </div>                                    
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card shadow mt-4 mb-4">
                                <input type="file" class="dropify" name="category_image" data-default-file="<?=base_url('assets/category_images/').$CategoryDetails[0]->category_image?>"/>
                                <input type="hidden" name="is_category_image" value="<?=$CategoryDetails[0]->category_image == "" ? 1 : 0 ?>" />
                            </div>
                        </div>
                    </div>
                </form>
                
                <!-- DataTales Example -->
                <div class="card shadow mb-4 d-none">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary"><?= $this->lang->line('Sub Categories')?></h6>
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
                            <?php foreach($subCategoryDetails as $cat):?>
                                <tr>
                                <td class="text-center"><?=$i?></td>
                                <td class="text-center"><?=$cat->sub_category_name_english?></td>
                                <td class="text-center"><?=$cat->sub_category_name_french?></td>
                                <td class="text-center"><?=$cat->sub_category_name_germany?></td>
                                <td class="text-center">
                                    <a href="javascript:void(0)" class="edit_sub_cat" title="<?= $this->lang->line('Edit Sub Category')?>" d-sub_cat_id="<?=$cat->sub_cat_id?>" d-sub_cat_name_english="<?=$cat->sub_category_name_english?>" d-sub_cat_name_french="<?=$cat->sub_category_name_french?>" d-sub_cat_name_germany="<?=$cat->sub_category_name_germany?>"><i class="fas fa-eye"></i></a>
                                    <a href="javascript:void(0)" title="<?= $this->lang->line('Remove Sub Category')?>" class="text-danger removesub_category" d-sub_cat_id="<?=$cat->sub_cat_id?>"><i class="fas fa-trash"></i></a>
                                </td>
                                </tr>
                            <?php $i++?>
                            <?php endforeach;?>
                            </tbody>
                        </table>
                        </div>
                    </div>
                </div>
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
