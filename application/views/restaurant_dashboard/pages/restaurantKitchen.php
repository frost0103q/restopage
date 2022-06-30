
<div class="container">
    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="py-5 px-md-5 px-3">
                        <?php
                            $res_kitchens = explode(",",$restDetails->kitchen_ids); 
                            $is_disabled = sizeof($res_kitchens) > 4 ? "disabled" : "";
                        ?> 
                        <form class="user" id="restaurantKitchen" data-rest_id = "<?=$restDetails->rest_id?>">
                            <section class="kitchen-page">
                                <div class="d-flex justify-content-between">
                                    <h1 class="h4 text-gray-900"><?= $this->lang->line('Choose your Kitchens')?></h1>
                                    <div><b class="kitchen_remaining_count text-primary mr-2"><?= 5-sizeof($res_kitchens)?></b> <?= $this->lang->line("Kitchens Remaining")?></div>
                                </div>
                                <hr>
                                <div class=" row">
                                    <?php foreach ($kitchens as $key => $kvalue) { 
                                        $kitchen_name_field = "kitchen_name_". $_lang;
                                        if ($kvalue-> $kitchen_name_field  == ""){
                                            $kitchen_name_field = "kitchen_name";
                                        }
                                        ?>
                                        <div class="col-sm-4 mt-3">
                                            <label class="d-flex align-items-center">
                                                <input type="checkbox" class="mr-2 restaurant_kitchen" name="restaurant_kitchen" value = "<?= $kvalue->kitchen_id ?>" <?= in_array($kvalue->kitchen_id,$res_kitchens) ? "checked": $is_disabled ?>>
                                                <span><?=  $kvalue->$kitchen_name_field?> </span>
                                            </label>
                                        </div>
                                    <?php } ?>
                                </div>
                                <input type="submit" class="btn btn-primary form-control mt-5" value="<?= $this->lang->line("Update") ?>">
                            </section>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

