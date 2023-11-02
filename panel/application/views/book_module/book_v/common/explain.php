<?php if (isset($item)) { ?>
    <table class="display">
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
                    <div class="col-1"  style="writing-mode: vertical-rl; text-align: center";>
                        <strong>Tarifi</strong>
                    </div>
                    <div class="col-11" style="text-align:justify;">
                        <?php echo $item->tarif; ?>
                    </div>
                </div>
            </td>
        </tr>
        </tbody>
    </table>
<?php } ?>
