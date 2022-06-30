
<?php
    // print_r($Categories);
    
?>
<script>
    $(document).on('keyup','.checkit',function(){
        var el = $(this);
        var value = el.val();
        if(value.includes(',')){
            alert('comma not allowed, please use point');
            location.reload();
        }
    })
</script>
    <div class="container menu-detailed-page" id = "all_menu_item" data-url ="<?= base_url('/')?>">

        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
            
                <div class="col-lg-12">
                    <div class="p-md-5 p-3">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4"><?= $this->lang->line('Item Details')?></h1>
                            <hr>
                        </div>
                    <form class="user" id="updateItemImage">
                        <div class="form-group row">
                        <div class="col-md-8 mx-auto">
                            <input type="hidden" name="menu_id" value="<?=$itemDetails->menu_id?>" class="form-control" readonly>
                            <!-- <input type="file" name="item_image"> -->
                            <input type="file" class="dropify" name="item_image" data-default-file="<?=base_url('assets/menu_item_images/').$itemDetails->item_image?>" />
                        </div>
                        </div>
                        
                    
                        <input type="submit" value="<?= $this->lang->line('Update Item Image')?>" class="btn btn-primary btn-user btn-block">
                        <button type="button" class="btn btn-danger btn-user btn-block deleter" menu_id="<?=$itemDetails->menu_id?>"><?= $this->lang->line('Delete Image')?></button>
                    
                    </form>
                    <br>
                    <br>
                    <section class="my-5 tab-panel-j">
                        <div class="row language-panel_">
                            <div class="d-flex align-items-center mx-auto">
                                <ul class="nav nav-tabs">
                                    <li class="active"><a class="<?= $section_lang == 'english' ? 'active' : ''  ?>" href="<?=base_url('Admin/editMenu/'.$itemDetails->menu_id.'/english')?>" data-lang="english"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/en-flag.png')?>"></a></li>
                                    <li><a class = "<?= $section_lang == 'french' ? 'active' : ''  ?>" href="<?=base_url('Admin/editMenu/'.$itemDetails->menu_id.'/french')?>" data-lang="french"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/fr-flag.png')?>"></a></li>
                                    <li><a class = "<?= $section_lang == 'germany' ? 'active' : ''  ?>" href="<?=base_url('Admin/editMenu/'.$itemDetails->menu_id.'/germany')?>" data-lang="germany"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/ge-flag.png')?>"></a></li>
                                </ul>
                            </div>
                        </div> 
                    </section>
                    <form id="updateItemDetails">
                        <?php
                            $flag_src["english"] = base_url('assets/flags/en-flag.png');
                            $flag_src["french"] = base_url('assets/flags/fr-flag.png');
                            $flag_src["germany"] = base_url('assets/flags/ge-flag.png');
                            $item_name_field = "item_name_". $section_lang;
                        ?>
                        <input type="hidden" name = "section_lang" value = "<?= $section_lang?>" id="section_lang"/>
                        <div class="form-group row">
                            
                            <div class="col-sm-3 mb-3 mb-sm-0">
                                <label><?= $this->lang->line('Item Name')?>*</label>
                                <input type="hidden" name="menu_id" value="<?=$itemDetails->menu_id?>" class="form-control" readonly>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="<?= $flag_src[$section_lang]?>" ></span>
                                    </div>
                                    <input type="text" class="form-control form-control-user"  placeholder="<?= $this->lang->line('Item Name')?>" name="item_name" value="<?=$itemDetails->$item_name_field?>" >
                                </div>
                            </div>
                            <div class="col-sm-3 mb-3 mb-sm-0">
                                <label><?= $this->lang->line('Item Type')?>*</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="<?= $flag_src[$section_lang]?>" ></span>
                                    </div>
                                    <select class="form-control" name = "item_cat_type" required id="item_cat_type">
                                        <?php 
                                        $itemDetails_type_id = $this->db->where('category_id',$itemDetails->category_id)->get('tbl_category')->row()->type_id;
                                        foreach($ItemType as $type): 
                                            $type_title_field = "type_title_".$section_lang;
                                            if($type->$type_title_field == $itemDetails_type_id){
                                                echo '<option value="'.$type->type_id.'" selected>'.$type->$type_title_field.'</option>';
                                            }else{
                                                echo '<option value="'.$type->type_id.'" >'.$type->$type_title_field.'</option>';
                                            }
                                        ?>
                                        <?php endforeach;?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-3 mb-3 mb-sm-0">
                                <label><?= $this->lang->line('Item Category')?>*</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="<?= $flag_src[$section_lang]?>" ></span>
                                    </div>
                                    <select class="form-control" name = "item_category_id" id = "item_category_id" required>
                                        <?php 
                                        $category_name_field = "category_name_" . $section_lang;
                                        foreach($Categories as $cat): ?>
                                        <?php
                                            if($cat->category_id==$itemDetails->category_id){
                                                echo '<option value="'.$cat->category_id.'" selected>'.$cat->$category_name_field.'</option>';
                                            }else{
                                                echo '<option value="'.$cat->category_id.'" >'.$cat->$category_name_field.'</option>';
                                            }
                                        ?>
                                        <?php endforeach;?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-3 mb-3 mb-sm-0">
                                <label><?= $this->lang->line('Item Sub Category')?></label>
                                <div class="input-group">
                                    <select class="form-control sub_category_id chosen-select-width" id="sub_category_id"  data-placeholder="Your Sub Category" name="sub_category_id[]"  multiple >
                                        <?php 
                                        $sub_category_name_field = "sub_category_name_" . $section_lang;
                                        foreach($subCategories as $subcats_i): 
                                            if(in_array($subcats_i->sub_cat_id, $subCat)){
                                                echo '<option value="'.$subcats_i->sub_cat_id.'" selected>'.$subcats_i->$sub_category_name_field.'</option>';
                                            }else{
                                                echo '<option value="'.$subcats_i->sub_cat_id.'" >'.$subcats_i->$sub_category_name_field.'</option>';
                                            }
                                        endforeach;?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-3 mb-3 mb-sm-0">
                                <label><?=$this->lang->line('Vegetarian')?></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="<?= $flag_src[$section_lang]?>" ></span>
                                    </div>
                                    <select class="form-control" name="item_type">
                                        <option value="3" <?php if($itemDetails->item_type=="Non Veg")echo "selected";?>><?=$this->lang->line('Non Veg')?></option>
                                        <option value="1" <?php if($itemDetails->item_type=="Vegetarian")echo "selected";?>><?=$this->lang->line('Vegetarian')?></option>
                                        <option value="2" <?php if($itemDetails->item_type=="Vegan")echo "selected";?>><?=$this->lang->line('Vegan')?></option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-3 mb-3 mb-sm-0">
                                <label><?= $this->lang->line("Item Allergens")?></label>
                                <div class="input-group">
                                    <select class="form-control item_allergens_id chosen-select-width-allergens" id="item_allergens"  data-placeholder="Your Allergens" name="item_allergens[]"  multiple >
                                        <?php 
                                        $allergen_name_field = "allergen_name_" . $section_lang;
                                        foreach($allergens as $allergen): 
                                            if(in_array($allergen->allergen_id, $allergen_arr)){
                                                echo '<option value="'.$allergen->allergen_id.'" selected>'.$allergen->$allergen_name_field.'</option>';
                                            }else{
                                                echo '<option value="'.$allergen->allergen_id.'" >'.$allergen->$allergen_name_field.'</option>';
                                            }
                                        endforeach;?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-3 mb-3 mb-sm-0">
                                <label>Sort Index</label>
                                <div class="input-group">
                                    <input type="number" class="form-control form-control-user"  placeholder="Sort Index" min="0" name="item_sort_index" value="<?=$itemDetails->item_sort_index?>">
                                </div>
                            </div>
                            <div class="col-sm-3 mb-3 mb-sm-0 d-flex align-items-center justify-content-around" >
                                <label for ="item_show_blue" class="mb-0"><?= $this->lang->line("Show Blue Bar")?></label>
                                <input type="checkbox" name="item_show_blue" id="item_show_blue" <?=$itemDetails->item_show_blue == 'on' ? "checked" : "" ?> style="width: 20px; height: 20px">
                            </div>
                            <div class="col-md-6 mb-3 mb-sm-0 row mt-3">
                            <?php 
                                if ($restDetails->dp_option == 1 || $restDetails->dp_option == 3 ){
                                    ?>
                                        <div class="col-md-6 align-items-center d-flex">
                                            <input type="checkbox" name="item_show_in_delivery" id ="item_show_in_delivery" class="item_show_in" <?=$itemDetails->item_show_on == 1 ? "checked" : "" ?> <?=$itemDetails->item_show_on == 3 ? "checked" : "" ?> style="width: 20px; height: 20px; margin-right: 10px;"> 
                                            <label for= "item_show_in_delivery" class="mb-0"> Delivery </label>
                                        </div>
                                    <?php
                                }
                                if ($restDetails->dp_option == 2 || $restDetails->dp_option == 3 ){
                                    ?>
                                        <div class="col-md-6 align-items-center d-flex">
                                            <input type="checkbox" name="item_show_in_pickup" id ="item_show_in_pickup" <?=$itemDetails->item_show_on > 1 ? "checked" : "" ?> class="item_show_in" style="width: 20px; height: 20px; margin-right: 10px;"> 
                                            <label for= "item_show_in_pickup" class="mb-0"> Pickup </label>
                                        </div>
                                    <?php
                                }
                            ?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <?php
                                $item_prices_title_field = "item_prices_title_" . $section_lang;
                                $price_title_french = explode(",",$itemDetails->item_prices_title_french);
                                $price_title_germany = explode(",",$itemDetails->item_prices_title_germany);
                                $price_title_english = explode(",",$itemDetails->item_prices_title_english);
                            ?>
                            <table class="w-100">
                                <tbody class="price-table">
                                    <?php foreach($Prices as $key => $price): ?>
                                    <tr class="price-row" data-id = "<?=$key?>">
                                        <td class="item_price_title input-group <?=$section_lang == "french" ? "" : "hide-field" ?> french-field">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="<?= $flag_src[$section_lang]?>"></span>
                                            </div>
                                            <input type="text" name="price_title_french[<?= $key ?>]" value="<?=$price_title_french[$key]?>" class="require_field  form-control checkit" placeholder="<?= $this->lang->line('Price Title')?>" data-id = "<?=$key?>">
                                        </td>
                                        <td class="item_price_title input-group <?=$section_lang == "germany" ? "" : "hide-field" ?> germany-field">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="<?= $flag_src[$section_lang]?>"></span>
                                            </div>
                                            <input type="text" name="price_title_germany[<?= $key ?>]" value="<?=$price_title_germany[$key]?>" class="require_field  form-control checkit" placeholder="<?= $this->lang->line('Price Title')?>" data-id = "<?=$key?>">
                                        </td>
                                        <td class="item_price_title input-group <?=$section_lang == "english" ? "" : "hide-field" ?> english-field">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="<?= $flag_src[$section_lang]?>"></span>
                                            </div>
                                            <input type="text" name="price_title_english[<?= $key ?>]" value="<?=$price_title_english[$key]?>" class="require_field  form-control checkit" placeholder="<?= $this->lang->line('Price Title')?>" data-id = "<?=$key?>">
                                        </td>
                                        <td class="pl-3 item_price">
                                            <input type="number" name="item_price[<?= $key ?>]" value="<?=$price?>" class="require_field form-control" placeholder="<?= $this->lang->line('Price')?>*" data-id = "<?=$key?>" min = "0" step = "0.01">
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
                                        $eachExtra = explode(",",$Extras[$key]);
                                        foreach ($eachExtra as $extra_key => $extra_value) {
                                            if ($extra_value !== ""){
                                                $extra_id = explode(":",$extra_value)[0];
                                                $extra_price = explode(":",$extra_value)[1];
                                                ?>
                                                <tr class="food-extra-row" data-extra-id="<?=$extra_key?>" data-id="<?= $key ?>">
                                                    <td class="food_extra">
                                                        <select class="form-control extra_id english-field <?=$section_lang == "english" ? "" : "hide-field" ?>" name="extra_id_english[<?= $key ?>][<?=$extra_key?>]" required="">
                                                            <?php
                                                                foreach ($foodExtras as $foodExtras_key => $foodExtras_value) { ?>
                                                                    
                                                                    <option value="<?= $foodExtras_value->extra_id?>" <?= $extra_id == $foodExtras_value->extra_id ? "selected" : ""  ?>><?= $foodExtras_value->food_extra_name_english?></option>
                                                            <?php } ?>
                                                        </select>
                                                        <select class="form-control extra_id germany-field <?=$section_lang == "germany" ? "" : "hide-field" ?>" name="extra_id_germany[<?= $key ?>][<?=$extra_key?>]" required="">
                                                            <?php
                                                                foreach ($foodExtras as $foodExtras_key => $foodExtras_value) { ?>
                                                                    <option value="<?= $foodExtras_value->extra_id?>" <?= $extra_id == $foodExtras_value->extra_id ? "selected" : ""  ?>><?= $foodExtras_value->food_extra_name_germany?></option>
                                                            <?php } ?>
                                                        </select>
                                                        <select class="form-control extra_id french-field <?=$section_lang == "french" ? "" : "hide-field" ?>" name="extra_id_french[<?= $key ?>][<?=$extra_key?>]" required="">
                                                            <?php
                                                                foreach ($foodExtras as $foodExtras_key => $foodExtras_value) { ?>
                                                                    <option value="<?= $foodExtras_value->extra_id?>" <?= $extra_id == $foodExtras_value->extra_id ? "selected" : ""  ?>><?= $foodExtras_value->food_extra_name_french?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </td>
                                                    <td class="pl-3 extra_price">
                                                        <input type="number" name="extra_price[<?= $key ?>][<?=$extra_key?>]" class="form-control" placeholder="Extra Price" data-extra-id="[<?=$extra_key?>]" min="0" step="0.01" value = "<?=$extra_price?>">
                                                    </td>
                                                    <td class="text-warning text-center pl-1 del-extra-price-row">
                                                        <i class="fa fa-times-circle"></i>
                                                    </td>
                                                    <td class="text-primary text-center pl-1 add-extra-price-row">
                                                        <i class="fa fa-plus"></i>
                                                    </td>
                                                </tr>
                                        <?php }else{
                                            } 
                                        }
                                    endforeach;?>
                                </tbody>
                            </table>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-12">
                                <label><?= $this->lang->line("Item Description")?></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="<?= $flag_src[$section_lang]?>" ></span>
                                    </div>
                                    <?php 
                                        $item_desc_field = "item_desc_" . $section_lang; 
                                        $item_desc = $itemDetails->$item_desc_field;
                                    ?>
                                    <textarea class="form-control form-control-user summernote"  rows="5" name="item_desc"><?=$item_desc?></textarea>
                                </div>
                            </div>
                        </div>
                        <input type="submit"  value="<?= $this->lang->line("Update Data")?>" class="btn btn-primary btn-user btn-block">
            
                    
                    </form>
                    <hr>
                    
                    </div>
                </div>
                </div>
            </div>
        </div>

    </div>
    <script>
        $(document).on('submit','#updateItemDetails',function(e){
            e.preventDefault();
            var formData= new FormData($(this)[0]);
            $.ajax({
                url:"<?=base_url('API/updateItemDetails')?>",
                type:"post",
                processData:false,
                cache:false,
                contentType:false,
                enctype:"multipart/form-data",
                data:formData,
                success:function(response){
                    
                    response=JSON.parse(response);
                    if(response.status==1){
                    swal("<?=$this->lang->line("Great..")?>","<?=$this->lang->line("Data Updated Successfully.")?>","<?=$this->lang->line("success")?>");
                    }else{
                    swal("<?=$this->lang->line("Ooops..")?>","<?=$this->lang->line("Something went wrong")?>","<?=$this->lang->line("error")?>");
                    }
                    setInterval(function(){
                    location.reload();
                    },1500);
                }
            })
        });
        $(document).on('submit','#updateItemImage',function(e){
            e.preventDefault();
            var formData= new FormData($(this)[0]);
            $.ajax({
            url:"<?=base_url('API/updateItemImage')?>",
            type:"post",
            processData:false,
            cache:false,
            contentType:false,
            enctype:"multipart/form-data",
            data:formData,
            success:function(response){
                //console.log(response);
                response=JSON.parse(response);
                if(response.status=="1"){
                swal("Great..","Image Updated Successfully.","success");

                }else{
                swal("<?=$this->lang->line("Ooops..")?>","<?=$this->lang->line("Something went wrong")?>","<?=$this->lang->line("error")?>");
                }
                setInterval(function(){
                location.reload();
                },1500);
            }
            })
        });
        $(document).on('click','.del-price-row',function(e){
            var row = $(this).parent();
            id = row.attr("data-id");
            if(id == "0"){
                row.find(".item_price_title input").val("");
                row.find(".item_price input").val("");
            }else{
                row.remove();
            }
        });
        $(document).on('click','.add-price-row',function(e){
            var row = $(this).parent();
            id = row.attr("data-id");
            var first_row = $(".price-table .price-row").first();
            var last_row = $(".price-table .price-row").last();
            var placeholder_ptitle = (first_row.find(".item_price_title input").attr("placeholder"));
            var placeholder_price = (first_row.find(".item_price input").attr("placeholder"));
            lang = $('.language-panel_ a.active').attr("data-lang");
            console.log(lang);
            new_row_id = parseInt(last_row.attr("data-id")) + 1;
            new_row ='';
            new_row +='<tr class="price-row" data-id = "'+ new_row_id +'">';
            new_row +='<td class="item_price_title input-group">';
            new_row +='<input type="text" name="price_title[]" class="require_field  form-control checkit" placeholder="'+placeholder_ptitle+'" data-id = "'+ new_row_id +'" >';
            new_row +='</td>';
            new_row +='<td class="pl-3 item_price">';
            new_row +='<input type="number" name="price[]" class="require_field form-control" placeholder="'+placeholder_price+'" data-id = "'+ new_row_id +'" min = "0" step = "0.01">';
            new_row +='<td class="text-danger text-center pl-1 del-price-row" ><i class="fa fa-times-circle"></i></td>';
            new_row +='<td class="text-success text-center pl-1 add-price-row"><i class="fa fa-plus"></i></td>';
            new_row +='</tr>';
            new_row =''; 

            new_row +='<tr class="price-row" data-id = "'+ new_row_id +'">';
            new_row +='<td class="item_price_title input-group align-center english-field pt-3 ';
            new_row += (lang == "english") ? '' : 'hide-field'; 
            new_row+= '">';
            new_row +='<div class="input-group-prepend">';
            new_row +='<span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/en-flag.png')?>"></span>';
            new_row +='</div>';
            new_row +='<input type="text" name="price_title' + '_english['+ new_row_id +']" class="form-control" placeholder="'+placeholder_ptitle+'" data-id = "'+ new_row_id +'" >';
            new_row +='</td>';
            new_row +='<td class="item_price_title input-group align-center french-field pt-3 ';
            new_row += (lang == "french") ? '' : 'hide-field'; 
            new_row+= '">';
            new_row +='<div class="input-group-prepend">';
            new_row +='<span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/fr-flag.png')?>"></span>';
            new_row +='</div>';
            new_row +='<input type="text" name="price_title' + '_french['+ new_row_id +']" class="form-control" placeholder="'+placeholder_ptitle+'" data-id = "'+ new_row_id +'" >';
            new_row +='</td>';
            new_row +='<td class="item_price_title input-group align-center germany-field pt-3 ';
            new_row += (lang == "germany") ? '' : 'hide-field'; 
            new_row+= '">';
            new_row +='<div class="input-group-prepend">';
            new_row +='<span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/ge-flag.png')?>"></span>';
            new_row +='</div>';
            new_row +='<input type="text" name="price_title' + '_germany['+ new_row_id +']" class="form-control" placeholder="'+placeholder_ptitle+'" data-id = "'+ new_row_id +'" >';
            new_row +='</td>';
            new_row +='<td class="pl-3 pt-3 item_price"><input type="number" name="item_price' + '['+ new_row_id +']" class="form-control" placeholder="'+placeholder_price+'"  data-id = "'+ new_row_id +'" min = "0" step = "0.01"></td>';
            new_row +='<td class="text-danger text-center pl-1 pt-3 del-price-row" ><i class="fa fa-times-circle"></i></td>';
            new_row +='<td class="text-success text-center pl-1 pt-3 add-price-row"><i class="fa fa-plus"></i></td>';
            new_row +='</tr>';
            $(".price-table").append(new_row);
        });
        $(document).on('change','#item_cat_type',function(){
            var cat_type_id= $(this).val();
            var category = $("#item_category_id");
            var sub_category = $("#sub_category_id");
            var section_lang = $("#section_lang").val();
            $.ajax({
                url:"<?=base_url('API/getAllCategory')?>",
                type:"post",
                data:{cat_type_id:cat_type_id},
                success:function(response){
                    response=JSON.parse(response);
                    if(response.data.length>0){
                        category.empty();
                        sub_category.empty();
                        sub_category.trigger("chosen:updated");
                        var cat = '';
                        category.append(cat);
                        for(let i=0; i<response.data.length; i++){
                            if (section_lang=="french"){
                                category_name = response.data[i].category_name_french;
                            }else if (section_lang=="germany"){
                                category_name = response.data[i].category_name_germany;
                            }else{
                                category_name = response.data[i].category_name_english;
                            }
                            cat = '<option value="' + response.data[i].category_id + '">' + category_name+'</option>';
                            category.append(cat);
                        }
                        if (response.data.length > 0){
                            category.attr('disabled',false);
                        }
                    }   
                }
            });
        });
        $(document).on('change','#item_category_id',function(){
            var category_id= $(this).val();
            var sub_category = $("#sub_category_id");
            var section_lang = $("#section_lang").val();
            $.ajax({
                url:"<?=base_url('API/getAllSubCategory')?>",
                type:"post",
                data:{category_id:category_id},
                success:function(response){
                    response=JSON.parse(response);
                    if(response.data.length>0){
                        sub_category.empty();
                        var subCat = '';
                        sub_category.append(subCat);
                        for(let i=0; i<response.data.length; i++){
                            if (section_lang=="french"){
                                sub_category_name = response.data[i].sub_category_name_french;
                            }else if (section_lang=="germany"){
                                sub_category_name = response.data[i].sub_category_name_germany;
                            }else{
                                sub_category_name = response.data[i].sub_category_name_english;
                            }
                            subCat = '<option value="' + response.data[i].sub_cat_id + '">' + sub_category_name+'</option>';
                            sub_category.append(subCat);
                            
                            sub_category.trigger("chosen:updated");
                        }
                        if (response.data.length > 0){
                            sub_category.attr('disabled',false);
                        }
                    }   
                }
            });
        });
    </script>
    <script>
        $(document).on('click','.deleter',function(){
            var menu_id=$(this).attr("menu_id");
            if(confirm("Are you sure to delete this image?")){
                $.ajax({
                    type:'POST',
                    data:{
                        menu_id:menu_id
                    },
                    url:'<?=base_url('API/deleteItemImage')?>',
                    success:function(response){
                        var response = JSON.parse(response);
                        if(response.status=="1"){
                            swal("<?=$this->lang->line("Success")?>","<?=$this->lang->line("Image Deleted Successfully")?>","<?=$this->lang->line("success")?>");
                            location.reload();
                        }
                        else{
                            swal("<?=$this->lang->line("Ooops..")?>","<?=$this->lang->line("Something went wrong")?>","<?=$this->lang->line("error")?>");
                        }
                    }
                })
            }
        })
    </script>
