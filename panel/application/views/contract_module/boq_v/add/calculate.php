<?php if (isset($income)) { ?>
<div class="card">
    <div class="card-body">
        <fieldset>
            <h4 class="m-t-10 text-center"><?php echo contract_name($contract_id); ?></h4>
            <h4 class="m-t-10 text-center"> <?php echo $payment_no; ?> Nolu Hakediş</h4>
            <h5 class="text-center"><?php echo boq_name($income); ?> </h5>
            <h6 class="text-center">Metraj Formu</h6>
            <hr>
            <div class="mb-3 row">
                <label class="col-lg-3 form-label text-lg-start" for="prependedcheckbox">El İle Toplam Metraj Girişi</label>
                <div class="col-lg-4">
                    <div class="input-group">
                        <span class="input-group-text">
                            <input type="checkbox" id="toggleCheckbox" name="bypass_total" onclick="toggleReadOnly(<?php echo $income; ?>)">
                        </span>
                        <input id="total_<?php echo $income; ?>" readonly name="total_<?php echo $income; ?>"
                               value="<?php if (!empty($old_boq)) { echo $old_boq->total; }?>"
                               class="form-control btn-square" type="text" placeholder=""><span class="input-group-text"><?php echo boq_unit($income); ?></span>
                        <input name="boq_id" hidden value="<?php echo $income; ?>">
                    </div>
                </div>
            </div>
        </fieldset>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <div class="container-fluid">

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
                <div class="col-2">
                    <strong>Toplam</strong>
                </div>
            </div>
        </div>
        <?php $range = 0; ?>
        <?php if (!empty($old_boq)) { ?>
            <?php $old_boqs = json_decode($old_boq->calculation, true); ?>
            <?php foreach ($old_boqs as $row_no => $info) { ?>
                <?php $range = count($old_boqs); ?>
                <div class="container-fluid">
                    <div class="row" id="row_<?php echo $old_boq->boq_id; ?>_<?php echo $row_no; ?>">
                        <div class="col-2 mb-1" style="margin: 0; padding: 0;">
                            <input name="boq[<?php echo $row_no; ?>][s]" style="width: 100%"
                                   id="s_<?php echo $old_boq->boq_id; ?>_<?php echo $row_no; ?>"
                                   value="<?php echo $info['s']; ?>"
                                   onblur="calculateAndSetResult(<?php echo $old_boq->boq_id; ?>, <?php echo $row_no; ?>)"
                                   type="text">
                        </div>
                        <div class="col-4" style="margin: 0; padding: 0;">
                            <input name="boq[<?php echo $row_no; ?>][n]" style="width: 100%"
                                   id="n_<?php echo $old_boq->boq_id; ?>_<?php echo $row_no; ?>"
                                   value="<?php echo $info['n']; ?>"
                                   onblur="calculateAndSetResult(<?php echo $old_boq->boq_id; ?>, <?php echo $row_no; ?>)"
                                   type="text">
                        </div>
                        <div class="col-1" style="margin: 0; padding: 0;">
                            <input name="boq[<?php echo $row_no; ?>][q]" style="width: 100%"
                                   id="q_<?php echo $old_boq->boq_id; ?>_<?php echo $row_no; ?>"
                                   value="<?php echo $info['q']; ?>"
                                   onblur="calculateAndSetResult(<?php echo $old_boq->boq_id; ?>, <?php echo $row_no; ?>)"
                                   type="number" step="any">
                        </div>
                        <div class="col-1" style="margin: 0; padding: 0;">
                            <input name="boq[<?php echo $row_no; ?>][w]" style="width: 100%"
                                   id="w_<?php echo $old_boq->boq_id; ?>_<?php echo $row_no; ?>"
                                   value="<?php echo $info['w']; ?>"
                                   onblur="calculateAndSetResult(<?php echo $old_boq->boq_id; ?>, <?php echo $row_no; ?>)"
                                   type="number" step="any">
                        </div>
                        <div class="col-1" style="margin: 0; padding: 0;" id="h_<?php echo $row_no; ?>">
                            <input name="boq[<?php echo $row_no; ?>][h]" style="width: 100%"
                                   id="h_<?php echo $old_boq->boq_id; ?>_<?php echo $row_no; ?>"
                                   value="<?php echo $info['h']; ?>"
                                   onblur="calculateAndSetResult(<?php echo $old_boq->boq_id; ?>, <?php echo $row_no; ?>)"
                                   type="number" step="any">
                        </div>
                        <div class="col-1" style="margin: 0; padding: 0;" id="l_<?php echo $row_no; ?>">
                            <input name="boq[<?php echo $row_no; ?>][l]" style="width: 100%"
                                   id="l_<?php echo $old_boq->boq_id; ?>_<?php echo $row_no; ?>"
                                   value="<?php echo $info['l']; ?>"
                                   onblur="calculateAndSetResult(<?php echo $old_boq->boq_id; ?>, <?php echo $row_no; ?>)"
                                   type="number" step="any">
                        </div>
                        <div class="col-2" style="margin: 0; padding: 0;" id="t_<?php echo $row_no; ?>">
                            <input readonly name="boq[<?php echo $row_no; ?>][t]" style="width: 100%"
                                   id="t_<?php echo $old_boq->boq_id; ?>_<?php echo $row_no; ?>"
                                   value="<?php echo $info['t']; ?>"
                                   onblur="calculateAndSetResult(<?php echo $old_boq->boq_id; ?>, <?php echo $row_no; ?>)"
                                   type="number" step="any">
                        </div>
                    </div>
                </div>
            <?php } ?>
        <?php } ?>
        <?php if (isset($old_boq)) { ?>
            <?php $row_numbers = range($range+1, ($range+10)); ?>
        <?php } else { ?>
            <?php $row_numbers = range(1, 10); ?>
        <?php } ?>
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
        <?php } else { ?>
            <div class="card" style="height: 150px">
                <div class="card-body">
                    <h4 class="m-t-10 text-center"><?php echo contract_name($contract_id); ?> </h4>
                    <h5 class="text-center"> <?php echo $payment_no; ?> Nolu Hakediş </h5>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    Soldaki Menüden İmalat Seçiniz
                </div>
            </div>
        <?php } ?>

        <?php if (isset($old_boq)) { ?>
            <?php
            $last_row = $range+10;
            $row_numbers = range($range+1, ($last_row)); ?>
        <?php } else { ?>
            <?php
            $last_row = 10;
            $row_numbers = range(1, $last_row); ?>
        <?php } ?>
        <script>
            function renderCalculate(btn) {
                var $url = btn.getAttribute('url');

                $.post($url, {}, function (response) {
                    $(".dynamic").html(response);
                })
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
            function calculateAndSetResult(income, row_number) {
                var totalResult = 0;
                var total = 0; // Toplamı saklamak için bir değişken tanımlayın
                var allEmpty = true; // Tüm q, w, h, l değerleri boş mu?

                for (var i = 1; i <= <?php echo $last_row; ?>; i++) {
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


                for (var i = 1; i <= <?php echo $last_row; ?>; i++) {
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








