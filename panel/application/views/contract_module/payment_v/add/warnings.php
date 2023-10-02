<?php if (empty($payments)) { ?>
    <div class="alert alert-info text-center">
        <p>İlk Hakedişi Düzenlemektesiniz</p>
    </div>
<?php } else { ?>
<div class="alert alert-info text-center">
    <table>
        <thead>
        <tr>
            <th>Hakediş No</th>
            <th>İmalat Tarihi</th>
            <th>Hakediş Bedeli</th>
            <th>Net Ödenen</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($payments as $payment) { ?>
            <tr>
                <td><?php  $payment->hakedis_no; ?></td>
                <td><?php  money_format($payment->bu_imalat_ihzarat)." ".get_currency($contract->id); ?></td>
                <td><?php  $payment->net_bedel; ?></td>
            </tr>
        <?php } ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="2">Toplam Hakediş (İmalat)</th>
                <th colspan="2"><?php  money_format(sum_payments("bu_imalat_ihzarat", $contract->id))." ".get_currency($contract->id); ?></th>
            </tr>
            <tr>
                <th colspan="2">Net Ödenen</th>
                <th colspan="2"><?php  money_format(sum_payments("net_bedel", $contract->id))." ".get_currency($contract->id); ?></th>
            </tr>
        </tfoot>
    </table>
</div>
<?php } ?>
<hr>
<div class="numberlist">
    <hd>Hakediş Esasları</hd>
    <ol>
        <li><b>Son imalat tarihi olarak ayın son gününü seçmeniz önerilir.</b></li>
        <li><b>Hakediş no otomatik olarak artmaktadır.</b></li>
        <li><b>Kesin Hakediş yapıyorsanız kesin hakediş kutucuğunu işareteyiniz.</b></li>
        <li><b>Kesin hakediş yapıldıktan sonra iş ile ilgili yeni hakediş girişi yapamazsınız.</b></li>
    </ol>
    <ol>
        <li><b>Hakediş Kapsamında Fiyat Farkı Ödemesi Yapılmalıdır</b></li>
        <li><b>Sözleşme bilgilerinde KDV miktarı belirtilmemiştir.</b></li>
        <li><b>Sözleşme bilgilerinde KDV Tevkifat Oranı Belirtilmemiştir</b></li>
        <li><b>Hakediş Tutanağı</b></li>
    </ol>
    <ol>
        <li><b>Yapılan avans ödemeleri öncelikle sözleşme kısmına girilmelidir.</b></li>
        <li><b>Avans mahsup oranında özel bir durum yoksa değişiklik yapmayınız.</b></li>
        <li><b>Kesilmesini istemediğiniz vergiler için sözleşme ayarlarında düzenleme yapınız.</b></li>
        <li><b>Hakediş Tutanağı</b></li>
    </ol>
</div>