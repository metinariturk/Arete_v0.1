<div class="card">
    <div class="card-header">
        <?php echo $main_group->code; ?>.<?php echo $main_group->name; ?>
        <br>
        <?php echo $main_group->code; ?>.<?php echo $sub_group->code; ?>.<?php echo $sub_group->name; ?>
    </div>
    <div class="card-body">
        <input type="text" id="searchInput" class="form-control mb-3" placeholder="İmalat Kalemi Ara...">
        <hr>
        <button type="button" class="btn btn-secondary" id="selectAllBtn">Tümünü Seç</button>
        <button type="button" class="btn btn-primary" onclick="saveSelection()">Seçimleri Gruba Kaydet</button>
        <hr>
        <div id="leaderList">
            <?php foreach ($leaders as $leader) { ?>
                <div class="form-check leader-item">
                    <input class="form-check-input" type="checkbox" name="leaders[]" value="<?php echo $leader->id; ?>">
                    <label class="form-check-label">
                        <?php echo $leader->code; ?> - <?php echo $leader->name; ?> - <?php echo $leader->unit; ?>
                        - <?php echo $leader->price; ?>
                    </label>
                </div>
            <?php } ?>
        </div>
    </div>
</div>

