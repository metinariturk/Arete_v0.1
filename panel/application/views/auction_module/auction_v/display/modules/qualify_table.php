<?php

if (!empty($item->yeterlilik)) {
    $yeterlilikler = json_decode($item->yeterlilik, true);
} else {
    $yeterlilikler = array();
}

?>
<div class="row">
    <div class="card-body">
        <h4 class="text-center">İstekli Yeterlilikleri</h4>
        <button class="btn btn-pill btn-outline-success" onclick="QualifyToExcel('xlsx')"
                type="button"><i class="fa fa-share-square-o"></i> EXCEL
        </button>
        <table class="timecard" style="width: 100%;" id="qualify_table">
            <thead>
            <tr style="border-bottom: 1pt solid; border-bottom-color: rgba(107,102,103,0.34); ">
                <th class="text-center">#</th>
                <?php $qualifies = get_as_array($settings->yeterlilik); ?>
                <?php foreach ($qualifies as $qualify) { ?>
                    <th style="writing-mode: vertical-rl; padding-left: -1px; padding-right: -1px; padding-top: -1px; padding-bottom: -1px; ">
                        <?php echo $qualify; ?>
                    </th>
                <?php } ?>

            </tr>
            </thead>
            <tbody>
            <?php foreach ($yeterlilikler as $yeterlilik) { ?>
                <tr>
                    <td style="padding: 15px">
                        <b><?php echo company_name(key($yeterlilik)); ?></b>
                    </td>
                    <?php foreach ($qualifies as $qualify) { ?>
                        <td style="writing-mode: vertical-rl; padding-left: -1px; padding-right: -1px; padding-top: -1px; padding-bottom: -1px;">
                            <?php foreach ($yeterlilik as $array_search) {
                                if (in_array($qualify, array_values($array_search))) { ?>
                                    <b><i style="color: rgba(11,134,215,0.89)!important">✔</i></b>
                                <?php } elseif (!in_array($qualify, array_values($array_search))) { ?>
                                    <b><i style="color: rgba(215,11,28,0.89)!important">✖</i></b>
                                <?php } ?>
                            <?php } ?>
                        </td>
                    <?php } ?>
                </tr>
            <?php } ?>
            </tbody>
        </table>

    </div>
</div>
