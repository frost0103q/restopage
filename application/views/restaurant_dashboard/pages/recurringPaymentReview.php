        <!-- Begin Page Content -->
        <div class="container-fluid">

            <!-- Page Heading -->
            <h1 class="h3 mb-2 text-gray-800">Monthly Payment Review</h1>
            <div class="row">
                <div class="col-md-12 ">
                    <div class="content_wrap tab-content">
                        <form action="<?=base_url()?>" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="rest_id" value = "<?= $myRestId?>">
                            <section>
                                <div class="card shadow mb-4">
                                    <div class="card-header py-3 d-flex justify-content-between title-bar">
                                        <?php
                                            $plan_start_date = $this->db->where("restaurant_id = $myRestId")->get('tbl_restaurant_details')->row()->pro_plan_start_date;
                                        ?> 
                                        <div>Payment Account Info</div>
                                        <div>( By <b><?=date("F jS Y", strtotime(date("Y-m-d", strtotime($plan_start_date)) . " + 1 year")) ?></b> It would be <b>free</b>.)</div>
                                    </div>
                                    <div class="card-body">
                                        <?php
                                            $ack = strtoupper($resArray["ACK"]);
                                            if( $ack == "SUCCESS" || $ack == "SUCESSWITHWARNING") {
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
                                                $phonNumber			= isset($resArray["PHONENUM"]) ? $resArray["PHONENUM"] : ""; // ' Payer's contact telephone number. Note:  PayPal returns a contact telephone number only if your Merchant account profile settings require that the buyer enter one. ?>
                                                <div class="    ">
                                                    <div class="mb-1 row">
                                                        <span class="col-md-4 col-10 font-weight-bold">Amount  </span>
                                                        <span class="col-md-1 col-2">:</span>  
                                                        <span class="col-md-7"><?= $currentRestCurrencySymbol?> 5 per Month</span>
                                                    </div>
                                                    <div class="mb-1 row">
                                                        <span class="col-md-4 col-10 font-weight-bold">Plan Start Date  </span>
                                                        <span class="col-md-1 col-2">:</span>
                                                        <span class="col-md-7"><?= date('F jS Y',strtotime($plan_start_date)) ?></span>
                                                    </div>
                                                    <div class="mb-1 row">
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
                                                    </div>
                                                </div>
                                                <span class="btn btn-primary confirm-plan-btn mt-3">Confirm</span>
                                                <span class="btn btn-warning cancel-plan-btn mt-3">Cancel</span>
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
