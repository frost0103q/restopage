
        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-2 text-gray-800">Category Details</h1>
          <?php 
            // print_r($jobApplications);
          ?>
          <div class="row">
            <div class="col-md-6">
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-primary">Update Category</h6>
                </div>
                <div class="card-body">
                  <form id="updateCate">
                    <div class="form-group row">
                      <div class="col-sm-8 mb-3 mb-sm-0">
                      	<input type="hidden" class="form-control form-control-user" id="cat_name" placeholder="Category Name" name="cat_id" value="<?=$CategoryDetails[0]->category_id?>">
                        <input type="text" class="form-control form-control-user" id="cat_name" placeholder="Category Name" name="cat_name" value="<?=$CategoryDetails[0]->category_name?>">
                      </div>
                      <div class="col-sm-4 mb-3 mb-sm-0">
                        <input type="submit" name="" value="Update Category" class="btn btn-primary btn-user btn-block">
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
              <h6 class="m-0 font-weight-bold text-primary">Sub Categories</h6>
            </div>


            <?php 
           // print_r($Categories)
            ?>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th class="text-center">S.No</th>
                      <th class="text-center">Name</th>
                      <th class="text-center">Action</th>
                    </tr>
                  </thead>
                 <!--  <tfoot>
                    <tr>
                      <th class="text-center">S.No</th>
                      <th class="text-center">Name</th>
                      <th class="text-center">Action</th>
                    </tr>
                  </tfoot> -->
                  <tbody>
                    <?php $i=1;?>
                    <?php foreach($subCategoryDetails as $cat):?>
                      <tr>
                        <td class="text-center"><?=$i?></td>
                        <td class="text-center"><?=$cat->sub_category_name?></td>
                        <td class="text-center">
                          <a href="javascript:void(0)" class="edit_sub_cat" title="Edit Sub Category" d-sub_cat_id="<?=$cat->sub_cat_id?>" d-sub_cat_name="<?=$cat->sub_category_name?>"><i class="fas fa-eye"></i></a>
                          <a href="javascript:void(0)" title="Remove Sub Category" class="text-danger removesub_category" d-sub_cat_id="<?=$cat->sub_cat_id?>"><i class="fas fa-trash"></i></a>
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
