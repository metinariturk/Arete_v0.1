<button class="btn btn-pill btn-outline-success" onclick="costincToExcel('xlsx')"
        type="button"><i class="fa fa-share-square-o"></i> EXCEL
</button>

<table class="table" id="costinc_table">
    <thead>
    <tr>
        <th class="d-none d-sm-table-cell"><i class="fa fa-reorder"></i></th>
        <th class="d-none d-sm-table-cell">Dosya No</th>
        <th class="d-none d-sm-table-cell">Keşif Artış Tarihi</th>
        <th>Keşif Artış Tutar - Oran</th>
        <th class="d-none d-sm-table-cell">Keşif Artış Gerekçe</th>
        <th>Evraklar</th>
    </tr>
    </thead>
    <tbody>
    <?php if (!empty($costincs)) { ?>
        <?php foreach ($costincs as $costinc) { ?>
            <tr id="center_row">
                <td class="d-none d-sm-table-cell">
                    <?php echo $costinc->id; ?>
                </td>
                <td class="d-none d-sm-table-cell">
                    <a  href="<?php echo base_url("costinc/file_form/$costinc->id"); ?>">
                        <?php echo $costinc->dosya_no; ?>
                    </a>
                </td>
                <td class="d-none d-sm-table-cell">
                    <a  href="<?php echo base_url("costinc/file_form/$costinc->id"); ?>">
                        <?php echo dateFormat_dmy($costinc->artis_tarih); ?>
                    </a>
                </td>
                <td>
                    <a  href="<?php echo base_url("costinc/file_form/$costinc->id"); ?>">
                        <?php echo $costinc->artis_miktar; ?> <?php echo "$item->para_birimi"; ?> - % <?php echo $costinc->artis_oran; ?>
                    </a>
                </td>
                <td class="d-none d-sm-table-cell">
                    <a  href="<?php echo base_url("costinc/file_form/$costinc->id"); ?>">
                        <?php cms_isset($costinc->newprice_id,"YBF Keşif Artışı","Sözleşme Miktar Artışı"); ?>
                    </a>
                </td>
                <td>
                    <div>
                        <?php if (!empty($costinc->id)) {
                            $costinc_files = get_module_files("costinc_files", "costinc_id", "$costinc->id");
                            if (!empty($costinc_files)) { ?>
                                <a class="btn btn-pill btn-success btn-air-success" type="button" title=""
                                   href="<?php echo base_url("costinc/download_all/$costinc->id"); ?>"
                                   data-bs-original-title="<?php foreach ($costinc_files as $costinc_file) { ?>
                                            <?php echo filenamedisplay($costinc_file->img_url); ?> |
                                            <?php } ?>"
                                   data-original-title="btn btn-pill btn-info btn-air-info btn-lg">
                                    <i class="fa fa-download" aria-hidden="true"></i>
                                    (<?php echo count($costinc_files); ?>)
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
            <?php echo money_format(sum_anything("costinc", "artis_miktar", "contract_id", $item->id)); ?>
            <?php echo "$item->para_birimi"; ?> <br> % <?php echo money_format(sum_anything("costinc", "artis_oran", "contract_id", $item->id)); ?>
        </td>
        <td  class="d-none d-sm-table-cell">

        </td>
    </tr>
    </tfoot>
</table>

 