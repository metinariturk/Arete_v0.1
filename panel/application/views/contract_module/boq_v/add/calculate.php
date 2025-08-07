<?php if (isset($income)) { ?>
<?php $boq = $this->Contract_price_model->get(array("id" => $income)); ?>

<?php $income_contract_price = $this->Contract_price_model->get(array("id" => $income)); ?>
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-3 bg3d">
                <h5>2D/3D Metraj</h5>
            </div>
            <div class="col-9">
                <fieldset>
                    <div class="text-center mb-4">
                        <h5 class="mb-1 text-uppercase">
                            <?php echo contract_name($contract_id); ?> - <?php echo $payment->hakedis_no; ?> Nolu
                            Hakediş
                        </h5>
                        <p class="text-muted mb-1">
                            <?php echo $this->Contract_price_model->get_field_by_id($boq->main_id, "code"); ?> -
                            <?php echo $this->Contract_price_model->get_field_by_id($boq->main_id, "name"); ?>
                        </p>
                        <p class="text-muted mb-0">
                            <?php echo $this->Contract_price_model->get_field_by_id($boq->sub_id, "code"); ?> -
                            <?php echo $this->Contract_price_model->get_field_by_id($boq->sub_id, "name"); ?>
                        </p>
                        <h6 class="mt-2"><?php echo $boq->code; ?> - <?php echo $boq->name; ?> Metraj Formu</h6>
                    </div>

                    <hr class="my-4">

                    <div class="d-grid gap-2 mb-4">
                        <a onclick="renderCalculate(this)"
                           href="#"
                           data-bs-original-title=""
                           title=""
                           url="<?php echo base_url("Boq/rebar_render/$contract_id/$payment->id/$income"); ?>"
                           class="btn btn-primary btn-sm">
                            Donatı Metrajı Yap
                        </a>
                    </div>

                    <div class="row mb-3 align-items-center">
                        <!-- Önceki Hakedişler Toplamı -->
                        <label for="prependedcheckbox" class="col-lg-4 col-form-label text-lg-end">
                            Önceki Hakedişler Toplamı
                        </label>
                        <div class="col-lg-5">
                            <div class="form-control-plaintext">
                                <?php
                                echo $old_total = $this->Boq_model->sum_all(
                                    array(
                                        'contract_id' => $payment->contract_id,
                                        "payment_no <" => $payment->hakedis_no,
                                        "boq_id" => $income_contract_price->id
                                    ),
                                    "total"
                                );
                                ?>
                                <?php echo $income_contract_price->unit; ?>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3 align-items-center">
                        <!-- Manuel Giriş -->
                        <label for="toggleCheckbox" class="col-lg-4 col-form-label text-lg-end">
                            El İle Toplam Metraj Girişi
                        </label>

                        <div class="col-lg-5">
                            <div class="input-group">
                                <div class="input-group-text">
                                    <input type="checkbox"
                                           id="toggleCheckbox"
                                           name="bypass_total"
                                           class="form-check-input m-0"
                                           onclick="toggleReadOnly(<?php echo $income; ?>)">
                                </div>

                                <input type="text"
                                       class="form-control"
                                       id="total_<?php echo $income; ?>"
                                       name="total_<?php echo $income; ?>"
                                       value="<?php if (!empty($old_boq)) echo $old_boq->total; ?>"
                                       placeholder="0.00"
                                       readonly>

                                <span class="input-group-text"><?php echo $income_contract_price->unit; ?></span>
                            </div>
                        </div>

                        <div class="col-lg-3 mt-2 mt-lg-0">
                            <input type="hidden" name="boq_id" id="dont_delete" value="<?php echo $income; ?>">
                            <button type="button"
                                    class="btn btn-outline-primary w-100"
                                    onclick="saveManuel(this)"
                                    form="save_boq"
                                    data-url="<?php echo base_url("Boq/save_total/$contract_id/$payment->id"); ?>">
                                Manuel Girişi Kaydet
                            </button>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="container-fluid">
        <div style="text-align: right;">

            <a onclick="delete_boq(this)"
               url="<?php echo base_url("Boq/delete/$contract_id/$payment->hakedis_no/$income"); ?>">
                <i style="font-size: 18px; color: Tomato;" class="fa fa-times-circle-o"></i>
            </a>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <div class="container-fluid">
            <div class="row">

                <div class="col-6">
                    <label for="excelDosyasi" class="form-label">Excel Dosyası Seçin:</label>
                    <input type="file" id="excelDosyasi" name="excelDosyasi" accept=".xlsx, .xls"
                           class="form-control form-control-lg">
                </div>
                <div class="col-3">
                    <label for="formFileLg" class="form-label">&nbsp;</label>
                    <br>
                    <button
                            class="btn btn-outline-primary"
                            type="button"
                            data-bs-original-title=""
                            onclick="saveCalc(this)"
                            form="save_boq"
                            data-url="<?php echo base_url("Boq/save/$contract_id/$payment->id"); ?>"
                            title="">
                        <i class="fa fa-file-excel-o"></i> Excel Yükle
                    </button>
                </div>
                <div class="col-3">
                    <div class="dropdown">
                        <button class="btn btn-outline-primary dropdown-toggle w-100" type="button"
                                id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                            Şablon İndir
                        </button>
                        <ul class="dropdown-menu w-100" aria-labelledby="dropdownMenuButton">
                            <?php
                            $limits = [100, 250, 500, 1000, 2500];
                            foreach ($limits as $limit) {
                                $url = base_url("Boq/template_download/$contract_id/$payment->id/$income") . "?limit=$limit";
                                echo "<li><a class='dropdown-item' href='$url'>$limit Satır</a></li>";
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="card text-end">
            <button
                    class="btn btn-outline-primary"
                    type="button"
                    data-bs-original-title=""
                    onclick="saveCalc(this)"
                    form="save_boq"
                    data-url="<?php echo base_url("Boq/save/$contract_id/$payment->id"); ?>"
                    title="">
                Kaydet/Satır Ekle
            </button>
        </div>
        <div class="row">
            <div class="col-1">
                <strong>Sil</strong>
            </div>
            <div class="col-2">
                <strong>Bölüm</strong>
            </div>
            <div class="col-3">
                <strong>Açıklama</strong>
            </div>
            <div class="col-1">
                <strong>Adet</strong>
            </div>
            <div class="col-1">
                <strong>En</strong>
            </div>
            <div class="col-1">
                <strong>Boy</strong>
            </div>
            <div class="col-1">
                <strong>Yükseklik</strong>
            </div>
            <div class="col-2" style="text-align: right">
                <strong>Toplam</strong>
            </div>
        </div>
    </div>
    <?php $j = null; ?>
    <?php $range = 0; ?>
    <?php if (!empty($old_boq)) { ?>
        <?php $old_boqs = json_decode($old_boq->calculation, true); ?>
        <?php $i = 1; ?>
        <?php if (isset($old_boqs)) { ?>
            <?php foreach ($old_boqs as $row_no => $info) { ?>
                <?php $j = $i++; ?>
                <?php $range = count($old_boqs); ?>
                <div class="container-fluid">
                    <div class="row" id="row_<?php echo $old_boq->boq_id; ?>_<?php echo $j; ?>">
                        <div class="col-1" style="margin: 0; padding: 0;">
                            <button type="button" class="btn btn-danger btn-sm"
                                    onclick="removeRow('row_<?php echo $old_boq->boq_id; ?>_<?php echo $j; ?>')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                        <div class="col-2 mb-1" style="margin: 0; padding: 0;">
                            <input name="boq[<?php echo $j; ?>][s]" style="width: 100%"
                                   id="s_<?php echo $old_boq->boq_id; ?>_<?php echo $j; ?>"
                                   value="<?php echo $info['s']; ?>"
                                   onclick="calculateAndSetResult(<?php echo $old_boq->boq_id; ?>, <?php echo $j; ?>)"
                                   onblur="calculateAndSetResult(<?php echo $old_boq->boq_id; ?>, <?php echo $j; ?>)"
                                   type="text">
                        </div>
                        <div class="col-3" style="margin: 0; padding: 0;">
                            <input name="boq[<?php echo $j; ?>][n]" style="width: 100%"
                                   id="n_<?php echo $old_boq->boq_id; ?>_<?php echo $j; ?>"
                                   value="<?php echo $info['n']; ?>"
                                   onclick="calculateAndSetResult(<?php echo $old_boq->boq_id; ?>, <?php echo $j; ?>)"
                                   onblur="calculateAndSetResult(<?php echo $old_boq->boq_id; ?>, <?php echo $j; ?>)"
                                   type="text">
                        </div>
                        <div class="col-1" style="margin: 0; padding: 0;">
                            <input name="boq[<?php echo $j; ?>][q]" style="width: 100%"
                                   id="q_<?php echo $old_boq->boq_id; ?>_<?php echo $j; ?>"
                                   value="<?php echo $info['q']; ?>"
                                   onclick="calculateAndSetResult(<?php echo $old_boq->boq_id; ?>, <?php echo $j; ?>)"
                                   onblur="calculateAndSetResult(<?php echo $old_boq->boq_id; ?>, <?php echo $j; ?>)"
                                   type="number" step="any">
                        </div>
                        <div class="col-1" style="margin: 0; padding: 0;">
                            <input name="boq[<?php echo $j; ?>][w]" style="width: 100%"
                                   id="w_<?php echo $old_boq->boq_id; ?>_<?php echo $j; ?>"
                                   value="<?php echo $info['w']; ?>"
                                   onclick="calculateAndSetResult(<?php echo $old_boq->boq_id; ?>, <?php echo $j; ?>)"
                                   onblur="calculateAndSetResult(<?php echo $old_boq->boq_id; ?>, <?php echo $j; ?>)"
                                   type="number" step="any">
                        </div>
                        <div class="col-1" style="margin: 0; padding: 0;" id="h_<?php echo $j; ?>">
                            <input name="boq[<?php echo $j; ?>][h]" style="width: 100%"
                                   id="h_<?php echo $old_boq->boq_id; ?>_<?php echo $j; ?>"
                                   value="<?php echo $info['h']; ?>"
                                   onclick="calculateAndSetResult(<?php echo $old_boq->boq_id; ?>, <?php echo $j; ?>)"
                                   onblur="calculateAndSetResult(<?php echo $old_boq->boq_id; ?>, <?php echo $j; ?>)"
                                   type="number" step="any">
                        </div>
                        <div class="col-1" style="margin: 0; padding: 0;" id="l_<?php echo $j; ?>">
                            <input name="boq[<?php echo $j; ?>][l]" style="width: 100%"
                                   id="l_<?php echo $old_boq->boq_id; ?>_<?php echo $j; ?>"
                                   value="<?php echo $info['l']; ?>"
                                   onclick="calculateAndSetResult(<?php echo $old_boq->boq_id; ?>, <?php echo $j; ?>)"
                                   onblur="calculateAndSetResult(<?php echo $old_boq->boq_id; ?>, <?php echo $j; ?>)"
                                   type="number" step="any">
                        </div>
                        <div class="col-2" style="margin: 0; padding: 0;" id="t_<?php echo $j; ?>">
                            <input readonly name="boq[<?php echo $j; ?>][t]" style="width: 100%"
                                   id="t_<?php echo $old_boq->boq_id; ?>_<?php echo $j; ?>"
                                   value="<?php echo isset($info['t']) ? $info['t'] : ''; ?>"
                                   onclick="calculateAndSetResult(<?php echo $old_boq->boq_id; ?>, <?php echo $j; ?>)"
                                   onblur="calculateAndSetResult(<?php echo $old_boq->boq_id; ?>, <?php echo $j; ?>)"
                                   type="number" step="any">
                        </div>
                    </div>
                </div>
            <?php } ?>
        <?php } ?>
    <?php } ?>

    <?php $row_numbers = range($j + 1, $j + 11); ?>
    <?php foreach ($row_numbers as $row_number) { ?>
        <div class="container-fluid">
            <div class="row" id="row_<?php echo $income; ?>_<?php echo $row_number; ?>">
                <div class="col-1" style="margin: 0; padding: 0;">
                    &nbsp;
                </div>
                <div class="col-2 mb-1" style="margin: 0; padding: 0;">
                    <input name="boq[<?php echo $row_number; ?>][s]" style="width: 100%"
                           id="s_<?php echo $income; ?>_<?php echo $row_number; ?>"
                           onclick="calculateAndSetResult(<?php echo $income; ?>, <?php echo $row_number; ?>)"
                           onblur="calculateAndSetResult(<?php echo $income; ?>, <?php echo $row_number; ?>)"
                           type="text">
                </div>
                <div class="col-3" style="margin: 0; padding: 0;">
                    <input name="boq[<?php echo $row_number; ?>][n]" style="width: 100%"
                           id="n_<?php echo $income; ?>_<?php echo $row_number; ?>"
                           onclick="calculateAndSetResult(<?php echo $income; ?>, <?php echo $row_number; ?>)"
                           onblur="calculateAndSetResult(<?php echo $income; ?>, <?php echo $row_number; ?>)"
                           type="text">
                </div>
                <div class="col-1" style="margin: 0; padding: 0;">
                    <input name="boq[<?php echo $row_number; ?>][q]" style="width: 100%"
                           id="q_<?php echo $income; ?>_<?php echo $row_number; ?>"
                           onclick="calculateAndSetResult(<?php echo $income; ?>, <?php echo $row_number; ?>)"
                           onblur="calculateAndSetResult(<?php echo $income; ?>, <?php echo $row_number; ?>)"
                           type="number" step="any">
                </div>
                <div class="col-1" style="margin: 0; padding: 0;">
                    <input name="boq[<?php echo $row_number; ?>][w]" style="width: 100%"
                           id="w_<?php echo $income; ?>_<?php echo $row_number; ?>"
                           onclick="calculateAndSetResult(<?php echo $income; ?>, <?php echo $row_number; ?>)"
                           onblur="calculateAndSetResult(<?php echo $income; ?>, <?php echo $row_number; ?>)"
                           type="number" step="any">
                </div>
                <div class="col-1" style="margin: 0; padding: 0;" id="h_<?php echo $row_number; ?>">
                    <input name="boq[<?php echo $row_number; ?>][h]" style="width: 100%"
                           id="h_<?php echo $income; ?>_<?php echo $row_number; ?>"
                           onclick="calculateAndSetResult(<?php echo $income; ?>, <?php echo $row_number; ?>)"
                           onblur="calculateAndSetResult(<?php echo $income; ?>, <?php echo $row_number; ?>)"
                           type="number" step="any">
                </div>
                <div class="col-1" style="margin: 0; padding: 0;" id="l_<?php echo $row_number; ?>">
                    <input name="boq[<?php echo $row_number; ?>][l]" style="width: 100%"
                           id="l_<?php echo $income; ?>_<?php echo $row_number; ?>"
                           onclick="calculateAndSetResult(<?php echo $income; ?>, <?php echo $row_number; ?>)"
                           onblur="calculateAndSetResult(<?php echo $income; ?>, <?php echo $row_number; ?>)"
                           type="number" step="any">
                </div>
                <div class="col-2" style="margin: 0; padding: 0;" id="t_<?php echo $row_number; ?>">
                    <input readonly name="boq[<?php echo $row_number; ?>][t]" style="width: 100%"
                           id="t_<?php echo $income; ?>_<?php echo $row_number; ?>"
                           onclick="calculateAndSetResult(<?php echo $income; ?>, <?php echo $row_number; ?>)"
                           onblur="calculateAndSetResult(<?php echo $income; ?>, <?php echo $row_number; ?>)"
                           type="number" step="any">
                </div>
            </div>
        </div>
    <?php } ?>
    <div class="container-fluid">
        <div class="card text-end">
            <button
                    class="btn btn-outline-primary"
                    type="button"
                    data-bs-original-title=""
                    onclick="saveCalc(this)"
                    form="save_boq"
                    data-url="<?php echo base_url("Boq/save/$contract_id/$payment->id"); ?>"
                    title="">
                Kaydet/Satır Ekle
            </button>
        </div>
    </div>
    <?php } else { ?>
        <?php $income = 0; ?>
        <div class="card" style="height: 150px">
            <div class="card-body">
                <h4 class="m-t-10 text-center"><?php echo contract_name($contract->id); ?> </h4>
                <h5 class="text-center"> <?php echo $payment->hakedis_no; ?> Nolu Hakediş </h5>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                Soldaki Menüden İmalat Seçiniz
            </div>
        </div>
    <?php } ?>

</div>
<script>
    function renderCalculate(btn) {
        var $url = btn.getAttribute('url');

        $.post($url, {}, function (response) {
            $(".dynamic").html(response);

        })
    }
</script>

<script>
    function delete_boq(btn) {
        var $url = btn.getAttribute('url');

        Swal.fire({
            title: "Metrajı Silmek İstediğine Emin Misin?",
            text: "Bu işlem geri alınamaz!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Sil",
            cancelButtonText: "İptal",
            dangerMode: true,
        }).then((result) => {
            if (result.isConfirmed) {
                $.post($url, {}, function (response) {
                    $(".dynamic").html(response);
                });

                Swal.fire("Metraj Başarılı Bir Şekilde Silindi", {
                    icon: "success",
                });

            } else {
                Swal.fire("Metraj Güvende");
            }
        });
    }
</script>


<script>
    function saveCalc(btn) {

        calculateAndSetResult(<?php echo $income; ?>, 1);

        var url = btn.getAttribute('data-url');
        var formId = btn.getAttribute('form');


        // Serialize the form data
        var formData = new FormData(document.getElementById(formId));

        // Send an AJAX POST request
        $.ajax({
            type: 'POST',
            url: url,
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                // Assuming the response contains the updated content
                $(".dynamic").html(response);
                calculateAndSetResult(<?php echo $income; ?>, 1);
                var autoRefreshButton = document.querySelector('.auto-refresh-button');
                if (autoRefreshButton) {
                    autoRefreshButton.click();
                }

            },
            error: function (xhr, status, error) {
                console.log(error);
            }
        });
    }
