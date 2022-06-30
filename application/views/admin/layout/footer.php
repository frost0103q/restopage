
        <!-- Footer -->
        <footer class="sticky-footer bg-white" data-url = "<?= base_url("/")?>">
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
    <!-- Edit Category modal -->
    <div id="editSubCategory" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">

            <div class="modal-body">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Update Category</h6>
                    </div>
                    <div class="card-body">
                        <form id="updateSubCate">
                            <div class="form-group row">
                                <div class="col-sm-12 mb-3 mb-sm-0">
                                    <input type="hidden" class="form-control form-control-user" id="subcat_id" name="subcat_id" value="">
                                
                                    <div class="input-group">
                                        <input type="text" class="form-control form-control-user" id="sub_cat_name_english" placeholder='<?= $this->lang->line("Sub Category Name") ?>' name="sub_cat_name_english" value="" >
                                        <div class="input-group-append">
                                            <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/en-flag.png')?>"></span>
                                        </div>
                                    </div>
                                    <div class="input-group mt-2">
                                        <input type="text" class="form-control form-control-user" id="sub_cat_name_french" placeholder='<?= $this->lang->line("Sub Category Name") ?>' name="sub_cat_name_french" value="" >
                                        <div class="input-group-append">
                                            <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/fr-flag.png')?>"></span>
                                        </div>
                                    </div>
                                    <div class="input-group mt-2">
                                        <input type="text" class="form-control form-control-user" id="sub_cat_name_germany" placeholder='<?= $this->lang->line("Sub Category Name") ?>' name="sub_cat_name_germany" value="" >
                                        <div class="input-group-append">
                                            <span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/ge-flag.png')?>"></span>
                                        </div>
                                    </div>
                                </div>
                            
                                
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-12 mb-3 mb-sm-0">
                                    <input type="submit" name="" value="Update Sub Category" class="btn btn-primary btn-user btn-block">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
            </div>

        </div>
    </div>
    <!-- Bootstrap core JavaScript-->
    <script src="<?=base_url('assets/comp_assets/')?>vendor/jquery/jquery.min.js"></script>
    <script src="<?=base_url('assets/comp_assets/')?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?=base_url('assets/comp_assets/')?>vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="<?=base_url('assets/comp_assets/')?>js/sb-admin-2.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.16/dist/summernote.min.js"></script>
    <!-- Page level plugins -->
    <script src="<?=base_url('assets/comp_assets/')?>vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <!-- <script src="<?=base_url('assets/comp_assets/')?>js/demo/chart-area-demo.js"></script> -->
    <!-- <script src="<?=base_url('assets/comp_assets/')?>js/demo/chart-pie-demo.js"></script> -->
    <!-- dropify js -->
    <script src="<?=base_url('assets/additional_assets/')?>js/dropify.min.js"></script>
    <script src="<?=base_url('assets/additional_assets/')?>js/form-fileupload.init.js"></script>
    <script src="<?=base_url('assets/additional_assets/')?>template/libs/switchery/switchery.min.js"></script>
    <script src="<?=base_url('assets/additional_assets/')?>template/libs/multiselect/jquery.multi-select.js"></script>
    <script src="<?=base_url('assets/additional_assets/')?>template/libs/select2/select2.min.js"></script>
    <script src="<?=base_url('assets/comp_assets/')?>vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="<?=base_url('assets/comp_assets/')?>vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <!-- multiselect -->
    <script src="<?=base_url('assets/additional_assets/')?>js/chosen.jquery.js"></script>
    <script type="text/javascript" src="<?= base_url('assets/additional_assets/jquery-ui-timepicker').'/jquery.ui.timepicker.js'?>"></script>
    <script src="<?=base_url('assets/additional_assets/')?>template/libs/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
    
    <!-- modify by Jfrost footer-->
    <script src="<?=base_url('assets/additional_assets/')?>js/myscript.js"></script>
    <!-- ---------------- -->
    <script type="text/javascript">
    $(document).ready(function(){
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
            e.preventDefault();
            // console.log("Working...");
            var formData= new FormData($(this)[0]);
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
        $('.addSubCate').on('submit',function(e){
            e.preventDefault();
            // console.log("Working...");
            var category_id=$('#category_id').val();
            
            if(category_id==0){
                swal("Ooops..","Please Select Category","error");
            }else{
                var formData= new FormData($(this)[0]);
                $.ajax({
                    url:"<?=base_url('API/addSubCategory')?>",
                    type:"post",
                    cache:false,
                    contentType:false,
                    processData:false,
                    data:formData,
                    success:function(response){
                        
                        response=JSON.parse(response);
                        if(response.status==1){
                        swal("Great..","Suub Category Added Successfully.","success");
                        }else if(response.status==2){
                        swal("Wait..","Sub Category Already Exists","warning");
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
    })

    </script>
</body>

</html>
