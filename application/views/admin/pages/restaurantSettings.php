
<div class="container">
    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
        
            <div class="col-lg-12">
                <div class="p-5">
                <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4"><?= $this->lang->line("Restaurant logo")?></h1>
                    <hr>
                </div>
                <form class="user" id="uploadMyLogo">
                    <div class="form-group row">
                    <div class="col-md-5">
                        <input type="file" name="rest_logo">
                    </div>
                    
                    <select class="form-control" name="rest_id" <?= $rest_id > 0 ? "disabled" : "" ?>>
                        <option value="0"><?= $this->lang->line("Select Restaurant")?></option>
                        <?php foreach($addRest as $res): ?>
                        <option value="<?=$res->rest_id?>" <?= $res->rest_id == $rest_id ? "selected" : "" ?>><?=$res->rest_name?></option>
                        <?php endforeach;?>
                    </select>
                    </div>
                    
                
                    <input type="submit" value="Update Data" class="btn btn-primary btn-user btn-block">
        
                
                </form>
                <br>
                <h1 class="h4 text-gray-900 mb-4"><?= $this->lang->line("Restaurant Details")?></h1>
                    <hr>
                <form  id="updateRestDetailByAdmin">
                    <div class="form-group row">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <label><?= $this->lang->line("Select Restaurant")?></label>
                            <?php 
                                if ($rest_id > 0 ){ ?>
                                    <input type="hidden" placeholder="<?= $this->lang->line("Restaurant Name")?>" name="rest_id" id="rest_id" value="<?=$rest_id?>">
                                    <select class="form-control rest_select" name = "rest_id_" <?= $rest_id > 0 ? "disabled" : "" ?>>
                            <?php }else{ ?>
                                    <select class="form-control rest_select" name="rest_id" id="rest_id" <?= $rest_id > 0 ? "disabled" : "" ?>>
                            <?php }?>
                                <option value="0"><?= $this->lang->line("Select Restaurant")?></option>
                                <?php foreach($addRest as $res): ?>
                                <option value="<?=$res->rest_id?>"  <?= $res->rest_id == $rest_id ? "selected" : "" ?>><?=$res->rest_name?></option>
                                <?php endforeach;?>
                            </select>
                        </div>
                    </div>
                    
                        
                
                    <div class="form-group row">
                    <div class="col-sm-6 mb-3 mb-sm-0">
                        <label><?= $this->lang->line("Restaurant Name")?></label>
                        <input type="text" class="form-control form-control-user"  placeholder="<?= $this->lang->line("Restaurant Name")?>" name="rest_name" id="rest_name" value="">
                    </div>
                    <div class="col-sm-6 mb-3 mb-sm-0">
                        <label><?= $this->lang->line("Restaurant Email")?></label>
                        <input type="email" class="form-control form-control-user" id="rest_email" placeholder="<?= $this->lang->line("Restaurant Email")?>" name="rest_email" value="">
                    </div>
                    
                    </div>
                    <div class="form-group row">
                    <div class="col-sm-6 mb-3 mb-sm-0">
                        <label><?= $this->lang->line("Restaurant Owner Name")?></label>
                    <input type="text" name="rest_owner_name" id="rest_owner_name" class="form-control form-control-user" placeholder="<?= $this->lang->line("Restaurant Owner")?>" value="" >
                    </div>
                    <div class="col-sm-6 mb-3 mb-sm-0">
                        <label><?= $this->lang->line("Restaurant Owner Contact No")?></label>
                        <input type="text" class="form-control form-control-user"  placeholder="<?= $this->lang->line("Restaurant Owner Mobile")?>" name="rest_owner_contact" id="rest_owner_contact" value="">
                    </div>
                    
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <label><?= $this->lang->line("Restaurant Address")?> (Number/Street)</label>
                            <input type="text" name="rest_address1" id="rest_address1" class="form-control form-control-user" placeholder="<?= $this->lang->line("Restaurant Address")?>" value="" >
                        </div>
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <label><?= $this->lang->line('Restaurant Address2')?> (Location/Postcode)</label>
                            <input type="text" name="rest_address2" id="rest_address2" class="form-control form-control-user" placeholder="<?= $this->lang->line('Restaurant Address')?>" value="" >
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <label><?= $this->lang->line("Restaurant Establishment Year")?></label>
                            <input type="text" class="form-control form-control-user"  placeholder="<?= $this->lang->line("Restaurant Establishment Year")?>" name="rest_est_year" id="rest_est_year" value="">
                        </div>
                    
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <label><?= $this->lang->line("Restaurant Contact No.")?></label>
                            <input type="text" class="form-control form-control-user" placeholder="<?= $this->lang->line("Restaurant Contact No.")?>" name="rest_contact" id="rest_contact" value="">
                        </div>
                    
                    </div>
                    
                    <div class="form-group row">
                        <div class="col-sm-6">
                            <label><?= $this->lang->line("New Password")?></label>
                            <input type="password" class="form-control form-control-user" id="NewPassword" placeholder="<?= $this->lang->line("New Password")?>" name="newpassword" value="">
                        </div>
                        
                        <div class="col-sm-6">
                            <label><?= $this->lang->line("Confirm Password")?></label>
                            <input type="password" class="form-control form-control-user" id="ConfirmPassword" placeholder="<?= $this->lang->line("Confirm Password")?>" name="confirmpassword" value="">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6">
                            <label>My Domain ( without Http:// , Https:// or www)</label>
                            <input type="text" class="form-control form-control-user"  id ="rest_domain" name="rest_domain" value="" placeholder="mydomain.com">
                        </div>
                        <div class="col-sm-6">
                            <label>Domain Status</label>
                            <div class="w-100 row">
                                <div class="col-sm-3">
                                    <label>Active</label>
                                    <input type="radio" id ="domain_status_active" name="domain_status" value = "active" class="domain_status">
                                </div>
                                <div class="col-sm-3">
                                    <label>Pending</label>
                                    <input type="radio" id ="domain_status_inactive" name="domain_status" value = "inactive" class="domain_status" checked>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <div class="col-sm-6">
                            <label>URL</label>
                            <input type="text" class="form-control form-control-user"  id ="rest_url_slug" name="rest_url_slug" placeholder="URL" value="" readonly>
                        </div>
                        <div class="col-sm-6">
                            <label><?= $this->lang->line('Delivery and Pickup for Restaurant User')?></label>
                            <div class="w-100 row">
                                <div class="col-sm-3">
                                    <label><?= $this->lang->line('Delivery')?></label>
                                    <input type="radio" id ="dp_option_delivery" name="dp_option" value = "1">
                                </div>
                                <div class="col-sm-3">
                                    <label><?= $this->lang->line('Pickup')?></label>
                                    <input type="radio" id ="dp_option_pickup" name="dp_option" value = "2">
                                </div>
                                <div class="col-sm-3">
                                    <label>Both</label>
                                    <input type="radio" id ="dp_option_both" name="dp_option" value = "3">
                                </div>
                                <div class="col-sm-3">
                                    <label>Deactive</label>
                                    <input type="radio" id ="dp_option_deactive" name="dp_option" value = "4">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <label><span><?= $this->lang->line("Status : ")?> </span><span id="res_Status"></span> </label>
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
    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
            <div class="row">
                <div class="col-lg-12">
                    <div class="p-5">
                        <form class="color" id="updateColor" data-base-url = "<?=base_url()?>">
                        
                            <input type="hidden" value = "" name="myRestId">
                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0 px-sm-5">
                                    <label><?= $this->lang->line('Price')?> <?= $this->lang->line('Color')?> </label>
                                    <div class="row">
                                        <input class="form-control col-9" value="" name="price_color" data-jscolor="{alphaElement:'#alp1'}">
                                        <input class="form-control col-3" id="alp1" value="" name="price_color_alpha">
                                    </div>
                                </div>
                                <div class="col-sm-6 mb-3 mb-sm-0 px-sm-5">
                                    <label><?= $this->lang->line('BlueLine')?> <?= $this->lang->line('Background')?> <?= $this->lang->line('Color')?></label>
                                    <div class="row">
                                        <input class="form-control col-9" value="" name="blueline_color" data-jscolor="{alphaElement:'#alp2'}">
                                        <input class="form-control col-3" id="alp2" value="" name="blueline_color_alpha">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0 px-sm-5">
                                    <label><?= $this->lang->line('Category')?> <?= $this->lang->line('Background')?> <?= $this->lang->line('Color')?></label>
                                    <div class="row">
                                        <input class="form-control col-9" value="" name="category_bg_color" data-jscolor="{alphaElement:'#alp3'}">
                                        <input class="form-control col-3" id="alp3" value="" name="category_bg_color_alpha">
                                    </div>
                                </div>
                                <div class="col-sm-6 mb-3 mb-sm-0 px-sm-5">
                                    <label><?= $this->lang->line('Category')?> <?= $this->lang->line('Color')?></label>
                                    <div class="row">
                                        <input class="form-control col-9" value="" name="category_color" data-jscolor="{alphaElement:'#alp4'}">
                                        <input class="form-control col-3" id="alp4" value="" name="category_color_alpha">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0 px-sm-5">
                                    <label><?= $this->lang->line('Tab Button')?> <?= $this->lang->line('Background')?> <?= $this->lang->line('Color')?></label>
                                    <div class="row">
                                        <input class="form-control col-9" value="" name="tabbtn_bg_color" data-jscolor="{alphaElement:'#alp5'}">
                                        <input class="form-control col-3" id="alp5" value="" name="tabbtn_bg_color_alpha">
                                    </div>
                                </div>
                                <div class="col-sm-6 mb-3 mb-sm-0 px-sm-5">
                                    <label><?= $this->lang->line('Tab Button')?> <?= $this->lang->line('Color')?></label>
                                    <div class="row">
                                        <input class="form-control col-9" value="" name="tabbtn_color" data-jscolor="{alphaElement:'#alp6'}">
                                        <input class="form-control col-3" id="alp6" value="" name="tabbtn_color_alpha">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0 px-sm-5">
                                    <label><?= $this->lang->line('Active')?> <?= $this->lang->line('Tab Button')?> <?= $this->lang->line('Background')?> <?= $this->lang->line('Color')?></label>
                                    <div class="row">
                                        <input class="form-control col-9" value="" name="active_tabbtn_bg_color" data-jscolor="{alphaElement:'#alp7'}">
                                        <input class="form-control col-3" id="alp7" value="" name="active_tabbtn_bg_color_alpha">
                                    </div>
                                </div>
                                <div class="col-sm-6 mb-3 mb-sm-0 px-sm-5">
                                    <label><?= $this->lang->line('Active')?> <?= $this->lang->line('Tab Button')?> <?= $this->lang->line('Color')?></label>
                                    <div class="row">
                                        <input class="form-control col-9" value="" name="active_tabbtn_color" data-jscolor="{alphaElement:'#alp8'}">
                                        <input class="form-control col-3" id="alp8" value="" name="active_tabbtn_color_alpha">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0 px-sm-5">
                                    <label><?= $this->lang->line('Wishlist Button')?> <?= $this->lang->line('Background')?> <?= $this->lang->line('Color')?></label>
                                    <div class="row">
                                        <input class="form-control col-9" value="" name="wishlist_tab_bg_color" data-jscolor="{alphaElement:'#alp9'}">
                                        <input class="form-control col-3" id="alp9" value="" name="wishlist_tab_bg_color_alpha">
                                    </div>
                                </div>
                                <div class="col-sm-6 mb-3 mb-sm-0 px-sm-5">
                                    <label><?= $this->lang->line('Wishlist Button')?> <?= $this->lang->line('Color')?></label>
                                    <div class="row">
                                        <input class="form-control col-9" value="" name="wishlist_tab_color" data-jscolor="{alphaElement:'#alp10'}">
                                        <input class="form-control col-3" id="alp10" value="" name="wishlist_tab_color_alpha">
                                    </div>
                                </div>
                            </div>
                            <input type="submit" value="<?= $this->lang->line('Update Data')?>" class="btn btn-primary btn-user btn-block">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).on('submit','#uploadMyLogo',function(e){
        e.preventDefault();
        var formData= new FormData($(this)[0]);
        $.ajax({
        url:"<?=base_url('API/addLogoByAdmin')?>",
        type:"post",
        processData:false,
        cache:false,
        contentType:false,
        enctype:"multipart/form-data",
        data:formData,
        success:function(response){
            
            response=JSON.parse(response);
            if(response.status==1){
            swal("Great..","Logo Added Successfully.","success");
            }else{
            swal("Ooops..","Something went wrong","error");
            }
            setInterval(function(){
            location.reload();
            },1500);
        }
        })
    });
    $(document).on('submit','#updateRestDetailByAdmin',function(e){

        if ($("#NewPassword").val() == $("#ConfirmPassword").val()){
            var formData= new FormData($(this)[0]);
            $.ajax({
                url:"<?=base_url('API/updateRestDetailByAdmin')?>",
                type:"post",
                processData:false,
                cache:false,
                contentType:false,
                enctype:"multipart/form-data",
                data:formData,
                success:function(response){
                    
                    response=JSON.parse(response);
                    if(response.code==1){
                    swal("Great..","Data Updated Successfully.","success");
                    }else{
                    swal("Ooops..","Something went wrong","error");
                    }
                    // setInterval(function(){
                    //   location.reload();
                    // },1500);
                }
            })
        }else{
            swal("<?= $this->lang->line('Ooops..')?>","<?= $this->lang->line('Password is not matched.')?>","<?= $this->lang->line('error')?>");
        }
        e.preventDefault();
        
    });
    $('.domain_status').on('change',function(){
        $("#rest_url_slug").val($(".domain_status:checked").attr("data-url")); 
    });

    $('.rest_select').on('change',function(){
        var rest_id=$(this).val();
        // alert("Activate "+rest_id);
        $("#myRestId").val(rest_id);
        $.ajax({
            url:"<?=base_url('API/getRestDetails')?>",
            type:"post",
            data:{rest_id:rest_id},
            success:function(response){
                console.log(response);
                response=JSON.parse(response);
                // console.log(response.data.length);
                if(response.code==1){
                    $('#rest_name').val(response.data.rest_name); 
                    $('#rest_email').val(response.data.rest_email);
                    $('#rest_owner_name').val(response.data.owner_name);
                    $('#rest_owner_contact').val(response.data.rest_contact_no);
                    $('#rest_address1').val(response.data.address1);
                    $('#rest_address2').val(response.data.address2);
                    $('#rest_est_year').val(response.data.establishment_year);
                    $('#res_Status').text(response.data.activation_status);
                    $('#rest_contact').val(response.data.rest_contact_no);
                    $('#rest_url_slug').val("<?=base_url("view/")?>"+response.data.rest_url_slug);
                    $('#rest_domain').val(response.data.rest_domain);

                    $('input[name="price_color"]').val(response.data.price_color);
                    $('input[name="blueline_color"]').val(response.data.blueline_color);
                    $('input[name="category_color"]').val(response.data.category_color);
                    $('input[name="category_bg_color"]').val(response.data.category_bg_color);
                    $('input[name="tabbtn_bg_color"]').val(response.data.tabbtn_bg_color);
                    $('input[name="tabbtn_color"]').val(response.data.tabbtn_color);
                    $('input[name="price_color_alpha"]').val(response.data.price_color_alpha);
                    $('input[name="blueline_color_alpha"]').val(response.data.blueline_color_alpha);
                    $('input[name="category_color_alpha"]').val(response.data.category_color_alpha);
                    $('input[name="category_bg_color_alpha"]').val(response.data.category_bg_color_alpha);
                    $('input[name="tabbtn_bg_color_alpha"]').val(response.data.tabbtn_bg_color_alpha);
                    $('input[name="tabbtn_color_alpha"]').val(response.data.tabbtn_color_alpha);
                    $('input[name="active_tabbtn_color"]').val(response.data.active_tabbtn_color);
                    $('input[name="active_tabbtn_bg_color"]').val(response.data.active_tabbtn_bg_color);
                    $('input[name="active_tabbtn_color_alpha"]').val(response.data.active_tabbtn_color_alpha);
                    $('input[name="active_tabbtn_bg_color_alpha"]').val(response.data.active_tabbtn_bg_color_alpha);
                    $('input[name="wishlist_tab_color"]').val(response.data.wishlist_tab_color);
                    $('input[name="wishlist_tab_color_alpha"]').val(response.data.wishlist_tab_color_alpha);
                    $('input[name="wishlist_tab_bg_color"]').val(response.data.wishlist_tab_bg_color);
                    $('input[name="wishlist_tab_bg_color_alpha"]').val(response.data.wishlist_tab_bg_color_alpha);
                    
                    if (response.data.dp_option == 1){
                        $('#dp_option_delivery').attr("checked","true");
                    }else if(response.data.dp_option == 2){
                        $('#dp_option_pickup').attr("checked","true");
                    }else if(response.data.dp_option == 3){
                        $('#dp_option_both').attr("checked","true");
                    }else{
                        $('#dp_option_deactive').attr("checked","true");
                    }

                    if (response.data.domain_status == "active"){
                        $('#domain_status_active').attr("checked","true");
                        $('#rest_url_slug').val("http://www." + response.data.rest_domain + "/" + "view/");
                    }else {
                        $('#domain_status_inactive').attr("checked","true");
                        $('#rest_url_slug').val("<?=base_url("view/")?>"+response.data.rest_url_slug);
                    }
                    
                    $('#domain_status_inactive').attr("data-url","<?=base_url("view/")?>"+response.data.rest_url_slug);
                    $('#domain_status_active').attr("data-url","http://www." + response.data.rest_domain + "/" + "view/");

                }else{
                    swal("Ooops..","Something went wrong","error");
                }
            
            }
        })
    });
    <?php
        if ($rest_id>0){ ?>
            $(document).ready(function() {
                
                var rest_id=<?= $rest_id?>;
                $("input[name = 'myRestId']").val(rest_id);
                $("input[name = 'myRestId']").val(rest_id);
                $.ajax({
                    url:"<?=base_url('API/getRestDetails')?>",
                    type:"post",
                    data:{rest_id:rest_id},
                    success:function(response){
                        response=JSON.parse(response);
                        if(response.code==1){
                            $('#rest_name').val(response.data.rest_name); 
                            $('#rest_email').val(response.data.rest_email);
                            $('#rest_owner_name').val(response.data.owner_name);
                            $('#rest_owner_contact').val(response.data.rest_contact_no);
                            $('#rest_address').val(response.data.address);
                            $('#rest_est_year').val(response.data.establishment_year);
                            $('#res_Status').text(response.data.activation_status);
                            $('#rest_contact').val(response.data.rest_contact_no);
                            $('#rest_domain').val(response.data.rest_domain);
                            
                            $('input[name="price_color"]').val(response.data.price_color);
                            $('input[name="blueline_color"]').val(response.data.blueline_color);
                            $('input[name="category_color"]').val(response.data.category_color);
                            $('input[name="category_bg_color"]').val(response.data.category_bg_color);
                            $('input[name="tabbtn_bg_color"]').val(response.data.tabbtn_bg_color);
                            $('input[name="tabbtn_color"]').val(response.data.tabbtn_color);
                            $('input[name="price_color_alpha"]').val(response.data.price_color_alpha);
                            $('input[name="blueline_color_alpha"]').val(response.data.blueline_color_alpha);
                            $('input[name="category_color_alpha"]').val(response.data.category_color_alpha);
                            $('input[name="category_bg_color_alpha"]').val(response.data.category_bg_color_alpha);
                            $('input[name="tabbtn_bg_color_alpha"]').val(response.data.tabbtn_bg_color_alpha);
                            $('input[name="tabbtn_color_alpha"]').val(response.data.tabbtn_color_alpha);
                            $('input[name="active_tabbtn_color"]').val(response.data.active_tabbtn_color);
                            $('input[name="active_tabbtn_bg_color"]').val(response.data.active_tabbtn_bg_color);
                            $('input[name="active_tabbtn_color_alpha"]').val(response.data.active_tabbtn_color_alpha);
                            $('input[name="active_tabbtn_bg_color_alpha"]').val(response.data.active_tabbtn_bg_color_alpha);
                            $('input[name="wishlist_tab_color"]').val(response.data.wishlist_tab_color);
                            $('input[name="wishlist_tab_color_alpha"]').val(response.data.wishlist_tab_color_alpha);
                            $('input[name="wishlist_tab_bg_color"]').val(response.data.wishlist_tab_bg_color);
                            $('input[name="wishlist_tab_bg_color_alpha"]').val(response.data.wishlist_tab_bg_color_alpha);
                            
                            if (response.data.dp_option == 1){
                                $('#dp_option_delivery').attr("checked","true");
                            }else if(response.data.dp_option == 2){
                                $('#dp_option_pickup').attr("checked","true");
                            }else if(response.data.dp_option == 3){
                                $('#dp_option_both').attr("checked","true");
                            }else {
                                $('#dp_option_deactive').attr("checked","true");
                            }

                            if (response.data.domain_status == "active"){
                                $('#domain_status_active').attr("checked","true");
                                $('#rest_url_slug').val("http://www." + response.data.rest_domain + "/" + "view/");
                            }else {
                                $('#domain_status_inactive').attr("checked","true");
                                $('#rest_url_slug').val("<?=base_url("view/")?>"+response.data.rest_url_slug);
                            }
                            $('#domain_status_inactive').attr("data-url","<?=base_url("view/")?>"+response.data.rest_url_slug);
                            $('#domain_status_active').attr("data-url","http://www." + response.data.rest_domain + "/" + "view/");
                        }else{
                        }
                    }
                })
            });
    <?php } ?>
    
</script>

