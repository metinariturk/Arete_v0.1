<table class="display" id="list" style="font-size: 12px;">
<thead>
    <tr>
        <th colspan="3" style="text-align:center; width: 50px;">POZ Listesi<p>&nbsp;</p></th>
    </tr>
    <tr>
        <th style="width: 50px;">Poz No</th>
        <th style="width: 50px;">Poz Adı</th>
        <th style="width: 50px;">Birimi</th>
    </tr>
    </thead>
    <tbody class="sortable">
    <?php if (isset($book_items)) { ?>
        <?php foreach ($book_items as $book_item) { ?>
            <tr>
                <td><a href="#" ondblclick="add_in_group(this)" url="<?php echo base_url("$this->Module_Name/add_item_sub/$item->id/$book_item->id"); ?>">
                        <?php echo $book_item->item_code; ?></a> </td>
                <td><?php echo $book_item->item_name; ?></td>
                <td><?php echo $book_item->item_unit; ?></td>
            </tr>
        <?php } ?>
    <?php } ?>
    </tbody>
</table>
