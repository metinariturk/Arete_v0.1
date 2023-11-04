<?php if (isset($detail)) { ?>
    <table class="table table-sm">
        <thead>
        <tr>
            <th colspan="2" style="text-align: center">
                <?php echo $book->book_name; ?>.<?php echo $main->main_code; ?>.<?php echo $sub->sub_code; ?>
                .<?php echo $title->title_code; ?>.<?php echo $detail->item_code; ?> - <?php echo $detail->item_name; ?>
                - <?php echo $detail->item_unit; ?>
            </th>
        </tr>
        <tr>
            <th colspan="2" style="text-align: center">
                Yaklaşık Birim Fiyatı : <?php echo $detail->item_price; ?> TL (<?php echo $book->book_year; ?>)
            </th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td style="width: 10%">
                Tarifi
            </td>
            <td>
                <?php echo $detail->item_explain; ?>
            </td>
        </tr>
        </tbody>
    </table>

<?php } ?>
