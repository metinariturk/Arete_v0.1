<div class="container mt-5">
    <div class="row">
        <div class="col-12 col-lg-6">
            <!-- Sekmeler -->
            <div class="tabs">
                <div class="tab-item" style="background-color: rgba(199,172,134,0.43);">
                    <a class="text-blink full-link" href="<?php echo base_url("project/file_form/$project->id"); ?>">Proje
                        <br><?php echo $project->project_code; ?>
                    </a>
                </div>
                <div class="tab-item" style="background-color: rgba(229,217,201,0.55);">
                    <a class="text-blink full-link" href="<?php echo base_url("contract/file_form/$contract->id"); ?>">Sözleşme
                        <br><?php echo $contract->dosya_no; ?>
                    </a>
                </div>
            </div>
            <hr>

            <div class="custom-card-body">
                <div class="table-responsive table-border-horizontal">
                    <table class="table-sm">
                        <tbody>
                        <tr>
                            <td><p>Şantiye Adı</p></td>
                            <td>
                                <p>
                                   <?php echo $item->dosya_no." - ".$item->santiye_ad; ?>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td><p>Şantiye Sorumlusu</p></td>
                            <td>
                                <p>
                                    <?php if (!empty($item->teknik_personel)) { ?>
                                        <?php foreach (get_as_array($item->teknik_personel) as $personel) { ?>
                                            <a target="_blank"
                                               href="<?php echo base_url("user/file_form/$personel"); ?>">
                                                <img
                                                        class="img-50 rounded-circle" <?php echo get_avatar($personel); ?>
                                                        alt=""
                                                        data-original-title=""
                                                        title="<?php echo full_name($personel); ?>">
                                                <?php echo full_name($personel); ?>
                                            </a>
                                            <br>
                                        <?php } ?>
                                    <?php } ?>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td><p>Kasa Durumu</p></td>
                            <td>
                                <p><?php echo money_format($total_deposit - $total_expense); ?><?php echo $contract->para_birimi; ?></p>
                            </td>
                        </tr>
                        <tr>
                            <td><p>Personel Çalışması</p></td>
                            <td>
                                <p>
                                    <?php echo sum_anything("report_workgroup", "number", "site_id", $item->id); ?>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td><p>Makine Çalışması</p></td>
                            <td>
                                <p>
                                    <?php echo sum_anything("report_workmachine", "number", "site_id", $item->id); ?>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td><p>Toplam Günlük Rapor</p></td>
                            <td><p><?php echo count($reports); ?></p></td>
                        </tr>
                        <tr>
                            <td><p>Aktif Çalışan Sayısı</p></td>
                            <td><p><?php echo count($personel_datas); ?></p></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-6">
            <!-- Sekmeler -->
            <div class="tabs">
                <div class="tab-item" style="background-color: rgba(199,172,134,0.43);">
                    <span><b>Son Raporlar</b><br>&nbsp;</span>
                </div>
            </div>
            <hr>

            <div class="custom-card-body">
                <div class="table-responsive table-border-horizontal">
                    <table class="table-sm" style="width: 100%">
                        <thead>
                        <tr>
                            <th><p>Rapor Gün</p></th>
                            <th colspan="2"><p class="text-center">İşlem</p></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (!empty($reports)) { ?>
                            <?php
                            $counter = 0; // Sayaç tanımlıyoruz
                            foreach ($reports as $report) {
                                if ($counter >= 5) break; // Sayaç 5'i geçtiğinde döngüden çık
                                $counter++; // Her döngüde sayaç bir artırılır
                                ?>
                                <tr id="center_row">
                                    <td>
                                        <a href="<?php echo base_url("report/file_form/$report->id"); ?>">
                                            <?php
                                            $formatter = new IntlDateFormatter(
                                                'tr_TR', // Locale
                                                IntlDateFormatter::LONG, // Date format
                                                IntlDateFormatter::NONE, // Time format
                                                'Europe/Istanbul', // Timezone
                                                IntlDateFormatter::GREGORIAN, // Calendar
                                                'd MMMM yyyy EEEE' // Custom format: day month year weekday
                                            );

                                            echo $formatter->format(strtotime($report->report_date));
                                            ?>
                                        </a>
                                    </td>

                                    <td>
                                        <a href="<?php echo base_url("report/print_report/$report->id/1/1"); ?>" class="btn-download">
                                            <i class="fa fa-download"></i>
                                        </a>
                                    </td>

                                    <td>
                                        <a href="<?php echo base_url("report/print_report/$report->id/1/1"); ?>" class="btn-display">
                                            <i class="fa fa-desktop"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php } ?>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <?php $this->load->view("{$viewModule}/{$viewFolder}/common/add_document"); ?>
</div>
