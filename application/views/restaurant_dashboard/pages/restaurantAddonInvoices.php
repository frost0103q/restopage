
        <!-- Begin Page Content -->

        <div class="container-fluid" id = "all_active_category" data-url = <?=base_url('/')?>>

            <!-- Page Heading -->
            
            <div class="content_wrap tab-content">
                <section>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h1 class="h3 mb-2 text-gray-800"><?= $this->lang->line("Addon") ?> <?= $this->lang->line("Invoices") ?></h1>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered dataTable dt-responsive nowrap"  width="100%" cellspacing="0">
                                            <thead class="">
                                                <tr>
                                                    <th><?= $this->lang->line("Invoice")?> #</th>
                                                    <th><?= $this->lang->line("Invoice")?> <?= $this->lang->line("Date")?></th>
                                                    <th><?= $this->lang->line("Due")?> <?= $this->lang->line("Date")?></th>
                                                    <th><?= $this->lang->line("Total")?></th>
                                                    <th><?= $this->lang->line("Status")?></th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    foreach ($addoninvoices as $ikey => $invoice) { ?>
                                                        <tr class="invoice_row" data-invoice_id = "<?= $invoice->id?>" data-status="<?= $invoice->status?>">
                                                            <td>
                                                                <?= $invoice->id?>
                                                            </td>
                                                            <td>
                                                                <?= date_format(date_create($invoice->invoice_date),$currentRestDetail->date_format ) ?>
                                                            </td>
                                                            <td>
                                                                <?= date_format(date_create($invoice->due_date),$currentRestDetail->date_format ) ?>
                                                            </td>
                                                            <td class="text-capitalize">
                                                                <?= $invoice->description?>
                                                            </td>
                                                            <td class="text-capitalize d-flex align-items-center" >
                                                                <div class="bg-<?= $invoice->status?> status-circle"> </div><?= $invoice->status?>
                                                            </td>
                                                            <td class="text-capitalize text-center">
                                                                <a class="btn btn-primary" href="<?=base_url('Restaurant/AddonInvoiceDetail/').$invoice->id?>" title="<?= $this->lang->line('View')?> <?= $this->lang->line('Invoice')?>"><i class="fas fa-eye"></i></a>
                                                                <a href="javascript:void(0)" title="<?= $this->lang->line('Remove')?> <?= $this->lang->line('Invoice')?>" class=" btn btn-danger  remove_addon_invoice" d-invoice_id="<?=$invoice->id?>"><i class="fas fa-trash"></i></a>
                                                            </td>
                                                        </tr>
                                                    <?php }   
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    
                    </div>
                
                    <!-- DataTales Example -->
                    
                </section>
            </div>
        </div>
        <!-- /.container-fluid -->

    </div>
    
