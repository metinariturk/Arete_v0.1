<div class="row box-col-3">
    <div class="repeater">
        <div class="container">
            <div class="row">
                <div class="col-11">
                    <h5>Çalışan Makineler
                        <button data-repeater-create type="button" class="btn btn-success add_btn">
                            <i class="fa fa-plus"></i>
                        </button>
                    </h5>
                </div>
                <div class="col-1">

                </div>
            </div>
        </div>
        <?php $wm = 99; ?>
        <?php foreach ($workmachines as $workmachine) { ?>
            <?php $wm -= 1;
            $wmc = $wm; ?>
            <div class="row">
                <div class="col-sm-4 col-md-3">
                    <div class="mb-2">
                        <select id="select2-demo-1" class="form-control"
                                data-plugin="select2" name="workmachine[<?php echo $wm; ?>][workmachine]">
                            <option selected="selected[]" value="<?php echo $workmachine->workmachine; ?>"><?php echo machine_name($workmachine->workmachine); ?>
                                <?php foreach ($active_machines

                                as $active_machine => $workmachine_codes) {
                                foreach ($workmachine_codes

                                as $workmachine_code) { ?>
                            <option value="<?php echo $workmachine_code; ?>"> <?php echo machine_name($workmachine_code); ?></option>
                            <?php } ?>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="col-sm-4 col-md-2">
                    <div class="mb-2">
                        <input type="number" min="1" step="any" class="form-control"
                               value="<?php echo $workmachine->number; ?>"
                                name="workmachine[<?php echo $wm; ?>][machine_count]">
                    </div>
                </div>
                <div class="col-sm-4 col-md-3">
                    <div class="mb-2">
                        <input type="text" class="form-control" value="<?php echo $workmachine->place; ?>"
                                name="workmachine[<?php echo $wm; ?>][machine_place]">
                    </div>
                </div>
                <div class="col-sm-10 col-md-3">
                    <div class="mb-2">
                        <input type="text" class="form-control" value="<?php echo $workmachine->notes; ?>"
                                name="workmachine[<?php echo $wm; ?>][machine_notes]">
                    </div>
                </div>
                <div class="col-sm-1 col-md-1">
                    <div class="mb-2">
                        <button type="button" class="btn btn-danger delete-old-btn"><i class="fa fa-trash"></i></button>
                    </div>
                </div>
            </div>
        <?php } ?>
        <div data-repeater-list="workmachine">
            <div data-repeater-item>
                <div class="row">
                    <div class="col-sm-4 col-md-3">
                        <div class="mb-2">
                            <select id="select2-demo-1" class="form-control"
                                    data-plugin="select2" name="workmachine">
                                <option selected="selected[]" value="">İş Makinesi Seçiniz</option>
                                <?php foreach ($active_machines as $active_machine => $workmachines) {
                                    foreach ($workmachines as $workmachine) { ?>
                                        <option value="<?php echo $workmachine; ?>"> <?php echo machine_name($workmachine); ?></option>
                                    <?php } ?>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-4 col-md-2">
                        <div class="mb-2">
                            <input type="number" min="1" step="any" class="form-control"
                                   name="machine_count" placeholder="Sayısı">
                        </div>
                    </div>
                    <div class="col-sm-4 col-md-3">
                        <div class="mb-2">
                            <input type="text" class="form-control"
                                   name="machine_place" placeholder="Mahal">
                        </div>
                    </div>
                    <div class="col-sm-10 col-md-3">
                        <div class="mb-2">
                            <input type="text" class="form-control"
                                   name="machine_notes" placeholder="Açıklama"">
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