</script>
<script>
    function renderGroup(btn) {
        var $url = btn.getAttribute('url');

        $.post($url, {}, function (response) {
            $(".renderGroup").html(response);
        })
    }
</script>
<script>
    function auto_refresh_list() {
        var contractId = document.getElementById("myElement").getAttribute("data-contract-id");
        var paymentNo = document.getElementById("myElement").getAttribute("data-payment-no");
        var groupId = document.getElementById("myElement").getAttribute("data-group-id");

        var url = base_url + "/" + this.Module_Name + "/select_group/" + contractId + "/" + paymentNo + "/" + groupId;

        $.post($url, {}, function (response) {
            $(".renderGroup").html(response);
        })
    }
</script>
<script>
    function calculateAndSetResult(income, row_number) {
        var totalResult = 0;
        var total = 0; // Toplamı saklamak için bir değişken tanımlayın
        var allEmpty = true; // Tüm q, w, h, l değerleri boş mu?

        for (var i = 1; i <= <?php echo $j + 11; ?>; i++) {
            var q = parseFloat(document.getElementById('q_' + income + '_' + i).value);
            var w = parseFloat(document.getElementById('w_' + income + '_' + i).value);
            var h = parseFloat(document.getElementById('h_' + income + '_' + i).value);
            var l = parseFloat(document.getElementById('l_' + income + '_' + i).value);

            var qElement = document.getElementById('q_' + income + '_' + i);
            if (qElement) {
                var q = parseFloat(qElement.value);
                // Diğer işlemleri yapın
            } else {
                console.log("Element bulunamadı: q_" + income + "_" + i);
            }

            var n = document.getElementById('n_' + income + '_' + i).value.toLowerCase();

            var forbiddenWord = 'minha';

            var qInput = document.getElementById('q_' + income + '_' + i);
            var wInput = document.getElementById('w_' + income + '_' + i);
            var nInput = document.getElementById('n_' + income + '_' + i);
            var sInput = document.getElementById('s_' + income + '_' + i);
            var hInput = document.getElementById('h_' + income + '_' + i);
            var lInput = document.getElementById('l_' + income + '_' + i);
            var tInput = document.getElementById('t_' + income + '_' + i);

            if (n.includes(forbiddenWord)) {
                qInput.style.backgroundColor = 'rgba(246,145,98,0.66)';
                wInput.style.backgroundColor = 'rgba(246,145,98,0.66)';
                hInput.style.backgroundColor = 'rgba(246,145,98,0.66)';
                lInput.style.backgroundColor = 'rgba(246,145,98,0.66)';
                tInput.style.backgroundColor = 'rgba(246,145,98,0.66)';
                nInput.style.backgroundColor = 'rgba(246,145,98,0.66)';
                sInput.style.backgroundColor = 'rgba(246,145,98,0.66)';
            } else {
                qInput.style.backgroundColor = '';
                wInput.style.backgroundColor = '';
                hInput.style.backgroundColor = '';
                lInput.style.backgroundColor = '';
                tInput.style.backgroundColor = '';
                nInput.style.backgroundColor = '';
                sInput.style.backgroundColor = '';
            }

            // Değerler boşsa, t değerini 0 olarak ayarla
            if (isNaN(q) && isNaN(w) && isNaN(h) && isNaN(l)) {
                document.getElementById('t_' + income + '_' + i).value = "0";
            } else {
                q = isNaN(q) ? 1 : q;
                w = isNaN(w) ? 1 : w;
                h = isNaN(h) ? 1 : h;
                l = isNaN(l) ? 1 : l;

                var m = n.includes(forbiddenWord) ? -1 : 1;

                var result = m * q * w * h * l;
                result = result.toFixed(2);
                document.getElementById('t_' + income + '_' + i).value = result;
                totalResult += parseFloat(result);
                allEmpty = false; // En az bir değer dolu, allEmpty değerini false yap
            }

        }

        if (allEmpty) {
            document.getElementById('total_' + income).value = "0";
        } else {
            document.getElementById('total_' + income).value = totalResult.toFixed(2);
        }

    }

