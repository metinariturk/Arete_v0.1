<?php if (isset($item)) { ?>
    <table class="table table-responsive-sm">
        <thead>
        <tr>
            <th>Poz No</th>
            <th>
                <?php echo $item->id; ?> - <?php echo $item->name; ?> - <?php echo $item->unit; ?>
            </th>
        </tr>
        <tr>
            <th colspan="2">Tarifi</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td colspan="2"><?php echo $item->tarif; ?></td>
        </tr>
        </tbody>
    </table>
<?php } ?>
