<table class="table" style="width:100%; font-size: 12px;">
    <thead>
    <tr>
        <th colspan="3" style="text-align:center; width: 50px;">
            <a id="category" href="#"
               url="<?php echo base_url("$this->Module_Name/back_to_book/$item->id"); ?>"
               onclick="back_to_book(this)" method="post"
               enctype="multipart">
                <i class="fa fa-angle-double-left"></i>
            </a>

                Ana Başlıklar
        </th>
    </tr>
    </thead>
    <tbody class="sortable">
    <?php if (isset($main_groups)) { ?>
        <?php foreach ($main_groups as $main_group) { ?>
            <tr>
                <td>
                    <a id="category" href="#"
                       url="<?php echo base_url("$this->Module_Name/show_sub/$item->id/$main_group->id"); ?>"
                       onclick="show_sub(this)" method="post" enctype="multipart">
                        <?php echo $main_group->main_code; ?>.<?php echo $main_group->main_name; ?>
                    </a>
                </td>
            </tr>
        <?php } ?>
    <?php } ?>
    </tbody>
</table>
