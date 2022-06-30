// modify by jfrost
// Size the parent iFrame
function iframeResize() {
    var height = $('body').outerHeight(); // IMPORTANT: If body's height is set to 100% with CSS this will not work.
    parent.postMessage(height,"*");
}
// ------------------------------Smooth scroll------------------------------
$(document).ready(function () {
	// Add smooth scrolling to all links
	$("a.j-scroll-effect").on('click', function (event) {
		if (this.hash !== "") {
			event.preventDefault();
			var hash = this.hash;
			$('html, body').animate({
				scrollTop: $(hash).offset().top
			}, 800, function () {
				window.location.hash = hash;
			});
		}
    });


});
// ------------------------------Website Page frontend-------------------------------
// function([string1, string2],target id,[color1,color2])    
$(document).ready(function() {
    if ($(".slider-welcome-section").length){
        consoleText(['Welcome to our Restopage.', 'Enjoy your meal.', 'Order your food online now.'], 'slider-welcome-section', ['tomato', 'rebeccapurple', 'lightblue']);
        function consoleText(words, id, colors) {
            if (colors === undefined) colors = ['#fff'];
            var visible = true;
            var con = document.getElementById('console');
            var letterCount = 1;
            var x = 1;
            var waiting = false;
            var target = document.getElementById(id)
            target.setAttribute('style', 'color:' + colors[0])
            window.setInterval(function () {
        
                if (letterCount === 0 && waiting === false) {
                    waiting = true;
                    target.innerHTML = words[0].substring(0, letterCount)
                    window.setTimeout(function () {
                        var usedColor = colors.shift();
                        colors.push(usedColor);
                        var usedWord = words.shift();
                        words.push(usedWord);
                        x = 1;
                        target.setAttribute('style', 'color:' + colors[0])
                        letterCount += x;
                        waiting = false;
                    }, 1000)
                } else if (letterCount === words[0].length + 1 && waiting === false) {
                    waiting = true;
                    window.setTimeout(function () {
                        x = -1;
                        letterCount += x;
                        waiting = false;
                    }, 1000)
                } else if (waiting === false) {
                    target.innerHTML = words[0].substring(0, letterCount)
                    letterCount += x;
                }
            }, 120)
            window.setInterval(function () {
                if (visible === true) {
                    visible = false;
                } else {
                    visible = true;
                }
            }, 400)
        }
    }
});
$('.menuList_ input[name="dp_option"]').on('change',function(e){
    base_url = $("#userLogin").attr("data-url");
    rest_url_slug = $("#userLogin").attr("data-rest_url_slug");
    dp_option_url = base_url + "Home/cart/" + rest_url_slug + "/" + $(this).val();
    location.replace(dp_option_url);
});
$('.menuList input[name="dp_option"]').on('change',function(e){
    base_url = $("#userLogin").attr("data-url");
    rest_url_slug = $("#userLogin").attr("data-rest_url_slug");
    lang_surfix = $(this).attr("data-lang_surfix");
    dp_option_url = base_url + $(this).val() + "/" + rest_url_slug + "?lang=" + lang_surfix;
    location.replace(dp_option_url);
});
$('.Pisi .filter_icon').on('click',function(e){
    $(".Pisi .category_id").toggleClass("hide-on-sticky");
    $(".Pisi .item_key").toggleClass("hide-on-sticky");
});
$('#contact-us-form').on('submit',function(e){
    e.preventDefault();
    nf = true;
    if ($("#email").val() == ""){
        swal("Ooops..","Insert your email address","error");
        nf = false;
    }
    if ($("#message").val() == ""){
        swal("Ooops..","Insert your message","error");
        nf = false;
    }
    if (nf){
        url = $(".lgblueBck").attr("data-url");
        var formData= new FormData($(this)[0]);
        $.ajax({
            url:url + "API/contact_us",
            type:"post",
            cache:false,
            contentType:false,
            processData:false,
            data:formData,
            success:function(response){
                response=JSON.parse(response);
                console.log(response);
                if(response.status==1){
                    swal("Great..","Thank you for your message.","success");
                }else{
                    swal("Ooops..",response.msg,"error");
                }
                setInterval(function(){
                    location.reload();
                },1500);
            }
        })
    }
});
$('#userLogin').on('submit',function(e){
    e.preventDefault();
    user_email = $("#user_email").val();
    user_pass =  $("#user_pass").val();
    rest_url_slug = $(this).attr("data-rest_url_slug");
    var base_url =  $(this).attr("data-url");
    url = base_url + "API/userLoginValidate";
    if (user_email !== '' && user_pass !== ''){
        $.ajax({
            url:url,
            type:"post",
            data:{user_pass:user_pass,user_email:user_email,rest_url_slug:rest_url_slug},
            success:function(response){
                
                response=JSON.parse(response);
                if(response.status==1){
                    swal("Great..","Login Successfully.","success");
                    setInterval(function(){
                        // console.log(base_url+"Customer/dashboard");
                        location.replace(base_url+"Customer/dashboard");
                    },1500);
                }else{
                    swal("Ooops..","Email or Password is wrong","error");
                }
                
            }
        })
    }else{
        swal("Ooops..","Email and Password shouldn't be empty.","error");
    }
});
$('#userRegister').on('submit',function(e){
    
    e.preventDefault();
    nf =true;
    if ($("#user_email_register").val() == ""){
        swal("Ooops..","Email is not allowed to be empty.","error");
        nf = false;
    }else{
        var regEx = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
        var validEmail = regEx.test($("#user_email_register").val());
        if (!validEmail){
            swal("Ooops..","It is invalid Email.","error");
            nf = false;
        }
    }

    if ($("#user_password_register").val() == ""){
        swal("Ooops..","Password is not allowed to be empty.","error");
        nf = false;
    }else{
        if ($("#user_password_confirm_register").val() !== $("#user_password_register").val()){
            swal("Ooops..","Password must be matched.","error");
            nf = false;
        }
    }
    if (nf){
        url =  $(this).attr("data-url") + "API/userRegister";
        grecaptcha.ready(function() {
            grecaptcha.execute('6LcQbNsaAAAAALyY3W-KNEpem4zuRZJOoah3uVTT', {action: 'customer_signup'}).then(function(token) {
                // add token to form
                var formData= new FormData($(this));
                $('#userRegister').prepend('<input type="hidden" name="g-recaptcha-response" value="' + token + '">');
                formData.append("g-recaptcha-response", token);
                $.ajax({
                    url:url,
                    type:"post",
                    cache:false,
                    contentType:false,
                    processData:false,
                    data:formData,
                    success:function(response){
                        
                        response=JSON.parse(response);
                        if(response.status==1){
                            swal({
                                title: "Great..",
                                text: "Register Successfully. Login Now?",
                                icon: "success",
                                buttons: [
                                    'No, Later',
                                    'Yes, Login Now'
                                ],
                                dangerMode: true
                            }).then(
                                function (isConfirm) {
                                    if (isConfirm) {
                                        $("#customerRegisterModal .customerlogin").click();
                                    }else{
                                        location.reload();
                                    }
                                }
                            )
                        }else{
                            swal("Ooops..",response.msg,"error");
                        }
                        
                    }
                })
            });
        });

    }
    
});
$('#userForgot').on('submit',function(e){
    
    e.preventDefault();
    nf =true;
    if ($("#user_email_forgot").val() == ""){
        swal("Ooops..","Email is not allowed to be empty.","error");
        nf = false;
    }else{
        var regEx = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
        var validEmail = regEx.test($("#user_email_forgot").val());
        if (!validEmail){
            swal("Ooops..","It is invalid Email.","error");
            nf = false;
        }
    }

    if (nf){
        url =  $(this).attr("data-url") + "API/recoveryPassword";
        var formData= new FormData($(this)[0]);
        $.ajax({
            url:url,
            type:"post",
            cache:false,
            contentType:false,
            processData:false,
            data:formData,
            success:function(response){
                
                response=JSON.parse(response);
                if(response.status==1){
                    swal("Great..","Send recovery email Successfully.","success");
                }else{
                    swal("Ooops..","Something Went Wrong","error");
                }
                
            }
        })
    }
    
});
$(document).on('click','.customerlogin',function(){
    $('.user-modal').modal('hide');
    $('.user-modal input[type="submit"]').attr('disabled','disabled');
    $('#customerloginModal').modal('show');
    $('#customerloginModal input[type="submit"]').removeAttr('disabled');
});
$(document).on('change','.is_discount',function(){
    if ($(this).val() == "yes"){
        $(".discount_wrap").removeClass("hide-field");
        $(".discount_wrap .loyalty_points").prop("disabled",false);
    }else{
        $(".discount_wrap").addClass("hide-field");
        $(".discount_wrap .loyalty_points").prop("disabled",true);
    }
});
$(document).on('change','.discount_wrap .loyalty_points',function(){
    points = $(this).val();
    if (points > $(this).prop("max")){
        $(this).val($(this).prop("max"));
    }
    if (points < 0){
        $(this).val(0);
    }
    redemption_conversion_rate = $(this).attr("data-redemption_conversion_rate") > 0 ? $(this).attr("data-redemption_conversion_rate") : 1;
    $(".discount_wrap .count_loyalty_points").html(points);
    $(".discount_wrap .discount_value_field").html(" = <b class='mx-1'>" + parseFloat(points / redemption_conversion_rate) + "</b>"+cur_symbol);
});

$(document).on('click','.register_btn_in_modal',function(){
    $('.user-modal').modal('hide');
    $('.user-modal input[type="submit"]').attr('disabled','disabled');
    $('#customerRegisterModal').modal('show');
    $('#customerRegisterModal input[type="submit"]').removeAttr('disabled');    
});

$(document).on('click','.forgot_btn_in_modal',function(){
    $('.user-modal').modal('hide');
    $('.user-modal input[type="submit"]').attr('disabled','disabled');
    $('#customerForgotModal').modal('show');
    $('#customerForgotModal input[type="submit"]').removeAttr('disabled');
});
$(document).on('click','.qty-plus',function(){
    var mode = $(".lgblueBck").attr("data-mode");
    qty = parseInt($(this).parent().parent().parent().find(".qty-field").html()) ;
    item_id =$(this).parent().parent().parent().attr("data-id");
    wish_index= $(this).parent().parent().parent().attr("data-wish-index");
    price_index =$(this).parent().parent().parent().find(".price-field").attr("data-price-index");
    base_url =$(this).parent().parent().parent().attr("data-base-url");
    extra_id_field = $(".wish-row[data-wish-index='"+wish_index+"'] .item-name .wishlist-food-extra");
    extra_id =[];
    for (let ei = 0; ei < extra_id_field.length; ei++) {
        const element = extra_id_field[ei];
        extra_id[ei] = $(element).attr("data-extra-id");
    }
    qty = qty + 1;
    
    extra_id_str = extra_id.join("|");
    if (mode == "table"){
        changeQtyWishlist(item_id,price_index,1,base_url,extra_id_str,wish_index);
    }else{
        changeQtyCart(item_id,price_index,1,base_url,extra_id_str,wish_index);
    }
});
$(document).on('click','.qty-minus',function(){
    var mode = $(".lgblueBck").attr("data-mode");
    qty = parseInt($(this).parent().parent().parent().find(".qty-field").html()) ;
    item_id =$(this).parent().parent().parent().attr("data-id");
    wish_index= $(this).parent().parent().parent().attr("data-wish-index");
    price_index =$(this).parent().parent().parent().find(".price-field").attr("data-price-index");
    base_url =$(this).parent().parent().parent().attr("data-base-url");
    extra_id_field = $(".wish-row[data-wish-index='"+wish_index+"'] .item-name .wishlist-food-extra");
    extra_id =[];
    for (let ei = 0; ei < extra_id_field.length; ei++) {
        const element = extra_id_field[ei];
        extra_id[ei] = $(element).attr("data-extra-id");
    }
    extra_id_str = extra_id.join("|");
    if (qty > 1) {
        if (mode == "table"){
            changeQtyWishlist(item_id,price_index,-1,base_url,extra_id_str,wish_index);
        }else{
            changeQtyCart(item_id,price_index,-1,base_url,extra_id_str,wish_index);
        }
    }
});
$(document).on('click','.delete-item',function(){
    var mode = $(".lgblueBck").attr("data-mode");
    qty = parseInt($(this).parent().parent().parent().find(".qty-field").html()) ;
    item_id =$(this).parent().parent().parent().attr("data-id");
    wish_index= $(this).parent().parent().parent().attr("data-wish-index");
    price_index =$(this).parent().parent().parent().find(".price-field").attr("data-price-index");
    base_url =$(this).parent().parent().parent().attr("data-base-url");
    extra_id_field = $(".wish-row[data-wish-index='"+wish_index+"'] .item-name .wishlist-food-extra");
    extra_id =[];
    for (let ei = 0; ei < extra_id_field.length; ei++) {
        const element = extra_id_field[ei];
        extra_id[ei] = $(element).attr("data-extra-id");
    }
    extra_id_str = extra_id.join("|");
    if (mode == "table"){
        changeQtyWishlist(item_id,price_index,-qty,base_url,extra_id_str,wish_index);
    }else{
        changeQtyCart(item_id,price_index,-qty,base_url,extra_id_str,wish_index);
    }
    $(".wish-row[data-wish-index='"+wish_index+"']").remove();
});
$(document).on('click','.j-checkout .j-payment-method-list .j-payment-method',function(){
    $(".j-checkout .j-payment-method-list .j-payment-method").removeClass("j-selected");
    $(this).addClass("j-selected");
    payment = $(this).attr("data-payment");
    $(".j-checkout #payment_method option:selected").attr("selected",false);
    $(".j-checkout #payment_method").find("option[data-payment='"+payment+"']").prop("selected",true);
});
$(document).on('change','.j-checkout #payment_method',function(){
    $(".j-checkout .j-payment-method-list .j-payment-method").removeClass("j-selected");
    payment = $(".j-checkout #payment_method option:selected").attr("data-payment");
    $(".j-checkout .j-payment-method-list .j-payment-method[data-payment='"+payment+"']").addClass("j-selected");
});
$(document).on('change','#user-checkout .is_tip',function(){
    if ($(this).prop("checked")){
        $("#user-checkout .tip_wrap .tip_amount").prop("disabled",false);
        $("#user-checkout .tip_wrap .tip_note").prop("disabled",false);
        $("#user-checkout .tip_wrap").removeClass("hide-field");
    }else{
        $("#user-checkout .tip_wrap .tip_amount").prop("disabled",true);
        $("#user-checkout .tip_wrap .tip_note").prop("disabled",true);
        $("#user-checkout .tip_wrap").addClass("hide-field");
    }
});
$(document).ready(function(){
    
    if ((window.performance.navigation.type == 1) || (localStorage.getItem("is_change_lang_event") == "true")){
        $('a.cattypebtn').on('show.bs.tab', function(e) {
            localStorage.setItem('cattypebtn_activeTab', $(e.target).attr('href'));
        });
        var cattypebtn_activeTab = localStorage.getItem('cattypebtn_activeTab');
        if(cattypebtn_activeTab){
            $('a.cattypebtn[href="' + cattypebtn_activeTab + '"]').tab('show');
            $('a.cattypebtn[href="' + cattypebtn_activeTab + '"]').parent().parent().find("li").removeClass("active");
            $('a.cattypebtn[href="' + cattypebtn_activeTab + '"]').parent().addClass("active");
            cattype = $(".category-type-bar-wrap li.active").attr("data-tab");
            $("#category_id").html($("#category_id_"+cattype).html());
        }

        $('a.category_cattype').on('show.bs.tab', function(e) {
            localStorage.setItem('category_cattype_activeTab', $(e.target).attr('href'));
        });
        var category_cattype_activeTab = localStorage.getItem('category_cattype_activeTab');
        if(category_cattype_activeTab){
            $('a.category_cattype[href="' + category_cattype_activeTab + '"]').tab('show');
        }

        $('a.foodextra_cattype').on('show.bs.tab', function(e) {
            localStorage.setItem('foodextra_cattype_activeTab', $(e.target).attr('href'));
        });
        var foodextra_cattype_activeTab = localStorage.getItem('foodextra_cattype_activeTab');
        if(foodextra_cattype_activeTab){
            $('a.foodextra_cattype[href="' + foodextra_cattype_activeTab + '"]').tab('show');
        }

        $('a.createMenu_cattype').on('show.bs.tab', function(e) {
            localStorage.setItem('createMenu_cattype_activeTab', $(e.target).attr('href'));
        });
        var createMenu_cattype_activeTab = localStorage.getItem('createMenu_cattype_activeTab');
        if(createMenu_cattype_activeTab){
            $('a.createMenu_cattype[href="' + createMenu_cattype_activeTab + '"]').tab('show');
        }
        localStorage.setItem("is_change_lang_event",false);
    }else{
        localStorage.setItem('cattypebtn_activeTab', $(".active.cattypebtn").attr('href'));
        localStorage.setItem('category_cattype_activeTab', $(".category_cattype.active").attr('href'));
        localStorage.setItem('foodextra_cattype_activeTab', $(".foodextra_cattype.active").attr('href'));
        localStorage.setItem('createMenu_cattype_activeTab', $(".createMenu_cattype.active").attr('href'));
        
        localStorage.setItem("is_change_lang_event",false);
    }
});
function changeQtyWishlist(item_id,price_index,price_qty,base_url,extra_id,wish_index){
    $.ajax({
        url:base_url + 'API/addWishlist',
        type:"post",
        data:{item_id:item_id ,price_index:price_index,price_qty: price_qty,extra_ids: extra_id},
        success:function(response){
            response=JSON.parse(response);
            if(response.status==1){
                console.log(response);
                qty = parseInt($(".wish-row[data-wish-index='"+wish_index+"'] .qty-field").html()) ;
                $(".wish-row[data-wish-index='"+wish_index+"'] .qty-field").html(qty + price_qty);
                total_price = 0;
                $( ".wish-row" ).each(function( e ) {
                    qty_ = parseFloat($(this).find(".price_value").html()) > 0 ? parseFloat($(this).find(".price_value").html()) : 0 ;
                    extra_price = 0;
                    $(this).find(".wishlist-food-extra-price").each(function(){
                        extra_price += parseFloat($(this).attr("data-extra-price"));
                    })
                    total_price = total_price + parseInt($(this).find(".qty-field").html()) * ( qty_ + extra_price);
                });
                $(".total_price").html(total_price);
            }else{
                swal('Ooops..','Something went wrong',"error");
            }
        }
    });
}
function changeQtyCart(item_id,price_index,price_qty,base_url,extra_id,wish_index){
    $.ajax({
        url:base_url + 'API/addCart',
        type:"post",
        data:{item_id:item_id ,price_index:price_index,price_qty: price_qty,extra_ids:extra_id},
        success:function(response){
            response=JSON.parse(response);
            if(response.status==1){
                console.log(response);
                qty = parseInt($(".wish-row[data-wish-index='"+wish_index+"'] .qty-field").html()) ;
                delivery_price = parseFloat($(".delivery_price").attr("data-delivery_price")) > 0 ? parseFloat($(".delivery_price").attr("data-delivery_price")) : 0;
                $(".wish-row[data-wish-index='"+wish_index+"'] .qty-field").html(qty + price_qty);
                total_price = 0;
                $( ".wish-row" ).each(function( e ) {
                    qty_ = parseFloat($(this).find(".price_value").html()) > 0 ? parseFloat($(this).find(".price_value").html()) : 0 ;
                    extra_price = 0;
                    // $(this).find(".wishlist-food-extra-price").each(function(e){
                    //     extra_price += parseFloat($(this).attr("data-extra-price"));
                    // })
                    total_price = parseFloat((total_price + parseInt($(this).find(".qty-field").html()) * ( qty_ + extra_price)).toFixed(2));
                });
                min_order_amount_free_delivery = $("#item-menu-table").attr("data-min_order_amount_free_delivery");
                if (min_order_amount_free_delivery <= total_price){
                    delivery_price = 0;
                }
                delivery_tax_percentage = parseFloat($(".delivery_tax_price").attr("data-tax_percentage")) > 0 ? parseFloat($(".delivery_tax_price").attr("data-tax_percentage")) : 0;
                delivery_tax_price = delivery_price * delivery_tax_percentage / 100 ;
                $(".delivery_price").html(delivery_price);
                $(".delivery_tax_price").html(delivery_tax_price);
                total_price_ = (total_price + delivery_price).toFixed(2);
                $(".subtotal_price").html(total_price);
                $(".total_price").html(total_price_);
            }else{
                swal('Ooops..','Something went wrong',"error");
            }
        }
    });
}
$(document).on('change','.qty-field',function(){
    qty = $(this).val();
    if (qty < 1){
        $(this).val(1);
    }
});

