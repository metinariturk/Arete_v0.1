<div class="container mt-4">
    <ul class="tree-structure">
        <?php foreach ($prices_main_groups as $prices_main_group) { ?>
            <li>
                <span class="num"><?php echo $prices_main_group->code; ?></span>
                <span class="f24" style="color: #808080"><?php echo upper_tr($prices_main_group->name); ?></span>
                <ol>
                    <?php
                    $sub_groups = $this->Contract_price_model->get_all(array('contract_id' => $item->id, "sub_group" => 1, "parent" => $prices_main_group->id), "rank ASC");
                    foreach ($sub_groups as $sub_group) {
                        ?>

                        <li>
                            <span class="num"><?php echo $prices_main_group->code; ?>.<?php echo $sub_group->code; ?></span>
                            <a href="<?php echo base_url("contract/add_contract_price/$sub_group->id"); ?>">
                               <span style="color: #809598"><?php echo upper_tr($sub_group->name); ?> <i class="fa fa-plus-circle fa-lg"></i></span>
                            </a>
                            <ol>
                                <?php
                                $boq_items = $this->Contract_price_model->get_all(array('contract_id' => $item->id, "sub_id" => $sub_group->id), "rank ASC");
                                if (!empty($boq_items)) { ?>
                                    <?php foreach ($boq_items as $boq_item) { ?>
                                        <li>
                                            <span class="num"><?php echo $boq_item->code; ?></span>
                                            <span style="color: #91b0b4"><?php echo $boq_item->name; ?> (<?php echo $boq_item->unit; ?>)</span>
                                        </li>
                                    <?php } ?>
                                <?php } ?>
                            </ol>
                        </li>
                    <?php } ?>
                </ol>
            </li>
        <?php } ?>
    </ul>
</div>