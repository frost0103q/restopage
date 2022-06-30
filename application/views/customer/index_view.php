<div class="content-page">
    <div class="content">

        <div class="container-fluid">
            <div class="card-box">
                <div class="">
                    <h4 class="header-title mt-0 mb-4 text-warning">Suggested Restaurants</h4>
                    <div class="item-list">
                        <?php
                            foreach ($rests as $rkey => $rvalue) { ?>
                                <div class='rest-item row my-2' data-rest-id = "<?= $rvalue->rest_id?>">
                                    <div class="rest-brand col-md-2 col-3 d-flex justify-content-center align-items-center">
                                        <img src="<?= base_url('assets/rest_logo/').$rvalue->rest_logo?>" alt="" height="35">
                                    </div>
                                    <div class="rest-info col-md-7 col-9">
                                        <h3 class="rest-name"><?= $rvalue->rest_name?></h3>
                                        <p class="rest-address"><span><?= $rvalue->address1?></span>| <span><?= $rvalue->address2?></span></p>
                                    </div>
                                    <div class="view-menu col-md-3 d-flex justify-content-center align-items-center">
                                        <a class="btn btn-lighten-primary waves-effect waves-primary  width-md" href="<?= base_url("view/").$rvalue->rest_url_slug?>">View Menu</a>
                                    </div>
                                </div>
                                    
                            <?php }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

