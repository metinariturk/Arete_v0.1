<?php
$bugun = date("Y-m-d");
?>
<div class="row">
    <div class="col-6" >
        <?php if (!empty($ymler)) { ?>
            <div class="text-center">
                <h4>Yaklaşık Maliyet</h4>
            </div>
            <div class="row" style="justify-content: center;">
                <?php if (!empty($ymler)) { ?>
                    <table style="width: 80%">
                        <tbody>
                        <?php if (!empty($ymler)) { ?>
                            <?php $groups = array_unique(array_column($ymler, 'ym_grup')); ?>
                            <tr>
                                <th>
                                    <h4>
                                        TOPLAM
                                    </h4>
                                </th>
                                <th>
                                    <h4>
                                        <?php echo money_format(sum_anything("cost", "cost", "auction_id", $item->id)); ?>
                                        <?php echo "$item->para_birimi"; ?>
                                    </h4>
                                </th>
                            </tr>
                            <?php foreach ($groups as $group) { ?>
                                <tr>
                                    <th><?php echo $group; ?></th>
                                    <th>
                                        <?php echo money_format(sum_anything_and("cost", "cost", "ym_grup", "$group", "auction_id", "$item->id")); ?>
                                        <?php echo "$item->para_birimi"; ?>
                                    </th>
                                </tr>
                                <?php foreach ($ymler as $ym) { ?>
                                    <?php if ($group == $ym->ym_grup) { ?>
                                        <tr>
                                            <td><?php echo $ym->ym_ad; ?></td>
                                            <td><?php echo money_format(ceil($ym->cost)); ?>
                                                <?php echo "$item->para_birimi"; ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                <?php } ?>
                            <?php } ?>
                        <?php } ?>
                        </tbody>
                    </table>
                <?php } ?>
            </div>
        <?php } ?>

    </div>
    <div class="col-6">
        <div class="text-center">
            <h4>Maliyet Dağılımı</h4>
        </div>
        <div style="justify-content: center;" id="yaklasik"></div>
    </div>
</div>
