<div class="col-sm-12">
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="display" id="basic-1">
                    <thead>
                    <tr>
                        <th>Sözleşme Adı</th>
                        <th>Şantiye Adı</th>
                        <th>Şantiye Sorumlusu</th>
                        <th>Günlük Rapor Sayısı</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($items as $item) { ?>
                        <tr>
                            <td>
                                <a href="<?php echo base_url("site/file_form/$item->id"); ?>">
                                    <?php echo contract_name($item->contract_id); ?>
                                </a>
                            </td>
                            <td>
                                <a href="<?php echo base_url("site/file_form/$item->id"); ?>">
                                    <?php echo $item->santiye_ad; ?>
                                </a>
                            </td>
                            <td>
                                <a href="<?php echo base_url("site/file_form/$item->id"); ?>">
                                    <?php echo full_name($item->santiye_sefi); ?>
                                </a>
                            </td>
                            <?php $reports = $this->Report_model->get_all(array("site_id" => $item->id)); ?>
                            <td>
                                <a href="<?php echo base_url("site/file_form/$item->id"); ?>">
                                    <?php echo count($reports); ?>
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>















