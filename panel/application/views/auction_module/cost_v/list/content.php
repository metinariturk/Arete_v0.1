<div class="col-sm-12">
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="display" id="basic-1">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Teklif Adı</th>
                        <th>Yaklaşık Maliyet Grubu</th>
                        <th>Yaklaşık Maliyet Ad</th>
                        <th>Yaklaşık Maliyet Tutar</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($items as $item) { ?>
                        <tr>
                            <td class="w5c"><?php echo $item->id; ?></td>
                            <td class="w30">
                                <a href="<?php echo base_url("$this->Module_Name/file_form/$item->id"); ?>">
                                    <?php echo get_from_id("auction", "ihale_ad", $item->auction_id); ?>
                                </a>
                            </td>
                            <td class="w10">
                                <a href="<?php echo base_url("$this->Module_Name/file_form/$item->id"); ?>">
                                    <?php echo $item->ym_grup; ?>
                                </a>
                            </td>
                            <td class="w10">
                                <a href="<?php echo base_url("$this->Module_Name/file_form/$item->id"); ?>">
                                    <?php echo $item->ym_ad; ?>
                                </a>
                            </td>
                            <td class="w10">
                                <a href="<?php echo base_url("$this->Module_Name/file_form/$item->id"); ?>">
                                    <?php echo money_format($item->cost); ?>
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