function to_wishlist(ele){
    hurl = $(ele).attr("data-href");
    suff = $("a.cattypebtn.active").attr("href").split("#")[1];
    location.replace(hurl+"/"+suff);
}
function save_delivery_postcode(address,item_id = 0){
    get_address = address ;
    menu_mode= $("#j-menu-section").attr("data-menu-mode");
    rest_name_slug= $("#j-menu-section").attr("data-rest-slug");
    base_url= $("#get_info_").attr("data-url");
    if (get_address == ""){
        swal("Sorry","Please Enter the Zip Code field","error");
    }else{
        $.ajax({
            url:base_url + 'API/get_saveZipcode',
            type:"post",
            data:{get_address:get_address , rest_name_slug: rest_name_slug},
            success:function(response){
                response=JSON.parse(response);
                if (response.status == 1){
                    swal("Great..","It is the available address.","success");
                    if (item_id > 0){
                        addCart(item_id);
                    }else{
                        location.reload();
                    }
                }else if(response.status == -1){
                    swal("Hmm..","Please enter your street and housenumber.","error");
                    // window.location.href = base_url + menu_mode + "/" + rest_name_slug;
                }else{
                    swal("Oops","It isn't the available address.","error");
                    // window.location.href = base_url + menu_mode + "/" + rest_name_slug;
                }
            }
        });
    }
}
function save_postcode(){
    get_address = $("#get_address").val();

    menu_mode= $("#j-menu-section").attr("data-menu-mode");
    rest_name_slug= $("#j-menu-section").attr("data-rest-slug");
    base_url= $("#get_info").attr("data-url");
    if (get_address == ""){
        swal("Sorry","Please Enter the Zip Code field","error");
    }else{
        $.ajax({
            url:base_url + 'API/get_saveZipcode',
            type:"post",
            data:{get_address:get_address , rest_name_slug: rest_name_slug},
            success:function(response){
                response=JSON.parse(response);
                console.log(response.data);
                if (response.status == 1){
                    // $("#get_zipcode").val(response.data);
                    swal("Great..","It is the available address.","success");
                    setInterval(function(){
                        window.location.href = base_url + menu_mode + "/" + rest_name_slug;
                    },1500);
                }else{
                    swal("Oops","It isn't the available address.","error");
                    // window.location.href = base_url + menu_mode + "/" + rest_name_slug;
                }
            }
        });
    }
}
$(document).on('click','#show-change-box',function(e){
    $(".customer-change-box").val();
    $(".customer-change-box").toggleClass("hide-field");
});
$(document).on('click','#show-change-box-mobile',function(e){
    $(".customer-change-box-mobile").val();
    $(".customer-change-box-mobile").toggleClass("hide-field");
});
$(document).on('click','#insertShippingAddressForm .jc-add_cart_enter_addressbtn',function(){
    address = $(this).parents(".get_address_field").find(".get_delivery_address").val();
    item_id = $(this).attr("data-item_id");
    save_delivery_postcode(address,item_id);
});
$(document).on('click','.jc-enter_addressbtn',function(){
    address = $(this).parents(".get_address_field").find(".get_delivery_address").val();
    save_delivery_postcode(address);
});
$(document).on('click','.j-dp-option-btn',function(){
    if(!$(".delivery-btn").hasClass("disabled") && !$(".delivery-btn").hasClass("disabled")){
        // $(".j-dp-option-btn").toggleClass("active");
    }
});
$(document).on('click','.accept_cookie',function(){
    base_url = $(this).attr("data-url");
    $.ajax({
        url:base_url + 'API/allow_cookie',
        type:"post",
        data:{allow_cookie:true},
        success:function(response){
            response=JSON.parse(response);
            if(response.status==1){
                $(".cookie-section").addClass("hide-field");
            }else{
                console.log(response);
            }
        }
    });
});
$(document).on('click','.footer-bar .footer-section.active .jc-footer_heading',function(){
    $(".footer-bar .footer-section").removeClass("active");
});
$(document).on('click','.footer-bar .footer-section:not(.active) .jc-footer_heading',function(){
    $(".footer-bar .footer-section").removeClass("active");
    $(this).parent().addClass("active");
});
function change_reservation_guest_number(guest_number){
    $("#number_of").val(guest_number);
    $(".guest_number_label").html(guest_number);
}
$(document).on('click','.increase_custom_guest_number',function(){
    guest_number = $(".custom_guest_number").val()*1 + 1;
    if (guest_number > $(".custom_guest_number").attr("max")){
        guest_number = $(".custom_guest_number").attr("max");
    }
    $(".choose_guest_number_btn").removeClass("selected-option");
    if (guest_number <6){
        $(".choose_guest_number_btn[data-number='"+guest_number+"']").addClass("selected-option");
    }
    change_reservation_guest_number(guest_number);
    $(".custom_guest_number").val(guest_number);
});
$(document).on('click','.decrease_custom_guest_number',function(){
    guest_number = $(".custom_guest_number").val()*1 - 1;
    if (guest_number < $(".custom_guest_number").attr("min")){
        guest_number = $(".custom_guest_number").attr("min");
    }
    $(".choose_guest_number_btn").removeClass("selected-option");
    if (guest_number <6){
        $(".choose_guest_number_btn[data-number='"+guest_number+"']").addClass("selected-option");
    }
    change_reservation_guest_number(guest_number);
    $(".custom_guest_number").val(guest_number);
});
$(document).on('click','.choose_guest_number_btn',function(){
    $(".choose_guest_number_btn").removeClass("selected-option");
    $(".custom_enter_symbol").removeClass("selected-option");
    $(this).addClass("selected-option");
    $(".choose_custom_guest_number_section").addClass("hide-field");
    $(".custom_enter_symbol").removeClass("hide-field");
    guest_number = $(this).attr("data-number");
    change_reservation_guest_number(guest_number);
});
$(document).on('click','.custom_enter_symbol',function(){
    $(".choose_guest_number_btn").removeClass("selected-option");
    $(this).addClass("selected-option").addClass("hide-field");
    $(".choose_custom_guest_number_section").removeClass("hide-field");
});

// -------------------------------Customer Dashboard----------------------------
$('#updateUserAccount').on('submit',function(e){
    e.preventDefault();
    nf =true;

    validate_required_field = $("#updateUserAccount .required-field");

	for (var i = validate_required_field.length - 1; i >= 0; i--)	{
		if ($(validate_required_field[i]).val().length < 1){
			$(validate_required_field[i]).after('<span class="error">This field is required</span>');
			$(validate_required_field[i]).addClass("error-field");
			nf=false;
        }
    }

    if ($("#email").val() == ""){
        swal("Ooops..","Email is not allowed to be empty.","error");
        nf = false;
    }else{
        var regEx = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
        var validEmail = regEx.test($("#email").val());
        if (!validEmail){
            swal("Ooops..","It is invalid Email.","error");
            nf = false;
        }
    }

    if ($("#new_password").val() !== $("#confirm_password").val() ){
        swal("Ooops..","Password must be matched","error");
        nf=false;
    }

    if (nf){
        url =  $(this).attr("data-url") + "Customer/updateAccount";
        var formData= new FormData($(this)[0]);
        $.ajax({
            url:url,
            type:"post",
            cache:false,
            contentType:false,
            processData:false,
            data:formData,
            success:function(response){
                
                response=JSON.parse(response);
                if(response.status==1){
                    swal("Great..","Update Account Successfully.","success");
                    location.reload();
                }else{
                    swal("Ooops..","Something Went Wrong","error");
                }
                
            }
        })
    }
    
});
// -------------------------------Owner Dashboard------------------------------
function mobileAndTabletCheck() {
    let check = false;
    (function(a){if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino|android|ipad|playbook|silk/i.test(a)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0,4))) check = true;})(navigator.userAgent||navigator.vendor||window.opera);
    return check;
};
if (!mobileAndTabletCheck){
    //WebSocket settings
    JSPM.JSPrintManager.auto_reconnect = true;
    JSPM.JSPrintManager.start();
    JSPM.JSPrintManager.WS.onStatusChanged = function () {
        if (jspmWSStatus()) {
            //get client installed printers
            JSPM.JSPrintManager.getPrinters().then(function (myPrinters) {
                var options = '';
                for (var i = 0; i < myPrinters.length; i++) {
                    options += '<option>' + myPrinters[i] + '</option>';
                }
                $('#installedPrinterName').html(options);
            });
        }
    };
    
    //Check JSPM WebSocket status
    function jspmWSStatus() {
        if (JSPM.JSPrintManager.websocket_status == JSPM.WSStatus.Open)
            return true;
        else if (JSPM.JSPrintManager.websocket_status == JSPM.WSStatus.Closed) {
            alert('JSPrintManager (JSPM) is not installed or not running! Download JSPM Client App from https://neodynamic.com/downloads/jspm');
            return false;
        }
        else if (JSPM.JSPrintManager.websocket_status == JSPM.WSStatus.Blocked) {
            alert('JSPM has blocked this website!');
            return false;
        }
    }
}

