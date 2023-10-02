<?php if (isset($item->offer)) { ?>
    <?php $teklifler = json_decode($item->offer, true); ?>
    <?php $para_birimi = get_from_id("auction", "para_birimi", "$item->auction_id"); ?>
    <?php if (isset($teklifler)) { ?>
        <?php foreach ($teklifler as $teklif) {
            $istekliler = array_keys($teklif);
        } ?>
        <button class="btn btn-pill btn-outline-success" onclick="OfferToExcel('xlsx')"
                type="button"><i class="fa fa-share-square-o"></i> EXCEL
        </button>
        <table class="table" id="offer_table">
            <thead>
            <tr>
                <th style="width: 150px;">Firma Adı</th>
                                   <?php $i = 0; ?>
                    <?php foreach ($teklifler as $key) { ?>
                        <?php $x = $i++; ?>
                        <th <?php if (($x > 1) and ($x < (count($teklifler)-2))){echo "class='d-none'";} ?> ><?php echo $x+1; ?>. Teklif</th>
                    <?php } ?>
                <th>En Yüksek</th>
                <th>En Düşük</th>
                <th>Tenzilat</th>
                <th>Teklif Dosyası</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($istekliler as $istekli) { ?>
                <tr>
                    <td><?php echo company_name($istekli); ?></td>
                     <?php $j = 0; ?>
                        <?php foreach ($teklifler as $teklif) { ?>
                            <?php $y = $j++; ?>
                            <td <?php if (($y > 1) and ($y < (count($teklifler)-2))){echo "class='d-none'";} ?> >
                                <?php echo money_format($teklif[$istekli]) . " " . $para_birimi; ?>
                                <?php $collect[] = $teklif[$istekli]; ?>
                            </td>
                        <?php } ?>
                    <td>
                        <?php echo money_format(max($collect)) . " " . $para_birimi; ?>
                    </td>
                    <td>
                        <?php echo money_format(min($collect)) . " " . $para_birimi; ?>
                    </td>
                    <td>
                        <?php echo two_digits_percantage(1 - min($collect) / max($collect)); ?>
                    </td>
                    <td>
                        <div data-url="<?php echo base_url("$this->Module_Name/refresh_file_list/$item->id"); ?>"
                             action="<?php echo base_url("$this->Module_Name/file_upload/$item->id/$istekli"); ?>" id="dropzone" class="dropzone"
                             data-plugin="dropzone" style="width: 150px; height: 150px"
                             data-options="{ url: '<?php echo base_url("$this->Module_Name/file_upload/$item->id/$istekli"); ?>'}">
                                <b><span>Teklif Dosyası</span></b>
                        </div>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
            <tfoot>
            <tr>
                <?php $collect_total = array(); ?>
                <?php $deneme = array(); ?>
                <?php $denememe = array(); ?>
                <?php foreach ($teklifler as $teklifs) { ?>
                    <?php foreach ($teklifs as $key => $value) {
                        $deneme[] = $value;
                    } ?>
                <?php } ?>
                <td colspan="3" class="bg-info">
                    <strong>En Yüksek Teklif : <?php $a = max($deneme);
                        echo money_format($a) . " " . $para_birimi; ?></strong>
                </td>
                <td colspan="<?php echo count($teklifler) + 1; ?>">
                    <h5>
                        <?php foreach ($teklifler as $teklifs) { ?>
                            <?php $higest_search = array_keys($teklifs, max($deneme)); ?>
                            <?php if (!empty($higest_search)) {
                                echo company_name($higest_search[0]);
                            } ?>
                        <?php } ?>
                    </h5>
                </td>
            </tr>
            <tr>
                <td colspan="3" class="bg-success">
                    <strong>En Düşük Teklif : <?php echo money_format(min($deneme)) . " " . $para_birimi; ?></strong>
                </td>
                <td colspan="<?php echo count($teklifler) + 1; ?>">
                    <h5>
                        <?php foreach ($teklifler as $teklifs) { ?>
                            <?php $lowest_search = array_keys($teklifs, min($deneme)); ?>
                            <?php if (!empty($lowest_search)) {
                                echo company_name($lowest_search[0]);
                            } ?>
                        <?php } ?>
                    </h5>
                </td>
            </tr>
            </tfoot>
        </table>
    <?php } ?>
<?php } ?>


