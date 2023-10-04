<?php if (empty($items)) { ?>
    <div class="alert alert-info text-center">
        <p>Burada herhangi bir veri bulunmamaktadır. Eklemek için lütfen
            <a href="<?php echo base_url("$this->Module_Name/select"); ?>"> Buradan
                Yeni <?php echo $this->Module_Title; ?> Ekleyiniz</a>
        </p>
    </div>
<?php } else { ?>
    <table id="default-datatable" data-plugin="DataTable" class="table table-striped">
        <thead>
        <tr>
            <th class="w5">ID</th>
            <th class="w10">Teklif Kodu</th>
            <th class="w30">Teklif Adı</th>
            <th class="w25">Proje Adı</th>
            <th class="w25">Teklif Bedel</th>
            <th class="w5">İşlem</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($items as $item) { ?>
            <tr>
                <td><?php echo $item->id; ?></td>
                <td><?php echo $item->dosya_no; ?></td>
                <td><h5>
                        <a href="<?php echo base_url("auction/file_form/$item->id"); ?>"><?php echo $item->ihale_ad; ?></a>
                    </h5></td>
                <td><h5>
                        <a href="<?php echo base_url("project/file_form/$item->proje_id"); ?>"><?php echo get_from_id("projects", "proje_ad", $item->proje_id); ?></a>
                    </h5></td>
                <td><?php echo money_format($item->butce) . " " . $item->para_birimi; ?></td>
                <td>
                    <a class="btn btn-info pager-btn" href="<?php echo base_url("auction/file_form/$item->id"); ?>"
                    <span class="m-r-xs"><i class="fas fa-ellipsis-h"></i></span>
                    <span>Detay</span>
                    </a>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
    <?php } ?>

