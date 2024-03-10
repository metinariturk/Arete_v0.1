<h3 class="text-center">Sözleşme İş Grupları</h3>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <form id="update_sub"
                  action="<?php echo base_url("$this->Module_Name/update_sub_group/$item->id"); ?>"
                  method="post"
                  enctype="multipart/form-data" autocomplete="off">
                <?php foreach ($main_groups as $main_group) { ?>

                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-3">
                                <input hidden type="text" name="groups[<?php echo $main_group->id; ?>][id]"
                                       class="form-control" style="width: 5px;"
                                       value="<?php echo $main_group->id; ?>">
                                <input type="text" name="groups[<?php echo $main_group->id; ?>][code]"
                                       class="form-control"
                                       value="<?php echo $main_group->code; ?>">
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="groups[<?php echo $main_group->id; ?>][name]"
                                       class="form-control" value="<?php echo $main_group->name; ?>">
                            </div>
                            <div class="col-md-3">
                                <?php $sub_groups = $this->Contract_price_model->get_all(array('contract_id' => $item->id, "sub_group" => 1, "parent" => $main_group->id)); ?>
                                <?php if (empty($sub_groups)) { ?>
                                    <a onclick="delete_group(this)" id="<?php echo $main_group->id; ?>">
                                        <i style="color: tomato" class="fa fa-minus-circle fa-2x"
                                           aria-hidden="true"></i>
                                    </a>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <hr>

                    <?php $j = 1; ?>

                    <?php foreach ($sub_groups as $sub_group) { ?>

                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-1">

                                </div>
                                <div class="col-md-3">
                                    <input hidden type="text" name="groups[<?php echo $sub_group->id; ?>][id]"
                                           class="form-control" style="width: 5px;"
                                           value="<?php echo $sub_group->id; ?>">
                                    <input type="text" name="groups[<?php echo $sub_group->id; ?>][code]"
                                           class="form-control"
                                           value="<?php echo $sub_group->code; ?>">
                                </div>
                                <div class="col-md-6">
                                    <input type="text" name="groups[<?php echo $sub_group->id; ?>][name]"
                                           class="form-control" value="<?php echo $sub_group->name; ?>">
                                </div>
                                <div class="col-md-3">
                                    <?php $sub_groups = $this->Contract_price_model->get_all(array('contract_id' => $item->id, "sub_group" => 1, "parent" => $main_group->id)); ?>
                                    <?php if (empty($sub_groups)) { ?>
                                        <a onclick="delete_group(this)" id="<?php echo $sub_group->id; ?>">
                                            <i style="color: tomato" class="fa fa-minus-circle fa-2x"
                                               aria-hidden="true"></i>
                                        </a>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>

                    <?php } ?>


                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-1">

                            </div>
                            <div class="col-md-3">
                                <input hidden type="text"
                                       name="groups[<?php echo $main_group->id; ?>][new_sub][main_id]"
                                       class="form-control" style="width: 5px;"
                                       value="<?php echo $main_group->id; ?>" placeholder="Alt Grup ID">
                                <input type="text" name="groups[<?php echo $main_group->id; ?>][new_sub][code]"
                                       class="form-control" placeholder="Alt Grup Kodu">
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="groups[<?php echo $main_group->id; ?>][new_sub][name]"
                                       class="form-control" placeholder="Alt Grup Adı">
                            </div>

                        </div>
                    </div>
                    <hr>

                <?php } ?>


                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-3">
                            <input hidden type="text" name="groups[new_main][main_id]" class="form-control"
                                   style="width: 5px;" disabled placeholder="Ana Grup Grup ID">
                            <input type="text" name="groups[new_main][code]" class="form-control"
                                   placeholder="Ana Grup Grup Kodu">
                        </div>
                        <div class="col-md-6">
                            <input type="text" name="groups[new_main][name]" class="form-control"
                                   placeholder="Ana Grup Adı">
                        </div>
                    </div>
                </div>

                <hr>

                <a form-id="update_sub" id="save_button" onclick="update_group(this)"
                   class="btn btn-success">
                    <i class="fa fa-floppy-o fa-lg"></i> Kaydet
                </a>
            </form>
        </div>
    </div>
</div>
