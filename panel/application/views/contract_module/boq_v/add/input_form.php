<?php $active_boqs = (json_decode($contract->price, true)); ?>

<?php if (!empty($active_boqs)){ ?>
<?php foreach ($active_boqs as $active_group => $boqs) { ?>

    <table class="table">
        <thead>
        <tr>
            <th colspan="8" class="text-center">
                <?php echo boq_name($active_group); ?> <br>
            </th>
        </tr>
        <tr>
            <th>Poz Adı</th>
            <th>Birimi</th>
            <th>Birim Fiyat</th>
            <th>Önceki Miktar</th>
            <th>Bu Miktar</th>
            <th>Önceki Tutar</th>
            <th>Bu Tutar</th>
            <th>Toplam</th>
        </tr>
        <tbody>
        <?php foreach ($boqs as $boq=>$value) { ?>
            <tr>
                <td>
                    <?php echo boq_name($boq); ?>
                </td>
                <td>
                    <?php echo boq_unit($boq); ?>
                </td>
                <td>
                    <?php echo $value["price"]; ?>
                    <span style="float: right;"><?php echo $contract->para_birimi; ?></span>
                </td>
                <td>
                </td>
                <td>
                   <input type="number" >
                </td>

                <td>
                    123
                </td>
                <td style="width: 3%">
                    <input type="number" >
                </td>
                <td style="width: 3%">
                    <input type="number" >
                </td>
            </tr>
        <?php } ?>
        </tbody>
        </thead>
    </table>
<?php } ?>
<?php } else { ?>
Sözleşme Pozlarını tanımlamadan hakediş metrajı yapamazsınız.
    <a href="<?php echo base_url("contract/file_form/$contract->id/boq"); ?>">Buradan Sözleşme Pozu Ekleyiniz</a>
<?php } ?>