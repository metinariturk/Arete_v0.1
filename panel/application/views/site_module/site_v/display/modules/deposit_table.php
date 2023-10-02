<table class="display" id="export-deposit">
    <thead>
    <tr>
        <th>Tarihi</th>
        <th>Belge No</th>
        <th>Harcama Tutar</th>
        <th>Ödeme Türü</th>
        <th>Açıklama</th>
        <th>İndir</th>
        <th>Sil</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($all_deposites as $deposit) { ?>
        <tr>
            <td><?php echo dateFormat_dmy($deposit->date); ?></td>
            <td><?php echo $deposit->bill_code; ?></td>
            <td><?php echo money_format($deposit->price); ?> TL</td>
            <td><?php echo $deposit->payment_type; ?></td>
            <td><?php echo $deposit->note; ?></td>
            <td>
                <a href="<?php echo base_url("$this->Module_Name/expense_download/$deposit->id"); ?>">
                    <i class="fa fa-download f-14 ellips"></i>
                </a>
            </td>
            <td>
                <a onclick="deleteDepositeFile(this)"
                   url="<?php echo base_url("site/expense_delete/$deposit->id"); ?>"
                <i style="font-size: 18px; color: Tomato;" class="fa fa-times-circle-o"
                   aria-hidden="true"></i>
                </a>
            </td>
        </tr>
    <?php } ?>
    </tbody>
</table>
