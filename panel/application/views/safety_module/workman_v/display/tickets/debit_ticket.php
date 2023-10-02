<div class="bg-color-op-yellow">
    <div class="clearfix m-b-sm">
        <div class="col-md-4"><strong>Zimmetler</strong></div>
        <div class="col-md-8">
            <a href="<?php echo base_url("workman/file_form/$item->id/2"); ?>">
                <div class="alert alert-success" role="alert">
                    <strong><?php $debits = get_from_any_array("debit", "worker_id", "$item->id");
                        if (isset($debits
                        )) {
                            echo count($debits
                            );
                        } else {
                            echo "0";
                        } ?>
                    </strong>
                    <span>Adet Zimmet Mevcut</span>
                </div>
            </a>
            <?php $control2 = get_from_any_and_array("debit", "worker_id", $item->id, "safety_id", "$item->safety_id"); ?>
            <?php $req_debits = get_as_array($settings->isg_debit); ?>
            <?php foreach ($control2 as $x) { ?>
                <?php $x = array_unique(array_column($x, "zimmet_turu")); ?>
                <?php $mevcut = count($x); ?>
                <?php $gerekli = count($req_debits); ?>
                <?php $fark = $gerekli - $mevcut; ?>
                <?php if ($fark > 0) { ?>
                    <a href="<?php echo base_url("workman/file_form/$item->id/2"); ?>">
                        <div class="alert alert-danger" role="alert">
                            <strong><?php echo $fark; ?> </strong>
                            <span>Adet Zorunlu Zimmet Verilmemiş</span>
                        </div>
                    </a>
                <?php } else { ?>
                    <a href="<?php echo base_url("workman/file_form/$item->id/2"); ?>">
                        <div class="alert alert-success" role="alert">
                            <strong> Tebrikler !</strong><br>
                            <span>Zorunlu Zimmet Tümü Verilmiş</span>
                        </div>
                    </a>
                <?php } ?>
            <?php } ?>
        </div>
    </div>
</div>
