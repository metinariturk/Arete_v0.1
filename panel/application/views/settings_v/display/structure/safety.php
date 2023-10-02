<?php

$site_input4 = array(
    "name" => "isg_main",
    "width" => "col-sm-6",
    "tag" => "İSG Gerekli Evraklar",
);
$site_input5 = array(
    "name" => "isg_education",
    "width" => "col-sm-6",
    "tag" => "İSG Eğitim Grupları",
);
$site_input6 = array(
    "name" => "isg_debit",
    "width" => "col-sm-4",
    "tag" => "İSG Zimmet Grupları",
);
$site_input7 = array(
    "name" => "isg_accident",
    "width" => "col-sm-4",
    "tag" => "İSG Kaza Grupları",
);
$site_input8 = array(
    "name" => "isg_checkup",
    "width" => "col-sm-4",
    "tag" => "İSG Sağlık Raporları",
);


$site_input_rows = array(
    "row2" => array( $site_input4, $site_input5),
    "row3" => array( $site_input6, $site_input7, $site_input8)
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


<div class="card-body">
    <div class="row g-3">
        <label>TC Kimlik No Doğrulama</label>
        <select style="width: 100%" id="select2-demo-1" class="form-control"
                data-plugin="select2"
                name="tckn_control">
            <option value="<?php echo $item->tckn_control; ?>"><?php echo cms_if_echo($item->tckn_control, "1", "Açık", "Kapalı"); ?></option>
            <option value="1">Açık</option>
            <option value="0">Kapalı</option>
        </select>
    </div>
</div><!-- Süreç -->
