<script>
    var placeSearch;
    var componentForm = {
        street_number: 'short_name',
        route: 'long_name',
        locality: 'long_name',
        neighborhood: 'long_name',
        administrative_area_level_1: 'short_name',
        administrative_area_level_2: 'short_name',
        administrative_area_level_3: 'short_name',
        country: 'long_name',
        postal_code: 'short_name'
    };
    var options = {
        componentRestrictions: {country: [<?= $countries?>]}
    };
    function initialize() {
        var input = document.getElementById('get_address');
        var autocomplete = new google.maps.places.Autocomplete(input, options);
        autocomplete.addListener('place_changed', function() {
            var place = autocomplete.getPlace();
            getDetailAddress(place,input);
        });
        
        var input_ = document.getElementById('get_address_');
        var autocomplete_ = new google.maps.places.Autocomplete(input_, options);
        autocomplete_.addListener('place_changed', function() {
            var place = autocomplete_.getPlace();
            getDetailAddress(place,input_);
        });
        
        var input__ = document.getElementById('get_address__');
        autocomplete__ = new google.maps.places.Autocomplete(input__, options);            
        autocomplete__.addListener('place_changed', function() {
            var place = autocomplete__.getPlace();
            getDetailAddress(place,input__);

        });
    }
    function getDetailAddress(place,input){
        if (place !== undefined && place.address_components.length > 0){
            // for (var i = 0; i < place.address_components.length; i++) {
            //     var addressType = place.address_components[i].types[0];
            //     if (componentForm[addressType]) {
            //         var val = place.address_components[i][componentForm[addressType]];
            //         console.log(val);
            //     }
            // }
            $(".get_current_address").val($(input).val());
        }
    }
    google.maps.event.addDomListener(window, 'load', initialize);

    <?php if (strtolower($mode) == "delivery"){ ?>
        if ("geolocation" in navigator){ //check Geolocation available 
            navigator.geolocation.getCurrentPosition(function(position){ 
                console.log("Found your location \nLat : "+position.coords.latitude+" \nLang :"+ position.coords.longitude);
                var lat = position.coords.latitude;
                var lng = position.coords.longitude;
                var google_map_position = new google.maps.LatLng( lat, lng );
                var google_maps_geocoder = new google.maps.Geocoder();
                google_maps_geocoder.geocode(
                    { 'latLng': google_map_position },
                    function( results, status ) {
                        $(".get_current_address").val(results[0].formatted_address);
                    }
                );
            });
        }else{
            console.log("Geolocation is not available!");
        }
    <?php } ?>
