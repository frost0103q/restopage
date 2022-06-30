<?php
    if (isset($social_setting->social_media)){
        $social_media = json_decode($social_setting->social_media);
    }else{
        $seo_titles = null;
    }
?>
<div class="container">
    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-header py-3 d-flex justify-content-between title-bar">
            <h1 class="h4 text-gray-900 mb-0 text-capitalize"><?= $this->lang->line('Restaurant')?> <?= $this->lang->line('social')?> <?= $this->lang->line('Setting')?></h1>
        </div>
        <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="py-5 px-md-5 px-3">
                        <form class="user" id="restaurantSocialSetting">
                            <input type="hidden" name="rest_id" value="<?= $myRestId?>">
                            <section class="social-setting mt-2">
                                <div class="row">
                                    <div class="col-md-6 mb-3 facebook-field">
                                        <label class="text-capitalize">facebook</label>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="input-group mr-md-3 mr-1">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fab fa-facebook"></i></span>
                                                </div>
                                                <input type="text" name="facebook_url" class="form-control" placeholder="https://facebook.com/" value="<?= isset($social_media->facebook->url) ? $social_media->facebook->url : "" ?>">
                                            </div>
                                            <input type="checkbox" class="form-control" data-plugin="switchery" name="facebook_status" value="on" <?= isset($social_media->facebook->status) && $social_media->facebook->status == "on" ? "checked" : "" ?>>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3 twitter-field">
                                        <label class="text-capitalize">twitter</label>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="input-group mr-md-3 mr-1">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fab fa-twitter"></i></span>
                                                </div>
                                                <input type="text" name="twitter_url" class="form-control" placeholder="https://twitter.com/" value="<?= isset($social_media->twitter->url) ? $social_media->twitter->url : "" ?>">
                                            </div>
                                            <input type="checkbox" class="form-control" data-plugin="switchery" name="twitter_status" value="on" <?= isset($social_media->twitter->status) && $social_media->twitter->status == "on" ? "checked" : "" ?>>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3 linkedin-field">
                                        <label class="text-capitalize">linkedin</label>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="input-group mr-md-3 mr-1">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fab fa-linkedin"></i></span>
                                                </div>
                                                <input type="text" name="linkedin_url" class="form-control" placeholder="https://linkedin.com/" value="<?= isset($social_media->linkedin->url) ? $social_media->linkedin->url : "" ?>">
                                            </div>
                                            <input type="checkbox" class="form-control" data-plugin="switchery" name="linkedin_status" value="on" <?= isset($social_media->linkedin->status) && $social_media->linkedin->status == "on" ? "checked" : "" ?>>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3 youtube-field">
                                        <label class="text-capitalize">youtube</label>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="input-group mr-md-3 mr-1">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fab fa-youtube"></i></span>
                                                </div>
                                                <input type="text" name="youtube_url" class="form-control" placeholder="https://youtube.com/" value="<?= isset($social_media->youtube->url) ? $social_media->youtube->url : "" ?>">
                                            </div>
                                            <input type="checkbox" class="form-control" data-plugin="switchery" name="youtube_status" value="on" <?= isset($social_media->youtube->status) && $social_media->youtube->status == "on" ? "checked" : "" ?>>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3 vimeo-field">
                                        <label class="text-capitalize">vimeo</label>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="input-group mr-md-3 mr-1">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fab fa-vimeo"></i></span>
                                                </div>
                                                <input type="text" name="vimeo_url" class="form-control" placeholder="https://vimeo.com/" value="<?= isset($social_media->vimeo->url) ? $social_media->vimeo->url : "" ?>">
                                            </div>
                                            <input type="checkbox" class="form-control" data-plugin="switchery" name="vimeo_status" value="on" <?= isset($social_media->vimeo->status) && $social_media->vimeo->status == "on" ? "checked" : "" ?>>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3 pinterest-field">
                                        <label class="text-capitalize">pinterest</label>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="input-group mr-md-3 mr-1">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fab fa-pinterest"></i></span>
                                                </div>
                                                <input type="text" name="pinterest_url" class="form-control" placeholder="https://pinterest.com/" value="<?= isset($social_media->pinterest->url) ? $social_media->pinterest->url : "" ?>">
                                            </div>
                                            <input type="checkbox" class="form-control" data-plugin="switchery" name="pinterest_status" value="on" <?= isset($social_media->pinterest->status) && $social_media->pinterest->status == "on" ? "checked" : "" ?>>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3 instagram-field">
                                        <label class="text-capitalize">instagram</label>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="input-group mr-md-3 mr-1">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fab fa-instagram"></i></span>
                                                </div>
                                                <input type="text" name="instagram_url" class="form-control" placeholder="https://instagram.com/" value="<?= isset($social_media->instagram->url) ? $social_media->instagram->url : "" ?>">
                                            </div>
                                            <input type="checkbox" class="form-control" data-plugin="switchery" name="instagram_status" value="on" <?= isset($social_media->instagram->status) && $social_media->instagram->status == "on" ? "checked" : "" ?>>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3 reddit-field">
                                        <label class="text-capitalize">reddit</label>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="input-group mr-md-3 mr-1">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fab fa-reddit"></i></span>
                                                </div>
                                                <input type="text" name="reddit_url" class="form-control" placeholder="https://reddit.com/" value="<?= isset($social_media->reddit->url) ? $social_media->reddit->url : "" ?>">
                                            </div>
                                            <input type="checkbox" class="form-control" data-plugin="switchery" name="reddit_status" value="on" <?= isset($social_media->reddit->status) && $social_media->reddit->status == "on" ? "checked" : "" ?>>
                                        </div>
                                    </div>
                                </div>
                            </section>
                            <input type="submit" value="Update Setting" class="btn btn-primary btn-user btn-block mt-4">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

