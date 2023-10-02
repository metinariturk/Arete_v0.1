<div class="bg-color-op-green">
    <div class="clearfix m-b-sm">
        <div class="col-md-4"><strong>Eğitimler</strong></div>
        <div class="col-md-8">
            <a href="<?php echo base_url("workman/file_form/$item->id/2"); ?>">
                <div class="alert alert-success" role="alert">
                    <strong><?php $educations = get_from_any_array("education", "worker_id", "$item->id");
                        if (isset($educations
                        )) {
                            echo count($educations
                            );
                        } else {
                            echo "0";
                        } ?>
                    </strong>
                    <span>Adet Eğtim Verilmiş</span>
                </div>
            </a>
            <?php $control2 = get_from_any_and_array("education", "worker_id", $item->id, "safety_id", "$item->safety_id"); ?>
            <?php $req_educations = get_as_array($settings->isg_education); ?>
            <?php foreach ($control2 as $x) { ?>
                <?php $x = array_unique(array_column($x, "egitim_turu")); ?>
                <?php $mevcut = count($x); ?>
                <?php $gerekli = count($req_educations); ?>
                <?php $fark = $gerekli - $mevcut; ?>
                <?php if ($fark > 0) { ?>
                    <a href="<?php echo base_url("workman/file_form/$item->id/2"); ?>">
                        <div class="alert alert-danger" role="alert">
                            <strong><?php echo $fark; ?> </strong>
                            <span>Adet Zorunlu Eğitim Verilmemiş</span>
                        </div>
                    </a>
                <?php } else { ?>
                    <a href="<?php echo base_url("workman/file_form/$item->id/2"); ?>">
                        <div class="alert alert-success" role="alert">
                            <strong> Tebrikler !</strong><br>
                            <span>Zorunlu Eğitimlerin Tümü Verilmiş</span>
                        </div>
                    </a>
                <?php } ?>
            <?php } ?>
        </div>
    </div>
</div>
