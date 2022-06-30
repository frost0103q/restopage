
        <!-- Begin Page Content -->

        <div class="container-fluid" id = "all_active_category" data-url = <?=base_url('/')?>>

            <!-- Page Heading -->
            <h1 class="h3 mb-2 text-gray-800"><?= $this->lang->line("Reservations") ?></h1>
            <!-- modify by Jfrost -->
            <section class="my-5 tab-panel-j">
                <div class="row type-panel mt-2">
                    <div class="d-flex align-items-center mx-auto">
                        <ul class="nav nav-tabs">
                            <li class="active">
                                <a class="active" data-toggle="tab" href="#pending_reservation"><?= $this->lang->line("Pending")?></a>
                            </li>
                            <li class="">
                                <a class="" data-toggle="tab" href="#accepted_reservation"><?= $this->lang->line("Accepted")?></a>
                            </li>
                            <li class="">
                                <a class="" data-toggle="tab" href="#rejected_reservation"><?= $this->lang->line("Rejected")?></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </section>
            <!-- ---------------- -->

            <div class="content_wrap tab-content">
                <?php
                $rvt = ["pending","accepted", "rejected"];
                foreach ($rvt as $key => $type) { ?>
                    <section id="<?= $type."_reservation"?>" class = "tab-pane <?=$key== 0 ? 'active' : '' ?>">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card shadow mb-4">
                                    <div class="card-header py-3">
                                        <h6 class="m-0 font-weight-bold text-primary text-capitalize"><?= $type?> <?= $this->lang->line("Reservations") ?></h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered dataTable dt-responsive nowrap"  width="100%" cellspacing="0">
                                                <thead class="">
                                                    <tr>
                                                        <th>When ?</th>
                                                        <th>Contact</th>
                                                        <th>Persons</th>
                                                        <th>Created At</th>
                                                        <th>Action</th>
                                                        <th>Remark</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        foreach ($reservations as $rkey => $rvalue) { 
                                                            if ($rvalue->status == $type){ ?>
                                                                <tr class="reservation_row" data-reservation_id = "<?= $rvalue->id?>" data-status="<?= $type?>">
                                                                    <td>
                                                                        <p class="mb-1"><b><?= $this->lang->line("Date")?> :</b> <span class="reservation-date"><?= $rvalue->date?></span></p>
                                                                        <p class="mb-1"><b><?= $this->lang->line("Time")?> :</b> <span class="reservation-time"><?= $rvalue->time?></span></p>
                                                                    </td>
                                                                    <td>
                                                                        <p class="mb-1"><b><?= $this->lang->line("Name")?> :</b> <span class="reservation-name"><?= $rvalue->first_name?> <?= $rvalue->last_name?></span></p>
                                                                        <p class="mb-1"><b><?= $this->lang->line("Phone")?> :</b> <span class="reservation-phone"><?= $rvalue->telephone?></span></p>
                                                                        <p class="mb-1"><b><?= $this->lang->line("Email")?> :</b> <span class="reservation-email"><?= $rvalue->email?></span></p>
                                                                    </td>
                                                                    <td>
                                                                        <p class="mb-1"><b><?= $this->lang->line("Person")?>(s) :</b> <span class="reservation-count"><?= $rvalue->number_of_people?></span></p>
                                                                    </td>
                                                                    <td>
                                                                        <p class="mb-1"><span class=""><?= $rvalue->created_at?></span></p>
                                                                    </td>
                                                                    <td class=" text-center">
                                                                        <?php 
                                                                            if ($type == "rejected" || $type == "pending"){
                                                                                echo '<span class="btn j-blue-bg accept_reservation">Accept</span>';
                                                                            }
                                                                            if ($type == "accepted" || $type == "pending"){
                                                                                echo '<span class="btn btn-danger cancel_reservation">Cancel</span>';
                                                                            }
                                                                        ?>
                                                                    </td>
                                                                    <td>
                                                                        <p class="mb-1"><span class=""><?= $rvalue->remark?></span></p>
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
                       
                        </div>
                    
                        <!-- DataTales Example -->
                      
                    </section>
                <?php } ?>
            </div>
        </div>
        <!-- /.container-fluid -->

    </div>
    <script>
        $(document).ready(function(){
            var rest_id="<?=$myRestId?>";
            lang = "<?= $this->session->userdata('site_lang_admin')?>";
            console.log(lang);
            $("."+lang+"-field").removeClass("hide-field");
        });
        $(document).on('click','.lang-bar .item-flag',function(){
            $(".lang-bar .item-flag").removeClass("active");
            lang = $(this).attr("data-flag");
            $(".lang-bar .item-flag[data-flag='"+lang+"']").addClass("active");
            $("."+"english"+"-field").addClass("hide-field");
            $("."+"germany"+"-field").addClass("hide-field");
            $("."+"french"+"-field").addClass("hide-field");
            $("."+lang+"-field").removeClass("hide-field");
        });
    </script>
    
