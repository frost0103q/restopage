
        <!-- Footer -->
        <footer class="sticky-footer bg-white"  data-url = "<?= base_url("/")?>" data-rest_id = "<?= $myRestId ?>" >
            <div class="container my-auto">
            <div class="copyright text-center my-auto">
                <span>Copyright &copy; MY.RESTOPAGE.EU 2021</span>
            </div>
            </div>
        </footer>
        <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
            </div>
            <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
            <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            <a class="btn btn-primary" href="login.html">Logout</a>
            </div>
        </div>
        </div>
    </div>

    <div id="addFoodExtraModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-body">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary add-extra-label hide-field"><?=$this->lang->line('Add')?> <?=$this->lang->line('Food Extra')?></h6>
                            <h6 class="m-0 font-weight-bold text-primary edit-extra-label hide-field"><?=$this->lang->line('Update Food Extra')?></h6>
                        </div>
                        <div class="card-body">
                            <form id="insertFoodExtra">
                                <div class="form-group row">
                                    <div class="col-sm-12 mb-3 mb-sm-0">
                                        <input type="hidden" class="form-control form-control-user foodExtra_id" name="foodExtra_id" value="">
                                        <div class="mb-3 mb-sm-0">
                                            <label><?=$this->lang->line('Select')?> <?=$this->lang->line('Food Extra')?> <?=$this->lang->line('Category')?></label>
                                            <select class="form-control extra_category_id_in_modal" name="extra_category_id" required=""   data-lang = "<?= $category_lang ?>" onchange="selectFoodExtraCategoryFunction()">
                                                <option value="0"><?=$this->lang->line('Select')?> <?=$this->lang->line('Food Extra')?> <?=$this->lang->line('Category')?></option>
                                                <?php
                                                    $extra_categories = $this->db->query("SELECT * FROM tbl_food_extra_category WHERE added_by = $myRestId AND extra_category_status ='active' ORDER BY extra_category_sort_index")->result();
                                                    $extra_category_name = "extra_category_name_" . $category_lang;
                                                    foreach ($extra_categories as $extra_category) { ?>
                                                        <option value="<?=  $extra_category->extra_category_id?>" data-type = "<?= $extra_category->is_multi_select?>" data-eng_name = "<?= $extra_category->extra_category_name_english == "" ? $extra_category->extra_category_name : $extra_category->extra_category_name_english ?>"
                                                        data-fre_name = "<?= $extra_category->extra_category_name_french == "" ? $extra_category->extra_category_name : $extra_category->extra_category_name_french ?>" 
                                                        data-ger_name = "<?= $extra_category->extra_category_name_germany == "" ? $extra_category->extra_category_name : $extra_category->extra_category_name_germany ?>">
                                                        <?=  $extra_category->$extra_category_name == "" ? $extra_category->extra_category_name : $extra_category->$extra_category_name ?></option>
                                                    <?php }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-12 mb-3 mt-2 mb-sm-0 subextra_label hide-field">
                                        <label><?=$this->lang->line('Select')?> <?=$this->lang->line('Food Extra')?></label>
                                    </div>
                                    <div class="col-sm-12 mb-3 mb-sm-0 subextra">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-12 mb-3 mb-sm-0">
                                        <input type="submit" name="" value="<?=$this->lang->line('Add Food Extra')?>" class="btn btn-primary btn-user btn-block add_extra_btn_in_modal add-extra-label hide-field" >
                                        <input type="submit" name="" value="<?=$this->lang->line('Update Food Extra')?>" class="btn btn-primary btn-user btn-block add_extra_btn_in_modal edit-extra-label hide-field" >
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
    <!-- Bootstrap core JavaScript-->
       
    <script src="<?=base_url('assets/comp_assets/')?>vendor/jquery/jquery.min.js"></script>
    <?php
    
        if(isset($externalScript)){
            echo $externalScript;
        }
        echo '<script type="text/javascript" src="'.base_url('assets/additional_assets/jquery-ui-timepicker').'/include/jquery-1.9.0.min.js"></script>';
        echo '<script type="text/javascript" src="'.base_url('assets/additional_assets/jquery-ui-timepicker').'/include/ui-1.10.0/jquery.ui.core.min.js"></script>';
        echo '<script type="text/javascript" src="'.base_url('assets/additional_assets/jquery-ui-timepicker').'/include/ui-1.10.0/jquery.ui.widget.min.js"></script>';
        echo '<script type="text/javascript" src="'.base_url('assets/additional_assets/jquery-ui-timepicker').'/include/ui-1.10.0/jquery.ui.tabs.min.js"></script>';
        echo '<script type="text/javascript" src="'.base_url('assets/additional_assets/jquery-ui-timepicker').'/include/ui-1.10.0/jquery.ui.position.min.js"></script>';
        echo '<script type="text/javascript" src="'.base_url('assets/additional_assets/jquery-ui-timepicker').'/jquery.ui.timepicker.js?v=0.3.3"></script>';
        echo '<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>';
    ?>
    <script src="<?=base_url('assets/additional_assets/')?>template/libs/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
    <script src="<?=base_url('assets/additional_assets/')?>template/libs/switchery/switchery.min.js"></script>
    <script src="<?=base_url('assets/additional_assets/')?>js/chosen.jquery.js"></script>
    <script src="<?=base_url('assets/comp_assets/')?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?=base_url('assets/comp_assets/')?>vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="<?=base_url('assets/comp_assets/')?>js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="<?=base_url('assets/comp_assets/')?>vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="<?=base_url('assets/comp_assets/')?>vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="<?=base_url('assets/comp_assets/')?>vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <script src="<?=base_url('assets/additional_assets/')?>template/libs/datatables/dataTables.responsive.min.js"></script>
    <!-- dropify js -->
    <script src="<?=base_url('assets/additional_assets/')?>js/dropify.min.js"></script>
    <script src="<?=base_url('assets/additional_assets/')?>js/form-fileupload.init.js"></script>

    <!-- multiselect -->
    
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.16/dist/summernote.min.js"></script>

    <!-- ---------------- -->
    <script type="text/javascript">
        $(document).on('submit','#uploadMyLogo',function(e){
            e.preventDefault();
            var formData= new FormData($(this)[0]);
            $.ajax({
            url:"<?=base_url('API/addLogo')?>",
            type:"post",
            processData:false,
            cache:false,
            contentType:false,
            enctype:"multipart/form-data",
            data:formData,
            success:function(response){
                
                response=JSON.parse(response);
                if(response.status==1){
                swal("Great..","Updated Successfully.","success");
                }else{
                swal("Ooops..","Something went wrong","error");
                }
                setInterval(function(){
                location.reload();
                },1500);
            }
            })
        });
        
        
    
        $(document).on('submit','#restDetaila',function(e){
            if ($("#NewPassword").val() == $("#ConfirmPassword").val()){
                var formData= new FormData($(this)[0]);
                $.ajax({
                    url:"<?=base_url('API/updateRestDetailByUser')?>",
                    type:"post",
                    processData:false,
                    cache:false,
                    contentType:false,
                    enctype:"multipart/form-data",
                    data:formData,
                    success:function(response){
                        
                        response=JSON.parse(response);
                        if(response.code==1){
                        swal("Great..","Data Updated Successfully.","success");
                        }else{
                        swal("Ooops..","Something went wrong","error");
                        }
                        // setInterval(function(){
                        //   location.reload();
                        // },1500);
                    }
                })
            }else{
                swal("<?= $this->lang->line('Ooops..')?>","<?= $this->lang->line('Password is not matched.')?>","<?= $this->lang->line('error')?>");
            }
            e.preventDefault();
        
        });
        
        $(document).ready(function(){
            website_languages = "<?= $this->myRestDetail->website_languages ?>";
            $(".multi-lang-page:not(.menu-lang-page) .lang-bar .item-flag").addClass("hide-field");
            website_languages.split(",").forEach(element => {
                $(".multi-lang-page:not(.menu-lang-page) .lang-bar .item-flag[data-flag='"+element+"']").removeClass("hide-field");
            });
            if ($(window).width() < 768) {
                $("body").toggleClass("sidebar-toggled");
                $(".sidebar").toggleClass("toggled");
                $(".sidebar").hasClass("toggled") && $(".sidebar .collapse").collapse("hide");
            }
            else {
            }
            $('.summernote').summernote();
            $('.deact_rest').on('click',function(){
                var rest_id=$(this).attr('d-rest');
                // alert("De-Activate "+rest_id);
                $.ajax({
                url:"<?=base_url('API/deactivateRestaurant')?>",
                type:"post",
                data:{restaurant_id:rest_id},
                success:function(response){
                    console.log(response);
                    response=JSON.parse(response);
                    if(response.status==1){
                    swal("Great..","Deactivated Successfully.","success");
                    }else{
                    swal("Ooops..","Something went wrong","error");
                    }
                    setInterval(function(){
                    location.reload();
                    },1500);
                }
                })
            });
            $('.activate_rest').on('click',function(){
                var rest_id=$(this).attr('d-rest');
                // alert("Activate "+rest_id);
                $.ajax({
                url:"<?=base_url('API/activateRestaurant')?>",
                type:"post",
                data:{restaurant_id:rest_id},
                success:function(response){
                    console.log(response);
                    response=JSON.parse(response);
                    if(response.status==1){
                    swal("Great..","Updated Successfully.","success");
                    }else{
                    swal("Ooops..","Something went wrong","error");
                    }
                    setInterval(function(){
                    location.reload();
                    },1500);
                }
                })
            });
            $('.remove_rest').on('click',function(){
                var rest_id=$(this).attr('d-rest');
                // alert("Activate "+rest_id);
                $.ajax({
                url:"<?=base_url('API/removeRestaurant')?>",
                type:"post",
                data:{rest_id:rest_id},
                success:function(response){
                    
                    response=JSON.parse(response);
                    if(response.status==1){
                    swal("Great..","Deleted Successfully.","success");
                    }else{
                    swal("Ooops..","Something went wrong","error");
                    }
                    setInterval(function(){
                    location.reload();
                    },1500);
                }
                })
            });
        
            $('#restDetail').on('submit',function(e){
                e.preventDefault();
                console.log("Working...");
                var pass=$('#rtestPass').val();
                var confpass=$('#restconfpass').val();
                if(pass!=confpass){
                swal("Ooops..","Password Not Matched","error");
                }else{
                var formData= new FormData($(this)[0]);
                $.ajax({
                    url:"<?=base_url('API/addNewRestaurant')?>",
                    type:"post",
                    cache:false,
                    contentType:false,
                    processData:false,
                    data:formData,
                    success:function(response){
                    
                    response=JSON.parse(response);
                    if(response.status==1){
                        swal("Great..","Restaurant Added Successfully.","success");
                    }else if(response.status==2){
                        swal("Wait..","Details Already Exists","warning");
                    }else{
                        swal("Ooops..","Something went wrong","error");
                    }
                    setInterval(function(){
                        location.reload();
                    },1500);
                    }
                })
                }
            });
            $('.addNewCate').on('submit',function(e){
            // $('#addNewCate_food').on('submit',function(e){
                e.preventDefault();
                console.log("Working...");
                var formData= new FormData($(this)[0]);
                cat_name_eng = $(this).find("input[name='cat_name_english']").val();
                cat_name_fre = $(this).find("input[name='cat_name_french']").val();
                cat_name_ger = $(this).find("input[name='cat_name_germany']").val();
                if (cat_name_eng == "" && cat_name_fre == "" && cat_name_ger == ""){
                    swal("Ooops..","You should insert at least one field.","error");
                }else{
                    $.ajax({
                        url:"<?=base_url('API/addNewCategory')?>",
                        type:"post",
                        cache:false,
                        contentType:false,
                        processData:false,
                        data:formData,
                        success:function(response){
                            
                            response=JSON.parse(response);
                            if(response.status==1){
                                swal("Great..","Category Added Successfully.","success");
                            }else if(response.status==2){
                                swal("Wait..","Details Already Exists","warning");
                            }else{
                                swal("Ooops..","Something went wrong","error");
                            }
                            setInterval(function(){
                                location.reload();
                            },1500);
                        }
                    })
                }
            });
            // modify by Jfrost in 3rd Stage
            $('.addNewExtraCate').on('submit',function(e){
                e.preventDefault();
                console.log("Working...");
                var formData= new FormData($(this)[0]);
                cat_name_eng = $(this).find("input[name='cat_name_english']").val();
                cat_name_fre = $(this).find("input[name='cat_name_french']").val();
                cat_name_ger = $(this).find("input[name='cat_name_germany']").val();
                if (cat_name_eng == "" && cat_name_fre == "" && cat_name_ger == ""){
                    swal("Ooops..","You should insert at least one field.","error");
                }else{
                    $.ajax({
                        url:"<?=base_url('API/addNewExtraCategory')?>",
                        type:"post",
                        cache:false,
                        contentType:false,
                        processData:false,
                        data:formData,
                        success:function(response){
                            
                            response=JSON.parse(response);
                            if(response.status==1){
                                swal("Great..","Extra Category Added Successfully.","success");
                            }else if(response.status==2){
                                swal("Wait..","It Already Exists","warning");
                            }else{
                                swal("Ooops..","Something went wrong","error");
                            }
                            setInterval(function(){
                                location.reload();
                            },1500);
                        }
                    })
                }
            });

            $('.remove_category').on('click',function(){
                var cate_id=$(this).attr('d-cat_id');
                // alert("Activate "+rest_id);
                $.ajax({
                url:"<?=base_url('API/removeCategory')?>",
                type:"post",
                data:{cat_id:cate_id},
                success:function(response){
                    console.log(response);
                    response=JSON.parse(response);
                    if(response.status==1){
                    swal("Great..","Deleted Successfully.","success");
                    }else{
                    swal("Ooops..","Something went wrong","error");
                    }
                    setInterval(function(){
                    location.reload();
                    },1500);
                }
                })
            });
            $('.remove_extra_category').on('click',function(){
                var cate_id=$(this).attr('d-cat_id');
                // alert("Activate "+rest_id);
                $.ajax({
                url:"<?=base_url('API/removeExtraCategory')?>",
                type:"post",
                data:{cat_id:cate_id},
                success:function(response){
                    console.log(response);
                    response=JSON.parse(response);
                    if(response.status==1){
                    swal("Great..","Deleted Successfully.","success");
                    }else{
                    swal("Ooops..","Something went wrong","error");
                    }
                    setInterval(function(){
                    location.reload();
                    },1500);
                }
                })
            });
        })
    </script>
    <!-- modify by Jfrost footer-->
    <script src="<?=base_url('assets/additional_assets/')?>js/myscript.js"></script>
</body>

</html>
