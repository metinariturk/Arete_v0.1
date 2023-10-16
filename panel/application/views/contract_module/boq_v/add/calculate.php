<?php if (isset($income)) { ?>
<div class="card" style="height: 100px">
    <div class="card-body">
        <input type="number" name="total[<?php echo $income; ?>]">
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

        <?php if (isset($income_number)) {
            $number = $income_number;
        } else {
            $number = 10;
        } ?>
        <?php $row_numbers = range(1, $number); ?>
        <?php foreach ($row_numbers as $row_number) { ?>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-2" style="margin: 0; padding: 0;">
                        <input name="boq[<?php echo $row_number; ?>][s]" style="width: 100%"
                               id="s_<?php echo $income; ?>_<?php echo $row_number; ?>" style="width: 100%" onchange="calculateAndSetResult(<?php echo $income; ?>, <?php echo $row_number; ?>)"
                               type="text">
                    </div>
                    <div class="col-4" style="margin: 0; padding: 0;">
                        <input name="boq[<?php echo $row_number; ?>][n]" style="width: 100%"
                               id="n_<?php echo $income; ?>_<?php echo $row_number; ?>" style="width: 100%" onchange="calculateAndSetResult(<?php echo $income; ?>, <?php echo $row_number; ?>)"
                               type="text">
                    </div>
                    <div class="col-1" style="margin: 0; padding: 0;">
                        <input name="boq[<?php echo $row_number; ?>][q]" style="width: 100%"
                               id="q_<?php echo $income; ?>_<?php echo $row_number; ?>" style="width: 100%" onchange="calculateAndSetResult(<?php echo $income; ?>, <?php echo $row_number; ?>)"
                               type="number">
                    </div>
                    <div class="col-1" style="margin: 0; padding: 0;">
                        <input name="boq[<?php echo $row_number; ?>][w]" style="width: 100%"
                               id="w_<?php echo $income; ?>_<?php echo $row_number; ?>" style="width: 100%" onchange="calculateAndSetResult(<?php echo $income; ?>, <?php echo $row_number; ?>)"
                               type="number">
                    </div>
                    <div class="col-1" style="margin: 0; padding: 0;" id="h_<?php echo $row_number; ?>">
                        <input name="boq[<?php echo $row_number; ?>][h]" style="width: 100%"
                               id="h_<?php echo $income; ?>_<?php echo $row_number; ?>" style="width: 100%" onchange="calculateAndSetResult(<?php echo $income; ?>, <?php echo $row_number; ?>)"
                               type="number">
                    </div>
                    <div class="col-1" style="margin: 0; padding: 0;" id="l_<?php echo $row_number; ?>">
                        <input name="boq[<?php echo $row_number; ?>][l]" style="width: 100%"
                               id="l_<?php echo $income; ?>_<?php echo $row_number; ?>" style="width: 100%" onchange="calculateAndSetResult(<?php echo $income; ?>, <?php echo $row_number; ?>)"
                               type="number">
                    </div>
                    <div class="col-2" style="margin: 0; padding: 0;" id="t_<?php echo $row_number; ?>">
                        <input name="boq[<?php echo $row_number; ?>][t]" style="width: 100%"
                               id="t_<?php echo $income; ?>_<?php echo $row_number; ?>" style="width: 100%" onchange="calculateAndSetResult(<?php echo $income; ?>, <?php echo $row_number; ?>)"
                               type="number">
                    </div>
                </div>
            </div>
        <?php } ?>
        <?php } else { ?>
            <div class="card" style="height: 100px">
                <div class="card-body">
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                </div>
            </div>
        <?php } ?>


        <script>
            function calculateAndSetResult(income, row_number) {
                var totalResult = 0;
                var allEmpty = true; // Tüm q, w, h, l değerleri boş mu?

                for (var i = 1; i <= 10; i++) {
                    var q = parseFloat(document.getElementById('q_' + income + '_' + i).value);
                    var w = parseFloat(document.getElementById('w_' + income + '_' + i).value);
                    var h = parseFloat(document.getElementById('h_' + income + '_' + i).value);
                    var l = parseFloat(document.getElementById('l_' + income + '_' + i).value);

                    // Değerler boşsa, t değerini 0 olarak ayarla
                    if (isNaN(q) && isNaN(w) && isNaN(h) && isNaN(l)) {
                        document.getElementById('t_' + income + '_' + i).value = "0";
                    } else {
                        var q = parseFloat(document.getElementById('q_' + income + '_' + i).value) || 1;
                        var w = parseFloat(document.getElementById('w_' + income + '_' + i).value) || 1;
                        var h = parseFloat(document.getElementById('h_' + income + '_' + i).value) || 1;
                        var l = parseFloat(document.getElementById('l_' + income + '_' + i).value) || 1;
                        var n = document.getElementById('n_' + income + '_' + i).value.toLowerCase();

                        var forbiddenWord = 'minha';

                        if (n.includes(forbiddenWord)) {
                            var m = -1;
                        } else {
                            var m = 1;
                        }

                        var result = m * q * w * h * l;
                        result = result.toFixed(2);
                        document.getElementById('t_' + income + '_' + i).value = result;
                        totalResult += parseFloat(result);
                        allEmpty = false; // En az bir değer dolu, allEmpty değerini false yap
                    }
                }

                // Eğer tüm değerler boşsa, totalResult 0 olarak ayarla
                if (allEmpty) {
                    document.getElementById('total_' + income).value = "0";
                } else {
                    document.getElementById('total_' + income).value = totalResult.toFixed(2);
                }
            }

        </script>









