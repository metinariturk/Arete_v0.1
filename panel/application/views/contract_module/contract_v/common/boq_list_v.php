<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6">
                    <form id="add_main"
                          action="<?php echo base_url("$this->Module_Name/add_main_group/$item->id"); ?>"
                          method="post"
                          enctype="multipart/form-data" autocomplete="off">
                        <div class="div">
                            <div class="mb-2">
                                <div class="col-form-label">Yeni Ana Grup</div>
                                <input value="<?php echo isset($form_error) ? set_value("main_code") : ""; ?>"
                                       class="form-control <?php cms_isset(form_error("main_code"), "is-invalid", ""); ?>"
                                       name="main_code"
                                       placeholder="Alt Kodu 01 - A - X vs"/>
                                <input value="<?php echo isset($form_error) ? set_value("main_group") : ""; ?>"
                                       class="form-control <?php cms_isset(form_error("main_group"), "is-invalid", ""); ?>"
                                       name="main_group"
                                       placeholder="Alt Grup Adı"/>

                            </div>
                            <?php if (isset($form_error)) { ?>
                                <div class="invalid-feedback"><?php echo form_error("main_group"); ?></div>
                            <?php } ?>
                            <?php if (isset($form_error)) { ?>
                                <div class="invalid-feedback"><?php echo form_error("main_code"); ?></div>
                            <?php } ?>
                        </div>
                        <a form-id="add_main" id="save_button" onclick="add_main(this)"
                           class="btn btn-success">
                            <i class="fa fa-plus fa-lg"></i> Ekle
                        </a>
                    </form>

                </div>
                <div class="col-md-6">
                    <form id="add_sub"
                          action="<?php echo base_url("$this->Module_Name/add_sub_group/$item->id"); ?>"
                          method="post"
                          enctype="multipart/form-data" autocomplete="off">
                        <div class="div">
                            <div class="mb-2">
                                <div class="col-form-label">Yeni Alt Grup</div>
                                <div class="mb-2">
                                    <select class="form-control" name="main_group_id">
                                        <?php foreach ($main_groups as $main_group) { ?>
                                            <option value="<?php echo $main_group->id; ?>"><?php echo $main_group->code; ?> - <?php echo $main_group->name; ?></option>
                                        <?php } ?>
                                    </select>
                                    <input value="<?php echo isset($form_error) ? set_value("sub_group_code") : ""; ?>"
                                           class="form-control <?php cms_isset(form_error("sub_group_code"), "is-invalid", ""); ?>"
                                           name="sub_group_code"
                                           placeholder="Alt Kodu 01 - A - X vs"/>
                                    <input value="<?php echo isset($form_error) ? set_value("sub_group_name") : ""; ?>"
                                           class="form-control <?php cms_isset(form_error("sub_group_name"), "is-invalid", ""); ?>"
                                           name="sub_group_name"
                                           placeholder="Alt Grup Adı"/>
                                </div>
                                <?php if (isset($form_error)) { ?>
                                    <div class="invalid-feedback"><?php echo form_error("sub_group_name"); ?></div>
                                <?php } ?>
                                <?php if (isset($form_error)) { ?>
                                    <div class="invalid-feedback"><?php echo form_error("sub_group_code"); ?></div>
                                <?php } ?>
                            </div>
                        </div>
                        <a form-id="add_sub" id="save_button" onclick="add_sub(this)"
                           class="btn btn-success">
                            <i class="fa fa-plus fa-lg"></i> Ekle
                        </a>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<?php echo validation_errors(); ?>