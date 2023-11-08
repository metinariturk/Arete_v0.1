<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Yeni Poz Kitabı</h5>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="#" url="<?php echo base_url("$this->Module_Name/add_book"); ?>" id="save_book"
                      method="post">
                    <label class="col-form-label" for="book_name">Poz Kitabı Adı:</label>
                    <input class="form-control" name="book_name">
                    <label class="col-form-label" for="book_name">Poz Kitabı Yılı:</label>
                    <input class="form-control" name="year">
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" type="button" data-bs-dismiss="modal">Close</button>
                <button class="btn btn-secondary" type="button" id="save_button" form="save_book">Save changes</button>
            </div>
        </div>
    </div>
</div>
<table class="display" id="book" style="font-size: 12px;">
    <thead>
    <tr>
        <th colspan="3">Poz Kitabı Adı</th>
    </tr>
    <tr>
        <th style="width: 50px;">Adı</th>
        <th style="width: 100px;">Yılı</th>
        <th style="width: 50px;">Sayısı</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($all_books as $book) { ?>
        <tr>
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
                <?php  ?>
            </td>
        </tr>
    <?php } ?>
    </tbody>
</table>
