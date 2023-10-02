<div class="row">
    <?php echo validation_errors(); ?>
    <?php foreach ($main_categories as $main_category) { ?>
        <div class="col-md-3">
            <h5>
                <b>
                    <button class="btn" type="button" data-bs-toggle="modal" data-bs-target="#main_<?php echo $main_category->id; ?>" data-whatever="@getbootstrap">
                        <i class="fa fa-plus"></i>
                    </button>
                    <div class="modal fade" id="main_<?php echo $main_category->id; ?>" tabindex="-1" role="dialog" aria-labelledby="main_<?php echo $main_category->id; ?>" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Yeni Altgrup</h5>
                                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="<?php echo $main_category->id; ?>" action="<?php echo base_url("$this->Module_Name/add_sub"); ?>"
                                          url="<?php echo base_url("$this->Module_Name/add_sub"); ?>"
                                          method="post" enctype="multipart">
                                        <div class="mb-3">
                                            <label class="col-form-label" for="recipient-name">Ana İş Grubu:</label>
                                            <span><?php echo $main_category->name; ?></span>
                                            <input type="text" name="main_group" hidden value="<?php echo $main_category->id; ?>" class="form-control"/>

                                        </div>
                                        <div class="mb-3">
                                            <label class="col-form-label" for="message-text">Alt İş Grubu Adı</label>
                                            <input type="text" name="sub_group" class="form-control"/>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">İptal</button>
                                    <span class="btn btn-primary" type="button" id="submitBtn" data-bs-dismiss="modal" onclick="test(this)" form-id="<?php echo $main_category->id; ?>">Kaydet
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <baslik><?php echo $main_category->name; ?>
                        <span onclick="delete_sub(this)"
                              url="<?php echo base_url("$this->Module_Name/delete_main/$main_category->id"); ?>"
                               text="<?php echo $main_category->name; ?> İsimli Ana Kategoriyi">
                             <i class="fa fa-trash-o"></i>
                        </span>
                    </baslik>
                </b>
            </h5>
            <nav class="nav">
                <ul class=list>
                    <li>
                        <?php $sub_categories = $this->Workgroup_model->get_all(array(
                            'sub_category' => 1,
                            'parent' => $main_category->id
                        )); ?>
                        <ul>
                            <?php foreach ($sub_categories

                                           as $sub_category) { ?>
                                <li><span><?php echo $sub_category->name; ?></span>
                                    <span onclick="delete_sub(this)"
                                          text="<?php echo $sub_category->name; ?> İsimli Alt Kategoriyi"
                                          url="<?php echo base_url("$this->Module_Name/delete_sub/$sub_category->id"); ?>">
                                            <i class="fa fa-trash-o"></i></span>
                                </li>

                            <?php } ?>

                        </ul>
                    </li>
                </ul>
            </nav>
        </div>
    <?php } ?>
</div>
