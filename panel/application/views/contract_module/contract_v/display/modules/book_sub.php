<table class="table" style="width:100%; font-size: 12px;">
    <thead>
    <tr>
        <th colspan="3" style="text-align:center; width: 50px;">POZ KİTAPLARI<p>&nbsp;</p></th>
    </tr>
    <tr>
        <th style="width: 50px;">Alt Grup</th>
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
