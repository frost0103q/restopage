    <!-- modify by Jfrost -->

    <div class="row container mx-auto">
        <div class="main-wrap col-md-6 p-0 pb-sm-5 mx-auto">
            <section class="my-5">
                <div class="d-flex justify-content-center">
                    <span class="text-center j-blue-color text-uppercase"><h3><?=$this->lang->line("Table Reservation")?></h3></span>
                    
                </div>
            </section>
            <!-- ------------------- -->
            <form id="reservationTable" class="card">
                <!-- <div class="card-body bg-dark">
                    <div class="row">
                        <div class="py-2 col-md-4">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-users"> <b class="text-danger">*</b>  </i></span>
                                </div>
                                <input type="number" name="number_of" id = "number_of" class="form-control" placeholder="<?= $this->lang->line('Number of people')?>" min="1" value="1">
                            </div>
                        </div>
                        <div class="py-2 col-md-4">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-calendar"> <b class="text-danger">*</b> </i></span>
                                </div>
                                <input type="text" name="reservation_date" id = "reservation_date" class="form-control datepickers" placeholder="<?= $this->lang->line('Date')?>" autocomplete="off">
                            </div>
                        </div>
                        <div class="py-2 col-md-4">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-clock-o"> <b class="text-danger">*</b> </i></span>
                                </div>
                                <input type="text" name="reservation_time" name="reservation_time" class="form-control timepickers" placeholder="<?= $this->lang->line('Time')?>" autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="py-2 col-md-6">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-user-circle"></i></span>
                                </div>
                                <input type="text" name="first_name" id = "first_name" class="form-control" placeholder="<?= $this->lang->line('First Name')?>">
                            </div>
                        </div>
                        <div class="py-2 col-md-6">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-user-circle"></i></span>
                                </div>
                                <input type="text" name="last_name" id = "last_name" class="form-control" placeholder="<?= $this->lang->line('Last Name')?>">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="py-2 col-md-12">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                </div>
                                <input type="text" name="phone" id = "phone" class="form-control" placeholder="<?= $this->lang->line('Telephone')?>">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="py-2 col-md-12">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-envelope"><b class="text-danger">*</b></i></span>
                                </div>
                                <input type="email" name="email" id = "email" class="form-control" placeholder="<?= $this->lang->line('Email')?>">
                            </div>
                        </div>
                        <div class="py-2 pb-5 col-md-12">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                </div>
                                <textarea name="remark" id = "remark" class="form-control" placeholder="Insert Text."></textarea>
                            </div>
                        </div>
                        <div class="py-2 col-md-12 text-center">
                            <input type="hidden" name="rest_id" id = "rest_id" value="<?= $myRestId?>">
                            <input type="submit" name="reservation_submit" id = "reservation_submit" class="btn j-blue-bg" value="<?= $this->lang->line('Reservation')?>">
                        </div>
                    </div>
                </div> -->
                <div class="accordion p-2 p-md-4" id="reservation_setting">
                    <div class="wrapper">
                        <div class="card border mb-2">
                            <div class="card-header" id="headingOne"  data-toggle="collapse" data-target="#guest_number_section">
                                <span class="fa fa-group section_icon"></span>
                                <div class="mb-0">
                                    <span class="guest_number_label">3</span> People
                                </div>
                            </div>
                            <div id="guest_number_section" class="collapse" aria-labelledby="headingOne" data-parent="#reservation_setting">
                                <input type="hidden" name="number_of" id = "number_of" min="1" value="3">
                                <div class="card-body">
                                    <div class="choose_guest_number_btn_list">
                                        <span class="choose_guest_number_btn" data-number="1">1</span>
                                        <span class="choose_guest_number_btn" data-number="2">2</span>
                                        <span class="choose_guest_number_btn selected-option" data-number="3">3</span>
                                        <span class="choose_guest_number_btn" data-number="4">4</span>
                                        <span class="choose_guest_number_btn" data-number="5">5</span>
                                    </div>
                                    <div class="justify-content-center d-flex custom_enter_symbol">
                                        <span class="fa fa-user-plus"></span>
                                    </div>
                                    <div class="choose_custom_guest_number_section hide-field">
                                        <span class="increase_custom_guest_number btn fa fa-plus"></span>
                                        <input type="number" class="custom_guest_number form-control mx-2" min='1' max='10' value="6">
                                        <span class="decrease_custom_guest_number btn fa fa-minus"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card border mb-2">
                            <div class="card-header" id="headingTwo"  data-toggle="collapse" data-target="#date_section">
                                <span class="fa fa-calendar section_icon"></span>
                                <div class="mb-0">
                                    <span class="reservation_date_label"></span> 
                                </div>
                            </div>
                            <div id="date_section" class="collapse" aria-labelledby="headingTwo" data-parent="#reservation_setting">
                                <input type="hidden" name="reservation_date" id = "reservation_date" class="form-control" placeholder="<?= $this->lang->line('Date')?>" autocomplete="off">
                                <div class="card-body">
                                    <div class="reservation_date_inner_side">
                                        <div id="reservation_date_wrap"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card border mb-2">
                            <div class="card-header" id="headingThree"  data-toggle="collapse" data-target="#time_section">
                                <span class="fa fa-clock section_icon"></span>
                                <div class="mb-0">
                                    <span class="reservation_time_label">Time</span> 
                                </div>
                            </div>
                            <div id="time_section" class="collapse" aria-labelledby="headingThree" data-parent="#reservation_setting">
                                <input type="hidden" name="reservation_time" id = "reservation_time" class="form-control" placeholder="<?= $this->lang->line('Date')?>" autocomplete="off">
                                <div class="card-body">
                                    <div class="reservation_time_inner_side">
                                        <div id="reservation_time_wrap"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
            
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $(".timepickers").timepicker();
            $(".datepickers").datepicker();
        });


        mobiscroll.setOptions({
            locale: mobiscroll.localeEn,  // Specify language like: locale: mobiscroll.localePl or omit setting to use default
            theme: 'ios',                 // Specify theme like: theme: 'ios' or omit setting to use default
                themeVariant: 'light'     // More info about themeVariant: https://docs.mobiscroll.com/5-7-2/calendar#opt-themeVariant
        });
        
        $(function () {
            // Mobiscroll Calendar initialization
            $('#reservation_date_wrap').mobiscroll().datepicker({
                controls: ['calendar'],   // More info about controls: https://docs.mobiscroll.com/5-7-2/calendar#opt-controls
                display: 'inline',         // Specify display mode like: display: 'bottom' or omit setting to use default
                touchUi: true,
                renderCalendarHeader: function () {
                    return '<div class="d-flex justify-content-center margin-auto w-100 mb-3"><div mbsc-calendar-prev class="custom-prev"></div>' +
                            '<div mbsc-calendar-nav class="custom-nav"></div>' +
                            '<div mbsc-calendar-next class="custom-next"></div></div>';
                },
                min: '2000-01-01T12:00',
                invalid: [
                    {
                        start: '2000-01-01',
                        end: '<?=date("Y-m-d", strtotime('-1 days'))?>'
                    }
                ],
                onChange: function (event, inst) {
                    if (event.valueText !== ""){
                        $(".reservation_date_label").html(event.valueText);
                        $("#reservation_date").val(event.valueText);
                    }
                },
                onInit: function (event, inst) {
                    var today = '<?=date("m/d/Y")?>';
                    $(".reservation_date_label").html(today);
                    $("#reservation_date").val(today);

                },
            });
        });
    </script>