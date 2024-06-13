<div class="row content-container">
    <div class="table-responsive">
        <table class="display" id="basic-2">
            <thead>
            <tr>
                <th>#</th>
                <th>Şantiye Adı</th>
                <th>Rapor Sayısı</th>
                <th>Puantaj Toplamı</th>
                <th>İş Makinesi Toplamı</th>
            </thead>
            </tr>
            <tbody>
            <?php foreach ($sites as $site) { ?>
                <tr>
                    <td>#</td>
                    <td>
                        <a href="<?php echo base_url("site/file_form/$site->id"); ?>">
                            <?php echo $site->santiye_ad; ?>
                        </a>
                    </td>

                    <?php $reports = $this->Report_model->get_all(array("site_id" => $site->id)); ?>
                    <td>
                        <a href="<?php echo base_url("site/file_form/$site->id"); ?>">
                            <?php echo count($reports); ?>
                        </a>
                    </td>
                    <?php $this->load->model("Report_workgroup_model"); ?>
                    <?php $workgroup_count = $this->Report_workgroup_model->sum_all(array("site_id" => $site->id), "number"); ?>
                    <td>
                        <a href="<?php echo base_url("site/file_form/$site->id"); ?>">
                            <?php echo $workgroup_count; ?>
                        </a>
                    </td>
                    <?php $this->load->model("Report_workmachine_model"); ?>
                    <?php $workmachine_count = $this->Report_workmachine_model->sum_all(array("site_id" => $site->id), "number"); ?>
                    <td>
                        <a href="<?php echo base_url("site/file_form/$site->id"); ?>">
                            <?php echo $workmachine_count; ?>
                        </a>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
            <tfoot>
            <tr>
                <td></td>
                <td></td>
                <td>TOPLAM</td>
            </tr>
            </tfoot>
        </table>
    </div>
</div>

