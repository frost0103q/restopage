        <!-- Begin Page Content -->
        <div class="container-fluid fileUploadingSetting-page" data-url ="<?= base_url('/')?>" >
            <div class="row">
                <div class="col-md-12 ">
                    <div class="content_wrap tab-content">
                        <form action="fileUploadingSetting" method="post" enctype="multipart/form-data" id="fileUploadingSetting">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3 d-flex justify-content-between title-bar">
                                    <h4 class="mb-0 text-capitalize"><?= $this->lang->line("file")?> <?= $this->lang->line("uploading")?> <?= $this->lang->line("Setting")?></h4>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <section class="food-menu-banner-section mt-5">
                                            <h5 class="text-capitalize"><?= $this->lang->line("Food Menu") ?> <?= $this->lang->line("Banner") ?> <?= $this->lang->line("image") ?></h5>
                                            <hr>
                                            <div class="row">
                                                <div class="col-md-4 ">
                                                    <label for="food_menu_banner_max_width" class="text-capitalize"><?= $this->lang->line("max") ?> <?= $this->lang->line("width") ?></label>
                                                    <div class="input-group">
                                                        <input type="number" name="food_menu_banner_max_width" id="food_menu_banner_max_width" class="form-control" value = "<?= isset($fileUploadingSetting->food_menu_banner) ? $fileUploadingSetting->food_menu_banner->max_width : "" ?>" min="150" placeholder = "1500">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text">px</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 ">
                                                    <label for="food_menu_banner_max_height" class="text-capitalize"><?= $this->lang->line("max") ?> <?= $this->lang->line("height") ?></label>
                                                    <div class="input-group">
                                                        <input type="number" name="food_menu_banner_max_height" id="food_menu_banner_max_height" class="form-control" value = "<?= isset($fileUploadingSetting->food_menu_banner) ? $fileUploadingSetting->food_menu_banner->max_height : "" ?>" min="150" placeholder = "768">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text">px</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 ">
                                                    <label for="food_menu_banner_compression" class="text-capitalize"><?= $this->lang->line("compression") ?></label>
                                                    <div class="input-group">
                                                        <input type="number" name="food_menu_banner_compression" id="food_menu_banner_compression" class="form-control" value = "<?= isset($fileUploadingSetting->food_menu_banner) ? $fileUploadingSetting->food_menu_banner->compression : "" ?>" max="99" placeholder = "70">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text">%</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </section>
                                        <section class="slider-section mt-5">
                                            <h5 class="text-capitalize"><?= $this->lang->line("Slider") ?> <?= $this->lang->line("image") ?></h5>
                                            <hr>
                                            <div class="row">
                                                <div class="col-md-4 ">
                                                    <label for="slider_max_width" class="text-capitalize"><?= $this->lang->line("max") ?> <?= $this->lang->line("width") ?></label>
                                                    <div class="input-group">
                                                        <input type="number" name="slider_max_width" id="slider_max_width" class="form-control" value = "<?= isset($fileUploadingSetting->slider) ? $fileUploadingSetting->slider->max_width : "" ?>" min="150" placeholder = "1500">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text">px</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 ">
                                                    <label for="slider_max_height" class="text-capitalize"><?= $this->lang->line("max") ?> <?= $this->lang->line("height") ?></label>
                                                    <div class="input-group">
                                                        <input type="number" name="slider_max_height" id="slider_max_height" class="form-control" value = "<?= isset($fileUploadingSetting->slider) ? $fileUploadingSetting->slider->max_height : "" ?>" min="150" placeholder = "768">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text">px</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 ">
                                                    <label for="slider_compression" class="text-capitalize"><?= $this->lang->line("compression") ?></label>
                                                    <div class="input-group">
                                                        <input type="number" name="slider_compression" id="slider_compression" class="form-control" value = "<?= isset($fileUploadingSetting->slider) ? $fileUploadingSetting->slider->compression : "" ?>" max="99" placeholder = "70">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text">%</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </section>
                                        <section class="category-section mt-5">
                                            <h5 class="text-capitalize"><?= $this->lang->line("Category") ?> <?= $this->lang->line("image") ?></h5>
                                            <hr>
                                            <div class="row">
                                                <div class="col-md-4 ">
                                                    <label for="category_max_width" class="text-capitalize"><?= $this->lang->line("max") ?> <?= $this->lang->line("width") ?></label>
                                                    <div class="input-group">
                                                        <input type="number" name="category_max_width" id="category_max_width" class="form-control" value = "<?= isset($fileUploadingSetting->category) ? $fileUploadingSetting->category->max_width : "" ?>" min="150" placeholder = "1500">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text">px</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 ">
                                                    <label for="category_max_height" class="text-capitalize"><?= $this->lang->line("max") ?> <?= $this->lang->line("height") ?></label>
                                                    <div class="input-group">
                                                        <input type="number" name="category_max_height" id="category_max_height" class="form-control" value = "<?= isset($fileUploadingSetting->category) ? $fileUploadingSetting->category->max_height : "" ?>" min="150" placeholder = "768">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text">px</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 ">
                                                    <label for="category_compression" class="text-capitalize"><?= $this->lang->line("compression") ?></label>
                                                    <div class="input-group">
                                                        <input type="number" name="category_compression" id="category_compression" class="form-control" value = "<?= isset($fileUploadingSetting->category) ? $fileUploadingSetting->category->compression : "" ?>" max="99" placeholder = "70">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text">%</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </section>
                                        <section class="menu-item-section mt-5">
                                            <h5 class="text-capitalize"><?= $this->lang->line("Menu") ?> <?= $this->lang->line("item") ?> <?= $this->lang->line("image") ?></h5>
                                            <hr>
                                            <div class="row">
                                                <div class="col-md-4 ">
                                                    <label for="menu_item_max_width" class="text-capitalize"><?= $this->lang->line("max") ?> <?= $this->lang->line("width") ?></label>
                                                    <div class="input-group">
                                                        <input type="number" name="menu_item_max_width" id="menu_item_max_width" class="form-control" value = "<?= isset($fileUploadingSetting->menu_item) ? $fileUploadingSetting->menu_item->max_width : "" ?>" min="150" placeholder = "1500">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text">px</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 ">
                                                    <label for="menu_item_max_height" class="text-capitalize"><?= $this->lang->line("max") ?> <?= $this->lang->line("height") ?></label>
                                                    <div class="input-group">
                                                        <input type="number" name="menu_item_max_height" id="menu_item_max_height" class="form-control" value = "<?= isset($fileUploadingSetting->menu_item) ? $fileUploadingSetting->menu_item->max_height : "" ?>" min="150" placeholder = "768">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text">px</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 ">
                                                    <label for="menu_item_compression" class="text-capitalize"><?= $this->lang->line("compression") ?></label>
                                                    <div class="input-group">
                                                        <input type="number" name="menu_item_compression" id="menu_item_compression" class="form-control" value = "<?= isset($fileUploadingSetting->menu_item) ? $fileUploadingSetting->menu_item->compression : "" ?>" max="99" placeholder = "70">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text">%</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </section>
                                        <section class="homepage-service-section mt-5">
                                            <h5 class="text-capitalize"><?= $this->lang->line("Homepage") ?> <?= $this->lang->line("Service") ?> <?= $this->lang->line("image") ?></h5>
                                            <hr>
                                            <div class="row">
                                                <div class="col-md-4 ">
                                                    <label for="homepage_service_max_width" class="text-capitalize"><?= $this->lang->line("max") ?> <?= $this->lang->line("width") ?></label>
                                                    <div class="input-group">
                                                        <input type="number" name="homepage_service_max_width" id="homepage_service_max_width" class="form-control" value = "<?= isset($fileUploadingSetting->homepage_service) ? $fileUploadingSetting->homepage_service->max_width : "" ?>" min="150" placeholder = "1500">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text">px</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 ">
                                                    <label for="homepage_service_max_height" class="text-capitalize"><?= $this->lang->line("max") ?> <?= $this->lang->line("height") ?></label>
                                                    <div class="input-group">
                                                        <input type="number" name="homepage_service_max_height" id="homepage_service_max_height" class="form-control" value = "<?= isset($fileUploadingSetting->homepage_service) ? $fileUploadingSetting->homepage_service->max_height : "" ?>" min="150" placeholder = "768">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text">px</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 ">
                                                    <label for="homepage_service_compression" class="text-capitalize"><?= $this->lang->line("compression") ?></label>
                                                    <div class="input-group">
                                                        <input type="number" name="homepage_service_compression" id="homepage_service_compression" class="form-control" value = "<?= isset($fileUploadingSetting->homepage_service) ? $fileUploadingSetting->homepage_service->compression : "" ?>" max="99" placeholder = "70">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text">%</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </section>
                                    </div>
                                    <div class="col-sm-12 mx-auto mb-3 mt-md-5 mt-3 mb-sm-0">
                                        <input type="submit" name="" value="<?= $this->lang->line('SAVE')?>" class="btn btn-danger btn-user btn-block submit-btn">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            
            </div>
        </div>
        <!-- /.container-fluid -->
