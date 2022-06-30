    <!-- modify by Jfrost -->
    <section class="container my-5">
        <div class="row">
            <div class="d-flex align-items-center col-6">
                <ul class="nav nav-tabs">
                    <?php
                        if ($site_lang == "" ) {
                            $page_lang ="english";
                        }else{
                            $page_lang =$site_lang;
                        }
                        $type_title_field  = "type_title_" . $page_lang;
                    ?>
                </ul>
            </div>
            <!-- modify by Jfrost rest-->
            <div class="col-6 row justify-content-end pl-0">
                <ul class="lang-setting d-flex align-items-center hide-field">
                    <!-- Nav Item - User Information -->
                    <li class="nav-item dropdown no-arrow">
                        <a class="nav-link p-1 nav-icon-j" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <!-- modify by Jfrost rest-->
                            <?php
                                if ($this->session->userdata('site_lang') == "english"){?>
                                    <img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/en-flag.png')?>">
                                    <?php 
                                }elseif ($this->session->userdata('site_lang') == "germany"){?>
                                    <img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/ge-flag.png')?>">
                                    <?php 
                                }else{?>
                                    <img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/fr-flag.png')?>">
                                <?php }
                            ?>
                            <!-- ------------------ -->
                        </a>
                        <!-- Dropdown - User Information -->
                        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                            <a class="dropdown-item french-flag hide-field" onclick = "change_language('<?= base_url('api/change_lang') ?>','french')">
                                <img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/fr-flag.png')?>">
                                French
                            </a>
                            <div class="dropdown-divider french-flag hide-field"></div>
                            <a class="dropdown-item germany-flag hide-field" onclick = "change_language('<?= base_url('api/change_lang') ?>','germany')">
                                <img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/ge-flag.png')?>">
                                Germany
                            </a>
                            <div class="dropdown-divider germany-flag hide-field"></div>
                            <a class="dropdown-item english-flag hide-field" onclick = "change_language('<?= base_url('api/change_lang') ?>','english')">
                                <img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/en-flag.png')?>">
                                English
                            </a>
                        </div>
                    </li>
                </ul>
                <div class="d-flex align-items-center justify-content-center text-success nav-icon-j ml-2">
                    <a href="<?=base_url($menu_mode)."/".$rest_url_slug ."/" . $iframe?>" class="close-back-btn">
                        <span class="d-none d-lg-block"><i class="fa fa-arrow-left"></i></span>
                        <span class="d-block d-sm-none p-1"><?=$this->lang->line("Back to Menu")?></span>
                    </a>
                </div>
            </div>
        </div>
    </section>
    <!-- ------------------- -->
    
    <div class="tab-content basket-page">
    <?php 
        $category_name_field = "category_name_".$page_lang;
    ?>
        <section class="container my-3 panel-section " data-lang="<?=$page_lang?>">
            <div class="menuList_ table-responsive">
                <div>
                    <div class="w-100">
                        <input type="radio" name="dp_option" value="Delivery" id="delivery_option" <?= $menu_mode == "Delivery" ? "checked" : "" ?>>
                        <label for="delivery_option"><?= $this->lang->line("Delivery")?></label>
                    </div>
                    <div class="w-100">
                        <input type="radio" name="dp_option" value="Pickup" id="pickup_option" <?= $menu_mode == "Pickup" ? "checked" : "" ?>>
                        <label for="pickup_option"><?= $this->lang->line("Pickup")?></label>
                    </div>
                </div>
                <table class="table w-100" id="item-menu-table">
                    <tbody>
                    <?php
                        $empty_item = true;
                        $total = 0 ;
                        $food_tax_list = array();
                        foreach ($cart_item_details as $item_key => $item) {
                            if ($item !== null){

                                $item_name_field = "item_name_" . $page_lang;
                                $item_prices_title_field = "item_prices_title_" . $page_lang;
                                $item_name = $item->$item_name_field == "" ? $item->item_name : $item->$item_name_field;
                                $price_index = $cart_price[ $item_key];
                                $item_price_title =  $item->$item_prices_title_field == "" ? "" : explode(",",$item->$item_prices_title_field)[$price_index];
                                $item_price_title =  ($item->item_prices_title == "") ? "" : ($item_price_title == "" ? explode(",",$item->item_prices_title)[$price_index] : $item_price_title);
                                $item_price = $item->item_prices == "" ? "" :explode(",",$item->item_prices)[$price_index];
                                
                                $item_extra_str = "";
                                $extra_price_value = 0;
                                if ($item->item_food_extra !== "" && $item->item_food_extra !== null ){
                                    $item_extra = explode("|",$item->item_food_extra)[$price_index];
                                    // $item_extra_arr = explode(",",$item_extra);
                                    $item_extra_p = explode("|",$item->item_food_extra)[$price_index];
                                    if ($item_extra_p !== "" && $item_extra_p !== null ){
                                        $item_extra_p_arr = explode(";",$item_extra_p);
                                        $item_extra_arr = array();
                                        foreach ($item_extra_p_arr as $ipkey => $ipvalue) {
                                            if (isset(explode("->",$ipvalue)[1])){
                                                $item_extra_arr = array_merge($item_extra_arr,explode(",",explode("->",$ipvalue)[1]));
                                            }else{
                                                $item_extra_arr = array_merge($item_extra_arr,explode(",",explode("->",$ipvalue)[0]));
                                            }
                                        }
                                        $ex_a_i = 0;
                                        foreach ($item_extra_arr as $ekey => $evalue) {
                                            if ($evalue !== ""){
                                                $extra_id = explode(":",$evalue)[0];
                                                $extra_price = explode(":",$evalue)[1];
                                                if (in_array($extra_id,$carts_item_extra_array[$item_key])){
                                                    $ex_a_i = $ex_a_i + 1;
                                                    if ($ex_a_i > sizeof($carts_item_extra_array[$item_key])-1){
                                                        $comma = "";
                                                    }else{
                                                        $comma = " , ";
                                                    }
                                                    $extra_food = $this->db->query("select * from tbl_food_extra where extra_id = $extra_id")->row();
                                                    $extra_name_field = "food_extra_name_" . $page_lang;
                                                    $extra_name = $extra_food->$extra_name_field == "" ? $extra_food ->food_extra_name : $extra_food->$extra_name_field;
                                                    $item_extra_str .= "<span class='wishlist-food-extra' data-extra-id='".$extra_food->extra_id."'>". $extra_name .$comma . "</span><b class='wishlist-food-extra-price hide-field' data-extra-price = '". $extra_price."'> : " . $extra_price  . "  $currentRestCurrencySymbol</b>";
                                                    $extra_price_value += floatval($extra_price);
                                                }
                                            }
                                        }
                                    }
                                }
                                $mode = $menu_mode;
                                if (($mode == "Delivery" && $item->item_show_on % 2 == 1) || ($mode == "Pickup" && $item->item_show_on > 1)){
                                    if (isset($food_tax_list[$item->item_tax_id])){
                                        $food_tax_list[$item->item_tax_id] +=  (floatval($item_price) + $extra_price_value) * intval($cart_qty[ $item_key]);
                                    }else{
                                        $food_tax_list[$item->item_tax_id] =  (floatval($item_price) + $extra_price_value) * intval($cart_qty[ $item_key]);
                                    }
                                }
                                
                                if (($mode == "Delivery" && $item->item_show_on % 2 == 1) || ($mode == "Pickup" && $item->item_show_on > 1)){
                                    $total += (floatval($item_price) + $extra_price_value) * intval($cart_qty[ $item_key]);
                                    $is_disabled_delivery_class = '';
                                    $is_disabled_delivery_btn = '';
                                }else{
                                    $is_disabled_delivery_class = 'delivery-disabled';
                                    $is_disabled_delivery_btn = 'disabled';
                                }
                            ?>  
                                <tr data-id ="<?=$item->menu_id?>" data-base-url = "<?= base_url()?>" data-wish-index = "<?=$item_key?>" class="wish-row wish-row-<?=$item->menu_id?>  <?= $is_disabled_delivery_class?>">
                                    <td class="text-center px-1">
                                        <div class="d-flex">
                                            <span class="qty-field j-font-size-13px"><?= $cart_qty[ $item_key]?></span>
                                            <span class="j-font-size-13px ml-1">x</span> 
                                        </div>
                                    </td>
                                    <td class="item-name">
                                        <p class="j-font-size-13px mb-2"><?= $item_name?></p>
                                        <p style="font-size: 10px;color：gray;" class="mb-0"><?= $item_extra_str?></p>
                                        
                                    </td>
                                    <td class="align-middle text-center d-none d-md-block">
                                        <img class="corner-rounded-img menu-card-item-img" width="40" height="40" src="<?=base_url() .'assets/menu_item_images/'.$item->item_image?>">
                                    </td>
                                    <td class="text-right px-0">
                                        <?php if (($mode == "Delivery" && $item->item_show_on % 2 == 1) || ($mode == "Pickup" && $item->item_show_on > 1)){
                                            ?>
                                            <b class="m-0 price-field" data-price-index = "<?=$price_index?>">
                                                <span class="text-center j-font-size-13px mr-1" style="max-width: 100px"><?= $item_price_title?></span>
                                            </b>
                                            <div class="d-flex mt-2 justify-content-end">
                                                <span class="badge border qty-plus ml-1">
                                                    <i class="fa fa-plus j-font-size-8px"> </i>
                                                </span>
                                                <span class="badge border qty-minus ml-1">
                                                    <i class="fa fa-minus j-font-size-8px"> </i>
                                                </span>
                                                <span class="price_value j-font-size-13px" style="width: 100px;"><?= $item_price+$extra_price_value?></span><span class="j-font-size-13px"><?= $item_price+$extra_price_value !== 0 ? " $currentRestCurrencySymbol " : ""?></span>
                                                <span class="badge text-danger delete-item ml-1">
                                                    <i class="fa fa-trash j-font-size-13px"> </i>
                                                </span>
                                            </div>
                                        <?php }else{ ?>
                                            <span class="badge">
                                                Only <?= $mode == "Delivery" ? "Pickup" : "Delivery" ?>
                                            </span>
                                        <?php } ?>
                                    </td>
                                </tr>
                                <?php
                                $empty_item = false;
                            }
                        }
                        if (!$empty_item) {?>
                            <tr>
                                <td class="align-middle d-md-text-center pl-1" colspan="2"><strong class="j-font-size-13px"><?=$this->lang->line("Subtotal")?></strong> ( incl Tax ) </td>
                                <td class="align-middle d-none d-md-block"></td>
                                <td class="align-middle text-right px-1 j-font-size-13px"><strong><span class="subtotal_price j-font-size-13px"><?= $total?></span></strong> <?=$currentRestCurrencySymbol?> </td>
                            </tr>
                            <?php
                            if ($total > 0){
                                $tax_cost = 0;
                                foreach ( $food_tax_list as $tax_id => $tax_food_value) {
                                    if ($tax_id !== 0){
                                        $tax = $this->db->where("rest_id",$myRestId)->where("id",$tax_id)->get('tbl_tax_settings')->row();
                                        $tax_cost += floatval($tax->tax_percentage) * floatval($tax_food_value) / 100; ?>
                                        
                                        <tr>
                                            <td class="align-middle d-md-text-center pl-1" colspan="2"><strong class="j-font-size-13px"><?=$this->lang->line("Tax")?></strong> ( <?=$tax->tax_percentage?>% ) </td>
                                            <td class="align-middle d-none d-md-block"></td>
                                            <td class="align-middle text-right px-1"><strong><span class="tax j-font-size-13px"><?= number_format(floatval($tax->tax_percentage) * floatval($tax_food_value) / 100, 2, '.', ' ') ?></span></strong> <?=$currentRestCurrencySymbol?> </td>
                                        </tr>
                                    <?php }
                                }
                            }
                            ?>
                            <?php if ($mode == "Delivery" ){ 
                                $delivery_tax_cost = $delivery_cost*$myRestDetail->delivery_tax/100 ; ?>
                            <tr>
                                <td class="align-middle d-md-text-center pl-1" colspan="2"><strong class="j-font-size-13px"><?=$this->lang->line("Delivery costs")?></strong> ( incl Tax ) </td>
                                <td class="align-middle d-none d-md-block"></td>
                                <td class="align-middle text-right px-1"><strong><span class="delivery_price j-font-size-13px"><?= $delivery_cost?></span></strong> <?=$currentRestCurrencySymbol?> </td>
                            </tr>
                            <tr>
                                <td class="align-middle d-md-text-center pl-1" colspan="2"><strong class="j-font-size-13px"><?=$this->lang->line("Delivery Tax")?></strong> ( <?= $myRestDetail->delivery_tax?>% ) </td>
                                <td class="align-middle d-none d-md-block"></td>
                                <td class="align-middle text-right px-1"><strong><span class="delivery_price j-font-size-13px"><?= number_format($delivery_tax_cost,2) ?></span></strong> <?=$currentRestCurrencySymbol?> </td>
                            </tr>
                            <?php }?>
                            <tr>
                                <td class="align-middle d-md-text-center pl-1" colspan="2"><strong class="j-font-size-13px"><?=$this->lang->line("Total")?></strong> ( incl Tax)  </td>
                                <td class="align-middle d-none d-md-block"></td>
                                <td class="align-middle text-right px-1"><strong><span class="total_price j-font-size-13px"><?= number_format($total + $delivery_cost   ,2)?></span></strong> <?=$currentRestCurrencySymbol?> </td>
                            </tr>
                        <?php } ?>
                    </tbody>   
                </table>
                <?php if(!$empty_item){?>
                    <div class="w-100 text-center">
                        <?= $this->lang->line("Minimum Order")?>  = <b class="minimum-order"><?= $min_order ?></b> <?=$currentRestCurrencySymbol?>
                        <?php
                            if (strtolower($mode) == "delivery" && null == $this->session->userdata('customer_info')){ ?>
                                <h4 class = "wishlist_empty_alert text-danger mt-5" >
                                    Please enter your delivery address.
                                </h4>
                            <?php }else { ?>
                                <div class="w-100 mt-5"><a class="btn btn-info w-100 order-btn" href="<?= base_url("Home/checkout/$rest_url_slug/$mode/$iframe")?>" style="background: #0184FFff;color: white;">Order</a></div>
                            <?php } 
                        ?>
                    </div>
                <?php } ?>
            </div>
            <?php if($empty_item){?>
                <div class="text-center mb-2">
                    <img src="<?= base_url('assets/additional_assets/img/').'cart-img.gif' ?>" class="img-fluid" width="100">
                    <p class = "wishlist_empty_alert mt-2" >
                        <?= $this->lang->line("Add delicious food from the menu and place your order")?>.
                    </p>
                </div>
            <?php } ?>
        </section>
    </div>
      <!-- End of Main Content -->
  
<script type="text/javascript">
    $(document).on('click','.qrCode',function(){
        var element=$(this);
        element.parent().parent().parent().find('.show_Allergens').toggle();
    });
</script>
<!-- ---------------- -->
</body>
</html>