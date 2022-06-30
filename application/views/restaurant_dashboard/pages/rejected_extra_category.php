
    <!-- Begin Page Content -->
    <div class="container-fluid" id = "rejected_category" data-url = <?=base_url('/')?>>

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800"><?= $this->lang->line('Rejected')?> <?= $this->lang->line('Food Extra')?>  <?= $this->lang->line('Category')?></h1>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary"><?= $this->lang->line('Categories')?></h6>
            </div>


            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th class="text-center"><?= $this->lang->line("S.No")?></th>
                                <th class="text-center">Sort Index</th>
                                <th class="text-center"><?= $this->lang->line("Name")?></th>
                                <th class="text-center"><?= $this->lang->line("Action")?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i=1;?>
                            <?php foreach($Categories as $cat):
                                    $cat_field_name = 'extra_category_name_' . $category_lang;
                                    $categorytitle = trim($cat->$cat_field_name) == "" ? $cat->extra_category_name : $cat->$cat_field_name;
                                ?>
                                <tr>
                                    <td class="text-center"><?=$i?></td>
                                    <td class="text-center"><?= $cat->extra_category_sort_index?></td>
                                    <td class="text-center"><?= $categorytitle?></td>
                                    <td class="text-center">

                                        <a href="javascript:void(0)" title="<?= $this->lang->line("Activate")?> <?= $this->lang->line('Category')?>" class="active_extra_category badge badge-primary p-2" d-cat_id="<?=$cat->extra_category_id?>"><?= $this->lang->line("Activate")?></a>

                                        <a href="javascript:void(0)" title="<?= $this->lang->line('Remove Category')?>" class="remove_extra_category badge badge-danger p-2 " d-cat_id="<?=$cat->extra_category_id?>"><?= $this->lang->line("Remove")?></a>
                                    </td>
                                </tr>
                                <?php $i++ ; ?>
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
