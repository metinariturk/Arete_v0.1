
<div class="col-sm-12">
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="display" id="basic-1">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>İhale Adı</th>
                        <th>Teklif Verenler</th>
                        <th>En Düşük Teklif</th>
                        <th>En Yüksek Teklif</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($items as $item) { ?>
                        <?php $para_birimi = get_from_id("auction","para_birimi","$item->auction_id"); ?>

                        <tr>
                            <td><?php echo $item->id; ?></td>
                            <td>
                                <a href="<?php echo base_url("$this->Module_Name/file_form/$item->id"); ?>">
                                    <?php echo get_from_id("auction", "ihale_ad", $item->auction_id); ?>
                                </a>
                            </td>
                            <td>
                                <?php $istekliler = json_decode(get_from_id("auction","istekliler","$item->auction_id")); ?>

                                <?php foreach ($istekliler as $istekli) {
                                    echo company_name($istekli)."<br>";
                                } ?>
                            </td>
                            <?php $teklifler = json_decode($item->offer, true); ?>
                            <td>
                                <?php $deneme = array(); ?>
                                <?php foreach ($teklifler as $teklifs) { ?>
                                    <?php foreach ($teklifs as $key => $value) {
                                        $deneme[] = $value;
                                    } ?>
                                <?php } ?>
                                <?php foreach ($teklifler as $teklifs) { ?>
                                    <?php $lowest_search = array_keys($teklifs, min($deneme)); ?>
                                    <?php if (!empty($lowest_search)) {
                                        echo company_name($lowest_search[0]);
                                    } ?>
                                <?php } ?>
                                <br>
                                <?php echo money_format(min($deneme)) . " " . $para_birimi; ?>
                            </td>
                            <td>
                                <?php foreach ($teklifler as $teklifs) { ?>
                                    <?php $higest_search = array_keys($teklifs, max($deneme)); ?>
                                    <?php if (!empty($higest_search)) {
                                        echo company_name($higest_search[0]);
                                    } ?>
                                <?php } ?>
                                <br>
                                <?php echo money_format(max($deneme)) . " " . $para_birimi; ?>
                            </td>
                        </tr>
                    <?php } ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>




