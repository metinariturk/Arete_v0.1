<?php if (!$item->parent) { ?>
    <div class="contract-card mt-4">
        <div class="card-header-with-action">
            <h5 class="table-title">Alt Sözleşmeler</h5>
            <div class="header-action">
                <span class="sub-contract-count"><?php echo count($sub_contracts); ?> Adet Mevcut</span>
                <a data-bs-toggle="modal" class="text-primary add-icon" id="open_add_sub_contract_modal"
                   onclick="edit_modal_form('<?php echo base_url("Contract/open_add_sub_contract_modal/$item->id"); ?>','add_sub_contract_modal','AddSubContractModal')">
                    <i class="fa fa-plus-square fa-lg"></i>
                </a>
            </div>
        </div>

        <div class="contract-details-table">
            <?php if (!empty($sub_contracts)) { ?>
                <table class="table table-sm table-borderless">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Sözleşme Adı</th>
                        <th>Yüklenici</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $i = 1;
                    foreach ($sub_contracts as $sub_contract) {
                        // Yüklenici adını al ve bir değişkene ata
                        $yuklenici_adi = company_name($sub_contract->yuklenici);

                        // Metin 30 karakterden uzunsa, sınırlama ve "..." ekleme işlemi yap
                        if (strlen($yuklenici_adi) > 25) {
                            $yuklenici_adi = mb_substr($yuklenici_adi, 0, 25, 'UTF-8') . '...';
                        }
                        ?>
                        <tr class="detail-row">
                            <td class="card-label">#<?php echo $i++; ?></td>
                            <td class="card-text">
                                <a href="<?php echo base_url("contract/file_form/$sub_contract->id"); ?>">
                                    <?php echo $sub_contract->contract_name; ?>
                                </a>
                            </td>
                            <td class="card-text">
                                <a href="<?php echo base_url("contract/file_form/$sub_contract->id"); ?>">
                                    <?php echo $yuklenici_adi; ?>
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            <?php } else { ?>
                <div class="text-center p-3 text-muted">
                    <p class="mb-0">Henüz alt sözleşme bulunmuyor.</p>
                </div>
            <?php } ?>
        </div>
    </div>
<?php } ?>