//Do printing...
function print_thermal(invoice_str,printer) {
    if (jspmWSStatus()) {
        //Create a ClientPrintJob
        var cpj = new JSPM.ClientPrintJob();
        //Set Printer type (Refer to the help, there many of them!)
        cpj.clientPrinter = new JSPM.InstalledPrinter($('#installedPrinterName').val());
        //Set content to print...
        //Create ESP/POS commands for sample label
        
        console.log(invoice_str);
        esc = '\x1B'; //ESC byte in hex notation
        newLine = '\x0A'; //LF byte in hex notation
        size1 = '\x38';
        size2 = '\x00';
        size3 = '\x18';
        // invoice_str = esc + "@"; //Initializes the printer (ESC @)
        // invoice_str += esc + '!' + '\x38'; //Emphasized.Double-height.Double-width mode selected (ESC ! (8.16.32)) 56 dec => 38 hex
        // invoice_str += 'Order ID #' + '101'; //text to print
        // console.log(invoice_str);
        // cpj.printerCommands = invoice_str;
        invoice_str = invoice_str.toString().replace('\x0A',newLine).replace('\x38',size1).replace('\x00',size2).replace('\x18',size3);
        console.log(invoice_str);
        cpj.printerCommands = esc + invoice_str;
        cpj.sendToClient();
    }else{
        console.log(jspmWSStatus() , "impossible");
    }
}
$(document).on('click','#thermal_print',function(e){
    e.preventDefault();
    order_id = $("#cancel_order").attr("d-order_id");
    print_by_thermal(order_id);
});
function print_by_thermal(order_id){
    html2canvas($("#order_a4"), {
        onrendered: function (canvas) {
            getCanvas = canvas;
            var imgageData = getCanvas.toDataURL("image/png");
            //Now browser starts downloading it instead of just showing it
            var newData = imgageData.replace(/^data:image\/png/, "data:application/octet-stream");
            // window.location.href = newData;
            url = $("footer").attr("data-url");
            var file= dataURLtoBlob(newData);
            var fd = new FormData();
            // fd.append("invoice", file);
            fd.append("order_id", order_id);

            $.ajax({
                url:url + "API/printThermal",
                type:"post",
                cache:false,
                data: fd,
                // data: {order_id:order_id},
                contentType:false,
                processData:false,
                success:function(response){
                    response=JSON.parse(response);
                    if(response.status==1){
                        invoice = response.invoice;
                        invoice_str = response.invoice_str;
                        printer = response.printer;
                        print_thermal(invoice_str,printer);
                        swal("Great..","Printing Now.","success");
                        return true;
                    }else{
                        swal("Ooops..","Something went wrong","error");
                        return false;
                    }
                }
            });

        }
    })
}
function dataURLtoBlob(dataURI) {
    // convert base64 to raw binary data held in a string
    // doesn't handle URLEncoded DataURIs - see SO answer #6850276 for code that does this
    var byteString = atob(dataURI.split(',')[1]);

    // separate out the mime component
    var mimeString = dataURI.split(',')[0].split(':')[1].split(';')[0]

    // write the bytes of the string to an ArrayBuffer
    var ab = new ArrayBuffer(byteString.length);

    // create a view into the buffer
    var ia = new Uint8Array(ab);

    // set the bytes of the buffer to the correct values
    for (var i = 0; i < byteString.length; i++) {
        ia[i] = byteString.charCodeAt(i);
    }

    // write the ArrayBuffer to a blob, and you're done
    var blob = new Blob([ab], {type: mimeString});
    return blob;
}
$('#updateCate').on('submit',function(e){
    e.preventDefault();
    url = $("#all_active_category").attr("data-url");
    var formData= new FormData($(this)[0]);
    $.ajax({
        url:url + "API/updateCategory",
        type:"post",
        cache:false,
        contentType:false,
        processData:false,
        data:formData,
            success:function(response){
            
            response=JSON.parse(response);
            if(response.status==1){
                swal("Great..","Updated Successfully.","success");
            }else{
                swal("Ooops..","Something went wrong","error");
            }
            setInterval(function(){
                location.reload();
            },1500);
        }
    })
    
});
$(document).on('click','#updateCate .dropify-clear',function(e){
    $('#updateCate input[name="is_category_image"]').val("1");
});
$('#updateExtraCate').on('submit',function(e){
    e.preventDefault();
    url = $("#all_active_category").attr("data-url");
    var formData= new FormData($(this)[0]);
    $.ajax({
        url:url + "API/updateExtraCategory",
        type:"post",
        cache:false,
        contentType:false,
        processData:false,
        data:formData,
            success:function(response){
            
            response=JSON.parse(response);
            if(response.status==1){
                swal("Great..","Updated Successfully.","success");
            }else{
                swal("Ooops..","Something went wrong","error");
            }
            setInterval(function(){
                location.reload();
            },1500);
        }
    })
    
});
$('#reservationTable').on('submit',function(e){
    e.preventDefault();
    url = $(".lgblueBck").attr("data-url");
    nf= true;
    if ($("#number_of").val() < 1){
        swal("Ooops..","Number of People must be more than 1.","error");
        nf= false;
    }
    if ($("#reservation_date").val() == ""){
        swal("Ooops..","Please Insert Date.","error");
        nf= false;
    }
    if ($("#reservation_time").val() == ""){
        swal("Ooops..","Please Insert Time.","error");
        nf= false;
    }
    if ($("#email").val() == ""){
        swal("Ooops..","Please Insert Email.","error");
        nf= false;
    }
 
    if (nf){
        var formData= new FormData($(this)[0]);
        $.ajax({
            url:url + "API/reservationTable",
            type:"post",
            cache:false,
            contentType:false,
            processData:false,
            data:formData,
                success:function(response){
                
                response=JSON.parse(response);
                if(response.status > 0){
                    swal("Great..","Reservated Successfully.","success");
                }else{
                    swal("Ooops..","Something went wrong","error");
                }
                setInterval(function(){
                    location.reload();
                },1500);
            }
        })
    }
    
});
$(document).on('click','#openingTimeSetting .delivery-hours-setting .add-period',function(){
    var row = $(this);
    weekday_id = row.attr("data-day");
    new_id = parseInt((row.parent().parent().find(".period-container[data-day='"+weekday_id+"'] .period").last().attr("data-id"))) + 1;
    add_new_period_row("delivery-opening-hours",weekday_id,new_id);
    $(".delivery-hours-setting .period-container[data-day="+weekday_id+"] tbody").append(new_tr);
    $(".timepickers").timepicker();
});
$(document).on('click','#openingTimeSetting .pickup-hours-setting .add-period',function(){
    var row = $(this);
    weekday_id = row.attr("data-day");
    new_id = parseInt((row.parent().parent().find(".period-container[data-day='"+weekday_id+"'] .period").last().attr("data-id"))) + 1;
    add_new_period_row("pickup-opening-hours",weekday_id,new_id);
    $(".pickup-hours-setting .period-container[data-day="+weekday_id+"] tbody").append(new_tr);
    $(".timepickers").timepicker();
});
$(document).on('click','#openingTimeSetting .opening-hours-setting .add-period',function(){
    var row = $(this);
    weekday_id = row.attr("data-day");
    new_id = parseInt((row.parent().parent().find(".period-container[data-day='"+weekday_id+"'] .period").last().attr("data-id"))) + 1;
    add_new_period_row("rest-opening-hours",weekday_id,new_id);
    $(".opening-hours-setting .period-container[data-day="+weekday_id+"] tbody").append(new_tr);
    $(".timepickers").timepicker();
});
function add_new_period_row(ptype,weekday_id,new_id){
    base_url = $("footer").attr("data-url");
    new_tr = '<tr class="period" data-id = "'+new_id+'">';
    new_tr +='<td class="col-time-start">';
    new_tr +='    <input type="text" name="'+ptype+'['+weekday_id+'][start]['+new_id+']" class="timepickers input-time-start form-control" value="07:00" >';
    new_tr +='</td>';
    new_tr +='<td class="col-time-end">';
    new_tr +='    <input type="text" name="'+ptype+'['+weekday_id+'][end]['+new_id+']" class="timepickers input-time-end form-control" value="22:00">';
    new_tr +='</td>';
    new_tr +='<td class="status_label_j closed-j" hidden="hidden"><img src="'+base_url+'assets/additional_assets/img/closed-1.png" width="90%"></td><td class="status_label_j open-j"><img src="'+base_url+'assets/additional_assets/img/open-1.png" width="90%"></td>';	
    new_tr +='<td class="col-delete-period">';
    new_tr +='    <a class="button delete-period has-icon red">';
    new_tr +='        <i class="fa fa-times"></i>';
    new_tr +='    </a>';
    new_tr +='</td>';
    new_tr +='</tr>';
    return new_tr;
}
$(document).on('click','.order-btn',function(e){
    e.preventDefault();
    
    minimum_order = $(".minimum-order").html();
    subtotal_price = $(".subtotal_price").html();
    if (parseFloat(minimum_order) > parseFloat(subtotal_price )){
        swal("Ooops..","The total amount is smaller than the Minimum Amount","error");
    }else{
        location.replace($(this).attr("href"));
    }
});
$(document).on('click','#openingTimeSetting .delete-period',function(){
    var row = $(this).parent().parent();
    row.remove();
});
$(document).on('click','#openingTimeSetting #add_new_holiday',function(){
    new_tr = '<tr class="op-holiday">';
    new_tr+= '<td class="col-name">';
    new_tr+= '<input type="text" name="opening-hours-holidays[name][]" class="form-control" value="">';
    new_tr+= '</td>';
    new_tr+= '<td class="col-date-start">';
    new_tr+= '<input type="text" name="opening-hours-holidays[dateStart][]" class="form-control date-start input-gray datepickers">';
    new_tr+= '</td>';
    new_tr+= '<td class="col-date-end">';
    new_tr+= '<input type="text" name="opening-hours-holidays[dateEnd][]" class="form-control date-end input-gray datepickers">';
    new_tr+= '</td>';
    new_tr+= '<td class="col-remove">';
    new_tr+= '<span class="btn btn-remove btn-danger remove-holiday has-icon"><i class="fa fa-times"></i></span>';
    new_tr+= '</td>';
    new_tr+= '</tr>';

    $("#op-holidays-table tbody" ).append(new_tr);
    $(".datepickers").datepicker();
});
$(document).on('click','#openingTimeSetting .remove-holiday',function(){
    var row = $(this).parent().parent();
    row.remove();
});
$(document).on('click','#openingTimeSetting #add_new_irregular_opening',function(){
    new_tr = '<tr class="op-irregular-opening">';
    new_tr+= '<td class="col-name">';
    new_tr+= '<input type="text" name="opening-hours-irregular-openings[name][]" class="form-control" value="">';
    new_tr+= '</td>';
    new_tr+= '<td class="col-date">';
    new_tr+= '<input type="text" name="opening-hours-irregular-openings[date][]" class="form-control date-start input-gray datepickers" value="" >';
    new_tr+= '</td>';
    new_tr+= '<td class="col-time-start">';
    new_tr+= '<input type="text" name="opening-hours-irregular-openings[timeStart][]" class="form-control date-end input-gray timepickers" value="" >';
    new_tr+= '</td>';
    new_tr+= '<td class="col-time-end">';
    new_tr+= '<input type="text" name="opening-hours-irregular-openings[timeEnd][]" class="form-control date-end input-gray timepickers" value="" >';
    new_tr+= '</td>';
    new_tr+= '<td class="col-remove">';
    new_tr+= '<span class="btn btn-remove btn-danger remove-io has-icon"><i class="fa fa-times"></i></span>';
    new_tr+= '</td>';
    new_tr+= '</tr>';
    $("#op-io-table tbody" ).append(new_tr);
    $(".timepickers").timepicker();
    $(".datepickers").datepicker();
});
$(document).on('click','#openingTimeSetting .remove-io',function(){
    var row = $(this).parent().parent();
    row.remove();
});
$(document).on('change','.period .timepickers',function(){
    var row = $(this).parent().parent();
    start_time = row.find(".input-time-start").val();
    end_time = row.find(".input-time-end").val();
    if ((start_time == "" && end_time == "") || (start_time == "00:00" && end_time == "00:00")){
        row.find(".closed-j").removeAttr("hidden");
        row.find(".open-j").attr("hidden","hidden");
    }else{
        row.find(".open-j").removeAttr("hidden");
        row.find(".closed-j").attr("hidden","hidden");
    }
});
$('#openingTimeSetting').on('submit',function(e){
    e.preventDefault();
    var formData= new FormData($(this)[0]);
    base_url = $("footer").attr("data-url");
    $.ajax({
        url:base_url + "API/saveOpeningTimeSetting",
        type:"post",
        cache:false,
        contentType:false,
        processData:false,
        data:formData,
        success:function(response){
            response=JSON.parse(response);
            console.log(response);
            if(response.status==1){
                swal("Great..","Saved Successfully.","success");
            }else{
                swal("Ooops..","Something went wrong","error");
            }
            setInterval(function(){
                location.reload();
            },1500);
        }
    })
});
$('#addDeliveryArea').on('submit',function(e){
    e.preventDefault();
    var formData= new FormData($(this)[0]);
    base_url = $("footer").attr("data-url");
    $.ajax({
        url:base_url + "API/addDeliveryArea",
        type:"post",
        cache:false,
        contentType:false,
        processData:false,
        data:formData,
        success:function(response){
            response=JSON.parse(response);
            console.log(response);
            if(response.status==1){
                swal("Great..","Saved Successfully.","success");
            }else{
                swal("Ooops..","Something went wrong","error");
            }
            setInterval(function(){
                location.reload();
            },1500);
        }
    })
});
$('#addDeliveryCountry').on('submit',function(e){
    e.preventDefault();
    var formData= new FormData($(this)[0]);
    base_url = $("footer").attr("data-url");
    $.ajax({
        url:base_url + "API/addDeliveryCountry",
        type:"post",
        cache:false,
        contentType:false,
        processData:false,
        data:formData,
        success:function(response){
            response=JSON.parse(response);
            console.log(response);
            if(response.status==1){
                swal("Great..","Saved Successfully.","success");
            }else{
                swal("Ooops..","Something went wrong","error");
            }
            setInterval(function(){
                location.reload();
            },1500);
        }
    })
});
$('#paymentSetting').on('submit',function(e){
    e.preventDefault();
    var formData= new FormData($(this)[0]);
    base_url = $("footer").attr("data-url");
    $.ajax({
        url:base_url + "API/updatePaymentSetting",
        type:"post",
        cache:false,
        contentType:false,
        processData:false,
        data:formData,
        success:function(response){
            response=JSON.parse(response);
            console.log(response);
            if(response.status==1){
                swal("Great..","Saved Successfully.","success");
            }else{
                swal("Ooops..","Something went wrong","error");
            }
            setInterval(function(){
                location.reload();
            },1500);
        }
    })
});
$('#updatedDeliveryAreaDetail').on('submit',function(e){
    e.preventDefault();
    var formData= new FormData($(this)[0]);
    base_url = $("footer").attr("data-url");
    $.ajax({
        url:base_url + "API/updatedDeliveryAreaDetail",
        type:"post",
        cache:false,
        contentType:false,
        processData:false,
        data:formData,
        success:function(response){
            response=JSON.parse(response);
            console.log(response);
            if(response.status==1){
                swal("Great..","Saved Successfully.","success");
            }else{
                swal("Ooops..","Something went wrong","error");
            }
            setInterval(function(){
                location.reload();
            },1500);
        }
    })
});
$('.deactivate_area').on('click',function(){
    var area_id=$(this).attr('d-area_id');
    url = $("footer").attr("data-url") + "API/deactivateArea";
    $.ajax({
        url:url,
        type:"post",
        data:{area_id:area_id},
        success:function(response){
            console.log(response);
            response=JSON.parse(response);
            if(response.status==1){
                swal("Great..","Deactivate Successfully.","success");
            }else{
                swal("Ooops..","Something went wrong","error");
            }
            setInterval(function(){
                location.reload();
            },1500);
        }
    })
});
$('.activate_area').on('click',function(){
    var area_id=$(this).attr('d-area_id');
    url = $("footer").attr("data-url") + "API/activateArea";
    $.ajax({
        url:url,
        type:"post",
        data:{area_id:area_id},
        success:function(response){
            console.log(response);
            response=JSON.parse(response);
            if(response.status==1){
                swal("Great..","Activate Successfully.","success");
            }else{
                swal("Ooops..","Something went wrong","error");
            }
            setInterval(function(){
                location.reload();
            },1500);
        }
    })
});
$('.remove_deliveryarea').on('click',function(){
    var area_id=$(this).attr('d-area_id');
    url = $("footer").attr("data-url") + "API/removeArea";
    $.ajax({
        url:url,
        type:"post",
        data:{area_id:area_id},
        success:function(response){
            console.log(response);
            response=JSON.parse(response);
            if(response.status==1){
                swal("Great..","Delete Successfully.","success");
            }else{
                swal("Ooops..","Something went wrong","error");
            }
            setInterval(function(){
                location.reload();
            },1500);
        }
    })
});
$('.accept_reservation').on('click',function(){
    var reservation_id =$(this).parent().parent().attr('data-reservation_id');
    url = $("footer").attr("data-url") + "API/changeStatusReservation";
    $.ajax({
        url:url,
        type:"post",
        data:{reservation_id:reservation_id,status: "accepted"},
        success:function(response){
            console.log(response);
            response=JSON.parse(response);
            if(response.status==1){
                swal("Great..","Accepted Successfully.","success");
            }else{
                swal("Ooops..","Something went wrong","error");
            }
            setInterval(function(){
                location.reload();
            },1500);
        }
    })
});
$('.cancel_reservation').on('click',function(){
    var reservation_id =$(this).parent().parent().attr('data-reservation_id');
    url = $("footer").attr("data-url") + "API/changeStatusReservation";
    $.ajax({
        url:url,
        type:"post",
        data:{reservation_id:reservation_id,status: "rejected"},
        success:function(response){
            console.log(response);
            response=JSON.parse(response);
            if(response.status==1){
                swal("Great..","Cancelled Successfully.","success");
            }else{
                swal("Ooops..","Something went wrong","error");
            }
            setInterval(function(){
                location.reload();
            },1500);
        }
    })
});
$('.remove_order').on('click',function(){
    var order_id=$(this).attr('d-order_id');
    url = $("footer").attr("data-url") + "API/removeOrder";
    $.ajax({
        url:url,
        type:"post",
        data:{order_id:order_id},
        success:function(response){
            console.log(response);
            response=JSON.parse(response);
            if(response.status==1){
                swal("Great..","Delete Successfully.","success");
            }else{
                swal("Ooops..","Something went wrong","error");
            }
            setInterval(function(){
                location.reload();
            },1500);
        }
    })
});
function change_language(url,lang){
    $.ajax({
        url: url,
        type: "post",
        data: "lang=" + lang,
        success: function (data) {
            // location.reload();
            prefix_lang = "";
            if (lang == "english"){
                prefix_lang = "en";
            }else if(lang == "germany"){
                prefix_lang = "de";
            }else if(lang == "french"){
                prefix_lang = "fr";
            }
            localStorage.setItem("is_change_lang_event",true);
            window.location.replace(location.protocol + '//' + location.host + location.pathname + "?lang=" + prefix_lang);
        },
        error: function () {
        }
    });
}
$(document).on('click','.del-price-row',function(){
    var row = $(this).parent();
    id = row.attr("data-id");
    if(id == "0"){
        row.find(".item_price_title input").val("");
        row.find(".item_price input").val("");
    }else{
        $('.price-row[data-id="'+id+'"]').remove();
    }
    $('.food-extra-row[data-id="'+id+'"]').remove();
    $('.food-extra-row-label[data-id="'+id+'"]').remove();
    $('.food-extra-form-row[data-id="'+id+'"]').remove();
});

$('.addNewAllergen').on('submit',function(e){
    e.preventDefault();
    var formData= new FormData($(this)[0]);
    url = $(this).attr("data-url") + "addNewAllergen";
    allergen_name_english = $(this).find("input[name='allergen_name_english']").val();
    allergen_name_french = $(this).find("input[name='allergen_name_french']").val();
    allergen_name_germany = $(this).find("input[name='allergen_name_germany']").val();
    if (allergen_name_germany == "" && allergen_name_french == "" && allergen_name_english == ""){
        swal("Ooops..","You should insert at least one field.","error");
    }else{
        $.ajax({
            url:url,
            type:"post",
            cache:false,
            contentType:false,
            processData:false,
            data:formData,
            success:function(response){
                
                response=JSON.parse(response);
                if(response.status==1){
                    swal("Great..","Allergen Added Successfully.","success");
                }else if(response.status==2){
                    swal("Wait..","Details Already Exists","warning");
                }else{
                    swal("Ooops..","Something went wrong","error");
                }
                setInterval(function(){
                    location.reload();
                },1500);
            }
        })
    }
});
$('#updateAllergens').on('submit',function(e){
    e.preventDefault();
    url =  $('#updateAllergens').attr("data-url") + "updateAllergen";
    var formData= new FormData($(this)[0]);
    $.ajax({
    url:url,
    type:"post",
    cache:false,
    contentType:false,
    processData:false,
    data:formData,
    success:function(response){
        
        response=JSON.parse(response);
        if(response.status==1){
        swal("Great..","Updated Successfully.","success");
        }else{
        swal("Ooops..","Something went wrong","error");
        }
        setInterval(function(){
        location.reload();
        },1500);
    }
    })
    
});

$('.remove_allergen').on('click',function(){
    var allergen_id=$(this).attr('d-allergen_id');
    // alert("Activate "+rest_id);
    url =  $('#addNewAllergen').attr("data-url") + "removeAllergen";
    $.ajax({
    url:url,
    type:"post",
    data:{allergen_id:allergen_id},
    success:function(response){
        console.log(response);
        response=JSON.parse(response);
        if(response.status==1){
        swal("Done..","Deleted Successfully.","success");
        }else{
        swal("Ooops..","Something went wrong","error");
        }
        setInterval(function(){
        location.reload();
        },1500);
    }
    })
});

$(document).on('change','.handle_category',function(){
    var cate_id=$(this).attr('d-cat_id');
    base_url =  $('#all_active_category').attr("data-url");
    $(this).parents("tr").toggleClass("disable-item");
    if ($(this).prop("checked") == false){
        url =  base_url + "API/deactivateCategory";
        success_msg = "Deactivate Successfully.";
        failed_msg = "Something went wrong";
    }else{
        url =  base_url + "API/activateCategory";
        success_msg = "Activate Successfully.";
        failed_msg = "Something went wrong";
    }

    $.ajax({
        url:url,
        type:"post",
        data:{cat_id:cate_id},
        success:function(response){
            response=JSON.parse(response);
            if(response.status==1){
                swal("Done",success_msg,"success");
            }else{
                swal("Ooops..",failed_msg,"error");
            }
            // setInterval(function(){
            //     location.reload();
            // },1500);
        }
    })
});
$(document).on('change','.currency_code_select_box',function(){
    country_code = $(this).find("option:selected").attr("data-country_code");
    currency_symbol = $(this).find("option:selected").attr("data-currency_symbol");
    $(".country_select_box .country_flag").removeClass().addClass("img-thumbnail flag flag-icon-background country_flag").addClass("flag-icon-" + country_code);
    $(".currency_select_box .currency_symbol").html(currency_symbol);
    $(".currency_code_select_box").val( $(this).val());
}); 
$(document).on('change','.handle_extra_category',function(){
    var cate_id=$(this).attr('d-cat_id');
    base_url =  $('footer').attr("data-url");
    if ($(this).prop("checked") == false){
        url =  base_url + "API/deactivateExtraCategory";
        success_msg = "Deactivate Successfully.";
        failed_msg = "Something went wrong";
    }else{
        url =  base_url + "API/activateExtraCategory";
        success_msg = "Activate Successfully.";
        failed_msg = "Something went wrong";
    }
    $.ajax({
        url:url,
        type:"post",
        data:{cat_id:cate_id},
        success:function(response){
            response=JSON.parse(response);
            if(response.status==1){
                swal("Done",success_msg,"success");
            }else{
                swal("Ooops..",failed_msg,"error");
            }
            setInterval(function(){
                location.reload();
            },1500);
        }
    })
});
$(document).on('change','.handle_menu',function(){
    var menuId=$(this).attr('d-item-id');
    base_url =  $('#all_menu_item').attr("data-url");
    if ($(this).prop("checked") == false){
        url =  base_url + "API/deactivateMenuItem";
        success_msg = "Deactivate Successfully.";
        failed_msg = "Something went wrong";
    }else{
        url =  base_url + "API/activateMenuItem";
        success_msg = "Activate Successfully.";
        failed_msg = "Something went wrong";
    }

    $.ajax({
        url:url,
        type:"post",
        data:{menuId:menuId},
        success:function(response){
            response=JSON.parse(response);
            if(response.status==1){
                swal("Done",success_msg,"success");
            }else{
                swal("Ooops..",failed_msg,"error");
            }
            // setInterval(function(){
            //     location.reload();
            // },1500);
        }
    })
});
$(document).on('click','.active_category',function(){
    var cate_id=$(this).attr('d-cat_id');
    url =  $('#rejected_category').attr("data-url") + "API/activateCategory";
    // alert("Activate "+rest_id);
    $.ajax({
        url:url,
        type:"post",
        data:{cat_id:cate_id},
        success:function(response){
            console.log(response);
            response=JSON.parse(response);
            if(response.status==1){
                swal("Great..","Activate Successfully.","success");
            }else{
                swal("Ooops..","Something went wrong","error");
            }
            setInterval(function(){
                location.reload();
            },1500);
        }
    })
});
$(document).on('click','.active_extra_category',function(){
    var cate_id=$(this).attr('d-cat_id');
    url =  $('#rejected_category').attr("data-url") + "API/activateExtraCategory";
    // alert("Activate "+rest_id);
    $.ajax({
        url:url,
        type:"post",
        data:{cat_id:cate_id},
        success:function(response){
            console.log(response);
            response=JSON.parse(response);
            if(response.status==1){
                swal("Great..","Activate Successfully.","success");
            }else{
                swal("Ooops..","Something went wrong","error");
            }
            setInterval(function(){
                location.reload();
            },1500);
        }
    })
});
$(document).on('click','.deactivate_category',function(){
    var cate_id=$(this).attr('d-cat_id');
    url =  $('#all_active_category').attr("data-url") + "API/deactivateCategory";
    // alert("Activate "+rest_id);
    $.ajax({
        url:url,
        type:"post",
        data:{cat_id:cate_id},
        success:function(response){
            console.log(response);
            response=JSON.parse(response);
            if(response.status==1){
                swal("Great..","Deactivate Successfully.","success");
            }else{
                swal("Ooops..","Something went wrong","error");
            }
            setInterval(function(){
                location.reload();
            },1500);
        }
    })
});
$(document).on('click','.deactivate_extra_category',function(){
    var cate_id=$(this).attr('d-cat_id');
    url =  $('#all_active_category').attr("data-url") + "API/deactivateExtraCategory";
    // alert("Activate "+rest_id);
    $.ajax({
        url:url,
        type:"post",
        data:{cat_id:cate_id},
        success:function(response){
            console.log(response);
            response=JSON.parse(response);
            if(response.status==1){
                swal("Great..","Deactivate Successfully.","success");
            }else{
                swal("Ooops..","Something went wrong","error");
            }
            setInterval(function(){
                location.reload();
            },1500);
        }
    })
});
$(document).on('click','.deactivateMenu',function(){
    var menuId=$(this).attr('d-item-id');
    url =  $('#all_menu_item').attr("data-url") + "API/deactivateMenuItem";
    $.ajax({
        url:url,
        type:"post",
        data:{menuId:menuId},
        success:function(response){
            response=JSON.parse(response);
            if(response.status==1){
                swal("Great..","Deactivate Successfully.","success");
            }else{
                swal("Ooops..","Something went wrong","error");
            }
            setInterval(function(){
              location.reload();
            },1500);
        }
        })
});
$(document).on('click','.activateMenu',function(){
    var menuId=$(this).attr('d-item-id');
    var element=$(this);
    url =  $('#rejected_menu').attr("data-url") + "API/activateMenuItem";
    $.ajax({
        url:url,
        type:"post",
        data:{menuId:menuId},
        success:function(response){
            response=JSON.parse(response);
            if(response.status==1){
                swal("Great..","Activate Successfully.","success");
            }else{
                swal("Ooops..","Something went wrong","error");
            }
            setInterval(function(){
              location.reload();
            },1500);
        }
        })
});
$(document).on('click','#bottom_language_parent',function(){
    $('#bottom_language_child').toggleClass('hide-field');
});
$(document).mouseup(function(e) 
{
    var container = $("#bottom_language_child");
    var container_parent = $("#bottom_language_parent");
    if (!container.is(e.target) && !container_parent.is(e.target) && container.has(e.target).length === 0) 
    {
        $('#bottom_language_child').addClass("hide-field");
    }
});

