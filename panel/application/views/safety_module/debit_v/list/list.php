<div class="widget p-lg">
    <?php if (empty($items)) { ?>
        <div class="alert alert-info text-center">
            <p>Burada herhangi bir veri bulunmamaktadır. Eklemek için lütfen
                <a href="<?php echo base_url("compute/select"); ?>"> Buradan Yeni Teknik Metraj Ekleyiniz</a>
            </p>
        </div>
    <?php } else { ?>
    <div class="table-responsive">
        <table id="default-datatable" data-plugin="DataTable" class="table table-striped">
            <thead>
            <tr>
                <th>#</th>
                <th>Personel Adı</th>
                <th>İSG Zimmet Grubu</th>
                <th>Zimmet Tarihi</th>
                <th>Zimmet Malzeme</th>
                <th>İşlem</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($items as $item) { ?>
                <tr>
                    <td class="w5c"><?php echo $item->id; ?></td>
                    <td class="w15">
                        <?php echo worker_name($item->worker_id); ?>
                    </td>
                    <td class="w10"> <?php echo $item->zimmet_turu; ?></td>
                    <td class="w10"><?php echo dateFormat_dmy($item->zimmet_tarihi); ?></td>
                    <td class="w30"><?php echo $item->zimmet_malzeme; ?></td>
                    <td class="w10">
                        <a class="btn btn-info pager-btn" href="<?php echo base_url("debit/file_form/$item->id"); ?>"
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

