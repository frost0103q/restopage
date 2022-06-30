<div class="container">

    <div class="card o-hidden border-0 shadow-lg my-5">
        <form  id="openingTimeSetting">
            <div class="card-body p-0 opening-hours-setting">
                <input type="hidden" name="rest_id" value="<?= $myRestId?>">
                <!-- Nested Row within Card Body -->
                    
                <div class="row">
                    <div class="col-lg-12">
                        <div class="p-md-5 p-3">
                            <h1 class="h4 text-gray-900 mb-4"><?= $this->lang->line('Opening Hours')?> <?= $rest_open ? '<img src="'.base_url("/").'assets/additional_assets/img/open-1.png" width="30">' : '<img src="'.base_url("/").'assets/additional_assets/img/closed-1.png" width="30">'?></h1>
                            <hr>
                            <table class="form-table form-opening-hours mx-auto w-100">
                                <tbody>
                                    <?php 
                                        if (isset($openingTimes)){
                                            $rest_hours = $openingTimes->opening_hours;
                                            $rest_hours = json_decode($rest_hours);
                                        }
                                        $weekdays = ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'];
                                        foreach ($weekdays as $key => $day) {
                                        
                                    ?>
                                        <tr class="periods-day">
                                            <td class="col-name align-middle" valign="top"><?= $day?></td>
                                            <td class="col-times" colspan="2" valign="top">
                                                <div class="period-container" data-day="<?= $key?>">
                                                    <table class="period-table mx-auto" style="min-width: 90%;">
                                                        <tbody>
                                                            <?php
                                                            if(isset($rest_hours[$key])){
                                                                foreach ($rest_hours[$key] as $rkey => $rvalue) {
                                                                    if (($rvalue->start == "" && $rvalue->end == "") || ($rvalue->start == "00:00" && $rvalue->end == "00:00")){
                                                                        $rstatus = false;
                                                                    }else{
                                                                        $rstatus = true;
                                                                    }
                                                                    ?>
                                                                    <tr class="period" data-id = "<?=$rkey?>">
                                                                        <td class="col-time-start">
                                                                            <input type="text" name="rest-opening-hours[<?= $key?>][start][<?=$rkey?>]" class="timepickers input-time-start form-control" value="<?=$rvalue->start?>" />
                                                                        </td>
                                                                        <td class="col-time-end">
                                                                            <input name="rest-opening-hours[<?= $key?>][end][<?=$rkey?>]" type="text" class="timepickers input-time-end form-control" value="<?=$rvalue->end?>" >
                                                                        </td>
                                                                        
                                                                        <td class="status_label_j closed-j" <?= $rstatus == true ? 'hidden' : "" ?>><img src="<?=base_url("/")."assets/additional_assets/img/"?>closed-1.png" width="90%"></td>
                                                                        <td class="status_label_j open-j" <?= $rstatus == false ? 'hidden' : "" ?>><img src="<?=base_url("/")."assets/additional_assets/img/"?>open-1.png" width="90%"></td>	
                                                                        <td class="col-delete-period">
                                                                            <a class="button delete-period has-icon red">
                                                                                <i class="fa fa-times"></i>
                                                                            </a>
                                                                        </td>
                                                                    </tr>
                                                                <?php }
                                                            }else{?>
                                                            <tr class="period" data-id = "0">
                                                                <td class="col-time-start">
                                                                    <input type="text" name="rest-opening-hours[<?= $key?>][start][0]" class="timepickers input-time-start form-control" value="" />
                                                                </td>
                                                                <td class="col-time-end">
                                                                    <input name="rest-opening-hours[<?= $key?>][end][0]" type="text" class="timepickers input-time-end form-control" value="" placeholder="">
                                                                </td>
                                                                
                                                                <td class="status_label_j closed-j"><img src="<?=base_url("/")."assets/additional_assets/img/"?>closed-1.png" width="90%"></td>
                                                                <td class="status_label_j open-j" hidden="hidden"><img src="<?=base_url("/")."assets/additional_assets/img/"?>open-1.png" width="90%"></td>	
                                                                <td class="col-delete-period">
                                                                    <a class="button delete-period has-icon red">
                                                                        <i class="fa fa-times"></i>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                            <?php }?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </td>
                                            <td class="col-options align-middle" valign="top">
                                                <a class="button add-period green has-icon" data-day="<?= $key?>">
                                                    <i class="fa fa-plus"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php 
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body p-0 pickup-hours-setting">
                <!-- Nested Row within Card Body -->
                    
                <div class="row">
                    <div class="col-lg-12">
                        <div class="p-md-5 p-3">
                            <h1 class="h4 text-gray-900 mb-4"><?= $this->lang->line('Pickup Hours')?> <?= $pickup_open ? '<img src="'.base_url("/").'assets/additional_assets/img/open-1.png" width="30">' : '<img src="'.base_url("/").'assets/additional_assets/img/closed-1.png" width="30">'?></h1>
                            <hr>
                            <table class="form-table form-opening-hours mx-auto w-100">
                                <tbody>
                                    <?php 
                                        if (isset($openingTimes)){
                                            $pickup_hours = $openingTimes->pickup_hours;
                                            $pickup_hours = json_decode($pickup_hours);
                                        }
                                        $weekdays = ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'];
                                        foreach ($weekdays as $key => $day) {
                                        
                                    ?>
                                        <tr class="periods-day">
                                            <td class="col-name align-middle" valign="top"><?= $day?></td>
                                            <td class="col-times" colspan="2" valign="top">
                                                <div class="period-container" data-day="<?= $key?>">
                                                    <table class="period-table mx-auto" style="min-width: 90%;">
                                                        <tbody>
                                                            <?php
                                                            if(isset($pickup_hours[$key])){
                                                                foreach ($pickup_hours[$key] as $pkey => $pvalue) {
                                                                    if (($pvalue->start == "" && $pvalue->end == "") || ($pvalue->start == "00:00" && $pvalue->end == "00:00")){
                                                                        $pstatus = false;
                                                                    }else{
                                                                        $pstatus = true;
                                                                    }
                                                                    ?>
                                                                    <tr class="period" data-id = "<?=$pkey?>">
                                                                        <td class="col-time-start">
                                                                            <input type="text" name="pickup-opening-hours[<?= $key?>][start][<?=$pkey?>]" class="timepickers input-time-start form-control" value="<?=$pvalue->start?>" />
                                                                        </td>
                                                                        <td class="col-time-end">
                                                                            <input name="pickup-opening-hours[<?= $key?>][end][<?=$pkey?>]" type="text" class="timepickers input-time-end form-control" value="<?=$pvalue->end?>" >
                                                                        </td>
                                                                        
                                                                        <td class="status_label_j closed-j" <?= $pstatus == true ? 'hidden' : "" ?>><img src="<?=base_url("/")."assets/additional_assets/img/"?>closed-1.png" width="90%"></td>
                                                                        <td class="status_label_j open-j" <?= $pstatus == false ? 'hidden' : "" ?>><img src="<?=base_url("/")."assets/additional_assets/img/"?>open-1.png" width="90%"></td>	
                                                                        <td class="col-delete-period">
                                                                            <a class="button delete-period has-icon red">
                                                                                <i class="fa fa-times"></i>
                                                                            </a>
                                                                        </td>
                                                                    </tr>
                                                                <?php }
                                                            }else{?>
                                                            <tr class="period" data-id = "0">
                                                                <td class="col-time-start">
                                                                    <input type="text" name="pickup-opening-hours[<?= $key?>][start][0]" class="timepickers input-time-start form-control" value="" />
                                                                </td>
                                                                <td class="col-time-end">
                                                                    <input name="pickup-opening-hours[<?= $key?>][end][0]" type="text" class="timepickers input-time-end form-control" value="" placeholder="">
                                                                </td>
                                                                
                                                                <td class="status_label_j closed-j"><img src="<?=base_url("/")."assets/additional_assets/img/"?>closed-1.png" width="90%"></td>
                                                                <td class="status_label_j open-j" hidden="hidden"><img src="<?=base_url("/")."assets/additional_assets/img/"?>open-1.png" width="90%"></td>	
                                                                <td class="col-delete-period">
                                                                    <a class="button delete-period has-icon red">
                                                                        <i class="fa fa-times"></i>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                            <?php }?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </td>
                                            <td class="col-options align-middle" valign="top">
                                                <a class="button add-period green has-icon" data-day="<?= $key?>">
                                                    <i class="fa fa-plus"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php 
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body p-0 delivery-hours-setting">
                <!-- Nested Row within Card Body -->
                <div class="row">

                    <div class="col-lg-12">
                        <div class="p-md-5 p-3">
                            <h1 class="h4 text-gray-900 mb-4"><?= $this->lang->line('Delivery Hours')?> <?= $delivery_open ? '<img src="'.base_url("/").'assets/additional_assets/img/open-1.png" width="30">' : '<img src="'.base_url("/").'assets/additional_assets/img/closed-1.png" width="30">'?></h1>
                            <hr>
                            <table class="form-table form-opening-hours mx-auto w-100">
                                <tbody>
                                    <?php 
                                        if (isset($openingTimes)){
                                            $delivery_hours = $openingTimes->delivery_hours;
                                            $delivery_hours = json_decode($delivery_hours);
                                        }
                                        $weekdays = ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'];
                                        foreach ($weekdays as $key => $day) {
                                    ?>
                                        <tr class="periods-day">
                                            <td class="col-name align-middle" valign="top"><?= $day?></td>
                                            <td class="col-times" colspan="2" valign="top">
                                                <div class="period-container" data-day="<?= $key?>">
                                                    <table class="period-table mx-auto" style="min-width: 90%;">
                                                        <tbody>
                                                            <?php
                                                            if(isset($delivery_hours[$key])){
                                                                foreach ($delivery_hours[$key] as $dkey => $dvalue) {
                                                                    if (($dvalue->start == "" && $dvalue->end == "") || ($dvalue->start == "00:00" && $dvalue->end == "00:00")){
                                                                        $dstatus = false;
                                                                    }else{
                                                                        $dstatus = true;
                                                                    }
                                                                    ?>
                                                                    <tr class="period"  data-id = "<?=$dkey?>">
                                                                        <td class="col-time-start">
                                                                            <input type="text" name="delivery-opening-hours[<?= $key?>][start][<?=$dkey?>]" class="timepickers input-time-start form-control" value="<?=$dvalue->start?>" />
                                                                        </td>
                                                                        <td class="col-time-end">
                                                                            <input name="delivery-opening-hours[<?= $key?>][end][<?=$dkey?>]" type="text" class="timepickers input-time-end form-control" value="<?=$dvalue->end?>">
                                                                        </td>
                                                                        
                                                                        <td class="status_label_j closed-j" <?= $dstatus == true ? 'hidden' : "" ?>><img src="<?=base_url("/")."assets/additional_assets/img/"?>closed-1.png" width="90%"></td>
                                                                        <td class="status_label_j open-j"  <?= $dstatus == false ? 'hidden' : "" ?>><img src="<?=base_url("/")."assets/additional_assets/img/"?>open-1.png" width="90%"></td>	
                                                                        <td class="col-delete-period">
                                                                            <a class="button delete-period has-icon red">
                                                                                <i class="fa fa-times"></i>
                                                                            </a>
                                                                        </td>
                                                                    </tr>
                                                                <?php }
                                                            }else{?>
                                                            <tr class="period"  data-id = "0">
                                                                <td class="col-time-start">
                                                                    <input type="text" name="delivery-opening-hours[<?= $key?>][start][0]" class="timepickers input-time-start form-control" value="" />
                                                                </td>
                                                                <td class="col-time-end">
                                                                    <input name="delivery-opening-hours[<?= $key?>][end][0]" type="text" class="timepickers input-time-end form-control" value="" placeholder="">
                                                                </td>
                                                                
                                                                <td class="status_label_j closed-j"><img src="<?=base_url("/")."assets/additional_assets/img/"?>closed-1.png" width="90%"></td>
                                                                <td class="status_label_j open-j" hidden="hidden"><img src="<?=base_url("/")."assets/additional_assets/img/"?>open-1.png" width="90%"></td>	
                                                                <td class="col-delete-period">
                                                                    <a class="button delete-period has-icon red">
                                                                        <i class="fa fa-times"></i>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                            <?php }?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </td>
                                            <td class="col-options align-middle" valign="top">
                                                <a class="button add-period green has-icon" data-day="<?= $key?>">
                                                    <i class="fa fa-plus"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php 
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body p-0 holiday-setting">
                <!-- Nested Row within Card Body -->
                <div class="row">

                    <div class="col-lg-12">
                        <div class="p-md-5 p-3">
                            <h1 class="h4 text-gray-900 mb-4"><?= $this->lang->line('Holidays')?></h1>
                            <hr>
                            <table class="op-holidays w-100" id="op-holidays-table">
                                <thead>
                                    <tr>
                                        <th><?= $this->lang->line('Name')?></th>
                                        <th><?= $this->lang->line('Date Start')?></th>
                                        <th><?= $this->lang->line('Date End')?></th>
                                    </tr>
                                </thead>
                                <tbody> 
                                    <?php 
                                        if (isset( $openingTimes)){
                                            $holidays = $openingTimes->holidays;
                                            $holidays = json_decode($holidays);
                                        }
                                        if (isset($holidays->dateStart)){
                                            foreach ($holidays->dateStart as $hkey => $hvalue) {?>
                                                <tr class="op-holiday" data-id = "0">
                                                    <td class="col-name">
                                                        <input type="text" name="opening-hours-holidays[name][]" class="form-control" value="<?= $holidays->name[$hkey]?>">
                                                    </td>
                                                    <td class="col-date-start">
                                                        <input type="text" name="opening-hours-holidays[dateStart][]" class="form-control date-start input-gray datepickers" value="<?= $holidays->dateStart[$hkey]?>" >
                                                    </td>
                                                    <td class="col-date-end">
                                                        <input type="text" name="opening-hours-holidays[dateEnd][]" class="form-control date-end input-gray datepickers" value="<?= $holidays->dateEnd[$hkey]?>" >
                                                    </td>
                                                    <td class="col-remove">
                                                        <span class="btn btn-remove btn-danger remove-holiday has-icon"><i class="fa fa-times"></i></span>
                                                    </td>
                                                </tr>
                                            <?php }
                                        }else{?>
                                            <tr class="op-holiday" data-id = "0">
                                                <td class="col-name">
                                                    <input type="text" name="opening-hours-holidays[name][]" class="form-control" value="">
                                                </td>
                                                <td class="col-date-start">
                                                    <input type="text" name="opening-hours-holidays[dateStart][]" class="form-control date-start input-gray datepickers" value="" >
                                                </td>
                                                <td class="col-date-end">
                                                    <input type="text" name="opening-hours-holidays[dateEnd][]" class="form-control date-end input-gray datepickers" value="" >
                                                </td>
                                                <!-- modify by jfrost -->
                                                <td class="col-remove">
                                                    <span class="btn btn-remove btn-danger remove-holiday has-icon"><i class="fa fa-times"></i></span>
                                                </td>
                                            </tr>
                                        <?php }
                                    ?>
                                </tbody>
                            </table>
                            <span class="btn btn-info mt-3" id="add_new_holiday"><?= $this->lang->line('Add New Holiday')?></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body p-0 irregular-opening-setting">
                <!-- Nested Row within Card Body -->
                <div class="row">

                    <div class="col-lg-12">
                        <div class="p-md-5 p-3">
                            <h1 class="h4 text-gray-900 mb-4"><?= $this->lang->line('Irregular Openings')?></h1>
                            <hr>
                            <table class="op-irregular-openings w-100" id="op-io-table">
                                <thead>
                                    <tr>
                                        <th><?= $this->lang->line('Name')?></th>
                                        <th><?= $this->lang->line('Date')?></th>
                                        <th><?= $this->lang->line('Time Start')?></th>
                                        <th><?= $this->lang->line('Time End')?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        if (isset($openingTimes)) {
                                            $irregular_openings = $openingTimes->irregular_openings;
                                            $irregular_openings = json_decode($irregular_openings);
                                        }
                                        if (isset($irregular_openings->date)){
                                            foreach ($irregular_openings->date as $ikey => $ivalue) {?>
                                                <tr class="op-irregular-opening" data-id = "0">
                                                    <td class="col-name">
                                                        <input type="text" name="opening-hours-irregular-openings[name][]" class="form-control" value="<?= $irregular_openings->name[$ikey]?>">
                                                    </td>
                                                    <td class="col-date">
                                                        <input type="text" name="opening-hours-irregular-openings[date][]" class="form-control date-start input-gray datepickers" value="<?= $irregular_openings->date[$ikey]?>" >
                                                    </td>
                                                    <td class="col-time-start">
                                                        <input type="text" name="opening-hours-irregular-openings[timeStart][]" class="form-control date-end input-gray timepickers" value="<?= $irregular_openings->timeStart[$ikey]?>" >
                                                    </td>
                                                    <td class="col-time-end">
                                                        <input type="text" name="opening-hours-irregular-openings[timeEnd][]" class="form-control date-end input-gray timepickers" value="<?= $irregular_openings->timeEnd[$ikey]?>" >
                                                    </td>
                                                    <td class="col-remove">
                                                        <span class="btn btn-remove btn-danger remove-io has-icon"><i class="fa fa-times"></i></span>
                                                    </td>
                                                </tr>
                                            <?php }
                                        }else{?>
                                            <tr class="op-irregular-opening" data-id = "0">
                                                <td class="col-name">
                                                    <input type="text" name="opening-hours-irregular-openings[name][]" class="form-control" value="">
                                                </td>
                                                <td class="col-date">
                                                    <input type="text" name="opening-hours-irregular-openings[date][]" class="form-control date-start input-gray datepickers" value="" >
                                                </td>
                                                <td class="col-time-start">
                                                    <input type="text" name="opening-hours-irregular-openings[timeStart][]" class="form-control date-end input-gray timepickers" value="" >
                                                </td>
                                                <td class="col-time-end">
                                                    <input type="text" name="opening-hours-irregular-openings[timeEnd][]" class="form-control date-end input-gray timepickers" value="" >
                                                </td>
                                                <td class="col-remove">
                                                    <span class="btn btn-remove btn-danger remove-io has-icon"><i class="fa fa-times"></i></span>
                                                </td>
                                            </tr>
                                        <?php }
                                    ?>
                                </tbody>
                            </table>
                            <span class="btn btn-info mt-3" id="add_new_irregular_opening"><?= $this->lang->line('Add New Irregular Opening')?></span>
                            <input type="submit"  value="<?= $this->lang->line('Update Data')?>" class="btn btn-primary btn-user btn-block mt-5">
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>



