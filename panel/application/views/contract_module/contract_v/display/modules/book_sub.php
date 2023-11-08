<table class="table" style="width:100%; font-size: 12px;">
    <thead>
    <tr>
        <th colspan="3" style="text-align:center; width: 50px;">
            <a id="category" href="#"
               url="<?php echo base_url("$this->Module_Name/show_main/$item->id/$book_id"); ?>"
               onclick="back_to_book(this)" method="post"
               enctype="multipart">
                <i class="fa fa-angle-double-left"></i>
            </a>
            Alt Gruplar
        </th>
    </tr>
    </thead>
    <tbody class="sortable">
    <?php if (isset($sub_groups)) { ?>
        <?php foreach ($sub_groups as $sub_group) { ?>
            <tr>
                <td>
                    <a id="category" href="#"
                       url="<?php echo base_url("$this->Module_Name/show_item/$item->id/$sub_group->id"); ?>"
                       onclick="show_items(this)" method="post" enctype="multipart">
                        <?php echo $sub_group->sub_code; ?>. <?php echo $sub_group->sub_name; ?>
                    </a>
                </td>
            </tr>
        <?php } ?>
    <?php } ?>
    </tbody>
</table>
