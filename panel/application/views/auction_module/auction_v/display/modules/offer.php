<?php if (isset($teklifler->offer)) { ?>
    <?php $teklifler = json_decode($teklifler->offer, true); ?>
    <?php if (isset($teklifler)) { ?>
        <?php foreach ($teklifler as $teklif) {
            $istekliler = array_keys($teklif);
        } ?>
        <div class="col-sm-12 d-none d-sm-block">
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
                    <th>İşlem</th>
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
                                <?php echo money_format($teklif[$istekli]) . " " . $item->para_birimi; ?>
                                <?php $collect[] = $teklif[$istekli]; ?>
                            </td>
                        <?php } ?>
                        <td>
                            <?php echo money_format(max($collect)) . " " . $item->para_birimi; ?>
                        </td>
                        <td>
                            <?php
                            $min_offer = min($collect);
                            echo money_format(min($collect)) . " " . $item->para_birimi; ?>

                        </td>
                        <td>
                            <?php echo two_digits_percantage(1 - min($collect) / max($collect)); ?>
                        </td>
                        <td><a class="btn btn-success active"
                               href="<?php echo base_url("contract/new_form_auction/$item->id/$istekli/$min_offer"); ?>"
                               type="button" title=""
                               data-bs-original-title="<?php echo min($collect); ?> İle Sözleşmeye Çevir">
                                <i class="menu-icon fa fa-check-circle-o"
                                   aria-hidden="true"></i>
                            </a>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
                <tfoot>
                <tr>
                    <?php $collect_total = array(); ?>
                    <?php $deneme = array(); ?>
                    <?php foreach ($teklifler as $teklifs) { ?>
                        <?php foreach ($teklifs as $key => $value) {
                            $deneme[] = $value;
                        } ?>
                    <?php } ?>
                    <td colspan="3" class="bg-info">
                        <strong>En Yüksek Teklif : <?php $a = max($deneme);
                            echo money_format($a) . " " . $item->para_birimi; ?>
                        </strong>
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
                        <strong>En Düşük Teklif
                            : <?php echo money_format(min($deneme)) . " " . $item->para_birimi; ?></strong>
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
        </div>
    <?php } ?>
    <?php if (isset($teklifler)) { ?>
        <?php foreach ($teklifler as $teklif) {
            $istekliler = array_keys($teklif);
        } ?>
        <div class="col-12 d-sm-none">
            <button class="btn btn-pill btn-outline-success" onclick="OfferToExcel('xlsx')"
                    type="button"><i class="fa fa-share-square-o"></i> EXCEL
            </button>
            <table class="table">
                <thead>
                <tr>
                    <th>Firma Adı</th>
                    <th>En Yüksek - En Düşük</th>
                    <th>İşlem</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($istekliler as $istekli) { ?>
                    <tr>
                        <td><?php echo company_name($istekli); ?></td>
                        <?php $collect = array(); ?>
                        <?php foreach ($teklifler as $teklif) { ?>
                            <?php $collect[] = $teklif[$istekli]; ?>
                        <?php } ?>
                        <td>
                            <?php echo money_format(max($collect)) . " " . $item->para_birimi; ?> -
                            <?php
                            $min_offer = min($collect);
                            echo money_format(min($collect)) . " " . $item->para_birimi; ?>
                        </td>
                        <td><a class="btn btn-success active"
                               href="<?php echo base_url("contract/new_form_auction/$item->id/$istekli/$min_offer"); ?>"
                               type="button" title=""
                               data-bs-original-title="<?php echo min($collect); ?> İle Sözleşmeye Çevir">
                                <i class="menu-icon fa fa-check-circle-o"
                                   aria-hidden="true"></i>
                            </a>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
                <tfoot>
                <tr>
                    <?php $collect_total = array(); ?>
                    <?php $deneme = array(); ?>
                    <?php foreach ($teklifler as $teklifs) { ?>
                        <?php foreach ($teklifs as $key => $value) {
                            $deneme[] = $value;
                        } ?>
                    <?php } ?>
                    <td colspan="1" class="bg-info">
                        <strong>En Yüksek Teklif : <?php $a = max($deneme);
                            echo money_format($a) . " " . $item->para_birimi; ?>
                        </strong>
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
                    <td colspan="1" class="bg-success">
                        <strong>En Düşük Teklif
                            : <?php echo money_format(min($deneme)) . " " . $item->para_birimi; ?></strong>
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
        </div>

        <button onclick='document.getElementById("foo").classList.toggle("hide2")'>Click me</button>
    <?php } ?>
<?php } ?>


