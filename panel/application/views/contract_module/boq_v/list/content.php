<div class="col-sm-12">
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="display" id="basic-1">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Sözleşme Adı</th>
                        <th>Dosya No</th>
                        <th>Karar Tarihi</th>
                        <th>YBF Tutarı</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($items as $item) { ?>

                        <tr>
                            <td>
                                <a href="<?php echo base_url("$this->Module_Name/file_form/$item->id"); ?>">
                                    <?php echo $item->id; ?>
                                </a>
                            </td>
                            <td>
                                <a href="<?php echo base_url("$this->Module_Name/file_form/$item->id"); ?>">
                                </a>
                            </td>
                            <td>
                                <a href="<?php echo base_url("$this->Module_Name/file_form/$item->id"); ?>">
                                    <?php echo $item->dosya_no; ?>
                                </a>
                            </td>
                            <td>
                                <a href="<?php echo base_url("$this->Module_Name/file_form/$item->id"); ?>">
                                </a>
                            </td>
                            <td>
                                <a href="<?php echo base_url("$this->Module_Name/file_form/$item->id"); ?>">
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








