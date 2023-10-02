<div class="row">
    <div class="card-body">
        <form action="<?php echo base_url("$this->Module_Name/add_qualify/$item->id"); ?>" method="post"
              enctype="multipart/form-data" id="demo"
              autocomplete="off">

            <?php $qualifies = get_as_array($settings->yeterlilik);
            $istekliler = json_decode($item->istekliler);
            ?>

            <?php

            if (!empty($item->yeterlilik)) {
                $yeterlilikler = json_decode($item->yeterlilik, true);
            } else {
                $yeterlilikler = array();
            }
            ?>


            <div class="row">

                <div class="col-sm-2"><strong>
                        Gerekli Evraklar</strong>
                </div>
                <?php if (!empty($istekliler)) { ?>
                    <?php foreach ($istekliler as $istekli) { ?>
                        <div class="col-sm-1"><strong>
                                <?php echo company_name($istekli); ?></strong>
                        </div>
                    <?php } ?>
                <?php } ?>
            </div>


            <?php $qualifies = get_as_array($settings->yeterlilik);
            $j = 0; ?>
            <?php foreach ($qualifies as $qualify) { ?>
                <div class="row">
                    <div class="col-sm-2"><strong>
                            <?php echo $qualify; ?></strong>
                    </div>
                    <?php if (!empty($istekliler)) { ?>

                        <?php
                        foreach ($istekliler as $istekli) { ?>
                            <div class="col-sm-1">
                                <div class="media-body text-start icon-state switch-outline">
                                    <label class="switch">
                                        <input class="isActive"
                                               type="checkbox"
                                               name="yeterlilik[]"
                                            <?php foreach ($yeterlilikler as $yeterlilik) {
                                                $a = array_keys($yeterlilik);
                                                foreach ($a as $b) {
                                                    if ($b == $istekli) {
                                                        if (array_search($qualify, $yeterlilik[$b]) !== FALSE) {
                                                            echo "checked";
                                                        }
                                                    }
                                                }

                                            } ?>
                                               value="<?php echo $istekli . ":" . $qualify; ?>">
                                        <span class="switch-state bg-success"></span>
                                    </label>
                                </div>
                            </div>
                        <?php } ?>
                    <?php } ?>
                </div>
                <hr>
            <?php } ?>
            <button class="pager-btn btn btn-success btn-outline" type="submit" value="Submit" name="submitBtn">
                <i class="fa fa-floppy-o" aria-hidden="true"></i> Değerleme Tutanağını Kaydet
            </button>
        </form>
    </div>
</div>

