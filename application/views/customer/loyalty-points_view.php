<div class="content-page">
    <div class="content">

        <div class="container-fluid">
            <div class="card-box">
                <div class="">
                    <h4 class="header-title mt-0 mb-4 text-warning"><?= $this->lang->line("Loyalty Points") ?></h4>
                    <div class="item-list">
                        <?php
                            foreach ($points as $pkey => $pvalue) { ?>
                                <div class='rest-item row my-2' data-rest-id = "<?= $pvalue->rest_id?>">
                                    <div class="rest-brand col-md-2 col-3 d-flex justify-content-center align-items-center">
                                        <img src="<?= base_url('assets/rest_logo/').$pvalue->rest_logo?>" alt="" height="35">
                                    </div>
                                    <div class="rest-info col-md-7 col-9">
                                        <h3 class="rest-name"><?= $pvalue->rest_name?></h3>
                                        <p class="rest-address"><span><?= $pvalue->address1?></span>| <span><?= $pvalue->address2?></span></p>
                                    </div>
                                    <div class="view-menu col-md-3 d-flex justify-content-center align-items-center">
                                        <b class="mr-2"><?= $pvalue->loyalty_points?></b> <?= $this->lang->line("Points")?>
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

