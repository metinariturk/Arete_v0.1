<?php $active_boqs = (json_decode($contract->price, true)); ?>
<pre>

<?php if (isset($exist_boq)){ $calculation_array = (json_decode($exist_boq->calculation,true)); }?>
    </pre>

<table class="table">
    <thead>
    <tr>
        <th style="width: 3%"id</th>
        <th style="width: 15%">Poz Adı</th>
        <th style="text-align: center; width: 7%">Sözleşme Miktarı</th>
        <th style="text-align: center; width: 7%">Birimi</th>
        <th style="text-align: center; width: 7%">Birim Fiyat</th>
        <th style="text-align: center; width: 10%">Önceki Miktar</th>
        <th style="text-align: center; width: 10%">Bu Miktar</th>
        <th style="text-align: center; width: 10%">Önceki Tutar</th>
        <th style="text-align: center; width: 10%">Bu Tutar</th>
        <th style="text-align: center; width: 10%">Toplam</th>
    </tr>
    </thead>
    <tbody>
    <?php if (!empty($active_boqs)) { ?>
        <?php foreach ($active_boqs as $active_group => $boqs) { ?>
            <?php foreach ($boqs as $boq => $value) { ?>
                <?php
                if (isset($exist_boq)) {$key_in_calculation = array_search($boq, array_keys($calculation_array)); }
                ?>
                <tr>

                    <td>
                        <?php echo $boq; ?><!--Poz Adı-->
                    </td>
                    <td>
                        <?php echo boq_name($boq); ?><!--Poz Adı-->
                    </td>
                    <td style="text-align: center;"><!--Sözleşme Miktarı-->
                        <span><?php echo $value["qty"]; ?></span>
                    </td>
                    <td style="text-align: center;"><!--Birimi-->
                        <?php echo boq_unit($boq); ?>
                    </td>
                    <td><!--Birim Fiyat-->
                        <input id="<?php echo $boq; ?>_unitprice" readonly class="form-control" value="<?php echo $value["price"]; ?>" style="float: right;">
                    </td>
                    <td><!--Önceki Miktar-->
                        <input id="<?php echo $boq; ?>_oldqty" readonly class="form-control" type="text">
                    </td>
                    <td><!--Bu Miktar-->
                        <input id="<?php echo $boq; ?>_thisqty" value="<?php if  (isset($exist_boq)) {echo  $calculation_array["$boq"]["thisqty"];} ?>" class="form-control" name="calculate[<?php echo $boq; ?>][thisqty]" type="text">
                    </td>
                    <td><!--Önceki Tutar-->
                        <input id="<?php echo $boq; ?>_oldprice" readonly class="form-control" type="text">
                    </td>
                    <td style="width: 3%"><!--Bu Tutar-->
                        <input id="<?php echo $boq; ?>_thisprice" readonly value="<?php if  (isset($exist_boq)) {echo  $calculation_array["$boq"]["thisqty"];} ?>" class="form-control" name="calculate[<?php echo $boq; ?>][thisprice]" type="text">
                    </td>
                    <td style="width: 3%"><!--Toplam-->
                        <input id="<?php echo $boq; ?>_totalprice" readonly class="form-control" name="calculate[<?php echo $boq; ?>][totalprice]" type="text">
                    </td>
                </tr>
            <?php } ?>
        <?php } ?>
    <?php } else { ?>
        Sözleşme Pozlarını tanımlamadan hakediş metrajı yapamazsınız.
        <a href="<?php echo base_url("contract/file_form/$contract->id/boq"); ?>">Buradan Sözleşme Pozu Ekleyiniz</a>
    <?php } ?>
    </tbody>
</table>

