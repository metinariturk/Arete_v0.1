<div class="container mt-5">
    <div class="row">
        <div class="col-6">
            <!-- Sekmeler -->
            <div class="tabs">
                <div class="tab-item" style="background-color: rgba(199,172,134,0.43);">
                    <a class="text-blink" href="<?php echo base_url("project/file_form/$item->proje_id"); ?>">Proje
                        <br><?php echo project_code($item->proje_id); ?>
                    </a>
                </div>
                <div class="tab-item" style="background-color: rgba(229,217,201,0.55);">
                    <a class="text-blink" href="<?php echo base_url("site/file_form/$site->id"); ?>">Şantiye
                        <br><?php echo site_code($site->id); ?>
                    </a>
                </div>
                <div class="tab-item" style="background-color: rgba(239,232,223,0.44);">
                    <a class="text-blink" href="<?php echo base_url("contract/file_form/$item->parent"); ?>"> Ana
                        Sözleşme
                        <br><?php echo contract_code($item->parent); ?>
                    </a>
                </div>
            </div>
            <div class="table-resposive table-border-horizontal">
                <table class="table-sm">
                    <tbody>
                    <tr>
                        <td><p>İmza Tarihi</p></td>
                        <td>
                            <p><?php echo $item->sozlesme_tarih == null ? 'Belirtilmemiş' : dateFormat('d-m-Y', $item->sozlesme_tarih); ?></p>
                        </td>
                    </tr>
                    <tr>
                        <td><p>İşin Süresi</p></td>
                        <td><p><?php echo $item->isin_suresi; ?> Gün</td>
                    </tr>
                    <tr>
                        <td><p>Bitiş Tarihi</p></td>
                        <td>
                            <p><?php echo $item->sozlesme_bitis == null ? 'Belirtilmemiş' : dateFormat('d-m-Y', $item->sozlesme_bitis); ?></p>
                        </td>
                    </tr>
                    <tr>
                        <td><p>Yer Teslimi</p></td>
                        <td><p><?php if (date_control($item->sitedel_date)) { ?>
                                    <?php echo $item->sitedel_date == null ? 'Belirtilmemiş' : dateFormat('d-m-Y', $item->sitedel_date); ?>
                                <?php } else {
                                    echo "Veri Yok";
                                } ?></p></td>
                    </tr>
                    <tr>
                        <td><p>İşin Türü</p></td>
                        <td><p><?php echo $item->isin_turu; ?></p></td>
                    </tr>
                    <tr>
                        <td><p>Teklif Türü</p></td>
                        <td><p><?php echo $item->sozlesme_turu; ?></p></td>
                    </tr>
                    <tr>
                        <td><p>Sözleşme Bedeli</p></td>
                        <td><p><?php echo money_format($item->sozlesme_bedel) . " " . $item->para_birimi; ?></p>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-6">
            <?php $this->load->view("{$viewModule}/{$viewFolder}/common/add_document"); ?>
        </div>
    </div>
</div>



