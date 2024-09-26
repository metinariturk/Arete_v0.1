<div class="card mb-0">
    <div class="card-header d-flex">
        <h6 class="mb-0">Puantaj</h6>
        <ul>
            <li>
                <button type="button" class="btn btn-primary mt-5" data-bs-toggle="modal" data-bs-target="#myModal">
                    Yeni Personel Ekle
                </button>

                <!-- The Modal -->
                <div class="modal fade" id="myModal">
                    <div class="modal-dialog">
                        <div class="modal-content">

                            <!-- Modal Header -->
                            <div class="modal-header">
                                <h4 class="modal-title">Kişisel Bilgi Formu</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                            </div>
                            <!-- Modal Body -->
                            <div class="modal-body">
                                <form id="personel_form"
                                      action="<?php echo base_url("$this->Module_Name/save_personel/$item->id"); ?>"
                                      method="post"
                                      enctype="multipart/form-data"
                                      autocomplete="off">
                                    <div class="mb-3">
                                        <label for="name_surname" class="form-label">Ad Soyad:</label>
                                        <input type="text" class="form-control" name="name_surname"
                                               placeholder="Adınız ve Soyadınız">
                                    </div>
                                    <div class="mb-3">
                                        <label for="group" class="form-label">Meslek:</label>
                                        <select class="form-select" name="group">
                                            <option value="" selected disabled>Seçiniz</option>
                                            <?php if (!empty($workgroups)) { ?>}
                                                <?php foreach ($workgroups as $active_workgroup => $workgroups) {
                                                    foreach ($workgroups as $workgroup) { ?>
                                                        <option value="<?php echo $workgroup; ?>"> <?php echo group_name($workgroup); ?></option>
                                                    <?php } ?>
                                                <?php } ?>
                                            <?php } ?>
                                            <?php if (!empty($workmachines)) { ?>}
                                                <?php foreach ($workmachines as $active_workmachines => $workmachines) {
                                                    foreach ($workmachines as $workmachine) { ?>
                                                        <option value="<?php echo $workmachine; ?>"> <?php echo machine_name($workmachine); ?></option>
                                                    <?php } ?>
                                                <?php } ?>
                                            <?php } ?>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="bank" class="form-label">Banka Adı:</label>
                                        <input type="text" class="form-control" name="bank" placeholder="Banka Adı">
                                    </div>
                                    <div class="mb-3">
                                        <label for="IBAN" class="form-label">Banka Hesap No:</label>
                                        <input type="text" class="form-control" name="IBAN"
                                               placeholder="Banka Hesap Numaranız">
                                    </div>
                                    <div class="mb-3">
                                        <label for="social_id" class="form-label">TC Kimlik No:</label>
                                        <input type="text" class="form-control" name="social_id"
                                               placeholder="TC Kimlik Numaranız">
                                    </div>
                                    <div class="mb-3">
                                        <label for="start_date" class="form-label">Giriş Tarihi:</label>
                                        <input class="datepicker-here form-control digits"
                                               type="text"
                                               name="start_date"
                                               value="<?php echo date('d-m-Y'); ?>"
                                               data-options="{ format: 'DD-MM-YYYY' }"
                                               data-language="tr">
                                    </div>
                                    <div class="mb-3">
                                        <label for="end_date" class="form-label">Çıkış Tarihi:</label>
                                        <input class="datepicker-here form-control digits"
                                               type="text"
                                               name="end_date"
                                               value=""
                                               data-options="{ format: 'DD-MM-YYYY' }"
                                               data-language="tr">
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
            </li>
        </ul>
    </div>

    <div class="row">
        <div class="col-9">
            <div class="personel_list">
                <?php if (!empty(validation_errors())) { ?>
                    <div class="alert alert-light-secondary" role="alert">
                        <p style="font-size: 25px" class="txt-secondary">Aşağıdaki uyarıları inceleyiniz</p>
                        <?php echo validation_errors(); ?>
                    </div>
                <?php } ?>
                <div class="container">
                    <div class="row">
                        <div class="col text-start">
                            <a class="btn btn-pill btn-success btn-lg" href="#" isActive="1" onclick="sendPersonelData(this)">
                                <i class="fa fa-print"></i> Çalışanları Yazdır
                            </a>
                        </div>
                        <div class="col text-end">
                            <a class="btn btn-pill btn-info btn-lg" href="#" isActive="0" onclick="sendPersonelData(this)">
                                <i class="fa fa-print"></i> Tümünü Yazdır
                            </a>
                        </div>
                        <div class="col-12">
                            <div>
                                <h3 class="text-center">
                                    Personel Listesi
                                </h3>
                                <table style="border-collapse: collapse; width: 100%;">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Adı Soyadı</th>
                                        <th>TC Kimlik No</th>
                                        <th>Branş</th>
                                        <th>İşe Giriş/Çıkış</th>
                                        <th>Hesap No</th>
                                        <th>Banka</th>
                                        <th>İşlem</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $i = 1;
                                    foreach ($personel_datas as $personel_data) { ?>
                                        <tr style="height: 30px; border: 1px solid black;">
                                            <td style="border: 1px solid black;"> <?php echo $i++; ?></td>
                                            <td style="border: 1px solid black;"> <?php echo $personel_data->name_surname; ?></td>
                                            <td style="border: 1px solid black;"> <?php echo $personel_data->social_id; ?></td>
                                            <td style="border: 1px solid black;"> <?php echo group_name($personel_data->group); ?></td>
                                            <td style="border: 1px solid black;">
                                                <?php echo dateFormat_dmy($personel_data->start_date); ?> /
                                                <?php if (!empty($personel_data->end_date)) { ?>
                                                    <?php echo dateFormat_dmy($personel_data->end_date); ?>
                                                <?php } else { ?>
                                                    Çalışıyor
                                                <?php } ?>
                                            </td>
                                            <td style="border: 1px solid black;"> <?php echo $personel_data->IBAN; ?> </td>
                                            <td style="border: 1px solid black;"> <?php echo $personel_data->bank; ?> </td>
                                            <td style="border: 1px solid black;">
                                                <i class="fa fa-edit" name="personel_id"
                                                   onclick="updatePersonelForm(this)"
                                                   workerid="<?php echo $personel_data->id; ?>"></i>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-3">
            <div class="personel_update_form">
                <form id="personel_form"
                      action="<?php echo base_url("$this->Module_Name/update_personel/$item->id"); ?>"
                      method="post"
                      enctype="multipart/form-data" autocomplete="off">
                    <h3 class="text-center">
                        Personel Güncelle
                    </h3>
                    <?php if (isset($worker)) { ?>
                        <form id="update_form"
                              action="<?php echo base_url("$this->Module_Name/update_personel/$worker->id/$item->id"); ?>"
                              method="post"
                              enctype="multipart/form-data"
                              autocomplete="off">
                            <div class="mb-3">
                                <label for="name_surname" class="form-label">Ad Soyad:</label>
                                <input type="text" class="form-control" name="name_surname"
                                       value="<?php if (isset($worker)) {
                                           echo $worker->name_surname;
                                       } ?>"
                                       placeholder="Adınız ve Soyadınız">
                            </div>
                            <div class="mb-3">
                                <label for="group" class="form-label">Meslek:</label>
                                <select id="select2-demo-1" style="width: 100%;"
                                        class="form-control <?php cms_isset(form_error("group"), "is-invalid", ""); ?>"
                                        data-plugin="select2" name="group">
                                    <option selected="selected"
                                            value="<?php echo isset($form_error) ? set_value("group") : $worker->group; ?>"> <?php echo isset($form_error) ? group_name(set_value("group")) : group_name($worker->group); ?>
                                    </option>
                                    <?php foreach ($workgroups as $active_workgroup => $workgroups) {
                                        foreach ($workgroups as $workgroup) { ?>
                                            <option value="<?php echo $workgroup; ?>"> <?php echo group_name($workgroup); ?></option>
                                        <?php } ?>
                                    <?php } ?>

                                </select>
                                <?php if (isset($form_error)) { ?>
                                    <div class="invalid-feedback"><?php echo form_error("group"); ?></div>
                                <?php } ?>
                            </div>
                            <div class="mb-3">
                                <label for="social_id" class="form-label">TC Kimlik No:</label>
                                <input type="number"
                                       class="form-control <?php cms_isset(form_error("social_id"), "is-invalid", ""); ?>"
                                       name="social_id"
                                       placeholder="TC Kimlik No"
                                       value="<?php echo isset($form_error) ? set_value("social_id") : "$worker->social_id"; ?>">
                                <?php if (isset($form_error)) { ?>
                                    <div class="invalid-feedback"><?php echo form_error("social_id"); ?></div>
                                <?php } ?>
                            </div>
                            <div class="mb-3">
                                <label for="bank" class="form-label">Banka Adı:</label>
                                <select id="select2-demo-1" style="width: 100%;"
                                        class="form-control <?php cms_isset(form_error("bank"), "is-invalid", ""); ?>"
                                        data-plugin="select2" name="bank">
                                    <option selected="selected"> <?php echo isset($form_error) ? (set_value("bank")) : $worker->bank; ?></option>
                                    <?php $banks = get_as_array($settings->bankalar);
                                    foreach ($banks as $bank) { ?>
                                        <option><?php echo $bank; ?></option>
                                    <?php } ?>
                                </select>
                                <?php if (isset($form_error)) { ?>
                                    <div class="invalid-feedback"><?php echo form_error("bank"); ?></div>
                                <?php } ?>
                            </div>
                            <div class="mb-3">
                                <label for="IBAN" class="form-label">Banka Hesap No:</label>
                                <input class="form-control <?php cms_isset(form_error("IBAN"), "is-invalid", ""); ?>"
                                       name="IBAN"
                                       placeholder="IBAN"
                                       value="<?php echo isset($form_error) ? set_value("IBAN") : "$worker->IBAN"; ?>">
                                <?php if (isset($form_error)) { ?>
                                    <div class="invalid-feedback"><?php echo form_error("IBAN"); ?></div>
                                <?php } ?>
                            </div>

                            <div class="mb-3">
                                <label for="start_date" class="form-label">Giriş Tarihi:</label>
                                <input class="datepicker-here form-control digits <?php cms_isset(form_error("start_date"), "is-invalid", ""); ?>"
                                       type="text"
                                       name="start_date"
                                       value="<?php echo isset($form_error) ? set_value("start_date") : dateFormat('d-m-Y', $worker->start_date); ?>"
                                       data-options="{ format: 'DD-MM-YYYY' }"
                                       data-language="tr">
                                <?php if (isset($form_error)) { ?>
                                    <div class="invalid-feedback"><?php echo form_error("start_date"); ?></div>
                                <?php } ?>
                            </div>
                            <div class="mb-3">
                                <label for="end_date" class="form-label">Çıkış Tarihi:</label>
                                <input class="datepicker-here form-control digits <?php cms_isset(form_error("end_date"), "is-invalid", ""); ?>"
                                       type="text"
                                       name="end_date"
                                    <?php if (!empty($worker->end_date)) { ?>
                                        value="<?php echo isset($form_error) ? set_value("end_date") : dateFormat('d-m-Y', $worker->end_date); ?>"
                                    <?php } else { ?>
                                        value="<?php echo isset($form_error) ? set_value("end_date") : "" ?>"
                                    <?php } ?>
                                       data-options="{ format: 'DD-MM-YYYY' }"
                                       data-language="tr">
                                <?php if (isset($form_error)) { ?>
                                    <div class="invalid-feedback"><?php echo form_error("end_date"); ?></div>
                                <?php } ?>
                            </div>
                            <div class="mb-3">
                                <a class="btn btn-success" onclick="updatePersonel(this)" form_id="update_form" url="<?php echo base_url("$this->Module_Name/update_personel/$worker->id/$item->id"); ?>">
                                    <i class="menu-icon fa fa-floppy-o fa-lg" aria-hidden="true"></i> Güncelle
                                </a>
                            </div>
                        </form>
                    <?php } ?>


                </form>
            </div>
        </div>
    </div>
</div>


