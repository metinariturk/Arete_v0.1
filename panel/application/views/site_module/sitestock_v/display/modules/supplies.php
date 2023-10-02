<?php $supplies = json_decode($item->supplies); ?>

<form id="extraction"
      action="<?php echo base_url("$this->Module_Name/save_consume/$item->id"); ?>" method="post"
      enctype="multipart/form-data" autocomplete="off">
    <div class="row">
        <?php if ($supplies != null) { ?>
            <?php foreach ($supplies as $supply) { ?>
                <div class="col-lg-12 col-xl-6 card-body">
                    <div class="row text-center" style="background: #d7e1ea; padding: 10px; border-radius: 10px;">
                        <div class="col-12">
                            <h4><?php echo $supply->id; ?> - <?php echo $supply->product_name ?>
                                - <?php echo company_name($supply->supplier); ?></h4>
                            <h5><?php echo group_name($supply->workgroup); ?> - <?php echo $supply->place; ?>
                                - <?php echo $supply->bill_code; ?></h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 ">
                            <hr>
                            <div class="row" style="font-weight: bold">
                                <div class="col-3 text-center">
                                    <span><i class="fa-solid fa-plus" style="color: green"></i></span>
                                    <span><?php echo number_format($supply->product_qty, "2"); ?></span>
                                    <span><?php echo $supply->unit; ?></span>
                                </div>
                                <div class="col-3 text-left">
                                    <span><?php echo money_format($supply->price); ?></span>
                                    <span>TL</span>
                                </div>
                                <div class="col-3">
                                    <?php echo dateFormat_dmy($item->arrival_date); ?>
                                </div>
                                <div class="col-3">
                                    <?php echo $supply->supply_notes; ?>
                                </div>
                            </div>
                            <?php if (!empty($item->consume)) { ?>
                                <?php $totalQty = 0; ?>
                                <?php foreach (json_decode($item->consume) as $consume_supply) { ?>
                                    <?php if ($supply->id == $consume_supply->id) { ?>
                                        <?php $totalQty += $consume_supply->product_qty; ?>
                                        <div class="row">
                                            <div class="col-3 text-center">
                                                <span><i class="fa-solid fa-minus" style="color: tomato"></i></span>
                                                <span><?php echo number_format($consume_supply->product_qty, "2"); ?></span>
                                                <span><?php echo $supply->unit; ?></span>
                                            </div>
                                            <div class="col-3 text-right">
                                                <span><?php echo money_format(($supply->price / $supply->product_qty) * $consume_supply->product_qty); ?></span>
                                                <span>TL</span>
                                            </div>
                                            <div class="col-3">
                                                <?php echo $consume_supply->date; ?>
                                            </div>
                                            <div class="col-3">
                                                <?php echo $consume_supply->supply_notes; ?>
                                            </div>
                                        </div>
                                    <?php } ?>
                                <?php } ?>
                                <div class="row" style="background: #ead7da; padding: 5px; border-radius: 10px;">
                                    <div class="col-3 text-center">
                                        <span><i class="fa-solid fa-plus-minus" style="color: grey"></i></span>
                                        <span><?php echo number_format(($supply->product_qty - $totalQty), "2"); ?></span>
                                        <span><?php echo $supply->unit; ?></span>
                                    </div>
                                    <div class="col-3 text-right">
                                        <span><?php echo money_format(($supply->price / $supply->product_qty) * ($supply->product_qty - $totalQty)); ?></span>
                                        <span>TL</span>
                                    </div>
                                    <div class="col-5">
                                    </div>
                                </div>
                            <?php } ?>
                            <hr>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <input class="datepicker-here form-control digits"
                                   type="text" required
                                   name="consume[<?php echo $supply->id; ?>][date]"
                                   value="<?php echo date('d-m-Y'); ?>"
                                   data-options="{ format: 'DD-MM-YYYY' }"
                                   data-language="tr">
                        </div>
                        <div class="col-6">
                            <input class="form-control" type="number" step="any"
                                   name="consume[<?php echo $supply->id; ?>][id]" hidden
                                   value="<?php echo $supply->id; ?>">
                            <input class="form-control" type="number" step="any" hidden
                                   value="<?php echo $supply->price / $supply->product_qty; ?>"
                                   name="consume[<?php echo $supply->id; ?>][price]">
                            <input class="form-control" type="number" step="any" placeholder="Çıkış Miktar"
                                   name="consume[<?php echo $supply->id; ?>][product_qty]">
                        </div>
                        <div class="col-11">
                            <input class="form-control" type="text" placeholder="Açıklama"
                                   name="consume[<?php echo $supply->id; ?>][supply_notes]">
                        </div>
                        <div class="col-1">
                            <button onclick="extraction(this)" class="btn btn-primary form-control" form="extraction"
                                    type="submit"><i class="fa fa-sign-out" aria-hidden="true"></i>
                            </button>
                        </div>
                    </div>
                </div>
            <?php } ?>
        <?php } ?>
    </div>
</form>



