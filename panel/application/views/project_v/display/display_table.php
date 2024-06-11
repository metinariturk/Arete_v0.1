<table class="table">
    <tbody>
    <tr>
        <td class="w30">İşin Durumu</td>
        <td>
            <?php echo project_cond($item->durumu); ?>
        </td>
    </tr>
    <tr>
        <td>Genel Açıklama - Kapsam</td>
        <td>
            <?php echo $item->notes; ?>
        </td>
    </tr>
    </tbody>
</table>