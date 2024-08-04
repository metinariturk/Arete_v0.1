<div>
    <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#exampleModalgetbootstrap" data-whatever="@getbootstrap"><i class="fa fa-plus"></i> Yeni Proje</button>
    <div class="modal fade" id="exampleModalgetbootstrap" tabindex="-1" role="dialog" aria-labelledby="exampleModalgetbootstrap" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-toggle-wrapper social-profile text-start dark-sign-up">
                    <h3 class="modal-header justify-content-center border-0">Yeni Proje Oluştur</h3>
                    <div class="modal-body">
                        <form class="row g-3 needs-validation" novalidate="" action="<?php echo base_url("$this->Module_Name/save/"); ?>" method="post" enctype="multipart/form-data">
                            <div class="mb-3">
                                <div class="col-form-label">Proje Kodu</div>
                                <div class="input-group">
                                    <span class="input-group-text" id="inputGroupPrepend">PRJ</span>
                                    <?php if (!empty(get_last_fn("project"))) { ?>
                                        <input class="form-control <?php echo cms_isset(form_error("project_code"), "is-invalid", ""); ?>" type="number" placeholder="Proje Kodu" aria-describedby="inputGroupPrepend" name="project_code" readonly value="<?php echo isset($form_error) ? set_value("project_code") : increase_code_suffix("project"); ?>">
                                    <?php } else { ?>
                                        <input class="form-control <?php echo cms_isset(form_error("project_code"), "is-invalid", ""); ?>" type="number" placeholder="Proje Kodu" aria-describedby="inputGroupPrepend" required name="project_code" readonly value="<?php echo isset($form_error) ? set_value("project_code") : fill_empty_digits() . "1" ?>">
                                    <?php } ?>
                                    <?php if (isset($form_error)) { ?>
                                        <div class="invalid-feedback"><?php echo form_error("project_code"); ?></div>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="mb-3">
                                <input class="form-control <?php echo cms_isset(form_error("project_name"), "is-invalid", ""); ?>"
                                       placeholder="Proje Adı" aria-describedby="inputGroupPrepend" name="project_name"
                                        value="<?php echo isset($form_error) ? set_value("project_name") : ""; ?>">
                                <?php if (isset($form_error)) { ?>
                                    <div class="invalid-feedback"><?php echo form_error("project_name"); ?></div>
                                <?php } ?>
                            </div>
                            <div class="mb-3">
                                <select id="select2-demo-1" style="width: 100%;" class="form-control <?php echo cms_isset(form_error("department"), "is-invalid", ""); ?>" data-plugin="select2" name="department">
                                    <option selected="selected">Seçiniz</option>
                                    <?php $departments = get_as_array($settings->department); foreach ($departments as $department) { ?>
                                        <option><?php echo $department; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <input type="text" class="form-control" name="notes" placeholder="Genel Açıklama">
                            </div>
                            <div class="col-md-12">
                                <button class="btn btn-primary" type="submit">Proje Oluştur</button>
                            </div>
                            <?php print_r(validation_errors()); ?>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<hr>
<div class="col-sm-12">
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table  id="project_list">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Proje Kodu</th>
                        <th>Proje Adı</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $i = 1; ?>
                    <?php foreach ($items as $item) { ?>
                        <tr>
                            <td>
                                <?php echo $i++; ?>
                            </td>
                            <td>
                                <a href="<?php echo base_url("project/file_form/$item->id"); ?>">
                                    <?php echo project_code($item->id); ?>
                                </a>
                            </td>
                            <td>
                                <a href="<?php echo base_url("project/file_form/$item->id"); ?>">
                                    <?php echo project_name($item->id); ?>
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    // Sayfa tamamen yüklendiğinde modalı aç
    $(document).ready(function() {
        $('#exampleModalgetbootstrap').modal('show');
    });
</script>