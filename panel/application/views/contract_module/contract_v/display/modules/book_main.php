<table class="table" style="width:100%; font-size: 12px;">
    <thead>
    <tr>
        <th colspan="3" style="text-align:center; width: 50px;">POZ KİTAPLARI<p>&nbsp;</p></th>
    </tr>
    <tr>
        <th style="width: 50px;">Kitap Adı</th>
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
