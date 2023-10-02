<table class="table tablecenter table-striped"">
<tbody class="bg-color-op-purple">
<?php $supplies = json_decode($item->supplies); ?>
<?php if ($supplies != null) { ?>
<tr>
    <th>id</th>
    <th>Tedarikçi</th>
    <th>
        Mahal
    </th>
    <th>
        Malzeme Adı
    </th>
    <th>
        Gelen Miktar
    </th>

    <th>
        Tutar
    </th>
    <th>
        İrsaliye/Fatura Kodu
    </th>
    <th>
        Açıklama
    </th>
    <th>
        İşlem
    </th>
</tr>
<?php foreach ($supplies

as $supply) { ?>
<tr>
    <td><?php echo $supply->id; ?></td>
    <td><?php echo company_name($supply->supplier) ?></td>
    <td>
        <?php echo group_name($supply->product_group) ?>
    </td>
    <td>
        <?php echo $supply->product_name ?>
    </td>
    <td>
        <?php echo $supply->product_qty . " " . $supply->unit; ?>
    </td>

    <td>
        <?php echo money_format($supply->price) . " " . $supply->currency; ?>
    </td>
    <td>
        <?php echo $supply->bill_code ?>
    </td>
    <td>
        <?php echo $supply->supply_notes ?>
    </td>
    <td>
        <a class="pager-btn btn btn-purple btn-outline"
           href="<?php echo base_url("$this->Module_Name/expensing_form/$item->id"); ?>">
            <i class="fas fa-arrow-left"></i>
            Stok Çıkışı
        </a>
    </td>
</tr>
<?php if (isset($item->consume)) { ?>
    <?php $a = array(json_decode($item->consume)); ?>
    <?php
    foreach ($a as $b) { ?>
        <?php foreach ($b as $c) { ?>
            <?php if ($c->id == $supply->id) { ?>
                <tr>
                    <td colspan="4"><strong>STOK ÇIKIŞI</strong></td>
                    <td><?php echo $c->qty . " " . $supply->unit; ?></td>
                    <td><?php echo money_format($c->qty * ($supply->price / $supply->product_qty)) . " " . $supply->currency; ?></td>
                    <td>Tarih : <?php echo $c->date; ?></td>
                    <td></td>
                    <td><?php echo $c->notes; ?></td>
                </tr>
            <?php } ?>
        <?php } ?>
        <tr>
            <td colspan="4"><strong>Kalan Stok</strong></td>
            <td>
                <?php $a = array(json_decode($item->consume)); ?>
                <?php if (!empty($item->consume)) { ?>
                    <?php $sum = 0; ?>
                    <?php foreach ($a as $b) {
                        foreach ($b as $c) {
                            if ($c->id == $supply->id) {
                                $sum += $c->qty;
                            }
                        }
                    }
                }
                ?>
                <strong><?php echo ($supply->product_qty-$sum)." ".$supply->unit; ?></strong>
            </td>
            <td><?php echo money_format(($supply->product_qty-$sum)*($supply->price / $supply->product_qty))." ".$supply->currency; ?></td>
            <td colspan="3"></td>
        </tr>
    <?php } ?>
<?php } else { ?>
    <tr id="accordion<?php echo $supply->id; ?>" class="collapse">
        <td>
            <a class="pager-btn btn btn-purple btn-outline"
               href="<?php echo base_url("$this->Module_Name/expensing_form/$item->id"); ?>">
                <i class="fas fa-arrow-left"></i>
                Stok Çıkışı
            </a>
        </td>
    </tr>
<?php } ?>
</tbody>
<?php } ?>
<?php } ?>
</table>
<hr>
