<script>
    function initialize() {
        var options = {
        componentRestrictions: {country: [<?= $countries?>]}
    };

    var input = document.getElementById('get_address');
    var autocomplete = new google.maps.places.Autocomplete(input, options);
    }
    google.maps.event.addDomListener(window, 'load', initialize);
</script>
  
    <?php
        function percentToHex($p){
            $percent = max(0, min(100, $p)); // bound percent from 0 to 100
            $intValue = round($p / 100 * 255); // map percent to nearest integer (0 - 255)
            $hexValue = dechex($intValue); // get hexadecimal representation
            return str_pad($hexValue, 2, '0', STR_PAD_LEFT); // format with leading 0 and upper case characters
        }
    ?>
    
    <!-- modify by Jfrost -->

	<div id="map" hidden></div>
    <div class="row container mx-auto" id="j-menu-section" data-rest-slug = "<?= $rest_url_slug?>" data-menu-mode = "<?= $menu_mode?>">
        <div class="main-wrap col-md-8 p-0 pb-sm-5 mx-auto">
            <section class="my-5">
                <div class="d-flex justify-content-between">
                    <span><h3><?=$this->lang->line("Enter your Address")?></h3></span>
                    <div class="">
                        <ul class="lang-setting d-flex align-items-center">
                            <!-- Nav Item - User Information -->
                            <li class="nav-item dropdown no-arrow">
                                <a class="nav-link p-1 nav-icon-j" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <!-- modify by Jfrost rest-->
                                    <?php
                                        if ($site_lang == "english"){?>
                                            <img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/en-flag.png')?>">
                                            <?php 
                                        }elseif ($site_lang == "germany"){?>
                                            <img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/ge-flag.png')?>">
                                            <?php 
                                        }else{?>
                                            <img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/fr-flag.png')?>">
                                        <?php }
                                    ?>
                                    <!-- ------------------ -->
                                </a>
                                <!-- Dropdown - User Information -->
                                <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                    <a class="dropdown-item french-flag" onclick = "change_language('<?= base_url('api/change_lang') ?>','french')">
                                        <img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/fr-flag.png')?>">
                                        French
                                    </a>
                                    <div class="dropdown-divider french-flag"></div>
                                    <a class="dropdown-item germany-flag" onclick = "change_language('<?= base_url('api/change_lang') ?>','germany')">
                                        <img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/ge-flag.png')?>">
                                        Germany
                                    </a>
                                    <div class="dropdown-divider germany-flag"></div>
                                    <a class="dropdown-item english-flag" onclick = "change_language('<?= base_url('api/change_lang') ?>','english')">
                                        <img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/en-flag.png')?>">
                                        English
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </section>
            <!-- ------------------- -->
            
            <div class="tab-content pb-5">
                <div class="text-center p-4 row">
                    <div class="col-md-12">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text text-success" style="width: 38px;"><i class="fa fa-map-marker text-success"></i></span>
                            </div>
                            <input type="text" class="form-control form-control-user" id="get_address" d-lat = "-49.8153" d-long = "6.1296" placeholder='<?= $this->lang->line("Enter your Address") ?>' name="get_address">
                            
                            <div class="input-group-append">
                                <span id="get_info" class="btn btn-primary btn-user btn-block" onclick = "save_postcode()" data-url="<?= base_url("/")?>">Save</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!-- modify by Jfrost rest-->
<script src="<?=base_url('assets/additional_assets/')?>js/myscript.js"></script>
<!-- ---------------- -->
</body>
</html>