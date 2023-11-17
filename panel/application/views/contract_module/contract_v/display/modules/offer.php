<?php if (isset($teklifler->offer)) { ?>
    <?php $teklifler = json_decode($teklifler->offer, true); ?>
    <?php if (isset($teklifler)) { ?>

        <?php foreach ($teklifler as $teklif) {
            $istekliler = array_keys($teklif);
        } ?>
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
                <th>İşlem</th>
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
                    <td>
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
                <td colspan="3" class="bg-info">
                    <strong>En Yüksek Teklif : <?php $a = max($deneme);
                        echo money_format($a) . " " . $item->para_birimi; ?>
                    </strong>
                </td>
                <td colspan="<?php echo count($teklifler) + 1; ?>">
                    <h5>
                        <?php foreach ($teklifler as $teklifs) { ?>
                            <?php $higest_search = array_keys($teklifs, max($deneme)); ?>
                            <?php if (!empty($higest_search)) {
                                echo company_name($higest_search[0]);
                            } ?>
                        <?php } ?>
                    </h5>
                </td>
            </tr>
            <tr>
                <td colspan="3" class="bg-success">
                    <strong>En Düşük Teklif
                        : <?php echo money_format(min($deneme)) . " " . $item->para_birimi; ?></strong>
                </td>
                <td colspan="<?php echo count($teklifler) + 1; ?>">
                    <h5>
                        <?php foreach ($teklifler as $teklifs) { ?>
                            <?php $lowest_search = array_keys($teklifs, min($deneme)); ?>
                            <?php if (!empty($lowest_search)) {
                                echo company_name($lowest_search[0]);
                            } ?>
                        <?php } ?>
                    </h5>
                </td>
            </tr>
            </tfoot>
        </table>
    <?php } ?>
<?php } ?>



<div class="col-12">
    <div class="col-sm-12 col-xl-12 box-col-6">
        <div class="card">
            <div class="card-header">
                <h5>Column Chart
                </h5>
            </div>
            <div class="card-body">
                <div id="annotationchart"></div>
            </div>
        </div>
    </div>
</div>

<script>

    function ExportToExcel(type, fn, dl) {
        var elt = document.getElementById('tbl_exporttable_to_xls');
        var wb = XLSX.utils.table_to_book(elt, {sheet: "sheet1"});
        return dl ?
            XLSX.write(wb, {bookType: type, bookSST: true, type: 'base64'}) :
            XLSX.writeFile(wb, fn || ('<?php echo $item->ihale_ad; ?> Teklifler.' + (type || 'xlsx')));
    }

</script>

