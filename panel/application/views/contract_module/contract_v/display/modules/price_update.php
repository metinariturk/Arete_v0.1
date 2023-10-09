<?php
$active_boqs = json_decode($item->active_boq, true);
?>

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

            <?php if (isset($active_boqs)) { ?>
            <?php foreach ($active_boqs as $active_group => $boqs) : ?>
            <tr>
                <th colspan="5"><?php echo boq_name($active_group); ?></th>
            </tr>
            <tr>
                <th>Poz ID</th>
                <th>Poz Adı</th>
                <th>Sözleşme Miktarı</th>
                <th>Fiyat</th>
                <th>Toplam Tutar</th>
            </tr>
            <?php foreach ($boqs as $boq) : ?>
            <tr>
                <td>
                    <div class="boq-name"><a href="#"> <?php echo $boq; ?></a></div>
                </td>
                <td>
                    <div class="boq-name"><a href="#"> <?php echo boq_name($boq); ?></a></div>
                </td>
                <td class="text-center">
                    <div class="input-group">
                        <input disabled id="<?php echo $boq; ?>_qty"
                               name="boq[<?php echo $active_group; ?>][<?php echo $boq; ?>][qty]"
                               class="form-control btn-square" placeholder="Miktar" type="text">
                        <span class="input-group-text btn btn-primary btn-right"><?php echo boq_unit($boq); ?></span>
                    </div>
                </td>
                <td class="text-center">
                    <div class="input-group">
                        <input disabled id="<?php echo $boq; ?>_price"
                               name="boq[<?php echo $active_group; ?>][<?php echo $boq; ?>][price]"
                               class="form-control btn-square" placeholder="Tutar" type="text">
                        <span class="input-group-text btn btn-primary btn-right"><?php echo $item->para_birimi; ?></span>
                    </div>
                </td>
                <td class="text-center">
                    <div class="input-group">
                        <input id="<?php echo $boq; ?>_total" disabled
                               name="boq[<?php echo $active_group; ?>][<?php echo $boq; ?>][total]"
                               class="form-control btn-square" placeholder="Toplam" type="text">
                        <span class="input-group-text btn btn-primary btn-right"><?php echo $item->para_birimi; ?></span>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php endforeach; ?>
            <?php } ?>
            </tbody>
        </table>
    </div>
    <input type="submit" value="Kaydet">
</form>
