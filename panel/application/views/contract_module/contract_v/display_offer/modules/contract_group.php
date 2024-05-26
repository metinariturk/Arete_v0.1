<?php if (isset($main_groups)) { ?>
    <table class="table table-responsive">
        <tbody>
        <?php foreach ($main_groups as $main_group) { ?>
            <tr>
                <td style="font-size: medium">
                    <?php echo $main_group->code; ?>
                </td>
                <td style="font-size: large">
                    <?php echo $main_group->name; ?>
                </td>
                <td>
                    <a id="category" href="#"
                       url="<?php echo base_url("$this->Module_Name/delete_main/$item->id/$main_group->id"); ?>"
                       onclick="delete_item(this)" method="post" enctype="multipart">
                        <i class="fa fa-minus-circle"></i>
                    </a>
                </td>
            </tr>
            <?php $sub_groups = $this->Contract_price_model->get_all(array('contract_id' => $item->id, "sub_group" => 1, "parent" => $main_group->id)); ?>
            <?php foreach ($sub_groups as $sub_group) { ?>
                <tr>
                    <td style="padding-left: 20px;"><?php echo $main_group->code; ?>.<?php echo $sub_group->code; ?></td>
                    <td>
                        <a id="category" href="#"
                           url="<?php echo base_url("$this->Module_Name/open_sub/$item->id/$sub_group->id"); ?>"
                           onclick="open_contract_group(this)" method="post" enctype="multipart">
                            <?php echo $sub_group->name; ?>
                        </a>
                    </td>
                    <td>
                        <a id="category" href="#"
                           url="<?php echo base_url("$this->Module_Name/delete_sub/$item->id/$sub_group->id"); ?>"
                           onclick="delete_item(this)" method="post" enctype="multipart">
                            <i class="fa fa-minus-circle"></i>
                        </a>
                    </td>
                </tr>
            <?php } ?>
        <?php } ?>
        </tbody>
    </table>
<?php } elseif (isset($sub_group)) { ?>
    <table class="table table-responsive active_group" group-id="<?php echo $sub_id; ?>">
        <thead>
        <tr>
            <th colspan="4" style="text-align:center; width: 50px;">
                <a id="category" href="#"
                   url="<?php echo base_url("$this->Module_Name/back_main/$item->id"); ?>"
                   onclick="back_main(this)"
                   method="post"
                   enctype="multipart">
                    <i class="fa fa-angle-double-left"></i>
                </a>
                Sözleşme Grupları
            </th>
        </tr>
        <tr>
            <th>

            </th>
            <th colspan="3"><?php echo $main_group->name; ?> - <?php echo $sub_group->name; ?></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($sub_cont_items as $sub_cont_item) { ?>
            <tr>
                <td>
                    <?php echo $sub_cont_item->item_id; ?>
                </td>
                <td>
                    <?php echo $sub_cont_item->name; ?>
                </td>
                <td>
                    <?php echo $sub_cont_item->unit; ?>
                </td>
                <td>
                    <a id="category" href="#"
                       url="<?php echo base_url("$this->Module_Name/delete_item/$item->id/$sub_cont_item->id"); ?>"
                       onclick="delete_item(this)" method="post" enctype="multipart">
                        <i class="fa fa-minus-circle"></i>
                    </a>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
<?php } ?>
