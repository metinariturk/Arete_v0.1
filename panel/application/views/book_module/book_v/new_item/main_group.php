<form id="add_main"
      action="<?php echo base_url("$this->Module_Name/add_main/$book->id"); ?>"
      method="post"
      enctype="multipart/form-data" autocomplete="off">
    <table class="table" style="font-size: 12px;">
        <thead>
        <tr>
            <th colspan="3"
                style="text-align:center; width: 50px;"><?php echo $book->book_name . " " . $book->book_year; ?> POZ
                KİTABI<p>ANA GRUPLAR</p></th>
        </tr>
        <tr>
            <th style="width: 50px;">Grup Kodu/Adı</th>
        </tr>
        </thead>
        <tbody class="sortable">
        <?php $main_groups = $this->Books_main_model->get_all(
            array(
                "book_id" => $book->id,
                "isActive" => 1,
            )
        ); ?>
        <?php if (isset($main_groups)) { ?>
            <?php foreach ($main_groups as $main_group) { ?>
                <tr>
                    <td>
                        <a onclick="deletemain(this)"
                           url="<?php echo base_url("$this->Module_Name/delete_main/$main_group->id"); ?>"
                           warning="Ana İş Grubunu Silmek Üzeresiniz">
                        <i style="font-size: 18px; color: Tomato;" class="fa fa-times-circle-o"
                           aria-hidden="true"></i>
                        </a>
                        <a id="category" href="#"
                           url="<?php echo base_url("$this->Module_Name/show_sub/$main_group->id"); ?>"
                           onclick="show_sub(this)" method="post" enctype="multipart">
                            <?php echo $main_group->main_code; ?>.<?php echo $main_group->main_name; ?>
                        </a>
                    </td>
                </tr>
            <?php } ?>
        <?php } ?>
        </tbody>
    </table>
    <div class="div">
        <div class="mb-2">
            <div class="col-form-label">Yeni Grup</div>
            <input class="form-control <?php cms_isset(form_error("main_group_code"), "is-invalid", ""); ?>"
                   name="main_group_code" value="<?php echo isset($form_error) ? set_value("main_group_code") : ""; ?>"
                   placeholder="Ana Grup Kodu - İ01 - Elk-02 vs."/>
            <?php if (isset($form_error)) { ?>
                <div class="invalid-feedback"><?php echo form_error("main_group_code"); ?></div>
            <?php } ?>
            <input class="form-control <?php cms_isset(form_error("group_name"), "is-invalid", ""); ?>"
                   name="group_name" value="<?php echo isset($form_error) ? set_value("group_name") : ""; ?>"
                   placeholder="Grup Adı"/>
            <?php if (isset($form_error)) { ?>
                <div class="invalid-feedback"><?php echo form_error("group_name"); ?></div>
            <?php } ?>
        </div>
    </div>
    <p><?php if (isset($error)) { echo $error;} ?></p>
    <a form-id="add_main" id="save_button" onclick="add_main(this)"
       class="btn btn-success">
        <i class="fa fa-plus fa-lg"></i> Ekle
    </a>
</form>
