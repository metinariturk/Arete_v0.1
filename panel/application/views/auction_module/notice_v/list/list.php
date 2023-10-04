<div class="widget p-lg">
    <?php if (empty($items)) { ?>
        <div class="alert alert-info text-center">
            <p>Burada herhangi bir veri bulunmamaktadır. Eklemek için lütfen
                <a href="<?php echo base_url("cost/select"); ?>"> Buradan Yeni Teknik Yaklaşık Maliyet Ekleyiniz</a>
            </p>
        </div>
    <?php } else { ?>
    <div class="table-responsive">
        <table id="default-datatable" data-plugin="DataTable" class="table table-striped">
            <thead>
            <tr>
                <th>#</th>
                <th>Teklif Adı</th>
                <th>Teknik Yaklaşık Maliyet Grubu</th>
                <th>Yaklaşık Maliyet Ad</th>
                <th>İşlem</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($items as $item) { ?>
                <tr>
                    <td class="w5c"><?php echo $item->id; ?></td>
                    <td class="w30">
                        <h5>
                            <a href="<?php echo base_url("$this->Module_Depended_Dir/file_form/$item->auction_id"); ?>"
                            <span><?php echo get_from_id("auction","ihale_ad",$item->auction_id); ?></span>
                            </a>
                        </h5>
                    </td>
                    <td class="w10"><?php echo $item->ym_grup; ?></td>
                    <td class="w10"><?php echo $item->ym_ad; ?></td>
                    <td class="w10">
                        <a class="btn btn-info pager-btn" href="<?php echo base_url("cost/file_form/$item->id"); ?>"
                        <span class="m-r-xs"><i class="fas fa-ellipsis-h"></i></span>
                        <span>Görüntüle</span>
                        </a>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
        <?php } ?>
    </div>
</div>

