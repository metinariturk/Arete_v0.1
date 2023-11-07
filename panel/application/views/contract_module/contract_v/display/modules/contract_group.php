<table class="table table-striped">
    <tbody>
    <?php foreach ($main_groups as $main_group) { ?>
        <tr>
            <td style="font-size: large">
                <?php echo $main_group->group_name; ?>
            </td>
        </tr>
        <?php $sub_groups = $this->Contract_price_model->get_all(array('contract_id' => $item->id, "sub_group" => 1, "parent" => $main_group->id)); ?>
        <?php foreach ($sub_groups as $sub_group) { ?>
            <tr>
                <td style="padding-left: 40px;">
                    <a id="category" href="#"
                       url="<?php echo base_url("$this->Module_Name/open_sub/$item->id/$sub_group->id"); ?>"
                       onclick="open_contract_group(this)" method="post" enctype="multipart">
                        <?php echo $sub_group->group_name; ?>
                    </a>
                </td>
            </tr>
        <?php } ?>
    <?php } ?>
    </tbody>
</table>
