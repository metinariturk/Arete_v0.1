<?php
$bugun = date("Y-m-d");
?>
<div class="col-4">
    <div class="card-header text-center">
        <h4>Süre İlerlemesi</h4>
    </div>
    <div id="circlechart"></div>
</div>
<div class="col-8">
    <div class="card-header text-center">
        <h4>Süre Ölçütleri</h4>
    </div>
    <div class="row">
        <div class="col-4">
            <div class="col-12 text-center"><strong>Sözleşme İmza Tarihi</strong></div>
            <div class="col-12 text-center">
                <i><?php echo $item->sozlesme_tarih == null ? null : dateFormat($format = 'd-m-Y', $item->sozlesme_tarih); ?></i>
            </div>
        </div>
        <div class="col-4">
            <div class="col-12 text-center"><strong>Yer Teslimi Tarihi</strong></div>
            <div class="col-12 text-center"><i>  <?php if (date_control($item->sitedel_date)) { ?>
                        <?php echo $item->sitedel_date == null ? null : dateFormat($format = 'd-m-Y', $item->sitedel_date); ?>
                    <?php } else { ?>
                        <a class="btn btn-success m-r-10" data-bs-original-title=""
                           href="<?php echo base_url("contract/file_form/$item->id/sitedel"); ?>">
                            <i class="fa fa-plus-circle me-1"></i>
                        </a>
                    <?php } ?></i>
            </div>
        </div>
        <div class="col-4">
            <div class="col-12 text-center"><strong>Sözleşme Bitiş Tarihi</strong></div>
            <div class="col-12 text-center">
                <i><?php echo $item->sozlesme_bitis == null ? null : dateFormat($format = 'd-m-Y', $item->sozlesme_bitis); ?></i>
            </div>
        </div>
    </div>
    <hr>
    <table class="table">
        <thead>
        <tr>
            <th>Dosya No</th>
            <th class="d-md-none">Süre Başl. Tarihi</th>
            <th>Süre Gün</th>
            <th class="d-md-none">Süre Bitiş. Tarihi</th>
            <th>Geçen Süre</th>
            <th>Yüzde</th>
        </tr>
        <tr>
            <th>
                <?php echo $item->dosya_no; ?>
            </th>
            <th class="d-md-none"><?php echo dateFormat_dmy($item->sitedel_date); ?></th>
            <th><?php echo $item->isin_suresi; ?> Gün</th>
            <th class="d-md-none"> <?php echo dateFormat_dmy($item->sozlesme_bitis); ?></th>
            <th><?php
                $gecen = dateDifference($item->sitedel_date, $bugun);
                if ($gecen < 0) {
                    echo "0";
                } elseif ($gecen > 0) {
                    echo $gecen;
                } else {
                    echo "0";
                } ?> Gün
            </th>
            <th>% <?php
                $gecen = dateDifference($item->sitedel_date, $bugun);
                if ($gecen < 0) {
                    echo "0";
                } elseif ($gecen > 0 and $gecen < $item->isin_suresi) {
                    echo round($gecen / $item->isin_suresi * 100);
                } else {
                    echo "100";
                } ?>
            </th>
        </tr>
        </thead>
        <tbody>
        <?php if (!empty($extimes)) { ?>
            <?php
            foreach ($extimes

                     as $extime) { ?>
                <tr>
                    <td>
                        <a href="<?php echo base_url("extime/file_form/$extime->id"); ?>">
                            <?php echo $extime->dosya_no; ?>
                        </a>
                    </td>
                    <td class="d-md-none"><?php echo dateFormat_dmy($extime->baslangic_tarih); ?></td>
                    <td><?php echo $extime->uzatim_miktar; ?> Gün</td>
                    <td class="d-md-none"> <?php echo dateFormat_dmy($extime->bitis_tarih); ?></td>
                    <td><?php
                        $gecen = dateDifference($extime->baslangic_tarih, $bugun);
                        if ($gecen < 0) {
                            echo "0";
                        } elseif ($gecen > 0) {
                            echo $extime->uzatim_miktar;
                        } else {
                            echo "0";
                        } ?> Gün
                    </td>
                    <td>% <?php
                        $gecen = dateDifference($extime->baslangic_tarih, $bugun);
                        if ($gecen < 0) {
                            echo "0";
                        } elseif ($gecen > 0) {
                            echo round($gecen / $extime->uzatim_miktar * 100);
                        } else {
                            echo "100";
                        } ?>
                    </td>
                </tr>
            <?php } ?>
        <?php } ?>
        </tbody>
        <?php if (!empty($extimes)) { ?>
            <tfoot>
            <td>GENEL</td>
            <td class="d-md-none"><?php echo dateFormat_dmy($item->sitedel_date); ?></td>
            <td><?php echo $total_day = $item->isin_suresi + sum_anything("extime", "uzatim_miktar", "contract_id", "$item->id"); ?>
                Gün
            </td>
            <td class="d-md-none"><?php if (!empty($extimes)) {
                    echo dateFormat_dmy(get_last_date("$item->id", "extime", "bitis_tarih"));
                } else {
                    echo dateFormat_dmy($item->sozlesme_bitis);
                }
                ?></td>
            <td><?php
                $time_elapsed = date_minus_day($bugun, $item->sitedel_date);
                if ($time_elapsed > $total_day) {
                    echo "∞";
                } elseif ($time_elapsed < $total_day) {
                    echo round($time_elapsed) . " Gün";
                }
                ?>
            </td>
            <td> %
                <?php
                if ($time_elapsed > $total_day) {
                    echo $sozlesme_yuzde = 100;
                } elseif ($time_elapsed < $total_day) {
                    echo $sozlesme_yuzde = round($time_elapsed / $total_day * 100);
                }
                ?>
            </td>
            </tfoot>
        <?php } ?>
    </table>
</div>








