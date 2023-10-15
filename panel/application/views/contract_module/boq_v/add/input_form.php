<div class="card">
    <div class="card-body">
        <div class="mb-2">
            <div class="col-form-label">Dosya No</div>
            <div class="input-group"><span class="input-group-text" id="inputGroupPrepend">TD</span>
                <?php if (!empty(get_last_fn("drawings"))) { ?>
                    <input class="form-control <?php cms_isset(form_error("dosya_no"), "is-invalid", ""); ?>"
                           type="number" placeholder="Proje Kodu" aria-describedby="inputGroupPrepend"
                           data-bs-original-title="" title="" name="dosya_no"
                           value="<?php echo isset($form_error) ? set_value("dosya_no") : increase_code_suffix("drawings"); ?>">
                    <?php
                } else { ?>
                    <input class="form-control <?php cms_isset(form_error("dosya_no"), "is-invalid", ""); ?>"
                           type="number" placeholder="Username" aria-describedby="inputGroupPrepend"
                           required="" data-bs-original-title="" title="" name="dosya_no"
                           value="<?php echo isset($form_error) ? set_value("dosya_no") : fill_empty_digits() . "1" ?>">
                <?php } ?>

                <?php if (isset($form_error)) { ?>
                    <div class="invalid-feedback"><?php echo form_error("dosya_no"); ?></div>
                    <div class="invalid-feedback">* Önerilen Proje Kodu
                        : <?php echo increase_code_suffix("drawings"); ?>
                    </div>
                <?php } ?>
            </div>
        </div>

        <?php $active_boqs = json_decode($contract->active_boq, true); ?>
        <style>
            #metraj-table table {
                width: 100%;
                border-collapse: collapse;
                border: 1px solid #ccc; /* Gri çizgi rengi */
            }

            #metraj-table th, #metraj-table td {
                border: 1px solid #ccc; /* Gri çizgi rengi */
                padding: 8px; /* İsteğe bağlı: Hücre içeriğine boşluk ekler */
            }

            #metraj-table th.boq-header {
                font-size: 14pt;
                text-align: center;
            }

            #metraj-table th.boq-subheader {
                font-size: 9pt;
                text-align: left;
            }

            #metraj-table th.boq-calheader-10 {
                font-size: 8pt;
                text-align: center;
                width: 10%;
            }

            #metraj-table th.boq-calheader-15 {
                font-size: 8pt;
                text-align: center;
                width: 15%;
            }

            #metraj-table th.boq-calheader-35 {
                font-size: 8pt;
                text-align: center;
                width: 35%;
            }

            #metraj-table td.boq-right {
                text-align: right;
            }

            /* İlk tablonun başlık hücresi */
            #metraj-table th {
                font-size: 14pt;
                text-align: left;
            }

            #metraj-table input {
                width: 100%;
            }
        </style>


        <div id="metraj-table">
            <table>
                <thead>
                <tr>
                    <th class="boq-header" colspan="7">METRAJ CETVELİ</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td colspan="5" style="width: 80%"></td>
                    <td class="boq-right">Hakediş No</td>
                    <td>1</td>
                </tr>
                </tbody>
            </table>
        </div>


        <?php foreach ($active_boqs as $active_boq => $boqs) { ?>
            <div id="metraj-table">
                <table>
                    <thead>
                    <tr>
                        <th class="boq-subheader" colspan="7">
                            <strong><?php echo $active_boq . " - " . mb_strtoupper(boq_name($active_boq)); ?></strong>
                        </th>
                    </tr>
                    </thead>
                </table>
                <?php foreach ($boqs as $boq) { ?>
                    <table>
                        <thead>
                        <tr>
                            <th class="boq-subheader" colspan="7">
                                <strong><?php echo $boq . " - " . mb_strtoupper(boq_name($boq)); ?></strong>
                            </th>
                        </tr>
                        <tr>
                            <th class="boq-calheader-10">
                                <strong>Bölüm</strong>
                            </th>
                            <th class="boq-calheader-35">
                                <strong>Açıklama</strong>
                            </th>
                            <th class="boq-calheader-10">
                                <strong>Adet</strong>
                            </th>
                            <th class="boq-calheader-10">
                                <strong>En</strong>
                            </th>
                            <th class="boq-calheader-10">
                                <strong>Boy</strong>
                            </th>
                            <th class="boq-calheader-10">
                                <strong>Yükseklik</strong>
                            </th>
                            <th class="boq-calheader-15">
                                <strong>Toplam</strong>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td><input></td>
                            <td><input></td>
                            <td><input></td>
                            <td><input></td>
                            <td><input></td>
                            <td><input></td>
                            <td><input readonly></td>
                        </tr>
                        </tbody>
                    </table>
                    <hr>
                <?php } ?>
            </div>
        <?php } ?>
    </div>
</div>