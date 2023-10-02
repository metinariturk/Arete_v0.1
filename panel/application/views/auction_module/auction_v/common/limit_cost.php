<div class="limit-listener">
    <div class="row">
        <div class="col-sm-6">
            <div class="row">
                <div class="col-12">
                    <div class="col-form-label">Aşırı Düşük
                        <?php if ($item->min_cost) { ?>
                            <a class="unstyled-button"
                               style="border: none; padding: 0; background: none;"
                               onclick="enable_min()">
                                <i class="fa fa-edit fa-2x"></i>
                            </a>
                        <?php } ?>
                    </div>
                    <input class="form-control digits"
                           type="number" step="any" autocomplete="off"
                           name="min_cost"
                           id="min_cost"
                        <?php if ($item->min_cost) { ?>
                            value="<?php echo $item->min_cost; ?>"
                            disabled
                        <?php } ?>>
                    <div class="row">
                        <div class="col-2">
                            <input type="submit" id="save_button" value="Kaydet" onclick="save_min(this)"
                                   url = <?php echo base_url("$this->Module_Name/limit_cost/min/$item->id"); ?>
                                   class="btn btn-success" <?php if ($item->min_cost) { ?>
                                style="display: none;"<?php } ?>>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="row">
                <div class="col-12">
                    <div class="col-form-label">Aşırı Yüksek
                        <?php if ($item->max_cost) { ?>
                            <a class="unstyled-button"
                               style="border: none; padding: 0; background: none;"
                               onclick="enable_max()">
                                <i class="fa fa-edit fa-2x"></i>
                            </a>
                        <?php } ?>
                    </div>
                    <input class="form-control digits"
                           type="number" step="any" autocomplete="off"
                           name="max_cost"
                           id="max_cost"
                        <?php if ($item->max_cost) { ?>
                            value="<?php echo $item->max_cost; ?>"
                            disabled
                        <?php } ?>>
                    <div class="row">
                        <div class="col-2">
                            <input type="submit" id="save_max_button" value="Kaydet" onclick="save_max(this)"
                                   url = <?php echo base_url("$this->Module_Name/limit_cost/max/$item->id"); ?>
                                   class="btn btn-success" <?php if ($item->max_cost) { ?>
                                style="display: none;"<?php } ?>>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>