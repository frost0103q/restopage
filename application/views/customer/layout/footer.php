        </div>
        
        <div class="rightbar-overlay"></div>

        <!-- Vendor js -->
        <script src="<?php echo base_url('assets/additional_assets/template/js/vendor.min.js');?>"></script>

        <!-- knob plugin -->
        <script src="<?php echo base_url('assets/additional_assets/template/libs/jquery-knob/jquery.knob.min.js');?>"></script>

        <script src="<?php echo base_url('assets/additional_assets/template/libs/custombox/custombox.min.js');?>"></script>
    
        <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.16/dist/summernote.min.js"></script>
        <script src="<?=base_url('assets/additional_assets/')?>js/chosen.jquery.js"></script>
        <script type="text/javascript" src="<?= base_url('assets/additional_assets/jquery-ui-timepicker').'/jquery.ui.timepicker.js'?>"></script>
        <?php
            if (isset($extra_script)){
                foreach ($extra_script as $key => $value) {
                    echo $value;
                }
            }
        ?>
        <!-- App js -->
        <script src="<?php echo base_url('assets/additional_assets/template/js/app.min.js');?>"></script>
        <!-- My script file -->
        <script src="<?php echo base_url('assets/additional_assets/js/myscript.js');?>"></script>
    </body>
</html>