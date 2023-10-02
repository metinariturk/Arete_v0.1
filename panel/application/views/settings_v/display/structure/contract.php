<?php


$cont_input2 = array(
    "name" => "is_grubu",
    "width" => "col-sm-6",
    "tag" => "İş Grupları",
);
$cont_input3 = array(
    "name" => "meslek",
    "width" => "col-sm-6",
    "tag" => "Meslekler (Proje Yöneticisi, Şantiye Şefi, Mühendis vs.)",
);
$cont_input4 = array(
    "name" => "surec_durum",
    "width" => "col-sm-6",
    "tag" => "Süreç Durumları (Devam Eden, Bitti vs.)",
);
$cont_input5 = array(
    "name" => "isin_turu",
    "width" => "col-sm-6",
    "tag" => "İşin Türü",
);
$cont_input6 = array(
    "name" => "sozlesme_taraflari",
    "width" => "col-sm-6",
    "tag" => "Sözleşme Tarafları",
);
$cont_input7 = array(
    "name" => "sozlesme_turu",
    "width" => "col-sm-6",
    "tag" => "Sözleşme Türleri",
);
$cont_input8 = array(
    "name" => "teknik_cizim",
    "width" => "col-sm-6",
    "tag" => "Teknik Çizim Grupları",
);
$cont_input9 = array(
    "name" => "tesvik",
    "width" => "col-sm-6",
    "tag" => "Teşvik Grupları",
);



$contract_input_rows = array(
    "row1" => array($cont_input2, $cont_input3),
    "row2" => array($cont_input4,$cont_input5),
    "row3" => array($cont_input6,$cont_input7 ),
    "row4" => array($cont_input8,$cont_input9)
)
?>

<?php foreach ($contract_input_rows as $contract_inputs) { ?>
    <div class="card-body">
        <div class="row g-3">
            <?php foreach ($contract_inputs as $finance_input) {
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