$(document.body).on('touchmove', onScroll); // for mobile
window.onscroll = function() {onScroll()};
// Add the sticky class to the navbar when you reach its scroll position. Remove "sticky" when you leave the scroll position
function onScroll() {
    var sticky = 150;
    if (window.pageYOffset >= sticky) {
        $(".mobile_top_bar_wrap").removeClass("hide-field").removeClass("d-flex").addClass("d-flex");
    } else {
        $(".mobile_top_bar_wrap").removeClass("hide-field").removeClass("d-flex").addClass("hide-field");
    }
    if (window.pageYOffset >= 350) {
        $(".main-wrap .category-type-bar").addClass("sticky-div");
        $(".main-wrap #j-menu-section>section").addClass("sticky-div");
    }else{
        $(".main-wrap .category-type-bar").removeClass("sticky-div");
        $(".main-wrap #j-menu-section>section").removeClass("sticky-div");
    }
}
function sortTable(ele){
    sort_direction = $(ele).attr("data-sort-direction");
    if(sort_direction == "down"){
        $(ele).attr("data-sort-direction","up");
        $(ele).find("i").removeClass("fa-sort-alpha-down").addClass("fa-sort-alpha-up");
        load_Menutable("ASC");
    }else{
        $(ele).attr("data-sort-direction","down");
        $(ele).find("i").removeClass("fa-sort-alpha-up").addClass("fa-sort-alpha-down");
        load_Menutable("DESC");
    }
}
function load_Menutable(sort_direction) {
    rest_id = $('#menuList').attr("data-rest-id");
    lang = $('.createMenu-page .language-panel').find('a.active').attr("data-lang");
    base_url_ = $('#menuList').attr("data-base-url");
    base_url=base_url_ + 'Restaurant/editMenu/';
    url = base_url_ + 'API/getAllMenuItem_I';
    $.ajax({
        url:url,
        type:"post",
        data:{rest_id:rest_id,lang:lang,sort_direction:sort_direction},
        success:function(response){
            response=JSON.parse(response);
            if(response.data.length>0){
                $('#menuList').empty();
                for(let i=0; i<response.data.length; i++){
                    is_hide_field =(response.data[i].cattype == 1) ? '' : 'hide-field';
                    var categor='<tr data-cattype = "' + response.data[i].cattype + '" class="'+is_hide_field+' our-menu-td category-title-bar" data-cat_id = "'+response.data[i].cat_id+'">'+
                                    '<td colspan="5" class="text-center bg-danger  text-white" style="border-radius:25px 25px">'+response.data[i].cate_name+
                                    '</td>'+
                                '</tr>';
                    $('#menuList').append(categor);
                    
                    var ItmesArray=response.data[i].items;
                    for(m=0; m<ItmesArray.length; m++){
                        
                        if (ItmesArray[m].item_detail.item_status == 'Available'){
                            is_checked_menu = "checked";
                            is_disabled_item = "";
                        }else{
                            is_checked_menu = "";
                            is_disabled_item = "disable-item";
                        }
                        menu_row = '<tr data-cattype = "' + response.data[i].cattype + '" class="'+is_hide_field+' our-menu-td  '+is_disabled_item+'" data-cat_id = "'+ItmesArray[m].item_detail.category_id+'" d-item-id="'+ItmesArray[m].item_detail.menu_id+'">';
                        if(lang == "french"){
                            item_name = ItmesArray[m].item_detail.item_name_french;
                        }else if(lang == "germany"){
                            item_name = ItmesArray[m].item_detail.item_name_germany;
                        }else{
                            item_name = ItmesArray[m].item_detail.item_name_english;
                        }
                        
                        menu_row += '<td class="align-middle text-center sort_index hide-field">'+ItmesArray[m].item_detail.item_sort_index+'</td>';
                        menu_row += '<td class="align-middle text-center item-name">'+item_name+'</td>';
                        menu_row += '<td class="align-middle text-center"><img class="corner-rounded-img menu-card-item-img" width="100" height = "100" src="'+base_url_+'assets/menu_item_images/'+ItmesArray[m].item_detail.item_image +'" onerror="this.src=\''+base_url_+'assets/menu_item_images/samplefood.png'+'\'"></td>';
                        
                        var subCategories=ItmesArray[m].sub_Cat;
                        var sub_cat_td ='<td class="text-center align-middle">';
                        for(let j=0; j<subCategories.length; j++){
                            sub_cat_td +='<span class="mr-4"><strong>'+subCategories[j]+'</strong></span>';
                        }
                        sub_cat_td += "</td>";

                        menu_row += sub_cat_td;
                        var item_price_row = "<td class='align-middle'>";
                        item_price_list  = ItmesArray[m].item_price;
                        item_price_title_list = ItmesArray[m].itemPriceTitle;
                        for (let index = 0; index < item_price_list.length; index++) {
                            const element = item_price_list[index];
                            item_price_row += "<p class='d-flex justify-content-around'><span class='text-center text-primary' style='max-width: 150px'>"+item_price_title_list[index]+"</span><span class=' text-danger text-danger'><strong> &#8364; "+item_price_list[index]+"</strong></span></p>";
                        }
                        item_price_row += "</td>";
                        menu_row += item_price_row;
                        var items=ItmesArray[m];
                        menu_row += '<td class="text-center align-middle">';
                        menu_row += '<a href="'+base_url+ItmesArray[m].item_detail.menu_id+'" class="btn btn-success viewMenuItem" title= "View Item"><i class="fas fa-eye"></i></a> ';
                        menu_row += '<a href="javascript:void(0)" class="btn btn-danger deleteMenu ml-1" title= "Delete Item" d-item-id="'+ItmesArray[m].item_detail.menu_id+'"><i class="fas fa-trash"></i></a>';
                        menu_row += '<a href="javascript:void(0)" class="btn btn-info copyMenuItem ml-1" title= "Duplicate Item" d-item-id="'+ItmesArray[m].item_detail.menu_id+'"><i class="fas fa-copy"></i></a>';
                        // menu_row += '<a href="javascript:void(0)" class="btn btn-warning deactivateMenu ml-1" d-item-id="'+ItmesArray[m].item_detail.menu_id+'"><i class="fa fa-power-off"></i></a>';
                        menu_row += '<span class="ml-1"><input type="checkbox" data-plugin="switchery" name = "is_active_menu" data-color="#3DDCF7" d-item-id="'+ItmesArray[m].item_detail.menu_id+'" '+is_checked_menu+' class = "handle_menu" /></span>';

                        menu_row += '</td>';
                        menu_row += '</tr>';
                        // --------------------------------------------------
                        
                        $('#menuList').append(menu_row);
                        
                    }
                }
                $('[data-plugin="switchery"]').each(function (e, t) {
                    new Switchery($(this)[0], $(this).data());
                });
                $("#menuList tr.our-menu-td:not(.category-title-bar):not(tr:first-child)").draggable({
                    appendTo:"body",
                    helper:"clone",
                    start: function( event, ui ) {
                        $(this).addClass("hide-field");
                    },
                    stop: function( event, ui ) {
                        $(this).removeClass("hide-field");
                    }
                });
                $("#menuList tr.our-menu-td:not(tr:first-child)").droppable({
                    activeClass:"",
                    hoverClass:"j-dest-hover",
                    accept:":not(.ui-sortable-helper)",
                    drop:function (event, ui) {
                        row = ui.draggable;
                        if ($(this).attr("data-cat_id") == $(row).attr("data-cat_id")){
                            $(this).after(row);
                            src_item_id = $(row).attr("d-item-id");
                            target_item_id =$(this).attr("d-item-id");
                            resort_index(src_item_id,target_item_id);
                        }
                    },
                    over: function( event, ui ) {
                        row = ui.draggable;
                        $("#menuList tr.our-menu-td:not(tr:first-child)").removeClass("j-invalid-draggable");
                        if ($(this).attr("data-cat_id") !== $(row).attr("data-cat_id")){
                            $(this).addClass("j-invalid-draggable");
                        }
                    }
                });
                
            }
        }
    });
}
function resort_index(src_item_id,target_item_id){
    if (!target_item_id){
        target_item_id = 0;
    }
    url = $('#menuList').attr("data-base-url");
    $.ajax({
        url:url + "API/changeSortIndex",
        type:"post",
        data:{src_item_id:src_item_id,target_item_id:target_item_id},
        success:function(response){
            response=JSON.parse(response);
            console.log(status);
            if(response.status == 1){
            }else{
            }
        }
    });
}
$('#addon_payout .vat-tooltip').on('click',function(){
    $('#addon_payout .vat-tooltip-content').toggleClass("hide-field");
});
$('#addon_payout .business_type').on('change',function(){
    if ($(this).val() == "freelancer"){
        $("#addon_payout .only_for_company").addClass("hide-field");
        $("#addon_payout .only_for_company input").prop("disabled",true);
    }else{
        $("#addon_payout .only_for_company").removeClass("hide-field");
        $("#addon_payout .only_for_company input").prop("disabled",false);
    }
});
$('.addFoodExtra').on('submit',function(e){
    e.preventDefault();
    food_extra_name_eng = $(this).find("input[name='food_extra_name_english']").val();
    food_extra_name_fre = $(this).find("input[name='food_extra_name_french']").val();
    food_extra_name_ger = $(this).find("input[name='food_extra_name_germany']").val();
    category_id = $(this).find("select[name='category_id_for_extra']").val();
    url = $("#all_active_category").attr("data-url");
    if(category_id==0){
        swal("Ooops..","Please Select Category","error");
    }else{
        if (food_extra_name_eng == "" && food_extra_name_fre == "" && food_extra_name_ger == ""){
            swal("Ooops..","You should insert at least one field.","error");
        }else{
            var formData= new FormData($(this)[0]);
            $.ajax({
                url:url + "API/addFoodExtra",
                type:"post",
                cache:false,
                contentType:false,
                processData:false,
                data:formData,
                success:function(response){
                    
                    response=JSON.parse(response);
                    if(response.status==1){
                        swal("Great..","Food Extra Added Successfully.","success");
                    }else if(response.status==2){
                        swal("Wait..","Food Extra Already Exists","warning");
                    }else{
                        swal("Ooops..","Something went wrong","error");
                    }
                    setInterval(function(){
                        location.reload();
                    },1500);
                }
            })
        }
    }
});
$('.edit_food_extra').on('click',function(){
    var extra_id=$(this).attr('d-extra_id');
    var food_extra_name_english=$(this).attr('d-food_extra_name_english');
    var food_extra_name_french=$(this).attr('d-food_extra_name_french');
    var food_extra_name_germany=$(this).attr('d-food_extra_name_germany');

    $('.foodExtra_id').val(extra_id);
    $('#food_extra_name_english').val(food_extra_name_english);
    $('#food_extra_name_french').val(food_extra_name_french);
    $('#food_extra_name_germany').val(food_extra_name_germany);
    $('#editFoodExtra').modal('show');
});
$('.order_status').on('change',function(e){
    var order_id=$(this).attr('d-order_id');
    var payment_method=$(this).attr('d-payment_method');
    old_status = $(this).attr("data-status");
    new_status = $(this).find("option:selected").val();
    url = $("footer").attr("data-url");
    dp_option = $(this).attr("d-order_type");
    process_order(new_status,old_status,order_id,payment_method,url,dp_option);
});
$('#cancel_order').on('click',function(e){
    var order_id=$(this).attr('d-order_id');
    var payment_method=$(this).attr('d-payment_method');
    old_status = $(this).attr("data-status");
    new_status = "canceled";
    url = $("footer").attr("data-url");
    process_order(new_status,old_status,order_id,payment_method,url);
});
$('#accept_order').on('click',function(e){
    var order_id=$("#delivery-time-setting #duration_order_id").val();
    var payment_method= $(this).attr('d-payment_method');
    old_status = $(this).attr("old_status");
    url = $("footer").attr("data-url");
    rest_id = $("footer").attr("data-rest_id");
    duration_time = $("#duration_time").val();
    accept_order(rest_id,order_id,payment_method,url,old_status,duration_time);
});

function process_order(new_status,old_status,order_id,payment_method,url,dp_option = "delivery"){
    if ( new_status == "accepted"){
        btn_text_yes = 'Yes, Accept it';
        btn_text_no = 'No, Decide later';
        if (old_status == "pending" && "payment_method" == "stripe"){
            btn_text_yes = 'Yes, Accept and Receive Funds';
            btn_text_no = 'No';
        }
        swal({
            title: "Are you sure?",
            text: "You will accept this order.",
            icon: "success",
            buttons: [
                btn_text_no,
                btn_text_yes
              ],
            dangerMode: true
        }).then(
            function (isConfirm) {
                if (isConfirm) {
                    $("#delivery-time-setting").modal("show");
                    if (dp_option == "delivery"){
                        $("#delivery-time-setting .duration-title").html("Delivery Time");
                    }else{
                        $("#delivery-time-setting .duration-title").html("Takeaway Time");
                    }
                    $("#delivery-time-setting #duration_order_id").val(order_id);
                    $("#delivery-time-setting #accept_order").attr("old_status",old_status);
                    $("#delivery-time-setting #accept_order").attr("d-payment_method",payment_method);
                    $("#delivery-time-setting #accept_order").attr("disabled",false);
                    // accept_order(order_id,payment_method,url,old_status);
                }else{
                    location.reload();
                }
            }
        )
    }else if (new_status == "canceled"){
        btn_text_yes = 'Yes, Refund to cancel it!';
        btn_text_no = 'No, Leave it!';
        if (old_status == "pending" && "payment_method" == "stripe"){
            btn_text_yes = 'Yes';
            btn_text_no = 'No';
        }
        swal({
            title: "Are you sure?",
            text: "You will cancel this order.",
            icon: "warning",
            buttons: [
                btn_text_no,
                btn_text_yes
              ],
            dangerMode: true
        }).then(
            function (isConfirm) {
                if (isConfirm) {
                    cancel_order(order_id,payment_method,url,old_status);
                }else{
                    location.reload();
                }
            }
        )
    }else{
        $.ajax({
            url:url + "API/changeOrderStatus",
            type:"post",
            data:{order_id:order_id,order_status:new_status},
            success:function(response){
                response=JSON.parse(response);
                if(response.status == 1){
                    swal("Great..","Changed Successfully.","success");
                    $.ajax({
                        url:url + "API/notify_order_status",
                        type:"post",
                        data:{order_id:order_id,order_status:new_status},
                        success:function(response){
                        }
                    });
                }else{
                    swal("Ooops..","Something went wrong","error");
                }
                setInterval(function(){
                    location.reload();
                },1500);
            }
        });
    }
}
$('#delivery-time-setting').on('hidden.bs.modal', function (e) {
    location.reload();
})
function accept_order(rest_id,order_id,payment_method,url,old_status,duration_time){
    accept_url = "API/changeOrderStatus";
    if (payment_method == "stripe" && old_status == "pending"){
        accept_url = "Stripe/payment";
    }
    $.ajax({
        url:url + accept_url,
        type:"post",
        data:{rest_id:rest_id,order_id:order_id,order_status:'accepted',duration_time:duration_time},
        success:function(response){
            response=JSON.parse(response);
            if(response.status == 1){
                transactionID = response.transactionID;
                swal("Success..","Menu-"+order_id+" ("+transactionID+") is Accepted.","success");
                
                $.ajax({
                    url:url + "API/notify_order_status",
                    type:"post",
                    data:{order_id:order_id,order_status:'accepted',duration_time:duration_time},
                    success:function(response){
                    }
                });

            }else if(response.status == 2){
                swal("hmm..",response.error,"error");

                $.ajax({
                    url:url + "API/notify_order_status",
                    type:"post",
                    data:{order_id:order_id,order_status:'accepted'},
                    success:function(response){
                    }
                });
            }else{
                swal("Ooops..","Something went wrong","error");
            }
            setInterval(function(){
                location.reload();
            },3000);
        }
    });
}
function cancel_order(order_id,payment_method,url,old_status){
    if (payment_method == "paypal"){
        refund_url = "paypal/Express_checkout/Refund_transaction";
    }else if (payment_method == "stripe"){
        if (old_status == "pending"){
            refund_url = "API/stripe_cancel";
        }else{
            refund_url = "Stripe/refund";
        }
    }else if(payment_method == "creditcard_on_the_door"){
        refund_url = "API/refund_creditcard_door";
    }else{
        refund_url = "API/refund_cash";
    }
    $.ajax({
        url:url + refund_url,
        type:"post",
        data:{order_id:order_id,order_status:'canceled'},
        success:function(response){
            response=JSON.parse(response);
            if(response.status == 1){
                transactionID = response.transactionID;
                swal("Success..","Menu-"+order_id+" ("+transactionID+") Canceled.","success");
                
                $.ajax({
                    url:url + "API/notify_order_status",
                    type:"post",
                    data:{order_id:order_id,order_status:'canceled'},
                    success:function(response){
                    }
                });

            }else if(response.status == 2){
                swal("Ooops..",response.error,"error");
            }else{
                swal("Ooops..","Something went wrong","error");
            }
            setInterval(function(){
                location.reload();
            },3000);
        }
    });
}
$('#updateFoodExtra').on('submit',function(e){
    e.preventDefault();
    var formData= new FormData($(this)[0]);
    url = $("#all_active_category").attr("data-url");
    $.ajax({
        url:url + "API/updateFoodExtra",
        type:"post",
        cache:false,
        contentType:false,
        processData:false,
        data:formData,
        success:function(response){
            response=JSON.parse(response);
            if(response.status==1){
                swal("Great..","Updated Successfully.","success");
            }else{
                swal("Ooops..","Something went wrong","error");
            }
            setInterval(function(){
                location.reload();
            },1500);
        }
    })
});
$('#orderpay').on('submit',function(e){
    e.preventDefault();
    var formData= new FormData($(this)[0]);
    url = $(".lgblueBck").attr("data-url");
    $.ajax({
        url:url + "API/orderpay",
        type:"post",
        cache:false,
        contentType:false,
        processData:false,
        data:formData,
        success:function(response){
            response=JSON.parse(response);
            if(response.status==1){
                swal("Great..","Successfully.","success");
                if (response.payment_method == 'paypal'){
                    document.location.replace (url + 'paypal/Express_checkout/SetExpressCheckout');
                }else if(response.payment_method == 'stripe'){
                    amount =  response.stripe.amount;
                    var handler = StripeCheckout.configure({
                        key: response.stripe.stripe_key,
                        locale: 'auto',
                        token: function (token) {
                            console.log('Token Created!!');
                            console.log(token);
                            // $('#token_response').html(JSON.stringify(token));
                            
                            $.ajax({
                                url: url + "API/stripe_payment",
                                method: 'post',
                                data: { tokenId: token.id, amount: amount, order_id:response.order_id},
                                dataType: "json",
                                success: function( res ) {
                                    console.log(res);
                                    if (res.status){
                                        location.replace(url+"Home/order_complete");
                                    }else{
                                        swal("Ooops..","Something went wrong","error");
                                    }
                                },
                                error: function(){
                                    swal("Ooops..","Something went wrong","error");
                                }
                            })
                            setInterval(function(){
                                location.reload();
                            },1500);

                            // $.ajax({
                            //     url: url + "stripe/payment",
                            //     method: 'post',
                            //     data: { tokenId: token.id, amount: amount*100 },
                            //     dataType: "json",
                            //     success: function( res ) {
                            //         location.replace(url+"Home/order_complete");
                            //         // $('#token_response').append( '<br />' + JSON.stringify(response.data));
                            //     }
                            // })
                        }
                    });

                    handler.open({
                        name: 'My Restopage',
                        description: 'Stripe Payment',
                        amount: parseInt(amount * 100),
                        currency: "eur"
                    });
                }else{
                    location.replace(url+"Home/order_complete");
                }
            }else if (response.status == -1){
                swal("Ooops..","The total amount is smaller than the Minimum Amount","error");
                dp_option = $("#dp_option").val();
                rest_url_slug = $("#rest_url_slug").val();
                setInterval(function(){
                    document.location.replace (url + dp_option + "/" + rest_url_slug);
                },1500);
            }else{
                swal("Ooops..","Something went wrong","error");
            }
        }
    })
});
$('#addNewTax').on('submit',function(e){
    e.preventDefault();
    var formData= new FormData($(this)[0]);
    url = $("#all_tax").attr("data-url");
    $.ajax({
        url:url + "API/addNewTax",
        type:"post",
        cache:false,
        contentType:false,
        processData:false,
        data:formData,
        success:function(response){
            response=JSON.parse(response);
            if(response.status==1){
                swal("Great..","Add New Tax Successfully.","success");
            }else if(response.status==2){
                swal("Hmmm..","It already exists","warning");
            }else{
                swal("Ooops..","Something went wrong","error");
            }
            setInterval(function(){
                location.reload();
            },1500);
        }
    })
});
$('#addNewDeliveryTax').on('submit',function(e){
    e.preventDefault();
    var formData= new FormData($(this)[0]);
    url = $("#all_tax").attr("data-url");
    $.ajax({
        url:url + "API/addNewDeliveryTax",
        type:"post",
        cache:false,
        contentType:false,
        processData:false,
        data:formData,
        success:function(response){
            response=JSON.parse(response);
            if(response.status==1){
                swal("Great..","Save Delivery Tax Successfully.","success");
            }else{
                swal("Ooops..","Something went wrong","error");
            }
            setInterval(function(){
                location.reload();
            },1500);
        }
    })
});
$('.remove_tax').on('click',function(){
    var tax_id=$(this).attr('d-tax_id');
    var rest_id=$("#rest_id").val();
    url = $("#all_tax").attr("data-url");
    // alert("Activate "+rest_id);
    $.ajax({
        url:url + "API/removeTax",
        type:"post",
        data:{rest_id:rest_id,tax_id:tax_id},
        success:function(response){
            
            response=JSON.parse(response);
            if(response.status==1){
            swal("Done..","Deleted Successfully.","success");
            }else{
            swal("Ooops..","Something went wrong","error");
            }
            setInterval(function(){
                location.reload();
            },1500);
        }
    })
});
$('.edit_tax').on('click',function(){
    var tax_id=$(this).attr('d-tax_id');
    var rest_id=$("#rest_id").val();
    url = $("#all_tax").attr("data-url");
    $.ajax({
        url:url + "API/getTax",
        type:"post",
        data:{rest_id:rest_id,tax_id:tax_id},
        success:function(response){
            response=JSON.parse(response);
            if(response.res !== null){
                tax_value = response.res.tax_percentage;
                tax_desc = response.res.tax_description;
                tax_id = response.res.id;
                $("#delivery-time-edting").modal("show");
                $("#delivery-time-edting #delivery_tax_description").val(tax_desc);
                $("#delivery-time-edting #delivery_tax_percentage").val(tax_value);
                $("#delivery-time-edting #delivery_tax_id").val(tax_id);
                $("#delivery-time-edting #save_tax").prop("disabled",false);
            }else{
            }
        }
    })
});
$('#editTaxForm').on('submit',function(e){
    e.preventDefault();
    var formData= new FormData($(this)[0]);
    url = $("#all_tax").attr("data-url");
    $.ajax({
        url:url + "API/updateTax",
        type:"post",
        cache:false,
        contentType:false,
        processData:false,
        data:formData,
        success:function(response){
            response=JSON.parse(response);
            if(response.status==1){
                swal("Great..","Update Tax Successfully.","success");
            }else{
                swal("Ooops..","Something went wrong","error");
            }
            setInterval(function(){
                location.reload();
            },1500);
        }
    })
});

