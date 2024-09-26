<?php
$tabs = [
    [
        'id' => 'tab1',
        'label' => 'Genel',
        'active' => true,
        'view' => 'tab_1_info',
        'excel' => 'export/',
        'pdf' => 'export/'
    ],
    [
        'id' => 'tab2',
        'label' => 'Günlük Rapor',
        'active' => false,
        'view' => 'tab_2_report',
        'new_form' => 'report/new_form/',
        'excel' => 'export/',
        'pdf' => 'export/'
    ],
    [
        'id' => 'tab3',
        'label' => 'Depo / Stok',
        'active' => false,
        'add_modal' => 'AddStockModal',
        'view' => 'tab_3_sitestock',
        'excel' => 'export/sitestock_download_excel',
        'pdf' => 'export/sitestock_download_pdf'
    ],
    [
        'id' => 'tab4',
        'label' => 'Kasa',
        'active' => false,
        'view' => 'tab_4_sitewallet',
         'excel' => 'export/sitestock_download_excel',
        'pdf' => 'sitestock_download_pdf'
    ],
    [
        'id' => 'tab5',
        'label' => 'Personel',
        'active' => false,
        'view' => null,
         'excel' => 'export/sitestock_download_excel',
        'pdf' => 'sitestock_download_pdf',
        'items' => [
            [
                'id' => 'tab5-1',
                'label' => 'Personel Liste',
                'view' => 'tab_5_1_personel',
                 'excel' => 'export/sitestock_download_excel',
        'pdf' => 'sitestock_download_pdf'
            ],
            [
                'id' => 'tab5-2',
                'label' => 'Puantaj',
                'view' => 'tab_5_2_puantaj',
                 'excel' => 'export/sitestock_download_excel',
        'pdf' => 'sitestock_download_pdf'
            ],
        ]
    ],
    [
        'id' => 'tab6',
        'label' => 'Rapor Ayarları',
        'active' => false,
        'view' => null,
         'excel' => 'export/sitestock_download_excel',
        'pdf' => 'sitestock_download_pdf',
        'items' => [
            [
                'id' => 'tab6-1',
                'label' => 'İş Grupları',
                'view' => 'tab_6_1_workgroup',
                 'excel' => 'export/sitestock_download_excel',
        'pdf' => 'sitestock_download_pdf'
            ],
            [
                'id' => 'tab6-2',
                'label' => 'İş Makineleri',
                'view' => 'tab_6_2_workmachine',
                 'excel' => 'export/sitestock_download_excel',
        'pdf' => 'sitestock_download_pdf'
            ],
            [
                'id' => 'tab6-3',
                'label' => 'İmzalar',
                'view' => 'tab_6_3_sign',
                 'excel' => 'export/sitestock_download_excel',
        'pdf' => 'sitestock_download_pdf'
            ],
        ]
    ]
];
?>

<div class="text-center">
    <ul class="nav nav-tabs search-list" id="top-tab" role="tablist">
        <?php foreach ($tabs as $tab): ?>
            <li class="nav-item">
                <a class="nav-link <?= $tab['active'] ? 'active' : '' ?>"
                   id="<?= $tab['id'] ?>-link"
                   data-bs-toggle="tab"
                   href="#<?= $tab['id'] ?>"
                   role="tab"
                   aria-selected="<?= $tab['active'] ? 'true' : 'false' ?>">
                    <?= $tab['label'] ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</div>

<div class="tab-content">
    <?php foreach ($tabs as $tab): ?>
        <div class="tab-pane fade <?= $tab['active'] ? 'show active' : '' ?>"
             id="<?= $tab['id'] ?>"
             role="tabpanel"
             aria-labelledby="<?= $tab['id'] ?>-link">

            <?php if (isset($tab['items'])): ?>
                <ul class="nav nav-tabs mt-3" role="tablist">
                    <?php foreach ($tab['items'] as $index => $item): ?>
                        <li class="nav-item">
                            <a class="nav-link <?= $index === 0 ? 'active' : '' ?>"
                               id="<?= $item['id'] ?>-link"
                               data-bs-toggle="tab"
                               href="#<?= $item['id'] ?>"
                               role="tab">
                                <?= $item['label'] ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <div class="tab-content mt-3">
                    <?php foreach ($tab['items'] as $index => $item): ?>
                        <div class="tab-pane fade <?= $index === 0 ? 'show active' : '' ?>"
                             id="<?= $item['id'] ?>"
                             role="tabpanel"
                             aria-labelledby="<?= $item['id'] ?>-link">
                            <?php if (isset($item['view'])): ?>
                                <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/tabs/{$item['view']}"); ?>
                            <?php else: ?>
                                <p>Bu alt tab için içerik yok.</p>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0"><?= $tab['label'] ?></h5>
                        <div>
                            <?php if (isset($tab['add_modal'])): ?>
                                <i class="fa fa-plus fa-2x text-primary me-0"
                                   style="cursor: pointer;"
                                   data-bs-toggle="modal"
                                   data-bs-target="#<?php echo $tab['add_modal']; ?>"></i>
                            <?php endif; ?>

                            <?php if (isset($tab['new_form'])): ?>
                                <a href="<?php echo base_url($tab['new_form']."/".$item->id); ?>">
                                    <i class="fa fa-plus fa-2x text-primary me-0"></i>
                                </a>
                            <?php endif; ?>

                            <?php $excel_export_link = $tab['excel']; ?>
                            <?php $pdf_export_link = $tab['pdf']; ?>
                            <a href="<?php echo base_url("$excel_export_link/$item->id"); ?>">
                                <i class="fa fa-file-excel-o fa-2x"></i>
                            </a>

                            <a href="<?php echo base_url("$pdf_export_link/$item->id"); ?>">
                                <i class="fa fa-file-pdf-o fa-2x"></i>
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <?php if ($tab['view']): ?>
                            <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/tabs/{$tab['view']}"); ?>
                        <?php else: ?>
                            <p>Bu tab için içerik yok.</p>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</div>

