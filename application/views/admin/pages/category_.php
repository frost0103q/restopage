
        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-2 text-gray-800">Categories</h1>
          <?php 
            // print_r($jobApplications);
          ?>
          <div class="row">
            <div class="col-md-6">
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-primary">New Categories</h6>
                </div>
                <div class="card-body">
                  <form id="addNewCate" class="addNewCate">
                    <div class="form-group row">
                      <div class="col-sm-8 mb-3 mb-sm-0">
                        <input type="text" class="form-control form-control-user" id="cat_name" placeholder="Category Name" name="cat_name" value="">
                      </div>
                      <div class="col-sm-4 mb-3 mb-sm-0">
                        <input type="submit" name="" value="Add New Category" class="btn btn-primary btn-user btn-block">
                      </div>
                      
                    </div>
                  
                  </form>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-primary">New Sub Categories</h6>
                </div>
                <div class="card-body">
                  <form id="addSubCate">
                    <div class="form-group row">
                      <div class="col-sm-4 mb-3 mb-sm-0">
                        <select class="form-control form-control-user" name="category_id" id="category_id">
                          <option value="0">Select Category</option>
                          <?php foreach($Categories as $cat_):?>
                            <option value="<?=$cat_->category_id?>"><?=$cat_->category_name?></option>
                          <?php endforeach;?>
                        </select>
                        
                      </div>
                      <div class="col-sm-5 mb-3 mb-sm-0">
                        <input type="text" class="form-control form-control-user" id="sub_cat_name" placeholder="Sub Category Name" name="sub_cat_name" value="">
                      </div>
                      <div class="col-sm-3 mb-3 mb-sm-0">
                        <input type="submit" name="" value="Add " class="btn btn-primary btn-user btn-block">
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
              <h6 class="m-0 font-weight-bold text-primary">All Categories</h6>
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
                    <?php foreach($Categories as $cat):?>
                      <tr>
                        <td class="text-center"><?=$i?></td>
                        <td class="text-center"><?=$cat->category_name?></td>
                        <td class="text-center">
                          <a href="<?=base_url('Admin/categoryDetails/').$cat->category_id?>" title="Edit Category"><i class="fas fa-eye"></i></a>
                          <a href="javascript:void(0)" title="Remove Category" class="text-danger remove_category" d-cat_id="<?=$cat->category_id?>"><i class="fas fa-trash"></i></a>
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
