<div class="col-sm-12">
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="display" id="basic-1">
                    <thead>
                    <tr>
                        <th>Proje Kodu</th>
                        <th>Proje Adı</th>
                        <th>Etiketler</th>
                        <th>Departman</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($items as $item) { ?>
                        <tr>
                            <td>
                                <a href="<?php echo base_url("project/file_form/$item->id"); ?>">
                                    <?php echo $item->proje_kodu; ?>
                                </a>
                            </td>
                            <td>
                                <a href="<?php echo base_url("project/file_form/$item->id"); ?>">
                                    <?php echo $item->proje_ad; ?>
                                </a>
                            </td>
                            <td>
                                <a href="<?php echo base_url("project/file_form/$item->id"); ?>">
                                    <?php echo tags($item->etiketler); ?>
                                </a>
                            </td>
                            <td>
                                <a href="<?php echo base_url("project/file_form/$item->id"); ?>">
                                    <?php echo $item->department; ?>
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>








