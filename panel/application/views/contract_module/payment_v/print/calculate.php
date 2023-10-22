<?php foreach ($active_boqs as $group_key => $boq_ids): ?>
    <?php $group_name = boq_name($group_key); ?>
    <?php foreach ($boq_ids as $boq_id): ?>
        <?php foreach ($calculates as $calculation_item): ?>
            <?php if ($calculation_item->boq_id == $boq_id): ?>
                <button class="page-break-button" onclick="togglePageBreak(this)">Bölümü Ayır</button>
                <table style="width:100%;">
                    <thead>
                    <tr>
                        <td colspan="7">
                            <p style="margin-top:3pt; margin-bottom:3pt; widows:0; orphans:0; font-size:10pt;">
                                <strong><?php echo $group_name; ?></strong>asd
                            </p>
                        </td>
                    </tr>
                    </thead>
                </table>
            <?php endif; ?>
        <?php break; endforeach; ?>
    <?php endforeach; ?>
    <?php foreach ($boq_ids as $boq_id): ?>
        <?php foreach ($calculates as $calculation_item): ?>
            <?php if ($calculation_item->boq_id == $boq_id): ?>
                <button class="page-break-button" onclick="togglePageBreak(this)">Tabloyu Ayır</button>
                <table style="width:100%;">
                    <thead>
                    <tr>
                        <td colspan="7">
                            <p style="margin:3pt 2.85pt; page-break-inside:avoid; page-break-after:avoid; widows:0; orphans:0; font-size:9pt;">
                                <strong><?php echo boq_name($boq_id) . " " . boq_unit($boq_id); ?></strong>
                            </p>
                        </td>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $calculation_datas = json_decode($calculation_item->calculation, true); ?>
                    <tr style="height:14.1pt;">
                        <td style="width:10%; background-color:#e7e7e7; text-align: center">
                            <p><strong>Bölüm</strong></p>
                        </td>
                        <td style="width:40%; background-color:#e7e7e7; text-align: center">
                            <p><strong>Açıklama</strong></p>
                        </td>
                        <td style="width:8%; background-color:#e7e7e7; text-align: center">
                            <p><strong>Adet</strong></p>
                        </td>
                        <td style="width:8%; background-color:#e7e7e7; text-align: center">
                            <p><strong>En</strong></p>
                        </td>
                        <td style="width:8%; background-color:#e7e7e7; text-align: center">
                            <p><strong>Boy</strong></p>
                        </td>
                        <td style="width:8%; background-color:#e7e7e7; text-align: center">
                            <p><strong>Yükseklik</strong></p>
                        </td>
                        <td style="width:18%; background-color:#e7e7e7; text-align: center">
                            <p><strong>Toplam</strong>
                        </td>
                    </tr>
                    <?php foreach ($calculation_datas as $calculation_data): ?>
                        <tr>
                            <td style="border-style:solid; text-align:left; border-width:0.75pt;">
                                <?php echo $calculation_data["s"]; ?>
                            </td>
                            <td style="border-style:solid; border-width:0.75pt; text-align:left; font-size:9pt;">
                                <?php echo $calculation_data["n"]; ?>
                            </td>
                            <td style="border-style:solid; border-width:0.75pt; text-align:right; font-size:9pt;">
                                <?php echo money_format($calculation_data["q"]); ?>
                            </td>
                            <td style="border-style:solid; border-width:0.75pt; text-align:right; font-size:9pt;">
                                <?php echo money_format($calculation_data["w"]); ?>
                            </td>
                            <td style="border-style:solid; border-width:0.75pt; text-align:right; font-size:9pt;">
                                <?php echo money_format($calculation_data["h"]); ?>
                            </td>
                            <td style="border-style:solid; border-width:0.75pt; text-align:right; font-size:9pt;">
                                <?php echo money_format($calculation_data["l"]); ?>
                            </td>
                            <td style="border-style:solid; border-width:0.75pt; text-align:right; font-size:9pt;">
                                <?php echo money_format($calculation_data["t"]); ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td colspan="5"></td>
                        <td style="border-style:solid; border-width:0.75pt; text-align:right; font-size:9pt;">
                            <strong>Toplam</strong>
                        </td>
                        <td style="border-style:solid; border-width:0.75pt; text-align:right; font-size:9pt;">
                            <strong><?php echo $calculation_item->total; ?></strong>
                        </td>
                    </tr>
                    </tbody>
                </table>
            <?php endif; ?>
        <?php endforeach; ?>
    <?php endforeach; ?>
<?php endforeach; ?>
<a href="<?php echo base_url("payment/export_pdf"); ?>" target="_blank" class="btn">PDF İndir</a>
