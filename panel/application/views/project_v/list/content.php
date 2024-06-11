<div>
    <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#exampleModalgetbootstrap" data-whatever="@getbootstrap">Open modal for cuba</button>
    <div class="modal fade" id="exampleModalgetbootstrap" tabindex="-1" role="dialog" aria-labelledby="exampleModalgetbootstrap" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-toggle-wrapper social-profile text-start dark-sign-up">
                    <h3 class="modal-header justify-content-center border-0">CUBA SIGN-UP</h3>
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
                                <button class="btn btn-primary" type="submit">Sign Up</button>
                            </div>
                            <?php print_r(validation_errors()); ?>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-sm-12">
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="example" class="table table-xl">
                    <thead>
                    <tr>
                        <th style="width: 15px;">Proje ID</th>
                        <th colspan="3">Proje Adı</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($items as $item): ?>
                        <?php $main_contract = $this->Contract_model->get(array("proje_id" => $item->id, "parent" => 0)); ?>
                        <?php if ($main_contract): ?>
                            <tr class="parent" data-parent="<?php echo $item->id; ?>">
                                <td><?php echo $item->id; ?></td>
                                <td><?php echo $item->project_name; ?></td>
                                <td><a href="<?php echo base_url("$this->Module_Name/file_form/$item->id"); ?>">
                                        Git </a></td>
                            </tr>
                            <tr class="child parent-<?php echo $item->id; ?>" style="display: none;">
                                <td></td>
                                <td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <a href="<?php echo base_url("Contract/file_form/$main_contract->id"); ?>">
                                        <i class="fa fa-star" style="color: gold"></i> Ana Sözleşme
                                        - <?php echo $main_contract->sozlesme_ad; ?>
                                    </a>
                                </td>
                            </tr>
                            <?php $sub_contracts = $this->Contract_model->get_all(array("proje_id" => $item->id, "parent" => $main_contract->id)); ?>
                            <?php foreach ($sub_contracts as $sub_contract): ?>
                                <tr class="child parent-<?php echo $item->id; ?>" style="display: none;">
                                    <td></td>
                                    <td colspan="2">
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <a href="<?php echo base_url("Contract/file_form/$sub_contract->id"); ?>">
                                            <i class="fa fa-arrow-circle-o-right"
                                               style="color: green"></i> <?php echo $sub_contract->sozlesme_ad; ?>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    <?php endforeach; ?>
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