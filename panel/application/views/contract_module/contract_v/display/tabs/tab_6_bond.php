<table class="table" id="bond_table">
    <thead>
    <tr>
        <th class="d-none d-sm-table-cell"><i class="fa fa-reorder"></i></th>
        <th class="d-none d-sm-table-cell">Dosya No</th>
        <th>Başlangıç-Bitiş Tarihi</th>
        <th class="d-none d-sm-table-cell">Gerekçe</th>
        <th>Teminat Tutar</th>
    </tr>
    </thead>
    <tbody>
    <?php if (!empty($bonds)) { ?>
        <?php foreach ($bonds as $bond) { ?>
            <tr id="center_row">
                <td class="d-none d-sm-table-cell">
                    <?php echo $bond->id; ?>
                </td>
                <td class="d-none d-sm-table-cell">
                    <a href="<?php echo base_url("bond/file_form/$bond->id"); ?>">
                        <?php echo $bond->dosya_no; ?>
                    </a>
                </td>
                <td>
                    <a href="<?php echo base_url("bond/file_form/$bond->id"); ?>">
                        <?php echo dateFormat_dmy($bond->teslim_tarihi); ?>
                    </a> /
                    <?php if (!empty($bond->gecerlilik_tarihi)) { ?>
                        <a href="<?php echo base_url("bond/file_form/$bond->id"); ?>">
                            <?php echo dateFormat_dmy($bond->gecerlilik_tarihi); ?>
                        </a>
                    <?php } else { ?>
                        <a href="<?php echo base_url("bond/file_form/$bond->id"); ?>">
                            Süresiz Teminat
                        </a>
                    <?php } ?>
                </td>

                <td class="d-none d-sm-table-cell">
                    <a href="<?php echo base_url("bond/file_form/$bond->id"); ?>">
                        <?php echo module_name($bond->teminat_gerekce); ?>
                    </a>
                </td>
                <td>
                    <a href="<?php echo base_url("bond/file_form/$bond->id"); ?>">
                        <?php echo $bond->teminat_miktar; ?><?php echo "$item->para_birimi"; ?>
                    </a>
                </td>

            </tr>
        <?php } ?>
    <?php } ?>
    </tbody>
    <tfoot>
    <tr>
        <td>
            TOPLAM
        </td>
        <td>
            <?php echo money_format(sum_anything("bond", "teminat_miktar", "contract_id", $item->id)); ?>
            <?php echo "$item->para_birimi"; ?>
        </td>
    </tr>
    </tfoot>
</table>
