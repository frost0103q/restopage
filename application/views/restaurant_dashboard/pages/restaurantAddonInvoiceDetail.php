<div class="container addonInvoiceDetail">
    <div class="row">
        <div class="col-md-9">
            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body m-md-4 m-1">
                    <div class="invoice-header row">
                        <div class="col-sm-7">
                            <h3 class="j-text-black"><?=$this->lang->line("Invoice")?> # <?=$addonInvoice->id?><?= $addonInvoice->status == "unpaid" ? "<span class='badge badge-danger text-uppercase j-font-size-13px ml-3'>unpaid</span>" : "<span class='badge badge-success text-uppercase j-font-size-13px ml-3'>paid</span>" ?></h3> 
                        </div>
                        <div class="col-sm-5">
                            <div class="mb-1 invoice-date mr-md-5 d-flex justify-content-between flex-wrap">
                                <span><?= $this->lang->line("Invoice")?> <?= $this->lang->line("Date")?></span>
                                <span><?= date_format(date_create(explode(" ",$addonInvoice->invoice_date)[0]),$currentRestDetail->date_format) ?></span>
                            </div>
                            <div class="mb-1 due-date mr-md-5 d-flex justify-content-between flex-wrap">
                                <span><?= $this->lang->line("Due")?> <?= $this->lang->line("Date")?></span>
                                <span><?= date_format(date_create(explode(" ",$addonInvoice->due_date)[0]),$currentRestDetail->date_format) ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="invoice-body row mt-2">
                        <div class="col-sm-7 invoice-pay-address">
                            <p class="j-text-black text-capitalize my-3">Pay To :</p>
                            <div class="paytoaddress">
                                Restopage.eu<br>
                                Made4you s.à r.l.<br>
                                16, Grand-Rue<br>
                                6630 Wasserbillig<br>
                                Luxembourg<br>
                            </div>
                        </div>
                        <div class="col-sm-5 invoice-invoiced-address my-2">
                            <p class="j-text-black text-capitalize">Invoiced To :</p>
                            <div class="invoicetoaddress">
                                <?=$addonInvoice->company_name?> <?=$addonInvoice->company_name == "" ? '': '<br>'?> 
                                <?=$addonInvoice->first_name?> <?=$addonInvoice->last_name?> <br> 
                                <?=$addonInvoice->address?><br> 
                                <?=$addonInvoice->city?> , <?=$addonInvoice->postcode?> <br> 
                                <?=$addonInvoice->country?><br> 
                            </div>
                        </div>
                        <div class="col-sm-12 mt-md-4 mt-2">
                            <?php
                                $addon = $this->db->where("addon_id",$addonInvoice->addon_id)->get("tbl_addons")->row();
                                if ($addon){
                                    $addon_title = json_decode($addon->addon_title);
                                    $title_name_field = "value_" . $_lang;
                                    $addonInvoiceTitle = $addon_title->$title_name_field == "" ? $addon_title->value: $addon_title->$title_name_field;
                                    $currency = $addonInvoice->currency == "" ? "€" : $addonInvoice->currency;
                                }
                            ?>
                            <p class="j-text-black h5"><?=$this->lang->line("Invoice")?> Items</p>
                            <div class="table-responsive">
                                <table class="table " id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th class=""><?=$this->lang->line("Description")?></th>
                                            <th class=""></th>
                                            <th class=""><?=$this->lang->line("Amount")?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class=""><?=$addonInvoiceTitle?></td>
                                            <td class=""></td>
                                            <td class=""><?=$addonInvoice->total?> <?=$currency?></td>
                                        </tr>
                                        <tr>
                                            <td class=""></td>
                                            <td class="">incl. 17% TAX</td>
                                            <td class=""><?=number_format($addonInvoice->total / 100 * 17,2)?> <?=$currency?></td>
                                        </tr>
                                        <tr>
                                            <td class=""></td>
                                            <td class=""><?=$this->lang->line("Total")?></td>
                                            <td class=""><?=number_format($addonInvoice->total,2)?> <?=$currency?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="bg-info rounded p-3 my-5">
                <p class="j-text-muted mb-1"><?=$this->lang->line("Total")?> <?=$this->lang->line("Due")?></p>
                <h1 class="text-white mb-4"><?=$currency?> <?=number_format($addonInvoice->total,2)?></h1>
                <p class="j-text-muted mb-1"><?=$this->lang->line("Payment")?> Method</p>
                <select class="form-control form-control-user" disabled>
                    <option value="visa" data-payment = "visa" <?=$addonInvoice->payment_method == "visa" ? "selected": "" ?>>Visa</option>
                    <option value="mastercard" data-payment = "mastercard" <?=$addonInvoice->payment_method == "mastercard" ? "selected": "" ?>>Mastercard</option>
                    <option value="american-express" data-payment = "american-express" <?=$addonInvoice->payment_method == "american-express" ? "selected": "" ?>>American Express</option>
                    <option value="paypal" data-payment = "paypal" <?=$addonInvoice->payment_method == "paypal" ? "selected": "" ?>>Paypal</option>
                </select>
                <p class="mt-4 mb-0 j-text-muted">Reference Number : <?= $addonInvoice->id?></p>
            </div>
        </div>
    </div>
</div>


