<table class="table tablecenter">
    <tbody class="bg-color-op-purple">
    <?php $supplies = json_decode($item->supplies); ?>
    <?php if ($supplies != null) { ?>
    <tr class="bg-color-op-green">
        <th style="width: 150px"><strong>#</strong></th>
        <th>
            <div class="row">
                <div class="col-sm-3">
                    <b>Malzeme Adı</b>
                </div>
                <div class="col-sm-2">
                    <b>Miktar</b>
                </div>
                <div class="col-sm-2">
                    <b>Birim</b>
                </div>
                <div class="col-sm-5">
                    <b>Açıklama</b>
                </div>
            </div>
        </th>
    </tr>
    <tr class="bg-color-op-green">
        <td style="width: 150px"><strong>Gelen Malzemeler</strong></td>
        <td>
            <?php foreach ($supplies as $supply) { ?>
                <div class="row">
                    <div class="col-sm-3">
                        <?php echo yazim_duzen($supply->supply); ?>
                    </div>
                    <div class="col-sm-2">
                        <?php echo $supply->qty; ?>
                    </div>
                    <div class="col-sm-2">
                        <?php echo $supply->unit; ?>
                    </div>
                    <div class="col-sm-5">
                        <?php echo yazim_duzen($supply->supply_notes); ?>
                    </div>
                </div>
            <?php } ?>
        </td>
    </tr>
    </tbody>
    <?php } else { ?>
        <tr>
            <td style="width: 150px"><strong>Gelen Malzemeler</strong></td>
            <td>Gelen Malzeme Yok</td>
        </tr>
        </tbody>
    <?php } ?>
</table>


