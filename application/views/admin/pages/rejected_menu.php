
    <!-- Begin Page Content -->
    <div class="container-fluid" id = "rejected_menu" data-url = <?=base_url('/')?>>
        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-gray-800"><?= $this->lang->line('Rejected')?> <?= $this->lang->line('Menu')?></h1>
        <!-- DataTales Example -->
        <div class="row language-panel hide-field">
            <div class="d-flex align-items-center mx-auto">
                <ul class="nav nav-tabs">
                    <li class="active"><a class="<?= $category_lang == 'english' ? 'active' : ''  ?>" href="<?=base_url('Restaurant/Menu/english')?>" data-lang="english"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/en-flag.png')?>"></a></li>
                    <li><a class = "<?= $category_lang == 'french' ? 'active' : ''  ?>" href="<?=base_url('Restaurant/Menu/french')?>" data-lang="french"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/fr-flag.png')?>"></a></li>
                    <li><a class = "<?= $category_lang == 'germany' ? 'active' : ''  ?>" href="<?=base_url('Restaurant/Menu/germany')?>" data-lang="germany"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/ge-flag.png')?>"></a></li>
                </ul>
            </div>
        </div>
        <div class="card shadow col-md-6 my-4">
            <div class="row p-3">
                <select class="form-control" name="rest_id" required id= "rest_id">
                    <option value="0" <?= 0 == $myRestId ? "selected": "" ?> ><?=$this->lang->line("Select Restaurant")?></option>
                    <?php foreach($addRest as $rest): ?>
                        <option value="<?=$rest->rest_id?>" <?= $rest->rest_id == $myRestId ? "selected": "" ?> ><?=$rest->rest_name?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between title-bar">
                <h6 class="m-0 font-weight-bold text-primary"><?= $this->lang->line('Our Menu')?></h6>
                <div class="cattype-bar d-flex align-items-center">
                    <span class="d-flex align-items-center sort-direct-icon mr-4 hide-field" data-sort-direction = "down" onclick = "sortTable(this)"><i class="fas fa-sort-alpha-down" aria-hidden="true"></i></span>
                    <select class="form-control cattype-id">
                        <?php 
                        $th = 0;
                        $types = $this->db->get('tbl_category_type')->result();
                        foreach ($types as $key => $type) { 
                            $th++;
                            $type_field = 'type_title_'.$category_lang;
                            ?>
                            <option value="<?= $type->type_id?>" <?= $th == 1 ? 'selected' : '' ?>><?=$type->$type_field?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>


            <div class="card-body">
                <div class="table-responsive">
                    <table class="table item-menu-table" id="item-menu-table" width="100%" >
                        <tbody id="menuList" data-base-url = "<?= base_url("/")?>"  data-rest-id = "<?=$myRestId?>">
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
    $(document).on('change','#rest_id',function(){    
        url = "<?= base_url("Admin/rejectedMenu/")?>";
        rest_id = $(this).val();
        location.replace(url + rest_id);
    });
    $(document).on('change','.cattype-bar .cattype-id',function(){
        cattype = $(this).val();
        $("tr.our-menu-td").addClass("hide-field");
        $("tr[data-cattype='"+cattype+"']").removeClass("hide-field");
    });
    $(document).ready(function(){
        var rest_id="<?= $myRestId?>";
        lang = $('#rejected_menu .language-panel').find('a.active').attr("data-lang");

        $("."+lang+"-field").removeClass("hide-field");

        $.ajax({
            url:"<?=base_url('API/getAllMenuItem_deactive')?>",
            type:"post",
            data:{rest_id:rest_id,lang:lang},
            success:function(response){
                
                response=JSON.parse(response);
                if(response.data.length>0){
                    $('#menuList').empty();
                    console.log(response.data.length);
                    for(let i=0; i<response.data.length; i++){
                        var base_url="<?=base_url('Admin/editMenu/')?>";
                        is_hide_field =(response.data[i].cattype == 1) ? '' : 'hide-field';
                        var categor='<tr data-cattype = "' + response.data[i].cattype + '" class="'+is_hide_field+' our-menu-td">'+
                                        '<td colspan="6" class="text-center bg-danger  text-white" style="border-radius:25px 25px">'+response.data[i].cate_name+
                                        '</td>'+
                                    '</tr>';
                        $('#menuList').append(categor);
                        
                        var ItmesArray=response.data[i].items;
                        for(m=0; m<ItmesArray.length; m++){
                            
                            menu_row = '<tr data-cattype = "' + response.data[i].cattype + '" class="'+is_hide_field+' our-menu-td">';
                            if(lang == "french"){
                                item_name = ItmesArray[m].item_detail.item_name_french;
                            }else if(lang == "germany"){
                                item_name = ItmesArray[m].item_detail.item_name_germany;
                            }else{
                                item_name = ItmesArray[m].item_detail.item_name_english;
                            }
                            
                            menu_row += '<td class="align-middle text-center">'+ItmesArray[m].item_detail.item_sort_index+'</td>';
                            menu_row += '<td class="align-middle text-center item-name">'+item_name+'</td>';
                            menu_row += '<td class="align-middle text-center"><img class="corner-rounded-img menu-card-item-img" width="100" height = "100" src="<?= base_url('assets/menu_item_images/')?>'+ItmesArray[m].item_detail.item_image +'"></td>';
                            
                            var subCategories=ItmesArray[m].sub_Cat;
                            var sub_cat_td ='<td class="text-center align-middle">';
                            for(let j=0; j<subCategories.length; j++){
                                sub_cat_td +='<span class="mr-4"><strong>'+subCategories[j]+'</strong></span>';
                            }
                            sub_cat_td += "</td>";

                            menu_row += sub_cat_td;
                            var item_price_row = "<td class='align-middle'>";
                            item_price_list  = ItmesArray[m].item_price;
                            item_price_title_list = ItmesArray[m].itemPriceTitle;
                            for (let index = 0; index < item_price_list.length; index++) {
                                const element = item_price_list[index];
                                item_price_row += "<p class='d-flex justify-content-around'><span class='text-center text-primary' style='max-width: 150px'>"+item_price_title_list[index]+"</span><span class=' text-danger text-danger'><strong> &#8364; "+item_price_list[index]+"</strong></span></p>";
                            }
                            item_price_row += "</td>";
                            menu_row += item_price_row;
                            var items=ItmesArray[m];
                            menu_row += '<td class="text-center align-middle">';
                            // menu_row += '<a href="'+base_url+ItmesArray[m].item_detail.menu_id+'" class="btn btn-success"><i class="fas fa-eye"></i></a> ';
                            menu_row += '<a href="javascript:void(0)" class="btn btn-danger deleteMenu ml-1" d-item-id="'+ItmesArray[m].item_detail.menu_id+'"><i class="fas fa-trash"></i></a>';
                            menu_row += '<a href="javascript:void(0)" class="btn btn-primary activateMenu ml-1" d-item-id="'+ItmesArray[m].item_detail.menu_id+'"><i class="fa fa-undo"></i></a>';
                            menu_row += '</td>';
                            menu_row += '</tr>';
                            // --------------------------------------------------
                            
                            $('#menuList').append(menu_row);
                            
                        }
                    }
                }
            }
        });
    });
</script>
