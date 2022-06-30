        <!-- Begin Page Content -->
        <div class="container-fluid multi-lang-page restaurant-addon-list-page" data-url ="<?= base_url('/')?>" >
            <div class="content_wrap">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary text-capitalize"><?= $this->lang->line("All") ?> <?= $this->lang->line("Restaurant") ?> <?= $this->lang->line("Addons") ?></h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered dataTable dt-responsive nowrap"  width="100%" cellspacing="0">
                                <thead class="text-capitalize">
                                    <tr>
                                        <th>No</th>
                                        <th><?= $this->lang->line("Restaurant") ?> <?= $this->lang->line("Name") ?></th>
                                        <?php foreach ($restaurant_addons as $akey => $addon) { 
                                            $addon_title = json_decode($addon->addon_title);
                                            $title_name_field = "value_" . $_lang;
                                            $title = $addon_title->$title_name_field == "" ? $addon_title->value: $addon_title->$title_name_field; ?>
                                            <th><?= $title ?></th>
                                        <?php } ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($restaurants as $rkey => $rst) { ?>
                                        <tr class="rest-addon-row"  data-rest_id = "<?= $rst->rid ?>">
                                            <td><?= $rkey + 1 ?></td>
                                            <td class="rest-name j-vertical-align-middle <?= in_array('pending',$rest_addon_status[$rst->rid]) ? 'has_new_addon_request': '' ?>">
                                                <?= $rst->rest_name ?>
                                                <span class="badge badge-danger float-right new_addon_request_badge"><?= $this->lang->line("Pending") ?></span>
                                            </td>
                                            <?php foreach ($rest_addon_status[$rst->rid] as $r_addon_id => $ras) { 
                                                ?>
                                                <td class="status-field">
                                                    <select class="form-control addon-status-btn <?= $ras?>" data-rest_id = <?=$rst->rid?> data-addon_id = <?=$r_addon_id?>>
                                                        <option value='inactive' <?= $ras == 'inactive' ? 'selected':'' ?>><?= $this->lang->line("Inactive") ?></option>
                                                        <option value='pending' <?= $ras == 'pending' ? 'selected':'' ?>><?= $this->lang->line("Pending") ?></option>
                                                        <option value='accepted' <?= $ras == 'accepted' ? 'selected':'' ?>><?= $this->lang->line("Accepted but Not Paid") ?></option>
                                                        <option value='active' <?= $ras == 'active' ? 'selected':'' ?>><?= $this->lang->line("Active") ?></option>
                                                    </select>
                                                </td>
                                            <?php } ?>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End of Page Content -->
