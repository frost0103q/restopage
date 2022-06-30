<div class="container orderManagement order-page">
	<div class="card o-hidden border-0 shadow-lg my-5">
		<div class="card-body">
            <div class="row">
                <div class="col-md-12 d-flex justify-content-between align-items-center mb-4">
                    <h1 class="h4 text-gray-900 text-capitalize"> <?= $filter_type?> <?= $this->lang->line('Orders Management')?></h1>
                    <div class="order-navigation d-flex">                    
                        <div class="j-status-badge accepted-badge"> 
                            <span>
                                <a class="collapse-item" href="<?=base_url('Restaurant/acceptedOrders')?>"><?= $this->lang->line('Accepted')?></a> 
                            </span>
                        </div>
                        <div class="j-status-badge pending-badge"> 
                            <span>
                                <a class="collapse-item" href="<?=base_url('Restaurant/pendingOrders')?>"><?= $this->lang->line('Pending')?></a> 
                            </span>
                        </div>
                        <div class="j-status-badge canceled-badge"> 
                            <span>
                                <a class="collapse-item" href="<?=base_url('Restaurant/rejectedOrders')?>"><?= $this->lang->line('Rejected')?></a> 
                            </span>
                        </div>
                        <div class="j-status-badge all-badge"> 
                            <span>
                                <a class="collapse-item" href="<?=base_url('Restaurant/orderManagement')?>"><?= $this->lang->line('All Orders')?></a>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
                <hr>
            <div class="row filter-bar">
                <div class="col-lg-7">
                    <div class="row">
                        <div class="col-lg-4 mt-3">
                            <label class="form-label"><?= $this->lang->line('Start Date')?></label>
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-calendar-alt"></i></span></div>
                                <input type="text" class="form-control form-control-user datepickers" id="start_date" name="start_date">
                            </div>
                        </div>
                        <div class="col-lg-4 mt-3">
                            <label class="form-label"><?= $this->lang->line('End Date')?></label>
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-calendar-alt"></i></span></div>
                                <input type="text" class="form-control form-control-user datepickers" id="end_date" name="end_date">
                            </div>
                        </div>
                        <div class="col-lg-4 mt-3">
                            <label class="form-label"><?= $this->lang->line('By Order Number')?></label>
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text">123</span></div>
                                <input type="text" class="form-control form-control-user" id="order_number"  name="order_number" >
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mt-3 ml-auto">
                    <div class="row mt-lg-5">
                        <div class="col-lg-6">
                            <div class="form-check">
                                <input class="form-check-input pickup_show filter-by-dp" name="pickup_show" id="pickup_show" type="checkbox" checked="true">
                                <label class="form-check-label pickup_show filter-by-dp" for="pickup_show"><?= $this->lang->line('Pickup')?></label>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-check">
                                <input class="form-check-input delivery_show filter-by-dp" name="delivery_show" id="delivery_show" type="checkbox"  checked="true">
                                <label class="form-check-label delivery_show filter-by-dp" for="delivery_show"><?= $this->lang->line('Delivery')?></label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 mt-3 d-flex justify-content-around align-items-end such-btn ml-auto">
                    <span class="btn btn-success" id="filter_order"><?= $this->lang->line('Filter Order')?></span>
                    <span class="btn btn-info" id="print_list"><?= $this->lang->line('Print List')?></span>
                    <span class="btn btn-info" id="save_pdf"><?= $this->lang->line('Save as PDF')?></span>
                </div>
            </div>
        </div>
        <div class="card-body">
            <hr>
            <div class="d-flex justify-content-between my-3">
                <div>
                    <span><?= $this->lang->line('All Orders')?></span>
                    <span> : <?= count($orders)?></span>
                </div>
                <div>
                    <?php if($filter_type == "all" || $filter_type == "pending"){?>
                        <div class="d-flex justify-content-between">
                            <span><?= $this->lang->line('Pending') ?> <?= $this->lang->line('Amount')?> </span>
                            <span> : <?=$currentRestCurrencySymbol?> <?= number_format($pending_order_value,2) ?></span>
                        </div>
                    <?php }
                    if($filter_type == "all" || $filter_type == "accepted"){?>
                        <div class="d-flex justify-content-between">
                            <span><?= $this->lang->line('Accepted') ?> <?= $this->lang->line('Amount')?> </span>
                            <span> : <?=$currentRestCurrencySymbol?> <?= number_format($accepted_order_value,2) ?></span>
                        </div>
                    <?php }
                    if($filter_type == "all" || $filter_type == "finished"){?>
                        <div class="d-flex justify-content-between">
                            <span><?= $this->lang->line('Finished') ?> <?= $this->lang->line('Amount')?> </span>
                            <span> : <?=$currentRestCurrencySymbol?> <?= number_format($finished_order_value,2) ?></span>
                        </div>
                    <?php }
                    if($filter_type == "all" || $filter_type == "rejected"){?>
                        <div class="d-flex justify-content-between">
                            <span><?= $this->lang->line('Rejected') ?> <?= $this->lang->line('Amount')?> </span>
                            <span> : <?=$currentRestCurrencySymbol?> <?= number_format($canceled_order_value,2) ?></span>
                        </div>
                    <?php }
                    if($filter_type == "all"){?>
                        <div class="d-flex justify-content-between">
                            <span><?= $this->lang->line('Total Amount')?> </span>
                            <span> : <?=$currentRestCurrencySymbol?> <?= number_format($total_order_value,2) ?></span>
                        </div>
                    <?php }?>
                </div>
            </div>
            <div class="table-responsive" id="order-table">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th class="text-center"><?= $this->lang->line("Order ID/Type")?></th>
                            <th class="text-center"><?= $this->lang->line("Order Date/Time")?></th>
                            <th class="text-center"><?= $this->lang->line("Amount")?></th>
                            <th class="text-center"><?= $this->lang->line("Delivery/Pickup")?></th>
                            <th class="text-center"><?= $this->lang->line("Phone/Email")?></th>
                            <th class="text-center"><?= $this->lang->line("Status")?></th>
                            <th class="text-center"><?= $this->lang->line("Action")?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $i = 1;
                            foreach ($orders as $okey => $ovalue) { 
                                $credit_card_door_label = strtolower($ovalue->order_type) == "pickup" ? "Creditcard at Pickup": "Creditcard on the Door";
                                ?>
                                <tr class="order-row order-row-<?=$i?>  <?=$ovalue->order_type?>-row" data-id = "<?= $i?>">
                                    <td class="text-center align-middle"><?= $i++?></td>
                                    <td class="text-center align-middle order-id "><div><div class="j-status-badge <?=$ovalue->order_status ?>-badge"> <span><?=$ovalue->order_status ?></span></div></div><span> Menu-<?= $ovalue->order_id?></td>
                                    <td class="text-center align-middle order-date"><?= date($currentRestDetail->date_format." | ".($currentRestDetail->time_format == "H:i" ? "H:i:s" : "h:i:s A" ), strtotime($ovalue->order_date))?></td>
                                    <td class="text-center align-middle"><strong><?=$currentRestCurrencySymbol?><?= $ovalue->order_amount?></strong><br><span class="text-uppercase small"><?= $ovalue->order_payment_method == "creditcard_on_the_door" ? $credit_card_door_label : $ovalue->order_payment_method ?></span></td>
                                    <td class="text-center align-middle text-uppercase"><p class='mb-0'><?= $ovalue->order_type?></p><?= $ovalue->order_specification == "pre" ? "<p class='mb-0 badge badge-success'> Pre Order</p>" : "" ?><?= $ovalue->order_specification == "virtual" ? "<p class='mb-0 badge badge-warning'>Virtual Order</p>" : "" ?></td>
                                    <td class="text-center align-middle"><?= $ovalue->customer_email?></td>
                                    <td class="text-center align-middle">
                                        <select class="order_status form-control" data-status = "<?= $ovalue->order_status ?>" d-order_id = <?= $ovalue->order_id?> d-payment_method = <?= $ovalue->order_payment_method?> d-order_type ="<?= $ovalue->order_type?>">
                                            <option value="accepted" <?= $ovalue->order_status =="accepted" ? "selected" : "" ?> >Accepted</option>
                                            <option value="canceled" <?= $ovalue->order_status =="canceled" ? "selected" : "" ?> >Canceled</option>
                                            <option value="pending" <?= $ovalue->order_status =="pending" ? "selected" : "" ?> >Pending</option>
                                        </select>
                                    </td>
                                    <td class="text-center align-middle">
                                        <a href="<?=base_url('Restaurant/orderDetail/').$ovalue->order_id?>" title="<?= $this->lang->line('Edit')?>"><i class="fas fa-eye"></i></a>
                                        <a href="javascript:void(0)" title="<?= $this->lang->line('Remove')?>" class="text-danger remove_order" d-order_id="<?= $ovalue->order_id?>"><i class="fas fa-trash"></i></a>
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


