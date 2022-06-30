<script>
    $(document).on('keyup','.checkit',function(){
        var el = $(this);
        var value = el.val();
        if(value.includes(',')){
            alert('<?= $this->lang->line('comma not allowed, please use point')?>');
            el.val('');
        }
    })
</script>
        <!-- Begin Page Content -->
        <div class="container-fluid createMenu-page" id = "all_menu_item" data-url ="<?= base_url('/')?>">

            <!-- Page Heading -->
            <h1 class="h3 mb-2 text-gray-800"><?= $this->lang->line("Add Menu Item")?></h1>
            <div class="row">

                <div class="col-md-12 ">
                    <?php
                    if($this->session->flashdata('msg')){
                        echo '<div class="alert alert-danger">'.$this->session->flashdata('msg').'</div>';
                    }
                    ?>
                    <!-- modify by Jfrost -->
                    <section class="my-5 tab-panel-j">
                        <div class="row language-panel">
                            <div class="d-flex align-items-center mx-auto">
                                <ul class="nav nav-tabs">
                                    <li class="active"><a class="<?= $category_lang == 'english' ? 'active' : ''  ?>" href="<?=base_url('Restaurant/Menu/english')?>" data-lang="english"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/en-flag.png')?>"></a></li>
                                    <li><a class = "<?= $category_lang == 'french' ? 'active' : ''  ?>" href="<?=base_url('Restaurant/Menu/french')?>" data-lang="french"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/fr-flag.png')?>"></a></li>
                                    <li><a class = "<?= $category_lang == 'germany' ? 'active' : ''  ?>" href="<?=base_url('Restaurant/Menu/germany')?>" data-lang="germany"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/ge-flag.png')?>"></a></li>
                                </ul>
                            </div>
                        </div>    
                        <div class="row type-panel mt-2">
                            <div class="d-flex align-items-center mx-auto">
                                <ul class="nav nav-tabs">
                                    <?php 
                                    $th = 0;
                                    $types = $this->db->get('tbl_category_type')->result();
                                    $type_field = 'type_title_'.$category_lang;
                                    foreach ($types as $key => $type) { 
                                        $th++;
                                        ?>
                                        <li class="<?= $th == 1 ? 'active' : '' ?>"><a class="<?= $th == 1 ? 'active' : '' ?>" data-toggle="tab" href="#<?= $type->type_title?>" data-type = "<?= $type->type_title?>"><?= $type->$type_field?></a></li>
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
                                <div class="card shadow mb-4">
                                    <div class="card-header py-3 d-flex justify-content-between title-bar">
                                        <h6 class="m-0 font-weight-bold text-primary">
                                            <?= $this->lang->line('Add Item')?>
                                        </h6>
                                        <div class="lang-bar">
                                            <span class="<?= $category_lang == 'english' ? 'active' : ''  ?> item-flag" data-flag="english"><img class="english-flag" src="<?= base_url('assets/flags/en-flag.png')?>"></span>
                                            <span class="<?= $category_lang == 'french' ? 'active' : ''  ?> item-flag" data-flag="french"><img class="french-flag" src="<?= base_url('assets/flags/fr-flag.png')?>"></span>
                                            <span class="<?= $category_lang == 'germany' ? 'active' : ''  ?> item-flag" data-flag="germany"><img class="germany-flag" src="<?= base_url('assets/flags/ge-flag.png')?>"></span>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <form action="<?=base_url('Admin/addMenuItem') . '/'.$type->type_title?>" method="post" enctype="multipart/form-data">
                                            <input type="hidden" name="item_type_title" value="<?= $type->type_title?>">
                                            <div class="form-group row">
                                                <div class="col-sm-4 mb-3 mb-sm-0">
                                                    <select class="form-control" name="rest_id" required id= "rest_id">
                                                        <option value="<?=$myRestId?>" <?= 0 == $myRestId ? "selected": "" ?> ><?=$this->lang->line("Select Restaurant")?></option>
                                                        <?php foreach($addRest as $rest): ?>
                                                            <option value="<?=$rest->rest_id?>" <?= $rest->rest_id == $myRestId ? "selected": "" ?> ><?=$rest->rest_name?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                                <div class="col-sm-4 mb-3 mb-sm-0">
                                                    <select class="form-control category_id hide-field require_field" name="category_id"  data-type = "<?=$type->type_id?>" required>
                                                        <option value="0"><?= $this->lang->line('Select Category')?></option>
                                                        <?php
                                                            $category_name_field = "category_name" .""; 
                                                            foreach($Categories as $cat): 
                                                            if ($cat->type_id ==$type->type_id){ ?>
                                                            <option value="<?=$cat->category_id?>"><?=$cat->$category_name_field?></option>
                                                        <?php } endforeach; ?>
                                                    </select>
                                                    <select class="form-control category_id english-field hide-field" name="category_id_english"  data-type = "<?=$type->type_id?>" required>
                                                        <option value="0"><?= $this->lang->line('Select Category')?></option>
                                                        <?php
                                                            $category_name_field = "category_name_" ."english"; 
                                                            foreach($Categories as $cat): 
                                                            if ($cat->type_id ==$type->type_id){ ?>
                                                            <option value="<?=$cat->category_id?>"><?=$cat->$category_name_field?></option>
                                                        <?php } endforeach; ?>
                                                    </select>
                                                    <select class="form-control category_id french-field hide-field" name="category_id_french"  data-type = "<?=$type->type_id?>" required>
                                                        <option value="0"><?= $this->lang->line('Select Category')?></option>
                                                        <?php
                                                            $category_name_field = "category_name_" ."french"; 
                                                            foreach($Categories as $cat): 
                                                            if ($cat->type_id ==$type->type_id){ ?>
                                                            <option value="<?=$cat->category_id?>"><?=$cat->$category_name_field?></option>
                                                        <?php } endforeach; ?>
                                                    </select>
                                                    <select class="form-control category_id germany-field hide-field" name="category_id_germany"  data-type = "<?=$type->type_id?>" required>
                                                        <option value="0"><?= $this->lang->line('Select Category')?></option>
                                                        <?php
                                                            $category_name_field = "category_name_" ."germany"; 
                                                            foreach($Categories as $cat): 
                                                            if ($cat->type_id ==$type->type_id){ ?>
                                                            <option value="<?=$cat->category_id?>"><?=$cat->$category_name_field?></option>
                                                        <?php } endforeach; ?>
                                                    </select>
                                                </div>
                                                <div class="col-sm-4 mb-3 mb-sm-0 hide-field">
                                                    <select class="form-control sub_category_id chosen-select-width" id="sub_category_id" name="sub_category_id[]"  data-type = "<?=$type->type_id?>" multiple disabled>
                                                    </select>
                                                </div>
                                                <div class="col-sm-4 mb-3 mb-sm-0 hide-field english-field">
                                                    <select class="form-control sub_category_id chosen-select-width" id="sub_category_id_english" name="sub_category_id_english[]" data-type = "<?=$type->type_id?>" multiple  disabled>
                                                    </select>
                                                </div>
                                                <div class="col-sm-4 mb-3 mb-sm-0 hide-field french-field">
                                                    <select class="form-control sub_category_id chosen-select-width" id="sub_category_id_french" name="sub_category_id_french[]" data-type = "<?=$type->type_id?>" multiple  disabled>
                                                    </select>
                                                </div>
                                                <div class="col-sm-4 mb-3 mb-sm-0 hide-field germany-field">
                                                    <select class="form-control sub_category_id chosen-select-width" id="sub_category_id_germany" name="sub_category_id_germany[]" data-type = "<?=$type->type_id?>" multiple  disabled>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-sm-6 col-md-4 mb-3 mb-sm-0">
                                                    <div class="input-group english-field hide-field">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/en-flag.png')?>" ></span>
                                                        </div>
                                                        <input type="text" name="item_name_<?=$type->type_title?>_english" class=" require_field form-control" placeholder="<?= $this->lang->line('Item Name')?>">
                                                    </div>
                                                    <div class="input-group french-field hide-field">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/fr-flag.png')?>" ></span>
                                                        </div>
                                                        <input type="text" name="item_name_<?=$type->type_title?>_french" class="require_field form-control" placeholder="<?= $this->lang->line('Item Name')?>">
                                                    </div>
                                                    <div class="input-group germany-field hide-field">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/ge-flag.png')?>" ></span>
                                                        </div>
                                                        <input type="text" name="item_name_<?=$type->type_title?>_germany" class="require_field form-control" placeholder="<?= $this->lang->line('Item Name')?>">
                                                    </div>
                                                    <div class="input-group mt-4">
                                                        <input type="number" name="item_sort_index" class="form-control" placeholder="Item Sort Index"  min = "0"></td>
                                                    </div>
                                                    <div class="input-group mt-4">
                                                    <?php 
                                                    
                                                        if (isset($restDetails)){
                                                            if ($restDetails->dp_option == 1 || $restDetails->dp_option == 3 ){
                                                                echo '
                                                                <div class="col-md-6 align-items-center d-flex">
                                                                    <input type="checkbox" name="item_show_in_delivery" id ="item_show_in_delivery" class="item_show_in" style="width: 20px; height: 20px; margin-right: 10px;"> 
                                                                    <label for= "item_show_in_delivery" class="mb-0"> Delivery </label>
                                                                </div>';
                                                            }
                                                            if ($restDetails->dp_option == 2 || $restDetails->dp_option == 3 ){
                                                                echo '
                                                                <div class="col-md-6 align-items-center d-flex">
                                                                    <input type="checkbox" name="item_show_in_pickup" id ="item_show_in_pickup" class="item_show_in" style="width: 20px; height: 20px; margin-right: 10px;"> 
                                                                    <label for= "item_show_in_pickup" class="mb-0"> Pickup </label>
                                                                </div>
                                                                ';
                                                            }
                                                        }
                                                    ?>
                                                        <!-- <div class="col-md-6 align-items-center d-flex">
                                                            <input type="checkbox" name="item_show_in_delivery" id ="item_show_in_delivery" class="item_show_in" style="width: 20px; height: 20px; margin-right: 10px;"> 
                                                            <label for= "item_show_in_delivery" class="mb-0"> Delivery </label>
                                                        </div>
                                                        <div class="col-md-6 align-items-center d-flex">
                                                            <input type="checkbox" name="item_show_in_pickup" id ="item_show_in_pickup" class="item_show_in" style="width: 20px; height: 20px; margin-right: 10px;"> 
                                                            <label for= "item_show_in_pickup" class="mb-0"> Pickup </label>
                                                        </div> -->
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-md-8 mb-3 mb-sm-0">
                                                    <input type="file" class="dropify" name="item_image" />
                                                </div>
                                            </div>
                                            <div  class="form-group">
                                                <table class="w-100">
                                                    <tbody class="<?= $type->type_title?>_price-table" data-type = "<?= $type->type_title?>">
                                                        <tr class="price-row" data-id = "1">
                                                            <td class="item_price_title input-group english-field hide-field">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/en-flag.png')?>"></span>
                                                                </div>
                                                                <input type="text" name="item_price_title_<?= $type->type_title?>_english[1]" class="form-control" placeholder="<?= $this->lang->line('Price Title')?>" data-id = "1" >
                                                            </td>
                                                            <td class="item_price_title input-group french-field hide-field">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/fr-flag.png')?>"></span>
                                                                </div>
                                                                <input type="text" name="item_price_title_<?= $type->type_title?>_french[1]" class="form-control" placeholder="<?= $this->lang->line('Price Title')?>" data-id = "1" >
                                                            </td>
                                                            <td class="item_price_title input-group germany-field hide-field">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/ge-flag.png')?>"></span>
                                                                </div>
                                                                <input type="text" name="item_price_title_<?= $type->type_title?>_germany[1]" class="form-control" placeholder="<?= $this->lang->line('Price Title')?>" data-id = "1" >
                                                            </td>
                                                            <td class="pl-3 item_price"><input type="number" name="item_price_<?= $type->type_title?>[1]" class="require_field form-control" placeholder="<?= $this->lang->line('Price')?>" data-id = "1" min = "0" step = "0.01"></td>
                                                            <td class="text-danger text-center pl-1 add-food-extra d-none d-sm-table-cell" data-price-placeholder = "<?= $this->lang->line('Extra Price')?>" ><span class="btn btn-success"><?= $this->lang->line('Add Food Extra')?></span></td>
                                                            <td class="text-danger text-center pl-1 del-price-row d-none d-sm-table-cell" ><i class="fa fa-times-circle"></i></td>
                                                            <td class="text-success text-center pl-1 add-price-row d-none d-sm-table-cell"><i class="fa fa-plus"></i></td>
                                                            <td class="text-info text-center pl-1 d-table-cell d-sm-none">
                                                                <div class="nav-item dropdown no-arrow show">
                                                                    <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                        <i class="fa fa-bars"></i>
                                                                    </a>
                                                                    <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown3" data-id = "1">
                                                                        <span class="add-food-extra dropdown-item" data-price-placeholder = <?= $this->lang->line('Extra Price')?> ><?= $this->lang->line('Add Food Extra')?></span>
                                                                        <span class="del-price-row dropdown-item"><?= $this->lang->line('Remove Price')?></span>
                                                                        <span class="add-price-row dropdown-item"><?= $this->lang->line('Add Price')?></span>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-4">
                                                <!-- <input type="text" name="item_allergens" placeholder="Item Allergens" class="form-control"> -->
                                                <div class="mb-3 mb-sm-0 hide-field">
                                                    <select class="form-control item_allergen_id chosen-select-width-allergens" id="item_allergens" name="item_allergens[]"  multiple >
                                                            <?php
                                                                foreach ($allergens as $key => $allergen) {
                                                                    echo '<option value = "'. $allergen->allergen_id.'">'.$allergen->allergen_name.'</option>';
                                                                }
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <div class="hide-field english-field h-100">
                                                        <select class="form-control item_allergen_id chosen-select-width-allergens" id="item_allergens_english" name="item_allergens_english[]" multiple  >
                                                            <?php
                                                                foreach ($allergens as $key => $allergen) {
                                                                    echo '<option value = "'. $allergen->allergen_id.'">'.$allergen->allergen_name_english.'</option>';
                                                                }
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <div class="hide-field french-field h-100">
                                                        <select class="form-control item_allergen_id chosen-select-width-allergens" id="item_allergens_french" name="item_allergens_french[]" multiple  >
                                                            <?php
                                                                foreach ($allergens as $key => $allergen) {
                                                                    echo '<option value = "'. $allergen->allergen_id.'">'.$allergen->allergen_name_french.'</option>';
                                                                }
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <div class="hide-field germany-field h-100">
                                                        <select class="form-control item_allergen_id chosen-select-width-allergens" id="item_allergens_germany" name="item_allergens_germany[]" multiple  >
                                                            <?php
                                                                foreach ($allergens as $key => $allergen) {
                                                                    echo '<option value = "'. $allergen->allergen_id.'">'.$allergen->allergen_name_germany.'</option>';
                                                                }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <select class="form-control" name="item_type">
                                                        <option value="3">Non Veg</option>
                                                        <option value="1"><?= $this->lang->line('Vegetarian')?></option>
                                                        <option value="2"><?= $this->lang->line('Vegan')?></option>
                                                    </select>
                                                
                                                </div>
                                                <div class="col-md-4 d-flex align-items-center justify-content-around" >
                                                    <label for ="item_show_blue" class="mb-0"><?= $this->lang->line("Show Blue Bar")?></label>
                                                    <input type="checkbox" name="item_show_blue" id="item_show_blue" checked style="width: 20px; height: 20px">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-12">
                                                    <div class="input-group english-field hide-field">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/en-flag.png')?>" ></span>
                                                        </div>
                                                        <textarea class="form-control summernote" name="item_desc_english" placeholder ="<?= $this->lang->line('Item Description')?>"></textarea>
                                                    </div>
                                                    <div class="input-group french-field hide-field">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text summernote"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/fr-flag.png')?>" ></span>
                                                        </div>
                                                        <textarea class="form-control" name="item_desc_french" placeholder ="<?= $this->lang->line('Item Description')?>"></textarea>
                                                    </div>
                                                    <div class="input-group germany-field hide-field">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text summernote"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/ge-flag.png')?>"></span>
                                                        </div>
                                                        <textarea class="form-control" name="item_desc_germany" placeholder ="<?= $this->lang->line('Item Description')?>"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-sm-4 mx-auto mb-3 mb-sm-0">
                                                <input type="submit" name="" value="<?= $this->lang->line('Add Item To Menu')?>" class="btn btn-danger btn-user btn-block" id="adNewIte<?= $type->type_title?>" disabled>
                                                </div>
                                                
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </section>
                        <?php } ?>
                    </div>
                </div>
            
            </div>
            
            
            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between title-bar">
                    <h6 class="m-0 font-weight-bold text-primary"><?= $this->lang->line('Our Menu')?></h6>
                    <div class="cattype-bar d-flex align-items-center">
                        <span class="d-flex align-items-center sort-direct-icon mr-4" data-sort-direction = "down" onclick = "sortTable(this)"><i class="fas fa-sort-alpha-down" aria-hidden="true"></i></span>
                        <select class="form-control cattype-id">
                            <?php 
                            $th = 0;
                            $types = $this->db->get('tbl_category_type')->result();
                            foreach ($types as $key => $type) { 
                                $th++;
                                $type_field = 'type_title_'.$category_lang;
                                ?>
                                <option value="<?= $type->type_id?>" <?= $th == 1 ? 'selected' : '' ?>><?=$type->$type_field?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                    <table class="table item-menu-table" id="item-menu-table" width="100%" >
                        <tbody id="menuList" data-base-url = "<?= base_url("/")?>"  data-rest-id = "<?=$myRestId?>">
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>

        </div>
        <!-- /.container-fluid -->
        </div>
        <!-- End of Main Content -->
<script type="text/javascript">
    $(document).on('change','.createMenu-page .category_id',function(){
        var category_id= $(this).val();
        lang = $('.createMenu-page .language-panel').find('a.active').attr("data-lang");
        $(".createMenu-page .category_id").val(category_id);
        // var sub_category = $(".createMenu-page #sub_category_id_"+lang);
        var sub_category = $(".createMenu-page .sub_category_id");
        var type_id = sub_category.attr("data-type");
        type = $('.createMenu-page .type-panel').find('a.active').attr("data-type");
        $.ajax({
            url:"<?=base_url('API/getAllSubCategory')?>",
            type:"post",
            data:{category_id:category_id,lang:lang},
            success:function(response){
                response=JSON.parse(response);
                // if(response.data.length>0){
                    sub_category.empty();
                    var subCat = '';
                    sub_category.append(subCat);
                    for(let i=0; i<response.data.length; i++){
                            subCat = '<option value="' + response.data[i].sub_cat_id + '">'+response.data[i].sub_category_name_french+'</option>';
                            $(".createMenu-page #sub_category_id_french").append(subCat);
                            subCat = '<option value="' + response.data[i].sub_cat_id + '">'+response.data[i].sub_category_name_germany+'</option>';
                            $(".createMenu-page #sub_category_id_germany").append(subCat);
                            subCat = '<option value="' + response.data[i].sub_cat_id + '">'+response.data[i].sub_category_name_english+'</option>';
                            $(".createMenu-page #sub_category_id_english").append(subCat);
                            subCat = '<option value="' + response.data[i].sub_cat_id + '">'+response.data[i].sub_category_name_english+'</option>';
                            $(".createMenu-page #sub_category_id").append(subCat);
                    }
                    if (response.data.length > 0){
                        sub_category.attr('disabled',false);
                        $("#adNewIte" + type).attr("disabled",false);
                    }else{
                        sub_category.attr('disabled',true);
                        $("#adNewIte" + type).attr("disabled",true);
                    }
                    sub_category.trigger("chosen:updated");
                // }   
            }
        });
    });
    $(document).on('change','.createMenu-page .cattype-bar .cattype-id',function(){
        cattype = $(this).val();
        $("tr.our-menu-td").addClass("hide-field");
        $("tr[data-cattype='"+cattype+"']").removeClass("hide-field");
    });
    // $(document).on('chaloa=nge','#rest_id_',function(){
    // });
    $(document).on('change','#rest_id',function(){    
        url = "<?= base_url("Admin/Menu/")?>";
        rest_id = $(this).val();
        console.log(rest_id);
        location.replace(url + rest_id);
    });
    $(document).ready(function(){
        var rest_id="<?= $myRestId?>";
        lang = $('.createMenu-page .language-panel').find('a.active').attr("data-lang");
        
        $('.summernote').summernote();
        $("."+lang+"-field").removeClass("hide-field");

        $.ajax({
            url:"<?=base_url('API/getAllMenuItem')?>",
            type:"post",
            data:{rest_id:rest_id,lang:lang},
            success:function(response){
                
                response=JSON.parse(response);
                if(response.data.length>0){
                    $('#menuList').empty();
                    for(let i=0; i<response.data.length; i++){
                        var base_url="<?=base_url('Admin/editMenu/')?>";
                        is_hide_field =(response.data[i].cattype == 1) ? '' : 'hide-field';
                        var categor='<tr data-cattype = "' + response.data[i].cattype + '" class="'+is_hide_field+' our-menu-td">'+
                                        '<td colspan="6" class="text-center bg-danger  text-white" style="border-radius:25px 25px">'+response.data[i].cate_name+
                                        '</td>'+
                                    '</tr>';
                        $('#menuList').append(categor);
                        
                        var ItmesArray=response.data[i].items;
                        for(m=0; m<ItmesArray.length; m++){
                            
                            menu_row = '<tr data-cattype = "' + response.data[i].cattype + '" class="'+is_hide_field+' our-menu-td">';
                            if(lang == "french"){
                                item_name = ItmesArray[m].item_detail.item_name_french;
                            }else if(lang == "germany"){
                                item_name = ItmesArray[m].item_detail.item_name_germany;
                            }else{
                                item_name = ItmesArray[m].item_detail.item_name_english;
                            }
                            
                            menu_row += '<td class="align-middle text-center">'+ItmesArray[m].item_detail.item_sort_index+'</td>';
                            menu_row += '<td class="align-middle text-center item-name">'+item_name+'</td>';
                            menu_row += '<td class="align-middle text-center"><img class="corner-rounded-img menu-card-item-img" width="100" height = "100" src="<?= base_url('assets/menu_item_images/')?>'+ItmesArray[m].item_detail.item_image +'"></td>';
                            
                            var subCategories=ItmesArray[m].sub_Cat;
                            var sub_cat_td ='<td class="text-center align-middle">';
                            for(let j=0; j<subCategories.length; j++){
                                sub_cat_td +='<span class="mr-4"><strong>'+subCategories[j]+'</strong></span>';
                            }
                            sub_cat_td += "</td>";

                            menu_row += sub_cat_td;
                            var item_price_row = "<td class='align-middle'>";
                            item_price_list  = ItmesArray[m].item_price;
                            item_price_title_list = ItmesArray[m].itemPriceTitle;
                            for (let index = 0; index < item_price_list.length; index++) {
                                const element = item_price_list[index];
                                item_price_row += "<p class='d-flex justify-content-around'><span class='text-center text-primary' style='max-width: 150px'>"+item_price_title_list[index]+"</span><span class=' text-danger text-danger'><strong> &#8364; "+item_price_list[index]+"</strong></span></p>";
                            }
                            item_price_row += "</td>";
                            menu_row += item_price_row;
                            var items=ItmesArray[m];
                            menu_row += '<td class="text-center align-middle">';
                            menu_row += '<a href="'+base_url+ItmesArray[m].item_detail.menu_id+'" class="btn btn-success"><i class="fas fa-eye"></i></a> ';
                            menu_row += '<a href="javascript:void(0)" class="btn btn-danger deleteMenu ml-1" d-item-id="'+ItmesArray[m].item_detail.menu_id+'"><i class="fas fa-trash"></i></a>';
                            menu_row += '<a href="javascript:void(0)" class="btn btn-warning deactivateMenu ml-1" d-item-id="'+ItmesArray[m].item_detail.menu_id+'"><i class="fa fa-power-off"></i></a>';
                            menu_row += '</td>';
                            menu_row += '</tr>';
                            // --------------------------------------------------
                            
                            $('#menuList').append(menu_row);
                            
                        }
                    }
                }
            }
        });
    });
    $(document).on('click','.deleteMenu',function(){
        var menuId=$(this).attr('d-item-id');
        var element=$(this);
        $.ajax({
            url:"<?=base_url('API/removeMenuItem')?>",
            type:"post",
            data:{menuId:menuId},
            success:function(response){
                
                response=JSON.parse(response);
                if(response.status==1){
                swal("<?= $this->lang->line('Great..')?>","<?= $this->lang->line('Deleted Successfully.')?>","<?= $this->lang->line('success')?>");
                element.parent().parent().remove();
                }else{
                swal("<?= $this->lang->line('Ooops..')?>","<?= $this->lang->line('Something went wrong')?>","<?= $this->lang->line('error')?>");
                }
                // setInterval(function(){
                //   location.reload();
                // },1500);
            }
            })
    });

    $(document).on('click','.createMenu-page .add-price-row',function(){
        var row = $(this).parent();
        var id = row.attr("data-id");
        row = $('.price-row[data-id="'+id+'"]');
        var data_type =  row.parent().attr("data-type");
        lang = $('.createMenu-page .lang-bar').find('.item-flag.active').attr("data-flag");
        var first_row = $("." + data_type+ "_price-table " + ".price-row").first();
        var last_row = $("." + data_type+ "_price-table " + ".price-row").last();
        var placeholder_ptitle = (first_row.find(".item_price_title input").attr("placeholder"));
        var placeholder_price = (first_row.find(".item_price input").attr("placeholder"));
        new_row_id = parseInt(last_row.find(".item_price_title input").attr("data-id")) + 1;
        new_row =''; 
        new_row +='<tr class="price-row" data-id = "'+ new_row_id +'">';
        new_row +='<td class="item_price_title input-group align-center english-field pt-3 ';
        new_row += (lang == "english") ? '' : 'hide-field'; 
        new_row+= '">';
        new_row +='<div class="input-group-prepend">';
        new_row +='<span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/en-flag.png')?>"></span>';
        new_row +='</div>';
        new_row +='<input type="text" name="item_price_title_' + data_type + '_english['+ new_row_id +']" class="form-control" placeholder="'+placeholder_ptitle+'" data-id = "'+ new_row_id +'" >';
        new_row +='</td>';
        new_row +='<td class="item_price_title input-group align-center french-field pt-3 ';
        new_row += (lang == "french") ? '' : 'hide-field'; 
        new_row+= '">';
        new_row +='<div class="input-group-prepend">';
        new_row +='<span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/fr-flag.png')?>"></span>';
        new_row +='</div>';
        new_row +='<input type="text" name="item_price_title_' + data_type + '_french['+ new_row_id +']" class="form-control" placeholder="'+placeholder_ptitle+'" data-id = "'+ new_row_id +'" >';
        new_row +='</td>';
        new_row +='<td class="pl-3 pt-3 item_price"><input type="number" name="item_price_' + data_type + '['+ new_row_id +']" class="form-control" placeholder="'+placeholder_price+'"  data-id = "'+ new_row_id +'" min = "0" step = "0.01"></td>';
        
        new_row +='<td class="text-danger text-center pl-1 pt-3 add-food-extra d-none d-sm-table-cell" data-price-placeholder = "<?= $this->lang->line('Extra Price')?>" ><span class="btn btn-success"><?= $this->lang->line('Add Food Extra')?></span></td>';
        new_row +='<td class="text-danger text-center pl-1 pt-3 del-price-row d-none d-sm-table-cell" ><i class="fa fa-times-circle"></i></td>';
        new_row +='<td class="text-success text-center pl-1 pt-3 add-price-row d-none d-sm-table-cell"><i class="fa fa-plus"></i></td>';
        new_row +='<td class="text-success text-center pl-1 pt-3 d-table-cell d-sm-none">';
        new_row +='<div class="nav-item dropdown no-arrow show">';
        new_row +='<a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-bars"></i></a>';
        new_row +='<div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown3" data-id = "'+ new_row_id +'">';
        new_row +='<span class="add-food-extra dropdown-item" data-price-placeholder = "<?= $this->lang->line('Extra Price')?>" ><?= $this->lang->line('Add Food Extra')?></span>';
        new_row +='<span class="del-price-row dropdown-item"><?= $this->lang->line('Remove Price')?></span>';
        new_row +='<span class="add-price-row dropdown-item"><?= $this->lang->line('Add Price')?></span>';
        new_row +='</div></div></td>';
        new_row +='</tr>';
        $("." + data_type + "_price-table").append(new_row);
    });
    $(document).on('keyup','.createMenu-page .require_field',function(){
        lang = $('.createMenu-page .language-panel').find('a.active').attr("data-lang");
        type = $('.createMenu-page .type-panel').find('a.active').attr("data-type");
        item_name_english = $('.createMenu-page input[name="item_name_' + type + '_english"]').val();
        item_name_french = $('.createMenu-page input[name="item_name_' + type + '_french"]').val();
        item_name_germany = $('.createMenu-page input[name="item_name_' + type + '_germany"]').val();
        price = $('.createMenu-page input[name="item_price_'+type+'[1]"]').val();
        cat_id = $('.createMenu-page #'+type+' #category_id').val();
        // console.log(lang,type,item_name_english,item_name_french,item_name_germany,english_title,french_title,germany_title,price,sub_cat_id);
        // if (cat_id !== "" && price.trim() !== "" && (item_name_english.trim() !== '' || item_name_french.trim() !== '' || item_name_germany.trim() !== '') ){
        if (cat_id !== "" ){
            $("#adNewIte" + type).attr("disabled",false);
        }else{
            $("#adNewIte" + type).attr("disabled",true );
        }
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
</script>