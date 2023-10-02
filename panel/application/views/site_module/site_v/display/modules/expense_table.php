<table class="display" id="export-expense">
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
    <?php foreach ($all_expenses as $expense) { ?>
        <tr>
            <td><?php echo dateFormat_dmy($expense->date); ?></td>
            <td><?php echo $expense->bill_code; ?></td>
            <td><?php echo money_format($expense->price); ?> TL</td>
            <td><?php echo $expense->payment_type; ?></td>
            <td><?php echo $expense->note; ?></td>
            <td>
                <a href="<?php echo base_url("$this->Module_Name/expense_download/$expense->id"); ?>">
                    <i class="fa fa-download f-14 ellips"></i>
                </a>
            </td>
            <td>
                <a onclick="deleteExpenseFile(this)"
                   url="<?php echo base_url("site/expense_delete/$expense->id"); ?>"
                <i style="font-size: 18px; color: Tomato;" class="fa fa-times-circle-o"
                   aria-hidden="true"></i>
                </a>
            </td>
        </tr>
    <?php } ?>
    </tbody>
</table>
