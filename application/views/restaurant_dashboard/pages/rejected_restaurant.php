
        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-2 text-gray-800">Rejected Restaurant</h1>
          <?php 
            // print_r($jobApplications);
          ?>

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Restaurant</h6>
            </div>


            
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>S.No</th>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Address</th>
                      <th>Action</th>
                      <!-- <th>Salary/</th> -->
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>S.No</th>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Address</th>
                      <th>Action</th>
                    </tr>
                  </tfoot>
                  <tbody>
                    <?php $i=1;?>
                    <?php foreach($rejRest as $rest): ?>
                        <tr>
                          <td><?=$i?></td>
                          <td>
                            <p><strong>Name:</strong> <?=$rest->rest_name?></p>
                            <p><strong>Email:</strong> <?=$rest->rest_email?></p>
                            <p><strong>Contact No:</strong> <?=$rest->rest_contact_no?></p>
                          </td>
                          <td>
                            <p><strong>Name:</strong> <?=$rest->owner_name?></p>
                            <p><strong>Contact No:</strong> <?=$rest->owner_mobile?></p>
                          </td>
                          <td>
                            <p><strong>Address:</strong> <?=$rest->address?></p>
                            <p><strong>GST No:</strong> <?=$rest->gst_no?></p>
                            <p><strong>Established On:</strong> <?=$rest->establishment_year?></p>
                          </td>
                          <td>
                            <p><a href="javascript:void(0)" class="btn btn-success activate_rest" d-rest="<?=$rest->rest_id?>">Activate</a></p>
                            <p><a href="javascript:void(0)" class="btn btn-danger remove_rest" d-rest="<?=$rest->rest_id?>">Remove</a></p>
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
