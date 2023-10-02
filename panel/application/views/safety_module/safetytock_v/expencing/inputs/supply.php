<div class="bg-color-op-blue" style="margin-left: 20px;">
    <table class="table">
        <tbody>
        <tr>
            <th>#</th>
            <th>Kullanan Grup</th>
            <th>Tedarikçi</th>
            <th>Malzeme Adı</th>
            <th>Stok KalanMiktar</th>
            <th>Açıklama</th>
            <th>Kullanılan Miktar</th>
            <th>Kullanım Açıklaması</th>
            <th>Kullanım Tarih</th>
            <th>Kalan Miktar</th>
        </tr>
        <?php $supplies = json_decode($item->supplies); ?>
        <?php foreach ($supplies

        as $supply) { ?>
        <tr>
            <td><input type="number" name="consume[<?php echo $supply->id; ?>][id]" hidden
                       value="<?php echo $supply->id; ?>"><?php echo $supply->id; ?></td>
            <td><?php echo group_name($supply->product_group); ?></td>
            <td><?php echo company_name($supply->supplier); ?></td>
            <td><?php echo $supply->product_name; ?></td>
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
                ?>
                <?php $kalan = $supply->product_qty - $sum;
                echo $kalan . " " . $supply->unit; ?>
                <?php } else { ?>
                <?php $kalan = $supply->product_qty;
                    echo $kalan . " " . $supply->unit; ?>
                <?php } ?>
                <input id="calB" type="number" hidden step="any" value="<?php echo $kalan; ?>">
            </td>
            <td><?php echo $supply->supply_notes ?></td>
            <td><input type="number" step="any" max="<?php echo "$kalan"; ?>" id="calA" onblur="calcular()"
                       onfocus="calcular()"
                       onChange="myFunction(calA)" class="form-control" name="consume[<?php echo $supply->id; ?>][qty]"
                       placeholder="Kullanılan Miktar">
            </td>
            <td>
                <input type="text" class="form-control" name="consume[<?php echo $supply->id; ?>][notes]">
            </td>
            <td>
                <input type="text" id="datetimepicker" class="form-control"
                       name="consume[<?php echo $supply->id; ?>][date]"
                       value="<?php echo isset($form_error) ? set_value("teslim_tarihi") : ""; ?>"
                       data-plugin="datetimepicker" data-options="{ format: 'DD-MM-YYYY' }"></td>
            <td>
                <input hidden type="text" id="calD">
                <div class="col-sm-4">
                    <span id="calC" onblur="calcular()" onfocus="calcular()"></span>
                </div>
            </td>
        </tr>
        <?php } ?>
        </tbody>
    </table>
</div>
