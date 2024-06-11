<button type="button" class="btn btn-primary mt-5" data-bs-toggle="modal" data-bs-target="#myModal">
    Yeni Proje Ekle
</button>

<!-- The Modal -->
<div class="modal fade" id="myModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Yeni Proje</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
            </div>
            <!-- Modal Body -->
            <div class="modal-body">
                <form id="project_form"
                      action="<?php echo base_url("$this->Module_Name/save/"); ?>"
                      method="post"
                      enctype="multipart/form-data"
                      autocomplete="off">
                    <div class="mb-3">
                        <div class="col-form-label">Proje Kodu</div>
                        <div class="input-group"><span class="input-group-text" id="inputGroupPrepend">PRJ</span>
                            <?php if (!empty(get_last_fn("project"))) { ?>
                                <input class="form-control <?php cms_isset(form_error("proje_kodu"), "is-invalid", ""); ?>"
                                       type="number" placeholder="Proje Kodu" aria-describedby="inputGroupPrepend"
                                       data-bs-original-title="" title="" name="proje_kodu"
                                       value="<?php echo isset($form_error) ? set_value("proje_kodu") : increase_code_suffix("contract"); ?>">
                                <?php
                            } else { ?>
                                <input class="form-control <?php cms_isset(form_error("proje_kodu"), "is-invalid", ""); ?>"
                                       type="number" placeholder="Proje Kodu" aria-describedby="inputGroupPrepend"
                                       required="" data-bs-original-title="" title="" name="proje_kodu"
                                       value="<?php echo isset($form_error) ? set_value("proje_kodu") : fill_empty_digits() . "1" ?>">
                            <?php } ?>

                            <?php if (isset($form_error)) { ?>
                                <div class="invalid-feedback"><?php echo form_error("proje_kodu"); ?></div>
                                <div class="invalid-feedback">* Önerilen Proje Kodu
                                    : <?php echo increase_code_suffix("project"); ?>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="proje_ad" class="form-label">Proje Adı:</label>
                        <input type="text" class="form-control" name="proje_ad"
                               placeholder="Proje Adı">
                    </div>
                    <div class="mb-3">
                        <label for="bank" class="form-label">Proje Türü:</label>
                        <select id="select2-demo-1" style="width: 100%;"
                                class="form-control <?php cms_isset(form_error("department"), "is-invalid", ""); ?>"
                                data-plugin="select2" name="department">
                            <option selected="selected">Seçiniz</option>
                            <?php $departments = get_as_array($settings->department);
                            foreach ($departments as $department) { ?>
                                <option><?php echo $department; ?></option>
                            <?php } ?>
                        </select>
                        <?php if (isset($form_error)) { ?>
                            <div class="invalid-feedback"><?php echo form_error("department"); ?></div>
                        <?php } ?>
                    </div>
                    <div class="mb-3">
                        <label for="genel_bilgi" class="form-label">Genel Bilgi:</label>
                        <input type="text" class="form-control" name="genel_bilgi" placeholder="Genel Açıklama">
                    </div>
                </form>
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat
                </button>
                <button type="button" onclick="savePersonel(this)" data-bs-dismiss="modal"
                        class="btn btn-primary">Kaydet
                </button>
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
                                <td><?php echo $item->proje_ad; ?></td>
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