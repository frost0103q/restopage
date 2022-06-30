
<div class="container">
    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="py-5 px-md-5 px-3">
                        <form class="user" id="restaurantSetting" data-rest_id = "<?=$restDetails->rest_id?>">
                            <section class="active-pages">
                                <div class="">
                                    <h1 class="h4 text-gray-900 mb-4"><?= $this->lang->line('Activate and deactivate Pages')?></h1>
                                    <hr>
                                </div>
                                
                                <div class="row">
                                    <div  class="active_page_option col-md-6 py-1 px-3 px-lg-5">
                                        <label class="border d-flex justify-content-between align-items-center w-100 p-3 rounded mb-0 <?= in_array("home",explode(",",$restDetails->active_pages)) ? "active" : "" ?>">    
                                            <span>Home</span> 
                                            <i class="fa fa-check active-signal"></i>
                                            <i class="fa fa-times bg-danger deactive-signal"></i>
                                            <input type="checkbox" class="active_page_item hide-field" id ="active_page_home" name="active_page_home"  <?= in_array("home",explode(",",$restDetails->active_pages)) ? "checked" : "" ?>>
                                        </label>
                                    </div>
                                    <div  class="active_page_option col-md-6 py-1 px-3 px-lg-5">
                                        <label class="border d-flex justify-content-between align-items-center w-100 p-3 rounded mb-0 <?= in_array("menu",explode(",",$restDetails->active_pages)) ? "active" : "" ?>">    
                                            <span>Food Menu</span> 
                                            <i class="fa fa-check active-signal"></i>
                                            <i class="fa fa-times bg-danger deactive-signal"></i>
                                            <input type="checkbox" class="active_page_item hide-field" id ="active_page_menu" name="active_page_menu" <?= in_array("menu",explode(",",$restDetails->active_pages)) ? "checked" : "" ?>>
                                        </label>
                                    </div>
                                    <div  class="active_page_option col-md-6 py-1 px-3 px-lg-5">
                                        <label class="border d-flex justify-content-between align-items-center w-100 p-3 rounded mb-0 <?= in_array("reservation",explode(",",$restDetails->active_pages)) ? "active" : "" ?>">    
                                            <span>Reservation</span> 
                                            <i class="fa fa-check active-signal"></i>
                                            <i class="fa fa-times bg-danger deactive-signal"></i>
                                            <input type="checkbox" class="active_page_item hide-field" id ="active_page_reservation" name="active_page_reservation" <?= in_array("reservation",explode(",",$restDetails->active_pages)) ? "checked" : "" ?>>
                                        </label>
                                    </div>
                                    <div  class="active_page_option col-md-6 py-1 px-3 px-lg-5">
                                        <label class="border d-flex justify-content-between align-items-center w-100 p-3 rounded mb-0 <?= in_array("tc",explode(",",$restDetails->active_pages)) ? "active" : "" ?>">    
                                            <span><?= $this->lang->line("Terms and Conditions")?></span> 
                                            <i class="fa fa-check active-signal"></i>
                                            <i class="fa fa-times bg-danger deactive-signal"></i>
                                            <input type="checkbox" class="active_page_item hide-field" id ="active_page_tc" name="active_page_tc" <?= in_array("tc",explode(",",$restDetails->active_pages)) ? "checked" : "" ?>>
                                        </label>
                                    </div>
                                    <div  class="active_page_option col-md-6 py-1 px-3 px-lg-5">
                                        <label class="border d-flex justify-content-between align-items-center w-100 p-3 rounded mb-0 <?= in_array("contact",explode(",",$restDetails->active_pages)) ? "active" : "" ?>">    
                                            <span>Contact</span> 
                                            <i class="fa fa-check active-signal"></i>
                                            <i class="fa fa-times bg-danger deactive-signal"></i>
                                            <input type="checkbox" class="active_page_item hide-field" id ="active_page_contact" name="active_page_contact" <?= in_array("contact",explode(",",$restDetails->active_pages)) ? "checked" : "" ?>>
                                        </label>
                                    </div>
                                </div>
                            </section>
                            <!-- <input type="submit" value="Update Setting" class="btn btn-primary btn-user btn-block mt-4"> -->
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

