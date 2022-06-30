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
        <!-- Begin Page Content -->
        <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800"><?= $this->lang->line("Add Menu Item")?></h1>
        <?php 
            // print_r($jobApplications);
        ?>
        <div class="row">

            <div class="col-md-12 ">
            <?php
                if($this->session->flashdata('msg')){
                echo '<div class="alert alert-info">'.$this->session->flashdata('msg').'</div>';
                }
            ?>
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Add Item</h6>
                </div>
                <div class="card-body">
                <form action="<?=base_url('Admin/addMenuItem')?>" method="post" enctype="multipart/form-data">
                    <div class="form-group row">
                    <div class="col-sm-3 mb-3 mb-sm-0">
                        <select class="form-control" name="rest_id" >
                        <option value="0">Select Restaurant</option>
                        <?php foreach($addRest as $rest): ?>
                            <option value="<?=$rest->rest_id?>"><?=$rest->rest_name?></option>
                        <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-sm-3 mb-3 mb-sm-0">
                        <select class="form-control" id="category_id" name="category_id">
                        <option value="0">Select Category</option>
                        <?php foreach($Categories as $cat): ?>
                            <option value="<?=$cat->category_id?>"><?=$cat->category_name?></option>
                        <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-sm-3 mb-3 mb-sm-0">
                        <input type="file" name="item_image"  >
                    </div>
                    <div class="col-sm-3 mb-3 mb-sm-0">
                        <input type="text" name="item_name" class="form-control" placeholder="Item Name">
                    </div>
                    
                    </div>
                    
                    <!--<div class="form-group row">-->
                    <!--  <div class="col-md-8">-->
                    <!--    <input type="text" name="item_desc" placeholder="Item Description" class="form-control">-->
                    <!--  </div>-->
                    <!--  <div class="col-md-4">-->
                    <!--      <select class="form-control" name="item_type">-->
                    <!--          <option value="3">Select Type</option>-->
                    <!--          <option value="1">Veg</option>-->
                    <!--          <option value="2">Non-Veg</option>-->
                    <!--      </select>-->
                        
                    <!--  </div>-->
                    <!--</div>-->
                    
                    <div class="form-group row" id="sub_itme">
                    
                    
                    </div>
                    <div class="form-group row">
                    <div class="col-md-8">
                        <input type="text" name="item_allergens" placeholder="Item Allergens" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                        <select class="form-control" name="item_type" required>
                            <option value="3">Non Veg</option>
                            <option value="1">Vegetarian</option>
                            <option value="2">Vegan</option>
                        </select>
                        
                    </div>
                    </div>
                    <div class="form-group row">
                    <div class="col-md-12">
                        <textarea class="form-control" name="item_desc" required></textarea>
                        
                    </div>
                    
                    </div>
                    <div class="form-group row">
                    <div class="col-sm-4 offset-md-4 mb-3 mb-sm-0">
                        <input type="submit" name="" value="Add Item To Menu" id="adNewIte" class="btn btn-danger btn-user btn-block" disabled>
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
5                </div>
                <div class="col-sm-5">
                    <select class="form-control" id="rest_id_">
                        <option value="0">Select Restaurant</option>
                        <?php foreach($addRest as $rest): ?>
                            <option value="<?=$rest->rest_id?>"><?=$rest->rest_name?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            
            
            </div>


            <?php 
        // print_r($Categories)
            ?>
            <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <tbody id="menuList">
                </tbody>
                </table>
            </div>
            </div>
        </div>

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- End of Main Content -->
<script type="text/javascript">
$(document).on('change','#category_id',function(){
    var category_id=$(this).val();
    $.ajax({
    url:"<?=base_url('API/getAllSubCategory')?>",
    type:"post",
    data:{category_id:category_id},
    success:function(response){
        
        response=JSON.parse(response);
        if(response.data.length>0){
        $('#sub_itme').empty();
        for(let i=0; i<response.data.length; i++){
            // console.log(response.data[i]);
            var subCat='';
            subCat+=''+
                        '<div class="col-sm-4 mb-3 mb-sm-0">'+
                        '<label>'+response.data[i].sub_category_name+'</label><input type="hidden" name="subcat[]" value="'+response.data[i].sub_cat_id+'" class="form-control" placeholder="Price">'+
                        '</div>'+
                        '<div class="col-sm-8 mb-3 mb-sm-0">'+
                        '<input type="text" name="rate[]" class="form-control checkit" placeholder="Price">'+
                        '</div>';
                    
                    $('#sub_itme').append(subCat);
        }
        $('#adNewIte').attr('disabled',false);
        }
        
                    
    }
    });
});
$(document).on('change','#rest_id_',function(){
    var rest_id=$(this).val();
    var lang="french";
    $.ajax({
    url:"<?=base_url('API/getAllMenuItem')?>",
    type:"post",
    data:{rest_id:rest_id,lang:lang},
    success:function(response){
        
        response=JSON.parse(response);
        if(response.data.length>0){
        $('#menuList').empty();
        for(let i=0; i<response.data.length; i++){
            var base_url="<?=base_url('Admin/editMenu/')?>";
            // console.log(response.data[i]);
            var categor='<tr>'+
                    '<td colspan="4" class="text-center bg-danger text-white">'+response.data[i].cate_name+
                    
                    '</td>'+
                    '</tr>';
            $('#menuList').append(categor);
            var subCategories=response.data[i].sub_categories;
            var td='';
            for(let j=0; j<subCategories.length; j++){
            
            td+='<td class="text-center"><strong>'+subCategories[j].sub_category_name+'</strong></td>';
            }
            var subCategory='<tr>'+
                    // '<td></td>'+
                    '<td class="text-center"><strong>Item Name</strong></td>'+
                    '<td colspan="1" class="text-center">'+
                        '<table class="text-center" width="100%">'+
                            '<tr class="text-center">'+td
                            
                            '</tr>'+
                        '</table>'+
                    '</td>'+
                    '</tr>';
            $('#menuList').append(subCategory);
            var items=response.data[i].items;
            
            
            var item='';
            for(let k=0; k<items.length; k++){
            var itemPrice=response.data[i].items[k].item_price;
            var pricetd='';
                for(let l=0; l<itemPrice.length; l++){
                    pricetd+='<td class="text-center"> &#8364; '+itemPrice[l]+'</td>';
                }
            item+='<tr>'+
                    // '<td class="text-center">'+(i+1)+'</td>'+
                    '<td class="text-center">'+items[k].item_detail.item_name+'</td>'+
                    '<td class="text-center">'+
                        '<table width="100%">'+
                            '<tr class="text-center">'+
                            pricetd+
                            '</tr>'+
                        '</table>'+
                    '</td>'+
                    '<td class="text-center">'+
                        '<a href="'+base_url+items[k].item_detail.menu_id+'" class="btn btn-success"><i class="fas fa-eye"></i></a> '+
                        '<a href="javascript:void(0)" class="btn btn-danger deleteMenu" d-item-id="'+items[k].item_detail.menu_id+'"><i class="fas fa-trash"></i></a>'+
                    '</td>'+
                    '</tr>';
            }
            $('#menuList').append(item);
            
        }
        }
        
                    
    }
    });
});
$(document).on('click','.deleteMenu',function(){
    var menuId=$(this).attr('d-item-id');
    var element=$(this);
    console.log("Menu Id: "+menuId);
    $.ajax({
        url:"<?=base_url('API/removeMenuItem')?>",
        type:"post",
        data:{menuId:menuId},
        success:function(response){
            
            response=JSON.parse(response);
            if(response.status==1){
            swal("Great..","Deleted Successfully.","success");
            element.parent().parent().remove();
            }else{
            swal("Ooops..","Something went wrong","error");
            }
            // setInterval(function(){
            //   location.reload();
            // },1500);
        }
        })
});
</script>