$('.is_standard').on('change',function(){
    var tax_id=$(this).attr('d-tax_id');
    var rest_id=$("#rest_id").val();
    url = $("#all_tax").attr("data-url");
    // alert("Activate "+rest_id);
    $.ajax({
        url:url + "API/setStandardTax",
        type:"post",
        data:{rest_id:rest_id,tax_id:tax_id},
        success:function(response){
            
            response=JSON.parse(response);
            if(response.status==1){
            swal("Great..","Standard Tax is changed successfully.","success");
            }else{
            swal("Ooops..","Something went wrong","error");
            }
            setInterval(function(){
                location.reload();
            },1500);
        }
    })
});
$('.point_status').on('change',function(){
    if ($(this).val() == "enable"){
        $(".point_setting_section").removeClass("hide-field");
    }else{
        $(".point_setting_section").addClass("hide-field");
    }
});
$('#loyaltyPointsForm').on('submit',function(e){
    e.preventDefault();
    var formData= new FormData($(this)[0]);
    url = $("footer").attr("data-url");
    $.ajax({
        url:url + "API/updateLoyaltyPointSetting",
        type:"post",
        cache:false,
        contentType:false,
        processData:false,
        data:formData,
        success:function(response){
            response=JSON.parse(response);
            if(response.status==1){
                swal("Great..","Update Loyal Point Settings Successfully.","success");
            }else{
                swal("Ooops..","Something went wrong","error");
            }
            setInterval(function(){
                location.reload();
            },1500);
        }
    })
});

$('.filter-by-dp').on('change',function(){
    $(".pickup-row").removeClass("hide-field");
    $(".delivery-row").removeClass("hide-field");
    if ($('#pickup_show').prop("checked") == false){
        $(".pickup-row").addClass("hide-field");
    }
    if ($('#delivery_show').prop("checked") == false){
        $(".delivery-row").addClass("hide-field");
    }
});
$('.removefood_extra').on('click',function(){
    var extra_id=$(this).attr('d-extra_id');
    url = $("#all_active_category").attr("data-url");
    // alert("Activate "+rest_id);
    $.ajax({
        url:url + "API/removeFoodExtra",
        type:"post",
        data:{extra_id:extra_id},
        success:function(response){
            
            response=JSON.parse(response);
            if(response.status==1){
            swal("Done..","Deleted Successfully.","success");
            }else{
            swal("Ooops..","Something went wrong","error");
            }
            setInterval(function(){
                location.reload();
            },1500);
        }
    })
});
$(document).on('submit','#updateDesignSettings',function(e){
    var formData= new FormData($(this)[0]);
    base_url = $(this).attr("data-base-url");
    rest_id = $("#myRestId").val();
    $.ajax({
        url:base_url + "API/updateDesignSettings",
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
            setInterval(function(){
              location.reload();
            },1500);
        }
    })
    e.preventDefault();

});
// modify by Jfrost in 2nd step
$(document).on('change','.font-family-selection',function(e){
    test_id = $(this).attr("data-test_id");
    font_family = $(this).find("option:selected").text();
    $("#"+test_id).css('font-family',font_family+" , Arial,​ sans-serif");
    console.log(font_family);
});

$(document).on('change','.restaurant_kitchen',function(e){
});
$(document).on('submit','#restaurantKitchen',function(e){
    e.preventDefault();
    rest_id = $("#restaurantKitchen").attr("data-rest_id");

    var checkedVals = $('.restaurant_kitchen:checked').map(function() {
        return this.value;
    }).get();
    kitchen_ids = checkedVals.join(",");
    console.log(kitchen_ids);

    base_url = $("footer").attr("data-url");
    $.ajax({
        url:base_url + "API/updateRestaurantSetting",
        type:"post",
        data:{"myRestId":rest_id,"kitchen_ids":kitchen_ids},
        success:function(response){
            response=JSON.parse(response);
            if(response.code==1){
                swal("Great..","Data Updated Successfully.","success");
            }else{
                swal("Ooops..","Something went wrong","error");
            }
            setTimeout(function(){
                location.reload();
            },1500);
        }
    })
});
$(document).on('change','input[name="admin_lang_option"]',function(e){
    rest_id = $("#restaurantSetting").attr("data-rest_id");
    admin_lang_option = $('input[name="admin_lang_option"]:checked').val();
    base_url = $("footer").attr("data-url");
    $.ajax({
        url:base_url + "API/updateRestaurantSetting",
        type:"post",
        data:{"myRestId":rest_id,"admin_lang_option":admin_lang_option},
        success:function(response){
            response=JSON.parse(response);
            if(response.code==1){
                swal("Great..","Data Updated Successfully.","success");
            }else{
                swal("Ooops..","Something went wrong","error");
            }
            setTimeout(function(){
                change_language(base_url + "API/change_lang_admin",admin_lang_option);
            },1500);
        }
    })
});
$(document).on('change','input[name="menu_lang_option"]',function(e){
    rest_id = $("#restaurantSetting").attr("data-rest_id");
    var menu_lang_option = [];
    if ($("#set_menu_french").prop("checked")){
        menu_lang_option.push("french");
    }
    if ($("#set_menu_germany").prop("checked")){
        menu_lang_option.push("germany");
    }
    if ($("#set_menu_english").prop("checked")){
        menu_lang_option.push("english");
    }
    if ($('input[name="menu_lang_option"]:checked').length > 0){
        base_url = $("footer").attr("data-url");
        $.ajax({
            url:base_url + "API/updateRestaurantSetting",
            type:"post",
            data:{"myRestId":rest_id,"menu_lang_option":menu_lang_option.join(",")},
            success:function(response){
                response=JSON.parse(response);
                if(response.code==1){
                    swal("Great..","Data Updated Successfully.","success");
                }else{
                    swal("Ooops..","Something went wrong","error");
                }
                // setInterval(function(){
                //     location.reload();
                // },1500);
            }
        })
    }else{
        swal("Ooops..","You should choose at least one Food Menu language","error");
        setInterval(function(){
            location.reload();
        },1500);
    }
});
$(document).on('change','input[name="website_lang_option"]',function(e){
    rest_id = $("#restaurantSetting").attr("data-rest_id");
    var website_lang_option = [];
    if ($("#set_website_french").prop("checked")){
        website_lang_option.push("french");
    }
    if ($("#set_website_germany").prop("checked")){
        website_lang_option.push("germany");
    }
    if ($("#set_website_english").prop("checked")){
        website_lang_option.push("english");
    }
    if ($('input[name="website_lang_option"]:checked').length > 0){
        base_url = $("footer").attr("data-url");
        $.ajax({
            url:base_url + "API/updateRestaurantSetting",
            type:"post",
            data:{"myRestId":rest_id,"website_lang_option":website_lang_option.join(",")},
            success:function(response){
                response=JSON.parse(response);
                if(response.code==1){
                    swal("Great..","Data Updated Successfully.","success");
                }else{
                    swal("Ooops..","Something went wrong","error");
                }
            }
        })
    }else{
        swal("Ooops..","You should choose at least one Website language","error");
        setInterval(function(){
            location.reload();
        },1500);
    }
});
$(document).on('change','input[name="dashboard_lang_option"]',function(e){
    rest_id = $("#restaurantSetting").attr("data-rest_id");
    var dashboard_lang_option = [];
    if ($("#set_dashboard_french").prop("checked")){
        dashboard_lang_option.push("french");
    }
    if ($("#set_dashboard_germany").prop("checked")){
        dashboard_lang_option.push("germany");
    }
    if ($("#set_dashboard_english").prop("checked")){
        dashboard_lang_option.push("english");
    }
    if ($(".dashboard_lang_option:checked").length > 0){
        base_url = $("footer").attr("data-url");
        $.ajax({
            url:base_url + "API/updateRestaurantSetting",
            type:"post",
            data:{"myRestId":rest_id,"dashboard_lang_option":dashboard_lang_option.join(",")},
            success:function(response){
                response=JSON.parse(response);
                if(response.code==1){
                    swal("Great..","Data Updated Successfully.","success");
                }else{
                    swal("Ooops..","Something went wrong","error");
                }
            }
        })
    }else{
        swal("Ooops..","You should choose at least one dashboard language","error");
        setInterval(function(){
            location.reload();
        },1500);
    }
});
$(document).on('change','input.active_page_item',function(e){
    rest_id = $("#restaurantSetting").attr("data-rest_id");
    var active_pages = [];
    if ($("#active_page_home").prop("checked")){
        active_pages.push("home");
    }
    if ($("#active_page_menu").prop("checked")){
        active_pages.push("menu");
    }
    if ($("#active_page_reservation").prop("checked")){
        active_pages.push("reservation");
    }
    if ($("#active_page_contact").prop("checked")){
        active_pages.push("contact");
    }
    if ($("#active_page_tc").prop("checked")){
        active_pages.push("tc");
    }
    base_url = $("footer").attr("data-url");
    $.ajax({
        url:base_url + "API/updateRestaurantSetting",
        type:"post",
        data:{"myRestId":rest_id,"active_pages":active_pages.join(",")},
        success:function(response){
            response=JSON.parse(response);
            if(response.code==1){
                swal("Great..","Data Updated Successfully.","success");
            }else{
                swal("Ooops..","Something went wrong","error");
            }
        }
    })
});
$(document).on('change','#item_cat_type',function(){
    $(".extra_id").empty();
});
$(document).on('change','.menu-detailed-page #item_category_id',function(){
    val = $(this).val();
    base_url = $("footer").attr("data-url");
    $.ajax({
        url:base_url + 'API/getCategoryFoodExtra',
        type:"post",
        data:{category_id:val},
        success:function(response){
            response=JSON.parse(response);
            $(".extra_id").empty();
            var extra_eng = '';
            var extra_fre = '';
            var extra_ger = '';
            for(let i=0; i<response.data.length; i++){
                food_extra_name_english = response.data[i].food_extra_name_english == "" ? response.data[i].food_extra_name : response.data[i].food_extra_name_english;
                extra_eng = '<option value="' + response.data[i].extra_id + '">'+response.data[i].food_extra_name_english+'</option>';
                $(".menu-detailed-page  .extra_id.english-field").append(extra_eng);

                food_extra_name_french = response.data[i].food_extra_name_french == "" ? response.data[i].food_extra_name : response.data[i].food_extra_name_french;
                extra_fre = '<option value="' + response.data[i].extra_id + '">'+response.data[i].food_extra_name_french+'</option>';
                $(".menu-detailed-page  .extra_id.french-field").append(extra_fre);
                
                food_extra_name_germnay = response.data[i].food_extra_name_germnay == "" ? response.data[i].food_extra_name : response.data[i].food_extra_name_germnay;
                extra_ger = '<option value="' + response.data[i].extra_id + '">'+response.data[i].food_extra_name_germnay+'</option>';
                $(".menu-detailed-page  .extra_id.germany-field").append(extra_ger);
            }
        }
    });
});
$(document).on('change','.createMenu-page .extra_id',function(){
    val = $(this).val();
    var row = $(this).parent().parent();
    row.find(".extra_id").val(val);
});

