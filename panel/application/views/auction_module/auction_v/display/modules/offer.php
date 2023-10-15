

<div class="col-sm-12">
    <table class="table" id="cost_table">
        <thead>
        <tr>
            <th class="d-none d-sm-table-cell"><i class="fa fa-reorder"></i></th>
            <th>Teklif No</th>
            <th>Teklif Tarih</th>
            <th>Teklif Tutar</th>
            <th>Açıklama</th>
        </tr>
        </thead>
        <tbody>
        <?php if (!empty($offers)) { ?>
            <?php foreach ($offers as $offer) { ?>
                <tr id="center_row">
                    <td class="d-none d-sm-table-cell">
                        <?php echo $offer->id; ?>
                    </td>
                    <td class="d-none d-sm-table-cell">
                        <a href="<?php echo base_url("offer/file_form/$offer->id"); ?>">
                            <?php echo $offer->offer_no; ?>
                        </a>
                    </td>
                    <td>
                        <a href="<?php echo base_url("offer/file_form/$offer->id"); ?>">
                            <?php echo $offer->offer_date; ?>
                        </a>
                    </td>
                    <td>
                        <a href="<?php echo base_url("offer/file_form/$offer->id"); ?>">
                            <?php echo money_format($offer->offer_price) . " " . get_currency_auc($item->id); ?>
                        </a>
                    </td>
                    <td>
                        <a href="<?php echo base_url("offer/file_form/$offer->id"); ?>">
                            <?php echo $offer->aciklama; ?>
                        </a>
                    </td>
                    <td>
                        <div>
                            <?php if (!empty($offer->id)) {
                                $offer_files = get_module_files("offer_files", "offer_id", "$offer->id");
                                if (!empty($offer_files)) { ?>
                                    <a class="btn btn-pill btn-success btn-air-success" type="button" title=""
                                       href="<?php echo base_url("offer/download_all/$offer->id"); ?>"
                                       data-bs-original-title="<?php foreach ($offer_files as $offer_file) { ?>
                                            <?php echo filenamedisplay($offer_file->img_url); ?> |
                                            <?php } ?>"
                                       data-original-title="btn btn-pill btn-info btn-air-info ">
                                        <i class="fa fa-download" aria-hidden="true"></i> Dosya
                                        (<?php echo count($offer_files); ?>)
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
    </table>
</div>
