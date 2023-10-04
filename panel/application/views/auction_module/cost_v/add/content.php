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
    <div class="row">
        <div class="col-sm-12 col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="file-sidebar">
                        <ul>
                            <li>
                                <div class="btn btn-light">
                                    <a href="<?php echo base_url("project/file_form/$project_id"); ?>">
                                        <i data-feather="home"></i>
                                        <?php echo project_code_name($project_id); ?>
                                    </a>
                                </div>
                            </li>
                            <li>
                                <div class="btn btn-light">
                                    <span style="padding-left: 40px">
                                        <i class="icon-gallery"></i>
                                        Yeni / <?php echo module_name($this->Module_Name); ?>
                                    </span>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-8">
            <div class="card">
                <form id="save_<?php echo $this->Module_Name; ?>"
                      action="<?php echo base_url("$this->Module_Name/save/$auc_id"); ?>" method="post"
                      enctype="multipart/form-data" autocomplete="off">
                    <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/input_form"); ?>
                </form>
            </div>
        </div>
    </div>
<?php } ?>














