

<div class="col-sm-12">
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table  id="subcontract_list">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Sözleşme Kodu</th>
                        <th>Sözleşme Adı</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $i = 1; ?>
                    <?php foreach ($items as $item) { ?>
                        <tr>
                            <td>
                                <?php echo $i++; ?>
                            </td>
                            <td>
                                <a href="<?php echo base_url("contract/file_form/$item->id"); ?>">
                                    <?php echo contract_code_name($item->id); ?>
                                </a>
                            </td>
                            <td>
                                <?php $sub_contracts = $this->Contract_model->get_all(array("parent" => $item->id),"sozlesme_bedel DESC"); ?>
                                <?php if (!empty($sub_contracts)) { ?>
                                    <?php if (!empty($sub_contracts)) { ?>
                                        <?php $j = 0; ?>
                                        <?php foreach ($sub_contracts as $sub_contract) { ?>
                                            <?php if ($j != 0) { ?>
                                                <hr>
                                            <?php }
                                        ; ?>
                                            <div>
                                                <a href="<?php echo base_url("contract/file_form/$sub_contract->id"); ?>">
                                                    <?php echo $j + 1; ?> - <?php echo $sub_contract->dosya_no; ?> Nolu
                                                    Hakediş
                                                    - <?php echo contract_name($sub_contract->id); ?>
                                                </a>
                                            </div>
                                            <?php $j++; ?>
                                        <?php } ?>
                                    <?php } ?>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>














