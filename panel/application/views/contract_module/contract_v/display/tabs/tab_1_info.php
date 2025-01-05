<?php $sub_contracts = $this->Contract_model->get_all(array('parent' => $item->id)); ?>
<div class="container mt-5">
    <div class="row">
        <!-- Sol Sekmeler ve İçerik -->
        <div class="col-md-6">
            <!-- Sekmeler -->
            <div class="tabs mb-4">
                <div class="tab-item" style="background-color: rgba(199,172,134,0.43);">
                    <a class="text-blink" href="<?php echo base_url("project/file_form/$item->proje_id"); ?>">
                        Proje <br><?php echo project_code($item->proje_id); ?>
                    </a>
                </div>
                <?php if (isset($site)) { ?>
                    <div class="tab-item" style="background-color: rgba(229,217,201,0.55);">
                        <a class="text-blink" href="<?php echo base_url("site/file_form/$site->id"); ?>">
                            Şantiye <br><?php echo site_code($site->id); ?>
                        </a>
                    </div>
                <?php } ?>
                <?php if ($item->parent) { ?>
                    <div class="tab-item" style="background-color: rgba(239,232,223,0.44);">
                        <a class="text-blink" href="<?php echo base_url("contract/file_form/$item->parent"); ?>">
                            Ana Sözleşme <br><?php echo contract_code($item->parent); ?>
                        </a>
                    </div>
                <?php } ?>
            </div>
            <!-- İçerikler -->
            <div class="custom-card-body">
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
                    <tr>
                        <td>Toplam Alt Sözleşme Sayısı</td>
                        <td><?php echo count($sub_contracts); ?></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Sağ Alt Sözleşmeler -->
        <?php if (!$item->parent) { ?>
        <div class="col-md-6">
            <div class="tabs mb-4">
                <div class="tab-item" style="background-color: rgba(199,172,134,0.43);">
                    <b>Alt Sözleşmeler<br><?php echo count($sub_contracts); ?> Adet Alt Sözleşme Mevcut</b>
                    <a href="<?php echo base_url("contract/new_form_sub/$item->id"); ?>" class="ml-2">
                        <i class="fa fa-plus-circle fa-lg"></i>
                    </a>
                </div>
            </div>
            <div class="custom-card-body">
                <?php if (!empty($sub_contracts)) { ?>
                    <table class="table table-sm table-borderless">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Alt Sözleşme Adı</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $i = 1;
                        foreach ($sub_contracts as $sub_contract) { ?>
                            <tr>
                                <td><?php echo $i++; ?></td>
                                <td>
                                    <a href="<?php echo base_url("contract/file_form/$sub_contract->id"); ?>"><?php echo $sub_contract->contract_name; ?></a>
                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                <?php } else { ?>
                    <p>Henüz alt sözleşme bulunmuyor.</p>
                <?php } ?>
            </div>
        </div>
        <?php } ?>
    </div>
</div>
