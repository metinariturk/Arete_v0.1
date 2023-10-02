<?php

$auction_input1 = array(
    "name" => "gecici",
    "width" => "col-sm-6",
    "tag" => "Geçici Kabul Teminat Oranları",
);
$auction_input2 = array(
    "name" => "teminat_turu",
    "width" => "col-sm-6",
    "tag" => "Teminat Türü",
);
$auction_input3 = array(
    "name" => "odeme_turu",
    "width" => "col-sm-6",
    "tag" => "Ödeme Türü",
);
$auction_input5 = array(
    "name" => "benzer_is",
    "width" => "col-sm-12",
    "tag" => "Benzer İşler",
);
$auction_input4 = array(
    "name" => "muteahhit_sinif",
    "width" => "col-sm-6",
    "tag" => "Müteahhit Sınıfı",
);
$auction_input6 = array(
    "name" => "sigorta",
    "width" => "col-sm-12",
    "tag" => "Sigorta",
);
$auction_input7 = array(
    "name" => "yeterlilik",
    "width" => "col-sm-12",
    "tag" => "İhale Yeterlilik Kontrolü",
);

$auction_input_rows = array(
    "row1" => array($auction_input1, $auction_input2),
    "row2" => array($auction_input3, $auction_input4),
    "row3" => array($auction_input5),
    "row4" => array($auction_input6),
    "row5" => array($auction_input7)
)
?>

<?php foreach ($auction_input_rows as $financial_inputs) { ?>
    <div class="card-body">
        <div class="row g-3">
            <?php foreach ($financial_inputs as $finance_input) {
                $name = $finance_input["name"];
                $tag = $finance_input["tag"];
                $width = $finance_input["width"]; ?>
                <div class="<?php echo $width; ?>">
                    <label class="form-label" for="validationCustom01"><?php echo $tag; ?></label><br>
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

