<?php if (!$item->parent) { ?>
    <div class="tabs mb-4">
        <div class="tab-item" style="background-color: rgba(199,172,134,0.43);">
            <b>Alt Sözleşmeler<br><?php echo count($sub_contracts); ?> Adet Alt Sözleşme Mevcut</b>
            <td>
                <a data-bs-toggle="modal" class="text-primary" id="open_add_sub_contract_modal"
                   onclick="edit_modal_form('<?php echo base_url("Contract/open_add_sub_contract_modal/$item->id"); ?>','add_sub_contract_modal','AddSubContractModal')">
                    <i class="fa fa-plus-square fa-lg"></i>
                </a>
            </td>
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
<?php } ?>