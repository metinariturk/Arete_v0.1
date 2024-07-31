<div class="col-sm-12">
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="display" id="basic-1">
                    <thead>
                    <tr>
                        <th>Sözleşme Kodu</th>
                        <th>Sözleşme Adı</th>
                        <th>İşveren</th>
                        <th>Sözleşme Tutar</th>
                        <th>İmza Tarihi</th>
                        <th>Bitiş Tarihi Tarihi</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($items as $item) { ?>
                        <tr>
                            <td>
                                <a href="<?php echo base_url("contract/file_form/$item->id"); ?>">
                                    <?php echo project_name($item->proje_id); ?>
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
                                    <?php echo money_format($item->sozlesme_bedel) . " " . $item->para_birimi; ?>
                                </a>
                            </td>
                            <td>
                                <a href="<?php echo base_url("contract/file_form/$item->id"); ?>">
                                    <?php echo dateFormat_dmy($item->sozlesme_tarih); ?>
                                </a>
                            </td>
                            <td>
                                <a href="<?php echo base_url("contract/file_form/$item->id"); ?>">
                                    <?php echo $item->sozlesme_bitis == null ? null : dateFormat($format = 'd-m-Y', $item->sozlesme_bitis); ?>
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








