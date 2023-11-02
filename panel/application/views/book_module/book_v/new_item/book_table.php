<div class="card-body">
    <table class="table" style="font-size: 12px;">
        <thead>
        <tr>
            <th colspan="3" style="text-align:center; width: 50px;">POZ KİTAPLARI<p>&nbsp;</p></th>
        </tr>
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
                       url="<?php echo base_url("$this->Module_Name/show_main/$book->id"); ?>"
                       onclick="show_main(this)" method="post" enctype="multipart">
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
