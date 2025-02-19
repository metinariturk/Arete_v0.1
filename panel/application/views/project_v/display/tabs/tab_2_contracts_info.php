<div class="card-body">
    <div class="card-header bg-dark text-white p-3 rounded">
        <h6 class="mb-0">SÖZLEŞMELER RAPORU</h6>
        <hr style="margin: 3px;">
    </div>

    <!-- Sekme Başlıkları -->
    <ul class="nav nav-tabs" id="contractTabs" role="tablist">
        <?php foreach ($main_contracts as $index => $main_contract) { ?>
            <li class="nav-item" role="presentation">
                <button class="nav-link <?php echo ($index === 0) ? 'active' : ''; ?>" id="tab-<?php echo $main_contract->id; ?>" data-bs-toggle="tab" data-bs-target="#content-<?php echo $main_contract->id; ?>" type="button" role="tab">
                    <?php echo $main_contract->contract_name; ?>
                </button>
            </li>
        <?php } ?>
    </ul>

    <!-- Sekme İçerikleri -->
    <div class="tab-content" id="contractTabsContent">
        <?php foreach ($main_contracts as $index => $main_contract) { ?>
            <div class="tab-pane fade <?php echo ($index === 0) ? 'show active' : ''; ?>" id="content-<?php echo $main_contract->id; ?>" role="tabpanel">

                <table class="table table-bordered mt-3">
                    <thead>
                    <tr>
                        <th>Dosya No</th>
                        <th>Sözleşme Ad</th>
                        <th>Sözleşme Tarih</th>
                        <th>Sözleşme Bedel</th>
                        <th>Yapılan Hakediş</th>
                        <th>Yapılan Tahsilat</th>
                        <th>Durum</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $total_payment = sum_anything("payment", "balance", "contract_id", $main_contract->id);
                    $total_collection = sum_anything("collection", "tahsilat_miktar", "contract_id", $main_contract->id);
                    ?>
                    <tr class="table-success">
                        <td><?php echo $main_contract->dosya_no; ?></td>
                        <td><?php echo $main_contract->contract_name; ?></td>
                        <td><?php echo dateFormat_dmy($main_contract->sozlesme_tarih); ?></td>
                        <td><?php echo money_format($main_contract->sozlesme_bedel); ?></td>
                        <td><?php echo money_format($total_payment); ?></td>
                        <td><?php echo money_format($total_collection); ?></td>
                        <td><?php echo money_format($total_payment - $total_collection); ?></td>
                    </tr>

                    <?php $sub_contracts = $this->Contract_model->get_all(array("parent" => $main_contract->id)); ?>
                    <?php foreach ($sub_contracts as $sub_contract) { ?>
                        <?php
                        $total_payment = sum_anything("payment", "balance", "contract_id", $sub_contract->id);
                        $total_collection = sum_anything("collection", "tahsilat_miktar", "contract_id", $sub_contract->id);
                        ?>
                        <tr class="table-info">
                            <td><?php echo $sub_contract->dosya_no; ?></td>
                            <td><?php echo $sub_contract->contract_name; ?></td>
                            <td><?php echo dateFormat_dmy($sub_contract->sozlesme_tarih); ?></td>
                            <td><?php echo money_format($sub_contract->sozlesme_bedel); ?></td>
                            <td><?php echo money_format($total_payment); ?></td>
                            <td><?php echo money_format($total_collection); ?></td>
                            <td><?php echo money_format($total_payment - $total_collection); ?></td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>

            </div>
        <?php } ?>
    </div>
</div>