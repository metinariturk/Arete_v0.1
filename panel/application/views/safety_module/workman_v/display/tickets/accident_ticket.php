<div class="bg-color-op-yellow">
    <div class="clearfix m-b-sm">
        <div class="col-md-4"><strong>Kazalar</strong></div>
        <div class="col-md-8">
            <a href="<?php echo base_url("workman/file_form/$item->id/3"); ?>">
                <div class="alert alert-success" role="alert">
                    <strong><?php $accidents = get_from_any_array("accident", "worker_id", "$item->id");
                        if (isset($accidents
                        )) {
                            echo count($accidents
                            );
                        } else {
                            echo "0";
                        } ?>
                        <span>Adet Kaza Mevcut</span>
                    </strong>
                </div>
            </a>
            <?php $danger_accidents = get_from_any_and_array_fe("accident", "worker_id", "$item->id", "bildiri_durumu", null); ?>
            <a href="<?php echo base_url("workman/file_form/$item->id/3"); ?>">
                <strong><?php
                    if (count($danger_accidents) > 0) { ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo count($danger_accidents); ?><span>Adet Kazanın SGK Bildirisi Yapılmamış</span>
                        </div>
                    <?php } else { ?>
                        <div class="alert alert-success" role="alert">
                            <span>Bildirimi Yapılacak Kaza Yok</span>
                        </div>
                    <?php } ?>
                </strong>
            </a>

        </div>
    </div>
</div>
