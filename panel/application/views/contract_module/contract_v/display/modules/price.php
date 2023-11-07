
<form id="save_price" action="<?php echo base_url("$this->Module_Name/save_price/$item->id"); ?>" method="post"
      enctype="multipart/form-data" autocomplete="off">


    <div class="order-history table-responsive wishlist">
        <table class="table table-bordered" id="contract_price">
            <thead>

            <tr>
                <td colspan="4">

                </td>
            </tr>
            <tr>
                <th colspan="6">
                    <div class="row">
                        <div class="col-12">
                            Sözleşme Pozları
                        </div>
                        <div class="media-body col-12 text-center icon-state switch-outline">
                            <label class="switch">
                                <input class="isActive" type="checkbox" name="notice" id="toggleCheckbox">
                                <span class="switch-state bg-primary"></span>
                            </label>
                        </div>
                    </div>

                    <div class="col-12 text-center">
                        <div class="media-body input-group">
                            <input id="total_contract" disabled name="appendedtext" class="form-control btn-square"
                                   placeholder="Toplam" type="text">
                            <span class="input-group-text btn btn-primary btn-right"><?php echo $item->para_birimi; ?></span>
                        </div>
                    </div>
                </th>
            </tr>
            </thead>
            <tbody>


            </tbody>
        </table>
    </div>
    <input type="submit" value="Kaydet">
</form>