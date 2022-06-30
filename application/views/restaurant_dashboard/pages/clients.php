<div class="container orderManagement order-page">
	<div class="card o-hidden border-0 shadow-lg my-5">
		<div class="card-body">
            <div class="row">
                <div class="col-md-12 d-flex justify-content-between align-items-center mb-4">
                    <h1 class="h4 text-gray-900 text-capitalize"> <?= $this->lang->line('Clients')?></h1>
                </div>
            </div>
        </div>
        <div class="card-body">
            <hr>
            <div class="table-responsive" id="client-table">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="text-center"><?= $this->lang->line("Customer")?> <?= $this->lang->line("ID")?></th>
                            <th class="text-center"><?= $this->lang->line("Customer")?> <?= $this->lang->line("Name")?></th>
                            <th class="text-center"><?= $this->lang->line("Customer")?> <?= $this->lang->line("Phone/Email")?></th>
                            <th class="text-center"><?= $this->lang->line("Company Name")?></th>
                            <!-- <th class="text-center"><?= $this->lang->line("Customer")?> <?= $this->lang->line("Status")?></th> -->
                            <th class="text-center"><?= $this->lang->line("Action")?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $i = 1;
                            foreach ($clients as $ckey => $cvalue) { 
                                $customer_email = isset($cvalue->account_email) ? $cvalue->account_email :  $cvalue->customer_email;
                                if ($customer_email !== "" && $customer_email !== null){
                                ?>
                                    <tr class="client-row cllient-row-<?=$cvalue->customer_id?>" data-cid = "<?= $cvalue->customer_id?>">
                                        <td class="text-center align-middle"><?= $cvalue->customer_id?></td>
                                        <td class="text-center align-middle"><?= $cvalue->customer_name?></td>
                                        <td class="text-center align-middle"><?= $cvalue->customer_phone?><br><?= $customer_email?></td>
                                        <td class="text-center align-middle"><?= $cvalue->customer_company_name?></td>
                                        <!-- <td class="text-center align-middle"><?= $cvalue->customer_id?></td> -->
                                        <td class="text-center align-middle">
                                            <a href="<?=base_url('Restaurant/clientOrder/').$cvalue->customer_id?>" title="<?= $this->lang->line('Edit')?>"><i class="fas fa-eye"></i></a>
                                        </td>
                                    </tr>
                                
                                <?php }
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div id="delivery-time-setting" class="modal fade" role="dialog">
    <div class="modal-dialog">

    <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-body">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary duration-title">Delivery Time</h6>
                    </div>
                    <div class="card-body durationForm">
                        <div class="form-group row">
                            <div class="col-sm-12 mb-3 mb-sm-0">
                                <input type="hidden" clasys="form-control form-control-user" id="duration_order_id" name="duration_order_id" value="">
                                <label>It will take for </label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-clock"></i></span>
                                    </div>
                                    <input type="number" class="form-control form-control-user" id="duration_time" placeholder='10' name="duration_time" min="0" >
                                    <div class="input-group-append">
                                        <span class="input-group-text">min(s)</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-12 mb-3 mb-sm-0">
                                <button type="button" id ="accept_order" class="btn btn-primary btn-user btn-block" disabled>Accept Order</button>
                            </div>                         
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?=$this->lang->line('Close')?></button>
            </div>
        </div>
    </div>
</div>


