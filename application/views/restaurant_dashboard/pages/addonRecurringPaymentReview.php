        <!-- Begin Page Content -->
        <div class="container-fluid">

            <!-- Page Heading -->
            <h1 class="h3 mb-4 text-gray-800"><?=strtoupper($addon->addon_lifecycle)?> Payment Review</h1>
            <div class="row">
                <div class="col-md-12 ">
                    <div class="content_wrap tab-content">
                        <form action="<?=base_url()?>" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="rest_id" value = "<?= $myRestId?>">
                            <input type="hidden" name="addon_id" value = "<?= $addon->addon_id?>">
                            <section>
                                <div class="card shadow mb-4">
                                    <div class="card-header py-3 d-flex justify-content-between title-bar">
                                        <?php
                                        ?> 
                                        <div>Payment Account Info</div>
                                        <div>( By <b><?=date("F jS Y", strtotime('+'.$addon->addon_trial_period.' days')) ?></b> It would be <b>free</b>.)</div>
                                    </div>
                                    <div class="card-body">
                                        <?php
                                            $ack = strtoupper($resArray["ACK"]);
                                            if( 1 || $ack == "SUCCESS" || $ack == "SUCESSWITHWARNING") {
                                                /*
                                                $email 			= isset($resArray["EMAIL"]) ? $resArray["EMAIL"] : ""; // ' Email address of payer.
                                                $payerId 			= isset($resArray["PAYERID"]) ? $resArray["PAYERID"] : ""; // ' Unique PayPal customer account identification number.
                                                $payerStatus		= isset($resArray["PAYERSTATUS"]) ? $resArray["PAYERSTATUS"] : ""; // ' Status of payer. Character length and limitations: 10 single-byte alphabetic characters.
                                                $salutation			= isset($resArray["SALUTATION"]) ? $resArray["SALUTATION"] : ""; // ' Payer's salutation.
                                                $firstName			= isset($resArray["FIRSTNAME"]) ? $resArray["FIRSTNAME"] : ""; // ' Payer's first name.
                                                $middleName			= isset($resArray["MIDDLENAME"]) ? $resArray["MIDDLENAME"] : ""; // ' Payer's middle name.
                                                $lastName			= isset($resArray["LASTNAME"]) ? $resArray["LASTNAME"] : ""; // ' Payer's last name.
                                                $suffix				= isset($resArray["SUFFIX"]) ? $resArray["SUFFIX"] : ""; // ' Payer's suffix.
                                                $cntryCode			= isset($resArray["COUNTRYCODE"]) ? $resArray["COUNTRYCODE"] : ""; // ' Payer's country of residence in the form of ISO standard 3166 two-character country codes.
                                                $business			= isset($resArray["BUSINESS"]) ? $resArray["BUSINESS"] : ""; // ' Payer's business name.
                                                $shipToName			= isset($resArray["SHIPTONAME"]) ? $resArray["SHIPTONAME"] : ""; // ' Person's name associated with this address.
                                                $shipToStreet		= isset($resArray["SHIPTOSTREET"]) ? $resArray["SHIPTOSTREET"] : ""; // ' First street address.
                                                $shipToStreet2		= isset($resArray["SHIPTOSTREET2"]) ? $resArray["SHIPTOSTREET2"] : ""; // ' Second street address.
                                                $shipToCity			= isset($resArray["SHIPTOCITY"]) ? $resArray["SHIPTOCITY"] : ""; // ' Name of city.
                                                $shipToState		= isset($resArray["SHIPTOSTATE"]) ? $resArray["SHIPTOSTATE"] : ""; // ' State or province
                                                $shipToCntryCode	= isset($resArray["SHIPTOCOUNTRYCODE"]) ? $resArray["SHIPTOCOUNTRYCODE"] : ""; // ' Country code. 
                                                $shipToZip			= isset($resArray["SHIPTOZIP"]) ? $resArray["SHIPTOZIP"] : ""; // ' U.S. Zip code or other country-specific postal code.
                                                $addressStatus 		= isset($resArray["ADDRESSSTATUS"]) ? $resArray["ADDRESSSTATUS"] : ""; // ' Status of street address on file with PayPal   
                                                $invoiceNumber		= isset($resArray["INVNUM"]) ? $resArray["INVNUM"] : ""; // ' Your own invoice or tracking number, as set by you in the element of the same name in SetExpressCheckout request .
                                                $phonNumber			= isset($resArray["PHONENUM"]) ? $resArray["PHONENUM"] : ""; // ' Payer's contact telephone number. Note:  PayPal returns a contact telephone number only if your Merchant account profile settings require that the buyer enter one.
                                                */
                                                ?>
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
                                                
                                                        <!-- <div class="mb-1 row">
                                                            <span class="col-md-4 col-10 font-weight-bold">Amount  </span>
                                                            <span class="col-md-1 col-2">:</span>  
                                                            <span class="col-md-7"><?= $currentRestCurrencySymbol?> 5 per Month</span>
                                                        </div>
                                                        <div class="mb-1 row">
                                                            <span class="col-md-4 col-10 font-weight-bold">Plan Start Date  </span>
                                                            <span class="col-md-1 col-2">:</span>
                                                            <span class="col-md-7"><?= date('F jS Y',strtotime($plan_start_date)) ?></span>
                                                        </div> -->
                                                        <!-- <div class="mb-1 row">
                                                            <span class="col-md-4 col-10 font-weight-bold">Email </span>
                                                            <span class="col-md-1 col-2">:</span>  
                                                            <span class="col-md-7"><?= $email ?> </span>
                                                        </div>
                                                        <div class="mb-1 row">
                                                            <span class="col-md-4 col-10 font-weight-bold">PayerID </span>
                                                            <span class="col-md-1 col-2">:</span>  
                                                            <span class="col-md-7 text-uppercase"><?= $payerId ?> </span>
                                                        </div>
                                                        <div class="mb-1 row">
                                                            <span class="col-md-4 col-10 font-weight-bold">PayerStatus </span>
                                                            <span class="col-md-1 col-2">:</span>  
                                                            <span class="col-md-7 text-uppercase"><?= $payerStatus ?></span>
                                                        </div>
                                                        <div class="mb-1 row">
                                                            <span class="col-md-4 col-10 font-weight-bold">Salutation </span>
                                                            <span class="col-md-1 col-2">:</span>  
                                                            <span class="col-md-7 text-uppercase"><?= $salutation ?></span>
                                                        </div>
                                                        <div class="mb-1 row">
                                                            <span class="col-md-4 col-10 font-weight-bold">Name </span>
                                                            <span class="col-md-1 col-2">:</span>  
                                                            <span class="col-md-7 text-uppercase"><?= $firstName?> <?= $middleName?> <?= $lastName?></span>
                                                        </div>
                                                        <div class="mb-1 row">
                                                            <span class="col-md-4 col-10 font-weight-bold">Business Name </span>
                                                            <span class="col-md-1 col-2">:</span>  
                                                            <span class="col-md-7 text-uppercase"><?= $business ?></span>
                                                        </div>
                                                        <div class="mb-1 row">
                                                            <span class="col-md-4 col-10 font-weight-bold">InvoiceNumber </span>
                                                            <span class="col-md-1 col-2">:</span>  
                                                            <span class="col-md-7 text-uppercase"><?= $invoiceNumber ?></span>
                                                        </div>
                                                        <div class="mb-1 row">
                                                            <span class="col-md-4 col-10 font-weight-bold">PhonNumber </span>
                                                            <span class="col-md-1 col-2">:</span>  
                                                            <span class="col-md-7 text-uppercase"><?= $phonNumber ?></span>
                                                        </div> -->
                                                    </div>
                                                    <div class="col-md-6 addon_info">
                                                        <section class="plan-package">
                                                            <?php
                                                                $addon_title = json_decode($addon->addon_title);
                                                                $title_name_field = "value_" . $_lang;
                                                                $title = $addon_title->$title_name_field == "" ? $addon_title->value: $addon_title->$title_name_field;
                                                                
                                                                $addon_content_html = json_decode($addon->addon_content_html);
                                                                $content_html_field = "value_" . $_lang;
                                                                $content_html = $addon_content_html->$content_html_field == "" ? $addon_content_html->value: $addon_content_html->$content_html_field;
                                                                $addon_price_currency = $this->db->where("id",$addon->addon_price_currency_id)->get('tbl_countries')->row()->currency_symbol;
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
                                                                            <div class="comment ml-1">/ <?= $addon->addon_lifecycle == "lifetime" ? "one time" : $addon->addon_lifecycle ?></div>
                                                                        </div>
                                                                    </div>
                                                                    <?php if ($addon->addon_trial_period > 0) { ?>
                                                                        <em class="free-time">first <span class="free-time-day"><?=$addon->addon_trial_period?></span> days for free</em>
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
                                                <span class="btn btn-primary confirm-addon_subscription-btn mt-3">Confirm</span>
                                                <a href = "<?= base_url("Restaurant/Addon")?>" class="btn btn-warning mt-3">Return</a>
                                                <?php
                                            } else {
                                                //Display a user friendly Error on the page using any of the following error information returned by PayPal
                                                $ErrorCode = urldecode($resArray["L_ERRORCODE0"]);
                                                $ErrorShortMsg = urldecode($resArray["L_SHORTMESSAGE0"]);
                                                $ErrorLongMsg = urldecode($resArray["L_LONGMESSAGE0"]);
                                                $ErrorSeverityCode = urldecode($resArray["L_SEVERITYCODE0"]);
                                                
                                                $error_msg .= "GetExpressCheckoutDetails API call failed. ";
                                                $error_msg .= "Detailed Error Message: " . $ErrorLongMsg;
                                                $error_msg .= "Short Error Message: " . $ErrorShortMsg;
                                                $error_msg .= "Error Code: " . $ErrorCode;
                                                $error_msg .= "Error Severity Code: " . $ErrorSeverityCode; ?>
                                                
                                                <div class="text-danger"><?=  $error_msg ?></div>
                                                
                                                <?php 
                                            }
                                        ?>
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
