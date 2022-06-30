
        <!-- Begin Page Content -->

        <div class="container-fluid">

            <!-- Page Heading -->
            <h1 class="h3 mb-2 text-gray-800"><?= $this->lang->line("Allergens") ?></h1>
            <div class="row mt-3">
                <div class="col-md-6">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary"><?= $this->lang->line("Restaurant") ?></h6>
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <div class="col-sm-8 mb-3 mb-sm-0">
                                    <select class="form-control form-control-user restaurant_id" name="restaurant_id">
                                        <option value="0" <?= $rest_id == "0" ? "selected" : "" ?>> <?= $this->lang->line("Select Restaurant") ?></option>
                                        <?php
                                            foreach ($Rests as $key => $value) {
                                            ?>
                                                <option value="<?= $value->restaurant_id?>" <?= $rest_id == $value->restaurant_id ? "selected" : "" ?> ><?= $value->rest_name ?> </option>
                                            <?php
                                            }
                                        ?>
                                    </select>
                                    
                                </div>
                                <div class="col-sm-4 mb-3 mb-sm-0">
                                    <input type="submit" name="" value='<?= $this->lang->line("Select") ?>' class="btn btn-primary btn-user btn-block">
                                </div>
                            
                            </div>
                        
                        </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- modify by Jfrost -->
            <section class="my-5 tab-panel-j">
                <div class="row mx-1 flex-row-reverse my-3">
                    <div class="lang-bar">
                        <span class="<?= $allergen_lang == 'english' ? 'active' : ''  ?> item-flag" data-flag="english"><img class="english-flag" src="<?= base_url('assets/flags/en-flag.png')?>"></span>
                        <span class="<?= $allergen_lang == 'french' ? 'active' : ''  ?> item-flag" data-flag="french"><img class="french-flag" src="<?= base_url('assets/flags/fr-flag.png')?>"></span>
                        <span class="<?= $allergen_lang == 'germany' ? 'active' : ''  ?> item-flag" data-flag="germany"><img class="germany-flag" src="<?= base_url('assets/flags/ge-flag.png')?>"></span>
                    </div>
                </div>   
            </section>
            <!-- ---------------- -->

            <div class="content_wrap tab-content">
                <section>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary"><?= $this->lang->line("New Allergen") ?></h6>
                                </div>
                                <div class="card-body">
                                    <form id = "addNewAllergen" class="addNewAllergen" data-url = "<?=base_url('API/')?>">
                                        <input type="hidden" name="restaurant_id" value="<?=$rest_id?>" >
                                        <div class="form-group row">
                                            <div class="col-sm-8 mb-3 mb-sm-0">
                                                <div class="input-group french-field hide-field">
                                                    <input type="text" class="form-control form-control-user" id="allergen_name_french" placeholder='<?= $this->lang->line("Allergen Name") ?>' name="allergen_name_french" value="" >
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/fr-flag.png')?>"></span>
                                                    </div>
                                                </div>
                                                <div class="input-group germany-field hide-field">
                                                    <input type="text" class="form-control form-control-user" id="allergen_name_germany" placeholder='<?= $this->lang->line("Allergen Name") ?>' name="allergen_name_germany" value="" >
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/ge-flag.png')?>"></span>
                                                    </div>
                                                </div>
                                                <div class="input-group english-field hide-field">
                                                    <input type="text" class="form-control form-control-user" id="allergen_name_english" placeholder='<?= $this->lang->line("Allergen Name") ?>' name="allergen_name_english" value="" >
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/en-flag.png')?>"></span>
                                                    </div>
                                                </div>
                                              
                                            </div>
                                            <div class="col-sm-4 mb-3 mb-sm-0">
                                                <input type="submit" name="" value='<?= $this->lang->line("Add New Allergen") ?>' class="btn btn-primary btn-user btn-block">
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
                        <h6 class="m-0 font-weight-bold text-primary"><?= $this->lang->line("All Allergens")?></h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th class="text-center"><?= $this->lang->line("S.No")?></th>
                                        <th class="text-center"><?= $this->lang->line("Name")?></th>
                                        <th class="text-center"><?= $this->lang->line("Action")?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i=1;?>
                                    <?php foreach($allergens as $allergen):
                                            $allergen_field_name = 'allergen_name_' . $allergen_lang;
                                            $allergentitle = trim($allergen->$allergen_field_name) == "" ? $allergen->allergen_name : $allergen->$allergen_field_name;
                                        ?>
                                        <tr>
                                            <td class="text-center"><?=$i?></td>
                                            <td class="text-center"><?= $allergentitle?></td>
                                            <td class="text-center">
                                                <a href="<?=base_url('Admin/allergenDetails/').$allergen->allergen_id?>" title="<?= $this->lang->line('Edit Allergen')?>"><i class="fas fa-eye"></i></a>
                                                <a href="javascript:void(0)" title="<?= $this->lang->line('Remove Allergen')?>" class="text-danger remove_allergen" d-allergen_id="<?=$allergen->allergen_id?>"><i class="fas fa-trash"></i></a>
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
    <script>
        $(document).ready(function(){
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
        $(document).on('change','.restaurant_id',function(){
            rest_id = $(this).val();
            url ="<?= base_url('Admin/Allergen/')?>";
            if (rest_id > 0){
                location.replace(url + rest_id);
            }else{
                location.replace(url);
            }
        });
    </script>
      <!-- End of Main Content -->
