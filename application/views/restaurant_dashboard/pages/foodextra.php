
        <!-- Begin Page Content -->

        <div class="container-fluid multi-lang-page menu-lang-page" id = "all_active_foodextra" data-url = <?=base_url('/')?>>

            <!-- Page Heading -->
            <h1 class="h3 mb-2 text-gray-800"><?= $this->lang->line("Food Extras") ?></h1>
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
                                <li class="<?= $th == 1 ? 'active' : '' ?>"><a class="foodextra_cattype <?= $th == 1 ? 'active' : '' ?>" data-toggle="tab" href="#<?= $type->type_title?>"><?= $type->$type_field?></a></li>
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
                        <div class="row mx-1 flex-row-reverse my-3">
                            
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card shadow mb-4">
                                    <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary   d-flex justify-content-between">
                                        <?= $this->lang->line("Add New") ?> <?= $this->lang->line("Food Extra") ?>  <?= $this->lang->line("Category") ?>
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
                                        <form id = "addNewExtraCate_<?= $type->type_title?>" class="addNewExtraCate">
                                            <div class="form-group row">
                                                <div class="col-sm-6 mb-3 mb-sm-0">
                                                    <input type="hidden" class="form-control form-control-user" id="added_by_<?= $category_lang?>"  name="added_by" value="<?=$myRestId?>" readonly>
                                                    <input type="hidden" class="form-control form-control-user" id="type_id_<?= $category_lang?>"  name="type_id" value="<?=$type->type_id?>" readonly>
                                                    <div class="input-group english-field hide-field lang-field">
                                                        <input type="text" class="form-control form-control-user" id="cat_name_english" placeholder='<?= $this->lang->line("Category Name") ?>' name="cat_name_english" value="" >
                                                        <div class="input-group-append">
                                                            <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/en-flag.png')?>"></span>
                                                        </div>
                                                    </div>
                                                    <div class="input-group french-field hide-field lang-field">
                                                        <input type="text" class="form-control form-control-user" id="cat_name_french" placeholder='<?= $this->lang->line("Category Name") ?>' name="cat_name_french" value="" >
                                                        <div class="input-group-append">
                                                            <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/fr-flag.png')?>"></span>
                                                        </div>
                                                    </div>
                                                    <div class="input-group germany-field hide-field lang-field">
                                                        <input type="text" class="form-control form-control-user" id="cat_name_germany" placeholder='<?= $this->lang->line("Category Name") ?>' name="cat_name_germany" value="" >
                                                        <div class="input-group-append">
                                                            <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/ge-flag.png')?>"></span>
                                                        </div>
                                                    </div>
                                                    <input type="number" class="form-control form-control-user mt-2" id="category_sort_index" placeholder='Category Sort Index' name="category_sort_index" value="" min = "0" >
                                                </div>
                                                <div class="col-sm-6 mb-3 mb-sm-0">
                                                    <select class="form-control form-control-user" name="is_multi_select">
                                                        <option value="0"><?= $this->lang->line("Show as Dropdown Fields") ?></option>
                                                        <option value="1"><?= $this->lang->line("Show as Multi Select Fields") ?></option>
                                                    </select>
                                                </div>
                                                <div class="col-sm-4 my-3 mb-sm-0">
                                                    <input type="submit" name="" value='<?= $this->lang->line("Add New") ?>' class="btn btn-primary btn-user btn-block">
                                                </div>
                                               
                                            </div>
                                        
                                        </form>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <!-- new food extras -->
                                <div class="card shadow mb-4">
                                    <div class="card-header py-3">
                                        <h6 class="m-0 font-weight-bold text-primary   d-flex justify-content-between"><?= $this->lang->line("New Food Extras") ?>
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
                                    <form class="addFoodExtra" id="addFoodExtra_<?= $type->type_title?>">
                                        <div class="form-group row">
                                            <div class="col-sm-4 mb-3 mb-sm-0">
                                                <select class="form-control form-control-user category_id_for_extra" name="category_id_for_extra" required>
                                                    <option value="0"><?= $this->lang->line("Select Category") ?></option>
                                                    <?php foreach($Categories as $cat_):
                                                        if ($cat_->type_id ==$type->type_id){
                                                            $cat_field_name = 'extra_category_name_' . $category_lang;
                                                            $categorytitle = trim($cat_->$cat_field_name) == "" ? $cat_->extra_category_name : $cat_->$cat_field_name;
                                                        ?>                              
                                                        <option value="<?=$cat_->extra_category_id?>"><?=$categorytitle?></option>
                                                    <?php } endforeach;?>   
                                                </select>
                                                
                                            </div>
                                            <div class="col-sm-5 mb-3 mb-sm-0">
                                                <div class="input-group english-field hide-field lang-field">
                                                    <input type="text" class="form-control form-control-user" id="food_extra_name_english" placeholder='<?= $this->lang->line("Food Extra Name") ?>' name="food_extra_name_english" value="" >
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/en-flag.png')?>"></span>
                                                    </div>
                                                </div>
                                                <div class="input-group french-field hide-field lang-field">
                                                    <input type="text" class="form-control form-control-user" id="food_extra_name_french" placeholder='<?= $this->lang->line("Food Extra Name") ?>' name="food_extra_name_french" value="" >
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/fr-flag.png')?>"></span>
                                                    </div>
                                                </div>
                                                <div class="input-group germany-field hide-field lang-field">
                                                    <input type="text" class="form-control form-control-user" id="food_extra_name_germany" placeholder='<?= $this->lang->line("Food Extra Name") ?>' name="food_extra_name_germany" value="" >
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
                                    <table class="table" id="dataTable" width="100%" cellspacing="0">
                                    <!-- <thead>
                                        <tr>
                                            <th class="text-center"><?= $this->lang->line("S.No")?></th>
                                            <th class="text-center">Sort Index</th>
                                            <th class="text-center"><?= $this->lang->line("Name")?></th>
                                            <th class="text-center"><?= $this->lang->line("Action")?></th>
                                        </tr>
                                    </thead> -->
                                    <tbody>
                                        <?php $i=1;?>
                                        <?php foreach($Categories as $cat):
                                            if ($type->type_id == $cat->type_id){
                                                $cat_field_name = 'extra_category_name_' . $category_lang;
                                                $categorytitle = trim($cat->$cat_field_name) == "" ? $cat->extra_category_name : $cat->$cat_field_name;
                                                $is_disabled_item = $cat->extra_category_status && $cat->extra_category_status == "active" ? "" : "disable-item";
                                            ?>
                                                <tr class="j-bg-light-gray j-text-black <?= $is_disabled_item ?>">
                                                    <!-- <td class="text-center"><?=$i?></td> -->
                                                    <td class="text-center"><?=$cat->extra_category_sort_index?></td>
                                                    <td class=""><?= $categorytitle?></td>
                                                    <td class="text-center">
                                                        <a class="btn btn-primary" href="<?=base_url('Restaurant/ExtraCategoryDetails/').$cat->extra_category_id?>" title="<?= $this->lang->line('Edit Category')?>"><i class="fas fa-eye"></i></a>
                                                        <a href="javascript:void(0)" title="<?= $this->lang->line('Remove Category')?>" class=" btn btn-danger  remove_extra_category" d-cat_id="<?=$cat->extra_category_id?>"><i class="fas fa-trash"></i></a>
                                                        <!-- <a href="javascript:void(0)" title="<?= $this->lang->line('Deactivate')?> <?= $this->lang->line('Category')?>" class="btn btn-warning deactivate_extra_category" d-cat_id="<?=$cat->extra_category_id?>"><i class="fa fa-power-off"></i></a> -->
                                                        <input type="checkbox" data-plugin="switchery" name = "is_active_extra_category" data-color="#3DDCF7"  d-cat_id="<?=$cat->extra_category_id?>"  class = "handle_extra_category" <?= $cat->extra_category_status && $cat->extra_category_status == "active" ? "checked" : "" ?>/>
                                                    </td>
                                                </tr>
                                                
                                                <?php 
                                                    $extra_food_of_cat = $this->db->query("select * from tbl_food_extra where category_id = ".$cat->extra_category_id)->result();
                                                    if (sizeof($extra_food_of_cat) > 0){
                                                        $ext_field_name = 'food_extra_name_' . $category_lang;

                                                        foreach ($extra_food_of_cat as $efckey => $efcvalue) { ?>
                                                            <tr class="j-bg-lighter-gray j-text-black <?= $is_disabled_item ?>">
                                                                <td></td>
                                                                <td colspan="2" class="text-left">
                                                                    <?= $efcvalue->$ext_field_name == "" ? $efcvalue->food_extra_name : $efcvalue->$ext_field_name ?>
                                                                </td>
                                                            </tr>
                                                        <?php }
                                                    }
                                                    $i++ ; 
                                                }
                                            ?>
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
    <script>
        // $(document).ready(function(){
        //     var rest_id="<?=$myRestId?>";
        //     lang = "<?= $this->session->userdata('site_lang_admin')?>";
        //     console.log(lang);
        //     $("."+lang+"-field").removeClass("hide-field");
        // });
        // $(document).on('click','.lang-bar .item-flag',function(){
        //     $(".lang-bar .item-flag").removeClass("active");
        //     lang = $(this).attr("data-flag");
        //     $(".lang-bar .item-flag[data-flag='"+lang+"']").addClass("active");
        //     $("."+"english"+"-field").addClass("hide-field");
        //     $("."+"germany"+"-field").addClass("hide-field");
        //     $("."+"french"+"-field").addClass("hide-field");
        //     $("."+lang+"-field").removeClass("hide-field");
        // });
    </script>
      <!-- End of Main Content -->
