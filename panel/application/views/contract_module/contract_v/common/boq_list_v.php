<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-8">
                    <form id="update_sub"
                          action="<?php echo base_url("$this->Module_Name/update_sub_group/$item->id"); ?>"
                          method="post"
                          enctype="multipart/form-data" autocomplete="off">
                        <div class="div">
                            <div class="mb-2">
                                <div class="col-form-label">İş Grupları</div>
                                <?php foreach ($main_groups as $main_group) { ?>
                                    <div class="input-group">
                                        <input hidden type="text" name="groups[<?php echo $main_group->id; ?>][id]" class="form-control" style="width: 5px;" value="<?php echo $main_group->id; ?>">
                                        <input type="text" name="groups[<?php echo $main_group->id; ?>][code]" class="form-control" style="width: 5px;" value="<?php echo $main_group->code; ?>">
                                        <input type="text" name="groups[<?php echo $main_group->id; ?>][name]" class="form-control" value="<?php echo $main_group->name; ?>">
                                        <?php $sub_groups = $this->Contract_price_model->get_all(array('contract_id' => $item->id, "sub_group" => 1, "parent" => $main_group->id)); ?>
                                        <?php if (empty($sub_groups)){ ?>
                                        <a onclick="delete_group(this)" id="<?php echo $main_group->id; ?>">
                                            <i style="color: tomato" class="fa fa-minus-circle fa-2x" aria-hidden="true"></i>
                                        </a>
                                        <?php } ?>
                                    </div>
                                    <?php $j = 1; ?>

                                    <?php foreach ($sub_groups as $sub_group) { ?>
                                        <div class="input-group">
                                            <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                            <input hidden type="text" name="groups[<?php echo $sub_group->id; ?>][id]" class="form-control" style="width: 5px;" value="<?php echo $sub_group->id; ?>">
                                            <input type="text" name="groups[<?php echo $sub_group->id; ?>][code]" class="form-control" style="width: 5px;" value="<?php echo $sub_group->code; ?>">
                                            <input type="text" name="groups[<?php echo $sub_group->id; ?>][name]" class="form-control"  value="<?php echo $sub_group->name; ?>">
                                            <a onclick="delete_group(this)" id="<?php echo $sub_group->id; ?>">
                                                <i style="color: tomato" class="fa fa-minus-circle fa-2x" aria-hidden="true"></i>
                                            </a>
                                        </div>
                                    <?php } ?>
                                    <div class="input-group">
                                        <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                        <input hidden type="text" name="groups[<?php echo $main_group->id; ?>][new_sub][main_id]" class="form-control" style="width: 5px;" value="<?php echo $main_group->id; ?>" placeholder="Alt Grup ID">
                                        <input type="text" name="groups[<?php echo $main_group->id; ?>][new_sub][code]" class="form-control" style="width: 5px;" placeholder="Alt Grup Kodu">
                                        <input type="text" name="groups[<?php echo $main_group->id; ?>][new_sub][name]" class="form-control"  placeholder="Alt Grup Adı">
                                    </div>
                                <?php } ?>

                            </div>

                        </div>
                        <div class="input-group">
                            <input hidden type="text" name="groups[new_main][main_id]" class="form-control" style="width: 5px;" disabled placeholder="Ana Grup Grup ID">
                            <input type="text" name="groups[new_main][code]" class="form-control" style="width: 5px;" placeholder="Ana Grup Grup Kodu">
                            <input type="text" name="groups[new_main][name]" class="form-control"  placeholder="Ana Grup Grup Adı">
                        </div>
                <a form-id="update_sub" id="save_button" onclick="update_group(this)"
                   class="btn btn-success">
                    <i class="fa fa-floppy-o fa-lg"></i> Kaydet
                </a>
                </form>

            </div>

        </div>
    </div>
</div>
</div>

<table class="table table-responsive">
    <tbody>

    </tbody>
</table>


<?php echo validation_errors(); ?>