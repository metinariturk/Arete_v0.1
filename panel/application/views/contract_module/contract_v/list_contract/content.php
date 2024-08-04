<div class="col-sm-12">
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table  id="contract_list">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Sözleşme Kodu</th>
                        <th>Sözleşme Adı</th>
                        <th>İşveren</th>
                        <th>İmza Tarihi</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $j = 1; ?>
                    <?php foreach ($items as $item) { ?>
                        <tr>
                            <td>
                                <?php echo $j++; ?>
                            </td>
                            <td>
                                <a href="<?php echo base_url("contract/file_form/$item->id"); ?>">
                                    <?php echo contract_code($item->id); ?>
                                </a>
                            </td>
                            <td>
                                <a href="<?php echo base_url("contract/file_form/$item->id"); ?>">
                                    <?php echo $item->sozlesme_ad; ?>
                                </a>
                            </td>
                            <td>
                                <a href="<?php echo base_url("contract/file_form/$item->id"); ?>">
                                    <?php echo company_name($item->isveren); ?>
                                </a>
                            </td>
                            <td>
                                <a href="<?php echo base_url("contract/file_form/$item->id"); ?>">
                                    <?php echo dateFormat_dmy($item->sozlesme_tarih); ?>
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