</script>
<script>
    function toggleReadOnly(income) {
        var toggleCheckbox = document.getElementById('toggleCheckbox');
        var readonlyInput = document.getElementById('total_' + income);

        readonlyInput.readOnly = !toggleCheckbox.checked;

        var pointerEventsValue = toggleCheckbox.checked ? "none" : "auto"; // pointerEvents ayarı

        for (var i = 1; i <= <?php echo $j + 11; ?>; i++) {
            var qInput = document.getElementById('q_' + income + '_' + i);
            var wInput = document.getElementById('w_' + income + '_' + i);
            var nInput = document.getElementById('n_' + income + '_' + i);
            var sInput = document.getElementById('s_' + income + '_' + i);
            var hInput = document.getElementById('h_' + income + '_' + i);
            var lInput = document.getElementById('l_' + income + '_' + i);
            var tInput = document.getElementById('t_' + income + '_' + i);

            qInput.readOnly = toggleCheckbox.checked;
            qInput.style.pointerEvents = pointerEventsValue;
            wInput.readOnly = toggleCheckbox.checked;
            wInput.style.pointerEvents = pointerEventsValue;
            nInput.readOnly = toggleCheckbox.checked;
            nInput.style.pointerEvents = pointerEventsValue;
            sInput.readOnly = toggleCheckbox.checked;
            sInput.style.pointerEvents = pointerEventsValue;
            hInput.readOnly = toggleCheckbox.checked;
            hInput.style.pointerEvents = pointerEventsValue;
            lInput.readOnly = toggleCheckbox.checked;
            lInput.style.pointerEvents = pointerEventsValue;
            tInput.readOnly = toggleCheckbox.checked;
            tInput.style.pointerEvents = pointerEventsValue;
        }
    }
