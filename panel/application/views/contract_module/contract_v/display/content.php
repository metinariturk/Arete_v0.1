<?php
// Sekme değişkenlerini tanımlı değilse boş değerle başlat
$tab1 = isset($tab1) ? $tab1 : "";
$tab2 = isset($tab2) ? $tab2 : "";
$tab3 = isset($tab3) ? $tab3 : "";
$tab4 = isset($tab4) ? $tab4 : "";
$tab5 = isset($tab5) ? $tab5 : "";
$tab6 = isset($tab6) ? $tab6 : "";
$tab7 = isset($tab7) ? $tab7 : "";

// Tüm sekme değişkenlerini bir diziye yerleştir
$tabs = [$tab1, $tab2, $tab3, $tab4, $tab5, $tab6, $tab7];

// Hiçbir sekme "active" değilse tab1'i aktif yap
if (!in_array("active", $tabs)) {
    $tab1 = "active"; // Sadece tab1'i aktif yapar
}
?>
<?php
// Modalın hata sonucunda otomatik açılması için kontrol
$error_modal = isset($error_modal) ? $error_modal : '';
?>
<div class="text-center">
    <ul class="nav nav-tabs search-list" id="top-tab" role="tablist">
        <li class="nav-item">
            <a class="nav-link <?= ($tab1 == "active") ? "active" : "" ?>"
               id="tab1-link" data-bs-toggle="tab" href="#tab1" role="tab"
                <?= ($tab1 == "active") ? '' : 'tabindex="-1"' ?>
               aria-selected="<?= ($tab1 == "active") ? "true" : "false" ?>">
                Genel
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= ($tab2 == "active") ? "active" : "" ?>"
               id="tab2-link" data-bs-toggle="tab" href="#tab2" role="tab"
                <?= ($tab2 == "active") ? '' : 'tabindex="-1"' ?>
               aria-selected="<?= ($tab2 == "active") ? "true" : "false" ?>">
                Sözleşme Raporu
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= ($tab3 == "active") ? "active" : "" ?>"
               id="tab3-link" data-bs-toggle="tab" href="#tab3" role="tab"
                <?= ($tab3 == "active") ? '' : 'tabindex="-1"' ?>
               aria-selected="<?= ($tab3 == "active") ? "true" : "false" ?>">
                Hakedişler
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= ($tab4 == "active") ? "active" : "" ?>"
               id="tab4-link" data-bs-toggle="tab" href="#tab4" role="tab"
                <?= ($tab4 == "active") ? '' : 'tabindex="-1"' ?>
               aria-selected="<?= ($tab4 == "active") ? "true" : "false" ?>">
                Ödemeler
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= ($tab5 == "active") ? "active" : "" ?>"
               id="tab5-link" data-bs-toggle="tab" href="#tab5" role="tab"
                <?= ($tab5 == "active") ? '' : 'tabindex="-1"' ?>
               aria-selected="<?= ($tab5 == "active") ? "true" : "false" ?>">
                Personel
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= ($tab6 == "active") ? "active" : "" ?>"
               id="tab6-link" data-bs-toggle="tab" href="#tab6" role="tab"
                <?= ($tab6 == "active") ? '' : 'tabindex="-1"' ?>
               aria-selected="<?= ($tab6 == "active") ? "true" : "false" ?>">
                Rapor Ayarları
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= ($tab7 == "active") ? "active" : "" ?>"
               id="tab7-link" data-bs-toggle="tab" href="#tab7" role="tab"
                <?= ($tab7 == "active") ? '' : 'tabindex="-1"' ?>
               aria-selected="<?= ($tab7 == "active") ? "true" : "false" ?>">
                Tutanaklar
            </a>
        </li>
    </ul>

</div>

