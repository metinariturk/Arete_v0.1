<div class="card">
    <div class="card-header">
        <?php echo $main_group->code; ?>.<?php echo $main_group->name; ?>
        <br>
        <?php echo $main_group->code; ?>.<?php echo $sub_group->code; ?>.<?php echo $sub_group->name; ?>
    </div>
    <div class="card-body">
        <!-- Form başlangıcı -->
        <form id="leaderForm" method="POST" action="<?php echo base_url("contract/add_price_to_sub/$contract->id/$sub_group->id"); ?>">
            <input type="text" id="searchInput" class="form-control mb-3" placeholder="İmalat Kalemi Ara...">
            <hr>
            <button type="button" class="btn btn-secondary" id="selectAllBtn">Tümünü Seç</button>
            <button type="submit" class="btn btn-primary">Seçimleri Gruba Kaydet</button>
            <hr>
            <div id="leaderList">
                <?php
                $boq_items = $this->Contract_price_model->get_all(array('contract_id' => $contract->id, "sub_id" => $sub_group->id), "rank ASC");

                // BOQ item'larının leader_id'lerini bir diziye alalım
                $boq_leader_ids = array_map(function($item) {
                    return $item->leader_id;
                }, $boq_items);
                ?>

                <?php foreach ($leaders as $leader) {
                    // Eğer $leader->id, $boq_leader_ids dizisinde varsa checkbox'ı işaretli yapalım
                    $isChecked = in_array($leader->id, $boq_leader_ids) ? 'checked' : '';
                    ?>

                    <div class="form-check leader-item">
                        <input class="form-check-input" type="checkbox" name="leaders[]" value="<?php echo $leader->id; ?>" <?php echo $isChecked; ?>>
                        <label class="form-check-label">
                            <?php echo $leader->code; ?> - <?php echo $leader->name; ?> - <?php echo $leader->unit; ?> - <?php echo $leader->price; ?>
                        </label>
                        <span>

                            <?php $paymnent_boqs = $this->Boq_model->get_all(array('leader_id' => $leader->id, "sub_id" => $sub_group->id, "contract_id" => $contract->id)); ?>
                            <?php echo count($paymnent_boqs); ?>
                        </span>
                    </div>
                <?php } ?>
            </div>
        </form>
        <!-- Form bitişi -->
    </div>
</div>
