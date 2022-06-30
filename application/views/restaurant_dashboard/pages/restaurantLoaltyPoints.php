<div class="container">
    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
            <div class="row">
                <div class="col-lg-12">
                    <div class="p-md-5 p-3">
                        <h1 class="h3 text-gray-900 mb-4"><?= $this->lang->line('Loyalty Points')?></h1>
                        <hr>
                        <form  id="loyaltyPointsForm">
                            <input type="hidden" class="form-control form-control-user" name="rest_id" value="<?=$myRestId?>">
                            <label class="text-gray-900"><?= $this->lang->line('Do you want to use loyalty points')?> ?</label>
                            <div class="form-group row">
                                <div class="col-6 col-md-4">
                                    <input type="radio" class="point_status"  name="point_status" id = "enable_status" <?= isset($loaltyPoints) && $loaltyPoints->status == "enable" ? "checked" : "" ?> value="enable">
                                    <label for="enable_status">Yes</label>
                                </div>
                                <div class="col-6 col-md-4">
                                    <input type="radio" class="point_status"  name="point_status" id = "disable_status" <?= isset($loaltyPoints) && $loaltyPoints->status == "enable" ? "" : "checked" ?> value="disable">
                                    <label for="disable_status">No</label>
                                </div>
                            </div>
                            <h3 class="text-gray-800 mb-0 j-bg-lighter-gray h4 pt-2 px-3 pb-1 d-inline-block"><?= $this->lang->line('Setting')?></h3>
                            <section class="point_setting_section j-bg-very-lighter-gray p-3 <?= isset($loaltyPoints) && $loaltyPoints->status == "enable" ? "" : "hide-field" ?>">
                                <div class="col-md-8">
                                    <div class="row mt-3">
                                        <label class="col-sm-6 col-md-4"><?= $this->lang->line('Earn')?> <?= $this->lang->line('Points')?> <?= $this->lang->line('Conversion Rate')?></label>
                                        <div class="col-sm-6 col-md-8">
                                            <div class="row">
                                                <div class="input-group col-md-7">
                                                    <input type="number" class="form-control form-control-user" id="earn_points_conversion_rate_points" placeholder="10" name="earn_points_conversion_rate_points" value="<?= isset($loaltyPoints) ? $loaltyPoints->earn_conversion_rate : "" ?>" <?= isset($loaltyPoints) && $loaltyPoints->status == "enable" ? "require" : "" ?> step= "0.01" min="0">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><?= $this->lang->line('Points')?></span>
                                                    </div>
                                                </div>
                                                <span class="col-md-1 text-center my-auto">=</span>
                                                <div class="input-group col-md-4">
                                                    <input type="nubmer" class="form-control form-control-user" id="earn_points_conversion_rate_money" placeholder="10" name="earn_points_conversion_rate_money" value="1" readonly>
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><?= $currentRestCurrencySymbol?></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <label class="col-sm-6 col-md-4"><?= $this->lang->line('Earn')?> <?= $this->lang->line('Points')?> <?= $this->lang->line('Rounding Mode')?></label>
                                        <div class="col-sm-6 col-md-8">
                                            <div class="row">
                                                <div class="input-group col-sm-12">
                                                    <select class="form-control form-control-user" id="earn_rounding_mode" name="earn_rounding_mode">
                                                        <option value="on" <?= isset($loaltyPoints) && $loaltyPoints->earn_rounding_mode == "on" ? "" : "selected" ?>><?= $this->lang->line('always round off')?></option>
                                                        <option value="off" <?= isset($loaltyPoints) && $loaltyPoints->earn_rounding_mode == "on" ? "selected" : "" ?>><?= $this->lang->line('always round on')?></option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <label class="col-sm-6 col-md-4"><?= $this->lang->line('Redemption')?> <?= $this->lang->line('Conversion Rate')?></label>
                                        <div class="col-sm-6 col-md-8">
                                            <div class="row">
                                                <div class="input-group col-md-7">
                                                    <input type="number" class="form-control form-control-user" id="redemption_conversion_rate_points" placeholder="10" name="redemption_conversion_rate_points" value="<?= isset($loaltyPoints) ? $loaltyPoints->redemption_conversion_rate : "" ?>" <?= isset($loaltyPoints) && $loaltyPoints->status == "enable" ? "require" : "" ?> step= "0.01" min="0">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><?= $this->lang->line('Points')?></span>
                                                    </div>
                                                </div>
                                                <span class="col-md-1 text-center my-auto">=</span>
                                                <div class="input-group col-md-4">
                                                    <input type="nubmer" class="form-control form-control-user" id="redemption_conversion_rate_money" placeholder="10" name="redemption_conversion_rate_money" value="1" readonly>
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><?= $currentRestCurrencySymbol?></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <label class="col-sm-6 col-md-4">
                                            <?= $this->lang->line('Points')?> <?= $this->lang->line('Expire after')?>
                                            <p class="small">(<?= $this->lang->line('How much days without a new order')?>)</p>
                                        </label>
                                        <div class="col-sm-6 col-md-8">
                                            <div class="row">
                                                <div class="input-group col-sm-12">
                                                    <input type="number" class="form-control form-control-user" id="expire_after" placeholder="365" name="expire_after" value="<?= isset($loaltyPoints) ? $loaltyPoints->expire_after : "" ?>" step= "1" min="0">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><?= $this->lang->line('day(s)')?></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="submit"  value="<?= $this->lang->line('Save Changes')?>" class="btn btn-primary btn-user btn-block col-6">
                                </div>
                            </section>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="row">
                <div class="col-lg-12">
                    <div class="p-md-5 p-3">
                        <h1 class="h3 text-gray-900 mb-4"><?= $this->lang->line('Clients')?></h1>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th><?= $this->lang->line('Customer Information')?></th>
                                        <th><?= $this->lang->line('Points')?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php  foreach ($clients as $ckey => $client) { ?>
                                        <tr class="points-row">
                                            <td> <?= $client->customer_email?></td>
                                            <td> <?= $client->loyalty_points?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

