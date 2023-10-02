<?php
$total_price = 0;
$total_consume_price = 0;

foreach ($site_stocks as $site_stock) {
    $total_price += array_sum(array_column(json_decode($site_stock->supplies, true), 'price'));

    if (!empty($site_stock->consume)) {
        $consume_data = json_decode($site_stock->consume, true);
        $total_consume_price += array_sum(array_map(function ($consume) {
            return $consume['price'] * $consume['product_qty'];
        }, $consume_data));
    }
}

?>
<div class="col-sm-12">
    <div class="card-body">
        <div class="row " id="ozet">
            <div class="col-12 d-flex justify-content-center align-items-center">
                <div class="col-sm-12 col-lg-6 text-left">
                    <div class="row">
                        <div class="col-6" id="baslik">
                            Toplam Gelen Malzeme Değeri
                        </div>
                        <div class="col-1" id="isaret">
                            :
                        </div>
                        <div class="col-5" id="para">
                            <?php echo money_format($total_price); ?> TL
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6" id="baslik">
                            Kullanılan Stok Değeri
                        </div>
                        <div class="col-1" id="isaret">
                            :
                        </div>
                        <div class="col-5" id="para">
                            <?php echo money_format($total_consume_price); ?> TL
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6" id="baslik">
                            Kalan Stok Değeri
                        </div>
                        <div class="col-1" id="isaret">
                            :
                        </div>
                        <div class="col-5" id="para">
                            <?php echo money_format($total_price - $total_consume_price); ?> TL
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-sm-12">
    <div class="card">
        <div class="card-header">
            Depo Kalan Malzemeler
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <input type="text" class="form-control" id="searchInput" placeholder="Arama Yapın...">
                <table id="myTable" class="table">
                    <thead>
                    <tr>
                        <th>Dosya No</th>
                        <th>Malzeme Adı</th>
                        <th>Miktar</th>
                        <th>Bedel</th>
                        <th>Teslim Günü</th>
                        <th>İrsaliye/Fatura No</th>
                        <th>Kalan</th>
                        <th>Kalan Bedel</th>
                        <th>Görüntüle</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $total_remain_all = 0; ?>

                    <?php foreach ($site_stocks as $site_stock) { ?>

                        <?php $supplies_array = json_decode($site_stock->supplies, true); ?>

                        <?php foreach ($supplies_array as $supplies_single) { ?>
                            <?php $totalQty = 0; ?>
                            <?php if (!empty($site_stock->consume)) { ?>
                                <?php foreach ((json_decode($site_stock->consume)) as $stock_consume) { ?>
                                    <?php if ($stock_consume->id == $supplies_single['id']) { ?>
                                        <?php $totalQty += $stock_consume->product_qty; ?>
                                    <?php } ?>
                                <?php } ?>
                            <?php } ?>
                            <?php $total_remain = ($supplies_single['product_qty'] - $totalQty) * ($supplies_single['price'] / $supplies_single['product_qty']); ?>
                            <?php if ($total_remain > 0) { ?>
                                <tr onclick="showrow(this)"
                                    id="<?php echo $site_stock->id . "-" . $supplies_single['id']; ?>">
                                    <td><?php echo $site_stock->dosya_no; ?></td>
                                    <td><?php echo $supplies_single['product_name']; ?></td>
                                    <td><?php echo $supplies_single['product_qty'] . " " . $supplies_single['unit']; ?></td>
                                    <td><?php echo money_format($supplies_single['price']); ?> TL</td>
                                    <td><?php echo dateFormat_dmy($site_stock->arrival_date); ?></td>
                                    <td><?php echo $supplies_single['bill_code']; ?></td>
                                    <td><?php echo ($supplies_single['product_qty'] - $totalQty) . " " . $supplies_single['unit']; ?></td>
                                    <td><?php $total_remain = ($supplies_single['product_qty'] - $totalQty) * ($supplies_single['price'] / $supplies_single['product_qty']); ?>
                                        <?php $total_remain_all += $total_remain; ?>
                                        <?php echo money_format($total_remain); ?> TL
                                    </td>
                                    <td style="text-align: center">
                                        <a href="<?php echo base_url("sitestock/file_form/$site_stock->id"); ?>">
                                            <span><i class="fas fa-ellipsis-h fa-2x"></i></span>
                                        </a>
                                    </td>
                                </tr>


                                <?php $remain_qty = $supplies_single['product_qty']; ?>
                                <?php if (!empty($site_stock->consume)) { ?>
                                    <?php foreach (json_decode($site_stock->consume) as $stock_consume) { ?>
                                        <?php if ($stock_consume->id == $supplies_single['id']) { ?>
                                            <?php $remain_qty -= $stock_consume->product_qty; ?>
                                            <tr id="outcome-<?php echo $site_stock->id . "-" . $supplies_single['id']; ?>"
                                                style="display: none; font-size: 12px; ">
                                                <td></td>
                                                <td>Çıkış</td>
                                                <td>
                                                    -<?php echo $stock_consume->product_qty . " " . $supplies_single['unit']; ?></td>
                                                <td>
                                                    -<?php echo money_format($stock_consume->product_qty * $stock_consume->price); ?></td>
                                                <td><?php echo $stock_consume->date; ?></td>
                                                <td><?php echo $stock_consume->supply_notes; ?></td>
                                                <td><?php echo $remain_qty . " " . $supplies_single['unit']; ?></td>
                                                <td><?php echo money_format($remain_qty * $stock_consume->price); ?>
                                                    TL
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    <?php } ?>
                                <?php } ?>
                            <?php } ?>
                        <?php } ?>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            Depo Biten Malzemeler
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <input type="text" id="searchInput_over" class="form-control" placeholder="Arama Yapın...">
                <table id="myTable_over" class="table">
                    <thead>
                    <tr>
                        <th>Dosya No</th>
                        <th>Malzeme Adı</th>
                        <th>Miktar</th>
                        <th>Bedel</th>
                        <th>Teslim Günü</th>
                        <th>İrsaliye/Fatura No</th>
                        <th>Kalan</th>
                        <th>Kalan Bedel</th>
                        <th>Görüntüle</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $total_remain_all = 0; ?>

                    <?php foreach ($site_stocks as $site_stock) { ?>

                        <?php $supplies_array = json_decode($site_stock->supplies, true); ?>

                        <?php foreach ($supplies_array as $supplies_single) { ?>
                            <?php $totalQty = 0; ?>
                            <?php if (!empty($site_stock->consume)) { ?>
                                <?php foreach ((json_decode($site_stock->consume)) as $stock_consume) { ?>
                                    <?php if ($stock_consume->id == $supplies_single['id']) { ?>
                                        <?php $totalQty += $stock_consume->product_qty; ?>
                                    <?php } ?>
                                <?php } ?>
                            <?php } ?>
                            <?php $total_remain = ($supplies_single['product_qty'] - $totalQty) * ($supplies_single['price'] / $supplies_single['product_qty']); ?>
                            <?php if ($total_remain <= 0) { ?>
                                <tr onclick="showrow_over(this)"
                                    id="<?php echo $site_stock->id . "-" . $supplies_single['id']; ?>">
                                    <td><?php echo $site_stock->dosya_no; ?></td>
                                    <td><?php echo $supplies_single['product_name']; ?></td>
                                    <td><?php echo $supplies_single['product_qty'] . " " . $supplies_single['unit']; ?></td>
                                    <td><?php echo money_format($supplies_single['price']); ?> TL</td>
                                    <td><?php echo dateFormat_dmy($site_stock->arrival_date); ?></td>
                                    <td><?php echo $supplies_single['bill_code']; ?></td>
                                    <td><?php echo ($supplies_single['product_qty'] - $totalQty) . " " . $supplies_single['unit']; ?></td>
                                    <td><?php $total_remain = ($supplies_single['product_qty'] - $totalQty) * ($supplies_single['price'] / $supplies_single['product_qty']); ?>
                                        <?php $total_remain_all += $total_remain; ?>
                                        <?php echo money_format($total_remain); ?> TL
                                    </td>
                                    <td style="position: center">asd
                                        <a href="<?php echo base_url("sitestock/file_form/$site_stock->id"); ?>">
                                            <span><i class="fas fa-ellipsis-h"></i></span>
                                        </a>
                                    </td>
                                </tr>

                                <?php $remain_qty = $supplies_single['product_qty']; ?>
                                <?php if (!empty($site_stock->consume)) { ?>
                                    <?php foreach (json_decode($site_stock->consume) as $stock_consume) { ?>
                                        <?php if ($stock_consume->id == $supplies_single['id']) { ?>
                                            <?php $remain_qty -= $stock_consume->product_qty; ?>
                                            <tr id="over-<?php echo $site_stock->id . "-" . $supplies_single['id']; ?>"
                                                style="display: none; font-size: 12px; ">
                                                <td></td>
                                                <td>Çıkış</td>
                                                <td>
                                                    -<?php echo $stock_consume->product_qty . " " . $supplies_single['unit']; ?></td>
                                                <td>
                                                    -<?php echo money_format($stock_consume->product_qty * $stock_consume->price); ?></td>
                                                <td><?php echo $stock_consume->date; ?></td>
                                                <td><?php echo $stock_consume->supply_notes; ?></td>
                                                <td><?php echo $remain_qty . " " . $supplies_single['unit']; ?></td>
                                                <td><?php echo money_format($remain_qty * $stock_consume->price); ?>
                                                    TL
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    <?php } ?>
                                <?php } ?>
                            <?php } ?>
                        <?php } ?>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


