<div class="col-sm-12">
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="display" id="basic-1">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Şirket Adı</th>
                        <th>Faaliyet Konusu</th>
                        <th>İletişim</th>
                        <th>Rolü</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($companys as $item) { ?>
                        <tr>
                            <td>
                                <a href="<?php echo base_url("company/file_form/$item->id"); ?>">
                                    <?php echo $item->id; ?>
                                </a>
                            </td>
                            <td>
                                <a href="<?php echo base_url("company/file_form/$item->id"); ?>">
                                    <?php echo $item->company_name; ?>
                                </a>
                            </td>
                            <td>
                                <a href="<?php echo base_url("company/file_form/$item->id"); ?>">
                                    <?php echo $item->profession; ?>
                                </a>
                            </td>
                            <td>
                                <a href="<?php echo base_url("company/file_form/$item->id"); ?>">
                                    <?php echo $item->email; ?>
                                </a>
                            </td>
                            <td>
                                <a href="<?php echo base_url("company/file_form/$item->id"); ?>">
                                    <?php echo $item->company_role; ?>
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