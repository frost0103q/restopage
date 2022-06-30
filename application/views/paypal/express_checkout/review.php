<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Parisienne&family=Satisfy&display=swap" rel="stylesheet">
    <style> 
    
    </style>
   
  <!-- modify by Jfrost load custom css-->
    <link href="<?=base_url('assets/additional_assets/')?>/css/mystyle.css" rel="stylesheet" type="text/css">
    <!-- <script src="Scripts/jquery-latest.min.js"></script>   -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.qrcode/1.0/jquery.qrcode.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="<?=base_url('assets/web_assets/')?>css/style.css">
    <?php 
        if($iframe == "iframe"){
            echo '<link rel="stylesheet" type="text/css" href="'. base_url('assets/additional_assets/').'css/iframe.css">';
        }
    ?>
    <title>Restaurant</title>
    </head>
    <body>
    <section class="lgblueBck" data-url="<?= base_url("/")?>" data-mode="<?= $menu_mode?>">
    <div class="card shadow  rounded-0">
        <div class="row container mx-auto px-0">
            <div class="col-sm-8 col-6">
                <?php
                if($myRestDetail->rest_logo!=""){
                    $logo=$myRestDetail->rest_logo;
                }else{
                    $logo="";
                }
                ?>
                <a class="navbar-brand" href="<?=base_url("view/$rest_url_slug/$iframe")?>"><img src="<?=base_url('assets/rest_logo/').$logo?>" alt="" class="img-fluid p-2" width="150" ></a>
            </div>
            <div class="col-sm-4 col-6 d-none justify-content-end">
                <!-- modify by Jfrost small changes -->
                <a class="navbar-brand d-flex align-items-center justify-content-center" href="<?=base_url("view/$rest_url_slug/$iframe")?>" style="float:right"><img src="<?=base_url('assets/web_assets/')?>images/restrologo.png" class="img-fluid" style="height:25px;"></a>
            </div>
        </div>
    </section>
    <!-- modify by Jfrost -->
    <section class="container my-5">
        <div class="row">
            <div class="d-flex align-items-center col-6">
                <?php
                    if ($site_lang == "" ) {
                        $page_lang ="english";
                    }else{
                        $page_lang =$site_lang;
                    }
                    $type_title_field  = "type_title_" . $page_lang;
                ?>
                <h3>Thank you, we have received your order.</h3>
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
    
    <div class="tab-content">
    <?php 
        $category_name_field = "category_name_".$page_lang;
    ?>
        <section class="container my-3 panel-section " data-lang="<?=$page_lang?>">
            <div class="menuList_ table-responsive">
                <table class="table w-100" id="item-menu-table">
                    <tbody>
                    <?php
                        $empty_item = true;
                        $total = 0 ;

                        foreach ($cart_item_details as $item_key => $item) {
                            if ($item !== null){

                                $rest_details=$this->db->where('restaurant_id',$myRestId)->get('tbl_restaurant_details')->row();
                                $rest_currency_id = $rest_details->currency_id;
                                $rest_currency_symbol = $this->db->where("id",$rest_currency_id)->get('tbl_countries')->row()->currency_symbol;
                                $rest_currency_symbol = $rest_currency_symbol == "" ? "&#8364;" : $rest_currency_symbol;

                                $item_name_field = "item_name_" . $page_lang;
                                $item_prices_title_field = "item_prices_title_" . $page_lang;
                                $item_name = $item->$item_name_field == "" ? $item->item_name : $item->$item_name_field;
                                $price_index = $cart_price[ $item_key];
                                $item_price_title =  $item->$item_prices_title_field == "" ? "" : explode(",",$item->$item_prices_title_field)[$price_index];
                                $item_price_title =  $item->item_prices_title == "" ? "" : ($item_price_title == "" ? explode(",",$item->item_prices_title)[$price_index] : $item_price_title);
                                $item_price = $item->item_prices == "" ? "" :explode(",",$item->item_prices)[$price_index];
                                
                                $item_extra_str = "";
                                $extra_price_value = 0;
                                if ($item->item_food_extra !== "" && $item->item_food_extra !== null ){
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

                                        foreach ($item_extra_arr as $ekey => $evalue) {
                                            if ($evalue !== ""){
                                                $extra_id = explode(":",$evalue)[0];
                                                $extra_price = explode(":",$evalue)[1];
                                                if (in_array($extra_id,$carts_item_extra_array[$item_key])){
                                                    $extra_food = $this->db->query("select * from tbl_food_extra where extra_id = $extra_id")->row();
                                                    $extra_name_field = "food_extra_name_" . $page_lang;
                                                    $extra_name = $extra_food->$extra_name_field == "" ? $extra_food ->food_extra_name : $extra_food->$extra_name_field;
                                                    $item_extra_str .= "<span class='wishlist-food-extra' data-extra-id='".$extra_food->extra_id."'>". $extra_name . "</span><b class='wishlist-food-extra-price' data-extra-price = '". $extra_price."'> : " . $extra_price  . $rest_currency_symbol."</b> <br>";
                                                    $extra_price_value += floatval($extra_price);
                                                }
                                            }
                                        }
                                    }
                                }
                                $total += (floatval($item_price) + $extra_price_value) * intval($cart_qty[ $item_key]);
                            ?>  
                                <tr data-id ="<?=$item->menu_id?>" data-base-url = "<?= base_url()?>" data-wish-index = "<?=$item_key?>" class="wish-row wish-row-<?=$item->menu_id?>">
                                    <td class="align-middle text-center">
                                        <span>
                                            <b class="qty-field"  style="font-size: 20px;"><?= $cart_qty[ $item_key]?></b>
                                            <i class="fa fa-times"></i></span> 
                                        <span></span>
                                    </td>
                                    <td class="align-middle item-name">
                                        <p style="font-size: 20px;" class="mb-0"><?= $item_name?></p>
                                        <p style="font-size: 10px;color：gray;" class="mb-0"><?= $item_extra_str?></p>
                                        <b class="m-0 price-field" data-price-index = "<?=$price_index?>">
                                            <span class="text-center" style="max-width: 150px"><?= $item_price_title?>:</span>
                                            <span ><strong class="price_value"><?= $item_price?><span ></strong></span><strong><?= $item_price !== "" ? $rest_currency_symbol : ""?></strong></span>
                                        </b>
                                    </td>
                                    <td class="align-middle text-center">
                                        <img class="corner-rounded-img menu-card-item-img" width="40" height="40" src="<?=base_url() .'assets/menu_item_images/'.$item->item_image?>">
                                    </td>
                                </tr>
                                <?php
                                $empty_item = false;
                            }
                        }
                    ?>
                    </tbody>   
                </table>
            </div>
            <div class="row clearfix">
                <div class="col-md-4 column">
                    <p><strong>Billing Information</strong></p>
                    <p>
                        <?php
                        echo $cart['first_name'] . ' ' . $cart['last_name'] . '<br />' .
                            $cart['email'] . '<br />'.
                            $cart['phone_number'] . '<br />';
                            if (isset($cart['paypal_transaction_id'])){
                                echo $cart['paypal_transaction_id'];
                            }
                        ?>
                    </p>
                </div>
                <div class="col-md-4 column">
                    <p><strong>Shipping Information</strong></p>
                    <p>
                        <?php
                        echo $cart['_name'] . '<br />' .
                            $cart['_email'] . '<br />' .
                            $cart['_phone_number'] . '<br />' .
                            $cart['_address'] . ', ' . $cart['_floor'] . '<br />' .
                            $cart['_city']  . '  ' . $cart['_postcode'] . '<br />' .
                            $cart['_phone_number'];
                        ?>
                    </p>
                </div>
                <div class="col-md-4 column">
                    <table class="table">
                        <tbody>
                        <tr>
                            <td><strong> Subtotal ( incl Tax )</strong></td>
                            <td> <?=$rest_currency_symbol?> <?php echo number_format($cart['shopping_cart']['subtotal'],2); ?></td>
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
                                        <td> <?=$rest_currency_symbol?> <?= number_format(floatval($tax->tax_percentage) * floatval($tax_food_value) / 100, 2, '.', ' ') ?></td>
                                    </tr>
                                <?php }
                            }
                            if ($cart['_order_type'] == "Delivery"){
                                ?>
                                <tr>
                                    <td><strong>Delivery ( incl Tax )</strong></td>
                                    <td> <?=$rest_currency_symbol?> <?php echo number_format($cart['shopping_cart']['shipping'],2); ?></td>
                                </tr>
                                <tr>
                                    <?php $rest = $this->db->where("restaurant_id",$cart['shopping_cart']['rest_id'])->get('tbl_restaurant_details')->row(); ?>
                                    <td><strong>Delivery Tax ( <?= $rest->delivery_tax?>% )</strong></td>
                                    <td> <?=$rest_currency_symbol?> <?php echo number_format($cart['shopping_cart']['shipping'] * $rest->delivery_tax /100 ,2,".",","); ?> </td>
                                </tr>
                        <?php } ?>
                        <tr>
                            <td><strong>Discount</strong></td>
                            <td> <?=$rest_currency_symbol?> <?php echo number_format($cart['discount'],2,".",","); ?> </td>
                        </tr>
                        <tr>
                            <td><strong>Grand Total ( incl Tax )</strong></td>
                            <td> <?=$rest_currency_symbol?> <?php echo number_format($cart['shopping_cart']['grand_total'],2); ?></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
      <!-- End of Main Content -->
<script type="text/javascript">
    $(document).on('click','.qrCode',function(){
        var element=$(this);
        element.parent().parent().parent().find('.show_Allergens').toggle();
    });
</script>
<!-- modify by Jfrost rest-->
<script src="<?=base_url('assets/additional_assets/')?>js/myscript.js"></script>
<!-- ---------------- -->
</body>
</html>