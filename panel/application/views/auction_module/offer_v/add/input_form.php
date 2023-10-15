<?php $proje_id = get_from_id("auction", "proje_id", $auc_id); ?>
<div class="mb-2">
    <div class="col-form-label">Dosya No</div>
    <div class="input-group"><span class="input-group-text" id="inputGroupPrepend">TKL</span>
        <?php if (!empty(get_last_fn("offer"))) { ?>
            <input class="form-control <?php cms_isset(form_error("dosya_no"), "is-invalid", ""); ?>"
                   type="number" placeholder="Proje Kodu" aria-describedby="inputGroupPrepend"
                   data-bs-original-title="" title="" name="dosya_no"
                   value="<?php echo isset($form_error) ? set_value("dosya_no") : increase_code_suffix("offer"); ?>">
            <?php
        } else { ?>
            <input class="form-control <?php cms_isset(form_error("dosya_no"), "is-invalid", ""); ?>"
                   type="number" placeholder="Username" aria-describedby="inputGroupPrepend"
                   required="" data-bs-original-title="" title="" name="dosya_no"
                   value="<?php echo isset($form_error) ? set_value("dosya_no") : fill_empty_digits() . "1" ?>">
        <?php } ?>

        <?php if (isset($form_error)) { ?>
            <div class="invalid-feedback"><?php echo form_error("dosya_no"); ?></div>
            <div class="invalid-feedback">* Önerilen Proje Kodu
                : <?php echo increase_code_suffix("offer"); ?>
            </div>
        <?php } ?>
    </div>
</div>

<?php
$inputFields = [
    [
        "order" => 3,
        "title" => "Teklif Bedel",
        "name" => "offer_price",
        "type" => "number",
        "input-group-text" => "TL",
        "div-class" => "col-md-12",
        "attributes" => [
            "min" => "1",
            "step" => "any",
        ],
        "placeholder" => "Teklif Bedelini Yazınız",
    ],
    [
        "order" => 1,
        "title" => "Teklif No",
        "name" => "offer_no",
        "type" => "number",
        "div-class" => "col-md-12",
        "attributes" => [
            "min" => "1",
            "step" => "1",
        ],
        "placeholder" => "Varsa Teklife Ait Notlarınızı Yazınız",
    ],
    [
        "order" => 4,
        "title" => "Teklif Not",
        "name" => "aciklama",
        "type" => "textarea",
        "div-class" => "col-md-12",
        "placeholder" => "Varsa Teklife Ait Notlarınızı Yazınız",
    ],
    [
        "order" => 2,
        "title" => "Teklif Verilme Tarihi",
        "name" => "offer_date",
        "type" => "text",
        "div-class" => "col-md-12",
        "attributes" => [
            "class" => "datepicker-here form-control digits",
            "data-options" => "{ format: 'DD-MM-YYYY' }",
            "data-language" => "tr",
        ],
        "placeholder" => "Planlanan Teklif Tarihini Yazınız",
    ],
];

// Sıra numarasına göre input alanlarını sırala
usort($inputFields, function ($a, $b) {
    return $a['order'] - $b['order'];
});

foreach ($inputFields as $field) {
    ?>
    <div class="mb-2 <?php echo $field['div-class']; ?>">
        <div class="col-form-label"><?php echo $field['title']; ?></div>
        <?php if ($field['type'] === "textarea") { ?>
            <textarea class="form-control <?php cms_isset(form_error($field['name']), "is-invalid", ""); ?>"
                      name="<?php echo $field['name']; ?>"
                      placeholder="<?php echo $field['placeholder']; ?>"><?php echo isset($form_error) ? set_value($field['name']) : ""; ?></textarea>
        <?php } else { ?>
            <div class="input-group">
                <?php if (isset($field['input-group-text'])) { ?>
                    <span class="input-group-text"
                          id="inputGroupPrepend"><?php echo get_currency_auc($auc_id); ?></span>
                <?php } ?>
                <input type="<?php echo $field['type']; ?>" <?php
                if (isset($field['attributes'])) {
                    foreach ($field['attributes'] as $attrName => $attrValue) {
                        if (is_array($attrValue)) {
                            $attrValue = json_encode($attrValue);
                        }
                        echo $attrName . '="' . $attrValue . '" ';
                    }
                }
                ?> class="form-control <?php cms_isset(form_error($field['name']), "is-invalid", ""); ?>"
                       name="<?php echo $field['name']; ?>"
                       value="<?php echo isset($form_error) ? set_value($field['name']) : ""; ?>">
            </div>
        <?php } ?>
        <?php if (isset($form_error)) { ?>
            <span style="color: #3b4bf1"><?php echo form_error($field['name']); ?></span>
        <?php } ?>
    </div>
<?php } ?>

