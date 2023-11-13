<form id="add_works_done"
      action="<?php echo base_url("$this->Module_Name/sign_options/$item->id/works_done_sign"); ?>"
      method="post"
      div="refresh_works_done_sign"
      enctype="multipart/form-data" autocomplete="off">
    <div class="div">
        <?php $works_done_sings = json_decode($payment_settings->works_done_sign, true); ?>

        <table style="width: 100%;">
            <thead>
            <tr>
                <td colspan="4" class="total-group-header-center">Yapılan İşler Listesi İmzaları</td>
            </tr>
            <tr>
                <td class="total-group-header-center">#</td>
                <td class="total-group-header-center">Ünvan</td>
                <td class="total-group-header-center">Ad - Soyad</td>
                <td class="total-group-header-center">
                    <a onclick="delete_sign(this)"
                       div="refresh_works_done_sign"
                       url="<?php echo base_url("$this->Module_Name/delete_sign/$item->id/works_done_sign"); ?>">
                        <i style="font-size: 18px; color: Tomato;" class="fa fa-times-circle-o"
                           aria-hidden="true"></i>
                    </a>
                </td>
            </tr>
            </thead>
            <tbody>
            <?php if (is_array($works_done_sings)) { ?>
                <?php $i = 1; ?>
                <?php foreach ($works_done_sings as $works_done_sing) { ?>
                    <tr>
                        <td><?php echo $i++; ?></td>
                        <td><?php echo $works_done_sing['position']; ?></td>
                        <td> <?php echo $works_done_sing['name']; ?></td>
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
    <a form-id="add_works_done" id="save_button" onclick="add_sign(this)"
       class="btn btn-success">
        <i class="fa fa-plus fa-lg"></i> Ekle
    </a>
</form>
