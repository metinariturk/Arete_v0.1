<?php
if (empty($contract_id)) { ?>
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4>Sözleşme Seçimi Yapmadan Bu İşleme Devam Edemezsiniz</h4>
                </div>
            </div>
            <div class="card">
                <form id="contract_id"
                      action="<?php echo base_url("$this->Module_Name/new_form/"); ?>"
                      method="post"
                      enctype="multipart">
                    <div class="card-body">
                        <div class="mb-2 col-sm-6">
                            <label class="col-form-label" for="recipient-name">Sözleşme Seçiniz</label>
                            <select class="form-control" name="contract_id">
                                <?php foreach ($active_contracts as $active_contract) { ?>
                                    <option value="<?php echo "$active_contract->id"; ?>">
                                        <?php echo "$active_contract->sozlesme_ad"; ?>
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
        <div class="col-sm-12 col-md-5">
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
                                <div class="btn btn-light ">
                                    <a href="<?php echo base_url("contract/file_form/$contract_id"); ?>">
                                    <span style="padding-left: 20px">
                                    <i class="icofont icofont-law-document"></i>
                                    <?php echo contract_code_name($contract_id); ?>
                                    </span>
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
            <div class="card">
                <div class="cord-body">
                </div>
            </div>
        </div>
        <?php if ($error_isset) { ?>
            <div class="col-sm-12 col-md-7">
                <form id="save_<?php echo $this->Module_Name; ?>"
                      action="<?php echo base_url("$this->Module_Name/save/$contract_id"); ?>" method="post"
                      enctype="multipart/form-data" autocomplete="off">
                    <div class="row">
                        <div class="card">
                            <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/input_form"); ?>
                            <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/input_form2"); ?>
                        </div>
                        <div class="card">
                            <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/input_form3"); ?>
                        </div>
                    </div>
                </form>
            </div>
        <?php } else { ?>
            <div class="col-sm-12 col-md-7">
                <div class="row">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="text-center">Bu Hakedişi Yapabilmek İçin Aşağıdaki Eksiklerin Tamamlanması
                                Gerekmektedir.</h3>
                        </div>
                        <div class="card-body">
                            <?php foreach ($error_array as $error) { ?>
                            <div class="row">
                                <?php if (!empty($error)) { ?>
                                <?php $error_splice = explode("*", "$error"); ?>
                                <div class="col-9">
                                    <div class="alert alert-info outline-2x" role="alert">
                                        <?php echo $error_splice[0]; ?>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <a class="btn btn-primary" target="_blank" href="<?php echo $error_splice[1]; ?>">
                                        <i class="fa fa-times"></i> İşlem Yap
                                    </a>
                                </div>
                            </div>
                        <?php } ?>
                        <?php } ?>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
<?php } ?>





