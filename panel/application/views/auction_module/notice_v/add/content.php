<?php
if (empty($auc_id)) { ?>
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4>Teklif Seçimi Yapmadan Bu İşleme Devam Edemezsiniz</h4>
                </div>
            </div>
            <div class="card">
                <form id="auction_id"
                      action="<?php echo base_url("$this->Module_Name/new_form/"); ?>"
                      method="post"
                      enctype="multipart">
                    <div class="card-body">
                        <div class="mb-2 col-sm-6">
                            <label class="col-form-label" for="recipient-name">Teklif Seçiniz</label>
                            <select class="form-control" name="auction_id">
                                <?php foreach ($prep_auctions as $prep_auction) { ?>
                                    <option value="<?php echo "$prep_auction->id"; ?>">
                                        <?php echo "$prep_auction->ihale_ad"; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php } else { ?>
    <form id="save_<?php echo $this->Module_Name; ?>"
          action="<?php echo base_url("$this->Module_Name/save/$auc_id"); ?>" method="post"
          enctype="multipart/form-data" autocomplete="off">
        <div class="row">
            <div class="col-xl-6 col-md-6 box-col-6">
                <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/input_form"); ?>
            </div>
            <?php if (!empty($notice_id)) { ?>
                <div class="col-xl-6 col-md-6 box-col-6">
                    <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/addenum_info"); ?>
                </div>
            <?php } ?>
        </div>
        <div class="row">
            <?php $this->load->view("{$viewModule}/{$viewFolder}/common/error_form"); ?>
        </div>
    </form>
<?php } ?>