function selectFoodExtraCategoryFunction(){
    var e = $(".extra_category_id_in_modal")[0];
    var type = e.options[e.selectedIndex].dataset.type;
    val = e.value;
    cat_lang = $(".extra_category_id_in_modal").attr("data-lang");
    base_url = $("footer").attr("data-url");
    $("#insertFoodExtra .subextra").empty();
    $("#insertFoodExtra .subextra_label").addClass("hide-field");
    if (val == "0"){
    }else{
        $.ajax({
            url:base_url + 'API/getCategoryFoodExtra',
            type:"post",
            data:{category_id:val},
            success:function(response){
                $("#insertFoodExtra .subextra_label").removeClass("hide-field");
                response=JSON.parse(response);
                $("#insertFoodExtra").attr("data-is-multi",type);
                // if (type == 0){
                if (type == -1){
                    extra_field = '<div class="extra_row row m-0">';
                    extra_field += '<select class="form-control extra_id_in_modal col-md-6" name="extra_id_in_modal">';
                    for(let i=0; i<response.data.length; i++){
                        extra_english_name = response.data[i].food_extra_name_english;
                        extra_french_name = response.data[i].food_extra_name_french;
                        extra_germany_name = response.data[i].food_extra_name_germany;
                        if (cat_lang == "english") {
                            extra_name = response.data[i].food_extra_name_english;
                        }else if(cat_lang == "french"){
                            extra_name = response.data[i].food_extra_name_french;
                        }else{
                            extra_name = response.data[i].food_extra_name_germany;
                        }
                        extra_name = extra_name == "" ? response.data[i].food_extra_name : extra_name;
                        extra_field += '<option value="' + response.data[i].extra_id + '">'+extra_name+'</option>';
                    }
                    extra_field += '</select>';
                    extra_field += '<div class="col-md-6 mb-3 d-flex justify-content-between align-items-center">';
                    extra_field += '<span>Price</span>';
                    extra_field += '<input type="number" class="extra_price justify-content-center form-control border border-top-0 border-left-0 border-right-0 rounded-0 text-center mx-2 shadow-none" step="0.01" min= "0">';
                    extra_field += '<span>'+cur_symbol+'</span>';
                    extra_field += "</div></div>"; 
                }else{
                    extra_field = "";
                    for(let i=0; i<response.data.length; i++){
                        extra_english_name = response.data[i].food_extra_name_english  == "" ? response.data[i].food_extra_name : response.data[i].food_extra_name_english  ;
                        extra_french_name = response.data[i].food_extra_name_french  == "" ? response.data[i].food_extra_name : response.data[i].food_extra_name_french;
                        extra_germany_name = response.data[i].food_extra_name_germany == "" ? response.data[i].food_extra_name : response.data[i].food_extra_name_germany;

                        if (cat_lang == "english") {
                            extra_name = response.data[i].food_extra_name_english;
                        }else if(cat_lang == "french"){
                            extra_name = response.data[i].food_extra_name_french;
                        }else{
                            extra_name = response.data[i].food_extra_name_germany;
                        }

                        extra_name = extra_name == "" ? response.data[i].food_extra_name : extra_name;
                        extra_field += '<div class="extra_row row" data-extra-id="' + response.data[i].extra_id +'">';
                        extra_field += '<label class="col-md-6  mb-3 d-flex align-items-center">';
                        extra_field += '<input type="checkbox" name="extra_id_in_modal" class="extra_id_in_modal mr-2" value="' + response.data[i].extra_id + '" data-english-name = "'+extra_english_name+'" data-french-name = "'+extra_french_name+'" data-germany-name = "'+extra_germany_name+'">';
                        extra_field += '<span>'+extra_name+'</span>';
                        extra_field += '</label>'; 
                        extra_field += '<div class="col-md-6 mb-3 d-flex justify-content-between align-items-center">';
                        extra_field += '<span>Price</span>';
                        extra_field += '<input type="number" class="extra_price justify-content-center form-control border border-top-0 border-left-0 border-right-0 rounded-0 text-center mx-2 shadow-none" step="0.01" min= "0">';
                        extra_field += '<span>'+cur_symbol+'</span>';
                        extra_field += '</div></div>';
                    }
                }
                $("#addFoodExtraModal .subextra").html(extra_field);
            }
        });
    }
}
function openFoodExtraModal(id){
    $('#addFoodExtraModal').modal('show');
    $("#addFoodExtraModal #insertFoodExtra .subextra").empty();
    $("#addFoodExtraModal #insertFoodExtra").attr("data-id",id);
    $("#addFoodExtraModal #insertFoodExtra .subextra_label").addClass("hide-field");
    $("#addFoodExtraModal #insertFoodExtra .extra_category_id_in_modal").val("0");
}
$('#insertFoodExtra').on('submit',function(e){
    e.preventDefault();
    id = $(this).attr("data-id");
    order_id = $(this).attr("data-order-id");
    exT = $("#insertFoodExtra .subextra .extra_row");

    type = $(this).attr("data-is-multi");
    if ($("#insertFoodExtra .subextra .extra_row input.extra_id_in_modal:checked").length > 0){
        method = $(this).attr("data-method");
    
        extra_value_field   = "";
        new_row             = "";
        new_form_row        = ""; 
        e_length = $('.tab-pane.active .food-extra-row[data-id="'+id+'"]').length;
        if (method == "edit"){
            e_length =parseInt(order_id);
        }
        // if (type == 1){
            for (let ie = 0; ie < exT.length; ie++) {
                if ($(exT[ie]).find(".extra_id_in_modal").prop("checked") == true){
    
                    eid = $(exT[ie]).attr("data-extra-id");
                    eprice = $(exT[ie]).find(".extra_price").val();
                    exteng_name = $(exT[ie]).find(".extra_id_in_modal").attr("data-english-name");
                    extfre_name = $(exT[ie]).find(".extra_id_in_modal").attr("data-french-name");
                    extger_name = $(exT[ie]).find(".extra_id_in_modal").attr("data-germany-name");
                    
                    extra_value_field += '<div class= "j-bg-lighter-gray p-2">';
                    extra_value_field += '<span class="english-field hide-field">'+ exteng_name +' - '+eprice+' '+cur_symbol+' </span>';
                    extra_value_field += '<span class="french-field hide-field">'+ extfre_name +' - '+eprice+' '+cur_symbol+' </span>';
                    extra_value_field += '<span class="germany-field hide-field">'+ extger_name +' - '+eprice+' '+cur_symbol+' </span>';
                    extra_value_field += '</div>';
                    
                    new_form_row +='<tr class="food-extra-form-row" data-id = "'+id+'" data-extra-id="'+e_length+'">'; 
                    new_form_row +='<td class="food_extra">'; 
                    new_form_row +='<input type="number" class="form-control extra_id hide-field" name="extra_id_english['+id+']['+e_length+'][]" required="" min="0" value="'+eid+'" >'; 
                    new_form_row +='</td>'; 
                    new_form_row +='<td class="pl-3 extra_price"><input type="number" name="extra_price['+id+']['+e_length+'][]" class="form-control hide-field" min = "0" step = "0.01" value="'+eprice+'"></td>'; 
                    new_form_row +='</tr>';
                }
            }
        // }
        var ee = $(".extra_category_id_in_modal")[0];
    
        extcateng_name = $(".extra_category_id_in_modal")[0].options[ee.selectedIndex].dataset.eng_name;
        extcatfre_name = $(".extra_category_id_in_modal")[0].options[ee.selectedIndex].dataset.fre_name;
        extcatger_name = $(".extra_category_id_in_modal")[0].options[ee.selectedIndex].dataset.ger_name;
        ext_cat = $(".extra_category_id_in_modal")[0].value;
        new_row +='<tr class="food-extra-row" data-id="'+id+'" data-extra-id="'+e_length+'" data-extra-cat = "'+ext_cat+'">';
        new_row +='<td class="food_extra-pl-50 j-text-black" colspan="2">';
        new_row +='<div class="j-bg-light-gray d-flex justify-content-between align-items-center p-2">';
        new_row += '<span class="english-field hide-field">'+ extcateng_name +'</span>';
        new_row += '<span class="french-field hide-field">'+ extcatfre_name +'</span>';
        new_row += '<span class="germany-field hide-field">'+ extcatger_name +'</span>';
        new_row += '<input type="hidden" name="extra_cat_ids['+id+'][]" value="'+ext_cat+'">';
        new_row +='<div><span class="btn btn-danger remove-extra-btn mr-2">Delete</span>';
        new_row +='<span class="btn btn-info edit-extra-btn">Edit</span></div>';
        new_row +='</div>';
        new_row += extra_value_field;
        new_row +='</td></tr>';
        new_row +='';
        
        if (method == "edit"){
            target_row = $('.tab-pane.active .food-extra-row[data-id="'+id+'"][data-extra-id="'+order_id+'"]');
            target_form_row = $('.tab-pane.active .food-extra-form-row[data-id="'+id+'"][data-extra-id="'+order_id+'"]');
            $('.tab-pane.active .food-extra-form-row[data-id="'+id+'"][data-extra-id="'+order_id+'"]:last').after(new_form_row);
            $(target_row).after(new_row);
            
            $(target_row).remove();
            $(target_form_row).remove();
            success_msg = "Updated Successfully.";
    
        }else if (method == "add"){
    
            if( e_length == 0){
                target_row = $('.tab-pane.active .price-row[data-id="'+id+'"]');
                target_form_row = $('.tab-pane.active .price-row[data-id="'+id+'"]');
            }else{
                target_row = $('.tab-pane.active .food-extra-row[data-id="'+id+'"]')[e_length-1];
                target_form_row = $('.tab-pane.active .food-extra-form-row[data-id="'+id+'"]:last');
            }
            $(target_form_row).after(new_form_row);
            $(target_row).after(new_row);
            success_msg = "Added Successfully.";
        }
    
        if($('.tab-pane.active .food-extra-row-label[data-id="'+id+'"]').length == 0){
            new_extra_option_label_row =''; 
            new_extra_option_label_row +='<tr class="food-extra-row-label j-text-black" data-id="'+id+'">';
            new_extra_option_label_row +='<td class="food_extra-pl-50" colspan="2">';
            new_extra_option_label_row +='<div class="p-2 j-bg-light-gray">';
            new_extra_option_label_row += $(".multi-lang-field").attr("data-food-extra-options");
            new_extra_option_label_row +='</div>';
            new_extra_option_label_row +='</td></tr>';
    
            $(target_row).after(new_extra_option_label_row);
        }
    
        lang = $('.createMenu-page .lang-bar').find('.item-flag.active').attr("data-flag") || $('.language-panel_ a.active').attr("data-lang");
        $("." + lang + "-field").removeClass("hide-field");   
        swal("Great..",success_msg,"success");
        setTimeout(function(){
            $('#addFoodExtraModal').modal('hide');
        },1000);
    }else{
        swal("Ooops..","Choose at least one extra item","error");
    }
});
$(document).on('submit','#uploadBannersForm',function(e){
    e.preventDefault();
    var formData= new FormData($(this)[0]);
    base_url = $("footer").attr("data-url");
    $.ajax({
    url: base_url + "API/uploadBanners",
    type:"post",
    processData:false,
    cache:false,
    contentType:false,
    enctype:"multipart/form-data",
    data:formData,
    success:function(response){
        
        response=JSON.parse(response);
        if(response.status==1){
            swal("Great..","Updated Successfully.","success");
        }else{
            swal("Ooops..","Something went wrong","error");
        }
        setInterval(function(){
        // location.reload();
        },1500);
    }
    })
});
$(document).on('click','.remove-extra-btn',function(){
    eid = $(this).parents(".food-extra-row").attr("data-id");
    eoid = $(this).parents(".food-extra-row").attr("data-extra-id");
    remove_extra_row(eid,eoid);
});
function remove_extra_row(eid,eoid){
    $('.tab-pane.active .food-extra-row[data-id="'+eid+'"][data-extra-id="'+eoid+'"]').remove();
    $('.tab-pane.active .food-extra-form-row[data-id="'+eid+'"][data-extra-id="'+eoid+'"]').remove();
    if ($('.tab-pane.active .food-extra-form-row[data-id="'+eid+'"]').length == 0){
        $('.tab-pane.active .food-extra-row-label[data-id="'+eid+'"]').remove();
    }

}
$(document).on('click','.add-food-extra',function(){
    var row = $(this).parent();
    var id = row.attr("data-id");
    openFoodExtraModal(id);
    $("#addFoodExtraModal #insertFoodExtra").attr("data-method","add");
    $("#addFoodExtraModal .add-extra-label").removeClass("hide-field");
    $("#addFoodExtraModal .edit-extra-label").addClass("hide-field");

    fer = $(".tab-pane.active  .food-extra-row[data-id = '"+ id+"']");
    $(".extra_category_id_in_modal option").removeAttr("disabled");
    for (let feri = 0; feri < fer.length; feri++) {
        ferc = $(fer[feri]).attr("data-extra-cat");
        console.log(ferc);
        $(".extra_category_id_in_modal option[value = '"+ferc+"']").attr("disabled","disabled");
    }
});
$(document).on('click','.edit-extra-btn',function(){
    var row = $(this).parents(".food-extra-row");
    var id = row.attr("data-id");
    var eidorder = row.attr("data-extra-id");
    var ecat = row.attr("data-extra-cat");
    openFoodExtraModal(id);
    $("#addFoodExtraModal #insertFoodExtra").attr("data-method","edit");
    $("#addFoodExtraModal #insertFoodExtra").attr("data-order-id",eidorder);
    $("#addFoodExtraModal .edit-extra-label").removeClass("hide-field");
    $("#addFoodExtraModal .add-extra-label").addClass("hide-field");

    ee = $(".food-extra-form-row[data-id='"+id+"'][data-extra-id='"+eidorder+"']");
    // $(".extra_category_id_in_modal").val(ecat).trigger('change');
    $(".extra_category_id_in_modal").val(ecat);

    var eci = $(".extra_category_id_in_modal")[0];
    var type = eci.options[eci.selectedIndex].dataset.type;


    // var e = $(".extra_category_id_in_modal")[0];
    // var type = e.options[e.selectedIndex].dataset.type;
    // val = e.value;
    cat_lang = $(".extra_category_id_in_modal").attr("data-lang");
    base_url = $("footer").attr("data-url");
    $("#insertFoodExtra .subextra").empty();
    $("#insertFoodExtra .subextra_label").addClass("hide-field");
    if (ecat == "0"){
    }else{
        $.ajax({
            url:base_url + 'API/getCategoryFoodExtra',
            type:"post",
            data:{category_id:ecat},
            success:function(response){
                $("#insertFoodExtra .subextra_label").removeClass("hide-field");
                response=JSON.parse(response);
                $("#insertFoodExtra").attr("data-is-multi",type);
                // if (type == 0){
                if (type == -1){
                    extra_field = '<div class="extra_row row m-0">';
                    extra_field += '<select class="form-control extra_id_in_modal col-md-6" name="extra_id_in_modal">';
                    for(let i=0; i<response.data.length; i++){
                        extra_english_name = response.data[i].food_extra_name_english;
                        extra_french_name = response.data[i].food_extra_name_french;
                        extra_germany_name = response.data[i].food_extra_name_germany;
                        if (cat_lang == "english") {
                            extra_name = response.data[i].food_extra_name_english;
                        }else if(cat_lang == "french"){
                            extra_name = response.data[i].food_extra_name_french;
                        }else{
                            extra_name = response.data[i].food_extra_name_germany;
                        }
                        extra_name = extra_name == "" ? response.data[i].food_extra_name : extra_name;
                        extra_field += '<option value="' + response.data[i].extra_id + '">'+extra_name+'</option>';
                    }
                    extra_field += '</select>';
                    extra_field += '<div class="col-md-6 mb-3 d-flex justify-content-between align-items-center">';
                    extra_field += '<span>Price</span>';
                    extra_field += '<input type="number" class="extra_price justify-content-center form-control border border-top-0 border-left-0 border-right-0 rounded-0 text-center mx-2 shadow-none" step="0.01" min= "0">';
                    extra_field += '<span>'+cur_symbol+'</span>';
                    extra_field += "</div></div>"; 
                }else{
                    extra_field = "";
                    for(let i=0; i<response.data.length; i++){
                        extra_english_name = response.data[i].food_extra_name_english  == "" ? response.data[i].food_extra_name : response.data[i].food_extra_name_english  ;
                        extra_french_name = response.data[i].food_extra_name_french  == "" ? response.data[i].food_extra_name : response.data[i].food_extra_name_french;
                        extra_germany_name = response.data[i].food_extra_name_germany == "" ? response.data[i].food_extra_name : response.data[i].food_extra_name_germany;

                        if (cat_lang == "english") {
                            extra_name = response.data[i].food_extra_name_english;
                        }else if(cat_lang == "french"){
                            extra_name = response.data[i].food_extra_name_french;
                        }else{
                            extra_name = response.data[i].food_extra_name_germany;
                        }
                        elel =  $(".food-extra-form-row[data-id='"+id+"'][data-extra-id='"+eidorder+"']").find(".extra_id[value='"+response.data[i].extra_id+"']");
                        exid_checked =$(elel).length > 0 ? "checked" : "";
                        ex_price = elel.parents(".food-extra-form-row").find(".extra_price input").val();

                        extra_name = extra_name == "" ? response.data[i].food_extra_name : extra_name;
                        extra_field += '<div class="extra_row row" data-extra-id="' + response.data[i].extra_id +'">';
                        extra_field += '<label class="col-md-6  mb-3 d-flex align-items-center">';
                        extra_field += '<input type="checkbox" name="extra_id_in_modal" class="extra_id_in_modal mr-2" value="' + response.data[i].extra_id + '" data-english-name = "'+extra_english_name+'" data-french-name = "'+extra_french_name+'" data-germany-name = "'+extra_germany_name+'" '+exid_checked+'>';
                        extra_field += '<span>'+extra_name+'</span>';
                        extra_field += '</label>'; 
                        extra_field += '<div class="col-md-6 mb-3 d-flex justify-content-between align-items-center">';
                        extra_field += '<span>Price</span>';
                        extra_field += '<input type="number" class="extra_price justify-content-center form-control border border-top-0 border-left-0 border-right-0 rounded-0 text-center mx-2 shadow-none" step="0.01" min= "0" value="'+ex_price+'">';
                        extra_field += '<span>'+cur_symbol+'</span>';
                        extra_field += '</div></div>';
                    }
                }
                $("#addFoodExtraModal .subextra").html(extra_field);
            }
        });
    }
});
$(document).on('click','.add-food-extra_',function(){
    openFoodExtraModal();

    var row = $(this).parent();
    extra_price_placeholder = $(this).attr("data-price-placeholder");
    category_id = $(".tab-pane.active .category_id").val() || $("#item_category_id").val();
    if (category_id > 0){
        lang = $('.createMenu-page .lang-bar').find('.item-flag.active').attr("data-flag") || $('.language-panel_ a.active').attr("data-lang");
       url = $("#all_menu_item").attr("data-url");
        var extra_eng = '';
        var extra_fre = '';
        var extra_ger = '';
        $.ajax({
            url:url + 'API/getCategoryFoodExtra',
            type:"post",
            data:{category_id:category_id},
            success:function(response){
                response=JSON.parse(response);
                console.log(response.data);
                if (response.data.length > 0){
                    for(let i=0; i<response.data.length; i++){
                        food_extra_name_english = response.data[i].food_extra_name_english == "" ? response.data[i].food_extra_name : response.data[i].food_extra_name_english;
                        extra_eng += '<option value="' + response.data[i].extra_id + '">'+food_extra_name_english+'</option>';

                        food_extra_name_french = response.data[i].food_extra_name_french == "" ? response.data[i].food_extra_name : response.data[i].food_extra_name_french;
                        extra_fre += '<option value="' + response.data[i].extra_id + '">'+food_extra_name_french+'</option>';
                        
                        food_extra_name_germany = response.data[i].food_extra_name_germany == "" ? response.data[i].food_extra_name : response.data[i].food_extra_name_germany;
                        extra_ger += '<option value="' + response.data[i].extra_id + '">'+food_extra_name_germany+'</option>';
                    }
                    var id = row.attr("data-id");
                    new_row =''; 
                    new_row +=''; 
                    new_row +='<tr class="food-extra-row" data-extra-id = "1" data-id = "'+id+'">'; 
                    new_row +='<td class="food_extra">'; 
                    new_row +='<select class="form-control extra_id english-field hide-field" name="extra_id_english['+id+'][1]" required="">'; 
                    new_row += extra_eng + '</select>'; 
                    new_row +='<select class="form-control extra_id germany-field hide-field" name="extra_id_germany['+id+'][1]" required="">'; 
                    new_row += extra_ger + '</select>'; 
                    new_row +='<select class="form-control extra_id french-field hide-field" name="extra_id_french['+id+'][1]" required="">'; 
                    new_row += extra_fre + '</select>'; 
                    new_row +='</td>'; 
                    new_row +='<td class="pl-3 extra_price"><input type="number" name="extra_price['+id+'][1]" class="form-control" placeholder="' + extra_price_placeholder + '" data-extra-id = "1" min = "0" step = "0.01"></td>'; 
                    new_row +='<td class="text-warning text-center pl-1 del-extra-price-row" ><i class="fa fa-times-circle"></i></td>'; 
                    new_row +='<td class="text-primary text-center pl-1 add-extra-price-row"><i class="fa fa-plus"></i></td>'; 
                    new_row +='</tr>';
                    if($('.tab-pane.active .food-extra-row[data-id="'+id+'"][data-extra-id="1"]').length == 0) {
                        row = $('.tab-pane.active .price-row[data-id="'+id+'"]');
                        row.after(new_row);
                    }
                    $("." + lang + "-field").removeClass("hide-field");
                }else{
                    swal("Ooops..","This category hasn't any Food Extra","error");
                }
            }
        });
    }else{
        swal("Ooops..","Please Select Category","error");
    }
});

