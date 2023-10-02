<div class="bg-color-op-yellow">
    <div class="clearfix m-b-sm">
        <div class="col-md-4"><strong>Sağlık Kontrolleri</strong></div>
        <div class="col-md-8">
            <a href="<?php echo base_url("workman/file_form/$item->id/3"); ?>">
                <div class="alert alert-success" role="alert">
                    <strong><?php $checkups = get_from_any_array("checkup", "worker_id", "$item->id");
                        if (isset($checkups
                        )) {
                            echo count($checkups
                            );
                        } else {
                            echo "0";
                        } ?>
                    </strong>
                    <span>Adet Sağlık Raporu</span>
                </div>
            </a>
            <?php $control2 = get_from_any_and_array("checkup", "worker_id", $item->id, "safety_id", "$item->safety_id"); ?>
            <?php $req_checkups = get_as_array($settings->isg_checkup); ?>
            <?php foreach ($control2 as $x) { ?>
                <?php $x = array_unique(array_column($x, "checkup_turu")); ?>
                <?php $mevcut = count($x); ?>
                <?php $gerekli = count($req_checkups); ?>
                <?php $fark = $gerekli - $mevcut; ?>
                <?php if ($fark > 0) { ?>
                    <a href="<?php echo base_url("workman/file_form/$item->id/3"); ?>">
                        <div class="alert alert-danger" role="alert">
                            <strong><?php echo $fark; ?> </strong>
                            <span>Adet Zorunlu Sağlık Raporu Verilmemiş</span>
                        </div>
                    </a>
                <?php } else { ?>
                    <a href="<?php echo base_url("workman/file_form/$item->id/3"); ?>">
                        <div class="alert alert-success" role="alert">
                            <strong> Tebrikler !</strong><br>
                            <span>Zorunlu Sağlık Kontrollerinin Tümü Yapılmış</span>
                        </div>
                    </a>
                <?php } ?>
            <?php } ?>
        </div>
    </div>
</div>
