<?php if (!empty($item->aciklama)) { ?>
    <div class="content">
        <table style="width:100%;">
            <thead>
            <tr>
                <th>
                    <p style="font-size:15pt;">
                        <strong>Genel Notlar</strong></p>
                </th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td class="total-group-row-left">
                    <?php echo $item->aciklama; ?>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
<?php } else { ?>
    <div class="content">
        <table style="width:100%;">
            <thead>
            <tr>
                <th colspan="4">
                    <p style="font-size:15pt;"><strong>Genel Not Yok</strong></p>
                </th>
            </tr>
            </thead>
        </table>
    </div>
<?php } ?>