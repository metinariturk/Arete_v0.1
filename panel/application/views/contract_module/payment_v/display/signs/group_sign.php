<form id="add_group_total"
      action="<?php echo base_url("$this->Module_Name/sign_options/$item->id/group_sign"); ?>"
      method="post"
      div="refresh_group_sign"
      enctype="multipart/form-data" autocomplete="off">
    <div class="div">
        <?php $group_total_sings = json_decode($payment_settings->group_sign, true); ?>

        <table style="width: 100%;">
            <thead>
            <tr>
                <td colspan="3" class="total-group-header-center">Grup İcmali İmzaları</td>
            </tr>
            <tr>
                <td class="total-group-header-center">#</td>
                <td class="total-group-header-center">Ünvan</td>
                <td class="total-group-header-center">Ad - Soyad</td>
            </tr>
            </thead>
            <tbody>
            <?php if (is_array($group_total_sings)) { ?>
                <?php $i = 1; ?>
                <?php foreach ($group_total_sings as $group_total_sing) { ?>
                    <tr>
                        <td><?php echo $i++; ?></td>
                        <td><?php echo $group_total_sing['position']; ?></td>
                        <td> <?php echo $group_total_sing['name']; ?></td>
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
    <a form-id="add_group_total" id="save_button" onclick="add_sign(this)"
       class="btn btn-success">
        <i class="fa fa-plus fa-lg"></i> Ekle
    </a>
</form>
