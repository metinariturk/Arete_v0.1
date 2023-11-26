<div class="row box-col-3">
    <div class="repeater">
        <div class="container">
            <div class="row">
                <div class="col-11">
                    <h5>Çalışan Ekipler
                        <button data-repeater-create type="button" class="btn btn-success add_btn">
                            <i class="fa fa-plus"></i>
                        </button>
                    </h5>
                </div>
            </div>
        </div>
        <?php $i = 99; ?>
        <?php foreach ($workgroups as $workgroup) { ?>
            <?php $i -= 1; $j = $i; ?>
            <div class="row">
                <div class="col-sm-4 col-md-3">
                    <div class="mb-2">
                        <select id="select2-demo-1" class="form-control"
                                data-plugin="select2" name="workgroups[<?php echo $j; ?>][workgroup]">
                            <option selected="selected[]" value="<?php echo $workgroup->workgroup; ?>"><?php echo group_name($workgroup->workgroup); ?>
                            </option>
                            <?php foreach ($active_workgroups as $active_workgroup => $group_codes) {
                                foreach ($group_codes as $group_code) { ?>
                                    <option value="<?php echo $group_code; ?>"> <?php echo group_name($group_code); ?></option>
                                <?php } ?>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="col-sm-4 col-md-2">
                    <div class="mb-2">
                        <input type="number" min="1" step="any" class="form-control" value="<?php echo $workgroup->number; ?>"
                               name="workgroups[<?php echo $j; ?>][worker_count]" placeholder="Sayısı">
                    </div>
                </div>
                <div class="col-sm-4 col-md-3">
                    <div class="mb-2">
                        <input type="text" class="form-control" value="<?php echo $workgroup->place; ?>"
                               name="workgroups[<?php echo $j; ?>][place]" placeholder="Mahal">
                    </div>
                </div>
                <div class="col-sm-10 col-md-3">
                    <div class="mb-2">
                        <input type="text" class="form-control" value="<?php echo $workgroup->notes; ?>"
                               name="workgroups[<?php echo $j; ?>][notes]" placeholder="Açıklama">
                    </div>
                </div>
                <div class="col-sm-1 col-md-1">
                    <div class="mb-2">
                        <button type="button" class="btn btn-danger delete-old-btn"><i class="fa fa-trash"></i></button>
                    </div>
                </div>
            </div>
        <?php } ?>

        <div data-repeater-list="workgroups">
            <div data-repeater-item>
                <div class="row">
                    <div class="col-sm-4 col-md-3">
                        <div class="mb-2">
                            <select id="select2-demo-1" class="form-control"
                                    data-plugin="select2" name="workgroup">
                                <option selected="selected[]" value="">İş Grubu Seçiniz
                                </option>
                                <?php foreach ($active_workgroups as $active_workgroup => $workgroups) {
                                    foreach ($workgroups as $workgroup) { ?>
                                        <option value="<?php echo $workgroup; ?>"> <?php echo group_name($workgroup); ?></option>
                                    <?php } ?>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-4 col-md-2">
                        <div class="mb-2">
                            <input type="number" min="1" step="any" class="form-control"
                                   name="worker_count" placeholder="Sayısı">
                        </div>
                    </div>
                    <div class="col-sm-4 col-md-3">
                        <div class="mb-2">
                            <input type="text" class="form-control"
                                   name="place" placeholder="Mahal">
                        </div>
                    </div>
                    <div class="col-sm-10 col-md-3">
                        <div class="mb-2">
                            <input type="text" class="form-control"
                                   name="notes" placeholder="Açıklama">
                        </div>
                    </div>
                    <div class="col-sm-1 col-md-1">
                        <div class="mb-2">
                            <button data-repeater-delete type="button" class="btn btn-danger"><i
                                        class="fa fa-trash"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
