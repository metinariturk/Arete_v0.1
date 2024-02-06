<form id="add_calculate"
      action="<?php echo base_url("$this->Module_Name/sign_options/$item->id/calculate_sign"); ?>"
      method="post"
      div="refresh_calculate_sign"
      enctype="multipart/form-data" autocomplete="off">
    <div class="div">
        <?php $calculate_sings = $this->Payment_sign_model->get_all(array("contract_id" => $item->contract_id, "sign_page" => "calculate_sign"), "rank ASC"); ?>

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
            </tr>
            </thead>
            <tbody class="sortable" data-url="<?php echo base_url("$this->Module_Name/sign_rankSetter"); ?>">
            <?php if (is_array($calculate_sings)) { ?>
                <?php foreach ($calculate_sings as $calculate_sing) { ?>
                    <tr id="sub-<?php echo $calculate_sing->id; ?>">
                        <td style="text-align: center"><i class="fa fa-reorder"></i></td>
                        <td><?php echo $calculate_sing->position; ?></td>
                        <td><?php echo $calculate_sing->name; ?></td>
                        <td style="text-align: center">
                            <a onclick="delete_sign(this)"
                               div="refresh_calculate_sign"
                               url="<?php echo base_url("$this->Module_Name/delete_sign/$calculate_sing->id/calculate_sign/$item->id"); ?>">
                                <i style="font-size: 18px; color: Tomato;" class="fa fa-times-circle-o"
                                   aria-hidden="true">
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
    <a form-id="add_calculate" id="save_button" onclick="add_sign(this)"
       class="btn btn-success">
        <i class="fa fa-plus fa-lg"></i> Ekle
    </a>
</form>
{"2":{"s":"Konferans Salonu","n":"\u0130\u015fler G\u00fc\u00e7ler Halledildi","q":"2","w":"1","h":"0.75","l":"0.2","t":"0.30"},"1":{"n":"Deneme \u0130\u00e7in K\u00f6\u015fe Kal\u0131b\u0131 Yap\u0131lmas\u0131","q":"10","w":"2","h":"1","l":"0.5","t":"10.00"},"3":{"s":"asdfasdf","n":"asd","q":"2","w":"3","h":"1","l":"1","t":"6.00"}}