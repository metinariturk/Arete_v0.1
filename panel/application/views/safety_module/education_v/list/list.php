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
                <th>İSG Eğitim Grubu</th>
                <th>Eğitim Tarihi</th>
                <th>Geçerlilik Tarihi</th>
                <th>İşlem</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($items as $item) { ?>
                <tr>
                    <td class="w5c"><?php echo $item->id; ?></td>
                    <td class="w30">

                    </td>
                    <td class="w10"></td>
                    <td class="w10"></td>
                    <td class="w10"></td>
                    <td class="w10">
                        <a class="btn btn-info pager-btn" href="<?php echo base_url("education/file_form/$item->id"); ?>"
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

