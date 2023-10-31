<?php if (isset($sub_items)) { ?>
    <table class="display" id="poz" style="font-size: 12px;">
        <thead>
        <tr>
            <th style="width: 5%;"><i class="fa fa-reorder"></i></th>
            <th>Poz No</th>
            <th>Tanımı</th>
            <th>Birimi</th>
        </tr>
        </thead>
        <tbody class="sortable">
        <?php foreach ($sub_items as $sub_item) { ?>
            <tr>
                <td style="width: 5%;">
                    <i class="fa fa-reorder"></i>
                </td>
                <td>
                    <a id="category" href="#"
                       url="<?php echo base_url("$this->Module_Name/show_explain/$book_name/$sub_item->id"); ?>"
                       onclick="show_explain(this)"
                       method="post" enctype="multipart">
                        <?php echo $sub_item->poz_no; ?>
                    </a>
                </td>
                <td><?php echo $sub_item->name; ?></td>
                <td><?php echo $sub_item->unit; ?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
<?php } ?>