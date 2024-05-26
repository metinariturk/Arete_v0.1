<table class="table" id="catalog_table">
    <thead>
    <tr>
        <th  class="d-none d-sm-table-cell"><i class="fa fa-reorder"></i></th>
        <th  class="d-none d-sm-table-cell">Dosya No</th>
        <th>Katalog Ad</th>
        <th  class="d-none d-sm-table-cell">Oluşturulma Tarihi</th>
        <th>Kapakta Kullan</th>
    </tr>
    </thead>
    <tbody>
    <?php if (!empty($catalogs)) { ?>
        <?php foreach ($catalogs as $catalog) { ?>
            <tr id="center_row">
                <td class="d-none d-sm-table-cell">
                    <?php echo $catalog->id; ?>
                </td>
                <td class="d-none d-sm-table-cell">
                    <a  href="<?php echo base_url("catalog/file_form/$catalog->id"); ?>">
                        <?php echo $catalog->dosya_no; ?>
                    </a>
                </td>

                <td>
                    <a  href="<?php echo base_url("catalog/file_form/$catalog->id"); ?>">
                        <?php echo $catalog->catalog_ad; ?>
                    </a>
                </td>
                <td class="d-none d-sm-table-cell">
                    <a  href="<?php echo base_url("catalog/file_form/$catalog->id"); ?>">
                        <?php if (isset($catalog->createdAt)) {
                            echo dateFormat_dmy($catalog->createdAt);
                        }
                        ?>
                    </a>
                </td>

                <td class="text-center">
                    <a  href="<?php echo base_url("catalog/file_form/$catalog->id"); ?>">
                        <?php cms_if_echo("$catalog->master","1", '<i class="fa fa-star" aria-hidden="true"></i> Kapak Görselleri',""); ?>
                    </a>
                </td>
            </tr>
        <?php } ?>
    <?php } ?>
    </tbody>
</table>
