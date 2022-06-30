<script>
    $(document).on('keyup','.checkit',function(){
        var el = $(this);
        var value = el.val();
        if(value.includes(',')){
            alert('comma not allowed, please use point');
            location.reload();
        }
    })
</script>
  <div class="container">

    <div class="card o-hidden border-0 shadow-lg my-5">
      <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">
       
          <div class="col-lg-12">
            <div class="p-5">
              <div class="text-center">
                <h1 class="h4 text-gray-900 mb-4">Item Details</h1>
                <hr>
              </div>
              <form class="user" id="updateItemImage">
                <div class="form-group row">
                  <div class="col-md-5">
                      <img src="<?=base_url('assets/menu_item_images/').$itemDetails->item_image?>" alt="" width="100%">
                     
                  </div>
                  <div class="col-md-5">
                      <label>Upload New Image</label>
                      <input type="text" name="menu_id" value="<?=$itemDetails->menu_id?>" class="form-control" readonly>
                      <input type="file" name="item_image">
                  </div>
                </div>
                
               
                <input type="submit" value="Update Item Image" class="btn btn-primary btn-user btn-block">
                <button type="button" class="btn btn-danger btn-user btn-block deleter" menu_id="<?=$itemDetails->menu_id?>">Delete Image</button>
              
              </form>
              <br>
             <br>
             
              <form  id="updateItemDetails">
                <div class="form-group row">
                    
                  <div class="col-sm-6 mb-3 mb-sm-0">
                      <label>Item Name</label>
                      <input type="text" name="menu_id" value="<?=$itemDetails->menu_id?>" class="form-control" readonly>
                    <input type="text" class="form-control form-control-user"  placeholder="Item Name" name="item_name" value="<?=$itemDetails->item_name?>">
                  </div>
                  <div class="col-sm-6 mb-3 mb-sm-0">
                      <label>Item Category</label>
                      <select class="form-control" disabled>
                          <?php foreach($Categories as $cat): ?>
                          <?php
                            if($cat->category_id==$itemDetails->category_id){
                                echo '<option value="'.$cat->category_id.'" selected>'.$cat->category_name.'</option>';
                            }else{
                                echo '<option value="'.$cat->category_id.'" >'.$cat->category_name.'</option>';
                            }
                          
                          ?>
                            
                          <?php endforeach;?>
                      </select>
                    <select class="form-control" name="item_type" required>
                      <option value="3" <?php if($itemDetails->item_type=="Non Veg")echo "selected";?>>Non Veg</option>
                      <option value="1" <?php if($itemDetails->item_type=="Vegetarian")echo "selected";?>>Vegetarian</option>
                      <option value="2" <?php if($itemDetails->item_type=="Vegan")echo "selected";?>>Vegan</option>
                    </select>
                 
                  </div>
                  
                </div>
                <div class="form-group row">
                    <div class="col-sm-6 mb-3 mb-sm-0">
                        <label>Sub Categories:</label>
                        <?php foreach($subCat as $sub): ?>
                            <?php 
                                foreach($subCategories as $miCat){
                                    if($miCat->sub_cat_id==$sub){
                                        echo '<input type="text" name="sub_cadt[]" value="'.$miCat->sub_category_name.'"  class="form-control" readonly>';
                                        echo '<input type="hidden" name="sub_cat[]" value="'.$miCat->sub_cat_id.'"  class="form-control" readonly>';
                                    }
                                }
                            ?>
                            
                        <?php endforeach;?>
                    </div>
                    <div class="col-sm-6 mb-3 mb-sm-0">
                        <label>Price:</label>
                        <?php foreach($subCatPrice as $price): ?>
                            <input type="text" name="price[]" value="<?=$price?>" class="form-control checkit" >
                        <?php endforeach;?>
                    </div>
                  
                  
                </div>
                <div class="form-group row">
                  
                  <div class="col-sm-12">
                    <label>Item Allergens</label>
                    <input class="form-control form-control-user"   name="item_allergens" value="<?=$itemDetails->item_allergens?>">
                    
                  </div>
                </div>
                <div class="form-group row">
                  
                  <div class="col-sm-12">
                    <label>Item Description</label>
                    <textarea class="form-control form-control-user"  rows="5" name="item_desc"><?=$itemDetails->item_desc?></textarea>
                    
                  </div>
                </div>
                <!-- <div class="form-group row">
                  
                  <div class="col-sm-12">
                    <label>Company Description</label>
                    <textarea class="form-control form-control-user"  rows="5" name="comp_desc"></textarea>
                    
                  </div>
                </div>

                <div class="form-group row">
                  
                  <div class="col-sm-12">
                    <label>Company Address</label>
                    <input type="text" class="form-control form-control-user" id="exampleRepeatPassword" placeholder="Company Address" name="comp_address" value="">
                  </div>
                </div>
                <div class="form-group row">
                  
                  <div class="col-sm-12">
                    <label>Company Registratio Number</label>
                    <input type="text" class="form-control form-control-user" id="exampleRepeatPassword" placeholder="Company Address" name="comp_reg" value="">
                  </div>
                </div> -->
                <input type="submit"  value="Update Data" class="btn btn-primary btn-user btn-block">
       
              
              </form>
              <hr>
              
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
  <script>
       $(document).on('submit','#updateItemDetails',function(e){
            e.preventDefault();
            var formData= new FormData($(this)[0]);
            $.ajax({
              url:"<?=base_url('API/updateItemDetails')?>",
              type:"post",
              processData:false,
              cache:false,
              contentType:false,
              enctype:"multipart/form-data",
              data:formData,
              success:function(response){
                
                response=JSON.parse(response);
                if(response.status==1){
                  swal("Great..","Data Updated Successfully.","success");
                }else{
                  swal("Ooops..","Something went wrong","error");
                }
                setInterval(function(){
                  location.reload();
                },1500);
              }
            })
        });
        $(document).on('submit','#updateItemImage',function(e){
            e.preventDefault();
            var formData= new FormData($(this)[0]);
            $.ajax({
              url:"<?=base_url('API/updateItemImage')?>",
              type:"post",
              processData:false,
              cache:false,
              contentType:false,
              enctype:"multipart/form-data",
              data:formData,
              success:function(response){
                
                response=JSON.parse(response);
                if(response.status==1){
                  swal("Great..","Image Updated Successfully.","success");
                }else{
                  swal("Ooops..","Something went wrong","error");
                }
                setInterval(function(){
                  location.reload();
                },1500);
              }
            })
        });
  </script>
                 <script>
                 $(document).on('click','.deleter',function(){
                     var menu_id=$(this).attr("menu_id");
                     if(confirm("Are you sure to delete this image?")){
                         $.ajax({
                             type:'POST',
                             data:{
                                 menu_id:menu_id
                             },
                             url:'<?=base_url('API/deleteItemImage')?>',
                             success:function(response){
                                 var response = JSON.parse(response);
                                 if(response.status=="1"){
                                     swal('Success','Image Deleted Successfully','success');
                                     location.reload();
                                 }
                                 else{
                                     swal('OOPS','SOMETHING WENT WRONG','error');
                                 }
                             }
                         })
                     }
                 })
             </script>
