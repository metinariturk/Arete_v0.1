<?php if (isset($teklifler->offer)) { ?>
    <?php $teklifler = json_decode($teklifler->offer, true); ?>
    <?php if (isset($teklifler)) { ?>
        <?php foreach ($teklifler as $teklif) {
            $istekliler = array_keys($teklif);
        } ?>
        <div class="card-body">
        <div class="row">
            <div class="col-12">
                <h4 class="text-center">İstekli Teklifleri</h4>
                <table class="table" id="tbl_exporttable_to_xls">
                    <thead>
                    <tr>
                        <th style="width: 150px;">Firma Adı</th>
                        <?php foreach ($teklifler as $key => $value) { ?>
                            <th><?php echo $key + 1; ?>. Teklif</th>
                        <?php } ?>
                        <th>En Yüksek</th>
                        <th>En Düşük</th>
                        <th>Tenzilat</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($istekliler as $istekli) { ?>
                        <tr>
                            <td><?php echo company_name($istekli); ?></td>
                            <?php $collect = array(); ?>
                            <?php foreach ($teklifler as $teklif) { ?>
                                <td><?php echo money_format($teklif[$istekli]) . " " . $item->para_birimi; ?>
                                    <?php $collect[] = $teklif[$istekli]; ?>

                                </td>
                            <?php } ?>
                            <td>
                                <?php echo money_format(max($collect)) . " " . $item->para_birimi; ?>
                            </td>
                            <td>
                                <?php
                                $min_offer = min($collect);
                                echo money_format(min($collect)) . " " . $item->para_birimi; ?>

                            </td>
                            <td>
                                <?php echo two_digits_percantage(1 - min($collect) / max($collect)); ?>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php } ?>
    <?php foreach ($teklifler as $teklif) {
        $istekliler = array_keys($teklif);
    } ?>
    <div class="row">
        <?php if (count($teklifler) > 6) { ?>
            <div class="col-sm-4">
                <table class="table">
                    <thead>
                    <tr>
                        <th>Firma Adı</th>
                        <th>En Yüksek - En Düşük</th>
                        <th>Tenzilat</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($istekliler as $istekli) { ?>
                        <tr>
                            <td><?php echo company_name($istekli); ?></td>
                            <?php $collect = array(); ?>
                            <?php foreach ($teklifler as $teklif) { ?>
                                <?php $collect[] = $teklif[$istekli]; ?>
                            <?php } ?>
                            <td>
                                <?php echo money_format(max($collect)) . " " . $item->para_birimi; ?> -
                                <?php
                                $min_offer = min($collect);
                                echo money_format(min($collect)) . " " . $item->para_birimi; ?>
                            </td>
                            <td>
                                <?php echo two_digits_percantage(1 - min($collect) / max($collect)); ?>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <?php $collect_total = array(); ?>
                        <?php $deneme = array(); ?>
                        <?php foreach ($teklifler as $teklifs) { ?>
                            <?php foreach ($teklifs as $key => $value) {
                                $deneme[] = $value;
                            } ?>
                        <?php } ?>
                        <td colspan="3" style="background-color: rgba(255,0,65,0.18)">
                            <strong>Gelen Teklifler Arasında En Yüksek Teklif Bedeli <?php $a = max($deneme);
                                echo money_format($a) . " " . $item->para_birimi; ?> ile
                                <?php count($teklifler) + 1; ?>
                                <?php foreach ($teklifler as $teklifs) { ?>
                                    <?php $higest_search = array_keys($teklifs, max($deneme)); ?>
                                    <?php if (!empty($higest_search)) {
                                        echo company_name($higest_search[0]);
                                    } ?>
                                <?php } ?>
                                a aittir
                            </strong>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" style="background-color: rgba(64,255,0,0.18)">
                            <strong>Gelen Teklifler Arasında En Düşük Teklif Bedeli
                                <?php echo money_format(min($deneme)) . " " . $item->para_birimi; ?>
                                <?php count($teklifler) + 1; ?>
                                <?php foreach ($teklifler as $teklifs) { ?>
                                    <?php $lowest_search = array_keys($teklifs, min($deneme)); ?>
                                    <?php if (!empty($lowest_search)) {
                                        echo company_name($lowest_search[0]);
                                    } ?>
                                <?php } ?>
                                a aittir

                            </strong>
                        </td>
                    </tr>
                    </tfoot>
                </table>
            </div>
        <?php } ?>
        <div class="col-sm-<?php if (count($teklifler) > 6) {
            echo "6";
        } else {
            echo "12";
        } ?>">
            <div id="annotationchart"></div>
        </div>
    </div>
<?php } ?>