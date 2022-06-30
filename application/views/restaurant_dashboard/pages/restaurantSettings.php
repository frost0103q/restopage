
<div class="container">
    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="p-5">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4"><?= $this->lang->line('Restaurant logo')?></h1>
                            <hr>
                        </div>
                        <form class="user" id="uploadMyLogo">
                            <input type="hidden" class="form-control form-control-user"   name="rest_id" value="<?=$restDetails->rest_id?>">
                            <div class="form-group row">
                                <div class="col-md-6 mb-3 mb-sm-0">
                                    <!-- <input type="file" name="rest_logo"> -->
                                    <?php
                                        if ($restDetails->rest_logo !== ""){
                                            $logo_image = base_url("assets/rest_logo/").$restDetails->rest_logo;
                                        }else{
                                            $logo_image = "";
                                        }
                                    ?>
                                    <label><h5>Logo</h5></label>
                                    <input type="file" class="dropify" name="rest_logo" data-default-file = "<?= $logo_image ?>" value = "<?= $logo_image ?>"/>
                                    <input type="hidden" name="is_update_rest_logo" value = "<?= $logo_image == "" ? "1" : "0"?>" />
                                </div>
                                <div class="col-md-6 mb-3 mb-sm-0">
                                    <?php
                                        if ($restDetails->rest_favicon !== ""){
                                            $favicon_image = base_url("assets/rest_favicon/").$restDetails->rest_favicon;
                                        }else{
                                            $favicon_image = "";
                                        }
                                    ?>
                                    <label><h5>Favicon</h5></label>
                                    <input type="file" class="dropify" name="rest_favicon" data-default-file = "<?= $favicon_image ?>" value = "<?= $favicon_image ?>"/>
                                    <input type="hidden" name="is_update_rest_favicon" value = "<?= $favicon_image == "" ? "1" : "0"?>" />
                                </div>
                            </div>
                            <input type="submit" value="<?= $this->lang->line('Update Data')?>" class="btn btn-primary btn-user btn-block">
                        </form>
                        <br>
                        <h1 class="h4 text-gray-900 mb-4 mt-5 text-center"><?= $this->lang->line('Restaurant Details')?></h1>
                        <hr>
                        <form  id="restDetaila">
                            <div class="form-group row">
                                <input type="hidden" class="form-control form-control-user"   name="rest_id" value="<?=$restDetails->rest_id?>">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <label><?= $this->lang->line('Restaurant Name')?></label>
                                    <input type="text" class="form-control form-control-user"  placeholder="<?= $this->lang->line('Restaurant Name')?>" name="rest_name" value="<?=$restDetails->rest_name?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <label><?= $this->lang->line('Restaurant Email')?></label>
                                    <input type="email" class="form-control form-control-user" id="restEmail" placeholder="<?= $this->lang->line('Restaurant Email')?>" name="rest_email" value="<?=$restDetails->rest_email?>" readonly>
                                </div>
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <label><?= $this->lang->line('Restaurant Email')?> <?= $this->lang->line('Contact')?> <?= $this->lang->line('Email')?></label>
                                    <input type="email" class="form-control form-control-user" id="restContactEmail" placeholder="<?= $this->lang->line('Restaurant Email')?> <?= $this->lang->line('Contact')?> <?= $this->lang->line('Email')?>" name="rest_contact_email" value="<?=$restDetails->rest_contact_email?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <label><?= $this->lang->line('Restaurant Owner Name')?></label>
                                <input type="text" name="rest_owner_name" class="form-control form-control-user" placeholder="<?= $this->lang->line('Restaurant Owner Name')?>" value="<?=$restDetails->owner_name?>" >
                                </div>
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <label><?= $this->lang->line('Restaurant Owner Contact No')?></label>
                                    <input type="text" class="form-control form-control-user"  placeholder="<?= $this->lang->line('Restaurant Owner Mobile')?>" name="rest_owner_contact" value="<?=$restDetails->owner_mobile?>">
                                </div>
                            
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <label><?= $this->lang->line('Restaurant Address')?> (Number/Street)</label>
                                    <input type="text" name="rest_address1" class="form-control form-control-user <?= isset($restDetails->address1) && $restDetails->address1 !== "" ? "": "init_complete_address" ?> auto_complete_address" placeholder="<?= $this->lang->line('Restaurant Address')?>" value="<?=$restDetails->address1?>">
                                </div>
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <label><?= $this->lang->line('Restaurant')?> GeoCode</label>
                                    <input type="text" name="rest_geocode" class="form-control form-control-user <?= isset($restDetails->geocode) && $restDetails->geocode !== "" ? "": "init_complete_geocode" ?> auto_complete_geocode" value='<?=$restDetails->geocode?>' readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <label><?= $this->lang->line('Restaurant Establishment Year')?></label>
                                    <input type="text" class="form-control form-control-user"  placeholder="<?= $this->lang->line('Restaurant Establishment Year')?>" name="rest_est_year" value="<?=$restDetails->establishment_year?>">
                                </div>
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <label><?= $this->lang->line('Restaurant Contact No.')?></label>
                                    <input type="text" class="form-control form-control-user" placeholder="<?= $this->lang->line('Restaurant Contact No.')?>" name="rest_contact" value="<?=$restDetails->rest_contact_no?>">
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <label><?= $this->lang->line("New Password")?></label>
                                    <input type="password" class="form-control form-control-user" id="NewPassword" placeholder="<?= $this->lang->line("New Password")?>" name="newpassword" value="">
                                </div>
                                
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <label><?= $this->lang->line("Confirm Password")?></label>
                                    <input type="password" class="form-control form-control-user" id="ConfirmPassword" placeholder="<?= $this->lang->line("Confirm Password")?>" name="confirmpassword" value="">
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <label><?= $this->lang->line("Currency")?></label>
                                    <?php 
                                        $countries = $this->db->where("NOT ISNULL(currency_code) AND currency_code <> ''")->get("tbl_countries")->result();
                                        $currency_id = $restDetails->currency_id > 0 ? $restDetails->currency_id : 120;
                                        $current_currency_country = $this->db->where('id',$currency_id)->get("tbl_countries")->row();
                                    ?>
                                    <div class="row">
                                        <div class="col-md-6 mb-3 mb-sm-0">
                                            <div class="input-group country_select_box">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="img-thumbnail flag flag-icon-background flag-icon-<?= strtolower($current_currency_country->abv) ?> country_flag"></i></span>
                                                </div>
                                                <select class="form-control form-control-user country_select currency_code_select_box" name="country">
                                                    <?php  foreach ($countries as $key => $country) { ?>
                                                        <option value="<?= $country->id?>" data-country_code = "<?= strtolower($country->abv) ?>" data-currency_symbol = "<?= strtolower($country->currency_symbol) ?>" <?= $current_currency_country->id == $country->id ? "selected" : "" ?>><?= $country->name?></option>    
                                                    <?php  } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3 mb-sm-0">
                                            <div class="input-group currency_select_box">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text currency_symbol"> <?= $current_currency_country->currency_symbol ?></span>
                                                </div>
                                                <select class="form-control form-control-user currency_select currency_code_select_box" name="currency">
                                                    <?php  foreach ($countries as $key => $country) { ?>
                                                        <option value="<?= $country->id?>" data-country_code = "<?= strtolower($country->abv) ?>" data-currency_symbol = "<?= strtolower($country->currency_symbol) ?>"  <?= $current_currency_country->id == $country->id ? "selected" : "" ?>><?= $country->currency_name?> (<?= $country->currency_symbol?>) </option>    
                                                    <?php  } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <div class="row">
                                        <div class="col-md-6 mb-3 mb-sm-0">
                                            <label>Date Format</label>
                                            <div class="input-group date_format">
                                                <select class="form-control form-control-user date_format_select" name="date_format">
                                                    <?php  
                                                    $date_format_arr = array(
                                                        "F j, Y",
                                                        "Y-m-d",
                                                        "d-m-Y",
                                                        "m-d-Y",
                                                        "Y.m.d",
                                                        "d.m.Y",
                                                        "m.d.Y",
                                                        "Y/m/d",
                                                        "d/m/Y",
                                                        "m/d/Y",
                                                        "Y-n-j",
                                                        "j-n-Y",
                                                        "n-j-Y",
                                                        "Y.n.j",
                                                        "j.n.Y",
                                                        "n.j.Y",
                                                        "Y/n/j",
                                                        "j/n/Y",
                                                        "n/j/Y",
                                                    );

                                                    foreach ($date_format_arr as $date_format) { ?>
                                                        <option value="<?= $date_format?>" <?= $restDetails->date_format == $date_format ? "selected" : "" ?>><?= $date_format ?> (<?= date($date_format)?>) </option>    
                                                    <?php  } ?>
                                                </select>
                                            </div>
                                        </div>          
                                        <?php if (in_array("date_time",$addon_features)){ ?>
                                            <div class="col-md-6 mb-3 mb-sm-0">
                                                <label>Time Format</label>
                                                <div class="input-group time_format">
                                                    <select class="form-control form-control-user time_format_select" name="time_format">
                                                        <option value="H:i" <?= $restDetails->time_format == "H:i" ? "selected" : "" ?>>24:00</option>    
                                                        <option value="h:i A" <?= $restDetails->time_format == "h:i A" ? "selected" : "" ?>>12:00 (AM/PM)</option>    
                                                    </select>
                                                </div>
                                            </div>   
                                        <?php } ?>       
                                    </div>
                                </div>
                            </div>
          
                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <?php if ($restDetails->resto_plan == 'pro'){ ?>
                                    <label class="d-flex justify-content-start align-items-center">
                                            <input type="checkbox" id ="allow_ontable_show" name="allow_ontable_show" <?= $restDetails->ontable_show ? "checked" : "" ?> value="on">
                                            <span class="ml-2 text-capitalize"><?= $this->lang->line('allow')?> <?= $this->lang->line('show')?> <?= $this->lang->line('onTable')?></span>
                                        </label>
                                    <?php }?>
                                    <label class="d-flex justify-content-start align-items-center">
                                        <input type="checkbox" id ="allow_guest_order" name="allow_guest_order" <?= $restDetails->allow_guest_order ? "checked" : "" ?> value="on">
                                        <span class="ml-2 text-capitalize"><?= $this->lang->line('allow')?> <?= $this->lang->line('Guest')?> <?= $this->lang->line('Order')?></span>
                                    </label>
                                </div>
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <!-- <label><span>Pre <?= $this->lang->line('Order')?></span></label> -->
                                    <label class="d-flex justify-content-start align-items-center flex-direction-row">
                                        <input type="checkbox" id ="pre_order" name="pre_order" <?= $restDetails->pre_order ? "checked" : "" ?> value="on"> <span class="ml-2">Enable Order while Restaurant close</span>
                                    </label>
                                    <label class="d-flex justify-content-start align-items-center flex-direction-row">
                                        <input type="checkbox" id ="open_pre_order" name="open_pre_order" <?= $restDetails->open_pre_order ? "checked" : "" ?> value="on"> <span class="ml-2">Enable Order while Restaurant open</span>
                                    </label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <?php if ($restDetails->resto_plan == 'pro'){ ?>
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <label><?= $this->lang->line('Delivery and Pickup for Restaurant User')?></label>
                                        <div class="w-100 row">
                                            <!-- <div class="col-sm-3">
                                                <label>None</label>
                                                <input type="radio" id ="dp_option_none" name="dp_option" value = "0"  <?= $restDetails->dp_option == "0" ? "checked" : "" ?>>
                                            </div> -->
                                            <div class="col-sm-3">
                                                <label><?= $this->lang->line('Delivery')?></label>
                                                <input type="radio" id ="dp_option_delivery" name="dp_option" value = "1" <?= $restDetails->dp_option == "1" ? "checked" : "" ?>>
                                            </div>
                                            <div class="col-sm-3">
                                                <label><?= $this->lang->line('Pickup')?></label>
                                                <input type="radio" id ="dp_option_pickup" name="dp_option" value = "2"  <?= $restDetails->dp_option == "2" ? "checked" : "" ?>>
                                            </div>
                                            <div class="col-sm-3">
                                                <label>Both</label>
                                                <input type="radio" id ="dp_option_both" name="dp_option" value = "3"  <?= $restDetails->dp_option == "3" ? "checked" : "" ?>>
                                            </div>
                                            <div class="col-sm-3">
                                                <label>Deactive</label>
                                                <input type="radio" id ="dp_option_deactive" name="dp_option" value = "4"  <?= $restDetails->dp_option == "4" ? "checked" : "" ?>>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <label><span><?= $this->lang->line('Status : ')?></span> <span class="badge badge-info"><?=$restDetails->activation_status?></span></label>
                                </div>
                                <div class="col-sm-6 mb-3 mb-sm-0 d-none">
                                    <label>Device Tokens</label>
                                    <div class=""><pre><?php print_r(explode(",",$restDetails->device_tokens))?></pre></div>
                                </div>
                            </div>
                            <input type="submit"  value="<?= $this->lang->line('Update Data')?>" class="btn btn-primary btn-user btn-block">
                        </form>
                        <hr>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    <script>
        function initialize() {
            var options = {
            };

            var input = document.getElementsByClassName('auto_complete_address')[0];
            var autocomplete = new google.maps.places.Autocomplete(input, options);
            google.maps.event.addListener(autocomplete, 'place_changed', function () {
                var place = autocomplete.getPlace();
                var lat = place.geometry.location.lat();
                var lng = place.geometry.location.lng();
                rest_geocode = {lat: lat, lng: lng};
                $(".auto_complete_geocode").val(JSON.stringify(rest_geocode));
            });
        }
        google.maps.event.addDomListener(window, 'load', initialize);
        if ("geolocation" in navigator){ //check Geolocation available 
            navigator.geolocation.getCurrentPosition(function(position){ 
                console.log("Found your location \nLat : "+position.coords.latitude+" \nLong :"+ position.coords.longitude);
                rest_geocode = {lat: position.coords.latitude, lng: position.coords.longitude};
                $(".init_complete_geocode").val(JSON.stringify(rest_geocode));
                var lat = position.coords.latitude;
                var lng = position.coords.longitude;
                var google_map_position = new google.maps.LatLng( lat, lng );
                var google_maps_geocoder = new google.maps.Geocoder();
                google_maps_geocoder.geocode(
                    { 'latLng': google_map_position },
                    function( results, status ) {
                        $(".init_complete_address").val(results[0].formatted_address);
                    }
                );
            });
        }else{
            console.log("Geolocation is not available!");
        }
    </script>

