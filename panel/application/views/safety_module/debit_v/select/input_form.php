<table class="table">
    <tbody>
    <tr>
        <td>
            <select id="select2-demo-1" class="form-control col-sm-12"
                    required data-plugin="select2" name="auction_id">
                <option value=""></option>
                <?php foreach ($prep_auctions as $prep_auction) { ?>
                    <option value="<?php echo $prep_auction->id; ?>"><?php echo $prep_auction->ihale_ad; ?></option>
                <?php } ?>
            </select>
        </td>
    </tr>
    <tr>
        <td>
            <small class="pull-left input-form-error"> Sadece aktif durumda olan işler
                listelenir. Projenizi listede bulamıyorsanız Projeler listesi üzerinde
                ilgili işi "Devam Ediyor" olarak değiştirmeniz gerekmektedir.</small>
        </td>
    </tr>
    </tbody>
</table>
