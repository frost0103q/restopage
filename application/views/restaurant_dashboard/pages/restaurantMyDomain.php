
<div class="container">
    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="p-5">
                        <form  id="restDetaila">
                            <input type="hidden" class="form-control form-control-user"   name="rest_id" value="<?=$restDetails->rest_id?>">
                            <input type="hidden" class="form-control form-control-user"   name="what_setting" value="mydomain">
                            <div>
                                <h1 class="h4 text-gray-900 mb-4"><?= $this->lang->line('My Domain')?></h1>
                                <hr>
                            </div>
                            <div class="form-group row my-5">
                                <?php  if ($restDetails->resto_plan == 'pro'){ ?>
                                    <div class="col-sm-6">
                                        <label>My Domain ( without Http:// , Https:// or www)</label>
                                        <input type="text" class="form-control form-control-user"  id ="rest_domain" name="rest_domain" value="<?=$restDetails->rest_domain?>" placeholder="mydomain.com">
                                    </div>
                                <?php } ?>
                                <div class="col-sm-6">
                                    <label>URL</label>
                                    <?php
                                        if ($restDetails->resto_plan == 'pro' && $restDetails->rest_domain !== null  && $restDetails->rest_domain !== ""){
                                            $rest_main_url = $restDetails->rest_domain ."/" ."view/";
                                        }else{
                                            $rest_main_url = base_url("view/").$restDetails->rest_url_slug;
                                        }
                                    ?>
                                    <input type="text" class="form-control form-control-user"  id ="rest_url_slug" name="rest_url_slug" value="<?=$rest_main_url?>" readonly>
                                </div>
                            </div>
                            <input type="submit"  value="<?= $this->lang->line('Update Data')?>" class="btn btn-primary btn-user btn-block">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

