<?php foreach ($prices_main_groups as $prices_main_group) { ?>
    <?php echo $prices_main_group->name; ?>
    <br>
    <?php $sub_groups = $this->Contract_price_model->get_all(array('contract_id' => $item->id, "sub_group" => 1, "parent" => $prices_main_group->id), "rank ASC"); ?>
    <?php foreach ($sub_groups as $sub_group) { ?>
        ----<?php echo $sub_group->name; ?>
        <br>
        <?php $boq_items = $this->Contract_price_model->get_all(array('contract_id' => $item->id, "sub_id" => $sub_group->id), "rank ASC"); ?>
        <?php foreach ($boq_items as $boq_item) { ?>
            -------------<?php echo $boq_item->name; ?>
            -------------<?php echo $boq_item->unit; ?>
            -------------<?php echo $boq_item->qty; ?>
            -------------<?php echo $boq_item->price; ?>
            <br>
        <?php } ?>
    <?php } ?>
<?php } ?>