<div class="content-page myorder-page">
    <div class="content">

        <div class="container-fluid">
            <div class="card-box">
                <div class="">
                    <h4 class="header-title mt-0 mb-4 text-warning">My Orders</h4>
                    <form id="myorders" type="get" >
                        <div class="order-filter row">
                            <div class="col-md-3 my-2 form-group">
                                <label>Select Restaurants</label>
                                <select class="form-control filter-for-order" id="filter_order_by_rest" name = "rest">
                                    <option value="" selected>All</option>
                                    <?php
                                        foreach ($rests as $rkey => $rvalue) { ?>
                                        <option value="<?=$rvalue->rest_id?>" <?= $filtered_rest_id == $rvalue->rest_id ? "selected" : "" ?>><?= $rvalue->rest_name ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-md-3  my-2 form-group">
                                <label>Select Order Status</label>
                                <select class="form-control text-capitalize filter-for-order" id="filter_order_by_status" name= "status">
                                
                                    <option value="" selected>All</option>
                                    <?php
                                        $status = ["accepted","canceled","finished","paid"];
                                        foreach ($status as $skey => $svalue) { ?>
                                        <option value="<?=$svalue?>" <?= $filtered_status == $svalue ? "selected" : "" ?>><?=$svalue?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-md-3  my-2 form-group">
                                <label>Select Date Range</label>
                                <input class="form-control input-daterange-datepicker filter-for-order" type="text" name="daterange" id="filter_order_by_date" value="<?= $filtered_date_range ?>"/>
                            </div>
                            <div class="col-md-3  my-2 form-group d-flex">
                                <label></label>
                                <button class="btn btn-primary d-flex mt-auto mx-auto px-5" type="submit" >Get</button>
                            </div>
                        </div>
                    </form>
                    <div class="item-list row">
                        <?php
                        
                            $rest_currency_id = $myRestDetail->currency_id;
                            $rest_currency_symbol = $this->db->where("id",$rest_currency_id)->get('tbl_countries')->row()->currency_symbol;
                            $rest_currency_symbol = $rest_currency_symbol == "" ? "&#8364;" : $rest_currency_symbol;

                            foreach ($orders as $okey => $ovalue) { ?>
                                <div class="col-md-6">
                                    <div class='order-item my-2 p-2 px-md-4'>
                                        <div class="order-brand d-flex justify-content-between align-items-center">
                                            <img src="<?= base_url('assets/rest_logo/').$ovalue->rest_logo?>" alt="" height="50">
                                            <p class="order-price text-primary h3"><?= $ovalue->order_amount?> <?= $rest_currency_symbol?></p>
                                        </div>
                                        <p class="dp_option header-title text-capitalize"><?= $ovalue->order_type?></p>
                                        <p class="dp_option text-muted font-13"><?= date_format(date_create($ovalue->order_date),"M d Y h:i A")?></p>
                                        <div class="order-brand d-flex justify-content-between align-items-center">
                                            <a class="btn btn-lighten-primary waves-effect waves-primary  width-xs" href="<?= base_url("Customer/orderdetail/").$ovalue->order_id?>">Order Detail</a>
                                            <span class="btn btn-primary width-xs text-capitalize" href="#"><?= $ovalue->order_status?></span>
                                        </div>
                                    </div>
                                </div>
                            <?php }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

