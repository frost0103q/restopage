<style type="text/css">
    @media print
    {
        #printable * { visibility: visible; }
        #printable { position: absolute; top: 40px; left: 30px; }
    }
    #printTable canvas{
        width: 100%;
    }
    #printTable_ canvas{
        width: 100%;
    }
</style>
<script src="https://files.codepedia.info/files/uploads/iScripts/html2canvas.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.qrcode/1.0/jquery.qrcode.min.js"></script>
<div class="container">
    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-5">
<!-- Nested Row within Card Body -->
            <div class="row">
                <div class="col-md-12">
                    <h1 class="h4 text-gray-900 mb-4"><?= $this->lang->line('My QR Code')?></h1>
                    <hr>
                </div>
            </div>

            <h4 class="my-4 text-center j-blue-color">Food Menu</h4>
            <div class="row">
                <div class="col-md-3">
                    <div  id="printTable">
                    </div>
                </div>
                <div class="col-md-6 text-center d-flex flex-column justify-content-around">
                    <div>
                        <input id="btn-Preview-Image" class="btn btn-success my-2" type="button" value="<?= $this->lang->line('Print QR')?>" style="max-width: 200px"/>
                        <a id="btn-Convert-Html2Image" class="btn btn-info  my-2" href="#" style="display:none; max-width: 200px"><?= $this->lang->line('Download')?></a>
                    </div>
                    <a href="<?=base_url('view/').$myRestUrlSlug?>"><?=base_url('view/').$myRestUrlSlug?></a>
                </div>
                <div class="col-md-3  text-center d-flex flex-column justify-content-around align-items-center">
                    <a class="btn btn-info j-blue-bg my-2" href="#" style="min-width: 150px">Buy Stickers</a>
                    <a class="btn btn-info j-blue-bg my-2" href="#" style="min-width: 150px">Buy Tischaufsteller</a>
                </div>
            </div>
            <hr>
            <h4 class="my-4 text-center j-blue-color">Home</h4>
            <div class="row">
                <div class="col-md-3">
                    <div  id="printTable_">
                    </div>
                </div>
                <div class="col-md-6 text-center d-flex flex-column justify-content-around">
                    <div>
                        <input id="btn-Preview-Image_" class="btn btn-success my-2" type="button" value="<?= $this->lang->line('Print QR')?>" style="max-width: 200px"/>
                        <a id="btn-Convert-Html2Image_" class="btn btn-info  my-2" href="#" style="display:none; max-width: 200px"><?= $this->lang->line('Download')?></a>
                    </div>
                    <a href="<?=base_url('main/').$myRestUrlSlug?>"><?=base_url('main/').$myRestUrlSlug?></a>
                </div>
                <div class="col-md-3  text-center d-flex flex-column justify-content-around align-items-center">
                    <a class="btn btn-info j-blue-bg my-2" href="#" style="min-width: 150px">Buy Stickers</a>
                    <a class="btn btn-info j-blue-bg my-2" href="#" style="min-width: 150px">Buy Tischaufsteller</a>
                </div>
            </div>
            <hr>
            <h4 class="my-4 text-center j-blue-color">onTable</h4>
            <div class="row">
                <div class="col-md-3">
                    <div  id="printTable__">
                    </div>
                </div>
                <div class="col-md-6 text-center d-flex flex-column justify-content-around">
                    <div>
                        <input id="btn-Preview-Image__" class="btn btn-success my-2" type="button" value="<?= $this->lang->line('Print QR')?>" style="max-width: 200px"/>
                        <a id="btn-Convert-Html2Image__" class="btn btn-info  my-2" href="#" style="display:none; max-width: 200px"><?= $this->lang->line('Download')?></a>
                    </div>
                    <a href="<?=base_url('main/').$myRestUrlSlug?>"><?=base_url('onTable/').$myRestUrlSlug?></a>
                </div>
                <div class="col-md-3  text-center d-flex flex-column justify-content-around align-items-center">
                    <a class="btn btn-info j-blue-bg my-2" href="#" style="min-width: 150px">Buy Stickers</a>
                    <a class="btn btn-info j-blue-bg my-2" href="#" style="min-width: 150px">Buy Tischaufsteller</a>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">  
    $('#printTable').qrcode({
        text:"<?=base_url('view/').$myRestUrlSlug?>"
    });
    $('#printTable_').qrcode({
        text:"<?=base_url('main/').$myRestUrlSlug?>"
    });
    $('#printTable__').qrcode({
        text:"<?=base_url('onTable/').$myRestUrlSlug?>"
    });

    $(document).ready(function(){
        var element = $("#printTable"); // global variable
        var getCanvas; // global variable
        $("#btn-Preview-Image").on('click', function () {
            html2canvas(element, {
                onrendered: function (canvas) {
                    $("#previewImage").append(canvas);
                    getCanvas = canvas;
                }
            });
            // printData();
            $('#btn-Convert-Html2Image').show();
        });
        $("#btn-Convert-Html2Image").on('click', function () {
            var imgageData = getCanvas.toDataURL("image/png");
            var newData = imgageData.replace(/^data:image\/png/, "data:application/octet-stream");
            $("#btn-Convert-Html2Image").attr("download", "menu_qrcode.png").attr("href", newData);
        });
        // -------------------------------------------------
        var element_ = $("#printTable_"); // global variable
        var getCanvas_; // global variable
        $("#btn-Preview-Image_").on('click', function () {
            html2canvas(element_, {
                onrendered: function (canvas_) {
                    $("#previewImage_").append(canvas_);
                    getCanvas_ = canvas_;
                }
            });
            // printData();
            $('#btn-Convert-Html2Image_').show();
        });
        $("#btn-Convert-Html2Image_").on('click', function () {
            var imgageData_ = getCanvas_.toDataURL("image/png");
            var newData_ = imgageData_.replace(/^data:image\/png/, "data:application/octet-stream");
            $("#btn-Convert-Html2Image_").attr("download", "home_qrcode.png").attr("href", newData_);
        });
        // ----------------------------------------------------
        var element__ = $("#printTable__"); // global variable
        var getCanvas__; // global variable
        $("#btn-Preview-Image__").on('click', function () {
            html2canvas(element__, {
                onrendered: function (canvas__) {
                    $("#previewImage__").append(canvas__);
                    getCanvas__ = canvas__;
                }
            });
            // printData();
            $('#btn-Convert-Html2Image__').show();
        });
        $("#btn-Convert-Html2Image__").on('click', function () {
            var imgageData__ = getCanvas__.toDataURL("image/png");
            var newData__ = imgageData__.replace(/^data:image\/png/, "data:application/octet-stream");
            $("#btn-Convert-Html2Image__").attr("download", "onTable_qrcode.png").attr("href", newData__);
        });
        // ----------------------------------------------------
        function printData(){
            var imgageData = getCanvas.toDataURL("image/png");
            var newData = imgageData.replace(/^data:image\/png/, "data:application/octet-stream");
            $("#btn-Convert-Html2Image").attr("download", "menu_qrcode.png").attr("href", newData);
        }
    });
</script>