$(document).on('click','.add-extra-price-row',function(){
    var row = $(this).parent();
    extra_price_placeholder = $(this).parent().find("input").attr("placeholder");
    category_id = $(".category_id").val() || $("#item_category_id").val();
    if (category_id > 0){
        lang = $('.createMenu-page .lang-bar').find('.item-flag.active').attr("data-flag") || $('.language-panel_ a.active').attr("data-lang");
        url = $("#all_menu_item").attr("data-url");
        var extra_eng = '';
        var extra_fre = '';
        var extra_ger = '';
        $.ajax({
            url:url + 'API/getCategoryFoodExtra',
            type:"post",
            data:{category_id:category_id},
            success:function(response){
                response=JSON.parse(response);
                if (response.data.length > 0){
                    for(let i=0; i<response.data.length; i++){
                        food_extra_name_english = response.data[i].food_extra_name_english == "" ? response.data[i].food_extra_name : response.data[i].food_extra_name_english;
                        extra_eng += '<option value="' + response.data[i].extra_id + '">'+food_extra_name_english+'</option>';

                        food_extra_name_french = response.data[i].food_extra_name_french == "" ? response.data[i].food_extra_name : response.data[i].food_extra_name_french;
                        extra_fre += '<option value="' + response.data[i].extra_id + '">'+food_extra_name_french+'</option>';
                        
                        food_extra_name_germany = response.data[i].food_extra_name_germany == "" ? response.data[i].food_extra_name : response.data[i].food_extra_name_germany;
                        extra_ger += '<option value="' + response.data[i].extra_id + '">'+food_extra_name_germany+'</option>';
                    }
                    var id = row.attr("data-id");
                    var data_type =  row.parent().attr("data-type");
                    var last_row = $(".tab-pane.active ." + data_type + "_price-table" + " .food-extra-row[data-id = '"+ id +"']").last() ;
                    if ($(".tab-pane.active ." + data_type + "_price-table" + " .food-extra-row[data-id = '"+ id +"']").length == 0){
                        last_row = $(".menu-detailed-page .price-table" + " .food-extra-row[data-id = '"+ id +"']").last();
                    }
                    new_row_id = parseInt(last_row.attr("data-extra-id")) + 1;
                    new_row =''; 
                    new_row +=''; 
                    new_row +='<tr class="food-extra-row" data-extra-id = "'+ new_row_id +'" data-id = "'+id+'">'; 
                    new_row +='<td class="food_extra">'; 
                    new_row +='<select class="form-control extra_id english-field hide-field" name="extra_id_english['+id+']['+ new_row_id +']" required="">'; 
                    new_row += extra_eng + '</select>'; 
                    new_row +='<select class="form-control extra_id germany-field hide-field" name="extra_id_germany['+id+']['+ new_row_id +']" required="">'; 
                    new_row += extra_ger + '</select>'; 
                    new_row +='<select class="form-control extra_id french-field hide-field" name="extra_id_french['+id+']['+ new_row_id +']" required="">'; 
                    new_row += extra_fre + '</select>'; 
                    new_row +='</td>'; 
                    new_row +='<td class="pl-3 extra_price"><input type="number" name="extra_price['+id+']['+ new_row_id +']" class="form-control" placeholder="' + extra_price_placeholder + '" data-extra-id = "'+ new_row_id +'" min = "0" step = "0.01"></td>'; 
                    new_row +='<td class="text-warning text-center pl-1 del-extra-price-row" ><i class="fa fa-times-circle"></i></td>'; 
                    new_row +='<td class="text-primary text-center pl-1 add-extra-price-row"><i class="fa fa-plus"></i></td>'; 
                    new_row +='</tr>';
    
                    last_row.after(new_row);
                    $("." + lang + "-field").removeClass("hide-field");
                }else{
                    swal("Ooops..","This category hasn't any Food Extra","error");
                }
            }
        });
    }else{
        swal("Ooops..","Please Select Category","error");
    }
});
$(document).on('click','.del-extra-price-row',function(){
    var row = $(this).parent();
    id = row.attr("data-id");
    extra_id = row.attr("data-extra-id");
    row = $('.food-extra-row[data-id="'+id+'"][data-extra-id="'+extra_id+'"]');
    row.remove();
});
$(document).on('click','#save_pdf',function(){
    var divName= "order-table";

    var printContents = document.getElementById(divName).innerHTML;
    var originalContents = document.body.innerHTML;

    document.body.innerHTML = printContents;

    window.print();

    document.body.innerHTML = originalContents;
});
$(document).on('click','#save_pdf_a4',function(){
    var divName= "order_a4";

    var printContents = document.getElementById(divName).innerHTML;
    var originalContents = document.body.innerHTML;
    document.body.innerHTML = '<style>@page {size: A4 landscape;}</style>' + printContents;

    window.print();

    document.body.innerHTML = originalContents;
});
$(document).on('change','.homepage-services input',function(){
    $(this).parent().toggleClass("active");
});
$(document).on('change','#company_location_country',function(){
    $("#company_vat_number").val($(this).val());
    
});
$(document).on('change','#company_vat_number',function(){
    url =  $('footer').attr("data-url") + "API/validateCheckVAT";
    countryCode = $("#company_location_country").val();
    vatNumber = $(this).val();
    $.ajax({
        url:url,
        type:"post",
        data:{countryCode:countryCode , vatNumber: vatNumber},
        success:function(response){
            response=JSON.parse(response);
            if (response.status == "true"){
                $(".company_vat_field").removeClass("j-invalid-value").addClass("j-valid-value");
                $(".is_valid_vat").removeClass("hide-field");
                $(".is_invalid_vat").addClass("hide-field");
            }else{
                $(".company_vat_field").addClass("j-invalid-value").removeClass("j-valid-value");
                $(".is_valid_vat").addClass("hide-field");
                $(".is_invalid_vat").removeClass("hide-field");
            }
        }
    })
});

$(document).on('change','.active_page_option .active_page_item',function(){
    $(this).parent().toggleClass("active");
});
$(document).on('click','#filter_order',function(){
    $(".order-row").addClass("hide-field");
    order_id = $("#order_number").val();
    if (order_id == ""){
        start_date = new Date($("#start_date").val() + " 00:00:00");
        end_date = new Date($("#end_date").val() + " 00:00:00");
        empty = new Date("");
        order_row = $(".order-row");
        for (let index = 0; index < order_row.length; index++) {
            ele = $(order_row)[index];
            order_data_id = $(ele).attr("data-id");
            order_date = $(".order-row-" + order_data_id).find(".order-date").text();
            odate = new Date(order_date);
            // console.log(odate.toUTCString());
            // console.log(odate.toDateString());
            if ($("#start_date").val() == ""){
                if ($("#end_date").val() == ""){
                    $(".order-row-" + order_data_id).removeClass("hide-field");
                }else{
                    if (end_date > odate){
                        $(".order-row-" + order_data_id).removeClass("hide-field");
                    }
                }
            }else{
                if ($("#end_date").val() == ""){
                    if (start_date < odate){
                        $(".order-row-" + order_data_id).removeClass("hide-field");
                    }
                }else{
                    if (end_date > odate && start_date < odate ){
                        $(".order-row-" + order_data_id).removeClass("hide-field");
                    }
                }
                
            }
        }
    }else{
        
        order_row = $(".order-row");
        for (let index = 0; index < order_row.length; index++) {
            ele = $(order_row)[index];
            order_data_id = $(ele).attr("data-id");
            order_type_id = $(".order-row-" + order_data_id).find(".order-id").text();
            if (order_type_id.includes(order_id)){
                $(".order-row-" + order_data_id).removeClass("hide-field");
            }
        }
    }
});
$(document).on('click','.close-announcement-btn',function(){
    announcement_id = $(this).attr("data-announcement-id");
    rest_id =$('footer').attr("data-rest_id");
    url =  $('footer').attr("data-url") + "Restaurant/hideAnnouncement";
    $(this).parent().addClass("hide-field");
    $.ajax({
        url:url,
        type:"post",
        data:{announcement_id:announcement_id , rest_id: rest_id},
        success:function(response){
            response=JSON.parse(response);
            if (response.status == 1){
            }
        }
    })
});
$(document).on('click','.announcement-notification-btn',function(){
    ann_id = $(this).attr("data-announcement-id");
    ann_ele = ".j-annnouncement-" + ann_id;
    $(ann_ele).removeClass("hide-field");
});
$(document).on('click','.delivery_area_zone_type:not(.selected)',function(){
    $(this).parents(".zone_area").find(".delivery_area_zone_type").removeClass("selected");
    $(this).addClass("selected");
});

$(document).on('submit','#restaurantSEOSetting',function(e){
    e.preventDefault();
    url =  $('footer').attr("data-url") + "API/restaurantSEOSetting";
    ajaxSubmitForm(url,$(this)[0]);
});
$(document).on('submit','#restaurantSocialSetting',function(e){
    e.preventDefault();
    url =  $('footer').attr("data-url") + "API/restaurantSocialSetting";
    ajaxSubmitForm(url,$(this)[0]);
});

$(document).on('submit','#updateLegalSetting',function(e){
    e.preventDefault();
    url =  $('footer').attr("data-url") + "API/updateLegalSetting";
    ajaxSubmitForm(url,$(this)[0]);
});
$(document).on('submit','#addon_payout',function(e){
    e.preventDefault();
    base_url = $('footer').attr("data-url") ;
    url =  base_url + "API/addonPayout";
    var formData= new FormData($(this)[0]);
    $.ajax({
        url:url,
        type:"post",
        processData:false,
        cache:false,
        contentType:false,
        enctype:"multipart/form-data",
        data:formData,
        success:function(response){
            response=JSON.parse(response);
            if(response.status==1){
                addon_id = response.addon_id;
                addon_invoice_id = response.addon_invoice_id;
                // if ($("#payment_method").val() == "paypal"){
                    swal("Great","Email will be sent to you.","success");
                    setTimeout(function(){
                        window.location = base_url + 'Restaurant/recurringPaymentReview/' + addon_invoice_id;
                    },1500);
                // }else{
                //     amount =  response.stripe.amount;
                //     currency_symbol = response.stripe.currency_symbol;
                //     $("#addonStripePaymentModal").modal("show");
                //     $("#addonStripePaymentModal #addonStripePaymentForm #addon_invoice_id").val(response.addon_invoice_id);
                //     $("#addonStripePaymentModal #addonStripePaymentForm #stripe_submit_btn").val("Pay " + currency_symbol +" "+ amount);
                // }
            }else{
                swal("Ooops..","Something went wrong","error");
            }
        }
    })
});
$(document).on('submit','#addonStripePaymentForm',function(e){
    e.preventDefault();
    base_url = $('footer').attr("data-url") ;
    url =  base_url + "API/addonPayout";
    var formData= $("#addonStripePaymentForm, #addon_payout").serialize();
    $.ajax({
        url:url,
        type:"post",
        data:formData,
        success:function(response){
            response=JSON.parse(response);
            if(response.status==1){

            }else{
                swal("Ooops..","Something went wrong","error");
            }
        }
    })
});
$(document).on('keydown','#addonStripePaymentForm #stripe_expiry',function(e){
    var inputLength = e.target.value.length;
    var thisVal = e.target.value;
    if (e.keyCode != 8){
        if(inputLength === 2 && e.keyCode != 191){
            thisVal += '/';
            $(e.target).val(thisVal);
        }
    }
});
$(document).on('keydown','#addonStripePaymentForm #stripe_card',function(e){
    e.target.value = e.target.value.replace(/[^\dA-Z]/g, '').replace(/(.{4})/g, '$1 ').trim();
});
$(document).on('click','.confirm-addon_subscription-btn',function(e){
    rest_id = $("footer").attr("data-rest_id");
    addon_id = $("input[name='addon_id']").val();
    base_url = $("footer").attr("data-url");
    $.ajax({
        url:base_url + "API/addonRecurringPlanConfirm",
        type:"post",
        data:{"rest_id":rest_id,"addon_id":addon_id},
        success:function(response){
            response=JSON.parse(response);
            console.log(response);
            if(response.code==1){
                swal("Great..","Addon package is purchased successfully.","success");
                setTimeout(function(){
                    window.location = base_url + 'Restaurant/Addon';
                },1500);
            }else{
                swal("Ooops..",response.error);
            };
        }
    })
});
$(document).on('click','.plan-btn',function(e){
    rest_id = $("#restaurantSetting").attr("data-rest_id");
    plan = $(this).attr("data-plan");
    base_url = $("footer").attr("data-url");
    if (plan == $(".bg-success.plan-btn").attr("data-plan")){

    }else{
        $.ajax({
            url:base_url + "API/updateRestaurantSetting",
            type:"post",
            data:{"myRestId":rest_id,"plan":plan},
            success:function(response){
                response=JSON.parse(response);
                if(response.code==1){
                    if (plan=="pro"){
                        window.location = base_url + 'API/recurringPaymentPlan/' + plan;
                    }else{
                        swal("Great..","Plan Updated Successfully.","success");
                        setInterval(function(){
                            location.reload();
                        },1500);
                    }
                }else{
                    swal("Ooops..","Something went wrong","error");
                    setInterval(function(){
                        location.reload();
                    },1500);
                }
            }
        })
    }
});
$(document).on('click','.confirm-plan-btn',function(e){
    rest_id = $("footer").attr("data-rest_id");
    base_url = $("footer").attr("data-url");
    $.ajax({
        url:base_url + "API/recurringPlanConfirm",
        type:"post",
        data:{"myRestId":rest_id},
        success:function(response){
            response=JSON.parse(response);
            if(response.code==1){
                swal("Great..","Plan Updated Successfully.","success");
            }else{
                swal("Ooops..","error");
            };
        }
    })
});
$(document).on('click','.cancel-plan-btn',function(e){
    rest_id = $("footer").attr("data-rest_id");
    base_url = $("footer").attr("data-url");
    $.ajax({
        url:base_url + "API/updateRestaurantSetting",
        type:"post",
        data:{"myRestId":rest_id,"plan":"free"},
        success:function(response){
            response=JSON.parse(response);
            if(response.code==1){
                swal("Hmm..","Pro Plan canceled.","success");
                setInterval(function(){
                    window.location.href = base_url + "Restaurant/setting";
                },1500);
            }else{
                swal("Ooops..","Something went wrong","error");
            };
        }
    })
});
$('.remove_addon_invoice').on('click',function(e){
    var invoice_id = $(this).attr('d-invoice_id');
    url =  $('footer').attr("data-url") + "API/removeAddonInvoice";
    $.ajax({
        url:url,
        type:"post",
        data:{invoice_id:invoice_id},
        success:function(response){
            response=JSON.parse(response);
            if(response.status==1){
                swal("Done..","Deleted Successfully.","success");
            }else{
                swal("Ooops..","Something went wrong","error");
            }
            setInterval(function(){
                location.reload();
            },1500);
        }
    })
});
// $("#menuList").sortable({
//     items: 'tr.our-menu-td:not(.category-title-bar):not(tr:first-child)',
//     cursor: 'pointer',
//     axis: 'y',
//     dropOnEmpty: false,
//     start: function (e, ui) {
//         ui.item.addClass("selected");
//     },
//     stop: function (e, ui) {
//         ui.item.removeClass("selected");
//         console.log(e,ui);
//         $(this).find("tr").each(function (index) {
//             if (index > 0) {
//                 // $(this).find("td").eq(2).html(index);
//             }
//         });
//     }
// });
// ------------------------------------------------------------------------------------
function check_is_exist_new(){
    base_url = $("footer").attr("data-url");
    rest_id = $("footer").attr("data-rest_id");
    $.ajax({
        url:base_url + 'API/check_new_order',
        type:"post",
        data:{rest_id:rest_id},
        success:function(response){
            response=JSON.parse(response);
            if(response.status==1){
                for (let index = 0; index < response.new_orders.length; index++) {
                    console.log(response.new_orders[index]);
                    print_by_thermal(order_id);
                }
            }else{
                // swal('Ooops..','Something went wrong',"error");
            }
        }
    });
}
// ------------------------------------Admin dashboard --------------------------------

$('#videoTutorialsForm').on('submit',function(e){
    e.preventDefault();
    url =  $('footer').attr("data-url") + "Admin/adminVideoTutorials";
    var formData= new FormData($(this)[0]);
    $.ajax({
        xhr: function() {
            var xhr = new window.XMLHttpRequest();         
            xhr.upload.addEventListener("progress", function(element) {
                if (element.lengthComputable) {
                    var percentComplete = ((element.loaded / element.total) * 100);
                    $(".video-upload-status").width(percentComplete + '%');
                    $(".video-upload-status").html(percentComplete+'%');
                }
            }, false);
            return xhr;
        },
        url:url,
        type:"post",
        cache:false,
        contentType:false,
        processData:false,
        data:formData,
        beforeSend: function(){
            $(".video-upload-status").width('0%');
            $(".video-upload-status-bar").removeClass('hide-field');
        },
        success:function(response){
            response=JSON.parse(response);
            if(response.status==1){
                swal("Great..","Updated Successfully.","success");
            }else{
                swal("Ooops..","Something went wrong","error");
            }
            setInterval(function(){
                location.reload();
            },1500);
        }
    })
});
$('#adminFreeSupport').on('submit',function(e){
    e.preventDefault();
    url =  $('footer').attr("data-url") + "Admin/adminFreeSupport";
    ajaxSubmitForm(url,$(this)[0]);
});

