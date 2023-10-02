<?php

$input1 = array(
    "name" => "KDV_oran",
    "width" => "col-sm-3",
    "tag" => "KDV Oranı",
);
$input2 = array(
    "name" => "kdv_tevkifat_oran",
    "width" => "col-sm-3",
    "tag" => "KDV Tevkifat Oranı",
);
$input3 = array(
    "name" => "damga_oran",
    "width" => "col-sm-3",
    "tag" => "Damga Vergisi Oranı",
);
$input4 = array(
    "name" => "stopaj_oran",
    "width" => "col-sm-3",
    "tag" => "Stopaj Oranı",
);
$input5 = array(
    "name" => "para_birimi",
    "width" => "col-sm-3",
    "tag" => "Para Birimi",
);
$input6 = array(
    "name" => "gecici",
    "width" => "col-sm-3",
    "tag" => "Geçici Kabul Teminat Oranları",
);
$input7 = array(
    "name" => "teminat_turu",
    "width" => "col-sm-3",
    "tag" => "Teminat Türü",
);
$input8 = array(
    "name" => "odeme_turu",
    "width" => "col-sm-3",
    "tag" => "Ödeme Türü",
);

$input9 = array(
    "name" => "bankalar",
    "width" => "col-sm-12",
    "tag" => "Bankalar",
);
$input10 = array(
    "name" => "teminat_esas_isler",
    "width" => "col-sm-6",
    "tag" => "Teminat Esas İşler",
);

$financial_input_rows = array(
    "row1" => array($input1, $input2, $input3, $input4),
    "row2" => array($input5, $input6,$input7, $input8),
    "row3" => array($input9),
    "row4" => array($input10)
)
?>

<?php foreach ($financial_input_rows as $financial_inputs) { ?>
    <div class="card-body">
    <div class="row g-3">
    <?php foreach ($financial_inputs as $finance_input) {
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

