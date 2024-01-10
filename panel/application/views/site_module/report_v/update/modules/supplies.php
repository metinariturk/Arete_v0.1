<div class="row box-col-3">
    <div class="repeater">
        <div class="container">
            <div class="row">
                <div class="col-11">
                    <h5>Gelen Malzemeler
                        <button data-repeater-create type="button" class="btn btn-success add_btn">
                            <i class="fa fa-plus"></i>
                        </button>
                    </h5>
                </div>
                <div class="col-1">

                </div>
            </div>
        </div>
        <?php $s = 99; ?>
        <?php foreach ($supplies as $supply) { ?>
            <?php $s -= 1;
            $p = $s; ?>
            <div class="row">
                <div class="col-sm-4 col-md-3">
                    <div class="mb-2">
                        <input type="text" class="form-control" name="supplies[<?php echo $p; ?>][supply]" value="<?php echo $supply->supply; ?>"
                               placeholder="Malzeme Adı">
                    </div>
                </div>
                <div class="col-sm-4 col-md-2">
                    <div class="mb-2">
                        <input type="number" min="1" step="any" class="form-control"  value="<?php echo $supply->qty; ?>"
                               name="supplies[<?php echo $p; ?>][qty]" placeholder="Miktar">
                    </div>
                </div>
                <div class="col-sm-2 col-md-2">
                    <div class="mb-2">
                        <div class="mb-2">
                            <input type="text" step="any" class="form-control" value="<?php echo $supply->unit; ?>"
                                   name="unit" placeholder="Miktar">
                        </div>
                    </div>
                </div>
                <div class="col-sm-10 col-md-4">
                    <div class="mb-2">
                        <input type="text" class="form-control" value="<?php echo $supply->notes; ?>"
                               name="supplies[<?php echo $p; ?>][supply_notes]" placeholder="Açıklama"">
                    </div>
                </div>
                <div class="col-sm-1 col-md-1">
                    <div class="mb-2">
                        <button type="button" class="btn btn-danger delete-old-btn"><i class="fa fa-trash"></i></button>
                    </div>
                </div>
            </div>
        <?php } ?>
        <div data-repeater-list="supplies">
            <div data-repeater-item>
                <div class="row">
                    <div class="col-sm-4 col-md-3">
                        <div class="mb-2">
                            <input type="text" class="form-control"
                                   name="supply" placeholder="Malzeme Adı">
                        </div>
                    </div>
                    <div class="col-sm-4 col-md-2">
                        <div class="mb-2">
                            <input type="number" min="1" step="any" class="form-control"
                                   name="qty" placeholder="Miktar">
                        </div>
                    </div>
                    <div class="col-sm-2 col-md-2">
                        <div class="mb-2">
                            <div class="mb-2">
                                <input type="text" step="any" class="form-control"
                                       name="unit" placeholder="Birim">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-10 col-md-4">
                        <div class="mb-2">
                            <input type="text" class="form-control"
                                   name="supply_notes" placeholder="Açıklama"">
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
