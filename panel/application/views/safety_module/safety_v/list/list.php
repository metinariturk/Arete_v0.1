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
        <th class="w30">Şantiye Adı</th>
        <th class="w25">İSG Görevli</th>
        <th class="w25">Şantiye Şefi</th>
        <th class="w5">İşlem</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($items as $item) {
        $site = $this->Site_model->get(array(
                "id" => $item->site_id));

        ?>
        <tr>
            <td><?php echo $item->id; ?></td>
            <?php if (isset($item->site_id)) { ?>
                <td>
                    <a href="<?php echo base_url("site/file_form/$item->site_id"); ?>"
                    <span><?php echo site_name($item->site_id); ?></span>
                    </a>
                </td>
            <?php } ?>

            <td>
                <h5>
                    <?php
                    $isg_personeller = get_as_array($item->isg_personeller);
                    foreach ($isg_personeller as $personel) { ?>
                        <a href="<?php echo base_url("user/file_form/$personel"); ?>"
                        <span><?php echo get_avatar($personel); ?><?php echo full_name($personel); ?></span>
                        </a>
                    <?php } ?>
                </h5>
            </td>
            <td>
                <?php echo get_avatar($site->santiye_sefi); ?><?php echo full_name($site->santiye_sefi); ?>
            </td>
            <td>
                <a class="btn btn-info pager-btn" href="<?php echo base_url("safety/file_form/$item->id"); ?>"
                <span class="m-r-xs"><i class="fas fa-ellipsis-h"></i></span>
                <span>Detay</span>
                </a>
            </td>
        </tr>
    <?php } ?>
    </tbody>
    </table>
<?php } ?>

