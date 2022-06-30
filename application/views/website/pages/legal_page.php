<div id="wrapper">
    <?php
        $page_content = "";
        if ($page_slug == "data-protection"){
            $page_slug = "data_protection";
            $page_title = $this->lang->line("Data Protection");
        }else if ($page_slug == "terms-conditions"){
            $page_slug = "tc";
            $page_title = $this->lang->line("Terms and Conditions");
        }else if ($page_slug == "imprint"){
            $page_title = $this->lang->line("Imprint");
        }
        if (isset($legal_contents)){
            $field_name = $page_slug . "_page_content_" . $site_lang;
            if (isset($legal_contents->$field_name)){
                if (trim($legal_contents->$field_name) == ""){
                    $pure_field_name = $page_slug . "_page_content";
                    $page_content = $legal_contents->$pure_field_name;
                }else{
                    $page_content = $legal_contents->$field_name;
                }
            }
        }else if (isset($standard_legal_page_settings)){
            $field_name = $page_slug . "_page_content_" . $site_lang;
            if (isset($standard_legal_page_settings->$field_name)){
                if (trim($standard_legal_page_settings->$field_name) == ""){
                    $pure_field_name = $page_slug . "_page_content";
                    $page_content = $standard_legal_page_settings->$pure_field_name;
                }else{
                    $page_content = $standard_legal_page_settings->$field_name;
                }
            }
        }
    ?>
    <div class="container py-5 legal_page">
        <section class="legal_content">
            <h3 class="mb-5"><?=$page_title?></h3>
            <?=  $page_content?>
        </section>
    </div>
</div>

