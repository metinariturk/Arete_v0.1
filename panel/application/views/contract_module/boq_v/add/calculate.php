<?php if (isset($income)) { ?>
<div class="card">
    <div class="card-body">
        <fieldset>
            <h4 class="m-t-10 text-center"><?php echo contract_name($contract_id); ?></h4>
            <h4 class="m-t-10 text-center"> <?php echo $payment->hakedis_no; ?> Nolu Hakediş</h4>
            <h5 class="text-center"><?php echo get_from_any("contract_price", "name", "id", "$income"); ?> </h5>
            <h6 class="text-center">Metraj Formu</h6>
            <hr>
            <div class="mb-3 row">
                <label class="col-lg-3 form-label text-lg-start" for="prependedcheckbox">El İle Toplam Metraj
                    Girişi</label>
                <div class="col-lg-4">
                    <div class="input-group">
                        <span class="input-group-text">
                            <input type="checkbox" id="toggleCheckbox" name="bypass_total"
                                   onclick="toggleReadOnly(<?php echo $income; ?>)">
                        </span>
                        <input id="total_<?php echo $income; ?>" readonly name="total_<?php echo $income; ?>"
                               value="<?php if (!empty($old_boq)) {
                                   echo $old_boq->total;
                               } ?>"
                               class="form-control btn-square" type="text" placeholder=""><span
                                class="input-group-text"><?php echo boq_unit($income); ?></span>
                        <input name="boq_id" hidden id="dont_delete" value="<?php echo $income; ?>">
                    </div>
                </div>
            </div>
        </fieldset>
    </div>
