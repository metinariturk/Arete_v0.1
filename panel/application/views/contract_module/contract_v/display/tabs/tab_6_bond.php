<table class="table-lg" id="bond_table">
    <thead>
    <tr>
        <th class="d-none d-sm-table-cell"><i class="fa fa-reorder"></i></th>
        <th class="d-none d-sm-table-cell"><p>Dosya No</p></th>
        <th><p>Başlangıç - Bitiş Tarihi</p></th>
        <th class="d-none d-sm-table-cell"><p>Gerekçe</p></th>
        <th><p>Teminat Tutar</p></th>
    </tr>
    </thead>
    <tbody>
    <?php if (!empty($bonds)) { ?>
        <?php foreach ($bonds as $bond) { ?>
            <tr id="center_row">
                <td class="d-none d-sm-table-cell">
                    <p><?php echo $bond->id; ?></p>
                </td>
                <td class="d-none d-sm-table-cell">
                    <a href="<?php echo base_url("bond/file_form/$bond->id"); ?>">
                        <p><?php echo $bond->dosya_no; ?></p>
                    </a>
                </td>
                <td>
                    <a href="<?php echo base_url("bond/file_form/$bond->id"); ?>">
                        <p><?php echo dateFormat_dmy($bond->teslim_tarihi); ?></p>
                    </a> /
                    <?php if (!empty($bond->gecerlilik_tarihi)) { ?>
                        <a href="<?php echo base_url("bond/file_form/$bond->id"); ?>">
                            <p><?php echo dateFormat_dmy($bond->gecerlilik_tarihi); ?></p>
                        </a>
                    <?php } else { ?>
                        <a href="<?php echo base_url("bond/file_form/$bond->id"); ?>">
                            <p>Süresiz Teminat</p>
                        </a>
                    <?php } ?>
                </td>
                <td class="d-none d-sm-table-cell">
                    <a href="<?php echo base_url("bond/file_form/$bond->id"); ?>">
                        <p><?php echo module_name($bond->teminat_gerekce); ?></p>
                    </a>
                </td>
                <td>
                    <a href="<?php echo base_url("bond/file_form/$bond->id"); ?>">
                        <p><?php echo $bond->teminat_miktar; ?> <?php echo "$item->para_birimi"; ?></p>
                    </a>
                </td>
            </tr>
        <?php } ?>
    <?php } ?>
    </tbody>
    <tfoot>
    <tr>
        <td colspan="4"><p>TOPLAM</p></td>
        <td>
            <p><?php echo money_format(sum_anything("bond", "teminat_miktar", "contract_id", $item->id)); ?> <?php echo "$item->para_birimi"; ?></p>
        </td>
    </tr>
    </tfoot>
</table>