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
                        <td><?php echo $site->santiye_ad; ?></td>
                        <?php $this->load->model("Report_model"); ?>
                        <?php $reports = $this->Report_model->get_all(array("site_id"=>$site->id)); ?>
                        <td><?php echo count($reports); ?></td>
                        <?php $this->load->model("Report_workgroup_model"); ?>
                        <?php $workgroup_count = $this->Report_workgroup_model->sum_all(array("site_id"=>$site->id),"number"); ?>
                        <td><?php echo $workgroup_count; ?></td>
                        <?php $this->load->model("Report_workmachine_model"); ?>
                        <?php $workmachine_count = $this->Report_workmachine_model->sum_all(array("site_id"=>$site->id),"number"); ?>
                        <td><?php echo $workmachine_count; ?></td>
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

