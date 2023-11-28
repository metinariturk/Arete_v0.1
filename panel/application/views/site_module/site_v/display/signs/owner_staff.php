<form id="owner_staff"
      action="<?php echo base_url("$this->Module_Name/sign_options/$item->id/owner_staff"); ?>"
      method="post"
      div="refresh_owner_staff"
      enctype="multipart/form-data" autocomplete="off">
    <div class="div">
        <table style="width: 100%;">
            <thead>
            <tr>
                <td colspan="4" class="total-group-header-center">İşveren Teknik Personel</td>
            </tr>
            <tr>
                <td class="total-group-header-center">#</td>
                <td class="total-group-header-center">Ünvan</td>
                <td class="total-group-header-center">Ad - Soyad</td>
                <td class="total-group-header-center">Sil</td>
            </tr>
            </thead>
            <tbody class="sortable" data-url="<?php echo base_url("$this->Module_Name/sign_rankSetter"); ?>">
            <?php if (is_array($owner_staff)) { ?>
                <?php foreach ($owner_staff as $owner_staf) { ?>
                    <tr id="sub-<?php echo $owner_staf->id; ?>">
                        <td style="text-align: center"><i class="fa fa-reorder"></i></td>
                        <td><?php echo $owner_staf->position; ?></td>
                        <td><?php echo $owner_staf->name; ?></td>
                        <td style="text-align: center">
                            <a onclick="delete_sign(this)"
                               div="refresh_owner_staff"
                               url="<?php echo base_url("$this->Module_Name/delete_sign/$owner_staf->id/owner_staff/$item->id"); ?>">
                                <i style="font-size: 18px; color: Tomato;" class="fa fa-times-circle-o" aria-hidden="true">
                                </i>
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
    <a form-id="owner_staff" id="save_button" onclick="add_sign(this)"
       class="btn btn-success">
        <i class="fa fa-plus fa-lg"></i> Ekle
    </a>
</form>