$('#announcement-setting-update-form').on('submit',function(e){
    e.preventDefault();
    url =  $('footer').attr("data-url") + "API/updateAnnouncement";
    ajaxSubmitForm(url,$(this)[0]);
});
$('#announcement-setting').on('submit',function(e){
    e.preventDefault();
    url =  $('footer').attr("data-url") + "API/AddAnnouncement";
    ajaxSubmitForm(url,$(this)[0]);
});
$('.remove_announcement').on('click',function(){
    var announcement_id=$(this).attr('d-announcement_id');
    url =  $('footer').attr("data-url") + "API/removeAnnouncement";
    $.ajax({
    url:url,
    type:"post",
    data:{announcement_id:announcement_id},
    success:function(response){
        response=JSON.parse(response);
        if(response.status==1){
        swal("Done..","Deleted Successfully.","success");
        }else{
        swal("Ooops..","Something went wrong","error");
        }
        setInterval(function(){
        location.reload();
        },1500);
    }
    })
});
$('.remove_video_tutorial').on('click',function(){
    var video_id=$(this).attr('d-video_id');
    url =  $('footer').attr("data-url") + "API/removeVideoTutorial";
    $.ajax({
    url:url,
    type:"post",
    data:{video_id:video_id},
    success:function(response){
        response=JSON.parse(response);
        if(response.status==1){
        swal("Done..","Deleted Successfully.","success");
        }else{
        swal("Ooops..","Something went wrong","error");
        }
        setInterval(function(){
        location.reload();
        },1500);
    }
    })
});
$('.is_upload_new_video').on('change',function(){
    is_upload_new_video = $(this).prop("checked");
    if (is_upload_new_video){
        $(".new_video_upload").removeClass("hide-field");
        $(".old_video").addClass("hide-field");
    }else{
        $(".new_video_upload").addClass("hide-field");
        $(".old_video").removeClass("hide-field");
    }
});
$('.addNewKitchen').on('submit',function(e){
    e.preventDefault();
    var formData= new FormData($(this)[0]);
    url = $(this).attr("data-url") + "/API/addNewKitchen";
    kitchen_name_english = $(this).find("input[name='kitchen_name_english']").val();
    kitchen_name_french = $(this).find("input[name='kitchen_name_french']").val();
    kitchen_name_germany = $(this).find("input[name='kitchen_name_germany']").val();
    if (kitchen_name_germany == "" && kitchen_name_french == "" && kitchen_name_english == ""){
        swal("Ooops..","You should insert at least one field.","error");
    }else{
        $.ajax({
            url:url,
            type:"post",
            cache:false,
            contentType:false,
            processData:false,
            data:formData,
            success:function(response){
                
                response=JSON.parse(response);
                if(response.status==1){
                    swal("Great..","Kitchen Added Successfully.","success");
                }else if(response.status==2){
                    swal("Wait..","Details Already Exists","warning");
                }else{
                    swal("Ooops..","Something went wrong","error");
                }
                setInterval(function(){
                    location.reload();
                },1500);
            }
        })
    }
});
$('.remove_kitchen').on('click',function(){
    var kitchen_id=$(this).attr('d-kitchen_id');
    // alert("Activate "+rest_id);
    url =  $('#addNewKitchen').attr("data-url") + "API/removeKitchen";
    $.ajax({
    url:url,
    type:"post",
    data:{kitchen_id:kitchen_id},
    success:function(response){
        response=JSON.parse(response);
        if(response.status==1){
            swal("Done..","Deleted Successfully.","success");
        }else{
            swal("Ooops..","Something went wrong","error");
        }
        setInterval(function(){
            location.reload();
        },1500);
    }
    })
});
$('#updateKitchen').on('submit',function(e){
    e.preventDefault();
    url =  $('footer').attr("data-url") + "Admin/updateKitchen";
    ajaxSubmitForm(url,$(this)[0]);
});
$('#fileUploadingSetting').on('submit',function(e){
    e.preventDefault();
    url =  $('footer').attr("data-url") + "Admin/updateFileUploadingSetting";
    ajaxSubmitForm(url,$(this)[0]);
});
$('#createAddon').on('submit',function(e){
    e.preventDefault();
    url =  $('footer').attr("data-url") + "Admin/createAddon";
    ajaxSubmitForm(url,$(this)[0]);
});
$('#editAddon').on('submit',function(e){
    e.preventDefault();
    url =  $('footer').attr("data-url") + "Admin/updateAddon";
    ajaxSubmitForm(url,$(this)[0]);
});
$('.addon_content_html').on('summernote.change',function(e){
    html_lang = $(this).attr("data-html_lang");
    html = `<div class="plan-package">
        <div class="item pb-0">
        <div class="item-body px-md-3">
        `+$(this).val()+`
        </div>
    </div>`;
    $(".addon_html_preview[data-html_lang='"+html_lang+"']").html(html);
});
$('.remove_addon').on('click',function(e){
    var addon_id = $(this).attr('d-addon_id');
    url =  $('footer').attr("data-url") + "Admin/removeAddon";
    $.ajax({
        url:url,
        type:"post",
        data:{addon_id:addon_id},
        success:function(response){
            response=JSON.parse(response);
            if(response.status==1){
                swal("Done..","Deleted Successfully.","success");
            }else{
                swal("Ooops..","Something went wrong","error");
            }
            setInterval(function(){
                location.reload();
            },1500);
        }
    })
});
$('.handle_addon').on('change',function(e){
    var addon_id = $(this).attr('d-addon_id');
    if ($(this).prop("checked")){
        addon_status = "active";
    }else{
        addon_status = "inactive";
    }
    url =  $('footer').attr("data-url") + "Admin/changeAddonStatus";
    $.ajax({
        url:url,
        type:"post",
        data:{addon_id:addon_id,addon_status:addon_status},
        success:function(response){
            response=JSON.parse(response);
            if(response.status==1){
                swal("Done..","Update Successfully.","success");
            }else{
                swal("Ooops..","Something went wrong","error");
            }
            setInterval(function(){
                location.reload();
            },1500);
        }
    })
});
$('.cancel-addon-btn').on('click',function(e){
    var addon_id = $(this).attr('d-addon_id');
    url =  $('footer').attr("data-url") + "API/cancelAddon";
    var rest_id = $('footer').attr("data-rest_id");
    btn_text_yes = 'Yes, Cancel it';
    btn_text_no = 'No, Decide later';
    swal({
        title: "Are you sure?",
        text: "If you click yes, you cancel your subscription.",
        icon: "success",
        buttons: [
            btn_text_no,
            btn_text_yes
          ],
        dangerMode: true
    }).then(
        function (isConfirm) {
            if (isConfirm) {
                $.ajax({
                    url:url,
                    type:"post",
                    data:{addon_id:addon_id,rest_id:rest_id},
                    success:function(response){
                        response=JSON.parse(response);
                        if(response.status==1){
                            swal("Done..","Canceled Successfully.","success");
                        }else{
                            swal("Ooops..","Something went wrong","error");
                        }
                        setInterval(function(){
                            location.reload();
                        },1500);
                    }
                })
            }else{
            }
        }
    )
});
$('.addon-status-btn').on('change',function(){
    let status = $(this).val();
    let rest_id = $(this).attr('data-rest_id');
    let addon_id = $(this).attr('data-addon_id');
    $(this).removeClass('inactive').removeClass('active').removeClass('accepted').removeClass('pending').addClass(status);
    let pF= false;
    let rest_addon_ele = $('.rest-addon-row[data-rest_id='+rest_id+'] .status-field .addon-status-btn');
    let active_arr = [];
    rest_addon_ele.each(function() {
        if ($(this).hasClass('pending')){
            pF = true;
        }else if ($(this).val() == 'active'){
            active_arr.push($(this).attr('data-addon_id'));
        }
    });
    if (!pF){
        $('.rest-addon-row[data-rest_id='+rest_id+'] .rest-name').removeClass('has_new_addon_request');
    }else{
        $('.rest-addon-row[data-rest_id='+rest_id+'] .rest-name').addClass('has_new_addon_request');
    }
    url =  $('footer').attr("data-url") + "Admin/changeRestAddonStatus";
    $.ajax({
        url:url,
        type:"post",
        data:{addon_id:addon_id,status:status,rest_id:rest_id,active_arr:active_arr.toString()},
        success:function(response){
            response=JSON.parse(response);
            if(response.status==1){
                swal("Done..","Update Successfully.","success");
            }else{
                swal("Ooops..","Something went wrong","error");
            }
        }
    })
});
// ------------------------------------------------------------------------------------
function ajaxSubmitForm(url,e){
    var formData= new FormData(e);
    $.ajax({
    url:url,
    type:"post",
    cache:false,
    contentType:false,
    processData:false,
    data:formData,
    success:function(response){
        
        response=JSON.parse(response);
        if(response.status==1){
            swal("Great..","Updated Successfully.","success");
        }else{
            swal("Ooops..","Something went wrong","error");
        }
        setInterval(function(){
            location.reload();
        },1500);
    }
    })
}
$(document).on('click','.multi-lang-page .item-flag',function(){
    select_lang = $(this).attr("data-flag");
    $(this).parent().find(".item-flag").removeClass("active");
    $(this).addClass("active");
    $(this).parents(".card").find(".lang-field").addClass("hide-field");
    $(this).parents(".card").find("."+select_lang+"-field").removeClass("hide-field");
});
$(document).on('click','.pageSetting-page section .close-section-btn',function(){
    let current_section = $(this).parents('section');
    const rest_id = $('footer').attr('data-rest_id');
    const section_id = current_section.attr('id');
    const section_type = current_section.attr('data-section_type');
    const url =  $('footer').attr('data-url') + 'API/removeHomePageSection';
    let rF = true;
    current_section.remove();
    const sId = current_section.find('input[name="sId"]').val();
    if ('homepage-my-service' !== section_type && 'homepage-welcome' !== section_type && 'undefined' !== sId){
        rF = false;
        $.ajax({
            url:url,
            type:'post',
            data:{rest_id:rest_id,section_id:section_id,sId:sId,section_type:section_type},
            success:function(response){
                response=JSON.parse(response);
                if(response.status==1){
                    rF = true;
                }else{
                    swal("Ooops..","Something went wrong","error");
                }
            }
        })
    }
    if (rF){
        swal("Done..","Remove the Section Successfully","success");
    }
});
$(document).on('click','.pageSetting-page section .sort-up-btn',function(){
    rearrangeHomeSection(this,'up');
});
$(document).on('click','.pageSetting-page section .sort-down-btn',function(){
    rearrangeHomeSection(this,'down');
});
function rearrangeHomeSection(e,type){
    let current_section = $(e).parents('section');
    const rest_id = $('footer').attr("data-rest_id");
    const section_id = current_section.attr("id");
    let current_sort_id = current_section.attr('data-sort_id');

    var max_sort_id = null;
    $('section').each(function() {
        var value = parseFloat($(this).attr('data-sort_id'));
        max_sort_id = (value > max_sort_id) ? value : max_sort_id;
    });
    let nF = false;
    if (type == 'up' && current_sort_id > 1){
        var des_section = current_section.prev();
        nF = true;
    }else if (type == 'down' && current_sort_id < max_sort_id){
        var des_section = current_section.next();
        nF = true;
    }
    if (nF){
        const des_section_id = des_section.attr("id");
        des_sort_id = des_section.attr('data-sort_id');
        url =  $('footer').attr("data-url") + "API/rearrangeSortHomeSection";
        $.ajax({
            url:url,
            type:"post",
            data:{rest_id:rest_id,section_id:section_id,des_section_id:des_section_id,sort_id:current_sort_id,sort_type:type},
            success:function(response){
                response=JSON.parse(response);
                if(response.status==1){
                    des_section.attr('data-sort_id', current_sort_id);
                    current_section.attr('data-sort_id', des_sort_id);
                    if (des_section.find('input[name="sort_num"]').length > 0){
                        des_section.find('input[name="sort_num"]').val(current_sort_id);
                    }
                    if (current_section.find('input[name="sort_num"]').length > 0){
                        current_section.find('input[name="sort_num"]').val(des_sort_id);
                    }
                    if (type == 'up'){
                        current_section.insertBefore(des_section);
                    }else if(type == 'down'){
                        current_section.insertAfter(des_section);
                    }
                }else{
                    swal("Ooops..","Something went wrong","error");
                }
            }
        })
    }
}
$(document).on('click','.pageSetting-page section #add_new_section_btn',function(){
    $('#new-section-type-select').modal('show');
});
$(document).on('click','.pageSetting-page section #select_new_section_type_btn',function(){
    $('#new-section-type-select').modal('show');
});
$(document).on('change','#new-section-type-select .home-text-type-box',function(){
    $('#new-section-type-select .home-text-type').removeClass('active');
    $('input.home-text-type-box[name="home-text-type-box"]:checked').parents('.home-text-type').addClass('active');
});
$(document).on('change','#new-section-type-select .section_type',function(){
    if ($('input.section_type[name="section_type"]:checked').val() == 'homepage-text'){
        $('#new-section-type-select .homepage-text-div').removeClass('hide-field');
    }else{
        $('#new-section-type-select .homepage-text-div').addClass('hide-field');
    }
});
$(document).on('click','#new-section-type-select #select_section_type_btn',function(){
    let section_type = $('input.section_type[name="section_type"]:checked').val();
    let url =  $('footer').attr("data-url");
    var max_sort_id = null;
    $('.pageSetting-page section').each(function() {
        var value = parseFloat($(this).attr('data-sort_id'));
        max_sort_id = (value > max_sort_id) ? value : max_sort_id;
    });
    let sort_num = max_sort_id + 1;
    if (section_type == 'homepage-text'){
        let text_section_type = $('input.home-text-type-box[name="home-text-type-box"]:checked').val();
        let section_id = 'homepage-text-'+sort_num;
        let section_heading_label = $("#homepage-welcome .card-body .section_heading_label").html();
        let langBarHtml = $("#homepage-welcome .card-header .lang-bar").html();
        let contentHtml = `
            <section class="homepage-text" id="`+section_id+`" data-sort_id="`+sort_num+`">
                <form class="updateHomepageTextSection" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="home_text_section_type" value="`+text_section_type+`">
                    <input type="hidden" name="sort_num" value="`+sort_num+`">
                    <input type="hidden" name="section_id" value="`+section_id+`">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex justify-content-between title-bar">
                            <div class="d-flex justify-content-between align-items-center left-bar">
                                <span class="sort-section-btn mr-2 ctrl-btn sort-down-btn">
                                    <img class="tar-icon" src="`+url+`assets/additional_assets/svg/arrow-alt-down.svg">
                                </span>
                                <span class="sort-section-btn mr-2 ctrl-btn sort-up-btn">
                                    <img class="tar-icon" src="`+url+`assets/additional_assets/svg/arrow-alt-up.svg">
                                </span>
                                <div class="v-splite-line"></div>
                                <input type="checkbox" data-plugin="switchery" name = "is_show_section" data-color="#3DDCF7"/>
                                <a class="section_title text-uppercase font-weight-bold j-font-size-18px mx-2" data-toggle="collapse" href="#`+section_id+`-body" role="button" aria-expanded="true" aria-controls="`+section_id+`-body">Unnamed</a>
                            </div>
                            <div class="right-bar">
                                <div class="lang-bar">
                                    `+langBarHtml+`
                                </div>
                                <div class="v-splite-line"></div>
                                <span class="close-section-btn">
                                    <i class="fa fa-times-circle"></i>
                                </span>
                            </div>
                        </div>
                        <div class="card-body collapse show" id="`+section_id+`-body">
                            <div class="form-group row">
                                <label class="col-md-4 text-center">`+section_heading_label+`</label>
                                <div class="input-group french-field hide-field col-md-8 lang-field">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="`+url+`assets/flags/fr-flag.png"></span>
                                    </div>
                                    <input type="text" class="form-control home_section_heading" name="section_heading_french" placeholder="Welcome" value="">
                                </div>
                                <div class="input-group germany-field hide-field col-md-8 lang-field">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="`+url+`assets/flags/ge-flag.png"></span>
                                    </div>
                                    <input type="text" class="form-control home_section_heading" name="section_heading_germany" placeholder="Welcome" value="">
                                </div>
                                <div class="input-group english-field hide-field col-md-8 lang-field">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="`+url+`assets/flags/en-flag.png">
                                        </span>
                                    </div>
                                    <input type="text" class="form-control home_section_heading" name="section_heading_english" placeholder="Welcome" value="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4 update-image">
                                    <input type="file" class="dropify" name="home_section_img" data-default-file = "" value = ""/>

                                    <input type="hidden" name="is_update_home_section_img" value = "" />
                                </div>
                                <div class="col-md-8">
                                    <div class="input-group english-field hide-field content-editor lang-field">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="`+url+`assets/flags/en-flag.png"></span>
                                        </div>
                                        <textarea class="summernote form-control home_section_content" name="page_content_english"></textarea>
                                    </div>
                                    <div class="input-group french-field hide-field content-editor lang-field">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="`+url+`assets/flags/fr-flag.png"></span>
                                        </div>
                                        <textarea class="summernote form-control home_section_content" name="page_content_french"></textarea>
                                    </div>
                                    <div class="input-group germany-field hide-field content-editor lang-field">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="`+url+`assets/flags/ge-flag.png"></span>
                                        </div>
                                        <textarea class="summernote form-control home_section_content" name="page_content_germany"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-12 mx-auto mb-3 mb-sm-0">
                                    <input type="submit" name="" value="SAVE" class="btn btn-danger btn-user btn-block submit-btn">
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </section>
        `;
        console.log($('#' + section_id + ' input[data-plugin="switchery"]'));
        
        $('.new_section').before(contentHtml);
        enableExternalPlugin_newTag(section_id);
        
    } else if(section_type == 'homepage-gallery'){

    }
});
$(document).on('submit','.updateHomepageTextSection',function(e){
    e.preventDefault();
    url =  $('footer').attr("data-url") + "Restaurant/updateHomepageTextSection";
    ajaxSubmitForm(url,$(this)[0]);
});
$(document).on('change','.pageSetting-page .homepage-text .home_section_heading',function(){
    $(this).parents('section').find('.section_title').html($(this).val());
});

function enableExternalPlugin_newTag(section_id){
    new Switchery($('#' + section_id + ' input[data-plugin="switchery"]')[0], $('#' + section_id + ' input[data-plugin="switchery"]').data());
    let active_lang = $('.pageSetting-page').attr('data-active_lang');
    $('#' + section_id + ' .lang-field.'+active_lang+'-field').removeClass('hide-field');
    $('.summernote').summernote({ 
        "height": 145, });
    $(".dropify").dropify({messages:{default:"Drag and drop a file here or click",replace:"Drag and drop or click to replace",remove:"Remove",error:"Ooops, something wrong appended."},error:{fileSize:"The file size is too big (1M max)."}});
}
$(document).ready(function() {
    lang = $('.multi-lang-page .lang-bar').find('span.active').attr("data-flag");
    
    $(".multi-lang-page ."+lang+"-field").removeClass("hide-field");
    $('.summernote').summernote({ 
        "height": 110, });
});

// $(document).ready(function() {
//     setInterval(iframeResize, 1000);
// });
$(document).ready(function() {
    if ($(".timepickers").length){
        $(".timepickers").timepicker();
    }
    if ($(".order_reservation_time").length){
        min_time = $(".order_reservation_time").attr("data-min_time");
        max_time = $(".order_reservation_time").attr("data-max_time");
        open_pre_order = $(".order_reservation_time").attr("data-open_pre_order");
        if (open_pre_order){
            $(".order_reservation_time").timepicker({ 
                'step': 15 ,
                'minTime': min_time,
                'maxTime': max_time,
            });
        }else{
            $(".order_reservation_time").timepicker({ 
                'step': 15 ,
                'minTime': "00:00",
                'maxTime': "23:59",
            });
        }
    }
    if ($(".datepickers").length){
        $(".datepickers").datepicker();
    }

    if ($(".dataTable").length){
        $('.dataTable').DataTable();
    }
 
    if ($('[data-plugin="switchery"]').length > 0){
        $('[data-plugin="switchery"]').each(function (e, t) {
            new Switchery($(this)[0], $(this).data());
        });
    }
    if ($('[data-plugin="multiselect"]').length > 0){
        $('[data-plugin="multiselect"]').multiSelect($(this).data());
    }
    if ($(".select2").length > 0){
        $(".select2").select2();
    }
});

var config = {
    '.chosen-select'           : {},
    '.chosen-select-deselect'  : { allow_single_deselect: true },
    '.chosen-select-no-single' : { disable_search_threshold: 10 },
    '.chosen-select-no-results': { no_results_text: 'Oops, nothing found!' },
    '.chosen-select-rtl'       : { rtl: true },
    '.chosen-select-width'     : { width: '95%' },
    '.chosen-select-width-allergens'     : {placeholder_text: "Select Allergens",width: '95%', height: '56px' },
    '.chosen-select-width-subcategories'     : {placeholder_text: "Select Subcategories",width: '95%' },
    '.chosen-select-width-foodextra'     : {placeholder_text: "Select Food Extra",width: '95%' },
}
for (var selector in config) {
    $(selector).chosen(config[selector]);
}

