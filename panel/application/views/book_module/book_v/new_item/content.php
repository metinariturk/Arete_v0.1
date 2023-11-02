<div class="card">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-4">
                        <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/book_table"); ?>
                    </div>
                    <div class="col-md-4 refresh_poz">
                        <form id="add_group"
                              action="<?php echo base_url("$this->Module_Name/add_book/"); ?>"
                              method="post"
                              enctype="multipart/form-data" autocomplete="off">

                            <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/group_table"); ?>
                            <div class="card-body">
                                <div class="mb-2">
                                    <div class="col-form-label">Grup Kodu</div>
                                    <input step="any" class="form-control <?php cms_isset(form_error("code"), "is-invalid", ""); ?>"
                                           name="code" value="<?php echo isset($form_error) ? set_value("code") : ""; ?>"
                                           placeholder="Örneğin : CSB2023-KGM2018-OZL01"/>
                                    <?php if (isset($form_error)) { ?>
                                        <div class="invalid-feedback"><?php echo form_error("code"); ?></div>
                                    <?php } ?>
                                </div>
                                <div class="mb-2">
                                    <div class="col-form-label">Grup Adı</div>
                                    <input step="any" class="form-control <?php cms_isset(form_error("book_name"), "is-invalid", ""); ?>"
                                           name="book_name" value="<?php echo isset($form_error) ? set_value("book_name") : ""; ?>"
                                           placeholder="Poz Kitabı Adı"/>
                                    <?php if (isset($form_error)) { ?>
                                        <div class="invalid-feedback"><?php echo form_error("book_name"); ?></div>
                                    <?php } ?>
                                </div>
                            </div>
                            <button type="submit" form="add_book" id="save_button"
                                    class="btn btn-success">
                                <i class="fa fa-floppy-o fa-lg"></i> Kaydet
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


