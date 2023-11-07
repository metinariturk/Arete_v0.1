Yadaki listede poz isimlerine çift tıklayarak poz ekleyiniz
<table class="table table-striped active_group" group-id="<?php echo $sub_id; ?>">
    <tbody>
    <?php foreach ($sub_cont_items as $sub_cont_item) { ?>
        <tr>
            <td  style="padding-left: 40px;">
                <?php echo $sub_cont_item->item_id; ?>
            </td>
        </tr>
    <?php } ?>
    </tbody>
</table>
