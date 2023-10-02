<button class="btn btn-pill btn-outline-success" onclick="CostToExcel('xlsx')"
        type="button"><i class="fa fa-share-square-o"></i> EXCEL
</button>

<div class="col-sm-12">
    <table class="table" id="cost_table">
        <thead>
        <tr>
            <th class="d-none d-sm-table-cell"><i class="fa fa-reorder"></i></th>
            <th class="d-none d-sm-table-cell">Grubu</th>
            <th>Adı</th>
            <th>Maliyet</th>
            <th>Dosyalar</th>
        </tr>
        </thead>
        <tbody>
        <?php if (!empty($ymler)) { ?>
            <?php foreach ($ymler as $ym) { ?>
                <tr id="center_row">
                    <td class="d-none d-sm-table-cell">
                        <?php echo $ym->id; ?>
                    </td>
                    <td class="d-none d-sm-table-cell">
                        <a href="<?php echo base_url("cost/file_form/$ym->id"); ?>">
                            <?php echo $ym->ym_grup; ?>
                        </a>
                    </td>
                    <td>
                        <a href="<?php echo base_url("cost/file_form/$ym->id"); ?>">
                            <?php echo $ym->ym_ad; ?>
                        </a>
                    </td>
                    <td>
                        <a href="<?php echo base_url("cost/file_form/$ym->id"); ?>">
                            <?php echo money_format($ym->cost) . " " . get_currency_auc($item->id); ?>
                        </a>
                    </td>
                    <td>
                        <div>
                            <?php if (!empty($ym->id)) {
                                $ym_files = get_module_files("cost_files", "cost_id", "$ym->id");
                                if (!empty($ym_files)) { ?>
                                    <a class="btn btn-pill btn-success btn-air-success" type="button" title=""
                                       href="<?php echo base_url("cost/download_all/$ym->id"); ?>"
                                       data-bs-original-title="<?php foreach ($ym_files as $ym_file) { ?>
                                            <?php echo filenamedisplay($ym_file->img_url); ?> |
                                            <?php } ?>"
                                       data-original-title="btn btn-pill btn-info btn-air-info ">
                                        <i class="fa fa-download" aria-hidden="true"></i> Dosya
                                        (<?php echo count($ym_files); ?>)
                                    </a>
                                <?php } ?>
                            <?php } else { ?>
                                <div class="div-table">
                                    <div class="div-table-row">
                                        <div class="div-table-col">
                                            Dosya Yok, Eklemek İçin Görüntüle Butonundan Şartname Sayfasına
                                            Gidiniz
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </td>
                </tr>
            <?php } ?>
        <?php } ?>
        </tbody>
        <tfoot>
        <tr>
            <td class="d-none d-sm-table-cell"></td>
            <td class="d-none d-sm-table-cell"></td>
            <td>
                TOPLAM
            </td>
            <td>
                <?php echo money_format(sum_anything("cost", "cost", "auction_id", $item->id)); ?>
                <?php echo "$item->para_birimi"; ?>
            </td>
            <td>
                <a class="btn btn-pill btn-success btn-air-success" type="button" title=""
                   href="<?php echo base_url("auction/download_module/$item->id/Cost"); ?>"
                   data-bs-original-title=""
                   data-original-title="btn btn-pill btn-info btn-air-info ">
                    <i class="fa fa-download" aria-hidden="true"></i> Tümünü İndir
                </a>
            </td>
        </tr>
        </tfoot>
    </table>
</div>

<div class="row">
    <div class="col-sm-6">
        <?php if (!empty($ymler)) { ?>
            <table class="table">
                <tbody>
                <?php if (!empty($ymler)) { ?>
                    <?php $groups = array_unique(array_column($ymler, 'ym_grup')); ?>
                    <tr>
                        <th>
                            <h4>
                                TOPLAM
                            </h4>
                        </th>
                        <th>
                            <h4>
                                <?php echo money_format(sum_anything("cost", "cost", "auction_id", $item->id)); ?>
                                <?php echo "$item->para_birimi"; ?>
                            </h4>
                        </th>
                    </tr>
                    <?php foreach ($groups as $group) { ?>
                        <tr>
                            <th><?php echo $group; ?></th>
                            <th><?php echo money_format(sum_anything_and("cost", "cost", "ym_grup", "$group", "auction_id", "$item->id")); ?>
                                <?php echo "$item->para_birimi"; ?>
                            </th>
                        </tr>
                        <?php foreach ($ymler as $ym) { ?>
                            <?php if ($group == $ym->ym_grup) { ?>
                                <tr>
                                    <td><?php echo $ym->ym_ad; ?></td>
                                    <td><?php echo money_format(ceil($ym->cost)); ?>
                                        <?php echo "$item->para_birimi"; ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        <?php } ?>
                    <?php } ?>
                <?php } ?>
                </tbody>
            </table>
        <?php } ?>
    </div>
    <div class="col-sm-6">
        <?php $this->load->view("{$viewModule}/{$viewFolder}/common/limit_cost"); ?>
    </div>
</div>

