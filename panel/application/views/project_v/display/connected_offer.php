<div class="row content-container">
    <div class="table">
        <table class="display">
            <thead>
            <tr>
                <th>Teklif Adı</th>
                <th>Teklif Bedel</th>
                <th>Teklif Bedeli</th>
            </thead>
            </tr>
            <tbody>
            <?php foreach ($offers as $offer) { ?>
                <?php $offer_price = $offer->sozlesme_bedel; ?>
                <tr>
                    <td>
                        <a href="<?php echo base_url("contract/file_form/$offer->id"); ?>">
                            <?php echo $offer->contract_name; ?>
                        </a>
                    </td>
                    <td style="text-align: right"><?php echo money_format($offer->sozlesme_bedel); ?></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>

