
        <!-- Begin Page Content -->
        <div class="container-fluid">

        <!-- Page Heading -->
        <div class="row py-2 my-1">
            
            <div class="col-md-8"><h3 class="h3 mb-2 text-gray-800"><?= $this->lang->line("Restaurant List")?></h3></div>
            <div class="col-md-4 pull-right">
                
                    <a href="<?=base_url('Admin/addRestaurant')?>" class="text-white btn btn-danger">
                        <div class="d-flex">
                            <label class="py-1 px-2 mt-1 bg-light rounded">
                                <i class="fas fa-utensils" style="color: black"></i>
                            </label>
                            <div class="ml-2">
                                <h6 class="m-0"><?= $this->lang->line("Add New")?></h6>
                                <small><?= $this->lang->line("Restaurant")?></small>
                            </div>
                        </div>
                    </a>
                
                
            </div>
        </div>
        
        <?php 
            // print_r($addRest);
        ?>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary"><?= $this->lang->line("Restaurant")?></h6>
            </div>


            
            <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                    <th><?= $this->lang->line("S.No")?></th>
                    <th><?= $this->lang->line("Restaurant Details")?></th>
                    <th><?= $this->lang->line("Owner Details")?></th>
                    <th><?= $this->lang->line("Address")?></th>
                    <th><?= $this->lang->line("Action")?></th>
                    </tr>
                </thead>
                
                <tbody>
                    <?php $i=1;?>
                    <?php foreach($addRest as $rest): ?>
                        <?php
                            if($rest->domain_status !== "active" ){
                                $domain_class="badge badge-danger";
                            }else{
                                $domain_class="badge badge-success";
                            }
                        ?>
                        <tr>
                        <td><?=$i?></td>
                        <td>
                            <p><strong><?= $this->lang->line("Name")?>:</strong> <?=$rest->rest_name?></p>
                            <p><strong><?= $this->lang->line("Email")?>:</strong> <?=$rest->rest_email?></p>
                            <p><strong><?= $this->lang->line("Contact No")?>:</strong> <?=$rest->rest_contact_no?></p>
                            <p class="<?= $domain_class?>"><strong>Domain:</strong> <?=$rest->rest_domain?></p>
                        </td>
                        <td>
                            <p><strong><?= $this->lang->line("Name")?>:</strong> <?=$rest->owner_name?></p>
                            <p><strong><?= $this->lang->line("Contact No")?>:</strong> <?=$rest->owner_mobile?></p>
                        </td>
                        <td>
                            <p><strong><?= $this->lang->line("Address")?>:</strong> <?=$rest->address1?> <?=$rest->address2?></p>
                            <p><strong><?= $this->lang->line("GST No")?>:</strong> <?=$rest->gst_no?></p>
                            <p><strong><?= $this->lang->line("Established On")?>:</strong> <?=$rest->establishment_year?></p>
                        </td>
                        <td>
                            <!--<p><a href="javascript:void(0)" class="btn btn-danger remove_rest" d-rest="<?=$rest->rest_id?>">Edit</a></p>-->
                            <p><a href="javascript:void(0)" class="badge badge-warning deact_rest p-2 w-100" d-rest="<?=$rest->rest_id?>"><?= $this->lang->line("Deactivate")?></a></p>
                            <p><a href="javascript:void(0)" class="badge badge-danger remove_rest p-2 w-100" d-rest="<?=$rest->rest_id?>"><?= $this->lang->line("Remove")?></a></p>
                            <p><a href="<?= base_url("Admin/Setting/".$rest->rest_id)?>" class="badge badge-success edit_rest p-2 w-100" d-rest="<?=$rest->rest_id?>"><?= $this->lang->line("Edit")?></a></p>
                            <p><a href="<?= base_url("Admin/viewRestaurant/".$rest->rest_id)?>" class="badge badge-primary edit_rest p-2 w-100" target="_blank" d-rest="<?=$rest->rest_id?>"><?= $this->lang->line("Dashboard")?></a></p>
                        </td>
                        </tr>
                        <?php $i++?>
                    <?php endforeach;?>
                </tbody>
                </table>
            </div>
            </div>
        </div>

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- End of Main Content -->
