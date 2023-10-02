
<div class="row">
    <div class="col-sm-4 text-left">
        <table class="table">
            <tbody>
            <tr>
                <td>İlk Stok Değeri</td>
                <td> : <?php
                    $totalPrice = 0;
                    foreach (json_decode($item->supplies) as $supply) {
                        $totalPrice += $supply->price;
                    }
                    echo money_format($totalPrice);
                    ?></td>
                <td>TL</td>
            </tr>
            <tr>
                <td>Kullanılan Stok Değeri</td>
                <td> :
                    <?php if (!empty(json_decode($item->consume))) {
                        $total_use = 0;
                        foreach (json_decode($item->consume) as $consume_supply) {
                            $total_use += $consume_supply->price * $consume_supply->product_qty;
                        }
                        echo money_format($total_use);
                    }
                    ?>
                </td>
                <td>TL</td>
            </tr>
            <tr>
                <td>Kalan Stok Değeri</td>
                <td> : <?php if (!empty(json_decode($item->consume))) {
                        echo money_format($totalPrice - $total_use);
                    } else {
                        echo money_format($totalPrice);
                    }
                    ?></td>
                <td>TL</td>
            </tr>
            </tbody>
        </table>
    </div>
    <div class="col-sm-4 text-center"> <p style="font-size:25px" class="text-center"><?php echo site_name($site->id); ?></p>
        <p style="font-size:20px" class="text-center">Stok Kartı</p></div>
    <div class="col-sm-4" style="text-align: right !important;"><?php echo dateFormat_dmy($item->arrival_date); ?></div>
</div>

