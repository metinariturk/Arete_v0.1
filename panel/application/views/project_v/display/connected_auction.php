<div class="row content-container">
    <table class="table table-bordered table-striped table-hover pictures_list">
        <thead>
        <th>#id</th>
        <th>İhale Adı</th>
        <th>Yaklaşık Maliyet</th>
        <th>İhale Tarihi</th>
        </thead>
        <tbody>
        <?php
        foreach ($prep_auctions as $prep_auction) { ?>
            <tr>
                <td><?php echo $prep_auction->id; ?></td>
                <td>
                    <?php $yetkili = get_as_array(get_from_id("auction", "yetkili_personeller", "$prep_auction->id"));
                    if ((in_array(active_user_id(), $yetkili))  or isAdmin()) { ?>
                        <a href="<?php echo base_url("auction/file_form/$prep_auction->id"); ?>"><?php echo $prep_auction->ihale_ad; ?></a>
                    <?php } else { ?>
                        <?php echo $prep_auction->ihale_ad; ?>
                    <?php } ?>
                </td>
                <td><?php echo money_format(sum_anything("cost", "cost", "auction_id", "$prep_auction->id")) . " " . $prep_auction->para_birimi; ?>
                <td><?php echo dateFormat_dmy($prep_auction->talep_tarih); ?>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>
