<div class="widget">
    <div class="widget-body">
        <div class="row content-container">
            <div id="left" class="text-left">
                <a class="pager-btn btn btn-purple btn-outline"
                   href="<?php echo base_url("Sitegroup/select/$item->id"); ?>" target=”_blank”>
                    <i class="fas fa-plus-square"></i>
                    Malzeme Grubu Ekle
                </a>
            </div>
            <div id="right" class="text-right">
                <a class="pager-btn btn btn-purple btn-outline"
                   href="<?php echo base_url("Sitestock/new_form/$item->id"); ?>">
                    <i class="fas fa-plus-square"></i>
                    Yeni Malzeme Girişi
                </a>
            </div>
        </div>
    </div>
    <div class="widget-body">
        <table id="default-datatable" data-plugin="DataTable" class="table table-striped tablecenter"
               style="width: 100%">
            <thead>
            <tr>
                <th>Stok Kodu</th>
                <th>Stok Giriş Tarihi</th>
                <th>Kullanım Yeri</th>
                <th>Ürün Adı</th>
                <th>Gelen Miktar</th>
                <th>Kalan Miktar</th>
                <th>Gelen Tutar</th>
                <th>Kalan Tutar</th>
                <th>Fatura/İrs. No</th>
                <th>Tedarikçi</th>
                <th>Açıklama</th>
                <th>İşlem</th>
            </tr>
            </thead>
            <tbody>

            <?php foreach ($safety_stocks as $safety_stock) { ?>
                <?php $supplies = json_decode($safety_stock->supplies); ?>
                <?php foreach ($supplies as $supply) { ?>
                    <tr>
                        <td><?php echo $safety_stock->dosya_no . " (" . $supply->id . ")"; ?></td>
                        <td><?php echo $safety_stock->arrival_date; ?></td>
                        <td><?php if (!empty($supply->product_group)) {
                                echo group_name($supply->product_group);
                            } else {
                                echo "Genel";
                            } ?> </td>
                        <td><?php echo $supply->product_name; ?></td>
                        <td><?php echo $supply->product_qty . " " . $supply->unit; ?></td>
                        <td><?php $consumes = json_decode($safety_stock->consume); ?>
                            <?php $sum = 0; ?>
                            <?php if (isset($consumes)) { ?>
                                <?php foreach ($consumes as $a) { ?>
                                    <?php if ($a->id == $supply->id) { ?>
                                        <?php $sum += $a->qty; ?>
                                    <?php } ?>
                                <?php } ?>
                            <?php } ?>

                            <?php $kalan = $supply->product_qty - $sum;
                            echo $kalan . " " . $supply->unit; ?>
                        </td>
                        <td><?php echo money_format($supply->price) . " " . $supply->currency; ?></td>
                        <td><?php echo money_format(($supply->price / $supply->product_qty) * $kalan) . " " . $supply->currency; ?></td>
                        <td><?php echo $supply->bill_code; ?></td>
                        <td><?php echo company_name($supply->supplier); ?></td>
                        <td><?php echo $supply->supply_notes; ?></td>
                        <td>
                            <a class="btn btn-info pager-btn"
                               href="<?php echo base_url("sitestock/file_form/$safety_stock->id"); ?>"
                            <span class="m-r-xs"><i class="fas fa-ellipsis-h"></i></span>
                            <span>Detay</span>
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<hr>




