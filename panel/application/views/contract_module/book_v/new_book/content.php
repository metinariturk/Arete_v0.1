<div class="card">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-6 refresh_list">
                        <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/add_books"); ?>
                    </div>
                    <div class="col-md-6 refresh_poz">
                        <form id="add_book"
                              action="<?php echo base_url("$this->Module_Name/add_book/"); ?>"
                              method="post"
                              enctype="multipart/form-data" autocomplete="off">

                            <div class="card-body">
                                <div class="mb-2">
                                    <div class="col-form-label">KISA KODU</div>
                                    <input step="any" class="form-control <?php cms_isset(form_error("code"), "is-invalid", ""); ?>"
                                           name="code" value="<?php echo isset($form_error) ? set_value("code") : ""; ?>"
                                           placeholder="Örneğin : CSB2023-KGM2018-OZL01">
                                    <?php if (isset($form_error)) { ?>
                                        <div class="invalid-feedback"><?php echo form_error("code"); ?></div>
                                    <?php } ?>
                                </div>
                                <div class="mb-2">
                                    <div class="col-form-label">Kitap Adı</div>
                                    <input step="any" class="form-control <?php cms_isset(form_error("book_name"), "is-invalid", ""); ?>"
                                           name="book_name" value="<?php echo isset($form_error) ? set_value("book_name") : ""; ?>"
                                           placeholder="Poz Kitabı Adı">
                                    <?php if (isset($form_error)) { ?>
                                        <div class="invalid-feedback"><?php echo form_error("book_name"); ?></div>
                                    <?php } ?>
                                </div>
                                <div class="mb-2">
                                    <div class="col-form-label">Yayın Yılı</div>
                                    <input type="number" step="any" class="form-control <?php cms_isset(form_error("year"), "is-invalid", ""); ?>"
                                           name="year" value="<?php echo isset($form_error) ? set_value("year") : ""; ?>"
                                           placeholder="Yıl">
                                    <?php if (isset($form_error)) { ?>
                                        <div class="invalid-feedback"><?php echo form_error("year"); ?></div>
                                    <?php } ?>
                                </div>
                                <div class="mb-2">
                                    <div class="col-form-label">Kurum/Kuruluş</div>
                                    <input step="any" class="form-control <?php cms_isset(form_error("owner"), "is-invalid", ""); ?>"
                                           name="owner" value="<?php echo isset($form_error) ? set_value("owner") : ""; ?>"
                                           placeholder="Kurum">
                                    <?php if (isset($form_error)) { ?>
                                        <div class="invalid-feedback"><?php echo form_error("owner"); ?></div>
                                    <?php } ?>
                                </div>
                            </div>
                            <button type="submit" form="add_book" id="save_button"
                                    class="btn btn-success"
                                <i class="fa fa-floppy-o fa-lg"></i> Kaydet
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


