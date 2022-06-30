    <div class="frost-wrap d-flex j-checkout" id="user-checkout" data-rest-slug = "<?= $rest_url_slug?>" data-menu-mode = "<?= $menu_mode?>">
        <div class="right-side wish-list-section px-3 box-shadow" >
            <?php 
                if ($site_lang == "" ) {
                    $page_lang ="english";
                }else{
                    $page_lang =$site_lang;
                }
            ?>
            <div class="right-side-wrap j-custom-scroll-bar">
                <section class="my-5">
                    <div class="row px-3">
                        <div class="px-3 text-center align-middle w-100 py-2 wishlist_tab_panel">
                            <a class="cattypebtn w-100"><?= $mode == "table" ? $this->lang->line("My Wishlist") :  $this->lang->line("My Cart")?></a>
                        </div>
                    </div>
                </section>
                <div class="tab-content">
                    <?php
                        if($mode == "table"){ ?>
                        <?php }else{ ?>
                            <!-- Delivery or Pickup -->
                            <section class="container my-3 panel-section px-0 <?= $mode ?>-section" data-lang="<?=$page_lang?>">
                                <div class="menuList">
                                    <table class="table w-100" id="item-menu-table">
                                        <tbody>
                                        <?php
                                            $empty_item = true;
                                            $total_cart = 0 ;
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
                                                                        $item_extra_str .= "<span class='wishlist-food-extra' data-extra-id='".$extra_food->extra_id."'>". $extra_name .$comma ."</span><b class='wishlist-food-extra-price hide-field' data-extra-price = '". $extra_price."'> : " . $extra_price  . "$currentRestCurrencySymbol</b>";
                                                                        $extra_price_value += floatval($extra_price);
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    }
                                                    if (($mode == "Delivery" && $item->item_show_on % 2 == 1) || ($mode == "Pickup" && $item->item_show_on > 1)){
                                                        if (isset($food_tax_list[$item->item_tax_id])){
                                                            $food_tax_list[$item->item_tax_id] +=  (floatval($item_price) + $extra_price_value) * intval($cart_qty[ $item_key]);
                                                        }else{
                                                            $food_tax_list[$item->item_tax_id] =  (floatval($item_price) + $extra_price_value) * intval($cart_qty[ $item_key]);
                                                        }
                                                    }
                                                    if (($mode == "Delivery" && $item->item_show_on % 2 == 1) || ($mode == "Pickup" && $item->item_show_on > 1)){
                                                        $total_cart += (floatval($item_price) + $extra_price_value) * intval($cart_qty[ $item_key]);
                                                        $is_disabled_delivery_class = '';
                                                        $is_disabled_delivery_btn = '';
                                                    }else{
                                                        $is_disabled_delivery_class = 'delivery-disabled';
                                                        $is_disabled_delivery_btn = 'disabled';
                                                    }
                                                    
                                                ?>  
                                                    <tr data-id ="<?=$item->menu_id?>" data-base-url = "<?= base_url()?>" data-wish-index = "<?=$item_key?>" class="wish-row wish-row-<?=$item->menu_id?> <?= $is_disabled_delivery_class?>" >
                                                        <td class="text-center px-1 d-flex">
                                                            <span class="qty-field j-font-size-13px"><?= $cart_qty[ $item_key]?></span>
                                                            <span class="j-font-size-13px ml-1">x</span> 
                                                        </td>
                                                        <td class="item-name">
                                                            <p class="j-font-size-13px mb-2"><?= $item_name?></p>
                                                            <p style="font-size: 10px;color：gray;" class="mb-0"><?= $item_extra_str?></p>
                                                            
                                                        </td>
                                                        <!-- <td class="align-middle text-center">
                                                            <img class="corner-rounded-img menu-card-item-img" width="40" height="40" src="<?=base_url() .'assets/menu_item_images/'.$item->item_image?>">
                                                        </td> -->
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
                                                                <span class="price_value j-font-size-13px" style="width: 50px;"><?= floatval($item_price)+floatval($extra_price_value)?></span><span class="j-font-size-13px"><?= (floatval($item_price)+floatval($extra_price_value)) !== 0 ? " $currentRestCurrencySymbol " : ""?></span>
                                                                <span class="badge text-success delete-item ml-1">
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
                                                    // }
                                                }
                                            }
                                            if (!$empty_item) {?>
                                                <tr>
                                                    <td class="align-middle d-md-text-center pl-1 j-font-size-13px" colspan="2"><strong class="j-font-size-13px"><?=$this->lang->line("Subtotal")?></strong> ( incl Tax ) </td>
                                                    <td class="align-middle text-right px-1"><strong><span class="subtotal_price j-font-size-13px"><?= $total_cart?></span></strong> <?=$currentRestCurrencySymbol?> </td>
                                                </tr>
                                                <?php
                                                if ($total_cart > 0){
                                                    $tax_cost = 0;
                                                    foreach ( $food_tax_list as $tax_id => $tax_food_value) {
                                                        if ($tax_id !== 0){
                                                            $tax = $this->db->where("rest_id",$myRestId)->where("id",$tax_id)->get('tbl_tax_settings')->row();
                                                            $tax_cost += floatval($tax->tax_percentage) * floatval($tax_food_value) / 100; ?>
                                                            
                                                            <tr>
                                                                <td class="align-middle d-md-text-center pl-1" colspan="2"><strong class="j-font-size-13px"><?=$this->lang->line("Tax")?> ( <?=$tax->tax_percentage?>% )</strong> </td>
                                                                <td class="align-middle text-right px-1"><strong><span class="tax j-font-size-13px"><?= number_format(floatval($tax->tax_percentage) * floatval($tax_food_value) / 100, 2, '.', ' ') ?></span></strong> <?=$currentRestCurrencySymbol?> </td>
                                                            </tr>
                                                        <?php }
                                                    }
                                                }
                                                ?>
                                               
                                                <?php if ($mode == "Delivery"){ 
                                                    $delivery_cost_original = $delivery_cost;
                                                    if ($total_cart >= $min_order_amount_free_delivery){
                                                        $delivery_cost = 0;
                                                    } 
                                                    $delivery_tax_cost = $delivery_cost*$myRestDetail->delivery_tax/100 ; ?>
                                                <tr>
                                                    <td class="align-middle d-md-text-center pl-1 j-font-size-13px" colspan="2"><strong class="j-font-size-13px"><?=$this->lang->line("Delivery costs")?></strong> ( incl Tax ) </td>
                                                    <td class="align-middle text-right px-1"><strong><span class="delivery_price j-font-size-13px" data-delivery_price ="<?=$delivery_cost_original?>"><?= $delivery_cost?></span></strong> <?=$currentRestCurrencySymbol?> </td>
                                                </tr>
                                                <tr>
                                                    <td class="align-middle d-md-text-center pl-1" colspan="2"><strong class="j-font-size-13px"><?=$this->lang->line("Delivery Tax")?> ( <?= $myRestDetail->delivery_tax?>% )</strong> </td>
                                                    <td class="align-middle text-right px-1"><strong><span class="delivery_tax_price j-font-size-13px" data-tax_percentage="<?=$myRestDetail->delivery_tax?>"><?= number_format($delivery_tax_cost,2) ?></span></strong> <?=$currentRestCurrencySymbol?> </td>
                                                </tr>
                                                <?php }else{
                                                    $delivery_tax_cost = 0;
                                                }?>
                                                <tr>
                                                    <td class="align-middle d-md-text-center pl-1 j-font-size-13px" colspan="2"><strong class="j-font-size-13px"><?=$this->lang->line("Total")?></strong> ( incl Tax ) </td>
                                                    <td class="align-middle text-right px-1">
                                                        <?php 
                                                            $grand_total_no_discount = number_format($total_cart + $delivery_cost ,2) 
                                                        ?>
                                                        <strong><span class="total_price j-font-size-13px"><?= $grand_total_no_discount?></span></strong> <?=$currentRestCurrencySymbol?> 
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>   
                                    </table>
                                </div>
                                <?php if($empty_item){?>
                                    <div class="text-center mb-2">
                                        <img src="<?= base_url('assets/additional_assets/img/').'cart-img.gif' ?>" class="img-fluid" width="100">
                                        <p class = "wishlist_empty_alert mt-2" >
                                            <?= $this->lang->line("Add delicious food from the menu and place your order")?>.
                                        </p>
                                    </div>
                                <?php }else{ ?>
                                    <div class="w-100 text-center"><?= $this->lang->line("Minimum Order")?>  = <b class="minimum-order"><?= $min_order ?></b> <?=$currentRestCurrencySymbol?></div>
                                <?php }?>
                            </section>
                        <?php }
                    ?>
                </div>
            </div>
        </div>
        <div class="main-wrap  px-md-5 px-4">
            <section class="my-5">
                <div class="d-flex justify-content-between">
                    <span><h3><?=$this->lang->line("Checkout")?></h3></span>
                </div>
            </section>
            <!-- ------------------- -->
            <div class="tab-content pb-5">
                <form class="orderpay" id="orderpay" action="" method="post">
                    <?php 
                    $is_allow_guest_order = true;
                    if ( null == $this->session->userdata("customer_Data")) { 
                        if ($myRestDetail->allow_guest_order == 0){ ?>
                        <p><?= $this->lang->line("It is not allowed to order as a guest") ?>. <a class="customerlogin" href="#"><?= $this->lang->line("Login please") ?></a> ... </p>
                        <?php 
                            $is_allow_guest_order = false;
                        }else{ ?>
                            <p><?= $this->lang->line("You have already an account?") ?> <a class="customerlogin" href="#"><?= $this->lang->line("Login please") ?></a> ... <?= $this->lang->line("or order as a") ?> <a class="j-scroll-effect" href="./#orderpay"><?= $this->lang->line("Guest") ?></a></p>
                        <?php 
                        }
                    } 
                    $customer_info_address = "";
                    $customer_info_city = "";
                    $customer_info_floor = "";
                    $customer_info_postcode = "";
                    if (null !== $this->session->userdata("customer_info")){
                        $customer_info = $this->session->userdata("customer_info");
                        // print_r($customer_info['detailed_address']);
                        $customer_info_address = "" ;
                        $customer_info_address .= (array_key_exists("route", $customer_info['detailed_address']) && null !== $customer_info['detailed_address']["route"]) ? $customer_info['detailed_address']["route"] : "" ;
                        $customer_info_address .=" ";
                        $customer_info_address .=(array_key_exists("street_number", $customer_info['detailed_address']) &&  null !== $customer_info['detailed_address']["street_number"]) ? $customer_info['detailed_address']["street_number"] : "" ;
                        $customer_info_city = ( array_key_exists("locality", $customer_info['detailed_address']) && null !== $customer_info['detailed_address']["locality"]) ? $customer_info['detailed_address']["locality"] : "";
                        $customer_info_floor = "";
                        $customer_info_postcode = ( array_key_exists("postal_code", $customer_info['detailed_address']) && null !== $customer_info['detailed_address']["postal_code"]) ? $customer_info['detailed_address']["postal_code"] : "";
                    }
                    ?>
                    <input type="hidden" class="form-control form-control-user" id= "dp_option" name = "dp_option" value= "<?=$menu_mode?>">
                    <input type="hidden" class="form-control form-control-user" id= "rest_url_slug" name = "rest_url_slug" value= "<?=$rest_url_slug?>">
                    <?php if (strtolower($menu_mode) == "pickup"){ ?>
                        <h5><?= $this->lang->line("You can pickup your order here")?></h5>
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="current-rest-address mb-3">
                                    <?= $myRestDetail->address1?> <?= $myRestDetail->address2 == "" ? "" : " | " . $myRestDetail->address2 ?>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="current-rest-map mb-3" id="rest-map">
                                </div>
                            </div>
                        </div>
                    <?php }else{ ?>
                        <h5><?= $this->lang->line("Where do you want your order to be delivered")?>?</h5>
                        <hr>
                        <div class="row">
                            <div class="col-sm-6 mb-3">
                                <label><?= $this->lang->line('Address')?><span class="text-danger"> *</span></label>
                                <input type="text" class="form-control form-control-user"  placeholder="<?= $this->lang->line('Address')?>" name="address"   title="<?= $this->lang->line('Please fill in your house number')?>" value="<?= ($customer!==null && $customer ) ? $customer->customer_address : $customer_info_address ?>" required <?= $is_allow_guest_order ? "" : "disabled" ?>>
                            </div>
                            <div class="col-sm-6 mb-3">
                                <label><?= $this->lang->line('PostCode')?><span class="text-danger"> *</span></label>
                                <input type="text" class="form-control form-control-user"  placeholder="<?= $this->lang->line('PostCode')?>" name="postcode"  value="<?= ($customer !==null && $customer ) ? $customer->customer_postcode : $customer_info_postcode ?>"  required <?= $is_allow_guest_order ? "" : "disabled" ?>>
                            </div>
                            <div class="col-sm-6 mb-3">
                                <label><?= $this->lang->line('City')?><span class="text-danger"> *</span></label>
                                <input type="text" class="form-control form-control-user"  placeholder="<?= $this->lang->line('City')?>" name="city"  value="<?= ($customer!==null && $customer ) ? $customer->customer_city : $customer_info_city ?>" required <?= $is_allow_guest_order ? "" : "disabled" ?>>
                            </div>
                            <div class="col-sm-6 mb-3">
                                <label><?= $this->lang->line('Floor')?></label>
                                <input type="text" class="form-control form-control-user"  placeholder="<?= $this->lang->line('Floor')?>" name="floor" value="<?= ($customer!==null && $customer ) ? $customer->customer_floor : $customer_info_floor ?>" <?= $is_allow_guest_order ? "" : "disabled" ?>>
                            </div>
                        </div>
                    <?php } ?>
                    
                    <h5 class="mt-5"><?= $this->lang->line("How can we reach you")?>?</h5>
                    <hr>
                    <div class="row">
                        <div class="col-sm-6 mb-3">
                            <label><?= $this->lang->line('Name')?><span class="text-danger text-capitalize"> * (<?= $this->lang->line("doorbell")?>)</span></label>
                            <input type="text" class="form-control form-control-user"  placeholder="<?= $this->lang->line('Name')?>" name="name" value="<?= ($customer!==null && $customer ) ? $customer->customer_name : "" ?>" required <?= $is_allow_guest_order ? "" : "disabled" ?>>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <label><?= $this->lang->line('E-Mail')?><span class="text-danger"> *</span></label>
                            <input type="email" class="form-control form-control-user"  placeholder="<?= $this->lang->line('E-Mail')?>" name="email" value="<?= ($customer!==null && $customer ) ? $customer->customer_email : "" ?>" required <?= $is_allow_guest_order ? "" : "disabled" ?>>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <label><?= $this->lang->line('Phone Number')?><span class="text-danger"> *</span></label>
                            <input type="text" class="form-control form-control-user"  placeholder="<?= $this->lang->line('Phone Number')?>" name="phone"  value="<?= ($customer!==null && $customer ) ? $customer->customer_phone : "" ?>" required <?= $is_allow_guest_order ? "" : "disabled" ?>>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <label><?= $this->lang->line('Company Name')?></label>
                            <input type="text" class="form-control form-control-user"  placeholder="<?= $this->lang->line('Company Name')?>" name="company_name" <?= $is_allow_guest_order ? "" : "disabled" ?>>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <label><?= $this->lang->line('Remarks')?></label>
                            <textarea class="form-control form-control-user"  placeholder="<?= $this->lang->line('Remarks')?>" name="order_remark" <?= $is_allow_guest_order ? "" : "disabled" ?>></textarea>
                        </div>
                    </div>
                    <?php if((isset($is_pre_order) && $is_pre_order == 1 && !$is_open_time) || (isset($is_open_pre_order) && $is_open_pre_order == 1 && $is_open_time)){
                    ?>
                        <section class="pre_order_section">
                            <h5 class="mt-5 text-capitalize"><?= $this->lang->line('Please choose your')?> <?=$this->lang->line($menu_mode)?> <?= $this->lang->line('Time')?></h5>
                            <hr>
                            <?php  if (null !== $this->session->userdata('customer_info')){
                                    $customer_info = $this->session->userdata('customer_info');
                                    if ($customer_info["filtered_by"] == "postcode"){
                                        $postcode_list = $this->db->where("rest_id = $myRestId and post_code = '".$customer_info["post_code"]."' ")->get("tbl_delivery_areas")->row();
                                    }
                                }
                                if ($_open_pre_order_day){
                                    if (strtolower($menu_mode) == "pickup"){
                                        $begin_time = date('H:i',strtotime('+20 minutes',strtotime($begin_time.":00")));
                                    }else{
                                        $begin_time = isset($postcode_list->delivery_time) ? date('H:i',strtotime('+'.$postcode_list->delivery_time.' minutes',strtotime($begin_time.":00"))) : date('H:i',strtotime('+20 minutes',strtotime($begin_time.":00")));
                                    }
                                }
                            ?>
                            <div class="row pre_order-wrap">
                                <div class="col-sm-6 mb-3 hide-field">
                                    <label class="text-capitalize"><?=$this->lang->line($menu_mode)?> <?= $this->lang->line('Time')?><span class="text-danger text-capitalize"> *</span></label>
                                    <input type="text" class="form-control form-control-user timepickers order_reservation_time" placeholder ="22:30" <?= $is_open_time ? "disabled" : "" ?> autocomplete="off" data-min_time = "<?= isset($_open_pre_order_day) && $_open_pre_order_day ? $begin_time : "00:00" ?>" data-max_time = "<?= isset($_open_pre_order_day) && $_open_pre_order_day ? $end_time : "23:59" ?>" data-open_pre_order = "<?= $_open_pre_order_day ?>" >
                                    <input type="hidden" class="form-control form-control-user is_pre_order" name="is_pre_order"  value="<?= $is_pre_order?>" <?= $is_open_time ? "disabled" : "" ?>>
                                </div>
                                <div class="col-sm-6 mb-3">
                                    <label class="text-capitalize"><?=$this->lang->line($menu_mode)?> <?= $this->lang->line('Time')?><span class="text-danger text-capitalize"> *</span></label>
                                    <select class="form-control order_reservation_time_real"  name="order_reservation_time"  required autocomplete="off" data-min_time = "<?= isset($_open_pre_order_day) && $_open_pre_order_day ? $begin_time : "00:00" ?>" data-max_time = "<?= isset($_open_pre_order_day) && $_open_pre_order_day ? $end_time : "23:59" ?>" data-open_pre_order = "<?= $_open_pre_order_day ?>" data-time_min_interval="15">
                                        <?php
                                            if ($is_open_time){
                                                echo '<option value="asap" selected> As soon as possible</option>';
                                            }else{
                                                echo '<option value=""> Please Select</option>';
                                            }
                                            $current = isset($_open_pre_order_day) && $_open_pre_order_day ? strtotime($begin_time) : strtotime('00:00');
                                            $end = isset($_open_pre_order_day) && $_open_pre_order_day ? strtotime($end_time) : strtotime('23:59') ;
                                            $interval = "+15 minutes";
                                            if ($_open_pre_order_day){
                                                while ($current <= $end) {
                                                    $time = date('H:i', $current);
                                                    echo "<option value=".$time.">" . date('H:i', $current) .'</option>';
                                                    // echo "<option value=".$time.">" . date('h.i A', $current) .'</option>';
                                                    $current = strtotime($interval, $current);
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                                <?php if (!$_open_pre_order_day){ ?>
                                <div class="col-sm-6 mt-3 pre_order_note p-2">
                                    <label class="mt-0">Today It is too late to process your order, We will process it as soon as we open later.</label>
                                </div>
                                <?php } ?>
                            </div>
                        </section>
                    <?php } ?>
                    <?php if ($is_allow_guest_order){ ?>
                        <section>
                            <h5 class="mt-5"><?= $this->lang->line("How would you like to pay")?>?</h5>
                            <hr>
                            <div class="row">
                                <div class="col-sm-6 mb-3 d-block d-md-none">
                                    <?php
                                        $credit_card_door_label =  strtolower($menu_mode) == "pickup" ? "Creditcard at Pickup": "Creditcard on the Door";
                                    ?>
                                    <select class="form-control form-control-user" name="payment_method" id="payment_method" required>
                                        <?= strpos($payment_settings->payment_method,'c') >-1 ? '<option value="cash" data-payment = "cash">'.$this->lang->line("Cash").'</option>' : ''?>
                                        <?= strpos($payment_settings->payment_method,'s') >-1 ? '<option value="stripe" data-payment = "visa">Visa</option>' : ''?>
                                        <?= strpos($payment_settings->payment_method,'s') >-1 ? '<option value="stripe" data-payment = "mastercard">Mastercard</option>' : ''?>
                                        <?= strpos($payment_settings->payment_method,'s') >-1 ? '<option value="stripe" data-payment = "american-express">American Express</option>' : ''?>
                                        <?= strpos($payment_settings->payment_method,'p') >-1 ? '<option value="paypal" data-payment = "paypal">Paypal</option>' : ''?>
                                        <?= strpos($payment_settings->payment_method,'d') >-1 ? '<option value="creditcard_on_the_door" data-payment = "creditcard-on-the-door">'.$credit_card_door_label.'</option>' : ''?>
                                    </select>
                                </div>
                                <div class="col-sm-12 mb-3 d-md-block d-none">
                                    <div class="j-payment-method-list">
                                        <?= strpos($payment_settings->payment_method,'c') >-1 ? '<div class="j-payment-method payment-cash j-selected" data-payment = "cash">Cash</div>' : ''?>
                                        <?= strpos($payment_settings->payment_method,'s') >-1 ? '<div class="j-payment-method payment-visa" data-payment = "visa">Visa</div>' : ''?>
                                        <?= strpos($payment_settings->payment_method,'s') >-1 ? '<div class="j-payment-method payment-mastercard" data-payment = "mastercard">Mastercard</div>' : ''?>
                                        <?= strpos($payment_settings->payment_method,'s') >-1 ? '<div class="j-payment-method payment-american-express" data-payment = "american-express">American Express</div>' : ''?>
                                        <?= strpos($payment_settings->payment_method,'p') >-1 ? '<div class="j-payment-method payment-paypal" data-payment = "paypal">Paypal</div>' : ''?>
                                        <?= strpos($payment_settings->payment_method,'d') >-1 ? '<div class="j-payment-method payment-creditcard-on-the-door" data-payment = "creditcard-on-the-door">'.$credit_card_door_label.'</div>' : ''?>
                                    </div>
                                </div>
                            </div>
                        </section>
                        <?php
                            $loyalty_points = 0;
                            if (isset($loyalty_point_setting) && $loyalty_point_setting && $loyalty_point_setting->status == "enable"){
                                if (isset($user_id)){
                                    $customer_point = $this->db->where("rest_id",$myRestId)->where("user_id",$user_id)->get("tbl_customer_loyalty_points")->row();
                                    if ($customer_point){
                                        $loyalty_points = $customer_point->loyalty_points; 
                                    }
                                    if ($loyalty_point_setting->earn_conversion_rate > 0 && isset($grand_total_no_discount )){
                                        $points_earning = $grand_total_no_discount * $loyalty_point_setting->earn_conversion_rate;
                                    }else{
                                        $points_earning = 0;
                                    }
                                    if ($loyalty_point_setting->earn_rounding_mode == "on"){
                                        $points_earning = round($points_earning+0.5);
                                    }else{
                                        $points_earning = round($points_earning-0.5);
                                    }
                                    ?>
                                    <section>
                                        <h5 class="mt-5"><?= $this->lang->line("Discount")?> <span class="small ml-3"><?= $this->lang->line("You have") ?> <?= $loyalty_points ?> <?= $this->lang->line("Points")?></span> <span class="small ml-3"><?= $this->lang->line("You will get") ?> <strong><?= $points_earning ?></strong> <?= $this->lang->line("Points")?></span> </h5>
                                        <hr>
                                        <div class="row mt-3">
                                            <div class="col-sm-6 mb-3">
                                                <select class="form-control form-control-user is_discount" <?= $loyalty_points > 0 ? "": "disabled" ?> name="is_discount">
                                                    <option value="no"><?= $this->lang->line("Don't use my")?> <?= $this->lang->line("Loyalty Points")?></option>
                                                    <option value="yes"><?= $this->lang->line("I want use some")?> <?= $this->lang->line("Loyalty Points")?></option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row discount_wrap hide-field">
                                            <div class="col-sm-12 mt-3">
                                                <label><b><?= $this->lang->line('How many points do you want to use')?> ?</b> (max <?= $loyalty_points ?> <?= $this->lang->line("Points")?>)</label>
                                            </div>
                                            <div class="col-sm-6 mb-3">
                                                <input type="number" class="form-control form-control-user loyalty_points" name="loyalty_points" disabled min="0" max="<?= $loyalty_points ?>" data-redemption_conversion_rate = "<?= $loyalty_point_setting->redemption_conversion_rate?>">
                                                <p class="small"><?= $this->lang->line('You want to use')?> <span class="count_loyalty_points">0</span> <?= $this->lang->line('Points')?>.<span class="discount_value_field"></span> </p>
                                            </div>
                                        </div>
                                    </section>
                                <?php }
                        } ?>
                        <section>
                            <h5 class="mt-5"><?= $this->lang->line("Would you like to tip")?>?</h5>
                            <hr>
                            <div class="row mt-3">
                                <div class="col-sm-6 mb-3">
                                    <label><input type="checkbox" name="is_tip" class="is_tip"> <?= $this->lang->line("If yes, please enter the amount")?></label>
                                </div>
                            </div>
                            <div class="row tip_wrap hide-field">
                                <div class="col-sm-6 mb-3">
                                    <label><?= $this->lang->line('Amount')?><span class="text-danger"> *</span></label>
                                    <input type="number" class="form-control form-control-user tip_amount"  placeholder="10.00" name="tip_amount" min="0" step="0.01" disabled required>
                                </div>
                                <div class="col-sm-6 mb-3">
                                    <label><?= $this->lang->line('Note')?></label>
                                    <textarea class="form-control form-control-user tip_note" name="tip_note" disabled></textarea>
                                </div>
                            </div>
                        </section>
                        <div class="row mt-5">
                            <input type="submit" name="orderpay" value='<?= $this->lang->line("ORDER AND PAY") ?>' class="btn btn-primary px-5 col-md-6 mb-md-3">
                            <!-- <a class="btn btn-info" href="<?=base_url($menu_mode)."/".$rest_url_slug ."/" . $iframe?>"> Cancel </a> -->
                        </div>
                        <p class="text-danger">By clicking ORDER AND PAY, you agree our <a href="<?=  (in_array("tc",explode(",",$myRestDetail->active_pages))) ? base_url("legal/").$rest_url_slug."/terms-conditions" : "#"?>">terms and conditions</a> and our <a href="<?= base_url("legal/").$rest_url_slug."/data-protection" ?>">privacy statement</a>.</p>

                    <?php } ?>
                        
                </form>
            </div>
        </div>

    </div>
    <section class="hide-on-website">
        <div class="row m-0 mobile_top_bar_wrap w-100  hide-field">
            <ul class="nav nav-tabs row w-100 m-0 p-0">
                <?php
                    if ($site_lang == "" ) {
                        $page_lang ="english";
                    }else{
                        $page_lang =$site_lang;
                    }
                ?>
            </ul>
        </div>
        <div class="row d-flex justify-content-around m-0 mobile_bottom_bar_wrap">
            <div class="lang-setting col-4 align-items-center">
                <!-- Nav Item - User Information -->
                <div class="pr-2">
                    <span class="mobile_bottom_bar" id="bottom_language_parent" role="button">
                        <!-- modify by Jfrost rest-->
                        <?php
                            if (explode(",",$myRestDetail->website_languages)[0] == "english"){?>
                                <img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/en-flag.png')?>">
                                <?php 
                            }elseif (explode(",",$myRestDetail->website_languages)[0] == "germany"){?>
                                <img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/ge-flag.png')?>">
                                <?php 
                            }else{?>
                                <img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/fr-flag.png')?>">
                            <?php }
                        ?>
                    </span>
                    <div class="bottom_language_child hide-field" id = "bottom_language_child">
                        <?php 
                            $website_lang_count = 0;
                            $website_languages = explode(",",$myRestDetail->website_languages);
                            foreach ($website_languages as $website_lang) { 
                                if ($website_lang == "english"){
                                    $abb_lang = "en";
                                }elseif($website_lang == "germany"){
                                    $abb_lang = "ge";
                                }else{
                                    $abb_lang = "fr";
                                }
                                $website_lang_count ++;
                                ?>
                                <div class="dropdown-divider <?= $website_lang_count == 1 ? "hide-field": ""?>"></div>
                                <a class="lang-item dropdown-item <?= $website_lang ?>-flag text-capitalize" onclick = "change_language('<?= base_url('api/change_lang') ?>','<?= $website_lang ?>')">
                                    <img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/'.$abb_lang.'-flag.png')?>">
                                    <?= $website_lang ?>
                                </a>
                        <?php } ?>
                    </div>
                </div>
                
            </div>
            <?php if ($mode == "table"){ ?>
                <div class="col-8 p-0">
                    <!-- <a class="mobile_bottom_bar text-danger wishlist-icon" href="<?= base_url('Home/wishList')."/$rest_url_slug/$iframe"?>"> -->
                    <a class="mobile_bottom_bar text-danger wishlist-icon to-wishlist-page" href="<?= base_url('Home/wishList')."/$rest_url_slug/$iframe"?>" data-href="<?= base_url('Home/wishList')."/$rest_url_slug/$iframe"?>" >
                        <span>
                            <i class="fa fa-heart"></i>
                        </span>
                        <p class="text-uppercase ml-3"><strong class="total_price"><?= $total?></strong> <?=$currentRestCurrencySymbol?> <?= $this->lang->line("My Wishlist")?></p>
                    </a>
                </div>
            <?php }else{ ?>
                <div class="col-8 p-0">
                    <a class="mobile_bottom_bar text-danger wishlist-icon to-wishlist-page" href="<?= base_url('Home/cart')."/$rest_url_slug/$mode/$iframe"?>" data-href="<?= base_url('Home/cart')."/$rest_url_slug/$mode/$iframe"?>" >
                        <span>
                            <i class="fa fa-shopping-cart"></i>
                        </span>
                        <p class="text-uppercase ml-3"><strong class="total_price"><?= $total_cart?></strong> <?=$currentRestCurrencySymbol?> <?= $this->lang->line("My Cart")?></p>
                    </a>
                </div>
            <?php } ?>
        </div>
    </section>
    <?php if (!$is_allow_guest_order){ ?>
        <script>
            $(document).ready(function() {
                $('#customerloginModal input[type="submit"]').removeAttr('disabled');
                $("#customerloginModal").modal("show");
            });
        </script>
    <?php } ?>
    <script>
        $(document).ready(function() {
            if ($("#rest-map").length >0){
                const lat = <?=$lat?>;
                const lng = <?=$lng?>;
                centerpoint = new google.maps.LatLng(lat,lng);
                var mapOptions = {
                    zoom: 13, 
                    center: centerpoint, 
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                };
                myMap = new google.maps.Map(
                    document.getElementById('rest-map'), 
                    mapOptions
                );
                marker = new google.maps.Marker({
                    position: { lat: lat, lng: lng },
                    // myMap,
                    title: "<?= $myRest->rest_name?>",
                });
                marker.setMap(myMap);
            }
        });
    </script>