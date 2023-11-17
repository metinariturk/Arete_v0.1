<table class="display" id="list" style="font-size: 12px;">
    <thead>
    <tr>
        <th colspan="3" style="text-align:center; width: 50px;">
            <a id="category" href="#"
               url="<?php echo base_url("$this->Module_Name/show_sub/$item->id/$main_id"); ?>"
               onclick="back_to_book(this)" method="post"
               enctype="multipart">
                <i class="fa fa-angle-double-left"></i>
            </a>
            POZ Listesi
        </th>
    </tr>
    <tr>
        <th style="width: 10%;">Poz No</th>
        <th style="width: 50%;">Poz Adı</th>
        <th style="width: 20%;">Birimi</th>
        <th style="width: 10%;">Ekle</th>
    </tr>
    </thead>
    <tbody class="sortable">
    <?php if (isset($book_items)) { ?>
        <?php foreach ($book_items as $book_item) { ?>
            <tr>
                <td style="text-align: center"><?php echo $book_item->item_code; ?></td>
                <td><?php echo $book_item->item_name; ?></td>
                <td style="text-align: center"><?php echo $book_item->item_unit; ?></td>
                <td style="text-align: center">
                    <a href="#" onclick="add_in_group(this)"
                       url="<?php echo base_url("$this->Module_Name/add_item_sub/$item->id/$book_item->id"); ?>">
                        <i style="color: green" class="fa fa-arrow-circle-right fa-lg"></i>
                    </a>
                </td>
            </tr>
        <?php } ?>
    <?php } ?>
    </tbody>
</table>
