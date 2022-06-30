        <!-- Begin Page Content -->
        <div class="container-fluid createMenu-page menu-lang-page multi-lang-page" id = "all_menu_item" data-url ="<?= base_url('/')?>">
            <div class="multi-lang-field hide-field" data-food-extra-options = "<?= $this->lang->line("Food Extra")?> <?= $this->lang->line("Options")?>"></div>
            <!-- Page Heading -->
            <h1 class="h3 mb-2 text-gray-800"><?= $this->lang->line("Item Details")?></h1>
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
                                    <li><a class="<?= explode(",",$this->myRestDetail->menu_languages)[0] == 'english' ? 'active' : ''  ?>" href="<?=base_url('Restaurant/Menu/english')?>" data-lang="english"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/en-flag.png')?>"></a></li>
                                    <li><a class = "<?= explode(",",$this->myRestDetail->menu_languages)[0] == 'french' ? 'active' : ''  ?>" href="<?=base_url('Restaurant/Menu/french')?>" data-lang="french"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/fr-flag.png')?>"></a></li>
                                    <li><a class = "<?= explode(",",$this->myRestDetail->menu_languages)[0] == 'germany' ? 'active' : ''  ?>" href="<?=base_url('Restaurant/Menu/germany')?>" data-lang="germany"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/ge-flag.png')?>"></a></li>
                                </ul>
                            </div>
                        </div>    
                        <div class="row type-panel mt-2">
                            <div class="d-flex align-items-center mx-auto">
                                <ul class="nav nav-tabs">
                                    <?php 
                                    $th = 0;
                                    $types = $this->db->get('tbl_category_type')->result();
                                    $itemDetails_type_id = $this->db->where('category_id',$itemDetails->category_id)->get('tbl_category')->row()->type_id;
                                    foreach ($types as $key => $type) { 
                                        $th++;
                                        $type_field = 'type_title_'.$category_lang;
                                        if ($type->type_id == $itemDetails_type_id ){
                                        ?>
                                        <li class="<?=  $type->type_id == $itemDetails_type_id ? 'active' : '' ?>"><a class="createMenu_cattype <?= $type->type_id == $itemDetails_type_id ? 'active' : '' ?>" data-toggle="tab" href="#<?= $type->type_title?>" data-type = "<?= $type->type_title?>"><?= $type->$type_field?></a></li>
                                    <?php } }?>
                                </ul>
                            </div>
                        </div>
                    </section>
                    <!-- ---------------- -->
                    <div class="content_wrap tab-content">
                        <?php
                        $ti = 0;
                        foreach ($types as $key => $type) { $ti++;?>
                            <section id="<?= $type->type_title?>" class = "tab-pane <?= $type->type_id == $itemDetails_type_id ? 'active' : '' ?>">
                                <div class="card shadow mb-4">
                                    <div class="card-header py-3 d-flex justify-content-between title-bar">
                                        <h6 class="m-0 font-weight-bold text-primary">
                                            <?= $this->lang->line('Edit')?> Item
                                        </h6>
                                        <div class="lang-bar">
                                            <?php 
                                                $en_f = true;
                                                $ge_f = true;
                                                $fr_f = true;
                                            ?>
                                            <?php if( in_array("english",explode(",",$restDetails->menu_languages))){ $en_f = false ; ?>
                                                <span class="<?= explode(",",$this->myRestDetail->menu_languages)[0] == 'english' ? 'active' : ''  ?> item-flag" data-flag="english"><img class="english-flag" src="<?= base_url('assets/flags/en-flag.png')?>"></span>
                                            <?php }?>
                                            <?php if( in_array("french",explode(",",$restDetails->menu_languages))){ $fr_f = false ;  ?>
                                                <span class="<?= explode(",",$this->myRestDetail->menu_languages)[0] == 'french' ? 'active' : ''  ?> item-flag" data-flag="french"><img class="french-flag" src="<?= base_url('assets/flags/fr-flag.png')?>"></span>
                                            <?php }?>
                                            <?php if( in_array("germany",explode(",",$restDetails->menu_languages))){ $ge_f = false ;  ?>
                                                <span class="<?= explode(",",$this->myRestDetail->menu_languages)[0] == 'germany' ? 'active' : ''  ?> item-flag" data-flag="germany"><img class="germany-flag" src="<?= base_url('assets/flags/ge-flag.png')?>"></span>
                                            <?php }?>
                                            <?php if (!(!$en_f || !$ge_f || !$fr_f)){ ?>
                                                <a href=<?=base_url('Restaurant/setting/Language')?>><?= $this->lang->line('Click here to set Menu languages')?></a>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <?php if (!$en_f || !$ge_f || !$fr_f){ ?>
                                        <div class="card-body">
                                            <form action="<?=base_url('Restaurant/updateMenuItem') . '/'.$type->type_title?>" method="post" enctype="multipart/form-data">
                                                <input type="hidden" name="item_type_title" value="<?= $type->type_title?>">
                                                <input type="hidden" name="menu_id" value="<?=$itemDetails->menu_id?>" class="form-control" readonly>
                                                <div class="form-group row">
                                                    <div class="col-sm-6 col-md-8 mb-3 mb-sm-0">
                                                        <label>Visible in</label>
                                                        <div class="input-group">
                                                            <?php 
                                                            if (isset($restDetails)){
                                                            
                                                                echo '
                                                                <div class="col-md-4 align-items-center d-flex">
                                                                    <input type="checkbox" name="item_show_in_menu" id ="item_show_in_menu" class="item_show_in" style="width: 20px; height: 20px; margin-right: 10px;" checked> 
                                                                    <label for= "item_show_in_menu" class="mb-0"> Standard Food Menu </label>
                                                                </div>';
                                                                if ($restDetails->dp_option == 1 || $restDetails->dp_option == 3 ){ ?>
                                                                    <div class="col-md-4 align-items-center d-flex">
                                                                        <input type="checkbox" name="item_show_in_delivery" id ="item_show_in_delivery" class="item_show_in" <?=$itemDetails->item_show_on == 1 ? "checked" : "" ?> <?=$itemDetails->item_show_on == 3 ? "checked" : "" ?> style="width: 20px; height: 20px; margin-right: 10px;"> 
                                                                        <label for= "item_show_in_delivery" class="mb-0"> Delivery </label>
                                                                    </div>
                                                                <?php }
                                                                if ($restDetails->dp_option == 2 || $restDetails->dp_option == 3 ){ ?>
                                                                    <div class="col-md-4 align-items-center d-flex">
                                                                        <input type="checkbox" name="item_show_in_pickup" id ="item_show_in_pickup" class="item_show_in" <?=$itemDetails->item_show_on > 1 ? "checked" : "" ?> style="width: 20px; height: 20px; margin-right: 10px;"> 
                                                                        <label for= "item_show_in_pickup" class="mb-0"> Pickup </label>
                                                                    </div>
                                                                <?php }
                                                            }
                                                            ?>
                                                        </div>
                                                        <div class="form-group row mt-4">
                                                            <div class="col-sm-6 mb-3 mb-sm-0">
                                                                <label><?= $this->lang->line('Item Name')?></label>
                                                                <div class="input-group english-field hide-field">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/en-flag.png')?>" ></span>
                                                                    </div>
                                                                    <input type="text" name="item_name_<?=$type->type_title?>_english" class=" require_field form-control" placeholder="<?= $this->lang->line('Item Name')?>" value="<?=$itemDetails->item_name_english == "" ? $itemDetails->item_name : $itemDetails->item_name_english?>" >
                                                                </div>
                                                                <div class="input-group french-field hide-field">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/fr-flag.png')?>" ></span>
                                                                    </div>
                                                                    <input type="text" name="item_name_<?=$type->type_title?>_french" class="require_field form-control" placeholder="<?= $this->lang->line('Item Name')?>" value="<?=$itemDetails->item_name_french == "" ? $itemDetails->item_name : $itemDetails->item_name_french?>">
                                                                </div>
                                                                <div class="input-group germany-field hide-field">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/ge-flag.png')?>" ></span>
                                                                    </div>
                                                                    <input type="text" name="item_name_<?=$type->type_title?>_germany" class="require_field form-control" placeholder="<?= $this->lang->line('Item Name')?>" value="<?=$itemDetails->item_name_germany == "" ? $itemDetails->item_name : $itemDetails->item_name_germany?>">
                                                                </div>
                                                            </div>
                                                            
                                                            <?php if (in_array("tax_setting",$addon_features)){ ?>
                                                            <div class="col-sm-6 mb-3 mb-sm-0">
                                                                <label><?= $this->lang->line('Tax')?></label>
                                                                <select class="form-control item_tax_id" name="item_tax_id">
                                                                    <option value="0"><?= $this->lang->line('Select Tax')?></option>
                                                                    <?php foreach($taxes as $tax): ?>
                                                                        <option value="<?=$tax->id?>" <?= $itemDetails->item_tax_id == $tax->id ? "selected" : "" ?>><?=$tax->tax_percentage?> %</option>
                                                                    <?php endforeach; ?>
                                                                </select>
                                                            </div>
                                                            <?php } ?>
                                                        </div>
                                                        <label class="mt-3"><?= $this->lang->line('Select Category')?></label>
                                                               
                                                        <div class="form-group row">
                                                            <div class="col-sm-4 mb-3 mb-sm-0 d-none">
                                                                <select class="form-control" name="rest_id" required>
                                                                    <option value="<?=$myRestId?>" selected><?=$myRestName?></option>
                                                                </select>
                                                            </div>
                                                            <div class="col-sm-6 mb-3 mb-sm-0">
                                                                <select class="form-control category_id hide-field require_field" name="category_id"  data-type = "<?=$type->type_id?>" required>
                                                                    <option value="0"><?= $this->lang->line('Select Category')?></option>
                                                                    <?php
                                                                        // print_r ($Categories);
                                                                        $category_name_field = "category_name" .""; 
                                                                        foreach($Categories as $cat): 
                                                                        if ($cat->type_id ==$type->type_id){ ?>
                                                                        <option value="<?=$cat->category_id?>" <?= $cat->category_id==$itemDetails->category_id ? "selected": "" ?>><?= $cat->$category_name_field == "" ? $cat->category_name : $cat->$category_name_field?></option>
                                                                    <?php } endforeach; ?>
                                                                </select>
                                                                <select class="form-control category_id english-field hide-field" name="category_id_english"  data-type = "<?=$type->type_id?>" required>
                                                                    <option value="0"><?= $this->lang->line('Select Category')?></option>
                                                                    <?php
                                                                        $category_name_field = "category_name_" ."english"; 
                                                                        foreach($Categories as $cat): 
                                                                        if ($cat->type_id ==$type->type_id){ ?>
                                                                        <option value="<?=$cat->category_id?>" <?= $cat->category_id==$itemDetails->category_id ? "selected": "" ?>><?= $cat->$category_name_field == "" ? $cat->category_name : $cat->$category_name_field?></option>
                                                                    <?php } endforeach; ?>
                                                                </select>
                                                                <select class="form-control category_id french-field hide-field" name="category_id_french"  data-type = "<?=$type->type_id?>" required>
                                                                    <option value="0"><?= $this->lang->line('Select Category')?></option>
                                                                    <?php
                                                                        $category_name_field = "category_name_" ."french"; 
                                                                        foreach($Categories as $cat): 
                                                                        if ($cat->type_id ==$type->type_id){ ?>
                                                                        <option value="<?=$cat->category_id?>" <?= $cat->category_id==$itemDetails->category_id ? "selected": "" ?>><?= $cat->$category_name_field == "" ? $cat->category_name : $cat->$category_name_field?></option>
                                                                    <?php } endforeach; ?>
                                                                </select>
                                                                <select class="form-control category_id germany-field hide-field" name="category_id_germany"  data-type = "<?=$type->type_id?>" required>
                                                                    <option value="0"><?= $this->lang->line('Select Category')?></option>
                                                                    <?php
                                                                        $category_name_field = "category_name_" ."germany"; 
                                                                        foreach($Categories as $cat): 
                                                                        if ($cat->type_id ==$type->type_id){ ?>
                                                                        <option value="<?=$cat->category_id?>" <?= $cat->category_id==$itemDetails->category_id ? "selected": "" ?>><?= $cat->$category_name_field == "" ? $cat->category_name : $cat->$category_name_field?></option>
                                                                    <?php } endforeach; ?>
                                                                </select>
                                                            </div>
                                                            
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6 col-md-4 mb-3 mb-sm-0">
                                                        <label class="hide-field">Item Sort Index</label>
                                                        <div class="input-group mb-4 hide-field">
                                                            <input type="number" name="item_sort_index" class="form-control" placeholder="Item Sort Index"  min = "0">
                                                        </div>
                                                        <label class=" mt-4">Image</label>
                                                        <input type="file" class="dropify" name="item_image" data-default-file="<?=base_url('assets/menu_item_images/').$itemDetails->item_image?>"/>
                                                        <input type="hidden" name="is_update_item_image" value = "<?= $itemDetails->item_image == "" ? "1" : "0"?>" />
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-12">
                                                    
                                                        <label>Description</label>
                                                        <div class="input-group english-field hide-field">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/en-flag.png')?>" ></span>
                                                            </div>
                                                            <textarea class="summernote form-control" name="item_desc_english"  placeholder ="<?= $this->lang->line('Item Description')?>"><?=$itemDetails->item_desc_english == "" ? $itemDetails->item_desc : $itemDetails->item_desc_english?></textarea>
                                                        </div>
                                                        <div class="input-group french-field hide-field">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/fr-flag.png')?>" ></span>
                                                            </div>
                                                            <textarea class="summernote form-control" name="item_desc_french"  placeholder ="<?= $this->lang->line('Item Description')?>"><?=$itemDetails->item_desc_french == "" ? $itemDetails->item_desc : $itemDetails->item_desc_french?></textarea>
                                                        </div>
                                                        <div class="input-group germany-field hide-field">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/ge-flag.png')?>"></span>
                                                            </div>
                                                            <textarea class="summernote form-control" name="item_desc_germany" placeholder ="<?= $this->lang->line('Item Description')?>"><?=$itemDetails->item_desc_germany == "" ? $itemDetails->item_desc : $itemDetails->item_desc_germany?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div  class="form-group">
                                                    <label>Price & Extras</label>
                                                    <?php
                                                        $flag_src["english"] = base_url('assets/flags/en-flag.png');
                                                        $flag_src["french"] = base_url('assets/flags/fr-flag.png');
                                                        $flag_src["germany"] = base_url('assets/flags/ge-flag.png');
                                                        $item_prices_title_field = "item_prices_title_" . $section_lang;
                                                        $price_title_french = explode(",",$itemDetails->item_prices_title_french);
                                                        $price_title_germany = explode(",",$itemDetails->item_prices_title_germany);
                                                        $price_title_english = explode(",",$itemDetails->item_prices_title_english);
                                                    ?>
                                                    <table class="w-100">
                                                        <tbody class="<?= $type->type_title ?>_price-table" data-type="<?=$type->type_title ?>">
                                                            <?php foreach($Prices as $key => $price): ?>
                                                            <tr class="price-row" data-id = "<?=$key?>">
                                                                <td class="item_price_title input-group <?=explode(",",$this->myRestDetail->menu_languages)[0] == "french" ? "" : "hide-field" ?> french-field">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/fr-flag.png')?>"></span>
                                                                    </div>
                                                                    <input type="text" name="item_price_title_<?= $type->type_title?>_french[<?= $key ?>]" value="<?=$price_title_french[$key]?>" class="require_field  form-control checkit" placeholder="<?= $this->lang->line('Price Title')?>" data-id = "<?=$key?>">
                                                                </td>
                                                                <td class="item_price_title input-group <?=explode(",",$this->myRestDetail->menu_languages)[0] == "germany" ? "" : "hide-field" ?> germany-field">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/ge-flag.png')?>"></span>
                                                                    </div>
                                                                    <input type="text" name="item_price_title_<?= $type->type_title?>_germany[<?= $key ?>]" value="<?=$price_title_germany[$key]?>" class="require_field  form-control checkit" placeholder="<?= $this->lang->line('Price Title')?>" data-id = "<?=$key?>">
                                                                </td>
                                                                <td class="item_price_title input-group <?=explode(",",$this->myRestDetail->menu_languages)[0] == "english" ? "" : "hide-field" ?> english-field">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/en-flag.png')?>"></span>
                                                                    </div>
                                                                    <input type="text" name="item_price_title_<?= $type->type_title?>_english[<?= $key ?>]" value="<?=$price_title_english[$key]?>" class="require_field  form-control checkit" placeholder="<?= $this->lang->line('Price Title')?>" data-id = "<?=$key?>">
                                                                </td>
                                                                <td class="pl-3 item_price">
                                                                    <input type="number" name="item_price_<?= $type->type_title?>[<?= $key ?>]" value="<?=$price?>" class="require_field form-control" placeholder="<?= $this->lang->line('Price')?>*" data-id = "<?=$key?>" min = "0" step = "0.01">
                                                                </td>
                                                                <td class="text-danger text-center pl-1 add-food-extra d-none d-sm-table-cell" data-price-placeholder = "<?= $this->lang->line('Extra Price')?>" ><span class="btn btn-success"><?= $this->lang->line('Add Food Extra')?></span></td>
                                                                <td class="text-danger text-center pl-1 del-price-row d-none d-sm-table-cell" ><i class="fa fa-times-circle"></i></td>
                                                                <td class="text-success text-center pl-1 add-price-row d-none d-sm-table-cell"><i class="fa fa-plus"></i></td>
                                                                <td class="text-info text-center pl-1 d-table-cell d-sm-none">
                                                                    <div class="nav-item dropdown no-arrow show">
                                                                        <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                            <i class="fa fa-bars"></i>
                                                                        </a>
                                                                        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown3" data-id = "<?=$key?>">
                                                                            <span class="add-food-extra dropdown-item" data-price-placeholder = <?= $this->lang->line('Extra Price')?> ><?= $this->lang->line('Add Food Extra')?></span>
                                                                            <span class="del-price-row dropdown-item"><?= $this->lang->line('Remove Price')?></span>
                                                                            <span class="add-price-row dropdown-item"><?= $this->lang->line('Add Price')?></span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <?php 
                                                                if (isset($Extras[$key])){
                                                                    $childrenExtra = explode(";",$Extras[$key]);
                                                                    if (is_array($childrenExtra)){ ?>
                                                                        <tr class="food-extra-row-label j-text-black" data-id = "<?=$key?>">
                                                                            <td class="food_extra-pl-50" colspan="2">
                                                                                <div class="p-2 j-bg-light-gray"><?=$this->lang->line("Food Extra") ?> <?=$this->lang->line("Options") ?></div>
                                                                            </td>
                                                                        </tr>
                                                                        <?php 
                                                                        $form_row = "";
                                                                        foreach ($childrenExtra as $child_extra_key => $child_extra) {
                                                                            if (sizeof(explode("->",$child_extra)) == 2){
                                                                                $ext_cat = explode("->",$child_extra)[0];
                                                                                $ext_c_b = explode("->",$child_extra)[1]; 
                                                                                if ($fecat = $this->db->where('extra_category_id',$ext_cat)->where('extra_category_status',"active")->get('tbl_food_extra_category')->row()){
                                                                                    $eachExtra = explode(",",$ext_c_b);
                                                                                    ?>
                                                                                    <tr class="food-extra-row" data-id = "<?=$key?>" data-extra-id="<?= $child_extra_key?>" data-extra-cat="<?= $ext_cat?>">
                                                                                        <td class="food_extra-pl-50 j-text-black" colspan="2">
                                                                                            <div class="j-bg-light-gray d-flex justify-content-between align-items-center p-2">
                                                                                                <span class="english-field <?=explode(",",$this->myRestDetail->menu_languages)[0] == "english" ? "" : "hide-field" ?>"><?=$fecat->extra_category_name_english == "" ? $fecat->extra_category_name : $fecat->extra_category_name_english ?></span>
                                                                                                <span class="french-field <?=explode(",",$this->myRestDetail->menu_languages)[0] == "french" ? "" : "hide-field" ?>"><?=$fecat->extra_category_name_french == "" ? $fecat->extra_category_name : $fecat->extra_category_name_french ?></span>
                                                                                                <span class="germany-field <?=explode(",",$this->myRestDetail->menu_languages)[0] == "germany" ? "" : "hide-field" ?>"><?=$fecat->extra_category_name_germany == "" ? $fecat->extra_category_name : $fecat->extra_category_name_germany ?></span>
                                                                                                <input type="hidden" name="extra_cat_ids[<?=$key?>][]" value="<?= $ext_cat?>">
                                                                                                <div>
                                                                                                    <span class="btn btn-danger remove-extra-btn mr-2">Delete</span>
                                                                                                    <span class="btn btn-info edit-extra-btn">Edit</span>
                                                                                                </div>
                                                                                            </div>
                                                                                            <?php 
                                                                                            foreach ($eachExtra as $extra_key => $extra_value) {
                                                                                                if ($extra_value !== ""){
                                                                                                    $extra_id = explode(":",$extra_value)[0];
                                                                                                    if ($extra_price = explode(":",$extra_value)[1]){
                                                                                                        $fecat = $this->db->where('category_id',$ext_cat)->where('extra_id',$extra_id)->get('tbl_food_extra')->row();

                                                                                                        $form_row .= '<tr class="food-extra-form-row" data-id="'.($key).'" data-extra-id="'.$child_extra_key.'">';
                                                                                                        $form_row .= '<td class="food_extra"><input type="number" class="form-control extra_id hide-field" name="extra_id_english['.($key).']['. $child_extra_key.'][]" required="" min="0" value="'. $extra_id.'"></td>';
                                                                                                        $form_row .='<td class="pl-3 extra_price"><input type="number" name="extra_price['.($key).']['. $child_extra_key.'][]" class="form-control hide-field" min="0" step="0.01" value="'. $extra_price.'"></td>';
                                                                                                        $form_row .="</tr>";

                                                                                                        ?>
                                                                                                        <div class="j-bg-lighter-gray p-2">
                                                                                                            <span class="english-field <?=explode(",",$this->myRestDetail->menu_languages)[0] == "english" ? "" : "hide-field" ?>"><?=$fecat->food_extra_name_english == "" ? $fecat->food_extra_name : $fecat->food_extra_name_english  ?> - <?=$extra_price?> <?=$currentRestCurrencySymbol?> </span>
                                                                                                            <span class="french-field <?=explode(",",$this->myRestDetail->menu_languages)[0] == "french" ? "" : "hide-field" ?>"><?=$fecat->food_extra_name_french == "" ? $fecat->food_extra_name : $fecat->food_extra_name_french  ?> - <?=$extra_price?> <?=$currentRestCurrencySymbol?> </span>
                                                                                                            <span class="germany-field <?=explode(",",$this->myRestDetail->menu_languages)[0] == "germany" ? "" : "hide-field" ?>"><?=$fecat->food_extra_name_germany == "" ? $fecat->food_extra_name : $fecat->food_extra_name_germany  ?> - <?=$extra_price?> <?=$currentRestCurrencySymbol?> </span>
                                                                                                        </div>
                                                                                                    
                                                                                                <?php }}else{
                                                                                                } 
                                                                                            } ?>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <?php
                                                                                        
                                                                                }
                                                                            }
                                                                        }
                                                                        echo $form_row;
                                                                    }
                                                                }
                                                            endforeach;?>
                                                        </tbody>
                                                    </table>
                                                    
                                                </div>
                                                <label>Allergens</label>
                                                <div class="form-group row">
                                                    <div class="col-md-12">
                                                        <!-- <input type="text" name="item_allergens" placeholder="Item Allergens" class="form-control"> -->
                                                        <div class="row">
                                                            <?php
                                                                foreach ($allergens as $key => $allergen) { ?>
                                                                    <label class="d-flex align-items-center font-size-12 col-md-3">
                                                                        <input type="checkbox" name="item_allergens[<?=$key?>]" value="<?=$allergen->allergen_id?>" style="width: 20px; height: 20px" class="mr-2 item_allergen_id" <?= in_array($allergen->allergen_id, $allergen_arr) ? "checked" : ""?>>
                                                                        <span class="hide-field english-field"><?= $allergen->allergen_name_english == "" ? $allergen->allergen_name  : $allergen->allergen_name_english?></span>
                                                                        <span class="hide-field french-field"><?= $allergen->allergen_name_french == "" ? $allergen->allergen_name  : $allergen->allergen_name_french  ?></span>
                                                                        <span class="hide-field germany-field"><?= $allergen->allergen_name_germany == "" ? $allergen->allergen_name  : $allergen->allergen_name_germany?></span>
                                                                    </label>
                                                            <?php } ?>
                                                        </div>
                                                        
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-8">
                                                        <label>Please Choose</label>
                                                        <?= $itemDetails->item_type ?>
                                                        <div>
                                                            <label for="non-veg" class="mr-md-5">
                                                                <input type="radio" name="item_type" class="" value="3" id="non-veg" <?= $itemDetails->item_type == "Non Veg" ? "checked" : ""?>>
                                                                Non Veg
                                                            </label>
                                                            <label for="vegetarian" class="mr-md-5">
                                                                <input type="radio" name="item_type" class="" value="1" id="vegetarian" <?= $itemDetails->item_type=="Vegetarian" ? "checked" : ""?>>
                                                                <?= $this->lang->line('Vegetarian')?>
                                                            </label>
                                                            <label for="vegan" class="mr-md-5">
                                                                <input type="radio" name="item_type" class="" value="2" id="vegan" <?= $itemDetails->item_type=="Vegan" ? "checked" : ""?>> 
                                                                <?= $this->lang->line('Vegan')?>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="mt-4"></label>
                                                        <div class="d-flex align-items-center justify-content-around">
                                                            <label for ="item_show_blue" class="mb-0"><?= $this->lang->line("Show Blue Bar")?></label>
                                                            <input type="checkbox" name="item_show_blue" id="item_show_blue" checked style="width: 20px; height: 20px"  <?=$itemDetails->item_show_blue == 'on' ? "checked" : "" ?> >
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-sm-12 mx-auto mb-3 mb-sm-0">
                                                    <input type="submit" name="" value="<?= $this->lang->line('Update')?>" class="submit-btn btn btn-danger btn-user btn-block" id="adNewIte<?= $type->type_title?>">
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    <?php } ?>
                                </div>
                            </section>
                        <?php } ?>
                    </div>
                </div>
            
            </div>
            
        </div>
        <!-- /.container-fluid -->
<script type="text/javascript">
    $(document).on('change','.createMenu-page .category_id',function(){
        var category_id= $(this).val();
        lang = $('.createMenu-page .language-panel').find('a.active').attr("data-lang");
        $(".createMenu-page .category_id").val(category_id);
        // var sub_category = $(".createMenu-page #sub_category_id_"+lang);
        var sub_category = $(".createMenu-page .sub_category_id");
        var extra_id = $(".createMenu-page .extra_id");
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
    $(document).ready(function(){
        lang = $('.createMenu-page .language-panel').find('a.active').attr("data-lang");
        $("."+lang+"-field").removeClass("hide-field");
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
    $(document).on('click','.copyMenuItem',function(){
        var menuId=$(this).attr('d-item-id');
        var element=$(this);
        $.ajax({
            url:"<?=base_url('API/duplicateMenuItem')?>",
            type:"post",
            data:{menuId:menuId},
            success:function(response){
                
                response=JSON.parse(response);
                console.log(response);
                if(response.status==1){
                    swal("<?= $this->lang->line('Great..')?>","<?= $this->lang->line('Duplicated Successfully.')?>","<?= $this->lang->line('success')?>");
                    url = $("footer").attr("data-url");

                    parent_td =  element.parents(".our-menu-td");
                    // parent_td.css("background","red");
                    parent_td.clone().insertAfter(parent_td);
                    parent_td.next().find(".deleteMenu").attr("d-item-id",response.new_item_id);
                    parent_td.next().find(".copyMenuItem").attr("d-item-id",response.new_item_id);
                    parent_td.next().find(".handle_menu").attr("d-item-id",response.new_item_id);
                    parent_td.next().find(".viewMenuItem").prop("href",url + "Restaurant/editMenu/" + response.new_item_id);
                }else{
                    swal("<?= $this->lang->line('Ooops..')?>","<?= $this->lang->line('Something went wrong')?>","<?= $this->lang->line('error')?>");
                }
                setInterval(function(){
                    // location.reload();
                },1500);
            }
        })
    });
    $(document).on('click','.dropify-clear',function(){
        $("input[name='is_update_item_image']").val("1");
    });
    $(document).on('click','.createMenu-page .add-price-row',function(){
        var row = $(this).parent();
        var id = row.attr("data-id");
        row = $('.tab-pane.active .price-row[data-id="'+id+'"]');
        var data_type =  row.parent().attr("data-type");
        console.log(data_type);
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
        new_row +='<td class="item_price_title input-group align-center germany-field pt-3 ';
        new_row += (lang == "germany") ? '' : 'hide-field'; 
        new_row+= '">';
        new_row +='<div class="input-group-prepend">';
        new_row +='<span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/ge-flag.png')?>"></span>';
        new_row +='</div>';
        new_row +='<input type="text" name="item_price_title_' + data_type + '_germany['+ new_row_id +']" class="form-control" placeholder="'+placeholder_ptitle+'" data-id = "'+ new_row_id +'" >';
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