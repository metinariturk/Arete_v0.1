<div class="col-sm-12">
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="display" id="basic-1">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Rapor No</th>
                        <th>Şantiye Adı</th>
                        <th>Rapor Tarih</th>
                        <th>Oluşturan</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($items as $item) { ?>
                        <tr>
                            <td>
                                <a href="<?php echo base_url("report/file_form/$item->id"); ?>">
                                    <?php echo $item->id; ?>
                                </a>
                            </td>
                            <td>
                                <a href="<?php echo base_url("report/file_form/$item->id"); ?>">
                                    <?php echo $item->dosya_no; ?>
                                </a>
                            </td>
                            <td>
                                <a href="<?php echo base_url("report/file_form/$item->id"); ?>">
                                    <?php echo site_name($item->site_id); ?>
                                </a>
                            </td>
                            <td>
                                <a href="<?php echo base_url("report/file_form/$item->id"); ?>">
                                    <?php echo dateFormat_dmy($item->report_date); ?>
                                </a>
                            </td>
                            <td>
                                <a href="<?php echo base_url("report/file_form/$item->id"); ?>">
                                    <?php echo full_name($item->createdBy); ?>
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








