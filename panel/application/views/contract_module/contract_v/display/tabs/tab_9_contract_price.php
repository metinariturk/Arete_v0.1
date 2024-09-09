
<div class="container mt-4">
    <h3>Ağaç Yapısı</h3>
    <ul class="tree-structure">
        <?php foreach ($prices_main_groups as $prices_main_group) { ?>

        <li>
            <span class="num"><?php echo $prices_main_group->code; ?></span>
            <a href="#"><?php echo upper_tr($prices_main_group->name); ?>></a>
            <ol>
                <?php
                $sub_groups = $this->Contract_price_model->get_all(array('contract_id' => $item->id, "sub_group" => 1, "parent" => $prices_main_group->id), "rank ASC");
                foreach ($sub_groups as $sub_group) {
                ?>

                <li>
                    <span class="num"><?php echo $sub_group->code; ?></span>
                    <a href="#"><?php echo upper_tr($sub_group->name); ?>
                        <a href="<?php echo base_url("contract/add_contract_price/$sub_group->id"); ?>">
                            <i class="fa fa-plus-circle fa-lg"></i>
                        </a>
                    </a>
                    <ol>
                        <?php
                        $boq_items = $this->Contract_price_model->get_all(array('contract_id' => $item->id, "sub_id" => $sub_group->id), "rank ASC");
                        if (!empty($boq_items)) { ?>
                        <?php foreach ($boq_items as $boq_item) { ?>
                        <li>
                            <span class="num"><?php echo $boq_item->code; ?></span>
                            <a href="#"> <?php echo $boq_item->name; ?> - <?php echo $boq_item->unit; ?></a>
                        </li>
                        <?php } ?>
                        <?php } ?>
                        <li>
                            <span class="num">01</span>
                            <a href="#"> deneme></a>
                        </li><li>
                            <span class="num">012</span>
                            <a href="#"> deneme></a>
                        </li><li>
                            <span class="num">013</span>
                            <a href="#"> deneme></a>
                        </li><li>
                            <span class="num">014</span>
                            <a href="#"> deneme></a>
                        </li><li>
                            <span class="num">051</span>
                            <a href="#"> deneme></a>
                        </li>
                    </ol>
                </li>
                <?php } ?>
            </ol>
        </li>
        <?php } ?>
    </ul>
</div>