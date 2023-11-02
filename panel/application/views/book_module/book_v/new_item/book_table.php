<div class="card-body">
    <table class="table" style="font-size: 12px;">
        <thead>
        <tr>
            <th style="width: 50px;">Kitap Adı</th>
            <th style="width: 50px;">Kurum/Kuruluş</th>
            <th style="width: 50px;">Poz Sayısı</th>
        </tr>
        </thead>
        <tbody class="sortable">
        <?php foreach ($sortedBooks as $book) { ?>
            <tr>
                <td>
                    <a id="category" href="#"
                       url="<?php echo base_url("$this->Module_Name/add_group/$book->id"); ?>"
                       onclick="add_book(this)" method="post" enctype="multipart">
                        <?php echo $book->book_name; ?>
                    </a>
                </td>
                <td>
                    <?php echo $book->owner; ?>
                </td>
                <td>
                    <?php echo count(get_book($book->db_name)); ?>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>
