<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-xl-8 col-md-10">
            <div class="card shadow-lg">
                <div class="card-header bg-danger text-white text-center">
                    <h4><i class="fa fa-exclamation-triangle"></i> Dikkat! Silme İşlemi</h4>
                </div>
                <div class="card-body">
                    <p class="text-danger fw-bold">
                        Aşağıdaki tüm veriler ve sözleşmeye ait dosyanın tamamı <u>kalıcı olarak</u> silinecektir!
                    </p>
                    <p>
                        <i class="fa fa-download text-primary"></i> Dosyanın yedeğini almak için
                        <a href="<?php echo base_url("project/download_backup/$item->id"); ?>" class="fw-bold">buraya tıklayın</a>.
                    </p>
                    <hr>

                    <!-- Alt Sözleşmeler -->
                    <h5><i class="fa fa-file-contract text-secondary"></i> Bağlı Alt Sözleşmeler (<?php echo count($main_contracts); ?>)</h5>
                    <?php if (empty($main_contracts)) { ?>
                        <div class="alert alert-success">
                            <i class="fa fa-check-circle"></i> Bağlı alt sözleşme yok.
                        </div>
                    <?php } else { ?>
                        <ul class="list-group mb-3">
                            <?php foreach ($main_contracts as $main_contract) { ?>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span><?php echo $main_contract->dosya_no; ?> - <?php echo $main_contract->contract_name; ?></span>
                                    <a href="<?php echo base_url("contract/file_form/$main_contract->id"); ?>" target="_blank" class="btn btn-sm btn-outline-success">
                                        <i class="fa fa-arrow-circle-right"></i> Görüntüle
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                    <?php } ?>

                    <!-- Bağlı Şantiyeler -->
                    <h5><i class="fa fa-hard-hat text-secondary"></i> Bağlı Şantiyeler (<?php echo count($sites); ?>)</h5>
                    <?php if (empty($sites)) { ?>
                        <div class="alert alert-success">
                            <i class="fa fa-check-circle"></i> Bağlı şantiye yok.
                        </div>
                    <?php } else { ?>
                        <ul class="list-group">
                            <?php foreach ($sites as $site) { ?>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span><?php echo $site->dosya_no . " Şantiye"; ?> - <?php echo $site->santiye_ad; ?></span>
                                    <a href="<?php echo base_url("site/file_form/$site->id"); ?>" target="_blank" class="btn btn-sm btn-outline-success">
                                        <i class="fa fa-arrow-circle-right"></i> Görüntüle
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                    <?php } ?>

                    <hr>
                    <!-- Silme Butonu -->
                    <div class="text-center">
                        <p class="text-danger fw-bold">Bu işlem geri alınamaz. Lütfen dikkatli olun!</p>
                        <a href="<?php echo base_url("project/hard_delete/$item->id"); ?>" class="btn btn-lg btn-danger">
                            <i class="fa fa-trash-alt"></i> Projeyi Kalıcı Olarak Sil
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
