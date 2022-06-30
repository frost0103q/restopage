
        <!-- Begin Page Content -->

        <div class="container-fluid" id = "all_tax" data-url = <?=base_url('/')?>>

            <!-- Page Heading -->
            <h1 class="h3 mb-2 text-gray-800"><?= $this->lang->line('Tax Setting')?></h1>
            <!-- modify by Jfrost -->
            <div class="content_wrap tab-content">
                <section>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary"><?= $this->lang->line("New Tax") ?></h6>
                                </div>
                                <div class="card-body">
                                    <form id="addNewTax">
                                        <div class="form-group row">
                                            <div class="col-sm-8 mb-3 mb-sm-0">
                                                
                                                <div class="input-group">
                                                    <input type="hidden" id="rest_id" name="rest_id" value="<?= $myRestId?>">
                                                    <input type="number" class="form-control form-control-user" id="tax_value" placeholder='3.00' name="tax_value" min="0" step="0.01" max= "100">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text">%</span>
                                                    </div>
                                                </div>
                                                <label class="mt-4"><?= $this->lang->line("Description")?></label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control form-control-user" id="tax_desc" placeholder='Tax 1' name="tax_desc">
                                                </div>
                                            </div>
                                            <div class="col-sm-4 mb-3 mb-sm-0">
                                                <input type="submit" name="" value='<?= $this->lang->line("Add New") ?>' class="btn btn-primary btn-user btn-block">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary"><?= $this->lang->line("Delivery Tax") ?></h6>
                                </div>
                                <div class="card-body">
                                    <form id="addNewDeliveryTax">
                                        <div class="form-group row">
                                            <div class="col-sm-8 mb-3 mb-sm-0">
                                                
                                                <div class="input-group">
                                                    <input type="hidden" id="delivery_rest_id" name="delivery_rest_id" value="<?= $myRestId?>">
                                                    <input type="number" class="form-control form-control-user" id="delivery_tax_value" placeholder='<?= $this->lang->line("Enter Delivery Tax")?>' name="delivery_tax_value" min="0" step="0.01" max= "100" value="<?= $delivery_tax?>">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text">%</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-4 mb-3 mb-sm-0">
                                                <input type="submit" name="" value='<?= $this->lang->line("SAVE") ?>' class="btn btn-primary btn-user btn-block">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary"><?= $this->lang->line("All Tax Settings")?></h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th class="text-center">No.</th>
                                        <th class="text-center">Tax ( % )</th>
                                        <th class="text-center"><?= $this->lang->line("Description")?></th>
                                        <th class="text-center"><?= $this->lang->line("Standard")?> <?= $this->lang->line("Tax")?></th>
                                        <th class="text-center"><?= $this->lang->line("Action")?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i=1;?>
                                    <?php foreach($tax_list as $tax): ?>
                                        <tr>
                                            <td class="text-center"><?=$i?></td>
                                            <td class="text-center"><?= $tax->tax_percentage?></td>
                                            <td class="text-center"><?= $tax->tax_description?></td>
                                            <td class="text-center"><input type="radio" class="is_standard" name="is_standard" <?= $tax->is_standard ? "checked" : "" ?> d-tax_id="<?=$tax->id?>"></td>
                                            <td class="text-center">
                                                <a href="javascript:void(0)" title="<?= $this->lang->line('Edit Tax')?>" class="text-success edit_tax"  d-tax_id="<?=$tax->id?>"><i class="fas fa-eye"></i></a>
                                                <a href="javascript:void(0)" title="<?= $this->lang->line('Remove Tax')?>" class="text-danger remove_tax" d-tax_id="<?=$tax->id?>"><i class="fas fa-trash"></i></a>
                                            </td>
                                        </tr>
                                        <?php $i++ ; ?>
                                    <?php endforeach;?>
                                </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
        <!-- /.container-fluid -->

    </div>
    <div id="delivery-time-edting" class="modal fade" role="dialog">
        <div class="modal-dialog">

        <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-body">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary duration-title"><?= $this->lang->line("Edit") ?> <?= $this->lang->line("Delivery Tax") ?></h6>
                        </div>
                        <div class="card-body durationForm">
                            <form id="editTaxForm">
                                <div class="form-group row">
                                    <div class="col-sm-12 mb-3 mb-sm-0">
                                        <input type="hidden" clasys="form-control form-control-user" id="delivery_tax_id" name="delivery_tax_id">
                                        <label><?= $this->lang->line("Tax")?></label>
                                        <div class="input-group">
                                            
                                            <input type="number" class="form-control form-control-user" id="delivery_tax_percentage" name="delivery_tax_percentage" min="0" max="100" step="0.01">
                                            <div class="input-group-append">
                                                <span class="input-group-text">%</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-12 mb-3 mb-sm-0">
                                        <label><?= $this->lang->line("Tax")?> <?= $this->lang->line("Description")?></label>
                                        <div class="input-group">
                                            <input type="text" class="form-control form-control-user" id="delivery_tax_description" name="delivery_tax_description" >
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-12 mb-3 mb-sm-0">
                                        <button type="submit" id ="save_tax" class="btn btn-primary btn-user btn-block" disabled><?= $this->lang->line("SAVE")?></button>
                                    </div>                         
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?=$this->lang->line('Close')?></button>
                </div>
            </div>
        </div>
    </div>
      <!-- End of Main Content -->
