<form id="add_contract"
      action="<?php echo base_url("$this->Module_Name/sign_options/$item->id/contractor_sign"); ?>"
      method="post"
      div="refresh_contractor_sign"
      enctype="multipart/form-data" autocomplete="off">
    <div class="div">
        <?php $contractor_sings = $this->Payment_sign_model->get_all(array("contract_id" => $item->contract_id, "sign_page" => "contractor_sign")); ?>

        <table style="width: 100%;">
            <thead>
            <tr>
                <td colspan="4" class="total-group-header-center">İşi Yapan</td>
            </tr>
            <tr>
                <td class="total-group-header-center">#</td>
                <td class="total-group-header-center">Ünvan</td>
                <td class="total-group-header-center">Ad - Soyad</td>
                <td class="total-group-header-center">Sil</td>
            </tr>
            </thead>
            <tbody>
            <?php if (is_array($contractor_sings)) { ?>
                <?php foreach ($contractor_sings as $contractor_sing) { ?>
                    <tr>
                        <td style="text-align: center"><i class="fa fa-reorder"></i></td>
                        <td><?php echo $contractor_sing->position; ?></td>
                        <td><?php echo $contractor_sing->name; ?></td>
                        <td style="text-align: center">
                            <a onclick="delete_sign(this)"
                               div="refresh_contractor_sign"
                               url="<?php echo base_url("$this->Module_Name/delete_sign/$contractor_sing->id/contractor_sign/$item->id"); ?>">
                                <i style="font-size: 18px; color: Tomato;" class="fa fa-times-circle-o"
                                   aria-hidden="true"></i>
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            <?php } ?>
            </tbody>
        </table>
        <?php if (empty($contractor_sings)) { ?>
            <div class="mb-2">
                <div class="col-form-label">Yeni İmza Satırı</div>
                <input value="<?php echo isset($form_error) ? set_value("position") : ""; ?>"
                       class="form-control <?php cms_isset(form_error("position"), "is-invalid", ""); ?>"
                       name="position"
                       placeholder="Yüklenici-Taşeron vs."/>
                <input value="<?php echo isset($form_error) ? set_value("name") : ""; ?>"
                       class="form-control <?php cms_isset(form_error("name"), "is-invalid", ""); ?>"
                       name="name"
                       placeholder="Firma Adı veya Ad Soyad"/>
            </div>
            <?php if (isset($form_error)) { ?>
                <div class="invalid-feedback"><?php echo form_error("position"); ?></div>
            <?php } ?>
            <?php if (isset($form_error)) { ?>
                <div class="invalid-feedback"><?php echo form_error("name"); ?></div>
            <?php } ?>

            <a form-id="add_contract" id="save_button" onclick="add_sign(this)"
               class="btn btn-success">
                <i class="fa fa-plus fa-lg"></i> Ekle
            </a>
        <?php } ?>
    </div>

</form>
