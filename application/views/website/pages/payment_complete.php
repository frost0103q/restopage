<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>My Restopage Payment Success</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Angell EYE">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <script type="text/javascript" src="https://code.jquery.com/jquery-2.2.0.min.js"></script>
    <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <style>
        #angelleye-logo { margin:10px 0; }
        thead th { background: #F4F4F4;  }
        th.center {
            text-align:center;
        }
        td.center{
            text-align:center;
        }
        #paypal_errors {
            margin-top:25px;
        }
        .general_message {
            margin: 20px 0 20px 0;
        }
        #angelleye-demo-digital-goods-success-msg {
            display:none;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="row clearfix">
        <div class="col-md-12 column">
            <div id="header" class="row clearfix">
                <div class="col-md-6 column">
                    <div id="angelleye-logo" style="margin-top: 100px;">
                    </div>
                </div>
            </div>
            <div class="h3">Thank you, we have received your order.</div>
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th class="center">Extra</th>
                    <th class="center">Price</th>
                    <th class="center">QTY</th>
                    <th class="center">Total</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $rest_id = $cart['shopping_cart']['rest_id'];
                $rest = $this->db->where("restaurant_id",$rest_id)->get('tbl_restaurant_details')->row();
                $rest_currency_id = $rest->currency_id;
                $rest_currency_symbol = $this->db->where("id",$rest_currency_id)->get('tbl_countries')->row()->currency_symbol;
                $currentRestCurrencySymbol = $rest_currency_symbol == "" ? "&#8364;" : $rest_currency_symbol;

                if (null !== $this->input->cookie('jfrost_carts')){
                    $carts_array = explode(",", $this->input->cookie("jfrost_carts"));
    
                    foreach ($carts_array as $key => $value) {
                        $cart_each_item_info = explode(":", $value);
                        $cart_each_item_id = $cart_each_item_info[0];
                        $cart_each_item_price_index = $cart_each_item_info[1];
                        $cart_each_item_price_qty = $cart_each_item_info[2];
                        $cart_each_item_extra_id = $cart_each_item_info[3];
    
                        $carts_item_id_array[] = $cart_each_item_id;
                        $carts_item_price_array[] = $cart_each_item_price_index;
                        $carts_item_qty_array[] = $cart_each_item_price_qty;
                        $carts_item_extra_array[] = explode("|",$cart_each_item_extra_id);
                    }
                }
                $item_extra_arr = array();
                foreach($cart['shopping_cart']['items'] as $item_key => $cart_item) {
                    $item_extra_arr = explode(",",$cart_item['extra']);
                    $item_extra_str = "";
                    $ex_p = 0;
                    foreach ($item_extra_arr as $ekey => $evalue) {
                        if ($evalue !== ""){
                            $extra_id = explode(":",$evalue)[0];
                            $extra_price = explode(":",$evalue)[1];
                            if (in_array($extra_id,$carts_item_extra_array[$item_key])){
                                $extra_food = $this->db->query("select * from tbl_food_extra where extra_id = $extra_id")->row();
                                $extra_name = $extra_food ->food_extra_name;
                                $item_extra_str .= "<span class='wishlist-food-extra' data-extra-id='".$extra_food->extra_id."'>". $extra_name . "</span> : $currentRestCurrencySymbol " . $extra_price  . "<br>";
                                $ex_p += floatval($extra_price); 
                            }
                        }
                    }
                    ?>
                    <tr>
                        <td><?php echo $cart_item['id']; ?></td>
                        <td><?php echo $cart_item['name']; ?> : <?=$currentRestCurrencySymbol?> <?php echo number_format(($cart_item['price'] - $ex_p),2); ?></td>
                        <td><?php echo $item_extra_str; ?></td>
                        <td class="center"> <?=$currentRestCurrencySymbol?> <?php echo number_format($cart_item['price'],2); ?></td>
                        <td class="center"><?php echo $cart_item['qty']; ?></td>
                        <td class="center"> <?=$currentRestCurrencySymbol?> <?php echo round($cart_item['qty'] * $cart_item['price'],2); ?></td>
                    </tr>
                    <?php
                }
                ?>
                </tbody>
            </table>
            <div class="row clearfix">
                <div class="col-md-4 column">
                    <p><strong>Billing Information</strong></p>
                    <p>
                        <?php
                        if ($cart['_payment_method'] !== "cash"){
                            echo $stripe['billing_details']['city'] . ' ' . $stripe['billing_details']['country'] . '<br />' .
                                $stripe['billing_details']['line1'] . ' ' . $stripe['billing_details']['line2'] . ' ' .  $stripe['billing_details']['postal_code'] .'<br />'.
                                $stripe['billing_details']['email'] . '<br />' .
                                $stripe['billing_details']['phone'] . '<br />' .
                                $stripe['billing_details']['name'] . '<br />' .
                                $stripe['transaction_id'] . '<br />' .
                                $stripe['balance_transaction'] . '<br />' .
                                $stripe['payment_method'];
                        }
                        ?>
                    </p>
                </div>
                <div class="col-md-4 column">
                    <p><strong>Shipping Information</strong></p>
                    <p>
                        <?php
                        echo $cart['_name'] . '<br />' .
                            $cart['_address'] . '<br />' .
                            $cart['_floor'] . ', ' . $cart['_city'] . '  ' . $cart['_postcode'] . '<br />' .
                            $cart['_email']  . '<br />' .
                            $cart['_phone_number']  . '<br />' .
                            $cart['_company_name'];
                        ?>
                    </p>
                </div>
                <div class="col-md-4 column"> </div>
                <div class="col-md-4 column">
                    <table class="table">
                        <tbody>
                        <tr>
                            <td><strong> Subtotal ( incl Tax )</strong></td>
                            <td> <?=$currentRestCurrencySymbol?> <?php echo number_format($cart['shopping_cart']['subtotal'],2,".",","); ?></td>
                        </tr>
                        <?php
                            $tax_cost = 0;
                            foreach ($cart['shopping_cart']['tax'] as $tax_id => $tax_food_value) { 
                                if ($tax_id > 0 && $cart['shopping_cart']['rest_id']){
                                    $tax = $this->db->where("rest_id",$cart['shopping_cart']['rest_id'])->where("id",$tax_id)->get('tbl_tax_settings')->row();
                                    $tax_cost += floatval($tax->tax_percentage) * floatval($tax_food_value) / 100;
                                ?>
                                    <tr>
                                        <td><strong> Tax ( <?=$tax->tax_percentage ?>% )</strong></td>
                                        <td> <?=$currentRestCurrencySymbol?> <?= number_format(floatval($tax->tax_percentage) * floatval($tax_food_value) / 100, 2, '.', ' ') ?></td>
                                    </tr>
                                <?php }
                            }
                            if ($cart['_order_type'] == "Delivery"){
                                $credit_card_door_label = "Creditcard on the Door";
                        ?>
                            <tr>
                                <td><strong>Delivery ( incl Tax )</strong></td>
                                <td> <?=$currentRestCurrencySymbol?> <?php echo number_format($cart['shopping_cart']['shipping'],2,".",","); ?></td>
                            </tr>
                            <tr>
                                <?php $rest = $this->db->where("restaurant_id",$cart['shopping_cart']['rest_id'])->get('tbl_restaurant_details')->row(); ?>
                                <td><strong>Delivery Tax ( <?= $rest->delivery_tax?>% )</strong></td>
                                <td> <?=$currentRestCurrencySymbol?> <?php echo number_format($cart['shopping_cart']['shipping'] * $rest->delivery_tax /100 ,2,".",","); ?> </td>
                            </tr>
                        <?php }else{
                            $credit_card_door_label = "Creditcard at Pickup";
                        } ?>
                        <tr>
                            <td><strong>Discount</strong></td>
                            <td> <?=$currentRestCurrencySymbol?> <?php echo number_format($cart['discount'],2,".",","); ?> </td>
                        </tr>
                        <tr>
                            <td><strong>Grand Total ( incl Tax )</strong></td>
                            <td> <?=$currentRestCurrencySymbol?> <?php echo ($cart['shopping_cart']['grand_total']); ?></td>
                        </tr>
                        <tr>
                            <td><strong>Order Type</strong></td>
                            <td class="text-capitalize"><?php echo $cart['_order_type'];?></td>
                        </tr>
                        <tr>
                            <td><strong>Payment Method</strong></td>
                            <?php ?>
                            <td class="text-capitalize"><?= strtolower($cart['_payment_method']) == "creditcard_on_the_door" ? $credit_card_door_label : $cart['_payment_method'] ?></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php
                $rest_id = $this->session->userdata('current_rest_id');
                
                $rest_url_slug = $this->db->where('rest_id',$rest_id)->get('tbl_restaurant')->row()->rest_url_slug;
            ?>
            <a class="btn btn-primary" href="<?php echo site_url("view/$rest_url_slug");?>">Menu Page</a>
        </div>
    </div>
</div>
</body>
</html>