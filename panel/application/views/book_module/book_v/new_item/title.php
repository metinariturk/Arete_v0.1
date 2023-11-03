<form id="add_title"
      action="<?php echo base_url("$this->Module_Name/add_title/$sub_id"); ?>"
      method="post"
      enctype="multipart/form-data" autocomplete="off">
    <div class="card-body">
        <table class="table" style="font-size: 12px;">
            <thead>
            <tr>
                <th colspan="3" style="text-align:center; width: 50px;"><?php echo $sub->main_code." - ".$sub->main_name; ?> GRUBU<p>ALT GRUPLARI</p></th>
            </tr>
            <tr>
                <th style="width: 50px;">Alt Grup Kodu</th>
                <th style="width: 50px;">Alt Grup Adı</th>
                <th style="width: 50px;">Poz Sayısı</th>
            </tr>
            </thead>
            <tbody class="sortable">
            <?php $titles = $this->Books_title_model->get_all(
                array(
                    "book_id" => $book_id,
                    "sub_id" => $sub->id,
                    "isActive" => 1,
                )
            ); ?>
            <?php if (isset($titles)) { ?>
                <?php foreach ($titles as $title) { ?>
                    <tr>
                        <td>
                            <a id="category" href="#"
                               url="<?php echo base_url("$this->Module_Name/show_sub/$title->id"); ?>"
                               onclick="show_sub(this)" method="post" enctype="multipart">
                                <?php echo $title->sub_code; ?>
                            </a>
                        </td>
                        <td>
                            <?php echo $title ->sub_name; ?>
                        </td>
                        <td>
                        </td>
                    </tr>
                <?php } ?>
            <?php } ?>
            </tbody>
        </table>
    </div>
    <div class="card-body">
        <div class="mb-2">
            <div class="col-form-label">Yeni Başlık</div>
            <input step="any" class="form-control <?php cms_isset(form_error("sub_group_code"), "is-invalid", ""); ?>"
                   name="sub_group_code" value="<?php echo isset($form_error) ? set_value("sub_group_code") : ""; ?>"
                   placeholder="Başlık Kodu 01 - A - I vs."/>
            <?php if (isset($form_error)) { ?>
                <div class="invalid-feedback"><?php echo form_error("sub_group_code"); ?></div>
            <?php } ?>
            <input step="any" class="form-control <?php cms_isset(form_error("sub_group_name"), "is-invalid", ""); ?>"
                   name="sub_group_name" value="<?php echo isset($form_error) ? set_value("sub_group_name") : ""; ?>"
                   placeholder="Başlık Adı - Döşeme İşleri - Duvar İşleri vs."/>
            <?php if (isset($form_error)) { ?>
                <div class="invalid-feedback"><?php echo form_error("sub_group_name"); ?></div>
            <?php } ?>
        </div>
    </div>
    <a  form-id="add_title" id="save_button" onclick="add_title(this)"
            class="btn btn-success">
        <i class="fa fa-floppy-o fa-lg"></i> Kaydet
    </a>
</form>
