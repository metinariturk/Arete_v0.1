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
    <?php foreach ($sortedBooks as $book) { ?>
        <tr>
            <td>
                <a id="category" href="#"
                   url="<?php echo base_url("$this->Module_Name/show_main/$item->id/$book->id"); ?>"
                   onclick="show_main(this)" method="post" enctype="multipart">
                    <?php echo $book->book_name; ?>-<?php echo $book->owner; ?>(
                    <?php echo count(get_book($book->db_name)); ?>)
                </a>
            </td>
        </tr>
    <?php } ?>
    </tbody>
</table>
