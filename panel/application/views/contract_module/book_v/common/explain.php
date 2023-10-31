<?php if (isset($item)) { ?>
    <table class="table" style="font-size: 11px">
        <thead>
        <tr>
            <th colspan="2">
                <?php echo $item->poz_no; ?>
            </th>
        </tr>
        <tr>
            <th>
                <?php echo $item->name; ?>
            </th>
            <th style="  text-align: center; vertical-align: top; ">
                <?php echo $item->unit; ?>
            </th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>
                <div class="row">
                    <div class="col-1"  style="transform: rotate(90deg)";>
                        Tarifi
                    </div>
                    <div class="col-11">
                        <?php echo $item->tarif; ?>
                    </div>
                </div>
            </td>
        </tr>
        </tbody>
    </table>
<?php } ?>
