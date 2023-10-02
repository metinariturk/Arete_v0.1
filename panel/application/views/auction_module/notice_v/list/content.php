<div class="col-sm-12">
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="display" id="basic-1">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>İhale Adı</th>
                        <th>İhale Yayınlama Tarihi</th>
                        <th>İhale Yayından Kalış Tarihi</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($items as $item) { ?>
                        <tr>
                            <td><?php echo $item->id; ?></td>
                            <td>
                                <a href="<?php echo base_url("$this->Module_Name/file_form/$item->id"); ?>">
                                    <?php echo get_from_id("auction", "ihale_ad", $item->auction_id); ?>
                                </a>
                            </td>
                            <td>
                                <a href="<?php echo base_url("$this->Module_Name/file_form/$item->id"); ?>">
                                    <?php echo $item->ilan_tarih; ?>
                                </a>
                            </td>
                            <td>
                                <a href="<?php echo base_url("$this->Module_Name/file_form/$item->id"); ?>">
                                    <?php echo $item->son_tarih; ?>
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




