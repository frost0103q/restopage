
        <!-- Begin Page Content -->

        <div class="container-fluid" id = "all_active_category" data-url = <?=base_url('/')?>>

            <!-- Page Heading -->
            <h1 class="h3 mb-2 text-gray-800"><?= $this->lang->line("Categories") ?></h1>
            <div class="row mt-3">
                <div class="col-md-6">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary"><?= $this->lang->line("Restaurant") ?></h6>
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <div class="col-sm-8 mb-3 mb-sm-0">
                                    <select class="form-control form-control-user restaurant_id" name="restaurant_id">
                                        <option value="0" <?= $rest_id == "0" ? "selected" : "" ?>> <?= $this->lang->line("Select Restaurant") ?></option>
                                        <?php
                                            foreach ($Rests as $key => $value) {
                                            ?>
                                                <option value="<?= $value->restaurant_id?>" <?= $rest_id == $value->restaurant_id ? "selected" : "" ?> ><?= $value->rest_name ?> </option>
                                            <?php
                                            }
                                        ?>
                                    </select>
                                    
                                </div>
                                <div class="col-sm-4 mb-3 mb-sm-0">
                                    <input type="submit" name="" value='<?= $this->lang->line("Select") ?>' class="btn btn-primary btn-user btn-block">
                                </div>
                            
                            </div>
                        
                        </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- modify by Jfrost -->
            <section class="my-5 tab-panel-j">
                <div class="row language-panel">
                    <div class="d-flex align-items-center mx-auto">
                        <ul class="nav nav-tabs">
                            <li class="active"><a class="<?= $category_lang == 'english' ? 'active' : ''  ?>" href="<?=base_url('Restaurant/Category/english')?>"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/en-flag.png')?>"></a></li>
                            <li><a class = "<?= $category_lang == 'french' ? 'active' : ''  ?>" href="<?=base_url('Restaurant/Category/french')?>" ><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/fr-flag.png')?>"></a></li>
                            <li><a class = "<?= $category_lang == 'germany' ? 'active' : ''  ?>" href="<?=base_url('Restaurant/Category/germany')?>"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/ge-flag.png')?>"></a></li>
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
                                <li class="<?= $th == 1 ? 'active' : '' ?>"><a class="<?= $th == 1 ? 'active' : '' ?>" data-toggle="tab" href="#<?= $type->type_title?>"><?= $type->$type_field?></a></li>
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
                            <div class="lang-bar">
                                <span class="<?= $category_lang == 'english' ? 'active' : ''  ?> item-flag" data-flag="english"><img class="english-flag" src="<?= base_url('assets/flags/en-flag.png')?>"></span>
                                <span class="<?= $category_lang == 'french' ? 'active' : ''  ?> item-flag" data-flag="french"><img class="french-flag" src="<?= base_url('assets/flags/fr-flag.png')?>"></span>
                                <span class="<?= $category_lang == 'germany' ? 'active' : ''  ?> item-flag" data-flag="germany"><img class="germany-flag" src="<?= base_url('assets/flags/ge-flag.png')?>"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card shadow mb-4">
                                    <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary"><?= $this->lang->line("New Categories") ?></h6>
                                    </div>
                                    <div class="card-body">
                                        <form id = "addNewCate_<?= $type->type_title?>" class="addNewCate">
                                            <input type="hidden" name="restaurant_id" value="<?=$rest_id?>" >
                                            <div class="form-group row">
                                                <div class="col-md-12 mb-2">
                                                    <input type="file" class="dropify" name="category_image" />
                                                </div>
                                                <div class="col-sm-8 mb-3 mb-sm-0">
                                                    <input type="hidden" class="form-control form-control-user" id="type_id_<?= $category_lang?>"  name="type_id" value="<?=$type->type_id?>" readonly>
                                                    <div class="input-group english-field hide-field">
                                                        <input type="text" class="form-control form-control-user" id="cat_name_english" placeholder='<?= $this->lang->line("Category Name") ?>' name="cat_name_english" value="" >
                                                        <div class="input-group-append">
                                                            <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/en-flag.png')?>"></span>
                                                        </div>
                                                    </div>
                                                    <div class="input-group french-field hide-field">
                                                        <input type="text" class="form-control form-control-user" id="cat_name_french" placeholder='<?= $this->lang->line("Category Name") ?>' name="cat_name_french" value="" >
                                                        <div class="input-group-append">
                                                            <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/fr-flag.png')?>"></span>
                                                        </div>
                                                    </div>
                                                    <div class="input-group germany-field hide-field">
                                                        <input type="text" class="form-control form-control-user" id="cat_name_germany" placeholder='<?= $this->lang->line("Category Name") ?>' name="cat_name_germany" value="" >
                                                        <div class="input-group-append">
                                                            <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/ge-flag.png')?>"></span>
                                                        </div>
                                                    </div>
                                                    <input type="number" class="form-control form-control-user mt-2" id="category_sort_index" placeholder='Category Sort Index' name="category_sort_index" value="" min = "0" >
                                                        
                                                </div>
                                                <div class="col-sm-4 mb-3 mb-sm-0">
                                                    <input type="submit" name="" value='<?= $this->lang->line("Add New Category") ?>' class="btn btn-primary btn-user btn-block">
                                                </div>
                                            
                                            </div>
                                        
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card shadow mb-4">
                                    <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary"><?= $this->lang->line("New Sub Categories") ?></h6>
                                    </div>
                                    <div class="card-body">
                                    <form class="addSubCate" id="addSubCate_<?= $type->type_title?>">
                                        <input type="hidden" name="restaurant_id" value="<?=$rest_id?>" >
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
                                            <div class="input-group english-field hide-field">
                                                <input type="text" class="form-control form-control-user" id="sub_cat_name_english" placeholder='<?= $this->lang->line("Sub Category Name") ?>' name="sub_cat_name_english" value="" >
                                                <div class="input-group-append">
                                                    <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/en-flag.png')?>"></span>
                                                </div>
                                            </div>
                                            <div class="input-group french-field hide-field">
                                                <input type="text" class="form-control form-control-user" id="sub_cat_name_french" placeholder='<?= $this->lang->line("Sub Category Name") ?>' name="sub_cat_name_french" value="" >
                                                <div class="input-group-append">
                                                    <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/fr-flag.png')?>"></span>
                                                </div>
                                            </div>
                                            <div class="input-group germany-field hide-field">
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
                                <!-- new food extras -->
                                <div class="card shadow mb-4">
                                    <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary"><?= $this->lang->line("New Food Extras") ?></h6>
                                    </div>
                                    <div class="card-body">
                                    <form class="addFoodExtra" id="addFoodExtra_<?= $type->type_title?>">
                                        <div class="form-group row">
                                        <div class="col-sm-4 mb-3 mb-sm-0">
                                            <select class="form-control form-control-user" name="category_id_for_extra" required>
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
                                            <div class="input-group english-field hide-field">
                                                <input type="text" class="form-control form-control-user" id="food_extra_name_english" placeholder='<?= $this->lang->line("Food Extra Name") ?>' name="food_extra_name_english" value="" >
                                                <div class="input-group-append">
                                                    <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/en-flag.png')?>"></span>
                                                </div>
                                            </div>
                                            <div class="input-group french-field hide-field">
                                                <input type="text" class="form-control form-control-user" id="food_extra_name_french" placeholder='<?= $this->lang->line("Food Extra Name") ?>' name="food_extra_name_french" value="" >
                                                <div class="input-group-append">
                                                    <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/fr-flag.png')?>"></span>
                                                </div>
                                            </div>
                                            <div class="input-group germany-field hide-field">
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
                                            ?>
                                            <tr>
                                                <td class="text-center"><?=$i?></td>
                                                <td class="text-center"><?= $cat->category_sort_index?></td>
                                                <td class="text-center"><?= $categorytitle?></td>
                                                <td class="text-center">
                                                    <a href="<?=base_url('Admin/categoryDetails/').$cat->category_id?>" title="<?= $this->lang->line('Edit Category')?>"><i class="fas fa-eye"></i></a>
                                                    <a href="javascript:void(0)" title="<?= $this->lang->line('Remove Category')?>" class="text-danger remove_category" d-cat_id="<?=$cat->category_id?>"><i class="fas fa-trash"></i></a>
                                                    <a href="javascript:void(0)" title="<?= $this->lang->line('Deactivate')?> <?= $this->lang->line('Category')?>" class="text-warning deactivate_category" d-cat_id="<?=$cat->category_id?>"><i class="fa fa-power-off"></i></a>
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
    <script>
        $(document).ready(function(){
            lang = "<?= $this->session->userdata('site_lang_admin')?>";
            console.log(lang);
            $("."+lang+"-field").removeClass("hide-field");
        });
        $(document).on('click','.lang-bar .item-flag',function(){
            $(".lang-bar .item-flag").removeClass("active");
            lang = $(this).attr("data-flag");
            $(".lang-bar .item-flag[data-flag='"+lang+"']").addClass("active");
            $("."+"english"+"-field").addClass("hide-field");
            $("."+"germany"+"-field").addClass("hide-field");
            $("."+"french"+"-field").addClass("hide-field");
            $("."+lang+"-field").removeClass("hide-field");
        });
        $(document).on('change','.restaurant_id',function(){
            rest_id = $(this).val();
            url ="<?= base_url('Admin/Category/')?>";
            if (rest_id > 0){
                location.replace(url + rest_id);
            }else{
                location.replace(url);
            }
        });
    </script>
      <!-- End of Main Content -->
