<div class="col-sm-12">
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="display" id="basic-1">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Şantiye/İş Yeri</th>
                        <th>Oluşturan</th>
                        <th>Teslim Günü</th>
                        <th>Malzeme Adı</th>
                        <th>İrsaliye/Fatura No</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($items as $item) { ?>
                        <tr>
                            <td>
                                <a href="<?php echo base_url("sitestock/file_form/$item->id"); ?>">
                                    <?php echo $item->id; ?>
                                </a>
                            </td>
                            <td>
                                <a href="<?php echo base_url("sitestock/file_form/$item->id"); ?>">
                                    <?php echo site_name($item->site_id); ?>
                                </a>
                            </td>
                            <td>
                                <a href="<?php echo base_url("sitestock/file_form/$item->id"); ?>">
                                    <?php echo full_name($item->createdBy); ?>
                                </a>
                            </td>
                            <td>
                                <a href="<?php echo base_url("sitestock/file_form/$item->id"); ?>">
                                    <?php echo dateFormat_dmy($item->arrival_date); ?>
                                </a>
                            </td>
                            <td>
                                <a href="<?php echo base_url("sitestock/file_form/$item->id"); ?>">
                                    <?php $supplies = json_decode($item->supplies, true); ?>
                                    <?php foreach ($supplies as $supply) { ?>
                                        <?php echo $supply['product_name']." - ".$supply['product_qty']." ".$supply['unit']; ?>
                                        <br>
                                    <?php } ?>
                                </a>
                            </td>
                            <td>
                                <a href="<?php echo base_url("sitestock/file_form/$item->id"); ?>">
                                    <?php $supplies = json_decode($item->supplies, true); ?>
                                    <?php foreach ($supplies as $supply) { ?>
                                        <?php echo $supply['bill_code']; ?>
                                        <br>
                                    <?php } ?>
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

