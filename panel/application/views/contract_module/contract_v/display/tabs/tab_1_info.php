<?php if ($item->parent) { ?>
    <h6><?php echo mb_strtoupper(contract_code($item->parent) . " / " . contract_name($item->parent)); ?></h6>
<?php } ?>
<h5 class="mb-0">
    <?php echo mb_strtoupper($item->dosya_no . " / " . $item->contract_name); ?>
    <small style="font-size: 14px;">(
        <?php
        if ($item->isActive == 1) {
            echo "Devam eden sözleşme";
        } elseif ($item->isActive == 2) {
            echo "Tamamlanan sözleşme";
        }
        ?>)
    </small>
</h5>
<?php echo mb_strtoupper(company_name($item->yuklenici)); ?>
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
            <div id="contract_table">
                <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/contract/contract_table"); ?>
            </div>
        </div>
        <!-- Sağ Alt Sözleşmeler -->
        <?php if (!$item->parent) { ?>
           <?php $sub_contracts = $this->Contract_model->get_all(array('parent' => $item->id)); ?>
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
