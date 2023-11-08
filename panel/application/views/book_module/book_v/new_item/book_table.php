<table class="table" style="width:100%; font-size: 12px;">
    <thead>
    <tr>
        <th colspan="3" style="text-align:center; width: 50px;">POZ KİTAPLARI<p>&nbsp;</p></th>
    </tr>
    </thead>
    <tbody class="sortable" data-url="<?php echo base_url("book/book_rankSetter"); ?>">
    <?php foreach ($sortedBooks as $book) { ?>
        <tr id="book-<?php echo $book->id; ?>">
            <td><i class="fa fa-reorder"></i></td>
            <td>
                <a id="category" href="#"
                   url="<?php echo base_url("$this->Module_Name/show_main/$book->id"); ?>"
                   onclick="show_main(this)" method="post" enctype="multipart">
                    <?php echo $book->book_name; ?>-<?php echo $book->owner; ?>
                </a>
            </td>
            <td><i style="font-size: 18px; color: grey;" class="fa fa-times-circle-o" aria-hidden="true"></i></td>
        </tr>
    <?php } ?>
    </tbody>
</table>
