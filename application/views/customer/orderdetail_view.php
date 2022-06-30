<div class="content-page">
    <div class="content">

        <div class="container-fluid">
            <div class="card-box">
                <div class="">
                    <h4 class="header-title mt-0 mb-4 text-warning">Order Detail</h4>
                    <div class="">
                        <div class="row  flex-row-reverse">
                            <div class="col-md-6 text-right">
                                <h4 class="Order-ID text-primary">
                                    Order ID #<span id="order_id"><?= $order->order_id?></span>
                                </h4>
                                <p class="my-1 mb-5" style="color: black"><?= $this->lang->line('Status')?> : <span id="order_status" class="text-capitalize">  <?= $order->order_status?></span></p>
                                <p class="my-1">Order Type : <span id="order_type"  class="text-capitalize">  <?= $order->order_type ?></span></p>
                                <p class="my-1"><?= $this->lang->line('Order Date')?> : <span id="order_date"> <?= date_format(date_create(explode(" ",$order->order_date)[0]),"M d Y") ?></span></p>
                                <p class="my-1"><?= $this->lang->line('Order Time')?> : <span id="order_time"> <?= date_format(date_create(explode(" ",$order->order_date)[1]),"H:i:s") ?></span></p>
                                <?php 
                                    $credit_card_door_label = strtolower($order->order_type) == "pickup" ? "Creditcard at Pickup": "Creditcard on the Door"; 
                                ?>
                                <p class="my-1"><?= $this->lang->line('Payment Mode')?> : <span id="order_payment_mode" class="text-capitalize"> <?= $order->order_payment_method == "creditcard_on_the_door" ? $credit_card_door_label : $order->order_payment_method ?></span></p>
                            </div>
                            <div class="col-md-6">
                                <!-- <p class="my-1"><?= $this->lang->line('Customer Information')?> :</p> -->
                                <p class="my-1"><?= $this->lang->line('Requested Time')?> : <span id="order_requested_time"> <?= $order->order_duration_time > 0 ? $order->order_duration_time . "mins" : "ASAP"?></span></p>
                            </div>
                        </div>
                        <div class="row my-3">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th class="text-center">#<?= $this->lang->line("Quantity")?></th>
                                            <th class="text-center"><?= $this->lang->line("Item Name")?></th>
                                            <th class="text-center"><?= $this->lang->line("Total")?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $order_item_ids = explode(",",$order->order_item_ids);
                                            $order_extra_ids = explode(",", $order->order_extra_ids);
                                            $order_qty = explode(",", $order->order_qty);
                                            $rest_currency_id = $myRestDetail->currency_id;
                                            $rest_currency_symbol = $this->db->where("id",$rest_currency_id)->get('tbl_countries')->row()->currency_symbol;
                                            $rest_currency_symbol = $rest_currency_symbol == "" ? "&#8364;" : $rest_currency_symbol;

                                            foreach ($order_item_ids as $okey => $ovalue) { 
                                                $item_id = explode(":",$ovalue)[0];
                                                $item_price_index = explode(":",$ovalue)[1];
                                                $item = $this->db->query("select * from tbl_menu_card where menu_id = $item_id")->row();
                                                if ($item){
                                                    $item_name_field = "item_name_" . $_lang;
                                                    $item_price_name_field =  "item_prices_title_" . $_lang;
                                                    $pdt_price = 0;
                                                    $extra_div = '';

                                                    if ($item_price_index == ""){
                                                        $price_title = "";
                                                        $price = "0";
                                                    }else{
                                                        $price_title = explode(",",$item->$item_price_name_field)[$item_price_index] == "" ? explode(",",$item->$item_price_name_field)[$item_price_index] : explode(",",$item->$item_price_name_field)[$item_price_index];
                                                        $price = explode(",",$item->item_prices)[$item_price_index];
                                                        $pdt_price +=  $price;
                                                        $item_food_extra = $item->item_food_extra;
                                                        if ($item_food_extra !== ""){
                                                            $evalue = explode("|",$item_food_extra)[$item_price_index];
                                                            if($evalue !== ""){
                                                                $extra_div .=" <strong>Extras</strong>";
                                                                $item_extra_p = $evalue;
                                                                if ($item_extra_p !== "" && $item_extra_p !== null ){
                                                                    $item_extra_p_arr = explode(";",$evalue);
                                                                    $item_extra_arr = array();
                                                                    foreach ($item_extra_p_arr as $ipkey => $ipvalue) {
                                                                        if (isset(explode("->",$ipvalue)[1])){
                                                                            $item_extra_arr = array_merge($item_extra_arr,explode(",",explode("->",$ipvalue)[1]));
                                                                        }else{
                                                                            $item_extra_arr = array_merge($item_extra_arr,explode(",",explode("->",$ipvalue)[0]));
                                                                        }
                                                                    }
                                                                    foreach ($item_extra_arr as $fkey => $fvalue) {
                                                                        $extra_id = explode(":",$fvalue)[0];
                                                                        if ($order_extra_ids[$okey] !== ""){
                                                                            $order_extra_ids_arr = explode("|",$order_extra_ids[$okey]);
                                                                            if (in_array($extra_id,$order_extra_ids_arr)){
                                                                                $extra_food = $this->db->query("select * from tbl_food_extra where extra_id = $extra_id")->row();
                                                                                $extra_name_field = "food_extra_name_" . $_lang;
                                                                                $extra_name = $extra_food->$extra_name_field == "" ? $extra_food ->food_extra_name : $extra_food->$extra_name_field;
                                                                    
                                                                                $extra_price = explode(":",$fvalue)[1];
                                                                                $extra_div .= "<p class='mb-1'>$extra_name : $extra_price $rest_currency_symbol</p>";
                                                                                $pdt_price += $extra_price;
                                                                            }
                                                                        }
                                                                    } 
                                                                }
                                                            }
                                                        }
                                                    }
                                                    ?>
                                                    <tr>
                                                        <td class="text-center bg-primary" style="color:white"><span><?= $order_qty[$okey]?></span> x</td>
                                                        <td class="text-center" style="background:#80808038;color:black;"><?= $item->$item_name_field == "" ? $item->item_name : $item->$item_name_field ?> | <?= $price_title ?> : <?= $price ?> <?= $rest_currency_symbol?> <br> <?= $extra_div?></td>
                                                        <td class="text-center bg-primary" style="color:white;"><?= number_format($pdt_price * $order_qty[$okey],2)?> <?= $rest_currency_symbol?></td>
                                                    </tr>
                                                <?php }else{ ?>
                                                    <tr>
                                                        <td class="text-center bg-primary" style="color:white"><span><?= $order_qty[$okey]?></span> x</td>
                                                        <td class="text-center bg-warning" ><span>This Item is removed from Dashboard</span></td>
                                                        <td class="text-center bg-primary" style="color:white;"> <?= $rest_currency_symbol?></td>
                                                    </tr>
                                                <?php }  
                                            }
                                        ?>
                                    
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row  flex-row-reverse">
                            <div class="col-md-6 text-right">
                                <p class="my-1"><?= $this->lang->line('Sub Total')?> ( incl Tax ) : <span id="sub_total"> <?= number_format($order->order_amount - (isset($order->order_delivery_cost) ? $order->order_delivery_cost : 0),2)?> </span><?=$rest_currency_symbol?></p>
                                <?php
                                    $tax_cost = 0;
                                    $order_tax_str = $order->order_tax;
                                    $order_tax = json_decode($order_tax_str);
                                    if (isset($order_tax->menu )){
                                        foreach ( $order_tax->menu as $tax_id => $tax_food_value) {
                                            if ($tax_id > 0){
                                                $tax = $this->db->where("rest_id",$order->order_rest_id)->where("id",$tax_id)->get('tbl_tax_settings')->row();
                                                $tax_cost += floatval($tax->tax_percentage) * floatval($tax_food_value) / 100; ?>
                                                
                                                <p class="my-1"><?= $this->lang->line('Tax')?> ( <?=$tax->tax_percentage?>% ) : <span class="order_tax"> <?= number_format(floatval($tax->tax_percentage) * floatval($tax_food_value) / 100, 2, '.', ' ') ?> </span><?=$rest_currency_symbol?></p>
                                            <?php }
                                        }
                                    }
                                    if($order->order_type == "delivery"){ ?>
                                        <p class="my-1"><?= $this->lang->line('Delivery Cost')?>  ( incl Tax ) : <span id="delivery_cost"> <?= $order->order_type == "ontable" ? "0.00" : number_format($order->order_delivery_cost,2) ?> </span><?=$rest_currency_symbol?></p>
                                        <p class="my-1"><?= $this->lang->line('Delivery Tax')?> ( <?= isset($order_tax->delivery) ? $order_tax->delivery : 0 ?>% ) : <span id="delivery_tax"> <?= isset($order_tax->delivery) ? number_format($order->order_delivery_cost * $order_tax->delivery / 100,2) : "0" ?> </span><?=$rest_currency_symbol?></p>
                                    <?php } ?>
                                <p class="my-1"><?= $this->lang->line('Discount')?>  : <span id="discount"> <?= number_format($order->order_discount,2)?>  </span><?=$rest_currency_symbol?></p>
                                <p class="my-1"><?= $this->lang->line('Total')?>  ( incl Tax ) : <span id="total"> <?= number_format($order->order_amount,2)?>  </span><?=$rest_currency_symbol?></p>
                            </div>
                            <div class="col-md-6">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