<div class="tab-content">
    <div class="tab-pane fade <?= ($tab1 == "active") ? "show active" : "" ?>" id="tab1" role="tabpanel" aria-labelledby="tab1-link">
        <div class="card">
            <div class="card-body">
                <h5><?php echo $item->dosya_no." / ".$item->contract_name; ?></h5>
                <div class="download_links mt-3">
                    <a href="<?php echo base_url('export/'); ?>">
                        <i class="fa fa-file-excel-o fa-2x"></i>
                    </a>
                    <a href="<?php echo base_url('export/'); ?>">
                        <i class="fa fa-file-pdf-o fa-2x"></i>
                    </a>
                </div>
                <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/tabs/tab_1_info"); ?>
            </div>
        </div>
    </div>

    <div class="tab-pane fade <?= ($tab2 == "active") ? "show active" : "" ?>" id="tab2" role="tabpanel" aria-labelledby="tab2-link">
        <div class="card">
            <div class="card-body">
                <h5>Günlük Rapor</h5>
                <div class="download_links mt-3">
                    <a href="<?php echo base_url("export/report_download_excel/$item->id"); ?>">
                        <i class="fa fa-file-excel-o fa-2x"></i>
                    </a>
                    <a href="<?php echo base_url("export/print_report/$item->id/1"); ?>">
                        <i class="fa fa-file-pdf-o fa-2x"></i>
                    </a>
                </div>
                <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/tabs/tab_2_report"); ?>

            </div>
        </div>
    </div>

    <div class="tab-pane fade <?= ($tab3 == "active") ? "show active" : "" ?>" id="tab3" role="tabpanel" aria-labelledby="tab3-link">
        <div class="card">
            <div class="card-body">
                <h5>Hakediş Listesi</h5>
                <div class="download_links mt-3">
                    <i class="fa fa-plus fa-2x text-primary"
                       style="cursor: pointer;" data-bs-toggle="modal"
                       data-bs-target="#modalPayment" title="Yeni Hakediş Oluştur"
                       aria-hidden="true">

                    </i>

                    <a href="<?php echo base_url("export/sitestock_download_excel/$item->id"); ?>">
                        <i class="fa fa-file-excel-o fa-2x"></i>
                    </a>
                    <a href="<?php echo base_url("export/sitestock_download_pdf/$item->id"); ?>">
                        <i class="fa fa-file-pdf-o fa-2x"></i>
                    </a>
                </div>
                <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/tabs/tab_3_payments"); ?>

                <div id="modal_payment">
                    <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/modals/payment_modal"); ?>
                </div>
            </div>
        </div>
    </div>

    <div class="tab-pane fade <?= ($tab4 == "active") ? "show active" : "" ?>" id="tab4" role="tabpanel" aria-labelledby="tab4-link">
        <div class="card">
            <div class="card-body">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" style="background-color: rgba(233,231,247,0.38);" id="tab4-1-link"
                           data-bs-toggle="tab" href="#tab4-1" role="tab">
                            <h5>Ödemeler</h5>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" style="background-color: rgba(233,231,247,0.38);" id="tab4-2-link"
                           data-bs-toggle="tab" href="#tab4-2" role="tab">
                            <h5>Avanslar</h5>
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="tab4-1" role="tabpanel" aria-labelledby="tab4-1-link">
                        <div class="download_links mt-3">
                            <i class="fa fa-plus fa-2x me-0" style="cursor: pointer;" data-bs-toggle="modal"
                               data-bs-target="#AddCollectionModal"></i>
                            <a href="<?php echo base_url('export/collection_download_excel'); ?>">
                                <i class="fa fa-file-excel-o fa-2x"></i>
                            </a>
                            <a href="<?php echo base_url('export/collection_download_pdf'); ?>">
                                <i class="fa fa-file-pdf-o fa-2x"></i>
                            </a>
                        </div>
                        <div id="tab_collection">
                            <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/modals/collection_modal"); ?>

                            <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/tabs/tab_4_collection"); ?>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="tab4-2" role="tabpanel" aria-labelledby="tab4-2-link">
                        <div class="download_links mt-3">
                            <i class="fa fa-plus fa-2x me-0" style="cursor: pointer;" data-bs-toggle="modal"
                               data-bs-target="#AddDepositModal"></i>
                            <a href="<?php echo base_url('export/sitewallet_download_excel'); ?>">
                                <i class="fa fa-file-excel-o fa-2x"></i>
                            </a>
                            <a href="<?php echo base_url('export/sitewallet_download_pdf'); ?>">
                                <i class="fa fa-file-pdf-o fa-2x"></i>
                            </a>
                        </div>
                        <div id="tab_deposits">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="tab-pane fade <?= ($tab5 == "active") ? "show active" : "" ?>" id="tab5" role="tabpanel" aria-labelledby="tab5-link">
        <div class="card">
            <div class="card-body">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" style="background-color: rgba(233,231,247,0.38);" id="tab5-1-link"
                           data-bs-toggle="tab" href="#tab5-1" role="tab">
                            <h5>Personel Liste</h5>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" style="background-color: rgba(233,231,247,0.38);" id="tab5-2-link"
                           data-bs-toggle="tab" href="#tab5-2" role="tab">
                            <h5>Puantaj</h5>
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="tab5-1" role="tabpanel" aria-labelledby="tab5-1-link">
                        <div class="download_links mt-3">
                            <i class="fa fa-plus fa-2x me-0" style="cursor: pointer;" data-bs-toggle="modal"
                               data-bs-target="#AddPersonelModal"></i>
                            <a href="<?php echo base_url("export/report_download_excel/$item->id"); ?>">
                                <i class="fa fa-file-excel-o fa-2x"></i>
                            </a>
                            <a href="<?php echo base_url("export/report_download_pdf/$item->id"); ?>">
                                <i class="fa fa-file-pdf-o fa-2x"></i>
                            </a>
                        </div>
                        <div id="tab_personel">
                        </div>
                    </div>
                    <div class="tab-pane fade" id="tab5-2" role="tabpanel" aria-labelledby="tab5-2-link">
                        <div class="download_links mt-3">
                            <a href="<?php echo base_url('export/sitewallet_download_excel'); ?>">
                                <i class="fa fa-file-excel-o fa-2x"></i>
                            </a>
                            <a href="#" onclick="sendPuantajDate(this)">
                                <i class="fa fa-file-pdf-o fa-2x"></i>
                            </a>
                        </div>
                        <div id="tab_puantaj">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="tab-pane fade <?= ($tab6 == "active") ? "show active" : "" ?>" id="tab6" role="tabpanel" aria-labelledby="tab6-link">
        <div class="card">
            <div class="card-body">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" style="background-color: rgba(233,231,247,0.38);" id="tab6-1-link"
                           data-bs-toggle="tab" href="#tab6-1" role="tab">
                            <h5>İş Grupları</h5>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" style="background-color: rgba(233,231,247,0.38);" id="tab6-2-link"
                           data-bs-toggle="tab" href="#tab6-2" role="tab">
                            <h5>İş Makineleri</h5>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" style="background-color: rgba(233,231,247,0.38);" id="tab6-3-link"
                           data-bs-toggle="tab" href="#tab6-3" role="tab">
                            <h5>İmalat Takip</h5>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" style="background-color: rgba(233,231,247,0.38);" id="tab6-4-link"
                           data-bs-toggle="tab" href="#tab6-4" role="tab">
                            <h5>İmzalar</h5>
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="tab6-1" role="tabpanel" aria-labelledby="tab6-1-link">
                        <div class="download_links mt-3">
                            <i class="fa fa-plus fa-2x me-0" style="cursor: pointer;" data-bs-toggle="modal"
                               data-bs-target="#AddWorker"></i>
                            <a href="<?php echo base_url('export/active_worker_download_excel'); ?>">
                                <i class="fa fa-file-excel-o fa-2x"></i>
                            </a>
                            <a href="<?php echo base_url('export/active_worker_download_pdf'); ?>">
                                <i class="fa fa-file-pdf-o fa-2x"></i>
                            </a>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="tab6-2" role="tabpanel" aria-labelledby="tab6-2-link">
                    </div>
                    <div class="tab-pane fade" id="tab6-3" role="tabpanel" aria-labelledby="tab6-3-link">
                        <div class="mt-3">
                            <!-- 6-3 tab content -->
                        </div>
                    </div>
                    <div class="tab-pane fade" id="tab6-4" role="tabpanel" aria-labelledby="tab6-4-link">
                        <div class="mt-3">
                            <!-- 6-4 tab content -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>