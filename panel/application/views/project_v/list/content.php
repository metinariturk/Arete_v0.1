<div class="col-sm-12">
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="example" class="table table-xl">
                    <thead>
                    <tr>
                        <th style="width: 15px;">Proje ID</th>
                        <th colspan="3">Proje Adı</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($items as $item): ?>
                        <?php $main_contract = $this->Contract_model->get(array("proje_id" => $item->id, "parent" => 0)); ?>
                        <?php if ($main_contract): ?>
                            <tr class="parent" data-parent="<?php echo $item->id; ?>">
                                <td><?php echo $item->id; ?></td>
                                <td><?php echo $item->proje_ad; ?></td>
                                <td><a href="<?php echo base_url("$this->Module_Name/file_form/$item->id"); ?>">
                                        Git </a></td>
                            </tr>
                            <tr class="child parent-<?php echo $item->id; ?>" style="display: none;">
                                <td></td>
                                <td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <a href="<?php echo base_url("Contract/file_form/$main_contract->id"); ?>">
                                        <i class="fa fa-star" style="color: gold"></i> Ana Sözleşme
                                        - <?php echo $main_contract->sozlesme_ad; ?>
                                    </a>
                                </td>
                            </tr>
                            <?php $sub_contracts = $this->Contract_model->get_all(array("proje_id" => $item->id, "parent" => $main_contract->id)); ?>
                            <?php foreach ($sub_contracts as $sub_contract): ?>
                                <tr class="child parent-<?php echo $item->id; ?>" style="display: none;">
                                    <td></td>
                                    <td colspan="2">
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <a href="<?php echo base_url("Contract/file_form/$sub_contract->id"); ?>">
                                            <i class="fa fa-arrow-circle-o-right"
                                               style="color: green"></i> <?php echo $sub_contract->sozlesme_ad; ?>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    <?php endforeach; ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>