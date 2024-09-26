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
                <?php if ($item->parent != 0 && $item->parent != null) { ?>
                    <div class="tab-item" style="background-color: rgba(239,232,223,0.44);">
                        <a class="text-blink" href="<?php echo base_url("contract/file_form/$item->parent"); ?>"> Ana
                            Sözleşme
                            <br><?php echo contract_code($item->parent); ?>
                        </a>
                    </div>
                <?php } ?>
            </div>
            <!-- İçerikler -->
            <div class="">
                <?php if ($item->parent == 0 || $item->parent == null) { ?>
                    <?php $sub_contracts = $this->Contract_model->get_all(array('parent' => $item->id)); ?>
                    <!-- Kart: Alt Sözleşmeler -->
                    <div class="table-resposive table-border-horizontal">
                    <table class="table-sm">
                        <thead>
                        <tr>
                            <th colspan="2">
                                <div class="d-flex align-items-center">
                                    <p class="mb-0 f-18">Alt Sözleşmeler</p>
                                    <a href="<?php echo base_url("contract/new_form_sub/$item->id"); ?>" class="add-subcontract ml-2">
                                        <i class="fa fa-plus-circle fa-lg"></i>
                                    </a>
                                </div>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (!empty($sub_contracts)) { ?>
                            <?php $i = 1; ?>
                            <?php foreach ($sub_contracts as $sub_contract) { ?>
                                <tr>
                                    <td class="w5"><p><?php echo $i++; ?></p></td>
                                    <td>
                                        <p>
                                            <a href="<?php echo base_url("contract/file_form/$sub_contract->id"); ?>"><?php echo $sub_contract->contract_name; ?>
                                            </a>
                                        </p>
                                    </td>
                                </tr>
                            <?php } ?>
                        <?php } else { ?>
                            <p>Henüz alt sözleşme bulunmuyor.</p>
                        <?php } ?>
                        </tbody>
                    </table>
                    </div>
                <?php } ?>
            </div>
        </div>
        <div class="col-6">
            <div class="custom-card-header bg-primary text-white">
                Detaylar
            </div>
            <div class="custom-card-body">
                <div class="table-resposive table-border-horizontal">
                    <table class="table-sm">
                        <tbody>
                        <tr>
                            <td><p>İmza Tarihi</p></td>
                            <td><p><?php echo $item->sozlesme_tarih == null ? 'Belirtilmemiş' : dateFormat('d-m-Y', $item->sozlesme_tarih); ?></p></td>
                        </tr>
                        <tr>
                            <td><p>İşin Süresi</p></td>
                            <td><p><?php echo $item->isin_suresi; ?> Gün</td>
                        </tr>
                        <tr>
                            <td><p>Bitiş Tarihi</p></td>
                            <td><p><?php echo $item->sozlesme_bitis == null ? 'Belirtilmemiş' : dateFormat('d-m-Y', $item->sozlesme_bitis); ?></p></td>
                        </tr>
                        <tr>
                            <td><p>Yer Teslimi</p></td>
                            <td><p><?php if (date_control($item->sitedel_date)) { ?>
                                    <?php echo $item->sitedel_date == null ? 'Belirtilmemiş' : dateFormat('d-m-Y', $item->sitedel_date); ?>
                                <?php } else { echo "Veri Yok"; } ?></p></td>
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
                            <td><p><?php echo money_format($item->sozlesme_bedel) . " " . $item->para_birimi; ?></p></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view("{$viewModule}/{$viewFolder}/common/add_document"); ?>


