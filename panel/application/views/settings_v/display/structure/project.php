<?php

$project_input1 = array(
    "name" => "department",
    "width" => "col-sm-6",
    "tag" => "Birimler",
);



$project_input_rows = array(
    "row1" => array( $project_input1)
)
?>

<?php foreach ($project_input_rows as $project_inputs) { ?>
    <div class="card-body">
        <div class="row g-3">
            <?php foreach ($project_inputs as $project_input) {
                $name = $project_input["name"];
                $tag = $project_input["tag"];
                $width = $project_input["width"]; ?>
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

