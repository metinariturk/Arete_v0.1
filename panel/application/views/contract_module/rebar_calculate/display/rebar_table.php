<?php
// Bu view dosyası HTML tablo içeriğini input alanlarıyla oluşturacak.

if (!empty($error_message)) : ?>
    <div class="error"><?php echo html_escape($error_message); ?></div>
<?php endif; ?>

    <h3>"<?php echo html_escape($file_name); ?>" Dosyası İçeriği</h3>



<?php if (!empty($csv_data_for_table)) : ?>
    <h3>Ayrıştırılmış Tablo Verileri (Toplam <?php echo count($csv_data_for_table); ?> satır)</h3>



    <form id="csvDataForm">
        <table border="1">
            <thead>
            <tr>
                <?php foreach ($csv_header_for_table as $colName) : ?>
                    <th><?php echo html_escape($colName); ?></th>
                <?php endforeach; ?>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($csv_data_for_table as $rowIndex => $rowData) : ?>
                <tr class="<?php echo ($rowData['is_qty_missing'] || $rowData['is_r_missing'] || $rowData['is_l_missing']) ? 'missing-data-row' : ''; ?>">
                    <td>
                        <input
                                type="text"
                                name="rows[<?php echo $rowIndex; ?>][raw_combined]"
                                value="<?php echo html_escape($rowData['raw_combined']); ?>"
                                style="width: 100%; box-sizing: border-box;"
                                readonly
                        >
                    </td>
                    <td>
                        <input
                                type="text"
                                name="rows[<?php echo $rowIndex; ?>][n]"
                                value="<?php echo html_escape($rowData['n']); ?>"
                                style="width: 100%; box-sizing: border-box;"
                        >
                    </td>
                    <td>
                        <input
                                type="text"
                                name="rows[<?php echo $rowIndex; ?>][qty]"
                                value="<?php echo html_escape($rowData['qty']); ?>"
                                style="width: 100%; box-sizing: border-box;"
                                class="<?php echo $rowData['is_qty_missing'] ? 'missing-qty' : ''; ?>"
                        >
                    </td>
                    <td>
                        <input
                                type="text"
                                name="rows[<?php echo $rowIndex; ?>][r]"
                                value="<?php echo html_escape($rowData['r']); ?>"
                                style="width: 100%; box-sizing: border-box;"
                                class="<?php echo $rowData['is_r_missing'] ? 'missing-r' : ''; ?>"
                        >
                    </td>
                    <td>
                        <input
                                type="text"
                                name="rows[<?php echo $rowIndex; ?>][l]"
                                value="<?php echo html_escape($rowData['l']); ?>"
                                style="width: 100%; box-sizing: border-box;"
                                class="<?php echo $rowData['is_l_missing'] ? 'missing-l' : ''; ?>"
                        >
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <br>
        <button type="button" id="processCsvData" style="background-color: #007bff; color: white; padding: 10px 15px; border: none; border-radius: 4px; cursor: pointer;">Verileri İşle (JSON Gönder)</button>
    </form>
<?php else : ?>
    <p>Ayrıştırılmış tablo verisi bulunamadı veya dosya işlenirken hata oluştu.</p>
<?php endif; ?>