<div class="card">
    <div class="card-header bg-dark text-white p-3 rounded">
        <h6 class="mb-0">ŞANTİYELER RAPORU</h6>
        <hr style="margin: 3px;">
        <div class="download_links mt-3">
            <a href="<?php echo base_url("export/contract_report_excel/$item->id"); ?>">
                <i class="fa fa-file-excel-o fa-2x"></i>
            </a>
            <a href="<?php echo base_url("export/contract_report_pdf/$item->id/1"); ?>">
                <i class="fa fa-file-pdf-o fa-2x"></i>
            </a>
        </div>
    </div>
    <!-- Sekmeler (Tabs) -->
    <ul class="nav nav-tabs" id="siteTabs" role="tablist">
        <?php foreach ($sites as $index => $site) { ?>
            <li class="nav-item" role="presentation">
                <button class="nav-link <?php echo $index === 0 ? 'active' : ''; ?>"
                        id="tab-<?php echo $site->id; ?>"
                        data-bs-toggle="tab"
                        data-bs-target="#content-<?php echo $site->id; ?>"
                        type="button"
                        role="tab">
                    <?php echo $site->santiye_ad; ?>
                </button>
            </li>
        <?php } ?>
    </ul>

    <!-- Sekme İçerikleri -->
    <div class="tab-content" id="siteTabsContent">
        <?php foreach ($sites as $index => $site) { ?>
            <div class="tab-pane fade <?php echo $index === 0 ? 'show active' : ''; ?>"
                 id="content-<?php echo $site->id; ?>"
                 role="tabpanel">
                <?php
                $total_expense = sum_anything_and("sitewallet", "price", "site_id", "$site->id", "type", "1");
                $total_deposit = sum_anything_and("sitewallet", "price", "site_id", "$site->id", "type", "0");
                $reports = $this->Report_model->get_all(array("site_id" => $site->id));
                $active_personel_datas = $this->Workman_model->get_all(array("site_id" => $site->id, "isActive" => 1), "group DESC");
                $passive_personel_datas = $this->Workman_model->get_all(array("site_id" => $site->id, "isActive" => 0), "group DESC");
                $total = $total_deposit - $total_expense;
                $totalFormatted = money_format($total, 2);
                ?>
                <div class="table-responsive">
                    <table class="table table-bordered mt-3">
                        <thead>
                        <tr>
                            <th>Şantiye Adı</th>
                            <th>Şantiye Sorumlusu</th>
                            <th>Personel Çalışması</th>
                            <th>Makine Çalışması</th>
                            <th>Günlük Rapor</th>
                            <th>Kasa Durumu</th>
                            <th>Aktif Çalışan</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>
                                <a href="<?php echo base_url("site/file_form/$site->id"); ?>">
                                    <?php echo $site->dosya_no . " - " . $site->santiye_ad; ?>
                                </a>
                            </td>
                            <td>
                                <?php if (!empty($site->teknik_personel)): ?>
                                    <?php foreach (get_as_array($site->teknik_personel) as $personel): ?>
                                        <a target="_blank" href="<?php echo base_url("user/file_form/$personel"); ?>">
                                            <?php echo full_name($personel); ?>
                                        </a><br>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </td>
                            <td><?php echo sum_anything("report_workgroup", "number", "site_id", $site->id); ?></td>
                            <td><?php echo sum_anything("report_workmachine", "number", "site_id", $site->id); ?></td>
                            <td><?php echo count($reports); ?></td>
                            <td>
                                <i class="fa fa-circle" style="color:
                                <?php echo ($total < 0) ? 'red' : (($total > 0) ? 'green' : 'gold'); ?>;
                                        margin-right: 5px;"></i>
                                <?php echo $totalFormatted . " " . (!empty($site->para_birimi) ? $site->para_birimi : 'TL'); ?>
                            </td>
                            <td><?php echo count($active_personel_datas) + count($passive_personel_datas); ?></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php } ?>
    </div>
</div>



