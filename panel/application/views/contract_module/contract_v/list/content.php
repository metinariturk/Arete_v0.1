<div class="col-sm-12">
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="contract_list">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Proje Kodu</th>
                        <th>Proje Adı</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $i = 1; ?>
                    <?php foreach ($items as $item) { ?>
                        <tr>
                            <td>
                                <?php echo $i++; ?>
                            </td>
                            <td>
                                <a href="<?php echo base_url("contract/file_form/$item->id"); ?>">
                                    <?php echo $item->dosya_no; ?>
                                </a>
                            </td>
                            <td>
                                <a href="<?php echo base_url("contract/file_form/$item->id"); ?>">
                                    <?php echo $item->contract_name; ?>
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
