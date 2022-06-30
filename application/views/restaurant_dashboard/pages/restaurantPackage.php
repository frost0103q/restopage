
<div class="container">
    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="py-5 px-md-5 px-3">
                        <form class="user" id="restaurantSetting" data-rest_id = "<?=$restDetails->rest_id?>">
                            <section class="plan-package">
                                <div class="">
                                    <h1 class="h4 text-gray-900 mb-4"><?= $this->lang->line('Restaurant')?> <?= $this->lang->line('Package')?></h1>
                                    <hr>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6 col-sm-12 order-lg-1 order-2 p-lg-5 mb-lg-0 mb-4">
                                        <!-- item -->
                                        <div class="item <?= $restDetails->resto_plan == 'pro' ? '' : 'active' ?>">
                                            <!-- item head -->
                                            <div class="item-head">
                                                <!-- name -->
                                                <h5 class="name mb-2 text-center"><strong>Free</strong> RestoPage</h5>
                                                <!-- price -->
                                                <div class="price">
                                                    <div class="d-flex align-items-start justify-content-center mt-4">
                                                        <div class="count">Free</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- item body -->
                                            <div class="item-body px-md-3 px-2">
                                                <ul class="list-unstyled mb-0">
                                                    <li><i class="fa fa-check"></i>Home</li>
                                                    <li><i class="fa fa-check"></i>Standard Food Menu</li>
                                                    <li><i class="fa fa-check"></i>Reservation</li>
                                                    <li><i class="fa fa-check"></i>Contact</li>
                                                    <li><i class="fa fa-check"></i>Multilingual (<em>English, German, French</em>)</li>
                                                    <li><i class="fa fa-check"></i>Change colors</li>
                                                </ul>
                                            </div>
                                            <!-- item footer -->
                                            <div class="item-footer">
                                                <span class="th-btn-fill-primary text-uppercase w-100 <?= $restDetails->resto_plan == 'pro' ? '' : 'bg-success' ?> plan-btn" data-plan="free">
                                                    <?= $restDetails->resto_plan == 'pro' ? 'Downgrade to Free' : 'Activated' ?>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-12 order-lg-1 order-2 p-lg-5 mb-lg-0 mb-4">
                                        <!-- item -->
                                        <div class="item <?= $restDetails->resto_plan == 'pro' ? 'active' : '' ?>">
                                            <!-- item head -->
                                            <div class="item-head">
                                                <!-- name -->
                                                <h5 class="name mb-2 text-center"><strong>PRO</strong> RestoPage</h5>
                                                <!-- price -->
                                                <div class="price">
                                                    <div class="d-flex align-items-start justify-content-center mt-4">
                                                        <!-- currency -->
                                                        <div class="currency mr-1 align-self-start"><?= $currentRestCurrencySymbol?></div>
                                                        <!-- count -->
                                                        <div class="count">5,00</div>
                                                        <!-- commnet -->
                                                        <div class="comment ml-1 align-self-end">/monthly</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- item body -->
                                            <div class="item-body px-md-3 px-2">
                                                <ul class="list-unstyled mb-0">
                                                    <li><i class="fa fa-check"></i>Home</li>
                                                    <li><i class="fa fa-check"></i>Standard Food Menu</li>
                                                    <li><i class="fa fa-check"></i>Delivery & Pickup Food Menu</li>
                                                    <li><i class="fa fa-check"></i>Orders Management</li>
                                                    <li><i class="fa fa-check"></i>Paypal & Stripe Payment</li>
                                                    <li><i class="fa fa-check"></i>Cash Payment</li>
                                                    <li><i class="fa fa-check"></i>Reservation</li>
                                                    <li><i class="fa fa-check"></i>Contact</li>
                                                    <li><i class="fa fa-check"></i>Multilingual (<em>English, German, French</em>)</li>
                                                    <li><i class="fa fa-check"></i>Change colors</li>
                                                </ul>
                                            </div>
                                            <!-- item footer -->
                                            <div class="item-footer">
                                                <span class="th-btn-fill-primary text-uppercase w-100 <?= $restDetails->resto_plan == 'pro' ? 'bg-success' : '' ?> plan-btn" data-plan="pro">
                                                    <?= $restDetails->resto_plan == 'pro' ? 'Activated' : 'Upgrade to Pro' ?>
                                                </span>
                                            </div>
                                        </div>
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

