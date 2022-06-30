
<!-- modify by Jfrost -->

<div class="container mx-auto contact-us">
    <div class="main-wrap p-0 pb-sm-5 mx-auto">
        <section class="my-5">
            <div class="d-flex justify-content-center">
                <span class="text-center j-blue-color"><h3 class="text-uppercase">Contact Us</h3></span>
            </div>
            <?= 0 ? '<p class="alert alert-success hide-field thank-message">Thank you for your message.</p>' : '' ?>
        </section>
        <!-- ------------------- -->
        
        <div class="tab-content pb-5 row">
            <div class="col-md-4">
                <div class="address-bar text-center text-md-left border-right">
                    <h4><?= $this->lang->line("Address")?></h4>
                    <div class="mb-md-5 mb-3">
                        <p class="mb-0"> <?= $myRestDetail->address1?> </p>
                        <p class="mb-0"> <?= $myRestDetail->address2?> </p>
                    </div>
                    <h4><?= $this->lang->line("Phone")?></h4>
                    <div class="">
                        <p class="mb-0"><?= $myRestDetail->rest_contact_no?> </p>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <form id = "contact-us-form">
                    <input type="hidden" name = "rest_id" value=<?=$myRestId?>>
                    <div class="">
                        <label><?= $this->lang->line("Name")?></label>
                        <div class="row">
                            <div class="col-md-6 mt-3">
                                <div class="input-group">
                                    <input type="text" name="first_name" id = "first_name" class="form-control" placeholder="First Name" >
                                </div>
                            </div>
                            <div class="col-md-6 mt-3">
                                <div class="input-group">
                                    <input type="text" name="last_name"  id = "last_name" class="form-control" placeholder="Last Name" >
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4">
                        <label><?= $this->lang->line("Email")?></label>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="input-group">
                                    <input type="email" name="email"  id = "email" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="">
                        <div class="row">
                            <div class="col-md-6 mt-4">
                                <label><?= $this->lang->line("Mobile")?></label>
                                <div class="input-group">
                                    <input type="text" name="mobile" id = "mobile" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6 mt-4">
                                <label><?= $this->lang->line("Phone")?></label>
                                <div class="input-group">
                                    <input type="text" name="phone" id = "phone"  class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4">
                        <label><?= $this->lang->line("Message")?></label>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="input-group">
                                    <textarea name="message" class="form-control" id = "message"  ></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-3">This site is protected by reCAPTCHA and the Google<a href="https://policies.google.com/privacy"> Privacy Policy </a> and <a href="https://policies.google.com/terms"> Terms of Service </a> apply.</div>

                    <input class="btn btn-primary mt-5" type="submit" id="contact-us-btn" value="Contact">
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        grecaptcha.ready(function() {
            grecaptcha.execute('6LcQbNsaAAAAALyY3W-KNEpem4zuRZJOoah3uVTT', {action: 'contact_us'}).then(function(token) {
                $('#contact-us-form').prepend('<input type="hidden" name="g-recaptcha-response" value="' + token + '">');
            });
        });
    });
</script>
<!-- modify by Jfrost rest-->