        <!-- Begin Page Content -->
        <div class="container-fluid">

            <!-- Page Heading -->
            <h1 class="h3 mb-4 text-gray-800"><?=strtoupper($addon_invoice->addon_lifecycle)?> Payment Review</h1>
            <div class="row">
                <div class="col-md-12 ">
                    <div class="content_wrap tab-content">
                        <form action="<?=base_url()?>" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="rest_id" value = "<?= $myRestId?>">
                            <input type="hidden" name="addon_id" value = "<?= $addon_invoice->addon_id?>">
                            <section>
                                <div class="card shadow mb-4">
                                    <div class="card-header py-3 d-flex justify-content-between title-bar">
                                        <?php
                                        ?> 
                                        <div>Payment Account Info</div>
                                        <div>( By <b><?=date("F jS Y", strtotime('+'.$addon_invoice->addon_trial_period.' days')) ?></b> It would be <b>free</b>.)</div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6 payer_info">
                                                <div class="mb-1 row">
                                                    <span class="col-md-4 col-10 font-weight-bold">Name </span>
                                                    <span class="col-md-1 col-2">:</span>  
                                                    <span class="col-md-7 text-uppercase"><?= $addon_invoice->first_name . ' ' .$addon_invoice->last_name ?> </span>
                                                </div>
                                                <div class="mb-1 row">
                                                    <span class="col-md-4 col-10 font-weight-bold">Restaurant Email </span>
                                                    <span class="col-md-1 col-2">:</span>  
                                                    <span class="col-md-7 text-uppercase"><?= $restDetails->rest_email ?> </span>
                                                </div>
                                                <div class="mb-1 row">
                                                    <span class="col-md-4 col-10 font-weight-bold">Restaurant Name </span>
                                                    <span class="col-md-1 col-2">:</span>  
                                                    <span class="col-md-7 text-uppercase"><?= $restDetails->rest_name ?> </span>
                                                </div>
                                                <div class="mb-1 row">
                                                    <span class="col-md-4 col-10 font-weight-bold">Restaurant Contact Number </span>
                                                    <span class="col-md-1 col-2">:</span>  
                                                    <span class="col-md-7 text-uppercase"><?= $restDetails->rest_contact_no?> </span>
                                                </div>
                                                <div class="mb-1 row">
                                                    <span class="col-md-4 col-10 font-weight-bold">Invoice Date </span>
                                                    <span class="col-md-1 col-2">:</span>  
                                                    <span class="col-md-7 text-uppercase"><?= $addon_invoice->invoice_date ?> </span>
                                                </div>
                                                <div class="mb-1 row">
                                                    <span class="col-md-4 col-10 font-weight-bold">Due Date </span>
                                                    <span class="col-md-1 col-2">:</span>  
                                                    <span class="col-md-7 text-uppercase"><?= $addon_invoice->due_date ?> </span>
                                                </div>
                                                <div class="mb-1 row">
                                                    <span class="col-md-4 col-10 font-weight-bold">Business type </span>
                                                    <span class="col-md-1 col-2">:</span>  
                                                    <span class="col-md-7 text-uppercase"><?= $addon_invoice->business_type ?> </span>
                                                </div>
                                                <div class="mb-1 row">
                                                    <span class="col-md-4 col-10 font-weight-bold">Payment Method </span>
                                                    <span class="col-md-1 col-2">:</span>  
                                                    <span class="col-md-7 text-uppercase"><?= $addon_invoice->payment_method ?> </span>
                                                </div>
                                                <div class="mb-1 row">
                                                    <span class="col-md-4 col-10 font-weight-bold">Cost </span>
                                                    <span class="col-md-1 col-2">:</span>  
                                                    <span class="col-md-7 text-uppercase"><?= $addon_invoice->total ?> </span>
                                                </div>
                                            </div>
                                            <div class="col-md-6 addon_info">
                                                <section class="plan-package">
                                                    <?php
                                                        $addon_title = json_decode($addon_invoice->addon_title);
                                                        $title_name_field = "value_" . $_lang;
                                                        $title = $addon_title->$title_name_field == "" ? $addon_title->value: $addon_title->$title_name_field;
                                                        
                                                        $addon_content_html = json_decode($addon_invoice->addon_content_html);
                                                        $content_html_field = "value_" . $_lang;
                                                        $content_html = $addon_content_html->$content_html_field == "" ? $addon_content_html->value: $addon_content_html->$content_html_field;
                                                        $addon_price_currency = $this->db->where("id",$addon_invoice->addon_price_currency_id)->get('tbl_countries')->row()->currency_symbol;
                                                        $current_addon_ids_arr = explode(",",$currentRestDetail->addon_ids);
                                                    ?>
                                                    <div class="item">
                                                        <!-- item head -->
                                                        <div class="item-head px-4">
                                                            <!-- name -->
                                                            <h5 class="name p-0"><?= $title?></h5>
                                                            <!-- price -->
                                                            <div class="price">
                                                                <div class="d-flex align-items-center justify-content-start flex-wrap">
                                                                    <!-- count -->
                                                                    <div class="count"><?= str_replace(".",",",number_format($addon_invoice->total,2)) ?></div>
                                                                    <!-- currency -->
                                                                    <div class="currency mx-1"> <?= $addon_price_currency?></div>
                                                                    <!-- commnet -->
                                                                    <div class="comment ml-1">/ <?= $addon_invoice->addon_lifecycle == "lifetime" ? "one time" : $addon_invoice->addon_lifecycle ?></div>
                                                                </div>
                                                            </div>
                                                            <?php if ($addon_invoice->addon_trial_period > 0) { ?>
                                                                <em class="free-time">first <span class="free-time-day"><?=$addon_invoice->addon_trial_period?></span> days for free</em>
                                                            <?php } ?>
                                                        </div>
                                                        <!-- item body -->
                                                        <div class="item-body px-md-3 px-2">
                                                            <?= $content_html ?>
                                                        </div>
                                                    </div>
                                                </section>
                                            </div>
                                        </div>
                                        <!-- <span class="btn btn-primary confirm-addon_subscription-btn mt-3">Confirm</span> -->
                                        <a href = "<?= base_url("Restaurant/Addon")?>" class="btn btn-warning mt-3">Return</a>
                                    </div>
                                </div>
                            </section>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
        </div>
        <!-- End of Main Content -->
