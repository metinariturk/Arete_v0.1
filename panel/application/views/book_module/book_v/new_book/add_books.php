<div class="card-body">
    <table class="display" id="book" style="font-size: 12px;">
        <thead>
        <tr>
            <th style="width: 50px;">Kodu</th>
            <th style="width: 50px;">Adı</th>
            <th style="width: 100px;">Yılı</th>
            <th style="width: 50px;">Kurum/Kuruluş</th>
            <th style="width: 50px;">Sayısı</th>
            <th style="width: 50px;">Durum</th>
        </tr>
        </thead>
        <tbody class="sortable">
        <?php foreach ($sortedBooks as $book) { ?>
            <tr>
                <td>
                    <?php echo $book->db_name; ?>
                </td>
                <td>
                    <a id="category"
                       href="#"
                       url="<?php echo base_url("$this->Module_Name/show_book/$book->id"); ?>"
                       onclick="show_book(this)"
                       method="post"
                       enctype="multipart">
                        <?php echo $book->book_name; ?>
                    </a>
                </td>
                <td>
                    <?php echo $book->book_year; ?>
                </td>
                <td>
                    <?php echo $book->owner; ?>
                </td>
                <td>
                </td>
                <td>
                    <div class="media-body text-center icon-state switch-outline">
                        <label class="switch">
                            <input id="isActive" type="checkbox" name="isActive" class="isActive"
                                <?php echo ($book->isActive) ? "checked" : ""; ?>
                                   data-url="<?php echo base_url("Book/isActiveSetter/$book->id"); ?>"
                                   data-bs-original-title=""
                                   title="">
                            <span class="switch-state bg-primary"></span>
                        </label>
                    </div>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>
