    <!-- modify by Jfrost -->
<?php
    if ($site_lang == "" ) {
        $page_lang ="english";
    }else{
        $page_lang =$site_lang;
    }
    $type_title_field  = "type_title_" . $page_lang;

    if ($this->session->userdata('site_lang')){
        $_lang = $this->session->userdata('site_lang');
    }else{
        $_lang = "french";
    }
    if ($_lang == "english"){
        $url_surfix = "/?lang="."en";
    }elseif ($_lang == "germany"){
        $url_surfix = "/?lang="."de";
    }else{
        $url_surfix = "/?lang="."fr";
    }
?>
    <section class="container my-5">
        <div class="row">
            <?php if ($myRestDetail->resto_plan == "pro" && ($myRestDetail->dp_option % 4 !== 0)){ ?>
                <div class="d-flex align-items-center col-8">
                    <div>
                        <?= $this->lang->line("At the moment you are in our onTable Food menu")?>.
                        <?= $this->lang->line("If you want to pickup or deliver your food, please click") ?> <a href="<?= base_url("choose/").$rest_url_slug.$url_surfix ?>"><?= $this->lang->line("here")?>...</a> 
                    </div>
                </div>
            <?php } ?>
            <!-- modify by Jfrost rest-->
            <div class="col-4 row justify-content-end pl-0">
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
                <div>
                    <div class="d-flex align-items-center justify-content-center text-success nav-icon-j ml-2 py-2 px-3">
                        <a href="<?=base_url('onTable/').$rest_url_slug ."/" . $iframe.$url_surfix?>" class="close-back-btn">
                            <span class="d-block d-sm-none"><i class="fa fa-arrow-left"></i></span>
                            <span class="d-none d-sm-block"><?=$this->lang->line("Back to Menu")?></span>
                        </a>
                    </div>
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
                <table class="table w-100" id="item-menu-table">
                    <tbody>
                    <?php
                        $empty_item = true;
                        $total = 0 ;
                        $food_tax_list =  array();
                        foreach ($item_details as $item_key => $item) {
                            if ($item !== null){

                                $item_name_field = "item_name_" . $page_lang;
                                $item_prices_title_field = "item_prices_title_" . $page_lang;
                                $item_name = $item->$item_name_field == "" ? $item->item_name : $item->$item_name_field;
                                $price_index = $wish_price[ $item_key];
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
                                        $ex_a_i = 0;
                                        foreach ($item_extra_arr as $ekey => $evalue) {
                                            if ($evalue !== ""){
                                                $extra_id = explode(":",$evalue)[0];
                                                $extra_price = explode(":",$evalue)[1];
                                                if (in_array($extra_id,$wishlist_item_extra_array[$item_key])){
                                                    $ex_a_i = $ex_a_i + 1;
                                                    if ($ex_a_i > sizeof($wishlist_item_extra_array[$item_key])-1){
                                                        $comma = "";
                                                    }else{
                                                        $comma = " , ";
                                                    }
                                                    $extra_food = $this->db->query("select * from tbl_food_extra where extra_id = $extra_id")->row();
                                                    $extra_name_field = "food_extra_name_" . $page_lang;
                                                    $extra_name = $extra_food->$extra_name_field == "" ? $extra_food ->food_extra_name : $extra_food->$extra_name_field;
                                                    $item_extra_str .= "<span class='wishlist-food-extra' data-extra-id='".$extra_food->extra_id."'>". $extra_name . $comma . "</span><b class='hide-field wishlist-food-extra-price' data-extra-price = '". $extra_price."'> : " . $extra_price  . "$currentRestCurrencySymbol</b>";
                                                    $extra_price_value += floatval($extra_price);
                                                }
                                            }
                                        }
                                    }
                                }
                                if (isset($food_tax_list[$item->item_tax_id])){
                                    $food_tax_list[$item->item_tax_id] +=  (floatval($item_price) + $extra_price_value) * intval($wish_qty[ $item_key]);
                                }else{
                                    $food_tax_list[$item->item_tax_id] =  (floatval($item_price) + $extra_price_value) * intval($wish_qty[ $item_key]);
                                }
                                $total += (floatval($item_price) + $extra_price_value) * intval($wish_qty[ $item_key]);
                            ?>  
                                <tr data-id ="<?=$item->menu_id?>" data-base-url = "<?= base_url()?>" data-wish-index = "<?=$item_key?>" class="wish-row wish-row-<?=$item->menu_id?>">
                                    <td class="text-center px-1">
                                        <div class="d-flex">
                                            <span class="qty-field j-font-size-13px"><?= $wish_qty[ $item_key]?>
                                            </span>
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
                                        <b class="m-0 price-field" data-price-index = "<?=$price_index?>">
                                            <span class="text-center j-font-size-13px mr-1" style="width:100px;"><?= $item_price_title?></span>
                                        </b>
                                        <div class="d-flex mt-2  justify-content-end">
                                            <span class="badge border qty-plus ml-1">
                                                <i class="fa fa-plus j-font-size-8px"> </i>
                                            </span>
                                            <span class="badge border qty-minus ml-1">
                                                <i class="fa fa-minus j-font-size-8px"> </i>
                                            </span>
                                            <span class="price_value j-font-size-13px" style="width: 100px;"><?= $item_price + $extra_price_value?></span><span class="j-font-size-13px"><?= ($item_price+$extra_price_value) !== 0 ? " $currentRestCurrencySymbol " : ""?></span>
                                            <span class="badge text-success delete-item ml-1">
                                                <i class="fa fa-trash j-font-size-13px"> </i>
                                            </span>
                                        </div>
                                    </td>
                                </tr>
                                <?php
                                $empty_item = false;
                            }
                        }
                        ?>
                        <tr>
                            <td class="align-middle d-md-text-center pl-1" colspan="2"><strong class="j-font-size-13px">Total</strong> </td>
                            <td class="align-middle d-none d-md-block"></td>
                            <td class="align-middle text-right px-1"><strong><span class="total_price j-font-size-13px"><?= $total?></span></strong> <?=$currentRestCurrencySymbol?> </td>
                        </tr>
                        <?php
                            $tax_cost = 0;
                            foreach ( $food_tax_list as $tax_id => $tax_food_value) {
                                if ($tax_id !== 0){
                                    $tax = $this->db->where("rest_id",$myRestId)->where("id",$tax_id)->get('tbl_tax_settings')->row();
                                    $tax_cost += floatval($tax->tax_percentage) * floatval($tax_food_value) / 100; ?>
                                    
                                    <tr>
                                        <td class="align-middle d-md-text-center pl-1" colspan="2"><strong class="j-font-size-13px"><?=$this->lang->line("Tax")?> ( <?=$tax->tax_percentage?>% )</strong> </td>
                                        <td class="align-middle d-none d-md-block"></td>
                                        <td class="align-middle text-right px-1"><strong><span class="tax j-font-size-13px"><?= number_format(floatval($tax->tax_percentage) * floatval($tax_food_value) / 100, 2, '.', ' ') ?></span></strong> <?=$currentRestCurrencySymbol?> </td>
                                    </tr>
                                <?php }
                            }
                        ?>
                    </tbody>   
                </table>
            </div>
            <?php if($empty_item){?>
                <h4 class = "wishlist_empty_alert text-danger" >
                    <?= $this->lang->line("Your wishlist is empty.")?>
                </h4>
            <?php } ?>
        </section>
    </div>
      <!-- End of Main Content -->
<script type="text/javascript">
    $(document).on('click','.qrCode',function(){
        var element=$(this);
        element.parent().parent().parent().find('.show_Allergens').toggle();
    });
    function removeWishlist(item_id){
        $.ajax({
            url:"<?=base_url('API/removeWishlist')?>",
            type:"post",
            data:{item_id:item_id },
            success:function(response){
                response=JSON.parse(response);
                if(response.status==1){
                    // swal("<?= $this->lang->line('Great..')?>","<?= $this->lang->line('Remove Wishlist Successfully.')?>","<?= $this->lang->line('success')?>");
                    swal({
                        title: "<?= $this->lang->line('Great..')?>",
                        text: "<?= $this->lang->line('Remove Wishlist Successfully.')?>",
                        type: "<?= $this->lang->line('success')?>"
                    }).then(function() {
                        $(".wishlist[data-id="+item_id+"]").addClass("on");
                        location.reload();
                    });
                }else{
                    swal("<?= $this->lang->line('Ooops..')?>","<?= $this->lang->line('Something went wrong')?>","<?= $this->lang->line('error')?>");
                }
            }
        });
    }
</script>
<!-- ---------------- -->
</body>
</html>