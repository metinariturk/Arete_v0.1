<div class="contract-card">
    <div class="contract-header">
        <h4 class="contract-title"><?php echo mb_strtoupper($item->dosya_no . " / " . $item->contract_name); ?></h4>
        <span class="contract-status <?php echo ($item->isActive == 1) ? 'status-active' : 'status-completed'; ?>">
                        <?php
                        if ($item->isActive == 1) {
                            echo "Devam Eden";
                        } elseif ($item->isActive == 2) {
                            echo "Tamamlandı";
                        }
                        ?>
                    </span>
    </div>

    <div class="action-buttons-row">
        <a href="<?php echo base_url("company/file_form/$item->isveren"); ?>"
           class="btn btn-sm btn-outline-primary w-100 mb-2 text-start">
            <i class="fa-solid fa-chess-king me-4"></i><?php echo mb_strtoupper(company_name($item->isveren)); ?>
        </a>

        <a href="<?php echo base_url("company/file_form/$item->yuklenici"); ?>"
           class="btn btn-sm btn-outline-secondary w-100 mb-2 text-start">
            <i class="fa-solid fa-chess-bishop me-4"></i><?php echo mb_strtoupper(company_name($item->yuklenici)); ?>
        </a>

        <a href="<?php echo base_url("project/file_form/$item->project_id"); ?>"
           class="btn btn-sm btn-outline-info w-100 mb-2 text-start">
            <i class="fa fa-folder-open me-4"></i>Proje: <?php echo $project->dosya_no; ?>
        </a>
        <?php if (isset($site)) { ?>
            <a href="<?php echo base_url("site/file_form/$site->id"); ?>"
               class="btn btn-sm btn-outline-warning w-100 mb-2 text-start">
                <i class="fa fa-building me-4"></i>Şantiye: <?php echo site_code($site->id); ?>
            </a>
        <?php } ?>
        <?php if ($item->parent) { ?>
            <a href="<?php echo base_url("contract/file_form/$item->parent"); ?>"
               class="btn btn-sm btn-outline-danger w-100 text-start">
                <i class="fa fa-file-contract me-4"></i> Ana Sözleşme: <?php echo contract_code($item->parent); ?>
            </a>
        <?php } ?>
    </div>
    <div class="contract-details-table">
        <h5 class="table-title">Sözleşme Detayları</h5>
        <table class="table table-sm table-borderless">
            <tbody>
            <tr>
                <td>İmza Tarihi</td>
                <td><?php echo $item->sozlesme_tarih ? dateFormat('d-m-Y', $item->sozlesme_tarih) : 'Belirtilmemiş'; ?></td>
            </tr>
            <tr>
                <td>İşin Süresi</td>
                <td><?php echo $item->isin_suresi; ?> Gün</td>
            </tr>
            <tr>
                <td>Bitiş Tarihi</td>
                <td><?php echo $item->sozlesme_bitis ? dateFormat('d-m-Y', $item->sozlesme_bitis) : 'Belirtilmemiş'; ?></td>
            </tr>
            <tr>
                <td>Yer Teslimi</td>
                <td><?php echo date_control($item->sitedel_date) ? dateFormat('d-m-Y', $item->sitedel_date) : 'Veri Yok'; ?></td>
            </tr>
            <tr>
                <td>İşin Türü</td>
                <td><?php echo $item->isin_turu; ?></td>
            </tr>
            <tr>
                <td>Teklif Türü</td>
                <td><?php echo $item->sozlesme_turu; ?></td>
            </tr>
            <tr>
                <td>Sözleşme Bedeli</td>
                <td><?php echo money_format($item->sozlesme_bedel) . " " . $item->para_birimi; ?></td>
            </tr>
            <?php if (isset($sub_contracts)) { ?>
                <tr>
                    <td>Toplam Alt Sözleşme Sayısı</td>
                    <td><?php echo count($sub_contracts); ?></td>
                </tr>
            <?php } ?>

            </tbody>
        </table>
    </div>
</div>
