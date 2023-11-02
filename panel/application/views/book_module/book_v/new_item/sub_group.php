<form id="add_sub"
      action="<?php echo base_url("$this->Module_Name/add_sub/$main_id"); ?>"
      method="post"
      enctype="multipart/form-data" autocomplete="off">
    <div class="card-body">
        <table class="table" style="font-size: 12px;">
            <thead>
            <tr>
                <th colspan="3" style="text-align:center; width: 50px;"><?php echo $main->main_code." - ".$main->main_name; ?> GRUBU<p>ALT GRUPLARI</p></th>
            </tr>
            <tr>
                <th style="width: 50px;">Alt Grup Kodu</th>
                <th style="width: 50px;">Alt Grup Adı</th>
                <th style="width: 50px;">Poz Sayısı</th>
            </tr>
            </thead>
            <tbody class="sortable">
            <?php $sub_groups = $this->Books_sub_model->get_all(
                array(
                    "book_id" => $book_id,
                    "main_id" => $main_id,
                    "isActive" => 1,
                )
            ); ?>
            <?php if (isset($sub_groups)) { ?>
                <?php foreach ($sub_groups as $sub_group) { ?>
                    <tr>
                        <td>
                            <a id="category" href="#"
                               url="<?php echo base_url("$this->Module_Name/show_sub/$sub_group->id"); ?>"
                               onclick="show_sub(this)" method="post" enctype="multipart">
                                <?php echo $sub_group->sub_code; ?>
                            </a>
                        </td>
                        <td>
                            <?php echo $sub_group->sub_name; ?>
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
            <div class="col-form-label">Yeni Alt Grup</div>
            <input step="any" class="form-control <?php cms_isset(form_error("sub_group_code"), "is-invalid", ""); ?>"
                   name="sub_group_code" value="<?php echo isset($form_error) ? set_value("sub_group_code") : ""; ?>"
                   placeholder="Ana Grup Kodu - İ01 - Elk-02 vs."/>
            <?php if (isset($form_error)) { ?>
                <div class="invalid-feedback"><?php echo form_error("sub_group_code"); ?></div>
            <?php } ?>
            <input step="any" class="form-control <?php cms_isset(form_error("sub_group_name"), "is-invalid", ""); ?>"
                   name="sub_group_name" value="<?php echo isset($form_error) ? set_value("sub_group_name") : ""; ?>"
                   placeholder="Grup Adı"/>
            <?php if (isset($form_error)) { ?>
                <div class="invalid-feedback"><?php echo form_error("sub_group_name"); ?></div>
            <?php } ?>
        </div>
    </div>
    <a  form-id="add_sub" id="save_button" onclick="add_sub(this)"
            class="btn btn-success">
        <i class="fa fa-floppy-o fa-lg"></i> Kaydet
    </a>
</form>
