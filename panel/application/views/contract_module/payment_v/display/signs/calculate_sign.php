<form id="add_contract"
      action="<?php echo base_url("$this->Module_Name/sign_options/$item->id/calculate_sign"); ?>"
      method="post"
      div = "refresh_calculate_sign"
      enctype="multipart/form-data" autocomplete="off">
    <div class="div">
        <?php $calculate_sings = json_decode($payment_settings->calculate_sign, true); ?>

        <table style="width: 100%;">
            <thead>
            <tr>
                <td colspan="4" class="total-group-header-center">Metraj Cetveli İmzaları</td>
            </tr>
            <tr>
                <td class="total-group-header-center">#</td>
                <td class="total-group-header-center">Ünvan</td>
                <td class="total-group-header-center">Ad - Soyad</td>
                <td class="total-group-header-center">Sil</td>
                </td>
            </tr>
            </thead>
            <tbody>
            <?php if (is_array($calculate_sings)) { ?>
                <?php $i = 1; ?>
                <?php foreach ($calculate_sings as $calculate_sing) { ?>
                    <tr>
                        <td><?php echo $i++; ?></td>
                        <td><?php echo $calculate_sing['position']; ?></td>
                        <td> <?php echo $calculate_sing['name']; ?></td>
                        <td> <a onclick="deleteConfirmationFile(this)"
                                url="<?php echo base_url("$this->Module_Name/fileDelete/$item->id/calculate_sign"); ?>">
                                <i style="font-size: 18px; color: Tomato;" class="fa fa-times-circle-o"
                                   aria-hidden="true"></i>
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            <?php } ?>
            </tbody>
        </table>
        <div class="mb-2">
            <div class="col-form-label">Yeni İmza Satırı</div>
            <input value="<?php echo isset($form_error) ? set_value("position") : ""; ?>"
                   class="form-control <?php cms_isset(form_error("position"), "is-invalid", ""); ?>"
                   name="position"
                   placeholder="Ünvan"/>
            <input value="<?php echo isset($form_error) ? set_value("name") : ""; ?>"
                   class="form-control <?php cms_isset(form_error("name"), "is-invalid", ""); ?>"
                   name="name"
                   placeholder="Ad Soyad"/>
        </div>
        <?php if (isset($form_error)) { ?>
            <div class="invalid-feedback"><?php echo form_error("position"); ?></div>
        <?php } ?>
        <?php if (isset($form_error)) { ?>
            <div class="invalid-feedback"><?php echo form_error("name"); ?></div>
        <?php } ?>
    </div>
    <a form-id="add_contract" id="save_button" onclick="add_sign(this)"
       class="btn btn-success">
        <i class="fa fa-plus fa-lg"></i> Ekle
    </a>
</form>