</script>
    <!-- modify by Jfrost -->
    <?php  if (null !== $this->session->userdata('customer_info')){
        $customer_info = $this->session->userdata('customer_info');
        if ($customer_info["filtered_by"] == "postcode"){
            $postcode_list = $this->db->where("rest_id = $myRestId and post_code = '".$customer_info["post_code"]."' AND status = 'active'")->get("tbl_delivery_areas")->row();
        }
    ?>
        <div class="customer-show-box hide-on-website">
            <div class="pl-3 d-flex align-items-center justify-content-between <?= strtolower($mode) == "delivery" ? "" : "hide-field" ?>" style="background: #e9e9e9;">
                <span class="text-success" ><i class="fa fa-map-marker text-success"></i> </span>
                <span class="mx-2"> <?=$customer_info["address"]?> </span> 
                <span id="show-change-box-mobile" class="btn btn-warning" >Change</span>
            </div>
        </div>  
        <div class=" d-flex justify-content-between customer-change-box-mobile py-1 hide-field">
            <div class="input-group get_address_field" style="background: #e9e9e9">
                <div class="input-group-prepend">
                    <span class="input-group-text text-success" style="width: 38px;"><i class="fa fa-map-marker text-success"></i></span>
                </div>
                
                <input type="text" class="form-control form-control-user get_delivery_address" id="get_address" placeholder='<?= $this->lang->line("Enter your Address") ?>' name="get_address" value = "<?=$customer_info["address"]?>">
                
                <div class="input-group-append">
                    <span id="get_info" class="btn btn-primary btn-user btn-block jc-enter_addressbtn" data-url="<?= base_url("/")?>">Update</span>
                </div>
            </div>
        </div>
    <?php } ?>
    <?php
        $banner_field_url = strtolower($mode)."_banner_url";
        if (isset($banner_settings->$banner_field_url) && $banner_url = $banner_settings->$banner_field_url){
        }else{
            $banner_url = "sample_banner.jpg";
        }

    ?>
    <div class="banner-section" style="background-image:url(<?=base_url("assets/rest_banner/").$banner_url?>)">
        
    </div>
    <div class="row mx-auto frost-wrap">
        <div class="main-wrap p-0 pb-sm-5">

            <section class="mx-auto container jc-address_time-container">
                <div class="m-0 my-3 p-1 p-md-3 jc-address_time" id="rest-bar">
                    <div class="address-bar">
                        <h4 class="bar-title"><?= $this->lang->line("Restaurant")?> <?= $myRestDetail->rest_name ?></h4>
                        <p class="mb-0 bar-info"> <?= $myRestDetail->address1?> <?= $myRestDetail->address2?> </p>
                        <p class="mb-0 bar-info"> <b>Phone</b> <?= $myRestDetail->rest_contact_no?> </p>
                    </div>
                    <div class="opening-time-bar">
                        <h4 class="bar-title"><?= $this->lang->line("Opening Time")?></h4>
                        <div class="time-schedule">
                            <?php
                                $time_format = $myRestDetail->time_format;
                                $date_format = $myRestDetail->date_format;
                                if (isset($openingTimes)){
                                    $opening_hours = $openingTimes->opening_hours;
                                    $opening_hours = json_decode($opening_hours);

                                    $pickup_hours = $openingTimes->pickup_hours;
                                    $pickup_hours = json_decode($pickup_hours);

                                    $delivery_hours = $openingTimes->delivery_hours;
                                    $delivery_hours = json_decode($delivery_hours);

                                    $holidays = $openingTimes->holidays;
                                    $holidays = json_decode($holidays);

                                    $irregular_openings = $openingTimes->irregular_openings;
                                    $irregular_openings = json_decode($irregular_openings);
                                }
                                $pickup_opening_times = "";
                                $delivery_opening_times = "";
                                $rest_opening_times = "";

                                // $weekdays = ['Mon','Tue','Wed','Thu','Fri','Sat','Sun'];
                                $weekdays = ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'];
                                
                                $now_weekday= (date("N") + 6) % 7;
                                
                                foreach ($weekdays as $key => $day) {
                                    if ($now_weekday ==  $key){
                                        $is_today = "style='color: red;'";
                                    }else{
                                        $is_today = "";
                                    }

                                    $ohour= "";
                                    if(isset($opening_hours[$key])){
                                        foreach ($opening_hours[$key] as $okey => $ovalue) {
                                            if ($okey > 0){
                                                $rest_opening_times .= "<p $is_today class='d-flex justify-content-between'><span> </span><span> : ".date($time_format, strtotime($ovalue->start)) ." - ". date($time_format, strtotime($ovalue->end)) . " </span></p>";
                                            }else{
                                                $rest_opening_times .= "<p $is_today class='d-flex justify-content-between'><span>$day </span><span> : ".date($time_format, strtotime($ovalue->start)) ." - ". date($time_format, strtotime($ovalue->end)) . " </span></p>";
                                            }
                                        }
                                    }
                                    $phour= "";
                                    if(isset($pickup_hours[$key])){
                                        foreach ($pickup_hours[$key] as $pkey => $pvalue) {
                                            if ($pkey > 0){
                                                $pickup_opening_times .= "<p $is_today class='d-flex justify-content-between> ".date($time_format, strtotime($pvalue->start))." - ". date($time_format, strtotime($pvalue->end))  ."</p>";
                                            }else{
                                                $pickup_opening_times .= "<p $is_today class='d-flex justify-content-between'><span>$day </span><span> : ".date($time_format, strtotime($pvalue->start)) ." - ". date($time_format, strtotime($pvalue->end)) . " </span></p>";
                                            }
                                        }
                                    }

                                    $dhour= "";
                                    if(isset($delivery_hours[$key])){
                                        foreach ($delivery_hours[$key] as $dkey => $dvalue) {
                                            if ($dkey > 0){
                                                $delivery_opening_times .= "<p $is_today class='d-flex justify-content-between'><span> </span><span> : ".date($time_format, strtotime($dvalue->start)) ." - ". date($time_format, strtotime($dvalue->end)) . " </span></p>";
                                            }else{
                                                $delivery_opening_times .= "<p $is_today class='d-flex justify-content-between'><span>$day </span><span> : ".date($time_format, strtotime($dvalue->start)) ." - ". date($time_format, strtotime($dvalue->end)) . " </span></p>";
                                            }
                                        }
                                    }
                                }
                                $holiday_schedule = "";
                                if (isset($holidays->dateStart)){
                                    $holiday_schedule .= "<h5 style='text-align: left;'>Holiday</h5>";
                                    foreach ($holidays->dateStart as $hkey => $hvalue) {
                                        $holiday_schedule .= "<p class='d-flex justify-content-between'> <b>".$holidays->name[$hkey]."</b> &emsp;". date($date_format, strtotime($holidays->dateStart[$hkey]))   ." ~ ". date($date_format, strtotime($holidays->dateEnd[$hkey]))."</p>";
                                    }
                                }

                                $irregular_openings_schedule = "";
                                if (isset($irregular_openings->date)){
                                    $irregular_openings_schedule .= "<h5 style='text-align: left;'>Irregular Opening</h5>";
                                    foreach ($irregular_openings->date as $ikey => $ivalue) {
                                        $irregular_openings_schedule .= "<p class='d-flex justify-content-between'> <b>".$irregular_openings->name[$ikey]."</b> &emsp; ". date($date_format, strtotime($irregular_openings->date[$ikey]))  ." ". date($time_format, strtotime($irregular_openings->timeStart[$ikey])) ." - ".date($time_format, strtotime($irregular_openings->timeEnd[$ikey]))."</p>";
                                    }
                                }

                                if (strtolower($mode) == "delivery"){
                                    $delivery_opening_times_today = "";
                                    if(isset($delivery_hours[$now_weekday])){
                                        foreach ($delivery_hours[$now_weekday] as $tkey => $tvalue) {
                                            if ($tkey > 0){
                                                $delivery_opening_times_today .= "<p> ".date($time_format, strtotime($tvalue->start)) ." - ". date($time_format, strtotime($tvalue->end))  ."</p>";
                                            }else{
                                                $delivery_opening_times_today .= "<p> Today : ".date($time_format, strtotime($tvalue->start)) ." - ". date($time_format, strtotime($tvalue->end))  ."</p>";
                                            }
                                        }
                                    }
                                    echo "<div class='today-schedule d-flex align-items-center justify-content-between'>
                                            <span class='mr-2' ><i class='fa fa-clock-o'></i> </span><div class='d-flex flex-column j-custom-scroll-bar' style='max-height: 40px;overflow-y: auto;'>".$delivery_opening_times_today."</div>
                                    </div>";
                                    echo "<div class='week-schedule p-3 hide-field'>".$delivery_opening_times.$holiday_schedule.$irregular_openings_schedule."</div>";
                                }else if (strtolower($mode) == "pickup"){
                                    
                                    $pickup_opening_times_today = "";
                                    if(isset($pickup_hours[$now_weekday])){
                                        foreach ($pickup_hours[$now_weekday] as $pkey => $pvalue) {
                                            if ($pkey > 0){
                                                $pickup_opening_times_today .= "<p> ".date($time_format, strtotime($pvalue->start)) ." - ". date($time_format, strtotime($pvalue->end))  ."</p>";
                                            }else{
                                                $pickup_opening_times_today .= "<p> Today : ".date($time_format, strtotime($pvalue->start)) ." - ". date($time_format, strtotime($pvalue->end))  ."</p>";
                                            }
                                        }
                                    }
                                    echo "<div class='today-schedule'>
                                    <span class='mr-2' ><i class='fa fa-clock-o'></i> </span>".$pickup_opening_times_today."
                                    </div>";
                                    echo "<div class='week-schedule p-3 hide-field'>".$pickup_opening_times.$holiday_schedule.$irregular_openings_schedule."</div>";
                                }

                            ?>
                        </div>
                    </div>
                </div>
            </section>
            <?php if ($mode == "table" && $myRestDetail->resto_plan == "pro" && ($myRestDetail->dp_option % 4 !== 0)) { ?>
                <div class="bg-warning p-3 h6 hide-on-website">
                    <?= $this->lang->line("If you want to pickup or deliver your food, please click") ?> <a href="<?= base_url("choose/").$rest_url_slug ?>"><?= $this->lang->line("here")?></a> 
                </div>
            <?php } ?>
            <div class="category-type-bar mt-3">
                <div class="category-type-bar-wrap d-flex align-items-center px-md-5 px-2">
                    <ul class="nav nav-tabs">
                        <?php
                            // $page_lang = $this->session->userdata("site_lang");
                            if ($site_lang == "" ) {
                                $page_lang ="english";
                            }else{
                                $page_lang =$site_lang;
                            }
                            $type_title_field  = "type_title_" . $page_lang;
                            foreach ($categorytype as $key => $ctype) {
                                
                                if  ($key == 0 ){ 
                                    $active = "active";
                                }else{
                                    $active = "";
                                }
                                ?>
                                
                                <li class="<?=$active?>" data-tab = "<?= $ctype->type_title?>"><a class="<?=$active?> hide-field cattypebtn_<?=$key+1?> cattypebtn" data-toggle="tab" href="#<?= $ctype->type_title?>"><?=$ctype->type_title_english?></a></li>
                                <?php 
                            }
                        ?>
                    </ul>
                </div>
                <!-- modify by Jfrost rest-->
                <div class="col-4 pl-0 d-sm-none hide-on-website hide-field">
                    <ul class="lang-setting d-flex align-items-center justify-content-end">
                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link p-1" href="#" id="pages_menu" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-align-justify text-primary"></i>
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="pages_menu">
                                <a class="dropdown-item french-flag" href="<?= base_url('help')?>">
                                    <?= $this->lang->line("Help")?>
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- ------------------- -->
           
            <div class="tab-content pb-5 px-lg-5 px-3" id="j-menu-section" data-rest-slug = "<?= $rest_url_slug?>" data-menu-mode = "<?= $mode?>">
                <?php 
                foreach ($categorytype as $key => $ctype) {
                    if  ($key == 0 ){ 
                        $active = "active";
                    }else{
                        $active = "";
                    }

                    $ctt  = $ctype->type_title;
                    $category_name_field = "category_name_".$page_lang;
                ?>

                
                    <section id="<?=$ctype->type_title?>" class="p-0 my-3 tab-pane <?=$active?> panel-section cattype_<?=$ctype->type_id?> hide-field" data-lang="<?=$page_lang?>" data-type="<?=$ctype->type_title?>">
                        
                            
                        <div class="Pisi mt-3">
                            <span class="filter_icon fa fa-search"></span>
                            <select class="form-control category_id" id="category_id_<?=$ctype->type_title?>" >
                                <option value="0"><?= $this->lang->line("Select Category")?></option>
                                <?php foreach($Categories_by_ctypes[$ctt][0] as $category):?>
                                    <option value="<?=$category->category_id?>"><?= $category->$category_name_field == "" ? $category->category_name : $category->$category_name_field ?></option>
                                <?php endforeach;?>
                            </select>
                            <input type="text" class="form-control mt-1 item_key hide-on-sticky" placeholder="<?= $this->lang->line('Search Your Item')?>">
                        </div>

                        <div class="menuList_">

                        </div>
                    </section>
                <?php }?>
            </div>
        </div>
        <div class="right-side wish-list-section px-3 py-4" >
            <div class="right-side-wrap j-custom-scroll-bar">
                <section>
                    <?php  if (strtolower($mode) == "delivery" && null !== $this->session->userdata('customer_info')){ ?>
                        
                        <div class="mt-4 d-flex justify-content-between customer-show-box">
                            <div class="pl-3 d-flex align-items-center <?= strtolower($mode) == "delivery" ? "" : "hide-field" ?>" style="background: #e9e9e9;">
                                <span class="text-success" ><i class="fa fa-map-marker text-success"></i> </span>
                                <span class="mx-2"> <?=$customer_info["address"]?> </span> 
                                <span id="show-change-box" class="btn btn-warning" >Change</span>
                            </div>
                            <div class="d-flex align-items-center px-2 hide-field" style="background: #e9e9e9;max-width:40%;">
                                <i class="fa fa-clock-o"></i> 
                                <span class="ml-3"> <?= $delivery_time > 0 ? $delivery_time." mins" : "" ?> </span>
                            </div>
                        </div>  

                        <div class="mt-4 d-flex justify-content-between hide-field customer-change-box">
                            <div class="input-group get_address_field" style="background: #e9e9e9">
                                <div class="input-group-prepend">
                                    <span class="input-group-text text-success" style="width: 38px;"><i class="fa fa-map-marker text-success"></i></span>
                                </div>
                                
                                <input type="text" class="form-control form-control-user get_delivery_address" id="get_address__" placeholder='<?= $this->lang->line("Enter your Address") ?>' name="get_address" value = "<?=$customer_info["address"]?>" >
                                
                                <div class="input-group-append">
                                    <span id="get_info" class="btn btn-primary btn-user btn-block jc-enter_addressbtn" data-url="<?= base_url("/")?>">Change</span>
                                </div>
                            </div>
                        </div>
                    <?php }
                    if (strtolower($mode) == "delivery" && null == $this->session->userdata('customer_info')){ ?>
                        <div class="tab-content pb-2">
                            <div class="">
                                <div class="">
                                    <div class="input-group get_address_field">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text text-success" style="width: 38px;"><i class="fa fa-map-marker text-success"></i></span>
                                        </div>
                                        <input type="text" class="form-control form-control-user get_delivery_address get_current_address" id="get_address__" placeholder='<?= $this->lang->line("Enter your Address") ?>' name="get_address__" >
                                        
                                        <div class="input-group-append">
                                            <span id="get_info_" class="btn btn-primary btn-user btn-block jc-enter_addressbtn" data-url="<?= base_url("/")?>">Save</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </section>
                <section class="my-2">
                    <div class="row px-3">
                        <?php if ($mode == "table" && $myRestDetail->resto_plan == "pro" && ($myRestDetail->dp_option % 4 !== 0)) { ?>
                            <div class="bg-warning h6 my-3 p-3">
                                <?= $this->lang->line("If you want to pickup or deliver your food, please click") ?> <a href="<?= base_url("choose/").$rest_url_slug ?>"><?= $this->lang->line("here")?></a> 
                            </div>
                        <?php } ?>
                        <div class="px-3 text-center align-middle w-100 py-2 wishlist_tab_panel">
                            <a class="cattypebtn w-100"><?= $mode == "table" ? $this->lang->line("My Wishlist") :  $this->lang->line("My Cart")?></a>
                        </div>
                    </div>
                </section>
                <div class="tab-content">
                    <?php
                        if($mode == "table"){ ?>
                            <!-- On Table -->
                            <section class="container my-3 panel-section px-0 <?= $mode ?>-section" data-lang="<?=$page_lang?>">
                                <div class="menuList">
                                    <table class="table w-100" id="item-menu-table">
                                        <tbody>
                                        <?php
                                            $empty_item = true;
                                            $total = 0 ;
                                            $food_tax_list =  array();
                                            foreach ($item_details as $item_key => $item) {
                                                if ($item !== null){
                                                    
                                                    $extra_price_value = 0;
                                                    $item_name_field = "item_name_" . $page_lang;
                                                    $item_prices_title_field = "item_prices_title_" . $page_lang;
                                                    $item_name = $item->$item_name_field == "" ? $item->item_name : $item->$item_name_field;
                                                    $price_index = $wish_price[ $item_key];
                                                    $item_price_title =  $item->$item_prices_title_field == "" ? "" : explode(",",$item->$item_prices_title_field)[$price_index];
                                                    $item_price_title =  ($item->item_prices_title == "") ? "" : ($item_price_title == "" ? explode(",",$item->item_prices_title)[$price_index] : $item_price_title);
                                                    $item_price = $item->item_prices == "" ? "" :explode(",",$item->item_prices)[$price_index];
                                                    
                                                    $item_extra_str = "";
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
                                                        <td class="text-center px-1 d-flex">
                                                            <span class="qty-field j-font-size-13px"><?= $wish_qty[ $item_key]?>
                                                            </span>
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
                                                                <span class="price_value j-font-size-13px" style="width: 50px;"><?= $item_price + $extra_price_value?></span><span class="j-font-size-13px"><?= ($item_price+$extra_price_value) !== 0 ? " $currentRestCurrencySymbol " : ""?></span>
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
                                                <td class="align-middle text-right px-1"><strong><span class="total_price j-font-size-13px"><?= $total?></span></strong> <?=$currentRestCurrencySymbol?> </td>
                                            </tr>
                                            <?php
                                                $tax_cost = 0;
                                                foreach ( $food_tax_list as $tax_id => $tax_food_value) {
                                                    if ($tax_id !== 0){
                                                        if ($tax = $this->db->where("rest_id",$myRestId)->where("id",$tax_id)->get('tbl_tax_settings')->row()){
                                                            $tax_cost += floatval($tax->tax_percentage) * floatval($tax_food_value) / 100; ?>
                                                        
                                                            <tr>
                                                                <td class="align-middle d-md-text-center pl-1" colspan="2"><strong class="j-font-size-13px"><?=$this->lang->line("Tax")?> ( <?=$tax->tax_percentage?>% )</strong> </td>
                                                                <td class="align-middle text-right px-1"><strong><span class="tax j-font-size-13px"><?= number_format(floatval($tax->tax_percentage) * floatval($tax_food_value) / 100, 2, '.', ' ') ?></span></strong> <?=$currentRestCurrencySymbol?> </td>
                                                            </tr>
                                                    <?php } }
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
                        <?php }else{ 
                            if ($page_lang == "english"){
                                $url_surfix = "en";
                            }elseif ($page_lang == "germany"){
                                $url_surfix = "de";
                            }else{
                                $url_surfix = "fr";
                            }
                            ?>
                            <!-- Delivery or Pickup -->
                            <section class="container my-3 panel-section px-0 <?= $mode ?>-section" data-lang="<?=$page_lang?>">
                                <div class="menuList">
                                    <div class="hide-field">
                                        <div class="w-100">
                                            <input type="radio" name="dp_option" value="Delivery" id="delivery_option" <?= $mode == "Delivery" ? "checked" : "" ?> <?=($is_open_delivery || $myRestDetail->pre_order) ? "" : "disabled" ?> data-lang_surfix = "<?= $url_surfix?>">
                                            <label for="delivery_option"><?= $this->lang->line("Delivery")?></label>
                                        </div>
                                        <div class="w-100">
                                            <input type="radio" name="dp_option" value="Pickup" id="pickup_option" <?= $mode == "Pickup" ? "checked" : "" ?> <?=($is_open_pickup || $myRestDetail->pre_order) ? "" : "disabled" ?> data-lang_surfix = "<?= $url_surfix?>">
                                            <label for="pickup_option"><?= $this->lang->line("Pickup")?></label>
                                        </div>
                                    </div>
                                    <div class="j-dp-option-btn-toggle">
                                        <label class="delivery-btn j-dp-option-btn <?= $mode == "Delivery" ? "active" : "" ?> <?=($is_open_delivery || $myRestDetail->pre_order) ? "" : "disabled" ?>" for="delivery_option">
                                            <i class="dp-icon fa fa-bicycle"></i>
                                            <div class="dp-info">
                                                <p class="dp-title">Delivery</p>
                                                <p class="dp-duration"><?= $delivery_time > 0 ? $delivery_time." mins" : "" ?></p>
                                            </div>
                                        </label>
                                        <label class="takeaway-btn j-dp-option-btn <?= $mode == "Pickup" ? "active" : "" ?> <?=($is_open_pickup || $myRestDetail->pre_order) ? "" : "disabled" ?>" for="pickup_option">
                                            <i class="dp-icon fa fa-gift"></i>
                                            <div class="dp-info">
                                                <p class="dp-title">Takeaway</p>
                                                <p class="dp-duration">20 mins</p>
                                            </div>
                                        </label>
                                    </div>
                                    <table class="table w-100" id="item-menu-table" data-min_order_amount_free_delivery = "<?=$min_order_amount_free_delivery?>">
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
                                                            <span class="j-font-size-13px ml-1">x </span> 
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
                                                                <span class="price_value j-font-size-13px" style="width: 50px;"><?= floatval($item_price+$extra_price_value) ?></span><span class="j-font-size-13px"><?= (floatval($item_price+$extra_price_value)) !== 0 ? " $currentRestCurrencySymbol " : ""?></span>
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
                                                            if ($tax = $this->db->where("rest_id",$myRestId)->where("id",$tax_id)->get('tbl_tax_settings')->row()){
                                                                $tax_cost += floatval($tax->tax_percentage) * floatval($tax_food_value) / 100; ?>
                                                                
                                                                <tr>
                                                                    <td class="align-middle d-md-text-center pl-1" colspan="2"><strong class="j-font-size-13px"><?=$this->lang->line("Tax")?> ( <?=$tax->tax_percentage?>% )</strong> </td>
                                                                    <td class="align-middle text-right px-1"><strong><span class="tax j-font-size-13px"><?= number_format(floatval($tax->tax_percentage) * floatval($tax_food_value) / 100, 2, '.', ' ') ?></span></strong> <?=$currentRestCurrencySymbol?> </td>
                                                                </tr>
                                                        <?php } }
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
                                                    <td class="align-middle text-right px-1"><strong><span class="delivery_price j-font-size-13px" data-delivery_price ="<?=$delivery_cost_original?>" ><?= $delivery_cost?></span></strong> <?=$currentRestCurrencySymbol?> </td>
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
                                                    <td class="align-middle text-right px-1"><strong><span class="total_price j-font-size-13px"><?= number_format($total_cart + $delivery_cost ,2)?></span></strong> <?=$currentRestCurrencySymbol?> </td>
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
                <?php if(!$empty_item){?>
                    <div class="w-100 text-center">
                        <?php
                            if (strtolower($mode) == "delivery" && null == $this->session->userdata('customer_info')){ ?>
                                <h4 class = "wishlist_empty_alert text-danger mt-5" >
                                    Please enter your delivery address.
                                </h4>
                            <?php }else if($mode !== "table"){ ?>
                                <div class="w-100 mt-5"><a class="btn btn-info w-100 order-btn" href="<?= base_url("Home/checkout/$rest_url_slug/$mode/$iframe")?>" style="background: #0184FFff;color: white;">Order</a></div>
                            <?php } 
                        ?>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <section class="hide-on-website">
        <div class="row m-0 mobile_top_bar_wrap w-100  hide-field">
            <ul class="nav nav-tabs row w-100 m-0 p-0">
                <?php
                    // $page_lang = $this->session->userdata("site_lang");
                    if ($site_lang == "" ) {
                        $page_lang ="english";
                    }else{
                        $page_lang =$site_lang;
                    }
                    $type_title_field  = "type_title_" . $page_lang;
                    foreach ($categorytype as $key => $ctype) {
                        if  ($key == 0 ){ 
                            $active = "active";
                        }else{
                            $active = "";
                        }
                        ?>
                        <li class="col-4 <?=$active?> p-0" data-tab = "<?= $ctype->type_title?>"><a class="<?=$active?> hide-field cattypebtn_<?=$key+1?> cattypebtn" data-toggle="tab" href="#<?= $ctype->type_title?>"><?=$ctype->type_title_english?></a></li>
                        <?php 
                    }
                ?>
            </ul>
            <!-- <div class="Pisi">
                <span class="filter_icon fa fa-search"></span>
                <select class="form-control category_id mt-3" id="category_id" >
                </select>
                <input type="text" class="form-control mt-1 item_key hide-on-sticky" placeholder="Search Your Item">
            </div> -->
        </div>
        <div class="row d-flex justify-content-between m-0 mobile_bottom_bar_wrap">
            <div class="lang-setting col-4 align-items-center">
                <!-- Nav Item - User Information -->
                <div class="pr-2">
                    <span class="mobile_bottom_bar" id="bottom_language_parent" role="button">
                        <!-- modify by Jfrost rest-->
                        <?php
                            if ($this->input->get("lang") == "en" && in_array("english",explode(",",$myRestDetail->website_languages))){?>
                                <img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/en-flag.png')?>">
                                <?php 
                            }elseif ($this->input->get("lang") == "de" && in_array("germany",explode(",",$myRestDetail->website_languages))){?>
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
    <div id="insertShippingAddressForm" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-body">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary"><?=$this->lang->line('Delivery Address')?></h6>
                        </div>
                        <div class="card-body">
                            <p>Please Enter your Delivery Address to add your menu to cart</p>
                            <div class="tab-content">
                                <div class="text-center py-4 row">
                                    <div class="col-md-12">
                                        <div class="input-group get_address_field">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text text-success" style="width: 38px;"><i class="fa fa-map-marker text-success"></i></span>
                                            </div>
                                            <input type="text" class="form-control form-control-user get_delivery_address get_current_address" id="get_address_" placeholder='<?= $this->lang->line("Enter your Address") ?>' name="get_address_" >
                                            
                                            <div class="input-group-append">
                                                <span id="get_info_" class="btn btn-primary btn-user btn-block jc-add_cart_enter_addressbtn" data-url="<?= base_url("/")?>" data-item_id = "0">Save</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?=$this->lang->line('Close')?></button>
                </div>
            </div>
        </div>
    </div>
      <!-- End of Main Content -->
<script type="text/javascript">
$(document).on('click','.qrCode',function(){
    var element=$(this);
    element.parent().parent().parent().find('.show_Allergens').toggle();
});
function get_food_extra_list(item_id,price_index){
    var item_wrap = $(".qty_field_wrap_" + item_id);
    var addcart_btn_Value = 0;
    base_url = $(".lgblueBck").attr("data-url");
    var lang = $(".panel-section").attr("data-lang");
    $.ajax({
        url:base_url + 'API/getExtraList',
        type:"post",
        data:{item_id:item_id,price_index:price_index},
        success:function(response){
            response=JSON.parse(response);
            if (!jQuery.isEmptyObject(response.data)){
                extra_cat = response.data['extra_cat'];
                extra = response.data['extra'];
                extra_price = response.data['price'];
                // food_extra_select  = '<p>You want some extras?</p><select class="form-control food_extra_id chosen-select-width-foodextra" id="food_extra_id_'+item_id+'[]" name="food_extra_id_'+item_id+'[]" multiple>';
                food_extra_select  = '<hr>';
                for (let eic = 0; eic < extra_cat.length; eic++) {
                    if (lang == "english"){
                        food_extra_cat_name =extra_cat[eic].extra_category_name_english;
                    }else if (lang == "germany"){
                        food_extra_cat_name =extra_cat[eic].extra_category_name_germany;
                    }else {
                        food_extra_cat_name =extra_cat[eic].extra_category_name_french;
                    }
                    food_extra_cat_name = food_extra_cat_name == "" ? extra_cat[eic].extra_category_name  : food_extra_cat_name;

                    food_extra_select  += '<p class="extra-category text-primary pt-4">'+food_extra_cat_name+'</p>';
                    food_extra_select  += '<div class="extra-body mb-3">';
                    if (extra_cat[eic].is_multi_select == 1){
                        food_extra_select += '<div class="">';
                    }else{
                        food_extra_select += '<select class="form-control food_extra_id" id="food_extra_id_'+item_id+'[]" name="food_extra_id_'+item_id+'[]">';
                    }
                    for (let ei = 0; ei < extra[eic].length; ei++) {
                        if (lang == "english"){
                            food_extra_name =extra[eic][ei].food_extra_name_english;
                        }else if (lang == "germany"){
                            food_extra_name =extra[eic][ei].food_extra_name_germany;
                        }else {
                            food_extra_name =extra[eic][ei].food_extra_name_french;
                        }
                        food_extra_name = food_extra_name == "" ? extra[eic][ei].food_extra_name  : food_extra_name;
                        if (extra_cat[eic].is_multi_select == 1){
                            food_extra_select += '<p><label class="food-extra"><input type="checkbox" class="food_extra_id mr-2" data-price = "'+extra_price[eic][ei]+'" data-value = "'+extra[eic][ei].extra_id+'" />' + food_extra_name + ' ( +' + extra_price[eic][ei] + '<?=$currentRestCurrencySymbol?> )</label></p>';
                        }else{
                            food_extra_select += '<option value="'+extra[eic][ei].extra_id+'" data-price="'+ extra_price[eic][ei] +'">' + food_extra_name + ' ( + ' + extra_price[eic][ei] + '<?=$currentRestCurrencySymbol?> )</option>';
                            if (ei == 0){
                                addcart_btn_Value += parseFloat(extra_price[eic][ei]);
                            }
                        }
                    }
                    if (extra_cat[eic].is_multi_select == 1){
                        food_extra_select += '</div>';
                    }else{
                        food_extra_select += '</select>';
                    }
                }
                $(".qty_field_wrap_"+item_id+" .food-extra-field").empty();
                $(".qty_field_wrap_"+item_id+" .food-extra-field").append(food_extra_select);
                // $(".chosen-select-width-foodextra").chosen({placeholder_text: "Select Food Extra",width: "95%"});
            }
            addcart_btn_Value += parseFloat(item_wrap.find(".item-price-select option:selected").attr("data-price"));
            if (isNaN(addcart_btn_Value)){
                addcart_btn_Value = 0;
            }
            item_wrap.find(".addcart-btn").html(addcart_btn_Value.toFixed(2) + " <?=$currentRestCurrencySymbol?>");
            item_wrap.find(".addcart-btn").attr("data-total-price",addcart_btn_Value);
        }
    });
}
//  $(document)
$(document).on('keyup','.item_key',function(){
    var keyword = $(this).val();
    $(".item_key").val(keyword);
    var rest_id="<?=$myRestId?>";
    var lang = $(".panel-section").attr("data-lang");
    var cattype = $(".panel-section.active").attr("data-type");
    var mode = $(".lgblueBck").attr("data-mode");
    $.ajax({
        url:"<?=base_url('API/getItemBySearchKey')?>",
        type:"post",
        data:{keyword:keyword,rest_id:rest_id,lang:lang,dp_option:mode},
        success:function(response){
            
            response=JSON.parse(response);
            if(response.data.length>0){
                $('.menuList_').empty();
                var base_url="<?=base_url('assets/menu_item_images/')?>";
                var cat_base_url="<?=base_url('assets/category_images/')?>";
                for(let i=0; i<response.data.length; i++){
                    var subCategories=response.data[i].sub_categories;
                    var allergens=response.data[i].allergens;
                    var cattype_id = response.data[i].cattype;
                    var sub_="";
                    categoryname_with_image = "";
                    if (response.data[i].category_img){
                        category_image='<div class="" style="padding:unset">'+
                                '<div class="mt-2 img-wh-wrap w-100">'+
                                '<img class = "category_img w-100" src = "'+cat_base_url+response.data[i].category_img+'" onerror="this.style.display=\'none\'">'
                                '</div>'+
                            '</div>';
                        categoryname_with_image = "categoryname_with_image";
                    }
                    var category_name='<div class="MenU_li MenU_li_title '+categoryname_with_image+'" >'+
                                        '<div class="row ">'+
                                            '<div class="col text-danger"><span class="catStyle px-2">'+response.data[i].category+'</span><div class="px-2 catDesc small text-left text-white">'+response.data[i].categoryDesc+'</div></div>'+
                                        '</div>'+
                                    '</div>';
                    $('.cattype_'+cattype_id+' .menuList_').append(category_image);
                    $('.cattype_'+cattype_id+' .menuList_').append(category_name);
                    $('.cattype_'+cattype_id).removeClass("hide-field");
                    $('.cattypebtn_'+cattype_id).removeClass("hide-field");
                    var ItmesArray=response.data[i].items;
                    length = ItmesArray.length;
                    for(j=0; j<ItmesArray.length; j++){
                        var subCats=ItmesArray[j].sub_Cat;
                        var priceArray=ItmesArray[j].item_price;
                        var span='';
                        var div='';
                        var subcatdiv='';
                        var td="";
                        var select_box ="";
                        var item_id = ItmesArray[j].item_detail.menu_id;
                        var item_name=ItmesArray[j].item_detail.item_name;
                        var item_image=ItmesArray[j].item_detail.item_image;
                        var item_desc=ItmesArray[j].item_detail.item_desc;
                        var item_type=ItmesArray[j].item_detail.item_type;
                        var item_price_title=ItmesArray[j].item_detail.item_prices_title;
                        var item_extras=ItmesArray[j].item_detail.item_food_extra;

                        // var item_allergens=ItmesArray[j].item_detail.item_allergens;
                        var item_show_blue=ItmesArray[j].item_detail.item_show_blue;
                        if (item_show_blue == "on"){
                            show_blue_bar = "";
                        }else{
                            show_blue_bar = "hide-field";
                        }
                        if (ItmesArray[j].item_detail.item_name_english !== ""){
                            $(".english-flag").removeClass("hide-field");
                        }
                        if (ItmesArray[j].item_detail.item_name_germany !== ""){
                            $(".germany-flag").removeClass("hide-field");
                        }
                        if (ItmesArray[j].item_detail.item_name_french !== ""){
                            $(".french-flag").removeClass("hide-field");
                        }
                        if (lang == "french"){
                            item_name_=ItmesArray[j].item_detail.item_name_french;
                            if (item_name_ == "" ){
                                item_name = ItmesArray[j].item_detail.item_name;
                            }else{
                                item_name = item_name_;
                                $(".french-flag").removeClass("hide-field");
                            }

                            item_desc_=ItmesArray[j].item_detail.item_desc_french;
                            item_desc = (item_desc_== "" ) ?  ItmesArray[j].item_detail.item_desc : item_desc_;

                            item_price_title_=ItmesArray[j].item_detail.item_prices_title_french;
                            item_price_title= (item_price_title_ == "") ? ItmesArray[j].item_detail.item_prices_title : item_price_title_;

                        }else if (lang =="germany"){
                            item_name_=ItmesArray[j].item_detail.item_name_germany;
                            if (item_name_ == "" ){
                                item_name = ItmesArray[j].item_detail.item_name;
                            }else{
                                item_name = item_name_;
                                $(".germany-flag").removeClass("hide-field");
                            }


                            item_desc_=ItmesArray[j].item_detail.item_desc_germany;
                            item_desc = (item_desc_== "") ?  ItmesArray[j].item_detail.item_desc : item_desc_;

                            item_price_title_=ItmesArray[j].item_detail.item_prices_title_germany;
                            item_price_title= (item_price_title_ == "") ? ItmesArray[j].item_detail.item_prices_title : item_price_title_;
                        }else{
                            item_name_=ItmesArray[j].item_detail.item_name_english;
                            if (item_name_ == "" ){
                                item_name = ItmesArray[j].item_detail.item_name;
                            }else{
                                item_name = item_name_;
                                $(".english-flag").removeClass("hide-field");
                            }


                            item_desc_=ItmesArray[j].item_detail.item_desc_english;
                            item_desc = (item_desc_== "") ?  ItmesArray[j].item_detail.item_desc : item_desc_;

                            item_price_title_=ItmesArray[j].item_detail.item_prices_title_english;
                            item_price_title= (item_price_title_ == "") ? ItmesArray[j].item_detail.item_prices_title : item_price_title_;
                        }
                        for(let k1=0; k1<subCategories.length; k1++){
                            if (-1 !== ItmesArray[j].item_detail.sub_cat_ids.split(",").indexOf((subCategories[k1].sub_cat_id))){
                                subcatdiv+='<div class=" my-2 mr-2">';
                                subcatdiv+=        '<div class="badge badge-success">'+subCategories[k1].sub_category_name+'</div>';
                                subcatdiv+='</div>';
                            }
                        }
                        item_allergens = "";
                        for(let k2=0; k2<allergens.length; k2++){
                            if (-1 !== ItmesArray[j].item_detail.item_allergens.split(",").indexOf((allergens[k2].allergen_id))){
                                if (lang == "english"){
                                    allergen_filed_ = allergens[k2].allergen_name_english;
                                    if (allergen_filed_ == ""){
                                        allergen_filed_ = allergens[k2].allergen_name;
                                    }
                                }else if (lang == "germany"){
                                    allergen_filed_ = allergens[k2].allergen_name_germany;
                                    if (allergen_filed_ == ""){
                                        allergen_filed_ = allergens[k2].allergen_name;
                                    }
                                }else{
                                    allergen_filed_ = allergens[k2].allergen_name_french;
                                    if (allergen_filed_ == ""){
                                        allergen_filed_ = allergens[k2].allergen_name;
                                    }
                                }
                                item_allergens+=        '<div class="badge badge-success">'+allergen_filed_+'</div>';
                            }
                        }
                        item_price_title_arr = item_price_title.split(',');
                        for(let k=0; k<item_price_title_arr.length; k++){
                            var itemPrice=response.data[i].items[j].item_price[k];
                            if(itemPrice!=''){
                                div+='<div class="d-flex mt-1 col p-0">';
                                if (item_price_title_arr[k] !== ""){
                                    div+=        '<div class="mr-2 overflow-hidden text-truncate text-nowrap jc-food_description"><b>'+item_price_title_arr[k]+'</b></div>';
                                    select_box +='<option value="'+k+'" data-price="'+itemPrice+'">' + item_price_title_arr[k]+'&emsp;';
                                }else{
                                    select_box +='<option value="'+k+'" data-price="'+itemPrice+'">';
                                }
                                div+='<div class=""><span class="prct p-0 d-inline-flex">'+parseFloat(itemPrice).toFixed(2).replace(".", ",")+' <span class=""> '+currentRestCurrencySymbol+'</span></span></div>';
                                select_box +=parseFloat(itemPrice).toFixed(2).replace(".", ",")+' <span class=""> '+currentRestCurrencySymbol+'</option>';
                                div+='</div>';
                                show_price_select = "";
                            }else{
                                show_price_select = "hide-field";
                            }
                        }
                        select = '<p class="'+show_price_select+'">Please Choose : </p>';
                        select +='<select class="form-control item-price-select  '+show_price_select+'">';
                        select += select_box;
                        select +='</select>';

                        span='<span class="prct">'+td+'</span>';
                        
                        if(item_type=="Vegetarian"){
                            var cls="text-success";
                            item_type = "<?= $this->lang->line("Vegetarian")?>";
                        }else if(item_type=="Vegan"){
                            var cls="text-warning";
                            item_type = "<?= $this->lang->line("Vegan")?>";
                        }else{
                            var cls="d-none";
                        }
                        var wishlist = '<div class="px-4 col-3 text-left text-danger wishlist" data-id = "'+item_id+'">'+
                            '<span class="text-danger p-1 mb-1" onclick="show_qty_field('+item_id+')">'+
                                '<i class="fa fa-heart"></i>'+
                            '</span>'+
                        '</div>';
                        
                        var wishlist_wrap = '<div class="col-7 input-group p-0 justify-content-center"><span class="btn btn-success w-100"  onclick="addWishlist('+item_id+')">Add to Wishlist</span></div>';

                        var cart = '<div class="px-4 col-3 text-left text-danger wishlist" data-id = "'+item_id+'">'+
                            '<span class="text-danger p-1 mb-1" onclick="show_qty_field('+item_id+')">'+
                                '<i class="fa fa-shopping-cart"></i>'+
                            '</span>'+
                        '</div>';
                        
                        var cart_wrap = '<div class="col-7 input-group p-0 justify-content-center"><span class="btn btn-success w-100 addcart-btn"  onclick="addCart('+item_id+')">Add to Cart</span></div>';

                        if (mode == "table"){
                            wishlist_or_cart = wishlist;
                            wishlist_or_cart_wrap = wishlist_wrap;
                        }else{
                            wishlist_or_cart = cart;
                            wishlist_or_cart_wrap = cart_wrap;
                        }

                        if (item_allergens == ""){
                            info_visible = "hide-field";
                        }else{
                            info_visible = "";
                        }
                        if (item_image == "samplefood.png" || item_image == ""){
                            var item_image_wrap = "";
                        }else{
                            var item_image_wrap = '<div class="col-5 p-2 text-right '+(item_image !== "samplefood.png" ? "":"d-none") +'">'+
                                        '<div class="img-wh-wrap">'+
                                            '<img src="'+base_url+item_image+'" alt=""  class="rounded img-fluid w-100 img-wh" onerror="this.style.display=\'none\'">'+
                                        '</div>'+
                                    '</div>';
                        }
                        var listitem=''+
                            '<div class="MenU_li mb-0 MenU_li_member" data-item_id="'+item_id+'">'+
                                '<div class="meal-wrap">'+
                                    '<div class="pl-2"><h5 class="item_name jc-food">'+item_name+'</h5></div>'+
                                    '<div class="row m-0">'+
                                        '<div class="col px-2 py-1">'+
                                            '<div class=""><div class="d-flex">'+
                                                subcatdiv+
                                            '</div><small class="item_desc jc-food_description">'+item_desc+'</small>'+
                                            '</div>'+
                                            '<div class="mt-3">'+
                                                div+
                                            '</div>'+
                                        '</div>'+
                                        item_image_wrap+
                                    '</div>'+
                                '</div>'+
                                '<div class="meal-menucard_sidedish_btn_">'+
                                '</div>'+
                            '</div>'+
                            '<div class="mt-0 fnt14 pb-2 '+show_blue_bar+'">'+
                                '<div class="row mt-2 mx-0 w-100">'+
                                        wishlist_or_cart+
                                    '<div class="px-2 col-9 text-right">'+
                                        '<small class="UHU_p text-primary jc-food_info">'+
                                        '<span class="ml-1 qrCode '+info_visible+'"><i class="fas fa-plus-circle"></i> Info</span>'+
                                        '<span class="ml-1 '+cls+'">'+item_type+'</span>'+
                                        '</small>'+
                                        '<div class="show_Allergens">'+
                                        '<p>'+item_allergens+'</p>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>'+
                            '</div>'+
                            '<div class="mt-0 qty_field_wrap qty_field_wrap_'+item_id +'" data-item-id = "'+item_id +'">'+
                                '<div class="row  pb-2 p-md-3 p-2 mt-2 mx-0 w-100">'+
                                    '<div class="px-2 col-md-12 mt-2">'+
                                        select+
                                    '</div>'+
                                    '<div class="px-2 col-md-8 mx-auto mt-3 food-extra-field">'+
                                    '</div>'+
                                    '<div class="px-2 col-md-12 text-right row m-0 mt-2">'+
                                        '<div class="col-5 input-group qty-field-wrap">'+
                                            '<input type="number" value="1" min="1" data-bts-mousewheel="true" class="form-control qty-field">'+
                                        '</div>'+
                                        wishlist_or_cart_wrap+
                                    '</div>'+
                                '</div>'+
                            '</div>';
                        $('.cattype_'+cattype_id+' .menuList_').append(listitem);
                        item_extra_build(item_id,item_extras,item_price_title_arr.length);
                    }
                }
                $(".qty-field-wrap .qty-field").TouchSpin({
                    initval: 1,
                    buttondown_class: "btn btn-primary",
                    buttonup_class: "btn btn-primary",
                });
            }
        }
    });
});

$(document).ready(function(){
    var rest_id = "<?=$myRestId?>";
    currentRestCurrencySymbol = "<?=$currentRestCurrencySymbol?>";
    // var language = window.navigator.userLanguage || window.navigator.language;
    // lang = language.substring(0,2);
    // if (lang == "en"){
    //     lang = "english";
    // }else if(lang == "de"){
    //     lang = "germany";
    // }else{
    //     lang = "french";
    // }
    
    var lang = $(".panel-section").attr("data-lang");
    var mode = $(".lgblueBck").attr("data-mode");
    var cattype = "<?=$categorytype[0]->type_title?>";
    $.ajax({
        url:"<?=base_url('API/getAllMenuItemByCatId')?>",
        type:"post",
        data:{rest_id:rest_id,lang:lang,cattype:cattype,dp_option:mode},
        success:function(response){
            response=JSON.parse(response);
            if(response.data.length>0){
                $('.menuList_').empty();
                var base_url="<?=base_url('assets/menu_item_images/')?>";
                var cat_base_url="<?=base_url('assets/category_images/')?>";
                for(let i=0; i<response.data.length; i++){
                    var subCategories=response.data[i].sub_categories;
                    var allergens=response.data[i].allergens;
                    var cattype_id = response.data[i].cattype;
                    var sub_="";
                    category_image = "";
                    categoryname_with_image = "";
                    if (response.data[i].category_img && response.data[i].category_img !== ""){
                        category_image='<div class="" style="padding:unset">'+
                                '<div class="mt-2 img-wh-wrap w-100">'+
                                '<img class = "category_img w-100" src = "'+cat_base_url+response.data[i].category_img+'" onerror="this.style.display=\'none\'">'
                                '</div>'+
                            '</div>';
                            categoryname_with_image = "categoryname_with_image";
                    }
                    var category_name='<div class="MenU_li MenU_li_title '+categoryname_with_image+'" >'+
                                        '<div class="row ">'+
                                            '<div class="col text-danger"><span class="catStyle px-2">'+response.data[i].category+'</span><div class="px-2 catDesc small text-left text-white">'+response.data[i].categoryDesc+'</div></div>'+
                                        '</div>'+
                                    '</div>';
                    $('.cattype_'+cattype_id+' .menuList_').append(category_image);
                    $('.cattype_'+cattype_id+' .menuList_').append(category_name);
                    $('.cattype_'+cattype_id).removeClass("hide-field");
                    $('.cattypebtn_'+cattype_id).removeClass("hide-field");
                    var ItmesArray=response.data[i].items;
                    for(j=0; j<ItmesArray.length; j++){
                        var subCats=ItmesArray[j].sub_Cat;
                        var priceArray=ItmesArray[j].item_price;
                        var span='';
                        var div='';
                        var subcatdiv='';
                        var td="";
                        var select_box ="";
                        var item_id = ItmesArray[j].item_detail.menu_id;
                        var item_name=ItmesArray[j].item_detail.item_name;
                        var item_image=ItmesArray[j].item_detail.item_image;
                        var item_desc=ItmesArray[j].item_detail.item_desc;
                        var item_type=ItmesArray[j].item_detail.item_type;
                        var item_price_title=ItmesArray[j].item_detail.item_prices_title;
                        var item_extras=ItmesArray[j].item_detail.item_food_extra;

                        // var item_allergens=ItmesArray[j].item_detail.item_allergens;
                        var item_show_blue=ItmesArray[j].item_detail.item_show_blue;
                        if (item_show_blue == "on"){
                            show_blue_bar = "";
                        }else{
                            show_blue_bar = "hide-field";
                        }
                        if (ItmesArray[j].item_detail.item_name_english !== ""){
                            $(".english-flag").removeClass("hide-field");
                        }
                        if (ItmesArray[j].item_detail.item_name_germany !== ""){
                            $(".germany-flag").removeClass("hide-field");
                        }
                        if (ItmesArray[j].item_detail.item_name_french !== ""){
                            $(".french-flag").removeClass("hide-field");
                        }
                        ItmesArray[j].item_detail.item_name_english;
                        if (lang == "french"){
                            item_name_=ItmesArray[j].item_detail.item_name_french;
                            if (item_name_ == "" ){
                                item_name = ItmesArray[j].item_detail.item_name;
                            }else{
                                item_name = item_name_;
                                $(".french-flag").removeClass("hide-field");
                            }

                            item_desc_=ItmesArray[j].item_detail.item_desc_french;
                            item_desc = (item_desc_ == "") ?ItmesArray[j].item_detail.item_desc : item_desc_;

                            item_price_title_=ItmesArray[j].item_detail.item_prices_title_french;
                            item_price_title =(item_price_title_ == "") ? ItmesArray[j].item_detail.item_prices_title : item_price_title_;

                        }else if (lang =="germany"){
                            item_name_=ItmesArray[j].item_detail.item_name_germany;
                            if (item_name_ == "" ){
                                item_name = ItmesArray[j].item_detail.item_name;
                            }else{
                                item_name = item_name_;
                                $(".germany-flag").removeClass("hide-field");
                            }

                            item_desc_=ItmesArray[j].item_detail.item_desc_germany;
                            item_desc = (item_desc_ == "") ?ItmesArray[j].item_detail.item_desc : item_desc_;

                            item_price_title_=ItmesArray[j].item_detail.item_prices_title_germany;
                            item_price_title =(item_price_title_ == "") ? ItmesArray[j].item_detail.item_prices_title : item_price_title_;
                        }else{
                            item_name_=ItmesArray[j].item_detail.item_name_english;
                            if (item_name_ == "" ){
                                item_name = ItmesArray[j].item_detail.item_name;
                            }else{
                                item_name = item_name_;
                                $(".english-flag").removeClass("hide-field");
                            }

                            item_desc_=ItmesArray[j].item_detail.item_desc_english;
                            item_desc = (item_desc_ == "") ?ItmesArray[j].item_detail.item_desc : item_desc_;

                            item_price_title_=ItmesArray[j].item_detail.item_prices_title_english;
                            item_price_title =(item_price_title_ == "") ? ItmesArray[j].item_detail.item_prices_title : item_price_title_;

                        }
                        for(let k1=0; k1<subCategories.length; k1++){

                            if (-1 !== ItmesArray[j].item_detail.sub_cat_ids.split(",").indexOf((subCategories[k1].sub_cat_id))){
                                subcatdiv+='<div class=" my-2 mr-2">';
                                subcatdiv+=        '<div class="badge badge-success">'+subCategories[k1].sub_category_name+'</div>';
                                subcatdiv+='</div>';
                            }
                        }
                        item_allergens = "";
                        for(let k2=0; k2<allergens.length; k2++){
                            if (-1 !== ItmesArray[j].item_detail.item_allergens.split(",").indexOf((allergens[k2].allergen_id))){
                                if (lang == "english"){
                                    allergen_filed_ = allergens[k2].allergen_name_english;
                                    if (allergen_filed_ == ""){
                                        allergen_filed_ = allergens[k2].allergen_name;
                                    }
                                }else if (lang == "germany"){
                                    allergen_filed_ = allergens[k2].allergen_name_germany;
                                    if (allergen_filed_ == ""){
                                        allergen_filed_ = allergens[k2].allergen_name;
                                    }
                                }else{
                                    allergen_filed_ = allergens[k2].allergen_name_french;
                                    if (allergen_filed_ == ""){
                                        allergen_filed_ = allergens[k2].allergen_name;
                                    }
                                }
                                item_allergens+=        '<div class="badge badge-success">'+allergen_filed_+'</div>';
                            }
                        }

                        

                        item_price_title_arr = item_price_title.split(',');
                        for(let k=0; k<item_price_title_arr.length; k++){
                            var itemPrice=response.data[i].items[j].item_price[k];
                            if(itemPrice!=''){
                                div+='<div class="d-flex mt-1 col p-0">';
                                if (item_price_title_arr[k] !== ""){
                                    div+=        '<div class="mr-2 overflow-hidden text-truncate text-nowrap jc-food_description"><b>'+item_price_title_arr[k]+'</b></div>';
                                    select_box +='<option value="'+k+'" data-price="'+itemPrice+'">' + item_price_title_arr[k]+'&emsp;';
                                }else{
                                    select_box +='<option value="'+k+'" data-price="'+itemPrice+'">';
                                }
                                div+='<div class=""><span class="prct p-0 d-inline-flex">'+parseFloat(itemPrice).toFixed(2).replace(".", ",")+' <span class=""> '+currentRestCurrencySymbol+'</span></span></div>';
                                select_box +=parseFloat(itemPrice).toFixed(2).replace(".", ",")+' <span class=""> '+currentRestCurrencySymbol+'</option>';
                                div+='</div>';
                                show_price_select = "";
                            }else{
                                show_price_select = "hide-field";
                            }
                        }
                        select = '<p class="'+show_price_select+'">Please Choose : </p>';
                        select +='<select class="form-control item-price-select  '+show_price_select+'">';
                        select += select_box;
                        select +='</select>';

                        span='<span class="prct">'+td+'</span>';
                        
                        if(item_type=="Vegetarian"){
                            var cls="text-success";
                            item_type = "<?= $this->lang->line("Vegetarian")?>";
                        }else if(item_type=="Vegan"){
                            var cls="text-warning";
                            item_type = "<?= $this->lang->line("Vegan")?>";
                        }else{
                            var cls="d-none";
                        }

                        var wishlist = '<div class="px-4 col-3 text-left text-danger wishlist" data-id = "'+item_id+'">'+
                            '<span class="text-danger p-1 mb-1" onclick="show_qty_field('+item_id+')">'+
                                '<i class="fa fa-heart"></i>'+
                            '</span>'+
                        '</div>';

                        var wishlist_wrap = '<div class="col-7 input-group p-0 justify-content-center"><span class="btn btn-success w-100"  onclick="addWishlist('+item_id+')">Add to Wishlist</span></div>';

                        var cart = '<div class="px-4 col-3 text-left text-danger wishlist" data-id = "'+item_id+'">'+
                            '<span class="text-danger p-1 mb-1" onclick="show_qty_field('+item_id+')">'+
                                '<i class="fa fa-shopping-cart"></i>'+
                            '</span>'+
                        '</div>';
                        
                        var cart_wrap = '<div class="col-7 input-group p-0 justify-content-center"><span class="btn btn-success w-100 addcart-btn"  onclick="addCart('+item_id+')">Add to Cart</span></div>';

                        if (mode == "table"){
                            wishlist_or_cart = wishlist;
                            wishlist_or_cart_wrap = wishlist_wrap;
                        }else{
                            wishlist_or_cart = cart;
                            wishlist_or_cart_wrap = cart_wrap;
                        }

                        if (item_allergens == ""){
                            info_visible = "hide-field";
                        }else{
                            info_visible = "";
                        }
                        if (item_image == "samplefood.png" || item_image == ""){
                            var item_image_wrap = "";
                        }else{
                            var item_image_wrap = '<div class="col-5 p-2 text-right '+(item_image !== "samplefood.png" ? "":"d-none") +'">'+
                                        '<div class="img-wh-wrap">'+
                                            '<img src="'+base_url+item_image+'" alt=""  class="rounded img-fluid w-100 img-wh" onerror="this.style.display=\'none\'">'+
                                        '</div>'+
                                    '</div>';
                        }
                        var listitem=''+
                            '<div class="MenU_li mb-0 MenU_li_member" data-item_id="'+item_id+'">'+
                                '<div class="meal-wrap">'+
                                    '<div class="pl-2"><h5 class="item_name jc-food">'+item_name+'</h5></div>'+
                                    '<div class="row m-0">'+
                                        '<div class="col px-2 py-1">'+
                                            '<div class=""><div class="d-flex">'+
                                                subcatdiv+
                                            '</div><small class="item_desc jc-food_description">'+item_desc+'</small>'+
                                            '</div>'+
                                            '<div class="mt-3">'+
                                                div+
                                            '</div>'+
                                        '</div>'+
                                        item_image_wrap+
                                    '</div>'+
                                '</div>'+
                                '<div class="meal-menucard_sidedish_btn_">'+
                                '</div>'+
                            '</div>'+
                            '<div class="mt-0 fnt14 pb-2 '+show_blue_bar+'">'+
                                '<div class="row mt-2 mx-0 w-100">'+
                                    wishlist_or_cart+
                                    '<div class="px-2 col-9 text-right">'+
                                        '<small class="UHU_p text-primary jc-food_info">'+
                                            '<span class="ml-1 qrCode '+info_visible+'"><i class="fas fa-plus-circle"></i> Info</span>'+
                                            '<span class="ml-1 '+cls+'">'+item_type+'</span>'+
                                        '</small>'+
                                        '<div class="show_Allergens">'+
                                        '<p>'+item_allergens+'</p>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>'+
                            '</div>'+
                            '<div class="mt-0 qty_field_wrap qty_field_wrap_'+item_id +'" data-item-id = "'+item_id +'">'+
                                '<div class="row  pb-2 p-md-3 p-2 mt-2 mx-0 w-100">'+
                                    '<div class="px-2 col-md-12 mt-2">'+
                                        select+
                                    '</div>'+
                                    '<div class="px-2 col-md-8 mx-auto mt-3 food-extra-field">'+
                                    '</div>'+
                                    '<div class="px-2 col-md-12 text-right row m-0 mt-2">'+
                                        '<div class="col-5 input-group qty-field-wrap">'+
                                            '<input type="number" value="1" min="1" data-bts-mousewheel="true" class="form-control qty-field">'+
                                        '</div>'+
                                        wishlist_or_cart_wrap+
                                    '</div>'+
                                '</div>'+
                            '</div>';
                        $('.cattype_'+cattype_id+' .menuList_').append(listitem);
                        
                        item_extra_build(item_id,item_extras,item_price_title_arr.length);
                    }
                }
                $(".qty-field-wrap .qty-field").TouchSpin({
                    initval: 1,
                    buttondown_class: "btn btn-primary",
                    buttonup_class: "btn btn-primary",
                });
            }
            $(".right-side").addClass("box-shadow");
        }
    });
    init_function();
});
$(document).on("click",".cattypebtn",function(){
    var cattype = $(this).parent().attr("data-tab");
    $(".nav.nav-tabs li").removeClass("active");
    $(".nav.nav-tabs li a").removeClass("active");
    $("li[data-tab='"+cattype+"']").removeClass("active").addClass("active");
    $("li[data-tab='"+cattype+"'] a").removeClass("active").addClass("active");
    $("#category_id").html($("#category_id_"+cattype).html());
});
$(document).on("click",".MenU_li.MenU_li_member",function(){
    item_id = $(this).attr("data-item_id");
    if ($(this).hasClass("no_extra-menucard")){
        if ($(".j-menu-section").attr("data-menu-mode") == "table"){
            addWishlist(item_id);
        }else{
            addCart(item_id);
        }
    }else{
        $(this).toggleClass("active");
        $(".qty_field_wrap_" + item_id).toggleClass("expand_wrap");
    }
});
$(document).on('change','.category_id',function(){

    var category_id=$(this).val();
    var lang = $(".panel-section").attr("data-lang");
    var cattype = $(".panel-section.active").attr("data-type");
    var mode = $(".lgblueBck").attr("data-mode");

    if(category_id==0){
        location.reload();
        return;
    }
    var rest_id="<?=$myRestId?>";
    var cat_base_url="<?=base_url('assets/category_images/')?>";
    $.ajax({
        url:"<?=base_url('API/getAllMenuItemByCategory_')?>",
        type:"post",
        data:{rest_id:rest_id,lang:lang,category_id:category_id,dp_option:mode},
        success:function(response){
            
            response=JSON.parse(response);
            if(response.data.items.length>0){
                $('#'+cattype+' .menuList_').empty();
                categoryname_with_image = "";
                if (response.data.category_img){
                    category_image='<div class="" style="padding:unset">'+
                            '<div class="mt-2 img-wh-wrap w-100">'+
                            '<img class = "category_img w-100" src = "'+cat_base_url+response.data.category_img+'"  onerror="this.style.display=\'none\'">'
                            '</div>'+
                        '</div>';
                    categoryname_with_image = "categoryname_with_image";
                }
                var category_name='<div class="MenU_li MenU_li_title '+categoryname_with_image+'" >'+
                                '<div class="row ">'+
                                    '<div class="col text-danger"><span class="catStyle px-2">'+response.data.categoryDesc+'</span><div class="px-2 catDesc small text-left text-white">'+"hello world"+'</div></div>'+
                                '</div>'+
                            '</div>';
                $('#'+cattype+' .menuList_').append(category_image);
                $('#'+cattype+' .menuList_').append(category_name);
                $('.cattype_'+cattype).removeClass("hide-field");
                var base_url="<?=base_url('assets/menu_item_images/')?>";
                var allergens=response.data.allergens;

                for(let i=0; i<response.data.items.length; i++){
                    var subCategories=response.data.sub_categories;
                    var span='';
                    var div='';
                    var subcatdiv='';
                    var td="";
                    var select_box ="";
                    var item_id         =   response.data.items[i].item_detail.menu_id;
                    var item_image      =   response.data.items[i].item_detail.item_image;
                    var item_desc       =   response.data.items[i].item_detail.item_desc;
                    var item_type       =   response.data.items[i].item_detail.item_type;
                    var item_show_blue  =   response.data.items[i].item_detail.item_show_blue;
                    var item_extras     =   response.data.items[i].item_detail.item_food_extra;

                    if (item_show_blue == "on"){
                        show_blue_bar = "";
                    }else{
                        show_blue_bar = "hide-field";
                    }
                    if (response.data.items[i].item_detail.item_name_english !== ""){
                        $(".english-flag").removeClass("hide-field");
                    }
                    if (response.data.items[i].item_detail.item_name_germany !== ""){
                        $(".germany-flag").removeClass("hide-field");
                    }
                    if (response.data.items[i].item_detail.item_name_french !== ""){
                        $(".french-flag").removeClass("hide-field");
                    }
                    if (lang == "french"){
                        item_name_tra_ =response.data.items[i].item_detail.item_name_french;
                        if (item_name_tra_ == "" ){
                            item_name_tra = response.data.items[i].item_detail.item_name;
                        }else{
                            item_name_tra = item_name_tra_;
                            $(".french-flag").removeClass("hide-field");
                        }

                        item_desc_tra =response.data.items[i].item_detail.item_desc_french;
                        item_price_title=response.data.items[i].item_detail.item_prices_title_french;
                    }else if (lang == "germany"){
                        item_name_tra_ =response.data.items[i].item_detail.item_name_germany;
                        if (item_name_tra_ == "" ){
                            item_name_tra = response.data.items[i].item_detail.item_name;
                        }else{
                            item_name_tra = item_name_tra_;
                            $(".germany-flag").removeClass("hide-field");
                        }

                        item_desc_tra =response.data.items[i].item_detail.item_desc_germany;
                        item_price_title=response.data.items[i].item_detail.item_prices_title_germany;
                    }else{
                        item_name_tra_ =response.data.items[i].item_detail.item_name_english;
                        if (item_name_tra_ == "" ){
                            item_name_tra = response.data.items[i].item_detail.item_name;
                        }else{
                            item_name_tra = item_name_tra_;
                            $(".english-flag").removeClass("hide-field");
                        }

                        item_desc_tra =response.data.items[i].item_detail.item_desc_english;
                        item_price_title=response.data.items[i].item_detail.item_prices_title_english;
                    }
                    for(let k1=0; k1<subCategories.length; k1++){
                        if (-1 !== response.data.items[i].item_detail.sub_cat_ids.split(",").indexOf((subCategories[k1].sub_cat_id))){
                            subcatdiv+='<div class=" my-2 mr-2">';
                            subcatdiv+=    '<div class="badge badge-success">'+subCategories[k1].sub_category_name+'</div>';
                            subcatdiv+='</div>';
                        }
                    }
                    item_allergens = "";
                    for(let k2=0; k2<allergens.length; k2++){
                        if (-1 !== response.data.items[i].item_detail.item_allergens.split(",").indexOf((allergens[k2].allergen_id))){
                            if (lang == "english"){
                                allergen_filed_ = allergens[k2].allergen_name_english;
                                if (allergen_filed_ == ""){
                                    allergen_filed_ = allergens[k2].allergen_name;
                                }
                            }else if (lang == "germany"){
                                allergen_filed_ = allergens[k2].allergen_name_germany;
                                if (allergen_filed_ == ""){
                                    allergen_filed_ = allergens[k2].allergen_name;
                                }
                            }else{
                                allergen_filed_ = allergens[k2].allergen_name_french;
                                if (allergen_filed_ == ""){
                                    allergen_filed_ = allergens[k2].allergen_name;
                                }
                            }
                            item_allergens+=        '<div class="badge badge-success">'+allergen_filed_+'</div>';
                        }
                    }
                    item_price_title_arr = item_price_title.split(',');
                    for(let k=0; k<item_price_title_arr.length; k++){
                        var itemPrice=response.data.items[i].item_price[k];
                        if(itemPrice!=''){
                            div+='<div class="d-flex mt-1 col p-0">';
                            if (item_price_title_arr[k] !== ""){
                                div+=        '<div class="mr-2 overflow-hidden text-truncate text-nowrap jc-food_description"><b>'+item_price_title_arr[k]+'</b></div>';
                                select_box +='<option value="'+k+'" data-price="'+itemPrice+'">' + item_price_title_arr[k]+'&emsp;';
                            }else{
                                select_box +='<option value="'+k+'" data-price="'+itemPrice+'">';
                            }
                            div+='<div class=""><span class="prct p-0 d-inline-flex">'+parseFloat(itemPrice).toFixed(2).replace(".", ",")+' <span class=""> '+currentRestCurrencySymbol+'</span></span></div>';
                            select_box +=parseFloat(itemPrice).toFixed(2).replace(".", ",")+' <span class=""> '+currentRestCurrencySymbol+'</option>';
                            div+='</div>';
                            show_price_select = "";
                        }else{
                            show_price_select = "hide-field";
                        }
                    }
                    select = '<p class="'+show_price_select+'">Please Choose : </p>';
                    select +='<select class="form-control item-price-select  '+show_price_select+'">';
                    select += select_box;
                    select +='</select>';

                    span='<span class="prct">'+td+'</span>';

                    if(item_type=="Vegetarian"){
                        var cls="text-success";
                        item_type = "<?= $this->lang->line("Vegetarian")?>";
                    }else if(item_type=="Vegan"){
                        var cls="text-warning";
                        item_type = "<?= $this->lang->line("Vegan")?>";
                    }else{
                        var cls="d-none";
                    }
                    var wishlist = '<div class="px-4 col-3 text-left text-danger wishlist" data-id = "'+item_id+'">'+
                        '<span class="text-danger p-1 mb-1" onclick="show_qty_field('+item_id+')">'+
                            '<i class="fa fa-heart"></i>'+
                        '</span>'+
                    '</div>';

                    var wishlist_wrap = '<div class="col-7 input-group p-0 justify-content-center"><span class="btn btn-success w-100"  onclick="addWishlist('+item_id+')">Add to Wishlist</span></div>';

                    var cart = '<div class="px-4 col-3 text-left text-danger wishlist" data-id = "'+item_id+'">'+
                        '<span class="text-danger p-1 mb-1" onclick="show_qty_field('+item_id+')">'+
                            '<i class="fa fa-shopping-cart"></i>'+
                        '</span>'+
                    '</div>';
                    
                    var cart_wrap = '<div class="col-7 input-group p-0 justify-content-center"><span class="btn btn-success w-100 addcart-btn"  onclick="addCart('+item_id+')">Add to Cart</span></div>';

                    if (mode == "table"){
                        wishlist_or_cart = wishlist;
                        wishlist_or_cart_wrap = wishlist_wrap;
                    }else{
                        wishlist_or_cart = cart;
                        wishlist_or_cart_wrap = cart_wrap;
                    }

                    if (item_allergens == ""){
                        info_visible = "hide-field";
                    }else{
                        info_visible = "";
                    }
                    if (item_image == "samplefood.png" || item_image == ""){
                        var item_image_wrap = "";
                    }else{
                        var item_image_wrap = '<div class="col-5 p-2 text-right '+(item_image !== "samplefood.png" ? "":"d-none") +'">'+
                                    '<div class="img-wh-wrap">'+
                                        '<img src="'+base_url+item_image+'" alt=""  class="rounded img-fluid w-100 img-wh" onerror="this.style.display=\'none\'">'+
                                    '</div>'+
                                '</div>';
                    }
                    var listitem ='' + 
                        '<div class="MenU_li mb-0 MenU_li_member" data-item_id="'+item_id+'">'+
                            '<div class="meal-wrap">'+
                                '<div class="pl-2"><h5 class="item_name jc-food">'+item_name_tra+'</h5></div>'+
                                '<div class="row m-0">'+
                                    '<div class="col px-2 py-1">'+
                                        '<div class=""><div class="d-flex">'+
                                            subcatdiv+
                                        '</div><small class="item_desc jc-food_description">'+item_desc_tra+'</small>'+
                                        '</div>'+
                                        '<div class="mt-3">'+
                                        div+
                                        '</div>'+
                                    '</div>'+
                                '</div>'+
                                item_image_wrap+
                            '</div>'+
                            '<div class="meal-menucard_sidedish_btn_">'+
                            '</div>'+
                        '</div>'+
                        '<div class="mt-0 fnt14 pb-2 '+show_blue_bar+'">'+
                            '<div class="row mt-2 mx-0 w-100 ">'+
                                wishlist_or_cart+
                                '<div class="px-2 col-9 text-right">'+
                                    '<small class="UHU_p text-primary jc-food_info">'+
                                    '<span class="ml-1 qrCode '+info_visible+'"><i class="fas fa-plus-circle"></i> Info</span>'+
                                    '<span class="ml-1 '+cls+'">'+item_type+'</span>'+
                                    '</small>'+
                                    '<div class="show_Allergens">'+
                                    '<p>'+item_allergens+'</p>'+
                                    '</div>'+
                                '</div>'+
                            '</div>'+
                        '</div>'+
                        '<div class="mt-0 qty_field_wrap qty_field_wrap_'+item_id +'" data-item-id = "'+item_id +'">'+
                            '<div class="row  pb-2 p-md-3 p-2 mt-2 mx-0 w-100">'+
                                '<div class="px-2 col-md-12 mt-2">'+
                                    select+
                                '</div>'+
                                '<div class="px-2 col-md-8 mx-auto mt-3 food-extra-field">'+
                                '</div>'+
                                '<div class="px-2 col-md-12 text-right row m-0 mt-2">'+
                                    '<div class="col-5 input-group qty-field-wrap">'+
                                        '<input type="number" value="1" min="1" data-bts-mousewheel="true" class="form-control qty-field">'+
                                    '</div>'+
                                    wishlist_or_cart_wrap+
                                '</div>'+
                            '</div>'+
                        '</div>';
                    $('#'+cattype+' .menuList_').append(listitem);
                                        
                    item_extra_build(item_id,item_extras,item_price_title_arr.length);
                }
                $(".qty-field-wrap .qty-field").TouchSpin({
                    initval: 1,
                    buttondown_class: "btn btn-primary",
                    buttonup_class: "btn btn-primary",
                });
            }else{
                $('#'+cattype+' .menuList_').empty();
                var nod='<div class="alert alert-info">No Data Found</div>';
                $('#'+cattype+' .menuList_').append(listitem);
            }
        }
    });
});
$(document).on('change','.qty_field_wrap .food_extra_id',function(){
    item_id = $(this).parents(".qty_field_wrap").attr("data-item-id");
    changeAddCartBtnValue(item_id);
});
$(document).on('change','.qty_field_wrap .qty-field',function(){
    item_id = $(this).parents(".qty_field_wrap").attr("data-item-id");
    changeAddCartBtnValue(item_id);
});
$(document).on('touchspin.on.startspin','.qty_field_wrap .qty-field',function(){
    item_id = $(this).parents(".qty_field_wrap").attr("data-item-id");
    changeAddCartBtnValue(item_id);
});
$(document).on('change','.item-price-select',function(){
    item_row = $(this).parent().parent().parent();
    item_id = item_row.attr( "data-item-id");
    price_index = $(this).val();
    get_food_extra_list(item_id,price_index);
});
function item_extra_build(item_id,item_extras,item_price_length){
    if (item_extras !== "" && item_extras !== null){
        item_extras_arr = item_extras.split('|');
        if (item_extras_arr[0] !== "" && item_extras_arr[0] !== null){
            get_food_extra_list(item_id,0);
            // changeAddCartBtnValue(item_id);
        }else{
            changeAddCartBtnValue(item_id);
            if (item_price_length < 2) $(".MenU_li_member[data-item_id='"+item_id+"']").addClass("no_extra-menucard");
        }
    }else{
        changeAddCartBtnValue(item_id);
        if (item_price_length < 2) $(".MenU_li_member[data-item_id='"+item_id+"']").addClass("no_extra-menucard");
    }
}
function init_function(){
    cattype = $(".category-type-bar-wrap li.active").attr("data-tab");
    $("#category_id").html($("#category_id_"+cattype).html());
};
function changeAddCartBtnValue(item_id){
    item_wrap = $(".qty_field_wrap_" + item_id);
    var price = parseFloat(item_wrap.find(".item-price-select option:selected").attr("data-price"));
    food_extra_ids = item_wrap.find(".food_extra_id");
    for (let fei = 0; fei < food_extra_ids.length; fei++) {
        food_extra_id = food_extra_ids[fei];
        if ($(food_extra_id).prop("tagName") == "SELECT"){
            price += parseFloat($(food_extra_id).find("option:selected").attr("data-price"));
        }else if($(food_extra_id).prop("tagName") == "INPUT"){
            if ($(food_extra_id).prop("checked") == true){
                price += parseFloat($(food_extra_id).attr("data-price"));
            }
        }
    }
    if (isNaN(price)){
        price = 0;
    }
    qty = $(".qty_field_wrap_" + item_id + " .qty-field").val();
    item_wrap.find(".addcart-btn").html((price*qty).toFixed(2) + " <?=$currentRestCurrencySymbol?>");
    item_wrap.find(".addcart-btn").attr("data-total-price",price);
}
function addWishlist(item_id){
    ele = $(".wishlist[data-id='"+ item_id + "']");
    ele_select = $(".qty_field_wrap_"+item_id+" select");
    ele_qty = $(".qty_field_wrap_"+item_id+" .qty-field");
    price_index = ele_select.val();
    price_qty = ele_qty.val();

    ele_extra_select = $(".qty_field_wrap_"+item_id+" select.food_extra_id");
    extra_ids_arr = [];
    extra_ids_arr_ = [];
    if (ele_extra_select.length > 0){
        for (let ieis = 0; ieis < ele_extra_select.length; ieis++) {
            extra_ids_arr.push($(ele_extra_select[ieis]).val());
        }
    }

    ele_extra_check = $(".qty_field_wrap_"+item_id+" input.food_extra_id[type='checkbox']:checked");
    if (ele_extra_check.length > 0){
        for (let ieic = 0; ieic < ele_extra_check.length; ieic++) {
            extra_ids_arr.push($(ele_extra_check[ieic]).attr("data-value"));
        }
    }
    for (let exi = 0; exi < extra_ids_arr.length; exi++) {
        ef = false;
        for (let exj = 0; exj < extra_ids_arr_.length; exj++) {
            if (extra_ids_arr[exi] == extra_ids_arr_[exj]){
                ef = true;
            }
        }
        if (!ef){
            extra_ids_arr_.push(extra_ids_arr[exi]);
        }
    }
    extra_ids = extra_ids_arr_.join("|");
    $.ajax({
        url:"<?=base_url('API/addWishlist')?>",
        type:"post",
        data:{item_id:item_id ,price_index:price_index,price_qty: price_qty,extra_ids : extra_ids},
        success:function(response){
            response=JSON.parse(response);
            if(response.status==1){
                swal("<?= $this->lang->line('Great..')?>","<?= $this->lang->line('Add to Wishlist Successfully.')?>","<?= $this->lang->line('success')?>");
                setInterval(function(){
                    location.reload();
                },1500);
            }else{
                swal("<?= $this->lang->line('Ooops..')?>","<?= $this->lang->line('Something went wrong')?>","<?= $this->lang->line('error')?>");
            }
        }
    });
}
function addCart(item_id){
    ele = $(".wishlist[data-id='"+ item_id + "']");
    ele_select = $(".qty_field_wrap_"+item_id+" select");
    ele_qty = $(".qty_field_wrap_"+item_id+" .qty-field");
    ele_extra = $(".qty_field_wrap_"+item_id+" .food_extra_id");
    var dp_option = $(".lgblueBck").attr("data-mode");
    price_index = ele_select.val();
    price_qty = ele_qty.val();

    ele_extra_select = $(".qty_field_wrap_"+item_id+" select.food_extra_id");
    extra_ids_arr = [];
    extra_ids_arr_ = [];
    if (ele_extra_select.length > 0){
        for (let ieis = 0; ieis < ele_extra_select.length; ieis++) {
            extra_ids_arr.push($(ele_extra_select[ieis]).val());
        }
    }

    ele_extra_check = $(".qty_field_wrap_"+item_id+" input.food_extra_id[type='checkbox']:checked");
    if (ele_extra_check.length > 0){
        for (let ieic = 0; ieic < ele_extra_check.length; ieic++) {
            extra_ids_arr.push($(ele_extra_check[ieic]).attr("data-value"));
        }
    }
    for (let exi = 0; exi < extra_ids_arr.length; exi++) {
        ef = false;
        for (let exj = 0; exj < extra_ids_arr_.length; exj++) {
            if (extra_ids_arr[exi] == extra_ids_arr_[exj]){
                ef = true;
            }
        }
        if (!ef){
            extra_ids_arr_.push(extra_ids_arr[exi]);
        }
    }
    extra_ids = extra_ids_arr_.join("|");
    
    $.ajax({
        url:"<?=base_url('API/addCart')?>",
        type:"post",
        data:{item_id:item_id ,price_index:price_index,price_qty: price_qty,extra_ids : extra_ids, dp_option: dp_option},
        success:function(response){
            response=JSON.parse(response);

            if(response.status==1){
                swal("<?= $this->lang->line('Great..')?>","<?= $this->lang->line('Add to Cart Successfully.')?>","<?= $this->lang->line('success')?>");
                setInterval(function(){
                    location.reload();
                },1500);
            }else if(response.status==2){
                if (dp_option == "Delivery"){
                    // swal("<?= $this->lang->line('Ooops..')?>","First, please insert your shipping address.","<?= $this->lang->line('error')?>");
                    $("#insertShippingAddressForm .jc-add_cart_enter_addressbtn").attr("data-item_id",item_id);
                    $("#insertShippingAddressForm").modal("show");
                    
                }
            }else{
                swal("<?= $this->lang->line('Ooops..')?>","<?= $this->lang->line('Something went wrong')?>","<?= $this->lang->line('error')?>");
            }
        }
    });
}
function show_qty_field(item_id){
    $(".qty_field_wrap_" + item_id).toggleClass("hide-field");
}
</script>
