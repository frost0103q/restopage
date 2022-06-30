
        <!-- Begin Page Content -->

        <div class="container-fluid multi-lang-page menu-lang-page" id = "all_active_category" data-url = <?=base_url('/')?>>

            <!-- Page Heading -->
            <h1 class="h3 mb-2 text-gray-800"><?= $this->lang->line("Categories") ?></h1>
            <!-- modify by Jfrost -->
            <section class="my-5 tab-panel-j">
                <div class="row language-panel">
                    <div class="d-flex align-items-center mx-auto">
                        <ul class="nav nav-tabs">
                            <li class="active"><a class="<?= explode(",",$this->myRestDetail->menu_languages)[0] == 'english' ? 'active' : ''  ?>" href="<?=base_url('Restaurant/Category/english')?>"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/en-flag.png')?>"></a></li>
                            <li><a class = "<?= explode(",",$this->myRestDetail->menu_languages)[0] == 'french' ? 'active' : ''  ?>" href="<?=base_url('Restaurant/Category/french')?>" ><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/fr-flag.png')?>"></a></li>
                            <li><a class = "<?= explode(",",$this->myRestDetail->menu_languages)[0] == 'germany' ? 'active' : ''  ?>" href="<?=base_url('Restaurant/Category/germany')?>"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/ge-flag.png')?>"></a></li>
                        </ul>
                    </div>
                </div>    
                <div class="row type-panel mt-2">
                    <div class="d-flex align-items-center mx-auto">
                        <ul class="nav nav-tabs">
                            <?php 
                            $th = 0;
                            $types = $this->db->get('tbl_category_type')->result();
                            foreach ($types as $key => $type) { 
                                $th++;
                                $type_field = 'type_title_'.$category_lang;
                                ?>
                                <li class="<?= $th == 1 ? 'active' : '' ?>"><a class="category_cattype <?= $th == 1 ? 'active' : '' ?>" data-toggle="tab" href="#<?= $type->type_title?>"><?= $type->$type_field?></a></li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </section>
            <!-- ---------------- -->

            <div class="content_wrap tab-content">
                <?php
                $ti = 0;
                foreach ($types as $key => $type) { $ti++;?>
                    <section id="<?= $type->type_title?>" class = "tab-pane <?=$ti== 1 ? 'active' : '' ?>">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card shadow mb-4">
                                    <div class="card-header py-3">
                                        <h6 class="m-0 font-weight-bold text-primary  d-flex justify-content-between"><?= $this->lang->line("New Categories") ?>
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
                                        <form id = "addNewCate_<?= $type->type_title?>" class="addNewCate">
                                            <div class="form-group row">

                                                <div class="col-md-12 mb-2">
                                                    <input type="file" class="dropify" name="category_image" />
                                                </div>
                                                <div class="col-sm-8 mb-3 mb-sm-0">
                                                    <input type="hidden" class="form-control form-control-user" name="added_by" value="<?=$myRestId?>" readonly>
                                                    <input type="hidden" class="form-control form-control-user" name="type_id" value="<?=$type->type_id?>" readonly>
                                                    <section>
                                                        <div class="input-group english-field hide-field lang-field">
                                                            <input type="text" class="form-control form-control-user" placeholder='<?= $this->lang->line("Category Name") ?>' name="cat_name_english" value="" >
                                                            <div class="input-group-append">
                                                                <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/en-flag.png')?>"></span>
                                                            </div>
                                                        </div>
                                                        <div class="input-group french-field hide-field lang-field">
                                                            <input type="text" class="form-control form-control-user" placeholder='<?= $this->lang->line("Category Name") ?>' name="cat_name_french" value="" >
                                                            <div class="input-group-append">
                                                                <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/fr-flag.png')?>"></span>
                                                            </div>
                                                        </div>
                                                        <div class="input-group germany-field hide-field lang-field">
                                                            <input type="text" class="form-control form-control-user" placeholder='<?= $this->lang->line("Category Name") ?>' name="cat_name_germany" value="" >
                                                            <div class="input-group-append">
                                                                <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/ge-flag.png')?>"></span>
                                                            </div>
                                                        </div>
                                                    </section>
                                                    <section class="mt-2">
                                                        <div class="input-group english-field hide-field lang-field">
                                                            <textarea type="text" class="form-control form-control-user" placeholder='<?= $this->lang->line("Category") ?> <?= $this->lang->line("Description") ?>' name="cat_description_english" value="" ></textarea>
                                                            <div class="input-group-append">
                                                                <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/en-flag.png')?>"></span>
                                                            </div>
                                                        </div>
                                                        <div class="input-group french-field hide-field lang-field">
                                                            <textarea type="text" class="form-control form-control-user" placeholder='<?= $this->lang->line("Category") ?> <?= $this->lang->line("Description") ?>' name="cat_description_french" value="" ></textarea>
                                                            <div class="input-group-append">
                                                                <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/fr-flag.png')?>"></span>
                                                            </div>
                                                        </div>
                                                        <div class="input-group germany-field hide-field lang-field">
                                                            <textarea type="text" class="form-control form-control-user" placeholder='<?= $this->lang->line("Category") ?> <?= $this->lang->line("Description") ?>' name="cat_description_germany" value="" ></textarea>
                                                            <div class="input-group-append">
                                                                <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/ge-flag.png')?>"></span>
                                                            </div>
                                                        </div>
                                                    </section>
                                                    <input type="number" class="form-control form-control-user mt-2" placeholder='Category Sort Index' name="category_sort_index" value="" min = "0" >
                                                </div>
                                                <div class="col-sm-4 mb-3 mb-sm-0">
                                                    <input type="submit" name="" value='<?= $this->lang->line("Add New Category") ?>' class="btn btn-primary btn-user btn-block">
                                                </div>
                                               
                                            </div>
                                        
                                        </form>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6 d-none">
                                <div class="card shadow mb-4">
                                    <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary"><?= $this->lang->line("New Sub Categories") ?></h6>
                                    </div>
                                    <div class="card-body">
                                    <form class="addSubCate" id="addSubCate_<?= $type->type_title?>">
                                        <div class="form-group row">
                                            <div class="col-sm-4 mb-3 mb-sm-0">
                                                <select class="form-control form-control-user" name="category_id" required>
                                                    <option value="0"><?= $this->lang->line("Select Category") ?></option>
                                                    <?php foreach($Categories as $cat_):
                                                        if ($cat_->type_id ==$type->type_id){
                                                            $cat_field_name = 'category_name_' . $category_lang;
                                                            $categorytitle = trim($cat_->$cat_field_name) == "" ? $cat_->category_name : $cat_->$cat_field_name;
                                                        ?>                              
                                                        <option value="<?=$cat_->category_id?>"><?=$categorytitle?></option>
                                                    <?php } endforeach;?>   
                                                </select>
                                                
                                            </div>
                                            <div class="col-sm-5 mb-3 mb-sm-0">
                                                <div class="input-group english-field hide-field lang-field">
                                                    <input type="text" class="form-control form-control-user" id="sub_cat_name_english" placeholder='<?= $this->lang->line("Sub Category Name") ?>' name="sub_cat_name_english" value="" >
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/en-flag.png')?>"></span>
                                                    </div>
                                                </div>
                                                <div class="input-group french-field hide-field lang-field">
                                                    <input type="text" class="form-control form-control-user" id="sub_cat_name_french" placeholder='<?= $this->lang->line("Sub Category Name") ?>' name="sub_cat_name_french" value="" >
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/fr-flag.png')?>"></span>
                                                    </div>
                                                </div>
                                                <div class="input-group germany-field hide-field lang-field">
                                                    <input type="text" class="form-control form-control-user" id="sub_cat_name_germany" placeholder='<?= $this->lang->line("Sub Category Name") ?>' name="sub_cat_name_germany" value="" >
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/ge-flag.png')?>"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-3 mb-3 mb-sm-0">
                                                <input type="submit" name="" value='<?= $this->lang->line("Add") ?>' class="btn btn-primary btn-user btn-block">
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
                            <h6 class="m-0 font-weight-bold text-primary"><?= $this->lang->line("All Categories")?></h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th class="text-center"><?= $this->lang->line("S.No")?></th>
                                            <th class="text-center">Sort Index</th>
                                            <th class="text-center"><?= $this->lang->line("Name")?></th>
                                            <th class="text-center"><?= $this->lang->line("Action")?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i=1;?>
                                        <?php foreach($Categories as $cat):
                                            if ($type->type_id == $cat->type_id){
                                                $cat_field_name = 'category_name_' . $category_lang;
                                                $categorytitle = trim($cat->$cat_field_name) == "" ? $cat->category_name : $cat->$cat_field_name;
                                                $is_disabled_item = $cat->category_status && $cat->category_status == "active" ? "" : "disable-item";
                                            ?>
                                            <tr class="<?= $is_disabled_item?>">
                                                <td class="text-center"><?=$i?></td>
                                                <td class="text-center"><?=$cat->category_sort_index?></td>
                                                <td class="text-center"><?= $categorytitle?></td>
                                                <td class="text-center">
                                                    <a href="<?=base_url('Restaurant/categoryDetails/').$cat->category_id?>" title="<?= $this->lang->line('Edit Category')?>"><i class="fas fa-eye"></i></a>
                                                    <a href="javascript:void(0)" title="<?= $this->lang->line('Remove Category')?>" class="text-danger remove_category" d-cat_id="<?=$cat->category_id?>"><i class="fas fa-trash"></i></a>
                                                    <!-- <a href="javascript:void(0)" title="<?= $this->lang->line('Deactivate')?> <?= $this->lang->line('Category')?>" class="text-warning deactivate_category" d-cat_id="<?=$cat->category_id?>"><i class="fa fa-power-off"></i></a> -->
                                                    <input type="checkbox" data-plugin="switchery" name = "is_active_category" data-color="#3DDCF7"  d-cat_id="<?=$cat->category_id?>"  class = "handle_category" <?= $cat->category_status && $cat->category_status == "active" ? "checked" : "" ?>/>
                                                </td>
                                            </tr>
                                            <?php $i++ ; }?>
                                        <?php endforeach;?>
                                    </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </section>
                <?php } ?>
            </div>
        </div>
        <!-- /.container-fluid -->

    </div>
      <!-- End of Main Content -->