</script>

<script>
    function removeRow(rowId) {
        var row = document.getElementById(rowId);
        if (row) {
            // Satırdaki tüm input ve select elemanlarını bul
            var inputs = row.querySelectorAll('input');
            var selects = row.querySelectorAll('select');

            // Tüm inputların değerini sıfırla
            inputs.forEach(function (input) {
                if (input.type === 'text' || input.type === 'number') {
                    input.value = '';
                }
            });

            // Tüm select elemanlarının değerini boş değere (null) getir
            selects.forEach(function (select) {
                select.value = '';
                if (select.options.length > 0 && select.options[0].value === '') {
                    select.selectedIndex = 0;
                }
            });

            // Satırı HTML sayfasında gizle
            row.style.display = 'none';

            // Toplamı manuel olarak güncelle ki kullanıcı gizlenen satırın etkisini hemen görebilsin
            calculateAndSetResult(<?php echo $income; ?>, 1);
        }
    }
</script>

<script>
    function removerebarRow(rowId) {
        var row = document.getElementById(rowId);
        if (row) {
            // Satırdaki tüm input ve select elemanlarını bul
            var inputs = row.querySelectorAll('input');
            var selects = row.querySelectorAll('select');

            // Tüm inputların değerini sıfırla
            inputs.forEach(function (input) {
                if (input.type === 'text' || input.type === 'number') {
                    input.value = '';
                }
            });

            // Tüm select elemanlarının değerini boş değere (null) getir
            selects.forEach(function (select) {
                select.value = '';
                if (select.options.length > 0 && select.options[0].value === '') {
                    select.selectedIndex = 0;
                }
            });

            // Satırı HTML sayfasında gizle
            row.style.display = 'none';

            // Toplamı manuel olarak güncelle ki kullanıcı gizlenen satırın etkisini hemen görebilsin
            calculaterebarAndSetResult(<?php echo $income; ?>, 1);
        }
    }
</script>
