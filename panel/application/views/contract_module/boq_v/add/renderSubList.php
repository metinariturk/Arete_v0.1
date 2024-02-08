<table class="table table-responsive active_group" group-id="<?php echo $sub_id; ?>">
    <thead>
    <tr>
        <th colspan="4" style="text-align:center; width: 50px;">
            <a id="category" href="#"
               url="<?php echo base_url("$this->Module_Name/back_main/$item->id/$payment->id"); ?>"
               onclick="back_main(this)"
               method="post"
               enctype="multipart">
                <i class="fa fa-angle-double-left"></i>
            </a>
            Ana Gruplar
        </th>
    </tr>
    <tr>
        <th>

        </th>
        <th colspan="2"><?php echo $main_group->name; ?> - <?php echo $sub_group->name; ?></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($sub_cont_items as $sub_cont_item) { ?>
        <tr>
            <td>
                <?php echo $sub_cont_item->item_id; ?>
            </td>
            <td>
                <a onclick="renderCalculate(this)"
                   href="#"
                   data-bs-original-title=""
                   title=""
                    <?php if ($sub_cont_item->type == "rebar"){ ?>
                        url="<?php echo base_url("$this->Module_Name/rebar_render/$contract->id/$payment->id/$sub_cont_item->id"); ?>">
                    <?php } else { ?>
                        url="<?php echo base_url("$this->Module_Name/calculate_render/$contract->id/$payment->id/$sub_cont_item->id"); ?>">
                    <?php } ?>
                    <?php echo $sub_cont_item->name; ?>
                    <span class="text-danger"> <?php if ($sub_cont_item->type == "rebar") {
                            echo "Donatı Metrajı";
                        }; ?></span>
                </a>
            </td>
            <td>
                <?php echo $sub_cont_item->unit; ?>
            </td>
        </tr>
    <?php } ?>
    </tbody>
</table>
