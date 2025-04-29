<button type="submit" class="btn btn-success">
    <i class="fa fa-floppy-o fa-lg"></i> Kaydet ve Hakedişe Geri Dön
</button>

<table class="table table-responsive">
    <tbody>
    <?php foreach ($main_groups as $main_group) { ?>
        <tr>
            <td style="font-size: medium" colspan="2">
                <?php echo $main_group->code; ?> - <?php echo $main_group->name; ?>
            </td>
        </tr>
        <?php $sub_groups = $this->Contract_price_model->get_all(array('contract_id' => $contract->id, "sub_group" => 1, "parent" => $main_group->id)); ?>
        <?php $i = 1; ?>
        <?php foreach ($sub_groups as $sub_group) { ?>
            <tr>
                <td style="padding-left: 20px; width: 10%;">
                    <?php echo $i++; ?>
                <td>
                    <a id="category" href="#"
                       url="<?php echo base_url("Boq/open_sub/$contract->id/$sub_group->id/$payment->id"); ?>"
                       onclick="open_contract_group(this)" method="post" enctype="multipart">
                        <?php if (empty($sub_group->name)){ echo "Alt Grup ".$i; } else { echo $sub_group->name; } ?>
                    </a>
                </td>
            </tr>
        <?php } ?>
    <?php } ?>
    </tbody>
</table>