</div>
<div class="row">
    <div class="container-fluid">
        <div style="text-align: right;">
            <a onclick="resetInputValues()">
                <i style="font-size: 18px; color: Tomato;" class="fa-regular fa-square-minus"
                   aria-hidden="true"></i>
            </a>

            <a onclick="delete_boq(this)"
               url="<?php echo base_url("$this->Module_Name/delete/$contract_id/$payment->hakedis_no/$income"); ?>">
                <i style="font-size: 18px; color: Tomato;" class="fa fa-times-circle-o"></i>
            </a>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <div class="container-fluid">
            <div class="row">

            <div class="col-8">
                <label for="excelDosyasi" class="form-label">Excel Dosyası Seçin:</label>
                <input type="file" id="excelDosyasi" name="excelDosyasi" accept=".xlsx, .xls" class="form-control form-control-lg">
            </div>
                <div class="col-4">
                    <label for="formFileLg" class="form-label">Excel Dosyası Seçin:</label>
                    <br>
                    <button
                            class="btn btn-outline-primary"
                            type="button"
                            data-bs-original-title=""
                            onclick="saveCalc(this)"
                            form="save_boq"
                            data-url="<?php echo base_url("$this->Module_Name/save/$contract_id/$payment->id"); ?>"
                            title="">
                        <i class="fa fa-file-excel-o"></i> Excel Yükle
                    </button>
                    <a href="<?php echo base_url("$this->Module_Name/template_download/$contract_id/$payment->id/$income"); ?>">

                        <i class="fa fa-file-excel-o"></i> Şablon İndir
                    </a>
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
                        data-url="<?php echo base_url("$this->Module_Name/save/$contract_id/$payment->id"); ?>"
                        title="">
                    Kaydet/Satır Ekle
                </button>
            </div>
            <div class="row">
                <div class="col-2">
                    <strong>Bölüm</strong>
                </div>
                <div class="col-4">
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
            <?php foreach ($old_boqs as $row_no => $info) { ?>
                <?php $j = $i++; ?>
                <?php echo $row_no; ?>
                <?php $range = count($old_boqs); ?>
                <div class="container-fluid">
                    <div class="row" id="row_<?php echo $old_boq->boq_id; ?>_<?php echo $j; ?>">
                        <div class="col-2 mb-1" style="margin: 0; padding: 0;">
                            <input name="boq[<?php echo $j; ?>][s]" style="width: 100%"
                                   id="s_<?php echo $old_boq->boq_id; ?>_<?php echo $j; ?>"
                                   value="<?php echo $info['s']; ?>"
                                   onblur="calculateAndSetResult(<?php echo $old_boq->boq_id; ?>, <?php echo $j; ?>)"
                                   type="text">
                        </div>
                        <div class="col-4" style="margin: 0; padding: 0;">
                            <input name="boq[<?php echo $j; ?>][n]" style="width: 100%"
                                   id="n_<?php echo $old_boq->boq_id; ?>_<?php echo $j; ?>"
                                   value="<?php echo $info['n']; ?>"
                                   onblur="calculateAndSetResult(<?php echo $old_boq->boq_id; ?>, <?php echo $j; ?>)"
                                   type="text">
                        </div>
                        <div class="col-1" style="margin: 0; padding: 0;">
                            <input name="boq[<?php echo $j; ?>][q]" style="width: 100%"
                                   id="q_<?php echo $old_boq->boq_id; ?>_<?php echo $j; ?>"
                                   value="<?php echo $info['q']; ?>"
                                   onblur="calculateAndSetResult(<?php echo $old_boq->boq_id; ?>, <?php echo $j; ?>)"
                                   type="number" step="any">
                        </div>
                        <div class="col-1" style="margin: 0; padding: 0;">
                            <input name="boq[<?php echo $j; ?>][w]" style="width: 100%"
                                   id="w_<?php echo $old_boq->boq_id; ?>_<?php echo $j; ?>"
                                   value="<?php echo $info['w']; ?>"
                                   onblur="calculateAndSetResult(<?php echo $old_boq->boq_id; ?>, <?php echo $j; ?>)"
                                   type="number" step="any">
                        </div>
                        <div class="col-1" style="margin: 0; padding: 0;" id="h_<?php echo $j; ?>">
                            <input name="boq[<?php echo $j; ?>][h]" style="width: 100%"
                                   id="h_<?php echo $old_boq->boq_id; ?>_<?php echo $j; ?>"
                                   value="<?php echo $info['h']; ?>"
                                   onblur="calculateAndSetResult(<?php echo $old_boq->boq_id; ?>, <?php echo $j; ?>)"
                                   type="number" step="any">
                        </div>
                        <div class="col-1" style="margin: 0; padding: 0;" id="l_<?php echo $j; ?>">
                            <input name="boq[<?php echo $j; ?>][l]" style="width: 100%"
                                   id="l_<?php echo $old_boq->boq_id; ?>_<?php echo $j; ?>"
                                   value="<?php echo $info['l']; ?>"
                                   onblur="calculateAndSetResult(<?php echo $old_boq->boq_id; ?>, <?php echo $j; ?>)"
                                   type="number" step="any">
                        </div>
                        <div class="col-2" style="margin: 0; padding: 0;" id="t_<?php echo $j; ?>">
                            <input readonly name="boq[<?php echo $j; ?>][t]" style="width: 100%"
                                   id="t_<?php echo $old_boq->boq_id; ?>_<?php echo $j; ?>"
                                   value="<?php echo $info['t']; ?>"
                                   onblur="calculateAndSetResult(<?php echo $old_boq->boq_id; ?>, <?php echo $j; ?>)"
                                   type="number" step="any">
                        </div>
                    </div>
                </div>
            <?php } ?>
        <?php } ?>

        <?php $row_numbers = range($j + 1, $j + 11); ?>
        <?php foreach ($row_numbers as $row_number) { ?>
            <div class="container-fluid">
                <div class="row" id="row_<?php echo $income; ?>_<?php echo $row_number; ?>">
                    <div class="col-2 mb-1" style="margin: 0; padding: 0;">
                        <input name="boq[<?php echo $row_number; ?>][s]" style="width: 100%"
                               id="s_<?php echo $income; ?>_<?php echo $row_number; ?>"
                               onblur="calculateAndSetResult(<?php echo $income; ?>, <?php echo $row_number; ?>)"
                               type="text">
                    </div>
                    <div class="col-4" style="margin: 0; padding: 0;">
                        <input name="boq[<?php echo $row_number; ?>][n]" style="width: 100%"
                               id="n_<?php echo $income; ?>_<?php echo $row_number; ?>"
                               onblur="calculateAndSetResult(<?php echo $income; ?>, <?php echo $row_number; ?>)"
                               type="text">
                    </div>
                    <div class="col-1" style="margin: 0; padding: 0;">
                        <input name="boq[<?php echo $row_number; ?>][q]" style="width: 100%"
                               id="q_<?php echo $income; ?>_<?php echo $row_number; ?>"
                               onblur="calculateAndSetResult(<?php echo $income; ?>, <?php echo $row_number; ?>)"
                               type="number" step="any">
                    </div>
                    <div class="col-1" style="margin: 0; padding: 0;">
                        <input name="boq[<?php echo $row_number; ?>][w]" style="width: 100%"
                               id="w_<?php echo $income; ?>_<?php echo $row_number; ?>"
                               onblur="calculateAndSetResult(<?php echo $income; ?>, <?php echo $row_number; ?>)"
                               type="number" step="any">
                    </div>
                    <div class="col-1" style="margin: 0; padding: 0;" id="h_<?php echo $row_number; ?>">
                        <input name="boq[<?php echo $row_number; ?>][h]" style="width: 100%"
                               id="h_<?php echo $income; ?>_<?php echo $row_number; ?>"
                               onblur="calculateAndSetResult(<?php echo $income; ?>, <?php echo $row_number; ?>)"
                               type="number" step="any">
                    </div>
                    <div class="col-1" style="margin: 0; padding: 0;" id="l_<?php echo $row_number; ?>">
                        <input name="boq[<?php echo $row_number; ?>][l]" style="width: 100%"
                               id="l_<?php echo $income; ?>_<?php echo $row_number; ?>"
                               onblur="calculateAndSetResult(<?php echo $income; ?>, <?php echo $row_number; ?>)"
                               type="number" step="any">
                    </div>
                    <div class="col-2" style="margin: 0; padding: 0;" id="t_<?php echo $row_number; ?>">
                        <input readonly name="boq[<?php echo $row_number; ?>][t]" style="width: 100%"
                               id="t_<?php echo $income; ?>_<?php echo $row_number; ?>"
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
                        data-url="<?php echo base_url("$this->Module_Name/save/$contract_id/$payment->id"); ?>"
                        title="">
                    Kaydet/Satır Ekle
                </button>
            </div>
        </div>
        <?php } else { ?>
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

        swal({
            title: "Metrajı Silmek İstediğine Emin Misin?",
            text: "Bu işlem geri alınamaz!",
            icon: "warning",
            buttons: ["İptal", "Sil"],
            dangerMode: true,
        })
            .then((willDelete) => {
                if (willDelete) {

                    $.post($url, {}, function (response) {
                        $(".dynamic").html(response);
                    })

                    swal("Metraj Başarılı Bir Şekilde Silindi", {
                        icon: "success",
                    });

                } else {
                    swal("Metraj Güvende");
                }
            })
    }
