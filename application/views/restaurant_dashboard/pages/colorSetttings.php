
<div class="container">
    <div class="card o-hidden border-0 shadow-lg my-5">
        <form class="color" id="updateDesignSettings" data-base-url = "<?=base_url()?>">
            <div class="card-body p-0">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="pt-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4"><?= $this->lang->line('WebSite Font')?></h1>
                                <hr>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="p-md-5 p-3">
                            <?php
                                $standard_font_family = "Roboto";
                                $font_settings = json_decode($restDetails->font_settings);
                            ?>
                            <div class="form-group row">
                                <div class="col-sm-12 mb-3 px-sm-5">
                                    <label class="text-capitalize"><?= $this->lang->line('Category')?> <?= $this->lang->line('Name')?> <?= $this->lang->line('font')?> </label>
                                    <div class="row">
                                        <input class="form-control category_name_font_family" type="hidden" value="<?=isset($font_settings->category_name_font_family) ? $font_settings->category_name_font_family : $standard_font_family ?>"  name="category_name_font_family">

                                        <div class="p-0 col-md-7 d-flex align-items-center mt-1">
                                            <div class="input-group input-group-lg">
                                                <select id='selectGFont' data-default='<?=isset($font_settings->category_name_font_family) ? $font_settings->category_name_font_family : $standard_font_family ?>' class="form-control invisible" ></select>
                                                <div class="input-group-append">
                                                    <select id='selectGFontVariante' data-default='regular' class="form-control invisible"></select>
                                                </div>
                                            </div>
                                            <!-- </select> -->
                                        </div>
                                        <div class="ml-auto col-md-4 font-family-selection-test p-2 mt-1 preview" id="category_name_font_family_test" style="font-family:<?=isset($font_settings->category_name_font_family) ? $font_settings->category_name_font_family : $standard_font_family ?>">
                                            AaBbCcDdEeFfGgHhIiJjKkLlMmNnOoPpQqRrSsTtUuVvWwXxYyZz
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-12 mb-3 px-sm-5">
                                    <div class="row">
                                        <input type="submit" value="<?= $this->lang->line('Update Data')?>" class="btn btn-primary btn-user btn-block">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        
            <div class="card-body p-0">
                <input type="hidden" value = "<?=$myRestId?>" name="myRestId">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="pt-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4"><?= $this->lang->line('WebSite Color')?></h1>
                                <hr>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="p-md-5 p-3">
                            <?php
                                $blue_color = "#00a2e6";
                                $orange_color = "#E69D1E";
                                $white_color = "#FFFFFF";

                                $standard_color                         = "#212529";
                                $standard_color_alpha                   = "1";
                                $navigation_bg_color                    = $white_color;
                                $navigation_bg_color_alpha              = "1";
                                $menu_bg_color                          = $blue_color;
                                $menu_bg_color_alpha                    = "1";
                                $menu_color                             = $white_color;
                                $menu_color_alpha                       = "1";
                                $loginbtn_bg_color                      = $blue_color;
                                $loginbtn_bg_color_alpha                = "1";
                                $loginbtn_color                         = $white_color;
                                $loginbtn_color_alpha                   = "1";
                                $slider_color                           = $white_color;
                                $slider_color_alpha                     = "1";
                                $slider_title_color                     = $blue_color;
                                $slider_title_color_alpha               = "1";
                                $slider_bg_color                        = "#19191a";
                                $slider_bg_color_alpha                  = "0.53";
                                $home_view_menubtn_color                = $white_color;
                                $home_view_menubtn_color_alpha          = "1";
                                $home_view_menubtn_bg_color             = $orange_color;
                                $home_view_menubtn_bg_color_alpha       = "1";
                                $home_view_menu_color                   = $white_color;
                                $home_view_menu_color_alpha             = "1";
                                $home_view_menu_bg_color                = $blue_color;
                                $home_view_menu_bg_color_alpha          = "1";
                                $home_view_menu_icon_color              = $white_color;
                                $home_view_menu_icon_color_alpha        = "1";
                                // $home_view_menu_color                   = $white_color;
                                // $home_view_menu_color_alpha             = "1";
                                // $home_view_menubtn_color                = $blue_color;
                                // $home_view_menubtn_color_alpha          = "1";
                                $body_color                             = "#e7f0f9";
                                $body_color_alpha                       = "1";
                                $service_color                          = $white_color;
                                $service_color_alpha                    = "1";
                                $servicebtn_bg_color                    = "#a18126";
                                $servicebtn_bg_color_alpha              = "1";
                                $servicebtn_color                       = $white_color;
                                $servicebtn_color_alpha                 = "1";
                                $footer_bg_color                        = "#1a282f";
                                $footer_bg_color_alpha                  = "1";
                                $footer_heading_color                   = $blue_color;
                                $footer_heading_color_alpha             = "1";
                                $price_color                            = "#C49A39";
                                $price_color_alpha                      = "1";
                                $menu_card_hover_bg_color               = "##EEF7FA";
                                $menu_card_hover_bg_color_alpha         = "1";
                                $blueline_color                         = "#E6E6E6";
                                $blueline_color_alpha                   = "1";
                                $category_bg_color                      = "#C49A39";
                                $category_bg_color_alpha                = "1";
                                $category_color                         = $white_color;
                                $category_color_alpha                   = "1";
                                $tabbtn_bg_color                        = "#000000";
                                $tabbtn_bg_color_alpha                  = "1";
                                $tabbtn_color                           = $white_color;
                                $tabbtn_color_alpha                     = "1";
                                $active_tabbtn_bg_color                 = "#C49A39";
                                $active_tabbtn_bg_color_alpha           = "1";
                                $active_tabbtn_color                    = $white_color;
                                $active_tabbtn_color_alpha              = "1";
                                $wishlist_tab_bg_color                  = "#007BFF";
                                $wishlist_tab_bg_color_alpha            = "0.8";
                                $wishlist_tab_color                     = $white_color;
                                $wishlist_tab_color_alpha               = "1";
                                $food_menu_big_tabs_bg_color            = $blue_color;
                                $food_menu_big_tabs_bg_color_alpha      = "1";
                                $food_menu_big_tabs_color               = $white_color;
                                $food_menu_big_tabs_color_alpha         = "1";
                                $food_menu_heading_color                = $blue_color;
                                $food_menu_heading_color_alpha          = "1";
                                $address_time_color                     = "#8b5b5c";
                                $address_time_color_alpha               = "1";
                                $address_time_bg_color                  = $white_color;
                                $address_time_bg_color_alpha            = "1";
                                $enter_addressbtn_bg_color              = $blue_color;
                                $enter_addressbtn_bg_color_alpha        = "1";
                                $enter_addressbtn_color                 = $white_color;
                                $enter_addressbtn_color_alpha           = "1";
                                $food_color                             = $standard_color;
                                $food_color_alpha                       = "1";
                                $food_description_color                 = $standard_color;
                                $food_description_color_alpha           = "1";
                                $food_info_color                        = $blue_color;
                                $food_info_color_alpha                  = "1";
                                $reservation_page_bg                    = "#343a40";
                                $reservation_page_bg_alpha              = "1";
                                $opening_section_bg                     = "#1A282F";
                                $opening_section_bg_alpha               = "1";
                                $delivery_section_bg                    = "#313E45";
                                $delivery_section_bg_alpha              = "1";
                                $pickup_section_bg                      = "#1A282F";
                                $pickup_section_bg_alpha                = "1";
                                $opening_section_heading_color          = "#FFFDFD";
                                $opening_section_heading_color_alpha    = "1";
                                $opening_section_color                  = $white_color;
                                $opening_section_color_alpha            = "1";
                                $opening_section_today_color            = "#FF1010";
                                $opening_section_today_color_alpha      = "1";
                                $home_service_section_bg                = "#200202";
                                $home_service_section_bg_alpha          = "0.36";

                                $color_settings = json_decode($restDetails->color_settings);
                                
                            ?>
                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 px-sm-5">
                                    <label><?= $this->lang->line('Standard')?> <?= $this->lang->line('Text')?> <?= $this->lang->line('Color')?> </label>
                                    <div class="row">
                                        <input class="form-control col-9" value="<?=isset($color_settings->standard_color) ? $color_settings->standard_color : $standard_color ?>" name="standard_color" data-jscolor="{alphaElement:'#halp1'}">
                                        <input class="form-control col-3" id="halp1" value="<?=isset($color_settings->standard_color_alpha) ? $color_settings->standard_color_alpha : $standard_color_alpha ?>" name="standard_color_alpha">
                                    </div>
                                </div>
                                <div class="col-sm-6 mb-3 px-sm-5">
                                    <label><?= $this->lang->line('Navigation')?> <?= $this->lang->line('Background')?> <?= $this->lang->line('Color')?> </label>
                                    <div class="row">
                                        <input class="form-control col-9" value="<?=isset($color_settings->navigation_bg_color) ? $color_settings->navigation_bg_color : $navigation_bg_color ?>" name="navigation_bg_color" data-jscolor="{alphaElement:'#halp2'}">
                                        <input class="form-control col-3" id="halp2" value="<?=isset($color_settings->navigation_bg_color_alpha) ? $color_settings->navigation_bg_color_alpha : $navigation_bg_color_alpha ?>" name="navigation_bg_color_alpha">
                                    </div>
                                </div>
                                <div class="col-sm-6 mb-3 px-sm-5">
                                    <label><?= $this->lang->line('Menu')?> <?= $this->lang->line('Background')?> <?= $this->lang->line('Color')?> </label>
                                    <div class="row">
                                        <input class="form-control col-9" value="<?=isset($color_settings->menu_bg_color) ? $color_settings->menu_bg_color : $menu_bg_color ?>" name="menu_bg_color" data-jscolor="{alphaElement:'#halp3'}">
                                        <input class="form-control col-3" id="halp3" value="<?=isset($color_settings->menu_bg_color_alpha) ? $color_settings->menu_bg_color_alpha : $menu_bg_color_alpha ?>" name="menu_bg_color_alpha">
                                    </div>
                                </div>
                                <div class="col-sm-6 mb-3 px-sm-5">
                                    <label><?= $this->lang->line('Menu')?> <?= $this->lang->line('Text')?> <?= $this->lang->line('Color')?> </label>
                                    <div class="row">
                                        <input class="form-control col-9" value="<?=isset($color_settings->menu_color) ? $color_settings->menu_color : $menu_color ?>" name="menu_color" data-jscolor="{alphaElement:'#halp4'}">
                                        <input class="form-control col-3" id="halp4" value="<?=isset($color_settings->menu_color_alpha) ? $color_settings->menu_color_alpha : $menu_color_alpha ?>" name="menu_color_alpha">
                                    </div>
                                </div>
                                <div class="col-sm-6 mb-3 px-sm-5">
                                    <label><?= $this->lang->line('Register/Dashboard')?> <?= $this->lang->line('Button')?> <?= $this->lang->line('Background')?> <?= $this->lang->line('Color')?> </label>
                                    <div class="row">
                                        <input class="form-control col-9" value="<?=isset($color_settings->loginbtn_bg_color) ? $color_settings->loginbtn_bg_color : $loginbtn_bg_color ?>" name="loginbtn_bg_color" data-jscolor="{alphaElement:'#halp5'}">
                                        <input class="form-control col-3" id="halp5" value="<?=isset($color_settings->loginbtn_bg_color_alpha) ? $color_settings->loginbtn_bg_color_alpha : $loginbtn_bg_color_alpha ?>" name="loginbtn_bg_color_alpha">
                                    </div>
                                </div>
                                <div class="col-sm-6 mb-3 px-sm-5">
                                    <label><?= $this->lang->line('Register/Dashboard')?> <?= $this->lang->line('Button')?> <?= $this->lang->line('Text')?> <?= $this->lang->line('Color')?> </label>
                                    <div class="row">
                                        <input class="form-control col-9" value="<?=isset($color_settings->loginbtn_color) ? $color_settings->loginbtn_color : $loginbtn_color ?>" name="loginbtn_color" data-jscolor="{alphaElement:'#halp6'}">
                                        <input class="form-control col-3" id="halp6" value="<?=isset($color_settings->loginbtn_color_alpha) ? $color_settings->loginbtn_color_alpha : $loginbtn_color_alpha ?>" name="loginbtn_color_alpha">
                                    </div>
                                </div>
                                <div class="col-sm-6 mb-3 px-sm-5">
                                    <label><?= $this->lang->line('Slider')?> <?= $this->lang->line('Title')?> <?= $this->lang->line('Color')?> </label>
                                    <div class="row">
                                        <input class="form-control col-9" value="<?=isset($color_settings->slider_title_color) ? $color_settings->slider_title_color : $slider_title_color ?>" name="slider_title_color" data-jscolor="{alphaElement:'#halp7'}">
                                        <input class="form-control col-3" id="halp7_" value="<?=isset($color_settings->slider_title_color_alpha) ? $color_settings->slider_title_color_alpha : $slider_title_color_alpha ?>" name="slider_title_color_alpha">
                                    </div>
                                </div>
                                <div class="col-sm-6 mb-3 px-sm-5">
                                    <label><?= $this->lang->line('Slider')?> <?= $this->lang->line('Text')?> <?= $this->lang->line('Color')?> </label>
                                    <div class="row">
                                        <input class="form-control col-9" value="<?=isset($color_settings->slider_color) ? $color_settings->slider_color : $slider_color ?>" name="slider_color" data-jscolor="{alphaElement:'#halp7_'}">
                                        <input class="form-control col-3" id="halp7" value="<?=isset($color_settings->slider_color_alpha) ? $color_settings->slider_color_alpha : $slider_color_alpha ?>" name="slider_color_alpha">
                                    </div>
                                </div>
                                <div class="col-sm-6 mb-3 px-sm-5">
                                    <label><?= $this->lang->line('Slider')?> <?= $this->lang->line('Text')?> <?= $this->lang->line('Background')?> <?= $this->lang->line('Color')?></label>
                                    <div class="row">
                                        <input class="form-control col-9" value="<?=isset($color_settings->slider_bg_color) ? $color_settings->slider_bg_color : $slider_bg_color ?>" name="slider_bg_color" data-jscolor="{alphaElement:'#halp8'}">
                                        <input class="form-control col-3" id="halp8" value="<?=isset($color_settings->slider_bg_color_alpha) ? $color_settings->slider_bg_color_alpha : $slider_bg_color_alpha ?>" name="slider_bg_color_alpha">
                                    </div>
                                </div>
                                <div class="col-sm-6 mb-3 px-sm-5">
                                    <label><?= $this->lang->line('Home View Menu')?> <?= $this->lang->line('Section')?> <?= $this->lang->line('Background')?> <?= $this->lang->line('Color')?></label>
                                    <div class="row">
                                        <input class="form-control col-9" value="<?=isset($color_settings->home_view_menu_bg_color) ? $color_settings->home_view_menu_bg_color : $home_view_menu_bg_color ?>" name="home_view_menu_bg_color" data-jscolor="{alphaElement:'#ralp1'}">
                                        <input class="form-control col-3" id="ralp1" value="<?=isset($color_settings->home_view_menu_bg_color_alpha) ? $color_settings->home_view_menu_bg_color_alpha : $home_view_menu_bg_color_alpha ?>" name="home_view_menu_bg_color_alpha">
                                    </div>
                                </div>
                                <div class="col-sm-6 mb-3 px-sm-5">
                                    <label><?= $this->lang->line('Home View Menu')?> <?= $this->lang->line('Section')?> <?= $this->lang->line('Text')?> <?= $this->lang->line('Color')?></label>
                                    <div class="row">
                                        <input class="form-control col-9" value="<?=isset($color_settings->home_view_menu_color) ? $color_settings->home_view_menu_color : $home_view_menu_color ?>" name="home_view_menu_color" data-jscolor="{alphaElement:'#halp9'}">
                                        <input class="form-control col-3" id="halp9" value="<?=isset($color_settings->home_view_menu_color_alpha) ? $color_settings->home_view_menu_color_alpha : $home_view_menu_color_alpha ?>" name="home_view_menu_color_alpha">
                                    </div>
                                </div>
                                <div class="col-sm-6 mb-3 px-sm-5">
                                    <label><?= $this->lang->line('Home View Menu')?> <?= $this->lang->line('Section')?> <?= $this->lang->line('Icon')?> <?= $this->lang->line('Color')?></label>
                                    <div class="row">
                                        <input class="form-control col-9" value="<?=isset($color_settings->home_view_menu_icon_color) ? $color_settings->home_view_menu_icon_color : $home_view_menu_icon_color ?>" name="home_view_menu_icon_color" data-jscolor="{alphaElement:'#ralp2'}">
                                        <input class="form-control col-3" id="ralp2" value="<?=isset($color_settings->home_view_menu_icon_color_alpha) ? $color_settings->home_view_menu_icon_color_alpha : $home_view_menu_icon_color_alpha ?>" name="home_view_menu_icon_color_alpha">
                                    </div>
                                </div>
                                <div class="col-sm-6 mb-3 px-sm-5">
                                    <label><?= $this->lang->line('Home View Menu')?> <?= $this->lang->line('Section')?> <?= $this->lang->line('Button')?> <?= $this->lang->line('Background')?></label>
                                    <div class="row">
                                        <input class="form-control col-9" value="<?=isset($color_settings->home_view_menubtn_bg_color) ? $color_settings->home_view_menubtn_bg_color : $home_view_menubtn_bg_color ?>" name="home_view_menubtn_bg_color" data-jscolor="{alphaElement:'#ralp3'}">
                                        <input class="form-control col-3" id="ralp3" value="<?=isset($color_settings->home_view_menubtn_bg_color_alpha) ? $color_settings->home_view_menubtn_bg_color_alpha : $home_view_menubtn_bg_color_alpha ?>" name="home_view_menubtn_bg_color_alpha">
                                    </div>
                                </div>
                                <div class="col-sm-6 mb-3 px-sm-5">
                                    <label><?= $this->lang->line('Home View Menu')?> <?= $this->lang->line('Section')?> <?= $this->lang->line('Button')?> <?= $this->lang->line('Text')?> <?= $this->lang->line('Color')?></label>
                                    <div class="row">
                                        <input class="form-control col-9" value="<?=isset($color_settings->home_view_menubtn_color) ? $color_settings->home_view_menubtn_color : $home_view_menubtn_color ?>" name="home_view_menubtn_color" data-jscolor="{alphaElement:'#ralp4'}">
                                        <input class="form-control col-3" id="ralp4" value="<?=isset($color_settings->home_view_menubtn_color_alpha) ? $color_settings->home_view_menubtn_color_alpha : $home_view_menubtn_color_alpha ?>" name="home_view_menubtn_color_alpha">
                                    </div>
                                </div>
                                <div class="col-sm-6 mb-3 px-sm-5">
                                    <label><?= $this->lang->line('Body')?> <?= $this->lang->line('Color')?></label>
                                    <div class="row">
                                        <input class="form-control col-9" value="<?=isset($color_settings->body_color) ? $color_settings->body_color : $body_color ?>" name="body_color" data-jscolor="{alphaElement:'#halp11'}">
                                        <input class="form-control col-3" id="halp11" value="<?=isset($color_settings->body_color_alpha) ? $color_settings->body_color_alpha : $body_color_alpha ?>" name="body_color_alpha">
                                    </div>
                                </div>
                                <div class="col-sm-6 mb-3 px-sm-5">
                                    <label><?= $this->lang->line('Service')?> <?= $this->lang->line('Color')?></label>
                                    <div class="row">
                                        <input class="form-control col-9" value="<?=isset($color_settings->service_color) ? $color_settings->service_color : $service_color ?>" name="service_color" data-jscolor="{alphaElement:'#halp12'}">
                                        <input class="form-control col-3" id="halp12" value="<?=isset($color_settings->service_color_alpha) ? $color_settings->service_color_alpha : $service_color_alpha ?>" name="service_color_alpha">
                                    </div>
                                </div>
                                <div class="col-sm-6 mb-3 px-sm-5">
                                    <label><?= $this->lang->line('Service')?> <?= $this->lang->line('Button')?> <?= $this->lang->line('Background')?> <?= $this->lang->line('Color')?></label>
                                    <div class="row">
                                        <input class="form-control col-9" value="<?=isset($color_settings->servicebtn_bg_color) ? $color_settings->servicebtn_bg_color : $servicebtn_bg_color ?>" name="servicebtn_bg_color" data-jscolor="{alphaElement:'#halp13'}">
                                        <input class="form-control col-3" id="halp13" value="<?=isset($color_settings->servicebtn_bg_color_alpha) ? $color_settings->servicebtn_bg_color_alpha : $servicebtn_bg_color_alpha ?>" name="servicebtn_bg_color_alpha">
                                    </div>
                                </div>
                                <div class="col-sm-6 mb-3 px-sm-5">
                                    <label><?= $this->lang->line('Service')?> <?= $this->lang->line('Button')?> <?= $this->lang->line('Text')?> <?= $this->lang->line('Color')?></label>
                                    <div class="row">
                                        <input class="form-control col-9" value="<?=isset($color_settings->servicebtn_color) ? $color_settings->servicebtn_color : $servicebtn_color ?>" name="servicebtn_color" data-jscolor="{alphaElement:'#halp14'}">
                                        <input class="form-control col-3" id="halp14" value="<?=isset($color_settings->servicebtn_color_alpha) ? $color_settings->servicebtn_color_alpha : $servicebtn_color_alpha ?>" name="servicebtn_color_alpha">
                                    </div>
                                </div>
                                <div class="col-sm-6 mb-3 px-sm-5">
                                    <label><?= $this->lang->line('Footer')?> <?= $this->lang->line('Background')?> <?= $this->lang->line('Color')?></label>
                                    <div class="row">
                                        <input class="form-control col-9" value="<?=isset($color_settings->footer_bg_color) ? $color_settings->footer_bg_color : $footer_bg_color ?>" name="footer_bg_color" data-jscolor="{alphaElement:'#halp15'}">
                                        <input class="form-control col-3" id="halp15" value="<?=isset($color_settings->footer_bg_color_alpha) ? $color_settings->footer_bg_color_alpha : $footer_bg_color_alpha ?>" name="footer_bg_color_alpha">
                                    </div>
                                </div>
                                <div class="col-sm-6 mb-3 px-sm-5">
                                    <label><?= $this->lang->line('Footer')?> <?= $this->lang->line('Heading')?> <?= $this->lang->line('Color')?></label>
                                    <div class="row">
                                        <input class="form-control col-9" value="<?=isset($color_settings->footer_heading_color) ? $color_settings->footer_heading_color : $footer_heading_color ?>" name="footer_heading_color" data-jscolor="{alphaElement:'#halp16'}">
                                        <input class="form-control col-3" id="halp16" value="<?=isset($color_settings->footer_heading_color_alpha) ? $color_settings->footer_heading_color_alpha : $footer_heading_color_alpha ?>" name="footer_heading_color_alpha">
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 px-sm-5">
                                    <label><?= $this->lang->line('Price')?> <?= $this->lang->line('Color')?> </label>
                                    <div class="row">
                                        <input class="form-control col-9" value="<?=isset($color_settings->menu_card_hover_bg_color) ? $color_settings->menu_card_hover_bg_color : $menu_card_hover_bg_color ?>" name="menu_card_hover_bg_color" data-jscolor="{alphaElement:'#alp0'}">
                                        <input class="form-control col-3" id="alp0" value="<?=isset($color_settings->menu_card_hover_bg_color_alpha) ? $color_settings->menu_card_hover_bg_color_alpha : $menu_card_hover_bg_color_alpha ?>" name="menu_card_hover_bg_color_alpha">
                                    </div>
                                </div>
                                <div class="col-sm-6 mb-3 px-sm-5">
                                    <label><?= $this->lang->line('Price')?> <?= $this->lang->line('Color')?> </label>
                                    <div class="row">
                                        <input class="form-control col-9" value="<?=isset($color_settings->price_color) ? $color_settings->price_color : $price_color ?>" name="price_color" data-jscolor="{alphaElement:'#alp1'}">
                                        <input class="form-control col-3" id="alp1" value="<?=isset($color_settings->price_color_alpha) ? $color_settings->price_color_alpha : $price_color_alpha ?>" name="price_color_alpha">
                                    </div>
                                </div>

                                <div class="col-sm-6 mb-3 px-sm-5">
                                    <label><?= $this->lang->line('BlueLine')?> <?= $this->lang->line('Background')?> <?= $this->lang->line('Color')?></label>
                                    <div class="row">
                                        <input class="form-control col-9" value="<?=isset($color_settings->blueline_color) ? $color_settings->blueline_color : $blueline_color ?>" name="blueline_color" data-jscolor="{alphaElement:'#alp2'}">
                                        <input class="form-control col-3" id="alp2" value="<?=isset($color_settings->blueline_color_alpha) ? $color_settings->blueline_color_alpha : $blueline_color_alpha ?>" name="blueline_color_alpha">
                                    </div>
                                </div>

                                <div class="col-sm-6 mb-3 px-sm-5">
                                    <label><?= $this->lang->line('Category')?> <?= $this->lang->line('Background')?> <?= $this->lang->line('Color')?></label>
                                    <div class="row">
                                        <input class="form-control col-9" value="<?=isset($color_settings->category_bg_color) ? $color_settings->category_bg_color : $category_bg_color ?>" name="category_bg_color" data-jscolor="{alphaElement:'#alp3'}">
                                        <input class="form-control col-3" id="alp3" value="<?=isset($color_settings->category_bg_color_alpha) ? $color_settings->category_bg_color_alpha : $category_bg_color_alpha ?>" name="category_bg_color_alpha">
                                    </div>
                                </div>
                                
                                <div class="col-sm-6 mb-3 px-sm-5">
                                    <label><?= $this->lang->line('Category')?> <?= $this->lang->line('Color')?></label>
                                    <div class="row">
                                        <input class="form-control col-9" value="<?=isset($color_settings->category_color) ? $color_settings->category_color : $category_color ?>" name="category_color" data-jscolor="{alphaElement:'#alp4'}">
                                        <input class="form-control col-3" id="alp4" value="<?=isset($color_settings->category_color_alpha) ? $color_settings->category_color_alpha : $category_color_alpha ?>" name="category_color_alpha">
                                    </div>
                                </div>
                            
                                <div class="col-sm-6 mb-3 px-sm-5">
                                    <label><?= $this->lang->line('Tab Button')?> <?= $this->lang->line('Background')?> <?= $this->lang->line('Color')?></label>
                                    <div class="row">
                                        <input class="form-control col-9" value="<?=isset($color_settings->tabbtn_bg_color) ? $color_settings->tabbtn_bg_color : $tabbtn_bg_color ?>" name="tabbtn_bg_color" data-jscolor="{alphaElement:'#alp5'}">
                                        <input class="form-control col-3" id="alp5" value="<?=isset($color_settings->tabbtn_bg_color_alpha) ? $color_settings->tabbtn_bg_color_alpha : $tabbtn_bg_color_alpha ?>" name="tabbtn_bg_color_alpha">
                                    </div>
                                </div>
                                <div class="col-sm-6 mb-3 px-sm-5">
                                    <label><?= $this->lang->line('Tab Button')?> <?= $this->lang->line('Color')?></label>
                                    <div class="row">
                                        <input class="form-control col-9" value="<?=isset($color_settings->tabbtn_color) ? $color_settings->tabbtn_color : $tabbtn_color ?>" name="tabbtn_color" data-jscolor="{alphaElement:'#alp6'}">
                                        <input class="form-control col-3" id="alp6" value="<?=isset($color_settings->tabbtn_color_alpha) ? $color_settings->tabbtn_color_alpha : $tabbtn_color_alpha ?>" name="tabbtn_color_alpha">
                                    </div>
                                </div>
                            
                                <div class="col-sm-6 mb-3 px-sm-5">
                                    <label><?= $this->lang->line('Active')?> <?= $this->lang->line('Tab Button')?> <?= $this->lang->line('Background')?> <?= $this->lang->line('Color')?></label>
                                    <div class="row">
                                        <input class="form-control col-9" value="<?=isset($color_settings->active_tabbtn_bg_color) ? $color_settings->active_tabbtn_bg_color : $active_tabbtn_bg_color ?>" name="active_tabbtn_bg_color" data-jscolor="{alphaElement:'#alp7'}">
                                        <input class="form-control col-3" id="alp7" value="<?=isset($color_settings->active_tabbtn_bg_color_alpha) ? $color_settings->active_tabbtn_bg_color_alpha : $active_tabbtn_bg_color_alpha ?>" name="active_tabbtn_bg_color_alpha">
                                    </div>
                                </div>
                                <div class="col-sm-6 mb-3 px-sm-5">
                                    <label><?= $this->lang->line('Active')?> <?= $this->lang->line('Tab Button')?> <?= $this->lang->line('Color')?></label>
                                    <div class="row">
                                        <input class="form-control col-9" value="<?=isset($color_settings->active_tabbtn_color) ? $color_settings->active_tabbtn_color : $active_tabbtn_color ?>" name="active_tabbtn_color" data-jscolor="{alphaElement:'#alp8'}">
                                        <input class="form-control col-3" id="alp8" value="<?=isset($color_settings->active_tabbtn_color_alpha) ? $color_settings->active_tabbtn_color_alpha : $active_tabbtn_color_alpha ?>" name="active_tabbtn_color_alpha">
                                    </div>
                                </div>
                            
                                <div class="col-sm-6 mb-3 px-sm-5">
                                    <label><?= $this->lang->line('Wishlist Button')?> <?= $this->lang->line('Background')?> <?= $this->lang->line('Color')?></label>
                                    <div class="row">
                                        <input class="form-control col-9" value="<?=isset($color_settings->wishlist_tab_bg_color) ? $color_settings->wishlist_tab_bg_color : $wishlist_tab_bg_color ?>" name="wishlist_tab_bg_color" data-jscolor="{alphaElement:'#alp9'}">
                                        <input class="form-control col-3" id="alp9" value="<?=isset($color_settings->wishlist_tab_bg_color_alpha) ? $color_settings->wishlist_tab_bg_color_alpha : $wishlist_tab_bg_color_alpha ?>" name="wishlist_tab_bg_color_alpha">
                                    </div>
                                </div>
                                <div class="col-sm-6 mb-3 px-sm-5">
                                    <label><?= $this->lang->line('Wishlist Button')?> <?= $this->lang->line('Color')?></label>
                                    <div class="row">
                                        <input class="form-control col-9" value="<?=isset($color_settings->wishlist_tab_color) ? $color_settings->wishlist_tab_color : $wishlist_tab_color ?>" name="wishlist_tab_color" data-jscolor="{alphaElement:'#alp10'}">
                                        <input class="form-control col-3" id="alp10" value="<?=isset($color_settings->wishlist_tab_color_alpha) ? $color_settings->wishlist_tab_color_alpha : $wishlist_tab_color_alpha ?>" name="wishlist_tab_color_alpha">
                                    </div>
                                </div>
                                <div class="col-sm-6 mb-3 px-sm-5">
                                    <label><?= $this->lang->line('Food Menu')?> <?= $this->lang->line('Big Tabs')?> <?= $this->lang->line('Background')?> <?= $this->lang->line('Color')?></label>
                                    <div class="row">
                                        <input class="form-control col-9" value="<?=isset($color_settings->food_menu_big_tabs_bg_color) ? $color_settings->food_menu_big_tabs_bg_color : $food_menu_big_tabs_bg_color ?>" name="food_menu_big_tabs_bg_color" data-jscolor="{alphaElement:'#alp11'}">
                                        <input class="form-control col-3" id="alp11" value="<?=isset($color_settings->food_menu_big_tabs_bg_color_alpha) ? $color_settings->food_menu_big_tabs_bg_color_alpha : $food_menu_big_tabs_bg_color_alpha ?>" name="food_menu_big_tabs_bg_color_alpha">
                                    </div>
                                </div>
                                <div class="col-sm-6 mb-3 px-sm-5">
                                    <label><?= $this->lang->line('Food Menu')?> <?= $this->lang->line('Big Tabs')?> <?= $this->lang->line('Text')?> <?= $this->lang->line('Color')?></label>
                                    <div class="row">
                                        <input class="form-control col-9" value="<?=isset($color_settings->food_menu_big_tabs_color) ? $color_settings->food_menu_big_tabs_color : $food_menu_big_tabs_color ?>" name="food_menu_big_tabs_color" data-jscolor="{alphaElement:'#alp12'}">
                                        <input class="form-control col-3" id="alp12" value="<?=isset($color_settings->food_menu_big_tabs_color_alpha) ? $color_settings->food_menu_big_tabs_color_alpha : $food_menu_big_tabs_color_alpha ?>" name="food_menu_big_tabs_color_alpha">
                                    </div>
                                </div>
                                <div class="col-sm-6 mb-3 px-sm-5">
                                    <label><?= $this->lang->line('Food Menu')?> <?= $this->lang->line('Heading')?> <?= $this->lang->line('Color')?></label>
                                    <div class="row">
                                        <input class="form-control col-9" value="<?=isset($color_settings->food_menu_heading_color) ? $color_settings->food_menu_heading_color : $food_menu_heading_color ?>" name="food_menu_heading_color" data-jscolor="{alphaElement:'#alp13'}">
                                        <input class="form-control col-3" id="alp13" value="<?=isset($color_settings->food_menu_heading_color_alpha) ? $color_settings->food_menu_heading_color_alpha : $food_menu_heading_color_alpha ?>" name="food_menu_heading_color_alpha">
                                    </div>
                                </div>
                                <div class="col-sm-6 mb-3 px-sm-5">
                                    <label><?= $this->lang->line('Address/Time')?> <?= $this->lang->line('Color')?></label>
                                    <div class="row">
                                        <input class="form-control col-9" value="<?=isset($color_settings->address_time_color) ? $color_settings->address_time_color : $address_time_color ?>" name="address_time_color" data-jscolor="{alphaElement:'#alp14'}">
                                        <input class="form-control col-3" id="alp14" value="<?=isset($color_settings->address_time_color_alpha) ? $color_settings->address_time_color_alpha : $address_time_color_alpha ?>" name="address_time_color_alpha">
                                    </div>
                                </div>
                                <div class="col-sm-6 mb-3 px-sm-5">
                                    <label><?= $this->lang->line('Address/Time')?> <?= $this->lang->line('Background')?> <?= $this->lang->line('Color')?></label>
                                    <div class="row">
                                        <input class="form-control col-9" value="<?=isset($color_settings->address_time_bg_color) ? $color_settings->address_time_bg_color : $address_time_bg_color ?>" name="address_time_bg_color" data-jscolor="{alphaElement:'#alp15'}">
                                        <input class="form-control col-3" id="alp15" value="<?=isset($color_settings->address_time_bg_color_alpha) ? $color_settings->address_time_bg_color_alpha : $address_time_bg_color_alpha ?>" name="address_time_bg_color_alpha">
                                    </div>
                                </div>
                                <div class="col-sm-6 mb-3 px-sm-5">
                                    <label><?= $this->lang->line('Enter Address')?> <?= $this->lang->line('Button')?> <?= $this->lang->line('Background')?> <?= $this->lang->line('Color')?></label>
                                    <div class="row">
                                        <input class="form-control col-9" value="<?=isset($color_settings->enter_addressbtn_bg_color) ? $color_settings->enter_addressbtn_bg_color : $enter_addressbtn_bg_color ?>" name="enter_addressbtn_bg_color" data-jscolor="{alphaElement:'#alp16'}">
                                        <input class="form-control col-3" id="alp16" value="<?=isset($color_settings->enter_addressbtn_bg_color_alpha) ? $color_settings->enter_addressbtn_bg_color_alpha : $enter_addressbtn_bg_color_alpha ?>" name="enter_addressbtn_bg_color_alpha">
                                    </div>
                                </div>
                                <div class="col-sm-6 mb-3 px-sm-5">
                                    <label><?= $this->lang->line('Enter Address')?> <?= $this->lang->line('Button')?> <?= $this->lang->line('Text')?> <?= $this->lang->line('Color')?></label>
                                    <div class="row">
                                        <input class="form-control col-9" value="<?=isset($color_settings->enter_addressbtn_color) ? $color_settings->enter_addressbtn_color : $enter_addressbtn_color ?>" name="enter_addressbtn_color" data-jscolor="{alphaElement:'#alp17'}">
                                        <input class="form-control col-3" id="alp17" value="<?=isset($color_settings->enter_addressbtn_color_alpha) ? $color_settings->enter_addressbtn_color_alpha : $enter_addressbtn_color_alpha ?>" name="enter_addressbtn_color_alpha">
                                    </div>
                                </div>
                                <div class="col-sm-6 mb-3 px-sm-5">
                                    <label><?= $this->lang->line('Food')?> <?= $this->lang->line('Text')?> <?= $this->lang->line('Color')?></label>
                                    <div class="row">
                                        <input class="form-control col-9" value="<?=isset($color_settings->food_color) ? $color_settings->food_color : $food_color ?>" name="food_color" data-jscolor="{alphaElement:'#alp18'}">
                                        <input class="form-control col-3" id="alp18" value="<?=isset($color_settings->food_color_alpha) ? $color_settings->food_color_alpha : $food_color_alpha ?>" name="food_color_alpha">
                                    </div>
                                </div>
                                <div class="col-sm-6 mb-3 px-sm-5">
                                    <label><?= $this->lang->line('Food')?> <?= $this->lang->line('Description')?> <?= $this->lang->line('Text')?> <?= $this->lang->line('Color')?></label>
                                    <div class="row">
                                        <input class="form-control col-9" value="<?=isset($color_settings->food_description_color) ? $color_settings->food_description_color : $food_description_color ?>" name="food_description_color" data-jscolor="{alphaElement:'#alp19'}">
                                        <input class="form-control col-3" id="alp19" value="<?=isset($color_settings->food_description_color_alpha) ? $color_settings->food_description_color_alpha : $food_description_color_alpha ?>" name="food_description_color_alpha">
                                    </div>
                                </div>
                                <div class="col-sm-6 mb-3 px-sm-5">
                                    <label><?= $this->lang->line('Food')?> <?= $this->lang->line('info')?> <?= $this->lang->line('Text')?> <?= $this->lang->line('Color')?></label>
                                    <div class="row">
                                        <input class="form-control col-9" value="<?=isset($color_settings->food_info_color) ? $color_settings->food_info_color : $food_info_color ?>" name="food_info_color" data-jscolor="{alphaElement:'#alp20'}">
                                        <input class="form-control col-3" id="alp20" value="<?=isset($color_settings->food_info_color_alpha) ? $color_settings->food_info_color_alpha : $food_info_color_alpha ?>" name="food_info_color_alpha">
                                    </div>
                                </div>
                                <div class="col-sm-6 mb-3 px-sm-5">
                                    <label><?= $this->lang->line('Reservation')?> <?= $this->lang->line('Page')?> <?= $this->lang->line('Background')?> <?= $this->lang->line('Color')?></label>
                                    <div class="row">
                                        <input class="form-control col-9" value="<?=isset($color_settings->reservation_page_bg) ? $color_settings->reservation_page_bg : $reservation_page_bg ?>" name="reservation_page_bg" data-jscolor="{alphaElement:'#alp21'}">
                                        <input class="form-control col-3" id="alp21" value="<?=isset($color_settings->reservation_page_bg_alpha) ? $color_settings->reservation_page_bg_alpha : $reservation_page_bg_alpha ?>" name="reservation_page_bg_alpha">
                                    </div>
                                </div>
                            </div>                            
                            <hr>
                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 px-sm-5">
                                    <label><?= $this->lang->line('Opening Hours')?> <?= $this->lang->line('Section')?> <?= $this->lang->line('Background')?> <?= $this->lang->line('Color')?></label>
                                    <div class="row">
                                        <input class="form-control col-9" value="<?=isset($color_settings->opening_section_bg) ? $color_settings->opening_section_bg : $opening_section_bg ?>" name="opening_section_bg" data-jscolor="{alphaElement:'#secp1'}">
                                        <input class="form-control col-3" id="secp1" value="<?=isset($color_settings->opening_section_bg_alpha) ? $color_settings->opening_section_bg_alpha : $opening_section_bg_alpha ?>" name="opening_section_bg_alpha">
                                    </div>
                                </div>
                                <div class="col-sm-6 mb-3 px-sm-5">
                                    <label><?= $this->lang->line('Delivery Hours')?> <?= $this->lang->line('Section')?> <?= $this->lang->line('Background')?> <?= $this->lang->line('Color')?></label>
                                    <div class="row">
                                        <input class="form-control col-9" value="<?=isset($color_settings->delivery_section_bg) ? $color_settings->delivery_section_bg : $delivery_section_bg ?>" name="delivery_section_bg" data-jscolor="{alphaElement:'#secp2'}">
                                        <input class="form-control col-3" id="secp2" value="<?=isset($color_settings->delivery_section_bg_alpha) ? $color_settings->delivery_section_bg_alpha : $delivery_section_bg_alpha ?>" name="delivery_section_bg_alpha">
                                    </div>
                                </div>
                                <div class="col-sm-6 mb-3 px-sm-5">
                                    <label><?= $this->lang->line('Pickup Hours')?> <?= $this->lang->line('Section')?> <?= $this->lang->line('Background')?> <?= $this->lang->line('Color')?></label>
                                    <div class="row">
                                        <input class="form-control col-9" value="<?=isset($color_settings->pickup_section_bg) ? $color_settings->pickup_section_bg : $pickup_section_bg ?>" name="pickup_section_bg" data-jscolor="{alphaElement:'#secp3'}">
                                        <input class="form-control col-3" id="secp3" value="<?=isset($color_settings->pickup_section_bg_alpha) ? $color_settings->pickup_section_bg_alpha : $pickup_section_bg_alpha ?>" name="pickup_section_bg_alpha">
                                    </div>
                                </div>
                                <div class="col-sm-6 mb-3 px-sm-5">
                                    <label><?= $this->lang->line('Opening Hours')?> <?= $this->lang->line('Section')?> <?= $this->lang->line('Color')?></label>
                                    <div class="row">
                                        <input class="form-control col-9" value="<?=isset($color_settings->opening_section_color) ? $color_settings->opening_section_color : $opening_section_color ?>" name="opening_section_color" data-jscolor="{alphaElement:'#secp4'}">
                                        <input class="form-control col-3" id="secp4" value="<?=isset($color_settings->opening_section_color_alpha) ? $color_settings->opening_section_color_alpha : $opening_section_color_alpha ?>" name="opening_section_heading_color_alpha">
                                    </div>
                                </div>
                                <div class="col-sm-6 mb-3 px-sm-5">
                                    <label><?= $this->lang->line('Opening Hours')?> <?= $this->lang->line('Section')?> <?= $this->lang->line('Heading')?> <?= $this->lang->line('Color')?></label>
                                    <div class="row">
                                        <input class="form-control col-9" value="<?=isset($color_settings->opening_section_heading_color) ? $color_settings->opening_section_heading_color : $opening_section_heading_color ?>" name="opening_section_heading_color" data-jscolor="{alphaElement:'#secp5'}">
                                        <input class="form-control col-3" id="secp5" value="<?=isset($color_settings->opening_section_heading_color_alpha) ? $color_settings->opening_section_heading_color_alpha : $opening_section_heading_color_alpha ?>" name="opening_section_heading_color_alpha">
                                    </div>
                                </div>
                                <div class="col-sm-6 mb-3 px-sm-5">
                                    <label><?= $this->lang->line('Opening Hours')?> <?= $this->lang->line('Section')?> <?= $this->lang->line('Today')?> <?= $this->lang->line('Color')?></label>
                                    <div class="row">
                                        <input class="form-control col-9" value="<?=isset($color_settings->opening_section_today_color) ? $color_settings->opening_section_today_color : $opening_section_today_color ?>" name="opening_section_today_color" data-jscolor="{alphaElement:'#secp6'}">
                                        <input class="form-control col-3" id="secp6" value="<?=isset($color_settings->opening_section_today_color_alpha) ? $color_settings->opening_section_today_color_alpha : $opening_section_today_color_alpha ?>" name="opening_section_today_color_alpha">
                                    </div>
                                </div>
                                <div class="col-sm-6 mb-3 px-sm-5">
                                    <label><?= $this->lang->line('Homepage')?> <?= $this->lang->line('Service')?> <?= $this->lang->line('Section')?> <?= $this->lang->line('Background')?> <?= $this->lang->line('Color')?></label>
                                    <div class="row">
                                        <input class="form-control col-9" value="<?=isset($color_settings->home_service_section_bg) ? $color_settings->home_service_section_bg : $home_service_section_bg ?>" name="home_service_section_bg" data-jscolor="{alphaElement:'#secp7'}">
                                        <input class="form-control col-3" id="secp7" value="<?=isset($color_settings->home_service_section_bg_alpha) ? $color_settings->home_service_section_bg_alpha : $home_service_section_bg_alpha ?>" name="home_service_section_bg_alpha">
                                    </div>
                                </div>
                            </div>                            
                            <div class="form-group row">
                                <div class="col-sm-12 mb-3 px-sm-5">
                                    <div class="row">
                                        <input type="submit" value="<?= $this->lang->line('Update Data')?>" class="btn btn-primary btn-user btn-block">
                                    </div>
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
    jQuery(document).ready(function(){

        selectGfont({
            key: 'AIzaSyDlD2NdRw4MDt-jDoTE_Hz3JqNpl154_qo', // Use You-Google-Fonts-API-Key
            containerFonte: '#selectGFont', 
            containerVariante: '#selectGFontVariante',
            sort: 'popularity',
            onSelectFonte: 'sGFselecionado',
            onSelectVariante: 'sGFselecionado'

        }).then( function() {
            console.log('OK');

        }).catch( function(erro) {
            console.error(erro);
            
        });


        // exemplo de utilização
        sGFselecionado = function(fonte, variante, json){
            jQuery(".preview").removeClass('sGFfonte-100 sGFfonte-200 sGFfonte-300 sGFfonte-regular sGFfonte-italic sGFfonte-500 sGFfonte-600 sGFfonte-700 sGFfonte-800 sGFfonte-900 sGFfonte-100italic sGFfonte-200italic sGFfonte-300italic sGFfonte-500italic sGFfonte-600italic sGFfonte-700italic sGFfonte-800italic sGFfonte-900italic')
                .css('font-family', fonte)
                .addClass( 'sGFfonte-'+variante );
            $(".category_name_font_family").val(fonte);
            console.log( 'fonte', fonte );
            console.log( 'variante', variante );
            console.log( 'json', json );

            // salvaFonte(fonte, variante, json);
        };

        // Faz download da fonte com php
        function salvaFonte (fonte, variante, json){
            jQuery.post({
                url: "./downloadFonte.php",
                data: {fonteNome:fonte, fonteVariante:variante ,fonteFile:json.files[variante] }
            });
        };

    });  
</script>
