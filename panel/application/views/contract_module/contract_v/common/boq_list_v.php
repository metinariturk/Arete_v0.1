<div class="row">
    <div class="col-md-12 col-lg-6">
        <div class="card-body">
            <div class="card-header">
                <h5 class="text-center"><?php if (isset($book->id)) { ?>
                        <?php echo $book->book_name; ?>
                        <a href="#" data-url="<?php echo base_url("Contract/add_book/$item->id"); ?>"
                           onclick="add_book(this)">
                            <i style="color: tomato" class="fa fa-cancel"></i>
                        </a>
                    <?php } ?></h5>
            </div>
            <?php if (!isset($book)) { ?>
                <div class="row">
                    Poz Kitabını Seçiniz
                    <?php foreach ($books as $book) { ?>
                        <a href="#" data-url="<?php echo base_url("Contract/add_book/$item->id/$book->id"); ?>"
                           onclick="add_book(this)">
                            <?php echo $book->book_name; ?>
                        </a>
                    <?php } ?>
                </div>
            <?php } else { ?>
                <?php if (!empty($active_boqs)) { ?>
                    <?php foreach ($active_boqs as $active_boq=>$asd) { ?>
                        <?php echo $asd; ?>
                    <?php } ?>
                <?php } ?>
                <input type="text" id="main_group" placeholder="Ana İş Grubu Ekle">
                <a href="#" id="add_main" data-url="<?php echo base_url("Contract/add_maingroup/$item->id"); ?>"
                   onclick="add_main()">
                    <i style="color: green" class="fa fa-arrow-right"></i>
                </a>
            <?php } ?>
        </div>
    </div>
    <div class="col-md-12 col-lg-6">
        <div class="card-body">
            <div class="card-header">
                <h5 class="text-center">İş Grupları</h5>
            </div>
            <div class="row">,
                Poz Seçi Gruba Ekle
            </div>
        </div>
    </div>
</div>
