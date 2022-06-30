<div class="container">

    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
        
                <div class="col-lg-12">
                    <div class="p-md-5 p-3">
                        <h1 class="h4 text-gray-900 mb-4"><?= $this->lang->line('Which payment you want to accept')?>?</h1>
                        <hr>
                        <form  id="paymentSetting">
                            <div class="form-group row">
                                <input type="hidden" class="form-control form-control-user"   name="rest_id" value="<?=$myRestId?>">
                                <div class="col-sm-3 mb-3 mb-sm-0">
                                    <input type="checkbox" class=""  name="payment_method_stripe" id = "payment_method_stripe" <?= isset($paymentSetting) ? (strpos($paymentSetting->payment_method,'s')>-1 ? "checked" : "" ) : "" ?>>
                                    <label for="payment_method_stripe">Creditcards (Stripe)</label>
                                </div>
                                <div class="col-sm-3 mb-3 mb-sm-0">
                                    <input type="checkbox" class=""  name="payment_method_paypal" id = "payment_method_paypal" <?= isset($paymentSetting) ? (strpos($paymentSetting->payment_method,'p')>-1  ? "checked" : "" ) : "" ?>>
                                    <label for="payment_method_paypal">Paypal</label>
                                </div>
                                <div class="col-sm-3 mb-3 mb-sm-0">
                                    <input type="checkbox" class=""  name="payment_method_cash" id = "payment_method_cash" <?= isset($paymentSetting) ? (strpos($paymentSetting->payment_method,'c')>-1  ? "checked" : "" ) : "" ?>>
                                    <label for="payment_method_cash">Cash</label>
                                </div>
                                <div class="col-sm-3 mb-3 mb-sm-0">
                                    <input type="checkbox" class=""  name="payment_method_creditcard_door" id = "payment_method_creditcard_door" <?= isset($paymentSetting) ? (strpos($paymentSetting->payment_method,'d')>-1  ? "checked" : "" ) : "" ?>>
                                    <label for="payment_method_creditcard_door">CreditCard On the Door</label>
                                </div>
                                <div class="col-12 mt-3">
                                    <div><?= $this->lang->line('It is needed that you have your own: Paypal and/or Stripe Account, if you want to accept Creditcards and/or Paypal')?></div>
                                    <div><?= $this->lang->line('If you need help, please contact us: info@restopage.eu')?></div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-12 mb-3 mb-sm-0">
                                    <h3 class="h4 text-gray-800 my-4">Stripe</h3>
                                    <div class="row">
                                        <label class="col-sm-6"><?= $this->lang->line('Live Publishable Key')?></label>
                                        <input type="text" name="stripe_public_key" class="col-sm-6 form-control form-control-user" placeholder="<?= $this->lang->line('Live Publishable Key')?>" value="<?=isset($paymentSetting) ? $paymentSetting->stripe_public_key : "" ?>" >
                                    </div>
                                    <div class="row mt-3">
                                        <label class="col-sm-6"><?= $this->lang->line('Live Secret Key')?></label>
                                        <input type="password"  name="stripe_secret_key" class="col-sm-6 form-control form-control-user" placeholder="<?= $this->lang->line('Live Secret Key')?>" value="<?=isset($paymentSetting) ? $paymentSetting->stripe_secret_key : "" ?>" >
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="form-group row">
                                <div class="col-sm-12 mb-3 mb-sm-0">
                                    <h3 class="h4 text-gray-800 my-4">Paypal</h3>
                                    <div class="row">
                                        <label class="col-sm-6"><?= $this->lang->line('Live API username')?></label>
                                        <input type="text" name="paypal_username" class="col-sm-6 form-control form-control-user" placeholder="<?= $this->lang->line('Live API username')?>" value="<?=isset($paymentSetting) ? $paymentSetting->paypal_api_username : "" ?>" >
                                    </div>
                                    <div class="row mt-3">
                                        <label class="col-sm-6"><?= $this->lang->line('Live API password')?></label>
                                        <input type="password"  name="paypal_password" class="col-sm-6 form-control form-control-user" placeholder="<?= $this->lang->line('Live API password')?>" value="<?=isset($paymentSetting) ? $paymentSetting->paypal_api_password : "" ?>" >
                                    </div>
                                    <div class="row mt-3">
                                        <label class="col-sm-6"><?= $this->lang->line('Live API singature')?></label>
                                        <input type="password"  name="paypal_signature" class="col-sm-6 form-control form-control-user" placeholder="<?= $this->lang->line('Live API singature')?>" value="<?=isset($paymentSetting) ? $paymentSetting->paypal_api_signature : "" ?>" >
                                    </div>
                                </div>
                            </div>
                            <hr>   
                            <input type="submit"  value="<?= $this->lang->line('Update Data')?>" class="btn btn-primary btn-user btn-block">
                
                        
                        </form>
                    
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

