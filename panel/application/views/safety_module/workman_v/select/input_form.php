<div class="container-fluid">
    <div class="row">
        <div class="col-md-10">
            <?php foreach ($main_categories as $main_category) { ?>
                <div class="col-md-2">
                    <h4>
                        <b>
                            <input type="checkbox" class='check<?php echo $main_category->id;?>'></span>
                            <baslik><?php echo $main_category->name; ?></baslik>
                        </b>
                    </h4>
                    <nav class="nav">
                        <ul class="list">
                            <li>
                                <a onclick="deleteConfirmationFile(this)"
                                   data-text="Bu Dosyayı Silerseniz Tüm Alt Kategoriler Silinecektir"
                                   data-url="<?php echo base_url("$this->Module_Name/delete/$main_category->id"); ?>">
                                    <i style="font-size: 12px; color: Tomato;" class="fa fa-times-circle-o"
                                       aria-hidden="true"></i>
                                </a>
                                <label>
                                    <span><br>
                                </label>

                                <?php $sub_categories = $this->Workgroup_model->get_all(array(
                                    'sub_category'=> 1,
                                    'parent'=> $main_category->id
                                )); ?>
                                <ul>
                                    <?php foreach ($sub_categories as $sub_category) { ?>
                                        <li>
                                            <div class="checkbox checkbox-primary">
                                                <input type="checkbox" class='<?php echo $main_category->id;?>'
                                                       value="<?php echo $sub_category->id; ?>"
                                                       name="active_group[]"
                                                       id ="<?php echo $sub_category->id; ?>"
                                                        <?php if (!empty($site->active_group)) { ?>
                                                        <?php if (in_array($sub_category->id, json_decode($site->active_group))) {
                                                            echo 'checked=""';
                                                        } ?>
                                                    <?php } ?>
                                                >
                                                <label for="<?php echo $sub_category->id; ?>"><?php echo $sub_category->name; ?></label>
                                            </div>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </li>
                        </ul>
                    </nav>
                </div>
            <?php } ?>
        </div>
        <div class="col-md-2">
            <div id="right" class="text-right">
                <button type="submit" class="pager-btn btn btn-info btn-outline"><i
                            class="fa fa-floppy-o" aria-hidden="true"></i> Kaydet ve Geri Dön
                </button>
            </div>
        </div>
    </div>
</div>



