<?php
$elapsed_Day = fark_gun($item->sozlesme_tarih);
$total_day = $item->isin_suresi;
$remain_day = ($total_day - $elapsed_Day);
$total_payment = sum_anything("payment", "balance", "contract_id", $item->id);
$total_collection = sum_anything("collection", "tahsilat_miktar", "contract_id", $item->id);
$total_provision = $this->Payment_model->sum_all(array('contract_id' => $item->id), "Kes_e");
$advance_admission = $this->Payment_model->sum_all(array('contract_id' => $item->id), "I");
$advance_given = sum_anything("advance", "avans_miktar", "contract_id", $item->id);
?>
<div class="card-body">
    <div class="card-header bg-dark text-white p-3 rounded">
        <div class="title"><p class="mb-0 text-uppercase">Sözleşme Raporu</p></div>
        <h5 class="mb-0"><?= mb_strtoupper($item->contract_name); ?></h5>
    </div>

    <!-- Sözleşme Detayları -->
    <table class="table-lg table-border-horizontal mt-4">
        <thead class="thead-dark">
        <tr>
            <th><p>Sözleşme Bedeli</p></th>
            <th><p>Sözleşme Tarihi</p></th>
            <th><p>Süresi</p></th>
            <th><p>Bitiş Tarihi</p></th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td><p><?= money_format($item->sozlesme_bedel) . " " . $item->para_birimi; ?></p></td>
            <td><p><?= dateFormat_dmy($item->sozlesme_tarih); ?></p></td>
            <td><p><?= $item->isin_suresi . " Gün"; ?></p></td>
            <td><p><?= dateFormat_dmy($item->sozlesme_bitis); ?></p></td>
        </tr>
        </tbody>
    </table>

    <!-- Sözleşme Süresi İlerlemesi -->
    <div class="mt-4">
        <h6><p class="f-16">Süreye Göre İlerleme</p></h6>
        <div class="progress">
            <div class="progress-bar bg-info" role="progressbar"
                 style="width: <?= ($total_day != 0) ? ($elapsed_Day / $total_day) * 100 : 0; ?>%;"
                 aria-valuenow="<?= $elapsed_Day; ?>" aria-valuemin="0" aria-valuemax="<?= $total_day; ?>">
                <?= ($total_day != 0) ? round(($elapsed_Day / $total_day) * 100, 2) : 0; ?>%
            </div>
        </div>
        <p>Geçen Süre: <?= $elapsed_Day; ?> Gün | Kalan Süre: <?= $remain_day; ?> Gün</p>
    </div>

    <!-- Süre Uzatımları -->
    <?php if (!empty($extimes)): ?>
        <div class="mt-4">
            <h6><p class="f-16">Süre Uzatımları</p></h6>
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>Uzatma No</th>
                    <th>Geçen Süre</th>
                    <th>Kalan Süre</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($extimes as $key => $extime): ?>
                    <tr>
                        <td><?= $key + 1; ?>. Süre Uzatımı</td>
                        <td><?= fark_gun($extime->baslangic_tarih) . " Gün"; ?></td>
                        <td><?= ($extime->uzatim_miktar - fark_gun($extime->baslangic_tarih)) . " Gün"; ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>

    <!-- Finansal İlerleme -->
    <div class="mt-4">
        <h6><p class="f-16">Finansal İlerleme</p></h6>
        <div class="progress">
            <div class="progress-bar bg-success" role="progressbar"
                 style="width: <?= ($item->sozlesme_bedel != 0) ? ($total_payment / $item->sozlesme_bedel) * 100 : 0; ?>%;"
                 aria-valuenow="<?= $total_payment; ?>" aria-valuemin="0" aria-valuemax="<?= $item->sozlesme_bedel; ?>">
                <?= ($item->sozlesme_bedel != 0) ? round(($total_payment / $item->sozlesme_bedel) * 100, 2) : 0; ?>%
            </div>
        </div>
        <p>Toplam Hakediş: <?= money_format($total_payment); ?> <?php echo $item->para_birimi; ?> / Sözleşme Bedeli: <?= money_format($item->sozlesme_bedel); ?> <?php echo $item->para_birimi; ?></p>
    </div>

    <!-- Avans İlerlemesi -->
    <div class="mt-4">
        <h6><p class="f-16">Avans İlerlemesi</p></h6>
        <div class="progress">
            <div class="progress-bar bg-warning" role="progressbar"
                 style="width: <?= ($advance_given != 0) ? ($advance_admission / $advance_given) * 100 : 0; ?>%;"
                 aria-valuenow="<?= $advance_admission; ?>" aria-valuemin="0" aria-valuemax="<?= $advance_given; ?>">
                <?= ($advance_given != 0) ? round(($advance_admission / $advance_given) * 100, 2) : 0; ?>%
            </div>
        </div>
        <p>Mahsup Edilen: <?= money_format($advance_admission); ?> <?php echo $item->para_birimi; ?> / Verilen Avans: <?= money_format($advance_given); ?> <?php echo $item->para_birimi; ?></p>
    </div>

    <!-- Ödeme Durumu -->
    <div class="mt-4">
        <h6><p class="f-16">Ödeme Durumu</p></h6>
        <div class="progress">
            <div class="progress-bar bg-danger" role="progressbar"
                 style="width: <?= ($total_payment != 0) ? ($total_collection / $total_payment) * 100 : 0; ?>%;"
                 aria-valuenow="<?= $total_collection; ?>" aria-valuemin="0" aria-valuemax="<?= $total_payment; ?>">
                <?= ($total_payment != 0) ? round(($total_collection / $total_payment) * 100, 2) : 0; ?>%
            </div>
        </div>
        <p>Toplam Ödeme: <?= money_format($total_collection); ?><?php echo $item->para_birimi; ?> / Toplam Hakediş: <?= money_format($total_payment); ?><?php echo $item->para_birimi; ?></p>
        <p>Kalan Avans: <?= money_format($advance_given - $advance_admission); ?> <?php echo $item->para_birimi; ?> </p>
        <p>Nakit Teminat Kesintisi: <?= money_format($total_provision); ?> <?php echo $item->para_birimi; ?> </p>
        <p><b>Kalan Ödeme: <?= money_format($total_payment - $total_collection - ($advance_given - $advance_admission) - $total_provision); ?> <?php echo $item->para_birimi; ?></b> </p>
    </div>
</div>