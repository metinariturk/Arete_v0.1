<div class="fade tab-pane <?php if ($active_tab == "personel") {
    echo "active show";
} ?>"
     id="personel" role="tabpanel"
     aria-labelledby="workgroup-tab">
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
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
                                            <input type="text" class="form-control" name="name_surname" placeholder="Adınız ve Soyadınız">
                                        </div>
                                        <div class="mb-3">
                                            <label for="group" class="form-label">Meslek:</label>
                                            <select class="form-select" name="group">
                                                <option value="" selected disabled>Seçiniz</option>
                                                <?php foreach ($workgroups as $active_workgroup => $workgroups) {
                                                    foreach ($workgroups as $workgroup) { ?>
                                                        <option value="<?php echo $workgroup; ?>"> <?php echo group_name($workgroup); ?></option>
                                                    <?php } ?>
                                                <?php } ?>
                                                <?php $active_workmachines = json_decode($item->active_machines, true); ?>
                                                <?php foreach ($workmachines as $active_workmachines => $workmachines) {
                                                    foreach ($workmachines as $workmachine) { ?>
                                                        <option value="<?php echo $workmachine; ?>"> <?php echo machine_name($workmachine); ?></option>
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
                                            <input type="text" class="form-control" name="IBAN" placeholder="Banka Hesap Numaranız">
                                        </div>
                                        <div class="mb-3">
                                            <label for="social_id" class="form-label">TC Kimlik No:</label>
                                            <input type="text" class="form-control" name="social_id" placeholder="TC Kimlik Numaranız">
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
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
                                    <button type="button" onclick="savePersonel(this)" data-bs-dismiss="modal" class="btn btn-primary">Kaydet</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </div>

        <div class="card-body">
            <div class="personel_list">
                <form id="personel_form"
                      action="<?php echo base_url("$this->Module_Name/update_personel/$item->id"); ?>" method="post"
                      enctype="multipart/form-data" autocomplete="off">
                    <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/modules/personel_liste"); ?>
                </form>
            </div>
        </div>
    </div>
</div>



<script>
    function savePersonel(btn) {
        var formId = "personel_form"; // doğru form ID'si olduğundan emin olun
        var formData = new FormData(document.getElementById(formId));

        var url = document.getElementById(formId).getAttribute('action');

        // Send an AJAX POST request
        $.ajax({
            type: 'POST',
            url: url,
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                // Assuming the response contains the updated content
                $(".personel_list").html(response);

                // Clear input fields after successful submission
                document.getElementById(formId).reset();
            },
            error: function (xhr, status, error) {
                console.log(error);
            }
        });
    }
</script>

