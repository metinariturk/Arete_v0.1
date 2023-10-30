<table class="table table-sm">
    <thead>
    <tr>
        <th>Poz Kitabı Adı</th>
        <th>Poz Kitabı Yılı</th>
        <th>Poz Sayısı</th>
    </tr>
    </thead>
    <tbody class="sortable">
    <tr>
        <?php foreach ($all_books as $book) { ?>
            <td>
                <a id="category" href="#"
                   url="<?php echo base_url("$this->Module_Name/show_book/$book->id"); ?>"
                   onclick="show_book(this)"
                   method="post" enctype="multipart">
                    <?php echo $book->book_name; ?>
                </a>
            </td>
            <td>
                <?php echo $book->book_year; ?>
            </td>
            <td>
                <?php echo count(get_book($book->db_name)); ?>
            </td>
        <?php } ?>
    </tr>
    </tbody>
</table>
