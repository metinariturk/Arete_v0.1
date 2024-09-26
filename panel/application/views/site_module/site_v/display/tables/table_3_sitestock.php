<div class="table-responsive"> <!-- Kaydırılabilir div -->
    <table class="table table-bordered table-striped" id="stock-table">
        <thead>
        <tr>
            <th colspan="2">İşlem</th>
            <th>Stok Adı</th>
            <th>Birim</th>
            <th>Miktarı</th>
            <th>Kalan</th>
            <th>Tarihi</th>
            <th>Açıklama</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($site_stocks as $site_stock) { ?>
                <?php $kalan = $site_stock->stock_in - sum_anything("sitestock", "stock_out", "parent_id", "$site_stock->id"); ?>
            <tr>
                <td>
                    <?php if ($kalan>0) { ?>
                    <a data-bs-toggle="modal" class="text-primary"
                       data-bs-target="#ExitModal"
                       data-id="<?php echo $site_stock->id; ?>">
                        <i class="fa fa-sign-out fa-2x"></i>
                    </a>
                    <?php } else { ?>
                        <i class="fa fa-sign-out fa-2x"
                           onclick="empty_stock()"></i>
                    <?php } ?>
                </td>
                <td>
                    <?php $is_parent = $this->Sitestock_model->get(array("parent_id" => $site_stock->id)); ?>
                    <?php if (empty($is_parent)) { ?>
                        <a href="javascript:void(0);"
                           onclick="confirmDelete(<?php echo $site_stock->id; ?>, '<?php echo base_url('Site/delete_stock'); ?>')">
                            <i class="fa fa-trash-o fa-2x"></i>
                        </a>
                    <?php } else { ?>
                        <i class="fa fa-trash-o fa-2x"
                           onclick="delete_stock_enter()"></i>
                    <?php } ?>
                </td>
                <td><?php echo $site_stock->stock_name; ?></td>
                <td><?php echo $site_stock->unit; ?></td>
                <td><?php echo $site_stock->stock_in; ?></td>
                <td><?php echo number_format($kalan); ?></td>
                <td><?php echo $site_stock->arrival_date; ?></td>
                <td>
                    <?php if (!empty($site_stock->site_from)) { ?>
                        <?php echo site_name($site_stock->site_from); ?> Şantiyesinden Transfer
                    <?php } ?>
                    <?php echo $site_stock->notes; ?>
                </td>
            </tr>
            <?php $stock_movements = $this->Sitestock_model->get_all(array("site_id" => $item->id, "parent_id" => $site_stock->id)); ?>
            <?php foreach ($stock_movements as $stock_movement) { ?>
                <tr>
                    <td colspan="3"><?php echo $stock_movement->notes; ?></td>
                    <td>- <?php echo $stock_movement->stock_out; ?></td>
                    <td></td>
                    <td><?php echo dateFormat_dmy($stock_movement->exit_date); ?></td>
                    <td>
                        <a
                                href="javascript:void(0);"
                                onclick="confirmDelete(<?php echo $stock_movement->id; ?>, '<?php echo base_url('Site/delete_stock'); ?>')"
                                title="Sil">
                            <i class="fa fa-trash-o fa-2x"></i>
                        </a>
                    </td>
                </tr>
            <?php } ?>
        <?php } ?>
        </tbody>
    </table>
</div>

<style>
    .table-responsive {
        overflow-x: auto; /* Mobil görünüm için kaydırma */
    }
</style>
