<button class="btn btn-pill btn-outline-success" onclick="paymentToExcel('xlsx')"
        type="button"><i class="fa fa-share-square-o"></i> EXCEL
</button>


<table class="table" id="payment_table">
    <thead>
    <tr>
        <th  class="d-none d-sm-table-cell">Hakediş No</th>
        <th  class="d-none d-sm-table-cell">Hakediş İtibar Tarihi</th>
        <th>Hakediş Tutar</th>
        <th  class="d-none d-sm-table-cell">Net Ödenecek</th>
        <th>Evraklar</th>
    </tr>
    </thead>
    <tbody>
    <?php if (!empty($payments)) { ?>
        <?php foreach ($payments as $payment) { ?>
            <tr id="center_row">
                <td class="d-none d-sm-table-cell">
                    <a  href="<?php echo base_url("payment/file_form/$payment->id"); ?>">
                        <?php echo str_pad($payment->hakedis_no, 2, "0", STR_PAD_LEFT);; ?>
                    </a>
                </td>
                <td class="d-none d-sm-table-cell">
                    <a  href="<?php echo base_url("payment/file_form/$payment->id"); ?>">
                        <?php echo dateFormat_dmy($payment->imalat_tarihi); ?>
                    </a>
                </td>
                <td>
                    <a  href="<?php echo base_url("payment/file_form/$payment->id"); ?>">
                        <?php echo money_format($payment->bu_imalat_ihzarat); ?> <?php echo "$item->para_birimi"; ?>
                    </a>
                </td>
                <td class="d-none d-sm-table-cell">
                    <a  href="<?php echo base_url("payment/file_form/$payment->id"); ?>">
                       <?php echo money_format($payment->net_bedel); ?> <?php echo "$item->para_birimi"; ?>
                    </a>
                </td>
                <td>
                    <div>
                        <?php if (!empty($payment->id)) {
                            $payment_files = get_module_files("payment_files", "payment_id", "$payment->id");
                            if (!empty($payment_files)) { ?>
                                <a class="btn btn-pill btn-success btn-air-success" type="button" title=""
                                   href="<?php echo base_url("payment/download_all/$payment->id"); ?>"
                                   data-bs-original-title="<?php foreach ($payment_files as $payment_file) { ?>
                                            <?php echo filenamedisplay($payment_file->img_url); ?> |
                                            <?php } ?>"
                                   data-original-title="btn btn-pill btn-info btn-air-info btn-lg">
                                    <i class="fa fa-download" aria-hidden="true"></i>
                                    (<?php echo count($payment_files); ?>)
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
    <tfoot>
    <tr>
        <td class="d-none d-sm-table-cell">
            TOPLAM
        </td>
        <td class="d-none d-sm-table-cell">
        </td>
        <td class="d-none d-sm-table-cell">
        </td>
        <td>
            <?php echo money_format(sum_anything("payment", "bu_imalat_ihzarat", "contract_id", $item->id)); ?>
            <?php echo "$item->para_birimi"; ?>
        </td>
        <td  class="d-none d-sm-table-cell">
            <?php echo money_format(sum_anything("payment", "net_bedel", "contract_id", $item->id)); ?> <?php echo "$item->para_birimi"; ?>
        </td>

    </tr>
    </tfoot>
</table>

<script>
    function paymentToExcel(type, fn, dl) {
        var elt = document.getElementById('payment_table');
        var wb = XLSX.utils.table_to_book(elt, {sheet: "Sayfa1"});
        return dl ?
            XLSX.write(wb, {bookType: type, bookSST: true, type: 'base64'}) :
            XLSX.writeFile(wb, fn || ('<?php echo $item->sozlesme_ad; ?> Hakediş.' + (type || 'xlsx')));
    }
</script>