</script>
<script>
    function resetInputValues() {

        swal({
            title: "Formu Temizlemek İstediğine Emin Misin?",
            text: "Bu işlem geri alınamaz!",
            icon: "warning",
            buttons: ["İptal", "Temizle"],
            dangerMode: true,
        })
            .then((willDelete) => {
                if (willDelete) {

                    var form = document.getElementById('save_boq');

                    // Get all input elements within the form
                    var inputElements = form.querySelectorAll('input');

                    // Loop through the input elements and set their values to 0, except for the input with id "dont_delete"
                    for (var i = 0; i < inputElements.length; i++) {
                        var input = inputElements[i];
                        if ((input.type === 'text' || input.type === 'number') && input.id !== 'dont_delete') {
                            input.value = '';
                        }
                    }

                    swal("Form Temizlendi; Kaydetmediğiniz sürece sildiğiniz veriler saklanır", {
                        icon: "success",
                    });

                } else {
                    swal("Temizleme İptal Edildi");
                }
            })
    }
</script>
<script>
    function saveCalc(btn) {
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
    function saveCalcexit(btn) {
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
                window.location.href = "<?php echo base_url("payment/file_form/$payment_id"); ?> // Replace with the URL you want to redirect to
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
                q = q || 1; // Eğer q değeri yoksa veya NaN ise 1 olarak ayarla
                w = w || 1; // Benzer şekilde diğer değerleri de düzelt
                h = h || 1;
                l = l || 1;

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




