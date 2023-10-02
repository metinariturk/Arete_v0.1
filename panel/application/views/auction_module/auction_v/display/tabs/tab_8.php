<div class="fade tab-pane <?php if ($active_tab == "bidder"){echo "active show"; } ?>"
     id="istekliler" role="tabpanel"
     aria-labelledby="istekliler-tab">
    <div class="card mb-0">
        <div class="card-header d-flex">
            <h6 class="mb-0">Teklif Veren İstekliler</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-12">
                    <select class="form-control" data-plugin="select2" id="bidder">
                        <option value="">İstekli Ekleyiniz</option>
                        <?php foreach ($yukleniciler as $yuklenici) { ?>
                            <option
                                    value="<?php echo base_url("$this->Module_Name/add_bidder/$item->id/$yuklenici->id"); ?>"
                            >
                                <?php echo $yuklenici->company_name; ?>

                            </option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/modules/bidders"); ?>
        </div>
    </div>
</div>

