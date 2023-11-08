<form id="add_item"
      action="<?php echo base_url("$this->Module_Name/add_item/$title->id"); ?>"
      method="post"
      enctype="multipart/form-data" autocomplete="off">
    <div class="row">
        <div class="col-4">
            <table class="table" style="font-size: 12px;">
                <thead>
                <tr>
                    <th colspan="3"
                        style="text-align:center; width: 50px;"><?php echo $title->title_code . " - " . $title->title_name; ?>
                        BAŞLIĞI<p>POZLARI</p></th>
                </tr>
                </thead>
                <tbody class="sortable" data-url="<?php echo base_url("book/item_rankSetter"); ?>">
                <?php if (isset($items)) { ?>
                    <?php foreach ($items as $item) { ?>
                        <tr id="sub-<?php echo $item->id; ?>">
                            <td><i class="fa fa-reorder"></i></td>
                            <td>
                                <a id="category" href="#"
                                   url="<?php echo base_url("$this->Module_Name/show_detail/$item->id"); ?>"
                                   onclick="show_detail(this)" method="post" enctype="multipart">
                                    <?php echo $item->item_code; ?>.<?php echo $item->item_name; ?>
                                </a>
                            </td>
                            <td>
                                <a onclick="deleteitem(this)"
                                   url="<?php echo base_url("$this->Module_Name/delete_item/$item->id"); ?>"
                                   warning="Başlığı Silmek Üzeresiniz - Başlık Altındaki Pozlar Da Silinecek">
                                    <i style="font-size: 18px; color: Tomato;" class="fa fa-times-circle-o"
                                       aria-hidden="true"></i>
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                <?php } ?>
                </tbody>
            </table>
        </div>
        <div class="col-4">
            <div class="detail">
                <?php $this->load->view("{$viewModule}/{$viewFolder}/new_item/detail"); ?>
            </div>
        </div>
        <div class="col-4">
            <div class="mb-2">
                <div class="col-form-label">Yeni Poz</div>
                <input step="any" class="form-control <?php cms_isset(form_error("item_code"), "is-invalid", ""); ?>"
                       name="item_code" value="<?php echo isset($form_error) ? set_value("item_code") : ""; ?>"
                       placeholder="Poz Kodu 01 - A - I vs."/>
                <?php if (isset($form_error)) { ?>
                    <div class="invalid-feedback"><?php echo form_error("item_code"); ?></div>
                <?php } ?>
            </div>
            <div class="mb-2">

                <input step="any" class="form-control <?php cms_isset(form_error("item_name"), "is-invalid", ""); ?>"
                       name="item_name" value="<?php echo isset($form_error) ? set_value("item_name") : ""; ?>"
                       placeholder="Poz Adı - 19 CM BİMSBETON DUVAR YAPILMASI  vs."/>
                <?php if (isset($form_error)) { ?>
                    <div class="invalid-feedback"><?php echo form_error("item_name"); ?></div>
                <?php } ?>
            </div>
            <div class="mb-2">

                <input step="any" class="form-control <?php cms_isset(form_error("item_unit"), "is-invalid", ""); ?>"
                       name="item_unit" value="<?php echo isset($form_error) ? set_value("item_unit") : ""; ?>"
                       placeholder="Birim"/>
                <?php if (isset($form_error)) { ?>
                    <div class="invalid-feedback"><?php echo form_error("item_unit"); ?></div>
                <?php } ?>
            </div>
            <div class="mb-2">

                <input type="number" step="any"
                       class="form-control <?php cms_isset(form_error("item_price"), "is-invalid", ""); ?>"
                       name="item_price" value="<?php echo isset($form_error) ? set_value("item_price") : ""; ?>"
                       id="sayiInput" onblur="convertToCustomDecimal(this)" onfocus="convertToCustomDecimal(this)"
                       placeholder="Birim Fiyat"/>
                <?php if (isset($form_error)) { ?>
                    <div class="invalid-feedback"><?php echo form_error("item_price"); ?></div>
                <?php } ?>
            </div>
            <div class="mb-2">
                <textarea step="any" placeholder="Tarifi"
                          class="form-control <?php cms_isset(form_error("item_explain"), "is-invalid", ""); ?>"
                          name="item_explain"
                          value="<?php echo isset($form_error) ? set_value("item_explain") : ""; ?>"></textarea>
            </div>
            <?php if (isset($form_error)) { ?>
                <div class="invalid-feedback"><?php echo form_error("item_explain"); ?></div>
            <?php } ?>

            <p><?php if (isset($error)) {
                    echo $error;
                } ?></p>

            <div class="row">
                <div class="col-12">
                    <a form-id="add_item" id="save_button" onclick="add_item(this)"
                       class="btn btn-success">
                        <i class="fa fa-plus fa-lg"></i> Ekle
                    </a>
                </div>
            </div>
        </div>
    </div>
</form>
