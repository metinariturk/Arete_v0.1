<?php
$caculation = $this->Boq_model->get(array(
    "contract_id" => $item->contract_id,
    "payment_no" => $item->hakedis_no
));
$calculations = json_decode($caculation->calculation, true);
?>

<table class="table">
    <thead>
    <tr>
        <th style="text-align: center">İmalat Adı</th>
        <th style="text-align: center">Önceki Miktar</th>
        <th style="text-align: center">Bu Miktar</th>
        <th style="text-align: center">Kümülatif</th>
        <th style="text-align: center">Bu Tutar</th>
        <th style="text-align: center">Toplam Tutar</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $total_price = 0;
    $this_price = 0;

    foreach ($calculations as $calculation => $value) {
        $this_qty = intval($value["thisqty"]);
        $cumulative = intval($value["cumulative"]);
        $this_price += floatval($value["thisprice"]);
        $total_price += floatval($value["totalprice"]);
        ?>
        <tr>
            <td><?php echo boq_name($calculation); ?></td>
            <td>
                <span style="float: left; padding-left: 20%"><?php echo money_format($cumulative - $this_qty); ?></span>
                <span style="float: right;"><?php echo boq_unit($calculation); ?></span>
            </td>
            <td>
                <span style="float: left; padding-left: 20%"><?php echo money_format($this_qty); ?></span>
                <span style="float: right;"><?php echo boq_unit($calculation); ?></span>
            </td>
            <td>
                <span style="float: left; padding-left: 20%"><?php echo money_format($cumulative); ?></span>
                <span style="float: right;"><?php echo boq_unit($calculation); ?></span>
            <td>
                <span style="float: left; padding-left: 5%"><?php echo money_format($value["thisprice"]); ?></span>
                <span style="float: right; padding-right: 5%"><?php echo get_currency($item->contract_id); ?></span>
            </td>
            <td>
                <span style="float: left;"><?php echo money_format($value["totalprice"]); ?></span>
                <span style="float: right;"><?php echo get_currency($item->contract_id); ?></span>
            </td>
        </tr>
        <?php
    }
    ?>
    </tbody>
    <tfoot>
    <tr>
        <td colspan="3"></td>
        <td>TOPLAM</td>
        <td>
            <span style="float: left; padding-left: 5%"><?php echo money_format($this_price); ?></span>
            <span style="float: right; padding-right: 5%"><?php echo get_currency($item->contract_id); ?></span>
        </td>
        <td>
            <span style="float: left;  padding-left: 5%"><?php echo money_format($total_price); ?></span>
            <span style="float: right;  padding-right: 5%"><?php echo get_currency($item->contract_id); ?></span>
    </tr>
    </tfoot>
</table>
