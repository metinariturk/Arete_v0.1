<?php

$site_input1 = array(
    "name" => "harcama_tur",
    "width" => "col-sm-4",
    "tag" => "Şantiye Harcama Türleri",
);
$site_input2 = array(
    "name" => "odeme_tur",
    "width" => "col-sm-4",
    "tag" => "Şantiye Ödeme Türleri",
);
$site_input3 = array(
    "name" => "belge_tur",
    "width" => "col-sm-4",
    "tag" => "Ödeme Belge Türleri",
);
$site_input4 = array(
    "name" => "units",
    "width" => "col-sm-4",
    "tag" => "Birimler",
);

$site_input_rows = array(
    "row1" => array($site_input1, $site_input2, $site_input3, $site_input4)
)
?>

<?php foreach ($site_input_rows as $site_inputs) { ?>
    <div class="card-body">
        <div class="row g-3">
            <?php foreach ($site_inputs as $finance_input) {
                $name = $finance_input["name"];
                $tag = $finance_input["tag"];
                $width = $finance_input["width"]; ?>
                <div class="<?php echo $width; ?>">
                    <label class="form-label" for="validationCustom01"><?php echo $tag; ?></label>
                    <input type="text"
                           class="<?php cms_isset(form_error($name), "is-invalid", ""); ?> form-control"
                           value="<?php echo $item->$name; ?>"
                           name="<?php echo $name; ?>"
                           style="height: 4em !important;"
                           data-role="tagsinput"
                           placeholder="Etiket Ekleyin.."/>
                    <?php if (isset($form_error)) { ?>
                        <div class="invalid-feedback"><?php echo form_error($name); ?></div>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>
    </div>
<?php } ?>
