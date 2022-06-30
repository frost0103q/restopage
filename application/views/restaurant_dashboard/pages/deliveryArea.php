<div class="container delivery_area_page">
	<div class="card o-hidden border-0 shadow-lg my-5">
		<div class="card-body p-md-5 p-3">
            <div class="row">
                <div class="col-md-12 d-flex justify-content-between align-items-center">
                    <h1 class="h4 text-gray-900"><?= $this->lang->line('Add')?> <?= $this->lang->line('Delivery Area')?></h1>            
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a href="#postcodes_panel" data-toggle="tab" aria-expanded="false" class="nav-link">
                                <span class="d-block d-sm-none"><i class="fa fa-envelope"></i></span>
                                <span class="d-none d-sm-block"> <i class="fa fa-envelope"></i> By Postcodes</span>            
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#deliveryzones_panel" data-toggle="tab" aria-expanded="true" class="nav-link active">
                                <span class="d-block d-sm-none"><i class="fa fa-shapes"></i></span>
                                <span class="d-none d-sm-block"> <i class="fa fa-shapes"></i> Delivery Zones</span> 
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <hr class="mt-0">
            <form id="addDeliveryArea">
                <div class="tab-content">
                    <section id="deliveryzones_panel" class="tab-pane active">
                        <div class="row">
                            <div style="height: 600px;" class="col-md-8">
                                <div id="map" style="height: 600px;" class=" border"></div>
                            </div>
                            <div class="col-md-4 d-flex">
                                <div class="zone_bar w-100">
                                    <a class="text-success btn add-another-zone-btn"><u>Add another zone ?</u></a>
                                </div>
                            </div>
                        </div>
                    </section>
                    <section id="postcodes_panel" class="tab-pane">
                        <input type="hidden" class="form-control form-control-user" id="rest_id" name="rest_id" value="<?=$myRestId?>">
                        <div class="row">
                            <div class="col-md-4  mt-4">
                                <label><?= $this->lang->line('Country')?> <span class="text-danger">*</span></label>
                                <select class="form-control form-control-user" name="country_for_postcode" id="country_for_postcode">
                                    <option >Select Country</option>
                                    <?php
                                        $countries = $this->db->get("tbl_countries")->result();
                                        foreach ($countries as $ck => $cvalue) {
                                            echo '<option value = "'.$cvalue->name.'">'.$cvalue->name.'</option>';
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-4 mt-4">
                                <label><?= $this->lang->line('Post Code')?> <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-user" id="postcode" placeholder="<?= $this->lang->line('Enter ZipCode / PostCode')?>" name="postcode" required>
                            </div>    
                        </div>
                        <div class="row">
                            <div class="col-md-4 mt-4">
                                <label><?= $this->lang->line('Area Name')?>(English)</label>
                                <div class="input-group">
                                    <input type="text" class="form-control form-control-user" id="areaname_english" name="areaname_english" >
                                    <div class="input-group-append">
                                        <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/en-flag.png')?>"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 mt-4">
                                <label><?= $this->lang->line('Area Name')?>(French)</label>
                                <div class="input-group">
                                    <input type="text" class="form-control form-control-user" id="areaname_french" name="areaname_french" >
                                    <div class="input-group-append">
                                        <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/fr-flag.png')?>"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 mt-4">
                                <label><?= $this->lang->line('Area Name')?>(Germany)</label>
                                <div class="input-group">
                                    <input type="text" class="form-control form-control-user" id="areaname_germany"  name="areaname_germany" >
                                    <div class="input-group-append">
                                        <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/ge-flag.png')?>"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 mt-4">
                                <label><?= $this->lang->line('Minimum Order Amount')?> <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number" class="form-control form-control-user" id="minimum_order_amount" placeholder="<?= $this->lang->line('Enter Min Order')?>" name="minimum_order_amount" required min="0" step="0.01">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><?= $currentRestCurrencySymbol?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 mt-4">
                                <label><?= $this->lang->line('Delivery Charge')?> <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number" class="form-control form-control-user" id="delivery_charge" placeholder="<?= $this->lang->line('Enter Delivery Charge')?>" name="delivery_charge" required min="0" step="0.01">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><?= $currentRestCurrencySymbol?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 mt-4">
                                <label><?= $this->lang->line('Delivery Time')?></label>
                                <div class="input-group">
                                    <input type="text" class="form-control form-control-user" id="delivery_time" placeholder="<?= $this->lang->line('Enter Delivery Time')?>" name="delivery_time">
                                    <div class="input-group-append">
                                        <span class="input-group-text">min</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mt-4">
                                <label><?= $this->lang->line('Minimum Order Amount for Free Delivery Charge')?></label>
                                <div class="input-group">
                                    <input type="number" class="form-control form-control-user" id="min_order_amount_free_delivery" placeholder="<?= $this->lang->line('Minimum Order Amount for Free Delivery Charge')?>" name="min_order_amount_free_delivery" min="0" step="0.01">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><?= $currentRestCurrencySymbol?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="submit"  value="<?= $this->lang->line('Add')?> <?= $this->lang->line('Delivery Area')?>" class="btn btn-primary mt-5 col-md-3">
                        <div class="card o-hidden my-5">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary"><?= $this->lang->line('Add')?> <?= $this->lang->line('Delivery')?> <?= $this->lang->line('Country')?></h6>
                            </div>
                            <div class="card-body p-md-4 p-3">
                                <form id="addDeliveryCountry">
                                    <div class="row">
                                        <input type="hidden" class="form-control form-control-user" name="rest_id" value="<?=$myRestId?>">
                                        <div class="col-md-6 mt-5">
                                            <label>Country <span class="text-danger">*</span></label>
                                        </div>
                                        
                                        <div class="col-md-6 mt-5">
                                            <select class="form-control form-control-user chosen-select-width" name="countries[]" id="countries" multiple>
                                                <?php
                                                    $dcountry = $this->db->where("rest_id = $myRestId")->get("tbl_delivery_countries")->row();
                                                    
                                                    if ($dcountry){
                                                        $dclist = explode(",",$dcountry->countries);
                                                    }else{
                                                        $dclist = array();
                                                    }
                                                    foreach ($countries as $ck => $cvalue) {
                                                        if (in_array($cvalue->abv,$dclist)){
                                                            echo '<option value = "'.$cvalue->abv.'" selected>'.$cvalue->name.'</option>';
                                                        }else{
                                                            echo '<option value = "'.$cvalue->abv.'">'.$cvalue->name.'</option>';
                                                        }
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                        <input type="submit"  value="<?= $this->lang->line('Add')?> <?= $this->lang->line('Delivery')?> Country" class="btn btn-primary mt-5 col-md-3">
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="card mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary"><?= $this->lang->line("Delivery Area List")?></h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered dataTable" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th class="text-center">#</th>
                                                <th class="text-center"><?= $this->lang->line("Country")?></th>
                                                <th class="text-center"><?= $this->lang->line("Area Name")?></th>
                                                <th class="text-center"><?= $this->lang->line("Delivery Charge")?> (<?= $currentRestCurrencySymbol?>)</th>
                                                <th class="text-center"><?= $this->lang->line("Delivery Time")?> (min)</th>
                                                <th class="text-center"><?= $this->lang->line("Min Order")?> (<?= $currentRestCurrencySymbol?>)</th>
                                                <th class="text-center"><?= $this->lang->line("Action")?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            $i = 1;
                                            foreach ($delivery_areas as $akey => $area) {
                                                $area_name = "area_name_" . $_lang;
                                                ?>
                                                <tr>
                                                    <td class="text-center"><?= $i++ ?></td>
                                                    <td class="text-center"><?=$area->area_country ?></td>
                                                    <td class="text-center"><?=$area->$area_name ?></td>
                                                    <td class="text-center"><?=$area->delivery_charge ?></td>
                                                    <td class="text-center"><?=$area->delivery_time ?></td>
                                                    <td class="text-center"><?=$area->min_order_amount?></td>
                                                    <td class="text-center">
                                                        <a href="<?=base_url('Restaurant/deliveryAreaDetail/').$area->id?>" title="<?= $this->lang->line('Edit')?>"><i class="fas fa-eye"></i></a>
                                                        <a href="javascript:void(0)" title="<?= $this->lang->line('Remove')?>" class="text-danger remove_deliveryarea" d-area_id="<?= $area->id ?>"><i class="fas fa-trash"></i></a>
                                                        <?php
                                                            if ($area->status == "deactive"){?>
                                                                <a href="javascript:void(0)" title="<?= $this->lang->line('Activate')?> <?= $this->lang->line('Delivery Area')?>" class="text-success activate_area" d-area_id="<?= $area->id ?>"><i class="fa fa-power-off"></i></a>
                                                            <?php }else{ ?>
                                                                <a href="javascript:void(0)" title="<?= $this->lang->line('Deactivate')?> <?= $this->lang->line('Delivery Area')?>" class="text-warning deactivate_area" d-area_id="<?= $area->id ?>"><i class="fa fa-power-off"></i></a>
                                                            <?php } 
                                                        ?>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    var delivery_areas =[];
    const lat = <?=$lat?>;
    const lng = <?=$lng?>;
    var myMap;
    $(document).on('click','.zone_bar .add-another-zone-btn',function(){
        if (typeof($(".zone_area:last").attr("data-area_index")) == "undefined"){
            area_index = 0;
        }else{
            area_index = parseInt($(".zone_area:last").attr("data-area_index")) + 1 ;
        } 
        randomColor = Math.floor(Math.random()*16777215).toString(16);
        new_ele = build_delivery_zone_html(area_index,0,"circle","#"+randomColor, 'Area '+area_index);
        $(this).before(new_ele);

        radius = (Math.random()*0.7 + 0.3).toFixed(2);
        centerpoint = new google.maps.LatLng(lat,lng);
        circle = new Circle(myMap,centerpoint,radius);
        circle.SetColor("#"+randomColor);
        circle.DrawingTools();

        delivery_areas[area_index] = circle;
        // polygon = new Polygon(myMap);
        // polygon.DrawingTools(randomColor);
        $(this).addClass("hide-field");
    });
    $(document).on('change','.zone_area input[type="radio"][name="delivery_area_zone_type"]',function(){
        area_index = $(this).parents(".zone_area").attr("data-area_index");
        delivery_areas[area_index].DeleteField();
        color = $(this).parents(".zone_area").find(".delivery-zone-color").attr("data-color");
        if ($(this).val() == "circle"){
            radius = (Math.random()*0.7 + 0.3).toFixed(2);

            centerpoint = new google.maps.LatLng(lat,lng);
            circle = new Circle(myMap,centerpoint,radius);
            circle.SetColor(color);
            circle.DrawingTools();

            delivery_areas[area_index] = circle;
        }else{
            polygon = new Polygon(myMap);
            polygon.SetColor(color);
            polygon.DrawingTools();
            delivery_areas[area_index] = polygon;
        }
    });
    $(document).on('click','.zone_bar .zone_area .accordion-head',function(){
        $(this).parent().toggleClass("active");
        area_index = $(this).parents(".zone_area").attr("data-area_index");
        if ($(this).parent().hasClass("active")){
            delivery_areas[area_index].FieldEditable(true);
            if (typeof(delivery_areas[area_index]) == typeof(new Circle)){
                delivery_areas[area_index].FieldShowInfo();
            }
        }else{
            delivery_areas[area_index].FieldEditable(false);
        }
    });
    $(document).on('click','.zone_bar .zone_area .del_area_btn',function(){
        area_index = $(this).parents(".zone_area").attr("data-area_index");
        area_id = $(this).parents(".zone_area").attr("data-area_id");
        is_ok_remove = false;
        base_url = $("footer").attr("data-url");
        rest_id = $("footer").attr("data-rest_id");
        if (area_id > 0){
            $.ajax({
                url:base_url + "API/removeDeliveryAreaZone",
                type:"post",
                data:{area_id:area_id,rest_id:rest_id},
                success:function(response){
                    response=JSON.parse(response);
                    if(response.status==1){
                        is_ok_remove = true;
                        $(".zone_area[data-area_id='"+area_id+"']").remove();
                        delivery_areas[area_index].DeleteField();
                        delivery_areas[area_index] = "";
                        toastr["success"]("Delivery Area Zone is deleted successfully.","Done");

                    }else{
                        is_ok_remove = false;
                        toastr["error"]("Something went wrong.","Error");
                    }
                }
            });
        }else{
            is_ok_remove = true;
            delivery_areas[area_index].DeleteField();
            area_index = $(this).parents(".zone_area").remove();
            delivery_areas[area_index] = "";
            toastr["success"]("Delivery Area Zone is deleted successfully.","Done");
            $(".zone_bar .add-another-zone-btn").removeClass("hide-field");
        }
    });
    $(document).on('click','.zone_bar .zone_area .save_area_btn',function(e){
        $(this).addClass("disabled").prop("disabled",true);
        zone_area = $(this).parents(".zone_area");
        area_index = zone_area.attr("data-area_index");
        area_id = zone_area.attr("data-area_id");
        type = zone_area.find('input[type="radio"][name="delivery_area_zone_type"]:checked').val();
        if (type=="shape"){
            zone_type = "shape";
            if (typeof (delivery_areas[area_index].myField) !== "undefined" ){
                coordinates = delivery_areas[area_index].myField.getPath().getArray();
                geo_data_arr = [];
                for (var i = 0; i < coordinates.length; i++) {
                    geo_data_arr.push({lat:coordinates[i].lat() , lng: coordinates[i].lng()});
                }
                geo_data = JSON.stringify(geo_data_arr);
            }else{
                toastr["error"]("Draw your areazone shape.","Error");
                is_ready = false;
            }
        }else{
            zone_type = "circle";
            geo_data_arr = {radius:delivery_areas[area_index].myField.getRadius() , center:delivery_areas[area_index].myField.getCenter()};
            geo_data = JSON.stringify(geo_data_arr);
        }
        area_name = zone_area.find('input[name="areaname"]').val();
        delivery_time = zone_area.find('input[name="delivery_time"]').val();
        minimum_order_amount = zone_area.find('input[name="minimum_order_amount"]').val();
        delivery_charge = zone_area.find('input[name="delivery_charge"]').val();
        min_order_amount_free_delivery = zone_area.find('input[name="min_order_amount_free_delivery"]').val();
        zone_color = zone_area.find('.delivery-zone-color').attr("data-color");
        
        is_ready = true;

        zone_area.find('.required-field').removeClass("is_empty_field");
        for (let index = 0; index < zone_area.find('.required-field').length; index++) {
            element = zone_area.find('.required-field')[index];
            if ($(element).val() == ""){
                toastr["error"]("<u class='text-uppercase'>" +$(element).prop("name") + "</u> is empty. Please enter the value.","Required Field");
                $(element).addClass("is_empty_field");
                is_ready = false;
            }
        }
        if (is_ready){
            base_url = $("footer").attr("data-url");
            rest_id = $("footer").attr("data-rest_id");
            $.ajax({
                url:base_url + "API/updateDeliveryAreaZone",
                type:"post",
                data:{area_id:area_id,rest_id:rest_id,area_name:area_name,delivery_time:delivery_time,minimum_order_amount:minimum_order_amount,delivery_charge:delivery_charge,min_order_amount_free_delivery:min_order_amount_free_delivery,zone_type:zone_type,zone_color:zone_color,geo_data:geo_data},
                success:function(response){
                    response=JSON.parse(response);
                    if(response.status==1){
                        toastr["success"]("Delivery Area Zone is updated successfully.","Done");
                        zone_area.attr("data-area_id",response.area_id);
                        zone_area.find(".delivery-zone-title").html(area_name);

                        delivery_areas[area_index].FieldEditable(false);
                        zone_area.find(".accordion-head").click();
                        $(".zone_bar .add-another-zone-btn").removeClass("hide-field");
                    }else{
                        toastr["error"]("Something went wrong.","Error");
                    }
                }
            })
        }
        $(this).removeClass("disabled").prop("disabled",false);
        // console.log(area_name,delivery_time,minimum_order_amount,delivery_charge,min_order_amount_free_delivery);
        
    });
    $(document).on('click','.zone_bar .zone_area .cancel_area_btn',function(e){
        base_url = $("footer").attr("data-url");
        rest_id = $("footer").attr("data-rest_id");
        area_index = $(this).parents(".zone_area").attr("data-area_index");
        area_id = $(this).parents(".zone_area").attr("data-area_id");
        $.ajax({
            url:base_url + "API/getDeliveryAreaZone",
            type:"post",
            data:{rest_id:rest_id,area_id:area_id},
            success:function(response){
                response=JSON.parse(response);
                area_zone = response.area_zone;
                drawEachAreaShape(area_zone,area_index,false);

            }
        })
    });
    function initialize() {
        centerpoint = new google.maps.LatLng(lat,lng);
        var mapOptions = {
            zoom: 13, 
            center: centerpoint, 
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        myMap = new google.maps.Map(
            document.getElementById('map'), 
            mapOptions
        );
        marker = new google.maps.Marker({
            position: { lat: lat, lng: lng },
            // myMap,
            title: "Restaurant",
        });
        marker.setMap(myMap);
        toastr.options = {
            "closeButton": false,
            "debug": false,
            "newestOnTop": true,
            "progressBar": false,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "500",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }
        drawAreaShapes(); 
    }
    function drawAreaShapes(){
        base_url = $("footer").attr("data-url");
        rest_id = $("footer").attr("data-rest_id");
        $.ajax({
            url:base_url + "API/getDeliveryAreaZone",
            type:"post",
            data:{rest_id:rest_id},
            success:function(response){
                response=JSON.parse(response);
                area_zones = response.area_zones;
                for (let area_index = 0; area_index < area_zones.length; area_index++) {
                    area_zone = area_zones[area_index];
                    drawEachAreaShape(area_zone,area_index);
                }
            }
        })
    }

    // new_nf : true - add newly
    // new_nf : false - reset / replace with original value from db
    function drawEachAreaShape(area_zone,area_index,new_nf = true){

        new_ele = build_delivery_zone_html(area_index,area_zone.id,area_zone.zone_type,area_zone.zone_color,area_zone.area_name ,area_zone.delivery_time ,area_zone.minimum_order_amount ,area_zone.delivery_charge ,area_zone.min_order_amount_free_delivery,"original" );
        if (new_nf){
            $(".zone_bar .add-another-zone-btn").before(new_ele);
        }else{
            $(".zone_bar .zone_area[data-area_index='"+area_index+"']").replaceWith(new_ele);
            delivery_areas[area_index].DeleteField();
        }
        zone_geo_data = JSON.parse(area_zone.zone_geo_data);
        if (area_zone.zone_type == "circle"){
            radius = zone_geo_data.radius / 1000;
            centerpoint = new google.maps.LatLng(zone_geo_data.center.lat,zone_geo_data.center.lng);
            circle = new Circle(myMap,centerpoint,radius);
            circle.SetColor(area_zone.zone_color);

            circle.DrawField();
            delivery_areas[area_index] = circle;
        }else{
            paths = zone_geo_data;
            polygon = new Polygon(myMap);
            polygon.SetColor(area_zone.zone_color);
            polygon.DrawField(paths);

            delivery_areas[area_index] = polygon;
        }
    }
    function build_delivery_zone_html(area_index,area_id,zone_type,color,area_name = "",delivery_time = "",minimum_order_amount = "",delivery_charge = "",min_order_amount_free_delivery = "" , is_new = "new"){
        if (zone_type == 'circle'){
            circle_label_selected = "selected";
            circle_checked = "checked='checked'";
            shape_label_selected = "";
            shape_checked = "";
        }else{
            shape_label_selected = "selected";
            shape_checked = "checked='checked'";
            circle_label_selected = "";
            circle_checked = "";
        }
        if (is_new == "new"){
            open_accordian = "active";
            cancel_btn="";
        }else{
            cancel_btn=' <span class="btn btn-warning w-100 cancel_area_btn">Cancel</span>  ';
            open_accordian = "";
        }
        new_ele = "";
            new_ele += '<div class="zone_area border mb-2 '+open_accordian+'" data-area_index = "'+area_index+'" data-area_id = "'+area_id+'">';
            new_ele += '    <div class="accordion-head d-flex align-items-center p-3">';
            new_ele += '        <div class="delivery-zone-color" data-color="'+color+'" style="background: '+color+'"></div>';
            new_ele += '        <div class="delivery-zone-title">'+area_name+'</div>';
            new_ele += '    </div>';
            new_ele += '    <div class="accordion_panel p-3">';
            new_ele += '        <form>';
            new_ele += '        <div class="d-flex">';
            new_ele += '            <label class="text-center border p-2 d-table w-50 delivery_area_zone_type '+circle_label_selected+'"><input type="radio" class="hide-field" name="delivery_area_zone_type" value="circle" data-type="circle" '+circle_checked+' />Circle</label>';
            new_ele += '            <label class="text-center border p-2 d-table w-50 delivery_area_zone_type '+shape_label_selected+'"><input type="radio" class="hide-field" name="delivery_area_zone_type" value="shape" data-type="shape" '+shape_checked+'/>Shape</label>';
            new_ele += '        </div>';
            new_ele += '        <div class ="row d-flex align-items-center mt-2">';
            new_ele += '            <div class="col-5"><label><?= $this->lang->line('Area Name')?> <span class="text-danger">*</span></label></div>';
            new_ele += '            <div class="col-7">';
            new_ele += '                <div class="input-group">';
            new_ele += '                    <input type="text" class="form-control form-control-user required-field" name="areaname" placeholder = "zone name" value="'+area_name+'" required>';
            new_ele += '                </div>';
            new_ele += '            </div>';
            new_ele += '        </div>';
                    
            new_ele += '        <div class ="row d-flex align-items-center mt-2">';
            new_ele += '            <div class="col-5"><label><?= $this->lang->line('Delivery Time')?></label></div>';
            new_ele += '            <div class="col-7">';
            new_ele += '                <div class="input-group">';
            new_ele += '                    <input type="text" class="form-control form-control-user" placeholder="30" name="delivery_time" value="'+delivery_time+'">';
            new_ele += '                    <div class="input-group-append">';
            new_ele += '                        <span class="input-group-text">min</span>';
            new_ele += '                    </div>';
            new_ele += '                </div>';
            new_ele += '            </div>';
            new_ele += '        </div>';
            new_ele += '        <div class ="row d-flex align-items-center mt-2">';
            new_ele += '            <div class="col-5"><label><?= $this->lang->line('Minimum Order Amount')?> <span class="text-danger">*</span></label></div>';
            new_ele += '            <div class="col-7">';
            new_ele += '                <div class="input-group">';
            new_ele += '                    <input type="number" class="form-control form-control-user required-field" placeholder="14.99" name="minimum_order_amount" value="'+minimum_order_amount+'" required="" min="0" step="0.01">';
            new_ele += '                    <div class="input-group-append">';
            new_ele += '                        <span class="input-group-text"><?= $currentRestCurrencySymbol?></span>';
            new_ele += '                    </div>';
            new_ele += '                </div>';
            new_ele += '            </div>';
            new_ele += '        </div>';
            new_ele += '        <div class ="row d-flex align-items-center mt-2">';
            new_ele += '            <div class="col-5"><label><?= $this->lang->line('Delivery Charge')?> <span class="text-danger">*</span></label></div>';
            new_ele += '            <div class="col-7">';
            new_ele += '                <div class="input-group">';
            new_ele += '                    <input type="number" class="form-control form-control-user required-field" placeholder="2.5" name="delivery_charge" value="'+delivery_charge+'" required="" min="0" step="0.01">';
            new_ele += '                    <div class="input-group-append">';
            new_ele += '                        <span class="input-group-text"><?= $currentRestCurrencySymbol?></span>';
            new_ele += '                    </div>';
            new_ele += '                </div>';
            new_ele += '            </div>';
            new_ele += '        </div>';
            new_ele += '        <label class="mt-4">( for free delivery )</label>';
            new_ele += '        <hr class="mt-0">';
            new_ele += '        <div class ="row d-flex align-items-center mt-2">';
            new_ele += '            <div class="col-5">';
            new_ele += '                <label><?= $this->lang->line('Minimum Order Amount')?></label>';
            new_ele += '            </div>';
            new_ele += '            <div class="col-7">';
            new_ele += '                <div class="input-group">';
            new_ele += '                    <input type="number" class="form-control form-control-user" placeholder="49.99" name="min_order_amount_free_delivery" value="'+min_order_amount_free_delivery+'" min="0" step="0.01">';
            new_ele += '                    <div class="input-group-append">';
            new_ele += '                        <span class="input-group-text"><?= $currentRestCurrencySymbol?></span>';
            new_ele += '                    </div>';
            new_ele += '                </div>';
            new_ele += '            </div>';
            new_ele += '        </div>';
            new_ele += '        <div class="row mt-4">';
            new_ele += '            <div class="col-md-4"> <span class="btn btn-danger w-100 del_area_btn">Delete</span> </div>';
            new_ele += '            <div class="col-md-4">'+cancel_btn+'</div>';
            new_ele += '            <div class="col-md-4"> <span class="btn btn-success w-100 save_area_btn">Save</span>  </div>';
            new_ele += '        </div>';
            new_ele += '        </form>';
            new_ele += '    </div>';
            new_ele += '</div>';
        return new_ele;
    }
    //(function(){ initialize(); })();
    $(document).ready(function() {
        initialize();
    });
</script>
