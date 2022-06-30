
<div class="container">
    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">\
                <div class="col-lg-12">
                    <div class="py-5 px-md-5 px-3">
                        <form id="addon_payout" data-rest_id = "<?=$restDetails->rest_id?>">
                            <input type="hidden" name="addon_id" value="<?=$addon_id?>">
                            <input type="hidden" name="rest_id" value="<?=$restDetails->rest_id?>">
                            <section class="addon-payout j-checkout">
                                <div class="">
                                    <h1 class="h4 text-gray-900 mb-4"><?= $this->lang->line('Restaurant')?> <?= $this->lang->line('Addons')?></h1>
                                    <hr>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-wrap px-1 py-4 p-md-4 m-md-0">
                                            <div class="form-group">
                                                <label class="text-capitalize font-weight-bold"><?= $this->lang->line("business type")?></label>
                                                <select class="form-control form-control-user business_type" name="business_type">
                                                    <option value="company">Purchase as business / company</option>    
                                                    <option value="freelancer">Purchase as authorized person / freelancer</option>    
                                                </select>
                                            </div>
    
                                            <div class="form-group">
                                                <label class="font-weight-bold"><?= $this->lang->line("Billing")?> <?= $this->lang->line("Address")?> (<?= $this->lang->line("appears on invoice")?>) : </label>
                                                <div class="input-group only_for_company">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">
                                                            <i class="fa fa-building"></i>
                                                        </div>
                                                    </div>
                                                    <input type="text" class="form-control form-control-user" placeholder="<?= $this->lang->line("Company Name")?> (<?=$this->lang->line("Company Name")?>) *" name="company_name" required>
                                                </div>
    
                                                <div class="input-group mt-2">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">
                                                            <i class="fa fa-user"></i>
                                                        </div>
                                                    </div>
                                                    <input type="text" class="form-control form-control-user" placeholder="<?=$this->lang->line("First Name")?> *" name="first_name" required>
                                                    <input type="text" class="form-control form-control-user" placeholder="<?=$this->lang->line("Last Name")?> *" name="last_name" required>
                                                </div>
    
                                                <div class="input-group mt-2">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">
                                                            <i class="fa fa-map-marker"></i>
                                                        </div>
                                                    </div>
                                                    <input type="text" class="form-control form-control-user" placeholder="<?= $this->lang->line("Address")?> *" name="address" required>
                                                </div>
                                               
                                                <div class="input-group mt-2">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">
                                                            <i class="fa fa-city"></i>
                                                        </div>
                                                    </div>
                                                    <input type="text" class="form-control form-control-user" placeholder="<?= $this->lang->line("City")?> *" name="city" required>
                                                    <input type="text" class="form-control form-control-user" placeholder="<?=$this->lang->line("Post Code")?> *" name="postcode" required>
                                                </div>
                                               
                                                <div class="input-group mt-2">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">
                                                            <i class="fa fa-globe-europe"></i>
                                                        </div>
                                                    </div>
                                                    <?php 
                                                        $countries = $this->db->get("tbl_countries")->result();
                                                    ?>
                                                    <select class="form-control form-control-user" name="country" required id="company_location_country">
                                                        <?php  foreach ($countries as $key => $country) { ?>
                                                            <option value="<?= $country->abv?>" <?= $country->abv=="LU" ? "selected": "" ?>><?= $country->name?></option>    
                                                        <?php  } ?>
                                                    </select>
                                                </div>
                                                
                                            </div>
    
                                            <div class="form-group only_for_company">
                                                <label class="text-capitalize font-weight-bold"><?= $this->lang->line("VAT identification number")?></label><span class="text-success margin-left is_valid_vat hide-field"> ( valid )</span></label><span class="text-danger margin-left is_invalid_vat hide-field"> ( invalid )</span>
                                                <div class="input-group company_vat_field">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">
                                                            <i class="fa fa-file-invoice"></i>
                                                        </div>
                                                    </div>
                                                    <input type="text" class="form-control form-control-user" placeholder="VAT - ID" name="vat_number" value="LU" id="company_vat_number">
                                                    <div class="input-group-append vat-tooltip">
                                                        <div class="input-group-text">
                                                            <i class="fa fa-info-circle"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="vat-tooltip-content small hide-field">
                                                    <p>What is a VAT ID number?</p>
                                                    The VAT ID only applies to business customers within the European Union, if you don‘t have a VAT ID, or if you are a private individual, you may leave this field blank. Please only enter capital letters and digits, do not include any blanks or other characters. 
                                                    <p class="m-0 text-warning">Example: LU123456789</p>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="form-footer">
                                                <?= $this->lang->line("By continuing you agree with")?> <a href="#">Restopage Terms and Conditions</a>.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-wrap px-1 py-4 p-md-4 m-md-0">
                                            <label class="text-capitalize font-weight-bold"><?= $this->lang->line("Payment")?></label>
                                            <div class="d-block d-md-none">
                                                <select class="form-control form-control-user" name="payment_method" id="payment_method" required>
                                                    <option value="visa" data-payment = "visa">Visa</option>
                                                    <option value="mastercard" data-payment = "mastercard">Mastercard</option>
                                                    <option value="american-express" data-payment = "american-express">American Express</option>
                                                    <option value="paypal" data-payment = "paypal" selected>Paypal</option>
                                                </select>
                                            </div>
                                            <div class="d-md-block d-none bg-white p-1">
                                                <div class="j-payment-method-list">
                                                   <div class="j-payment-method payment-visa" data-payment = "visa">Visa</div>
                                                   <div class="j-payment-method payment-mastercard" data-payment = "mastercard">Mastercard</div>
                                                   <div class="j-payment-method payment-american-express" data-payment = "american-express">American Express</div>
                                                   <div class="j-payment-method payment-paypal j-selected" data-payment = "paypal">Paypal</div>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="submit" class="w-100 btn btn-primary bg-blue text-capitalize mt-3 p-3" value="<?= $this->lang->line("Order")?>">
                                    </div>                                   
                                </div>
                            </section>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="addonStripePaymentModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-body">
                <div class="py-3">
                    <h4 class="m-0 font-weight-bold text-center">My Restopage</h4>
                    <h6 class="mt-2 text-center">Recurring Stripe Payment</h6>
                </div>
                <form id="addonStripePaymentForm">
                    <input type="hidden" name="addon_invoice_id" id="addon_invoice_id">
                    <input type="hidden" name="stripePaymentForm" id="stripePaymentForm" value="1">
                    <div class="form-group row">
                        <div class="col-12 mb-4">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                                </div>
                                <input type="email" class="form-control" name="stripe_email" placeholder="Email">
                            </div>
                        </div>        

                        <div class="col-12 mb-1">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-credit-card"></i></span>
                                </div>
                                <input type="text" class="form-control" name="stripe_card" id="stripe_card" placeholder="Card Number" maxlength="19" size="19">
                            </div>
                        </div>        
                        <div class="col-6 mb-1">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-calendar-alt"></i></span>
                                </div>
                                <input type="text" class="form-control" name="stripe_expiry" id="stripe_expiry" placeholder="MM/YY" maxlength="5" size="5" />
                            </div>
                        </div>        
                        <div class="col-6 mb-1">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-lock"></i></span>
                                </div>
                                <input type="text" class="form-control" name="stripe_cvc" placeholder="CVC" maxlength="3" size="3" id="stripe_cvc" />
                            </div>
                        </div> 
                        <div class="col-12 mt-3">
                            <input type="submit" class="form-control text-white font-weight-bolder" id="stripe_submit_btn" value="Pay 15">
                        </div>         
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?=$this->lang->line('Close')?></button>
            </div>
        </div>
    </div>
</div>

